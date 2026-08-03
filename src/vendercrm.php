<?php
declare(strict_types=1);

/**
 * B1 — VenderCRM client.
 *
 * Spec: docs/VENDERCRM_INTEGRATION.md
 *
 * Returns rather than throws; the caller decides what a failure means. On this
 * site a failure means "log it and still show the visitor the thank-you page"
 * — see rule 5 in the integration doc.
 */

/**
 * POST a lead to VenderCRM.
 *
 * @param array         $payload   Built by vendercrm_build_payload().
 * @param callable|null $transport Injectable for tests:
 *                                 fn(string $url, string $body, string[] $headers, int $timeout)
 *                                   : array{status:int, body:string, error:string}
 *
 * @return array{ok:bool, status:int, body:string, error:string,
 *                contact_id:string, deal_id:string, duplicate:bool}
 */
function vendercrm_push(array $payload, ?callable $transport = null): array
{
    $base = (string) cfg('vendercrm_url');
    $key  = (string) cfg('vendercrm_key');

    $fail = static fn (string $err): array => [
        'ok' => false, 'status' => 0, 'body' => '', 'error' => $err,
        'contact_id' => '', 'deal_id' => '', 'duplicate' => false,
    ];

    if ($base === '' || $key === '') {
        // Almost always a shared-hosting environment problem rather than a
        // typo. Named explicitly so the log says what to check.
        return $fail('VENDERCRM_URL or VENDERCRM_API_KEY missing from the environment');
    }

    $json = json_encode($payload, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    if ($json === false) {
        return $fail('payload could not be encoded as JSON');
    }

    $transport ??= 'vendercrm_curl_transport';

    $res = $transport(
        $base . '/api/v1/leads',
        $json,
        [
            'Content-Type: application/json',
            'Accept: application/json',
            'X-Api-Key: ' . $key,
        ],
        (int) cfg('crm_timeout', 10)
    );

    $status = (int) ($res['status'] ?? 0);
    $body   = (string) ($res['body'] ?? '');
    $error  = (string) ($res['error'] ?? '');

    $decoded = $body !== '' ? json_decode($body, true) : null;
    $decoded = is_array($decoded) ? $decoded : [];

    // 201 = created. 200 = idempotency key replayed, which is the retry
    // working as designed and is a success, not a duplicate to clean up.
    $ok = ($status === 201 || $status === 200);

    return [
        'ok'         => $ok,
        'status'     => $status,
        'body'       => $body,
        'error'      => $error,
        'contact_id' => isset($decoded['contactId']) ? (string) $decoded['contactId'] : '',
        'deal_id'    => isset($decoded['dealId']) ? (string) $decoded['dealId'] : '',
        'duplicate'  => (bool) ($decoded['duplicate'] ?? false),
    ];
}

/**
 * Default transport.
 *
 * Peer and host verification stay on. There is no configuration flag to turn
 * them off, deliberately: a debugging session is exactly when someone reaches
 * for CURLOPT_SSL_VERIFYPEER => false and forgets to put it back.
 */
function vendercrm_curl_transport(string $url, string $body, array $headers, int $timeout): array
{
    $ch = curl_init($url);
    if ($ch === false) {
        return ['status' => 0, 'body' => '', 'error' => 'curl_init failed'];
    }

    curl_setopt_array($ch, [
        CURLOPT_POST           => true,
        CURLOPT_POSTFIELDS     => $body,
        CURLOPT_HTTPHEADER     => $headers,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_TIMEOUT        => $timeout,
        CURLOPT_CONNECTTIMEOUT => min(5, $timeout),
        CURLOPT_SSL_VERIFYPEER => true,
        CURLOPT_SSL_VERIFYHOST => 2,
        CURLOPT_FOLLOWLOCATION => false,
        CURLOPT_PROTOCOLS      => CURLPROTO_HTTPS,
    ]);

    $out    = curl_exec($ch);
    $status = (int) curl_getinfo($ch, CURLINFO_RESPONSE_CODE);
    $error  = curl_error($ch);
    curl_close($ch);

    return [
        'status' => $status,
        'body'   => is_string($out) ? $out : '',
        'error'  => $error,
    ];
}

/**
 * Build the payload from validated input.
 *
 * Optional fields are omitted rather than sent as "" — an empty string fails
 * validation on `email` and returns a 422.
 *
 * Never sets pipeline, stage, owner or tag: routing lives on the site record
 * in the CRM so it can change without a deploy, and so a leaked key cannot
 * redirect leads into another pipeline.
 */
function vendercrm_build_payload(array $clean, array $attr, string $idempotencyKey): array
{
    $page = (string) ($clean['page'] ?? '');

    $payload = [
        'phone'           => (string) $clean['telefono'],
        'idempotency_key' => $idempotencyKey,
        'source'          => 'cyber:' . ($page !== '' ? $page : 'desconocida'),
    ];

    // page_url is composed server-side from the validated slug rather than
    // taken from the request, so a forged field cannot plant an arbitrary URL
    // on the CRM timeline.
    $payload['page_url'] = cfg('site_url') . '/' . ltrim($page, '/');

    foreach (['nombre' => 'name', 'email' => 'email', 'mensaje' => 'message'] as $src => $dst) {
        if (!empty($clean[$src])) {
            $payload[$dst] = (string) $clean[$src];
        }
    }

    foreach (['referrer', 'utm_source', 'utm_medium', 'utm_campaign',
              'utm_term', 'utm_content', 'gclid', 'fbclid'] as $k) {
        if (!empty($attr[$k])) {
            $payload[$k] = (string) $attr[$k];
        }
    }

    // `fields` values are enum strings so they stay filterable in the CRM.
    // Free text belongs in `message`.
    $fields = ['form_type' => (string) $clean['form_type']];
    foreach (['empresa', 'empleados', 'rubro', 'disparador'] as $k) {
        if (!empty($clean[$k])) {
            $fields[$k] = (string) $clean[$k];
        }
    }

    if ($clean['form_type'] === 'autoevaluacion') {
        if (isset($clean['score'])) {
            $fields['score'] = (string) $clean['score'];
        }
        if (!empty($clean['banda'])) {
            $fields['banda'] = (string) $clean['banda'];
        }
        // Flattened rather than nested, so each domain is filterable.
        foreach (($clean['dominios'] ?? []) as $name => $val) {
            $fields['dominio_' . $name] = (string) $val;
        }
    }

    $payload['fields'] = $fields;

    return $payload;
}

/**
 * Stable idempotency key.
 *
 * Phone + form + current hour: collapses genuine double-submits (double click,
 * a timeout after the write succeeded) while still letting the same person
 * enquire again tomorrow.
 */
function vendercrm_idempotency_key(string $phone, string $formType): string
{
    return hash('sha256', $phone . '|' . $formType . '|' . gmdate('Y-m-d-H'));
}
