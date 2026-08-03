# LEAD_FUNNEL.md — ciberseguridad.com.py

How a stranger becomes a conversation, how that conversation is qualified, and
what happens to the record.

---

## 1. Entry points, honestly weighted

Do not build the funnel around the assumption that organic search fills it.
Expected share of qualified conversations in year one:

| Entry | Share | Notes |
|---|---|---|
| Referral (accountant, IT provider, existing client) | ~40% | Highest close rate. The site's job here is verification, not persuasion. |
| Outbound and network (events, associations, LinkedIn) | ~30% | The site is the landing page for every touch. |
| Organic search — situational queries | ~20% | Grows over 12–18 months. Incident response and questionnaire pages carry most of it. |
| Tools and content | ~10% | Lower intent, higher volume, longest cycle. |

The design implication: **every page must work for a visitor who arrives
already warm and is checking whether you are real.** That is a different job
from converting cold traffic, and it favours specificity, named humans and real
deliverables over persuasion architecture.

## 2. The four paths

```
                     ┌─────────────────────────────────────┐
  Referral / outbound│                                     │
  ──────────────────▶│  Home → trigger router → service    │──┐
                     │                                     │  │
  Urgent search      │  Incident page (no router, no        │  │
  ──────────────────▶│  detour, phone at the top)          │──┤
                     │                                     │  │
  Situational search │                                     │  │
  ──────────────────▶│  Service or vertical page           │──┤
                     │                                     │  │
  Content / tools    │  Blog or tool → result → service    │──┤
  ──────────────────▶│                                     │  │
                     └─────────────────────────────────────┘  │
                                                              ▼
                                              ┌───────────────────────────┐
                                              │  WhatsApp  ·  Form  ·  Tel│
                                              └───────────────────────────┘
                                                              │
                                                              ▼
                                          local store → VenderCRM → email alert
                                                              │
                                                              ▼
                                              30-min qualification conversation
                                                              │
                                                              ▼
                                              fixed-scope proposal (2–3 days)
```

## 3. The three conversion actions

### WhatsApp — primary everywhere except the incident page

`https://wa.me/595XXXXXXXXX?text=<URL-encoded, page-specific prefill>`

The prefill does real work: it opens the conversation already qualified and
saves you the "which page were you on?" exchange.

| Page | Prefill |
|---|---|
| `/` | `Hola, quiero consultar sobre seguridad informática para mi empresa` |
| `/servicios/diagnostico` | `Hola, quiero un diagnóstico de seguridad para mi empresa` |
| `/servicios/cuestionarios-de-proveedores` | `Hola, un cliente nos pidió completar un cuestionario de seguridad y necesitamos ayuda` |
| `/servicios/seguridad-gestionada` | `Hola, quiero consultar por el servicio de seguridad gestionada` |
| `/para/clinicas` | `Hola, tengo una clínica y quiero consultar sobre seguridad informática` |
| `/para/contadores` | `Hola, tengo un estudio contable y quiero consultar sobre seguridad informática` |
| `/para/ecommerce` | `Hola, tengo una tienda online y quiero consultar sobre seguridad` |
| `/recursos/autoevaluacion` | `Hola, hice la autoevaluación y quiero conversar sobre los resultados` |

Every click fires GA4 `whatsapp_click` with `page_path` and `service`.

**The known cost of WhatsApp-first:** the lead never reaches the CRM
automatically. A WhatsApp conversation is invisible to attribution and to the
pipeline unless someone creates the record. Two mitigations, both required:

1. WhatsApp Business with labelled chats and saved quick replies, so at minimum
   the conversation is triaged in-channel.
2. A one-line rule: **any WhatsApp conversation that reaches the qualification
   stage gets a manual contact created in VenderCRM the same day**, with source
   `cyber:whatsapp-manual`. Without this the pipeline is systematically blind
   to the highest-intent channel and every report understates it.

### Form — for people who prefer a paper trail

Present on `/contacto`, at the foot of every service page, and as the
assessment submission. Deliberately short — see `PHP_FORM_SPEC.md`. This is the
path a larger prospect and a more senior buyer will choose, and it is the only
path that reaches the CRM automatically.

### Phone — the incident page

`tel:` link. Fires GA4 `phone_click`. Primary and largest CTA on
`/servicios/respuesta-a-incidentes`, secondary elsewhere, always present in the
footer.

## 4. Qualification

