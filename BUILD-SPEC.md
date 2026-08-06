# BUILD-SPEC.md — ciberseguridad.com.py

**Execution instruction (turn 3):**
> *Implementá `BUILD-SPEC.md` y `BUILD-SPEC-PAGES.md` exactamente. No te desvíes.
> Preguntá ante cualquier duda en vez de adivinar.*

Every decision is closed here. If a line requires a judgement call at execution
time, that line is a defect in this spec — report it rather than deciding.

Interior pages live in `BUILD-SPEC-PAGES.md`. Strategy and the reasoning behind
these decisions live in `PLAN.md` and `STEP0_RECON.md`; **do not re-read them to
execute** — everything needed is here.

---

## 1. Intake

```
NEGOCIO:        Ciberseguridad.com.py          (mode 3 — the domain IS the brand)
OFICIO:         consultoría de ciberseguridad B2B
CIUDAD:         Asunción · Departamento Central
COBERTURA:      todo Paraguay (servicio nacional, remoto + presencial en Gran Asunción)
WHATSAPP:       +595 995 628862                (stage 1, shared across portfolio)
TELÉFONO:       +595 995 628862                (same number)
EMAIL:          ⚠️ contacto@ciberseguridad.com.py   (assumed — confirm mailbox exists)
SERVICIOS:      auditoría de seguridad · pentesting · respuesta a incidentes ·
                cumplimiento · capacitación
DIFERENCIAL:    alcance y precio fijo por escrito + la postura de seguridad
                verificable del propio sitio
CONFIANZA:      ⚠️ RUC pendiente · ⚠️ certificaciones pendientes ·
                sin servicios ofensivos (declarado) · informe con hallazgos priorizados
RESEÑAS:        NINGUNA — sección sustituida por "Cómo trabajamos" (§5 del skill)
FOTOS:          6 imágenes generadas (ver §9) · proof-photo PENDIENTE ·
                retrato del profesional PENDIENTE (real o vacío, nunca generado)
CONVERSIÓN:     MIXTA — ver §4
DISEÑO:         CLINICAL (web-design-system)
PRECIOS:        ⚠️ NO se publican importes. `/precios` es un explicador de
                alcance y cotización. Ver §12 para el bloque a insertar si se
                decide publicar bandas.
PAGOS:          no se muestran — irrelevante en B2B por factura
```

## 2. Design tokens — copy verbatim into `assets/css/site.css`

Track **CLINICAL**. One accent. These are values, not references.

```css
:root{
  --font-display:'General Sans',system-ui,sans-serif;
  --font-text:'General Sans',system-ui,sans-serif;
  --base:#FFFFFF;
  --ink:#0B1B2B;
  --accent:#1F6FEB;
  --surface:#F4F7FB;
  --danger:#B3261E;               /* respuesta-a-incidentes ONLY */

  --ink-70:color-mix(in srgb,var(--ink) 70%,transparent);
  --ink-55:color-mix(in srgb,var(--ink) 55%,transparent);
  --hairline:color-mix(in srgb,var(--ink) 10%,transparent);
  --hairline-strong:color-mix(in srgb,var(--ink) 18%,transparent);

  --t--1:0.812rem; --t-0:1.0625rem; --t-1:1.383rem; --t-2:1.797rem;
  --t-3:2.336rem;  --t-4:3.037rem;  --t-5:3.948rem; --t-6:5.133rem;
  --measure:65ch;

  --s-1:.25rem; --s-2:.5rem; --s-3:.75rem; --s-4:1rem;
  --s-6:1.5rem; --s-8:2rem;  --s-12:3rem;  --s-16:4rem;
  --s-24:6rem;  --s-32:8rem; --s-40:10rem;

  --r-sm:6px; --r-md:14px; --r-lg:28px;

  --shadow-1:0 1px 2px rgb(0 0 0/.04), 0 4px 12px rgb(0 0 0/.06);
  --shadow-2:0 2px 4px rgb(0 0 0/.06), 0 16px 40px rgb(0 0 0/.10);

  --ease-out:cubic-bezier(.16,1,.3,1);
  --ease-io:cubic-bezier(.4,0,.2,1);
  --dur-fast:180ms; --dur:280ms; --dur-slow:400ms;

  --container:1200px;
  --gutter:clamp(1rem,5vw,3rem);

  --wa-number:595995628862;       /* the ONLY place this appears in code */
  --tel-display:"+595 995 628862";
}
```

Then copy the rest of `web-design-system/references/tokens.css` unchanged:
`.grain`, `.scrim`, the primitives, the five `.card--*` variants, `.btn`,
`.eyebrow`, `.statement`, `.wrap`, `.bleed`.

Binding rules from the design system, restated because they are the ones that
get dropped in execution:

- Borders are `1px solid var(--hairline)` — **never** a solid grey.
- Shadows are always two-layer. Never a single blurry `box-shadow`.
- Three radii, assigned by element class: `--r-sm` inputs/chips/badges,
  `--r-md` cards/images, `--r-lg` panels/feature blocks.
