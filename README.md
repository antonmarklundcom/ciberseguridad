# Ciberseguridad.com.py

Independent Spanish-language guidance for businesses in Paraguay. This PHP site explains security services and helps visitors prepare a scoped conversation with a specialist. The platform does not perform technical security work or promise emergency response.

The October 2026 implementation preserves the 39 published live URLs, 17 service pages and seven guides. The live site's original PHP source was not present in any inspected Git branch: reviewed public content was recovered and integrated into the existing PHP shell. See [the Swedish audit and delivery report](docs/review/REPORT-SV.md) for evidence and limitations.

## Current implementation

- `public_html/`: public PHP controllers, assets, sitemap, robots and Apache configuration.
- `src/`: private rendering, page registry, reviewed HTML content, validation and delivery code.
- `storage/`: private CSV, operational logs and rate-limit state; never ship existing data in a release.
- `bin/purge-leads.php`: CLI-only 30-day local lead cleanup.
- `tests/`: isolated validation/transport tests and local HTTP/Apache checks.
- `docs/review/`: live inventory, test evidence, image cost log and before/after screenshots.

No framework, database, production Node dependency or asset build step. PHP 8.3.33 and 8.5.11 were tested. PHP needs mbstring, curl and openssl for the configured delivery path. Apache/LiteSpeed must support the documented `.htaccess` directives.

## Review locally

```sh
php -S 127.0.0.1:8899 -t public_html tests/router.php
php tests/run.php
php tests/orientation.php
php tests/config-gate.php
php tests/seo-check.php
```

The development server emulates page routing only. Apache checks verify rewrite rules, headers, forbidden paths and both supported document roots. Python HTTP checks require requests and BeautifulSoup and target localhost only.

## Publish manually after review

Follow [DEPLOYMENT.md](docs/DEPLOYMENT.md). `.env.example` ships with `LEAD_ENABLED=0`. Requests stay unavailable until the owner verifies the recipient identity, delivery configuration, legal/privacy text, retention and operational monitoring. Do not copy a test recipient into production. No production form submissions, merge or Hostinger deployment were performed.

Older strategy/specification documents and legacy helpers are historical context. They do not establish business capabilities, credentials, prices, staffing, contact numbers or current launch requirements. This README, deployment guide and October report supersede conflicting earlier assumptions.
