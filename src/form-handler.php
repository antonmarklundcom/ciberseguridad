<?php
declare(strict_types=1);

/**
 * B3 — form handler.
 *
 * Spec: PHP_FORM_SPEC.md §3 (flow), §4 (security), §5 (payload), §6 (email).
 *
 * The flow order in §3 is load-bearing: the local CSV write happens *before*
 * the CRM push, so no CRM failure mode — outage, rotated key, 422 — can lose a
 * lead. Success is a 302, never a rendered page, so a refresh cannot resubmit.
 */

require_once __DIR__ . '/config.php';
require_once __DIR__ . '/validate.php';
require_once __DIR__ . '/vendercrm.php';

/**
 * @return array{action:'redirect'|'render'|'deny', to?:string,
 *               errors?:array<string,string>, old?:array<string,string>,
 *               form_type?:string, page?:string}
 */
function handle_submission(array $post, array $server, array $cookie): array
{
    // 1. Method.
    if (($server['REQUEST_METHOD'] ?? '') !== 'POST') {
        return ['action' => 'deny', 'code' => 405];
    }

    // 2. CSRF. Silent 403 — the response says nothing about why.
    $sent   = is_string($post['csrf'] ?? null) ? $post['csrf'] : '';
    $cookied = is_string($cookie['csrf'] ?? null) ? $cookie['csrf'] : '';
    if ($sent === '' || $cookied === '' || !hash_equals($cookied, $sent)) {
        form_log('csrf_reject', ['ip' => form_client_ip($server)]);
        return ['action' => 'deny', 'code' => 403];
    }

    $formType = is_string($post['form_type'] ?? null) ? $post['form_type'] : 'contacto';
    if (!in_array($formType, V_FORM_TYPES, true)) {
        $formType = 'contacto';
    }

    // 3. Honeypot. Silent success: the bot sees a normal thank-you page and
    //    nothing is sent anywhere.
    if (trim((string) ($post['website'] ?? '')) !== '') {
        form_log('honeypot', ['ip' => form_client_ip($server)]);
        return ['action' => 'redirect', 'to' => '/gracias?t=' . rawurlencode($formType)];
    }

    // 4. Timing. Faster than 3s is a bot; older than 2h is a stale tab.
    $ts  = (int) ($post['ts'] ?? 0);
    $age = time() - $ts;
    if ($ts <= 0 || $age < (int) cfg('min_fill_secs') || $age > (int) cfg('max_form_age')) {
        form_log('timing_reject', ['ip' => form_client_ip($server), 'age' => $age]);
        return ['action' => 'redirect', 'to' => '/gracias?t=' . rawurlencode($formType)];
    }

    // 5. Rate limit.
    if (!form_rate_ok(form_client_ip($server))) {
        form_log('rate_limited', ['ip' => form_client_ip($server)]);
        return ['action' => 'redirect', 'to' => '/gracias?t=' . rawurlencode($formType)];
    }

    // 6. Validate. On failure re-render with errors and preserve input.
    [$clean, $errors] = validate_submission($post);
    if ($errors !== []) {
        return [
            'action'    => 'render',
            'errors'    => $errors,
            'old'       => form_old_input($post),
            'form_type' => $formType,
            'page'      => (string) ($clean['page'] ?? ''),
        ];
    }

    // 7–8. Attribution and idempotency.
    $attr = form_attribution($cookie, $server);
    $key  = vendercrm_idempotency_key((string) $clean['telefono'], (string) $clean['form_type']);
    $band = lead_band($clean);

    // 10. Local write FIRST. This is the durability guarantee.
    $rowId = leads_append($clean, $attr, $band, $key);

    // 11. CRM push. Never allowed to break the visitor's journey.
    $crm = ['ok' => false, 'status' => 0, 'body' => '', 'error' => 'not attempted',
            'contact_id' => '', 'deal_id' => '', 'duplicate' => false];
    try {
        $payload = vendercrm_build_payload($clean, $attr, $key);
        $crm     = vendercrm_push($payload);
    } catch (Throwable $e) {
        // Class name only. The message could contain payload fragments.
        $crm['error'] = 'exception: ' . get_class($e);
    }

    if ($crm['ok']) {
        leads_mark_pushed($rowId, $crm['contact_id'], $crm['deal_id'], $crm['status']);
    }
    form_log('crm_push', [
        'status'    => $crm['status'],
        'ok'        => $crm['ok'] ? '1' : '0',
        'duplicate' => $crm['duplicate'] ? '1' : '0',
        'error'     => $crm['error'],
        // Response body is logged because it names the failing field on a 422.
        'body'      => $crm['ok'] ? '' : mb_substr($crm['body'], 0, 500),
    ]);

    // 12. Notify.
    try {
        form_notify($clean, $band, $attr, $crm);
    } catch (Throwable $e) {
        form_log('notify_failed', ['error' => get_class($e)]);
    }

    // 13. Redirect.
    return ['action' => 'redirect', 'to' => '/gracias?t=' . rawurlencode((string) $clean['form_type'])];
}

