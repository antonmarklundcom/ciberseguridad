<?php
declare(strict_types=1);
require dirname(__DIR__).'/src/render.php';
$n=0;$questions=[];$answers=[];$services=0;
function editorial_check(bool $ok,string $label):void{
 global $n;if(!$ok){fwrite(STDERR,"FAIL: $label\n");exit(1);}$n++;
}
foreach(site_pages() as $slug=>$page){
 if(!str_starts_with((string)$slug,'servicios/'))continue;
 $services++;
 $html=(string)file_get_contents(dirname(__DIR__).'/src/content/'.$slug.'.html');
 editorial_check(str_contains($page['title'],'Paraguay'),'Service title explains market: '.$slug);
 editorial_check(substr_count($html,'class="service-editorial"')===1,'One distinct editorial section: '.$slug);
 preg_match('/<section class="service-editorial".*?<\/section>/s',$html,$section);
 editorial_check(isset($section[0]),'Editorial section is server-rendered: '.$slug);
 preg_match_all('/<h3>(¿.*?)<\/h3><p>(.*?)<\/p>/su',$section[0]??'',$faqs,PREG_SET_ORDER);
 editorial_check(count($faqs)===3,'Three buyer FAQs: '.$slug);
 foreach($faqs as $faq){$questions[]=$faq[1];$answers[]=$faq[2];}
 preg_match('/<ol>(.*?)<\/ol>/s',$section[0]??'',$steps);
 editorial_check(substr_count($steps[1]??'','<li>')===3,'Three scoped buying steps: '.$slug);
 editorial_check(str_contains($html,'La plataforma no ejecuta este servicio'),'Intermediary scope retained: '.$slug);
 editorial_check(str_contains($html,'?servicio='.substr($slug,10)),'CTA preserves exact service context: '.$slug);
 editorial_check(substr_count($html,'<h1>')===1,'One H1 in source: '.$slug);
 editorial_check(str_contains($html,'Qué no es') && str_contains($html,'Autorización y alcance'),'Existing boundaries retained: '.$slug);
}
editorial_check($services===17,'All 17 existing services covered');
editorial_check(count(array_unique($questions))===51,'Questions are service-specific, not duplicated');
editorial_check(count(array_unique($answers))===51,'Answers are service-specific, not duplicated');
$provider=site_page('proveedores');
editorial_check($provider['label']==='Cómo elegir proveedor','Provider registry label renamed');
$header=render_header($provider,false);
preg_match('/<details class="services-menu".*?<\/details>/s',$header,$menu);
editorial_check(str_contains($menu[0]??'','href="/proveedores/" aria-current="page"'),'Provider link lives inside Servicios and marks current page');
$after=substr($header,(int)strpos($header,'</details>')+10);
editorial_check(!str_contains($after,'href="/proveedores/"'),'No separate provider item in main navigation');
editorial_check(substr_count($header,'aria-current="page"')===1,'Provider guide has unique current-page state');
editorial_check(str_contains(render_footer(),'href="/proveedores/">Cómo elegir proveedor'),'Footer name consistent');
$source=(string)file_get_contents(dirname(__DIR__).'/src/content/proveedores.html');
editorial_check(str_contains($source,'<h1>Cómo elegir proveedor</h1>'),'Visible provider guide renamed');
editorial_check(str_contains($source,'todavía no publicamos perfiles'),'Empty-directory status remains honest');
editorial_check(str_contains($source,'#preparar-cotizacion'),'Provider guide offers self-service outcome');
echo "PASS: $n service SEO/provider checks\n";
