<?php
declare(strict_types=1);
require dirname(__DIR__).'/src/render.php';
$n=0;
function nav_check(bool $ok,string $label): void {
    global $n; if(!$ok){fwrite(STDERR,"FAIL: $label\n");exit(1);} $n++;
}
$slugs=[];
foreach(services_menu_groups() as $label=>$items) {
    nav_check($label!=='' && $items!==[],'Each group has a label and links');
    foreach($items as $slug=>$name) {
        nav_check(isset(site_pages()['servicios/'.$slug]),'Published service: '.$slug);
        nav_check($name!=='' && !isset($slugs[$slug]),'Unique labeled service: '.$slug);
        $slugs[$slug]=true;
    }
}
$registry=[];
foreach(site_pages() as $slug=>$p) if(str_starts_with((string)$slug,'servicios/'))$registry[]=substr($slug,10);
$menu=array_keys($slugs);sort($menu);sort($registry);
nav_check(count($menu)===17 && $menu===$registry,'Exact current 17 service coverage');
$html=render_header(site_page('servicios/backup-recuperacion'),false);
nav_check(str_contains($html,'<summary') && str_contains($html,'<details'),'Native no-JavaScript disclosure');
nav_check(!str_contains($html,'role="menu"'),'Site navigation uses normal links, not application menu roles');
foreach($slugs as $slug=>$_)nav_check(substr_count($html,'href="/servicios/'.$slug.'/"')===1,'Exactly one service link: '.$slug);
nav_check(str_contains($html,'href="/servicios/backup-recuperacion/" aria-current="page"'),'Current service marked');
nav_check(str_contains($html,'href="/servicios/"'),'Catalog remains accessible');
nav_check(str_contains($html,'href="/proveedores/"'),'Provider URL preserved');
nav_check(!str_contains(render_header(site_page('gracias'),true),'services-menu'),'Minimal receipt header remains minimal');
nav_check(substr_count(render_header(site_page('servicios'),false),'aria-current="page"')===1,'Catalog current state is unique');
echo "PASS: $n navigation structure checks\n";
