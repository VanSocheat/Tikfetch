#!/bin/sh
set -eu

cd /var/www/html

# Render should provide APP_KEY as an environment variable.
# SQLite is used only as a lightweight demo database; its data is ephemeral
# on a typical Render free web service.
if [ "${DB_CONNECTION:-sqlite}" = "sqlite" ]; then
    touch database/database.sqlite
    chown www-data:www-data database/database.sqlite
    chmod 664 database/database.sqlite
fi

php artisan config:clear || true
php artisan migrate --force --no-interaction || true

exec apache2-foreground
