#!/bin/sh
set -e

# Change to application directory
cd /var/www/html || exit 1

# Railway tự động quản lý PORT - script này chỉ đọc PORT từ environment variable
# Ensure PORT is an integer (defaults to 80 if not set)
if [ -z "$PORT" ]; then
    PORT=8080
fi

# Extract only numeric part and ensure it's a valid integer
PORT_NUM=$(echo "$PORT" | sed 's/[^0-9]//g')
if [ -z "$PORT_NUM" ] || [ "$PORT_NUM" = "" ]; then
    PORT_NUM=8080
fi
 
# Ensure PORT_NUM is not empty and is numeric
if ! echo "$PORT_NUM" | grep -qE '^[0-9]+$'; then
    PORT_NUM=8080 
fi

# Railway tự động quản lý HOST - mặc định là 0.0.0.0 để accept external connections
# Không cần set HOST thủ công, Railway sẽ tự động quản lý
HOST="${HOST:-0.0.0.0}"

echo "Starting PHP built-in server on $HOST:$PORT_NUM (converted from PORT=$PORT)"
echo "Working directory: $(pwd)"
echo "Public directory exists: $(test -d public && echo 'yes' || echo 'no')"
echo "Router script exists: $(test -f public/index.php && echo 'yes' || echo 'no')"

# Export PORT as integer
export PORT=$PORT_NUM

# Ensure storage directories are writable
chmod -R 775 storage bootstrap/cache 2>/dev/null || true

# Verify Laravel bootstrap files exist
if [ ! -f bootstrap/app.php ]; then
    echo "ERROR: bootstrap/app.php not found!"
    exit 1
fi

if [ ! -f public/index.php ]; then
    echo "ERROR: public/index.php not found!"
    exit 1
fi

# Test if PHP can parse the entry point
php -l public/index.php || {
    echo "ERROR: public/index.php has syntax errors!"
    exit 1
}

# Check if .env exists (Laravel requires it)
if [ ! -f .env ]; then
    echo "WARNING: .env file not found! Creating from .env.example..."
    if [ -f .env.example ]; then
        cp .env.example .env
        echo "Created .env from .env.example"
    else
        echo "ERROR: .env.example not found! Cannot create .env file."
        exit 1
    fi
fi

# Test Laravel bootstrap (check if app can initialize)
echo "Testing Laravel bootstrap..."
php artisan --version > /dev/null 2>&1 || {
    echo "WARNING: Laravel artisan command failed, but continuing..."
}

# Test database connection (optional, don't fail if DB is not ready)
if [ -n "$DB_HOST" ]; then
    echo "Testing database connection..."
    php -r "
    try {
        \$pdo = new PDO('mysql:host=' . getenv('DB_HOST') . ';port=' . (getenv('DB_PORT') ?: '3306'), 
                       getenv('DB_USERNAME') ?: 'root', 
                       getenv('DB_PASSWORD') ?: '');
        echo 'Database connection: OK\n';
    } catch (Exception \$e) {
        echo 'Database connection: FAILED - ' . \$e->getMessage() . '\n';
    }
    " 2>&1 || echo "Database check skipped"
fi

echo "All checks passed. Starting PHP built-in server on $HOST:$PORT_NUM..."

# Run PHP built-in server with Laravel router script
# Use -t to set document root and specify router script
# The router script (public/index.php) handles all requests
# Redirect stderr to stdout so Railway can see all logs
# Use exec to replace shell process with PHP server
exec php -S $HOST:$PORT_NUM \
    -t public \
    public/index.php \
    2>&1

