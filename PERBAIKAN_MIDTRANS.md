# Perbaikan Error Midtrans - curl_init()

## Masalah
Error: `Call to undefined function Midtrans\curl_init()`

## Penyebab
Library Midtrans PHP v2.6.2 memiliki bug dimana fungsi-fungsi curl dipanggil tanpa backslash `\` di depannya. Karena file `ApiRequestor.php` berada dalam namespace `Midtrans`, PHP mencari fungsi `curl_init()` di namespace `Midtrans\curl_init()` bukan di global namespace `\curl_init()`.

## Solusi
File yang diperbaiki: `vendor/midtrans/midtrans-php/Midtrans/ApiRequestor.php`

### Fungsi yang diperbaiki:
1. `curl_init()` → `\curl_init()`
2. `curl_setopt()` → `\curl_setopt()`
3. `curl_setopt_array()` → `\curl_setopt_array()`
4. `curl_exec()` → `\curl_exec()`
5. `curl_error()` → `\curl_error()`
6. `curl_errno()` → `\curl_errno()`
7. `curl_getinfo()` → `\curl_getinfo()`

## PENTING!
⚠️ **Jangan jalankan `composer update midtrans/midtrans-php`** karena akan menimpa perubahan ini!

Jika terpaksa update library, ulangi perbaikan ini dengan menambahkan backslash `\` di depan semua fungsi curl di file `ApiRequestor.php`.

## Alternatif (Solusi Permanen)
Jika ingin solusi yang tidak hilang saat update composer, buat wrapper custom atau tunggu sampai bug ini diperbaiki oleh Midtrans di versi berikutnya.

## Tanggal Perbaikan
17 Juni 2026

## Status
✅ Sudah diperbaiki dan berhasil
