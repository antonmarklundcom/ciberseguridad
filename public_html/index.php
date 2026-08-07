<?php
declare(strict_types=1);

/**
 * Home page — BUILD-SPEC.md §8.
 *
 * Section 09 (Postura técnica verificable) is omitted: it is launch-gated on
 * real SSL Labs / securityheaders.com grades (BUILD-SPEC.md §12 item 8), which
 * are not in hand yet. Per the spec, "if the grades are not in hand at launch,
 * the section is removed — not softened." Sections 10 (statement) and 11 (FAQ)
 * are renumbered down by one position but keep their content unchanged; P9
 * still sits between the two P4 sections (08 and FAQ), so the "no 2 consecutive
 * sections share a pattern" constraint still holds without section 09.
 */

require_once dirname(__DIR__) . '/src/render.php';

$faqs = [
    ['¿Trabajan solo en Asunción?', 'Trabajamos con empresas de todo el país. La mayor parte del trabajo es remoto; en Gran Asunción también vamos presencialmente cuando el trabajo lo requiere, y fuera del Gran Asunción lo coordinamos según el caso.'],
    ['¿Cuánto cuesta una auditoría?', 'Depende del tamaño de la empresa y del alcance, y por eso lo cotizamos después de una conversación de 30 minutos. Lo que sí te garantizamos es que vas a recibir un precio fijo por escrito antes de que empecemos, no una factura por hora al final.'],
    ['¿Hacen el trabajo ustedes o lo tercerizan?', 'Lo hacemos nosotros. Si en algún punto necesitamos a un tercero, te lo decimos antes y figura en la propuesta con nombre y alcance.'],
    ['Nuestro proveedor de IT dice que ya estamos seguros. ¿Para qué los necesitamos?', 'Porque nadie audita bien su propio trabajo, y no es un problema de honestidad sino de perspectiva. Tu proveedor de IT mantiene los sistemas funcionando; nosotros miramos lo mismo desde afuera y con otra pregunta en la cabeza. Los hallazgos se los entregamos a ellos para que los corrijan.'],
    ['¿Publican los nombres de sus clientes?', 'No, y no lo vamos a hacer con el tuyo tampoco. En seguridad, quién contrató a quién es información sensible. Si necesitás referencias, las coordinamos directamente y con permiso previo de la otra empresa.'],
];

$faqJsonLd = [
    '@context' => 'https://schema.org', '@type' => 'FAQPage',
    'mainEntity' => array_map(static fn ($f) => [
        '@type' => 'Question', 'name' => $f[0],
        'acceptedAnswer' => ['@type' => 'Answer', 'text' => $f[1]],
    ], $faqs),
];

$orgJsonLd = [
    '@context' => 'https://schema.org', '@type' => 'ProfessionalService',
    'name' => 'Ciberseguridad.com.py',
    'url' => 'https://ciberseguridad.com.py',
    'telephone' => '+595995628862',
    'address' => ['@type' => 'PostalAddress', 'addressLocality' => 'Asunción', 'addressRegion' => 'Central', 'addressCountry' => 'PY'],
    'areaServed' => [['@type' => 'Country', 'name' => 'Paraguay']],
    'knowsAbout' => ['auditoría de seguridad informática', 'pentesting', 'respuesta a incidentes', 'cumplimiento normativo', 'capacitación en ciberseguridad'],
];

