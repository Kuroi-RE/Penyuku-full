# 🐢 PenyuKu - Platform Konservasi Penyu Cilacap

Platform web berbasis Laravel untuk mendukung konservasi penyu di pantai-pantai Cilacap, Jawa Tengah. Sistem ini menggabungkan fitur media sosial, edukasi, dan transparansi data konservasi.

![Laravel](https://img.shields.io/badge/Laravel-12.36.1-FF2D20?style=flat&logo=laravel&logoColor=white)
![PHP](https://img.shields.io/badge/PHP-8.3.7-777BB4?style=flat&logo=php&logoColor=white)
![MySQL](https://img.shields.io/badge/MySQL-8.0-4479A1?style=flat&logo=mysql&logoColor=white)
![Bootstrap](https://img.shields.io/badge/Bootstrap-5.3.0-7952B3?style=flat&logo=bootstrap&logoColor=white)

---

## 📋 Daftar Isi

-   [Tentang Project](#-tentang-project)
-   [Fitur Utama](#-fitur-utama)
-   [Teknologi](#-teknologi)
-   [Instalasi](#-instalasi)
-   [Konfigurasi](#-konfigurasi)
-   [Struktur Database](#-struktur-database)
-   [Peran Pengguna](#-peran-pengguna)
-   [Penggunaan](#-penggunaan)
-   [Struktur Folder](#-struktur-folder-project)
-   [API Routes](#-api-routes)
-   [Testing](#-testing)
-   [Kontribusi](#-kontribusi)

---

## 🌊 Tentang Project

**PenyuKita** adalah platform digital yang dikembangkan untuk mendukung upaya konservasi penyu di Cilacap. Platform ini menyediakan:

-   📱 **Media Sosial Komunitas** - Berbagi informasi, foto, dan diskusi seputar konservasi penyu
-   📚 **Portal Edukasi** - Artikel, panduan, dan berita terkini tentang penyu dan konservasinya
-   📊 **Transparansi Data** - Dashboard publik yang menampilkan data real-time peneluran dan penetasan
-   📝 **Sistem Pencatatan** - Tools khusus untuk admin penangkaran mencatat temuan sarang dan wilayah peneluran

**Lokasi Fokus:** 13 Pantai di Cilacap (Sodong, Srandil, Welahan Wetan, Widarapayung Kulon, Sidayu, Widarapayung Wetan, Sidaurip, Pagubugan Kulon, Pagubugan, Karangtawang, Karangpakis, Jetis, Glempangpasir)

---

## ✨ Fitur Utama

### 🔐 Autentikasi & User Management

-   ✅ Register dengan role (Komunitas/Penangkaran)
-   ✅ Login/Logout dengan session management
-   ✅ Profile management (edit info, ganti password, upload avatar)
-   ✅ User profiles publik dengan posts & statistics

### 📰 PenyuKita (Portal Artikel)

-   ✅ Browse artikel konservasi penyu (Kegiatan, Edukasi, Berita, Panduan, Penelitian)
-   ✅ Detail artikel dengan like, comment, dan share
-   ✅ Search & filter artikel (kategori, keyword)
-   ✅ Related articles berdasarkan kategori
-   ✅ View counter untuk setiap artikel

### 📱 Postingan Komunitas

-   ✅ Create, edit, delete posts dengan text & image
-   ✅ Like & unlike posts
-   ✅ Comment pada posts dengan nested display
-   ✅ Delete comment (owner atau post owner)
-   ✅ Badge "edited" untuk post yang di-update
-   ✅ Real-time interaction tanpa reload (AJAX)

### 💬 Chat Global

-   ✅ Real-time global chat room
-   ✅ Kirim pesan text ke semua user
-   ✅ Auto-scroll ke pesan terbaru
-   ✅ Display nama & timestamp

### 📊 Dashboard Data Penyu (Public)

**Dapat diakses oleh semua user yang login**

-   ✅ Statistics cards (total sarang, telur, menetas, success rate)
-   ✅ Temuan per lokasi dengan visualisasi progress bar
-   ✅ Distribusi peneluran per pantai
-   ✅ Tren bulanan dengan tabel detail
-   ✅ Recent findings list
-   ✅ Filter data per tahun

### 🎯 Fitur Admin Penangkaran

#### 📝 Kelola Artikel

-   ✅ CRUD artikel (Create, Read, Update, Delete)
-   ✅ Upload gambar artikel
-   ✅ Auto-generate slug dari judul
-   ✅ Draft/Published status
-   ✅ Statistics (views, likes, comments)

#### 🥚 Pencatatan Data Temuan Sarang

-   ✅ CRUD temuan sarang penyu
-   ✅ Fields: tanggal temuan, kode sarang (P1, P2, dst), lokasi, jumlah telur
-   ✅ Perkiraan menetas (auto-calculate +55 hari)
-   ✅ Jumlah menetas & persentase keberhasilan (auto-calculate)
-   ✅ Status: Monitoring/Hatched/Taken by Fisherman
-   ✅ Filter by year, location, status
-   ✅ Pagination & statistics dashboard

#### 🗺️ Pencatatan Wilayah Peneluran

-   ✅ Matrix view seperti Excel (Bulan × Lokasi)
-   ✅ Bulk input untuk semua lokasi & bulan sekaligus
-   ✅ Data per tahun dengan totals per bulan dan per lokasi
-   ✅ Top locations chart dengan progress bars
-   ✅ Update/replace data existing

---

## 🛠️ Teknologi

### Backend

-   **Framework:** Laravel 12.36.1
-   **PHP:** 8.3.7
-   **Database:** MySQL 8.0
-   **Authentication:** Laravel Breeze
-   **Storage:** Laravel Storage (public disk)

### Frontend

-   **Template Engine:** Blade
-   **CSS Framework:** Bootstrap 5.3.0 + Tailwind CSS
-   **Icons:** Font Awesome 6.4.0
-   **JavaScript:** jQuery 3.6.0 (AJAX interactions)
-   **Build Tool:** Vite

### Libraries & Tools

-   **Image Storage:** Laravel Storage Facade
-   **Pagination:** Laravel Paginator
-   **Form Validation:** Laravel Validation
-   **Middleware:** Custom role-based middleware (isPenangkaran)

---

## 📦 Instalasi

### Prerequisites

-   PHP >= 8.3.7
-   Composer
-   Node.js & NPM
-   MySQL 8.0
-   Git

### Langkah Instalasi

1. **Clone Repository**

```bash
git clone <repository-url>
cd Penyuku-full
```

2. **Install Dependencies**

```bash
# Install PHP dependencies
composer install

# Install Node dependencies
npm install
```

3. **Environment Setup**

```bash
# Copy environment file
cp .env.example .env

# Generate application key
php artisan key:generate
```

4. **Database Configuration**

Edit file `.env`:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=penyuku_db
DB_USERNAME=root
DB_PASSWORD=your_password
```

5. **Create Database**

```bash
# Buat database MySQL
mysql -u root -p
CREATE DATABASE penyuku_db;
exit;
```

6. **Run Migrations & Seeders**

```bash
# Run all migrations
php artisan migrate

# Seed sample data
php artisan db:seed --class=ArticleSeeder
php artisan db:seed --class=TurtleDataSeeder
```

7. **Create Storage Link**

```bash
php artisan storage:link
```

8. **Build Assets**

```bash
# Development
npm run dev

# Production
npm run build
```

9. **Run Application**

```bash
# Start Laravel server
php artisan serve

# Application akan berjalan di http://localhost:8000
```

---

## ⚙️ Konfigurasi

### Storage Configuration

Pastikan folder berikut memiliki permission write:

```
storage/
storage/app/public/
storage/framework/
storage/logs/
bootstrap/cache/
```

### Image Upload

Gambar di-upload ke:

-   **Artikel:** `storage/app/public/articles/`
-   **Posts:** `storage/app/public/posts/`
-   **Profile:** `storage/app/public/profile/`

### Middleware Custom

**isPenangkaran** - Middleware untuk restrict akses fitur admin:

```php
// app/Http/Middleware/isPenangkaran.php
// Hanya user dengan role='penangkaran' yang bisa akses
```

---

## 🗄️ Struktur Database

### Core Tables

#### **users**

```sql
- id (PK)
- username (unique)
- name
- email (unique)
- password
- role (enum: komunitas, penangkaran)
- avatar (nullable)
- bio (nullable)
- timestamps
```

#### **articles**

```sql
- id (PK)
- user_id (FK → users)
- title
- slug (unique)
- excerpt
- content (longText)
- image (nullable)
- category (enum: Kegiatan, Edukasi, Berita, Panduan, Penelitian)
- status (enum: draft, published)
- views (default: 0)
- timestamps
```

#### **posts**

```sql
- id (PK)
- user_id (FK → users)
- content (text)
- image (nullable)
- timestamps
```

#### **turtle_nest_findings**

```sql
- id (PK)
- user_id (FK → users)
- finding_date (date)
- nest_code (nullable, contoh: P1, P2)
- egg_count (integer)
- location (string)
- estimated_hatching_date (nullable)
- hatched_count (default: 0)
- hatching_percentage (decimal)
- status (enum: monitoring, hatched, taken_by_fisherman)
- notes (nullable)
- timestamps
```

#### **turtle_nesting_locations**

```sql
- id (PK)
- user_id (FK → users)
- location_name (string)
- month (enum: Januari-Desember)
- year (integer)
- nesting_count (default: 0)
- notes (nullable)
- timestamps
- INDEX (location_name, month, year)
```

### Relationship Tables

#### **likes** (Post Likes)

```sql
- id (PK)
- user_id (FK → users)
- post_id (FK → posts)
- UNIQUE (user_id, post_id)
```

#### **comments** (Post Comments)

```sql
- id (PK)
- user_id (FK → users)
- post_id (FK → posts)
- content (text)
- timestamps
```

#### **article_likes**

```sql
- id (PK)
- user_id (FK → users)
- article_id (FK → articles)
- UNIQUE (user_id, article_id)
```

#### **article_comments**

```sql
- id (PK)
- user_id (FK → users)
- article_id (FK → articles)
- content (text)
- timestamps
```

#### **chat_messages**

```sql
- id (PK)
- user_id (FK → users)
- message (text)
- timestamps
```

---

## 👥 Peran Pengguna

### 1. **Komunitas** (Default Role)

**Akses:**

-   ✅ PenyuKita (browse & baca artikel)
-   ✅ Postingan (CRUD post, like, comment)
-   ✅ Chat Global
-   ✅ Dashboard Data Penyu (view only)
-   ✅ Profile management

**Tidak Bisa:**

-   ❌ Kelola artikel
-   ❌ Pencatatan data temuan & wilayah

### 2. **Penangkaran** (Admin Role)

**Akses Semua Fitur Komunitas +**

-   ✅ Kelola Artikel (CRUD)
-   ✅ Pencatatan Temuan Sarang (CRUD)
-   ✅ Pencatatan Wilayah Peneluran (CRUD)

---

## 🚀 Penggunaan

### Untuk Komunitas

1. **Register** sebagai user komunitas
2. **Browse PenyuKita** untuk membaca artikel konservasi
3. **Buat Post** untuk berbagi foto/informasi
4. **Like & Comment** pada post atau artikel
5. **Join Chat Global** untuk diskusi real-time
6. **Lihat Dashboard Data** untuk transparansi konservasi

### Untuk Admin Penangkaran

**Login Credentials (Development):**

```
Email: admin@penangkaran.com
Password: password
```

**Workflow:**

1. **Kelola Artikel**

    - Menu: Kelola Artikel → Tambah Artikel
    - Upload gambar, tulis konten, pilih kategori
    - Publish atau simpan sebagai draft

2. **Catat Temuan Sarang**

    - Menu: Pencatatan Data → Data Temuan Sarang
    - Klik "Tambah Temuan Baru"
    - Isi: tanggal, lokasi, kode sarang, jumlah telur
    - Update hasil penetasan saat telur menetas

3. **Input Data Wilayah**

    - Menu: Pencatatan Data → Wilayah Peneluran
    - Klik "Input Data Wilayah"
    - Pilih tahun, isi matrix peneluran per bulan/lokasi
    - Submit untuk save semua data sekaligus

4. **Monitor Dashboard**
    - Menu: Data Penyu
    - Lihat statistics, charts, dan tren data

---

## 📂 Struktur Folder Project

```
Penyuku-full/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── ArticleController.php
│   │   │   ├── ChatController.php
│   │   │   ├── HomeController.php
│   │   │   ├── PenyuKitaController.php
│   │   │   ├── PostController.php
│   │   │   ├── ProfileUpdateController.php
│   │   │   ├── TurtleDataDashboardController.php
│   │   │   ├── TurtleNestFindingController.php
│   │   │   ├── TurtleNestingLocationController.php
│   │   │   └── UserProfileController.php
│   │   └── Middleware/
│   │       └── isPenangkaran.php
│   └── Models/
│       ├── Article.php
│       ├── ArticleComment.php
│       ├── ArticleLike.php
│       ├── ChatMessage.php
│       ├── Comment.php
│       ├── Like.php
│       ├── Post.php
│       ├── TurtleNestFinding.php
│       ├── TurtleNestingLocation.php
│       └── User.php
├── database/
│   ├── migrations/
│   │   ├── create_users_table.php
│   │   ├── create_posts_table.php
│   │   ├── create_articles_table.php
│   │   ├── create_turtle_nest_findings_table.php
│   │   ├── create_turtle_nesting_locations_table.php
│   │   └── ...
│   └── seeders/
│       ├── ArticleSeeder.php
│       └── TurtleDataSeeder.php
├── resources/
│   ├── css/
│   │   └── app.css
│   ├── js/
│   │   ├── app.js
│   │   └── bootstrap.js
│   └── views/
│       ├── articles/
│       ├── chat/
│       ├── home.blade.php
│       ├── layouts/
│       │   ├── app.blade.php
│       │   └── navigation.blade.php
│       ├── penyukita/
│       ├── posts/
│       ├── profile/
│       ├── turtle-data/
│       │   └── dashboard.blade.php
│       └── turtle-eggs/
│           ├── index.blade.php
│           ├── findings/
│           │   ├── index.blade.php
│           │   ├── create.blade.php
│           │   ├── edit.blade.php
│           │   └── show.blade.php
│           └── locations/
│               ├── index.blade.php
│               └── create.blade.php
├── routes/
│   ├── web.php
│   └── auth.php
├── public/
│   └── storage/ (symlink)
├── storage/
│   └── app/
│       └── public/
│           ├── articles/
│           ├── posts/
│           └── profile/
├── .env
├── composer.json
├── package.json
├── vite.config.js
└── README.md
```

---

## 🔧 API Routes

### Public Routes

```
GET  /                          - Landing page (guest only)
GET  /register                  - Register form
POST /register                  - Process registration
GET  /login                     - Login form
POST /login                     - Process login
```

### Authenticated Routes

```
GET  /penyukita                 - Portal artikel
GET  /penyukita/article/{slug}  - Detail artikel
GET  /posts                     - Feed postingan
GET  /chat                      - Global chat
GET  /turtle-data               - Dashboard data penyu
GET  /user/{user}               - User profile
GET  /profile/custom            - Edit profile
```

### Penangkaran Only Routes

```
# Articles
GET    /articles               - List artikel
GET    /articles/create        - Form artikel
POST   /articles               - Store artikel
GET    /articles/{id}/edit     - Edit artikel
PUT    /articles/{id}          - Update artikel
DELETE /articles/{id}          - Delete artikel

# Nest Findings
GET    /turtle-eggs/findings              - List temuan
GET    /turtle-eggs/findings/create       - Form temuan
POST   /turtle-eggs/findings              - Store temuan
GET    /turtle-eggs/findings/{id}         - Detail temuan
GET    /turtle-eggs/findings/{id}/edit    - Edit temuan
PUT    /turtle-eggs/findings/{id}         - Update temuan
DELETE /turtle-eggs/findings/{id}         - Delete temuan

# Nesting Locations
GET    /turtle-eggs/locations             - Matrix view
GET    /turtle-eggs/locations/create      - Bulk input form
POST   /turtle-eggs/locations             - Store bulk data
```

---

## 🧪 Testing

### Sample Data

Project sudah include seeders dengan sample data:

**ArticleSeeder** - 6 artikel tentang konservasi penyu
**TurtleDataSeeder** - 15 temuan sarang + 31 records wilayah peneluran (2024)

### Run Seeders

```bash
php artisan db:seed --class=ArticleSeeder
php artisan db:seed --class=TurtleDataSeeder
```

### Test Accounts

```
# Admin Penangkaran
Email: admin@penangkaran.com
Password: password

# User Komunitas (buat sendiri via register)
```

---

## 🤝 Kontribusi

Kontribusi sangat diterima! Silakan:

1. Fork project ini
2. Buat branch fitur (`git checkout -b feature/AmazingFeature`)
3. Commit perubahan (`git commit -m 'Add some AmazingFeature'`)
4. Push ke branch (`git push origin feature/AmazingFeature`)
5. Buat Pull Request

---

## 📝 TODO / Future Enhancements

-   [ ] Export data ke Excel/PDF
-   [ ] Email notifications untuk temuan baru
-   [ ] Dashboard analytics lebih detail
-   [ ] Mobile app (Flutter/React Native)
-   [ ] API REST untuk integrasi
-   [ ] Multi-language support
-   [ ] Dark mode
-   [ ] Advanced search & filters
-   [ ] User reputation system
-   [ ] Volunteer management

---

## 📄 Lisensi

Project ini dikembangkan untuk keperluan akademik dan konservasi penyu di Cilacap.

---

## 🙏 Acknowledgments

-   Tim Penangkaran Penyu Cilacap
-   Komunitas konservasi penyu Indonesia
-   Laravel Community
-   Bootstrap & Font Awesome

---

**🐢 Mari bersama-sama menjaga kelestarian penyu Indonesia! 🌊**

---

_Last Updated: November 2024_