### What is captured
From the form: name, phone, email, company, employee-count band, sector,
trigger, message. From the assessment: score, per-domain breakdown, employee
band, sector. Attribution comes from the `vc_attr` cookie automatically.

### Scoring
This is a low-volume, high-value funnel. Automated lead scoring would be
premature engineering — you will have single-digit leads per week and you will
read every one. What is needed is **sorting**, not scoring:

| Band | Signal | Action |
|---|---|---|
| **A — call today** | Trigger = incident, or trigger = questionnaire with a deadline, or 30+ employees with assessment score under 40 | Respond within the hour in business hours |
| **B — call this week** | 15+ employees, any trigger, real company | Respond same business day |
| **C — nurture** | Under 15 employees, or trigger = curiosity, or assessment only | Assessment detail email, added to the list |
| **D — not a fit** | Individuals, students, job seekers, offers to sell you something | Polite reply with a pointer to the free resources |

Band D will be a meaningful share of volume. `ciberseguridad.com.py` will
attract students and job applicants. Have a courteous canned reply ready — some
of them will work at a prospect in three years.

The employee-count and sector selects on the form exist to make this sort
possible in five seconds. That is their only purpose, and it is enough.

### Response commitments
- Band A, business hours: within 1 hour
- Band B: same business day
- Band C: within 2 business days
- All bands: whatever is published on the site, and nothing more optimistic

## 5. Nurture

Low-frequency, high-signal. A monthly email is the correct cadence for a B2B
audience of this size; anything more frequent produces unsubscribes without
producing engagements.

**Monthly email — "Lo que pasó este mes"**, one page:
- One local fraud or incident pattern seen recently, described so a
  non-technical reader can act on it
- One thing to check this month, taking under thirty minutes
- One link to a new resource or post

That is the whole newsletter. Its value is that it is short, specific, and
never sells. The sale happens when a trigger fires at the reader's company and
yours is the name they think of.

**Assessment follow-up sequence** (the only automated sequence, 3 emails):
1. Immediately: full result detail, per-domain breakdown, three priority
   actions, sample deliverable PDF
2. +4 days: a deeper piece on their weakest domain
3. +14 days: an offer of a 30-minute call, no pressure, and an explicit
   unsubscribe

Then they join the monthly list. Nothing else.

## 6. Record keeping

Every form submission and every assessment submission:

1. Validated and honeypot-checked
2. Appended to `storage/leads.csv` (outside the web root, git-ignored)
3. Pushed to VenderCRM with a stable `idempotency_key`
4. Notification email sent to the practitioner
5. Visitor redirected to `/gracias`

The local write happens **before** the CRM push, so a CRM outage, a rotated key
or a validation rejection never loses a lead. A weekly manual check
reconciles the CSV against the CRM; anything present locally and absent in the
CRM is replayed with its original idempotency key.

Protocol details: `docs/VENDERCRM_INTEGRATION.md`.
Field-level spec: `PHP_FORM_SPEC.md`.

## 7. Measurement

| Stage | Metric | Where |
|---|---|---|
| Reach | Impressions on the 11 target queries | GSC |
| Engagement | Assessment starts, completion rate | GA4 |
| Intent | `whatsapp_click` and `phone_click` by page | GA4 |
| Capture | Form submissions by source | CRM + CSV |
| Qualification | Conversations by band | CRM |
| Close | Proposals sent, proposals accepted | CRM |

**The single most useful number** is conversations-per-page: which pages
produce people who actually talk to you. Expect the incident-response and
questionnaire pages to dominate and the generic PYME page to underperform.
Reallocate content effort accordingly at month three and month six.

**Deliberately not tracked:** bounce rate, session duration, total pageviews.
In a market this small they are noise and optimising for them pulls the site
toward student traffic.

## 8. Known leaks and their fixes

| Leak | Fix |
|---|---|
| WhatsApp conversations never reaching the CRM | The manual-creation rule in §3. Non-optional. |
| Assessment completed, contact details not submitted | Show the full result first, unconditionally. The email offer must add value (the detail, the priority actions, the sample report), not unlock what was already earned. |
| Band A lead arrives outside business hours | Only publish availability you will honour. An auto-reply on WhatsApp Business stating when you will respond is better than silence and far better than a broken 24/7 promise. |
| Prospect reads everything and never contacts | The sample deliverable and published price bands exist for exactly this person — they are deciding whether to start a conversation they cannot yet price. |
| Referred prospect cannot find who you are | `/nosotros` with a real name and photo, linked from the header, not buried. |
