#!/bin/sh
set -e

cd /var/www/html

if [ ! -f .env ]; then
    cp .env.example .env
fi

# Parse DATABASE_URL from Fly.io and write individual DB vars into .env
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

if [ -z "$APP_KEY" ]; then
    php artisan key:generate --force
fi

php artisan config:cache
php artisan route:cache
php artisan view:cache

mkdir -p /var/log/supervisor

exec /usr/bin/supervisord -c /etc/supervisor/conf.d/supervisord.conf
