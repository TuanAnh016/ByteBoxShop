#!/bin/bash

# Install dependencies
composer install --no-dev --optimize-autoloader

# Create database directory
mkdir -p /tmp

# Generate app key if not exists
if [ -z "$APP_KEY" ]; then
    php artisan key:generate --force
fi

# Run migrations
php artisan migrate --force

# Clear and cache configs
php artisan config:clear
php artisan config:cache
php artisan route:clear
php artisan route:cache
php artisan view:clear
php artisan view:cache

# Build frontend assets
npm install
npm run build
