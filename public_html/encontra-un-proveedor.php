<?php
require dirname(__DIR__) . '/src/render.php';
require_once dirname(__DIR__) . '/src/form-handler.php';
csrf_token();
page_start('encontra-un-proveedor');
?>
<section class="page-hero"><div class="shell narrow"><p class="eyebrow">Orientación para empresas</p><h1>Definí tu próximo paso.</h1><p class="lede">Compartí solo el contexto de tu empresa y tu contacto. El formulario no hace un diagnóstico ni confirma disponibilidad de un especialista.</p><a class="text-link" href="/incidente/">¿Hay un incidente en curso? Ver canal oficial →</a></div></section>
<section class="section"><div class="shell form-layout"><div class="form-intro"><p class="eyebrow">Contexto, no secretos</p><h2>Una solicitud más simple.</h2><p>No hace falta que sepas qué servicio contratar.</p><ol><li>Seleccioná el tipo y tamaño de empresa.</li><li>Elegí la necesidad más cercana a la tuya.</li><li>Dejá un contacto para la primera conversación.</li></ol><div class="safety-warning" role="note"><strong>No envíes contraseñas, tokens ni datos técnicos.</strong><span>No aceptamos archivos, dominios, direcciones IP ni relatos de incidentes.</span></div><p>Hoy no hay proveedores verificados publicados. Si no hay un contacto disponible, las guías te permiten preparar una búsqueda por tu cuenta.</p><a class="text-link" href="/metodologia-verificacion/">Cómo verificamos →</a></div><div><?php $page='encontra-un-proveedor'; require dirname(__DIR__) . '/src/partials/orientation-form.php'; ?></div></div></section>
<?php page_end(); ?>
