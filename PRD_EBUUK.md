# PRD — ebuuk.id

**Versi:** 1.1
**Tanggal:** Mei 2026
**Status:** Active Development

### Changelog
| Versi | Perubahan |
|-------|-----------|
| 1.0 | Dokumen awal |
| 1.1 | Update tech stack: Laravel + Inertia.js + Vue 3 + Tailwind CSS |

---

## 1. Tentang ebuuk.id

**ebuuk.id** adalah platform ebook reader online berbasis web yang memungkinkan pengguna membaca buku digital (PDF) langsung di browser tanpa perlu mengunduh aplikasi tambahan. Platform ini menyediakan katalog buku yang dapat diakses secara gratis oleh siapa saja yang telah mendaftar.

### Visi:
Menjadi platform baca buku digital yang mudah diakses, ringan, dan nyaman digunakan oleh siapa saja di Indonesia.

### Misi:
- Menyediakan koleksi buku digital berkualitas yang dapat dibaca secara online
- Memberikan pengalaman membaca yang nyaman langsung di browser
- Memudahkan pengelolaan dan distribusi konten buku digital

---

## 2. Latar Belakang Project

Kebutuhan membaca buku digital semakin tinggi, namun banyak platform ebook yang mengharuskan pengguna mengunduh aplikasi khusus atau membayar langganan mahal. ebuuk.id hadir sebagai alternatif yang ringan, berbasis web, dan sepenuhnya gratis — cukup daftar dan langsung bisa membaca.

---

## 3. Tujuan Project

1. Membangun platform baca buku digital berbasis web yang ringan dan mudah digunakan
2. Menyediakan PDF reader online yang aman — buku hanya bisa dibaca, tidak bisa diunduh
3. Menyediakan fitur personal untuk pengguna: rak buku dan riwayat bacaan
4. Menyediakan panel admin untuk mengelola katalog buku
5. Memberikan pengalaman SPA (Single Page Application) yang smooth dan nyaman

---

## 4. Pengguna Sistem

### 4.1 Pengunjung (Belum Login)
- Siapa saja yang mengakses website
- Dapat melihat landing page, katalog buku, dan detail buku
- **Tidak bisa membaca buku** — harus login terlebih dahulu
- Dapat mendaftar akun baru

### 4.2 User (Sudah Login)
- Pengguna yang sudah memiliki akun dan login
- Dapat membaca semua buku secara penuh
- Dapat menyimpan buku ke Rak Buku (bookmark)
- Dapat melihat riwayat bacaan
- Semua fitur **gratis** tanpa pembayaran

### 4.3 Admin
- Staf internal yang mengelola konten platform
- Akses via `/admin/login` — tidak ada tombol login admin di halaman publik
- Mengelola katalog buku, kategori, dan user

---

## 5. Fitur Sistem

### 5.1 Public Side (Tanpa Login)

#### A. Landing Page (`/`)
- Hero section — headline, subheadline, tombol CTA "Mulai Membaca" → /daftar
- Section keunggulan platform — gratis, online, mudah
- Section buku terbaru — preview cover dan judul
- Section kategori populer
- Footer — navigasi, kontak

#### B. Katalog Buku (`/katalog`)
- Grid semua buku yang tersedia
- Filter berdasarkan kategori
- Search buku (judul, penulis)
- Setiap card buku: cover, judul, penulis, kategori
- Klik buku → halaman detail buku

#### C. Detail Buku (`/buku/{slug}`)
- Cover buku besar
- Informasi lengkap: judul, penulis, deskripsi, kategori, jumlah halaman
- Tombol **"Baca Sekarang"**:
  - Jika belum login → redirect ke halaman login
  - Jika sudah login → buka reader

#### D. Register (`/daftar`)
- Form: nama, email, password, konfirmasi password
- Setelah daftar → auto login → redirect ke katalog

#### E. Login (`/masuk`)
- Form: email, password
- Setelah login → redirect ke halaman sebelumnya atau katalog

---

### 5.2 User Side (Sudah Login)