- **`.grain` on every dark section**, including the incident band and the footer.
- Any text over any image sits on `.scrim`. Never raw.
- Headings: `font-weight:450`, `letter-spacing:-.03em`, `line-height:1.02`.
  Not 700 — heavy display weight reads as budget.
- Body 17px / 1.65, measure capped at 65ch, muted text never below 4.5:1.
- `#25D366` appears **only** inside the WhatsApp glyph `<svg>` fill. Never a
  section fill, never a button background. WhatsApp buttons use `.btn--wa`
  (ink background, green glyph).

### Fonts

General Sans, self-hosted woff2 in `assets/fonts/`, weights **400, 450, 500**
only. `font-display:swap`, `<link rel="preload" as="font" crossorigin>` for the
400 and 450 files. No Google Fonts request — the CSP forbids third-party origins
and this site's own hardening is the product.

One family in two roles satisfies "one display face + one text face": 450 at
display sizes, 400/500 at text sizes. **Do not add a second family.**

## 3. Motion

Copy `web-design-system/references/motion.js` verbatim into `assets/js/site.js`.
No additions. The complete permitted motion set:

- Scroll reveal, fade-up 12px, 60–80ms stagger, capped at 6 siblings, once.
- Hover on cards and buttons: `translateY(-4px)` (buttons `-2px`) + shadow step,
  180ms, `--ease-io`.
- Sticky header state change on scroll.
- **Nothing else.** No parallax, no counters, no typewriter, no particles, no
  carousels, no preloader, no custom cursor, no WebGL, no video background.
- ≤15% of elements animate. No entrance animation on above-the-fold hero text.
- `prefers-reduced-motion: reduce` disables all of it — the guard ships in the
  file and is not removed.

## 4. Conversion model — MIXED

This is the spec's most important behavioural rule. Two modes on one site.

### Mode A — urgent (WhatsApp-first)

**Only** `/servicios/respuesta-a-incidentes` and the incident band on the home
page (section 06).

- Primary CTA: WhatsApp, `.btn--primary` sized larger than anywhere else.
- **`tel:` is co-primary** — same size, same visual weight, directly beside it.
  A breached company at 23:00 uses whichever is closer to their thumb.
- Mobile sticky bar on that page: WhatsApp left, "Llamar" right, 50/50 split.
- Sticky bar background uses `--danger` `#B3261E` on that page only.
- The advisory line ships on that page verbatim (see `BUILD-SPEC-PAGES.md` §3).

### Mode B — consult/offer-first (everywhere else)

- Primary CTA: **"Agendá una llamada"** → `/contacto#agendar`, `.btn--primary`.
- Secondary: **"Escribinos por WhatsApp"**, `.btn--wa`.
- Tertiary: the form at `/contacto`.
- WhatsApp FAB present on every page; sticky mobile bar shows
  "Agendá una llamada" primary + WhatsApp secondary.

### WhatsApp link format

Built from `--wa-number` in one place. **Every link carries a prefilled message
identifying site and page** — on a shared stage-1 number this is the only
attribution that exists.

```
https://wa.me/595995628862?text=Hola%2C%20vengo%20de%20ciberseguridad.com.py%20({slug})%20-%20
```

Per-page `{slug}` values are given with each page. Example, incident page:

```
https://wa.me/595995628862?text=Hola%2C%20vengo%20de%20ciberseguridad.com.py%20(incidente)%20-%20necesitamos%20ayuda%20urgente
```

The number also appears as **visible selectable text** in the header, the
contact page and the footer — many people copy it by hand.

### Analytics attributes

Every CTA carries `data-ev` and `data-ev-loc`. Ship the 350-byte inert shim from
`web-design-system/references/analytics-prep.md` on every page.

```
data-ev="whatsapp_click" | "call_click" | "form_submit" | "schedule_click"
data-ev-loc="hero" | "router" | "servicios" | "incidente" | "cta_final" | "footer" | "fab" | "sticky"
```

## 5. Global shell

### 5.1 `<head>` — every page

```html
<!doctype html><html lang="es-PY">
<meta charset="utf-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<title>{per page}</title>
<meta name="description" content="{per page}">
<link rel="canonical" href="https://ciberseguridad.com.py{path}">
<meta property="og:type" content="website">
<meta property="og:locale" content="es_PY">
<meta property="og:title" content="{per page}">
<meta property="og:description" content="{per page}">
<meta property="og:url" content="https://ciberseguridad.com.py{path}">
<meta property="og:image" content="https://ciberseguridad.com.py/assets/img/og-ciberseguridad-paraguay.jpg">
<meta name="twitter:card" content="summary_large_image">
<link rel="icon" href="/favicon.svg" type="image/svg+xml">
<link rel="preload" as="font" type="font/woff2" crossorigin href="/assets/fonts/GeneralSans-Regular.woff2">
<link rel="preload" as="font" type="font/woff2" crossorigin href="/assets/fonts/GeneralSans-Medium.woff2">
<style>/* critical CSS, inlined per page */</style>
<link rel="stylesheet" href="/assets/css/site.css" media="print" onload="this.media='all'">
```

⚠️ **Until launch, every page carries** `<meta name="robots" content="noindex,nofollow">`.
Removing it is a line item on the launch gate, not an afterthought.

