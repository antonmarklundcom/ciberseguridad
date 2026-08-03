# SERVICE_PAGE_PLAN.md — ciberseguridad.com.py

The build sheet for the money pages. One section per page: what it targets, its
section order, the copy points, and the acceptance criteria. An implementer
should be able to write each page from this without further strategy input.

---

## Shared template

Unless a page overrides it, every service page follows this order:

1. **H1 + one-sentence subline + primary CTA** (above fold at 390px)
2. **La situación** — name the reader's circumstance in their words
3. **Qué hacemos** — the service, concretely
4. **Qué recibís** — the deliverable, itemised
5. **Cómo trabajamos** — the three-step process with real timeframes
6. **Cuánto cuesta** — a starting band, not "consultanos"
7. **Preguntas frecuentes** — 4–6, feeding `FAQPage` schema
8. **CTA final** — full-width accent section, one action

Overrides are called out per page below.

Word count target: 700–1,100. Below 600 it will not rank against nothing;
above 1,400 nobody in this audience reads it.

---

## 1. `/servicios/diagnostico` — Diagnóstico de seguridad

**Target:** `auditoría de seguridad informática paraguay`
**Reader:** a manager or owner who suspects they are exposed but does not know
where, and wants a defensible picture before spending money.
**Trigger:** "got scared" / "got audited"

### Copy points

**La situación.** They have an IT provider who says everything is fine. They
have antivirus. They are not confident that is the whole answer, and they
cannot evaluate the answer they are getting. Name that discomfort directly —
it is the actual reason they are on the page, and nobody else in this market
will say it out loud.

**Qué revisamos.** Name the domains concretely. Vagueness here reads as not
knowing:

- Identidad y accesos — who can reach what, MFA coverage, dormant accounts,
  shared credentials, offboarding
- Correo y fraude — email authentication (SPF/DKIM/DMARC), impersonation
  exposure, the bank-details-change process
- Copias de seguridad — existence, isolation, immutability, and whether a
  restore has actually been tested
- Puestos de trabajo — patching, disk encryption, endpoint protection, admin
  rights
- Red y segmentación — flat networks, exposed services, remote access
- Terceros — which suppliers hold access, and what happens when one is breached
- Preparación — whether there is a written plan and a call list

**Qué recibís.** An executive summary a non-technical director can read; a
prioritised findings list with severity and effort; a remediation plan your
existing IT provider can execute; and a 30-minute walkthrough call.

That last item matters: prospects fear receiving a PDF and being left alone
with it.

**The sample deliverable.** Link a redacted real report, two or three pages,
as a PDF. Highest-converting asset on the site. Label it clearly as redacted.

**Cuánto cuesta.** A band by company size, e.g. "desde Gs. X para empresas de
hasta 30 puestos". A concrete anchor converts better than "consultanos" and
saves you calls from prospects who were never in range.

### FAQ
- ¿Esto interrumpe la operación? (No — the work is observation and review)
- ¿Necesitan acceso a nuestros sistemas? (What is needed and what is not)
- ¿Y si ya tenemos un proveedor de IT? (Explicitly: you are not replacing them
  — this reassures the reader and avoids making an internal enemy of the
  person who will be asked to approve it)
- ¿Cuánto demora?
- ¿Firman acuerdo de confidencialidad? (Yes, and it is standard)

### Acceptance
- [ ] Sample deliverable PDF linked and genuinely redacted
- [ ] Seven review domains named
- [ ] Price band published
- [ ] No promise of security or immunity anywhere in the copy
- [ ] `Service` + `BreadcrumbList` + `FAQPage` JSON-LD

---

## 2. `/servicios/respuesta-a-incidentes` — Respuesta a incidentes

**Target:** `ataque de ransomware qué hacer empresa`
**Reader:** someone in a crisis, on a phone, possibly at night, possibly on a
compromised device.
**Trigger:** "got hit"

**This page overrides the shared template.** Marketing sections come last, or
not at all.

### Structure

1. **H1: Respuesta a incidentes de seguridad.** Directly beneath it, the phone
   number as a `tel:` link, largest element on the page after the H1. WhatsApp
   as a secondary text link.
2. **Una advertencia, en una línea:** *"Si sospechás que tu correo o tu
   teléfono están comprometidos, llamanos desde otro dispositivo."*
3. **Qué hacer ahora mismo** — the immediate defensive steps, before any
   selling:
   - Disconnect affected machines from the network — but do **not** power them
     off, memory holds evidence
   - Do not delete anything, including the ransom note
   - Do not pay before understanding the situation
   - Change critical credentials from a device you know is clean
   - Write down what you saw and when, as you go
   - If money moved, call the bank now — the window is hours
4. **Cómo te ayudamos** — containment, investigation, recovery, and the report
   afterwards.
