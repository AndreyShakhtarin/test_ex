#!/bin/sh
set -ex

cd /var/www/html

if [ ! -f .env ]; then
    cp .env.example .env
fi


if [ -z "$APP_KEY" ]; then
    php artisan key:generate --force
fi

php artisan config:clear
php artisan route:clear
php artisan view:clear

echo "DATABASE_URL set: $([ -n "$DATABASE_URL" ] && echo yes || echo NO)"
echo "DB_CONNECTION: $DB_CONNECTION"

# Wait for database to be ready
echo "Waiting for database..."
until php artisan db:show 2>&1; do
    echo "Database not ready, retrying in 3s..."
    sleep 3
done
echo "Database ready."

php artisan migrate --force

# Seed only on first boot
USER_COUNT=$(php artisan tinker --execute="echo \App\Models\User::query()->count();" 2>/dev/null | grep -E '^[0-9]+$' | tail -1)
if [ -z "$USER_COUNT" ] || [ "$USER_COUNT" = "0" ]; then
    php artisan db:seed --force
fi

mkdir -p /var/log/supervisor

exec /usr/bin/supervisord -c /etc/supervisor/conf.d/supervisord.conf
