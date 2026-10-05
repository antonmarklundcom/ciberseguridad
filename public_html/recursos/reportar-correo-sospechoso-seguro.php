<?php
declare(strict_types=1);
require dirname(__DIR__, 2) . '/src/render.php';
page_start('recursos/reportar-correo-sospechoso-seguro');
echo file_get_contents(__DIR__ . '/../../src/content/recursos/reportar-correo-sospechoso-seguro.html');
page_end();
