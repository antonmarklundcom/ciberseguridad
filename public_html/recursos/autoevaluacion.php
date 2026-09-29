<?php
declare(strict_types=1);
require dirname(__DIR__, 2) . '/src/render.php';
require_once dirname(__DIR__, 2) . '/src/form-handler.php'; // csrf_token()
require_once dirname(__DIR__, 2) . '/src/assessment.php';

$questions = assess_questions();
$total = count($questions);

page_start('recursos/autoevaluacion');
echo breadcrumbs('recursos/autoevaluacion');
?>
<section class="hero">
  <div class="wrap narrow">
    <p class="eyebrow">Herramienta gratuita</p>
    <h1>Autoevaluación de seguridad informática para tu empresa</h1>
    <p class="lead">Respondé <?= (int) $total ?> preguntas de opción múltiple sobre siete áreas. Ves el resultado completo al terminar, sin dejar ningún dato.</p>
    <div class="callout callout--warn" id="limits">
      <p><strong>Este resultado se basa únicamente en lo que indicaste y no constituye una evaluación técnica. Un puntaje alto no significa que tu empresa esté segura.</strong></p>
    </div>
    <p class="note">Todo ocurre en tu navegador. No se envía nada a ningún servidor hasta que vos decidas mandarnos el resultado. No se conecta a ningún sistema ni escanea nada.</p>
  </div>
</section>

<section class="section section--alt">
  <div class="wrap narrow assess" id="assess">
    <p class="no-js-only note">Esta herramienta necesita JavaScript para calcular el resultado. Mientras tanto podés leer las preguntas, o <a href="/contacto">escribirnos</a> y las repasamos juntos.</p>

    <div id="progress" hidden>
      <p class="note" id="progress-label" aria-live="polite">Pregunta 1 de <?= (int) $total ?></p>
      <div class="progress" role="progressbar" aria-valuemin="0" aria-valuemax="<?= (int) $total ?>" aria-valuenow="0" aria-label="Progreso"><div class="progress__bar" id="progress-bar"></div></div>
    </div>

    <form id="questions" novalidate>
<?php foreach ($questions as $i => $q): ?>
      <fieldset class="q" data-domain="<?= e($q['domain']) ?>" data-weight="<?= (int) $q['weight'] ?>">
        <legend><span class="q__dom"><?= e(ASSESS_DOMAINS[$q['domain']]) ?></span><?= ($i + 1) ?>. <?= e($q['q']) ?></legend>
<?php foreach ($q['opts'] as $j => [$pts, $label]): ?>
        <label class="opt"><input type="radio" name="<?= e($q['id']) ?>" value="<?= (int) $j ?>" data-pts="<?= (int) $pts ?>"><span><?= e($label) ?></span></label>
<?php endforeach; ?>
      </fieldset>
<?php endforeach; ?>
    </form>

    <div class="assess-nav" id="assess-nav" hidden>
      <button type="button" class="btn btn--ghost" id="btn-prev">Anterior</button>
      <button type="button" class="btn btn--primary" id="btn-next" disabled>Siguiente</button>
    </div>

    <div class="result" id="result" hidden tabindex="-1">
      <p class="eyebrow">Tu resultado</p>
      <h2 id="result-title">Resultado</h2>
      <p class="score"><span id="result-score">0</span><span class="note"> / 100</span></p>
      <p id="result-band" class="lead"></p>
      <div class="callout callout--warn"><p><strong>Este resultado se basa únicamente en lo que indicaste y no constituye una evaluación técnica. Un puntaje alto no significa que tu empresa esté segura.</strong></p></div>
      <h3>Por área</h3>
      <div id="result-domains"></div>
      <h3>Tres cosas para mirar primero</h3>
      <ol id="result-actions"></ol>
      <ul id="advice-source" hidden>
<?php foreach (ASSESS_ADVICE as $d => $text): ?>
        <li data-domain="<?= e($d) ?>" data-label="<?= e(ASSESS_DOMAINS[$d]) ?>"><?= e($text) ?></li>
<?php endforeach; ?>
      </ul>
      <p class="no-print"><button type="button" class="btn btn--ghost" id="btn-print">Imprimir este resultado</button></p>

      <div class="no-print" id="capture">
        <h3>¿Querés el detalle por correo, con acciones para tu caso?</h3>
        <p>Es opcional. Dejá tus datos y te escribimos para conversarlo. El resultado de arriba ya es tuyo.</p>
<?php
$form_type = 'autoevaluacion';
$page = 'recursos/autoevaluacion';
$errors = [];
$old = [];
require dirname(__DIR__, 2) . '/src/partials/lead-form.php';
?>
      </div>
      <p class="no-print"><a href="/servicios/diagnostico">Si querés una revisión técnica de tu empresa, mirá el diagnóstico de seguridad</a>.</p>
    </div>
  </div>
</section>

<section class="section">
  <div class="wrap narrow prose">
    <h2>Qué mide y qué no mide</h2>
    <p>La autoevaluación recorre siete áreas: copias de seguridad, identidad y accesos, correo y fraude, dispositivos, terceros, personas y preparación. Las copias de seguridad, el segundo factor y el proceso ante pedidos de cambio de cuenta bancaria pesan el doble, porque es donde suelen concentrarse los daños más graves.</p>
    <p>No verifica nada: no revisa tus sistemas ni comprueba que lo que respondas sea cierto. Sirve para ordenar la conversación y ver dónde conviene mirar primero. Para una revisión real, existe el <a href="/servicios/diagnostico">diagnóstico</a>. Si ya tuviste un incidente, andá a <a href="/servicios/respuesta-a-incidentes">respuesta a incidentes</a>.</p>
    <p>Más orientación para empresas chicas en <a href="/para/pymes">ciberseguridad para PYMES</a>.</p>
  </div>
</section>
<?php
page_end([
    'schema' => [webapp_ld('recursos/autoevaluacion', 'Autoevaluación de seguridad informática', 'Cuestionario de opción múltiple sobre siete áreas de seguridad, con resultado por área. No es una evaluación técnica.')],
    'scripts' => ['/assets/js/autoevaluacion.js'],
    'service' => 'autoevaluacion',
]);
