<?php
require dirname(__DIR__) . '/src/render.php';
require_once dirname(__DIR__) . '/src/form-handler.php';
csrf_token();
page_start('contacto');
?>
<section class="page-hero"><div class="shell narrow"><p class="eyebrow">Contacto general</p><h1>Hablemos de la plataforma.</h1><p class="lede">Para consultas comerciales, editoriales, correcciones o privacidad. Elegí “Consulta general / editorial / privacidad” en el formulario.</p><a class="text-link" href="/incidente/">¿Hay un incidente en curso? Ver canal oficial →</a></div></section>
<section class="section"><div class="shell form-layout"><div class="form-intro"><p class="eyebrow">Contexto, no secretos</p><h2>Una solicitud más simple.</h2><p>No hace falta que sepas qué servicio contratar.</p><ol><li>Seleccioná el tipo y tamaño de empresa.</li><li>Elegí la necesidad más cercana a la tuya.</li><li>Dejá un contacto para la primera conversación.</li></ol><div class="safety-warning" role="note"><strong>No envíes contraseñas, tokens ni datos técnicos.</strong><span>No aceptamos archivos, dominios, direcciones IP ni relatos de incidentes.</span></div><p>Hoy no hay proveedores verificados publicados. Si no hay un contacto disponible, las guías te permiten preparar una búsqueda por tu cuenta.</p><a class="text-link" href="/metodologia-verificacion/">Cómo verificamos →</a></div><div><?php $page='contacto'; require dirname(__DIR__) . '/src/partials/orientation-form.php'; ?></div></div></section>
<?php page_end(); ?>
