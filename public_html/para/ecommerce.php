<?php
declare(strict_types=1);

/** /para/ecommerce — BUILD-SPEC-PAGES.md §8. */

require_once dirname(__DIR__, 2) . '/src/render.php';

layout_open([
    'title'       => 'Seguridad para tiendas online y ecommerce | Paraguay',
    'description' => 'Checkout, panel de administración y datos de clientes. Pentesting, auditoría y respuesta a incidentes para tiendas online paraguayas.',
    'path'        => '/para/ecommerce',
    'mode'        => 'b',
    'wa_slug'     => 'ecommerce',
    'jsonld'      => [breadcrumb_jsonld([['Inicio', '/'], ['Para tu rubro', ''], ['Tiendas online', '']])],
]);
?>
<main id="main">

  <section class="hero">
    <div class="wrap">
      <span class="eyebrow">PARA TIENDAS ONLINE</span>
      <h1>Seguridad para tiendas online.</h1>
      <p>Tu tienda tiene que estar abierta y tiene que parecer confiable en el momento exacto en que alguien va a poner los datos de su tarjeta. Las dos cosas se pierden juntas y se recuperan por separado.</p>
      <div class="btn-row">
        <a class="btn btn--primary" href="/contacto#agendar" data-ev="schedule_click" data-ev-loc="hero">Agendá una llamada</a>
        <a class="btn btn--wa" href="<?= htmlspecialchars(wa_url('ecommerce')) ?>" data-ev="whatsapp_click" data-ev-loc="hero"><?= wa_glyph() ?> Escribinos por WhatsApp</a>
      </div>
    </div>
  </section>

  <section>
    <div class="wrap p2">
      <h2>Lo que más duele no se nota.</h2>
      <p>Una tienda caída se ve enseguida y se arregla. Un código malicioso inyectado en la página de pago no se ve: la tienda funciona normal, las ventas entran, y en paralelo los datos de cada tarjeta se copian a un servidor ajeno.</p>
      <p>Ese tipo de ataque suele descubrirse meses después, y casi nunca lo descubre el dueño de la tienda: lo descubre el banco o la procesadora, llamando. Para ese momento el problema ya no es técnico, es contractual.</p>
    </div>
  </section>

  <section>
    <div class="wrap p4">
      <div class="p4-heading">
        <span class="eyebrow">QUÉ ESTÁ EN JUEGO</span>
        <h2>Lo que se pone en riesgo.</h2>
      </div>
      <ul class="hairline-list p4-body">
        <li><strong>El checkout</strong> — Cada script de terceros que corre en la página de pago (chat, analítica, remarketing) es una vía de entrada más, y suele estar ahí porque alguien lo agregó rápido hace dos años.</li>
        <li><strong>El panel de administración</strong> — Si alguien entra ahí, puede cambiar precios, ver pedidos, exportar clientes o modificar el checkout sin tocar el servidor.</li>
        <li><strong>Los datos de tus clientes</strong> — Nombres, direcciones, teléfonos, historial de compras. Sirven para fraude dirigido contra tus propios compradores, usando tu nombre.</li>
        <li><strong>Tu relación con la procesadora de pagos</strong> — Un incidente de datos de tarjeta pone en riesgo la posibilidad de seguir cobrando, que es la parte que realmente cierra tiendas.</li>
      </ul>
    </div>
  </section>

  <section>
    <div class="wrap">
      <span class="eyebrow">QUÉ HACEMOS EN UNA TIENDA</span>
      <h2>Tres prioridades concretas.</h2>
      <div class="p3-grid" data-count="3" style="margin-top:var(--s-8)">
        <div class="card card--accent span-2" data-reveal="0">
          <h3>Pentesting sobre el checkout y el panel</h3>
          <p>Con autorización escrita y en ambiente coordinado. Control de acceso entre usuarios, manipulación de precios y cantidades, y qué puede hacer un cliente común que no debería poder hacer.</p>
        </div>
        <div class="card card--accent" data-reveal="1">
          <h3>Inventario de scripts de terceros</h3>
          <p>Qué se está cargando en la página de pago, quién lo puso, si sigue haciendo falta. Casi siempre sobra algo, y lo que sobra es riesgo gratis.</p>
        </div>
        <div class="card card--accent" data-reveal="2">
          <h3>Accesos del panel y de los proveedores</h3>
          <p>Segundo factor obligatorio, cuentas nominales en vez de una compartida, y revocación cuando termina la relación con una agencia o un desarrollador.</p>
        </div>
      </div>
    </div>
  </section>

  <section class="bleed p9 grain">
    <div class="wrap">
      <p class="statement">La tienda abierta es la mitad. La otra mitad es que el pago siga siendo confiable.</p>
      <a class="btn btn--primary" href="/contacto#agendar" data-ev="schedule_click" data-ev-loc="cta_final">Agendá una llamada</a>
    </div>
  </section>

  <section style="padding-top:0">
    <div class="wrap">
      <p><strong>Servicios relacionados para tiendas online:</strong> <a href="/servicios/pentesting">pentesting</a> y <a href="/servicios/respuesta-a-incidentes">respuesta a incidentes</a>.</p>
    </div>
  </section>

  <?php service_closing_cta('ecommerce', 'para/ecommerce'); ?>

</main>
<?php
layout_close(['mode' => 'b', 'wa_slug' => 'ecommerce']);