### 5.2 Header — sticky, all pages

Left: wordmark **`Ciberseguridad.com.py`** as text, 450 weight, `--ink`, no
padlock, no shield, no icon of any kind.

Nav: `Servicios ▾` · `Para tu rubro ▾` · `Guías` · `Nosotros` · `Contacto`

Right: phone as visible text `+595 995 628862` (`tel:` link,
`data-ev="call_click" data-ev-loc="header"`) + `.btn--primary` **"Agendá una llamada"**.

Mobile <1024px: hamburger → full-screen panel, nav stacked, phone text and both
CTAs pinned to the bottom of the panel.

### 5.3 Footer

Four columns ≥1024px, stacked below. `.grain` on the dark field.

```
Ciberseguridad.com.py
Seguridad informática para empresas paraguayas.

Asunción, Paraguay
+595 995 628862
⚠️ contacto@ciberseguridad.com.py

Servicios            Para tu rubro          La empresa
Auditoría            Clínicas               Nosotros
Pentesting           Estudios contables     Cómo cotizamos
Respuesta a incidentes  Tiendas online      Guías
Cumplimiento         PYMES                  Preguntas frecuentes
Capacitación                                Contacto
```

Bottom bar, verbatim:

```
Este sitio publica su propia configuración de seguridad — verificala vos mismo:
SSL Labs · securityheaders.com · security.txt

© 2026 Ciberseguridad.com.py · Política de privacidad · Términos
```

**No street address. No postal code. No map. No `aggregateRating`. No
"desde 20XX".** `Asunción, Paraguay` is the complete location line — mode 3
§10.2. ⚠️ RUC row is **hidden entirely** until a real RUC is supplied; when it
is, it goes on its own line above the phone.

### 5.4 WhatsApp FAB — every page

`position:fixed; right:16px; bottom:16px`, min 56×56px,
`aria-label="Escribinos por WhatsApp"`, `data-ev="whatsapp_click" data-ev-loc="fab"`.
Ink circle, `#25D366` glyph only. Below 768px it lifts to `bottom:88px` and
`body` gets `padding-bottom:88px` so it clears the sticky bar.

### 5.5 Sticky mobile bar — below 768px

Mode B pages: "Agendá una llamada" (accent, 60%) + WhatsApp (ink, 40%).
Mode A page: WhatsApp (50%) + "Llamar ahora" (50%), bar background `--danger`.

## 6. Responsive contract — non-negotiable

Base styles written for 360px; larger screens add on.

- Breakpoints, exactly three: `640px` · `1024px` · `1280px`.
- All splits (P1, P7, P12) collapse to one column below 1024px. Visual **above**
  text in the hero, **below** text everywhere else.
- P3 grid → 2 columns below 1024px → 1 below 640px.
- P5 process rail → vertical with a connecting 1px line below 768px.
- P7 sticky column: `position:sticky` disabled below 1024px.
- No fixed pixel widths on content. `.wrap` = `width:min(1200px, 100% - 48px)`,
  `100% - 32px` below 640px.
- All typography in `clamp()`.
- `aspect-ratio` on the hero image against CLS.
- Full-bleed: `width:100vw; margin-left:calc(50% - 50vw)` + `overflow-x:hidden`
  on `body`.
- Tap targets ≥48×48px.
- **Test at 360 / 390 / 768 / 1024 / 1440. Zero horizontal scroll at every one.**
  Check: `document.documentElement.scrollWidth === document.documentElement.clientWidth`.

## 7. File tree

```
public_html/
  index.php
  servicios/
    auditoria-de-seguridad.php
    pentesting.php
    respuesta-a-incidentes.php
    cumplimiento.php
    capacitacion.php
  para/
    clinicas.php
    contadores.php
    ecommerce.php
    pymes.php
  guias/
    responder-un-cuestionario-de-seguridad.php
    index.php
  precios.php
  nosotros.php
  contacto.php
  preguntas-frecuentes.php
  gracias.php
  404.php
  enviar.php                      → includes ../src/form-handler.php
  politica-de-privacidad.php
  terminos.php
  .htaccess
  robots.txt
  sitemap.xml
  favicon.svg
  .well-known/security.txt
  assets/
    css/site.css
    js/site.js
    fonts/GeneralSans-{Regular,Medium,Semibold}.woff2
    img/*.avif  *.webp  og-ciberseguridad-paraguay.jpg
src/                              OUTSIDE the web root
  config.php  render.php  form-handler.php  vendercrm.php  validate.php
  partials/{head,header,footer,form,cta-final,fab}.php
storage/                          OUTSIDE the web root, git-ignored
  leads.csv  form.log
```

Extensionless URLs via `.htaccess`:

```apache
RewriteCond %{REQUEST_FILENAME}.php -f
RewriteRule ^(.*)$ $1.php [L]
```

## 8. Home page — `/`

**Slug:** `home` · **WhatsApp `{slug}`:** `inicio` · **`source`:** `cyber:home`
**Primary keyword:** `empresa de ciberseguridad en paraguay`

