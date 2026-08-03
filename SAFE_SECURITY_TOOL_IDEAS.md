# SAFE_SECURITY_TOOL_IDEAS.md — ciberseguridad.com.py

Which tools can be built, which cannot, and the rule that separates them.

---

## 1. The bright line

You asked what AI safety restrictions permit. The honest answer is that they
are not the binding constraint here — Paraguayan law and your professional
liability are, and they draw a stricter line in the same place. The rule that
resolves every case:

> **A tool may process what the user tells you about their own organisation.
> A tool may not reach out and touch a system, unless the user has proven they
> control it.**

Declarative input is safe. Interaction with a remote host is not, until
ownership is verified.

This is not an arbitrary boundary. It tracks Paraguayan criminal law: Ley
4439/2011 amended the Código Penal to criminalise unauthorised access to
computer systems (Art. 174b and related). "It was only a port scan" and "it was
only an HTTP header request" are not statutory defences, and the fact that a
visitor typed the URL into your form does not establish that the visitor owns
the host. A tool that accepts an arbitrary URL and probes it is a tool that
performs unauthorised access on your infrastructure, at your IP, on behalf of
whoever asked.

It is also the correct commercial line. The obvious lead magnet in this
category — "escaneo gratis, ingresá tu dominio" — is offered by dozens of
vendors, generates unqualified traffic, and would put a security consultancy in
the position of running unauthorised scans as its marketing strategy. It is the
one idea in this space that looks clever and is actually disqualifying.

## 2. Build these — all safe, all valuable

### 2.1 Autoevaluación de riesgo (self-assessment) — **build first**

The highest-value tool on this list by a wide margin, because it is three
things at once: a lead magnet, a qualifier, and a sales-call agenda.

**Mechanics.** 18–22 questions across 7 domains, all declarative, all
multiple-choice, no free text. Entirely client-side JavaScript. Nothing is sent
anywhere until the user chooses to submit the result with their contact details.

Domains and sample questions:

| Domain | Example question |
|---|---|
| Copias de seguridad | ¿Cuándo fue la última vez que restauraron un backup para verificar que funciona? |
| Identidad y accesos | ¿Usan segundo factor en el correo corporativo? |
| Correo y fraude | Si un proveedor les escribe pidiendo cambiar su cuenta bancaria, ¿qué proceso siguen? |
| Dispositivos | ¿Todas las computadoras reciben actualizaciones automáticas? |
| Terceros | ¿Saben qué proveedores tienen acceso a sus sistemas? |
| Personas | ¿Cuándo fue la última capacitación sobre fraude y phishing? |
| Preparación | ¿Existe una lista escrita de a quién llamar si mañana no arranca ningún sistema? |

**Scoring.** Weighted, not a flat sum. Backups, MFA and BEC process carry
roughly double weight — they are where actual Paraguayan losses concentrate.
Output is a 0–100 score plus a per-domain breakdown, banded:

- 0–39 **Exposición alta** — a serious incident would likely be unrecoverable
- 40–69 **Exposición media** — the basics exist, the gaps are specific
- 70–100 **Base sólida** — the remaining work is depth

**Framing — this is where a self-assessment tool goes wrong.** The result must
never say or imply "estás seguro" or "estás protegido". A high score means the
declared controls are in place, nothing more. The output carries, prominently:

> Este resultado se basa únicamente en lo que indicaste y no constituye una
> evaluación técnica. Un puntaje alto no significa que tu empresa esté segura.

**Conversion.** Result is shown in full, unconditionally, without a form. Then:
"Recibí el detalle por correo, con las tres acciones prioritarias para tu
caso" → name, email, phone, company size, sector. Never gate the result — the
usefulness is the reason they share the details.

**Why it qualifies leads.** The submitted payload carries the score, the
per-domain breakdown, employee count and sector. A 25-point score at a
120-employee clinic is a sales call today. An 80-point score at a 3-person
business is a newsletter subscriber. You know which is which before you dial,
and the low score gives you an opening line that is about them.

