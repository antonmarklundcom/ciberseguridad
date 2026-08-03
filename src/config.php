<?php
declare(strict_types=1);

/**
 * Configuration. Reads the environment; holds no secrets itself.
 *
 * Block A owns the full version of this file. Block B needs only the keys
 * below — extend rather than replace.
 */

function cfg(?string $key = null, mixed $default = null): mixed
{
    static $cfg = null;
    if ($cfg === null) {
        $cfg = cfg_build();
    }
    if ($key === null) {
        return $cfg;
    }
    return $cfg[$key] ?? $default;
}

function cfg_build(): array
{
    $root = dirname(__DIR__);
    cfg_load_env_file($root . '/.env');

    return [
        'site_url'       => rtrim(cfg_env('SITE_URL', 'https://ciberseguridad.com.py'), '/'),
        'vendercrm_url'  => rtrim(cfg_env('VENDERCRM_URL', ''), '/'),
        'vendercrm_key'  => cfg_env('VENDERCRM_API_KEY', ''),
        'notify_email'   => cfg_env('NOTIFY_EMAIL', ''),
        'mail_from'      => cfg_env('MAIL_FROM', ''),
        // STORAGE_DIR is overridable so the test suite never touches real leads.
        'storage_dir'    => cfg_env('STORAGE_DIR', $root . '/storage'),

        // Tunables. See PHP_FORM_SPEC.md §3–§4.
        'crm_timeout'    => 10,
        'rate_limit'     => 5,
        'rate_window'    => 3600,
        'min_fill_secs'  => 3,
        'max_form_age'   => 7200,
    ];
}

/**
 * Minimal .env reader.
 *
 * Deliberately does NOT use putenv()/$_ENV: values stay in this process only
 * and never leak into a subprocess environment.
 */
function cfg_load_env_file(string $path): void
{
    static $loaded = [];
    if (isset($loaded[$path]) || !is_readable($path)) {
        return;
    }
    $loaded[$path] = true;

    $lines = file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    if ($lines === false) {
        return;
    }
    foreach ($lines as $line) {
        $line = trim($line);
        if ($line === '' || $line[0] === '#' || !str_contains($line, '=')) {
            continue;
        }
        [$k, $v] = explode('=', $line, 2);
        $k = trim($k);
        $v = trim($v);
        if (strlen($v) > 1 && ($v[0] === '"' || $v[0] === "'") && $v[0] === substr($v, -1)) {
            $v = substr($v, 1, -1);
        }
        cfg_env_store($k, $v);
    }
}

function cfg_env_store(?string $key = null, ?string $value = null): array
{
    static $store = [];
    if ($key !== null) {
        $store[$key] = (string) $value;
    }
    return $store;
}

/**
 * Reads from the .env store first, then the real environment.
 *
 * getenv() returning false on shared hosting is a common cause of a silent
 * 401 from the CRM — see docs/VENDERCRM_INTEGRATION.md, "When leads are not
 * arriving".
 */
function cfg_env(string $key, string $default = ''): string
{
    $store = cfg_env_store();
    if (isset($store[$key]) && $store[$key] !== '') {
        return $store[$key];
    }
    $v = getenv($key);
    if (is_string($v) && $v !== '') {
        return $v;
    }
    return $default;
}
