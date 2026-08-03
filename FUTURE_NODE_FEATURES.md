# FUTURE_NODE_FEATURES.md — ciberseguridad.com.py

What would justify moving beyond static HTML + PHP, what would not, and the
specific conditions that should trigger the decision.

Current decision and its reasoning: `STACK_DECISION.md`.
Portfolio context: `planning/_shared/PORTFOLIO_STACK_ALLOCATION.md`.

---

## 1. The test

> A feature justifies Node when it requires **persistent server state tied to
> an identified user**, **generated artefacts that must outlive the request**,
> or **work that happens when nobody is on the site**.
>
> A feature does not justify Node because it would be more pleasant to write.

Applied to what this project might plausibly want:

| Candidate feature | Needs state? | Needs artefacts? | Needs scheduling? | Verdict |
|---|---|---|---|---|
| Self-assessment (calculator) | No | No | No | **Stays client-side.** Already built. |
| Incident checklist generator | No | No | No | **Stays client-side.** Print via CSS. |
| Phishing quiz | No | No | No | **Stays client-side.** |
| Backup verifier | No | No | No | **Stays client-side.** |
| Blog | No | No | No | **Stays static.** Markdown → HTML at edit time. |
| Lead capture | No | No | No | **Stays PHP.** One endpoint. |
| Newsletter sending | No | No | Yes, but | **Use an email provider.** Do not build. |
| Policy generator (download only) | No | Borderline | No | **Client-side + client-side PDF.** See §3. |
| **Saved, re-runnable assessments** | **Yes** | **Yes** | Maybe | **Justifies Node.** |
| **Client portal for deliverables** | **Yes** | **Yes** | No | **Justifies Node.** |
| **Verified-ownership posture check** | **Yes** | **Yes** | **Yes** | **Justifies Node.** |
| **Scheduled posture re-checks + alerts** | **Yes** | **Yes** | **Yes** | **Justifies Node.** |

Four features clear the bar. All four share one property: they turn a visitor
into a returning, identified user. That is the actual threshold, and everything
before it is a document with a calculator on it.

## 2. The four features that would justify it

### 2.1 Saved and re-runnable assessments

**The trigger feature.** The self-assessment is currently a calculator: answer,
see a score, leave. With an account it becomes a product:

- Results saved against a company profile
- Re-run in three months and see the delta per domain
- A generated PDF report with the company's name on it, suitable for showing a
  board or attaching to a supplier questionnaire response
- Multiple people in the same company completing it and the results compared —
  which surfaces the interesting finding that IT and management disagree about
  the state of the controls

That last item is a genuinely good product idea and it is impossible without
accounts. The PDF is what people actually want; a downloadable, dated,
branded document is the artefact that gets forwarded internally, and every
forward is a new prospect inside the same company.

**Requires:** auth, a database, PDF generation, email delivery.

**Build trigger:** ≥ 150 assessment completions per month sustained for three
months, **and** ≥ 5 unsolicited requests for a saved or downloadable version.
Do not build it on the theory that saving would increase completions — it would
not; requiring an account before a result would reduce them.

### 2.2 Client portal

Existing clients logging in to retrieve deliverables, see remediation progress,
and view retainer activity.

Honest assessment: **this is worth almost nothing until you have around fifteen
retainer clients.** Below that, email and a shared folder are better in every
dimension — cheaper, more familiar to the client, and impossible to have a
security incident in. A portal holding your clients' security reports is,
carefully considered, one of the highest-value targets you could construct.
If it is ever built, it needs the same rigour you would apply to a client's
system: MFA mandatory, full audit logging, encrypted at rest, tested restore,
and an external review before it holds a single real report.

**Build trigger:** ≥ 15 active retainer clients **and** a client asking for it.
Not before.

### 2.3 Verified-ownership external posture check

Fully specified in `SAFE_SECURITY_TOOL_IDEAS.md` §4. The short version: a check
of TLS configuration, security headers, DNS records and email authentication
policy, run only against a domain the user has proven they control via a
nonce-based DNS TXT or file challenge, from an authenticated account, with
explicit logged authorisation and per-account rate limiting.