layout_open([
    'title'       => 'Ciberseguridad para empresas en Paraguay | Auditoría, pentesting y respuesta a incidentes',
    'description' => 'Auditorías de seguridad, pentesting, respuesta a incidentes, cumplimiento y capacitación para empresas paraguayas. Alcance y precio fijo por escrito. Escribinos.',
    'path'        => '/',
    'mode'        => 'b',
    'wa_slug'     => 'inicio',
    'jsonld'      => [$orgJsonLd, $faqJsonLd],
]);
?>
<main id="main">

  <!-- 02 — Hero · P1 asymmetric split 7/5 -->
  <section class="hero">
    <div class="wrap p1">
      <div>
        <span class="eyebrow">ASUNCIÓN · PARAGUAY</span>
        <h1>Ciberseguridad para empresas paraguayas que ya no pueden improvisar.</h1>
        <p>Auditorías, pentesting, respuesta a incidentes, cumplimiento y capacitación para empresas que manejan datos que le importan a alguien más: pacientes, clientes, socios, medios de pago.</p>
        <p>Trabajamos con alcance y precio fijo por escrito. Sin abono por hora abierto, sin promesas de seguridad absoluta.</p>
        <div class="btn-row">
          <a class="btn btn--primary" href="/contacto#agendar" data-ev="schedule_click" data-ev-loc="hero">Agendá una llamada</a>
          <a class="btn btn--wa" href="<?= htmlspecialchars(wa_url('inicio')) ?>" data-ev="whatsapp_click" data-ev-loc="hero"><?= wa_glyph() ?> Escribinos por WhatsApp</a>
        </div>
        <small>Primera conversación de 30 minutos, sin costo y sin compromiso.</small>
      </div>
      <div class="p1-visual">
        <div class="hero-visual" style="aspect-ratio:16/10">
          <?= picture_tag('empresa-de-ciberseguridad-asuncion-paraguay', 'Dos profesionales revisando documentación de seguridad informática en una oficina de Asunción', '1280', '800', true) ?>
        </div>
      </div>
    </div>
  </section>

  <!-- 03 — Router de situación · P3 staggered-weight grid -->
  <section>
    <div class="wrap">
      <span class="eyebrow">¿POR DÓNDE EMPEZAR?</span>
      <h2>Decinos en qué situación estás.</h2>
      <p>Cada una necesita algo distinto. Elegí la que más se parece a la tuya.</p>
      <div class="p3-grid" data-count="4" style="margin-top:var(--s-8)">
        <a class="card card--accent span-2" href="/servicios/respuesta-a-incidentes" data-reveal="0">
          <h3>«Nos atacaron.»</h3>
          <p>Ransomware, una cuenta tomada, plata que se fue a la cuenta equivocada. Necesitás contener el daño hoy, no la semana que viene.</p>
          <span>Respuesta a incidentes →</span>
        </a>
        <a class="card card--accent" href="/servicios/cumplimiento" data-reveal="1">
          <h3>«Un cliente nos pidió un cuestionario de seguridad.»</h3>
          <p>Te llegó una planilla con doscientas preguntas y una fecha límite, y nadie en la empresa sabe por dónde empezar.</p>
          <span>Cumplimiento →</span>
        </a>
        <a class="card card--accent" href="/servicios/auditoria-de-seguridad" data-reveal="2">
          <h3>«Queremos saber cómo estamos parados.»</h3>
          <p>Nunca nadie revisó la seguridad de la empresa desde afuera y ya es momento de tener un diagnóstico honesto.</p>
          <span>Auditoría de seguridad →</span>
        </a>
        <a class="card card--accent" href="/servicios/pentesting" data-reveal="3">
          <h3>«Queremos que alguien intente entrar antes que otro.»</h3>
          <p>Tenés un sistema, una app o una red y querés saber qué pasa cuando alguien la ataca en serio, con autorización y por escrito.</p>
          <span>Pentesting →</span>
        </a>
      </div>
    </div>
  </section>

  <!-- 04 — Franja de confianza · P8 full-bleed ribbon -->
  <section class="bleed p8 grain">
    <div class="wrap">
      <span>Alcance y precio fijo por escrito</span><span class="divider">·</span>
      <span>Informe con hallazgos priorizados y plan de remediación</span><span class="divider">·</span>
      <span>Sin servicios ofensivos ni escaneos sin autorización</span><span class="divider">·</span>
      <span>Este sitio publica su propia configuración de seguridad</span>
    </div>
  </section>

  <!-- 05 — Servicios · P7 sticky-side scroll -->
  <section>
    <div class="wrap p7">
      <div class="p7-sticky">
        <span class="eyebrow">SERVICIOS</span>
        <h2>Cinco cosas, hechas bien.</h2>
        <p>No hacemos todo. Hacemos esto, con alcance cerrado y un entregable que podés mostrarle a tu directorio o a tu proveedor de IT.</p>
      </div>
      <div class="p7-items">
        <div class="card card--ink" data-reveal="0">
          <div style="border-radius:var(--r-md);overflow:hidden;margin-bottom:var(--s-4)">
            <?= picture_tag('auditoria-de-seguridad-informatica', 'Informe de auditoría de seguridad informática con anotaciones sobre un escritorio', '560', '420', false, [640, 1280]) ?>
          </div>
          <h3>Auditoría de seguridad</h3>
          <p>Revisamos cómo está parada tu empresa: identidades y accesos, equipos, copias de seguridad y sus pruebas de restauración, seguridad del correo y exposición a fraude de facturas, segmentación de la red, proveedores con acceso y preparación ante incidentes.</p>
          <p>Recibís un informe con los hallazgos priorizados por riesgo real y un plan de remediación que tu proveedor de IT puede ejecutar.</p>
          <a href="/servicios/auditoria-de-seguridad">Ver auditoría de seguridad →</a>
        </div>
        <div class="card card--hair" data-reveal="1">
          <div style="border-radius:var(--r-md);overflow:hidden;margin-bottom:var(--s-4)">
            <?= picture_tag('pentesting-pruebas-de-penetracion', 'Especialista realizando pruebas de penetración sobre una aplicación en una oficina', '560', '420', false, [640, 1280]) ?>
          </div>
          <h3>Pentesting</h3>
          <p>Pruebas de penetración sobre tu aplicación, tu sitio o tu red interna, siempre con autorización escrita y alcance definido de antemano. Te entregamos cada hallazgo con su prueba de concepto, su impacto explicado en términos de negocio y cómo corregirlo. Después reprobamos las correcciones sin costo adicional.</p>
          <a href="/servicios/pentesting">Ver pentesting →</a>
        </div>
        <div class="card card--hair" data-reveal="2">
          <h3>Respuesta a incidentes</h3>
          <p>Si ya pasó, lo primero es contener. Trabajamos con vos desde el primer llamado: contención, análisis de qué entró y por dónde, recuperación ordenada y un informe de cierre que sirve para el seguro, para el cliente que pregunta y para que no vuelva a pasar.</p>
          <a href="/servicios/respuesta-a-incidentes">Ver respuesta a incidentes →</a>
        </div>
        <div class="card card--hair" data-reveal="3">
          <div style="border-radius:var(--r-md);overflow:hidden;margin-bottom:var(--s-4)">
            <?= picture_tag('cumplimiento-y-cuestionarios-de-seguridad', 'Reunión de trabajo revisando requisitos de cumplimiento de seguridad', '560', '420', false, [640, 1280]) ?>
          </div>
          <h3>Cumplimiento</h3>
          <p>Cuestionarios de seguridad de clientes y bancos, análisis de brechas contra el marco que te están pidiendo, y la carpeta de evidencias que respalda cada respuesta. También acompañamiento para la Ley 6534/2020 de protección de datos personales.</p>
          <a href="/servicios/cumplimiento">Ver cumplimiento →</a>
        </div>
        <div class="card card--hair" data-reveal="4">
          <div style="border-radius:var(--r-md);overflow:hidden;margin-bottom:var(--s-4)">
            <?= picture_tag('capacitacion-en-ciberseguridad-para-empresas', 'Capacitación en ciberseguridad para el personal de una empresa paraguaya', '560', '420', false, [640, 1280]) ?>
          </div>
          <h3>Capacitación</h3>
          <p>Formación para el equipo que realmente toca los datos: cómo reconocer un pedido de cambio de cuenta bancaria, qué hacer con un correo raro, cómo proteger las cuentas de la empresa. Presencial en Gran Asunción o remoto.</p>
          <a href="/servicios/capacitacion">Ver capacitación →</a>
        </div>
      </div>
    </div>
  </section>

  <!-- 06 — Respuesta a incidentes · P6 bleed-image overlap -->
  <section class="p6">
    <div class="bleed scrim grain p6-band">
      <?= picture_tag('respuesta-a-incidentes-de-seguridad-paraguay', 'Técnico atendiendo un incidente de seguridad en una sala de servidores', '1920', '822', false, [640, 1280]) ?>
      <div class="wrap" style="position:absolute;inset:0;display:flex;flex-direction:column;justify-content:center">
        <span class="eyebrow" style="color:#fff">URGENCIAS</span>
        <h2 style="color:#fff">¿Ya está pasando?</h2>
        <p style="color:#fff;opacity:.85">Si tenés un incidente en curso, no completes un formulario. Escribinos o llamanos ahora.</p>
      </div>
    </div>
    <div class="wrap">
      <div class="card card--raised p6-overlap" style="max-width:640px">
        <p><strong>Si sospechás que tu correo o tu teléfono están comprometidos, llamanos desde otro dispositivo.</strong></p>
        <div class="btn-row">
          <a class="btn btn--primary" href="<?= htmlspecialchars(wa_url('incidente', 'necesitamos ayuda urgente')) ?>" data-ev="whatsapp_click" data-ev-loc="incidente"><?= wa_glyph() ?> Escribinos por WhatsApp</a>
          <a class="btn btn--ghost" href="<?= htmlspecialchars(tel_href()) ?>" data-ev="call_click" data-ev-loc="incidente">+595 995 628862</a>
        </div>
        <small>⚠️ Atendemos incidentes las 24 horas, todos los días.</small>
      </div>
    </div>
  </section>

  <!-- 07 — Cómo trabajamos · P5 numbered process rail -->
  <section style="padding-top:calc(var(--s-16) + 40px)">
    <div class="wrap">
      <span class="eyebrow">CÓMO TRABAJAMOS</span>
      <h2>Sin sorpresas en la factura.</h2>
      <div class="p5-rail" style="--rail-count:3;margin-top:var(--s-12)">
        <div class="p5-step">
          <span class="step-num">01</span>
          <h3>Conversación inicial — 30 minutos, sin costo</h3>
          <p>Nos contás la situación. Te decimos con franqueza si somos las personas indicadas para resolverla y, si no lo somos, te lo decimos igual.</p>
        </div>
        <div class="p5-step">
          <span class="step-num">02</span>
          <h3>Propuesta con alcance y precio fijo — 2 a 3 días hábiles</h3>
          <p>Qué se hace, qué no se hace, qué recibís y cuánto cuesta. Por escrito, antes de empezar. No facturamos por hora abierta.</p>
        </div>
        <div class="p5-step">
          <span class="step-num">03</span>
          <h3>Ejecución y entrega</h3>
          <p>Hacemos el trabajo y entregamos un informe con los hallazgos priorizados por riesgo y un plan de remediación concreto, escrito para que tu proveedor de IT lo pueda ejecutar sin traducción.</p>
        </div>
      </div>
    </div>
  </section>

  <!-- 08 — Para tu rubro · P4 editorial two-column -->
  <section>
    <div class="wrap p4">
      <div class="p4-heading">
        <span class="eyebrow">PARA TU RUBRO</span>
        <h2>El riesgo no es igual en todos lados.</h2>
      </div>
      <ul class="hairline-list p4-body">
        <li><a href="/para/clinicas"><strong>Clínicas y consultorios →</strong></a> Historias clínicas, agenda y facturación en la misma red que el equipamiento de imágenes. Cuando se cae, no se cae un sistema: se cae la atención.</li>
        <li><a href="/para/contadores"><strong>Estudios contables →</strong></a> Concentrás los datos financieros de decenas de clientes en una sola oficina, y la credencial del portal de la SET es un único punto de falla.</li>
        <li><a href="/para/ecommerce"><strong>Tiendas online →</strong></a> El checkout, el panel de administración y los datos de tus clientes. Un skimmer inyectado en el pago no se ve y factura durante meses.</li>
        <li><a href="/para/pymes"><strong>PYMES →</strong></a> Tenés soporte de IT pero no tenés función de seguridad, y nadie te dijo nunca cuál es la diferencia.</li>
      </ul>
    </div>
  </section>

  <!-- 10 — Statement CTA · P9 oversized statement -->
  <section class="bleed p9 grain">
    <div class="wrap">
      <p class="statement">Media hora ahora cuesta menos que un lunes entero apagando incendios.</p>
      <p>Contanos qué te preocupa. Si no somos los indicados, te lo decimos en la primera llamada.</p>
      <a class="btn btn--primary" href="/contacto#agendar" data-ev="schedule_click" data-ev-loc="cta_final">Agendá una llamada</a>
    </div>
  </section>

  <!-- 11 — Preguntas frecuentes · P4 editorial two-column -->
  <section>
    <div class="wrap p4">
      <div class="p4-heading">
        <span class="eyebrow">PREGUNTAS FRECUENTES</span>
        <h2>Antes de escribirnos.</h2>
      </div>
      <div class="faq-list p4-body">
