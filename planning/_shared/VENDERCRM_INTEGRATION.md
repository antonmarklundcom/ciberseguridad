# VenderCRM integration — shared spec

Every property in this set sends its leads to VenderCRM. The integration is
identical across them; only the `fields` payload and the `source` string
differ. Project docs reference this file rather than restating it.

---

## The one architectural rule

**The browser never talks to VenderCRM.** The form posts to the site's own
server; that server posts to VenderCRM with the site's API key.

```
visitor → [form] → site's own PHP/Node handler → VenderCRM /api/v1/leads
                     (holds the key)
```

The endpoint sends no CORS headers on purpose. A browser `fetch` to it fails by
design — that is what keeps the API key out of page source. A leaked key lets
anyone write into the pipeline, and rotating it means touching every site that
shares it.

## Configuration

Obtain from VenderCRM → **Sitios**, per site:

1. **CRM base URL** — e.g. `https://crm.sudominio.com`
2. **Site API key** — created per site, shown exactly once

One key per site, never shared. That is what makes per-site lead reporting work
and lets one compromised site be cut off without touching the others.

Store as `VENDERCRM_API_KEY` in the server environment. Never in HTML, never in
client JS, never committed.

## Endpoint

`POST {CRM_URL}/api/v1/leads`
Headers: `Content-Type: application/json`, `X-Api-Key: <site key>`

| Field | Required | Notes |
|---|---|---|
| `phone` | **yes** | 6–30 chars. The contact identity. `0981 123 456` is normalized to `+595981123456` server-side |
| `idempotency_key` | **yes** | 8–100 chars |
| `name` | no | ≤200 |
| `email` | no | ≤320, must parse as an email if sent |
| `message` | no | ≤5000 |
| `source` | no | ≤100. Defaults to `site:<site-slug>` |
| `utm_source` `utm_medium` `utm_campaign` `utm_term` `utm_content` | no | ≤200 each |
| `gclid` `fbclid` | no | ≤200 |
| `page_url` `referrer` | no | ≤2000 |
| `fields` | no | Object. Everything else worth keeping on the timeline |

Omit optional fields rather than sending `""` — an empty string fails
validation on `email`.

**Never send pipeline, stage, owner or tag.** Routing lives on the site record
inside the CRM so it can be changed without a code deploy, and so a leaked key
cannot redirect leads into another pipeline.

### Responses

| Status | Meaning | Handler behaviour |
|---|---|---|
| `201` | Created. Body: `contactId`, `dealId`, `submissionId`, `duplicate:false` | Success |
| `200` | Idempotency key replayed, `duplicate:true` | Treat as success — the retry worked |
| `401` | Missing/invalid key | Log loudly; site misconfigured |
| `403` | Site deactivated or subscription read-only | Log; check **Sitios** / billing |
| `422` | Validation failed; body names the field | Log the body |
| `429` | Rate limited (60/min per site) | Log; back off |

## Six rules that decide whether this works in production

1. **Key server-side.** Covered above.
2. **Always send `idempotency_key`.** Users double-click; networks time out
   after the write succeeded. Derive it from data identifying *this*
   submission — `sha256(phone + "|" + YYYY-MM-DD-HH)` collapses genuine
   double-submits while still letting the same person enquire again tomorrow.
   A per-submission UUID is fine if the form already has one.
3. **Phone is required and is the identity.** `type="tel"`, `required`, and
   validated server-side too. Accept the local format people actually type.
4. **Stop spam at the site, not in the CRM.** Honeypot on every form:
   ```html
   <input name="website" tabindex="-1" autocomplete="off"
          style="position:absolute;left:-9999px" aria-hidden="true">
   ```
   Non-empty on arrival → redirect to thank-you, post nothing. Add Cloudflare
   Turnstile once a property has real traffic.
5. **Never block the visitor on the CRM.** try/catch with a ~10s timeout. If
   the CRM is unreachable, still show the thank-you page and log the failure.
   A visitor who filled a form and got an error page is a lost customer; a
   logged error is a five-minute fix.
6. **Capture attribution.** Add to every page:
   ```html
   <script src="{CRM_URL}/vc-attribution.js" defer></script>
   ```
   It stores the first `utm_*` / `gclid` / `fbclid` in a 90-day `vc_attr`
   cookie and never overwrites it. Read that cookie server-side and map it into
   the payload. Without it every lead looks like direct traffic.

## Per-project `source` and `fields`

`source` is set explicitly rather than relying on the default, so campaign and
page origin survive into reporting.

| Project | `source` pattern | Key `fields` |
|---|---|---|
| ciberseguridad | `cyber:{page-slug}` | `servicio`, `empleados`, `rubro`, `disparador`, `urgencia`, `autoeval_score` |
| viaje | `viaje:{page-slug}` | `destino`, `fecha_salida`, `pasajeros`, `presupuesto_pp`, `tipo_viaje` |
| visas | `visas:{destino}` | `destino`, `tipo_visa`, `urgencia`, `intentos_previos`, `score`, `banda` |
| criptomonedas | `cripto:{page-slug}` | `interes`, `nivel`, `motivo` |
| prestamo | `prestamo:{page-slug}` | `monto`, `plazo`, `ingreso_banda`, `empleo`, `ciudad`, `urgencia`, `score`, `banda` |

`fields` values must be **enum strings, not free text**, wherever the form uses
a select. Free text in `fields` cannot be filtered on in the CRM. Put free text
in `message`.

## Sites with no backend

If a property is pure static hosting with no PHP or Node, do not stand up a
server just for this. VenderCRM hosts the form:

```
{CRM_URL}/f/{tenant-slug}/{form-slug}
```

Trade-off to state to the user: the hosted form cannot be styled to match the
site and does not pick up the `vc_attr` cookie from their domain. Fine for a
demo; not fine for a property running paid traffic.

None of the five properties here should need this — all four PHP properties
have a server, and viaje has Node.

## Verification before calling any integration done

Do not report success because the code compiles. Confirm the round trip:

1. Submit the real form with a real phone number.
2. VenderCRM → **Contactos**: contact present, phone normalized to `+595…`.
3. **Pipeline**: deal created, if a default stage is configured on the site.
4. **Sitios**: lead counted against this site.
5. Submit the identical form twice — the second must **not** create a second
   contact. If it does, `idempotency_key` is not stable.

## When leads are not arriving

Ordered by how often each is the actual cause:

1. **Check the site's server log first.** The handler swallows errors by design
   (rule 5), so the failure is in the log, not on screen.
2. `401` → key wrong, or `X-Api-Key` not actually sent. On shared hosting,
   `getenv` returning `false` is common.
3. `422` → the body names the field. Usually `email: ""` sent instead of
   omitted, or `idempotency_key` under 8 characters.
4. `403` → site deactivated in **Sitios**, or subscription lapsed.
5. Nothing in the log at all → the form is not reaching the handler. Check
   `action` and method.
6. Contact but no deal → expected unless a default stage is set on the site.
   CRM configuration, not a code bug.

## Local mirror

Every property except `criptomonedas.com.py` also writes the lead to its own
storage before calling the CRM:

- PHP-only properties without MySQL: append a row to a git-ignored
  `storage/leads.csv` **and** send a notification email.
- Properties with MySQL: insert into the project's `leads` table, then push to
  the CRM, then record `crm_contact_id` and `crm_pushed_at` on success.

This is not redundancy for its own sake. It means a CRM outage, a rotated key,
or a `422` never loses a lead, and it gives a replay path: a nightly job picks
up rows where `crm_pushed_at IS NULL` and retries them with the original
`idempotency_key`.
