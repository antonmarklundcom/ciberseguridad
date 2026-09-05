# STEP0_RECON.md — ciberseguridad.com.py

Mode 3 (regional vertical, EMD domain), track CLINICAL, mixed conversion model.
Produced under `paraguay-local-site` STEP 0 + `web-design-system` + `higgsfield-web-imagery`.

This document supersedes the design and conversion sections of the earlier
planning docs. See §7 for exactly what changes and what survives.

---

## a) 30 keyword candidates for Google Keyword Planner

Paste block, shortest first. No numbering by design.

```
ciberseguridad
seguridad informática
pentesting
hacking ético
auditoría de seguridad
respuesta a incidentes
análisis de vulnerabilidades
ciberseguridad paraguay
seguridad informática paraguay
auditoría informática
consultoría de ciberseguridad
empresa de ciberseguridad
seguridad de redes
protección de datos
ransomware empresas
capacitación en ciberseguridad
ISO 27001
pentest web
ciberseguridad para empresas
seguridad informática asunción
empresa de ciberseguridad en paraguay
auditoría de seguridad informática asunción
servicios de ciberseguridad para empresas
pentesting en paraguay
consultoría en seguridad informática asunción
recuperación de ransomware paraguay
cuestionario de seguridad para proveedores
ley 6534 protección de datos paraguay
certificación iso 27001 paraguay
capacitación en seguridad informática para empresas
```

Read the export for the **informational tail** as well as the commercial head —
per PLAN.md §1 the commercial volume here is genuinely thin, and the tail
("qué es un pentest", "cómo responder a un cuestionario de seguridad") is where
the topical authority for this domain gets built. The two `/guias/` pages in the
CORE set come out of that tail, not from invention.

## b) Blocking questions (5)

These cannot be derived. Everything else in this document is already decided.

1. **Is "respuesta a incidentes 24/7" literally true — will someone answer at
   02:00 on a Sunday?** If not, the page says "respondemos en horario laboral y
   devolvemos llamadas fuera de horario". Publishing an unmet 24/7 promise in
   this category is worse than publishing no promise.
2. **Which certifications are actually held** (OSCP, CEH, CISSP, ISO 27001 Lead
   Auditor, CISA…)? This is the regulated-credential question for this vertical.
   Not assumed in either direction — a real cert is the strongest differentiator
   available, an invented one ends the business.
3. **Is there a legal entity with a RUC yet, and does it go on the site?**
   Determines whether the trust ribbon has a RUC field or the row is hidden.
4. **Named, photographed practitioner — yes or no?** See §7.3; this is the one
   place where Mode 3's anonymous-domain default is commercially risky for B2B.
5. **Are prices published?** Recommendation is yes, a starting band per service
   ("desde Gs. X para empresas de hasta N puestos") — it converts better than
   "consultanos" and filters non-buyers. Default if unanswered: no prices, and
   `/precios` becomes a scoping-and-billing explainer instead.

## c) Design track — CLINICAL

Chosen by the brief; confirmed correct. Values written out, not referenced.

| Token | Value |
|---|---|
| `--font-display` | `'General Sans', system-ui, sans-serif` |
| `--font-text` | `'General Sans', system-ui, sans-serif` |
| `--base` | `#FFFFFF` |
| `--ink` | `#0B1B2B` |
| `--accent` | `#1F6FEB` |
| `--surface` | `#F4F7FB` |
| `--hairline` | `color-mix(in srgb, #0B1B2B 10%, transparent)` |
| `--hairline-strong` | `color-mix(in srgb, #0B1B2B 18%, transparent)` |
| Material | soft two-layer shadow, 2px borders on emphasis, cool field |
| Radii | `--r-sm 6px` · `--r-md 14px` · `--r-lg 28px` |
| Shadows | `--shadow-1: 0 1px 2px rgb(0 0 0/.04), 0 4px 12px rgb(0 0 0/.06)` · `--shadow-2: 0 2px 4px rgb(0 0 0/.06), 0 16px 40px rgb(0 0 0/.10)` |
| Type scale | ratio 1.30 on 17px base — 13 / 17 / 22.1 / 28.8 / 37.4 / 48.6 / 63.2 / 82.1 px |
| Danger (incident page only) | `#B3261E` |