#### A. Reader Buku (`/baca/{slug}`)
- PDF reader fullscreen menggunakan **PDF.js**
- Fitur reader:
  - Navigasi halaman (prev/next, input nomor halaman)
  - Zoom in/out
  - Mode layar penuh
- **Proteksi konten:**
  - File PDF tidak bisa diakses langsung via URL
  - Tidak ada tombol download
  - File disimpan di `storage/app/private/ebooks/`
  - Distream via Laravel controller yang cek autentikasi
- Simpan progress otomatis (halaman terakhir dibaca) via Inertia/axios

#### B. Rak Buku (`/rak-buku`)
- Daftar buku yang disimpan user
- Tombol "Hapus dari Rak" per buku
- Klik buku → langsung ke reader

#### C. Riwayat Bacaan (`/riwayat`)
- Daftar buku yang pernah dibaca
- Info halaman terakhir dibaca
- Tombol "Lanjut Baca" → buka reader di halaman terakhir

#### D. Profil (`/profil`)
- Info akun: nama, email
- Ubah nama dan password
- Statistik: jumlah buku dibaca, buku di rak

---

### 5.3 Admin Side

#### A. Login Admin (`/admin/login`)
- Form email + password
- Session-based custom (terpisah dari auth user)
- Tidak ada link di halaman publik

#### B. Dashboard (`/admin/dashboard`)
- Stat card: Total Buku, Total User, Total Kategori
- Buku terbaru yang ditambahkan
- User terbaru yang mendaftar

#### C. Manajemen Buku (`/admin/buku`)
- Tabel: No, Cover, Judul, Penulis, Kategori, Halaman, Aksi
- Search + pagination
- CRUD lengkap
- Form tambah/edit buku:
  - Cover: upload JPG/PNG/WEBP maks 2MB → `public/images/covers/`
  - File PDF: upload PDF maks 50MB → `storage/app/private/ebooks/`
  - Judul (wajib), Slug (auto-generate)
  - Penulis
  - Deskripsi (textarea)
  - Kategori (dropdown)
  - Jumlah halaman (input manual)
- Hapus buku → file cover dan PDF ikut terhapus

#### D. Manajemen Kategori (`/admin/kategori`)
- CRUD kategori
- Tabel: No, Nama, Slug, Jumlah Buku, Aksi
- Kategori tidak bisa dihapus jika masih ada buku

#### E. Manajemen User (`/admin/user`)
- Tabel: No, Nama, Email, Tanggal Daftar, Aksi
- Search user
- Lihat detail aktivitas user
- Hapus user

#### F. Pengaturan (`/admin/pengaturan`)
- Ubah password admin

---

## 6. Struktur Database

### Tabel: `users`

| Kolom | Tipe | Keterangan |
|-------|------|------------|
| id | bigint PK | Auto increment |
| name | varchar | Nama lengkap |
| email | varchar, unique | Email login |
| password | varchar | Hashed bcrypt |
| email_verified_at | timestamp, nullable | — |
| remember_token | varchar, nullable | — |
| created_at | timestamp | — |
| updated_at | timestamp | — |

### Tabel: `kategori`

| Kolom | Tipe | Keterangan |
|-------|------|------------|
| id | bigint PK | Auto increment |
| nama | varchar | Nama kategori |
| slug | varchar, unique | Auto-generate |
| created_at | timestamp | — |
| updated_at | timestamp | — |

### Tabel: `buku`

| Kolom | Tipe | Keterangan |
|-------|------|------------|
| id | bigint PK | Auto increment |
| judul | varchar | Wajib |
| slug | varchar, unique | Auto-generate dari judul |
| cover | varchar, nullable | → public/images/covers/ |
| file_pdf | varchar | → storage/app/private/ebooks/ |
| penulis | varchar, nullable | Nama penulis |
| deskripsi | text, nullable | Sinopsis |
| kategori_id | bigint FK, nullable | → kategori.id (set null) |
| halaman | integer, nullable | Jumlah halaman |
| created_at | timestamp | — |
| updated_at | timestamp | — |

### Tabel: `rak_buku`