```
Title:       Ciberseguridad para empresas en Paraguay | Auditoría, pentesting y respuesta a incidentes
Description: Auditorías de seguridad, pentesting, respuesta a incidentes, cumplimiento y capacitación para empresas paraguayas. Alcance y precio fijo por escrito. Escribinos.
```

Sections follow §d of `STEP0_RECON.md`. **All copy below is verbatim.**

---

### 02 — Hero · pattern **P1** asymmetric split 7/5

Left 7 cols. Right 5 cols: `hero-bleed` image, `--r-md`, `aspect-ratio:16/10`,
`fetchpriority="high"`, **not lazy**. Above the text below 1024px.

> `.eyebrow` — **ASUNCIÓN · PARAGUAY**
>
> `<h1>` — **Ciberseguridad para empresas paraguayas que ya no pueden improvisar.**
>
> Auditorías, pentesting, respuesta a incidentes, cumplimiento y capacitación
> para empresas que manejan datos que le importan a alguien más: pacientes,
> clientes, socios, medios de pago.
>
> Trabajamos con alcance y precio fijo por escrito. Sin abono por hora abierto,
> sin promesas de seguridad absoluta.
>
> [ **Agendá una llamada** ] `.btn--primary` `data-ev="schedule_click" data-ev-loc="hero"`
> [ Escribinos por WhatsApp ] `.btn--wa` `data-ev="whatsapp_click" data-ev-loc="hero"`
>
> `small` — Primera conversación de 30 minutos, sin costo y sin compromiso.

No entrance animation on this block.

---

### 03 — Router de situación · pattern **P3** staggered-weight grid

Four `card--accent`, 2×2 ≥1024px. Each card is a link to its service page.
This is the most important block on the page: the visitor self-identifies in
three seconds.

> `.eyebrow` — **¿POR DÓNDE EMPEZAR?**
>
> `<h2>` — Decinos en qué situación estás.
>
> Cada una necesita algo distinto. Elegí la que más se parece a la tuya.

| Card | Título (h3) | Cuerpo | CTA → |
|---|---|---|---|
| 1 | **«Nos atacaron.»** | Ransomware, una cuenta tomada, plata que se fue a la cuenta equivocada. Necesitás contener el daño hoy, no la semana que viene. | Respuesta a incidentes → `/servicios/respuesta-a-incidentes` |
| 2 | **«Un cliente nos pidió un cuestionario de seguridad.»** | Te llegó una planilla con doscientas preguntas y una fecha límite, y nadie en la empresa sabe por dónde empezar. | Cumplimiento → `/servicios/cumplimiento` |
| 3 | **«Queremos saber cómo estamos parados.»** | Nunca nadie revisó la seguridad de la empresa desde afuera y ya es momento de tener un diagnóstico honesto. | Auditoría de seguridad → `/servicios/auditoria-de-seguridad` |
| 4 | **«Queremos que alguien intente entrar antes que otro.»** | Tenés un sistema, una app o una red y querés saber qué pasa cuando alguien la ataca en serio, con autorización y por escrito. | Pentesting → `/servicios/pentesting` |

---

### 04 — Franja de confianza · pattern **P8** full-bleed ribbon

Edge-to-edge `--ink` band, 1–2 lines tall, `.grain`. Four items separated by a
hairline divider. No cards, no icons.

> **Alcance y precio fijo por escrito** · **Informe con hallazgos priorizados y
> plan de remediación** · **Sin servicios ofensivos ni escaneos sin autorización**
> · **Este sitio publica su propia configuración de seguridad**

⚠️ When the RUC exists, it becomes a fifth item: `RUC {número}`.
⚠️ When certifications exist, they become a sixth. **Neither is invented. Until
supplied, the item does not exist** — do not add a placeholder chip.

---

### 05 — Servicios · pattern **P7** sticky-side scroll

Left column `position:sticky; top:12vh` (disabled <1024px) holding the heading.
Right column: five items scrolling past. Item 1 is `card--ink` (the primary
service); items 2–5 are `card--hair`. Each carries its `card-motif` image.

**Left, sticky:**

> `.eyebrow` — **SERVICIOS**
>
> `<h2>` — Cinco cosas, hechas bien.
>
> No hacemos todo. Hacemos esto, con alcance cerrado y un entregable que
> podés mostrarle a tu directorio o a tu proveedor de IT.

**Right:**

**1 · Auditoría de seguridad** `card--ink` · img `auditoria-de-seguridad`
> Revisamos cómo está parada tu empresa: identidades y accesos, equipos,
> copias de seguridad y sus pruebas de restauración, seguridad del correo y
> exposición a fraude de facturas, segmentación de la red, proveedores con
> acceso y preparación ante incidentes.
> Recibís un informe con los hallazgos priorizados por riesgo real y un plan
> de remediación que tu proveedor de IT puede ejecutar.
> **Ver auditoría de seguridad →**

**2 · Pentesting** `card--hair` · img `pentesting`
> Pruebas de penetración sobre tu aplicación, tu sitio o tu red interna,
> siempre con autorización escrita y alcance definido de antemano.
> Te entregamos cada hallazgo con su prueba de concepto, su impacto explicado
> en términos de negocio y cómo corregirlo. Después reprobamos las
> correcciones sin costo adicional.
> **Ver pentesting →**