Two resolutions the track table leaves open, decided here:

- **`--surface` is `#F4F7FB`, not `#FFFFFF`.** CLINICAL's base is already white;
  identical base and surface would collapse every card into the page and produce
  exactly the flat look the design floor exists to prevent.
- **CLINICAL uses one family in two roles.** `qa-preflight` asks for "one display
  face + one text face" — satisfied here by General Sans at 450 weight /
  `-0.03em` tracking for display and 400/500 for text. Do not add a second family
  to satisfy the checkbox literally.

**Grain applies to every dark section**, including the incident band. On a mostly
white track it is the one thing keeping the dark bands from reading as flat fill.

### Anti-footprint check (§10.7)

| Vertical | Track | Status |
|---|---|---|
| pozo.com.py, gruas.com.py | INDUSTRIAL | in use |
| dentista.com.py, clínica | EDITORIAL | in use |
| salón, gastronomía | WARM CRAFT | in use |
| **ciberseguridad.com.py** | **CLINICAL** | **first use — clean** |

CLINICAL is unclaimed, so there is no palette collision today. It is also the
track the table assigns to "SaaS, medical tech, B2B", so the **next** B2B vertical
on this domain portfolio must shift the accent (e.g. `#3B5BDB` or `#0E7C86`) and
take a different section order rather than reusing this build. Record that now;
it is invisible until the second B2B site exists and then it is expensive.

The old `#2EC4B6` teal from PRODUCT_SPEC §4 is **dropped**. One accent only.

## d) Section → layout pattern (home page, complete)

| # | Section | Pattern |
|---|---|---|
| 01 | Sticky header — wordmark `Ciberseguridad.com.py`, nav, WhatsApp CTA | — |
| 02 | Hero | **P1** asymmetric split 7/5 |
| 03 | Router de situación — 4 buying triggers | **P3** staggered-weight grid |
| 04 | Franja de confianza — RUC · certificaciones · alcance · sin scripts de terceros | **P8** full-bleed ribbon |
| 05 | Servicios — 5 | **P7** sticky-side scroll |
| 06 | Respuesta a incidentes 24/7 | **P6** bleed-image overlap |
| 07 | Cómo trabajamos — 3 pasos con plazos reales | **P5** numbered process rail |
| 08 | Para tu rubro — clínicas · contadores · ecommerce · pymes | **P4** editorial two-column |
| 09 | Postura técnica verificable — live scan links | **P10** data panel |
| 10 | Statement CTA | **P9** oversized statement |
| 11 | Preguntas frecuentes | **P4** editorial two-column |
| 12 | Contacto — formulario + agendá una llamada + WhatsApp | **P1** mirrored 5/7 |
| 13 | Footer + WhatsApp FAB + sticky mobile bar | — |

**Constraint check, shown:**

- *No more than 2 consecutive sections share a pattern* — zero adjacent repeats.
  P4 appears at 08 and 11, separated by P10 and P9. ✓
- *≥1 full-bleed* — 04 (P8 ribbon) and 06 (P6 band). ✓
- *≥1 overlap crossing a section boundary* — 06, the `card--raised` panel
  translating 40% into section 07. ✓
- *≥1 oversized statement* — 10, `.statement` at `--t-6`, alone. ✓
- *≥3 card variants, none more than 4×* — `card--accent` ×4 (router, 03),
  `card--hair` ×5 spread across 05/08/11, `card--raised` ×2 (06 overlap panel,
  09 data panel), `card--ink` ×1 (the span-2 primary service in 05). Four
  variants. `card--hair` at 5 uses breaches the ≤4 rule → drop section 11's FAQ
  items to plain `<details>` on a hairline rule instead of cards. ✓ after that fix.

