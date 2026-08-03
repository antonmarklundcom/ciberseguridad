# PRODUCT_SPEC.md — ciberseguridad.com.py

What gets built, page by page, with the copy direction and the design system.
Read `PLAN.md` first for why.

---

## 1. Site map

```
/                                     Home
/servicios/diagnostico                Diagnóstico de seguridad          [money]
/servicios/respuesta-a-incidentes     Respuesta a incidentes            [money, urgent]
/servicios/cuestionarios-de-proveedores  Cuestionarios de proveedores   [money, beachhead]
/servicios/seguridad-gestionada       Seguridad gestionada (retainer)   [money]
/para/clinicas                        Clínicas y consultorios
/para/contadores                      Estudios contables
/para/ecommerce                       Tiendas online
/para/pymes                           PYMES (entry / router page)
/recursos                             Hub
/recursos/autoevaluacion              Self-assessment tool     [Phase 2]
/recursos/checklist-de-incidentes     Incident checklist       [Phase 2]
/nosotros                             Who this actually is
/contacto                             Contact
/gracias                              Thank-you (noindex)
/politica-de-privacidad
/terminos
/blog/*                               Phase 3
/404
```

Phase 1 ships everything above except `/recursos/*` and `/blog/*`.

## 2. Global elements

### Header
Logo (wordmark, no padlock icon), nav: Servicios ▾ · Para tu rubro ▾ ·
Recursos · Nosotros · Contacto, and one accent CTA button "Escribinos".
Mobile: hamburger, full-screen panel, CTA pinned at the bottom of the panel.

### Sticky mobile CTA
Fixed bottom bar, 56px, accent background, WhatsApp icon + "Escribinos por
WhatsApp". Present on every page except `/servicios/respuesta-a-incidentes`,
where it is replaced by a `tel:` bar reading "Llamanos ahora".

