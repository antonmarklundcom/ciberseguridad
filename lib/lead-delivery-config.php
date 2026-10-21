<?php
declare(strict_types=1);
require_once __DIR__ . '/lead-delivery.php';
$webRoot = dirname(__DIR__) . '/public_html';
require_once dirname(__DIR__) . '/src/config.php';
$config = ['url'=>cfg('vendercrm_url'), 'api_key'=>cfg('vendercrm_key')];
$config['site_domain'] = 'ciberseguridad.com.py';
$config['outbox_dir'] = getenv('VENDERCRM_OUTBOX_DIR') ?: rtrim((string)cfg('storage_dir'), '/\\') . '/.delivery-outbox';
return new VenderCrmDelivery($config, $webRoot);
