# 🚀 Setup Project TokoBunga

Panduan cepat untuk developer baru yang clone project ini.

---

## 📋 Prerequisites

Pastikan sudah terinstall:
- ✅ PHP 8.3+ dengan ekstensi cURL aktif
- ✅ Composer
- ✅ MySQL/MariaDB
- ✅ Node.js & NPM
- ✅ Laragon (jika di Windows)

---

## 🔧 Instalasi

### 1. Clone Repository

```bash
git clone <repository-url>
cd tokobunga
```

### 2. Install Dependencies PHP

```bash
composer install
```

**Catatan:** Script `patch-midtrans.php` akan **otomatis berjalan** dan memperbaiki bug Midtrans. Anda akan melihat output seperti:

```
🔧 Memperbaiki bug namespace curl...
✅ Perbaikan selesai! Total 7 perubahan.
```

### 3. Copy Environment File

```bash
copy .env.example .env
```

Atau di Git Bash/Linux:
```bash
cp .env.example .env
```

### 4. Generate Application Key

```bash
php artisan key:generate
```

### 5. Setup Database

Edit file `.env` dan sesuaikan dengan database Anda:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=tokobunga
DB_USERNAME=root
DB_PASSWORD=
```

### 6. Import Database

Import file `database/butik.sql` ke MySQL:

**Via Laragon:**
- Klik Menu → MySQL → MySQL Console
- Jalankan:
  ```sql
  CREATE DATABASE tokobunga;
  USE tokobunga;
  source C:/laragon/www/tokobunga/database/butik.sql;
  ```

**Via Command:**
```bash
mysql -u root -p tokobunga < database/butik.sql
```

### 7. Install NPM Dependencies

```bash
npm install
```

### 8. Build Assets

```bash
npm run build
```

---

## ▶️ Menjalankan Aplikasi

### Development Server

```bash
php artisan serve
```

Atau jika pakai Laragon, cukup start Laragon dan akses:
```
http://tokobunga.test
http://tokobunga.test:8080
```

### NPM Watch (untuk development)

Di terminal terpisah, jalankan:
```bash
npm run dev
```

---

## ⚠️ Troubleshooting

### Error: "Call to undefined function Midtrans\curl_init()"

**Solusi 1:** Jalankan patch manual
```bash
php patch-midtrans.php
php artisan config:clear
```

**Solusi 2:** Aktifkan cURL di PHP
- Buka Laragon → PHP → Extensions
- Centang "curl"
- Restart Laragon

**Solusi 3:** Pull update terbaru
```bash
git pull
composer install
```

### Error: "No application encryption key has been set"

```bash
php artisan key:generate
```

### Error: Database connection refused

Pastikan:
1. MySQL sudah running
2. Kredensial di `.env` sudah benar
3. Database `tokobunga` sudah dibuat

### Port 8080 sudah digunakan

Edit file `.env`:
```env
APP_PORT=8081
```

Atau jalankan dengan port berbeda:
```bash
php artisan serve --port=8081
```

---

## 📝 Konfigurasi Midtrans

Edit file `.env` dan isi dengan kredensial Midtrans Anda:

```env
MIDTRANS_SERVER_KEY=your-server-key
MIDTRANS_CLIENT_KEY=your-client-key
MIDTRANS_IS_PRODUCTION=false
MIDTRANS_IS_SANITIZED=true
MIDTRANS_IS_3DS=true
```

Dapatkan key di: https://dashboard.midtrans.com/

---

## 👥 User Default

Setelah import database, gunakan kredensial berikut:

### Admin
- Email: `admin@tokobunga.com`
- Password: `password`

### Customer
- Buat akun baru via register

### Kurir
- Email: `kurir@tokobunga.com`
- Password: `password`

---

## 📚 Dokumentasi Tambahan

- **Perbaikan Bug Midtrans:** Lihat `PERBAIKAN_MIDTRANS.md`
- **Laravel Docs:** https://laravel.com/docs
- **Midtrans Docs:** https://docs.midtrans.com

---

## 🤝 Team Workflow

### Pull Latest Changes

```bash
git pull
composer install    # Patch akan otomatis berjalan
php artisan config:clear
```

### Push Changes

```bash
git add .
git commit -m "your message"
git push
```

---

## ❓ Bantuan

Jika masih ada masalah, hubungi team lead atau buka issue di repository.

---

**Happy Coding! 🌸**
