# SEO_ARCHITECTURE.md — ciberseguridad.com.py

Structure, targeting, technical baseline, and content plan.
Read `PLAN.md` §1 first: SEO is the secondary channel here, not the primary one.

---

## 1. What the market actually looks like

Paraguayan search volume for commercial cybersecurity terms is thin. A useful
mental model before choosing targets:

- Head terms (`ciberseguridad`, `seguridad informática`) carry the most volume
  and the worst intent. A large share is students, job seekers, and people
  looking for university courses. Ranking for them produces traffic and no
  leads.
- The commercially valuable queries are **long-tail, situational, and low
  volume** — tens of searches a month, not thousands, with intent so specific
  that a meaningful share of searchers are buyers.
- Competition is correspondingly weak. Most local competitors are IT resellers
  with a security page, not security firms. Genuinely useful, specific content
  ranks here with an effort that would be hopeless in a larger market.

The strategy that follows: **do not chase volume. Own the situations.** Ten
pages ranking for queries with thirty searches a month, where the searcher has
a problem and a budget, beat one page ranking for a term with two thousand
searches from people writing a thesis.

## 2. Architecture

Money pages are organised by **buying trigger**. Vertical pages are the
supporting layer and route into the triggers. This is the inversion of the
original brief and it is deliberate — see `PLAN.md` §2.

```
/                                            brand + category entry
│
├── /servicios/                              ← MONEY LAYER (trigger-based)
│   ├── diagnostico                          "queremos saber cómo estamos"
│   ├── respuesta-a-incidentes               "nos atacaron"          ← urgent intent
│   ├── cuestionarios-de-proveedores         "nos pidieron un cuestionario"
│   └── seguridad-gestionada                 "necesitamos apoyo continuo"
│
├── /para/                                   ← SUPPORTING LAYER (vertical)
│   ├── clinicas
│   ├── contadores
│   ├── ecommerce
│   ├── pymes                                router page
│   └── cooperativas                         Phase 3
│
├── /recursos/                               ← TOOLS (link magnets + capture)
│   ├── autoevaluacion
│   ├── checklist-de-incidentes
│   ├── quiz-phishing
│   └── verificador-de-backups
│
├── /blog/                                   ← INFORMATIONAL (feeds money pages)
│
├── /nosotros
└── /contacto
```

**No city pages.** This is a national B2B service delivered largely remotely.
Ten pages differing only by a swapped city name are doorway pages and are a
ranking liability. Asunción appears naturally in the NAP, the schema, the
footer and the home-page copy, which is sufficient for the local signal that
exists.

**No `/servicios/` index page beyond a simple hub.** Four service pages do not
need a landing page competing with them.

## 3. Keyword targeting

One page, one primary intent. No two pages compete for the same query.

| URL | Primary target | Secondary | Intent |
|---|---|---|---|
| `/` | empresa de ciberseguridad paraguay | seguridad informática empresas paraguay | Brand / category |
| `/servicios/diagnostico` | auditoría de seguridad informática paraguay | evaluación de seguridad empresa, análisis de vulnerabilidades empresa | Commercial |
| `/servicios/respuesta-a-incidentes` | ataque de ransomware qué hacer empresa | nos hackearon la empresa, recuperar archivos ransomware paraguay | **Urgent commercial** |
| `/servicios/cuestionarios-de-proveedores` | cuestionario de seguridad para proveedores | responder cuestionario de seguridad cliente, evaluación de proveedor seguridad | Commercial |
| `/servicios/seguridad-gestionada` | soporte de seguridad informática mensual | seguridad informática tercerizada paraguay | Commercial |
| `/para/clinicas` | seguridad informática para clínicas | protección de datos de pacientes paraguay | Vertical commercial |
| `/para/contadores` | seguridad informática para estudios contables | proteger datos de clientes estudio contable | Vertical commercial |
| `/para/ecommerce` | seguridad para tiendas online paraguay | proteger tienda online de fraude | Vertical commercial |
| `/para/pymes` | ciberseguridad para pymes paraguay | seguridad informática para empresas pequeñas | Vertical / router |
| `/recursos/autoevaluacion` | test de seguridad informática empresa | autoevaluación de ciberseguridad | Informational-to-commercial |
| `/recursos/checklist-de-incidentes` | qué hacer si hackean mi empresa | plan de respuesta a incidentes plantilla | Informational, urgent-adjacent |

`/servicios/respuesta-a-incidentes` is the highest-priority page on the site
for SEO purposes. It is the only URL targeting a query someone types in a
panic with a credit card available.

## 4. Titles and metas

