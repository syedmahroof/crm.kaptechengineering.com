#!/bin/bash

# Fix Inertia Middleware Issue on Server
# Run this script on your server to fix the "Class Inertia\Middleware not found" error

echo "🔧 Fixing Inertia Middleware Issue..."
echo ""

# Navigate to project directory (adjust path if needed)
cd "$(dirname "$0")" || exit

echo "📦 Installing/Updating Composer Dependencies..."
composer install --no-dev --optimize-autoloader

echo ""
echo "🔄 Regenerating Autoloader..."
composer dump-autoload --optimize

echo ""
echo "🧹 Clearing Laravel Caches..."
php artisan config:clear
php artisan cache:clear
php artisan route:clear
php artisan view:clear

echo ""
echo "💾 Caching Configuration..."
php artisan config:cache
php artisan route:cache

echo ""
echo "✅ Verifying Inertia Package..."
if composer show inertiajs/inertia-laravel > /dev/null 2>&1; then
    echo "✅ Inertia package is installed"
    composer show inertiajs/inertia-laravel | head -5
else
    echo "❌ Inertia package not found. Installing..."
    composer require inertiajs/inertia-laravel
fi

echo ""
echo "🔍 Checking vendor directory..."
if [ -d "vendor/inertiajs/inertia-laravel" ]; then
    echo "✅ vendor/inertiajs/inertia-laravel directory exists"
    ls -la vendor/inertiajs/inertia-laravel/src/ | head -5
else
    echo "❌ vendor/inertiajs/inertia-laravel directory not found"
    echo "Running composer install again..."
    composer install --no-dev --optimize-autoloader
fi

echo ""
echo "✨ Done! Please test your application now."
echo ""
echo "If the issue persists, check:"
echo "1. PHP version: php -v (should be 8.4+)"
echo "2. Composer version: composer --version"
echo "3. File permissions: ls -la vendor/inertiajs/"
echo "4. Laravel logs: tail -f storage/logs/laravel.log"