**3 · Respuesta a incidentes** `card--hair`
> Si ya pasó, lo primero es contener. Trabajamos con vos desde el primer
> llamado: contención, análisis de qué entró y por dónde, recuperación
> ordenada y un informe de cierre que sirve para el seguro, para el cliente
> que pregunta y para que no vuelva a pasar.
> **Ver respuesta a incidentes →**

**4 · Cumplimiento** `card--hair` · img `cumplimiento`
> Cuestionarios de seguridad de clientes y bancos, análisis de brechas contra
> el marco que te están pidiendo, y la carpeta de evidencias que respalda cada
> respuesta. También acompañamiento para la Ley 6534/2020 de protección de
> datos personales.
> **Ver cumplimiento →**

**5 · Capacitación** `card--hair` · img `capacitacion`
> Formación para el equipo que realmente toca los datos: cómo reconocer un
> pedido de cambio de cuenta bancaria, qué hacer con un correo raro, cómo
> proteger las cuentas de la empresa. Presencial en Gran Asunción o remoto.
> **Ver capacitación →**

---

### 06 — Respuesta a incidentes · pattern **P6** bleed-image overlap

**This is the page's required overlap and one of its two full-bleeds.**

Full-bleed `section-break` image, `.scrim` + `.grain`, 50–60vh. Heading over the
image. A `card--raised` panel crosses the bottom boundary by `translateY(40%)`
into section 07.

**Over the image:**

> `.eyebrow` — **URGENCIAS**
>
> `<h2>` — ¿Ya está pasando?
>
> Si tenés un incidente en curso, no completes un formulario. Escribinos o
> llamanos ahora.

**In the overlapping `card--raised` panel:**

> **Si sospechás que tu correo o tu teléfono están comprometidos, llamanos
> desde otro dispositivo.**
>
> [ **Escribinos por WhatsApp** ] `.btn--primary` `data-ev-loc="incidente"`
> [ **+595 995 628862** ] `.btn--ghost` `tel:` `data-ev="call_click" data-ev-loc="incidente"`
>
> `small` — ⚠️ Atendemos incidentes las 24 horas, todos los días.

⚠️ **BLOCKING — the 24/7 line.** It ships as written **only if someone genuinely
answers at 02:00 on a Sunday.** If not, replace that one line, everywhere it
appears on the site, with exactly:

> `small` — Respondemos en horario laboral y devolvemos las llamadas fuera de horario.

Publishing an unmet response commitment is listed in `PLAN.md` §6 as a named
reputational risk. Do not ship the 24/7 wording on assumption.

---

### 07 — Cómo trabajamos · pattern **P5** numbered process rail

Four-up horizontal ≥1024px — three steps plus the closing note. Oversized step
numbers at `--t-5`, accent, 20% opacity, behind the text. Vertical rail with a
connecting 1px line below 768px.

> `.eyebrow` — **CÓMO TRABAJAMOS**
>
> `<h2>` — Sin sorpresas en la factura.

**01 · Conversación inicial — 30 minutos, sin costo**
> Nos contás la situación. Te decimos con franqueza si somos las personas
> indicadas para resolverla y, si no lo somos, te lo decimos igual.

**02 · Propuesta con alcance y precio fijo — 2 a 3 días hábiles**
> Qué se hace, qué no se hace, qué recibís y cuánto cuesta. Por escrito, antes
> de empezar. No facturamos por hora abierta.

**03 · Ejecución y entrega**
> Hacemos el trabajo y entregamos un informe con los hallazgos priorizados por
> riesgo y un plan de remediación concreto, escrito para que tu proveedor de IT
> lo pueda ejecutar sin traducción.

---

### 08 — Para tu rubro · pattern **P4** editorial two-column

Heading in the left 4 columns, list in the right 7, one gutter column between.
Body capped at 65ch. Four links on hairline rules — **not cards.**

**Left:**

> `.eyebrow` — **PARA TU RUBRO**
>
> `<h2>` — El riesgo no es igual en todos lados.

**Right:**

> **Clínicas y consultorios →** Historias clínicas, agenda y facturación en la
> misma red que el equipamiento de imágenes. Cuando se cae, no se cae un
> sistema: se cae la atención.
>
> **Estudios contables →** Concentrás los datos financieros de decenas de
> clientes en una sola oficina, y la credencial del portal de la SET es un
> único punto de falla.
>
> **Tiendas online →** El checkout, el panel de administración y los datos de
> tus clientes. Un skimmer inyectado en el pago no se ve y factura durante meses.
>
> **PYMES →** Tenés soporte de IT pero no tenés función de seguridad, y nadie
> te dijo nunca cuál es la diferencia.

---

### 09 — Postura técnica verificable · pattern **P10** data panel

`card--raised` on a `--surface` field. Three real, live third-party links.