≤60 and ≤155 characters, keyword front-loaded, conversion verb in the meta.

| URL | Title | Meta |
|---|---|---|
| `/` | Empresa de Ciberseguridad en Paraguay \| Ciberseguridad.com.py | Seguridad informática para empresas paraguayas. Diagnóstico, respuesta a incidentes y acompañamiento continuo. Escribinos por WhatsApp. |
| `/servicios/diagnostico` | Auditoría de Seguridad Informática para Empresas \| Paraguay | Evaluamos tu seguridad y te entregamos un informe con prioridades claras y precio fijo. Pedí tu diagnóstico por WhatsApp. |
| `/servicios/respuesta-a-incidentes` | Respuesta a Incidentes y Ransomware \| Ciberseguridad Paraguay | ¿Te atacaron? Qué hacer ahora mismo y cómo te ayudamos a contener, recuperar y evitar que se repita. Llamanos. |
| `/servicios/cuestionarios-de-proveedores` | Cuestionarios de Seguridad para Proveedores \| Paraguay | ¿Un cliente te pidió completar un cuestionario de seguridad? Te ayudamos a responderlo y a cerrar las brechas. |
| `/servicios/seguridad-gestionada` | Seguridad Informática Gestionada para Empresas \| Paraguay | Acompañamiento mensual: parches, backups verificados, accesos y capacitación. Consultá el alcance por WhatsApp. |
| `/para/clinicas` | Seguridad Informática para Clínicas y Consultorios \| Paraguay | Protegé historias clínicas y la continuidad de la atención. Diagnóstico específico para el sector salud. |
| `/para/contadores` | Seguridad Informática para Estudios Contables \| Paraguay | Los datos de tus clientes son tu reputación profesional. Evaluación y protección para estudios contables. |
| `/para/ecommerce` | Seguridad para Tiendas Online en Paraguay | Protegé tu checkout, tu panel de administración y los datos de tus clientes. Diagnóstico para ecommerce. |
| `/para/pymes` | Ciberseguridad para PYMES en Paraguay \| Guía y Servicios | Qué necesita realmente una empresa pequeña o mediana, sin humo y sin gastar de más. Empezá con la autoevaluación. |
| `/recursos/autoevaluacion` | Autoevaluación de Seguridad Informática \| Gratis, 5 minutos | Respondé 20 preguntas y obtené tu nivel de exposición con las 3 acciones prioritarias para tu empresa. |

Headings: exactly one H1 per page containing the primary term naturally. H2s
phrased as the questions people actually ask, which feeds both FAQ schema and
AI-answer surfaces.

## 5. Structured data

JSON-LD on every page, mirroring visible content exactly.

| Page | Schema |
|---|---|
| `/` | `Organization` + `WebSite` + `FAQPage` |
| `/servicios/*` | `Service` + `BreadcrumbList` (+ `FAQPage` where Q&As are visible) |
| `/para/*` | `Service` with `audience` + `BreadcrumbList` |
| `/recursos/*` | `WebApplication` + `BreadcrumbList` |
| `/blog/*` | `Article` + author `Person` + `BreadcrumbList` |
| `/contacto` | `Organization` with `ContactPoint` |

**`Organization`, not `LocalBusiness`.** This is a national B2B service, not a
walk-in business. Using `LocalBusiness` invites a local-pack interpretation
that does not fit and does not help.

**No `aggregateRating`. No `review`.** Not until real, displayed, attributable
reviews exist. This is the most common way a site of this type quietly earns a
structured-data manual action.

Phone in E.164 (`+595…`), identical to the footer, the contact page and GBP.

## 6. Technical baseline

- `es-PY` on `<html>`. No hreflang — single locale.
- Self-referencing canonical on every page.
- `sitemap.xml` containing only indexable 200s. `/gracias` and `/404` excluded
  and `noindex`.
- `robots.txt` allowing everything, blocking nothing in CSS/JS, linking the
  sitemap.
- Extensionless lowercase URLs, hyphens, no accents or `ñ` in slugs.
- Images AVIF/WebP with explicit dimensions, descriptive Spanish alt, and
  descriptive filenames (`diagnostico-seguridad-informatica-asuncion.webp`).
- Hero and LCP element never lazy-loaded; hero preloaded.
- OG image 1200×630 per money page, with the service name and brand legible at
  thumbnail size. In Paraguay these pages are shared into WhatsApp groups and
  the OG card is the advertisement — this is not a minor item.
- 404 page linking back to the four money pages.
- Google Search Console verified before launch; sitemap submitted day one.

