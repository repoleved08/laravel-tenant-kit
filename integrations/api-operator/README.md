# api-operator integration

Connect [api-operator](https://github.com/mohammedelkarsh/api-operator) to this app via **YAML adapter** — no Python in this repo.

Install from PyPI: [pypi.org/project/api-operator](https://pypi.org/project/api-operator/)

## Prerequisites

1. Tenant Kit running (match `APP_URL` in `.env`)
2. `php artisan migrate --seed`
3. api-operator installed: `pip install api-operator` (or clone the [GitHub repo](https://github.com/mohammedelkarsh/api-operator))

## Quick test

```bash
git clone https://github.com/mohammedelkarsh/api-operator.git
cd api-operator
python scripts/integration_tenant_kit.py
```

Interactive chat from this repo:

```bash
api-operator chat \
  --adapter yaml \
  --config integrations/api-operator/adapter.yaml \
  --base-url http://laravel-tenant-kit.test \
  --token "YOUR_SANCTUM_TOKEN"
```

## Files

| File | Purpose |
|------|---------|
| `adapter.yaml` | HTTP tools for Sanctum API |
| `README.md` | This guide |

Keep in sync with `api-operator/examples/tenant-kit-adapter/` when upgrading.

## Local dev credentials

See the main [README](../../README.md) for seeded admin and demo workspace accounts.
