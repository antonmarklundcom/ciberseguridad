# ciberseguridad.com.py — planning repository

This repo holds the **planning and specification documents** for
`ciberseguridad.com.py`. No application code has been written yet, by design:
these documents exist so that an implementation model (Sonnet 5 / Codex) can
build the site without re-deriving strategy.

## Layout

```
/                              ← ciberseguridad.com.py docs (this project)
  PLAN.md
  STACK_DECISION.md
  PRODUCT_SPEC.md
  SAFE_SECURITY_TOOL_IDEAS.md
  SEO_ARCHITECTURE.md
  SERVICE_PAGE_PLAN.md
  LEAD_FUNNEL.md
  PHP_FORM_SPEC.md
  FUTURE_NODE_FEATURES.md
  IMPLEMENTATION_PHASES.md
  CLAUDE_TASKS.md

planning/_shared/              ← conventions shared by all five domains
  CONVENTIONS.md
  VENDERCRM_INTEGRATION.md
  PORTFOLIO_STACK_ALLOCATION.md

planning/viaje.com.py/         ← travel product
planning/visas.com.py/         ← visa lead-gen
planning/criptomonedas.com.py/ ← crypto education
planning/prestamo.com.py/      ← loan lead-gen
```

## Why four other domains live in this repo

This session had GitHub access scoped to `antonmarklundcom/ciberseguridad`
only, and the planning request covered five domains. Rather than lose four
document sets, they were written here under `planning/`. Each folder is
self-contained: `git mv planning/viaje.com.py/* .` into a fresh repo and the
docs still work, with the exception of relative links into
`planning/_shared/`, which should be copied alongside.

## Reading order for an implementer

1. `planning/_shared/CONVENTIONS.md` — rules that apply to every build
2. The project's `PLAN.md` — strategy, critique, and the decisions taken
3. The project's `STACK_DECISION.md` — what to build it in and why
4. The project's `IMPLEMENTATION_PHASES.md` — what ships when
5. The project's `CLAUDE_TASKS.md` — the actual ordered work queue

Everything else is reference material consumed by those tasks.

## Status

| Domain | Recommended stack | Node slot? | Priority |
|---|---|---|---|
| ciberseguridad.com.py | Static HTML + PHP endpoint | No (Phase 4 maybe) | 2 |
| viaje.com.py | Next.js + MySQL (Drizzle) | **Yes — spend it here** | 1 |
| visas.com.py | PHP + MySQL | No | 3 |
| criptomonedas.com.py | Static HTML + PHP | No | 5 |
| prestamo.com.py | PHP + MySQL | No | 4 |

Rationale for the allocation is in
`planning/_shared/PORTFOLIO_STACK_ALLOCATION.md`.
