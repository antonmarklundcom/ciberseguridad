# STACK_DECISION.md — ciberseguridad.com.py

**Decision: hand-written static HTML + CSS + a small amount of vanilla JS,
with one PHP endpoint for form handling. No framework, no database, no build
step, in Phase 1.**

---

## 1. The requirements that actually decide this

| Requirement | Present in Phase 1–2? |
|---|---|
| User accounts / login | No |
| Persistent per-user state | No |
| Server-generated artefacts (PDFs, saved reports) | No |
| Scheduled background work | No |
| Content volume needing a CMS | No — 15–25 pages |
| Dynamic content per request | No |
| Form submission → external API | **Yes** (one endpoint) |
| Client-side interactive calculators | **Yes** (pure client-side) |

One row requires a server, and it requires about eighty lines of it. Everything
else is documents.

## 2. Why HTML + PHP, concretely

**Attack surface is a first-order concern here, not a footnote.** This is the
one project in the portfolio where the site being compromised is not an
inconvenience but a business-ending story. Static HTML has no attack surface
worth the name. A single PHP file that accepts a POST, validates it, and makes
one outbound HTTPS call has a surface you can read in one sitting and reason
about completely. A Node application has a `node_modules` tree with hundreds of
transitive dependencies, any of which can ship a compromised release on a
Tuesday. WordPress would be worse still — it is the single most-attacked
software on the public internet, and a security consultancy running an
unpatched plugin is the punchline of a joke you do not want to be in.

**No build step means no build rot.** Static HTML written today opens correctly
in 2031. A Next.js 15 app left untouched for two years will not `npm install`
cleanly. For a site that changes a few times a quarter, that maintenance
asymmetry is the whole argument.

**Performance is free.** Hand-written HTML with inlined critical CSS and two
self-hosted fonts hits LCP well under 1.5s on 4G with no optimisation effort.
Getting a React app to the same number takes deliberate work.

**PHP is already on the hosting.** Hostinger shared hosting runs PHP 8.2 with
no configuration. There is no deploy pipeline, no process manager, no port
binding, no `npm ci` on a shared host with a broken PATH. `git push` to a
deploy hook, or SFTP, and it is live.

**It is fast to build.** Phase 1 is realistically five to seven working days
including the hardening. The same scope in Next.js is two to three weeks by the
time deployment, environment variables and the database that turns out not to
be needed are dealt with.

## 3. What was considered and rejected

### Next.js / Node.js — rejected for Phase 1

Would be justified by user accounts, persistent artefacts, or scheduled work.
None exist yet. Adopting it now means paying the operational tail — dependency
patching, build fragility, a deploy pipeline, a hosting slot — to gain
developer ergonomics on a site that is fifteen static documents.

The scarce resource is not the hosting — a Node slot costs a few dollars. It is
the operational tail: a database to back up, dependencies to patch, an admin
login to secure, a deploy pipeline that can break at 11pm, and a build that
fails six months later because a transitive dependency dropped a Node version.
Static HTML plus PHP has almost no tail. It sits there and works.

Revisit when the triggers in `FUTURE_NODE_FEATURES.md` fire. The migration path
is clean and is designed for in §5.

### WordPress — rejected outright

Ruled out on the security-credibility argument above, and separately on
performance: a WordPress build in this category ends up with a page builder, a
slider plugin, and 900kb of jQuery, none of which this site needs. The only
thing WordPress would buy is a blog editor, and the blog does not exist until
Phase 3 — at which point Markdown files rendered at build time solve it.

### A static site generator (Astro / Eleventy) — rejected, but narrowly

This is the strongest alternative and it is genuinely close. Astro would give
components and layouts instead of copy-pasted HTML, which matters more as the
page count grows toward 40 with the blog.

Rejected for Phase 1 on the build-rot argument and because it reintroduces
`node_modules` for a fifteen-page site. But the decision is revisited at a
specific point: **if the page count passes ~35, adopt Eleventy** (chosen over
Astro for its much smaller dependency tree and its ability to output pure
static HTML that the existing PHP endpoint keeps serving unchanged). PHP
partials via `include` handle the shared header/footer/nav until then, which
covers the duplication problem at Phase 1 scale without any tooling at all.

### Headless CMS — rejected

