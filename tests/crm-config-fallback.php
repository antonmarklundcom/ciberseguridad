<?php
declare(strict_types=1);
require dirname(__DIR__) . '/src/form-handler.php';
cfg_load_env_file(dirname(__DIR__) . '/.env');
$tmp=sys_get_temp_dir().'/crm-fallback-'.bin2hex(random_bytes(6));
mkdir($tmp,0770,true);
foreach (['STORAGE_DIR'=>$tmp,'LEAD_ENABLED'=>'1','PRACTITIONER_NAME'=>'Synthetic recipient','VENDERCRM_URL'=>'http://crm.example.com','VENDERCRM_API_KEY'=>'never-output-synthetic-key','VENDERCRM_CONFIG_FILE'=>'','NOTIFY_EMAIL'=>'synthetic@example.com','SITE_URL'=>'https://ciberseguridad.com.py'] as $key=>$value) cfg_env_store($key,$value);
$post=['form_type'=>'orientacion','page'=>'servicios/backup-recuperacion','ts'=>(string)(time()-30),'csrf'=>str_repeat('a',64),'nombre'=>'Persona Sintética','telefono'=>'0981 123 456','rubro'=>'comercio','empleados'=>'1-9','disparador'=>'backup','consent'=>'1','email'=>'synthetic@example.com','website'=>''];
$pushes=0;$notifications=0;
$result=handle_submission($post,['REQUEST_METHOD'=>'POST','REMOTE_ADDR'=>'127.0.0.1'],['csrf'=>str_repeat('a',64)],
    function()use(&$pushes):array{$pushes++;throw new RuntimeException('network must never be used');},
    function()use(&$notifications):void{$notifications++;});
$log=is_file($tmp.'/form.log')?file_get_contents($tmp.'/form.log'):'';
$ok=$result['action']==='redirect' && $pushes===0 && $notifications===1 && is_file(leads_file())
    && cfg('vendercrm_url')==='' && cfg('vendercrm_key')==='' && cfg('lead_enabled')===true
    && !str_contains($log,'never-output-synthetic-key');
echo ($ok?'PASS ':'FAIL ').'invalid CRM preserves recorded consented request and notification fallback without transport'.PHP_EOL;
foreach (glob($tmp.'/ratelimit/*')?:[] as $file) unlink($file);
if(is_dir($tmp.'/ratelimit'))rmdir($tmp.'/ratelimit');
foreach(glob($tmp.'/*')?:[] as $file)if(is_file($file))unlink($file);
rmdir($tmp);
exit($ok?0:1);
