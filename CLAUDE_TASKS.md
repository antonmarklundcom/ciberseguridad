# CLAUDE_TASKS.md — ciberseguridad.com.py

Ordered, self-contained work queue for an implementation model (Sonnet 5 /
Codex). Each task names its inputs, its output, and its acceptance criteria.
Execute in order; tasks within a block are independent unless stated.

**Before starting anything, read:** `planning/_shared/CONVENTIONS.md`,
`PLAN.md`, `STACK_DECISION.md`.

**Standing rules for every task in this file:**
- Paraguayan Spanish, voseo, `es-PY`. Never `tú` forms.
- Zero fabricated trust signals. No invented numbers, logos, ratings, years,
  certifications, or client names. If real content is missing, leave a clearly
  marked `TODO(content)` — never invent a placeholder that reads as real.
- No security outcome is ever promised in any copy.
- No tool contacts any host the visitor has not proven they own.
- Mobile-first: build and verify at 390px before anything else.
- Anti-fluff list in `PRODUCT_SPEC.md` §4 is binding.

---

## BLOCK A — Foundation

### A1. Repository scaffold
**Output:** directory structure, `.gitignore`, `CLAUDE.md`, `.env.example`
- Layout exactly per `STACK_DECISION.md` §4. `src/` and `storage/` **outside**
  the web root.
- `.gitignore`: `.env`, `storage/*`, `!storage/.gitkeep`, OS junk.
- `.env.example` with `VENDERCRM_URL`, `VENDERCRM_API_KEY`, `NOTIFY_EMAIL`,
  `SITE_URL` — names only, never values.
- `CLAUDE.md` documenting the local run command, the deploy method, and where
  secrets live.
**Accept:** `git status` clean after a dry run; no secret is committable.

### A2. `.htaccess` and server hardening
**Input:** `STACK_DECISION.md` §6
**Output:** `public_html/.htaccess`
- Force HTTPS, non-www → www or the reverse, chosen once and consistent.
- Extensionless URL rewriting.
- Every security header from §6, including a CSP with `default-src 'self'` and
  no `unsafe-inline`.
- Deny access to `.env`, `storage/`, dotfiles, and `*.md`.
- Directory listing off; `expose_php` off via `php.ini` or `.user.ini`.
- Custom 404.
**Accept:** securityheaders.com returns **A**; `/storage/leads.csv` returns
403/404; no PHP version in response headers.

### A3. Design system CSS
**Input:** `PRODUCT_SPEC.md` §4
**Output:** `assets/css/site.css`
- CSS custom properties for the full token set in §4.
- Type scale 16/20/25/31/39/49 with `clamp()` on the top two; body 17px,
  line-height 1.6, max 70ch.
- 8px spacing grid; section padding 96/56.
- Components: button (48px min, full-width mobile), card, bento grid, form
  control, FAQ accordion (`<details>`, no JS), sticky mobile CTA bar.
- One fade-up reveal keyframe; all motion disabled under
  `prefers-reduced-motion: reduce`.
- Print stylesheet stub for the Phase 2 tools.
**Accept:** under 16kb uncompressed; accent `#2EC4B6` appears **only** on
primary CTA rules; contrast of button text on accent ≥ 4.5:1 (darken the accent
if it fails, and record the adjusted value in `PRODUCT_SPEC.md`).

### A4. Fonts
**Output:** `assets/fonts/`, `@font-face` block
- Space Grotesk 600/700, Inter 400/500. Self-hosted woff2, Latin subset.
- `font-display: swap`; preload the two most critical faces.
**Accept:** exactly 4 files; no external font request in the network panel;
total under 120kb.

### A5. Layout shell
**Input:** `PRODUCT_SPEC.md` §2
**Output:** `src/render.php` with `layout()`, `meta()`, `jsonld()`, `breadcrumbs()`
- `meta()` takes title, description, canonical, OG image, and `noindex` flag.
- Header with dropdown nav; mobile hamburger with a full-screen panel and the
  CTA pinned at its foot.
- Footer with the exact NAP block, nav repeat, legal links, and the
  verify-our-security line.
- Sticky mobile CTA bar, with a parameter to switch it to `tel:` for the
  incident page.
- Skip-to-content link; semantic landmarks.
**Accept:** one H1 per page is enforced by the template contract; nav fully
keyboard-navigable; no layout shift on load.

### A6. `site.js`
**Output:** `assets/js/site.js`
- Nav toggle with focus trapping in the mobile panel.
- One IntersectionObserver fade-up reveal, fires once, 12px translate.
- Form UX: validate on blur, submit-button disable-on-submit, error focus.
- WhatsApp and phone click → GA4 event with `page_path` and `service`.
- No dependencies. No polyfills.
**Accept:** under 8kb uncompressed; site fully functional with JS disabled;
zero console errors.

---

