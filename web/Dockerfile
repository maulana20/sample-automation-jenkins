FROM php:8.3-fpm

COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer

RUN apt-get update && \
    apt-get install -y unzip curl nginx git libzip-dev zip && \
    docker-php-ext-install mysqli pdo pdo_mysql zip && \
    apt-get clean && \
    rm -rf /var/lib/apt/lists/*

RUN cp "$PHP_INI_DIR/php.ini-development" "$PHP_INI_DIR/php.ini" && \
    sed -i -e 's/^expose_php = On$/expose_php = Off/g' "$PHP_INI_DIR/php.ini" && \
    sed -i -e 's/^memory_limit =.*$/memory_limit = 1024M/g' "$PHP_INI_DIR/php.ini"

COPY ./nginx/default.conf /etc/nginx/sites-available/default

WORKDIR /var/www/html

CMD composer install \
  && php artisan optimize:clear \
  && php artisan migrate \
  && chmod -R 777 storage \
  && php-fpm -D && nginx -g "daemon off;"

EXPOSE 80