Section 09 is the one place `P10` is honest: the scan links are real live data,
not a decorative widget. Per `web-design-system`'s anti-pattern list, **no
decorative SVG diagrams anywhere** — no network topology art, no concentric
"security layers", no map with attack arcs.

## e) Image prompts — standalone, paste-ready

Written for the Higgsfield UI. **No `<<<element_id>>>` placeholders** — palette,
light, lens and mood are restated in every prompt so the set coheres without
server-side element resolution. Negative block is identical on all six and must
be pasted with each.

**Shared negative block (append to every prompt):**

```
Negative: padlock icons, glowing shields, matrix rain, green code on black, hooded
figure, anonymous mask, circuit board background, world map with attack arcs, binary
digits, neon cyan glow, HUD overlays, fake dashboards, lens flare, teal-and-orange
grade, text, watermarks, logos, distorted hands, extra fingers, plastic skin,
oversaturated colour, stock-photo handshake, people looking at camera.
```

**1 — `hero-bleed`, 21:9, 2048px, `nano_banana_2`**
```
Wide editorial photograph of a modern Latin American corporate office interior in
Asunción, Paraguay, late afternoon. Two colleagues in plain business-casual shirts
stand at a glass-partition wall reviewing printed documents; both seen from behind
and in three-quarter profile, faces not identifiable. Cool restrained palette of
white, pale blue-grey and deep navy, one small saturated blue accent from a monitor
in the background. Soft diffuse daylight from a large window camera-left, gentle
falloff, no hard specular highlights. Shot on 35mm lens at f/2.8, natural depth of
field, calm documentary framing with generous negative space in the upper right for
overlaid text. Muted contrast, fine natural grain, understated corporate realism.
```

**2 — `section-break` (incident band), 21:9, 1024px, `soul_cinematic`**
```
Cinematic wide shot of a dim server room corridor at night, cool blue-grey and deep
navy palette, rows of dark equipment racks receding into shallow focus. A single
technician in a plain shirt stands mid-frame with their back to camera holding a
laptop, lit only by ambient equipment light and one cool overhead strip. Deep shadow
across the lower third, no coloured neon, no glowing symbols. Shot on 50mm at f/2,
handheld feel, heavy natural grain, desaturated filmic grade, restrained and serious
rather than dramatic. Wide negative space camera-right for overlaid text.
```

**3 — `card-motif` auditoría, 4:3, 1024px, `nano_banana_flash`**
```
Overhead photograph of a clean light-grey desk with a printed technical report,
its pages annotated in pen, beside a closed laptop and a plain white coffee cup.
Palette strictly white, pale blue-grey and deep navy with one small blue accent.
Soft even daylight from above-left, gentle shadows, 50mm lens, shallow depth of
field on the far edge. Documents are generic printed tables and paragraphs with no
legible text. Calm, precise, understated corporate still life, fine natural grain.
```

**4 — `card-motif` pentesting, 4:3, 1024px, `nano_banana_flash`**
```
Close photograph over the shoulder of a person working at a laptop in a bright
office, screen angled away and out of focus so no interface is readable, hands
resting on the keyboard, face out of frame. Cool white, pale blue-grey and deep
navy palette with one small saturated blue reflection. Soft window daylight from
camera-left, natural falloff, 50mm at f/1.8, shallow depth of field. Quiet and
methodical rather than dramatic, muted contrast, fine natural grain.
```

**5 — `card-motif` cumplimiento, 4:3, 1024px, `nano_banana_flash`**
```
Photograph of two people seated across a light wood meeting table in a bright
Latin American office, mid-conversation over a printed document and a tablet, seen
from a low three-quarter angle with faces turned away and not identifiable. Cool
white, pale blue-grey and deep navy palette, one small blue accent. Soft diffuse
daylight from a window behind camera, even illumination, 35mm lens, natural depth
of field. Businesslike and unhurried, muted contrast, fine natural grain.
```

