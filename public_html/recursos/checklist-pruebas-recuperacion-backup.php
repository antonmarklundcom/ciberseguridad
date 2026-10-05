<?php
declare(strict_types=1);
require dirname(__DIR__, 2) . '/src/render.php';
page_start('recursos/checklist-pruebas-recuperacion-backup');
echo file_get_contents(__DIR__ . '/../../src/content/recursos/checklist-pruebas-recuperacion-backup.html');
page_end();
