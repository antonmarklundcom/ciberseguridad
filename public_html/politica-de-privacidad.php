<?php
declare(strict_types=1);

/**
 * /politica-de-privacidad — BUILD-SPEC-PAGES.md §15.
 *
 * ⚠️ Not drafted here as full legal text — this carries legal effect under
 * Ley 6534/2020 and should be reviewed by a lawyer rather than generated.
 * The minimum content the spec requires this page to state is included below
 * as a factual description of this site's own actual, verifiable behavior
 * (what the form collects, who receives it, that it goes to a CRM, retention,
 * deletion) — not fabricated legal boilerplate. Broader clauses (liability,
 * applicable law, dispute resolution, cookie categories beyond the one this
 * site sets) are explicitly left for legal review before launch, per the
 * launch-gate rule that the site must not launch with this page empty.
 */

require_once dirname(__DIR__) . '/src/render.php';

layout_open([
    'title'       => 'Política de privacidad | Ciberseguridad.com.py',
    'description' => 'Qué datos recolecta el formulario de este sitio, quién los recibe y cómo pedir que se eliminen.',
    'path'        => '/politica-de-privacidad',
    'mode'        => 'b',
    'wa_slug'     => 'privacidad',
]);
?>
<main id="main">
  <section class="hero" style="padding-block:var(--s-16)">
    <div class="wrap">
      <h1>Política de privacidad</h1>
      <p><strong>⚠️ Pendiente de revisión legal.</strong> Esta página cubre el contenido mínimo que exige <code>BUILD-SPEC-PAGES.md</code> — qué recolectamos, quién lo recibe, que se envía a un CRM, cuánto tiempo se conserva y cómo pedir su eliminación — descrito con precisión sobre el funcionamiento real del sitio. No reemplaza una revisión por un abogado antes del lanzamiento, particularmente respecto de la Ley 6534/2020 de protección de datos personales.</p>
    </div>
  </section>
  <section style="padding-top:0">
    <div class="wrap" style="max-width:var(--measure)">
      <h2>Qué datos recolecta el formulario</h2>
      <p>El formulario de contacto de este sitio pide tu nombre, teléfono o WhatsApp, correo electrónico (opcional), empresa (opcional), cantidad de empleados, rubro, qué te trae por acá, cómo preferís que te contactemos y un mensaje breve (opcional). No pedimos cédula, RUC, contraseñas, detalles técnicos sensibles ni diagramas de red.</p>

      <h2>Quién recibe estos datos</h2>
      <p>Los datos los recibe únicamente Ciberseguridad.com.py. No se comparten con terceros, salvo el proveedor de CRM que usamos internamente para organizar consultas (ver siguiente punto).</p>

      <h2>Que se envían a un CRM</h2>
      <p>Tu consulta se guarda en nuestro propio servidor y además se envía a VenderCRM, la herramienta que usamos para organizar y responder consultas. VenderCRM procesa estos datos en nuestro nombre y no los usa para ningún otro fin.</p>

      <h2>Cuánto tiempo se conservan</h2>
      <p>Conservamos tu consulta mientras dure la relación comercial o el intercambio de mensajes, y por un tiempo razonable después para poder responder preguntas de seguimiento. No la usamos para enviarte publicidad no solicitada.</p>

      <h2>Cómo pedir que se eliminen</h2>
      <p>Podés pedirnos en cualquier momento que eliminemos tus datos escribiendo a <a href="mailto:contacto@ciberseguridad.com.py">contacto@ciberseguridad.com.py</a> o por WhatsApp al <a href="<?= htmlspecialchars(tel_href()) ?>">+595 995 628862</a>.</p>

      <h2>Cookies</h2>
      <p>Este sitio usa una cookie estrictamente necesaria para recordar que aceptaste este aviso, y una cookie de sesión para proteger el formulario contra envíos falsificados (CSRF). No usamos cookies de seguimiento de terceros ni scripts de analítica de terceros.</p>
    </div>
  </section>
</main>
<?php
layout_close(['mode' => 'b', 'wa_slug' => 'privacidad']);
