<?php
declare(strict_types=1);
require dirname(__DIR__, 2) . '/src/render.php';
page_start('servicios/preparacion-recuperacion-ransomware');
echo file_get_contents(__DIR__ . '/../../src/content/servicios/preparacion-recuperacion-ransomware.html');
page_end();
