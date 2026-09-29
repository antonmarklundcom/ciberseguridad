<?php
declare(strict_types=1);
require dirname(__DIR__, 2) . '/src/render.php';

page_start('para/clinicas');
echo breadcrumbs('para/clinicas');
?>
<section class="hero">
  <div class="wrap">
    <p class="eyebrow">Para clínicas y consultorios</p>
    <h1>Seguridad informática para clínicas y consultorios</h1>
    <p class="lead">Una clínica que no puede abrir mañana es un problema distinto de una clínica que filtró datos. Nos ocupamos primero del que más preocupa: la continuidad de la atención.</p>
    <div class="btn-row"><?= cta_button('Consultá por WhatsApp') ?></div>
  </div>
</section>

<section class="section section--alt reveal">
  <div class="wrap narrow prose">
    <h2>La amenaza real de un centro de salud</h2>
    <p>El riesgo que más pesa en el sector es el secuestro de datos: un programa malicioso cifra el sistema de turnos, la facturación y las historias clínicas, y el personal vuelve a trabajar con papel. Ese día no se pierde solo información: se atrasan consultas, estudios y cirugías, y hay pacientes esperando.</p>
    <p>Además, muchas clínicas conviven con equipos que no se pueden actualizar: un tomógrafo, un equipo de laboratorio o una impresora de imágenes que funciona con un sistema operativo que el fabricante ya no soporta. Si están en la misma red que las computadoras de recepción, un problema en una recepción llega hasta ellos.</p>
  </div>
</section>

<section class="section reveal">
  <div class="wrap narrow prose">
    <h2>Los datos que manejás y por qué alguien los quiere</h2>
    <p>Historias clínicas, diagnósticos, estudios, documentos de identidad, datos de contacto, información de cobertura y de facturación. Esa combinación permite suplantar a un paciente, extorsionar o cometer fraudes de facturación. Y a diferencia de una tarjeta, un diagnóstico no se puede «cancelar» ni cambiar: por eso los datos de salud tienen tanto valor para quien los roba.</p>
    <p>También hay accesos que se pasan por alto: el usuario compartido de recepción que usan cuatro personas, la cuenta del médico que ya no trabaja acá, el WhatsApp del consultorio abierto en la computadora de la sala de espera.</p>

    <h2>La obligación que te aplica</h2>
    <p>Los datos de salud están cubiertos por el deber de confidencialidad profesional, y la Ley 6534/2020 de protección de datos personales crediticios puede alcanzarte cuando manejás datos de financiación o cobranza. Además, los seguros y las obligaciones contractuales con financiadores empiezan a pedir evidencia de controles básicos.</p>
    <!-- TODO(legal): have a lawyer review the paragraph above before launch; we make no claim about how the law applies to a given clinic. -->
    <p class="note">Esto es una orientación general y no asesoramiento legal. La aplicación concreta de la ley a tu clínica la define un abogado.</p>

    <h2>Cómo es el trabajo en una clínica como la tuya</h2>
    <p>Empezamos con un <a href="/servicios/diagnostico">diagnóstico</a> adaptado al sector. Lo primero que miramos:</p>
    <ul class="checks">
      <li><strong>Qué se detiene si el sistema principal cae</strong> y cuánto tarda la recepción en volver a operar con lo que hay.</li>
      <li><strong>Las copias de seguridad de la historia clínica</strong> y, sobre todo, si alguien probó restaurarlas.</li>
      <li><strong>La red:</strong> si los equipos médicos que no se pueden actualizar están separados del resto.</li>
      <li><strong>Los accesos:</strong> quién ve qué historias, cuentas compartidas y bajas del personal.</li>
      <li><strong>El plan escrito:</strong> a quién se llama primero cuando no arranca nada, un sábado a la noche.</li>
    </ul>
    <p>Trabajamos sin interrumpir la atención: la revisión es de observación y coordinamos los horarios con la administración. El resultado es un informe con prioridades que tu proveedor de IT puede ejecutar.</p>
    <p>Si ya pasó algo, andá directo a <a href="/servicios/respuesta-a-incidentes">respuesta a incidentes</a>. Si un financiador o un socio te pidió evidencia de controles, mirá <a href="/servicios/cuestionarios-de-proveedores">cuestionarios de proveedores</a>.</p>
    <div class="btn-row"><?= cta_button('Consultá por WhatsApp') ?></div>
  </div>
</section>

<?= cta_final('Empecemos por lo que no puede parar', 'Contanos qué sistemas usa tu clínica. En 30 minutos vemos por dónde conviene empezar.') ?>
<?php
page_end([
    'schema' => [service_ld('para/clinicas', 'Seguridad informática para clínicas y consultorios', 'Diagnóstico de seguridad orientado a la continuidad de la atención y a la confidencialidad de historias clínicas.', 'Clínicas y consultorios')],
    'service' => 'clinicas',
]);
