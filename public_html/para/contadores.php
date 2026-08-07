<?php
declare(strict_types=1);

/** /para/contadores — BUILD-SPEC-PAGES.md §7. */

require_once dirname(__DIR__, 2) . '/src/render.php';

layout_open([
    'title'       => 'Seguridad informática para estudios contables | Paraguay',
    'description' => 'Concentrás los datos financieros de decenas de clientes. Protección de accesos, credenciales de la SET, correo y respaldo para estudios contables en Paraguay.',
    'path'        => '/para/contadores',
    'mode'        => 'b',
    'wa_slug'     => 'contadores',
    'jsonld'      => [breadcrumb_jsonld([['Inicio', '/'], ['Para tu rubro', ''], ['Estudios contables', '']])],
]);
?>
<main id="main">

  <section class="hero">
    <div class="wrap">
      <span class="eyebrow">PARA ESTUDIOS CONTABLES</span>
      <h1>Seguridad informática para estudios contables.</h1>
      <p>Guardás en una sola oficina los datos financieros de decenas de empresas. Para un atacante, eso no es un estudio contable: es el atajo a todos tus clientes al mismo tiempo.</p>
      <div class="btn-row">
        <a class="btn btn--primary" href="/contacto#agendar" data-ev="schedule_click" data-ev-loc="hero">Agendá una llamada</a>
        <a class="btn btn--wa" href="<?= htmlspecialchars(wa_url('contadores')) ?>" data-ev="whatsapp_click" data-ev-loc="hero"><?= wa_glyph() ?> Escribinos por WhatsApp</a>
      </div>
    </div>
  </section>

  <section>
    <div class="wrap p2">
      <h2>Sos un objetivo concentrado, y por eso valés más.</h2>
      <p>Atacar a cincuenta empresas cuesta cincuenta veces más que atacar a quien tiene acceso a las cincuenta. Los estudios contables son, por diseño, ese punto de concentración.</p>
      <p>Se suma la estacionalidad: en época de cierres y vencimientos llega mucho correo con adjuntos, de remitentes que cambian, con urgencia real, y a nadie le sobra tiempo para dudar de un archivo. Es la ventana perfecta y los atacantes la conocen igual que vos.</p>
    </div>
  </section>

  <section>
    <div class="wrap p4">
      <div class="p4-heading">
        <span class="eyebrow">QUÉ ESTÁ EN JUEGO</span>
        <h2>Lo que se pone en riesgo.</h2>
      </div>
      <ul class="hairline-list p4-body">
        <li><strong>La credencial del portal de la SET</strong> — Un único punto de falla con consecuencias inmediatas y visibles para tus clientes. Merece segundo factor y merece no estar anotada en un archivo compartido.</li>
        <li><strong>Los datos financieros de tus clientes</strong> — Facturación, nómina, saldos, estructura societaria. Información que sirve tanto para el fraude directo como para preparar un engaño creíble contra tu cliente.</li>
        <li><strong>Tu responsabilidad profesional</strong> — Si los datos de un cliente se filtran desde tu estudio, el problema no es técnico. Es de tu relación con ese cliente y de tu reputación en un mercado donde todos se conocen.</li>
        <li><strong>La continuidad en fecha de vencimiento</strong> — Un incidente en la semana equivocada no es un inconveniente: es un incumplimiento en cadena.</li>
      </ul>
    </div>
  </section>

  <section>
    <div class="wrap">
      <span class="eyebrow">QUÉ HACEMOS EN UN ESTUDIO</span>
      <h2>Tres prioridades concretas.</h2>
      <div class="p3-grid" data-count="3" style="margin-top:var(--s-8)">
        <div class="card card--accent span-2" data-reveal="0">
          <h3>Ordenar credenciales y accesos</h3>
          <p>Gestor de contraseñas, segundo factor en todo lo que lo permita, y el fin de la credencial compartida por WhatsApp. Es poco glamoroso y es lo que más reduce el riesgo real en este rubro.</p>
        </div>
        <div class="card card--accent" data-reveal="1">
          <h3>Endurecer el correo</h3>
          <p>SPF, DKIM y DMARC bien configurados para que no sea trivial hacerse pasar por tu dominio ante tus propios clientes.</p>
        </div>
        <div class="card card--accent" data-reveal="2">
          <h3>Respaldo probado y separado</h3>
          <p>Copias que un ransomware no pueda alcanzar desde la red, con una restauración probada de verdad y no supuesta.</p>
        </div>
      </div>
    </div>
  </section>

  <section class="bleed p9 grain">
    <div class="wrap">
      <p class="statement">Tus clientes te confiaron sus números. Esa confianza es el producto.</p>
      <a class="btn btn--primary" href="/contacto#agendar" data-ev="schedule_click" data-ev-loc="cta_final">Agendá una llamada</a>
    </div>
  </section>

  <section style="padding-top:0">
    <div class="wrap">
      <p><strong>Servicios relacionados para estudios contables:</strong> <a href="/servicios/auditoria-de-seguridad">auditoría de seguridad</a> y <a href="/servicios/cumplimiento">cumplimiento</a>.</p>
    </div>
  </section>

  <?php service_closing_cta('contadores', 'para/contadores'); ?>

</main>
<?php
layout_close(['mode' => 'b', 'wa_slug' => 'contadores']);
