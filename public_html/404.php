<?php
http_response_code(404);
require dirname(__DIR__) . '/src/render.php';
page_start('404'); ?>
<section class="page-hero"><div class="shell narrow"><p class="eyebrow">404</p><h1>No encontramos esa página.</h1><p>Podés volver al inicio o explorar los servicios y sus alcances.</p><a class="button" href="/">Volver al inicio ↗</a></div></section>
<?php page_end(); ?>
