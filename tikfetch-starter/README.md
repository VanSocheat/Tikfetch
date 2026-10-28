# TikFetch — Laravel starter kit

This is a starter kit for a public TikTok profile video browser with individual download actions. It is **not** a claim that arbitrary TikTok videos can already be downloaded: real profile discovery and media downloads require a compatible, authorized provider.

## Requirements
- PHP 8.3+
- Composer
- Node.js/npm
- MySQL or SQLite
- A supported Laravel version (this kit targets Laravel 12)

## Install
1. Create a fresh Laravel application:
   ```bash
   composer create-project laravel/laravel tikfetch
   cd tikfetch
   ```
2. Copy the files in this kit into the matching paths in your Laravel project, overwriting `routes/web.php` and adding the new files.
3. Install frontend assets if needed:
   ```bash
   npm install
   npm run build
   ```
4. Configure `.env` and database:
   ```bash
   cp .env.example .env   # only if you do not already have .env
   php artisan key:generate
   php artisan migrate
   php artisan serve
   ```
5. Open `http://127.0.0.1:8000`.

The starter's demo provider returns clearly labeled sample videos. Its download action returns a clear “provider not configured” response; it never fabricates a successful MP4 download.

## Provider integration
Implement `App\\Contracts\\TikTokVideoProviderInterface` with a provider whose documented terms and access model support your use case. Configure it through `TIKTOK_PROVIDER` and the service container. Official TikTok Display API access is authorization-based and is not a universal downloader for any public username.

Before enabling real downloads:
- Verify the provider's permission and terms for public-profile discovery and media delivery.
- Restrict outbound requests to the provider's approved hostnames.
- Do not accept arbitrary download URLs from the browser.
- Add timeouts, rate limits, quota enforcement, copyright/takedown handling, and tests.
- Never bypass private-profile restrictions, CAPTCHAs, or access controls.

## Included
- Responsive homepage and video gallery
- Profile URL validation
- Provider interface and labeled demo provider
- Individual download endpoint placeholder
- Initial migration for lookup/download logs
- Clear provider-not-configured behavior

## Current limitations
- Authentication and admin dashboard are not included in this first milestone.
- The demo provider is not a real TikTok integration.
- Individual downloads only work after a compatible authorized provider is implemented and configured.