// ---------------------------------------------------------------------------
// CSRF
// ---------------------------------------------------------------------------

/**
 * Double-submit cookie. Session-scoped, so it rotates per browser session.
 */
function csrf_token(): string
{
    $existing = $_COOKIE['csrf'] ?? '';
    if (is_string($existing) && preg_match('/^[a-f0-9]{64}$/', $existing) === 1) {
        return $existing;
    }

    $token = bin2hex(random_bytes(32));
    if (!headers_sent()) {
        setcookie('csrf', $token, [
            'expires'  => 0,          // session cookie
            'path'     => '/',
            'secure'   => true,
            'httponly' => true,
            'samesite' => 'Strict',
        ]);
    }
    $_COOKIE['csrf'] = $token;

    return $token;
}

// ---------------------------------------------------------------------------
// Attribution
// ---------------------------------------------------------------------------

/**
 * First-touch attribution from the vc_attr cookie set by vc-attribution.js.
 *
 * Parsed defensively: the cookie is client-controlled and a malformed value
 * must never throw. Only known keys are read, each capped at 200 characters.
 */
function form_attribution(array $cookie, array $server): array
{
    $out  = [];
    $keys = ['utm_source', 'utm_medium', 'utm_campaign', 'utm_term', 'utm_content', 'gclid', 'fbclid'];

    $raw = $cookie['vc_attr'] ?? '';
    if (is_string($raw) && $raw !== '' && strlen($raw) <= 2000) {
        $decoded = json_decode(rawurldecode($raw), true);
        if (is_array($decoded)) {
            foreach ($keys as $k) {
                $v = $decoded[$k] ?? null;
                if (is_string($v) || is_int($v)) {
                    $v = v_line((string) $v);
                    if ($v !== null && $v !== '') {
                        $out[$k] = mb_substr($v, 0, 200);
                    }
                }
            }
        }
    }

    $ref = $server['HTTP_REFERER'] ?? '';
    if (is_string($ref) && $ref !== '' && strlen($ref) <= 2000
        && preg_match('#^https?://#i', $ref) === 1
        && preg_match('/[\x00-\x1F\x7F]/', $ref) !== 1
    ) {
        $out['referrer'] = $ref;
    }

    return $out;
}

function form_client_ip(array $server): string
{
    $ip = $server['REMOTE_ADDR'] ?? '';
    return is_string($ip) && filter_var($ip, FILTER_VALIDATE_IP) ? $ip : '0.0.0.0';
}

/** Re-render values. Never includes csrf, ts, honeypot or assessment state. */
function form_old_input(array $post): array
{
    $out = [];
    foreach (['nombre', 'telefono', 'email', 'empresa', 'empleados', 'rubro', 'disparador', 'preferencia_de_contacto', 'mensaje'] as $k) {
        $v = $post[$k] ?? '';
        if (is_string($v)) {
            $out[$k] = mb_substr($v, 0, 2000);
        }
    }
    return $out;
}

// ---------------------------------------------------------------------------
// Rate limiting
// ---------------------------------------------------------------------------

