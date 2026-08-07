<?php
declare(strict_types=1);

/**
 * A5 — shared layout: <head>, header, footer, FAB, sticky bar, JSON-LD.
 *
 * Spec: BUILD-SPEC.md §5 (global shell), §4 (conversion model / WhatsApp
 * link format), §13 (schema). Every page calls layout_open($opts) then
 * layout_close($opts) around its own <main> markup — see public_html/index.php
 * for the canonical usage.
 */

require_once __DIR__ . '/config.php';

const WA_NUMBER = '595995628862';

/** Builds a WhatsApp deep link with the mandatory prefilled, page-identifying text. */
function wa_url(string $slug, string $extra = ''): string
{
    $text = 'Hola, vengo de ciberseguridad.com.py (' . $slug . ') - ' . $extra;
    return 'https://wa.me/' . WA_NUMBER . '?text=' . rawurlencode($text);
}

function tel_href(): string
{
    return 'tel:+' . WA_NUMBER;
}

/**
 * <picture> markup for an image slot per BUILD-SPEC.md §9: AVIF + WebP at
 * 640/1280/1920, explicit width/height against CLS, hero eager + high
 * priority, everything else lazy.
 *
 * @param int[] $widths Native-resolution-capped widths this stem was
 *                       actually rendered at (see the img pipeline's own
 *                       report — 1024px source images only get 640/1280).
 */
