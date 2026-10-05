<?php
declare(strict_types=1);
require dirname(__DIR__, 2) . '/src/render.php';
page_start('recursos/autorizacion-alcance-pruebas-seguridad');
echo file_get_contents(__DIR__ . '/../../src/content/recursos/autorizacion-alcance-pruebas-seguridad.html');
page_end();
