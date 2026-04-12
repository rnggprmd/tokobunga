<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductVariant;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Admin User
        User::updateOrCreate(
            ['email' => 'admin@tokobunga.com'],
            [
                'name' => 'Admin',
                'password' => Hash::make('password'),
                'role' => 'admin',
            ]
        );

        // Customer User
        User::updateOrCreate(
            ['email' => 'user@tokobunga.com'],
            [
                'name' => 'User',
                'password' => Hash::make('password'),
                'role' => 'customer',
            ]
        );

        // Categories
        $bunga = Category::updateOrCreate(
            ['nama_kategori' => 'Bunga'],
            ['deskripsi' => 'Berbagai jenis bunga segar untuk kebutuhan upacara dan dekorasi']
        );

        $pernikahan = Category::updateOrCreate(
            ['nama_kategori' => 'Alat Pernikahan (Tradisi Adat Jawa)'],
            ['deskripsi' => 'Perlengkapan pernikahan tradisional adat Jawa']
        );

        $kematian = Category::updateOrCreate(
            ['nama_kategori' => 'Alat-alat Kematian'],
            ['deskripsi' => 'Perlengkapan untuk upacara pemakaman dan duka cita']
        );

        // === BUNGA ===
        $kantil = Product::updateOrCreate(
            ['nama_produk' => 'Bunga Kantil'],
            [
                'category_id' => $bunga->id,
                'deskripsi' => 'Bunga kantil segar, dijual per biji. Bunga khas Jawa yang harum dan sering digunakan untuk upacara adat.',
                'harga' => 2000,
                'stok' => 500,
                'tipe_produk' => 'ready',
            ]
        );
        ProductVariant::updateOrCreate(
            ['product_id' => $kantil->id, 'size' => 'Per Biji'],
            ['stock' => 500, 'price_adjustment' => 2000]
        );

        $tabur = Product::updateOrCreate(
            ['nama_produk' => 'Bunga Tabur Makam'],
            [
                'category_id' => $bunga->id,
                'deskripsi' => 'Campuran bunga tabur untuk ziarah makam, harum dan segar.',
                'harga' => 5000,
                'stok' => 200,
                'tipe_produk' => 'ready',
            ]
        );
        ProductVariant::updateOrCreate(
            ['product_id' => $tabur->id, 'size' => 'Per Bungkus'],
            ['stock' => 200, 'price_adjustment' => 5000]
        );

        $kenanga = Product::updateOrCreate(
            ['nama_produk' => 'Bunga Kenanga'],
            [
                'category_id' => $bunga->id,
                'deskripsi' => 'Bunga kenanga berkualitas, dijual per kilogram. Cocok untuk upacara dan pembuatan minyak atsiri.',
                'harga' => 35000,
                'stok' => 50,
                'tipe_produk' => 'ready',
            ]
        );
        ProductVariant::updateOrCreate(
            ['product_id' => $kenanga->id, 'size' => 'Per Kg'],
            ['stock' => 50, 'price_adjustment' => 35000]
        );

        // === ALAT PERNIKAHAN ===
        $janur = Product::updateOrCreate(
            ['nama_produk' => 'Janur Kuning'],
            [
                'category_id' => $pernikahan->id,
                'deskripsi' => 'Janur kuning untuk dekorasi pernikahan adat Jawa. Segar dan sudah dibentuk siap pakai.',
                'harga' => 45000,
                'stok' => 30,
                'tipe_produk' => 'ready',
            ]
        );
        ProductVariant::updateOrCreate(
            ['product_id' => $janur->id, 'size' => 'Per Set'],
            ['stock' => 30, 'price_adjustment' => 45000]
        );

        $sambung = Product::updateOrCreate(
            ['nama_produk' => 'Sambung Tuwuh'],
            [
                'category_id' => $pernikahan->id,
                'deskripsi' => 'Paket lengkap perlengkapan Sambung Tuwuh untuk upacara pernikahan adat Jawa, dijual per pasang.',
                'harga' => 1700000,
                'stok' => 10,
                'tipe_produk' => 'ready',
            ]
        );
        ProductVariant::updateOrCreate(
            ['product_id' => $sambung->id, 'size' => 'Per Pasang'],
            ['stock' => 10, 'price_adjustment' => 1700000]
        );

        // === ALAT KEMATIAN ===
        $paketKematian = Product::updateOrCreate(
            ['nama_produk' => 'Alat Kematian (Paket)'],
            [
                'category_id' => $kematian->id,
                'deskripsi' => 'Paket lengkap alat-alat kematian termasuk perlengkapan memandikan, mengkafani, dan pemakaman.',
                'harga' => 400000,
                'stok' => 20,
                'tipe_produk' => 'ready',
            ]
        );
        ProductVariant::updateOrCreate(
            ['product_id' => $paketKematian->id, 'size' => 'Per Paket'],
            ['stock' => 20, 'price_adjustment' => 400000]
        );

        $tikar = Product::updateOrCreate(
            ['nama_produk' => 'Tikar'],
            [
                'category_id' => $kematian->id,
                'deskripsi' => 'Tikar untuk keperluan upacara pemakaman.',
                'harga' => 60000,
                'stok' => 50,
                'tipe_produk' => 'ready',
            ]
        );
        ProductVariant::updateOrCreate(
            ['product_id' => $tikar->id, 'size' => 'Per Lembar'],
            ['stock' => 50, 'price_adjustment' => 60000]
        );

        $kafan = Product::updateOrCreate(
            ['nama_produk' => 'Kain Kafan'],
            [
                'category_id' => $kematian->id,
                'deskripsi' => 'Kain kafan putih berkualitas, dijual per meter.',
                'harga' => 25000,
                'stok' => 100,
                'tipe_produk' => 'ready',
            ]
        );
        ProductVariant::updateOrCreate(
            ['product_id' => $kafan->id, 'size' => 'Per Meter'],
            ['stock' => 100, 'price_adjustment' => 25000]
        );
    }
}
