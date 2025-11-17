# 🚀 Quick Fix: Frontend CSS Not Loading on Server

## Immediate Solution

**Run these commands on your server:**

```bash
cd /path/to/crm.kaptechengineering.com

# 1. Install/update NPM dependencies
npm install

# 2. Build Vite assets for production
npm run build

# 3. Set correct permissions
chmod -R 755 public/build/
chown -R www-data:www-data public/build/  # Adjust user/group as needed

# 4. Clear Laravel caches
php artisan config:clear
php artisan cache:clear
php artisan view:clear

# 5. Rebuild caches
php artisan config:cache
php artisan route:cache
```

## Or Use the Automated Script

```bash
cd /path/to/crm.kaptechengineering.com
chmod +x fix-frontend-css-server.sh
./fix-frontend-css-server.sh
```

## What This Fixes

1. ✅ Builds Vite assets (`public/build/assets/app.css` and JS files)
2. ✅ Creates/updates `manifest.json` for asset loading
3. ✅ Ensures proper file permissions
4. ✅ Clears stale Laravel caches

## Verification

After running, check:

```bash
# Verify manifest exists
ls -la public/build/manifest.json

# Verify CSS file exists
ls -la public/build/assets/app.css

# Test in browser
# Visit: https://yourdomain.com/build/assets/app.css
# Should return CSS content, not 404
```

## Why This Happens

- **Development**: Vite dev server handles assets
- **Production**: Assets must be pre-built with `npm run build`
- **Server**: Needs built assets in `public/build/` directory

## Prevention

Always run `npm run build` after:
- Deploying code changes
- Updating NPM dependencies
- Changing CSS/JS files

---

**The updated `app.blade.php` now includes smart fallbacks to handle missing assets gracefully.**