5. **Las primeras 48 horas** — an hour-by-hour outline of what an engagement
   actually looks like. Reduces the fear of calling.
6. **Después del incidente** — remediation, and the honest observation that
   most organisations are hit again through the same gap if nothing changes.
   Route to `/servicios/diagnostico`.
7. **Disponibilidad y costos** — honest. See below.
8. **CTA final** — phone.

### Hard constraints

- **No hero image. No scroll reveal. No motion of any kind.** This must be the
  fastest page on the site. Target LCP under 1.0s.
- The sticky mobile bar is `tel:`, not WhatsApp, on this page only.
- The `#B3261E` danger colour is used for the phone CTA here and nowhere else.
- **Publish only a response commitment you will honour at 2am.** If you cannot,
  write: *"Respondemos llamadas en horario laboral. Fuera de horario, dejá un
  mensaje y devolvemos la llamada."* Honest beats aspirational; a missed 24/7
  promise during someone's worst week is unrecoverable reputationally.
- Never state or imply that files can be recovered. Frequently they cannot.
  Say what the process is, not what the outcome will be.

### Acceptance
- [ ] `tel:` link works and fires a GA4 event
- [ ] "Qué hacer ahora mismo" is the first content block, above any selling
- [ ] Zero images, zero JS beyond analytics
- [ ] LCP < 1.0s on 4G
- [ ] Availability statement is literally true
- [ ] No recovery outcome promised

---

## 3. `/servicios/cuestionarios-de-proveedores` — Cuestionarios de proveedores

**Target:** `cuestionario de seguridad para proveedores`
**Reader:** an operations or commercial manager who has been sent a
security questionnaire by a bank, a multinational client, or an insurer, and
has a deadline and a contract riding on it.
**Trigger:** "got asked" — the commercial beachhead

### Why this page matters most commercially
The buyer has an external forcing function, a deadline, a budget already
allocated to keeping the contract, and no internal capability. That is the best
shape a services engagement can have. Give this page the most care.

### Copy points

**La situación.** "Te llegó una planilla de 200 preguntas de un cliente y no
sabés por dónde empezar. Tenés dos semanas y el contrato depende de esto."
Say it exactly that plainly.

**Qué hacemos.**
- Read the questionnaire and translate it into what is actually being asked
- Gap analysis: what you already satisfy, what you do not
- A remediation plan ordered by what moves the questionnaire outcome most per
  unit of effort
- Assemble the evidence pack — policies, screenshots, configurations, records
- Complete the questionnaire in the requester's language and format
- Support you through the follow-up round, which there almost always is

**"¿Y si la respuesta a una pregunta es 'no'?"** — its own subsection, and the
strongest differentiator on the page. Most companies assume any "no"
disqualifies them. Explain that reviewers are generally assessing risk and
trajectory, that a documented remediation plan with dates is usually an
acceptable answer, and that pretending to have a control you lack is the one
answer that actually ends the relationship. This single subsection will convert
readers by itself.

**Qué recibís.** The completed questionnaire, the evidence pack, the
remediation plan, and a reusable file so the next questionnaire takes days
instead of weeks. Name that reuse benefit explicitly — it is how this becomes a
retainer.

**Cuánto cuesta.** Band by questionnaire scope. Note that a rush timeline is
possible and priced accordingly.

### FAQ
- ¿Pueden trabajar con el marco que nos pidieron? (ISO 27001, SOC 2, a bank's
  own template — name whichever you actually can, and only those)
- ¿Cuánto tardan?
- ¿Nos garantizan que el cliente nos apruebe? (**No** — and say why not
  plainly. The decision belongs to the requester.)
- ¿Qué pasa la próxima vez que nos manden uno?
- ¿Firman NDA?

### Acceptance
- [ ] The "¿y si la respuesta es no?" section is present and substantial
- [ ] No approval outcome guaranteed, explicitly disclaimed in the FAQ
- [ ] Only frameworks you can genuinely work with are named
- [ ] Reuse benefit stated

---

## 4. `/servicios/seguridad-gestionada` — Seguridad gestionada

**Target:** `soporte de seguridad informática mensual`
**Reader:** someone who has already done a diagnostic, or who knows they need
ongoing attention and has no internal capacity.
**Trigger:** "queremos apoyo continuo" — the retainer

### Copy points

**Qué incluye**, itemised by cadence, because a retainer sold vaguely is a
retainer that gets cancelled:

- Monthly: patch and configuration review, access review, backup restore test
- Quarterly: posture report, phishing simulation with training for anyone who
  clicks
- Continuous: a named contact for questions, and priority support if something
  happens
- Annual: full re-diagnostic

