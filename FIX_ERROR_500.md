# 🔍 Fix Error 500 di Vercel

## Kemungkinan Penyebab & Solusi

### 1. APP_KEY Tidak Terset (PALING UMUM)

**Check di Vercel:**
- Dashboard → Settings → Environment Variables
- Pastikan `APP_KEY` ada dan benar formatnya: `base64:...`

**Generate baru jika perlu:**
```bash
php artisan key:generate --show
```

Copy outputnya dan paste ke Vercel ENV dengan format lengkap (termasuk `base64:`)

---

### 2. Environment Variables Belum Lengkap

**WAJIB ada di Vercel:**

```env
APP_NAME=PenyuKita
APP_ENV=production
APP_KEY=base64:/SrWHjH4IJZ5qTlUVnB2ZPlGzILwwINS9HCMDOh9LHM=
APP_DEBUG=true
APP_URL=https://your-actual-vercel-url.vercel.app

DB_CONNECTION=mysql
DB_HOST=switchback.proxy.rlwy.net
DB_PORT=44110
DB_DATABASE=railway
DB_USERNAME=root
DB_PASSWORD=IrLLEQXGSFaBMaowfxYZZjcgvXIHidhm

SESSION_DRIVER=cookie
SESSION_LIFETIME=120
SESSION_ENCRYPT=false
SESSION_SECURE_COOKIE=false

CACHE_DRIVER=array
QUEUE_CONNECTION=sync
LOG_CHANNEL=stderr
LOG_LEVEL=debug

FILESYSTEM_DISK=public

BCRYPT_ROUNDS=10
```

**PENTING:** 
- Set `APP_DEBUG=true` untuk sementara (untuk lihat error detail)
- Set `SESSION_SECURE_COOKIE=false` (Vercel kadang issue dengan secure cookie)
- Set `LOG_LEVEL=debug` untuk detail error

---

### 3. Missing Vercel-specific Configs

Tambahkan ENV ini khusus untuk Vercel:

```env
APP_CONFIG_CACHE=/tmp/config.php
APP_EVENTS_CACHE=/tmp/events.php
APP_PACKAGES_CACHE=/tmp/packages.php
APP_ROUTES_CACHE=/tmp/routes.php
APP_SERVICES_CACHE=/tmp/services.php
VIEW_COMPILED_PATH=/tmp

DB_CONNECTION=mysql
```

---

### 4. Update vercel.json

Pastikan `vercel.json` memiliki config lengkap:

```json
{
  "version": 2,
  "builds": [
    {
      "src": "api/index.php",
      "use": "vercel-php@0.7.1"
    }
  ],
  "routes": [
    {
      "src": "/storage/(.*)",
      "dest": "/storage/$1"
    },
    {
      "src": "/build/(.*)",
      "dest": "/build/$1"
    },
    {
      "src": "/(.*\\.(css|js|json|png|jpg|jpeg|gif|ico|svg|woff|woff2|ttf|eot))",
      "dest": "/public/$1"
    },
    {
      "src": "/(.*)",
      "dest": "/api/index.php"
    }
  ],
  "env": {
    "APP_ENV": "production",
    "APP_DEBUG": "true",
    "VIEW_COMPILED_PATH": "/tmp",
    "SESSION_DRIVER": "cookie",
    "CACHE_DRIVER": "array",
    "LOG_CHANNEL": "stderr"
  }
}
```

---

## 🛠️ Langkah-langkah Fix

### Step 1: Check Runtime Logs

1. Vercel Dashboard → Deployments
2. Click deployment terakhir
3. Tab **Runtime Logs**
4. Lihat error messagenya

### Step 2: Enable Debug Mode

Di Vercel Environment Variables:
```
APP_DEBUG=true
LOG_LEVEL=debug
```

Redeploy, lalu check logs lagi untuk error detail.

### Step 3: Verify Database Connection

Test dari local:
```bash
php test-railway-connection.php
```

Jika gagal, berarti Railway DB bermasalah.

### Step 4: Check Missing Dependencies

