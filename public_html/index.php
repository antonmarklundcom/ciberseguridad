<?php
require dirname(__DIR__) . '/src/render.php';
page_start('');
echo file_get_contents(dirname(__DIR__) . '/src/content/home.html');
page_end(['schema'=>[organization_ld(), website_ld()]]);
