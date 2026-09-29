<?php
declare(strict_types=1);
require dirname(__DIR__) . '/src/render.php';

$t = ($_GET['t'] ?? '') === 'autoevaluacion' ? 'autoevaluacion' : 'contacto';

page_start('gracias');
?>
<section class="hero">
  <div class="wrap narrow">
    <p class="eyebrow">Consulta recibida</p>
    <h1>Gracias, recibimos tu consulta</h1>
    <?php if ($t === 'autoevaluacion'): ?>
    <p class="lead">Recibimos el resultado de tu autoevaluación. Te escribimos en el día hábil para conversarlo y ordenar las prioridades.</p>
    <?php else: ?>
    <p class="lead">Te respondemos en el día hábil. Si es urgente y no querés esperar, escribinos por WhatsApp.</p>
    <?php endif; ?>
    <div class="btn-row">
      <?= cta_button('Ir más rápido por WhatsApp') ?>
      <a class="btn btn--ghost" href="/recursos">Ver los recursos gratuitos</a>
    </div>
    <p class="note">Si tu consulta es por un incidente en curso, <a href="/servicios/respuesta-a-incidentes">llamanos</a>: no esperes el correo.</p>
  </div>
</section>
<?php
page_end(['event' => 'generate_lead', 'service' => 'gracias']);
