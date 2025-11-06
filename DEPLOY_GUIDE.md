# 🚀 Deploy Laravel ke Vercel - Updated Guide

## ⚠️ PENTING: Build Assets Terlebih Dahulu!

Vercel tidak akan menjalankan `npm run build` secara otomatis. Anda harus build di local dan commit hasilnya.

---

## 📝 Langkah Deploy

### Step 1: Build Assets di Local

```bash
# Install dependencies
npm install

# Build production assets
npm run build
```

### Step 2: Commit Build Results

```bash
# Add semua file termasuk build results
git add .
git add -f public/build

# Commit
git commit -m "Add Vercel configuration and build assets"

# Push ke GitHub
git push origin main
```

### Step 3: Update .gitignore

Pastikan `public/build` TIDAK diabaikan. Buka `.gitignore` dan comment atau hapus baris:

```
# /public/build  <- Comment atau hapus baris ini!
```

Kemudian build dan commit lagi:

```bash
npm run build
git add public/build
git commit -m "Add build files for Vercel"
git push
```

### Step 4: Import ke Vercel

1. Buka https://vercel.com/new
2. Import repository **Penyuku-full**
3. **Framework Preset:** Other
4. **Build Command:** KOSONGKAN (leave empty)
5. **Output Directory:** `public`
6. **Install Command:** KOSONGKAN (leave empty)
7. Click **Deploy**

### Step 5: Set Environment Variables

Di Vercel Dashboard → Settings → Environment Variables, tambahkan:

```env
# Application
APP_NAME=PenyuKita
APP_ENV=production
APP_KEY=base64:/SrWHjH4IJZ5qTlUVnB2ZPlGzILwwINS9HCMDOh9LHM=
APP_DEBUG=false
APP_URL=https://your-app.vercel.app

# Database Railway
DB_CONNECTION=mysql
DB_HOST=switchback.proxy.rlwy.net
DB_PORT=44110
DB_DATABASE=railway
DB_USERNAME=root
DB_PASSWORD=IrLLEQXGSFaBMaowfxYZZjcgvXIHidhm

# Session & Cache
SESSION_DRIVER=cookie
SESSION_LIFETIME=120
CACHE_DRIVER=array
QUEUE_CONNECTION=sync

# Storage & Logs
FILESYSTEM_DISK=public
LOG_CHANNEL=stderr
LOG_LEVEL=error
```

**Set untuk:** Production, Preview, dan Development

### Step 6: Redeploy

Setelah set environment variables:
- Vercel Dashboard → Deployments
- Click menu (⋮) → **Redeploy**

### Step 7: Update APP_URL

Setelah deploy berhasil, copy URL Vercel dan update:
1. Vercel Dashboard → Settings → Environment Variables
2. Update `APP_URL` dengan URL actual (contoh: `https://penyuku-full.vercel.app`)
3. Redeploy lagi

### Step 8: Run Migrations

**Di local, connect ke Railway database:**

Update `.env` local:
```env
DB_HOST=switchback.proxy.rlwy.net
DB_PORT=44110
DB_DATABASE=railway
DB_USERNAME=root
DB_PASSWORD=IrLLEQXGSFaBMaowfxYZZjcgvXIHidhm
```

Jalankan migrations:
```bash
php artisan migrate --force
php artisan db:seed --class=ArticleSeeder
php artisan db:seed --class=TurtleDataSeeder
```

---

## ✅ Checklist

- [ ] `npm run build` di local
- [ ] Commit `public/build` ke Git
- [ ] Push ke GitHub
- [ ] Import project ke Vercel
- [ ] Build & Install command KOSONG
- [ ] Set ALL environment variables
- [ ] Redeploy setelah set ENV
- [ ] Update APP_URL
- [ ] Redeploy lagi
- [ ] Run migrations dari local

---

## 🔧 Troubleshooting

### Assets tidak load (404)

**Solusi:**
```bash
# Build ulang
npm run build

# Force add build folder
git add -f public/build/*

# Commit dan push
git commit -m "Force add build assets"
git push

# Redeploy di Vercel
```

### 500 Internal Server Error

**Check:**
1. Vercel Dashboard → Deployments → Runtime Logs
2. Pastikan semua ENV variables sudah di-set
3. Verify `APP_KEY` ada dan benar
4. Check database connection

### Database connection failed

**Check:**
1. Railway MySQL masih running
2. Credentials benar
3. Test connection: `php test-railway-connection.php`

### Build command error 127

**Fix:** Jangan set build command di Vercel! Kosongkan saja. Build dilakukan di local sebelum push.

---

## 📌 Important Notes

### Yang HARUS Dilakukan di Local:
- ✅ `npm install`
- ✅ `npm run build`
- ✅ Commit `public/build`
- ✅ Push ke GitHub

### Yang TIDAK Dilakukan di Vercel:
- ❌ `composer install`
- ❌ `npm install`
- ❌ `npm run build`
- ❌ Migrations

Vercel hanya serve PHP files dan static assets yang sudah ada!

---

## 🎯 After Deploy

Test semua fitur:
- [ ] Homepage loading
- [ ] Login/Register
- [ ] PenyuKita (artikel)
- [ ] Postingan komunitas
- [ ] Like & Comment
- [ ] Chat global
- [ ] Dashboard data penyu
- [ ] Admin features (penangkaran role)

---

## 🚨 Known Limitations

1. **File Uploads** - Tidak persisten (gunakan Cloudinary/S3)
2. **Session** - Harus cookie-based
3. **Cache** - Harus array atau Redis
4. **Cron Jobs** - Tidak didukung

---

## 📞 Need Help?

- Check Vercel Runtime Logs
- Test Railway connection locally
- Review environment variables
- Check build files exists in Git

---

**Good luck! 🐢🚀**
