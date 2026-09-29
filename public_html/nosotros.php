<?php
declare(strict_types=1);
require dirname(__DIR__) . '/src/render.php';

$who = (string) cfg('practitioner');

page_start('nosotros');
echo breadcrumbs('nosotros');
?>
<section class="hero">
  <div class="wrap narrow">
    <p class="eyebrow">Nosotros</p>
    <h1>Quiénes somos y cómo trabajamos</h1>
    <p class="lead">En seguridad informática lo que se compra es criterio. Por eso preferimos explicarte cómo trabajamos, qué no hacemos y cómo se cobra, antes que mostrarte logos.</p>
  </div>
</section>

<?php if ($who !== ''): ?>
<section class="section section--alt">
  <div class="wrap narrow prose">
    <h2>Quién te atiende</h2>
    <p><?= e($who) ?> atiende personalmente cada consulta y se encarga del trabajo.</p>
    <!-- TODO(content): real photo, real background and only the credentials genuinely held (Phase 0). Add here; never invent them. -->
  </div>
</section>
<?php endif; /* TODO(content): PRACTITIONER_NAME is empty, so the "Quién te atiende" section (name, photo, background, credentials) is hidden until Phase 0 supplies real data. */ ?>

<section class="section reveal">
  <div class="wrap narrow prose">
    <h2>Lo que no hacemos</h2>
    <ul class="checks checks--no">
      <li><strong>No accedemos a sistemas sin autorización escrita.</strong> Ni para una prueba, ni «solo para mirar». El acceso no autorizado a sistemas informáticos es un delito en Paraguay, y nuestro trabajo consiste en lo contrario.</li>
      <li><strong>No escaneamos sistemas ajenos.</strong> Tampoco desde este sitio: ninguna herramienta gratuita se conecta a un servidor que vos no hayas probado que es tuyo.</li>
      <li><strong>No vendemos miedo.</strong> Te explicamos el riesgo una vez, con claridad, y usamos el resto del tiempo en lo que se puede hacer.</li>
      <li><strong>No prometemos resultados de seguridad.</strong> Describimos el proceso y los entregables. Nadie puede prometer que no habrá un incidente.</li>
      <li><strong>No ofrecemos servicios ofensivos</strong> contra terceros, bajo ningún pretexto.</li>
    </ul>

    <h2>Cómo se cobra y cómo se define el trabajo</h2>
    <p>Cada trabajo empieza con una conversación sin costo de 30 minutos, sigue con una propuesta escrita con alcance, entregables y precio fijo, y termina con un informe. No hay horas abiertas: si el alcance cambia, se acuerda un cambio por escrito antes de hacerlo.</p>
    <?= process_steps() ?>

    <h2>Confidencialidad, y por qué no hay logos</h2>
    <p>No publicamos los nombres de nuestros clientes. Trabajar con información sensible de una empresa exige discreción, y un listado de nombres sería lo contrario. Por eso este sitio no tiene un muro de logos ni testimonios inventados, y por eso te ofrecemos un acuerdo de confidencialidad desde la primera conversación.</p>
    <p>Lo que sí podemos mostrar es cómo trabajamos: los entregables, el proceso y los plazos están escritos en cada página de servicio. Cuando haya casos que se puedan contar sin identificar a nadie, los vamos a publicar como ejemplos anónimos y aclarando que lo son.</p>
    <p>Las páginas de <a href="/servicios/diagnostico">diagnóstico</a>, <a href="/servicios/respuesta-a-incidentes">respuesta a incidentes</a>, <a href="/servicios/cuestionarios-de-proveedores">cuestionarios de proveedores</a> y <a href="/servicios/seguridad-gestionada">seguridad gestionada</a> detallan cada servicio.</p>
    <div class="btn-row"><?= cta_button('Escribinos por WhatsApp') ?></div>
  </div>
</section>
<?php
/*
TODO(launch-gate F2): the technical-posture strip is also shown on /nosotros
(PRODUCT_SPEC.md §2). Keep it out until the scans return the claimed grades.
*/
page_end(['service' => 'nosotros']);
