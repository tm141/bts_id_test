FROM php:8.4-cli-alpine

RUN apk add --no-cache postgresql-dev unzip git \
    && docker-php-ext-install pdo_pgsql

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8000"]