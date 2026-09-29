<?php
declare(strict_types=1);

/**
 * Block B test suite. Zero dependencies: `php tests/run.php`.
 *
 * Covers the parts of PHP_FORM_SPEC.md §8 that are testable without a live
 * host. The remainder — securityheaders.com grade, .env unreachable over HTTP,
 * display_errors off, no PHP version header, screen-reader flow — are
 * deployment checks and belong to the F2 launch gate.
 */

// Isolate storage before anything reads config, so tests never touch real leads.
$tmp = sys_get_temp_dir() . '/cyber-tests-' . bin2hex(random_bytes(4));
mkdir($tmp, 0770, true);

putenv('STORAGE_DIR=' . $tmp);
putenv('SITE_URL=https://ciberseguridad.com.py');
putenv('VENDERCRM_URL=https://crm.example.test');
putenv('VENDERCRM_API_KEY=test-key');
putenv('NOTIFY_EMAIL=');   // suppresses mail() during tests

$root = dirname(__DIR__);
require_once $root . '/src/form-handler.php';

$GLOBALS['__pass'] = 0;
$GLOBALS['__fail'] = 0;

function ok(string $name, bool $cond, string $detail = ''): void
{
    if ($cond) {
        $GLOBALS['__pass']++;
        echo "  PASS  $name\n";
    } else {
        $GLOBALS['__fail']++;
        echo "  FAIL  $name" . ($detail !== '' ? "  ($detail)" : '') . "\n";
    }
}

function section(string $t): void
{
    echo "\n$t\n" . str_repeat('-', strlen($t)) . "\n";
}

/** A valid POST body, overridable per test. */
function post(array $over = []): array
{
    return $over + [
        'form_type'  => 'contacto',
        'page'       => 'servicios/diagnostico',
        'ts'         => (string) (time() - 30),
        'csrf'       => str_repeat('a', 64),
        'website'    => '',
        'nombre'     => 'María González',
        'telefono'   => '0981 123 456',
        'email'      => 'maria@empresa.com.py',
        'empresa'    => 'Importadora del Este S.A.',
        'empleados'  => '25-49',
        'rubro'      => 'comercio',
        'disparador' => 'cuestionario',
        'mensaje'    => 'Un cliente nos pidió completar un cuestionario.',
    ];
}

function server(): array
{
    return ['REQUEST_METHOD' => 'POST', 'REMOTE_ADDR' => '203.0.113.' . random_int(1, 254)];
}

function cookie(): array
{
    return ['csrf' => str_repeat('a', 64)];
}

// ===========================================================================
section('Validation');

[$clean, $errors] = validate_submission(post());
ok('valid submission produces no errors', $errors === [], json_encode($errors));
ok('email retained', ($clean['email'] ?? '') === 'maria@empresa.com.py');

[$clean, $errors] = validate_submission(post(['email' => '']));
ok('blank email → key absent, not ""', !array_key_exists('email', $clean));
ok('blank email is not an error', !isset($errors['email']));

[, $errors] = validate_submission(post(['email' => 'not-an-email']));
ok('invalid email rejected', isset($errors['email']));

[, $errors] = validate_submission(post(['empleados' => '9999-forged']));
ok('forged enum rejected (empleados)', isset($errors['empleados']));

[, $errors] = validate_submission(post(['rubro' => 'otro; DROP TABLE']));
ok('forged enum rejected (rubro)', isset($errors['rubro']));

[, $errors] = validate_submission(post(['disparador' => 'incidente']));
ok('valid enum accepted (disparador)', !isset($errors['disparador']));

[, $errors] = validate_submission(post(['telefono' => '']));
ok('missing phone rejected', isset($errors['telefono']));

[, $errors] = validate_submission(post(['telefono' => '((((((']));
ok('phone needing 6 digits rejected', isset($errors['telefono']));

[$clean] = validate_submission(post(['telefono' => '+595 981 123-456']));
ok('local phone format accepted', ($clean['telefono'] ?? '') !== '');

[, $errors] = validate_submission(post(['nombre' => 'A']));
ok('1-char name rejected', isset($errors['nombre']));

[, $errors] = validate_submission(post(['mensaje' => str_repeat('x', 2001)]));
ok('over-length message rejected', isset($errors['mensaje']));

[$clean] = validate_submission(post(['page' => '../../etc/passwd']));
ok('path-traversal page slug dropped', ($clean['page'] ?? 'x') === '');

[$clean] = validate_submission(post(['page' => 'servicios/diagnostico']));
ok('valid page slug kept', ($clean['page'] ?? '') === 'servicios/diagnostico');

// ---------------------------------------------------------------------------
section('Header injection');

