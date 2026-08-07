<?php
declare(strict_types=1);

/** /servicios/cumplimiento — BUILD-SPEC-PAGES.md §4. */

require_once dirname(__DIR__, 2) . '/src/render.php';

$faqs = [
    ['¿Ustedes certifican ISO 27001?', 'No, y desconfiá de quien te diga que sí: certificar es atribución exclusiva de un organismo de certificación acreditado, y quien te prepara no puede certificarte. Nosotros te preparamos para esa auditoría y te acompañamos durante el proceso.'],
    ['¿Qué pasa si la respuesta a una pregunta es «no»?', 'Se responde que no, con un plan de remediación fechado al lado. La mayoría de los programas de proveedores acepta una brecha conocida con un plan creíble; lo que no aceptan es descubrir después que la respuesta era falsa. Ahí no perdés el contrato: perdés la relación.'],
    ['Tenemos poco tiempo. ¿Se puede en dos semanas?', 'A veces sí, según el tamaño y qué documentación exista. Decinos la fecha límite en la primera llamada y te decimos con franqueza si llegamos.'],
    ['¿Esto es lo mismo que una auditoría de seguridad?', 'No. La auditoría responde «cómo estamos». Cumplimiento responde «cómo demostramos que estamos, en el formato que nos están pidiendo». Muchas veces conviene la auditoría primero, y te lo decimos si es tu caso.'],
];