| Kolom | Tipe | Keterangan |
|-------|------|------------|
| id | bigint PK | Auto increment |
| user_id | bigint FK | → users.id (cascade delete) |
| buku_id | bigint FK | → buku.id (cascade delete) |
| created_at | timestamp | — |
| updated_at | timestamp | — |

Unique: `(user_id, buku_id)`

### Tabel: `riwayat_baca`

| Kolom | Tipe | Keterangan |
|-------|------|------------|
| id | bigint PK | Auto increment |
| user_id | bigint FK | → users.id (cascade delete) |
| buku_id | bigint FK | → buku.id (cascade delete) |
| halaman_terakhir | integer, default 1 | Progress bacaan |
| created_at | timestamp | — |
| updated_at | timestamp | — |

Unique: `(user_id, buku_id)`

### Tabel: `admins`

| Kolom | Tipe | Keterangan |
|-------|------|------------|
| id | bigint PK | Auto increment |
| name | varchar | Nama admin |
| email | varchar, unique | Email login |
| password | varchar | Hashed bcrypt |
| created_at | timestamp | — |
| updated_at | timestamp | — |

### Relasi
```
kategori (1) ──── (N) buku
users    (1) ──── (N) rak_buku    ──── (N) buku
users    (1) ──── (N) riwayat_baca ─── (N) buku
```

---

## 7. Tech Stack

| Layer | Teknologi |
|-------|-----------|
| Backend | Laravel (PHP) |
| Frontend | Inertia.js + Vue 3 + Tailwind CSS v3 |
| PDF Reader | PDF.js (Mozilla, open source, via CDN) |
| Database | MySQL |
| Auth User | Laravel Breeze (Inertia + Vue starter kit) |
| Auth Admin | Session manual (custom, terpisah dari auth user) |
| Build Tool | Vite |
| Font | Inter (Google Fonts) |
| Server dev | Laragon — ebuuk.test |
| Repo | https://github.com/MalikSae/ebuuk.git |

### Kenapa Inertia.js + Vue 3:
- SPA feel — navigasi smooth tanpa full page reload
- Tetap pakai Laravel di backend — tidak perlu buat REST API terpisah
- Vue 3 + Inertia adalah kombinasi paling matang di ekosistem Laravel
- PDF Reader lebih mudah dikelola state-nya dengan Vue component
- Build dengan Vite → file statis → deploy ke Hostinger shared hosting tetap bisa

---

## 8. Arsitektur Inertia.js

Inertia.js menggantikan Blade views untuk halaman publik dan user. Cara kerjanya:

```
Request browser
    ↓
Laravel Router → Controller
    ↓
Inertia::render('NamaPage', ['data' => $data])
    ↓
Vue Component (resources/js/Pages/NamaPage.vue)
    ↓
Render di browser (SPA, no full reload)
```

**Yang tetap pakai Blade:**
- Admin panel (`/admin/*`) — tetap Blade + Tailwind biasa (lebih simpel untuk CRUD)

**Yang pakai Inertia + Vue:**
- Semua halaman publik dan user

---

## 9. Struktur Routing

