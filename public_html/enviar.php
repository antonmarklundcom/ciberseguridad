<?php
declare(strict_types=1);

/**
 * POST /enviar — the only server-side entry point on the site.
 *
 * Thin front controller: it delegates to handle_submission() and turns the
 * result into a response. All logic lives in src/, outside the web root.
 */

require_once dirname(__DIR__) . '/src/form-handler.php';

$result = handle_submission($_POST, $_SERVER, $_COOKIE);

switch ($result['action']) {
    case 'redirect':
        header('Location: ' . $result['to'], true, 302);
        exit;

    case 'deny':
        $code = (int) ($result['code'] ?? 403);
        http_response_code($code);
        header('Content-Type: text/html; charset=UTF-8');
        // Deliberately says nothing about why. A CSRF failure and a wrong
        // method look identical from outside.
        echo '<!doctype html><html lang="es-PY"><head><meta charset="utf-8">'
           . '<title>No se pudo procesar</title><meta name="robots" content="noindex">'
           . '</head><body><h1>No se pudo procesar el formulario</h1>'
           . '<p>Volvé a la página e intentá de nuevo, o escribinos por WhatsApp.</p>'
           . '<p><a href="/">Volver al inicio</a></p></body></html>';
        exit;

    case 'render':
    default:
        http_response_code(422);
        header('Content-Type: text/html; charset=UTF-8');

        $form_type = $result['form_type'] ?? 'contacto';
        $page      = $result['page'] ?? '';
        $errors    = $result['errors'] ?? [];
        $old       = $result['old'] ?? [];

        // Re-render inside the real site shell. The form partial is unchanged.
        require_once dirname(__DIR__) . '/src/render.php';
        $GLOBALS['__page'] = ['title' => 'Revisá el formulario | Ciberseguridad.com.py',
            'desc' => 'Revisá los campos marcados y volvé a enviar tu consulta.',
            'label' => 'Formulario', 'group' => 'hidden', 'index' => false, 'prio' => '0.0',
            'wa' => 'Hola, quiero hacer una consulta sobre seguridad informática', 'slug' => 'contacto'];
        ob_start();
        echo '<section class="hero"><div class="wrap"><h1>Revisá el formulario</h1><div class="two-col"><div>';
        require dirname(__DIR__) . '/src/partials/lead-form.php';
        echo '</div></div></div></section>';
        echo layout($GLOBALS['__page'], (string) ob_get_clean(), ['service' => 'contacto']);
        exit;
}
