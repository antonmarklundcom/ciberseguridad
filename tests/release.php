<?php
declare(strict_types=1);
// Local/offline release checks. No installation, production configuration changes or network.
$root=dirname(__DIR__);
putenv('PATH='.dirname(PHP_BINARY).PATH_SEPARATOR.(getenv('PATH') ?: ''));
$files=[];
foreach (['src','lib','bin','public_html','tests'] as $dir) {
    $it=new RecursiveIteratorIterator(new RecursiveDirectoryIterator($root.'/'.$dir,FilesystemIterator::SKIP_DOTS));
    foreach ($it as $file) if ($file->isFile() && $file->getExtension()==='php') $files[]=$file->getPathname();
}
foreach ($files as $file) {
    exec(escapeshellarg(PHP_BINARY).' -l '.escapeshellarg($file).' 2>&1',$out,$code);
    if ($code!==0) { echo implode("\n",$out)."\n"; exit($code); }
    $out=[];
}
echo 'PASS: '.count($files)." PHP syntax checks\n";
foreach (['run','orientation','config-gate','crm-config-fallback','lead-delivery','buyer-journey','navigation','service-seo','seo-check'] as $suite) {
    passthru(escapeshellarg(PHP_BINARY).' '.escapeshellarg(__DIR__.'/'.$suite.'.php'),$code);
    if ($code!==0) exit($code);
}
echo "PASS: all offline PHP release suites\n";
