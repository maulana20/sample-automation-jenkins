#!/bin/sh

composer install
php artisan optimize:clear
php artisan migrate
chmod -R 777 storage

php-fpm -D && nginx -g "daemon off;"