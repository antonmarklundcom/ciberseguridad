<?php
declare(strict_types=1);

/**
 * /precios — «Cómo cotizamos» — BUILD-SPEC-PAGES.md §10.
 * ⚠️ Ships with no published amounts (BUILD-SPEC.md §12 item 5). If bands are
 * later approved, they insert as a table after §03 — no other change needed.
 */

require_once dirname(__DIR__) . '/src/render.php';

layout_open([
    'title'       => 'Cómo cotizamos | Alcance y precio fijo por escrito',
    'description' => 'Cómo se determina el precio de una auditoría, un pentesting o un trabajo de cumplimiento, y por qué trabajamos con precio fijo en vez de hora abierta.',
    'path'        => '/precios',
    'mode'        => 'b',
    'wa_slug'     => 'precios',
    'jsonld'      => [breadcrumb_jsonld([['Inicio', '/'], ['Cómo cotizamos', '']])],
]);
?>
<main id="main">

  <section class="hero">
    <div class="wrap">
      <span class="eyebrow">CÓMO COTIZAMOS</span>
      <h1>Alcance y precio fijo, por escrito, antes de empezar.</h1>
      <p>No publicamos una lista de precios porque una auditoría de una empresa de veinte personas y una de doscientas no se parecen en nada, y un número inventado en una tabla no te ayuda a decidir.</p>
      <p>Lo que sí podemos decirte de antemano es exactamente cómo se determina, para que sepas qué esperar antes de la primera llamada.</p>
    </div>
  </section>

  <section>
    <div class="wrap p4">
      <div class="p4-heading">
        <span class="eyebrow">POR QUÉ PRECIO FIJO</span>
        <h2>La hora abierta te traslada a vos todo el riesgo.</h2>
      </div>
      <div class="p4-body">
        <p>Si facturamos por hora, cada complicación que aparece la pagás vos, y no tenés forma de saber al firmar cuánto va a terminar costando. Cotizando cerrado, ese riesgo es nuestro, que es de quien tiene la experiencia para estimarlo.</p>
        <p>También hace la conversación más honesta: si a mitad del trabajo aparece algo que está fuera del alcance, te lo decimos y decidís vos si lo agregamos, en vez de descubrirlo en la factura.</p>
      </div>
    </div>
  </section>

  <section>
    <div class="wrap">
      <span class="eyebrow">QUÉ DETERMINA EL PRECIO</span>
      <h2>Tres factores, en orden de peso.</h2>
      <div class="p3-grid" data-count="3" style="margin-top:var(--s-8)">
        <div class="card card--accent span-2" data-reveal="0">
          <h3>El tamaño y la cantidad de sistemas</h3>
          <p>Cuántas personas, cuántas sedes, cuántos sistemas propios, si hay desarrollo interno. Es lo que más pesa, y se puede estimar bastante bien en la primera conversación.</p>
        </div>
        <div class="card card--accent" data-reveal="1">
          <h3>La profundidad</h3>
          <p>Un diagnóstico de superficie y una revisión a fondo con pruebas técnicas son trabajos distintos. Muchas veces conviene empezar por el primero.</p>
        </div>
        <div class="card card--accent" data-reveal="2">
          <h3>El plazo</h3>
          <p>Si hay una fecha límite externa que obliga a comprimir el trabajo, eso tiene un costo y te lo decimos de frente en vez de esconderlo.</p>
        </div>
      </div>
    </div>
  </section>

  <section>
    <div class="wrap">
      <span class="eyebrow">SIEMPRE INCLUIDO</span>
      <h2>Qué está siempre incluido.</h2>
      <div class="p5-rail" style="--rail-count:4;margin-top:var(--s-12)">
        <div class="p5-step"><span class="step-num">01</span><h3>La conversación inicial de 30 minutos</h3><p>Sin costo, sin compromiso, y sin que termine en una propuesta si vemos que no hace falta.</p></div>
        <div class="p5-step"><span class="step-num">02</span><h3>La propuesta</h3><p>Escrita, con alcance explícito, exclusiones explícitas, plazo y precio. No se cobra.</p></div>
        <div class="p5-step"><span class="step-num">03</span><h3>La reunión de cierre</h3><p>Presentamos los hallazgos y respondemos preguntas del equipo.</p></div>
        <div class="p5-step"><span class="step-num">04</span><h3>Las dudas posteriores</h3><p>Durante los 90 días siguientes a la entrega, las consultas sobre el informe están incluidas. No te vamos a facturar por explicar lo que escribimos.</p></div>
      </div>
    </div>
  </section>

  <section class="bleed p9 grain">
    <div class="wrap">
      <p class="statement">Vas a saber cuánto cuesta antes de decidir. Esa es la idea.</p>
      <a class="btn btn--primary" href="/contacto#agendar" data-ev="schedule_click" data-ev-loc="cta_final">Agendá una llamada</a>
    </div>
  </section>

  <?php service_closing_cta('precios', 'precios'); ?>

</main>
<?php
layout_close(['mode' => 'b', 'wa_slug' => 'precios']);
