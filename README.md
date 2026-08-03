# ciberseguridad.com.py — planning repository

This repo holds the **planning and specification documents** for
`ciberseguridad.com.py`, a cybersecurity services lead-generation site for the
Paraguayan market. No application code has been written yet, by design: these
documents exist so that an implementation model (Sonnet 5 / Codex) can build
the site without re-deriving strategy.

## Layout

```
PLAN.md                      Strategy, critique of the brief, decisions taken
STACK_DECISION.md            Static HTML + PHP, and why not Node or WordPress
PRODUCT_SPEC.md              Site map, page specs, design system, copy rules
SAFE_SECURITY_TOOL_IDEAS.md  What tooling can be built, what cannot, and the line
SEO_ARCHITECTURE.md          Structure, targeting, schema, content plan
SERVICE_PAGE_PLAN.md         Build sheet for the money pages
LEAD_FUNNEL.md               How a stranger becomes a conversation
PHP_FORM_SPEC.md             The form and its handler, in full
FUTURE_NODE_FEATURES.md      What would justify Node, and the triggers
IMPLEMENTATION_PHASES.md     What ships when, and the launch gates
CLAUDE_TASKS.md              The ordered work queue for an implementer

docs/CONVENTIONS.md          Language, anti-fabrication, technical baseline
docs/VENDERCRM_INTEGRATION.md  Lead capture protocol and its six rules
```

## Reading order for an implementer

1. `docs/CONVENTIONS.md` — the rules that apply to everything
2. `PLAN.md` — strategy and the decisions taken, especially §1
3. `STACK_DECISION.md` — what to build it in and why
4. `IMPLEMENTATION_PHASES.md` — what ships when
5. `CLAUDE_TASKS.md` — the actual ordered work queue

Everything else is reference material consumed by those tasks.

## The four decisions worth knowing up front

**Static HTML with one PHP endpoint.** No framework, no database, no build
step. This is a brochure plus a form; it ships in a week and will still be the
right architecture in two years. Attack surface is a first-order concern on
this site specifically, and that argues against a dependency tree.

**Money pages are organised by buying trigger, not service category.** Got hit,
got asked, got scared, got audited. A prospect self-identifies in three
seconds, and the pages can be written because you know who is reading.

**The site's own security posture is the primary trust signal.** A+ on SSL
Labs, A on securityheaders.com, HSTS preload, strict CSP, DNSSEC, DMARC at
`p=reject`, and a published `security.txt` — then link the live third-party
scans so a visitor can verify it in one click. It costs a day and no competitor
in this market can copy it without doing the work. It is launch-blocking.

**Tools operate on declared input only.** Nothing this site publishes ever
touches a host the visitor has not proven they own. That rule excludes the
obvious "free scan, enter any URL" lead magnet, which would be unauthorised
access performed by your infrastructure under Ley 4439/2011. See
`SAFE_SECURITY_TOOL_IDEAS.md` §1.

## Honest expectation setting

Read `PLAN.md` §1 before anything else. Search volume for commercial
cybersecurity terms in Paraguay is thin, and most of it is students and job
seekers. This site's primary job is closing referrals and outbound, not
originating demand. That is why it is a one-week build rather than a six-week
one — the time saved belongs in the channels that actually fill the funnel.
