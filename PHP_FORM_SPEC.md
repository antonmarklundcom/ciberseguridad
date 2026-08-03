# PHP_FORM_SPEC.md — ciberseguridad.com.py

The complete specification for the form and its handler. This is the only
server-side code in Phase 1–3, and on a security consultancy's own website it
is the only attack surface — it gets built carefully and reviewed twice.

Protocol details for the CRM call: `docs/VENDERCRM_INTEGRATION.md`.

---

## 1. Fields

Two forms share one handler, distinguished by a `form_type` hidden field.

### Contact form (`form_type=contacto`)

| Field | Name | Type | Required | Validation |
|---|---|---|---|---|
| Nombre | `nombre` | text | yes | 2–100 chars |
| Teléfono / WhatsApp | `telefono` | tel | **yes** | 6–30 chars, digits/space/`+`/`-`/`(`/`)` only |
| Correo | `email` | email | no | ≤320, must parse; omit from payload if blank |
| Empresa | `empresa` | text | no | ≤120 |
| Cantidad de empleados | `empleados` | select | yes | enum below |
| Rubro | `rubro` | select | yes | enum below |
| ¿Qué te trae por acá? | `disparador` | select | yes | enum below |
| Mensaje | `mensaje` | textarea | no | ≤2000 |
| — honeypot — | `website` | text | — | must be empty |
| — timestamp — | `ts` | hidden | — | see §4 |
| — CSRF — | `csrf` | hidden | yes | see §4 |
| — page — | `page` | hidden | — | slug of the originating page |

**Enums** (values are stored, labels are displayed):

```
empleados:  1-9 | 10-24 | 25-49 | 50-99 | 100-249 | 250+
rubro:      salud | contable | ecommerce | financiero | industria |
            comercio | servicios | educacion | ong | otro
disparador: incidente        (Tuvimos un incidente)
            cuestionario     (Un cliente nos pidió un cuestionario de seguridad)
            diagnostico      (Queremos saber cómo estamos)
            cumplimiento     (Tenemos una obligación que cumplir)
            continuo         (Buscamos acompañamiento mensual)
            otro             (Otra cosa)
```

`empleados`, `rubro` and `disparador` exist for one reason: to let a lead be
sorted into a band in five seconds (`LEAD_FUNNEL.md` §4). Do not add fields
that do not serve that purpose. Every additional field costs conversions.

**Not collected, ever:** cédula, RUC, document uploads, system details,
credentials, network diagrams, or anything describing the prospect's
infrastructure. A form that invites a worried company to describe its
vulnerabilities in a web form is a form that creates a target — and if it were
ever breached, it would be the end of the business. This is a hard rule, and
the copy next to the message field says so: *"No incluyas contraseñas ni
detalles técnicos sensibles — eso lo conversamos por un canal seguro."*

### Assessment submission (`form_type=autoevaluacion`)

Same fields plus, injected by the tool's JavaScript from client-side state:

| Field | Name | Validation |
|---|---|---|
| Puntaje total | `score` | integer 0–100 |
| Banda | `banda` | `alta` \| `media` \| `solida` |
| Detalle por dominio | `dominios` | JSON, ≤1000 chars, integer values only, keys matched against a server-side allow-list |

`mensaje` is omitted on this form. `disparador` is set to `diagnostico` by
default and remains changeable.

**Server-side, `dominios` is parsed and re-serialised** rather than passed
through. Never forward a client-supplied JSON blob into an outbound API call
unexamined.

## 2. Markup

