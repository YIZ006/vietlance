#!/bin/sh
set -e

echo "Starting Vietlance application..."

# Wait for MySQL to be ready
echo "Waiting for MySQL..."
until php -r "try { new PDO('mysql:host=${DB_HOST:-mysql};port=${DB_PORT:-3306}', '${DB_USERNAME:-root}', '${DB_PASSWORD:-password}'); echo 'MySQL is ready\n'; exit(0); } catch (Exception \$e) { exit(1); }" 2>/dev/null; do
    echo "MySQL is unavailable - sleeping"
    sleep 2
done

# Create .env file if it doesn't exist
if [ ! -f .env ]; then
    echo "Creating .env file from .env.example..."
    cp .env.example .env 2>/dev/null || echo "Warning: .env.example not found"
fi

# Generate application key if not set
if ! grep -q "APP_KEY=base64:" .env 2>/dev/null; then
    echo "Generating application key..."
    php artisan key:generate --force || true
fi

# Create storage link
if [ ! -L public/storage ]; then
    echo "Creating storage symlink..."
    php artisan storage:link || true
fi

# Set permissions
echo "Setting permissions..."
chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache
chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

# Clear and cache config
echo "Optimizing Laravel..."
php artisan config:clear || true
php artisan cache:clear || true
php artisan view:clear || true
php artisan route:clear || true

# Run migrations (optional - comment out if you want to run manually)
# echo "Running migrations..."
# php artisan migrate --force || true

# Cache config for production
if [ "${APP_ENV:-production}" = "production" ]; then
    echo "Caching configuration for production..."
    php artisan config:cache || true
    php artisan route:cache || true
    php artisan view:cache || true
fi

echo "Application is ready!"

# Execute the main command
exec "$@"