[, $errors] = validate_submission(post(['nombre' => "María\r\nBcc: attacker@evil.test"]));
ok('CRLF in nombre rejected outright', isset($errors['nombre']));

[$clean, $errors] = validate_submission(post(['empresa' => "Acme\nX-Header: y"]));
ok('LF in empresa rejected', isset($errors['empresa']));
ok('rejected empresa is not silently dropped', !isset($clean['empresa']));

[$clean, $errors] = validate_submission(post(['email' => "a@b.test\r\nBcc: evil@x.test"]));
ok('CRLF in email rejected, not silently dropped', isset($errors['email']) && !isset($clean['email']));

$subject = "[A] Test \r\nBcc: attacker@evil.test";
$stripped = str_replace(["\r", "\n", "\0"], ' ', $subject);
ok('subject sanitiser removes CRLF', !str_contains($stripped, "\n") && !str_contains($stripped, "\r"));

// ---------------------------------------------------------------------------
section('XSS / output encoding');

$xss = '<script>alert(1)</script>';
[$clean, $errors] = validate_submission(post(['nombre' => $xss, 'empresa' => $xss]));
ok('script tag passes validation as literal text', $errors === [], json_encode($errors));
ok('script tag stored verbatim, not stripped', ($clean['nombre'] ?? '') === $xss);

