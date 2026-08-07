<?php
declare(strict_types=1);

/**
 * /nosotros — BUILD-SPEC-PAGES.md §11.
 * ⚠️ Ships in the unnamed form — complete and honest as written. No
 * [COMPLETAR], no empty team grid, no generated portrait. §11.1's named-
 * practitioner block is NOT built here: it requires a real name and a real
 * photograph, neither of which exist yet (BUILD-SPEC.md §12 item 4).
 */

require_once dirname(__DIR__) . '/src/render.php';

layout_open([
    'title'       => 'Quiénes somos | Ciberseguridad.com.py',
    'description' => 'Cómo trabajamos, qué no hacemos y por qué no publicamos nombres de clientes. Consultoría de seguridad informática para empresas en Paraguay.',
    'path'        => '/nosotros',
    'mode'        => 'b',
    'wa_slug'     => 'nosotros',
    'jsonld'      => [breadcrumb_jsonld([['Inicio', '/'], ['Nosotros', '']])],
]);
?>
<main id="main">

  <section class="hero">
    <div class="wrap">
      <span class="eyebrow">QUIÉNES SOMOS</span>
      <h1>Una consultora de seguridad, no una agencia de marketing.</h1>
      <p>Trabajamos con empresas paraguayas de entre quince y doscientas cincuenta personas que guardan datos que le importan a alguien más, y que tienen soporte informático pero no una función de seguridad.</p>
    </div>
  </section>

  <section>
    <div class="wrap p4">
      <div class="p4-heading">
        <span class="eyebrow">CÓMO TRABAJAMOS</span>
        <h2>Sin miedo como argumento de venta.</h2>
      </div>
      <div class="p4-body">
        <p>En este rubro es fácil vender asustando, y es la forma más rápida de que un cliente compre algo que no necesita. No usamos estadísticas sin fuente, no hablamos de empresas que cierran a los seis meses, y no prometemos seguridad: nadie puede.</p>
        <p>Lo que sí prometemos es concreto: alcance cerrado, precio fijo por escrito, un informe que se entiende, y decirte cuando algo no hace falta. Varias veces la primera llamada termina con «esto no lo necesitás todavía», y esa llamada es tan útil como la que termina en una propuesta.</p>
      </div>
    </div>
  </section>

  <section>
    <div class="wrap">
      <span class="eyebrow">LO QUE NO HACEMOS</span>
      <h2>Tres límites que no cruzamos.</h2>
      <div class="p3-grid" data-count="3" style="margin-top:var(--s-8)">
        <div class="card card--accent span-2" data-reveal="0">
          <h3>No hacemos servicios ofensivos</h3>
          <p>Nada de desarrollo de herramientas de ataque, ni acceso a sistemas de terceros, ni recuperación de cuentas ajenas, ni «investigación» sobre personas. Si nos lo pedís, la respuesta es no y ahí termina la conversación.</p>
        </div>
        <div class="card card--accent" data-reveal="1">
          <h3>No escaneamos sin autorización</h3>
          <p>Ninguna prueba se ejecuta sin autorización escrita del dueño del sistema. Si el sistema es de un proveedor, también necesitamos la suya. En Paraguay eso es delito bajo la Ley 4439/2011.</p>
        </div>
        <div class="card card--accent" data-reveal="2">
          <h3>No publicamos nombres de clientes</h3>
          <p>Quién contrató seguridad y cuándo es información sensible, y publicarla es contradecir el servicio. Por eso no vas a ver logos acá. Si necesitás referencias, las coordinamos con permiso previo.</p>
        </div>
      </div>
    </div>
  </section>

  <section>
    <div class="wrap p4">
      <div class="p4-heading">
        <span class="eyebrow">CONFIDENCIALIDAD</span>
        <h2>Qué pasa con lo que vemos.</h2>
      </div>
      <div class="p4-body">
        <p>En un trabajo de seguridad vemos cómo funciona la empresa por dentro, y a veces vemos cosas incómodas. Firmamos acuerdo de confidencialidad antes de empezar, siempre, incluso cuando el cliente no lo pide.</p>
        <p>Los informes se entregan cifrados y por un canal acordado, no por correo común. Los datos del trabajo se eliminan al cierre según lo que hayamos acordado por escrito, y la única copia que conservamos es la mínima que necesitamos para responder consultas durante el período de acompañamiento.</p>
      </div>
    </div>
  </section>

  <section class="bleed p9 grain">
    <div class="wrap">
      <p class="statement">Preferimos una conversación honesta antes que un contrato rápido.</p>
      <a class="btn btn--primary" href="/contacto#agendar" data-ev="schedule_click" data-ev-loc="cta_final">Agendá una llamada</a>
    </div>
  </section>

  <?php service_closing_cta('nosotros', 'nosotros'); ?>

</main>
<?php
layout_close(['mode' => 'b', 'wa_slug' => 'nosotros']);