**Qué NO incluye.** Its own section, and it builds more trust than the
inclusions do. This is not a 24/7 SOC. It is not unlimited incident response
hours. It does not replace your IT provider. Saying so in writing is what
distinguishes a real offer from an over-promise, and it prevents the scope
argument in month four.

**Cuánto cuesta.** Monthly band by company size, minimum term, notice period.

**Cómo empieza.** Almost always with a diagnostic first — you cannot maintain a
posture you have not measured. Route to `/servicios/diagnostico`.

### FAQ
- ¿Reemplaza a nuestro proveedor de IT? (No, and why)
- ¿Qué pasa si hay un incidente? (What is covered, what is billed)
- ¿Hay permanencia mínima?
- ¿Podemos empezar sin el diagnóstico? (Honest answer: possible but worse)

### Acceptance
- [ ] "Qué NO incluye" section present
- [ ] Cadence itemised
- [ ] Monthly band and minimum term published
- [ ] No SOC or 24/7 claim unless literally true

---

## Vertical pages — `/para/*`

**Governing rule: if 400 genuinely distinct words cannot be written for a
vertical, the page is not built.** Templated vertical pages with a swapped noun
are transparent to readers and are doorway pages to Google. Better three real
pages than six hollow ones.

Every vertical page has the same five-part skeleton, filled with genuinely
different content:

1. **La amenaza real de tu sector** — concrete, not generic
2. **Los datos que tenés y por qué alguien los quiere**
3. **La obligación que te aplica** — regulation or contractual
4. **Cómo es el trabajo en una empresa como la tuya** — size, systems, budget
5. **Route** to the relevant trigger pages

### `/para/clinicas`
Threat: ransomware halting patient care; imaging and lab equipment on flat
networks running unsupported operating systems that cannot be patched.
Data: clinical histories, identity documents, billing.
Obligation: confidentiality of health data; Ley 6534/2020 where credit data is
involved; increasingly, insurer requirements.
Angle: **continuity, not just confidentiality.** A clinic that cannot open
tomorrow morning is a different problem from a clinic that leaked data, and the
first one is what keeps directors awake.
Routes to: diagnóstico, respuesta a incidentes.

### `/para/contadores`
Threat: concentration — one office holds the financial data of a hundred
businesses, which makes a small firm a high-value target. Tax-season phishing.
The SET portal credential as a single point of failure.
Data: client financials, tax filings, payroll, powers of attorney.
Obligation: professional confidentiality; client contractual expectations.
Angle: **your clients' data is your professional reputation.** A breach is a
professional-conduct problem, not an IT problem.
Secondary purpose: this page is also a pitch to a referral channel. An
accountant who trusts you introduces you to their client book. Write it so an
accountant finishes it thinking "I should send this to my clients too", and
include a short section addressed to that: *"¿Tus clientes te preguntan sobre
esto?"*
Routes to: diagnóstico, cuestionarios.

### `/para/ecommerce`
Threat: admin-panel takeover, checkout skimming injected via a compromised
third-party script, credential stuffing against customer accounts, fraudulent
orders and chargebacks.
Data: customer PII, order history, payment tokens.
Obligation: payment-processor requirements; platform terms.
Angle: **the store stays open and the checkout stays trustworthy.** Downtime
and a browser warning are both revenue events.
Routes to: diagnóstico, respuesta a incidentes.

### `/para/pymes` — router page
Not a targeted page; a positioning and routing page. The phrase "PYME" is how
this market describes itself so it must be present, but nobody's specific
problem is "being a PYME".
Content: what a small business actually needs versus what gets sold to it; the
minimum viable posture (MFA, tested backups, patching, a payment-change
process, a written call list); honest guidance on what not to buy yet; then
route hard to the three specific verticals and to the self-assessment.
This page's primary conversion is the assessment, not a call.

### `/para/cooperativas` — Phase 3
Threat: member financial data, digital channel fraud, board-level accountability.
Obligation: supervisory expectations, Ley 6534/2020, member trust.
Angle: governance — a board that can evidence it exercised diligence.
Only build once there is capacity to serve an entity of that size credibly.

---

## Cross-page acceptance criteria

Applies to every page in this document:

- [ ] Exactly one H1, containing the primary term naturally
- [ ] Primary CTA visible without scrolling at 390px
- [ ] CTA repeated after every major section
- [ ] `wa.me` prefill is URL-encoded and names this page's service
- [ ] Unique title ≤60 and meta ≤155
- [ ] Valid JSON-LD mirroring visible content, no `aggregateRating`
- [ ] OG image 1200×630 specific to the page
- [ ] Zero fabricated trust signals — scan for numbers, logos, ratings, years
- [ ] No outcome guaranteed anywhere
- [ ] Voseo consistent throughout
- [ ] Links to at least one other money page with descriptive anchor text
- [ ] Reads correctly at 390px before anything else is checked
