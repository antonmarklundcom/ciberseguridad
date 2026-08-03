# PLAN.md — ciberseguridad.com.py

Strategy, critique, and the decisions this project is built on.
Market: Paraguay. Goal: lead generation for cybersecurity services.

---

## 1. The honest framing, before anything else

A cybersecurity website in Paraguay does not create demand. It closes it.

Nobody in Asunción wakes up and searches "empresa de ciberseguridad" the way
they search "cerrajero 24 horas". Search volume for cybersecurity terms in
Paraguay is genuinely thin — a few hundred meaningful commercial searches a
month across the entire category, most of them people looking for a job or a
university course rather than a service. If you build this site expecting
inbound leads to arrive because the site exists, you will conclude after four
months that cybersecurity does not work in Paraguay. The conclusion would be
wrong; the expectation was.

What actually generates cybersecurity engagements in this market:

1. **Referral** from an accountant, an IT provider, a lawyer, or another client.
2. **Outbound** to companies with a visible trigger.
3. **Events and associations** — chambers of commerce, ISACA-type
   professional circles, sector associations, bank supplier days.
4. **Incident response** — a company that got hit calls whoever they can find,
   fast, and that search *does* happen.

The website's job in all four is the same: **the prospect will look you up
before they reply.** Every referral checks the site. Every cold email recipient
who is even mildly interested opens the domain in a tab. The site is the
credibility gate. It converts existing interest into a conversation, and it
does that job whether or not it ever ranks.

This changes what to build. It means:

- Design and specificity matter more than keyword volume.
- The pages that matter most are the ones a referred prospect reads: what you
  actually do, who you actually are, what the deliverable actually looks like.
- SEO is a slow secondary channel worth building correctly but not worth
  waiting on.
- One page — the incident-response page — targets a real, urgent, high-intent
  search and deserves disproportionate attention.

None of this argues against building the site. It argues for building it in one
week rather than six, and spending the saved time on outbound.

## 2. Critique of the ideas as briefed

### "Premium animated lead-gen site first"

**Half right, and the animated half is a trap.**

Right: lead-gen first, tools later. Correct sequencing. Tools are a content and
credibility asset, not a business, and building them before you have a service
that sells is the classic order-of-operations mistake.

The trap: in this category, animation does not read as premium. It reads as
agency. Prospects buying security are, by selection, people worried about
risk — and heavy motion, gradient meshes, particle networks and "cyber" visual
clichés (glowing padlocks, green matrix rain, hooded figures, circuit-board
backgrounds) signal *marketing company* rather than *security practitioner*.
The category's most credible firms have restrained, dense, typographic sites.

There is a much cheaper and much stronger trust signal available, and it is the
single most important recommendation in this document:

> **The site must itself be demonstrably secure, and must show it.**
>
> A+ on SSL Labs. A on securityheaders.com. Full CSP with no `unsafe-inline`.
> HSTS with preload. A published, correct `/.well-known/security.txt`. No
> third-party scripts loaded from CDNs. Subresource integrity where any
> external asset is unavoidable. DNSSEC on the domain. SPF, DKIM and DMARC at
> `p=reject` on the mail domain.

Then put a small, honest technical-posture section on the site linking to the
live third-party scanner results, so a visitor can verify it themselves in one
click. That is a claim no competitor in this market can copy without doing the
work, it costs about a day of configuration, and it is worth more than any
amount of animation. A security company whose own site scores an F is a story
that closes deals for someone else.

So: keep "premium", redefine it as **precision** rather than motion. See
`PRODUCT_SPEC.md` §Design.

### "Cybersecurity services for Paraguayan businesses"

**Too broad to sell.** "Cybersecurity for Paraguayan businesses" describes a
category, not an offer. A prospect cannot tell from it whether to call you, and
you cannot write a page that converts because you do not know who is reading.

Narrow to buying triggers. In this market there are four, and they are what the
service pages should be organised around:

