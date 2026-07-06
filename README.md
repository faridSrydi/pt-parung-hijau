# 🌿 PT Parung Hijau Perkasa — Sistem Informasi Agribisnis

Sistem informasi berbasis web untuk PT Parung Hijau Perkasa, perusahaan agribisnis terintegrasi yang bergerak di bidang perkebunan, peternakan, perikanan, dan pengolahan limbah organik. Dibangun menggunakan framework **CodeIgniter 4** dengan arsitektur MVC.

---

## 📋 Daftar Isi

- [Fitur Utama](#-fitur-utama)
- [Tech Stack](#-tech-stack)
- [Prasyarat](#-prasyarat)
- [Cara Setup](#-cara-setup-di-device-baru)
- [Struktur Folder](#-struktur-folder)
- [Akun Default](#-akun-default)
- [Kontributor](#-kontributor)

---

## ✨ Fitur Utama

| Modul | Deskripsi |
|---|---|
| **Frontend Public** | Landing page, katalog produk, detail unit bisnis, halaman checkout |
| **Dashboard Admin** | Kelola produk, unit bisnis, akun pengguna, supir, transaksi, dan laporan ekspor |
| **Dashboard Produksi** | Input & riwayat data panen per unit bisnis |
| **Dashboard Distribusi** | Manajemen pengiriman barang dan cetak resi |
| **Dashboard Pelanggan** | Riwayat pesanan, kelola alamat pengiriman, upload bukti bayar |
| **Autentikasi** | Login & register dengan sistem role (Admin, Produksi, Distribusi, Pelanggan) |

---

## 🛠 Tech Stack

- **Backend**: PHP 8.2+, CodeIgniter 4.7
- **Database**: MySQL / MariaDB
- **Frontend**: HTML5, Vanilla CSS, Vanilla JavaScript
- **Server Lokal**: Laragon / XAMPP / MAMP

---

## 📌 Prasyarat

Pastikan perangkat kamu sudah terinstal software berikut:

| Software | Versi Minimum | Keterangan |
|---|---|---|
| **PHP** | 8.2 | Termasuk ekstensi `intl`, `mbstring`, `json`, `mysqlnd` |
| **Composer** | 2.x | Dependency manager untuk PHP |
| **MySQL / MariaDB** | 5.7+ / 10.4+ | Database server |
| **Git** | 2.x | Version control |
| **Laragon** *(Rekomendasi)* | 6.x | Sudah termasuk PHP, MySQL, dan Apache |

---

## 🚀 Cara Setup di Device Baru

### 1. Clone Repository

```bash
git clone https://github.com/faridSrydi/pt-parung-hijau.git
cd pt-parung-hijau
```

### 2. Install Dependensi PHP (Composer)

```bash
composer install
```

### 3. Konfigurasi Environment

Salin file `env` menjadi `.env`, lalu sesuaikan konfigurasi database:

```bash
copy env .env
```

Buka file `.env` menggunakan text editor, lalu ubah bagian berikut sesuai konfigurasi lokal kamu:

```ini
CI_ENVIRONMENT = development

app.baseURL = 'http://localhost:8080/'

database.default.hostname = localhost
database.default.database = pt_parung_hijau_db
database.default.username = root
database.default.password =
database.default.DBDriver = MySQLi
database.default.port = 3306
```

> **Catatan:** Sesuaikan `app.baseURL` dengan port yang kamu gunakan. Jika menggunakan Laragon dengan Apache, biasanya cukup `http://pt_parung_hijau.test/`.

### 4. Buat Database

Buat database baru di MySQL dengan nama `pt_parung_hijau_db`:

```sql
CREATE DATABASE pt_parung_hijau_db CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
```

Atau bisa juga menggunakan phpMyAdmin / HeidiSQL / DBeaver.

### 5. Jalankan Migrasi Database

Perintah ini akan membuat seluruh tabel yang dibutuhkan secara otomatis:

```bash
php spark migrate --all
```

### 6. Jalankan Seeder (Data Awal)

Perintah ini akan mengisi seluruh data awal (user default, unit bisnis, produk, supir, panen, dan transaksi contoh) secara otomatis:

```bash
php spark db:seed DatabaseSeeder
```

### 7. Import Data SQL *(Opsional)*

Jika ingin langsung menggunakan dump database lengkap (termasuk data transaksi contoh), import file SQL yang tersedia:

```bash
mysql -u root pt_parung_hijau_db < schema_dump.sql
```

Atau import file `schema_dump.sql` melalui phpMyAdmin.

### 8. Jalankan Server Lokal

```bash
php spark serve --host 0.0.0.0 --port 8080
```

Buka browser dan akses: **http://localhost:8080**

---

## 📁 Struktur Folder

```
pt-parung-hijau/
│
├── app/                          # Kode aplikasi utama (MVC)
│   ├── Config/                   # Konfigurasi app, routes, database
│   ├── Controllers/              # Controller (Admin, Pelanggan, Produksi, Distribusi)
│   ├── Database/
│   │   ├── Migrations/           # File migrasi per tabel
│   │   └── Seeds/                # Data seeder awal
│   ├── Models/                   # Model database (Eloquent-style)
│   └── Views/                    # Template tampilan (PHP)
│       ├── layouts/              # Layout utama (front, admin, auth)
│       ├── dashboard/            # Halaman dashboard per role
│       └── auth/                 # Halaman login & register
│
├── public/                       # Document root (diakses langsung oleh browser)
│   ├── assets/                   # Asset statis bawaan tema (MASUK GIT)
│   │   ├── css/                  # front-styles.css, admin-styles.css
│   │   ├── js/                   # front-app.js, admin-app.js
│   │   ├── images/               # Gambar statis (logo, hero, placeholder produk)
│   │   └── videos/               # Video latar belakang
│   ├── uploads/                  # File unggahan dinamis (TIDAK MASUK GIT)
│   │   ├── produk/               # Foto produk hasil upload admin
│   │   └── unit/                 # Foto unit bisnis hasil upload admin
│   └── dash/                     # Template dashboard HTML statis (referensi)
│
├── writable/                     # Cache, log, session (auto-generated)
├── .env                          # Konfigurasi environment (TIDAK MASUK GIT)
├── .gitignore                    # Daftar file/folder yang diabaikan Git
├── composer.json                 # Dependensi PHP
├── schema_dump.sql               # Dump database lengkap
└── spark                         # CLI tool CodeIgniter
```

---

## 🔑 Akun Default

Setelah melakukan seeding atau import SQL, gunakan akun berikut untuk login:

| Role | Username | Email | Password |
|---|---|---|---|
| **Admin** | `admin_test` | `admin@test.com` | `password123` |
| **Produksi** | `produksi_test` | `produksi@test.com` | `password123` |
| **Distribusi** | `distribusi_test` | `distribusi@test.com` | `password123` |
| **Pelanggan** | `pelanggan_test` | `pelanggan@test.com` | `password123` |

> ⚠️ **Penting:** Akun di atas tersedia setelah menjalankan `php spark db:seed DatabaseSeeder` pada langkah ke-6.

---

## 👥 Kontributor

| Nama |
|---|
| Muhamad Faridzqi Suryadi |
| Dede Ahmad Fauzan |
| Refa Aulia |
---

## 📄 Lisensi

Proyek ini dibuat untuk keperluan akademik mata kuliah Rekayasa Perangkat Lunak di Program Studi Informatika.
