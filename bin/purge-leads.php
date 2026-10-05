<?php
declare(strict_types=1);
if (PHP_SAPI !== 'cli') { http_response_code(404); exit; }
require dirname(__DIR__) . '/src/form-handler.php';
try { echo 'Removed rows: ' . leads_prune() . PHP_EOL; }
catch (Throwable $e) { fwrite(STDERR, "Private lead cleanup failed. Check storage permissions.\n"); exit(1); }
