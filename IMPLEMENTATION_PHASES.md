# IMPLEMENTATION_PHASES.md — ciberseguridad.com.py

What ships when, what gates each phase, and what is deliberately deferred.

---

## Phase 0 — Prerequisites (before any code)

These are gathering tasks, not build tasks, and the build stalls without them.

- [ ] Real business name, RUC, address, phone (`+595…`), email — the NAP block
- [ ] WhatsApp Business number active, with a profile and business hours set
- [ ] A real photograph of the practitioner — professional, not a stock image
- [ ] Real credentials and background for `/nosotros` — only what is genuinely
      held
- [ ] **A redacted sample deliverable.** The single highest-converting asset on
      the site. If no past report exists, produce one from a realistic
      hypothetical, and label it clearly as an example rather than a real
      engagement.
- [ ] Price bands decided for all four services, and defensible
- [ ] An honest availability commitment for incident response, decided now and
      never inflated later
- [ ] VenderCRM: site created under **Sitios**, API key issued, default
      pipeline stage configured
- [ ] Hosting: Hostinger account, domain pointed, PHP 8.2 confirmed
- [ ] Google: Search Console property, GA4 property, Business Profile created

**Gate:** the NAP, the photo and the sample deliverable exist. Do not begin
Phase 1 without them — they are what the pages are built around, and building
placeholder-first produces a site that never gets finished.

---

## Phase 1 — The lead-generation site
**Target: 5–7 working days.**

### Build

Structure and infrastructure:
- [ ] Directory layout per `STACK_DECISION.md` §4, with `src/` and `storage/`
      outside the web root
- [ ] Extensionless URL rewriting
- [ ] The shared shell: `render.php` with `layout()`, `meta()`, `jsonld()`
- [ ] CSS design system per `PRODUCT_SPEC.md` §4 — tokens, type scale, spacing
- [ ] Self-hosted Space Grotesk + Inter, woff2, subset to Latin, 4 weights total
- [ ] `site.js` under 8kb: nav toggle, one IntersectionObserver reveal, form UX

Pages (all per `SERVICE_PAGE_PLAN.md`):
- [ ] `/` including the four-card trigger router
- [ ] `/servicios/diagnostico`
- [ ] `/servicios/respuesta-a-incidentes` — no images, no motion, `tel:` first
- [ ] `/servicios/cuestionarios-de-proveedores`
- [ ] `/servicios/seguridad-gestionada`
- [ ] `/para/clinicas`
- [ ] `/para/contadores`
- [ ] `/para/ecommerce`
- [ ] `/para/pymes`
- [ ] `/nosotros`
- [ ] `/contacto`
- [ ] `/gracias` (`noindex`)
- [ ] `/politica-de-privacidad`
- [ ] `/terminos`
- [ ] `/404`

Forms and CRM:
- [ ] `form-handler.php` complete, per `PHP_FORM_SPEC.md`
- [ ] `vendercrm.php` client, per the shared integration spec
- [ ] Local CSV write **before** the CRM push
- [ ] Notification email with the band letter in the subject
- [ ] `vc-attribution.js` on every page

SEO:
- [ ] Titles and metas per `SEO_ARCHITECTURE.md` §4
- [ ] JSON-LD per §5 — `Organization`, not `LocalBusiness`; no `aggregateRating`
- [ ] `sitemap.xml`, `robots.txt`, canonicals
- [ ] OG images 1200×630 per money page
- [ ] GA4 with `whatsapp_click`, `phone_click`, `generate_lead`

Hardening (per `STACK_DECISION.md` §6):
- [ ] TLS 1.2+, modern ciphers
- [ ] HSTS with `preload`, submitted to the preload list
- [ ] CSP with `default-src 'self'`, no `unsafe-inline`
- [ ] `nosniff`, `Referrer-Policy`, `Permissions-Policy`, `X-Frame-Options: DENY`
- [ ] Zero third-party CDN scripts; GA4 explicitly allowed in CSP
- [ ] `/.well-known/security.txt` with a real contact and an expiry
- [ ] `expose_php = Off`, `display_errors = Off`, directory listing off
- [ ] DNSSEC on the domain
- [ ] SPF, DKIM, DMARC `p=reject`
- [ ] `.env`, `src/`, `storage/` unreachable over HTTP

### Launch gate — all must pass

