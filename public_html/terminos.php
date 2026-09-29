<?php
declare(strict_types=1);
require dirname(__DIR__) . '/src/render.php';

page_start('terminos');
echo breadcrumbs('terminos');
?>
<section class="hero">
  <div class="wrap narrow">
    <h1>Términos de uso</h1>
    <p class="lead">Las condiciones para usar este sitio y sus herramientas gratuitas, y lo que no hacemos sin autorización.</p>
    <p class="note">Versión preliminar, pendiente de revisión legal.</p>
  </div>
</section>
<!-- TODO(legal): the visible note above is intentional until a lawyer signs off. Remove it then. -->

<section class="section">
  <div class="wrap narrow prose">
    <h2>Qué es este sitio</h2>
    <p>Es el sitio de <?= e(cfg('brand')) ?>, un servicio de consultoría en seguridad informática para empresas en Paraguay. El contenido es informativo y general.</p>

    <h2>Las herramientas gratuitas</h2>
    <p>La <a href="/recursos/autoevaluacion">autoevaluación</a> y el <a href="/recursos/checklist-de-incidentes">checklist de incidentes</a> dan orientación general. No son una auditoría, un peritaje ni asesoramiento legal, y no reemplazan una evaluación técnica de tu empresa.</p>
    <p><strong>Un puntaje alto no significa que tu empresa esté segura.</strong> El resultado se basa únicamente en lo que vos declaraste.</p>

    <h2>Lo que nuestras herramientas no hacen</h2>
    <p>Ninguna herramienta ni página de este sitio se conecta a servidores, dominios o sistemas tuyos ni de terceros. No escaneamos nada. Trabajamos sobre lo que vos nos contás.</p>

    <h2>Sin autorización no hay acceso</h2>
    <p>No accedemos, probamos ni escaneamos sistemas sin autorización escrita de quien tiene control sobre ellos. Si un trabajo lo requiere, se define en una propuesta firmada.</p>

    <h2>Sin promesas de resultado</h2>
    <p>No garantizamos que una empresa quede libre de incidentes, que se recuperen archivos tras un ataque ni que un tercero apruebe un cuestionario. Describimos el trabajo y los entregables; el resultado depende de factores que no controlamos.</p>

    <h2>Contratación de servicios</h2>
    <p>Los servicios se contratan por escrito, con alcance, plazos y precio. Lo que dice una página del sitio orienta, pero manda la propuesta firmada.</p>

    <h2>Uso del sitio</h2>
    <p>Podés navegar y usar las herramientas para tu propia empresa. No intentes sobrecargar o vulnerar el sitio. Si encontrás una falla de seguridad, avisanos desde la <a href="/contacto">página de contacto</a> o por el contacto de <a href="/.well-known/security.txt">security.txt</a>, y no la aproveches.</p>

    <h2>Datos personales</h2>
    <p>Cómo tratamos tus datos está en la <a href="/politica-de-privacidad">política de privacidad</a>.</p>

    <h2>Ley aplicable</h2>
    <p>Estos términos se rigen por las leyes de la República del Paraguay. <!-- TODO(legal): jurisdicción y foro. --></p>
  </div>
</section>
<?php
page_end();
