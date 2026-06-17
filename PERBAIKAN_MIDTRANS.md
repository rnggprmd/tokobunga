# Perbaikan Error Midtrans - curl_init()

## Masalah
Error: `Call to undefined function Midtrans\curl_init()`

## Penyebab
Library Midtrans PHP v2.6.2 memiliki bug dimana fungsi-fungsi curl dipanggil tanpa backslash `\` di depannya. Karena file `ApiRequestor.php` berada dalam namespace `Midtrans`, PHP mencari fungsi `curl_init()` di namespace `Midtrans\curl_init()` bukan di global namespace `\curl_init()`.

## Solusi OTOMATIS ✅ (Recommended)

### Untuk Developer Baru / Teman yang Clone Project:

1. **Clone repository** (jika belum):
   ```bash
   git clone <repository-url>
   cd tokobunga
   ```

2. **Install dependencies**:
   ```bash
   composer install
   ```
   
   Script `patch-midtrans.php` akan **otomatis dijalankan** setelah `composer install` selesai dan akan memperbaiki bug Midtrans.

3. **Jika masih error**, jalankan manual:
   ```bash
   php patch-midtrans.php
   ```

4. **Clear cache Laravel**:
   ```bash
   php artisan config:clear
   php artisan cache:clear
   php artisan view:clear
   ```

5. **Refresh browser** dan coba lagi.

### Apa yang Dilakukan Script Otomatis?

File `patch-midtrans.php` akan:
- ✅ Otomatis memeriksa file `vendor/midtrans/midtrans-php/Midtrans/ApiRequestor.php`
- ✅ Mendeteksi apakah sudah diperbaiki atau belum
- ✅ Memperbaiki semua fungsi curl dengan menambahkan backslash `\`
- ✅ Membuat backup file original ke `ApiRequestor.php.backup`
- ✅ Dijalankan otomatis setiap kali `composer install` atau `composer update`

---

## Solusi MANUAL (Jika Script Gagal)

File yang diperbaiki: `vendor/midtrans/midtrans-php/Midtrans/ApiRequestor.php`

### Fungsi yang diperbaiki:
1. `curl_init()` → `\curl_init()`
2. `curl_setopt()` → `\curl_setopt()`
3. `curl_setopt_array()` → `\curl_setopt_array()`
4. `curl_exec()` → `\curl_exec()`
5. `curl_error()` → `\curl_error()`
6. `curl_errno()` → `\curl_errno()`
7. `curl_getinfo()` → `\curl_getinfo()`

### Cara Manual:
1. Buka file: `vendor/midtrans/midtrans-php/Midtrans/ApiRequestor.php`
2. Cari semua fungsi curl yang disebutkan di atas
3. Tambahkan backslash `\` di depan setiap fungsi curl
4. Save file

---

## Catatan Penting

### ⚠️ Jangan Lupa!
- Script `patch-midtrans.php` **sudah ditambahkan** ke `composer.json`
- Akan **otomatis berjalan** setiap `composer install` atau `composer update`
- **Commit file** `patch-midtrans.php` dan `composer.json` ke Git

### 📁 File yang Perlu di-Commit ke Git:
```
✅ patch-midtrans.php          (script perbaikan otomatis)
✅ composer.json                (sudah ada hook otomatis)
✅ PERBAIKAN_MIDTRANS.md       (dokumentasi ini)
❌ vendor/                      (jangan di-commit, sudah ada di .gitignore)
```

### 🔄 Workflow untuk Team:

**Developer A (Anda):**
```bash
git add patch-midtrans.php composer.json PERBAIKAN_MIDTRANS.md
git commit -m "fix: tambah patch otomatis untuk bug Midtrans curl"
git push
```

**Developer B (Teman):**
```bash
git pull
composer install    # Script patch akan otomatis berjalan
```

---

## Testing

Untuk memastikan perbaikan berhasil:

```bash
# Jalankan script manual
php patch-midtrans.php

# Clear cache
php artisan config:clear
php artisan cache:clear

# Test checkout di browser
# Buka: http://tokobunga.test:8080/checkout
```

---

## Troubleshooting

### Jika masih error setelah patch:

1. **Cek apakah cURL extension aktif:**
   ```bash
   php -m | findstr curl
   ```
   Harus muncul: `curl`

2. **Jalankan patch manual:**
   ```bash
   php patch-midtrans.php
   ```

3. **Cek isi file ApiRequestor.php:**
   Baris 68 harus berisi `\curl_init()` (dengan backslash)

4. **Restart Laragon/Apache:**
   - Klik kanan icon Laragon
   - Pilih "Stop All"
   - Kemudian "Start All"

---

## Alternatif Solusi (Jika Script Tidak Bekerja)

Jika script patch tidak bekerja sama sekali, bisa gunakan wrapper custom atau tunggu update dari Midtrans.

---

## Changelog

### 17 Juni 2026
- ✅ Bug ditemukan dan diperbaiki manual
- ✅ Script otomatis `patch-midtrans.php` dibuat
- ✅ Hook otomatis ditambahkan ke `composer.json`
- ✅ Dokumentasi lengkap dibuat

## Status
✅ **Sudah diperbaiki dan berfungsi dengan patch otomatis**