| Trigger | What happened | What they buy | Urgency |
|---|---|---|---|
| **Got hit** | Ransomware, account takeover, data leak | Incident response, then hardening | Hours |
| **Got asked** | A bank, a multinational client, or an insurer sent a security questionnaire | Assessment + remediation + evidence | Weeks |
| **Got scared** | A competitor or peer got hit; a director read something | Diagnostic assessment | Months |
| **Got audited** | Regulatory or contractual obligation | Gap analysis against a named framework | Fixed deadline |

"Got asked" is the best commercial beachhead. It is a real and growing pattern:
Paraguayan companies in the supply chain of Brazilian, Argentine and US firms
are increasingly sent vendor security questionnaires, and they have no idea how
to answer them. The buyer has a deadline, an external forcing function, and no
internal capability. That is the ideal shape for a services engagement.

"Got hit" is the best *search* beachhead. It is the only intent in this category
with genuine urgency behind the query.

### "WhatsApp-first consultation"

**Right, with one exception that matters.**

WhatsApp is correct for Paraguay generally and correct for the "got scared" and
"got audited" triggers. But there is a real tension: a company that has just
been breached should not be asked to describe the breach over WhatsApp on a
possibly-compromised device, and a CISO-equivalent at a larger company will
often prefer email for a first contact that leaves a paper trail.

Resolution: WhatsApp is the primary CTA everywhere **except** the incident
response page, where the primary CTA is a phone number (`tel:`) with WhatsApp
secondary, plus one line of advice: *"Si sospechás que tu correo o tu teléfono
están comprometidos, llamanos desde otro dispositivo."* That line costs nothing
and is exactly the kind of specificity that makes a security firm sound like a
security firm.

Also add a plain email address, visible, on the contact page. B2B buyers at the
larger end of your range expect one, and its absence is a small credibility
leak.

### "Contact form to VenderCRM later"

**Do it from day one, not later.** The integration is a few hours of work
against a spec that already exists (`planning/_shared/VENDERCRM_INTEGRATION.md`).
Retrofitting means a period where leads live only in an inbox, which is where
leads go to die, and it means the attribution cookie was not being set during
exactly the period you most need to learn which channel works.

Build it in Phase 1. Write to a local CSV *and* push to the CRM, so a CRM
outage never loses a lead.

### "SEO pages: pymes, colegios, clínicas, contadores, ecommerce"

**Good instinct, wrong axis, and one of these should be dropped.**

The instinct — vertical pages — is right. Vertical pages convert far better
than generic ones because they let you name the reader's actual situation, and
in a thin-volume market long-tail specificity is the only viable SEO play.

Two problems:

*Wrong axis.* These are industry segments, but the buying trigger is what
actually determines whether someone calls. A clinic that just got ransomwared
and a clinic idly considering security are different prospects who need
different pages. The strongest architecture is **trigger pages as the money
pages, vertical pages as the supporting layer**, with each vertical page
routing to the relevant trigger page.

*Vertical selection.* Assessed individually:

- **Clínicas / sector salud** — strongest. Patient data, real legal exposure,
  budget, and a genuine ransomware pattern in the region. Build first.
- **Contadores / estudios contables** — strong and underrated. They hold client
  financial data, they are a compliance-minded audience that understands
  professional liability, and critically **they are a referral channel to every
  other vertical**. An accountant who trusts you sends you their client book.
  This page is worth building for the referral relationship alone.
- **Ecommerce / tiendas online** — good. Payment data, a concrete fraud story,
  and an owner who already thinks about their site.
- **PYMES** — keep, but understand it is a positioning page, not a targeted
  one. "PYME" is how the market describes itself, so the phrase must appear,
  but nobody's specific problem is "being a PYME". Make it the general entry
  page that routes to the specific ones.
- **Colegios** — **drop it, or defer it to Phase 4.** Paraguayan private
  schools have the thinnest security budgets of any segment on this list, the
  longest decision cycles, committee-based purchasing, and the lowest deal
  sizes. It is the least commercially attractive vertical here and it is
  occupying a slot.

Replace it with one of:

- **Estudios jurídicos** — client confidentiality is the entire product; a
  breach is a professional-conduct problem, not just an IT problem.
- **Cooperativas** — this is the strongest replacement. Paraguay has a large,
  well-capitalised cooperative sector holding member financial data under real
  supervisory attention. They have budget, boards that ask questions, and a
  compliance function that already exists. Recommended.
