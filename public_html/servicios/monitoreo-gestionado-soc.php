<?php
declare(strict_types=1);
require dirname(__DIR__, 2) . '/src/render.php';
page_start('servicios/monitoreo-gestionado-soc');
echo file_get_contents(__DIR__ . '/../../src/content/servicios/monitoreo-gestionado-soc.html');
page_end();
