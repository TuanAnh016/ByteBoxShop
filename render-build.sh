#!/usr/bin/env bash
set -e

echo "============================================"
echo "  ByteBox Build — Installing PHP + Composer"
echo "============================================"

# -----------------------------------------------
# 1. Install pkgx (rootless package manager)
# -----------------------------------------------
echo "===> Installing pkgx..."
curl -fsS https://pkgx.sh | sh
export PATH="$HOME/.local/bin:$PATH"

# -----------------------------------------------
# 2. Install PHP 8.3 and Composer via pkgx
# -----------------------------------------------
echo "===> Installing PHP 8.3..."
pkgx install php@8.3
pkgx install composer

# Add to PATH
export PATH="$HOME/.pkgx/php.net/v8.3/bin:$HOME/.pkgx/getcomposer.org/v2/bin:$PATH"

# Verify installations
echo "===> PHP version:"
php -v || pkgx php -v
echo "===> Composer version:"
composer --version || pkgx composer --version

# -----------------------------------------------
# 3. Install PHP dependencies
# -----------------------------------------------
echo "===> Installing PHP dependencies (Composer)..."
composer install --no-dev --optimize-autoloader --no-interaction || \
pkgx composer install --no-dev --optimize-autoloader --no-interaction

# -----------------------------------------------
# 4. Install Node dependencies & build frontend
# -----------------------------------------------
echo "===> Installing Node dependencies..."
npm ci || npm install

echo "===> Building frontend (Vite)..."
npm run build

# -----------------------------------------------
# 5. Prepare Laravel
# -----------------------------------------------
echo "===> Preparing Laravel storage..."
mkdir -p storage/framework/sessions storage/framework/views storage/framework/cache/data
chmod -R 775 storage bootstrap/cache || true
php artisan storage:link 2>/dev/null || true

echo "============================================"
echo "  Build completed successfully!"
echo "============================================"
