# Portfolio stack allocation — how the Node.js slot gets spent

The five properties were briefed separately, but they compete for the same
scarce resources: your attention, one Hostinger Node.js slot, and the operating
overhead of anything with a database and a login screen. This document decides
the allocation once so the individual `STACK_DECISION.md` files can just
reference it.

---

## The actual scarce resource is not hosting

A Node.js slot costs a few dollars. What costs real money is **the operational
tail** of a stateful app: a database to back up, dependencies to patch, an
admin login to secure, a deploy pipeline that can break at 11pm, and a build
that fails six months later because a transitive dependency dropped a Node
version. A static HTML + PHP site has almost no tail. It sits there and works.

So the question for each property is not "would Node be nicer?" — it usually
would. It is: **does this property have a function that cannot exist without
persistent server state, and is that function worth an operational tail?**

Three things genuinely require it:

1. **User accounts** — anything a visitor logs back into.
2. **Generated artefacts that must persist** — saved assessments, PDF reports,
   itineraries with a shareable URL.
3. **Scheduled server work** — price alerts, re-checks, digest emails.

A blog with an admin panel does *not* require Node. Neither does lead scoring,
a multi-step wizard, a calculator, or a CRM push. Those are all PHP-sized
problems, and treating them as Node problems is the single most common way
these projects get expensive without getting better.

---

## The allocation

| Property | Stack | Node slot | Reasoning |
|---|---|---|---|
| **viaje.com.py** | Next.js + MySQL + Drizzle | **Yes** | The only property with all three triggers: saved/shareable itineraries, streaming AI responses, and scheduled price-alert jobs. Also the only one where programmatic SEO across hundreds of destination × season pages pays for a framework. |
| **prestamo.com.py** | PHP 8.2 + MySQL | No | Forms, a scoring function, an admin table, a CRM push. Every one of these is a solved PHP problem. Node buys nothing until real-time partner routing exists, which requires partners that do not exist yet. |
| **visas.com.py** | PHP 8.2 + MySQL | No | The eligibility wizard is a client-side decision tree with a PHP submit. Scoring is thirty lines. Admin is CRUD. There is no persistent user artefact and no scheduled work. |
| **ciberseguridad.com.py** | Static HTML + one PHP endpoint | No | Pure lead-gen. No accounts, no state. Revisit only if the security self-assessment grows into saved, re-runnable, PDF-reported assessments — see its `FUTURE_NODE_FEATURES.md`. |
| **criptomonedas.com.py** | Static HTML + one PHP endpoint | No | Content and client-side calculators. A database would hold nothing but blog posts, and blog posts are better as files in git for this volume. |

**Net: one Node property, four PHP properties.** That is the right shape. Four
low-maintenance sites you can leave alone for a quarter, and one real
application that gets your attention.

---

## Why viaje wins the slot over prestamo

`prestamo.com.py` looks like the more "serious" application — money, scoring,
pipelines. But look at what its Node version would actually do differently from
its PHP version: nothing a user would notice. The scoring runs in 2ms either
way. The admin table renders either way. Node would buy a nicer developer
experience for a system that gets touched twice a year.

`viaje.com.py` is different in kind. Token-by-token streaming of a generated
itinerary is a materially better experience than a 20-second blank page, and it
is genuinely awkward in PHP on shared hosting. Itineraries need a persistent
shareable URL, which means real storage and a real object model. And its SEO
strategy depends on generating and incrementally revalidating hundreds of
destination × season pages, which is what Next.js ISR exists for.

That is the test: **does the framework change what the user gets, or only what
the developer gets?** Only on viaje does it change what the user gets.

---

## Build order

Sequenced by expected return per week of effort, not by how interesting they
are.

1. **ciberseguridad.com.py** — smallest build in the set (about a week), and it
   supports a service you can sell at a high price immediately. Ship it first
   to get a fast win and a live template for the other PHP builds.
2. **viaje.com.py** — largest build and the only one with genuine compounding
   value through content and email. Start it early because it takes longest to
   mature; SEO on a new .com.py takes months regardless of build quality.
3. **visas.com.py** — reuses the ciberseguridad PHP skeleton almost verbatim,
   plus a wizard. Roughly a week once the skeleton exists.
4. **prestamo.com.py** — gated on a commercial precondition, not a technical
   one. Do not build the lead machine before you have someone to sell leads to.
   See its `PLAN.md` §Phase 0.
5. **criptomonedas.com.py** — lowest expected return per hour and the highest
   ratio of traffic to revenue. Build it when the other four are running, or
   not at all.

## The shared PHP skeleton

Properties 1, 3, 4 and 5 should share one skeleton, extracted from
ciberseguridad after it ships and kept in its own small repo or copied
deliberately:

```
public/                 index.php, page templates, assets
src/
  form-handler.php      validate → honeypot → local store → VenderCRM push
  vendercrm.php         the API client (see VENDERCRM_INTEGRATION.md)
  render.php            layout, meta, JSON-LD helpers
  config.php            reads env, never contains secrets
storage/                git-ignored: leads.csv, logs
```

Write it once, carefully, on ciberseguridad. Every hour spent on that skeleton
is repaid three times. Copy it explicitly rather than making it a shared
dependency — four sites coupled to one library is a worse failure mode than
four copies that drift slightly.