**6 — `card-motif` capacitación, 4:3, 1024px, `nano_banana_flash`**
```
Photograph of a small training session in a plain modern meeting room, five adults
seated facing a blank presentation screen, all seen from behind at a low angle so
no faces are visible. Cool white, pale blue-grey and deep navy palette, one small
blue accent from the screen glow. Soft even ceiling daylight, minimal shadow, 35mm
lens at f/4, moderate depth of field. Ordinary, calm, documentary corporate realism,
muted contrast, fine natural grain.
```

**Not generated, deliberately:** `proof-photo` slots, and any photograph of the
practitioner. Per `higgsfield-web-imagery` rule 1, a generated face captioned as
a named person is the exact failure mode that gets found out. If §b question 4
resolves to a named practitioner, that photograph is **real or the slot stays
empty**.

## f) Image manifest

```json
{
  "vertical": "ciberseguridad",
  "track": "CLINICAL",
  "element_id": null,
  "images": [
    { "slot": "hero-bleed", "n": 1,
      "file": "empresa-de-ciberseguridad-asuncion-paraguay.avif",
      "alt": "Dos profesionales revisando documentación de seguridad informática en una oficina de Asunción",
      "ratio": "21:9", "px": 2048, "model": "nano_banana_2" },
    { "slot": "section-break", "n": 2,
      "file": "respuesta-a-incidentes-de-seguridad-paraguay.avif",
      "alt": "Técnico atendiendo un incidente de seguridad en una sala de servidores",
      "ratio": "21:9", "px": 1024, "model": "soul_cinematic" },
    { "slot": "card-motif", "n": 3,
      "file": "auditoria-de-seguridad-informatica.avif",
      "alt": "Informe de auditoría de seguridad informática con anotaciones sobre un escritorio",
      "ratio": "4:3", "px": 1024, "model": "nano_banana_flash" },
    { "slot": "card-motif", "n": 4,
      "file": "pentesting-pruebas-de-penetracion.avif",
      "alt": "Especialista realizando pruebas de penetración sobre una aplicación en una oficina",
      "ratio": "4:3", "px": 1024, "model": "nano_banana_flash" },
    { "slot": "card-motif", "n": 5,
      "file": "cumplimiento-y-cuestionarios-de-seguridad.avif",
      "alt": "Reunión de trabajo revisando requisitos de cumplimiento de seguridad",
      "ratio": "4:3", "px": 1024, "model": "nano_banana_flash" },
    { "slot": "card-motif", "n": 6,
      "file": "capacitacion-en-ciberseguridad-para-empresas.avif",
      "alt": "Capacitación en ciberseguridad para el personal de una empresa paraguaya",
      "ratio": "4:3", "px": 1024, "model": "nano_banana_flash" },
    { "slot": "proof-photo", "n": null, "file": null,
      "alt": null, "status": "PENDING — real photography only, never generated" }
  ]
}
```

Six images, saved as `01.png`…`06.png` in the order above (≤10, so filenames are
applied automatically from `n`). Do **not** order by download timestamp — one
rejected-and-regenerated image silently misplaces the whole set.

Run a `get_cost: true` preflight on `nano_banana_2`, `nano_banana_flash` and
`soul_cinematic` at these resolutions before the batch, and report the credit
maths against the 6,000/month pool. `use_unlim` is not available on this account.

---

## 7. Delta against the existing planning docs

### 7.1 Verdict: keep the docs, do not start over

No application code exists — the repo is 13 markdown files and nothing else. There
is nothing built to throw away, so "start over" and "keep going" cost the same in
code and differ only in whether the strategy work gets re-derived. Re-deriving it
would be pure waste: the strategic content is track-independent and most of it is
better than what a fresh pass would produce, because it argues with the brief
instead of executing it.

**Keep as-is (≈85%):** `PLAN.md`, `STACK_DECISION.md`, `SEO_ARCHITECTURE.md`,
`SERVICE_PAGE_PLAN.md`, `LEAD_FUNNEL.md`, `PHP_FORM_SPEC.md`,
`SAFE_SECURITY_TOOL_IDEAS.md`, `FUTURE_NODE_FEATURES.md`,
`docs/CONVENTIONS.md`, `docs/VENDERCRM_INTEGRATION.md`.

