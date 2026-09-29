# CLAUDE.md — ciberseguridad.com.py

Working notes for anyone (human or model) touching this repo.
Strategy and specs live in the root `*.md` files; start with `CLAUDE_TASKS.md`.

## Build status

| Block | State |
|---|---|
| A — foundation (`.htaccess`, CSS, JS, `render.php` layout, system fonts) | **Done** (fonts: system stack, no font files) |
| B — validation, CRM client, form handler, form partial | **Done**, 97/97 tests passing |
| C — pages | **Built**; Phase 0 content shown only when supplied (see `docs/owner-todo.md`) |
| D — SEO metadata, JSON-LD, sitemap, robots | **Done**; OG images wait on owner files; `php tests/seo-check.php` |
| E — Phase 2 tools (`/recursos`, autoevaluación, checklist) | **Built** (E4 emails: owner, email provider) |
| F — launch | Not started; owner gate, see `docs/owner-todo.md` |

## Layout

```
public_html/     web root — this is what Hostinger serves
  *.php          one file per page, using page_start()/page_end()
  enviar.php     the only server-side entry point
  assets/        css/site.css, js/*.js (no inline script/style: strict CSP)
src/             OUTSIDE the web root: all logic
  config.php     reads env; holds no secrets
  validate.php   B2
  vendercrm.php  B1
  form-handler.php  B3
  partials/lead-form.php  B4
  render.php     layout(), meta(), jsonld(), breadcrumbs(), helpers
  pages.php      page registry: titles, descriptions, nav, sitemap
  assessment.php questions and weights for the self-assessment
bin/build-sitemap.php   regenerates public_html/sitemap.xml
storage/         OUTSIDE the web root, git-ignored: leads.csv, form.log, ratelimit/
tests/run.php    zero-dependency test suite
```

`src/` and `storage/` being outside the web root is load-bearing, not stylistic.
On Hostinger, set the domain's document root to `public_html/`. If the whole
repo ends up served, `storage/leads.csv` becomes a public file.

## Commands

```bash
# Tests — no dependencies, no database, no network.
php tests/run.php

# SEO and content guard rails: titles, descriptions, H1, JSON-LD, CSP-inline,
# fabrication words, tú-forms, links, sitemap parity.
php tests/seo-check.php

# Local server with extensionless URLs (router emulates .htaccess).
php -S 127.0.0.1:8899 -t public_html tests/router.php

# Plain local server. Note: .htaccess is NOT applied by the built-in server, so
# extensionless URLs don't work locally — POST to /enviar.php, not /enviar.
php -S 127.0.0.1:8899 -t public_html
```

PHP 8.2 is the deployment target (Hostinger). 8.4 is fine for development;
`fputcsv`/`fgetcsv` are called with an explicit `$escape` argument so the 8.4
deprecation doesn't fire.

## Secrets

Copy `.env.example` to `.env` and fill it in. `.env` is git-ignored and is
additionally denied by `.htaccess` (Block A2). Never put a key in HTML, in
client JS, or in a commit.

On shared hosting `getenv()` returning `false` is a common cause of a silent
`401` from the CRM — `src/config.php` reads the `.env` file first for exactly
this reason. If leads stop arriving, read `storage/form.log` before anything
else; the handler swallows CRM errors by design so the visitor is never blocked.

## Conventions that bite

- Paraguayan Spanish, voseo, `es-PY`. Never `tú` forms.
- No fabricated trust signals — see `docs/CONVENTIONS.md` §2. This is a hard
  rule, not a style preference.
- Never promise a security outcome in any copy.
- No tool or page ever contacts a host the visitor has not proven they own.
- Mobile-first: verify at 390px before anything else.

## Owner-supplied facts

Business facts (phone, email, practitioner name, hours, prices, GA4 id) come from
`.env` via `src/config.php`; empty means the section is hidden, never invented.
Full list in `docs/owner-todo.md`. Grep `TODO(content)` / `TODO(legal)` for spots.