Pastikan `composer.json` tidak butuh extension PHP yang tidak ada di Vercel:
- Vercel PHP 8.2 memiliki extension terbatas
- Cek error logs untuk "extension not found"

### Step 5: Redeploy

Setelah update ENV variables:
1. Vercel Dashboard → Deployments
2. Click ⋮ menu → **Redeploy**
3. Tunggu dan check logs

---

## 🔍 Common Errors & Solutions

### "No application encryption key has been specified"

**Fix:**
```bash
# Generate key
php artisan key:generate --show

# Copy output (contoh: base64:abcd1234...)
# Add to Vercel ENV: APP_KEY=base64:abcd1234...
```

### "SQLSTATE[HY000] [2002] Connection refused"

**Fix:**
- Check Railway MySQL masih running
- Verify credentials benar
- Test: `php test-railway-connection.php`

### "Class 'Redis' not found"

**Fix:**
```env
CACHE_DRIVER=array
SESSION_DRIVER=cookie
QUEUE_CONNECTION=sync
```

### "storage/framework not writable"

**Fix:** Sudah di-handle di `vercel.json` dengan `/tmp`

### "View not found"

**Fix:**
```env
VIEW_COMPILED_PATH=/tmp
```

---

## 📋 Complete ENV Checklist

Copy semua ini ke Vercel Environment Variables:

```env
# Application
APP_NAME=PenyuKita
APP_ENV=production
APP_KEY=base64:/SrWHjH4IJZ5qTlUVnB2ZPlGzILwwINS9HCMDOh9LHM=
APP_DEBUG=true
APP_URL=https://penyuku-full.vercel.app
APP_LOCALE=en
APP_FALLBACK_LOCALE=en
APP_FAKER_LOCALE=en_US
APP_MAINTENANCE_DRIVER=file

# Vercel-specific Paths
APP_CONFIG_CACHE=/tmp/config.php
APP_EVENTS_CACHE=/tmp/events.php
APP_PACKAGES_CACHE=/tmp/packages.php
APP_ROUTES_CACHE=/tmp/routes.php
APP_SERVICES_CACHE=/tmp/services.php
VIEW_COMPILED_PATH=/tmp

# Database
DB_CONNECTION=mysql
DB_HOST=switchback.proxy.rlwy.net
DB_PORT=44110
DB_DATABASE=railway
DB_USERNAME=root
DB_PASSWORD=IrLLEQXGSFaBMaowfxYZZjcgvXIHidhm

# Session
SESSION_DRIVER=cookie
SESSION_LIFETIME=120
SESSION_ENCRYPT=false
SESSION_PATH=/
SESSION_SECURE_COOKIE=false

# Cache & Queue
CACHE_DRIVER=array
CACHE_PREFIX=
QUEUE_CONNECTION=sync

# Filesystem
FILESYSTEM_DISK=public

# Logging
LOG_CHANNEL=stderr
LOG_STACK=single
LOG_DEPRECATIONS_CHANNEL=null
LOG_LEVEL=debug

# Other
BCRYPT_ROUNDS=10
BROADCAST_CONNECTION=log

# Mail (optional)
MAIL_MAILER=log
MAIL_FROM_ADDRESS=hello@example.com
MAIL_FROM_NAME="${APP_NAME}"

# Vite
VITE_APP_NAME="${APP_NAME}"
```

---

## 🚀 Quick Fix Commands

```bash
# 1. Update local .env untuk test Railway
DB_HOST=switchback.proxy.rlwy.net
DB_PORT=44110

# 2. Test database
php test-railway-connection.php

# 3. Generate new key
php artisan key:generate --show

# 4. Copy key to Vercel ENV
# 5. Redeploy di Vercel
```

---

## 📞 Still Not Working?

1. **Check Vercel Runtime Logs** - Ini yang paling penting!
2. **Enable APP_DEBUG=true** - Untuk lihat error detail
3. **Test database locally** - Pastikan Railway accessible
4. **Check PHP version** - Vercel uses PHP 8.2
5. **Verify all ENV set** - Double check semua variable

---

**Setelah selesai, set kembali:**
```env
APP_DEBUG=false
LOG_LEVEL=error
```