This is the most valuable future feature. It is also the one with real
consequences if built carelessly, because the verification step is the entire
safety property — a version without it is precisely the tool
`SAFE_SECURITY_TOOL_IDEAS.md` §3 forbids.

**Requires:** auth, a job queue, an audit store, careful outbound network
egress controls, and abuse monitoring.

**Build trigger:** the saved-assessment product exists and is used, **and**
there is capacity to operate abuse monitoring. Not a standalone project.

### 2.4 Scheduled re-checks and alerts

Once 2.3 exists, running it weekly against verified domains and emailing on
change ("tu certificado vence en 14 días", "cambió tu registro DMARC") is a
small addition with a large retention effect. It is also a natural upsell into
the managed service.

Only meaningful as an extension of 2.3.

## 3. Things that look like they need Node and do not

**Blog with an admin panel.** At one post a month, an admin panel is a login
screen, a database, an editor, and an XSS surface, to save you from editing a
Markdown file. Write posts as Markdown in the repo. If a non-technical author
is ever needed, use a git-backed editor rather than building one.

**PDF generation for the free tools.** Client-side print styles produce a clean
PDF via the browser's own print dialogue, at zero cost and zero server risk.
Server-side PDF generation is only needed when the document must be *stored* —
which is feature 2.1, not the free tools.

**Analytics dashboard.** GA4 and Search Console already exist and are better
than anything worth building.

**"Personalised" content.** Serving different copy by inferred industry is a
complexity-to-return ratio that does not work at this traffic level, and the
trigger-router pattern on the home page achieves the same outcome with a static
grid of four links.

**Newsletter.** Use an email provider. Building sending infrastructure means
owning deliverability, bounce handling, unsubscribe compliance and IP
reputation — a full-time concern for a one-page monthly email.

## 4. If the triggers fire: the architecture

**Do not migrate the marketing site.** The correct end state is two systems,
each simple:

```
ciberseguridad.com.py          static HTML + PHP endpoint    unchanged
app.ciberseguridad.com.py      Node application              new
```

The marketing site keeps its zero-dependency, zero-build, minimal-surface
properties — which are themselves a selling point that gets published on the
site. The application carries the state, and its risk is contained to a
subdomain that holds no marketing traffic.

Proposed stack for the application, aligned with the existing Hostinger
tooling:

| Concern | Choice | Reason |
|---|---|---|
| Framework | Next.js (App Router) | Matches `nodejs-mysql-hostinger-stack`; existing deployment experience |
| Database | MySQL + Drizzle | Same |
| Auth | Email magic link, then TOTP MFA mandatory | Passwords are the wrong choice for a security product; MFA is non-negotiable given what is stored |
| PDF | Server-side render to PDF, queued | Artefacts must be reproducible and stored |
| Queue | Database-backed job table | A real broker is overkill at this volume |
| Hosting | Hostinger Node slot | See the deployment skill for the IPv6, PATH and Remote MySQL issues |

Data-protection constraints, given what this would hold:

- No client system details, credentials, network diagrams or findings in the
  assessment database — the assessment stores answers to declarative questions
  and scores, nothing more
- Encryption at rest, tested restores, and a documented retention policy
- Full audit log of every access to any stored assessment
- An external security review before it holds real client data. A security
  consultancy shipping an unreviewed authenticated application is the story
  that ends the business.

## 5. Decision review points

Do not revisit this continuously. Review at fixed points:

| When | Question |
|---|---|
| Month 6 after launch | Are assessment completions above 150/month? Has anyone asked to save one? |
| Month 12 | Are there 15+ retainer clients? Has a client asked for a portal? |
| Month 12 | Is the page count above 35? (→ adopt Eleventy, not Node) |
| Any time | Has a paying client committed to something that requires state? (→ build it, that is the only trigger that overrides the rest) |

Between reviews, the answer is no.