**Safety review:** all input declarative, nothing transmitted to third parties,
no host contacted, no data about anyone but the respondent's own organisation.
Clean.

### 2.2 Quiz de reconocimiento de phishing

**Mechanics.** 10 screenshots of messages — email and WhatsApp, since WhatsApp
fraud is the dominant vector in Paraguay. User marks each legitimate or
fraudulent. Each answer reveals the specific tells: display name versus actual
address, the urgency framing, the bank-details change request, the lookalike
domain, the pressure to bypass process.

**Localisation is the whole value.** Generic phishing quizzes exist in Spanish.
None of them use messages that look like they came from a Paraguayan bank, the
SET, a local ISP, or a supplier asking to change a bank account. Build the
examples from patterns actually seen locally — with all real identifiers
replaced by invented ones.

**Critical construction rule:** every example is **fabricated in the style of**
a real pattern, never a real captured phish, and never uses a real
organisation's name, logo, or lookalike domain. Using a real bank's brand in a
fake fraudulent message — even educationally — creates trademark exposure and a
screenshot that can be lifted and used for actual fraud. Use invented names
("Banco del Este", "Importadora Lambaré S.A.") that are visibly fictional.

**Safety review:** teaching recognition is purely defensive. The tells are
defensive knowledge — an actual attacker knows them already. No template that
could be repurposed into a working phishing kit is produced. Clean, with the
fabrication rule enforced.

**Conversion:** "Este quiz para tu equipo" → team-training lead. Strong offer:
it is a small, concrete, easy-to-approve first engagement.

### 2.3 Checklist de respuesta a incidentes

**Mechanics.** A short branching questionnaire — what happened (ransomware /
account takeover / data leak / fraudulent transfer / unsure), when, what is
affected — producing a printable prioritised checklist for the first 24 hours.

**Content is entirely defensive:** contain, preserve, notify, recover. Do not
power off encrypted machines (memory evidence). Do not delete anything. Do not
pay before understanding the situation. Change credentials from a known-clean
device. Write a timeline as you go. Who to notify and in what order. When to
involve the bank. When to file a complaint and with whom.

**Highest-value element:** a fill-in-before-you-need-it contact sheet — IT
provider, bank fraud line, key internal decision-makers, insurer, legal — that
prints to one page and goes on a wall. Genuinely useful, costs an afternoon to
build, and it lives in the office with your logo on it.

**Framing:** general guidance, not a substitute for professional response.
Every path ends with the incident-response page and the phone number.

**Safety review:** defensive response guidance. Clean.

### 2.4 Verificador de copias de seguridad (restore readiness)

Deliberately narrow, which is why it is good. 8 questions about whether backups
would actually work: where they are stored, whether a copy is offline or
immutable, when a restore was last tested, how long a full restore takes,
whether that meets what the business can tolerate, who can perform it, whether
that person is on holiday.

Output: a plain verdict on whether the organisation could recover from
ransomware tomorrow, and what to fix first.

**Why this one:** it is the single control that most determines whether a
Paraguayan SME survives a ransomware incident, and the gap between "tenemos
backups" and "podemos restaurar" is where almost every company actually sits.
Narrow, honest, and it opens a conversation that leads directly to a paid
engagement.

**Safety review:** declarative. Clean.

### 2.5 Generador de políticas — **build last, and carefully**

Produces a starting-point document — acceptable use, password and MFA, backup,
incident response, or supplier access — from a short questionnaire about
company size, sector, and current practice. Output: editable text plus PDF.

**The risk is not AI safety, it is false assurance.** A downloaded policy
document that a company files without implementing anything makes them *less*
safe by giving them a compliance artefact in place of a control. It can also be
waved at an auditor or an insurer as evidence of something that is not true.

Mitigations, all mandatory:
- Every generated document carries a visible header: *"Borrador. Debe ser
  revisado y adaptado por un profesional antes de su adopción formal."*
