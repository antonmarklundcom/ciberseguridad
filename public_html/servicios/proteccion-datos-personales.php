<?php
declare(strict_types=1);
require dirname(__DIR__, 2) . '/src/render.php';
page_start('servicios/proteccion-datos-personales');
echo file_get_contents(__DIR__ . '/../../src/content/servicios/proteccion-datos-personales.html');
page_end();
