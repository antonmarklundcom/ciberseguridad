<?php
declare(strict_types=1);
require dirname(__DIR__, 2) . '/src/render.php';

page_start('para/pymes');
echo breadcrumbs('para/pymes');
?>
<section class="hero">
  <div class="wrap">
    <p class="eyebrow">Para PYMES</p>
    <h1>Ciberseguridad para PYMES en Paraguay: por dónde empezar</h1>
    <p class="lead">Lo que una empresa pequeña o mediana necesita de verdad, sin humo y sin gastar de más. Empezá con la autoevaluación gratuita: son unos minutos y no dejás ningún dato.</p>
    <div class="btn-row">
      <a class="btn btn--primary" href="/recursos/autoevaluacion">Hacer la autoevaluación gratis</a>
    </div>
  </div>
</section>

<section class="section section--alt reveal">
  <div class="wrap narrow prose">
    <h2>Lo que una PYME necesita y lo que le venden</h2>
    <p>A las empresas chicas les ofrecen de todo: paquetes de herramientas, suscripciones y certificaciones. Casi nada de eso es lo primero que hace falta. Los incidentes que más daño hacen a una empresa de este tamaño suelen entrar por lo básico.</p>
    <h3>La postura mínima</h3>
    <ul class="checks">
      <li><strong>Segundo factor de autenticación</strong> en el correo y en los sistemas críticos.</li>
      <li><strong>Copias de seguridad que se probaron restaurar</strong>, y que no se pueden borrar desde la misma red.</li>
      <li><strong>Actualizaciones al día</strong> en computadoras, routers y sistemas.</li>
      <li><strong>Un proceso para cambios de cuenta bancaria:</strong> cualquier cambio se confirma por otro canal, siempre.</li>
      <li><strong>Una lista escrita de a quién llamar</strong> si mañana no arranca nada. Podés imprimir la <a href="/recursos/checklist-de-incidentes">hoja de contactos</a>.</li>
    </ul>
    <h3>Un orden razonable para el primer mes</h3>
    <p>Si no sabés por dónde arrancar, este orden funciona para casi cualquier empresa chica, y no requiere comprar nada:</p>
    <ol>
      <li><strong>Semana uno:</strong> activá el segundo factor en el correo del dueño y de quien maneja los pagos. Es la mejora que más riesgo baja por el menor esfuerzo.</li>
      <li><strong>Semana dos:</strong> restaurá una copia de seguridad en otra computadora y comprobá que los archivos abren. Si nunca lo hiciste, es probable que descubras algo.</li>
      <li><strong>Semana tres:</strong> escribí la regla de cambio de cuentas bancarias y comunicásela a quien paga: ningún cambio sin confirmar por otro canal.</li>
      <li><strong>Semana cuatro:</strong> completá la lista de contactos de emergencia y dejala impresa donde todos la vean.</li>
    </ol>
    <p>Con eso hecho, un diagnóstico rinde mucho más: en vez de descubrir lo básico, se dedica a lo que de verdad hay que decidir.</p>
    <h3>Qué no conviene comprar todavía</h3>
    <p>Un software de monitoreo continuo sin nadie que mire las alertas, una póliza de riesgo cibernético sin conocer sus exclusiones, o una certificación cuando nadie te la pidió. Primero lo básico, medido, y después lo demás.</p>
  </div>
</section>

<section class="section reveal">
  <div class="wrap">
    <h2>Seguí por tu rubro o tu situación</h2>
    <div class="cards cards--3">
      <a class="card" href="/para/clinicas"><h3>Clínicas y consultorios</h3><p>Continuidad de la atención e historias clínicas.</p></a>
      <a class="card" href="/para/contadores"><h3>Estudios contables</h3><p>Datos de clientes concentrados en una oficina.</p></a>
      <a class="card" href="/para/ecommerce"><h3>Tiendas online</h3><p>Checkout, panel y datos de clientes.</p></a>
    </div>
    <div class="cards cards--3">
      <a class="card" href="/servicios/diagnostico"><h3>Queremos saber cómo estamos</h3><p>Diagnóstico de seguridad.</p></a>
      <a class="card" href="/servicios/cuestionarios-de-proveedores"><h3>Un cliente nos pidió un cuestionario</h3><p>Cuestionarios de proveedores.</p></a>
      <a class="card" href="/servicios/respuesta-a-incidentes"><h3>Nos atacaron</h3><p>Respuesta a incidentes.</p></a>
    </div>
  </div>
</section>

<section class="section section--alt reveal">
  <div class="wrap narrow prose">
    <h2>Primero, autoevaluate</h2>
    <p>La <a href="/recursos/autoevaluacion">autoevaluación</a> te lleva unos minutos y te muestra el resultado completo, sin pedirte datos. Cubre siete áreas y te dice dónde están tus brechas declaradas. No es una auditoría y un puntaje alto no significa que tu empresa esté a salvo, pero te da un punto de partida ordenado para conversar.</p>
    <div class="btn-row"><a class="btn btn--primary" href="/recursos/autoevaluacion">Hacer la autoevaluación gratis</a></div>
  </div>
</section>
<?php
page_end([
    'schema' => [service_ld('para/pymes', 'Ciberseguridad para PYMES', 'Guía de la postura mínima para empresas pequeñas y medianas, con rutas a los servicios y a la autoevaluación gratuita.', 'PYMES')],
    'service' => 'pymes',
]);
