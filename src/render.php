<?php
declare(strict_types=1);

/**
 * A5 — layout shell and helpers.
 *
 * Every page does:
 *
 *     require dirname(__DIR__) . '/src/render.php';   // (../../ for subfolders)
 *     page_start('servicios/diagnostico');
 *     ?> ...HTML with exactly one <h1>... <?php
 *     page_end(['schema' => [...], 'faqs' => $faqs]);
 *
 * Rules enforced here rather than remembered on every page:
 * - one H1 per page (warning if not),
 * - every printed value goes through e(),
 * - no inline <script>/<style>: the CSP has no 'unsafe-inline'.
 */

require_once __DIR__ . '/config.php';
require_once __DIR__ . '/pages.php';

const PUBLIC_DIR = __DIR__ . '/../public_html';

function e(mixed $v): string
{
    return htmlspecialchars((string) $v, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

function site_url(string $path = ''): string
{
    return (string) cfg('site_url') . $path;
}

/** wa.me deep link with a URL-encoded, page-specific prefill. */
function wa(string $text): string
{
    return 'https://wa.me/' . cfg('wa_number') . '?text=' . rawurlencode($text);
}

function tel_href(): string
{
    return 'tel:' . cfg('phone_e164');
}

/** Cache-busted asset URL. */
function asset(string $path): string
{
    $file = PUBLIC_DIR . $path;
    $v = is_file($file) ? (string) filemtime($file) : '0';
    return $path . '?v=' . $v;
}

/**
 * Single source for the NAP block. The footer, /contacto and the JSON-LD all
 * read this, so they cannot drift apart. Street address is deliberately absent
 * (STEP0_RECON.md §7.2: no street address until one really exists).
 */
function nap(): array
{
    return [
        'name'     => (string) cfg('brand'),
        'locality' => 'Asunción',
        'country'  => 'Paraguay',
        'phone'    => (string) cfg('phone_display'),
        'e164'     => (string) cfg('phone_e164'),
        'email'    => (string) cfg('contact_email'),
    ];
}

function nap_html(): string
{
    $n = nap();
    $h  = '<address class="nap">';
    $h .= '<strong>' . e($n['name']) . '</strong><br>';
    $h .= e($n['locality']) . ', ' . e($n['country']) . '<br>';
    $h .= '<a href="tel:' . e($n['e164']) . '">' . e($n['phone']) . '</a>';
    if ($n['email'] !== '') {
        $h .= '<br><a href="mailto:' . e($n['email']) . '">' . e($n['email']) . '</a>';
    }
    return $h . '</address>';
}

// ---------------------------------------------------------------------------
// JSON-LD
// ---------------------------------------------------------------------------

/** Encode one JSON-LD document as a <script> block. Safe inside HTML. */
function jsonld(array $data): string
{
    $json = json_encode(
        ['@context' => 'https://schema.org'] + $data,
        JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_HEX_TAG | JSON_HEX_AMP | JSON_THROW_ON_ERROR
    );
    return '<script type="application/ld+json">' . $json . '</script>';
}

/**
 * Organization (not LocalBusiness), built only from facts in config.
 * No aggregateRating, no review, no foundingDate, no sameAs until real.
 */
function organization_ld(): array
{
    $n = nap();
    $org = [
        '@type'    => 'Organization',
        '@id'      => site_url('/#organization'),
        'name'     => $n['name'],
        'url'      => site_url('/'),
        'areaServed' => ['@type' => 'Country', 'name' => 'Paraguay'],
    ];
    if ($n['email'] !== '') {
        $org['email'] = $n['email'];
    }
    if ($n['e164'] !== '') {
        $org['telephone'] = $n['e164'];
    }
    return $org;
}

function website_ld(): array
{
    return [
        '@type' => 'WebSite',
        '@id'   => site_url('/#website'),
        'url'   => site_url('/'),
        'name'  => (string) cfg('brand'),
        'inLanguage' => 'es-PY',
        'publisher' => ['@id' => site_url('/#organization')],
    ];
}

function service_ld(string $slug, string $name, string $description, ?string $audience = null): array
{
    $svc = [
        '@type' => 'Service',
        'name'  => $name,
        'description' => $description,
        'url'   => site_url(page_path($slug)),
        'provider' => ['@id' => site_url('/#organization')],
        'areaServed' => ['@type' => 'Country', 'name' => 'Paraguay'],
    ];
    if ($audience !== null) {
        $svc['audience'] = ['@type' => 'BusinessAudience', 'audienceType' => $audience];
    }
    return $svc;
}

/** @param array<int,array{0:string,1:string}> $faqs [question, answer] plain text */
function faq_ld(array $faqs): array
{
    return [
        '@type' => 'FAQPage',
        'mainEntity' => array_map(static fn (array $f): array => [
            '@type' => 'Question',
            'name'  => $f[0],
            'acceptedAnswer' => ['@type' => 'Answer', 'text' => $f[1]],
        ], $faqs),
    ];
}

function webapp_ld(string $slug, string $name, string $description): array
{
    return [
        '@type' => 'WebApplication',
        'name'  => $name,
        'description' => $description,
        'url'   => site_url(page_path($slug)),
        'applicationCategory' => 'BusinessApplication',
        'operatingSystem' => 'Web',
        'inLanguage' => 'es-PY',
        'isAccessibleForFree' => true,
        'offers' => ['@type' => 'Offer', 'price' => '0', 'priceCurrency' => 'PYG'],
        'provider' => ['@id' => site_url('/#organization')],
    ];
}

/** BreadcrumbList data + visible trail share one definition. @return array<int,array{0:string,1:string}> */
function crumbs_for(string $slug): array
{
    $trail = [['Inicio', '/']];
    if ($slug === '') {
        return $trail;
    }
    $parts = explode('/', $slug);
    if (count($parts) === 2) {
        $parent = ['servicios' => ['Servicios', '/servicios/'], 'para' => ['Para tu rubro', '/para/pymes'], 'recursos' => ['Guías', '/recursos/']][$parts[0]] ?? null;
        if ($parent !== null) {
            $trail[] = $parent;
        }
    }
    $trail[] = [site_page($slug)['label'], page_path($slug)];
    return $trail;
}

function breadcrumbs_ld(string $slug): array
{
    $items = [];
    foreach (crumbs_for($slug) as $i => [$name, $path]) {
        $items[] = ['@type' => 'ListItem', 'position' => $i + 1, 'name' => $name, 'item' => site_url($path)];
    }
    return ['@type' => 'BreadcrumbList', 'itemListElement' => $items];
}

function breadcrumbs(string $slug): string
{
    $trail = crumbs_for($slug);
    if (count($trail) < 2) {
        return '';
    }
    $h = '<nav class="crumbs" aria-label="Migas de pan"><ol>';
    foreach ($trail as $i => [$name, $path]) {
        $last = $i === count($trail) - 1;
        $h .= '<li>' . ($last ? '<span aria-current="page">' . e($name) . '</span>' : '<a href="' . e($path) . '">' . e($name) . '</a>') . '</li>';
    }
    return $h . '</ol></nav>';
}

// ---------------------------------------------------------------------------
// <head> metadata
// ---------------------------------------------------------------------------

/**
 * @param array{title:string,desc:string,slug:string,index:bool} $page
 */
function meta(array $page, ?string $ogImage = null): string
{
    $canon = site_url(page_path($page['slug']));
    $h  = '<title>' . e($page['title']) . '</title>' . "\n";
    $h .= '<meta name="description" content="' . e($page['desc']) . '">' . "\n";
    $h .= '<link rel="canonical" href="' . e($canon) . '">' . "\n";
    if ($page['index']) {
        $h .= '<meta name="robots" content="index,follow,max-image-preview:large">' . "\n";
        $h .= '<link rel="alternate" hreflang="es-PY" href="' . e($canon) . '">' . "\n";
        $h .= '<link rel="alternate" hreflang="x-default" href="' . e($canon) . '">' . "\n";
    } else {
        $h .= '<meta name="robots" content="noindex,follow">' . "\n";
    }
    $h .= '<meta property="og:type" content="website">' . "\n";
    $h .= '<meta property="og:locale" content="es_PY">' . "\n";
    $h .= '<meta property="og:site_name" content="' . e(cfg('brand')) . '">' . "\n";
    $h .= '<meta property="og:title" content="' . e($page['title']) . '">' . "\n";
    $h .= '<meta property="og:description" content="' . e($page['desc']) . '">' . "\n";
    $h .= '<meta property="og:url" content="' . e($canon) . '">' . "\n";
    if ($ogImage !== null) {
        $h .= '<meta property="og:image" content="' . e(site_url($ogImage)) . '">' . "\n";
        $h .= '<meta property="og:image:width" content="1200">' . "\n";
        $h .= '<meta property="og:image:height" content="630">' . "\n";
        $h .= '<meta name="twitter:card" content="summary_large_image">' . "\n";
        $h .= '<meta name="twitter:image" content="' . e(site_url($ogImage)) . '">' . "\n";
    } else {
        $h .= '<meta name="twitter:card" content="summary">' . "\n";
    }
    return $h;
}

/**
 * OG image only when the owner has actually put the file there (1200x630).
 * assets/img/og/<slug with - >.png. We never point a tag at a missing file.
 */
function og_image_for(string $slug): ?string
{
    $name = $slug === '' ? 'home' : str_replace('/', '-', $slug);
    foreach (['png', 'jpg', 'webp'] as $ext) {
        if (is_file(PUBLIC_DIR . "/assets/img/og/$name.$ext")) {
            return "/assets/img/og/$name.$ext";
        }
    }
    return '/assets/img/og/default.jpg';
}

// ---------------------------------------------------------------------------
// Layout
// ---------------------------------------------------------------------------

function nav_groups(): array
{
    $g = ['servicios' => [], 'para' => []];
    foreach (site_pages() as $slug => $p) {
        if (isset($g[$p['group']])) {
            $g[$p['group']][$slug] = $p['label'];
        }
    }
    return $g;
}

function render_header(array $page, bool $minimal): string
{
    $h='<header class="site-header"><div class="shell bar"><a class="brand" href="/" aria-label="Ciberseguridad.com.py — inicio"><span class="brand-mark" aria-hidden="true">c.</span><span>ciberseguridad<span class="brand-domain">.com.py</span></span></a>';
    if ($minimal) return $h . '</div></header>';
    $h.='<button class="nav-toggle" type="button" aria-expanded="false" aria-controls="nav-panel">Menú <span aria-hidden="true">☰</span></button><div class="nav-panel" id="nav-panel"><nav aria-label="Principal"><ul class="nav">';
    foreach (['servicios'=>'Servicios','recursos'=>'Guías','proveedores'=>'Proveedores','nosotros'=>'La plataforma','contacto'=>'Contacto'] as $slug=>$label) {
        $h.='<li><a href="'.e(page_path($slug)).'"'.($page['slug']===$slug?' aria-current="page"':'').'>'.e($label).'</a></li>';
    }
    return $h.'</ul></nav><a class="button nav-cta" href="/encontra-un-proveedor/">Pedir orientación <span aria-hidden="true">↗</span></a></div></div></header>';
}

function render_footer(): string
{
    return '<footer class="site-footer"><div class="shell"><div class="footer-grid"><div><a class="brand" href="/">ciberseguridad.com.py</a><p>Orientación independiente para empresas en Paraguay. Te ayudamos a entender y comparar servicios de seguridad.</p><p class="foot-note">No prestamos servicios técnicos de seguridad ni somos CERT-PY o MITIC.</p></div><nav aria-label="Plataforma"><h2>Explorá</h2><a href="/servicios/">Servicios</a><a href="/recursos/">Guías para empresas</a><a href="/proveedores/">Proveedores</a><a href="/encontra-un-proveedor/">Pedir orientación</a><a href="/incidente/">Incidente en curso</a></nav><nav aria-label="Confianza"><h2>La plataforma</h2><a href="/nosotros/">Sobre nosotros</a><a href="/metodologia-verificacion/">Cómo verificamos</a><a href="/registro-proveedor/">Soy proveedor</a><a href="/correcciones/">Correcciones</a><a href="/divulgacion-responsable/">Divulgación responsable</a></nav><nav aria-label="Contacto y privacidad"><h2>Contacto</h2><a href="/contacto/">Contacto general</a><a href="/privacidad/">Privacidad</a><a href="/terminos/">Términos</a><a href="https://www.cert.gov.py/contacto/" rel="noopener">Canal oficial CERT-PY ↗</a></nav></div><div class="footer-bottom"><span>Paraguay · Español</span><span>Datos mínimos. Alcance por escrito. Decisiones informadas.</span></div></div></footer>';
}

/**
 * Wrap $body in the site shell.
 *
 * @param array<string,mixed> $page   from site_page()
 * @param array{schema?:array,minimal?:bool,sticky?:string,scripts?:array,body_class?:string,service?:string,event?:string} $opts
 */
function layout(array $page, string $body, array $opts = []): string
{
    if (preg_match_all('/<h1[\s>]/i', $body) !== 1) {
        trigger_error('Page "' . $page['slug'] . '" must have exactly one <h1>.', E_USER_WARNING);
    }

    $minimal = (bool) ($opts['minimal'] ?? false);
    $sticky  = (string) ($opts['sticky'] ?? 'wa');
    $schema  = $opts['schema'] ?? [];
    $scripts = $opts['scripts'] ?? [];

    // Structured data: page-specific documents plus breadcrumbs. Organization
    // is emitted on the home and contact pages only, others reference its @id.
    $ld = jsonld(['@type'=>'WebPage','name'=>$page['title'],'description'=>$page['desc'],'url'=>site_url(page_path($page['slug'])),'inLanguage'=>'es-PY']) . "\n";
    if (isset($page['published_at'], $page['modified_at'])) {
        preg_match('/<h1[^>]*>(.*?)<\/h1>/is', $body, $headline);
        $ld .= jsonld([
            '@type'=>'Article',
            'headline'=>html_entity_decode(strip_tags($headline[1] ?? $page['label']), ENT_QUOTES | ENT_HTML5, 'UTF-8'),
            'url'=>site_url(page_path($page['slug'])),
            'datePublished'=>$page['published_at'],
            'dateModified'=>$page['modified_at'],
            'inLanguage'=>'es-PY',
            'author'=>['@type'=>'Organization', 'name'=>cfg('brand')],
            'publisher'=>['@id'=>site_url('/#organization')],
        ]) . "\n";
    }
    foreach ($schema as $doc) {
        $ld .= jsonld($doc) . "\n";
    }
    if (!$minimal && !in_array($page['slug'], ['', '404', 'gracias'], true)) {
        $ld .= jsonld(breadcrumbs_ld($page['slug'])) . "\n";
    }

    $bodyAttrs = ' data-page="' . e($page['slug'] === '' ? 'home' : $page['slug']) . '"';
    if (isset($opts['service'])) {
        $bodyAttrs .= ' data-service="' . e($opts['service']) . '"';
    }
    if (isset($opts['event'])) {
        $bodyAttrs .= ' data-event="' . e($opts['event']) . '"';
    }
    $cls = trim((string) ($opts['body_class'] ?? '') . ($minimal ? ' page-min' : ''));
    if ($cls !== '') {
        $bodyAttrs .= ' class="' . e($cls) . '"';
    }

    $out  = "<!doctype html>\n<html lang=\"es-PY\">\n<head>\n<meta charset=\"utf-8\">\n";
    $out .= '<meta name="viewport" content="width=device-width,initial-scale=1">' . "\n";
    $out .= '<meta name="theme-color" content="#163b3c">' . "\n";
    $out .= meta($page, $opts['og_image'] ?? og_image_for($page['slug']));
    $out .= '<link rel="stylesheet" href="' . e(asset('/assets/css/orientation.css')) . '">' . "\n";
    $out .= '<link rel="icon" href="/favicon.svg" type="image/svg+xml">' . "\n";
    $out .= $ld;
    $out .= "</head>\n<body{$bodyAttrs}>\n";
    $out .= '<a class="skip" href="#main">Saltar al contenido</a>' . "\n";
    $out .= render_header($page, $minimal) . "\n";
    $out .= '<main id="main" tabindex="-1">' . "\n" . $body . "\n</main>\n";
    $out .= render_footer() . "\n";

    if (!$minimal && !in_array($page['slug'], ['encontra-un-proveedor','contacto','incidente','gracias','404','privacidad','terminos'], true)) {
        $out .= '<div class="sticky-cta"><a class="button" href="/encontra-un-proveedor/">Pedir orientación <span aria-hidden="true">↗</span></a></div>';
    }
    if (!$minimal) {
        $out .= '<script src="' . e(asset('/assets/js/site.js')) . '"></script>' . "\n";
    }
    foreach ($scripts as $s) {
        $out .= '<script src="' . e(asset($s)) . '" defer></script>' . "\n";
    }
    $out .= '<script src="' . e(asset('/assets/js/vc-attribution.js')) . '" defer></script>' . "\n";
    if ((string) cfg('ga4_id') !== '') {
        $out .= '<script src="' . e(asset('/assets/js/analytics.js')) . '" data-ga="' . e(cfg('ga4_id')) . '" defer></script>' . "\n";
    }
    return $out . "</body>\n</html>\n";
}

// ---------------------------------------------------------------------------
// Page helpers: page_start()/page_end() wrap the output buffer.
// ---------------------------------------------------------------------------

function page_start(string $slug): void
{
    $GLOBALS['__page'] = site_page($slug);
    ob_start();
}

/** @param array<string,mixed> $opts see layout(); plus 'faqs' to add FAQPage schema */
function page_end(array $opts = []): void
{
    $body = (string) ob_get_clean();
    $page = $GLOBALS['__page'];
    if (isset($opts['faqs'])) {
        $opts['schema'] = array_merge($opts['schema'] ?? [], [faq_ld($opts['faqs'])]);
    }
    echo layout($page, $body, $opts);
}

function current_page(): array
{
    return $GLOBALS['__page'];
}

// ---------------------------------------------------------------------------
// Reusable blocks
// ---------------------------------------------------------------------------

function cta_button(string $label = 'Escribinos por WhatsApp', ?string $text = null): string
{
    $text ??= current_page()['wa'];
    return '<a class="btn btn--primary" href="' . e(wa($text)) . '" data-track="whatsapp">' . e($label) . '</a>';
}

/** Full-width closing section, one action. */
function cta_final(string $title, string $lead, ?string $text = null, string $label = 'Escribinos por WhatsApp'): string
{
    return '<section class="section section--dark cta-final"><div class="wrap narrow">'
        . '<h2>' . e($title) . '</h2><p>' . e($lead) . '</p>'
        . '<p>' . cta_button($label, $text) . '</p></div></section>';
}

/** @param array<int,array{0:string,1:string}> $faqs plain-text Q/A (mirrors FAQPage schema) */
function faq_html(array $faqs, string $title = 'Preguntas frecuentes'): string
{
    $h = '<section class="section"><div class="wrap narrow"><h2>' . e($title) . '</h2><div class="faq">';
    foreach ($faqs as [$q, $a]) {
        $h .= '<details><summary>' . e($q) . '</summary><p>' . e($a) . '</p></details>';
    }
    return $h . '</div></div></section>';
}

/** The standard three-step process (PRODUCT_SPEC.md §5). */
function process_steps(string $third = 'Ejecución y entrega'): string
{
    $steps = [
        ['Conversación inicial (30 minutos, sin costo)', 'Nos contás la situación y te decimos con franqueza si somos las personas indicadas para resolverla.'],
        ['Propuesta con alcance y precio fijo (2 a 3 días hábiles)', 'Qué se hace, qué se entrega y cuánto cuesta, por escrito. Sin horas abiertas ni sorpresas.'],
        [$third, 'Hacemos el trabajo y lo entregamos con un informe escrito, con hallazgos priorizados y un plan que puede ejecutar tu proveedor de IT.'],
    ];
    $h = '<ol class="steps">';
    foreach ($steps as $i => [$t, $d]) {
        $h .= '<li><span class="steps__n" aria-hidden="true">' . ($i + 1) . '</span><div><h3>' . e($t) . '</h3><p>' . e($d) . '</p></div></li>';
    }
    return $h . '</ol>';
}

/**
 * Price block. Shows the published band only if the owner has set one;
 * otherwise states the pricing method honestly and invents no number.
 * TODO(content): owner sets PRICE_* in .env (Phase 0: price bands).
 */
function price_block(string $key, string $method): string
{
    $band = (string) cfg('price_' . $key, '');
    $h = '<div class="price">';
    if ($band !== '') {
        $h .= '<p class="price__band">Desde ' . e($band) . '</p>';
    }
    return $h . '<p>' . e($method) . '</p></div>';
}