$escaped = htmlspecialchars($xss, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
ok('escaper neutralises the tag', !str_contains($escaped, '<script>'));

// ---------------------------------------------------------------------------
section('Assessment submission');

$adom = ['backups' => 1, 'accesos' => 2, 'correo' => 1, 'dispositivos' => 3,
         'terceros' => 2, 'personas' => 1, 'preparacion' => 0];
$apost = post([
    'form_type' => 'autoevaluacion',
    'page'      => 'recursos/autoevaluacion',
    'score'     => '34',
    'banda'     => 'alta',
    'dominios'  => json_encode($adom),
    'mensaje'   => '',
]);

[$clean, $errors] = validate_submission($apost);
ok('assessment validates', $errors === [], json_encode($errors));
ok('score is an int', ($clean['score'] ?? null) === 34);
ok('all seven domains parsed', count($clean['dominios'] ?? []) === 7);

[, $errors] = validate_submission(post(['form_type' => 'autoevaluacion', 'score' => '900', 'banda' => 'alta']));
ok('out-of-range score rejected', isset($errors['score']));

[, $errors] = validate_submission(post(['form_type' => 'autoevaluacion', 'score' => '50', 'banda' => 'forged']));
ok('forged banda rejected', isset($errors['banda']));

[$clean] = validate_submission($apost + ['dominios' => json_encode($adom + ['evil' => 'x'])]);
ok('unknown domain key dropped', !isset($clean['dominios']['evil']));

[, $errors] = validate_submission(post([
    'form_type' => 'autoevaluacion', 'score' => '50', 'banda' => 'alta',
    'dominios'  => '{"backups": "not-a-number"}',
]));
ok('non-numeric domain value rejected', isset($errors['dominios']));

// ---------------------------------------------------------------------------
section('Payload construction');

[$clean] = validate_submission(post());
$key = vendercrm_idempotency_key($clean['telefono'], $clean['form_type']);
$payload = vendercrm_build_payload($clean, ['utm_source' => 'google', 'utm_medium' => 'organic'], $key);

ok('phone present', ($payload['phone'] ?? '') !== '');
ok('idempotency_key present and >= 8 chars', strlen($payload['idempotency_key'] ?? '') >= 8);
ok('source is cyber:{slug}', ($payload['source'] ?? '') === 'cyber:servicios/diagnostico');
ok('page_url composed server-side', ($payload['page_url'] ?? '') === 'https://ciberseguridad.com.py/servicios/diagnostico');
ok('no pipeline key', !isset($payload['pipeline']));
ok('no stage key', !isset($payload['stage']));
ok('no owner key', !isset($payload['owner']));
ok('no tag key', !isset($payload['tag']));
ok('utm carried through', ($payload['utm_source'] ?? '') === 'google');
ok('fields carries enums', ($payload['fields']['rubro'] ?? '') === 'comercio');

[$clean2] = validate_submission(post(['email' => '', 'empresa' => '', 'mensaje' => '']));
$p2 = vendercrm_build_payload($clean2, [], 'k');
ok('blank email omitted from payload', !array_key_exists('email', $p2));
ok('blank message omitted from payload', !array_key_exists('message', $p2));
ok('blank empresa omitted from fields', !array_key_exists('empresa', $p2['fields']));

[$clean3] = validate_submission($apost);
$p3 = vendercrm_build_payload($clean3, [], 'k');
ok('score flattened into fields as string', ($p3['fields']['score'] ?? '') === '34');
ok('domains flattened, dominio_ prefixed', ($p3['fields']['dominio_backups'] ?? '') === '1');
ok('all seven domains in fields', count(array_filter(array_keys($p3['fields']),
    static fn ($k) => str_starts_with($k, 'dominio_'))) === 7);

// ---------------------------------------------------------------------------
section('Idempotency');

$k1 = vendercrm_idempotency_key('0981 123 456', 'contacto');
$k2 = vendercrm_idempotency_key('0981 123 456', 'contacto');
ok('same phone+form+hour → same key', $k1 === $k2);
ok('different form → different key', $k1 !== vendercrm_idempotency_key('0981 123 456', 'autoevaluacion'));
ok('different phone → different key', $k1 !== vendercrm_idempotency_key('0982 000 000', 'contacto'));

// ---------------------------------------------------------------------------
section('CRM client (stubbed transport)');

$stub = static function (int $status, string $body): callable {
    return static function (string $u, string $b, array $h, int $t) use ($status, $body): array {
        $GLOBALS['__last_headers'] = $h;
        $GLOBALS['__last_body']    = $b;
        return ['status' => $status, 'body' => $body, 'error' => ''];
    };
};

$r = vendercrm_push($payload, $stub(201, '{"contactId":"c1","dealId":"d1","duplicate":false}'));
ok('201 → ok', $r['ok'] === true);
ok('contactId parsed', $r['contact_id'] === 'c1');
ok('dealId parsed', $r['deal_id'] === 'd1');
ok('X-Api-Key header sent', in_array('X-Api-Key: test-key', $GLOBALS['__last_headers'], true));

$r = vendercrm_push($payload, $stub(200, '{"contactId":"c1","duplicate":true}'));
ok('200 replay → ok (retry working)', $r['ok'] === true);
ok('duplicate flag parsed', $r['duplicate'] === true);

$r = vendercrm_push($payload, $stub(401, '{"error":"invalid key"}'));
ok('401 → not ok', $r['ok'] === false);
ok('401 body retained for the log', str_contains($r['body'], 'invalid key'));

$r = vendercrm_push($payload, $stub(422, '{"error":"email must be a valid email"}'));
ok('422 → not ok', $r['ok'] === false);
ok('422 body names the field', str_contains($r['body'], 'email'));

$r = vendercrm_push($payload, $stub(500, 'upstream exploded'));
ok('500 does not throw', $r['ok'] === false);

$r = vendercrm_push($payload, static fn (...$a): array
    => ['status' => 0, 'body' => '', 'error' => 'Connection timed out']);
ok('timeout does not throw', $r['ok'] === false && $r['error'] !== '');

// ---------------------------------------------------------------------------
section('Lead banding (LEAD_FUNNEL.md §4)');

$band = static function (array $o): string {
    [$c] = validate_submission(post($o));
    return lead_band($c);
};

ok('incidente → A', $band(['disparador' => 'incidente', 'empleados' => '1-9']) === 'A');
ok('cuestionario → A', $band(['disparador' => 'cuestionario', 'empleados' => '1-9']) === 'A');
ok('25-49 + diagnostico → B', $band(['disparador' => 'diagnostico', 'empleados' => '25-49']) === 'B');
ok('10-24 + diagnostico → B', $band(['disparador' => 'diagnostico', 'empleados' => '10-24']) === 'B');
ok('1-9 + diagnostico → C', $band(['disparador' => 'diagnostico', 'empleados' => '1-9']) === 'C');
ok('1-9 + continuo → C', $band(['disparador' => 'continuo', 'empleados' => '1-9']) === 'C');

[$ac] = validate_submission($apost + ['empleados' => '100-249']);
ok('large co. + low assessment score → A', lead_band($ac) === 'A');

// ---------------------------------------------------------------------------
section('Attribution parsing');

$a = form_attribution(['vc_attr' => json_encode(['utm_source' => 'google', 'gclid' => 'abc'])], []);
ok('utm_source read from cookie', ($a['utm_source'] ?? '') === 'google');
ok('gclid read from cookie', ($a['gclid'] ?? '') === 'abc');

ok('malformed cookie does not throw', form_attribution(['vc_attr' => '{not json'], []) === []);
ok('array-of-arrays cookie ignored', form_attribution(['vc_attr' => '[[1,2],[3]]'], []) === []);

$a = form_attribution(['vc_attr' => json_encode(['utm_source' => str_repeat('x', 500)])], []);
ok('over-length utm truncated to 200', strlen($a['utm_source'] ?? '') === 200);

$a = form_attribution([], ['HTTP_REFERER' => 'https://www.google.com/']);
ok('referrer captured', ($a['referrer'] ?? '') === 'https://www.google.com/');

$a = form_attribution([], ['HTTP_REFERER' => 'javascript:alert(1)']);
ok('non-http referrer rejected', !isset($a['referrer']));

// ---------------------------------------------------------------------------
section('Handler flow');

$res = handle_submission(post(), ['REQUEST_METHOD' => 'GET', 'REMOTE_ADDR' => '198.51.100.1'], cookie());
ok('GET → 405 deny', $res['action'] === 'deny' && $res['code'] === 405);

$res = handle_submission(post(['csrf' => 'wrong']), server(), cookie());
ok('bad CSRF → 403 deny', $res['action'] === 'deny' && $res['code'] === 403);

$res = handle_submission(post(), server(), []);
ok('missing CSRF cookie → 403 deny', $res['action'] === 'deny' && $res['code'] === 403);

$res = handle_submission(post(['website' => 'http://spam.test']), server(), cookie());
ok('honeypot → silent redirect to /gracias', $res['action'] === 'redirect' && str_starts_with($res['to'], '/gracias'));

$res = handle_submission(post(['ts' => (string) time()]), server(), cookie());
ok('submitted in <3s → treated as bot', $res['action'] === 'redirect');

$res = handle_submission(post(['ts' => (string) (time() - 99999)]), server(), cookie());
ok('stale form → treated as bot', $res['action'] === 'redirect');

$res = handle_submission(post(['nombre' => '']), server(), cookie());
ok('validation failure → render', $res['action'] === 'render');
ok('errors returned', isset($res['errors']['nombre']));
ok('input preserved for re-render', ($res['old']['telefono'] ?? '') === '0981 123 456');

// ---------------------------------------------------------------------------
section('Rate limiting');

$ip = '198.51.100.77';
$srv = ['REQUEST_METHOD' => 'POST', 'REMOTE_ADDR' => $ip];
$accepted = 0;
for ($i = 0; $i < 7; $i++) {
    if (form_rate_ok($ip)) {
        $accepted++;
    }
}
ok('6th and 7th attempt from one IP blocked', $accepted === 5, "accepted=$accepted");

// ---------------------------------------------------------------------------
section('Local lead store');

$leadsFile = cfg('storage_dir') . '/leads.csv';
@unlink($leadsFile);

[$c] = validate_submission(post());
$rowId = leads_append($c, ['utm_source' => 'google'], 'A', 'idem-key-123456');
ok('CSV created', is_file($leadsFile));

$rows = array_map('str_getcsv', file($leadsFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES));
ok('header row written', ($rows[0][0] ?? '') === 'row_id');
ok('lead row written', count($rows) === 2);
ok('crm_status starts pending', in_array('pending', $rows[1], true));

leads_mark_pushed($rowId, 'contact-9', 'deal-9', 201);
$rows = array_map('str_getcsv', file($leadsFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES));
$idx  = array_flip(LEAD_COLUMNS);
ok('crm_contact_id recorded', ($rows[1][$idx['crm_contact_id']] ?? '') === 'contact-9');
ok('crm_status updated', ($rows[1][$idx['crm_status']] ?? '') === '201');
ok('crm_pushed_at set', ($rows[1][$idx['crm_pushed_at']] ?? '') !== '');
ok('row count unchanged after update', count($rows) === 2);

$xssRow = validate_submission(post(['nombre' => '<script>alert(1)</script>']))[0];
leads_append($xssRow, [], 'C', 'idem-2');
ok('XSS payload stored literally in CSV',
    str_contains(file_get_contents($leadsFile), '<script>alert(1)</script>'));

// ---------------------------------------------------------------------------
section('Logging hygiene');

@unlink(cfg('storage_dir') . '/form.log');
form_log('crm_push', ['status' => 422, 'body' => 'email must be valid']);
$log = file_get_contents(cfg('storage_dir') . '/form.log');
ok('log line written', str_contains($log, 'crm_push'));
ok('status logged', str_contains($log, 'status=422'));
ok('log is single-line per event', substr_count(trim($log), "\n") === 0);

// ===========================================================================
echo "\n" . str_repeat('=', 46) . "\n";
printf("  %d passed, %d failed\n", $GLOBALS['__pass'], $GLOBALS['__fail']);
echo str_repeat('=', 46) . "\n";

// Clean up temp storage.
foreach (glob($tmp . '/{,.}*', GLOB_BRACE) ?: [] as $f) {
    if (is_file($f)) {
        @unlink($f);
    }
}
foreach (glob($tmp . '/ratelimit/*') ?: [] as $f) {
    @unlink($f);
}
@rmdir($tmp . '/ratelimit');
@rmdir($tmp);

exit($GLOBALS['__fail'] > 0 ? 1 : 0);
