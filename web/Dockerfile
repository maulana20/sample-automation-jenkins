FROM dunglas/frankenphp:php8.3

COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer

RUN apt-get update && \
    apt-get install -y unzip curl git libzip-dev zip && \
    docker-php-ext-install mysqli pdo pdo_mysql zip && \
    apt-get clean && \
    rm -rf /var/lib/apt/lists/*

RUN cp "$PHP_INI_DIR/php.ini-development" "$PHP_INI_DIR/php.ini" && \
    sed -i -e 's/^expose_php = On$/expose_php = Off/g' "$PHP_INI_DIR/php.ini" && \
    sed -i -e 's/^memory_limit =.*$/memory_limit = 1024M/g' "$PHP_INI_DIR/php.ini"

COPY . .

WORKDIR /app

CMD sh ./nginx/startup.sh

EXPOSE 80 443