/** 5 submissions per IP per hour, file-based. No database needed at this volume. */
function form_rate_ok(string $ip): bool
{
    $dir = cfg('storage_dir') . '/ratelimit';
    if (!is_dir($dir) && !@mkdir($dir, 0770, true) && !is_dir($dir)) {
        // Fail open: a broken storage directory must not block real leads.
        form_log('rate_dir_unavailable', []);
        return true;
    }

    $file   = $dir . '/' . hash('sha256', $ip) . '.txt';
    $now    = time();
    $window = (int) cfg('rate_window');
    $limit  = (int) cfg('rate_limit');

    $fh = @fopen($file, 'c+');
    if ($fh === false) {
        return true;
    }

    $allowed = true;
    if (flock($fh, LOCK_EX)) {
        $contents = stream_get_contents($fh) ?: '';
        $stamps   = array_filter(
            array_map('intval', preg_split('/\s+/', trim($contents)) ?: []),
            static fn (int $t): bool => $t > 0 && ($now - $t) < $window
        );

        if (count($stamps) >= $limit) {
            $allowed = false;
        } else {
            $stamps[] = $now;
        }

        ftruncate($fh, 0);
        rewind($fh);
        fwrite($fh, implode("\n", $stamps));
        fflush($fh);
        flock($fh, LOCK_UN);
    }
    fclose($fh);

    return $allowed;
}

// ---------------------------------------------------------------------------
// Local lead store
// ---------------------------------------------------------------------------

const LEAD_COLUMNS = [
    'row_id', 'received_at', 'form_type', 'page', 'lead_band',
    'nombre', 'telefono', 'email', 'empresa', 'empleados', 'rubro', 'disparador', 'preferencia_de_contacto', 'mensaje',
    'score', 'banda', 'dominios',
    'utm_source', 'utm_medium', 'utm_campaign', 'utm_term', 'utm_content',
    'gclid', 'fbclid', 'referrer',
    'idempotency_key', 'crm_status', 'crm_contact_id', 'crm_deal_id', 'crm_pushed_at',
];

function leads_file(): string
{
    return cfg('storage_dir') . '/leads.csv';
}

/** Append the lead and return its row id. Runs before the CRM call. */
function leads_append(array $clean, array $attr, string $band, string $key): string
{
    $rowId = bin2hex(random_bytes(8));
    $file  = leads_file();

    $dir = dirname($file);
    if (!is_dir($dir)) {
        @mkdir($dir, 0770, true);
    }

    $row = [
        'row_id'          => $rowId,
        'received_at'     => gmdate('c'),
        'form_type'       => (string) $clean['form_type'],
        'page'            => (string) ($clean['page'] ?? ''),
        'lead_band'       => $band,
        'nombre'          => (string) ($clean['nombre'] ?? ''),
        'telefono'        => (string) ($clean['telefono'] ?? ''),
        'email'           => (string) ($clean['email'] ?? ''),
        'empresa'         => (string) ($clean['empresa'] ?? ''),
        'empleados'       => (string) ($clean['empleados'] ?? ''),
        'rubro'           => (string) ($clean['rubro'] ?? ''),
        'disparador'      => (string) ($clean['disparador'] ?? ''),
        'preferencia_de_contacto' => (string) ($clean['preferencia_de_contacto'] ?? ''),
        'mensaje'         => (string) ($clean['mensaje'] ?? ''),
        'score'           => isset($clean['score']) ? (string) $clean['score'] : '',
        'banda'           => (string) ($clean['banda'] ?? ''),
        'dominios'        => !empty($clean['dominios'])
            ? (json_encode($clean['dominios'], JSON_UNESCAPED_UNICODE) ?: '')
            : '',
        'utm_source'      => (string) ($attr['utm_source'] ?? ''),
        'utm_medium'      => (string) ($attr['utm_medium'] ?? ''),
        'utm_campaign'    => (string) ($attr['utm_campaign'] ?? ''),
        'utm_term'        => (string) ($attr['utm_term'] ?? ''),
        'utm_content'     => (string) ($attr['utm_content'] ?? ''),
        'gclid'           => (string) ($attr['gclid'] ?? ''),
        'fbclid'          => (string) ($attr['fbclid'] ?? ''),
        'referrer'        => (string) ($attr['referrer'] ?? ''),
        'idempotency_key' => $key,
        'crm_status'      => 'pending',
        'crm_contact_id'  => '',
        'crm_deal_id'     => '',
        'crm_pushed_at'   => '',
    ];

    $fh = @fopen($file, 'a+');
    if ($fh === false) {
        form_log('leads_write_failed', ['row_id' => $rowId]);
        return $rowId;
    }
    if (flock($fh, LOCK_EX)) {
        if (ftell($fh) === 0 || filesize($file) === 0) {
            fputcsv($fh, LEAD_COLUMNS, ',', '"', '\\');
        }
        fputcsv($fh, array_values($row), ',', '"', '\\');
        fflush($fh);
        flock($fh, LOCK_UN);
    }
    fclose($fh);

    return $rowId;
}