<?php foreach ($faqs as $f): ?>
        <details>
          <summary><?= htmlspecialchars($f[0]) ?></summary>
          <p><?= htmlspecialchars($f[1]) ?></p>
        </details>
<?php endforeach; ?>
      </div>
    </div>
  </section>

  <!-- 12 — Contacto · P1 mirrored 5/7 -->
  <section id="contacto">
    <div class="wrap p1 p1--mirrored">
      <div>
        <span class="eyebrow">CONTACTO</span>
        <h2>Escribinos.</h2>
        <p><strong>Por WhatsApp</strong> — la vía más rápida. +595 995 628862</p>
        <a class="btn btn--wa" href="<?= htmlspecialchars(wa_url('inicio')) ?>" data-ev="whatsapp_click" data-ev-loc="contacto"><?= wa_glyph() ?> Escribinos por WhatsApp</a>
        <p style="margin-top:var(--s-6)"><strong>Por teléfono</strong> — <a href="<?= htmlspecialchars(tel_href()) ?>">+595 995 628862</a></p>
        <p><strong>Por correo</strong> — <a href="mailto:contacto@ciberseguridad.com.py">contacto@ciberseguridad.com.py</a></p>
        <p><strong>Agendá una llamada</strong> — media hora, sin costo, para entender tu situación.</p>
        <small>Si tenés un incidente en curso, no uses el formulario: escribinos o llamanos ahora.</small>
      </div>
      <div>
        <p>Contanos brevemente y te respondemos en el día hábil.</p>
        <?php
        $form_type = 'contacto';
        $page      = 'home';
        $errors    = [];
        $old       = [];
        require dirname(__DIR__) . '/src/partials/lead-form.php';
        ?>
      </div>
    </div>
  </section>

</main>
<?php
layout_close(['mode' => 'b', 'wa_slug' => 'inicio']);
