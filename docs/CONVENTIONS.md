# Conventions — ciberseguridad.com.py

Rules that apply to every page, task and commit on this project. The other
planning documents assume these and do not repeat them. If a project doc
contradicts this file, the project doc wins and should say why.

---

## 1. Language

- **Paraguayan Spanish with voseo.** `vos tenés`, `contactanos`, `agendá`,
  `escribinos`, `pedí`, `enterate`. Never `tú tienes` / `contáctanos`.
- `lang="es-PY"` on `<html>`.
- Currency written `Gs. 1.500.000` (dot thousands separator). USD written
  `USD 1.500`. Never mix in the same sentence without labelling both.
- No Guaraní. This is a B2B audience searching in Spanish; it is not a search
  language for these intents and reads as pandering.
- Slugs: lowercase, hyphens, no accents or `ñ` → `diagnostico`,
  `respuesta-a-incidentes`, `ciberseguridad-para-pymes`.

## 2. Anti-fabrication (hard rule)

Never invent, in copy or in schema:

- testimonials, names of clients, client logos
- review counts, star ratings, `aggregateRating`
- "desde 2015", years in business, team size
- counters: "+500 empresas protegidas", "1.200 visas aprobadas"
- certifications, partnerships, accreditations

Where real proof does not exist yet, use **structural trust**: a named real
person with a real photo, a real phone number, a written process with
timeframes, a concrete deliverable description, an honest and honorable
guarantee, and a stated response time.

This is not a style preference. On a security consultancy's own site, a
fabricated credential is the claim a prospect is most likely to check.

## 3. Conversion

- WhatsApp is the primary channel, except on
  `/servicios/respuesta-a-incidentes`, where it is `tel:` — see
  `PLAN.md` §2 and `SERVICE_PAGE_PLAN.md` §2.
- Deep link format:
  `https://wa.me/595XXXXXXXXX?text=<URL-encoded, page-specific prefill>`
- The prefill must name the page's service so the conversation opens
  qualified: `Hola, quiero una evaluación de seguridad para mi empresa`.
- Primary CTA visible without scrolling at 390px, repeated after every major
  section, plus a sticky mobile button.
- One accent colour, used only on the primary CTA.
- Never two competing primary CTAs on one page.

## 4. Design

Follow the `conversion-design` skill, Direction **B — Bento Profesional**. It
is chosen because this site must itself demonstrate technical competence: the
prospect is buying judgement, and the site is the first sample of it. Exact
tokens, type scale and motion budget are in `PRODUCT_SPEC.md` §4.

The anti-fluff list in that skill is binding. In particular: no WebGL, no
scroll hijacking, no preloaders, no carousels, no custom cursors, one animation
concept per page maximum, `prefers-reduced-motion` respected. Additionally, and
specific to this category: no padlocks, no matrix rain, no hooded figures, no
circuit-board backgrounds, no world maps with attack arcs.

## 5. Technical baseline

- Mobile-first, designed at 390px.
- LCP < 2.5s on 4G, CLS < 0.1, INP < 200ms.
- Total JS ≤ 150 kb gzipped on marketing pages. Hero image ≤ 120 kb, AVIF or
  WebP, explicit width/height, never lazy-loaded.
- Max 2 font families / 4 weights, self-hosted, `font-display: swap`.
- HTTPS only, HSTS, no mixed content, lowercase URLs, consistent trailing
  slash, self-referencing canonical on every page.
- Every page: unique `<title>` ≤ 60 chars, meta description ≤ 155, exactly one
  H1, valid JSON-LD mirroring visible content, OG image 1200×630.
- OG images matter disproportionately: in Paraguay links are shared in
  WhatsApp groups and the OG card is the advertisement.

## 6. Hosting

Hostinger shared hosting, PHP 8.2. No Node runtime, no build step, no
dependency tree — see `STACK_DECISION.md` for the reasoning, which on this
property is as much a security argument as an operational one.

Secrets live in server environment variables, never in the repo, never in
client JS. `.env` is git-ignored from commit one and additionally denied by
`.htaccess`.

The full hardening list is in `STACK_DECISION.md` §6 and it is
**launch-blocking**, not a follow-up task.

## 7. Analytics

- GA4, with `whatsapp_click`, `phone_click` and `generate_lead` events carrying
  `page_path` and `service` parameters.
- Google Search Console verified before launch, sitemap submitted.
- First-touch attribution via the VenderCRM snippet (see
  `VENDERCRM_INTEGRATION.md`) on every page, so a visitor who arrives from a
  campaign and converts a week later is still credited.
- GA4 is the only third-party script on the site, and it is allowed explicitly
  in the CSP. Never widen the policy to `unsafe-inline` to make a tag work.

## 8. Privacy and data

- Publish `/politica-de-privacidad` and `/terminos` before the first form goes
  live, not after.
- Collect the minimum needed to have a first conversation. Never collect cédula
  numbers, document scans, or account numbers through a web form.
- Never invite a prospect to describe their vulnerabilities, systems or
  credentials in a form. A form that collects that data creates a target, and
  its breach would end the business. The message field says so in its hint
  text — see `PHP_FORM_SPEC.md` §1.
- Retention: raw lead rows purged or anonymised after 24 months unless the lead
  became a customer.
- Every form states, next to the submit button, who receives the data and what
  happens next.

## 9. Legal posture

- Never guarantee an outcome — security, immunity, recovery of encrypted files,
  or approval by a third party assessing the client.
- Free tools give general guidance, labelled as such, and name the professional
  engagement that must follow. A high self-assessment score never means secure.
- Disclaimers go on the page near the claim, not buried in a footer link.
- No tool, page or service ever touches a host the visitor has not proven they
  own. Ley 4439/2011 makes unauthorised access a criminal matter and the
  visitor typing a URL is not proof of ownership. See
  `SAFE_SECURITY_TOOL_IDEAS.md` §1.

## 10. Repository hygiene

- `main` is deployable. Feature branches for work in progress.
- `docs/` holds cross-cutting specs; the root holds this project's planning
  documents. Specs are updated in the same commit as the code that invalidates
  them.
- A `CLAUDE.md` at root once code exists, describing run and deploy commands
  and where secrets live.