> `.eyebrow` — **PREDICAMOS CON EL EJEMPLO**
>
> `<h2>` — No te pedimos que nos creas. Verificalo.
>
> Una empresa de seguridad cuyo propio sitio está mal configurado ya te dijo
> todo lo que necesitabas saber. Este sitio corre con HSTS con preload, una
> política de contenido estricta, sin scripts de terceros, con DNSSEC y con
> DMARC en `p=reject`.
>
> Estos tres enlaces no los controlamos nosotros:
>
> [ Calificación en SSL Labs ↗ ] [ Cabeceras en securityheaders.com ↗ ] [ security.txt ↗ ]

⚠️ **LAUNCH GATE.** This section **must not ship** until the scans actually
return A+ / A. Publishing it while scoring a B is worse than not publishing it.
If the grades are not in hand at launch, the section is removed — not softened.

**No decorative SVG diagrams anywhere on this site.** No network topology art,
no concentric "security layers", no map with attack arcs. If a diagram does not
encode real data, it does not exist.

---

### 10 — Statement CTA · pattern **P9** oversized statement

The page's one expensive moment. `--ink` field, `.grain`, `.statement` at
`--t-6`, `line-height:.95`. Nothing else in the section but the sub-line and one
button.

> `.statement` — **Media hora ahora cuesta menos que un lunes entero apagando incendios.**
>
> Contanos qué te preocupa. Si no somos los indicados, te lo decimos en la
> primera llamada.
>
> [ **Agendá una llamada** ] `.btn--primary` `data-ev-loc="cta_final"`

---

### 11 — Preguntas frecuentes · pattern **P4** editorial two-column

Heading left 4 cols; questions right 7 as `<details>`/`<summary>` separated by
`1px solid var(--hairline)` rules. **Not cards** — this keeps `card--hair` at
four uses on the page, within the ≤4 limit.

Feeds `FAQPage` JSON-LD. Five questions, verbatim:

**¿Trabajan solo en Asunción?**
> Trabajamos con empresas de todo el país. La mayor parte del trabajo es
> remoto; en Gran Asunción también vamos presencialmente cuando el trabajo lo
> requiere, y fuera del Gran Asunción lo coordinamos según el caso.

**¿Cuánto cuesta una auditoría?**
> Depende del tamaño de la empresa y del alcance, y por eso lo cotizamos
> después de una conversación de 30 minutos. Lo que sí te garantizamos es que
> vas a recibir un precio fijo por escrito antes de que empecemos, no una
> factura por hora al final.

**¿Hacen el trabajo ustedes o lo tercerizan?**
> Lo hacemos nosotros. Si en algún punto necesitamos a un tercero, te lo
> decimos antes y figura en la propuesta con nombre y alcance.

**Nuestro proveedor de IT dice que ya estamos seguros. ¿Para qué los necesitamos?**
> Porque nadie audita bien su propio trabajo, y no es un problema de honestidad
> sino de perspectiva. Tu proveedor de IT mantiene los sistemas funcionando;
> nosotros miramos lo mismo desde afuera y con otra pregunta en la cabeza. Los
> hallazgos se los entregamos a ellos para que los corrijan.

**¿Publican los nombres de sus clientes?**
> No, y no lo vamos a hacer con el tuyo tampoco. En seguridad, quién contrató a
> quién es información sensible. Si necesitás referencias, las coordinamos
> directamente y con permiso previo de la otra empresa.

---

### 12 — Contacto · pattern **P1** mirrored 5/7

Left 5 cols: the three channels. Right 7 cols: the form (§10).

**Left:**

> `.eyebrow` — **CONTACTO**
>
> `<h2>` — Escribinos.
>
> **Por WhatsApp** — la vía más rápida. `+595 995 628862`
> [ Escribinos por WhatsApp ] `.btn--wa` `data-ev-loc="contacto"`
>
> **Por teléfono** — `+595 995 628862` (visible text + `tel:`)
>
> **Por correo** — ⚠️ `contacto@ciberseguridad.com.py`
>
> **Agendá una llamada** — media hora, sin costo, para entender tu situación.
>
> `small` — Si tenés un incidente en curso, no uses el formulario: escribinos o
> llamanos ahora.

**Right:** the contact form per §10, with the intro line:

> Contanos brevemente y te respondemos en el día hábil.

---

### 13 — Footer

Per §5.3.

## 9. Image plan

Manifest and prompts: `STEP0_RECON.md` §e and §f. Six generated images, saved
`01.png`…`06.png` in manifest order.

| n | Slot | File (stem) | Placement |
|---|---|---|---|
| 1 | `hero-bleed` | `empresa-de-ciberseguridad-asuncion-paraguay` | home §02, right column |
| 2 | `section-break` | `respuesta-a-incidentes-de-seguridad-paraguay` | home §06 + `/servicios/respuesta-a-incidentes` |
| 3 | `card-motif` | `auditoria-de-seguridad-informatica` | home §05 item 1 + `/servicios/auditoria-de-seguridad` |
| 4 | `card-motif` | `pentesting-pruebas-de-penetracion` | home §05 item 2 + `/servicios/pentesting` |
| 5 | `card-motif` | `cumplimiento-y-cuestionarios-de-seguridad` | home §05 item 4 + `/servicios/cumplimiento` + `/guias/...` |
| 6 | `card-motif` | `capacitacion-en-ciberseguridad-para-empresas` | home §05 item 5 + `/servicios/capacitacion` |