- Placeholders remain visible as `[NOMBRE DE LA EMPRESA]`, `[RESPONSABLE]` — the
  document must look unfinished, because it is.
- A closing section: "Esta política no tiene efecto hasta que estas cinco cosas
  estén implementadas", listing them.
- Never described as making anyone "compliant" with anything.
- Never generate a document claiming conformity with a named standard.

Phase 4. It is the least valuable of the five for lead generation and carries
the most framing risk.

## 3. Do not build these

| Idea | Why not |
|---|---|
| "Escaneá tu dominio gratis" — any tool taking an arbitrary URL and probing it | Unauthorised access under Ley 4439/2011, performed by your infrastructure. The visitor typing a URL is not proof of ownership. Non-negotiable. |
| Port scanner, TLS scanner, header checker on arbitrary input | Same as above. The mildness of the probe is irrelevant to the authorisation question. |
| Subdomain / DNS enumeration on arbitrary input | Reconnaissance tooling. Same problem. |
| Email breach lookup ("¿tu correo fue filtrado?") | Requires holding or querying breach corpora. Data-protection exposure, and it normalises submitting an email address to an unknown party — the exact behaviour you teach people to avoid. |
| Password strength checker taking a real password | Trains users to type real passwords into web forms. Actively harmful pedagogy even when done client-side. |
| Any exploit, PoC, payload generator, or "test if you're vulnerable to X" | Offensive tooling. Excluded categorically. |
| Live threat map / attack counter | Theatre. Fabricated or meaningless data, and it is exactly the visual cliché the positioning avoids. |
| Dark-web monitoring | Cannot be delivered honestly at this scale; the phrase is mostly marketing. |
| Public leaderboard of assessment scores | Publishes which local companies are weakest. Reckless. |

## 4. The one exception, and its conditions

An **external posture check on a domain the user has proven they control** is
legitimate — it is what a client actually wants and it is standard practice
with authorisation. It is excluded from Phase 1–3 solely because doing it
correctly requires infrastructure this stack does not have.

Conditions, all required, before it could ship:

1. **Ownership verification** — a DNS TXT record containing a per-request
   nonce, or a file at a nonce path. Verified server-side before any probe.
2. **Authenticated account** — tied to a real, verified identity, not anonymous.
3. **Explicit written authorisation** accepted in-session, logged with
   timestamp, IP, and account, and retained.
4. **Strictly passive-to-benign scope** — TLS configuration, security headers,
   public DNS records, published email authentication policy. No port scanning,
   no fingerprinting, no payloads, no authentication attempts.
5. **Rate limiting** per account and per target.
6. **Full audit log** of every check performed, retained.

That is a Node application with accounts, a job queue, and an audit store. See
`FUTURE_NODE_FEATURES.md`. Do not attempt a cut-down version — the verification
step is the entire safety property, and a version without it is the forbidden
tool with extra steps.

## 5. Build order

| Order | Tool | Phase | Effort | Value |
|---|---|---|---|---|
| 1 | Autoevaluación de riesgo | 2 | 3–4 days | Very high |
| 2 | Checklist de respuesta a incidentes | 2 | 1–2 days | High |
| 3 | Quiz de phishing | 3 | 2–3 days | Medium-high |
| 4 | Verificador de copias de seguridad | 3 | 1 day | Medium |
| 5 | Generador de políticas | 4 | 3–4 days | Medium |
| — | Posture check with verified ownership | 5, conditional | 3–4 weeks | High, gated |

## 6. Rules for every tool built here

1. Client-side by default. Nothing leaves the browser until the user submits.
2. No tool contacts any host the user has not proven they own.
3. No tool claims the user is secure, protected, or compliant.
4. Every result carries its limitation in visible text, not a footnote.
5. Results are shown in full before any form. Gating the value destroys it.
6. No tool stores data about a third party.
7. Every tool ends by routing to a service page and a human conversation.
8. Every tool is reviewed against this list before it ships, in writing.
