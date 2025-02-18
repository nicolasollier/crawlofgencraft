#!/bin/sh

while ! nc -z mysql 3306; do
  sleep 1
done

php artisan migrate --seed

php-fpm