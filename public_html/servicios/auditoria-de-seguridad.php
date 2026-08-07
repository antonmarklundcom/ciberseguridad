<?php
declare(strict_types=1);

/** /servicios/auditoria-de-seguridad — BUILD-SPEC-PAGES.md §1. */

require_once dirname(__DIR__, 2) . '/src/render.php';

$faqs = [
    ['¿Interrumpe la operación?', 'No. Una auditoría es revisión y entrevistas, no pruebas de ataque. Si querés que intentemos entrar de verdad, eso es pentesting y se contrata aparte.'],
    ['¿Cuánto tiempo le tenemos que dedicar?', 'Entre dos y cuatro horas repartidas del lado de tu equipo, casi todo en entrevistas cortas y en darnos accesos de solo lectura.'],
    ['¿Necesitan acceso a nuestros sistemas?', 'Accesos de solo lectura, los mínimos necesarios, documentados en la propuesta y revocados al terminar. No pedimos contraseñas de usuarios.'],
    ['¿Sirve para responder un cuestionario de un cliente?', 'Sirve como base, pero si eso es lo que necesitás mirá directamente cumplimiento, que está armado para ese caso puntual.'],
];

layout_open([
    'title'       => 'Auditoría de seguridad informática para empresas | Paraguay',
    'description' => 'Revisamos accesos, equipos, backups, correo, red y proveedores. Informe con hallazgos priorizados y plan de remediación. Alcance y precio fijo.',
    'path'        => '/servicios/auditoria-de-seguridad',
    'mode'        => 'b',
    'wa_slug'     => 'auditoria',
    'jsonld'      => [
        service_jsonld('Auditoría de seguridad informática'),
        breadcrumb_jsonld([['Inicio', '/'], ['Servicios', ''], ['Auditoría de seguridad', '']]),
        faq_jsonld($faqs),
    ],
]);
?>
<main id="main">

  <!-- 01 · Hero -->
  <section class="hero">
    <div class="wrap p1">
      <div>
        <span class="eyebrow">AUDITORÍA DE SEGURIDAD</span>
        <h1>Auditoría de seguridad informática para tu empresa.</h1>
        <p>Una revisión completa de cómo está parada tu empresa, hecha desde afuera y con la pregunta que tu proveedor de IT no se hace: ¿por dónde entraría alguien hoy?</p>
        <p>Termina en un informe que podés llevar a una reunión de directorio y en un plan que tu equipo de sistemas puede ejecutar el lunes.</p>
        <div class="btn-row">
          <a class="btn btn--primary" href="/contacto#agendar" data-ev="schedule_click" data-ev-loc="hero">Agendá una llamada</a>
          <a class="btn btn--wa" href="<?= htmlspecialchars(wa_url('auditoria')) ?>" data-ev="whatsapp_click" data-ev-loc="hero"><?= wa_glyph() ?> Escribinos por WhatsApp</a>
        </div>
      </div>
      <div class="p1-visual">
        <div class="hero-visual" style="aspect-ratio:16/10">
          <?= picture_tag('auditoria-de-seguridad-informatica', 'Informe de auditoría de seguridad informática con anotaciones sobre un escritorio', '1280', '800', true, [640, 1280]) ?>
        </div>
      </div>
    </div>
  </section>

  <!-- 02 · La situación · P2 offset stack -->
  <section>
    <div class="wrap p2">
      <h2>Nadie miró nunca esto desde afuera.</h2>
      <p>Tenés soporte de IT, tenés antivirus, tenés backups configurados. Y aun así, si alguien te preguntara hoy cuáles son los tres riesgos más grandes de tu empresa y en qué orden conviene resolverlos, no tendrías una respuesta escrita.</p>
      <p>Eso no es negligencia. Es que mantener los sistemas andando y evaluar cómo se rompen son dos trabajos distintos, y casi nadie tiene tiempo para el segundo.</p>
    </div>
  </section>

  <!-- 03 · Qué incluye · P3, card--accent x3 + hairline list -->
  <section>
    <div class="wrap">
      <span class="eyebrow">ALCANCE</span>
      <h2>Qué miramos, concretamente.</h2>
      <div class="p3-grid" data-count="3" style="margin-top:var(--s-8)">
        <div class="card card--accent span-2" data-reveal="0">
          <h3>Identidades y accesos</h3>
          <p>Quién tiene acceso a qué, qué pasa cuando alguien se va de la empresa, dónde falta segundo factor, cuántas cuentas de administrador hay realmente y cuántas se usan. Es el punto de entrada más común y casi siempre el más desordenado.</p>
        </div>
        <div class="card card--accent" data-reveal="1">
          <h3>Copias de seguridad</h3>
          <p>No si existen: si se restauran. Probamos una restauración real y medimos cuánto tarda. Un backup que nunca se restauró es una hipótesis, no un respaldo.</p>
        </div>
        <div class="card card--accent" data-reveal="2">
          <h3>Correo y fraude de facturas</h3>
          <p>Configuración de SPF, DKIM y DMARC, y qué tan fácil es hacerse pasar por tu dominio. El fraude de cambio de cuenta bancaria es la pérdida real más frecuente en empresas de este tamaño en Paraguay.</p>
        </div>
      </div>
      <p style="margin-top:var(--s-8)"><strong>También revisamos:</strong> equipos y estaciones de trabajo · segmentación de la red interna · proveedores y terceros con acceso a tus sistemas · exposición de servicios publicados a internet · preparación ante incidentes (qué pasa, literalmente, si mañana no arranca nada).</p>
    </div>
  </section>

  <!-- 04 · Qué recibís · P4, card--hair x3 -->
  <section>
    <div class="wrap p4">
      <div class="p4-heading">
        <span class="eyebrow">ENTREGABLE</span>
        <h2>Un informe que se puede usar.</h2>
      </div>
      <div class="p4-body" style="display:flex;flex-direction:column;gap:var(--s-6)">
        <div class="card card--hair"><h3>Informe ejecutivo</h3><p>Entre cuatro y seis páginas, sin jerga, escrito para alguien que decide presupuesto. Qué encontramos, qué significa para el negocio, qué conviene hacer primero.</p></div>
        <div class="card card--hair"><h3>Detalle técnico con hallazgos priorizados</h3><p>Cada hallazgo con su riesgo real, no con una etiqueta genérica de "crítico". Un hallazgo crítico en un sistema que nadie usa no es crítico, y lo decimos así.</p></div>
        <div class="card card--hair"><h3>Plan de remediación con responsables y plazos</h3><p>Escrito para que tu proveedor de IT lo ejecute sin necesitar que se lo traduzcamos. Si algo requiere inversión, lo separamos de lo que es solo configuración.</p></div>
      </div>
    </div>
  </section>

  <!-- 05 · Cómo trabajamos · P5 -->
  <section>
    <div class="wrap">
      <span class="eyebrow">CÓMO TRABAJAMOS</span>
      <div class="p5-rail" style="--rail-count:4;margin-top:var(--s-12)">
        <div class="p5-step"><span class="step-num">01</span><h3>Conversación inicial — 30 minutos, sin costo</h3><p>Entendemos el tamaño, los sistemas y qué te preocupa.</p></div>
        <div class="p5-step"><span class="step-num">02</span><h3>Propuesta con alcance y precio fijo — 2 a 3 días hábiles</h3><p>Qué se revisa, qué no, cuánto dura y cuánto cuesta.</p></div>
        <div class="p5-step"><span class="step-num">03</span><h3>Relevamiento — 1 a 2 semanas según el tamaño</h3><p>Entrevistas cortas con tu gente y revisión técnica. Ocupamos poco tiempo de tu equipo: normalmente entre dos y cuatro horas en total.</p></div>
        <div class="p5-step"><span class="step-num">04</span><h3>Entrega y reunión de cierre</h3><p>Te presentamos los hallazgos, respondemos preguntas y dejamos el plan por escrito. Quedamos disponibles para las dudas que aparezcan cuando empiecen a corregir.</p></div>
      </div>
    </div>
  </section>

  <!-- 06 · Statement CTA · P9 -->
  <section class="bleed p9 grain">
    <div class="wrap">
      <p class="statement">Preferís enterarte vos antes que enterarte por un tercero.</p>
      <a class="btn btn--primary" href="/contacto#agendar" data-ev="schedule_click" data-ev-loc="cta_final">Agendá una llamada</a>
    </div>
  </section>

  <?php faq_section($faqs); ?>

  <?php service_closing_cta('auditoria', 'servicios/auditoria-de-seguridad'); ?>

</main>
<?php
layout_close(['mode' => 'b', 'wa_slug' => 'auditoria']);