| Check | Threshold |
|---|---|
| SSL Labs | **A+** |
| securityheaders.com | **A** |
| Full form round trip verified end to end | Per `VENDERCRM_INTEGRATION.md` §Verification |
| Duplicate submission test | Second creates no second contact |
| LCP, mobile 4G, every page | < 2.5s (incident page < 1.0s) |
| CLS | < 0.1 |
| Every page at 390px | CTA above fold, no horizontal scroll |
| Fabrication scan | Zero invented numbers, logos, ratings, years |
| Voseo | Consistent, no `tú` forms anywhere |
| GSC | Verified, sitemap submitted |

**The security grades are launch-blocking, not aspirational.** A cybersecurity
consultancy launching with a B on securityheaders.com has done itself more harm
than launching two days later. The technical-posture strip does not go live
until the scans return the grades it claims.

### Deliberately not in Phase 1
Blog, tools, cooperativas page, newsletter, any database.

---

## Phase 2 — The self-assessment
**Target: 4–5 days, starting 2–3 weeks after launch.**

The gap is intentional: let the site settle, fix what the first real visitors
reveal, and confirm the form actually works in production before adding to it.

- [ ] `/recursos` hub
- [ ] `/recursos/autoevaluacion` — 18–22 questions, 7 domains, weighted scoring,
      per `SAFE_SECURITY_TOOL_IDEAS.md` §2.1
- [ ] Entirely client-side until submission; nothing transmitted before consent
- [ ] Result shown **in full, unconditionally**, before any form
- [ ] Limitation text prominent: a high score does not mean secure
- [ ] Submission path through the same handler, with `score`, `banda`, and the
      seven domain values flattened into `fields`
- [ ] Three-email follow-up sequence configured in the email provider
- [ ] `/recursos/checklist-de-incidentes` — branching, printable, including the
      fill-in-before-you-need-it contact sheet
- [ ] Print stylesheet producing a clean one-page PDF via the browser
- [ ] `WebApplication` JSON-LD on both
- [ ] GA4: `assessment_start`, `assessment_complete`, `assessment_submit`

**Gate:** completion rate above 40% of starts. Below that the questionnaire is
too long — cut questions rather than adding persuasion.

---

## Phase 3 — Content and depth
**Months 2–12, one post per month.**

- [ ] Blog index and post template, `Article` JSON-LD, author `Person`
- [ ] Posts 1–12 per `SEO_ARCHITECTURE.md` §8, in that order
- [ ] Post 1 (vendor questionnaires) in the first week — highest value by a
      wide margin
- [ ] `/para/cooperativas`, once there is capacity to serve one credibly
- [ ] `/recursos/quiz-phishing` — fabricated examples only, invented
      organisation names, no real brands
- [ ] `/recursos/verificador-de-backups`
- [ ] Monthly newsletter live in the email provider
- [ ] Google Business Profile completed and linked in schema `sameAs`
- [ ] Association memberships and directory listings — real ones only

**Ongoing, monthly:** re-run the header and TLS scans (a hosting change can
silently undo the hardening); review GSC for the eleven target queries; review
conversations-per-page and reallocate content effort.

**Gate for continuing content investment at month 6:** are situational queries
producing conversations? If the incident-response and questionnaire pages are
generating leads, keep going. If twelve months of content produces traffic but
no conversations, `PLAN.md` §1 was right and the effort belongs in outbound.

---

## Phase 4 — Optional additions
**No fixed date. Only on evidence.**

- [ ] `/recursos/generador-de-politicas` — with every framing safeguard in
      `SAFE_SECURITY_TOOL_IDEAS.md` §2.5. Lowest lead value of the five tools
      and the highest framing risk; last for a reason.
- [ ] Anonymised case studies, once there are engagements to describe
- [ ] Named client references, only with written permission
- [ ] Eleventy adoption if the page count passes ~35
- [ ] Spanish-language video walkthroughs of the free tools, if the content
      channel is working

---

## Phase 5 — Node, conditional

Only if the triggers in `FUTURE_NODE_FEATURES.md` §5 fire. Reviewed at month 6
and month 12, not continuously. Between reviews the answer is no.

If it fires: a separate application at `app.ciberseguridad.com.py`. The
marketing site is not migrated.

---

## Effort summary

| Phase | Effort | Elapsed |
|---|---|---|
| 0 | 1–2 days of gathering | Before start |
| 1 | 5–7 days | Week 1–2 |
| 2 | 4–5 days | Week 5–6 |
| 3 | ~1 day/month | Months 2–12 |
| 4 | 3–5 days | Conditional |
| 5 | 3–6 weeks | Conditional |

**Total to a complete, functioning lead-generation property with tools: about
twelve working days.** That is the whole argument for the stack choice, and it
leaves the remaining time for the channels that `PLAN.md` §1 identifies as
actually filling the funnel.
