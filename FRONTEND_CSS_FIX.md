# 🎨 Frontend CSS Loading Fix - Server Deployment

## Problem
Frontend CSS is not loading on the server, possibly due to Inertia/Vite configuration.

## Root Causes

1. **Vite assets not built** - Production requires `npm run build`
2. **Manifest.json missing** - Vite needs manifest.json to load assets
3. **Environment configuration** - APP_ENV and VITE settings may be incorrect
4. **File permissions** - Web server may not have access to build files

## ✅ Quick Fix (Run on Server)

### Option 1: Use the Fix Script
```bash
cd /path/to/crm.kaptechengineering.com
chmod +x fix-frontend-css-server.sh
./fix-frontend-css-server.sh
```

### Option 2: Manual Steps
```bash
cd /path/to/crm.kaptechengineering.com

# Install/update NPM dependencies
npm install

# Build Vite assets for production
npm run build

# Verify build output
ls -la public/build/assets/

# Clear Laravel caches
php artisan config:clear
php artisan cache:clear
php artisan view:clear

# Rebuild caches
php artisan config:cache
php artisan route:cache
```

## 🔍 Verification

After running the fix, verify:

```bash
# Check if manifest exists
ls -la public/build/manifest.json

# Check if CSS file exists
ls -la public/build/assets/app.css

# Check file permissions
ls -la public/build/

# Test asset URL (replace with your domain)
curl -I https://yourdomain.com/build/assets/app.css
```

## 📋 Environment Configuration

Ensure your `.env` file has:

```env
APP_ENV=production
APP_DEBUG=false

# Vite Configuration (if using custom domain)
VITE_APP_URL=https://crm.kaptechengineering.com
```

## 🎯 Different Asset Types

### 1. Inertia Pages (React/TypeScript)
- Uses: `@vite(['resources/js/app.tsx'])`
- Requires: `npm run build`
- Output: `public/build/assets/app.css` and `app-*.js`

### 2. Frontend Pages (Blade Templates)
- Uses: `asset('assets/css/style.css')`
- Location: `public/assets/css/style.css`
- Static files - should already exist

### 3. RH Pages (Kaptech Solutions)
- Uses: `asset('rh/css/style.css')`
- Location: `public/rh/css/style.css`
- Static files - should already exist

## 🚨 Common Issues & Solutions

### Issue 1: "Vite manifest not found"
**Solution:**
```bash
npm run build
```

### Issue 2: "404 on /build/assets/app.css"
**Solution:**
1. Check file exists: `ls -la public/build/assets/app.css`
2. Check permissions: `chmod -R 755 public/build/`
3. Check web server can access the directory

### Issue 3: "CSS loads but styles don't apply"
**Solution:**
1. Clear browser cache
2. Check if Tailwind CSS is included in build
3. Verify `resources/css/app.css` imports Tailwind

### Issue 4: "Assets load in dev but not production"
**Solution:**
1. Ensure `APP_ENV=production` in `.env`
2. Run `npm run build` (not `npm run dev`)
3. Check `public/build/manifest.json` exists

## 📦 Deployment Checklist

```bash
# 1. Install dependencies
npm install

# 2. Build assets
npm run build

# 3. Verify build
ls -la public/build/assets/

# 4. Set permissions
chmod -R 755 public/build/
chown -R www-data:www-data public/build/  # Adjust user/group as needed

# 5. Clear Laravel caches
php artisan config:clear
php artisan cache:clear
php artisan view:clear

# 6. Rebuild caches
php artisan config:cache
php artisan route:cache

# 7. Test
curl -I https://yourdomain.com/build/assets/app.css
```

## 🔧 Advanced: Fallback Configuration

If Vite assets still don't load, the updated `app.blade.php` includes a fallback that tries to load assets directly. This ensures the site works even if Vite manifest is missing.

## 📝 Files Modified

1. `resources/views/app.blade.php` - Added fallback for production
2. `fix-frontend-css-server.sh` - Automated fix script

## ⚠️ Important Notes

1. **Always run `npm run build` after deploying code changes**
2. **Don't commit `node_modules/` or `public/build/` to git**
3. **Ensure `.env` has correct `APP_ENV` setting**
4. **Check web server can access `public/build/` directory**
5. **File permissions must allow web server to read files**

## 🆘 Still Not Working?

1. Check Laravel logs: `tail -f storage/logs/laravel.log`
2. Check web server error logs
3. Verify file permissions: `ls -la public/build/`
4. Test asset URLs directly in browser
5. Check browser console for 404 errors
6. Verify `APP_ENV` matches your environment