Every image ships AVIF + WebP at 640 / 1280 / 1920 inside `<picture>`, with
explicit `width`/`height`. Hero ≤120 KB, `fetchpriority="high"`, **not lazy**.
Everything below the fold `loading="lazy"`.

⚠️ `proof-photo` slots and any practitioner portrait: **PENDING, real only.**
Never generated, never captioned with a name. If no photo exists, the slot is
removed — not filled with a generated face.

⚠️ `higgsfield-web-imagery/references/fetch-images.mjs` is missing from the
skill install. Write an equivalent ~30-line `sharp` script at placement time, or
restore the file first.

## 10. Form contract

Base spec: `PHP_FORM_SPEC.md`. **Three amendments, which take precedence:**

**1. New field** — `preferencia_de_contacto`, select, required, placed directly
after `telefono`:

```
whatsapp  (Prefiero WhatsApp)
llamada   (Prefiero que me llamen)
email     (Prefiero correo)
```
Label: **¿Cómo preferís que te contactemos?**
Carried into `fields` as an enum string.

**2. `disparador` enum updated** to match the five published services. `continuo`
is removed — no retainer service is published, and an enum value that maps to no
page produces leads for something the site does not sell.

```
incidente      (Tuvimos un incidente)
cuestionario   (Un cliente nos pidió un cuestionario de seguridad)
diagnostico    (Queremos saber cómo estamos)
pentesting     (Queremos una prueba de penetración)
cumplimiento   (Tenemos una obligación que cumplir)
capacitacion   (Queremos capacitar al equipo)
otro           (Otra cosa)
```

**3. `#agendar` anchor** on `/contacto` — the "Agendá una llamada" CTA target.
It focuses the form and preselects `preferencia_de_contacto=llamada`. It is
**not** a third-party booking embed: no Calendly, no external script. The CSP
forbids it and a scheduling widget is not worth the exception.

Everything else in `PHP_FORM_SPEC.md` stands unchanged, including the hard rule
that the form never collects cédula, RUC, uploads, system details, credentials
or network diagrams, and the hint line beside the message field.

## 11. Lead connection

Per `docs/VENDERCRM_INTEGRATION.md`, unchanged. Execution checklist:

- Browser never talks to VenderCRM. Form → `/enviar` → `src/form-handler.php` →
  `POST {CRM_URL}/api/v1/leads` with `X-Api-Key` from the environment.
- `source` = `cyber:{page-slug}` — e.g. `cyber:servicios/pentesting`.
  Home is `cyber:home`. WhatsApp conversations logged by hand use
  `cyber:whatsapp-manual`.
- `idempotency_key` = `sha256(phone + "|" + YYYY-MM-DD-HH)`.
- `fields` carries `empresa`, `empleados`, `rubro`, `disparador`,
  `preferencia_de_contacto`, `form_type` — enum strings only, free text goes in
  `message`.
- Write to `storage/leads.csv` under `flock` **before** calling the CRM. Never
  block the visitor on the CRM: 10s timeout, try/catch, show `/gracias` anyway,
  log the failure.
- Omit optional fields rather than sending `""`.
- ⚠️ **Create the site record in VenderCRM → Sitios now**, before the form is
  written, so the key exists. Until it does, `VENDERCRM_URL` and
  `VENDERCRM_API_KEY` are environment placeholders and the handler logs to
  `storage/form.log`. **No `mailto:`, no Formspree, no third-party endpoint** —
  ever, at any stage.
- `vc-attribution.js` (rule 6) is the **single** permitted third-party script
  and needs an explicit CSP `script-src` allowance for the CRM origin. Note it
  in the CSP header; do not silently add `unsafe-inline` to make it work.

## 12. Placeholder list — everything assumed

Nothing below is invented on the page. Each either ships as specified, or its
element is **hidden entirely** until the real value arrives.

| # | Item | Default until answered | Blocking? |
|---|---|---|---|
| 1 | **24/7 incident response is real** | Ships as 24/7 per the brief. ⚠️ Swap to the business-hours line in §06 if untrue. | **Yes — launch** |
| 2 | **Certifications held** | Trust ribbon item does not exist. `/nosotros` credentials block omitted. | No |
| 3 | **RUC** | Footer RUC line and ribbon item hidden. | No |
| 4 | **Named + photographed practitioner** | `/nosotros` ships in its unnamed form (`BUILD-SPEC-PAGES.md` §11), which is complete and honest as written. Named block drops in additively. | No |
| 5 | **Prices published** | No amounts anywhere. `/precios` is "Cómo cotizamos". | No |
| 6 | Email address | `contacto@ciberseguridad.com.py` assumed — confirm the mailbox resolves before launch. | **Yes — launch** |
| 7 | VenderCRM site key | Env placeholder, handler logs locally. | No |
| 8 | SSL Labs / securityheaders grades | Section 09 does not ship until A+/A confirmed. | **Yes — launch** |
| 9 | `fetch-images.mjs` | Write a `sharp` equivalent. | No |