/**
 * Mark a row pushed.
 *
 * Read-modify-write of a small file under an exclusive lock. The lock is taken
 * *after* the CRM call, never held across it — a 10s network call must not
 * block other submissions. At single-digit leads per week the rewrite cost is
 * irrelevant; if this file ever grows past a few thousand rows, that is the
 * signal to move to MySQL, not to optimise this function.
 */
function leads_mark_pushed(string $rowId, string $contactId, string $dealId, int $status): void
{
    $file = leads_file();
    if (!is_file($file)) {
        return;
    }

    $fh = @fopen($file, 'r+');
    if ($fh === false) {
        return;
    }
    if (!flock($fh, LOCK_EX)) {
        fclose($fh);
        return;
    }

    $rows = [];
    while (($row = fgetcsv($fh, 0, ',', '"', '\\')) !== false) {
        if ($row === [null] || $row === false) {
            continue;
        }
        if (($row[0] ?? '') === $rowId) {
            $idx = array_flip(LEAD_COLUMNS);
            $row[$idx['crm_status']]     = (string) $status;
            $row[$idx['crm_contact_id']] = $contactId;
            $row[$idx['crm_deal_id']]    = $dealId;
            $row[$idx['crm_pushed_at']]  = gmdate('c');
        }
        $rows[] = $row;
    }

    ftruncate($fh, 0);
    rewind($fh);
    foreach ($rows as $row) {
        fputcsv($fh, $row, ',', '"', '\\');
    }
    fflush($fh);
    flock($fh, LOCK_UN);
    fclose($fh);
}

// ---------------------------------------------------------------------------
// Notification email
// ---------------------------------------------------------------------------

/**
 * Notify the practitioner.
 *
 * Headers are assembled from configuration only. No user input reaches a
 * header: the lead's own email address goes in the body, not into Reply-To.
 * That costs one copy-paste when replying and removes the entire class of
 * header-injection bugs.
 */