## BLOCK B — Forms and CRM
*Depends on Block A. This is the only server-side code — review it twice.*

### B1. VenderCRM client
**Input:** `planning/_shared/VENDERCRM_INTEGRATION.md`
**Output:** `src/vendercrm.php`
- `push_lead(array $payload): array` returning status and body.
- Key from the environment. 10s timeout. Peer and host verification on —
  never `CURLOPT_SSL_VERIFYPEER => false`, including during testing.
- Omit optional fields rather than sending `""`.
- **Never** send pipeline, stage, owner or tag.
- Returns rather than throws; the caller decides.
**Accept:** unit-testable with a stubbed transport; a 500 from the CRM does not
raise an uncaught error.

### B2. Validation
**Input:** `PHP_FORM_SPEC.md` §1
**Output:** `src/validate.php`
- Server-side allow-lists for `empleados`, `rubro`, `disparador`, `banda`.
- Length caps on every field; `filter_var` for email; control characters and
  newlines rejected in single-line fields.
- `dominios` JSON parsed, keys matched against an allow-list, values coerced to
  int, then re-serialised. Never pass a client blob through.
- Returns `[$clean, $errors]`.
**Accept:** every test in `PHP_FORM_SPEC.md` §8 under "Security" passes.

### B3. Form handler
**Input:** `PHP_FORM_SPEC.md` §3–§6
**Output:** `src/form-handler.php`, `public_html/enviar.php`
- Exact flow from §3, in that order. The local CSV write precedes the CRM push.
- CSRF via `hash_equals`; honeypot; 3s timing check; 5/IP/hour rate limit with
  `flock`.
- Idempotency key: `sha256(telefono|form_type|Y-m-d-H)`.
- `vc_attr` cookie parsed defensively; malformed cookie must not throw.
- Notification email with the band letter first in the subject, built with a
  mail library, never raw string concatenation into headers.
- Redirect 302 to `/gracias?t={form_type}`. Never render on success.
**Accept:** the full functional and security checklist in `PHP_FORM_SPEC.md` §8.

### B4. Contact form partial
**Input:** `PHP_FORM_SPEC.md` §2
**Output:** `src/partials/lead-form.php`
- Takes `form_type` and `page` as parameters.
- Markup exactly as §2, including the honeypot, the sensitive-details hint, and
  the `form-note` beneath the button.
- Errors bound via `aria-describedby`, announced, input preserved on re-render.
**Accept:** every input has a bound label; no input under 16px; full flow works
with a keyboard and with a screen reader.

---

## BLOCK C — Pages
*Depends on Blocks A and B. Each page is independent of the others.*

For every page in this block:
- Content per `SERVICE_PAGE_PLAN.md`
- Title, meta, JSON-LD per `SEO_ARCHITECTURE.md` §4–§5
- Cross-page acceptance criteria at the foot of `SERVICE_PAGE_PLAN.md`
- 700–1,100 words on service and vertical pages

### C1. `/` home
Trigger router is the priority block — four cards, mobile order defined first.
Technical-posture strip present but **commented out until the scans return the
claimed grades** (see F2).

### C2. `/servicios/diagnostico`
Seven review domains named. Sample deliverable PDF linked. Price band published.

### C3. `/servicios/respuesta-a-incidentes`
**Special constraints — do not treat this as a normal page.** No images, no
motion, no reveal. `tel:` sticky bar replaces WhatsApp. "Qué hacer ahora mismo"
is the first content block, before any selling. Danger colour `#B3261E` used
here and nowhere else. Availability statement literally true.
**Accept:** LCP < 1.0s; zero JS beyond analytics; no recovery outcome promised.

### C4. `/servicios/cuestionarios-de-proveedores`
The "¿y si la respuesta es no?" section is required and substantial. FAQ
explicitly disclaims any approval guarantee. Only name frameworks genuinely
supported — leave `TODO(content)` rather than guessing.

### C5. `/servicios/seguridad-gestionada`
"Qué NO incluye" section required. Cadence itemised. No SOC or 24/7 claim.

### C6–C9. `/para/clinicas`, `/para/contadores`, `/para/ecommerce`, `/para/pymes`
Five-part skeleton, genuinely distinct content per vertical.
**Hard gate: if 400 genuinely distinct words cannot be written for a page, do
not build it — report back instead.** `/para/contadores` includes the
"¿Tus clientes te preguntan sobre esto?" referral section. `/para/pymes` is a
router; its primary conversion is the assessment, not a call.

### C10. `/nosotros`
Real name, real photo, real background. What you will not do. Confidentiality
position explaining the absence of a logo wall.
Anything unavailable → `TODO(content)`, never invented.

### C11. `/contacto`
WhatsApp, phone, **visible email**, form, hours, NAP block byte-identical to
the footer and the JSON-LD.

### C12. `/gracias`, `/404`
`/gracias` is `noindex`, varies by `?t=`, fires `generate_lead`.
`/404` links to the four money pages.

