<?php
declare(strict_types=1);
require dirname(__DIR__, 1) . '/src/render.php';
page_start('nosotros');
echo file_get_contents(__DIR__ . '/../src/content/nosotros.html');
page_end();