Specifically worth preserving, because a fresh start would lose them:

- The honest framing in `PLAN.md` §1 — this site closes referrals, it does not
  originate demand. That single decision is why the build is one week not six.
- Money pages organised by **buying trigger** rather than service category.
- The site's own security posture as the primary trust signal, launch-blocking.
- The bright line in `SAFE_SECURITY_TOOL_IDEAS.md` §1 — no tool touches a host
  the visitor has not proven they own. That rule keeps this project lawful under
  Ley 4439/2011 and it is not obvious.
- The anti-fabrication rules and the "no folklore statistics" position.
- Static HTML + one PHP endpoint, and the reasoning about attack surface.

**Amended by this document:** `PRODUCT_SPEC.md` §4 (design), §2 (footer/NAP),
§6 (trust inventory); `PLAN.md` §"WhatsApp-first consultation"; the sitemap in
`PRODUCT_SPEC.md` §1 and `STACK_DECISION.md` §4.

### 7.2 What actually changes, and why it matters

**1. The design floor did not exist before.** `PRODUCT_SPEC.md` §4 specified a
palette, two fonts and "restraint" — and no per-section layout assignment, no
full-bleed / overlap / oversized-statement requirement, no card-variant limit, no
depth rules. "Bento, executed with restraint" is, in practice, the recipe for the
20-identical-white-cards page that `web-design-system` was written against. §d
above is the fix and it is the single biggest upgrade the new skills bring.

**2. Mode 3 changes the trust architecture.** The old docs assume a real business
with a street address, a published NAP block byte-identical across footer, contact
page and JSON-LD, and a photographed practitioner. Mode 3 §10.2 says the brand is
the **domain**, there is no street address until a partner exists, the footer reads
`Asunción, Paraguay`, and the schema is a service-area `LocalBusiness` with
`streetAddress` deliberately omitted. Adopt Mode 3 — but see §7.3, this is not
free here.

**3. Phone number.** Stage 1 uses `+595 995 628862` for every site in the
portfolio, held in **one** constant (`--wa-number`) so the later swap is a
one-line change.

**4. Conversion model is now mixed**, replacing the old resolution.
`PLAN.md` currently argues incidents should be **phone-first** with WhatsApp
secondary. The brief now says incidents are **WhatsApp-first, 24/7**. Your call
takes precedence and is implemented — but keep both of the old page's genuinely
good details, which cost nothing and survive the change:
   - `tel:` stays co-primary and visually equal on that page. A breached company
     at 23:00 will use whichever is closer to their thumb.
   - Keep the line *"Si sospechás que tu correo o tu teléfono están comprometidos,
     llamanos desde otro dispositivo."* It is the most credible sentence on the
     site and it works with either channel first.
   - Note the standing tension: §b question 1 exists because `PLAN.md` §6 lists an
     unmeetable response commitment as a named reputational risk.

   Everything else is **consult/offer-first**: form + "Agendá una llamada",
   WhatsApp as the fast lane. The booking path is new — it is not in the old docs
   at all and `PHP_FORM_SPEC.md` needs one added field (`preferencia_de_contacto`:
   whatsapp | llamada | email).

**5. Sitemap reconciled to the stated five services.** The old sitemap had four
different services. Use the five from the brief; the old
`cuestionarios-de-proveedores` page — its sharpest commercial insight — becomes
the lead angle of `/servicios/cumplimiento` **and** one of the two `/guias/`
pages, so nothing is lost:

```
/                                    home
/servicios/auditoria-de-seguridad
/servicios/pentesting
/servicios/respuesta-a-incidentes    urgent, WhatsApp-first + tel: co-primary
/servicios/cumplimiento
/servicios/capacitacion
/para/clinicas
/para/contadores
/para/ecommerce
/para/pymes                          router page
/precios                             or scoping explainer — see §b q5
/nosotros
/contacto
/preguntas-frecuentes
/guias/responder-un-cuestionario-de-seguridad
/guias/<from the KWP informational tail>
```

