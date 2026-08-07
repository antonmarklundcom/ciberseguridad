<?php
declare(strict_types=1);

/**
 * /terminos — BUILD-SPEC-PAGES.md §15.
 * ⚠️ Not drafted here — entirely legal content, no minimum spec given for it
 * unlike the privacy policy. Route, layout and footer link exist; body copy
 * is left for legal review before launch, per the launch-gate rule that the
 * site must not launch with this page empty.
 */

require_once dirname(__DIR__) . '/src/render.php';

layout_open([
    'title'       => 'Términos | Ciberseguridad.com.py',
    'description' => 'Términos de uso de este sitio.',
    'path'        => '/terminos',
    'mode'        => 'b',
    'wa_slug'     => 'terminos',
]);
?>
<main id="main">
  <section class="hero" style="padding-block:var(--s-16)">
    <div class="wrap">
      <h1>Términos</h1>
      <p><strong>⚠️ Pendiente de redacción legal.</strong> Esta página existe como ruta y estructura, lista para recibir el texto de términos de uso una vez que lo revise un abogado. No se publica contenido legal generado sin revisión — ver <code>BUILD-SPEC-PAGES.md</code> §15. Esto es un ítem bloqueante del lanzamiento.</p>
      <p>Mientras tanto, para cualquier consulta sobre el uso de este sitio, escribinos a <a href="mailto:contacto@ciberseguridad.com.py">contacto@ciberseguridad.com.py</a>.</p>
    </div>
  </section>
</main>
<?php
layout_close(['mode' => 'b', 'wa_slug' => 'terminos']);