### Footer
Real business name, real address, real phone in `+595` format, real email.
Nav repeat. Links to privacy, terms, and `security.txt`. A single line:
*"Este sitio publica su propia configuración de seguridad —
[verificala](https://securityheaders.com/?q=ciberseguridad.com.py)."*
The NAP block must be byte-identical to the contact page and to the JSON-LD.

### Technical-posture strip
A small block, shown on the home page and `/nosotros` only:

> **Practicamos lo que vendemos.** Este sitio corre con HSTS preload, CSP
> estricta, sin scripts de terceros, DNSSEC y DMARC en `p=reject`.
> Verificalo vos mismo: [SSL Labs] · [securityheaders.com] · [security.txt]

Three real links to live third-party scans. This must not ship until the scans
actually return those grades. Publishing it while scoring a B is worse than not
publishing it.

## 3. Page specifications

### `/` — Home

**Primary intent:** a referred or outbound-touched prospect verifying that this
is a real, competent firm.

| Section | Content |
|---|---|
| Hero | H1: *Seguridad informática para empresas paraguayas que ya no pueden improvisar.* Subline: what you do, for whom, and the next step — one sentence. Primary CTA. Real photo of the practitioner, not a stock image. |
| Trigger router | Four cards, one per buying trigger, each linking to its service page: *"Nos atacaron"* / *"Un cliente nos pidió un cuestionario de seguridad"* / *"Queremos saber cómo estamos"* / *"Necesitamos cumplir con algo"*. This is the most important block on the page — it lets every visitor self-identify in three seconds. |
| Servicios | The four services, one line each, linking through. |
| Cómo trabajamos | Three numbered steps with real timeframes. See §5. |
| Para tu rubro | Four vertical links. |
| Technical-posture strip | As above. |
| FAQ | 5 questions, feeding `FAQPage` schema. |
| Final CTA | Full-width accent section, one action. |

The hero must pass the three-question test at 390px: what do you do, for whom,
what next.

### `/servicios/diagnostico`

The general-purpose entry service and the one most prospects buy first.

Content: what it is, what is examined (name the domains concretely — identity
and access, endpoints, backups and restore testing, email security and BEC
exposure, network segmentation, third-party exposure, incident readiness), what
you receive, how long it takes, what it costs, what happens after.

**Include a real, redacted sample deliverable** — two or three pages of an
actual report with client identifiers removed, as a PDF. This is the single
highest-converting asset on the whole site. Prospects buying professional
services are trying to picture what arrives in their inbox; show them.

Price: publish a starting band ("desde Gs. X para empresas de hasta N puestos").
A concrete anchor converts better than "consultanos" and filters out prospects
who were never going to buy.

### `/servicios/respuesta-a-incidentes`

**The only page on the site with a real urgent search intent behind it.** Treat
it as a landing page for someone in a crisis at 11pm.

Requirements specific to this page:

- Phone number as H1-adjacent, `tel:` link, largest element after the H1.
- No hero image, no scroll reveal, no motion. Fastest page on the site.
- First content block is not marketing — it is **"Qué hacer ahora mismo"**:
  four immediate defensive steps (disconnect affected machines from the network
  but do not power them off; do not delete anything; do not pay; write down
  what you observed and when). Genuinely useful, entirely defensive, and it
  establishes competence faster than any claim could.
- The line: *"Si sospechás que tu correo o tu teléfono están comprometidos,
  llamanos desde otro dispositivo."*
- Then: what the engagement is, the first 48 hours, what is delivered.
- Response-time commitment **only if it is real**. If you cannot answer at 2am,
  say "respondemos en horario laboral y devolvemos llamadas fuera de horario"
  and let that be honest.

### `/servicios/cuestionarios-de-proveedores`

The commercial beachhead. Written for a company that has been sent a security
questionnaire by a bank, a multinational client, or an insurer, and has a
deadline.

Content: the situation named exactly as the reader experiences it ("Te llegó un
Excel de 200 preguntas y no sabés por dónde empezar"), what you do (gap
analysis against the requested framework, remediation plan, evidence pack,
completed questionnaire, support through the follow-up round), typical
timeline, what it costs, and what happens if the answer to a question is "no".

That last point is worth its own subsection and is a strong differentiator:
most companies fear the questionnaire because they assume any "no" disqualifies
them. Explaining that a documented remediation plan is usually acceptable is
exactly the kind of insight that converts a reader into a caller.

### `/servicios/seguridad-gestionada`

The retainer. Monthly ongoing work: patch and configuration review, backup
restore testing, access review, phishing simulation and training, quarterly
posture report, and named-contact incident support.

Be honest about what a retainer at this price is and is not. It is not a 24/7
SOC. Saying so builds more trust than implying otherwise.

### `/para/{vertical}` — the four vertical pages

**Hard rule: if 400 genuinely distinct words cannot be written for a vertical,
the page does not get built.** Templated vertical pages with a swapped noun are
transparent to readers and are doorway pages to Google.

Each must contain, specific to that sector:

1. The threat that actually hits this sector, described concretely.
2. The data they hold and why someone wants it.
3. The regulation or contractual obligation that applies to them.
4. What the engagement looks like for a business of this shape and size.
5. Route to the relevant trigger page(s).

Sector-specific angles:

- **Clínicas** — patient records, appointment and billing systems, imaging
  equipment on flat networks, ransomware with a direct patient-care impact,
  confidentiality obligations. Angle: continuity, not just data.
- **Contadores** — client financial data concentrated in one office, tax-season
  phishing, professional liability if client data leaks, the SET portal
  credential as a single point of failure. Angle: your clients' data is your
  professional reputation. Secondary purpose: this page is a referral-channel
  pitch as much as a service pitch.
- **Ecommerce** — payment flows, admin-panel takeover, card skimming injected
  into checkout, customer PII, fraudulent orders and chargebacks. Angle: the
  store staying open and the checkout staying trustworthy.
- **PYMES** — the router page. General framing, then honest routing to the
  three specific pages and the trigger pages. Do not try to make this page
  do everything.

### `/nosotros`

Under-appreciated and important. In this market a named, photographed,
credentialled human closes more than an agency identity.

Real name, real photo, real background, real certifications **if they exist**
(and nothing if they do not — see the anti-fabrication rule). What you will not
do (no offensive services, no scanning without authorisation, no scare
selling). How engagements are scoped and billed. Confidentiality and NDA
posture — say plainly that client names are not published, which explains the
absence of a logo wall and turns a weakness into a positioning statement.

### `/contacto`

WhatsApp button, phone, **a visible email address**, the form, business hours,
and the NAP block. Three fields plus two selects — see `PHP_FORM_SPEC.md`.
Next to the submit button, one line stating who receives the data and what
happens next.

### `/gracias`

`noindex`. Confirms receipt, restates the response time, offers the WhatsApp
link as a faster path, links to the resources hub. Fires the GA4 conversion.

## 4. Design system

Direction **B — Bento Profesional**, executed with restraint.

| Token | Value |
|---|---|
| Base | `#FFFFFF` |
| Surface / cards | `#F5F7FA` |
| Text / headings | `#0B2545` |
| Accent (CTA only) | `#2EC4B6` |
| Border | `#E2E8F0` |
| Danger (incident page only) | `#B3261E`, used for the phone CTA on that page only |

Headings: **Space Grotesk** 600/700, letter-spacing `-0.02em`.
Body: **Inter** 400/500, 17px, line-height 1.6, max 70ch.
Two families, four weights, self-hosted woff2, `font-display: swap`.

Type scale: 16 / 20 / 25 / 31 / 39 / 49, `clamp()` on the top two.
Spacing: 8px grid — 8/16/24/32/48/64/96. Section padding 96px desktop, 56px mobile.

**Motion — the complete permitted list:**
- 150–250ms `ease-out` on button and card hover/active states
- One fade-up-on-scroll reveal, via IntersectionObserver, 12px translate, once
- Nothing else. No parallax, no counters, no typewriter, no particles

`prefers-reduced-motion: reduce` disables all of it.

**Bento usage:** the trigger router on the home page and the services grid. Six
cells maximum, mobile single-column order defined first, no cell smaller than a
thumb target. Nowhere else.

**Imagery:** one real photograph of the practitioner. Screenshots of the
redacted deliverable. Simple line diagrams for the process. Zero stock photos,
zero padlocks, zero matrix rain, zero hooded figures, zero glowing circuit
boards, zero world maps with attack arcs.

**Anti-fluff, binding:** no WebGL, no scroll hijacking, no video backgrounds,
no preloaders, no custom cursors, no carousels, no chat widget that covers the
WhatsApp button.

## 5. Copy rules

- Voseo throughout. `Escribinos`, `Contactanos`, `Pedí`, `Agendá`, `enterate`.
- Second person, present tense, short sentences.
- Every claim is either verifiable or removed. No statistics without a linked
  primary source. The "60% of SMEs close within six months" line is folklore —
  it does not appear.
- No fear-based headlines. State the risk plainly once, then spend the rest of
  the page on what is done about it.
- Never promise security, immunity, or an outcome. Describe process and
  deliverables.
- Name real timeframes and real prices. Vagueness reads as evasion in this
  category.
- Technical terms are used correctly and then explained in one clause. Getting
  a term subtly wrong is the fastest way to lose a technical reader.

### Standard process block

Used on the home page and every service page, with per-service specifics:

1. **Conversación inicial (30 min, sin costo)** — you describe the situation,
   we tell you whether we are the right people for it.
2. **Propuesta con alcance y precio fijo (2–3 días hábiles)** — what is done,
   what is delivered, what it costs. No open-ended hourly billing.
3. **Ejecución y entrega** — the work, then a written report with prioritised
   findings and a remediation plan you can hand to your IT provider.

## 6. Trust inventory

What is used, given the anti-fabrication rule:

**Available now:** named practitioner with photo and real background; real
certifications if held; the redacted sample deliverable; a written methodology
with real timeframes; published fixed-scope pricing bands; the site's own
verifiable security posture; a stated confidentiality position; real NAP; a
published RUC.

**Available once earned:** named client references with written permission;
anonymised case studies ("una clínica de 40 empleados en Asunción") — permitted
because the claim is about the work, not a fabricated identity; sector
association memberships once actually joined.

**Never:** invented logos, star ratings, `aggregateRating` in schema, client
counters, "desde 20XX" if untrue, certifications not held, "certified partner"
claims without the partnership.

## 7. Accessibility

WCAG 2.1 AA. Body text ≥ 7:1 contrast where possible and never below 4.5:1;
the `#2EC4B6` accent is checked against white for button text and darkened if
it fails. Full keyboard navigation with a visible focus ring. Semantic
landmarks. Form labels bound to inputs; errors announced and linked to fields.
Alt text in Spanish on every meaningful image. Skip-to-content link.