- **Importadoras / logística** — high BEC/invoice-fraud exposure, which is the
  single most common real loss event for Paraguayan companies of this size.

Recommendation: launch with **clínicas, contadores, ecommerce, pymes**, add
**cooperativas** in Phase 3, and skip colegios.

### "Defensive-only blog content"

**Correct and non-negotiable**, but "defensive-only" understates the editorial
opportunity. The highest-value content in this market is not "what is
ransomware" — that exists in Spanish a thousand times over and you will not
outrank it. It is **local, specific, and operational**:

- How to respond to a vendor security questionnaire, with a worked example.
- The fraud patterns actually hitting Paraguayan companies right now — invoice
  redirection, WhatsApp account takeover, fake supplier bank-change emails.
- What Ley 6534/2020 means in practice if you hold customer data.
- What a bank actually asks a supplier for, and how to have those answers ready.
- Backup verification: how to prove your backups work before you need them.

That content has almost no competition, is genuinely useful, is entirely
defensive, and every piece routes to a service page. See `SEO_ARCHITECTURE.md`.

### "Future safe tools"

**All five are buildable and all five are safe.** They share the property that
makes them safe: they operate on information the user tells you about their own
organisation, and they never touch a remote system. See
`SAFE_SECURITY_TOOL_IDEAS.md` for the full analysis, including the one
bright-line rule that keeps this project out of trouble.

Priority among the five: the **risk self-assessment** is worth building first
by a wide margin — it is a lead magnet, a qualifier, and a sales-call opener in
one artefact. The others are content assets. The **policy generator** should be
approached most carefully, not for AI-safety reasons but because a generated
policy document can create a false sense of compliance; it needs framing as a
starting template reviewed by a professional, and it should be Phase 4.

## 3. Answers to the seven questions

**1. Is HTML/PHP the right step 1?**
Yes, without qualification. This is a brochure-plus-form. There are no accounts,
no persistent user state, no scheduled work. Static HTML with one PHP endpoint
ships in a week, costs nothing to run, has essentially no attack surface — which
matters unusually much here — and will still be the right architecture in two
years. Full reasoning in `STACK_DECISION.md`.

**2. What should the first lead-gen version include?**
Nine pages, one form, one WhatsApp integration, and a hardened server config.
Precisely: home, 4 service pages, 3 vertical pages, contact, plus privacy and
terms. Not a blog yet, not tools yet. See `IMPLEMENTATION_PHASES.md` Phase 1.

**3. What animated/design direction builds trust without feeling gimmicky?**
Direction B (Bento Profesional) from the `conversion-design` skill, executed
with restraint: deep navy, white, one teal accent reserved for the CTA, Space
Grotesk headings, Inter body. Motion limited to one fade-up reveal and hover
states. Zero "cyber" visual clichés. The trust comes from a real photograph of
a real person, a redacted real deliverable, a written methodology with
timeframes, and verifiable technical hardening — not from motion.
Full spec in `PRODUCT_SPEC.md` §4.

**4. What can be built despite AI safety restrictions?**
Effectively everything worth building. The restrictions bind on offensive
tooling — exploit code, credential harvesting, scanners pointed at systems the
user does not own, evasion techniques. None of that belongs on a lead-gen site
for a legitimate services business anyway; it would create Paraguayan criminal
exposure under Ley 4439/2011 and would make you uninsurable. The productive
line is: **tools that assess what the user declares about their own
organisation are unrestricted; tools that reach out and touch a host are not,
until you have verified ownership.** `SAFE_SECURITY_TOOL_IDEAS.md` works this
through with specifics.

**5. What future functions would justify Node.js?**
Saved, re-runnable assessments behind a login, with generated PDF reports and
scheduled re-checks — i.e. the moment the self-assessment stops being a
calculator and becomes a product. Also a verified-ownership external posture
scanner, which needs a job queue. Neither is Phase 1 or 2 work.
`FUTURE_NODE_FEATURES.md` sets the specific triggers.