**Anti-fabrication, hard:** zero invented reseñas, ratings, client counts, years
in business, guarantees, certifications, RUC, client names, logos, prices, or
statistics. No `aggregateRating` in schema. Any statistic that appears carries a
link to a named primary source, or it does not appear. Never promise security,
immunity, or an outcome.

## 13. Schema — `/` only

Service-area business. `streetAddress` is **deliberately omitted** — do not add
one.

```json
{
  "@context":"https://schema.org","@type":"ProfessionalService",
  "name":"Ciberseguridad.com.py",
  "url":"https://ciberseguridad.com.py",
  "telephone":"+595995628862",
  "address":{"@type":"PostalAddress","addressLocality":"Asunción","addressRegion":"Central","addressCountry":"PY"},
  "areaServed":[{"@type":"Country","name":"Paraguay"}],
  "knowsAbout":["auditoría de seguridad informática","pentesting","respuesta a incidentes","cumplimiento normativo","capacitación en ciberseguridad"]
}
```

Plus `FAQPage` from §11 and `BreadcrumbList` on every interior page.
`Service` schema on each `/servicios/*` page — see `BUILD-SPEC-PAGES.md`.

No `openingHours` unless it is true. No `aggregateRating`. No `priceRange` while
no prices are published.

## 14. QA gate — every box ticked before anything is shown

**Content integrity**
- [ ] Zero placeholder text in rendered output. No `[COMPLETAR]`, no lorem, no TODO.
- [ ] Zero empty rows, dangling dashes, half-filled tables.
- [ ] Zero fabricated reseñas, ratings, counts, years, certifications, guarantees, prices.
- [ ] Every image slot has an asset or is listed as pending in §12.
- [ ] Section 09 removed if the scan grades are not in hand.

**Language and conversion**
- [ ] Voseo in every CTA. Zero `tú` forms. Zero English in UI text.
- [ ] `<html lang="es-PY">` on every page.
- [ ] WhatsApp links tested; format `5959…`, no `+`, no spaces; prefilled text unique per page.
- [ ] `+595 995 628862` visible as selectable text in header, contact and footer.
- [ ] `--wa-number` appears exactly once in the codebase.
- [ ] Mode A / Mode B CTA hierarchy correct on every page (§4).

**Layout**
- [ ] No unintentional overlap at 360 / 768 / 1280 / 1920.
- [ ] No more than 2 consecutive sections share a pattern.
- [ ] ≥1 full-bleed, ≥1 intentional overlap, ≥1 oversized statement.
- [ ] ≥3 card variants; none more than 4×. (FAQ uses `<details>`, not cards.)
- [ ] Zero horizontal scroll at 360 / 390 / 768 / 1024 / 1440.

**Type and colour**
- [ ] One family, weights 400/450/500, preloaded, `font-display:swap`.
- [ ] Body ≥17px, line-height ≥1.6, measure ≤65ch.
- [ ] Muted text ≥4.5:1 against its actual background.
- [ ] Exactly one accent. `#25D366` only inside a WhatsApp glyph. `#B3261E` only on the incident page.

**Motion**
- [ ] `prefers-reduced-motion: reduce` disables everything — tested.
- [ ] ≤15% of elements animate. No entrance animation on hero text. No parallax <1024px.

**Performance**
- [ ] Hero ≤120 KB, AVIF + WebP, `fetchpriority="high"`, not lazy.
- [ ] All below-fold images lazy with explicit dimensions.
- [ ] Total page ≤500 KB. Lighthouse mobile ≥90. LCP <2.5s, CLS <0.1.

**Technical**
- [ ] One H1 per page. Semantic landmarks. Skip-to-content link. Spanish alt text.
- [ ] Canonical, og tags with a real image, viewport, favicon on every page.
- [ ] JSON-LD validates. `FAQPage` where an FAQ exists. No `aggregateRating`.
- [ ] Form posts to the site's own PHP handler. No `mailto:`, no third-party endpoint, no API key in client source.
- [ ] `data-ev` on every CTA; shim present; `whatsapp_click`, `call_click`, `form_submit`, `schedule_click` fire with `page_path`.
- [ ] WCAG 2.1 AA: keyboard navigation, visible focus ring, labels bound, errors announced and linked.
- [ ] Cookie consent banner present, nothing pre-ticked (Ley 6534/2020).
- [ ] `noindex,nofollow` present on every page until launch, then removed deliberately.

**Launch gate — additionally blocking**
- [ ] A+ on SSL Labs, A on securityheaders.com.
- [ ] HSTS with `preload`, submitted. CSP with no `unsafe-inline`. `frame-ancestors 'none'`.
- [ ] `X-Content-Type-Options`, `Referrer-Policy`, `Permissions-Policy`, `X-Frame-Options: DENY`.
- [ ] `/.well-known/security.txt` with a real contact and an expiry date.
- [ ] DNSSEC on the domain. SPF, DKIM, DMARC `p=reject`.
- [ ] `expose_php = Off`, directory listing off, `src/` and `storage/` outside the web root.
- [ ] VenderCRM round trip verified per `docs/VENDERCRM_INTEGRATION.md`: real submission, contact created, phone normalized, duplicate submission does **not** create a second contact.
