# Development roadmap

Planned releases from the current stable tag through **v1.4.0**. Dates are not committed until scoped.

## Overview

| Version | Theme | Repo | Status |
|---------|--------|------|--------|
| **v1.2.3** | CI / smoke-test hardening | tenant-kit | ✅ Released |
| **v1.3.0** | Usage-based billing | tenant-kit | ✅ Released |
| **v1.3.1** | [api-operator](https://github.com/mohammedelkarsh/api-operator) (PyPI) + in-app guided agent | tenant-kit + [api-operator](https://github.com/mohammedelkarsh/api-operator) | ✅ Ready for tag `v1.3.1` |
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

**Release checklist:** CHANGELOG, README roadmap `[x]`, tag `v1.3.0`, CI green on Docker path. ✅

---

## v1.3.1 — api-operator + guided agent ✅

**Goal:** Operate Tenant Kit via [api-operator](https://github.com/mohammedelkarsh/api-operator) (CLI + HTTP) and an in-app guided chat on the central domain.

| Item | Status |
|------|--------|
| `docs/api-operator.md` | ✅ |
| `integrations/api-operator/` README + adapter | ✅ |
| In-app chat widget + guided flows | ✅ |
| Laravel proxy (`/api-operator/chat`) | ✅ |
| Docker `operator` profile + setup scripts | ✅ |
| README + screenshots + demo GIF | ✅ |
| `ApiOperatorChatTest` + adapter tests | ✅ |
| Sync with api-operator `examples/tenant-kit-adapter/` | ✅ |
| Integration test documented | ✅ |

**Release checklist:** tag `v1.3.1`, GitHub release, optional run `integration_tenant_kit.py` against Docker.

The Python package lives in a **separate repo**: [api-operator](https://github.com/mohammedelkarsh/api-operator) (`pip install api-operator`). Tenant Kit stays PHP-only; the operator runs as a sidecar.

**Parallel track (api-operator repo):** PyPI `v0.10.0` (Docker `connect_host`, formatters); promote to `v1.0.0` when the agent HTTP API is frozen.

**Still out of scope for v1.3.1:** embedding Python in PHP, AI usage meters on `usage_records` (see after v1.4).

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
