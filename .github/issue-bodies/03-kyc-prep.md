## Summary

Prepare tenant-kit for optional KYC in **v1.4.0** without requiring `kyc-ai/laravel` yet.

## Tasks (tenant-kit repo only)

- [ ] `config/kyc.php` with `enabled` default `false`
- [ ] `.env.example`: `KYC_ENABLED=false` + link to `docs/kyc.md`
- [ ] `docs/kyc.md` stub: opt-in path, link to [laravel-kyc-ai](https://github.com/mohammedelkarsh/laravel-kyc-ai)
- [ ] `App\Support\Kyc::enabled()` helper
- [ ] Test: when disabled, no KYC routes or panels registered

## Explicitly NOT in this issue

- No `composer require kyc-ai/laravel`
- No changes to laravel-kyc-ai repo
- No Filament plugin wiring (Phase B — maintainer)

## Why

Lets contributors help v1.4 without cross-repo confusion. Full integration follows in a separate issue/PR.

See [ROADMAP](docs/ROADMAP.md) — v1.4.0 Phase A.
