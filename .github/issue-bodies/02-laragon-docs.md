## Summary

Many users mix **Laragon (port 80)** with **Docker (port 8080)** and copy `.env.docker` while browsing without `:8080`, causing confusing errors.

## Tasks

- [ ] Add `docs/laragon.md` (or expand `docs/docker.md`) with a clear comparison table
- [ ] When to use `.env.example` vs `.env.docker`
- [ ] Hosts file entries for both setups
- [ ] Common errors: tenant 404, `DB_HOST=mysql` on Laragon, missing `:8080`
- [ ] Link from README Quick start section

## Acceptance

- New developer can choose Laragon OR Docker without mixing configs
- No code changes required unless a small README link

See [ROADMAP](docs/ROADMAP.md) — v1.4 prep / DX.
