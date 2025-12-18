#!/bin/sh
set -e

# Ensure PORT is an integer
if [ -z "$PORT" ]; then
    PORT=80
fi

# Extract only numeric part
PORT_NUM=$(echo "$PORT" | sed 's/[^0-9]//g')
if [ -z "$PORT_NUM" ]; then
    PORT_NUM=80
fi

echo "Starting Laravel server on port $PORT_NUM"

# Export PORT as integer for Laravel
export PORT=$PORT_NUM

# Run Laravel artisan serve with proper port handling
exec php artisan serve --host=0.0.0.0 --port=$PORT_NUM

