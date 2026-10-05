<?php
declare(strict_types=1);
require dirname(__DIR__, 2) . '/src/render.php';
page_start('servicios/respuesta-incidentes');
echo file_get_contents(__DIR__ . '/../../src/content/servicios/respuesta-incidentes.html');
page_end();
