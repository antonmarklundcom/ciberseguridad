<?php
declare(strict_types=1);
require dirname(__DIR__, 2) . '/src/render.php';
page_start('recursos/preparar-hoja-contactos-incidentes');
echo file_get_contents(__DIR__ . '/../../src/content/recursos/preparar-hoja-contactos-incidentes.html');
page_end();
