<?php
declare(strict_types=1);
require dirname(__DIR__, 2) . '/src/render.php';

page_start('para/ecommerce');
echo breadcrumbs('para/ecommerce');
?>
<section class="hero">
  <div class="wrap">
    <p class="eyebrow">Para tiendas online</p>
    <h1>Seguridad para tiendas online en Paraguay</h1>
    <p class="lead">Que la tienda siga abierta y que el checkout siga siendo confiable. Una caída y una advertencia del navegador son dos formas de perder ventas el mismo día.</p>
    <div class="btn-row"><?= cta_button('Consultá por WhatsApp') ?></div>
  </div>
</section>

<section class="section section--alt reveal">
  <div class="wrap narrow prose">
    <h2>La amenaza real de una tienda online</h2>
    <p>En una tienda online los problemas suelen llegar por cuatro caminos:</p>
    <ul class="checks">
      <li><strong>Toma del panel de administración.</strong> Alguien entra con la clave de un empleado o de la agencia que armó la tienda y cambia precios, datos de pago o cuentas de cobro.</li>
      <li><strong>Código inyectado en el checkout.</strong> Un script de terceros (un chat, un píxel, una librería) queda comprometido y copia datos en el momento del pago sin que nadie lo note.</li>
      <li><strong>Reutilización de contraseñas de clientes.</strong> Se prueban en tu tienda claves filtradas de otros sitios hasta que alguna coincide.</li>
      <li><strong>Pedidos fraudulentos y contracargos.</strong> Compras con tarjetas ajenas que después vuelven como reclamos.</li>
    </ul>
  </div>
</section>

<section class="section reveal">
  <div class="wrap narrow prose">
    <h2>Los datos que manejás y por qué alguien los quiere</h2>
    <p>Nombres, direcciones, teléfonos, historial de compras y, según cómo cobres, tokens o datos de tarjeta. Para un delincuente, la lista de clientes con su historial sirve para armar mensajes de fraude creíbles («tu pedido tiene un problema, confirmá acá»). Y si el problema se hace público, tus clientes dejan de confiar en tu marca, algo que cuesta mucho más recuperar que un sitio caído.</p>

    <h2>La obligación que te aplica</h2>
    <p>Las condiciones de tu procesador de pagos y de la plataforma que usás suelen exigir controles mínimos y avisarles rápido si algo pasa. Leelas: en general te piden más de lo que pensás. También tenés el compromiso con tus propios clientes de cuidar los datos que te dejan.</p>
    <!-- TODO(legal): payment-processor and data-protection obligations should be reviewed by the practitioner/lawyer before launch; none are asserted here. -->

    <h2>Cómo es el trabajo en una tienda como la tuya</h2>
    <p>Un <a href="/servicios/diagnostico">diagnóstico</a> para ecommerce revisa:</p>
    <ul class="checks">
      <li><strong>Quién tiene acceso al panel</strong>, con qué claves y si hay segundo factor activado.</li>
      <li><strong>Qué scripts de terceros cargan en el checkout</strong> y quién los mantiene.</li>
      <li><strong>Actualizaciones</strong> de la plataforma, los plugins y el tema, y qué pasa cuando alguien deja de trabajar con vos.</li>
      <li><strong>Copias de seguridad</strong> de la tienda y de la base de datos, con una prueba de restauración.</li>
      <li><strong>Controles antifraude</strong> y el proceso cuando llega un pedido raro.</li>
    </ul>
    <p>Como una tienda vive de estar en línea, coordinamos el trabajo para no tocar el sitio en producción sin acuerdo previo. Nada se prueba contra tu tienda sin tu autorización por escrito.</p>
    <p>Si ya notaste algo raro, no esperes: <a href="/servicios/respuesta-a-incidentes">respuesta a incidentes</a>. Si un marketplace o un banco te pidió evidencia de controles, mirá <a href="/servicios/cuestionarios-de-proveedores">cuestionarios de proveedores</a>.</p>
    <div class="btn-row"><?= cta_button('Consultá por WhatsApp') ?></div>
  </div>
</section>

<?= cta_final('Revisemos tu checkout', 'Contanos qué plataforma usás y cómo cobrás. En 30 minutos vemos qué mirar primero.') ?>
<?php
page_end([
    'schema' => [service_ld('para/ecommerce', 'Seguridad para tiendas online', 'Diagnóstico de seguridad para tiendas online: panel de administración, checkout, scripts de terceros y copias de seguridad.', 'Tiendas online')],
    'service' => 'ecommerce',
]);
