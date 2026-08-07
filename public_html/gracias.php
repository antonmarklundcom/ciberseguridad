<?php
declare(strict_types=1);

/**
 * /gracias — BUILD-SPEC-PAGES.md §15. noindex,nofollow permanently (not just
 * pre-launch). Fires the form_submit conversion event via the data-ev shim.
 */

require_once dirname(__DIR__) . '/src/render.php';

layout_open([
    'title'       => 'Recibimos tu consulta | Ciberseguridad.com.py',
    'description' => 'Te respondemos por el canal que elegiste, normalmente dentro del día hábil.',
    'path'        => '/gracias',
    'mode'        => 'b',
    'wa_slug'     => 'gracias',
    'noindex'     => true, // permanent — not the pre-launch default, an intentional never-index
]);
?>
<main id="main">
  <section class="hero">
    <div class="wrap">
      <h1>Recibimos tu consulta.</h1>
      <p>Te respondemos por el canal que elegiste, normalmente dentro del día hábil. Si es urgente y preferís no esperar, escribinos por WhatsApp ahora.</p>
      <a class="btn btn--wa" href="<?= htmlspecialchars(wa_url('gracias')) ?>" data-ev="whatsapp_click" data-ev-loc="gracias"><?= wa_glyph() ?> Escribinos por WhatsApp</a>
      <p style="margin-top:var(--s-6)">Mientras tanto, quizá te sirva leer <a href="/precios">cómo cotizamos</a> o las <a href="/preguntas-frecuentes">preguntas frecuentes</a>.</p>
    </div>
  </section>
</main>
<script>
window.dataLayer = window.dataLayer || [];
window.dataLayer.push({ event: 'form_submit', page_path: location.pathname });
</script>
<?php
layout_close(['mode' => 'b', 'wa_slug' => 'gracias']);
