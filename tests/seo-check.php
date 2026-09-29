<?php
declare(strict_types=1);
/**
 * SEO + content guard rails (Block D / F3). No network, no server.
 *   php tests/seo-check.php
 * Renders every page in-process and checks metadata, H1, JSON-LD, inline
 * script/style (CSP), sitemap parity and fabrication-risk words.
 */
require dirname(__DIR__) . '/src/render.php';

$fail = 0;
function bad(string $m): void { global $fail; $fail++; echo "FAIL  $m\n"; }
function ok(string $m): void { echo "ok    $m\n"; }

$pages = site_pages();
$titles = [];
$descs = [];
foreach ($pages as $slug => $p) {
    $slug = (string) $slug;
    $label = '/' . $slug;
    $tl = mb_strlen($p['title']);
    $dl = mb_strlen($p['desc']);
    if ($tl > 60) bad("$label title $tl > 60");
    if ($dl < 120 || $dl > 155) bad("$label description $dl not in 120-155");
    if (isset($titles[$p['title']])) bad("$label duplicate title");
    if (isset($descs[$p['desc']])) bad("$label duplicate description");
    $titles[$p['title']] = $descs[$p['desc']] = true;
}
ok(count($pages) . ' registry entries checked for title/description');

// Render each page through PHP CLI so notices surface.
$forbidden = '/garantiz|100\s?%|\bseguro\b|\bprotegid|certificad|\d\s?%|\d\s?\+|\d+\s+a[nñ]os|\d+\s+(clientes|empresas)\b/iu';
$falsePositive = '/(no significa que[^.]*seguro|no garantiz\w*|nos garantizan|no asegura[^.]*seguro|ni garantiz\w*)/iu';
$tuForms = '/\b(tú|tienes|puedes|quieres|contáctanos|escríbenos|necesitas|sabes|eres|haz clic tú)\b/iu';

foreach ($pages as $slug => $p) {
    $slug = (string) $slug;
    $file = PUBLIC_DIR . '/' . ($slug === '' ? 'index' : $slug) . '.php';
    if (!is_file($file)) { bad("missing file for /$slug"); continue; }
    $cmd = 'php -d display_errors=1 -d error_reporting=-1 ' . escapeshellarg($file) . ' 2>&1';
    $out = (string) shell_exec($cmd);
    $lab = '/' . $slug;
    if (preg_match('/(Notice|Warning|Deprecated|Fatal error|Parse error)/', $out)) { bad("$lab PHP diagnostics: " . substr(strip_tags($out), 0, 200)); continue; }
    if (preg_match_all('/<h1[\s>]/i', $out) !== 1) bad("$lab needs exactly one h1");
    if (!str_contains($out, '<link rel="canonical" href="' . site_url('/' . $slug) . '">')
        && !($slug === '' && str_contains($out, 'rel="canonical" href="' . site_url('/') . '"'))) bad("$lab canonical");
    if (preg_match('/<script(?![^>]*\bsrc=)(?![^>]*application\/ld\+json)[^>]*>/i', $out)) bad("$lab inline script");
    if (preg_match('/\sstyle=|<style/i', $out)) bad("$lab inline style (CSP)");
    if (preg_match('/aggregateRating|"review"/i', $out)) bad("$lab aggregateRating/review in output");
    if (preg_match_all('#<script type="application/ld\+json">(.*?)</script>#s', $out, $m)) {
        foreach ($m[1] as $j) {
            if (json_decode(html_entity_decode($j), true) === null) bad("$lab invalid JSON-LD");
        }
    } elseif ($slug !== '404' && $slug !== 'gracias') {
        bad("$lab has no JSON-LD");
    }
    $text = strip_tags(preg_replace('#<(script|style)\b.*?</\1>#si', '', $out));
    $clean = preg_replace($falsePositive, '', $text);
    if (preg_match($forbidden, (string) $clean, $mm)) bad("$lab fabrication-risk word: " . $mm[0]);
    if (preg_match($tuForms, $text, $mm)) bad("$lab tú-form: " . $mm[0]);
    if (preg_match('/href="\/[^"#?]*\.php/', $out)) bad("$lab links to a .php URL");
    // Word count on content pages
    if (in_array($p['group'], ['servicios', 'para'], true)) {
        $w = str_word_count(preg_replace('/\s+/', ' ', $text), 0, 'áéíóúñÁÉÍÓÚÑüÜ');
        echo "      /$slug ~$w words\n";
    }
}

// Internal link targets exist.
foreach ($pages as $slug => $p) {
    $slug = (string) $slug;
    $file = PUBLIC_DIR . '/' . ($slug === '' ? 'index' : $slug) . '.php';
    $out = (string) shell_exec('php ' . escapeshellarg($file) . ' 2>&1');
    preg_match_all('/href="(\/[^"#?]*)/', $out, $m);
    foreach (array_unique($m[1]) as $href) {
        $s = trim($href, '/');
        if ($href === '/' || isset($pages[$s]) || is_file(PUBLIC_DIR . $href) || $s === 'enviar') continue;
        bad("/$slug links to missing $href");
    }
}

// Sitemap parity.
$sm = @file_get_contents(PUBLIC_DIR . '/sitemap.xml') ?: '';
foreach ($pages as $slug => $p) {
    $loc = '<loc>' . site_url($slug === '' ? '/' : '/' . $slug) . '</loc>';
    if ($p['index'] && !str_contains($sm, $loc)) bad("sitemap missing /$slug");
    if (!$p['index'] && str_contains($sm, $loc)) bad("sitemap must not contain /$slug");
}

echo $fail === 0 ? "\nSEO check: all good\n" : "\nSEO check: $fail failure(s)\n";
exit($fail === 0 ? 0 : 1);