```html
<form method="POST" action="/enviar" novalidate class="lead-form">
  <input type="hidden" name="form_type" value="contacto">
  <input type="hidden" name="page" value="servicios/diagnostico">
  <input type="hidden" name="ts" value="<?= time() ?>">
  <input type="hidden" name="csrf" value="<?= csrf_token() ?>">

  <!-- honeypot: never remove, never make it look tempting to a human -->
  <input name="website" tabindex="-1" autocomplete="off" aria-hidden="true"
         style="position:absolute;left:-9999px">

  <label for="nombre">Nombre <span aria-hidden="true">*</span></label>
  <input id="nombre" name="nombre" type="text" required
         autocomplete="name" maxlength="100">

  <label for="telefono">Teléfono / WhatsApp <span aria-hidden="true">*</span></label>
  <input id="telefono" name="telefono" type="tel" required
         autocomplete="tel" inputmode="tel" maxlength="30"
         placeholder="0981 123 456">

  <label for="email">Correo</label>
  <input id="email" name="email" type="email"
         autocomplete="email" maxlength="320">

  <label for="empresa">Empresa</label>
  <input id="empresa" name="empresa" type="text"
         autocomplete="organization" maxlength="120">

  <label for="empleados">Cantidad de empleados <span aria-hidden="true">*</span></label>
  <select id="empleados" name="empleados" required>…</select>

  <label for="rubro">Rubro <span aria-hidden="true">*</span></label>
  <select id="rubro" name="rubro" required>…</select>

  <label for="disparador">¿Qué te trae por acá? <span aria-hidden="true">*</span></label>
  <select id="disparador" name="disparador" required>…</select>

  <label for="mensaje">Contanos brevemente</label>
  <textarea id="mensaje" name="mensaje" rows="4" maxlength="2000"></textarea>
  <p class="hint">No incluyas contraseñas ni detalles técnicos sensibles —
     eso lo conversamos por un canal seguro.</p>

  <button type="submit">Enviar consulta</button>

  <p class="form-note">
    Recibe tu consulta [Nombre real], directamente. Respondemos en el día hábil.
    Tus datos no se comparten con terceros.
    <a href="/politica-de-privacidad">Política de privacidad</a>.
  </p>
</form>
```

Notes:
- `novalidate` so validation messaging is controlled and consistent; JS
  validates on blur, PHP validates authoritatively.
- The `form-note` beneath the button is required by the shared conventions:
  who receives the data, what happens next.
- Inputs are 48px minimum height, full-width on mobile, 16px font (below 16px
  iOS zooms on focus and the layout jumps).

## 3. Handler flow

`POST /enviar` → `src/form-handler.php`

```
1.  Method is POST, else 405.
2.  CSRF token valid, else 403 (silent — no detail in the response).
3.  Honeypot `website` empty, else → 302 /gracias, log, send nothing.
4.  `ts` is between 3 seconds and 2 hours old, else treat as bot → 302 /gracias.
5.  Rate limit: max 5 submissions per IP per hour (file-based counter in
    storage/, no database needed). Over → 302 /gracias, log.
6.  Validate every field. Enums checked against server-side allow-lists —
    never trust a select. On failure → re-render the form with errors,
    preserving input.
7.  Normalise: trim, collapse whitespace, strip control characters. Phone
    keeps its local format; VenderCRM normalises it.
8.  Build the idempotency key:
        sha256(telefono + '|' + form_type + '|' + gmdate('Y-m-d-H'))
9.  Read the vc_attr cookie, parse it defensively, map utm_*/gclid/fbclid.
10. Append the row to storage/leads.csv with an exclusive flock.   ← before CRM
11. POST to VenderCRM, 10s timeout, inside try/catch.
       201/200 → record crm_contact_id and crm_pushed_at on the row
       anything else → log status + response body, continue
12. Send the notification email.
13. 302 → /gracias?t={form_type}
```

Order matters. Step 10 precedes step 11 so that no CRM failure mode can lose a
lead. Step 13 is a redirect, not a rendered page, so a refresh does not
resubmit.

**The handler never echoes user input back into HTML on the success path**, and
on the error path it escapes with `htmlspecialchars($v, ENT_QUOTES|ENT_SUBSTITUTE, 'UTF-8')`.
There is no other output path. This is what keeps the surface analysable.

## 4. Security requirements

Non-negotiable on this site specifically.

| Control | Implementation |
|---|---|
| CSRF | Token in a `Secure; HttpOnly; SameSite=Strict` cookie, mirrored in a hidden field, compared with `hash_equals`. Rotated per session. |
| Honeypot | `website` field. Non-empty → silent success. |
| Timing check | Submissions faster than 3s are bots. |
| Rate limiting | 5/IP/hour, file-based counter with `flock`. |
| Input validation | Allow-lists for every enum. Length caps on every field. `filter_var` for email. Reject anything with control characters or newlines in single-line fields. |
| Output encoding | `htmlspecialchars` with `ENT_QUOTES\|ENT_SUBSTITUTE` on the error path; nothing echoed on the success path. |
| Header injection | Notification email built with a mail library, not raw `mail()` string concatenation. Never place user input in a header. |
| Secrets | `VENDERCRM_API_KEY` from the environment. `src/` and `storage/` outside the web root. `.env` git-ignored and additionally denied by `.htaccess`. |
| TLS | The outbound call verifies peer and host. Never `CURLOPT_SSL_VERIFYPEER => false`, under any circumstance, including "just to test". |
| Logging | Log status codes, timestamps, and the CRM response body. **Never log the full submission.** `storage/` is not web-accessible. |
| Error display | `display_errors = Off` in production. A stack trace on a security consultancy's contact form is a very bad day. |
| Dependencies | Zero, or one vetted mail library pinned to an exact version. No package with a large transitive tree. |