### C13. `/politica-de-privacidad`, `/terminos`
What is collected, why, who receives it, retention (24 months for
non-customers), how to request deletion, contact for data requests.
Written for Paraguayan law; leave `TODO(legal)` where a lawyer must review
rather than asserting a legal position.

---

## BLOCK D — SEO and analytics

### D1. Metadata pass
Every page's title ≤60 and meta ≤155, exactly per `SEO_ARCHITECTURE.md` §4.
**Accept:** no duplicate titles; no page over the limits; one H1 each.

### D2. JSON-LD
Per §5. `Organization`, **not** `LocalBusiness`. Phone in E.164, identical
across footer, contact page and schema. **No `aggregateRating`, no `review`.**
**Accept:** validates in the Rich Results Test; mirrors visible content exactly.

### D3. Sitemap, robots, canonicals
`sitemap.xml` with indexable 200s only — `/gracias` and `/404` excluded.
`robots.txt` blocking nothing in CSS/JS and linking the sitemap.
Self-referencing canonical on every page.

### D4. Images and OG
AVIF + WebP, explicit dimensions, descriptive Spanish alt, descriptive
filenames. Hero preloaded and never lazy-loaded. OG image 1200×630 per money
page, service name and brand legible at thumbnail size.
**Accept:** hero ≤ 120kb; WhatsApp link preview renders correctly for every
money page (test by actually sending one).

### D5. Analytics
GA4 with `whatsapp_click`, `phone_click`, `generate_lead`,
`assessment_start`/`_complete`/`_submit`. `vc-attribution.js` on every page.
GA4 allowed explicitly in the CSP — no blanket `unsafe-inline` to make it work.
**Accept:** every event fires with correct parameters; zero CSP violations in
the console.

---

## BLOCK E — Phase 2 tools
*Only after Phase 1 has been live for 2–3 weeks.*

### E1. `/recursos` hub
Cards for each tool, honest description of what each does and does not do.

### E2. Self-assessment
**Input:** `SAFE_SECURITY_TOOL_IDEAS.md` §2.1
**Output:** `public_html/recursos/autoevaluacion.php`, `assets/js/autoevaluacion.js`
- 18–22 questions, 7 domains, all declarative multiple-choice, no free text.
- Weighted scoring — backups, MFA and BEC process at roughly double weight.
- One question per screen on mobile, progress indicator, back button, state
  held in memory only.
- **Result shown in full, unconditionally, before any form.**
- Limitation text prominent and unavoidable: a high score does not mean secure.
- Submission via the Block B handler with `score`, `banda` and seven flattened
  `dominio_*` keys.
**Accept:** nothing transmitted before submit (verify in the network panel);
works with the browser back button; completion measurable in GA4.

### E3. Incident checklist
**Input:** `SAFE_SECURITY_TOOL_IDEAS.md` §2.3
Branching by incident type; printable output; the fill-in-before-you-need-it
contact sheet printing to one page. Every path ends at
`/servicios/respuesta-a-incidentes`.
**Accept:** print output is one clean page with no navigation chrome.

### E4. Follow-up emails
Three-email sequence per `LEAD_FUNNEL.md` §5, configured in the email provider.
Every email carries a working unsubscribe.

---

## BLOCK F — Launch

### F1. Pre-launch audit
Run every item in `IMPLEMENTATION_PHASES.md` §"Launch gate". Report results as
a table; do not mark the phase done on a partial pass.

### F2. Hardening verification — **launch-blocking**
- SSL Labs → **A+**
- securityheaders.com → **A**
- HSTS preload submitted
- DNSSEC active
- SPF, DKIM, DMARC `p=reject` verified with a real test send
- `security.txt` reachable, valid, with a real contact and a future expiry
**Only after all six pass:** uncomment the technical-posture strip from C1 and
add the live scan links. Publishing that claim before the grades are real is
worse than not publishing it at all.

### F3. Content audit
Grep the whole site for fabrication risk: digits followed by `%`, `+`, `años`,
`clientes`, `empresas`; the words `garantiz`, `100%`, `seguro`, `protegido`,
`certificad`. Every hit reviewed by hand against the anti-fabrication rule.
**Accept:** zero unsupported claims; every statistic carries a linked primary
source or is deleted.

### F4. Go live
DNS, GSC verification, sitemap submission, GA4 realtime confirmation, and one
real end-to-end form submission verified through to VenderCRM per the
integration spec's verification section.

---

## Reporting

After each block, report:
1. What was built, as a file list
2. Acceptance criteria: passed / failed / not applicable
3. Every `TODO(content)` and `TODO(legal)` left, with its file and line
4. Anything in the specs that turned out to be wrong or unbuildable — say so
   rather than silently working around it

Do not report a block complete with failing acceptance criteria. Report it as
partial and name what failed.
