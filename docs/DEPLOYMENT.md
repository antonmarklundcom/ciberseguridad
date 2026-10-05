# Manual deployment and rollback — October 2026

Publication-ready code ships with request intake disabled by default. It does not establish verified business facts or live delivery. No merge or deployment is authorized by this implementation task.

## Contents and prerequisites

Deploy `public_html/`, `src/`, `bin/`, `storage/.gitkeep`, root `.htaccess` and `.env.example` together, preserving relative locations. Never deploy `.tools/`, tests, screenshots, audit captures, `.git/`, local `.env` or test leads. PHP must read private source and write private storage. Do not use world-writable permissions.

Tests used PHP 8.3.33/8.5.11 with mbstring/curl/openssl, plus Apache 2.4.69 and mod_fcgid. Actual Hostinger LiteSpeed/PHP needs staging verification. `.user.ini` keeps display_errors off; disable `expose_php` in the host settings as well.

## Before replacement

1. Back up actual hosting files, `.env`, private storage and server settings. No inspected Git branch matched all 39 live pages; this implementation includes recovered public content rather than live PHP source.
2. Review the draft PR and business role. Do not auto-deploy the default planning branch. This change targets `main` from `codex/business-orientation-redesign`.
3. Stage separately and copy `.env.example` to private `.env`, retaining `LEAD_ENABLED=0`. Never overwrite production `.env` or a pre-existing CSV with release contents. New intake uses separate `orientation-leads.csv`; existing `leads.csv` remains untouched.

## Supported document roots

Preferred: point the domain document root directly to the release's `public_html/`. `src/`, `.env` and `storage/` remain outside it. `public_html/.htaccess` handles routing, canonical URLs, headers and additional denials.

Alternative: if Hostinger Git deployment makes the repository root the document root, include root `.htaccess`. It routes into nested `public_html/` and forbids direct private paths and `/public_html/` requests. Both layouts passed local Apache checks. Verify actual Hostinger behavior before traffic. A server that ignores `.htaccess` requires equivalent host-level configuration.

## Staging verification

Check home, services (including a nested service), resources, contact, orientation, privacy, incident guidance, sitemap, robots and `.well-known/security.txt`. Canonicals use HTTPS, non-www and trailing slashes. Old service/tool URLs redirect to relevant pages. Unknown URLs return 404, not 500. Private config/source/storage URLs return 403/404 without content. Verify headers and CSS/JS/images under CSP.

Static asset cache is one day; CSS/JS cache-busting remains. No security rating, live TLS grade, DNSSEC or HSTS preload claim is made. HSTS covers the current hostname without an unverified subdomain/preload commitment.

Before intake, complete `owner-todo.md`. Set verified `PRACTITIONER_NAME` and either valid monitored `NOTIFY_EMAIL`, or HTTPS `VENDERCRM_URL` with a private API key. The presence gate cannot verify ownership/delivery. Test staging mail/CRM, monitor pending private rows and failures, and assign retry responsibility. The visitor's success receipt confirms private recording, not guaranteed downstream delivery or specialist availability.

Schedule daily CLI cleanup with the host's verified PHP executable and absolute private release path: `php /absolute/private/path/bin/purge-leads.php`. It removes CSV rows older than 30 days. CRM, email, backups, rate-limit files and operational logs need separate owner-defined retention. No hosting task was scheduled here.

## Rollback

Keep the pre-deployment snapshot and configuration. On routing, assets or storage failures, restore public/private code together and the previous document-root/server settings. Preserve newly received private records separately before rollback; never replace lead storage with an empty release directory. Disable intake while reconciling a failure.

No production forms, external messages, Hostinger changes or merges were performed.
