<?php
declare(strict_types=1);
/**
 * Regenerates public_html/sitemap.xml from the page registry (src/pages.php).
 * Indexable pages only: /gracias and /404 are excluded. No <lastmod>: we do not
 * invent dates. Run: php bin/build-sitemap.php
 */
require dirname(__DIR__) . '/src/render.php';

$xml = '<?xml version="1.0" encoding="UTF-8"?>' . "\n"
     . '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\n";
foreach (site_pages() as $slug => $p) {
    if (!$p['index']) {
        continue;
    }
    $xml .= "  <url><loc>" . htmlspecialchars(site_url($slug === '' ? '/' : page_path($slug)), ENT_XML1) . "</loc>"
          . "<priority>{$p['prio']}</priority></url>\n";
}
$xml .= "</urlset>\n";
file_put_contents(PUBLIC_DIR . '/sitemap.xml', $xml);
echo "wrote " . PUBLIC_DIR . "/sitemap.xml\n";