Fifteen indexable pages + `/gracias`, `/politica-de-privacidad`, `/terminos`,
`/404`. This is CORE 15 adapted: **`/para/<rubro>` replaces `/zonas/<ciudad>`.**
CORE 15's zone pages assume a physical-service vertical; `SEO_ARCHITECTURE.md`
already rejected city pages for this site as doorway pages, and that rejection is
correct for national B2B. Do not add them back. One primary keyword per page, no
two pages competing.

**6. Imagery.** The old spec said zero stock photography, one real practitioner
photo. That is too strict under Mode 3 — a site with empty image slots does not
read as restrained, it reads as unfinished. §e generates six illustrative images
and holds `proof-photo` and any practitioner portrait to real-only. The old
"zero cyber clichés" rule is preserved verbatim in the negative block.

### 7.3 The one place Mode 3 fights this vertical — flagging, not blocking

Mode 3's anonymous domain-brand works because a plumber is judged on response
time, not on identity. **A security consultancy is judged on exactly the identity
Mode 3 removes.** `PLAN.md` §6 already names founder-dependent credibility as
structural and recommends leaning into it: "in this market a named person
outperforms a fictional agency identity". Both cannot be true at once.

Recommendation: run Mode 3's address and schema rules (no street address, no
fabricated NAP, service-area schema) **but keep `/nosotros` named and
photographed** if a real person and a real photo exist. That takes the anti-
fabrication benefit of Mode 3 without the credibility cost. That is what §b
question 4 decides — it is the highest-leverage of the five.

### 7.4 Missing skill reference files — real, and it affects execution

Only `web-design-system/references/` is installed. These are absent:

- `paraguay-local-site/references/design-lib-py.md` — worked around: the track came
  from `web-design-system`'s own table and you named CLINICAL explicitly.
- `paraguay-local-site/references/keywords-py.md` — worked around: §a is built for
  KWP, which is the authoritative source anyway.
- `paraguay-local-site/references/vendercrm-integration.md` — worked around: this
  repo's `docs/VENDERCRM_INTEGRATION.md` covers the same ground.
- `paraguay-local-site/references/expansion-py.md` — worked around: §7.2 point 5.
- `higgsfield-web-imagery/references/prompt-library.md` — worked around: §e prompts
  are standalone by design.
- `higgsfield-web-imagery/references/fetch-images.mjs` — **not worked around.** The
  download/convert/place script does not exist. Either restore it or budget ~30
  lines of `sharp` to write an equivalent at image-placement time.

Restoring these files in the skills repo is worth doing before the next vertical.

---

## 8. How to run this to spend the fewest credits

The credit sink is not code volume — it is a strong model making the same
decisions repeatedly across turns. `paraguay-local-site` §0.5 exists precisely
for this. Three turns, not fifteen:

| Turn | Model | Output |
|---|---|---|
| 1 — done | Opus | this document |
| 2 | Opus, one turn | `BUILD-SPEC.md` — every §0.5 point closed, **verbatim copy for every section**, tokens written out, per-section patterns, filenames, alt text, keyword map, `preferencia_de_contacto` added to the form contract, QA checklist inlined |
| 3 | **Sonnet** | *"Implementá BUILD-SPEC.md exactamente. No te desvíes. Preguntá ante cualquier duda en vez de adivinar."* |

The test for whether turn 2 is finished: **if any line in the spec requires a
decision at execution time, that line is not written yet.** Copy is where a
cheaper model drifts most, so copy goes in the spec word-for-word — not
instructions describing what the copy should say.

Answer the five questions in §b before turn 2. Each unanswered one becomes a
placeholder that surfaces again later, and a question answered mid-execution
costs several times what it costs now.

Images are independent of turns 2–3 and can run in parallel — nothing in the
build blocks on them except final placement.
