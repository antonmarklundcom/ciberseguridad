<?php
declare(strict_types=1);
require dirname(__DIR__, 2) . '/src/render.php';

page_start('para/contadores');
echo breadcrumbs('para/contadores');
?>
<section class="hero">
  <div class="wrap">
    <p class="eyebrow">Para estudios contables</p>
    <h1>Seguridad informática para estudios contables</h1>
    <p class="lead">Los datos de tus clientes son tu reputación profesional. Un incidente en tu estudio no es un problema de IT: es un problema profesional.</p>
    <div class="btn-row"><?= cta_button('Consultá por WhatsApp') ?></div>
  </div>
</section>

<section class="section section--alt reveal">
  <div class="wrap narrow prose">
    <h2>La amenaza real de un estudio contable: la concentración</h2>
    <p>Un estudio chico guarda en una sola oficina las finanzas de decenas de empresas: balances, declaraciones, planillas de sueldos, poderes. Para quien ataca, es más eficiente entrar a un estudio que a cincuenta empresas por separado. Ese es el riesgo particular de tu rubro, y no depende de cuán grande sea tu estudio.</p>
    <p>Hay dos formas típicas de entrada. La primera es el correo falso que aparece en épocas de vencimientos y presentaciones: un mensaje que parece de un cliente o de la administración tributaria y pide abrir un archivo o confirmar una clave. La segunda es la más silenciosa: el usuario y la clave del portal de la SET (Marangatu) de un cliente, que en muchos estudios circulan por chats y planillas.</p>
  </div>
</section>

<section class="section reveal">
  <div class="wrap narrow prose">
    <h2>Los datos que tenés y por qué alguien los quiere</h2>
    <p>Con la información de un estudio se puede montar un fraude convincente contra sus clientes: se conoce quién le debe a quién, cuándo se pagan las cuentas y cuál es el banco de cada uno. Un pedido de «cambio de cuenta para el pago» que llega con datos verdaderos es muy difícil de detectar. Por eso lo que un estudio guarda vale más para un delincuente de lo que parece a simple vista.</p>

    <h2>La obligación que te aplica</h2>
    <p>El secreto profesional y las expectativas contractuales de tus clientes son la obligación principal. Cada vez más clientes, sobre todo los que venden a bancos o a grandes empresas, quieren saber cómo cuidás su información antes de compartirla.</p>
    <!-- TODO(legal): confirm with the practitioner/lawyer which professional-conduct rules to cite; none are asserted here. -->

    <h2>Cómo es el trabajo en un estudio como el tuyo</h2>
    <p>Un <a href="/servicios/diagnostico">diagnóstico</a> para un estudio se enfoca en cuatro cosas:</p>
    <ul class="checks">
      <li><strong>Dónde están las claves de tus clientes</strong> y quién puede verlas, incluidas las del portal de la SET.</li>
      <li><strong>El proceso de cambio de datos bancarios:</strong> una verificación por otro canal antes de cualquier cambio.</li>
      <li><strong>El correo:</strong> segundo factor, autenticación del dominio y hábitos ante archivos adjuntos.</li>
      <li><strong>Las copias de seguridad</strong> de los archivos contables, y una prueba real de restauración.</li>
    </ul>
    <p>No hace falta un equipo de sistemas: el informe se escribe para que el proveedor que ya tenés, o quien te atienda la computadora, pueda ejecutarlo.</p>
    <p>Si un cliente tuyo te pidió un informe de cómo cuidás sus datos, tenemos un servicio pensado para eso: <a href="/servicios/cuestionarios-de-proveedores">cuestionarios de proveedores</a>.</p>
    <div class="btn-row"><?= cta_button('Consultá por WhatsApp') ?></div>
  </div>
</section>

<section class="section section--alt reveal" id="clientes">
  <div class="wrap narrow prose">
    <h2>¿Tus clientes te preguntan sobre esto?</h2>
    <p>Cada vez más empresas quieren saber si sus proveedores, entre ellos su estudio contable, cuidan su información. Si un cliente te pregunta, tenés dos opciones: responder de memoria o responder con un informe.</p>
    <p>Si te resulta útil, podés pasarle esta página a tus clientes que manejan información sensible, o pedirnos una charla breve para tu cartera. Un cliente que entiende su propio riesgo suele agradecer que su estudio lo haya traído a la conversación.</p>
    <p>Si querés hablar de cómo trabajar juntos, <a href="/contacto">escribinos</a>.</p>
  </div>
</section>

<?= cta_final('Empecemos por tu estudio', 'Contanos cuántas personas trabajan y qué sistemas usan. En 30 minutos vemos qué conviene revisar primero.') ?>
<?php
page_end([
    'schema' => [service_ld('para/contadores', 'Seguridad informática para estudios contables', 'Diagnóstico de seguridad para estudios contables: claves de clientes, proceso de cambio bancario, correo y copias de seguridad.', 'Estudios contables')],
    'service' => 'contadores',
]);
