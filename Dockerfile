FROM php:8.3-apache

ENV APACHE_DOCUMENT_ROOT=/var/www/html/public
ENV COMPOSER_ALLOW_SUPERUSER=1

RUN apt-get update && apt-get install -y --no-install-recommends \
    git unzip libicu-dev libzip-dev libxml2-dev libsqlite3-dev \
    && docker-php-ext-install mbstring intl pdo_sqlite bcmath zip \
    && a2enmod rewrite headers \
    && rm -rf /var/lib/apt/lists/*

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Create a real Laravel application inside the image.
WORKDIR /var/www/html
RUN composer create-project --no-interaction laravel/laravel:^11.0 /var/www/html

# Copy this repository's TikFetch starter files into the Laravel skeleton.
COPY . /tmp/tikfetch-source/

RUN set -eux; \
    cp /tmp/tikfetch-source/routes/web.php routes/web.php; \
    mkdir -p app/Contracts app/Services app/Http/Controllers public/css resources/views; \
    cp /tmp/tikfetch-source/app/Contracts/TikTokVideoProviderInterface.php app/Contracts/; \
    cp /tmp/tikfetch-source/app/Services/*.php app/Services/; \
    cp /tmp/tikfetch-source/app/Http/Controllers/ProfileLookupController.php app/Http/Controllers/; \
    cp /tmp/tikfetch-source/app/Providers/AppServiceProvider.php app/Providers/AppServiceProvider.php; \
    cp /tmp/tikfetch-source/resources/views/home.blade.php resources/views/home.blade.php; \
    cp /tmp/tikfetch-source/public/css/tikfetch.css public/css/tikfetch.css; \
    cp /tmp/tikfetch-source/database/migrations/2026_10_28_000001_create_video_lookup_logs_table.php database/migrations/; \
    sed -i 's#DocumentRoot /var/www/html#DocumentRoot /var/www/html/public#' /etc/apache2/sites-available/000-default.conf; \
    sed -i 's#<Directory /var/www/>#<Directory /var/www/html/public>#' /etc/apache2/apache2.conf; \
    chown -R www-data:www-data storage bootstrap/cache database; \
    chmod -R ug+rwx storage bootstrap/cache database

COPY docker/start.sh /usr/local/bin/tikfetch-start
RUN chmod +x /usr/local/bin/tikfetch-start

EXPOSE 80
CMD ["/usr/local/bin/tikfetch-start"]
