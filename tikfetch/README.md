# TikFetch — Laravel source overlay (development scaffold)

**Status: incomplete, not production-ready.** This package contains application-specific Laravel source files, not a bootable Laravel distribution. Composer and Internet access were unavailable in the build environment, so no Laravel dependencies were installed and no framework tests/migrations could be executed. Do not deploy as-is.

## Implemented source
- Bootstrap 5/Blade responsive homepage, FAQ, gallery, checkboxes, selection count and local search.
- Strict public TikTok URL parser; demo provider returns visibly labeled sample records only.
- Provider interface, DTO, cache wrapper, demo provider, service bindings, sample provider health.
- Login, registration, logout controllers; user and admin views; schema migrations; quota attempt checks and history logging.
- Fail-closed download controller: **no real downloads**. No false success status.
- Basic parser and demo-provider PHPUnit tests (not run).

## Not implemented / integration required
- A documented, contractually authorized live provider adapter and real download streaming.
- Complete Laravel application skeleton, email verification delivery, password resets, user settings/deletion, full admin settings and audit trails, pagination aggregation, real provider health UI, production policies and contact addresses.
- Full test suite, CI, verified migrations, real MySQL, queue jobs, complete SSRF-safe network transport and production hardening.

## Installation on a PHP 8.3+ host with Composer and MySQL
1. `composer create-project laravel/laravel tikfetch-base "^12.0"`
2. Copy this overlay's `app/`, `config/tikfetch.php`, `database/migrations/`, `resources/views/`, `routes/web.php`, `public/css/`, `public/js/`, `tests/Feature/`, and `docs/` into `tikfetch-base/`. **Merge** `app/Providers` rather than deleting Laravel defaults.
3. Add `App\Providers\TikFetchServiceProvider::class` to `bootstrap/providers.php`.
4. Copy overlay `.env.example` values into the base application's `.env` while retaining the Laravel-generated keys and mail/session configuration. Configure MySQL credentials. Set `APP_DEBUG=false` for production.
5. `php artisan key:generate && php artisan migrate` (base Laravel provides users/cache/jobs/session migrations).
6. `php artisan test` and `php artisan serve`.
7. To use Bootstrap without external CDN access, vendor Bootstrap locally and replace the stylesheet link. This source currently uses the Bootstrap CDN.

## Security and provider limitations
Read `docs/PROVIDER.md` and `docs/SECURITY.md`. No credentials are included. Do not set `TIKTOK_PROVIDER` to a live value without implementing and auditing an adapter. The download controller intentionally refuses real transfers, even if an adapter returns a URL. The current DNS validation helper is only a preliminary check and must not be used as a complete SSRF defense for outbound HTTP. User-supplied TikTok URLs are parsed, never fetched directly. External image URLs require an approved provider and CSP policy.

## Production deployment target
Linux VPS + Nginx + PHP-FPM + MySQL + TLS. Point Nginx root to Laravel `public/`, deny dotfiles, use secure cookies and server-side secrets, run `php artisan config:cache`, `php artisan route:cache`, migrations with rollback plans, queue workers under systemd, monitoring, backups, and a proper production build. Conduct a security and legal review first.
