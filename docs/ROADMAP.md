# Development roadmap

Planned releases from the current stable tag through **v1.4.0**. Dates are not committed until scoped.

## Overview

| Version | Theme | Repo | Status |
|---------|--------|------|--------|
| **v1.2.3** | CI / smoke-test hardening | tenant-kit | ✅ Released |
| **v1.3.0** | Usage-based billing | tenant-kit | 🟡 Ready locally — pending tag |
| **v1.3.1** | [api-operator](https://github.com/mohammedelkarsh/api-operator) (PyPI) integration | tenant-kit + [api-operator](https://github.com/mohammedelkarsh/api-operator) | 📋 Planned |
| **v1.4.0** | Optional KYC module | tenant-kit + [kyc-ai/laravel](https://packagist.org/packages/kyc-ai/laravel) | 📋 Planned |

**Semver:** patch (1.2.x) = fixes · minor (1.3.x, 1.4.0) = new features · major (2.0) = breaking changes (not planned yet).

---

## v1.3.0 — Usage-based billing

**Goal:** Track workspace usage locally; optional sync to Stripe Billing Meters.

| Item | Notes |
|------|--------|
| Local meters | `api_calls` (middleware), `team_seats` (gauge snapshot) |
| Database | `usage_records` table (per tenant, meter, calendar month) |
| API | `GET /api/workspaces/{id}/usage`; subscription payload includes usage |
| Billing UI | Usage section on `/billing/{tenant}` when `USAGE_BILLING_ENABLED=true` |
| Stripe sync | Optional via `USAGE_SYNC_TO_STRIPE` + Cashier `reportMeterEvent()` |
| Config | `config/usage.php`, `.env.example` vars |
| Tests | `UsageBillingTest`, system-test + page-audit coverage |
| Adapter stub | `get_usage` tool in `integrations/api-operator/adapter.yaml` |

**Release checklist:** CHANGELOG, README roadmap `[x]`, tag `v1.3.0`, CI green on Docker path.

---

## v1.3.1 — api-operator integration (PyPI)

**Goal:** First-class docs and adapter for [api-operator](https://github.com/mohammedelkarsh/api-operator) — install via [PyPI](https://pypi.org/project/api-operator/), operate Tenant Kit APIs without clicking Filament.

The agent lives in a **separate repo**: [api-operator](https://github.com/mohammedelkarsh/api-operator) (`pip install api-operator`). Tenant Kit stays PHP-only; no Python in `require`.

### api-operator (PyPI package)

| Item | Notes |
|------|--------|
| PyPI publish | `pip install api-operator` (core); `pip install api-operator[llm]` for OpenAI planner |
| Stable tag | Promote from current `v0.9.0` beta → `v1.0.0` on PyPI when API is frozen |
| Tenant Kit example | Keep `examples/tenant-kit-adapter/` in sync with tenant-kit adapter |
| Integration script | `scripts/integration_tenant_kit.py` — CI optional marker |

### tenant-kit (integration layer)

| Item | Notes |
|------|--------|
| `adapter.yaml` | Full tool set synced with `integrations/api-operator/` (workspaces, subscription, usage, team invite) |
| Docs | `docs/api-operator.md` — tokens, CLI, `api-operator serve`, Docker notes |
| README | Quick start: `pip install api-operator` + link to adapter |
| Smoke | Document or optional CI step running integration script against Docker stack |

**Out of scope for v1.3.1:** embedding Python in Laravel, Filament chat widget, or billing meter for LLM tokens (see after v1.4).

---

## v1.4.0 — Optional KYC module

**Goal:** Integrate [kyc-ai/laravel](https://packagist.org/packages/kyc-ai/laravel) without forcing it on every installation. Deferred from v1.3 so billing + agent ship first.

| Item | Notes |
|------|--------|
| Opt-in dependency | Document `composer require kyc-ai/laravel`; not in default `require` |
| Per-tenant config | Extraction driver, country, verification level inside `$tenant->run()` |
| Migrations | Publish `kyc_verifications` to tenant migration path (Stancl) |
| Filament | Register `KycFilamentPlugin` on workspace panel for manual review |
| Queue | Tenant-aware dispatch for `ProcessKycDocument` |
| Onboarding | Example workspace flow: upload ID → internal verify → audit |
| Reference | [tenant-kit integration guide](../../laravel-kyc-ai/docs/tenant-kit.md) |

**Prerequisite:** stable external verification drivers (see kyc-ai roadmap) before promoting `KycLevel::Full` in docs.

### v1.4.0 — stretch (if time)

| Item | Notes |
|------|--------|
| KYC webhooks | Notify workspace when verification status changes |
| Plan gating | KYC enabled per subscription tier / feature flag |
| Copy | Pre-built Arabic/English onboarding strings |

---

## After v1.4 — under consideration

- Usage meter: **AI / agent calls** (link api-operator events to `usage_records` or Stripe meter)
- Additional meters: storage, outbound email, webhook deliveries
- api-operator: RAG over tenant-kit docs; confirm-before-write UX in Filament
- PostgreSQL-first Docker profile as default in docs
- Marketing / Dev.to articles per minor release (separate `laravel-tenant-kit-marketing` repo)

---

## Related repositories

| Repo | Role |
|------|------|
| [laravel-tenant-kit](https://github.com/mohammedelkarsh/laravel-tenant-kit) | This starter — PHP, Docker, API |
| [api-operator](https://github.com/mohammedelkarsh/api-operator) | Python AI operator — PyPI, YAML adapters |
| [laravel-kyc-ai](https://github.com/mohammedelkarsh/laravel-kyc-ai) | Optional KYC package for v1.4 |
| laravel-tenant-kit-marketing | Articles, tweets — **not** in main repo |

---

## How we ship

1. **Feature branch or main** — implement + Docker tests (`php artisan test`, `system-test.php`, `page-audit.php`).
2. **CHANGELOG + this file** — update status column when tagged.
3. **README roadmap** — check off completed minors.
4. **Git tag + GitHub release** — one story per minor (Dev.to optional, from marketing repo).
