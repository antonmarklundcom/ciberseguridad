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
    ['configured HTTPS CRM accepted', ['LEAD_ENABLED'=>'1', 'PRACTITIONER_NAME'=>'Synthetic', 'VENDERCRM_URL'=>'https://crm.example.invalid', 'VENDERCRM_API_KEY'=>'synthetic'], true],
];
$failed=0;
foreach ($cases as [$label, $values, $expected]) {
    foreach (['LEAD_ENABLED'=>'0', 'PRACTITIONER_NAME'=>'', 'NOTIFY_EMAIL'=>'', 'VENDERCRM_URL'=>'', 'VENDERCRM_API_KEY'=>''] as $key=>$value) cfg_env_store($key, $value);
    foreach ($values as $key=>$value) cfg_env_store($key, $value);
    $ok=cfg_build()['lead_enabled']===$expected;
    echo ($ok?'PASS ':'FAIL ').$label.PHP_EOL;
    if (!$ok) $failed++;
}
exit($failed ? 1 : 0);
