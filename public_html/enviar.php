<?php
declare(strict_types=1);
require_once dirname(__DIR__) . '/src/form-handler.php';
header('Cache-Control: no-store');
header('X-Robots-Tag: noindex');
if (($_SERVER['REQUEST_METHOD'] ?? '') === 'POST' && v_post($_POST, 'form_type') !== 'orientacion') {
    $result = ['action'=>'deny', 'code'=>422];
} else {
    $result = handle_submission($_POST, $_SERVER, $_COOKIE);
}
if ($result['action'] === 'redirect') {
    header('Location: /gracias/', true, 303);
    exit;
}
require_once dirname(__DIR__) . '/src/render.php';
if ($result['action'] === 'deny') {
    $code=(int)($result['code'] ?? 403);
    http_response_code($code);
    if ($code===405) header('Allow: POST');
    if ($code===429) header('Retry-After: 3600');
    if ($code===503) header('Retry-After: 300');
    $message=match($code) {
        429=>'Hay demasiados intentos. Esperá antes de volver a enviar.',
        503=>'El canal de solicitudes no está disponible. La solicitud no quedó confirmada. Intentá más tarde.',
        default=>'No se pudo procesar el formulario. Volvé a abrir la solicitud y revisá los datos.'
    };
    $p=site_page('gracias'); $p['title']='No se pudo registrar la solicitud';
    echo layout($p,'<section class="page-hero"><div class="shell narrow"><h1>No se pudo registrar la solicitud.</h1><p>'.e($message).'</p><a class="button" href="/encontra-un-proveedor/">Volver al formulario</a></div></section>',['minimal'=>true]);
    exit;
}
http_response_code(422);
csrf_token();
$errors=$result['errors']??[]; $old=$result['old']??[]; $page='encontra-un-proveedor';
$p=site_page($page); $p['title']='Revisá la solicitud'; $p['index']=false;
ob_start();
echo '<section class="page-hero"><div class="shell narrow"><h1>Revisá la solicitud.</h1><p>Corregí los campos marcados y volvé a enviar.</p></div></section><section class="section"><div class="shell narrow">';
require dirname(__DIR__) . '/src/partials/orientation-form.php';
echo '</div></section>';
echo layout($p,(string)ob_get_clean());