function form_notify(array $clean, string $band, array $attr, array $crm): void
{
    $to = (string) cfg('notify_email');
    if ($to === '' || !filter_var($to, FILTER_VALIDATE_EMAIL)) {
        form_log('notify_skipped', ['reason' => 'NOTIFY_EMAIL missing or invalid']);
        return;
    }

    $labels = [
        'incidente'    => 'Incidente',
        'cuestionario' => 'Cuestionario',
        'diagnostico'  => 'Diagnóstico',
        'pentesting'   => 'Pentesting',
        'cumplimiento' => 'Cumplimiento',
        'capacitacion' => 'Capacitación',
        'otro'         => 'Otro',
    ];

    $subject = sprintf(
        '[%s] %s · %s · %s · %s',
        $band,
        $labels[$clean['disparador'] ?? 'otro'] ?? 'Consulta',
        ($clean['empresa'] ?? '') !== '' ? $clean['empresa'] : ($clean['nombre'] ?? 'Sin empresa'),
        $clean['empleados'] ?? '?',
        $clean['rubro'] ?? '?'
    );

    $lines = [
        'Banda: ' . $band,
        'Formulario: ' . ($clean['form_type'] ?? ''),
        'Página: ' . ($clean['page'] ?? ''),
        '',
        'Nombre: ' . ($clean['nombre'] ?? ''),
        'Teléfono: ' . ($clean['telefono'] ?? ''),
        'Correo: ' . ($clean['email'] ?? '—'),
        'Empresa: ' . ($clean['empresa'] ?? '—'),
        'Empleados: ' . ($clean['empleados'] ?? ''),
        'Rubro: ' . ($clean['rubro'] ?? ''),
        'Qué lo trae: ' . ($clean['disparador'] ?? ''),
        'Prefiere contacto por: ' . ($clean['preferencia_de_contacto'] ?? ''),
    ];

    if (($clean['mensaje'] ?? '') !== '') {
        $lines[] = '';
        $lines[] = 'Mensaje:';
        $lines[] = $clean['mensaje'];
    }

    if (($clean['form_type'] ?? '') === 'autoevaluacion') {
        $dominios = $clean['dominios'] ?? [];
        asort($dominios);
        $weakest = array_slice(array_keys($dominios), 0, 2);

        $lines[] = '';
        $lines[] = 'Autoevaluación: ' . ($clean['score'] ?? '?') . '/100 (' . ($clean['banda'] ?? '?') . ')';
        if ($weakest !== []) {
            $lines[] = 'Dominios más débiles: ' . implode(', ', $weakest);
        }
        foreach ($dominios as $name => $val) {
            $lines[] = '  - ' . $name . ': ' . $val;
        }
    }

    $attrLines = [];
    foreach (['utm_source', 'utm_medium', 'utm_campaign', 'gclid', 'fbclid', 'referrer'] as $k) {
        if (!empty($attr[$k])) {
            $attrLines[] = '  ' . $k . ': ' . $attr[$k];
        }
    }
    if ($attrLines !== []) {
        $lines[] = '';
        $lines[] = 'Atribución:';
        array_push($lines, ...$attrLines);
    }

    $lines[] = '';
    $lines[] = 'CRM: ' . ($crm['ok']
        ? 'ok (contacto ' . $crm['contact_id'] . ($crm['duplicate'] ? ', duplicado' : '') . ')'
        : 'FALLÓ — status ' . $crm['status'] . ' — revisá storage/form.log');

    form_send_mail($to, $subject, implode("\n", $lines));
}

/**
 * Send plain-text UTF-8 mail.
 *
 * The subject is stripped of CR/LF and then MIME encoded-word wrapped, so it
 * cannot introduce a header even if a control character survived validation.
 * Header assembly is centralised here rather than concatenated at call sites.
 */
function form_send_mail(string $to, string $subject, string $body): bool
{
    $subject = str_replace(["\r", "\n", "\0"], ' ', $subject);
    $subject = mb_substr($subject, 0, 200);
    if (preg_match('/^[\x20-\x7E]*$/', $subject) !== 1) {
        $subject = '=?UTF-8?B?' . base64_encode($subject) . '?=';
    }

    $from = (string) cfg('mail_from');
    if ($from === '' || !filter_var($from, FILTER_VALIDATE_EMAIL)) {
        $from = 'no-reply@' . (parse_url((string) cfg('site_url'), PHP_URL_HOST) ?: 'localhost');
    }

    $headers = [
        'From: ' . $from,
        'MIME-Version: 1.0',
        'Content-Type: text/plain; charset=UTF-8',
        'Content-Transfer-Encoding: 8bit',
        'X-Auto-Response-Suppress: All',
    ];

    $body = str_replace("\r\n", "\n", $body);

    return @mail($to, $subject, $body, implode("\r\n", $headers));
}

// ---------------------------------------------------------------------------
// Logging
// ---------------------------------------------------------------------------

/**
 * Append a structured line to storage/form.log.
 *
 * Never logs the submission itself — see PHP_FORM_SPEC.md §4. Status codes,
 * timestamps and the CRM response body only.
 */
function form_log(string $event, array $context): void
{
    $dir = cfg('storage_dir');
    if (!is_dir($dir) && !@mkdir($dir, 0770, true) && !is_dir($dir)) {
        return;
    }

    $parts = [gmdate('c'), $event];
    foreach ($context as $k => $v) {
        $v = str_replace(["\r", "\n", "\t"], ' ', (string) $v);
        $parts[] = $k . '=' . $v;
    }

    @file_put_contents($dir . '/form.log', implode("\t", $parts) . "\n", FILE_APPEND | LOCK_EX);
}
