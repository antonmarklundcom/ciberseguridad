<?php
declare(strict_types=1);

/**
 * B2 — validation.
 *
 * Spec: PHP_FORM_SPEC.md §1 (fields) and §4 (security requirements).
 *
 * Every enum is checked against a server-side allow-list. A <select> in the
 * browser is a suggestion, not a constraint — the POST body is attacker
 * controlled in full.
 */

const V_FORM_TYPES = ['contacto', 'autoevaluacion'];

const V_EMPLEADOS = ['1-9', '10-24', '25-49', '50-99', '100-249', '250+'];

const V_RUBROS = [
    'salud', 'contable', 'ecommerce', 'financiero', 'industria',
    'comercio', 'servicios', 'educacion', 'ong', 'otro',
];

const V_DISPARADORES = [
    'incidente', 'cuestionario', 'diagnostico', 'cumplimiento', 'continuo', 'otro',
];

const V_BANDAS = ['alta', 'media', 'solida'];

/** The seven assessment domains. SAFE_SECURITY_TOOL_IDEAS.md §2.1. */
const V_DOMINIOS = [
    'backups', 'accesos', 'correo', 'dispositivos', 'terceros', 'personas', 'preparacion',
];

/**
 * Collapse a single-line field.
 *
 * Returns null when the value contains a control character or a line break.
 * Rejecting rather than stripping is deliberate: a newline in `nombre` is not
 * a formatting accident, it is a header-injection attempt, and it should fail
 * the submission loudly rather than pass through cleaned.
 */
function v_line(string $raw): ?string
{
    if (preg_match('/[\x00-\x1F\x7F]/u', $raw) === 1) {
        return null;
    }
    if (!mb_check_encoding($raw, 'UTF-8')) {
        return null;
    }
    return trim(preg_replace('/\s+/u', ' ', $raw) ?? '');
}

/** Multi-line field: newlines allowed, other control characters stripped. */
function v_text(string $raw): ?string
{
    if (!mb_check_encoding($raw, 'UTF-8')) {
        return null;
    }
    $clean = preg_replace('/[^\P{C}\n]+/u', '', $raw) ?? '';
    $clean = str_replace("\r\n", "\n", $clean);
    return trim($clean);
}

function v_post(array $post, string $key): string
{
    $v = $post[$key] ?? '';
    return is_string($v) ? $v : '';
}

/**
 * Validate a whole submission.
 *
 * @return array{0: array<string,mixed>, 1: array<string,string>} [$clean, $errors]
 */
function validate_submission(array $post): array
{
    $clean  = [];
    $errors = [];

    // --- form_type ---------------------------------------------------------
    $formType = v_line(v_post($post, 'form_type')) ?? '';
    if (!in_array($formType, V_FORM_TYPES, true)) {
        $formType = 'contacto';
    }
    $clean['form_type'] = $formType;

    // --- page slug (drives `source`; user controlled, so constrain hard) ----
    $page = v_line(v_post($post, 'page')) ?? '';
    $clean['page'] = preg_match('#^[a-z0-9\-/]{0,80}$#', $page) === 1 ? $page : '';

    // --- nombre ------------------------------------------------------------
    $nombre = v_line(v_post($post, 'nombre'));
    if ($nombre === null) {
        $errors['nombre'] = 'Revisá el nombre: contiene caracteres no permitidos.';
    } elseif (mb_strlen($nombre) < 2 || mb_strlen($nombre) > 100) {
        $errors['nombre'] = 'Ingresá tu nombre (entre 2 y 100 caracteres).';
    } else {
        $clean['nombre'] = $nombre;
    }

    // --- telefono (required; the contact identity) -------------------------
    $tel = v_line(v_post($post, 'telefono'));
    if ($tel === null || $tel === '') {
        $errors['telefono'] = 'Ingresá un teléfono o WhatsApp.';
    } elseif (
        preg_match('/^[0-9 +\-().]{6,30}$/', $tel) !== 1
        || preg_match_all('/[0-9]/', $tel) < 6
    ) {
        $errors['telefono'] = 'Ingresá un teléfono válido, por ejemplo 0981 123 456.';
    } else {
        $clean['telefono'] = $tel;
    }

    // --- email (optional; omitted from the payload when blank) -------------
    //
    // Note the null/'' distinction on every optional field below: v_line()
    // returns null for a *rejected* value and '' for an *absent* one. Coalescing
    // the two would silently drop an injection attempt and let the submission
    // through without the field, which hides an attack instead of failing on it.
    $email = v_line(v_post($post, 'email'));
    if ($email === null) {
        $errors['email'] = 'Ese correo no parece válido.';
    } elseif ($email !== '') {
        if (mb_strlen($email) > 320 || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = 'Ese correo no parece válido.';
        } else {
            $clean['email'] = $email;
        }
    }

    // --- empresa (optional) ------------------------------------------------
    $empresa = v_line(v_post($post, 'empresa'));
    if ($empresa === null) {
        $errors['empresa'] = 'El nombre de la empresa contiene caracteres no permitidos.';
    } elseif ($empresa !== '') {
        if (mb_strlen($empresa) > 120) {
            $errors['empresa'] = 'El nombre de la empresa es demasiado largo.';
        } else {
            $clean['empresa'] = $empresa;
        }
    }

    // --- enums -------------------------------------------------------------
    $empleados = v_line(v_post($post, 'empleados')) ?? '';
    if (!in_array($empleados, V_EMPLEADOS, true)) {
        $errors['empleados'] = 'Elegí la cantidad de empleados.';
    } else {
        $clean['empleados'] = $empleados;
    }

    $rubro = v_line(v_post($post, 'rubro')) ?? '';
    if (!in_array($rubro, V_RUBROS, true)) {
        $errors['rubro'] = 'Elegí el rubro.';
    } else {
        $clean['rubro'] = $rubro;
    }

    $disparador = v_line(v_post($post, 'disparador')) ?? '';
    if ($formType === 'autoevaluacion' && $disparador === '') {
        $disparador = 'diagnostico';
    }
    if (!in_array($disparador, V_DISPARADORES, true)) {
        $errors['disparador'] = 'Contanos qué te trae por acá.';
    } else {
        $clean['disparador'] = $disparador;
    }

    // --- form-specific -----------------------------------------------------
    if ($formType === 'contacto') {
        $mensaje = v_text(v_post($post, 'mensaje'));
        if ($mensaje === null) {
            $errors['mensaje'] = 'El mensaje contiene caracteres no permitidos.';
            $mensaje = '';
        }
        if (mb_strlen($mensaje) > 2000) {
            $errors['mensaje'] = 'El mensaje es demasiado largo (máximo 2000 caracteres).';
        } elseif ($mensaje !== '') {
            $clean['mensaje'] = $mensaje;
        }
    } else {
        [$assess, $assessErrors] = validate_assessment($post);
        $clean  = array_merge($clean, $assess);
        $errors = array_merge($errors, $assessErrors);
    }

    return [$clean, $errors];
}

