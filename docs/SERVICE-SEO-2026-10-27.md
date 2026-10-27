# Service SEO and provider navigation release — 27 October 2026

Base main: af42f74418005900795b947dd0f814d4680924fa. Owner explicitly requested improvements to existing service pages, rename/relocation of Proveedores, tests and main merge.

## Delivered

All17 existing service pages retain their H1s and original content, with an added service-specific section explaining scope distinctions, three buying steps and three distinct FAQs each (51 total). The new copy helps visitors compare proposals; it is not a claim that the platform delivers technical security work. No fabricated qualifications, prices, availability, customer cases, legal obligations or technical-review approvals.

All17 service titles and descriptions now explain the service and Paraguayan audience more clearly. Snippets describe the buying question rather than implying published prices or guaranteed outcomes. Titles remain unique and at most60 characters; descriptions remain unique and within the existing60–155 guardrail. These are editorial intent-based improvements, not Search Console-tested keyword/CTR wins.

Proveedores is now Cómo elegir proveedor, under Servicios, with /proveedores/ unchanged. The header no longer has a separate provider item. Its submenu link retains correct active context; footer and supplier-registration cross-link use the new name. Provider title/description/label/H1 and page introduction explain that it is selection advice, not a populated directory. The guide prioritizes self-service scope comparison and the private quotation brief, available with intake off. No provider profiles or new public URLs are created.

## Preservation

Exactly39 indexable URLs,17 service pages and seven guides. All canonical paths, sitemap, robots, redirects, index flags, priorities, publication/modification dates, guide content, dark CSS/JS/images/video loader and recovered homepage are retained. Original17 service texts and H1s match the prior release after removing the clearly bounded added sections. Only17 service title/description pairs and provider title/description/label change in the registry.

Form partial, handler, validator, configuration, lib, durable receipts/storage/retry, consent/intake gates and attribution/analytics code are unchanged. No new runtime dependency, environment variable, database migration, cron or install.

## Verification

PASS:
- Existing PHP release runner, including PHP syntax,98 core,25 orientation,13 configuration, one CRM fallback,28 durable-delivery,166 buyer-journey/URL and64 navigation checks.
-164 new service SEO/provider checks:17 complete editorial sections,51 unique questions/answers, context-preserving CTAs, boundaries, provider placement/name/current state and unchanged provider path.
- SEO checks across all41 registry entries; seven analytics tests; JavaScript syntax.
-184 focused browser checks: all17 service pages at390px with current metadata/canonicals, content, CTA context and no page overflow; four representative pages at390/1440px; no-JavaScript service content and provider-to-brief journey.
-173 menu browser checks across320/390/768/1151/1200/1440px, JS/noJS, keyboard/focus/Escape, all17 service links and provider selection/current state.
- Final short provider H1 separately verified in mobile browser after visual review, including its submenu/current-page journey.

Screenshots inspected for desktop service hierarchy and mobile provider readability. The provider H1 was shortened to the exact requested name to avoid awkward offline-font wrapping. The older generic browser test's no-JavaScript assertion now checks the visible native summary rather than an anchor hidden inside a closed disclosure. This release uses the existing focused menu/service suites; it does not rerun the old full-route visual matrix.

External browser requests blocked; no live site, Hostinger, competitor, search engine, Search Console or customer data contacted. This follows the earlier no-website-contact restriction. No fresh legal/standards claims were added; real expert review remains outstanding. The test browser and task-owned preview server were closed. No new E: disk jobs.

Local evidence: C:/AI work/Artifacts/ciberseguridad/2026-10-27/service-seo. seo-preservation.json contains the field-by-field metadata changes and protected-path audit; service-seo-browser.json contains browser results. Existing Python HTTP/Apache environment was not set up or rerun: routing/CSP are unchanged and selected Python lacks its requests/BeautifulSoup dependencies. Live fonts/media, Apache/LiteSpeed behavior, deployed revision, field performance and rankings remain unverified.

## Reproduce

    php tests/release.php
    node --test tests/analytics.test.cjs

