# 🚀 Deploy PenyuKita ke Vercel

Panduan lengkap untuk deploy aplikasi Laravel PenyuKita ke Vercel dengan database Railway MySQL.

---

## 📋 Prerequisites

1. ✅ Akun [Vercel](https://vercel.com)
2. ✅ Akun [Railway](https://railway.app) dengan MySQL sudah setup
3. ✅ Repository GitHub (push code ke GitHub terlebih dahulu)
4. ✅ Vercel CLI (opsional): `npm install -g vercel`

---

## 🗂️ File Konfigurasi yang Sudah Dibuat

- ✅ `vercel.json` - Konfigurasi routing dan runtime
- ✅ `api/index.php` - Entry point untuk Vercel
- ✅ `.env.production` - Environment variables template
- ✅ `vercel-build.sh` - Build script (opsional)

---

## 📝 Langkah-langkah Deploy

### Step 1: Push ke GitHub

```bash
git add .
git commit -m "Add Vercel configuration"
git push origin main
```

### Step 2: Connect ke Vercel

1. Buka [Vercel Dashboard](https://vercel.com/dashboard)
2. Click **"Add New..."** → **"Project"**
3. **Import Git Repository** → Pilih repository `Penyuku-full`
4. Click **"Import"**

### Step 3: Configure Project

Di Vercel project settings:

#### Framework Preset
- Select: **"Other"** (bukan Laravel, karena kita custom setup)

#### Build & Development Settings
- **Build Command:** `composer install --no-dev --optimize-autoloader && npm install && npm run build`
- **Output Directory:** `public`
- **Install Command:** (leave default)

#### Root Directory
- Leave as: `./` (root)

### Step 4: Environment Variables

Di Vercel Dashboard → **Settings** → **Environment Variables**, tambahkan:

#### Application Variables
```env
APP_NAME=PenyuKita
APP_ENV=production
APP_KEY=base64:/SrWHjH4IJZ5qTlUVnB2ZPlGzILwwINS9HCMDOh9LHM=
APP_DEBUG=false
APP_URL=https://your-app.vercel.app
```

#### Database Variables (Railway MySQL)
```env
DB_CONNECTION=mysql
DB_HOST=switchback.proxy.rlwy.net
DB_PORT=44110
DB_DATABASE=railway
DB_USERNAME=root
DB_PASSWORD=IrLLEQXGSFaBMaowfxYZZjcgvXIHidhm
```

#### Session & Cache
```env
SESSION_DRIVER=cookie
SESSION_LIFETIME=120
SESSION_ENCRYPT=false
CACHE_DRIVER=array
QUEUE_CONNECTION=sync
```

#### Filesystem & Logging
```env
FILESYSTEM_DISK=public
LOG_CHANNEL=stderr
LOG_LEVEL=error
```

#### Other
```env
BCRYPT_ROUNDS=12
BROADCAST_CONNECTION=log
```

**⚠️ PENTING:** Set environment untuk **Production, Preview, dan Development**

### Step 5: Deploy

Click **"Deploy"** button di Vercel!

Tunggu proses build selesai (~2-5 menit).

---

## 🔧 Post-Deployment Setup

### 1. Run Migrations via Railway CLI

Karena Vercel adalah serverless, migration harus dijalankan secara manual:

**Option A: Via Railway MySQL Client**
```bash
railway connect mysql
```

Kemudian paste SQL dari migration files.

**Option B: Via Local artisan (connect to Railway DB)**

Update `.env` lokal dengan Railway DB credentials:
```bash
php artisan migrate --force
php artisan db:seed --class=ArticleSeeder
php artisan db:seed --class=TurtleDataSeeder
```

### 2. Generate APP_KEY Baru (Jika Perlu)

```bash
php artisan key:generate --show
```

Copy output dan update di Vercel Environment Variables.

### 3. Storage Symlink

Karena Vercel filesystem bersifat read-only, upload file akan disimpan sementara.

**Rekomendasi:** Gunakan cloud storage untuk production:
- AWS S3
- Cloudinary
- ImageKit
- DigitalOcean Spaces

Update `config/filesystems.php` untuk menggunakan cloud storage.

---

## 🔍 Troubleshooting

### Issue 1: 500 Internal Server Error

**Fix:**
1. Check Vercel Logs: Dashboard → Deployments → Click deployment → Runtime Logs
2. Pastikan `APP_KEY` sudah di-set
3. Check database connection credentials

### Issue 2: Database Connection Failed

**Fix:**
1. Verifikasi Railway MySQL credentials
2. Pastikan Railway MySQL public network enabled
3. Test koneksi dari local:
```bash
mysql -h switchback.proxy.rlwy.net -P 44110 -u root -pIrLLEQXGSFaBMaowfxYZZjcgvXIHidhm railway
```

### Issue 3: Assets Not Loading (CSS/JS)

**Fix:**
1. Check `vercel.json` routes config
2. Pastikan `npm run build` berhasil
3. Verify `APP_URL` sesuai dengan domain Vercel
4. Clear browser cache

### Issue 4: Session Lost/Not Working

**Fix:**
- Pastikan `SESSION_DRIVER=cookie` (bukan database/file)
- Set `SESSION_SECURE_COOKIE=true` di production
- Check `SESSION_DOMAIN` setting

### Issue 5: File Upload Not Working

**Expected:** Vercel filesystem adalah read-only

**Solution:**
1. Gunakan cloud storage (S3, Cloudinary, etc)
2. Install package:
```bash
composer require league/flysystem-aws-s3-v3
```
3. Update `config/filesystems.php`

---

## 📊 Monitoring & Logs

### View Logs
- **Real-time Logs:** Vercel Dashboard → Deployments → Runtime Logs
- **Build Logs:** Vercel Dashboard → Deployments → Build Logs

### Performance Monitoring
- Install Vercel Analytics:
```bash
npm install @vercel/analytics
```

---

## 🔒 Security Checklist

- ✅ `APP_DEBUG=false` di production
- ✅ `APP_ENV=production`
- ✅ Generate new `APP_KEY` untuk production
- ✅ Gunakan HTTPS (auto by Vercel)
- ✅ Update `APP_URL` dengan domain Vercel
- ✅ Set strong database password
- ✅ Enable Railway MySQL SSL/TLS
- ✅ Restrict Railway MySQL access by IP (if possible)

---

## 🚀 Custom Domain (Optional)

1. Go to Vercel Dashboard → Settings → Domains
2. Add your custom domain
3. Configure DNS records at your domain provider
4. Update `APP_URL` environment variable

---

## 📝 Post-Deployment Checklist

- [ ] App deployed successfully
- [ ] Database connection working
- [ ] Migrations ran successfully
- [ ] Seeders ran (if needed)
- [ ] Login/Register working
- [ ] Image uploads working (or cloud storage configured)
- [ ] All routes accessible
- [ ] CSS/JS loading correctly
- [ ] Mobile responsive working
- [ ] Test all CRUD operations
- [ ] Check error logs for issues

---

## 🔄 Continuous Deployment

Vercel akan otomatis re-deploy setiap kali ada push ke GitHub:
- **Push ke `main` branch** → Deploy to Production
- **Push ke branch lain** → Deploy Preview (testing)

---

## 📞 Support

Jika ada masalah:
1. Check Vercel Logs
2. Check Railway MySQL status
3. Review `.env` variables
4. Test database connection locally
5. Check Vercel Status Page

---

## 🎉 Done!

Aplikasi PenyuKita Anda sekarang live di Vercel! 🐢

**Production URL:** `https://your-app.vercel.app`

---

**Note:** Untuk production yang lebih robust, pertimbangkan:
- Upgrade Vercel plan untuk unlimited executions
- Setup CDN untuk static assets
- Implement Redis untuk caching (Upstash)
- Setup monitoring (Sentry, New Relic)
- Backup database secara regular
