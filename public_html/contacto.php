<?php
declare(strict_types=1);

/** /contacto — BUILD-SPEC-PAGES.md §12. Pattern: 01 P1 (channels 5/form 7) · 02 P8 ribbon · 03 P4. */

require_once dirname(__DIR__) . '/src/render.php';

layout_open([
    'title'       => 'Contacto | Ciberseguridad.com.py',
    'description' => 'Escribinos por WhatsApp, llamanos o agendá una llamada de 30 minutos sin costo. Respondemos en el día hábil.',
    'path'        => '/contacto',
    'mode'        => 'b',
    'wa_slug'     => 'contacto',
    'jsonld'      => [breadcrumb_jsonld([['Inicio', '/'], ['Contacto', '']])],
]);
?>
<main id="main">

  <!-- 01 · Contacto -->
  <section>
    <div class="wrap p1 p1--mirrored">
      <div>
        <span class="eyebrow">CONTACTO</span>
        <h1>Escribinos.</h1>
        <p><strong>Por WhatsApp</strong> — la vía más rápida. +595 995 628862</p>
        <a class="btn btn--wa" href="<?= htmlspecialchars(wa_url('contacto')) ?>" data-ev="whatsapp_click" data-ev-loc="contacto"><?= wa_glyph() ?> Escribinos por WhatsApp</a>
        <p style="margin-top:var(--s-6)"><strong>Por teléfono</strong> — <a href="<?= htmlspecialchars(tel_href()) ?>">+595 995 628862</a></p>
        <p><strong>Por correo</strong> — <a href="mailto:contacto@ciberseguridad.com.py">contacto@ciberseguridad.com.py</a></p>
        <p><strong>Agendá una llamada</strong> — media hora, sin costo, para entender tu situación.</p>
        <p><strong>Horarios de atención</strong> — Lunes a viernes, de 8:00 a 18:00.</p>
        <small>⚠️ Incidentes en curso: ver <a href="/servicios/respuesta-a-incidentes">respuesta a incidentes</a>.</small>
      </div>
      <div id="agendar-form">
        <p>Contanos brevemente tu situación y te respondemos en el día hábil. Si preferís hablar antes de escribir, escribinos por WhatsApp.</p>
        <?php
        $form_type = 'contacto';
        $page      = 'contacto';
        $errors    = [];
        $old       = [];
        require dirname(__DIR__) . '/src/partials/lead-form.php';
        ?>
      </div>
    </div>
  </section>

  <!-- 02 · Franja · P8 ribbon -->
  <section class="bleed p8 grain">
    <div class="wrap">
      <span>Respondemos en el día hábil</span><span class="divider">·</span>
      <span>Primera conversación de 30 minutos sin costo</span><span class="divider">·</span>
      <span>Acuerdo de confidencialidad antes de empezar</span>
    </div>
  </section>

  <!-- 03 · Qué pasa después · P4 -->
  <section>
    <div class="wrap p4">
      <div class="p4-heading">
        <span class="eyebrow">DESPUÉS DE ESCRIBIR</span>
        <h2>Qué pasa después de que escribís.</h2>
      </div>
      <div class="p4-body">
        <p>Te respondemos por el canal que elegiste, normalmente el mismo día hábil. Coordinamos una llamada de 30 minutos, sin costo, donde nos contás la situación y te decimos con franqueza si somos las personas indicadas.</p>
        <p>Si lo somos, te mandamos una propuesta con alcance y precio fijo en dos o tres días hábiles. Si no lo somos, te lo decimos y te orientamos hacia quien sí.</p>
      </div>
    </div>
  </section>

</main>
<?php
layout_close(['mode' => 'b', 'wa_slug' => 'contacto']);
