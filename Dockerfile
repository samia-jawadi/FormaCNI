# ---- builder: install composer deps ----
FROM composer:2.7 AS vendor
WORKDIR /app
COPY composer.json composer.lock /app/
RUN composer install --no-dev --optimize-autoloader --prefer-dist --no-interaction --no-progress

# ---- runtime: PHP + extensions ----
FROM php:8.2-fpm

# system deps
RUN apt-get update && apt-get install -y \
    git curl zip unzip libpq-dev libonig-dev libxml2-dev libzip-dev \
 && rm -rf /var/lib/apt/lists/*

# PHP extensions
RUN docker-php-ext-install pdo pdo_mysql pdo_pgsql mbstring exif pcntl bcmath zip sockets \
 && docker-php-ext-enable sockets

# copy composer deps
COPY --from=vendor /app/vendor /var/www/vendor
COPY --from=vendor /app/composer.lock /var/www/composer.lock
COPY --from=vendor /app/composer.json /var/www/composer.json

# copy app
WORKDIR /var/www
COPY . /var/www

# permissions
RUN mkdir -p storage/framework storage/logs bootstrap/cache \
 && chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache \
 && chmod -R 775 /var/www/storage /var/www/bootstrap/cache

EXPOSE 8080

# Start Laravel
CMD ["sh", "-c", "php artisan migrate --force || true; php artisan config:cache; php artisan serve --host 0.0.0.0 --port ${PORT:-8080}"]
