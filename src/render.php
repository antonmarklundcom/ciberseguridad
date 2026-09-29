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
        'telephone' => $n['e164'],
        'areaServed' => ['@type' => 'Country', 'name' => 'Paraguay'],
        'address'  => [
            '@type' => 'PostalAddress',
            'addressLocality' => $n['locality'],
            'addressCountry'  => 'PY',
        ],
        'contactPoint' => [[
            '@type' => 'ContactPoint',
            'contactType' => 'customer service',
            'telephone' => $n['e164'],
            'availableLanguage' => 'es',
        ] + ($n['email'] !== '' ? ['email' => $n['email']] : [])],
    ];
    if ($n['email'] !== '') {
        $org['email'] = $n['email'];
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
        $parent = ['servicios' => ['Servicios', '/#servicios'], 'para' => ['Para tu rubro', '/para/pymes'], 'recursos' => ['Recursos', '/recursos']][$parts[0]] ?? null;
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
    return null;
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
    $brand = '<a class="brand" href="/" aria-label="' . e(cfg('brand')) . ' — inicio">Ciberseguridad<span>.com.py</span></a>';
    if ($minimal) {
        return '<header class="site-header site-header--min"><div class="wrap bar">' . $brand
            . '<a class="btn-link" href="/">Ir al inicio</a></div></header>';
    }

    $g = nav_groups();
    $cur = $page['slug'];
    $li = static function (string $slug, string $label) use ($cur): string {
        $c = $slug === $cur ? ' aria-current="page"' : '';
        return '<li><a href="' . e(page_path($slug)) . '"' . $c . '>' . e($label) . '</a></li>';
    };

    $h  = '<header class="site-header"><div class="wrap bar">' . $brand;
    $h .= '<button class="nav-toggle" type="button" aria-expanded="false" aria-controls="nav-panel"><span class="nav-toggle__bars" aria-hidden="true"></span><span class="sr">Menú</span></button>';
    $h .= '<div class="nav-panel" id="nav-panel"><nav aria-label="Principal"><ul class="nav">';
    $h .= '<li class="has-sub"><button class="sub-toggle" type="button" aria-expanded="false">Servicios</button><ul class="sub">';
    foreach ($g['servicios'] as $slug => $label) {
        $h .= $li($slug, $label);
    }
    $h .= '</ul></li>';
    $h .= '<li class="has-sub"><button class="sub-toggle" type="button" aria-expanded="false">Para tu rubro</button><ul class="sub">';
    foreach ($g['para'] as $slug => $label) {
        $h .= $li($slug, $label);
    }
    $h .= '</ul></li>';
    $h .= $li('recursos', 'Recursos') . $li('nosotros', 'Nosotros') . $li('contacto', 'Contacto');
    $h .= '</ul></nav>';
    $h .= '<a class="btn btn--primary nav-cta" href="' . e(wa($page['wa'])) . '" data-track="whatsapp">Escribinos</a>';
    $h .= '</div></div></header>';
    return $h;
}

function render_footer(): string
{
    $g = nav_groups();
    $h  = '<footer class="site-footer"><div class="wrap">';
    $h .= '<div class="foot-grid">';
    $h .= '<div>' . nap_html() . '</div>';
    $h .= '<nav aria-label="Servicios"><h2 class="foot-h">Servicios</h2><ul>';
    foreach ($g['servicios'] as $slug => $label) {
        $h .= '<li><a href="' . e(page_path($slug)) . '">' . e($label) . '</a></li>';
    }
    $h .= '</ul></nav>';
    $h .= '<nav aria-label="Para tu rubro"><h2 class="foot-h">Para tu rubro</h2><ul>';
    foreach ($g['para'] as $slug => $label) {
        $h .= '<li><a href="' . e(page_path($slug)) . '">' . e($label) . '</a></li>';
    }
    $h .= '</ul></nav>';
    $h .= '<nav aria-label="Sitio"><h2 class="foot-h">Sitio</h2><ul>'
        . '<li><a href="/recursos">Recursos</a></li>'
        . '<li><a href="/nosotros">Nosotros</a></li>'
        . '<li><a href="/contacto">Contacto</a></li>'
        . '<li><a href="/politica-de-privacidad">Política de privacidad</a></li>'
        . '<li><a href="/terminos">Términos de uso</a></li>'
        . '<li><a href="/.well-known/security.txt">security.txt</a></li>'
        . '</ul></nav>';
    $h .= '</div>';
    // Verify-our-security line (PRODUCT_SPEC.md §2). This only invites a scan
    // of our own host; it makes no claim about the grade.
    $h .= '<p class="foot-note">Este sitio publica su propia configuración de seguridad — '
        . '<a href="https://securityheaders.com/?q=ciberseguridad.com.py" rel="noopener">verificala</a>.</p>';
    $h .= '</div></footer>';
    return $h;
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
    $ld = '';
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
    $out .= '<meta name="theme-color" content="#0B2545">' . "\n";
    $out .= meta($page, $opts['og_image'] ?? og_image_for($page['slug']));
    $out .= '<link rel="stylesheet" href="' . e(asset('/assets/css/site.css')) . '">' . "\n";
    $out .= '<link rel="icon" href="/favicon.svg" type="image/svg+xml">' . "\n";
    $out .= $ld;
    $out .= "</head>\n<body{$bodyAttrs}>\n";
    $out .= '<a class="skip" href="#main">Saltar al contenido</a>' . "\n";
    $out .= render_header($page, $minimal) . "\n";
    $out .= '<main id="main" tabindex="-1">' . "\n" . $body . "\n</main>\n";
    $out .= render_footer() . "\n";

    if ($sticky === 'tel') {
        $out .= '<div class="sticky-cta sticky-cta--tel"><a class="btn btn--danger" href="' . e(tel_href())
            . '" data-track="phone">Llamanos ahora</a></div>' . "\n";
    } elseif ($sticky === 'wa') {
        $out .= '<div class="sticky-cta"><a class="btn btn--primary" href="' . e(wa($page['wa']))
            . '" data-track="whatsapp">Escribinos por WhatsApp</a></div>' . "\n";
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
