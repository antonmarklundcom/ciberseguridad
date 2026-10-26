<?php
declare(strict_types=1);
require dirname(__DIR__) . '/src/render.php';
$checks=0;
function verify(bool $ok, string $message): void {
    global $checks;
    if (!$ok) { fwrite(STDERR, "FAIL: $message\n"); exit(1); }
    $checks++;
}
$pages=site_pages();
$actual=[];
foreach ($pages as $slug=>$p) if ($p['index']) $actual[]=page_path((string)$slug);
$expected=json_decode((string)file_get_contents(__DIR__.'/published-urls.json'),true);
sort($actual); sort($expected);
verify(count($actual)===39 && $actual===$expected,'Exact 39 published URL paths preserved');
$all=buyer_journeys();
verify(count($all)===17,'All 17 services have buying guidance');
$guides=[];
foreach ($all as $service=>$data) {
    verify(isset($pages['servicios/'.$service]),'Service exists: '.$service);
    $context=buyer_context('servicios/'.$service);
    verify(str_contains($context,e($data['acceptance'])),'Tailored acceptance criteria: '.$service);
    verify(str_contains($context,'Ejemplo orientativo'),'Examples are labeled as illustrative: '.$service);
    foreach ($data['guides'] as $guide) {
        $guides[$guide]=true;
        verify(isset($pages['recursos/'.$guide]),'Guide exists: '.$guide);
        verify(str_contains($context,'href="/recursos/'.$guide.'/"'),'Service links to guide: '.$service);
        verify(str_contains(buyer_context('recursos/'.$guide),'href="/servicios/'.$service.'/"'),'Guide links back: '.$guide);
    }
}
verify(count($guides)===7,'All seven guides are connected');
foreach ($guides as $guide=>$_) {
    $slug='recursos/'.$guide;
    $context=orientation_service($slug);
    verify(isset($all[$context]) && in_array($guide,$all[$context]['guides'],true),'Primary service relates to guide: '.$guide);
    $source=(string)file_get_contents(dirname(__DIR__).'/src/content/'.$slug.'.html');
    verify(substr_count($source,'href="'.orientation_path($slug).'"')===2,'Hero and sidebar preserve primary service: '.$guide);
    verify(str_contains($source,'Revisión técnica pendiente'),'No fabricated review: '.$guide);
    verify(str_contains($source,'<dd>'.$pages[$slug]['modified_at'].'</dd>'),'Visible and structured modification dates agree: '.$guide);
    verify(str_contains($source,'<caption>') && str_contains($source,'scope="row"'),'Accessible worksheet: '.$guide);
}
verify(orientation_path('unknown')==='/encontra-un-proveedor/','Unknown pages get general guidance');
verify(buyer_context('contacto')==='','No unrelated blocks on contact');
$_GET=['servicio'=>'backup-recuperacion'];
$html=layout(site_page('encontra-un-proveedor'),'<h1>Test</h1>');
verify(str_contains($html,'data-service="backup-recuperacion"'),'Known form service context is preserved');
$_GET=['servicio'=>'forged-secret'];
$html=layout(site_page('encontra-un-proveedor'),'<h1>Test</h1>');
verify(!str_contains($html,'forged-secret'),'Unknown query is not reflected as analytics context');
$_GET=['servicio'=>['array']];
verify(!str_contains(layout(site_page('encontra-un-proveedor'),'<h1>Test</h1>'),'data-service='),'Array query is ignored safely');
echo "PASS: $checks buyer journey and URL checks\n";
