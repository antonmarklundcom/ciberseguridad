<?php
declare(strict_types=1);
require dirname(__DIR__) . '/src/render.php';

page_start('recursos');
echo breadcrumbs('recursos');
?>
<section class="hero">
  <div class="wrap narrow">
    <p class="eyebrow">Recursos</p>
    <h1>Recursos gratuitos de seguridad informática para empresas</h1>
    <p class="lead">Herramientas simples, pensadas para que las uses hoy. Ninguna escanea ni se conecta a tus sistemas, y ninguna te pide contraseñas.</p>
  </div>
</section>

<section class="section section--alt">
  <div class="wrap">
    <div class="cards cards--2">
      <a class="card card--big" href="/recursos/autoevaluacion">
        <h3>Autoevaluación de seguridad</h3>
        <p><strong>Qué hace:</strong> veinte preguntas de opción múltiple sobre siete áreas y un resultado por área, con tres cosas para mirar primero.</p>
        <p><strong>Qué no hace:</strong> no revisa tus sistemas ni verifica tus respuestas. Un puntaje alto no significa que estés seguro.</p>
        <span class="card__more">Hacer la autoevaluación</span>
      </a>
      <a class="card card--big" href="/recursos/checklist-de-incidentes">
        <h3>Checklist de incidentes</h3>
        <p><strong>Qué hace:</strong> te da pasos defensivos para las primeras horas según el tipo de ataque, y una hoja de contactos para imprimir y completar antes de necesitarla.</p>
        <p><strong>Qué no hace:</strong> no reemplaza a un profesional. Cada camino termina en nuestra página de respuesta a incidentes.</p>
        <span class="card__more">Ver el checklist</span>
      </a>
    </div>
  </div>
</section>

<section class="section">
  <div class="wrap narrow prose">
    <h2>Nuestra regla para las herramientas</h2>
    <p>Una herramienta de este sitio puede procesar lo que vos nos contás sobre tu propia empresa. No se conecta a ningún servidor, dominio o sistema, ni tuyo ni de terceros. Esa regla es la que separa la orientación general del acceso no autorizado, que en Paraguay es un delito.</p>
    <p>Si necesitás una revisión técnica real, mirá el <a href="/servicios/diagnostico">diagnóstico de seguridad</a>. Si sos una empresa chica y no sabés por dónde empezar, leé <a href="/para/pymes">ciberseguridad para PYMES</a>.</p>
  </div>
</section>
<?php
page_end(['service' => 'recursos']);
