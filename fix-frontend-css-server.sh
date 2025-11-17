#!/bin/bash

# Fix Frontend CSS Loading Issue on Server
# This script builds Vite assets and ensures all CSS files are available

echo "🔧 Fixing Frontend CSS Loading Issue..."
echo ""

# Navigate to project directory
cd "$(dirname "$0")" || exit

echo "📦 Installing/Updating NPM Dependencies..."
npm install

echo ""
echo "🏗️  Building Vite Assets for Production..."
npm run build

echo ""
echo "✅ Verifying Build Output..."
if [ -f "public/build/manifest.json" ]; then
    echo "✅ Vite manifest.json exists"
    cat public/build/manifest.json | head -20
else
    echo "❌ Vite manifest.json not found!"
    echo "Build may have failed. Check the output above."
fi

echo ""
echo "🔍 Checking CSS Files..."
if [ -f "public/build/assets/app.css" ]; then
    echo "✅ Vite CSS file exists: public/build/assets/app.css"
    ls -lh public/build/assets/app.css
else
    echo "❌ Vite CSS file not found!"
fi

echo ""
echo "🔍 Checking Static CSS Files..."
if [ -f "public/assets/css/style.css" ]; then
    echo "✅ Frontend CSS exists: public/assets/css/style.css"
    ls -lh public/assets/css/style.css
else
    echo "⚠️  Frontend CSS not found (may be optional)"
fi

if [ -f "public/rh/css/style.css" ]; then
    echo "✅ RH CSS exists: public/rh/css/style.css"
    ls -lh public/rh/css/style.css
else
    echo "⚠️  RH CSS not found (may be optional)"
fi

echo ""
echo "🧹 Clearing Laravel Caches..."
php artisan config:clear
php artisan cache:clear
php artisan view:clear
php artisan route:clear

echo ""
echo "💾 Caching Configuration..."
php artisan config:cache
php artisan route:cache

echo ""
echo "✨ Done! Frontend CSS should now load correctly."
echo ""
echo "If issues persist, check:"
echo "1. File permissions: ls -la public/build/"
echo "2. Web server can access public/build/"
echo "3. APP_ENV in .env is set correctly"
echo "4. VITE_APP_URL in .env matches your domain"

