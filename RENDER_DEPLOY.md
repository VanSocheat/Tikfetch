# TikFetch: Render deployment files

These files let Render build a Laravel 11 application from the existing TikFetch starter files.

## Add these files to the GitHub repository

Upload the `Dockerfile` to the repository root and upload the `docker` folder with `start.sh` inside it. Keep the existing TikFetch starter files and folders in place.

On GitHub:
1. Open the `tikfetch` repository.
2. Choose **Add file → Upload files**.
3. Upload `Dockerfile` and the `docker` folder.
4. Commit with a message such as `Add Render Docker deployment`.

The repository root should include at least:
- `Dockerfile`
- `docker/start.sh`
- `routes/web.php`
- `app/Contracts/`
- `app/Services/`
- `app/Http/Controllers/`
- `app/Providers/AppServiceProvider.php`
- `resources/views/home.blade.php`
- `public/css/tikfetch.css`
- `database/migrations/`

## Create the Render service

1. Open https://dashboard.render.com/
2. Select **New → Web Service**.
3. Connect GitHub and select the `tikfetch` repository.
4. Set **Runtime** to **Docker** (or allow Render to detect the Dockerfile).
5. Set the branch to `main` if that is your repository's default branch.
6. Create the service.

## Environment variables

In the Render service's **Environment** tab, add:

- `APP_ENV` = `production`
- `APP_DEBUG` = `false`
- `APP_KEY` = a Laravel application key generated locally or with a trusted Laravel environment
- `LOG_CHANNEL` = `stderr`
- `DB_CONNECTION` = `sqlite`

Do not commit `.env` or secret keys to GitHub.

If you do not have an APP_KEY, you can generate one in a local Laravel project with `php artisan key:generate --show`. Copy the generated value into Render as `APP_KEY`. Keep it private.

## Important limitations

- This is a starter deployment, not a finished production service.
- The demo provider returns sample data and does not retrieve or download real TikTok videos.
- SQLite storage on a typical Render free web service is ephemeral; database changes can be lost when the instance is replaced or redeployed. Add a persistent database before relying on saved data.
- The startup script runs migrations but tolerates migration errors to keep the demo UI available. Review logs and fix any migration/database errors before production use.
- Do not use this deployment to bypass private-account restrictions, CAPTCHAs, or access controls.