## 5. Payload to VenderCRM

```json
{
  "phone": "0981 123 456",
  "idempotency_key": "a3f1…",
  "name": "María González",
  "email": "maria@empresa.com.py",
  "message": "Un cliente nos pidió completar un cuestionario…",
  "source": "cyber:servicios/cuestionarios-de-proveedores",
  "page_url": "https://ciberseguridad.com.py/servicios/cuestionarios-de-proveedores",
  "referrer": "https://www.google.com/",
  "utm_source": "google",
  "utm_medium": "organic",
  "fields": {
    "empresa": "Importadora del Este S.A.",
    "empleados": "25-49",
    "rubro": "comercio",
    "disparador": "cuestionario",
    "form_type": "contacto"
  }
}
```

Assessment submissions add to `fields`:

```json
"score": "34",
"banda": "alta",
"dominio_backups": "1",
"dominio_accesos": "2",
"dominio_correo": "1",
"dominio_dispositivos": "3",
"dominio_terceros": "2",
"dominio_personas": "1",
"dominio_preparacion": "0"
```

Domain scores are flattened into individual `fields` keys rather than nested
JSON, so they are filterable in the CRM. Values are strings.

Rules from the shared spec that apply here: omit optional fields rather than
sending `""`; never send pipeline, stage, owner or tag.

## 6. Notification email

To the practitioner, plain text, subject line built for phone triage:

```
Subject: [A] Cuestionario · Importadora del Este · 25-49 · comercio
```

Band letter first so the phone notification is sortable at a glance. Body:
every submitted field, the source page, attribution, and — on assessment
submissions — the score and the two weakest domains, so the first reply can
already be about them.

The band is computed by the same rules as `LEAD_FUNNEL.md` §4, in one small
function, not by a scoring engine.

## 7. `/gracias`

`noindex, nofollow`. Confirms receipt, restates the published response time,
offers WhatsApp as a faster path with a prefill naming the submitted trigger,
links to `/recursos`. Fires the GA4 `generate_lead` conversion with the
`form_type` parameter.

Content varies slightly by `?t=`: assessment submitters are told the detail
email is on its way.

## 8. Testing checklist

Functional:
- [ ] Valid submission → row in CSV, contact in VenderCRM, email received,
      redirect to `/gracias`
- [ ] Identical submission twice → one contact, `duplicate:true` on the second
- [ ] Honeypot filled → `/gracias`, nothing sent, log entry present
- [ ] Submitted in under 3s → treated as bot
- [ ] Missing required field → errors shown, input preserved, nothing sent
- [ ] Blank email → field omitted from payload, not sent as `""`
- [ ] Invalid enum value posted directly → rejected server-side
- [ ] CRM unreachable → visitor still reaches `/gracias`, row in CSV,
      failure in log
- [ ] Wrong API key → `401` logged with body, visitor unaffected
- [ ] Assessment submission → score and all seven domains in `fields`

Security:
- [ ] Missing/invalid CSRF token → 403
- [ ] `<script>alert(1)</script>` in every field → never rendered unescaped,
      appears literally in CSV and CRM
- [ ] Newline injection in `nombre` → does not reach any email header
- [ ] 6th submission from one IP within an hour → rate limited
- [ ] Direct request to `/src/form-handler.php` → not reachable
- [ ] Direct request to `/storage/leads.csv` → 403 or 404
- [ ] `.env` not reachable over HTTP
- [ ] `display_errors` off; a forced error shows a generic page
- [ ] No PHP version in response headers

Accessibility:
- [ ] Every input has a bound `<label>`
- [ ] Errors linked to fields via `aria-describedby` and announced
- [ ] Full keyboard navigation with a visible focus ring
- [ ] Complete flow usable with a screen reader
- [ ] No input under 16px font size

Run the security block again after any hosting or PHP version change.