```
PUBLIC & USER (Inertia):
GET  /                      → LandingController → Pages/Landing.vue
GET  /katalog               → BukuController@index → Pages/Katalog.vue
GET  /buku/{slug}           → BukuController@show → Pages/DetailBuku.vue
GET  /daftar                → AuthController@showRegister → Pages/Auth/Register.vue
POST /daftar                → AuthController@register
GET  /masuk                 → AuthController@showLogin → Pages/Auth/Login.vue
POST /masuk                 → AuthController@login
POST /keluar                → AuthController@logout

USER (middleware 'auth'):
GET  /baca/{slug}           → ReaderController@show → Pages/Reader.vue
POST /baca/{slug}/stream    → ReaderController@stream (stream PDF bytes, bukan Inertia)
POST /baca/{slug}/progress  → ReaderController@saveProgress (AJAX)
GET  /rak-buku              → RakBukuController@index → Pages/RakBuku.vue
POST /rak-buku/{id}         → RakBukuController@store
DELETE /rak-buku/{id}       → RakBukuController@destroy
GET  /riwayat               → RiwayatController@index → Pages/Riwayat.vue
GET  /profil                → ProfilController@index → Pages/Profil.vue
PUT  /profil                → ProfilController@update
PUT  /profil/password       → ProfilController@updatePassword

ADMIN (middleware 'admin.auth', Blade):
GET    /admin/login                  → AdminAuthController@showLogin
POST   /admin/login                  → AdminAuthController@login
POST   /admin/logout                 → AdminAuthController@logout
GET    /admin/dashboard              → AdminDashboardController@index
GET    /admin/buku                   → AdminBukuController@index
GET    /admin/buku/create            → AdminBukuController@create
POST   /admin/buku                   → AdminBukuController@store
GET    /admin/buku/{id}/edit         → AdminBukuController@edit
PUT    /admin/buku/{id}              → AdminBukuController@update
DELETE /admin/buku/{id}              → AdminBukuController@destroy
GET    /admin/kategori               → AdminKategoriController@index
GET    /admin/kategori/create        → AdminKategoriController@create
POST   /admin/kategori               → AdminKategoriController@store
GET    /admin/kategori/{id}/edit     → AdminKategoriController@edit
PUT    /admin/kategori/{id}          → AdminKategoriController@update
DELETE /admin/kategori/{id}          → AdminKategoriController@destroy
GET    /admin/user                   → AdminUserController@index
GET    /admin/user/{id}              → AdminUserController@show
DELETE /admin/user/{id}              → AdminUserController@destroy
GET    /admin/pengaturan             → AdminPengaturanController@index
PUT    /admin/pengaturan/password    → AdminPengaturanController@updatePassword
```

---

## 10. Struktur Folder

```
ebuuk/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── LandingController.php
│   │   │   ├── BukuController.php
│   │   │   ├── AuthController.php
│   │   │   ├── ReaderController.php
│   │   │   ├── RakBukuController.php
│   │   │   ├── RiwayatController.php
│   │   │   ├── ProfilController.php
│   │   │   └── Admin/
│   │   │       ├── AdminAuthController.php
│   │   │       ├── AdminDashboardController.php
│   │   │       ├── AdminBukuController.php
│   │   │       ├── AdminKategoriController.php
│   │   │       ├── AdminUserController.php
│   │   │       └── AdminPengaturanController.php
│   │   └── Middleware/
│   │       └── AdminAuth.php
│   └── Models/
│       ├── User.php
│       ├── Buku.php
│       ├── Kategori.php
│       ├── RakBuku.php
│       ├── RiwayatBaca.php
│       └── Admin.php
├── database/
│   ├── migrations/
│   └── seeders/
│       ├── AdminSeeder.php
│       └── KategoriSeeder.php
├── resources/
│   ├── js/
│   │   ├── app.js           ← Inertia entry point
│   │   ├── Pages/           ← Vue page components
│   │   │   ├── Landing.vue
│   │   │   ├── Katalog.vue
│   │   │   ├── DetailBuku.vue
│   │   │   ├── Reader.vue
│   │   │   ├── RakBuku.vue
│   │   │   ├── Riwayat.vue
│   │   │   ├── Profil.vue
│   │   │   └── Auth/
│   │   │       ├── Login.vue
│   │   │       └── Register.vue
│   │   └── Components/      ← Vue reusable components
│   │       ├── Navbar.vue
│   │       ├── Footer.vue
│   │       ├── BukuCard.vue
│   │       └── PdfReader.vue
│   └── views/
│       └── admin/           ← Blade views untuk admin panel
│           ├── login.blade.php
│           ├── dashboard.blade.php
│           ├── buku/
│           ├── kategori/
│           ├── user/
│           └── pengaturan/
├── storage/
│   └── app/
│       └── private/
│           └── ebooks/      ← file PDF (tidak bisa diakses public)
└── public/
    └── images/
        └── covers/          ← cover buku
```

---

## 11. Mekanisme Proteksi PDF

File PDF **tidak boleh** diakses langsung via URL. Mekanismenya:

