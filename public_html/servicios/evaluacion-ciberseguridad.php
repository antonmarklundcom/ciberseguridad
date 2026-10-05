<?php
declare(strict_types=1);
require dirname(__DIR__, 2) . '/src/render.php';
page_start('servicios/evaluacion-ciberseguridad');
echo file_get_contents(__DIR__ . '/../../src/content/servicios/evaluacion-ciberseguridad.html');
page_end();
