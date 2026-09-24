#!/bin/sh
set -e

cd /var/www/html

if [ ! -f .env ]; then
    cp .env.example .env
fi

# Parse DATABASE_URL into individual DB vars
if [ -n "$DATABASE_URL" ]; then
    php -r "
\$url = parse_url(getenv('DATABASE_URL'));
\$env = file_get_contents('.env');
\$replacements = [
    'DB_HOST'     => \$url['host'],
    'DB_PORT'     => \$url['port'] ?? 5432,
    'DB_DATABASE' => ltrim(\$url['path'], '/'),
    'DB_USERNAME' => \$url['user'],
    'DB_PASSWORD' => \$url['pass'],
];
foreach (\$replacements as \$key => \$value) {
    \$env = preg_replace('/^' . \$key . '=.*/m', \$key . '=' . \$value, \$env);
}
file_put_contents('.env', \$env);
"
fi

# Unset HTTP server vars that Railway injects and confuse Laravel CLI
unset HTTP_HOST
unset SERVER_NAME
unset SERVER_ADDR

if [ -z "$APP_KEY" ]; then
    php artisan key:generate --force
fi

php artisan config:cache
php artisan route:cache
php artisan view:cache

# Wait for database to be ready
echo "Waiting for database..."
until php artisan db:show > /dev/null 2>&1; do
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
