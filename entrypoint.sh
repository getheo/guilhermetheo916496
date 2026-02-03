#!/bin/sh
set -e

echo "📦 Dependências PHP..."
if [ ! -d "vendor" ]; then
    if [ "${APP_ENV}" = "production" ]; then
        composer install --no-dev --optimize-autoloader --no-interaction
    else
        composer install --no-interaction
    fi
fi

echo "📦 Assets (Vite)..."
if [ ! -d "node_modules" ]; then
    npm install
fi

if [ "${APP_ENV}" = "production" ]; then
    npm run build
else
    # Em dev, você pode rodar build ou deixar o 'npm run dev' em um terminal separado
    npm run build 
fi

if [ ! -f ".env" ]; then
    cp .env.example .env
fi

echo "⏳ Aguardando Postgres..."
while ! pg_isready -h "$DB_HOST" -p "$DB_PORT" -U "$DB_USERNAME" >/dev/null 2>&1; do
    sleep 2
done

if ! grep -q "^APP_KEY=" .env || [ -z "$(grep APP_KEY= .env | cut -d '=' -f2)" ]; then
    php artisan key:generate
fi

php artisan migrate --force

if [ "${APP_ENV}" != "production" ]; then
    php artisan db:seed
fi

php artisan l5-swagger:generate

php artisan config:clear
php artisan route:clear
php artisan view:clear

chown -R www-data:www-data storage bootstrap/cache
chmod -R 775 storage bootstrap/cache

echo "🚀 Ambiente pronto."
exec apache2-foreground
