#!/bin/sh
set -e

cd /var/www/html

if [ ! -f .env ]; then
    cp .env.example .env
fi

php artisan key:generate --force

php artisan config:cache
php artisan route:cache
php artisan view:cache

php artisan migrate --force

php artisan db:seed --force

mkdir -p /var/log/supervisor

exec /usr/bin/supervisord -c /etc/supervisor/conf.d/supervisord.conf
