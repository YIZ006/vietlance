#!/bin/sh
set -e

echo "Starting Vietlance application..."

# Set PORT from Railway environment variable (default to 80)
export PORT=${PORT:-80}
echo "Using PORT: $PORT"

# Generate Nginx config with PORT variable from template
if [ -f /etc/nginx/http.d/default.conf.template ]; then
    # Use envsubst if available, otherwise use sed
    if command -v envsubst >/dev/null 2>&1; then
        envsubst '${PORT}' < /etc/nginx/http.d/default.conf.template > /etc/nginx/http.d/default.conf
        echo "Nginx config generated with PORT=$PORT (using envsubst)"
    else
        # Fallback: use sed to replace ${PORT} with actual PORT value
        sed "s/\${PORT}/${PORT}/g" /etc/nginx/http.d/default.conf.template > /etc/nginx/http.d/default.conf
        echo "Nginx config generated with PORT=$PORT (using sed)"
    fi
else
    # Fallback: modify existing config if template not found
    sed -i "s/listen 80/listen ${PORT}/g" /etc/nginx/http.d/default.conf 2>/dev/null || true
    sed -i "s/listen \[::\]:80/listen [::]:${PORT}/g" /etc/nginx/http.d/default.conf 2>/dev/null || true
    echo "Nginx config updated with PORT=$PORT"
fi

# Check if vendor directory exists
if [ ! -d "/var/www/html/vendor" ]; then
    echo "ERROR: vendor directory not found! Installing dependencies..."
    composer install --no-dev --optimize-autoloader --no-interaction || {
        echo "Failed to install composer dependencies"
        exit 1
    }
fi

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
    php artisan key:generate --force 2>/dev/null || echo "Warning: Could not generate APP_KEY"
fi

# Create storage link
if [ ! -L public/storage ]; then
    echo "Creating storage symlink..."
    php artisan storage:link 2>/dev/null || echo "Warning: Could not create storage link"
fi

# Set permissions
echo "Setting permissions..."
chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache
chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

# Clear and cache config
echo "Optimizing Laravel..."
php artisan config:clear 2>/dev/null || true
php artisan cache:clear 2>/dev/null || true
php artisan view:clear 2>/dev/null || true
php artisan route:clear 2>/dev/null || true

# Run migrations (optional - comment out if you want to run manually)
# echo "Running migrations..."
# php artisan migrate --force || true

# Cache config for production
if [ "${APP_ENV:-production}" = "production" ]; then
    echo "Caching configuration for production..."
    php artisan config:cache 2>/dev/null || true
    php artisan route:cache 2>/dev/null || true
    php artisan view:cache 2>/dev/null || true
fi

echo "Application is ready!"

# Execute the main command
exec "$@"