layout_open([
    'title'       => 'Cumplimiento en seguridad de la información | ISO 27001 y cuestionarios | Paraguay',
    'description' => 'Análisis de brechas contra el marco que te piden, plan de remediación, carpeta de evidencias y acompañamiento en cuestionarios de clientes y Ley 6534/2020.',
    'path'        => '/servicios/cumplimiento',
    'mode'        => 'b',
    'wa_slug'     => 'cumplimiento',
    'jsonld'      => [
        service_jsonld('Cumplimiento en seguridad de la información'),
        breadcrumb_jsonld([['Inicio', '/'], ['Servicios', ''], ['Cumplimiento', '']]),
        faq_jsonld($faqs),
    ],
]);
?>
<main id="main">

  <section class="hero">
    <div class="wrap p1">
      <div>
        <span class="eyebrow">CUMPLIMIENTO</span>
        <h1>Cumplimiento en seguridad: que te alcance el sí.</h1>
        <p>Un cliente, un banco, una casa matriz o un seguro te está pidiendo demostrar controles de seguridad, y no alcanza con decir que los tenés: hay que mostrarlos.</p>
        <p>Hacemos el análisis de brechas contra el marco que te están pidiendo, el plan para cerrarlas y la carpeta de evidencias que respalda cada respuesta.</p>
        <div class="btn-row">
          <a class="btn btn--primary" href="/contacto#agendar" data-ev="schedule_click" data-ev-loc="hero">Agendá una llamada</a>
          <a class="btn btn--wa" href="<?= htmlspecialchars(wa_url('cumplimiento')) ?>" data-ev="whatsapp_click" data-ev-loc="hero"><?= wa_glyph() ?> Escribinos por WhatsApp</a>
        </div>
      </div>
      <div class="p1-visual">
        <div class="hero-visual" style="aspect-ratio:16/10">
          <?= picture_tag('cumplimiento-y-cuestionarios-de-seguridad', 'Reunión de trabajo revisando requisitos de cumplimiento de seguridad', '1280', '800', true, [640, 1280]) ?>
        </div>
      </div>
    </div>
  </section>

  <section>
    <div class="wrap p2">
      <h2>Te llegó una planilla con doscientas preguntas.</h2>
      <p>Y una fecha límite. Y varias de esas preguntas usan términos que nadie en la empresa había leído antes.</p>
      <p>Lo que casi todos hacen primero es tratar de contestarla rápido para sacársela de encima, y ahí aparecen los dos errores caros: responder que sí a algo que no se tiene, o responder que no y suponer que ahí se terminó la conversación.</p>
    </div>
  </section>

  <section>
    <div class="wrap">
      <span class="eyebrow">ALCANCE</span>
      <h2>Qué hacemos, concretamente.</h2>
      <div class="p3-grid" data-count="3" style="margin-top:var(--s-8)">
        <div class="card card--accent span-2" data-reveal="0">
          <h3>Análisis de brechas contra el marco que te piden</h3>
          <p>ISO/IEC 27001, el cuestionario propio del cliente, los requisitos de un banco o lo que exija tu casa matriz. Comparamos control por control lo que la empresa tiene hoy contra lo que se está pidiendo, y marcamos dónde estás parado en cada punto.</p>
        </div>
        <div class="card card--accent" data-reveal="1">
          <h3>Carpeta de evidencias</h3>
          <p>Políticas, registros, capturas y procedimientos que respaldan cada respuesta. Sin evidencia, un "sí" en una planilla es una afirmación que la primera revisión seria desarma.</p>
        </div>
        <div class="card card--accent" data-reveal="2">
          <h3>Ley 6534/2020 de protección de datos</h3>
          <p>Qué significa en la práctica para una empresa que guarda datos de clientes o pacientes en Paraguay, y qué conviene tener documentado.</p>
        </div>
      </div>
    </div>
  </section>

  <section>
    <div class="wrap p4">
      <div class="p4-heading">
        <span class="eyebrow">ENTREGABLE</span>
        <h2>Qué recibís.</h2>
      </div>
      <div class="p4-body" style="display:flex;flex-direction:column;gap:var(--s-6)">
        <div class="card card--hair"><h3>La planilla completada, con su respaldo</h3><p>Cada respuesta con la evidencia que la sostiene y con la referencia a dónde está guardada.</p></div>
        <div class="card card--hair"><h3>Plan de remediación con plazos</h3><p>Para todo lo que hoy es un no. Con esfuerzo estimado y orden sugerido, separando lo que se resuelve configurando de lo que requiere inversión.</p></div>
        <div class="card card--hair"><h3>Acompañamiento en la ronda de repreguntas</h3><p>Casi siempre hay una segunda vuelta con aclaraciones. Es donde se cae la mitad de los procesos y donde más sirve tener a alguien que ya vio veinte de estas.</p></div>
      </div>
    </div>
  </section>

  <section>
    <div class="wrap">
      <span class="eyebrow">CÓMO TRABAJAMOS</span>
      <div class="p5-rail" style="--rail-count:4;margin-top:var(--s-12)">
        <div class="p5-step"><span class="step-num">01</span><h3>Conversación inicial — 30 minutos, sin costo</h3></div>
        <div class="p5-step"><span class="step-num">02</span><h3>Propuesta con alcance y precio fijo — 2 a 3 días hábiles</h3></div>
        <div class="p5-step"><span class="step-num">03</span><h3>Trabajo y entrega</h3></div>
        <div class="p5-step"><span class="step-num">04</span><h3>Ronda de repreguntas</h3><p>Cuando el cliente o el banco vuelve con aclaraciones, las respondemos con vos. Está incluido: no es un trabajo aparte.</p></div>
      </div>
    </div>
  </section>

  <section class="bleed p9 grain">
    <div class="wrap">
      <p class="statement">Un «no» documentado con un plan casi nunca te descalifica. Un «sí» sin respaldo, sí.</p>
      <p>Esta es la parte que casi nadie sabe, y es la que más cambia el resultado.</p>
      <a class="btn btn--primary" href="/contacto#agendar" data-ev="schedule_click" data-ev-loc="cta_final">Agendá una llamada</a>
    </div>
  </section>

  <?php faq_section($faqs); ?>

  <?php service_closing_cta('cumplimiento', 'servicios/cumplimiento'); ?>

</main>
<?php
layout_close(['mode' => 'b', 'wa_slug' => 'cumplimiento']);
