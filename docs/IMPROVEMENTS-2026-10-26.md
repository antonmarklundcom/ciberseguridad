# Buyer journey improvements — 26 October 2026

Base: merged dark restoration dd1cbd402ea02b44a8e932ff81c94277d7edf01f. Owner authorized implementation, tests and merge into main. Production redeployment remains separate.

## Implemented

- All 17 services have an illustrative deliverable and acceptance question, plus contextual guide links. These describe what to agree with a provider, not packages sold by the platform.
- All seven guides link back to services, retain their original advice/sources and pending technical review labels, and add planning worksheets. Visible/Article modification dates reflect the editorial addition; publication dates are retained. The additions organize buying decisions; they are not technical instructions or a claim of expert review.
- Guide hero, sidebar and sticky CTAs carry the same allowlisted service into the existing orientation form. Service and orientation pages expose that context to optional analytics.
- The service catalog compares adjacent scopes. The existing orientation URL has a printable quotation brief usable with intake disabled and without JavaScript. It collects/stores nothing; its print button is progressive enhancement.
- The disabled intake notice points to that brief. No recipient, fees, staffing, qualifications, availability or verified providers are invented. Intake gates remain.
- Optional GA4 records orientation_click, orientation_start once per form view, and valid orientation_submit attempts with service context. This code includes no field values, destination contacts, query strings or full referrers. page_location uses the registry path, including on error pages. Invalid/absent GA4_ID leaves analytics off.
- No generate_lead event is inferred from thank-you visits: bots, direct visits and accepted requests can all reach that page. Submission measures intent only; accepted/delivered totals remain private CSV/outbox operational measures. A consented, deduplicated receipt-backed analytics bridge is deferred. Existing attribution/CRM behavior stays unchanged. If analytics is enabled, review consent requirements and disable overlapping enhanced form/click measurement in GA4. Never label intent events as accepted leads.
- The phone pattern now works with modern browser validation; format errors explain correction; returning to a cached form restores its submit button. The favicon matches the orange/black header symbol.
- Fixed 39-URL inventory, topic/context checks, analytics tests, a PHP release runner and loopback-only browser checks protect future releases.

This implements independent parts of analysis priorities 5, 10, 11, 13–15, 20–21, 23, 25 and 30. It does not complete all 30 recommendations.

## SEO and preserved behavior

Exactly the same 39 indexable URLs: 17 services, seven guides, 15 other pages. Titles, descriptions, canonicals, index flags, publication dates, sitemap, robots, redirects, original service bodies and recovered home content remain. Guide advice is retained and extended; shared rendering adds examples and reciprocal links. Only seven registry modification dates change.

These are additive content/navigation changes, not just colors. No ranking/indexing outcome can be guaranteed without Search Console evidence. Export queries, URLs, clicks, impressions and indexed status before further metadata changes. No new indexable routes, fabricated schema credentials/reviews or mass keyword rewrites.

The dark shell, hero/video loader, orange buttons and pill navigation remain. No handler, validator, configuration, durable storage, CRM library, CSP or routing changes.

## Test commands

From the repository root:

    php tests/release.php
    node --test tests/analytics.test.cjs
    node --check public_html/assets/js/site.js
    node --check public_html/assets/js/analytics.js

The runner resolves its own PHP binary for subprocesses, lints PHP and runs core, orientation, configuration, CRM fallback, durable-delivery, buyer journey and SEO suites. Tests use fictional data and isolated temporary state.

Browser verification with an existing Playwright installation:

    php -S 127.0.0.1:8899 -t public_html tests/router.php
    node tests/browser-check.cjs http://127.0.0.1:8899

The browser rejects non-loopback targets and blocks off-origin requests. BROWSER_EXECUTABLE selects an installed Chrome; NODE_PATH may identify existing Playwright. BROWSER_ARTIFACTS optionally saves screenshots/PDF/JSON. Use task-specific TEMP/TMP. Default tests expect intake off.

Actual handler/transport checks:

    node tests/form-delivery-http.mjs ciberseguridad

Set PHP_BINARY and choose a free FORM_TEST_PORT. This runner disables native cURL, supplies synthetic receipts and uses isolated storage. The fixture correctly passes static assets through and identifies itself with X-Synthetic-Delivery. Tests are never deployed.

For browser synthetic forms, start tests/mock-curl-router.php with CRM_TEST_SOURCE, CRM_TEST_SITE=ciberseguridad, CRM_TEST_MODE_FILE, CRM_TEST_CAPTURE; fictional VENDERCRM_CONFIG_FILE, VENDERCRM_URL/API_KEY; isolated VENDERCRM_OUTBOX_DIR/STORAGE_DIR; LEAD_ENABLED=1, PRACTITIONER_NAME=Synthetic test recipient, blank NOTIFY_EMAIL/MAIL_FROM, GA4_ID=G-TEST. Use PHP -n with mbstring and no native cURL. The mode file supplies a fictional 201 contactId/submissionId/dealId response. Run browser-check.cjs against that loopback server with --synthetic-forms --forms-only. A fixture header is required before filling any form. Never use production recipients/settings.

The older Python HTTP suite requires requests/BeautifulSoup, unavailable in the selected runtime. Equivalent route/canonical/legacy/private-path/disabled-intake checks run in the browser suite; no packages were installed. Apache/LiteSpeed and external fonts/media were not reverified: routing/CSP are unchanged and no live requests were authorized.

## Deployment and recovery

Deploy complete merged main using [DEPLOYMENT.md](DEPLOYMENT.md). Preserve private source/lib/storage layout, configuration, accepted records and pending queues. Include new src/buyer-journey.php and src/buyer-journey.json; public_html alone is insufficient. No new runtime dependency, database, cron or environment change is needed.

After owner redeployment, verify serving revision, home/service/guide/brief, menus, external fonts/media/CSP and existing form configuration. Enabled intake still requires the owner checks and a controlled real receipt test. No Hostinger, DNS, deployment, production form or customer data operation occurred here.

To roll back these changes, restore prior complete dark release dd1cbd4 public/private code together, preserving private configuration/data/queues. The earlier form/CRM repair is retained. Never replace storage or replay historical enquiries.

## Deferred owner/reviewer facts

Operator/contact identity, recipient activation, provider agreements/capacity, fees, genuine technical review, permissioned cases/bios and Search Console evidence remain. Existing citations were retained, not re-fetched. No fresh legal/standards claims were added. Offer examples are illustrative until actually contracted.

## Final local results

PASS: 79 PHP syntax files; 98 core, 25 orientation, 13 configuration-gate, one CRM fallback, 28 durable-delivery and 166 buyer-journey/URL assertions; SEO all 41 registry entries. PASS: seven analytics tests and JavaScript syntax.

PASS: 577 default-intake browser checks across all 39 URLs at 320/390/1440px, redirects, private/unknown routes, disabled POST, keyboard, no-JavaScript and print. PASS: 35 enabled-fixture browser checks including corrected phone validation, service prefill, no field values in analytics, synthetic JS/no-JS submissions and returning to the form. PASS: 15 actual handler HTTP transport checks for strict receipts, idempotent replay, outages, retry and required local-write failure.

Protected-path diff confirms the recovered homepage, original 17 service bodies, form-handler/validator/configuration, lib, routing/CSP, sitemap and robots are unchanged. Registry comparison confirms only seven modification dates differ. No dependencies installed or live requests made.
