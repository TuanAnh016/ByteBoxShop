#!/bin/bash
set -e

echo "========================================"
echo "  ByteBox - Starting deployment..."
echo "========================================"

cd /var/www/html

# Generate APP_KEY if not set
if [ -z "$APP_KEY" ]; then
    echo ">> Generating APP_KEY..."
    php artisan key:generate --force
fi

# Cache configuration for performance
echo ">> Caching configuration..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Run migrations
echo ">> Running migrations..."
php artisan migrate --force

# Create storage link (in case it doesn't exist)
php artisan storage:link 2>/dev/null || true

# Set permissions
chown -R www-data:www-data storage bootstrap/cache
chmod -R 775 storage bootstrap/cache

echo "========================================"
echo "  ByteBox is ready! Listening on :10000"
echo "========================================"

# Start Supervisor (manages PHP-FPM + Nginx)
exec /usr/bin/supervisord -c /etc/supervisor/conf.d/supervisord.conf
