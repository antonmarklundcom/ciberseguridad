<?php
declare(strict_types=1);
require dirname(__DIR__) . '/src/render.php';
require_once dirname(__DIR__) . '/src/form-handler.php'; // csrf_token()

$n = nap();
$hours = (string) cfg('hours');

page_start('contacto');
echo breadcrumbs('contacto');
?>
<section class="hero">
  <div class="wrap">
    <p class="eyebrow">Contacto</p>
    <h1>Contacto</h1>
    <p class="lead">La forma más rápida es WhatsApp. Si preferís, llamanos o dejá tu consulta en el formulario y respondemos en el día hábil.</p>
    <div class="btn-row">
      <?= cta_button('Escribinos por WhatsApp') ?>
      <a class="btn btn--ghost" href="<?= e(tel_href()) ?>" data-track="phone">Llamar al <?= e($n['phone']) ?></a>
    </div>
    <p class="note">Si se trata de un incidente en curso, andá a <a href="/servicios/respuesta-a-incidentes">respuesta a incidentes</a>.</p>
  </div>
</section>

<section class="section section--alt">
  <div class="wrap two-col">
    <div>
      <h2>Dejá tu consulta</h2>
      <?php
      $form_type = 'contacto';
      $page = 'contacto';
      $errors = [];
      $old = [];
      require dirname(__DIR__) . '/src/partials/lead-form.php';
      ?>
    </div>
    <div>
      <h2>Datos de contacto</h2>
      <?= nap_html() ?>
      <?php if ($hours !== ''): ?>
      <p><strong>Horario:</strong> <?= e($hours) ?></p>
      <?php endif; /* TODO(content): set BUSINESS_HOURS in .env once decided (Phase 0); the row is hidden until then. */ ?>
      <?php if ($n['email'] === ''): ?>
      <!-- TODO(content): CONTACT_EMAIL is empty. B2B buyers expect a visible email; set it in .env and it appears here, in the footer and in the JSON-LD. -->
      <?php endif; ?>
      <p class="note">No compartas contraseñas ni detalles técnicos sensibles por ningún canal hasta que lo acordemos: lo conversamos por una vía segura.</p>
    </div>
  </div>
</section>
<?php
page_end(['schema' => [organization_ld()], 'service' => 'contacto']);
