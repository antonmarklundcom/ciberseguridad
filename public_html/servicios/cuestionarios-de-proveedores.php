<?php
declare(strict_types=1);
require dirname(__DIR__, 2) . '/src/render.php';

$faqs = [
    ['¿Pueden trabajar con el marco o la planilla que nos pidieron?', 'Depende de cuál sea. En la conversación inicial nos mostrás lo que te mandaron y te decimos con franqueza con qué marcos podemos trabajar y con cuáles no. Preferimos decirte que no a tomar un trabajo que no dominamos.'],
    ['¿Cuánto tardan?', 'Depende de la cantidad de preguntas, del plazo del cliente y de cuánta evidencia ya existe. Lo acordamos por escrito antes de empezar. Si el plazo es muy corto se puede hacer con prioridad, con un precio acorde.'],
    ['¿Nos garantizan que el cliente nos apruebe?', 'No, y no lo hace nadie con honestidad. La decisión es de quien te envió el cuestionario, con sus propios criterios. Lo que sí hacemos es que tus respuestas sean claras, verdaderas y estén respaldadas con evidencia, y que tengas un plan para lo que todavía no cumplís.'],
    ['¿Qué pasa la próxima vez que nos manden uno?', 'Te dejamos un archivo reutilizable con tus respuestas y la evidencia ordenada. El próximo cuestionario se apoya en eso y suele llevar días en lugar de semanas.'],
    ['¿Firman NDA?', 'Sí. Es lo habitual y lo firmamos antes de ver el cuestionario o cualquier dato de tu empresa.'],
];

page_start('servicios/cuestionarios-de-proveedores');
echo breadcrumbs('servicios/cuestionarios-de-proveedores');
?>
<section class="hero">
  <div class="wrap">
    <p class="eyebrow">Servicio · Cuestionarios</p>
    <h1>Cuestionario de seguridad para proveedores: te ayudamos a responderlo</h1>
    <p class="lead">Te mandaron una planilla larga y hay un plazo. Traducimos lo que preguntan, ordenamos la evidencia y completamos el cuestionario con respuestas verdaderas.</p>
    <div class="btn-row"><?= cta_button('Mostranos el cuestionario por WhatsApp') ?></div>
  </div>
</section>

<section class="section section--alt reveal">
  <div class="wrap narrow prose">
    <h2>La situación</h2>
    <p>Te llegó una planilla de 200 preguntas de un cliente y no sabés por dónde empezar. Tenés dos semanas y el contrato depende de esto.</p>
    <p>Es una situación muy común cuando una empresa empieza a venderle a un banco, a una multinacional o a una aseguradora. Las preguntas usan un vocabulario que no es el tuyo, algunas se parecen entre sí y otras esconden una trampa, y nadie en tu equipo tiene tiempo ni práctica para responderlas bien.</p>
  </div>
</section>

<section class="section reveal">
  <div class="wrap narrow prose">
    <h2>¿Qué hacemos con tu cuestionario de seguridad?</h2>
    <ul class="checks">
      <li>Leemos el cuestionario y lo traducimos a lo que realmente se está preguntando.</li>
      <li>Hacemos un análisis de brechas: qué ya cumplís, qué no y qué cumplís a medias.</li>
      <li>Armamos un plan de remediación ordenado por lo que más mueve el resultado con menos esfuerzo.</li>
      <li>Reunimos el paquete de evidencia: políticas, capturas de pantalla, configuraciones y registros.</li>
      <li>Completamos el cuestionario en el idioma y el formato que exige quien lo envió.</li>
      <li>Te acompañamos en la ronda de seguimiento, que casi siempre existe.</li>
    </ul>
    <p>Trabajamos siempre sobre tu información y con tu autorización. No probamos ni escaneamos sistemas de terceros para completar respuestas.</p>
  </div>
</section>

<section class="section section--alt reveal" id="respuesta-no">
  <div class="wrap narrow prose">
    <h2>¿Y si la respuesta a una pregunta es «no»?</h2>
    <p>Es el miedo más común: creer que un solo «no» te descalifica. En general no funciona así.</p>
    <ul class="checks">
      <li><strong>Quien revisa suele evaluar riesgo y trayectoria</strong>, no perfección. Un «todavía no, y esto es lo que vamos a hacer y para cuándo» es una respuesta que se puede evaluar.</li>
      <li><strong>Un plan de remediación con fechas suele ser una respuesta aceptable.</strong> No hay una regla universal: cada solicitante decide con sus propios criterios, y algunas preguntas sí son excluyentes. Por eso conviene conocerlas antes de responder.</li>
      <li><strong>Decir que tenés un control que no tenés es la respuesta que más probablemente termina la relación.</strong> Si después se comprueba, se pierde el contrato y también la confianza.</li>
    </ul>
    <p>Por eso nuestro trabajo no es maquillar las respuestas. Es decirte cuáles son verdaderas hoy, cuáles podés volver verdaderas antes del plazo y cuáles conviene declarar con un plan.</p>
  </div>
</section>

<section class="section reveal">
  <div class="wrap narrow prose">
    <h2>¿Qué recibís?</h2>
    <ul class="checks">
      <li>El cuestionario completado, listo para enviar.</li>
      <li>El paquete de evidencia, ordenado y nombrado.</li>
      <li>El plan de remediación con prioridades y fechas propuestas.</li>
      <li><strong>Un archivo reutilizable</strong>, para que el próximo cuestionario lleve días y no semanas.</li>
    </ul>
    <p>Esa reutilización es la razón por la que muchos clientes pasan después a un acompañamiento mensual. Si te interesa, mirá la <a href="/servicios/seguridad-gestionada">seguridad gestionada</a>.</p>
    <!-- TODO(content): name the frameworks the practitioner genuinely works with (e.g. ISO 27001, a bank template). Until confirmed, none are named. -->

    <h2>Cómo trabajamos</h2>
    <?= process_steps('Ejecución y entrega') ?>

    <h2>¿Cuánto cuesta?</h2>
    <?= price_block('cuestionarios', 'El precio depende del alcance: cantidad de preguntas, marco solicitado y cuánta evidencia ya existe. Se acuerda por escrito antes de empezar. Si el plazo es muy corto, se puede trabajar con prioridad y se cotiza en consecuencia.') ?>
    <p>Si querés saber antes de responder qué encontrarían en una revisión, un <a href="/servicios/diagnostico">diagnóstico de seguridad</a> te da ese cuadro completo.</p>
    <div class="btn-row"><?= cta_button('Mostranos el cuestionario por WhatsApp') ?></div>
  </div>
</section>

<?= faq_html($faqs) ?>
<?= cta_final('Antes de que se venza el plazo', 'Mandanos una foto de las primeras preguntas y te decimos cómo lo encararíamos. No compartas datos sensibles: alcanza con el formato.') ?>
<?php
page_end([
    'schema' => [service_ld('servicios/cuestionarios-de-proveedores', 'Cuestionarios de seguridad para proveedores', 'Análisis de brechas, evidencia y cuestionario de seguridad completado para empresas que responden a un cliente. No garantiza la aprobación.')],
    'faqs' => $faqs,
    'service' => 'cuestionarios-de-proveedores',
]);
