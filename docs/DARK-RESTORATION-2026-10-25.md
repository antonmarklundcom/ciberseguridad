# Dark design restoration — 25 October 2026

Base: 648ee98c7cf644dc453d3e4031b8146c0023483c (main, merged durable form/CRM repair).
Branch: codex/restore-dark-design-20261025.
Local worktree: C:/Projects/ciberseguridad-dark-20261025.

## Recovery and reconstruction

The original shared PHP/CSS/JavaScript source was not recovered. The 4–5 October audit retained 39 page-body captures, before screenshots and a metadata inventory. A local temporary file also preserved the old complete rendered homepage. The audit intentionally removed forms, scripts, styles and inline styles.

This change restores the old homepage's actual copy and section structure, including **Entender antes de contratar**, the independent-platform explanation, service categories, decision steps, context, commitments and guides. It rebuilds the black shared shell, orange actions, logo, centered pill navigation, Handjet headings and JetBrains Mono text. This is a reconstruction; the missing original stylesheet has not been recovered.

The dark.css layer uses the existing PHP implementation. Google Fonts and the original CloudFront/Higgs references are retained. Decorative videos load lazily; reduced-motion/data-saving visitors get no video load, and pause/play is available. Missing media leaves readable content on a static dark backdrop. No paid generation or new production dependency was introduced.

## SEO comparison

Local comparison against docs/review/live-inventory.json and the 39 old bodies:

| Item | Old dark site vs main before restoration |
|---|---|
| Indexable URLs | Same 39; zero missing and zero added |
| Services | Same 17; headings and most body text retained |
| Guides | Same seven; headings/core material retained, some editorial wording changed |
| H1 | 35 of 39 unchanged |
| Exact page titles | All 39 changed |
| Exact descriptions | 20 unchanged; 19 changed |
| Homepage | Substantially rewritten: about 1,029 captured words versus 437 on main |
| Other larger rewrites | Orientation, incident, contact and privacy |

Word comparisons normalize HTML and omit forms/scripts/styles, as the old capture did. Text alignment is not an SEO or ranking score. Some title changes concern branding/wording. Rankings, Search Console and analytics were not accessed; no actual ranking gain/loss can be established.

## Preserved behavior

All current service/guide bodies, registry titles/descriptions, canonical URLs, index/noindex flags, sitemap, robots and redirects remain unchanged. The homepage returns to its recovered old text/H1 and structure. Intake/consent gates, private storage, separate submission identities, strict CRM receipts and durable retry remain unchanged.

No extra published SEO URL exists in the old 39-page inventory. Do not deploy stripped captures as PHP or replace the current form implementation with historical HTML.

## Verification and limitations

- Existing PHP validation/handler suite: 98 pass; orientation suite: 25 pass; durable delivery: 28 pass.
- SEO suite: all 41 registry entries pass, including 39 indexable pages.
- JavaScript syntax and Git whitespace checks pass.
- Local HTTP: all 39 indexable URLs return 200 with their canonical target.
- All 39 indexable pages checked for mobile overflow; representative desktop/mobile homepage, service, guide and orientation views also checked for one H1.
- Mobile menu opens/closes with Escape; no browser JavaScript errors.
- Reduced-motion preview makes zero video requests.
- External requests were blocked. Font/video/image availability, live CSP and production rendering remain unverified. Screenshots show fallback fonts/static backgrounds.
- No Hostinger action, DNS change or live form submission.

Local screenshots/results: C:/AI work/Artifacts/ciberseguridad/2026-10-25/dark-restoration/.

## Redeployment and recovery

After merge, deploy the complete repository revision using [DEPLOYMENT.md](DEPLOYMENT.md). Preserve private configuration, storage, pending deliveries and consent/intake settings. Use a documented document-root layout; public_html also needs its private PHP dependencies.

Confirm fonts and CloudFront/Higgs assets load under the deployed CSP. Check home, a service, a guide, navigation, canonicals, sitemap and existing form configuration. This change does not enable intake.

If needed, revert only the visual restoration commit. Keep the merged form/CRM repair and all accepted/private records. No database or lead-storage rollback is required.
