<?php
declare(strict_types=1);
require dirname(__DIR__, 2) . '/src/render.php';
page_start('recursos/que-significa-certificacion-iso-27001');
echo file_get_contents(__DIR__ . '/../../src/content/recursos/que-significa-certificacion-iso-27001.html');
page_end();
