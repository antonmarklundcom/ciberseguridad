<?php
declare(strict_types=1);

/** /para/clinicas — BUILD-SPEC-PAGES.md §6. Pattern: 01 P1 · 02 P2 · 03 P4 · 04 P3 · 05 P9 · 06 P1 mirrored. */

require_once dirname(__DIR__, 2) . '/src/render.php';

layout_open([
    'title'       => 'Seguridad informática para clínicas y consultorios | Paraguay',
    'description' => 'Historias clínicas, agenda y facturación en la misma red que el equipamiento de imágenes. Auditoría, respuesta a incidentes y cumplimiento para el sector salud.',
    'path'        => '/para/clinicas',
    'mode'        => 'b',
    'wa_slug'     => 'clinicas',
    'jsonld'      => [breadcrumb_jsonld([['Inicio', '/'], ['Para tu rubro', ''], ['Clínicas', '']])],
]);
?>
<main id="main">

  <section class="hero">
    <div class="wrap">
      <span class="eyebrow">PARA CLÍNICAS Y CONSULTORIOS</span>
      <h1>Seguridad informática para clínicas y consultorios.</h1>
      <p>Cuando una clínica se detiene, no se detiene un sistema: se detiene la atención. Los pacientes ya están en la sala y la agenda del día no espera a que se resuelva un problema informático.</p>
      <div class="btn-row">
        <a class="btn btn--primary" href="/contacto#agendar" data-ev="schedule_click" data-ev-loc="hero">Agendá una llamada</a>
        <a class="btn btn--wa" href="<?= htmlspecialchars(wa_url('clinicas')) ?>" data-ev="whatsapp_click" data-ev-loc="hero"><?= wa_glyph() ?> Escribinos por WhatsApp</a>
      </div>
    </div>
  </section>

  <section>
    <div class="wrap p2">
      <h2>El problema no es solo el dato: es la continuidad.</h2>
      <p>El ransomware en salud es frecuente en la región por una razón simple y poco agradable: es el rubro donde más probable es que se pague, porque la alternativa es suspender atención.</p>
      <p>Y hay una particularidad técnica que hace a las clínicas más vulnerables que a una oficina del mismo tamaño: el equipamiento médico. Un equipo de imágenes corre con el software con el que vino, suele estar fuera de garantía de actualización, y casi siempre está en la misma red plana que la computadora de recepción. No se puede simplemente actualizar. <strong>Se puede separar</strong>, y eso es la mitad del trabajo.</p>
    </div>
  </section>

  <section>
    <div class="wrap p4">
      <div class="p4-heading">
        <span class="eyebrow">QUÉ ESTÁ EN JUEGO</span>
        <h2>Lo que se pone en riesgo.</h2>
      </div>
      <ul class="hairline-list p4-body">
        <li><strong>Historias clínicas</strong> — Es la categoría de dato más sensible que existe y no se puede cambiar como se cambia una tarjeta. Una filtración no se revierte.</li>
        <li><strong>Agenda y facturación</strong> — Si se caen, la clínica no factura ni atiende. La pérdida no es el rescate: es el día perdido, y el segundo día.</li>
        <li><strong>Equipamiento de imágenes y laboratorio</strong> — Sistemas viejos que no se pueden actualizar y que suelen estar donde no deberían estar dentro de la red.</li>
        <li><strong>La obligación de confidencialidad</strong> — El deber sobre los datos del paciente no desaparece porque el problema haya sido informático. Sigue siendo tuyo.</li>
      </ul>
    </div>
  </section>

  <section>
    <div class="wrap">
      <span class="eyebrow">QUÉ HACEMOS EN UNA CLÍNICA</span>
      <h2>Tres prioridades concretas.</h2>
      <div class="p3-grid" data-count="3" style="margin-top:var(--s-8)">
        <div class="card card--accent span-2" data-reveal="0">
          <h3>Separar la red</h3>
          <p>El equipamiento médico y los sistemas administrativos dejan de verse entre sí. Es la medida con mejor relación entre costo y efecto en este rubro, y casi nunca está hecha.</p>
        </div>
        <div class="card card--accent" data-reveal="1">
          <h3>Probar la restauración</h3>
          <p>No revisamos si el backup existe: restauramos una historia clínica de prueba y medimos cuánto tarda. Ese número es tu tiempo real de recuperación, y suele sorprender.</p>
        </div>
        <div class="card card--accent" data-reveal="2">
          <h3>Accesos por rol</h3>
          <p>Recepción, enfermería, profesionales y administración no necesitan ver lo mismo. Y cuando alguien deja la clínica, el acceso se va con la persona.</p>
        </div>
      </div>
    </div>
  </section>

  <section class="bleed p9 grain">
    <div class="wrap">
      <p class="statement">La agenda de mañana no espera a que se resuelva.</p>
      <a class="btn btn--primary" href="/contacto#agendar" data-ev="schedule_click" data-ev-loc="cta_final">Agendá una llamada</a>
    </div>
  </section>

  <section style="padding-top:0">
    <div class="wrap">
      <p><strong>Servicios relacionados para clínicas:</strong> <a href="/servicios/auditoria-de-seguridad">auditoría de seguridad</a> y <a href="/servicios/respuesta-a-incidentes">respuesta a incidentes</a>.</p>
    </div>
  </section>

  <?php service_closing_cta('clinicas', 'para/clinicas'); ?>

</main>
<?php
layout_close(['mode' => 'b', 'wa_slug' => 'clinicas']);