With existing Playwright/Chrome and an intake-disabled loopback PHP preview:

    node tests/service-seo-browser.cjs http://127.0.0.1:PORT
    node tests/navigation-browser.cjs http://127.0.0.1:PORT

BROWSER_EXECUTABLE and NODE_PATH select existing installed tools. Use task-specific TEMP/TMP; BROWSER_ARTIFACTS optionally saves evidence. Browser scripts reject non-loopback targets and abort external requests.

## Deploy and recovery

Redeploy complete merged main following [DEPLOYMENT.md](DEPLOYMENT.md), keeping compatible public/private source and all private configuration, accepted records and pending queues. No hosting action was performed here; deployment/auto-deploy configuration was not inspected. The owner should verify serving revision, the renamed menu/guide, representative service metadata, fonts/media and actual existing form configuration after deployment.

Rollback code to the prior complete release af42f74 if needed, preserving private configuration/storage/queues. Never overwrite data or replay historical enquiries. The previous release already includes the dark restoration, buying resources, mega menu and durable CRM fixes.

Before another metadata batch, obtain a Search Console baseline by query/landing page. Preserve these URLs; do not infer ranking changes from source checks or create synonym/city/provider placeholder pages.

## Title change record

| Existing URL | Previous title | New title |
|---|---|---|
| /proveedores/ | Proveedores de ciberseguridad en Paraguay | Cómo elegir proveedor de ciberseguridad en Paraguay |
| /servicios/evaluacion-ciberseguridad/ | Evaluación de ciberseguridad | Evaluación de ciberseguridad en Paraguay &#124; Alcance |
| /servicios/evaluacion-vulnerabilidades/ | Evaluación de vulnerabilidades | Evaluación de vulnerabilidades en Paraguay &#124; Guía |
| /servicios/pentesting-autorizado/ | Pentesting autorizado | Pentesting autorizado en Paraguay &#124; Qué contratar |
| /servicios/preparacion-respuesta-incidentes/ | Preparación para respuesta a incidentes | Plan de respuesta a incidentes en Paraguay &#124; Guía |
| /servicios/respuesta-incidentes/ | Apoyo de respuesta a incidentes | Respuesta a incidentes en Paraguay &#124; Cómo pedir ayuda |
| /servicios/preparacion-recuperacion-ransomware/ | Preparación y recuperación ante ransomware | Preparación ante ransomware en Paraguay &#124; Recuperación |
| /servicios/seguridad-microsoft-365-google-workspace/ | Seguridad de Microsoft 365 y Google Workspace | Seguridad Microsoft 365 y Google Workspace &#124; Paraguay |
| /servicios/revision-seguridad-nube/ | Revisión de seguridad en la nube | Revisión de seguridad en la nube en Paraguay &#124; Alcance |
| /servicios/backup-recuperacion/ | Revisión de backup y recuperación | Backup y recuperación en Paraguay &#124; Qué comprobar |
| /servicios/seguridad-red-endpoints/ | Seguridad de red y endpoints | Seguridad de redes y endpoints en Paraguay &#124; Guía |
| /servicios/capacitacion-phishing/ | Capacitación sobre phishing | Capacitación sobre phishing en Paraguay &#124; Empresas |
| /servicios/iso-27001/ | Preparación para ISO 27001 | Preparación ISO 27001 en Paraguay &#124; Consultoría y alcance |
| /servicios/asesoria-pci-dss/ | Asesoría PCI DSS | Asesoría PCI DSS en Paraguay &#124; Alcance y contratación |
| /servicios/politicas-gobernanza-seguridad/ | Políticas y gobernanza de seguridad | Políticas de seguridad en Paraguay &#124; Gobernanza |
| /servicios/monitoreo-gestionado-soc/ | Monitoreo gestionado y SOC | Monitoreo gestionado y SOC en Paraguay &#124; Qué comparar |
| /servicios/proteccion-datos-personales/ | Adecuación a la ley de protección de datos personales | Protección de datos en Paraguay &#124; Alcance de asesoría |
| /servicios/ciso-externo/ | CISO externo o responsable de seguridad por horas | CISO externo en Paraguay &#124; Alcance y dedicación |
