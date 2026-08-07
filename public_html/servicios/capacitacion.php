<?php
declare(strict_types=1);

/** /servicios/capacitacion — BUILD-SPEC-PAGES.md §5. */

require_once dirname(__DIR__, 2) . '/src/render.php';

$faqs = [
    ['¿Cuánta gente puede participar?', 'Hasta 25 personas por sesión para que sea conversada. Si son más, hacemos varias tandas.'],
    ['¿Es presencial o remoto?', 'Las dos. Presencial funciona mejor y en Gran Asunción es lo habitual; remoto permite juntar sucursales.'],
    ['¿Sirve para cumplir con un requisito de un cliente?', 'Sí. Muchos cuestionarios de proveedores piden capacitación periódica documentada, y dejamos constancia de asistencia y contenido para esa carpeta.'],
    ['¿Hacen simulación de phishing sin avisarle a nadie?', 'A la gente no, a la dirección siempre. Y el resultado se informa agregado, nunca por persona.'],
];

layout_open([
    'title'       => 'Capacitación en ciberseguridad para empresas | Paraguay',
    'description' => 'Formación práctica para el equipo que toca los datos: fraude de facturas, phishing, cuentas de la empresa y WhatsApp. Presencial en Gran Asunción o remoto.',
    'path'        => '/servicios/capacitacion',
    'mode'        => 'b',
    'wa_slug'     => 'capacitacion',
    'jsonld'      => [
        service_jsonld('Capacitación en ciberseguridad'),
        breadcrumb_jsonld([['Inicio', '/'], ['Servicios', ''], ['Capacitación', '']]),
        faq_jsonld($faqs),
    ],
]);
?>
<main id="main">

  <section class="hero">
    <div class="wrap p1">
      <div>
        <span class="eyebrow">CAPACITACIÓN</span>
        <h1>Capacitación en ciberseguridad para tu equipo.</h1>
        <p>No una charla genérica sobre contraseñas. Formación sobre los engaños que están llegando ahora mismo a empresas paraguayas, con ejemplos reales del rubro de quien escucha.</p>
        <p>Presencial en Gran Asunción o remoto, en sesiones de 90 minutos que la gente puede tomar sin frenar el día entero.</p>
        <div class="btn-row">
          <a class="btn btn--primary" href="/contacto#agendar" data-ev="schedule_click" data-ev-loc="hero">Agendá una llamada</a>
          <a class="btn btn--wa" href="<?= htmlspecialchars(wa_url('capacitacion')) ?>" data-ev="whatsapp_click" data-ev-loc="hero"><?= wa_glyph() ?> Escribinos por WhatsApp</a>
        </div>
      </div>
      <div class="p1-visual">
        <div class="hero-visual" style="aspect-ratio:16/10">
          <?= picture_tag('capacitacion-en-ciberseguridad-para-empresas', 'Capacitación en ciberseguridad para el personal de una empresa paraguaya', '1280', '800', true, [640, 1280]) ?>
        </div>
      </div>
    </div>
  </section>

  <section>
    <div class="wrap p2">
      <h2>La mayoría de las pérdidas no empiezan con una vulnerabilidad técnica.</h2>
      <p>Empiezan con un correo bien escrito que llega en un momento ocupado, y con alguien de administración que hace exactamente su trabajo: pagar una factura.</p>
      <p>Ese caso no lo resuelve un firewall. Lo resuelve que la persona sepa que ese pedido existe, que sepa cómo se ve, y que tenga permiso explícito de la empresa para frenar y verificar sin sentir que está molestando.</p>
    </div>
  </section>

  <section>
    <div class="wrap">
      <span class="eyebrow">ALCANCE</span>
      <h2>Qué cubrimos, concretamente.</h2>
      <div class="p3-grid" data-count="3" style="margin-top:var(--s-8)">
        <div class="card card--accent span-2" data-reveal="0">
          <h3>Fraude de cambio de cuenta bancaria</h3>
          <p>El más caro y el más frecuente en empresas paraguayas de este tamaño. Cómo llega, por qué es convincente, y el procedimiento de verificación que lo corta: llamar al número que ya tenías, nunca al que viene en el correo.</p>
        </div>
        <div class="card card--accent" data-reveal="1">
          <h3>Phishing y cuentas tomadas</h3>
          <p>Cómo reconocer un pedido de credenciales, qué hacer cuando ya se hizo clic, y por qué el segundo factor es la diferencia entre un susto y un incidente. Incluye WhatsApp, que es donde más pasa acá.</p>
        </div>
        <div class="card card--accent" data-reveal="2">
          <h3>Higiene de cuentas de la empresa</h3>
          <p>Gestores de contraseñas, segundo factor, qué pasa con los accesos cuando alguien se va, y por qué la cuenta compartida de administración es un problema de todos.</p>
        </div>
      </div>
      <p style="margin-top:var(--s-8)"><strong>Formatos:</strong> sesión general para todo el personal (90 minutos) · sesión específica para administración y finanzas, que es donde pega el fraude de facturas (90 minutos) · sesión para dirección sobre decisiones y presupuesto (60 minutos).</p>
    </div>
  </section>

  <section>
    <div class="wrap p4">
      <div class="p4-heading">
        <span class="eyebrow">ENTREGABLE</span>
        <h2>Qué recibís.</h2>
      </div>
      <div class="p4-body" style="display:flex;flex-direction:column;gap:var(--s-6)">
        <div class="card card--hair"><h3>Material de referencia en español</h3><p>Una guía corta que queda en la empresa, para quien entre después de la capacitación.</p></div>
        <div class="card card--hair"><h3>Procedimiento de verificación de pagos por escrito</h3><p>El entregable más útil de todos: un procedimiento de una carilla, aprobado por la dirección, que le da a la gente de administración permiso explícito para frenar un pago y verificarlo.</p></div>
        <div class="card card--hair"><h3>Simulación de phishing, opcional</h3><p>Un envío controlado y acordado con la dirección, con el resultado agregado. <strong>Sin exponer ni sancionar a nadie individualmente</strong> — si se usa para señalar personas, la próxima vez nadie reporta nada y estás peor que antes.</p></div>
      </div>
    </div>
  </section>

  <section>
    <div class="wrap">
      <span class="eyebrow">CÓMO TRABAJAMOS</span>
      <div class="p5-rail" style="--rail-count:4;margin-top:var(--s-12)">
        <div class="p5-step"><span class="step-num">01</span><h3>Conversación inicial — 30 minutos, sin costo</h3><p>Qué rubro, cuánta gente, qué pasó antes si pasó algo.</p></div>
        <div class="p5-step"><span class="step-num">02</span><h3>Adaptación del contenido</h3><p>Ajustamos los ejemplos al rubro y a los sistemas que la empresa usa de verdad.</p></div>
        <div class="p5-step"><span class="step-num">03</span><h3>Las sesiones</h3><p>Presencial en Gran Asunción o remoto, en los horarios que menos molesten.</p></div>
        <div class="p5-step"><span class="step-num">04</span><h3>Material y procedimiento entregados</h3></div>
      </div>
    </div>
  </section>

  <section class="bleed p9 grain">
    <div class="wrap">
      <p class="statement">Tu gente no es el eslabón débil. Es el único que puede frenar el pago.</p>
      <a class="btn btn--primary" href="/contacto#agendar" data-ev="schedule_click" data-ev-loc="cta_final">Agendá una llamada</a>
    </div>
  </section>

  <?php faq_section($faqs); ?>

  <?php service_closing_cta('capacitacion', 'servicios/capacitacion'); ?>

</main>
<?php
layout_close(['mode' => 'b', 'wa_slug' => 'capacitacion']);
