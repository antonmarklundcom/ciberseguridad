# Owner checklist — what only you can do

The site builds and runs without any of this. Each item below either switches a
hidden section on or unblocks launch. Nothing here should be invented.

## Before it can go live

- [ ] Hostinger: set the domain's document root to `public_html/` (not the repo root).
- [ ] Hostinger: PHP 8.2; turn `expose_php` Off in hPanel (cannot be set from `.user.ini`).
- [ ] Copy `.env.example` to `.env` on the server and fill in `VENDERCRM_URL`,
      `VENDERCRM_API_KEY`, `NOTIFY_EMAIL`, `MAIL_FROM`.
- [ ] Do one real form submission and confirm the lead reaches VenderCRM
      (`storage/form.log` explains any failure).
- [ ] Confirm the phone/WhatsApp number `+595 995 628862` is the real one (taken from
      `STEP0_RECON.md`); override with `WA_NUMBER`, `PHONE_DISPLAY`, `PHONE_E164`.
- [ ] Legal review of `/politica-de-privacidad` and `/terminos` (both say "pendiente de
      revisión legal"; remove that line after review). Add razón social and RUC.
- [ ] Launch gate (`IMPLEMENTATION_PHASES.md`): SSL Labs A+, securityheaders.com A,
      HSTS preload, DNSSEC, SPF/DKIM/DMARC `p=reject`, GSC verified and sitemap submitted.
- [ ] `public_html/.well-known/security.txt`: contact is the /contacto URL, expiry is
      2027-03-29. Set a real email contact and renew before expiry.

## Phase 0 content (set in `.env`, or drop the file in place)

- [ ] `PRACTITIONER_NAME` — shows the "Quién te atiende" block on /nosotros and names
      who receives the form. Add real photo and credentials there too (only real ones).
- [ ] `CONTACT_EMAIL` — appears in footer, /contacto and JSON-LD.
- [ ] `BUSINESS_HOURS` — shows on /contacto.
- [ ] `INCIDENT_AVAILABILITY` — default is the honest "horario laboral, devolvemos la
      llamada". Only change it to something you will honour at 2 a.m.
- [ ] `PRICE_DIAGNOSTICO`, `PRICE_CUESTIONARIOS`, `PRICE_GESTIONADA`, `PRICE_INCIDENTES`
      — free text after "Desde", e.g. `Gs. X para empresas de hasta N puestos`.
- [ ] Redacted sample report at `public_html/assets/docs/ejemplo-informe-diagnostico.pdf`
      (link appears automatically on /servicios/diagnostico).
- [ ] Which questionnaire frameworks you genuinely work with (see the
      `TODO(content)` in `servicios/cuestionarios-de-proveedores.php`; none are named now).
- [ ] `GA4_ID` (e.g. `G-XXXXXXX`) to enable analytics; the privacy page updates itself.

## Images (none were generated)

- [ ] OG images, 1200x630, at `public_html/assets/img/og/<page>.png`
      (`home`, `servicios-diagnostico`, `servicios-respuesta-a-incidentes`,
      `servicios-cuestionarios-de-proveedores`, `servicios-seguridad-gestionada`,
      `para-clinicas`, ...). The tag is added automatically once the file exists.
- [ ] Real practitioner photo for /nosotros.

## After launch

- [ ] Only when every scan returns the claimed grade: uncomment the technical-posture
      strip in `public_html/index.php` and `nosotros.php`.
- [ ] Phase 2 follow-up emails (`LEAD_FUNNEL.md` §5) in your email provider.
- [ ] Optional: self-host Space Grotesk / Inter (site currently uses the system font stack).
- [ ] Re-run `php bin/build-sitemap.php` when pages are added.

## Deploy por Git (hPanel → Avanzado → GIT) — este sitio es distinto
El sitio se sirve desde `public_html/` del repo, **no** desde la raíz: `src/`, `storage/` y `.env` tienen que quedar fuera del docroot. Si el repo se instala directo en `public_html` de Hostinger, la raíz no tiene `index.php` y el sitio da 404.
1. En GIT: repositorio `antonmarklundcom/ciberseguridad`, rama `main`, ruta de instalación **`ciberseguridad-repo`** (una carpeta fuera del docroot, p. ej. `/home/<usuario>/ciberseguridad-repo`).
2. Por SSH (una sola vez): mover el `public_html` original y apuntar el docroot al repo:
   `mv ~/domains/ciberseguridad.com.py/public_html ~/public_html.old && ln -s ~/ciberseguridad-repo/public_html ~/domains/ciberseguridad.com.py/public_html`
   (ajustá la ruta al layout de tu cuenta; si Hostinger no sigue el symlink, pedile a soporte que cambie el document root a `ciberseguridad-repo/public_html`).
3. Creá `ciberseguridad-repo/.env` (copia de `.env.example`) por el administrador de archivos; Git no lo pisa.
4. Webhook de Hostinger → GitHub → Settings → Webhooks: cada merge redeploya solo.
5. Verificá: `/`, `/contacto`, un POST a `/enviar` y que `/src/config.php`, `/storage/` y `/.env` den 403/404.
