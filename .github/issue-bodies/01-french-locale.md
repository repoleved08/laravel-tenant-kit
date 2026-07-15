## Summary

Add **French** as a third locale. English and Arabic already ship in `lang/en` and `lang/ar`.

## Tasks

- [ ] Copy `lang/en/app.php` → `lang/fr/app.php` and translate all strings (including `api_operator` guided agent menus/flows)
- [ ] Register `fr` in `config/locales.php` with label + direction `ltr`
- [ ] Document in README under "Add a new language" (French included)
- [ ] Optional: PHPUnit assertion that `Locales::available()` includes `fr`

## Out of scope

- Filament vendor translations
- Machine translation only — human-readable French please

## How to test

1. Set `APP_AVAILABLE_LOCALES=en,ar,fr` in `.env`
2. Switch locale on landing/login → French strings appear
3. Open guided agent on `/dashboard` → French menu labels

## Acceptance

PR passes CI (`php artisan test`).

See [ROADMAP](docs/ROADMAP.md) — contributor-friendly, tenant-kit only.
