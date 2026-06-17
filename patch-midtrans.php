#!/usr/bin/env php
<?php
/**
 * Script untuk memperbaiki bug Midtrans PHP Library
 * Bug: fungsi curl dipanggil tanpa backslash di namespace Midtrans
 * 
 * Jalankan script ini setiap kali setelah composer install/update
 * Atau tambahkan ke composer.json sebagai post-install-cmd
 */

$file = __DIR__ . '/vendor/midtrans/midtrans-php/Midtrans/ApiRequestor.php';

if (!file_exists($file)) {
    echo "❌ File ApiRequestor.php tidak ditemukan!\n";
    echo "   Pastikan package midtrans/midtrans-php sudah terinstall.\n";
    echo "   Jalankan: composer install\n";
    exit(1);
}

echo "🔍 Memeriksa file Midtrans ApiRequestor.php...\n";

$content = file_get_contents($file);

// Cek apakah sudah diperbaiki
if (strpos($content, '\curl_init()') !== false) {
    echo "✅ File sudah diperbaiki sebelumnya. Tidak ada yang perlu dilakukan.\n";
    exit(0);
}

echo "🔧 Memperbaiki bug namespace curl...\n";

// Daftar fungsi curl yang perlu diperbaiki
$replacements = [
    'curl_init()' => '\curl_init()',
    'curl_setopt(' => '\curl_setopt(',
    'curl_setopt_array(' => '\curl_setopt_array(',
    'curl_exec(' => '\curl_exec(',
    'curl_error(' => '\curl_error(',
    'curl_errno(' => '\curl_errno(',
    'curl_getinfo(' => '\curl_getinfo(',
    // 'curl_close(' => '\curl_close(', // Sudah di-comment di original
];

$totalReplacements = 0;

foreach ($replacements as $old => $new) {
    $count = 0;
    $content = str_replace($old, $new, $content, $count);
    $totalReplacements += $count;
    if ($count > 0) {
        echo "   - Memperbaiki {$old}: {$count} kali\n";
    }
}

if ($totalReplacements > 0) {
    // Backup file original
    $backupFile = $file . '.backup';
    if (!file_exists($backupFile)) {
        copy($file, $backupFile);
        echo "💾 Backup dibuat: {$backupFile}\n";
    }
    
    // Tulis file yang sudah diperbaiki
    file_put_contents($file, $content);
    echo "✅ Perbaikan selesai! Total {$totalReplacements} perubahan.\n";
    echo "\n";
    echo "📝 Catatan:\n";
    echo "   - File original di-backup ke: ApiRequestor.php.backup\n";
    echo "   - Jalankan script ini lagi setiap kali composer update\n";
} else {
    echo "⚠️  Tidak ada yang diperbaiki. Mungkin file sudah benar atau formatnya berbeda.\n";
}

exit(0);
