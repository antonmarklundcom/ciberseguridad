<?php
declare(strict_types=1);
require dirname(__DIR__) . '/src/render.php';

$faqs = [
    ['¿Para qué tipo de empresas trabajan?', 'Para empresas paraguayas que dependen de sus sistemas para operar y que no tienen un área de seguridad propia: clínicas, estudios contables, tiendas online, comercios, industrias y servicios. Si tu caso queda fuera de lo que hacemos bien, te lo decimos en la primera conversación.'],
    ['¿Necesito tener un equipo de IT para contratarlos?', 'No. Si ya tenés un proveedor de IT, trabajamos con él y no lo reemplazamos: el informe está escrito para que pueda ejecutarlo. Si no tenés, te ayudamos a ordenar las prioridades para que sepas qué pedirle a quien contrates.'],
    ['¿Cómo se cobra?', 'Con una propuesta por escrito, con alcance y precio fijo, antes de empezar. No trabajamos con horas abiertas. La primera conversación de 30 minutos no tiene costo.'],
    ['¿Van a escanear nuestros sistemas sin avisar?', 'Nunca. No accedemos ni probamos ningún sistema que no sea tuyo o sobre el que no tengamos autorización escrita. Lo mismo vale para este sitio: sus herramientas gratuitas no se conectan a ningún servidor tuyo.'],
    ['¿Qué pasa con la confidencialidad?', 'Firmamos un acuerdo de confidencialidad cuando lo pedís. No publicamos nombres de clientes; por eso este sitio no tiene un muro de logos. Preferimos explicarte cómo trabajamos a mostrarte marcas ajenas.'],
];

page_start('');
?>
<section class="hero">
  <div class="wrap">
    <p class="eyebrow">Ciberseguridad.com.py</p>
    <h1>Seguridad informática para empresas paraguayas que ya no pueden improvisar.</h1>
    <p class="lead">Revisamos cómo está tu empresa, te ayudamos cuando algo salió mal y te acompañamos para que no se repita. Todo por escrito, con precio fijo.</p>
    <div class="btn-row">
      <?= cta_button('Escribinos por WhatsApp') ?>
      <a class="btn btn--ghost" href="/contacto">Dejar una consulta</a>
    </div>
    <p class="note">La primera conversación, de 30 minutos, no tiene costo.</p>
  </div>
</section>

<section class="section section--alt reveal" id="router">
  <div class="wrap">
    <h2>¿Qué te trae por acá?</h2>
    <p class="lead">Elegí la situación más parecida a la tuya.</p>
    <div class="bento">
      <a class="card card--big" href="/servicios/respuesta-a-incidentes">
        <h3>Nos atacaron</h3>
        <p>Algo dejó de funcionar, aparecieron archivos cifrados o se movió dinero que no debía. Qué hacer ahora mismo y cómo te ayudamos.</p>
        <span class="card__more">Respuesta a incidentes</span>
      </a>
      <a class="card card--big" href="/servicios/cuestionarios-de-proveedores">
        <h3>Un cliente nos pidió un cuestionario de seguridad</h3>
        <p>Te llegó una planilla larga y hay un plazo. Te ayudamos a responderla con evidencia y a cerrar las brechas.</p>
        <span class="card__more">Cuestionarios de proveedores</span>
      </a>
      <a class="card card--big" href="/servicios/diagnostico">
        <h3>Queremos saber cómo estamos</h3>
        <p>Tu proveedor dice que está todo bien y no tenés cómo comprobarlo. Un diagnóstico te da un cuadro claro y priorizado.</p>
        <span class="card__more">Diagnóstico de seguridad</span>
      </a>
      <a class="card card--big" href="/servicios/seguridad-gestionada">
        <h3>Necesitamos cumplir con algo</h3>
        <p>Una obligación contractual o interna pide mantener controles a lo largo del tiempo, no un esfuerzo de una sola vez.</p>
        <span class="card__more">Seguridad gestionada</span>
      </a>
    </div>
  </div>
</section>

<section class="section reveal" id="servicios">
  <div class="wrap">
    <h2>Cuatro servicios, cada uno con alcance definido</h2>
    <ul class="checks">
      <li><a href="/servicios/diagnostico"><strong>Diagnóstico de seguridad.</strong></a> Revisión de siete áreas y un informe con prioridades y plan de acción.</li>
      <li><a href="/servicios/respuesta-a-incidentes"><strong>Respuesta a incidentes.</strong></a> Contención, investigación y recuperación de lo que sea posible, con informe posterior.</li>
      <li><a href="/servicios/cuestionarios-de-proveedores"><strong>Cuestionarios de proveedores.</strong></a> Análisis de brechas, evidencia y cuestionario completado.</li>
      <li><a href="/servicios/seguridad-gestionada"><strong>Seguridad gestionada.</strong></a> Trabajo mensual y trimestral con un contacto nombrado. No es un SOC 24/7.</li>
    </ul>
  </div>
</section>

<section class="section section--alt reveal">
  <div class="wrap">
    <h2>Cómo trabajamos</h2>
    <?= process_steps() ?>
    <p><a href="/nosotros">Más sobre cómo trabajamos y qué no hacemos</a></p>
  </div>
</section>

<section class="section reveal" id="rubros">
  <div class="wrap">
    <h2>Para tu rubro</h2>
    <p>Cada sector tiene amenazas, datos y obligaciones distintas. Estas páginas las explican una por una.</p>
    <div class="cards cards--4">
      <a class="card" href="/para/clinicas"><h3>Clínicas y consultorios</h3><p>Continuidad de la atención e historias clínicas.</p></a>
      <a class="card" href="/para/contadores"><h3>Estudios contables</h3><p>Los datos de tus clientes son tu reputación.</p></a>
      <a class="card" href="/para/ecommerce"><h3>Tiendas online</h3><p>Checkout, panel de administración y datos de clientes.</p></a>
      <a class="card" href="/para/pymes"><h3>PYMES</h3><p>Lo mínimo que necesita una empresa chica, sin humo.</p></a>
    </div>
    <p>¿Preferís empezar solo? Probá la <a href="/recursos/autoevaluacion">autoevaluación gratuita</a> o guardá el <a href="/recursos/checklist-de-incidentes">checklist de incidentes</a>.</p>
  </div>
</section>

<?php
/*
TODO(launch-gate F2): technical-posture strip (PRODUCT_SPEC.md §2). Do NOT
uncomment until SSL Labs A+, securityheaders.com A, HSTS preload, DNSSEC and
DMARC p=reject are all verified live. Publishing it early is worse than not
publishing it.

<section class="section section--alt"><div class="wrap">
<p><strong>Practicamos lo que vendemos.</strong> Este sitio corre con HSTS preload, CSP estricta, sin scripts de terceros, DNSSEC y DMARC en p=reject. Verificalo vos mismo: SSL Labs · securityheaders.com · security.txt</p>
</div></section>
*/
?>

<?= faq_html($faqs) ?>
<?= cta_final('Contanos tu situación', 'En 30 minutos te decimos si podemos ayudarte y cómo lo haríamos.') ?>
<?php
page_end([
    'schema' => [organization_ld(), website_ld()],
    'faqs'   => $faqs,
]);
