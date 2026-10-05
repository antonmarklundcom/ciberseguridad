<?php
declare(strict_types=1);
require dirname(__DIR__, 2) . '/src/render.php';
page_start('servicios/politicas-gobernanza-seguridad');
echo file_get_contents(__DIR__ . '/../../src/content/servicios/politicas-gobernanza-seguridad.html');
page_end();