/**
 * Assessment-specific fields.
 *
 * `dominios` arrives as a JSON blob from client-side JavaScript. It is parsed,
 * key-checked against the allow-list and re-serialised rather than forwarded —
 * a client blob must never be passed through into an outbound API call.
 */
function validate_assessment(array $post): array
{
    $clean  = [];
    $errors = [];

    $scoreRaw = v_line(v_post($post, 'score')) ?? '';
    if (preg_match('/^\d{1,3}$/', $scoreRaw) !== 1 || (int) $scoreRaw > 100) {
        $errors['score'] = 'Puntaje inválido.';
    } else {
        $clean['score'] = (int) $scoreRaw;
    }

    $banda = v_line(v_post($post, 'banda')) ?? '';
    if (!in_array($banda, V_BANDAS, true)) {
        $errors['banda'] = 'Banda inválida.';
    } else {
        $clean['banda'] = $banda;
    }

    $raw = v_post($post, 'dominios');
    if (strlen($raw) > 1000) {
        $errors['dominios'] = 'Detalle por dominio demasiado extenso.';
        return [$clean, $errors];
    }

    $dominios = [];
    if ($raw !== '') {
        $decoded = json_decode($raw, true);
        if (!is_array($decoded)) {
            $errors['dominios'] = 'Detalle por dominio inválido.';
            return [$clean, $errors];
        }
        foreach (V_DOMINIOS as $name) {
            if (!array_key_exists($name, $decoded)) {
                continue;
            }
            $val = $decoded[$name];
            if (!is_int($val) && !(is_string($val) && preg_match('/^\d{1,3}$/', $val) === 1)) {
                $errors['dominios'] = 'Detalle por dominio inválido.';
                return [$clean, $errors];
            }
            $dominios[$name] = min(100, max(0, (int) $val));
        }
    }
    $clean['dominios'] = $dominios;

    return [$clean, $errors];
}

/**
 * Lead band, per LEAD_FUNNEL.md §4.
 *
 * A/B/C only. Band D ("not a fit" — individuals, students, job seekers) is a
 * human judgement that no form field can carry, and inventing a heuristic for
 * it would mis-sort real prospects. It is assigned by hand in the CRM.
 */
function lead_band(array $clean): string
{
    $disparador = $clean['disparador'] ?? '';
    $empleados  = $clean['empleados'] ?? '';

    // Employee bands, ordered. "30+" and "15+" in the funnel doc fall inside
    // the 25-49 and 10-24 buckets respectively; the bucket boundary is used.
    $rank = array_flip(V_EMPLEADOS);
    $size = $rank[$empleados] ?? 0;

    if (in_array($disparador, ['incidente', 'cuestionario'], true)) {
        return 'A';
    }
    if ($size >= ($rank['25-49'] ?? 2) && isset($clean['score']) && $clean['score'] < 40) {
        return 'A';
    }
    if ($size >= ($rank['10-24'] ?? 1)) {
        return 'B';
    }
    return 'C';
}
