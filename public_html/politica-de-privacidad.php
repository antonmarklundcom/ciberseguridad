<?php
declare(strict_types=1);
require dirname(__DIR__) . '/src/render.php';

$email = (string) cfg('contact_email');
$ga = (string) cfg('ga4_id') !== '';

page_start('politica-de-privacidad');
echo breadcrumbs('politica-de-privacidad');
?>
<section class="hero">
  <div class="wrap narrow">
    <h1>Política de privacidad</h1>
    <p class="lead">Qué datos recolectamos cuando nos escribís, para qué los usamos, quién los recibe y cómo pedir que los borremos. Redactado en lenguaje simple.</p>
    <p class="note">Versión preliminar, pendiente de revisión legal.</p>
  </div>
</section>
<!-- TODO(legal): the visible note above is intentional until a lawyer signs off. Remove it then. -->

<section class="section">
  <div class="wrap narrow prose">
    <h2>Quién es responsable</h2>
    <p><?= e(cfg('brand')) ?>, con sede en Asunción, Paraguay. <!-- TODO(legal): razón social y RUC (Phase 0) --></p>

    <h2>Qué datos recolectamos</h2>
    <p>Solo los necesarios para tener una primera conversación. Cuando completás el formulario de contacto:</p>
    <ul>
      <li>Nombre, teléfono, y opcionalmente correo y empresa.</li>
      <li>Cantidad de empleados, rubro y motivo de la consulta, elegidos de una lista.</li>
      <li>El mensaje que escribas, si lo hacés.</li>
      <li>Si venís de una campaña, la fuente registrada en el enlace (por ejemplo, parámetros utm).</li>
    </ul>
    <p>Si completás la autoevaluación y decidís enviarnos el resultado, además recibimos tu puntaje, tu nivel y el puntaje por área. Las respuestas individuales no se envían.</p>
    <p><strong>Lo que no pedimos:</strong> números de cédula, escaneos de documentos, números de cuenta, contraseñas ni descripciones técnicas de tus sistemas. Por favor no las escribas en ningún formulario.</p>
    <p>Cuando usás WhatsApp o el teléfono, aplican además las condiciones de esos servicios.</p>

    <h2>Para qué los usamos</h2>
    <p>Para responderte y para preparar una propuesta si la pedís. No enviamos publicidad que no hayas solicitado y no vendemos ni compartimos tus datos con terceros con fines comerciales.</p>

    <h2>Quién los recibe</h2>
    <ul>
      <li>Nosotros, que atendemos tu consulta.</li>
      <li>Nuestro sistema de gestión de contactos (VenderCRM), donde se registra la consulta para el seguimiento.</li>
      <li>El proveedor de hosting del sitio, que almacena los datos que se guardan en el servidor.</li>
    </ul>
    <p>No los entregamos a nadie más, salvo que una autoridad competente lo exija.</p>

    <h2>Cookies y medición</h2>
    <ul>
      <li><strong>Cookie del formulario (csrf):</strong> se crea para proteger el envío del formulario y dura lo que dura tu sesión.</li>
      <li><strong>Cookie de atribución (vc_attr):</strong> si llegás desde un enlace con parámetros utm, guardamos la fuente durante un tiempo limitado para saber qué canal funcionó.</li>
      <?php if ($ga): ?>
      <li><strong>Google Analytics 4:</strong> medimos visitas y clics en WhatsApp, teléfono y formulario. Google recibe datos técnicos del navegador según sus propias condiciones.</li>
      <?php else: ?>
      <li>Por ahora no usamos herramientas de análisis de terceros en este sitio.</li>
      <?php endif; ?>
    </ul>

    <h2>Cuánto tiempo los guardamos</h2>
    <p>Guardamos los datos de consultas hasta 24 meses. Pasado ese plazo los borramos o los anonimizamos, salvo que te hayas convertido en cliente: en ese caso los conservamos mientras dure la relación y el tiempo que la ley exija.</p>

    <h2>Cómo pedir acceso, corrección o borrado</h2>
    <p>Escribinos y verificamos que sos vos antes de actuar. <?php if ($email !== ''): ?>Podés hacerlo a <a href="mailto:<?= e($email) ?>"><?= e($email) ?></a>, por <?php else: ?>Podés hacerlo por <?php endif; ?><a href="<?= e(wa('Hola, quiero pedir acceso, corrección o borrado de mis datos')) ?>" data-track="whatsapp">WhatsApp</a> o desde la <a href="/contacto">página de contacto</a>. Respondemos en un plazo razonable.</p>
    <!-- TODO(legal): specify response deadline and the data-protection contact once legal review is done. -->

    <h2>Cambios</h2>
    <p>Si cambiamos esta política, actualizamos esta página. La versión vigente es siempre la publicada acá.</p>
    <p><a href="/terminos">Términos de uso</a></p>
  </div>
</section>
<?php
page_end();
