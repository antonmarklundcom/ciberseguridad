<?php
declare(strict_types=1);

/** /404 — BUILD-SPEC-PAGES.md §15. */

require_once dirname(__DIR__) . '/src/render.php';

http_response_code(404);

layout_open([
    'title'       => 'Esta página no existe | Ciberseguridad.com.py',
    'description' => 'Puede que el enlace esté viejo o que la dirección tenga un error de tipeo.',
    'path'        => '/404',
    'mode'        => 'b',
    'wa_slug'     => '404',
]);
?>
<main id="main">
  <section class="hero">
    <div class="wrap">
      <h1>Esta página no existe.</h1>
      <p>Puede que el enlace esté viejo o que la dirección tenga un error de tipeo.</p>
      <div class="btn-row">
        <a class="btn btn--primary" href="/">Ir al inicio</a>
        <a class="btn btn--ghost" href="/servicios/auditoria-de-seguridad">Ver servicios</a>
        <a class="btn btn--ghost" href="/contacto">Contacto</a>
      </div>
    </div>
  </section>
</main>
<?php
layout_close(['mode' => 'b', 'wa_slug' => '404']);