Content is authored by one person, changes rarely, and belongs in git where it
is reviewable and revertable. A CMS adds a vendor, a monthly cost, an API
dependency and a second place for content to live.

## 4. The Phase 1–3 architecture

```
public_html/
  index.php                    home
  servicios/
    diagnostico.php
    respuesta-a-incidentes.php
    cuestionarios-de-proveedores.php
    seguridad-gestionada.php
  para/
    clinicas.php
    contadores.php
    ecommerce.php
    pymes.php
  recursos/
    index.php
    autoevaluacion.php         client-side tool
    checklist-de-incidentes.php
  blog/                        Phase 3
  contacto.php
  gracias.php
  politica-de-privacidad.php
  terminos.php
  404.php
  .well-known/security.txt
  robots.txt
  sitemap.xml
  assets/
    css/site.css
    js/site.js                 nav, reveal, form UX — under 8kb
    js/autoevaluacion.js       the assessment tool
    fonts/                     self-hosted, woff2
    img/                       AVIF + WebP
src/                           OUTSIDE the web root
  config.php                   reads env, holds no secrets
  render.php                   layout(), meta(), jsonld() helpers
  form-handler.php             the POST target
  vendercrm.php                CRM client
  validate.php
storage/                       OUTSIDE the web root, git-ignored
  leads.csv
  form.log
```

`.php` extensions are hidden by rewrite so URLs are extensionless and stable
across a later migration:

```apache
RewriteCond %{REQUEST_FILENAME}.php -f
RewriteRule ^(.*)$ $1.php [L]
```

Pages are PHP only to use `include` for the shared shell and to inject per-page
meta. There is no database, no session, no user input rendered anywhere except
the one form handler — which never echoes user input back into HTML at all.

## 5. Migration path if Node becomes justified

Designed for now so it is cheap later:

1. URLs are extensionless from day one, so nothing changes in the URL space and
   no redirects are needed.
2. The lead payload contract is defined in `PHP_FORM_SPEC.md` independently of
   PHP, so a Node handler is a drop-in replacement for one file.
3. Page content is HTML with a thin PHP shell — converting a page to a
   component is mechanical, not a rewrite.
4. The likely end state is **not** a full migration. It is the marketing site
   staying static and a Node application being added at `app.ciberseguridad.com.py`
   for the authenticated tooling. Two systems, each simple, is a better outcome
   than one system doing both jobs badly.

## 6. Hosting and hardening

Hostinger shared hosting, PHP 8.2, with these as **launch-blocking** items —
this section is the reason the stack decision is what it is, so it belongs here
rather than in an appendix:

- TLS 1.2+ only, modern cipher suite, target A+ on SSL Labs
- `Strict-Transport-Security: max-age=63072000; includeSubDomains; preload`
  and submitted to the HSTS preload list
- `Content-Security-Policy` with `default-src 'self'`, no `unsafe-inline`
  (hash or nonce the one inline script if one survives), `frame-ancestors 'none'`
- `X-Content-Type-Options: nosniff`
- `Referrer-Policy: strict-origin-when-cross-origin`
- `Permissions-Policy: geolocation=(), camera=(), microphone=(), interest-cohort=()`
- `X-Frame-Options: DENY`
- Zero third-party CDN scripts. Fonts self-hosted. GA4 is the single external
  script and it is loaded with an explicit CSP allowance and SRI where possible.
- `/.well-known/security.txt` with a real contact and an expiry date, signed
- `server_tokens`/PHP version header suppressed; `expose_php = Off`
- Directory listing off; `src/` and `storage/` outside the web root
- DNSSEC enabled on the domain
- SPF, DKIM, DMARC `p=reject` on the mail domain
- Automated weekly re-check of the headers, because a hosting change can
  silently undo this

## 7. Summary

| | Phase 1–3 | Phase 4+ (conditional) |
|---|---|---|
| Pages | Static HTML + PHP includes | unchanged |
| Styling | Hand-written CSS, ~12kb | unchanged |
| JS | Vanilla, <15kb total | unchanged on marketing pages |
| Forms | One PHP endpoint | unchanged |
| Data | CSV + VenderCRM | + MySQL for saved assessments |
| Auth | None | Node app on a subdomain |
| Build | None | Eleventy if page count > 35 |
| Hosting | Hostinger shared | + Node slot only if triggers fire |
