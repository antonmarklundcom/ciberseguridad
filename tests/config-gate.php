<?php
declare(strict_types=1);
require dirname(__DIR__) . '/src/config.php';
cfg_load_env_file(dirname(__DIR__) . '/.env');
$cases = [
    ['disabled by default', ['LEAD_ENABLED'=>'0'], false],
    ['missing recipient identity', ['LEAD_ENABLED'=>'1', 'NOTIFY_EMAIL'=>'synthetic@example.invalid'], false],
    ['missing delivery destination', ['LEAD_ENABLED'=>'1', 'PRACTITIONER_NAME'=>'Synthetic'], false],
    ['invalid email rejected', ['LEAD_ENABLED'=>'1', 'PRACTITIONER_NAME'=>'Synthetic', 'NOTIFY_EMAIL'=>'invalid'], false],
    ['HTTP CRM rejected', ['LEAD_ENABLED'=>'1', 'PRACTITIONER_NAME'=>'Synthetic', 'VENDERCRM_URL'=>'http://crm.example.invalid', 'VENDERCRM_API_KEY'=>'synthetic'], false],
    ['malformed HTTPS CRM rejected', ['LEAD_ENABLED'=>'1', 'PRACTITIONER_NAME'=>'Synthetic', 'VENDERCRM_URL'=>'https://', 'VENDERCRM_API_KEY'=>'synthetic'], false],
    ['configured email channel accepted', ['LEAD_ENABLED'=>'1', 'PRACTITIONER_NAME'=>'Synthetic', 'NOTIFY_EMAIL'=>'synthetic@example.invalid'], true],
    ['configured HTTPS CRM accepted', ['LEAD_ENABLED'=>'1', 'PRACTITIONER_NAME'=>'Synthetic', 'VENDERCRM_URL'=>'https://crm.example.com', 'VENDERCRM_API_KEY'=>'synthetic'], true],
];
$failed=0;
foreach ($cases as [$label, $values, $expected]) {
    foreach (['LEAD_ENABLED'=>'0', 'PRACTITIONER_NAME'=>'', 'NOTIFY_EMAIL'=>'', 'VENDERCRM_URL'=>'', 'VENDERCRM_API_KEY'=>''] as $key=>$value) cfg_env_store($key, $value);
    foreach ($values as $key=>$value) cfg_env_store($key, $value);
    $ok=cfg_build()['lead_enabled']===$expected;
    echo ($ok?'PASS ':'FAIL ').$label.PHP_EOL;
    if (!$ok) $failed++;
}
// Invalid CRM is isolated: site rendering and monitored email/storage remain usable.
foreach ([
    ['VENDERCRM_URL'=>'http://crm.example.com', 'VENDERCRM_API_KEY'=>'synthetic-secret-marker'],
    ['VENDERCRM_URL'=>'https://crm.example.com', 'VENDERCRM_API_KEY'=>''],
    ['VENDERCRM_URL'=>'https://127.0.0.1', 'VENDERCRM_API_KEY'=>'synthetic-secret-marker'],
    ['VENDERCRM_URL'=>'https://crm.example.com', 'VENDERCRM_API_KEY'=>"synthetic-secret-marker\r\nheader"],
] as $badCrm) {
    foreach (['LEAD_ENABLED'=>'1', 'PRACTITIONER_NAME'=>'Synthetic', 'NOTIFY_EMAIL'=>'synthetic@example.com', 'VENDERCRM_CONFIG_FILE'=>''] + $badCrm as $key=>$value) cfg_env_store($key,$value);
    $result=cfg_build();
    $ok=$result['lead_enabled']===true && $result['vendercrm_url']==='' && $result['vendercrm_key']===''
        && $result['notify_email']==='synthetic@example.com' && $result['storage_dir']!==''
        && $result['site_url']!=='' && $result['vendercrm_config_error']!==''
        && !str_contains($result['vendercrm_config_error'],'synthetic-secret-marker');
    echo ($ok?'PASS ':'FAIL ').'invalid CRM preserves site and email/storage fallback'.PHP_EOL;
    if (!$ok) $failed++;
}
$oldUrl=getenv('VENDERCRM_URL'); $oldKey=getenv('VENDERCRM_API_KEY');
putenv('VENDERCRM_URL=https://process.example.com'); putenv('VENDERCRM_API_KEY=process-synthetic');
cfg_env_store('VENDERCRM_URL','https://store.example.com'); cfg_env_store('VENDERCRM_API_KEY','store-synthetic');
$result=cfg_build();
$ok=$result['vendercrm_url']==='https://store.example.com' && $result['vendercrm_key']==='store-synthetic';
echo ($ok?'PASS ':'FAIL ').'effective store settings override process CRM pair'.PHP_EOL;
if (!$ok) $failed++;
$oldUrl===false ? putenv('VENDERCRM_URL') : putenv('VENDERCRM_URL='.$oldUrl);
$oldKey===false ? putenv('VENDERCRM_API_KEY') : putenv('VENDERCRM_API_KEY='.$oldKey);
exit($failed ? 1 : 0);
