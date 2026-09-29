<?php
declare(strict_types=1);
require dirname(__DIR__, 2) . '/src/render.php';

$faqs = [
    ['¿Esto interrumpe la operación?', 'No. El trabajo es de observación y revisión: entrevistas, revisión de configuraciones y de documentos. Coordinamos los horarios para no frenar a nadie.'],
    ['¿Necesitan acceso a nuestros sistemas?', 'Necesitamos ver configuraciones, y para eso alguien de tu equipo o de tu proveedor nos las muestra o nos da acceso de solo lectura, siempre con tu autorización escrita. No hace falta que nos entregues contraseñas de administrador, y no probamos nada que no hayamos acordado antes.'],
    ['¿Y si ya tenemos un proveedor de IT?', 'Mejor. No lo reemplazamos: el informe está escrito para que él pueda ejecutar el plan. Muchas veces el diagnóstico le da el respaldo que necesitaba para pedir presupuesto.'],
    ['¿Cuánto demora?', 'Depende del tamaño y de qué tan rápido nos consigan la información. Lo definimos en la propuesta escrita, con fechas de entrega, antes de empezar.'],
    ['¿Firman acuerdo de confidencialidad?', 'Sí, y es lo habitual. Lo firmamos antes de ver cualquier dato de tu empresa.'],
];

page_start('servicios/diagnostico');
echo breadcrumbs('servicios/diagnostico');
?>
<section class="hero">
  <div class="wrap">
    <p class="eyebrow">Servicio · Diagnóstico</p>
    <h1>Auditoría de seguridad informática para tu empresa</h1>
    <p class="lead">Revisamos siete áreas clave y te entregamos un informe que un director puede leer y que tu proveedor de IT puede ejecutar. Alcance y precio fijo, por escrito.</p>
    <div class="btn-row"><?= cta_button('Pedí tu diagnóstico por WhatsApp') ?></div>
  </div>
</section>

<section class="section section--alt reveal">
  <div class="wrap narrow prose">
    <h2>La situación</h2>
    <p>Tenés un proveedor de IT que dice que está todo bien. Tenés antivirus. Y aun así no estás tranquilo, porque no podés evaluar la respuesta que te dan: nadie te mostró qué se revisó ni qué quedó afuera.</p>
    <p>Esa incomodidad es la razón por la que estás leyendo esto, y es razonable. Un diagnóstico independiente no discute con tu proveedor: te da un cuadro comprobable de dónde está cada cosa.</p>
  </div>
</section>

<section class="section reveal" id="revisamos">
  <div class="wrap narrow prose">
    <h2>¿Qué revisamos en un diagnóstico de seguridad?</h2>
    <p>Nombramos las áreas de forma concreta, porque la vaguedad en este rubro suele esconder que no se sabe qué mirar.</p>
    <ul class="checks">
      <li><strong>Identidad y accesos.</strong> Quién llega a qué, cobertura del segundo factor, cuentas dormidas, credenciales compartidas y qué pasa cuando alguien se va de la empresa.</li>
      <li><strong>Correo y fraude.</strong> Autenticación del correo (SPF, DKIM, DMARC), exposición a suplantación y el proceso que seguís cuando un proveedor pide cambiar su cuenta bancaria.</li>
      <li><strong>Copias de seguridad.</strong> Si existen, si están aisladas, si se pueden borrar desde la misma red y, sobre todo, si alguna vez se probó restaurarlas.</li>
      <li><strong>Puestos de trabajo.</strong> Actualizaciones, cifrado de discos, protección de los equipos y quién tiene permisos de administrador.</li>
      <li><strong>Red y segmentación.</strong> Redes planas, servicios expuestos a internet y accesos remotos.</li>
      <li><strong>Terceros.</strong> Qué proveedores tienen acceso a tus sistemas y qué pasaría si uno de ellos sufre una intrusión.</li>
      <li><strong>Preparación.</strong> Si hay un plan escrito y una lista de a quién llamar, y si alguien más que vos sabe dónde está.</li>
    </ul>
    <p>El diagnóstico es una revisión de lo que hay y de cómo se gestiona. No es una prueba de intrusión y no demuestra que no exista un problema que no encontramos: describe lo que se observó en el alcance acordado.</p>
  </div>
</section>

<section class="section section--alt reveal">
  <div class="wrap narrow prose">
    <h2>¿Qué recibís?</h2>
    <ul class="checks">
      <li>Un resumen ejecutivo que un director sin formación técnica puede leer en diez minutos.</li>
      <li>Una lista de hallazgos priorizados, con la gravedad y el esfuerzo estimado de cada uno.</li>
      <li>Un plan de remediación que tu proveedor de IT puede ejecutar paso a paso.</li>
      <li>Una llamada de 30 minutos para recorrer el informe con vos. Nadie debería recibir un PDF y quedarse solo con él.</li>
    </ul>
    <?php if (is_file(PUBLIC_DIR . '/assets/docs/ejemplo-informe-diagnostico.pdf')): ?>
    <div class="callout">
      <p><a href="/assets/docs/ejemplo-informe-diagnostico.pdf"><strong>Ver un ejemplo de informe (PDF)</strong></a>. Es un ejemplo con identificadores removidos, no el informe de una empresa real que podés identificar.</p>
    </div>
    <?php endif; /* TODO(content): drop the redacted sample at public_html/assets/docs/ejemplo-informe-diagnostico.pdf (Phase 0). The block appears automatically. */ ?>
  </div>
</section>

<section class="section reveal">
  <div class="wrap narrow prose">
    <h2>Cómo trabajamos</h2>
    <?= process_steps('Revisión y entrega del informe') ?>
    <h2>¿Cuánto cuesta?</h2>
    <?= price_block('diagnostico', 'Precio fijo por escrito, según el tamaño de la empresa y el alcance acordado. Lo ves antes de decidir y no cambia durante el trabajo. La conversación inicial no tiene costo.') ?>
    <p>Después del informe, el paso natural es ejecutar el plan con tu proveedor. Si querés que alguien verifique el avance mes a mes, existe la <a href="/servicios/seguridad-gestionada">seguridad gestionada</a>. Y si ya pasó algo grave, andá directo a <a href="/servicios/respuesta-a-incidentes">respuesta a incidentes</a>.</p>
    <p>Si un cliente te pidió evidencia de tus controles, este diagnóstico es también la base de un <a href="/servicios/cuestionarios-de-proveedores">cuestionario de proveedores</a> bien respondido.</p>
    <div class="btn-row"><?= cta_button('Pedí tu diagnóstico por WhatsApp') ?></div>
  </div>
</section>

<?= faq_html($faqs) ?>
<?= cta_final('Empecemos por una conversación', 'Contanos cómo trabajás hoy. En 30 minutos vemos si el diagnóstico es lo que necesitás.') ?>
<?php
page_end([
    'schema' => [service_ld('servicios/diagnostico', 'Diagnóstico de seguridad informática', 'Revisión de siete áreas de seguridad de una empresa, con informe priorizado y plan de remediación.')],
    'faqs' => $faqs,
    'service' => 'diagnostico',
]);
