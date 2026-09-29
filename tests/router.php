<?php
/**
 * Router for the built-in server: emulates .htaccess extensionless URLs.
 *   php -S 127.0.0.1:8899 -t public_html tests/router.php
 */
$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$root = dirname(__DIR__) . '/public_html';
if ($path !== '/' && is_file($root . $path)) {
    return false;
}
if ($path === '/') {
    require $root . '/index.php';
    return true;
}
$file = $root . rtrim($path, '/') . '.php';
if (is_file($file)) {
    require $file;
    return true;
}
require $root . '/404.php';
return true;
