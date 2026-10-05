<?php
declare(strict_types=1);
require dirname(__DIR__, 1) . '/src/render.php';
page_start('reclamar-perfil');
echo file_get_contents(__DIR__ . '/../src/content/reclamar-perfil.html');
page_end();
