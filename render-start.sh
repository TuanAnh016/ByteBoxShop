#!/usr/bin/env bash
set -e

echo "============================================"
echo "  ByteBox Start — Running Laravel"
echo "============================================"

# Ensure pkgx is in PATH
export PATH="$HOME/.local/bin:$PATH"

# Setup PHP PATH via pkgx
export PATH="$HOME/.pkgx/php.net/v8.3/bin:$HOME/.pkgx/getcomposer.org/v2/bin:$PATH"

# Try to use pkgx directly if regular PHP fails
if ! command -v php &> /dev/null; then
    alias php="pkgx php"
fi

echo "===> Running migrations..."
php artisan migrate --force

echo "===> Caching configurations..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

echo "===> Starting Laravel server on port ${PORT:-10000}..."
exec php artisan serve --host=0.0.0.0 --port=${PORT:-10000}
