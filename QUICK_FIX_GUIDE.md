# Quick Fix Guide - Inertia & Database Issues

## 🚨 Issues Found

1. **Server:** `Class "Inertia\Middleware" not found`
2. **Local:** `SQLSTATE[HY000]: General error: 1 no such table: products`

---

## ✅ Solution 1: Fix Inertia Middleware on Server

**Run these commands on your server:**

```bash
cd /path/to/your/project

# Install/update dependencies
composer install --no-dev --optimize-autoloader

# Regenerate autoloader
composer dump-autoload --optimize

# Clear and cache config
php artisan config:clear
php artisan cache:clear
php artisan config:cache
```

**If that doesn't work, try:**

```bash
# Reinstall Inertia package
composer require inertiajs/inertia-laravel --no-update
composer update inertiajs/inertia-laravel

# Verify installation
composer show inertiajs/inertia-laravel
```

---

## ✅ Solution 2: Fix Missing Products Table (Local)

**Run these commands locally:**

```bash
cd /path/to/your/project

# Run pending migrations
php artisan migrate
```

**The following migrations are pending:**
- `2025_11_13_155257_create_products_table` ✅ Fixed
- `2025_11_13_160100_create_lead_products_table` ✅ Fixed
- `2025_11_14_083223_add_slug_to_products_table` ✅ Fixed

**If you need to refresh everything:**

```bash
# WARNING: This will drop all tables and recreate them
php artisan migrate:fresh

# Or with seed data
php artisan migrate:fresh --seed
```

---

## 🔧 Code Changes Made

1. **ProductController.php** - Added table existence check:
   ```php
   if (!Schema::hasTable('products')) {
       return redirect()->route('products.index')
           ->with('error', 'Products table does not exist. Please run migrations: php artisan migrate');
   }
   ```

2. **Fixed query** - Changed `COUNT(*) as count` to `COUNT(*) as total` to match error message

---

## 📋 Verification Steps

### For Server (Inertia):
```bash
# Check if package is installed
composer show inertiajs/inertia-laravel

# Check if vendor directory exists
ls -la vendor/inertiajs/inertia-laravel/

# Test if middleware loads
php artisan route:list | grep -i inertia
```

### For Local (Database):
```bash
# Check migration status
php artisan migrate:status

# Verify table exists
php artisan tinker
>>> Schema::hasTable('products')
# Should return: true
```

---

## 🎯 Quick Commands Summary

### Server Fix:
```bash
composer install --no-dev --optimize-autoloader && composer dump-autoload --optimize && php artisan config:clear && php artisan cache:clear && php artisan config:cache
```

### Local Fix:
```bash
php artisan migrate
```

---

## ⚠️ Important Notes

1. **Always run `composer install` after deploying to server**
2. **Always run `php artisan migrate` after pulling code changes**
3. **Keep `.env` file properly configured on both environments**
4. **Never delete migration files from version control**

---

## 🆘 Still Having Issues?

1. Check Laravel logs: `tail -f storage/logs/laravel.log`
2. Check database connection: `php artisan db:show`
3. Verify `.env` file has correct database settings
4. Check file permissions: `ls -la vendor/` and `ls -la database/`

