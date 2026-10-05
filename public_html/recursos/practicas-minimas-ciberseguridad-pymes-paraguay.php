<?php
declare(strict_types=1);
require dirname(__DIR__, 2) . '/src/render.php';
page_start('recursos/practicas-minimas-ciberseguridad-pymes-paraguay');
echo file_get_contents(__DIR__ . '/../../src/content/recursos/practicas-minimas-ciberseguridad-pymes-paraguay.html');
page_end();
