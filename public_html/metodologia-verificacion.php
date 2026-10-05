<?php
declare(strict_types=1);
require dirname(__DIR__, 1) . '/src/render.php';
page_start('metodologia-verificacion');
echo file_get_contents(__DIR__ . '/../src/content/metodologia-verificacion.html');
page_end();
