# Shared conventions — all five .com.py properties

Rules that apply to every project in this planning set. Project docs assume
these and do not repeat them. If a project doc contradicts this file, the
project doc wins and should say why.

---

## 1. Language

- **Paraguayan Spanish with voseo.** `vos tenés`, `contactanos`, `agendá`,
  `escribinos`, `pedí`, `enterate`. Never `tú tienes` / `contáctanos`.
- `lang="es-PY"` on `<html>`.
- Currency written `Gs. 1.500.000` (dot thousands separator). USD written
  `USD 1.500`. Never mix in the same sentence without labelling both.
- No Guaraní on B2B or financial properties — it is not a search language for
  these intents and reads as pandering. Occasional Guaraní is acceptable only
  on `viaje.com.py` for warmth, never in headings or metadata.
- Slugs: lowercase, hyphens, no accents or `ñ` → `prestamo-personal`,
  `ciberseguridad-para-pymes`.

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

This is not a style preference. On the financial and immigration properties
it is also a consumer-protection exposure.

## 3. Conversion

- WhatsApp is the primary channel on every property.
- Deep link format:
  `https://wa.me/595XXXXXXXXX?text=<URL-encoded, page-specific prefill>`
- The prefill must name the page's service so the conversation opens
  qualified: `Hola, quiero una evaluación de seguridad para mi empresa`.
- Primary CTA visible without scrolling at 390px, repeated after every major
  section, plus a sticky mobile button.
- One accent colour, used only on the primary CTA.
- Never two competing primary CTAs on one page.

## 4. Design

Follow the `conversion-design` skill. Per-project direction:

| Project | Direction | Reason |
|---|---|---|
| ciberseguridad | B — Bento Profesional | Site must itself demonstrate technical competence |
| viaje | B — Bento Profesional, warmer imagery | Younger audience, image-led |
| visas | A — Confianza Local | Life-changing decision, conservative trust |
| criptomonedas | C — Resonant Stark | Distance from scam-adjacent visual language |
| prestamo | A — Confianza Local | Financial anxiety, needs calm and solidity |

The anti-fluff list in that skill is binding on all five. In particular: no
WebGL, no scroll hijacking, no preloaders, no carousels, no custom cursors,
one animation concept per page maximum, `prefers-reduced-motion` respected.

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

Hostinger shared hosting for the PHP properties; Hostinger managed Node.js for
`viaje.com.py`. See the `nextjs-deploy-hostinger` and
`nodejs-mysql-hostinger-stack` skills at implementation time — in particular
the IPv6 routing issue, the SSH `npm` PATH problem, and Remote MySQL IP
whitelisting.

Secrets live in server environment variables, never in the repo, never in
client JS. `.env` is git-ignored on every project from commit one.

## 7. Analytics

- GA4 on every property, with a `whatsapp_click` event carrying
  `page_path` and `service` parameters.
- Google Search Console verified before launch, sitemap submitted.
- First-touch attribution via the VenderCRM snippet (see
  `VENDERCRM_INTEGRATION.md`) on every page, so a visitor who arrives from a
  campaign and converts a week later is still credited.
- No Meta Pixel on `prestamo.com.py` or `visas.com.py` without a privacy
  review — the inferred audiences there are sensitive categories.

## 8. Privacy and data

- Publish `/politica-de-privacidad` and `/terminos` on every property before
  the first form goes live, not after.
- Ley 6534/2020 (protection of personal credit data) is directly relevant to
  `prestamo.com.py` and indirectly to any property storing identity data.
  Collect the minimum needed to have a first conversation. Never collect
  cédula numbers, document scans, or account numbers through a web form.
- Retention: raw lead rows purged or anonymised after 24 months unless the
  lead became a customer.
- Every form states, next to the submit button, who receives the data and
  what happens next.

## 9. Legal posture

Each of these properties sells or refers to a regulated or consequential
outcome. The standing rules:

- Never guarantee an outcome (approval, ranking, immunity, returns, visa).
- Never state or imply influence over a government or lender decision.
- Always label general information as general information, and name the
  professional consultation that must follow.
- Disclaimers go on the page near the claim, not buried in a footer link.

## 10. Repository hygiene

- One repo per domain once split out.
- `main` is deployable. Feature branches for work in progress.
- `docs/` holds specs; specs are updated in the same commit as the code that
  invalidates them.
- Every project keeps a `CLAUDE.md` at root once code exists, describing build,
  run, and deploy commands.
