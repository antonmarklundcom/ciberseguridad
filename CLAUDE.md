# CLAUDE.md — ciberseguridad.com.py

Working notes for anyone (human or model) touching this repo.
Strategy and specs live in the root `*.md` files; start with `CLAUDE_TASKS.md`.

## Build status

| Block | State |
|---|---|
| A — foundation (scaffold, .htaccess, CSS, fonts, layout, JS) | **Not started**, except the minimal scaffold Block B needed |
| B — validation, CRM client, form handler, form partial | **Done**, 97/97 tests passing |
| C — pages | **Blocked on Phase 0 content** (see `IMPLEMENTATION_PHASES.md`) |
| D — SEO metadata | Not started |
| E — Phase 2 tools | Not started |
| F — launch | Not started |

## Layout

```
public_html/     web root — this is what Hostinger serves
  enviar.php     the only server-side entry point
src/             OUTSIDE the web root: all logic
  config.php     reads env; holds no secrets
  validate.php   B2
  vendercrm.php  B1
  form-handler.php  B3
  partials/lead-form.php  B4
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

# Local server. Note: .htaccess is NOT applied by the built-in server, so
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

## Known TODOs left by Block B

- `src/partials/lead-form.php` — `TODO(content)`: the practitioner's real name
  in the form note (Phase 0).
- `public_html/enviar.php` — `TODO(block-a)`: the 422 re-render uses a bare
  HTML shell; swap in `layout()` from `src/render.php` once A5 lands. The form
  partial itself is final.
