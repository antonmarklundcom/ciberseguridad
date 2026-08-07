<?php
declare(strict_types=1);

/**
 * /guias/ — hub — BUILD-SPEC-PAGES.md §14.1.
 *
 * ⚠️ The one planned guide (responder-un-cuestionario-de-seguridad) is not
 * built yet — its ~1,200-1,600 word prose is explicitly a separate content
 * turn per §14.2, and "a hub padded with stubs is not fine" per the same
 * section. Rather than fabricate a stub article (which the QA gate forbids —
 * zero placeholder text in rendered output) or dead-link to a page that
 * doesn't exist, this hub ships honest about its current state. Add the
 * article listing here the same day the article itself ships.
 */

require_once dirname(__DIR__, 2) . '/src/render.php';

layout_open([
    'title'       => 'Guías | Ciberseguridad para empresas en Paraguay',
    'description' => 'Material práctico sobre seguridad informática para empresas paraguayas, escrito para quien tiene que tomar la decisión.',
    'path'        => '/guias/',
    'mode'        => 'b',
    'wa_slug'     => 'guias',
    'jsonld'      => [breadcrumb_jsonld([['Inicio', '/'], ['Guías', '']])],
]);
?>
<main id="main">

  <section>
    <div class="wrap p4">
      <div class="p4-heading">
        <span class="eyebrow">GUÍAS</span>
        <h1>Guías</h1>
      </div>
      <div class="p4-body">
        <p>Estamos preparando la primera guía, sobre cómo responder un cuestionario de seguridad de un cliente. Mientras tanto, si tenés una situación concreta, escribinos directamente.</p>
        <a class="btn btn--wa" href="<?= htmlspecialchars(wa_url('guias')) ?>" data-ev="whatsapp_click" data-ev-loc="guias"><?= wa_glyph() ?> Escribinos por WhatsApp</a>
      </div>
    </div>
  </section>

</main>
<?php
layout_close(['mode' => 'b', 'wa_slug' => 'guias']);