function picture_tag(string $stem, string $alt, string $ratioW, string $ratioH, bool $eager = false, array $widths = [640, 1280, 1920], string $class = ''): string
{
    $e        = static fn (?string $v): string => htmlspecialchars((string) $v, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
    $fallback = max($widths);
    $avifSet  = implode(', ', array_map(static fn ($w) => "/assets/img/{$stem}-{$w}.avif {$w}w", $widths));
    $webpSet  = implode(', ', array_map(static fn ($w) => "/assets/img/{$stem}-{$w}.webp {$w}w", $widths));

    $imgAttrs = 'alt="' . $e($alt) . '" width="' . (int) $ratioW . '" height="' . (int) $ratioH . '" class="' . $e($class) . '"';
    $imgAttrs .= $eager ? ' fetchpriority="high"' : ' loading="lazy"';

    return '<picture>'
        . '<source type="image/avif" srcset="' . $e($avifSet) . '">'
        . '<source type="image/webp" srcset="' . $e($webpSet) . '">'
        . '<img src="/assets/img/' . $e($stem) . '-' . $fallback . '.webp" ' . $imgAttrs . '>'
        . '</picture>';
}

/**
 * @param array{
 *   title:string, description:string, path:string, mode:'a'|'b', wa_slug:string,
 *   og_image?:string, jsonld?:array<int,array<string,mixed>>, noindex?:bool
 * } $opts
 */
function layout_open(array $opts): void
{
    $title       = $opts['title'];
    $description = $opts['description'];
    $path        = $opts['path'];
    $mode        = $opts['mode'] ?? 'b';
    $waSlug      = $opts['wa_slug'];
    $ogImage     = $opts['og_image'] ?? 'https://ciberseguridad.com.py/assets/img/og-ciberseguridad-paraguay.jpg';
    $jsonld      = $opts['jsonld'] ?? [];
    $noindex     = $opts['noindex'] ?? true; // ⚠️ pre-launch default — see BUILD-SPEC.md §5.1
    $canonical   = 'https://ciberseguridad.com.py' . $path;
    $e           = static fn (?string $v): string => htmlspecialchars((string) $v, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');

    echo '<!doctype html><html lang="es-PY"><head><meta charset="utf-8">';
    echo '<meta name="viewport" content="width=device-width,initial-scale=1">';
    echo '<title>' . $e($title) . '</title>';
    echo '<meta name="description" content="' . $e($description) . '">';
    echo '<link rel="canonical" href="' . $e($canonical) . '">';
    echo '<meta property="og:type" content="website">';
    echo '<meta property="og:locale" content="es_PY">';
    echo '<meta property="og:title" content="' . $e($title) . '">';
    echo '<meta property="og:description" content="' . $e($description) . '">';
    echo '<meta property="og:url" content="' . $e($canonical) . '">';
    echo '<meta property="og:image" content="' . $e($ogImage) . '">';
    echo '<meta name="twitter:card" content="summary_large_image">';
    echo '<link rel="icon" href="/favicon.svg" type="image/svg+xml">';
    echo '<link rel="preload" as="font" type="font/woff2" crossorigin href="/assets/fonts/GeneralSans-Regular.woff2">';
    echo '<link rel="preload" as="font" type="font/woff2" crossorigin href="/assets/fonts/GeneralSans-Medium.woff2">';
    echo '<style>';
    echo '@font-face{font-family:"General Sans";font-weight:400;font-style:normal;font-display:swap;src:url("/assets/fonts/GeneralSans-Regular.woff2") format("woff2")}';
    echo '@font-face{font-family:"General Sans";font-weight:450;font-style:normal;font-display:swap;src:url("/assets/fonts/GeneralSans-Regular.woff2") format("woff2")}';
    echo '@font-face{font-family:"General Sans";font-weight:500;font-style:normal;font-display:swap;src:url("/assets/fonts/GeneralSans-Medium.woff2") format("woff2")}';
    echo '</style>';
    echo '<link rel="stylesheet" href="/assets/css/site.css" media="print" onload="this.media=\'all\'">';
    echo '<noscript><link rel="stylesheet" href="/assets/css/site.css"></noscript>';
    if ($noindex) {
        echo '<meta name="robots" content="noindex,nofollow">';
    }
    echo '<!-- ANALYTICS: paste GTM or GA4 here. Events already fire via data-ev shim. -->';
    echo '<!-- SEARCH-CONSOLE: <meta name="google-site-verification" content=""> -->';
    foreach ($jsonld as $block) {
        echo '<script type="application/ld+json">' . json_encode($block, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) . '</script>';
    }
    echo '</head><body class="mode-' . $e($mode) . ' has-sticky-bar">';
    echo '<a class="skip-link" href="#main">Saltar al contenido</a>';

    render_header($waSlug, $e);
}

/** @param callable(?string):string $e */
function render_header(string $waSlug, callable $e): void
{
    ?>
<header class="site-header" data-sticky-header>
  <div class="wrap">
    <a href="/" class="wordmark">Ciberseguridad.com.py</a>
    <nav class="site-nav" aria-label="Principal">
      <ul>
        <li class="has-dropdown">
          <a href="/servicios/auditoria-de-seguridad">Servicios ▾</a>
          <div class="dropdown">
            <a href="/servicios/auditoria-de-seguridad">Auditoría de seguridad</a>
            <a href="/servicios/pentesting">Pentesting</a>
            <a href="/servicios/respuesta-a-incidentes">Respuesta a incidentes</a>
            <a href="/servicios/cumplimiento">Cumplimiento</a>
            <a href="/servicios/capacitacion">Capacitación</a>
          </div>
        </li>
        <li class="has-dropdown">
          <a href="/para/pymes">Para tu rubro ▾</a>
          <div class="dropdown">
            <a href="/para/clinicas">Clínicas</a>
            <a href="/para/contadores">Estudios contables</a>
            <a href="/para/ecommerce">Tiendas online</a>
            <a href="/para/pymes">PYMES</a>
          </div>
        </li>
        <li><a href="/guias/">Guías</a></li>
        <li><a href="/nosotros">Nosotros</a></li>
        <li><a href="/contacto">Contacto</a></li>
      </ul>
    </nav>
    <div class="header-right">
      <a class="header-phone" href="<?= $e(tel_href()) ?>" data-ev="call_click" data-ev-loc="header">+595 995 628862</a>
      <a class="btn btn--primary" href="/contacto#agendar" data-ev="schedule_click" data-ev-loc="header">Agendá una llamada</a>
      <button class="hamburger" data-mobile-open aria-label="Abrir menú" aria-controls="mobile-panel">
        <span></span>
      </button>
    </div>
  </div>
</header>

<div class="mobile-panel" id="mobile-panel" data-mobile-panel aria-hidden="true">
  <div class="mobile-panel-top">
    <span class="wordmark">Ciberseguridad.com.py</span>
    <button class="mobile-panel-close" data-mobile-close aria-label="Cerrar menú">✕</button>
  </div>
  <nav aria-label="Principal, móvil">
    <a href="/servicios/auditoria-de-seguridad">Servicios</a>
    <a href="/para/pymes">Para tu rubro</a>
    <a href="/guias/">Guías</a>
    <a href="/nosotros">Nosotros</a>
    <a href="/contacto">Contacto</a>
  </nav>
  <div class="mobile-panel-bottom">
    <a class="header-phone" href="<?= $e(tel_href()) ?>" data-ev="call_click" data-ev-loc="header">+595 995 628862</a>
    <a class="btn btn--primary" href="/contacto#agendar" data-ev="schedule_click" data-ev-loc="header">Agendá una llamada</a>
    <a class="btn btn--wa" href="<?= $e(wa_url($waSlug)) ?>" data-ev="whatsapp_click" data-ev-loc="header"><?= wa_glyph() ?> Escribinos por WhatsApp</a>
  </div>
</div>
    <?php
}

function wa_glyph(): string
{
    return '<svg viewBox="0 0 24 24" aria-hidden="true"><path d="M12 2a10 10 0 0 0-8.6 15.1L2 22l5-1.3A10 10 0 1 0 12 2Zm0 18.2a8.2 8.2 0 0 1-4.2-1.1l-.3-.2-3 .8.8-2.9-.2-.3A8.2 8.2 0 1 1 12 20.2Zm4.5-6.1c-.2-.1-1.5-.7-1.7-.8-.2-.1-.4-.1-.6.1-.2.2-.7.8-.8 1-.2.2-.3.2-.5.1a6.7 6.7 0 0 1-2-1.2 7.4 7.4 0 0 1-1.4-1.7c-.1-.2 0-.4.1-.5l.4-.4.2-.4a.5.5 0 0 0 0-.4c-.1-.1-.6-1.4-.8-1.9-.2-.5-.4-.4-.6-.4h-.5a1 1 0 0 0-.7.3 3 3 0 0 0-.9 2.2c0 1.3.9 2.6 1.1 2.8.1.2 2 3 4.7 4.2a15 15 0 0 0 1.6.6 3.8 3.8 0 0 0 1.7.1c.5-.1 1.5-.6 1.7-1.2.2-.6.2-1.1.2-1.2-.1-.1-.3-.2-.5-.3Z"/></svg>';
}

/**
 * @param array{mode:'a'|'b', wa_slug:string} $opts
 */
function layout_close(array $opts): void
{
    $mode   = $opts['mode'] ?? 'b';
    $waSlug = $opts['wa_slug'];
    $e      = static fn (?string $v): string => htmlspecialchars((string) $v, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');

    render_footer($e);

    if ($mode === 'a') {
        echo '<div class="sticky-bar sticky-bar--modea">';
        echo '<a href="' . $e(wa_url($waSlug, 'necesitamos ayuda urgente')) . '" data-ev="whatsapp_click" data-ev-loc="sticky">Escribinos</a>';
        echo '<a href="' . $e(tel_href()) . '" data-ev="call_click" data-ev-loc="sticky">Llamar ahora</a>';
        echo '</div>';
    } else {
        echo '<div class="sticky-bar sticky-bar--modeb">';
        echo '<a href="/contacto#agendar" data-ev="schedule_click" data-ev-loc="sticky">Agendá una llamada</a>';
        echo '<a href="' . $e(wa_url($waSlug)) . '" data-ev="whatsapp_click" data-ev-loc="sticky">' . wa_glyph() . '</a>';
        echo '</div>';
    }

    echo '<a class="wa-fab" href="' . $e(wa_url($waSlug)) . '" aria-label="Escribinos por WhatsApp" data-ev="whatsapp_click" data-ev-loc="fab">' . wa_glyph() . '</a>';

    echo '<div class="cookie-banner" data-cookie-banner>';
    echo '<p>Usamos cookies estrictamente necesarias para el funcionamiento del sitio y para recordar tu preferencia. No usamos cookies de seguimiento de terceros. <a href="/politica-de-privacidad">Política de privacidad</a>.</p>';
    echo '<div class="cookie-banner-actions"><button class="btn btn--primary" data-cookie-accept type="button">Entendido</button></div>';
    echo '</div>';

    echo '<script src="/assets/js/site.js" defer></script>';
    echo '</body></html>';
}

/** @param callable(?string):string $e */
function render_footer(callable $e): void
{
    ?>
<footer class="site-footer grain">
  <div class="wrap footer-grid">
    <div class="footer-brand">
      <a href="/" class="wordmark" style="color:#fff">Ciberseguridad.com.py</a>
      <p>Seguridad informática para empresas paraguayas.</p>
      <div class="footer-contact">
        <span>Asunción, Paraguay</span>
        <a href="<?= $e(tel_href()) ?>" data-ev="call_click" data-ev-loc="footer">+595 995 628862</a>
        <a href="mailto:contacto@ciberseguridad.com.py">contacto@ciberseguridad.com.py</a>
      </div>
    </div>
    <div>
      <h3>Servicios</h3>
      <ul>
        <li><a href="/servicios/auditoria-de-seguridad">Auditoría</a></li>
        <li><a href="/servicios/pentesting">Pentesting</a></li>
        <li><a href="/servicios/respuesta-a-incidentes">Respuesta a incidentes</a></li>
        <li><a href="/servicios/cumplimiento">Cumplimiento</a></li>
        <li><a href="/servicios/capacitacion">Capacitación</a></li>
      </ul>
    </div>
    <div>
      <h3>Para tu rubro</h3>
      <ul>
        <li><a href="/para/clinicas">Clínicas</a></li>
        <li><a href="/para/contadores">Estudios contables</a></li>
        <li><a href="/para/ecommerce">Tiendas online</a></li>
        <li><a href="/para/pymes">PYMES</a></li>
      </ul>
    </div>
    <div>
      <h3>La empresa</h3>
      <ul>
        <li><a href="/nosotros">Nosotros</a></li>
        <li><a href="/precios">Cómo cotizamos</a></li>
        <li><a href="/guias/">Guías</a></li>
        <li><a href="/preguntas-frecuentes">Preguntas frecuentes</a></li>
        <li><a href="/contacto">Contacto</a></li>
      </ul>
    </div>
  </div>
  <div class="wrap footer-bottom">
    <span>Este sitio publica su propia configuración de seguridad — verificala vos mismo: SSL Labs · securityheaders.com · security.txt</span>
    <span>© 2026 Ciberseguridad.com.py · <a href="/politica-de-privacidad">Política de privacidad</a> · <a href="/terminos">Términos</a></span>
  </div>
</footer>
    <?php
}
