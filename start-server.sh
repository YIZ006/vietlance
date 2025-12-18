#!/bin/sh
set -e

# Change to application directory
cd /var/www/html || exit 1

# Ensure PORT is an integer
if [ -z "$PORT" ]; then
    PORT=80
fi

# Extract only numeric part and ensure it's a valid integer
PORT_NUM=$(echo "$PORT" | sed 's/[^0-9]//g')
if [ -z "$PORT_NUM" ] || [ "$PORT_NUM" = "" ]; then
    PORT_NUM=80
fi

# Ensure PORT_NUM is not empty and is numeric
if ! echo "$PORT_NUM" | grep -qE '^[0-9]+$'; then
    PORT_NUM=80
fi

echo "Starting Laravel server on port $PORT_NUM (converted from PORT=$PORT)"

# Export PORT as integer for Laravel (this ensures it's treated as integer)
export PORT=$PORT_NUM

# Run Laravel artisan serve with proper port handling
# Use --port with the numeric value explicitly
exec php artisan serve --host=0.0.0.0 --port=$PORT_NUM

