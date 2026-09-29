<?php
declare(strict_types=1);
require dirname(__DIR__) . '/src/render.php';

http_response_code(404);
page_start('404');
?>
<section class="hero">
  <div class="wrap narrow">
    <p class="eyebrow">Error 404</p>
    <h1>No encontramos esa página</h1>
    <p class="lead">Puede que el enlace esté mal escrito o que la página ya no exista. Estos son los servicios principales:</p>
    <div class="cards cards--2">
      <a class="card" href="/servicios/respuesta-a-incidentes"><h3>Respuesta a incidentes</h3><p>Si te atacaron, empezá por acá.</p></a>
      <a class="card" href="/servicios/cuestionarios-de-proveedores"><h3>Cuestionarios de proveedores</h3><p>Si un cliente te pidió uno.</p></a>
      <a class="card" href="/servicios/diagnostico"><h3>Diagnóstico de seguridad</h3><p>Para saber cómo estás.</p></a>
      <a class="card" href="/servicios/seguridad-gestionada"><h3>Seguridad gestionada</h3><p>Acompañamiento mensual.</p></a>
    </div>
    <div class="btn-row"><?= cta_button('Escribinos por WhatsApp') ?></div>
  </div>
</section>
<?php
page_end(['service' => '404']);