The security headers in `STACK_DECISION.md` §6 also serve here: HTTPS and CWV
are ranking inputs, and the site's hardening delivers both as a side effect.

## 7. Internal linking

```
Blog post ──descriptive anchor──▶ Vertical page ──▶ Trigger/service page ──▶ CTA
Tool result ─────────────────────────────────────▶ Trigger/service page ──▶ CTA
Home trigger router ─────────────────────────────▶ Service pages
```

Rules:
- Every blog post links to at least one money page with descriptive anchor text
  within the first 400 words. No orphan content, ever.
- Every vertical page links to at least two service pages.
- Every tool result routes to a service page.
- Service pages link laterally to each other only where genuinely relevant
  (incident response → diagnostic as the follow-on engagement).
- Footer carries the four service links on every page.

## 8. Content plan

Twelve posts covering the twelve months of Phase 3, ordered by value. Every one
is defensive, specific, and locally grounded — which is precisely where there
is no competition.

| # | Working title | Target intent | Links to |
|---|---|---|---|
| 1 | Cómo responder un cuestionario de seguridad que te mandó un cliente (con ejemplo) | cuestionario seguridad proveedor responder | `/servicios/cuestionarios-de-proveedores` |
| 2 | El fraude del cambio de cuenta bancaria: cómo funciona y cómo cortarlo | fraude transferencia proveedor empresa | `/servicios/diagnostico` |
| 3 | Tenés backups. ¿Podés restaurarlos? Cómo verificarlo esta semana | verificar backups empresa | `/recursos/verificador-de-backups` |
| 4 | Qué hacer en las primeras 24 horas después de un ataque de ransomware | ransomware qué hacer empresa | `/servicios/respuesta-a-incidentes` |
| 5 | Ley 6534/2020 en la práctica: qué cambia si tu empresa guarda datos de clientes | ley 6534 datos personales paraguay empresas | `/servicios/diagnostico` |
| 6 | Robo de cuentas de WhatsApp empresariales: prevención y recuperación | robo cuenta whatsapp empresa paraguay | `/servicios/diagnostico` |
| 7 | Segundo factor de autenticación: por dónde empezar en una empresa chica | activar 2fa empresa | `/para/pymes` |
| 8 | Qué mira un banco cuando evalúa a un proveedor tecnológico | requisitos seguridad proveedor banco | `/servicios/cuestionarios-de-proveedores` |
| 9 | Historias clínicas y ransomware: el riesgo específico del sector salud | seguridad datos pacientes clínica | `/para/clinicas` |
| 10 | Cuando se va un empleado: la checklist de accesos que casi nadie hace | dar de baja accesos empleado | `/servicios/seguridad-gestionada` |
| 11 | Cuánto cuesta realmente la seguridad informática para una PYME paraguaya | cuánto cuesta ciberseguridad pyme | `/servicios/diagnostico` |
| 12 | Skimming en el checkout: cómo se roban tarjetas de una tienda online | fraude tarjetas tienda online | `/para/ecommerce` |

Cadence: one per month is enough. Two thin posts are worth less than one that
is genuinely the best Spanish-language page on its topic. Post 1 is the single
most valuable and should go up in the same week the blog launches.

**Editorial constraint:** posts explain how attacks work only to the depth
needed to defend against them, and never provide a reproducible method. Post 12
describes what skimming is and how to detect and prevent it; it does not
contain skimmer code.

## 9. Off-page

Given the market, links come from relationships rather than outreach campaigns.

- Google Business Profile created and completed, linked from schema `sameAs`.
- Chambers of commerce and sector association member directories — real
  memberships only.
- Guest articles for accountancy and clinic-sector publications and
  association newsletters. `/para/contadores` exists partly to make this pitch.
- Local business press: the incident-response and fraud content is genuinely
  newsworthy and journalists in this market need sources who explain clearly.
- LinkedIn: the practitioner's personal profile will outperform a company page
  in this category. Post the blog content there first.
- **No paid link building, no directory spam, no PBNs.** In a market this
  small, an unnatural link profile is both detectable and reputationally
  expensive.

## 10. Measurement

Track in GSC and GA4, reviewed monthly:

- Impressions and clicks for the eleven target queries specifically, not
  site-wide totals
- Ranking position for `respuesta a incidentes` variants — the leading
  indicator that matters most
- `whatsapp_click` events by `page_path`, so it is visible which pages convert
- Form submissions by source
- Assessment starts, completions, and completion-to-submission rate
- Scroll depth on service pages, as a proxy for whether the copy holds

Ignore: total sessions, bounce rate, time on site. In a market this small they
are noise, and optimising for them leads directly to chasing student traffic.
