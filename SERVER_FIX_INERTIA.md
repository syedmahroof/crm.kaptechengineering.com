# 🚨 Server Fix: Inertia Middleware Not Found

## Error
```
Class "Inertia\Middleware" not found
```

## Quick Fix (Run on Server)

### Option 1: Use the Fix Script (Recommended)
```bash
cd /path/to/your/project
./fix-inertia-server.sh
```

### Option 2: Manual Commands
```bash
cd /path/to/your/project

# Install/update dependencies
composer install --no-dev --optimize-autoloader

# Regenerate autoloader
composer dump-autoload --optimize

# Clear all caches
php artisan config:clear
php artisan cache:clear
php artisan route:clear
php artisan view:clear

# Rebuild caches
php artisan config:cache
php artisan route:cache
```

### Option 3: If Package is Missing
```bash
cd /path/to/your/project

# Install Inertia package
composer require inertiajs/inertia-laravel

# Regenerate autoloader
composer dump-autoload --optimize

# Clear and rebuild caches
php artisan config:clear
php artisan cache:clear
php artisan config:cache
```

## Verification

After running the fix, verify the installation:

```bash
# Check if package is installed
composer show inertiajs/inertia-laravel

# Check if vendor directory exists
ls -la vendor/inertiajs/inertia-laravel/

# Check if class is autoloadable
php artisan tinker
>>> class_exists('Inertia\Middleware')
# Should return: true
```

## Common Causes

1. **Vendor directory not uploaded**: The `vendor/` directory might not be on the server
2. **Autoloader outdated**: Composer autoloader needs regeneration
3. **Package not installed**: Inertia package wasn't installed on server
4. **Cache issues**: Laravel config cache has old data

## Prevention

1. **Always run `composer install` after deployment**
2. **Don't commit vendor directory** (it's in .gitignore)
3. **Run migrations and cache clearing** after deployment
4. **Use deployment scripts** that include these commands

## Deployment Checklist

```bash
# After deploying code to server:
cd /path/to/project
composer install --no-dev --optimize-autoloader
composer dump-autoload --optimize
php artisan migrate --force
php artisan config:clear
php artisan cache:clear
php artisan config:cache
php artisan route:cache
```

## If Still Not Working

1. **Check PHP version**: `php -v` (should be 8.4+)
2. **Check Composer**: `composer --version`
3. **Check file permissions**: `ls -la vendor/inertiajs/`
4. **Check Laravel logs**: `tail -f storage/logs/laravel.log`
5. **Verify .env file**: Make sure it's properly configured
6. **Check disk space**: `df -h`

## Temporary Workaround

If you need the site to work immediately while fixing, you can temporarily comment out the Inertia middleware in `bootstrap/app.php`:

```php
$middleware->web(append: [
    HandleAppearance::class,
    // HandleInertiaRequests::class, // Temporarily disabled
    AddLinkHeadersForPreloadedAssets::class,
]);
```

**Note**: This will break Inertia pages, but the site will load.

