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

# Use HOST from env if set, otherwise use 0.0.0.0
HOST="${HOST:-0.0.0.0}"

echo "Starting PHP built-in server on $HOST:$PORT_NUM (converted from PORT=$PORT)"

# Export PORT as integer
export PORT=$PORT_NUM

# Run PHP built-in server with Laravel router script
# public/index.php is the router script that handles all requests
exec php -S $HOST:$PORT_NUM -t public public/index.php

