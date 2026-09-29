<?php
declare(strict_types=1);
require dirname(__DIR__, 2) . '/src/render.php';

$faqs = [
    ['¿Reemplaza a nuestro proveedor de IT?', 'No. Tu proveedor sigue operando los sistemas. Nosotros revisamos, verificamos y te decimos qué falta, para que las cosas se hagan y se puedan comprobar. Es un control independiente, no un reemplazo.'],
    ['¿Qué pasa si hay un incidente?', 'Tenés un contacto con prioridad de atención. La respuesta a un incidente en sí es un trabajo aparte, con alcance y precio acordados por escrito: no hay horas ilimitadas de respuesta incluidas.'],
    ['¿Hay permanencia mínima?', 'El plazo mínimo y el aviso para dar de baja se definen y se escriben en la propuesta, antes de empezar. Nada queda implícito.'],
    ['¿Podemos empezar sin el diagnóstico?', 'Se puede, pero es peor: no se puede mantener una postura que nunca se midió. Casi siempre empezamos con un diagnóstico para saber desde dónde partimos.'],
];

page_start('servicios/seguridad-gestionada');
echo breadcrumbs('servicios/seguridad-gestionada');
?>
<section class="hero">
  <div class="wrap">
    <p class="eyebrow">Servicio · Acompañamiento mensual</p>
    <h1>Seguridad informática gestionada: acompañamiento mensual</h1>
    <p class="lead">Un trabajo repetido, con calendario, contacto nombrado e informes. Para empresas que necesitan atención continua y no tienen un área de seguridad propia.</p>
    <div class="btn-row"><?= cta_button('Consultá el alcance por WhatsApp') ?></div>
  </div>
</section>

<section class="section section--alt reveal">
  <div class="wrap narrow prose">
    <h2>Qué incluye, según la frecuencia</h2>
    <p>Un servicio mensual vendido de forma vaga es un servicio que se cancela. Por eso lo detallamos por frecuencia.</p>
    <div class="cards cards--2">
      <div class="card"><h3>Todos los meses</h3><ul class="checks"><li>Revisión de parches y configuración</li><li>Revisión de accesos</li><li>Prueba de restauración de una copia de seguridad</li></ul></div>
      <div class="card"><h3>Cada trimestre</h3><ul class="checks"><li>Informe de postura, con lo que mejoró y lo que falta</li><li>Simulación de phishing, con capacitación para quienes hagan clic</li></ul></div>
      <div class="card"><h3>De forma continua</h3><ul class="checks"><li>Un contacto nombrado para tus consultas</li><li>Prioridad de atención si pasa algo</li></ul></div>
      <div class="card"><h3>Una vez por año</h3><ul class="checks"><li>Un nuevo <a href="/servicios/diagnostico">diagnóstico</a> completo</li></ul></div>
    </div>
  </div>
</section>

<section class="section reveal">
  <div class="wrap narrow prose">
    <h2>Cómo se ve un mes de trabajo</h2>
    <p>Para que sepas qué esperar, este es el ritmo típico. Las fechas exactas se acuerdan con tu proveedor de IT para no interferir con la operación.</p>
    <ol>
      <li><strong>Primera semana.</strong> Revisamos el estado de las actualizaciones y de la configuración, y te avisamos de lo que quedó pendiente.</li>
      <li><strong>Segunda semana.</strong> Revisamos los accesos: quién entró, quién se fue y quién sigue teniendo permisos que ya no necesita.</li>
      <li><strong>Tercera semana.</strong> Restauramos una copia de seguridad de prueba y verificamos que los datos se recuperan y abren.</li>
      <li><strong>Cierre del mes.</strong> Un resumen corto por escrito: qué se hizo, qué se encontró y qué sigue.</li>
    </ol>
    <p>Cada trimestre ese resumen se convierte en un informe de postura más completo, para que puedas mostrarlo a la dirección o a un cliente que te pida evidencia de tus controles.</p>
  </div>
</section>

<section class="section section--alt reveal" id="no-incluye">
  <div class="wrap narrow prose">
    <h2>Qué NO incluye</h2>
    <p>Esta sección genera más confianza que la anterior, y evita la discusión de alcance en el cuarto mes.</p>
    <ul class="checks checks--no">
      <li><strong>No es un SOC ni una guardia 24/7.</strong> No monitoreamos tus sistemas de noche ni los fines de semana.</li>
      <li><strong>No incluye horas ilimitadas de respuesta a incidentes.</strong> Un incidente se trabaja con su propio alcance acordado.</li>
      <li><strong>No reemplaza a tu proveedor de IT.</strong> Verificamos y recomendamos; no operamos tu infraestructura.</li>
      <li><strong>No asegura que no habrá incidentes.</strong> Reduce brechas conocidas y mantiene la evidencia de que se hizo el trabajo, nada más.</li>
    </ul>
  </div>
</section>

<section class="section reveal">
  <div class="wrap narrow prose">
    <h2>Cómo empieza</h2>
    <p>Casi siempre con un <a href="/servicios/diagnostico">diagnóstico de seguridad</a>: no se puede mantener una postura que nunca se midió. Con ese informe en mano, el acompañamiento mensual se organiza alrededor de las prioridades reales de tu empresa.</p>
    <?= process_steps('Arranque y primer mes') ?>
    <h2>¿Cuánto cuesta?</h2>
    <?= price_block('gestionada', 'Un monto mensual según el tamaño de la empresa, con plazo mínimo y aviso de baja escritos en la propuesta. Sin costos ocultos por el alcance descrito arriba.') ?>
    <p>Si tu necesidad es responder a un cliente que te pide evidencia, este trabajo mensual es también la mejor base para los <a href="/servicios/cuestionarios-de-proveedores">cuestionarios de proveedores</a>.</p>
    <div class="btn-row"><?= cta_button('Consultá el alcance por WhatsApp') ?></div>
  </div>
</section>

<?= faq_html($faqs) ?>
<?= cta_final('Hablemos del alcance', 'Contanos cuántos puestos son y qué sistemas usan, y te decimos qué incluiría el acompañamiento en tu caso.') ?>
<?php
page_end([
    'schema' => [service_ld('servicios/seguridad-gestionada', 'Seguridad informática gestionada', 'Acompañamiento mensual: revisión de parches, accesos, prueba de restauración de copias y capacitación. No es un SOC 24/7.')],
    'faqs' => $faqs,
    'service' => 'seguridad-gestionada',
]);