**6. What SEO structure fits Paraguay?**
Trigger-first money pages, vertical pages as the supporting layer, a resources
hub carrying the tools, and an operational blog. No city pages — this is a
national B2B service and ten thin city pages would be doorway pages. Spanish
with voseo, `es-PY`. Full architecture in `SEO_ARCHITECTURE.md`.

**7. How should leads be captured and sent to VenderCRM later?**
Not later — from launch. One PHP handler: validate, honeypot, write locally,
push to VenderCRM with an idempotency key, notify by email, redirect to a
thank-you page. Never block the visitor on the CRM. Spec in `PHP_FORM_SPEC.md`,
protocol in `planning/_shared/VENDERCRM_INTEGRATION.md`.

## 4. Positioning

**Who this is for:** Paraguayan companies of roughly 15–250 employees that hold
data someone else cares about — patient records, client financials, cardholder
data, member accounts — and that have IT support but no security function.

**What it says:** Concrete, verifiable, unglamorous competence. The tone is a
senior practitioner explaining something clearly, not a vendor selling fear.

**Positioning line (working):**
> Seguridad informática para empresas paraguayas que ya no pueden improvisar.

**What is deliberately not said:** no fear-based headlines, no threat counters,
no "el 60% de las PYMES que sufren un ataque cierran en 6 meses" — that
statistic is folklore and repeating it is exactly the credibility leak this
positioning is built to avoid. If a statistic appears on the site it carries a
link to a named primary source, or it does not appear.

## 5. Success metrics

Phase 1 is not measured on traffic. It is measured on whether the site closes
what other channels open.

| Horizon | Metric | Target |
|---|---|---|
| Launch + 2 weeks | securityheaders.com / SSL Labs | A / A+ |
| Launch + 2 weeks | CWV on all pages, mobile | LCP <2.5s, CLS <0.1 |
| Month 1 | Referred prospects who mention the site unprompted | any — this is the real signal |
| Month 3 | Qualified conversations from all channels | 8–12 |
| Month 3 | Indexed pages in GSC | 15+ |
| Month 6 | Organic sessions/month | 300–800 (not more — the market is small) |
| Month 6 | Inbound qualified leads/month | 3–6 |
| Month 6 | Self-assessment completions/month | 25+ |

If month-6 organic is 3,000 sessions, check what they are: it will be students
and job seekers, and it is not a success.

## 6. Principal risks

| Risk | Assessment | Mitigation |
|---|---|---|
| Market too small for SEO to pay back | Likely true for generic terms | Treat SEO as secondary; the site's job is closing referrals. Build the trigger pages, skip the volume chase. |
| Site is a security embarrassment | Fatal if it happens | Hardening is a Phase 1 gate, not a nice-to-have. `IMPLEMENTATION_PHASES.md` blocks launch on it. |
| Cannot deliver what the site promises | Business-ending | Only publish services you can actually staff. Better three real services than eight aspirational ones. |
| Incident-response leads arrive when unavailable | Reputational | Only publish a response-time commitment you will meet at 2am, or publish none. Do not publish "24/7" aspirationally. |
| Free tools attract tyre-kickers, not buyers | Probable | Tools qualify rather than just capture: the assessment asks employee count and sector, so low-value completions are visibly low-value and cost nothing. |
| Vertical pages read as templated | Real, and it kills them | Each vertical page needs genuinely different content — different threat, different regulation, different deliverable. If you cannot write 400 genuinely distinct words, do not build the page. |
| Founder-dependent credibility | Structural | Accept it. Lean in: name and photograph the practitioner. In this market a named person outperforms a fictional agency identity. |

## 7. What this project explicitly does not do

Recorded so it does not get relitigated:

- No offensive tooling of any kind, published or internal-facing.
- No scanning, probing, or fingerprinting of any host the visitor has not
  proven they own.
- No "free vulnerability scan, enter any URL" lead magnet. It is the most
  obvious idea in this category and it is unlawful in shape, legally exposed
  under Ley 4439/2011, and would poison the brand.
- No breach-data lookup ("check if your email was leaked") built in-house.
- No fear-based marketing, no fabricated statistics, no invented client logos.
- No guarantee of security outcomes. Ever, in any copy.
- No city pages. No colegios page in Phase 1–3.
