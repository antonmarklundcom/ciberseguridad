<?php
declare(strict_types=1);

/**
 * /para/pymes — BUILD-SPEC-PAGES.md §9. Router page.
 * Pattern: 01 P1 · 02 P4 · 03 P3 (router) · 04 P5 · 05 P9 · 06 P1 mirrored.
 * Per §16: the only /para/* page that links to all four other vertical pages.
 */

require_once dirname(__DIR__, 2) . '/src/render.php';

layout_open([
    'title'       => 'Ciberseguridad para PYMES en Paraguay',
    'description' => 'Tenés soporte de IT pero no función de seguridad. Por dónde empezar, qué se resuelve configurando y qué requiere inversión. Guía honesta y sin humo.',
    'path'        => '/para/pymes',
    'mode'        => 'b',
    'wa_slug'     => 'pymes',
    'jsonld'      => [breadcrumb_jsonld([['Inicio', '/'], ['Para tu rubro', ''], ['PYMES', '']])],
]);
?>
<main id="main">

  <section class="hero">
    <div class="wrap">
      <span class="eyebrow">PARA PYMES</span>
      <h1>Ciberseguridad para PYMES paraguayas.</h1>
      <p>Tenés entre quince y doscientos empleados, tenés alguien que se ocupa de la informática, y no tenés a nadie cuyo trabajo sea la seguridad. Eso no es una falla de gestión: es lo normal a este tamaño.</p>
      <div class="btn-row">
        <a class="btn btn--primary" href="/contacto#agendar" data-ev="schedule_click" data-ev-loc="hero">Agendá una llamada</a>
        <a class="btn btn--wa" href="<?= htmlspecialchars(wa_url('pymes')) ?>" data-ev="whatsapp_click" data-ev-loc="hero"><?= wa_glyph() ?> Escribinos por WhatsApp</a>
      </div>
    </div>
  </section>

  <section>
    <div class="wrap p4">
      <div class="p4-heading">
        <span class="eyebrow">SOPORTE DE IT Y SEGURIDAD NO SON LO MISMO</span>
        <h2>Son dos trabajos distintos.</h2>
      </div>
      <div class="p4-body">
        <p>Tu proveedor de IT mantiene los sistemas funcionando. Se lo mide por eso, y normalmente lo hace bien. La seguridad se mide por lo contrario: por cómo se rompe algo que hoy funciona, y qué pasa después.</p>
        <p>Un proveedor de IT excelente puede tener la red entera en un solo segmento y los backups en un disco que el ransomware alcanza, y no es un descuido: es que nadie le pidió nunca ese trabajo, ni se lo pagó.</p>
        <p>No venimos a reemplazar a tu proveedor. Los hallazgos se los entregamos a ellos, escritos para que los puedan ejecutar.</p>
      </div>
    </div>
  </section>

  <section>
    <div class="wrap">
      <span class="eyebrow">¿POR DÓNDE EMPEZAR?</span>
      <h2>Elegí tu situación.</h2>
      <div class="p3-grid" data-count="3" style="margin-top:var(--s-8)">
        <a class="card card--accent" href="/servicios/auditoria-de-seguridad" data-reveal="0">
          <h3>Si no pasó nada todavía</h3>
          <p>Empezá por saber cómo estás parado. Un diagnóstico ordenado vale más que comprar herramientas sueltas por recomendación.</p>
          <span>Auditoría de seguridad →</span>
        </a>
        <a class="card card--accent" href="/servicios/cumplimiento" data-reveal="1">
          <h3>Si un cliente te está pidiendo algo</h3>
          <p>Necesitás demostrar controles en un formato específico y con fecha límite. Es un trabajo distinto al diagnóstico.</p>
          <span>Cumplimiento →</span>
        </a>
        <a class="card card--accent" href="/servicios/respuesta-a-incidentes" data-reveal="2">
          <h3>Si ya pasó algo</h3>
          <p>No leas más: escribinos o llamanos.</p>
          <span>Respuesta a incidentes →</span>
        </a>
      </div>
    </div>
  </section>

  <section>
    <div class="wrap">
      <h2>Cuatro cosas que sirven casi siempre.</h2>
      <p>Ninguna es cara. Ninguna es glamorosa. Juntas eliminan la mayoría de los incidentes que vemos en empresas de este tamaño.</p>
      <div class="p5-rail" style="--rail-count:4;margin-top:var(--s-12)">
        <div class="p5-step"><span class="step-num">01</span><h3>Segundo factor en el correo y en los sistemas críticos</h3><p>La medida individual con mejor relación entre esfuerzo y resultado que existe.</p></div>
        <div class="p5-step"><span class="step-num">02</span><h3>Copias de seguridad que se restauran de verdad</h3><p>Probadas, no supuestas, y donde el ransomware no llegue desde la red.</p></div>
        <div class="p5-step"><span class="step-num">03</span><h3>Un procedimiento escrito para verificar cambios de cuenta bancaria</h3><p>Una carilla firmada por la dirección. Corta el fraude más caro del rubro.</p></div>
        <div class="p5-step"><span class="step-num">04</span><h3>Quitar accesos cuando alguien se va</h3><p>Sencillo de decir, casi nunca hecho de forma completa.</p></div>
      </div>
    </div>
  </section>

  <section class="bleed p9 grain">
    <div class="wrap">
      <p class="statement">No hace falta hacer todo. Hace falta saber qué hacer primero.</p>
      <a class="btn btn--primary" href="/contacto#agendar" data-ev="schedule_click" data-ev-loc="cta_final">Agendá una llamada</a>
    </div>
  </section>

  <section style="padding-top:0">
    <div class="wrap">
      <p><strong>¿Cuál se parece más a tu empresa?</strong> <a href="/para/clinicas">Clínicas</a> · <a href="/para/contadores">Estudios contables</a> · <a href="/para/ecommerce">Tiendas online</a></p>
    </div>
  </section>

  <?php service_closing_cta('pymes', 'para/pymes'); ?>

</main>
<?php
layout_close(['mode' => 'b', 'wa_slug' => 'pymes']);
