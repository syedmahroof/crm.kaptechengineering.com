# Fix Inertia Middleware and Database Issues

## Issue 1: Inertia Middleware Not Found on Server

**Error:** `Class "Inertia\Middleware" not found`

### Solution:

1. **On the server, run these commands:**

```bash
# Navigate to project directory
cd /path/to/your/project

# Install/update composer dependencies
composer install --no-dev --optimize-autoloader

# Or if composer install doesn't work, try:
composer update --no-dev --optimize-autoloader

# Clear and cache config
php artisan config:clear
php artisan cache:clear
php artisan config:cache

# Regenerate autoloader
composer dump-autoload --optimize
```

2. **Verify Inertia package is installed:**

```bash
composer show inertiajs/inertia-laravel
```

3. **If the package is missing, install it:**

```bash
composer require inertiajs/inertia-laravel
```

4. **Check if vendor directory exists and has proper permissions:**

```bash
ls -la vendor/inertiajs/
```

5. **If still having issues, check bootstrap/app.php:**

Make sure the middleware is properly registered. The file should have:
```php
use App\Http\Middleware\HandleInertiaRequests;

->withMiddleware(function (Middleware $middleware): void {
    $middleware->web(append: [
        HandleInertiaRequests::class,
    ]);
})
```

---

## Issue 2: Products Table Missing in Local Database

**Error:** `SQLSTATE[HY000]: General error: 1 no such table: products`

### Solution:

1. **Run migrations to create the products table:**

```bash
# Make sure you're in the project directory
cd /path/to/your/project

# Run all pending migrations
php artisan migrate

# Or if you want to refresh the database (WARNING: This will drop all tables)
php artisan migrate:fresh

# Or if you want to refresh and seed
php artisan migrate:fresh --seed
```

2. **Verify the migration file exists:**

The migration file should be at:
`database/migrations/2025_11_13_155257_create_products_table.php`

3. **Check if migration has been run:**

```bash
php artisan migrate:status
```

Look for `2025_11_13_155257_create_products_table` in the list. If it shows "Pending", run migrations.

4. **If migration is already run but table is missing, check:**

```bash
# Check database connection
php artisan db:show

# Check if SQLite database file exists
ls -la database/database.sqlite

# If using MySQL/PostgreSQL, check connection in .env
```

5. **If using SQLite, ensure the database file exists:**

```bash
touch database/database.sqlite
chmod 664 database/database.sqlite
php artisan migrate
```

---

## Quick Fix Commands (Run in Order)

### For Server (Inertia Issue):
```bash
cd /path/to/project
composer install --no-dev --optimize-autoloader
composer dump-autoload --optimize
php artisan config:clear
php artisan cache:clear
php artisan config:cache
```

### For Local (Database Issue):
```bash
cd /path/to/project
php artisan migrate
# Or if you need to refresh:
php artisan migrate:fresh --seed
```

---

## Additional Troubleshooting

### If Inertia still doesn't work:

1. Check `composer.json` has the package:
```json
"inertiajs/inertia-laravel": "^2.0.1"
```

2. Check `app/Http/Middleware/HandleInertiaRequests.php` extends:
```php
use Inertia\Middleware;

final class HandleInertiaRequests extends Middleware
```

3. Verify the package is in vendor:
```bash
ls vendor/inertiajs/inertia-laravel/
```

### If Products table still doesn't exist:

1. Check migration file syntax is correct
2. Check database connection in `.env`
3. Try running specific migration:
```bash
php artisan migrate --path=database/migrations/2025_11_13_155257_create_products_table.php
```

4. Check Laravel logs:
```bash
tail -f storage/logs/laravel.log
```

---

## Prevention

1. **Always run `composer install` after deploying to server**
2. **Always run `php artisan migrate` after pulling code changes**
3. **Keep `.env` file properly configured on both local and server**
4. **Use version control for migrations, never delete migration files**