1. File PDF disimpan di `storage/app/private/ebooks/` — di luar folder `public/`
2. User akses reader via `/baca/{slug}` → Vue component `Reader.vue` load
3. `Reader.vue` inisialisasi PDF.js dengan URL `/baca/{slug}/stream`
4. Laravel `ReaderController@stream`:
   - Cek session auth user → jika tidak login, return 401
   - Ambil path file dari database
   - Return response stream:
     - `Content-Type: application/pdf`
     - `Content-Disposition: inline`
5. PDF.js render PDF dari stream — tidak ada URL langsung ke file

---

## 12. Design Guidelines

- **Nama platform:** ebuuk.id
- **Tone:** Modern, bersih, fokus pada konten buku
- **Warna:** Akan ditentukan saat fase UI
- **Font:** Inter (Google Fonts)
- **Komponen:** Card-based, clean, nyaman untuk membaca
- **Responsif:** Mobile-friendly
- **Reader:** Fullscreen, minim distraksi
- **Admin panel:** Blade + Tailwind (tidak pakai Inertia/Vue)

---

## 13. Urutan Pengerjaan (Development Flow)

1. ⬜ Setup Laravel baru + install Breeze (Inertia + Vue)
2. ⬜ Konfigurasi .env + database
3. ⬜ Migration semua tabel
4. ⬜ Seeder: AdminSeeder, KategoriSeeder
5. ⬜ Model + relasi semua entitas
6. ⬜ Routes lengkap + named routes
7. ⬜ Middleware AdminAuth (custom, terpisah dari Breeze auth)
8. ⬜ Auth user: register, login, logout (Breeze)
9. ⬜ UI Admin: layout Blade (sidebar + topbar)
10. ⬜ UI Admin: login
11. ⬜ UI Admin: dashboard
12. ⬜ UI Admin: CRUD kategori
13. ⬜ UI Admin: CRUD buku + upload PDF + cover
14. ⬜ UI Admin: manajemen user
15. ⬜ UI Admin: pengaturan
16. ⬜ PDF Stream Controller (proteksi file)
17. ⬜ Vue: Layout (Navbar + Footer)
18. ⬜ Vue: Landing page
19. ⬜ Vue: Katalog + search + filter kategori
20. ⬜ Vue: Detail buku
21. ⬜ Vue: Reader (PDF.js + Vue component)
22. ⬜ Vue: Rak buku
23. ⬜ Vue: Riwayat bacaan + save progress
24. ⬜ Vue: Profil
25. ⬜ Testing menyeluruh
26. ⬜ Build production + deploy ke Hostinger

---

## 14. Catatan Penting untuk Developer

- **Inertia.js hanya untuk halaman publik & user** — admin panel tetap Blade biasa
- **File PDF di `storage/app/private/`** — BUKAN di `public/`, tidak bisa diakses langsung
- **Stream PDF via controller** yang wajib cek auth sebelum kirim bytes
- **Content-Disposition: inline** — bukan attachment, mencegah download
- **PDF.js via CDN** — tidak perlu install npm package
- **Vue Pages** ada di `resources/js/Pages/` — ini yang dirender Inertia
- **Vue Components** ada di `resources/js/Components/` — reusable UI components
- **Admin auth terpisah** dari user auth — session manual `session(['admin_id'])`
- **User auth** menggunakan Laravel Breeze bawaan
- **Slug auto-generate** dari judul, unik, regenerate jika judul berubah
- **Kategori tidak bisa dihapus** jika masih ada buku terkait
- **Hapus buku** → file PDF dan cover ikut terhapus
- **Save progress** via axios POST saat user ganti halaman di reader
- **Build production**: `npm run build` → `git add -f public/build` → push → deploy
- Semua teks konten **Bahasa Indonesia**

---

## 15. Informasi Deployment

**SSH:**
`ssh -p 65002 u585715077@145.79.14.106`

**Set PHP version:**
export PATH=/opt/alt/php83/usr/bin:$PATH

**Domain:**
https://ebuuk.msae.web.id

**Direktori Server:**
`/home/u585715077/domains/msae.web.id/public_html/ebuuk`

