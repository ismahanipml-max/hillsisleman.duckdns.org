#!/bin/sh
set -e
cd /var/www/html

mkdir -p storage/database storage/app/public storage/logs \
    storage/framework/cache/data storage/framework/sessions storage/framework/views

if [ -z "$APP_KEY" ]; then
    if [ ! -s storage/app.key ]; then
        echo "base64:$(head -c 32 /dev/urandom | base64)" > storage/app.key
        echo "[entrypoint] APP_KEY baru dibuat di storage/app.key"
    fi
    APP_KEY="$(cat storage/app.key)"
    export APP_KEY
fi

DB_FILE="${DB_DATABASE:-/var/www/html/storage/database/database.sqlite}"
[ -f "$DB_FILE" ] || touch "$DB_FILE"

chown -R www-data:www-data storage bootstrap/cache

php artisan package:discover --ansi
php artisan storage:link --force
php artisan migrate --force

if [ "${SEED_ON_FIRST_RUN:-true}" = "true" ] && [ ! -f storage/database/.seeded ]; then
    php artisan db:seed --force
    touch storage/database/.seeded
fi

php artisan optimize

chown -R www-data:www-data storage bootstrap/cache

exec "$@"
