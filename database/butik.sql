-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Apr 10, 2026 at 02:52 PM
-- Server version: 8.0.30
-- PHP Version: 8.3.21

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `butik`
--

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cache`
--

INSERT INTO `cache` (`key`, `value`, `expiration`) VALUES
('laravel-cache-livewire-rate-limiter:a17961fa74e9275d529f489537f179c05d50c2f3', 'i:1;', 1775807702),
('laravel-cache-livewire-rate-limiter:a17961fa74e9275d529f489537f179c05d50c2f3:timer', 'i:1775807702;', 1775807702);

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` bigint UNSIGNED NOT NULL,
  `nama_kategori` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `deskripsi` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `nama_kategori`, `deskripsi`, `created_at`, `updated_at`) VALUES
(1, 'Pakaian Pria', NULL, '2025-11-27 19:11:51', '2025-11-27 19:11:51'),
(2, 'Pakaian Wanita', NULL, '2025-12-21 06:34:59', '2025-12-21 06:34:59');

-- --------------------------------------------------------

--
-- Table structure for table `custom_requests`
--

CREATE TABLE `custom_requests` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `produk_id` bigint UNSIGNED DEFAULT NULL,
  `foto_referensi` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `foto_request` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `keterangan` text COLLATE utf8mb4_unicode_ci,
  `status` enum('pending','approved','rejected','in_progress','done') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `harga_estimasi` decimal(10,2) NOT NULL DEFAULT '0.00',
  `customer_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `customer_email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `customer_phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `alamat` text COLLATE utf8mb4_unicode_ci,
  `product_category` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `custom_requests`
--

INSERT INTO `custom_requests` (`id`, `user_id`, `produk_id`, `foto_referensi`, `foto_request`, `keterangan`, `status`, `harga_estimasi`, `customer_name`, `customer_email`, `customer_phone`, `alamat`, `product_category`, `created_at`, `updated_at`) VALUES
(1, 2, NULL, NULL, NULL, 'lorem ipsum', 'done', '1000.00', 'Azril Ardiansyah', 'contohazril@gmail.com', '085779745421', NULL, 'Pakaian Pria', '2025-12-03 07:41:06', '2025-12-11 08:03:34'),
(2, 2, NULL, 'images/1765257882.jpg', NULL, 'test', 'pending', '1000.00', 'Azril Ardiansyah', 'contohazril@gmail.com', '085779745421', NULL, 'Pakaian Pria', '2025-12-08 22:25:14', '2025-12-08 22:25:14');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint UNSIGNED NOT NULL,
  `reserved_at` int UNSIGNED DEFAULT NULL,
  `available_at` int UNSIGNED NOT NULL,
  `created_at` int UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext COLLATE utf8mb4_unicode_ci,
  `cancelled_at` int DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2025_10_21_115048_create_categories_table', 1),
(5, '2025_10_21_115054_create_products_table', 1),
(6, '2025_10_21_115100_create_custom_requests_table', 1),
(7, '2025_10_21_115106_create_orders_table', 1),
(8, '2025_10_21_115112_create_order_items_table', 1),
(9, '2025_10_21_115118_create_pengiriman_table', 1),
(10, '2025_10_21_115123_create_pembayaran_table', 1),
(11, '2025_10_23_034722_create_sessions_table', 1),
(12, '2025_10_30_092735_create_product_variants_table', 1),
(13, '2025_11_02_164206_add_customer_fields_to_custom_requests_table', 1),
(14, '2025_11_07_235955_add_customer_fields_to_orders_table', 1),
(15, '2025_11_19_062728_add_variant_id_to_order_items_table', 1),
(16, '2025_11_22_063726_update_order_status_enum', 1),
(17, '2025_11_22_104636_add_alamat_to_custom_requests_table', 1),
(19, '2025_12_18_130047_add_gallery_to_products_table', 2);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `total_harga` decimal(10,2) NOT NULL,
  `status` enum('pending','paid','success','failed','expired','cancelled','challenge','shipped','completed') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `metode_pembayaran` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `alamat_pengiriman` text COLLATE utf8mb4_unicode_ci,
  `customer_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `customer_email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `customer_phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `total_harga`, `status`, `metode_pembayaran`, `alamat_pengiriman`, `customer_name`, `customer_email`, `customer_phone`, `created_at`, `updated_at`) VALUES
(3, 2, '61000.00', 'completed', 'transfer', 'Jl. Hall 51 Jakarta Selatan', 'Azril Ardiansyah', 'contohazril@gmail.com', '085779745421', '2025-12-03 07:41:06', '2025-12-03 20:44:19'),
(4, 2, '1000.00', 'completed', 'transfer', 'Jl. Hall 51 Jakarta Selatan', 'Azril Ardiansyah', 'contohazril@gmail.com', '085779745421', '2025-12-08 22:25:14', '2025-12-08 22:30:20'),
(5, 2, '60000.00', 'shipped', 'transfer', 'Jl. Hall 51 Jakarta Selatan', 'Azril Ardiansyah', 'contohazril@gmail.com', '085779745421', '2025-12-11 07:51:19', '2025-12-11 07:55:27'),
(6, 2, '50000.00', 'shipped', 'transfer', 'Jl. Hall 51 Jakarta Selatan', 'Laura', 'laura@gmail.com', '08123456789', '2026-04-10 07:56:52', '2026-04-10 08:03:06');

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `id` bigint UNSIGNED NOT NULL,
  `order_id` bigint UNSIGNED NOT NULL,
  `product_id` bigint UNSIGNED DEFAULT NULL,
  `custom_request_id` bigint UNSIGNED DEFAULT NULL,
  `jumlah` int NOT NULL,
  `harga_satuan` decimal(10,2) NOT NULL,
  `subtotal` decimal(10,2) NOT NULL,
  `harga` decimal(10,2) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `variant_id` bigint UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`id`, `order_id`, `product_id`, `custom_request_id`, `jumlah`, `harga_satuan`, `subtotal`, `harga`, `created_at`, `updated_at`, `variant_id`) VALUES
(3, 3, NULL, 1, 1, '1000.00', '1000.00', '1000.00', '2025-12-03 07:41:06', '2025-12-03 07:41:06', NULL),
(4, 3, 1, NULL, 1, '60000.00', '60000.00', '60000.00', '2025-12-03 07:41:06', '2025-12-03 07:41:06', 2),
(5, 4, NULL, 2, 1, '1000.00', '1000.00', '1000.00', '2025-12-08 22:25:14', '2025-12-08 22:25:14', NULL),
(6, 5, 1, NULL, 1, '60000.00', '60000.00', '60000.00', '2025-12-11 07:51:19', '2025-12-11 07:51:19', 2),
(7, 6, 1, NULL, 1, '50000.00', '50000.00', '50000.00', '2026-04-10 07:56:52', '2026-04-10 07:56:52', 1);

-- --------------------------------------------------------

--
-- Table structure for table `pembayaran`
--

CREATE TABLE `pembayaran` (
  `id` bigint UNSIGNED NOT NULL,
  `order_id` bigint UNSIGNED NOT NULL,
  `metode_pembayaran` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `jumlah_bayar` decimal(10,2) NOT NULL,
  `bukti_bayar` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status_pembayaran` enum('pending','paid','failed','refund') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `tanggal_bayar` datetime DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pembayaran`
--

INSERT INTO `pembayaran` (`id`, `order_id`, `metode_pembayaran`, `jumlah_bayar`, `bukti_bayar`, `status_pembayaran`, `tanggal_bayar`, `created_at`, `updated_at`) VALUES
(3, 3, 'transfer', '61000.00', NULL, 'paid', '2025-12-03 14:42:21', '2025-12-03 07:41:06', '2025-12-03 07:42:21'),
(4, 4, 'transfer', '1000.00', NULL, 'paid', '2025-12-09 05:25:52', '2025-12-08 22:25:14', '2025-12-08 22:25:52'),
(5, 5, 'transfer', '60000.00', NULL, 'paid', '2025-12-11 14:51:53', '2025-12-11 07:51:19', '2025-12-11 07:51:53'),
(6, 6, 'transfer', '50000.00', NULL, 'paid', '2026-04-10 14:57:41', '2026-04-10 07:56:52', '2026-04-10 07:57:41');

-- --------------------------------------------------------

--
-- Table structure for table `pengiriman`
--

CREATE TABLE `pengiriman` (
  `id` bigint UNSIGNED NOT NULL,
  `order_id` bigint UNSIGNED NOT NULL,
  `nama_penerima` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `alamat_pengiriman` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `no_hp` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `kurir` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `no_resi` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status_pengiriman` enum('pending','dikirim','sampai','dibatalkan') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `tanggal_kirim` date DEFAULT NULL,
  `tanggal_terima` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pengiriman`
--

INSERT INTO `pengiriman` (`id`, `order_id`, `nama_penerima`, `alamat_pengiriman`, `no_hp`, `kurir`, `no_resi`, `status_pengiriman`, `tanggal_kirim`, `tanggal_terima`, `created_at`, `updated_at`) VALUES
(4, 3, 'Azril Ardiansyah', 'Jl. Hall 51 Jakarta Selatan', '085779745421', 'Adit', '12345678', 'sampai', '2025-12-04', '2025-12-06', '2025-12-03 20:25:52', '2025-12-03 20:44:19'),
(6, 4, 'Azril Ardiansyah', 'Jl. Hall 51 Jakarta Selatan', '085779745421', 'Adit', '12345678', 'sampai', '2025-12-09', '2025-12-13', '2025-12-08 22:29:07', '2025-12-08 22:30:20'),
(7, 5, 'Azril Ardiansyah', 'Jl. Hall 51 Jakarta Selatan', '085779745421', 'Bambang', '12345678', 'dikirim', '2025-12-11', '2025-12-12', '2025-12-11 07:55:27', '2025-12-11 07:55:27'),
(8, 6, 'Laura', 'Hall 51 Jakarta Selatan', '08123456789', 'Zura', '12345678', 'dikirim', '2026-04-11', '2026-04-13', '2026-04-10 08:03:06', '2026-04-10 08:03:06');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` bigint UNSIGNED NOT NULL,
  `category_id` bigint UNSIGNED NOT NULL,
  `nama_produk` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `deskripsi` text COLLATE utf8mb4_unicode_ci,
  `harga` decimal(10,2) NOT NULL,
  `stok` int NOT NULL DEFAULT '0',
  `foto` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `gallery` json DEFAULT NULL,
  `tipe_produk` enum('ready','custom') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'ready',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `category_id`, `nama_produk`, `deskripsi`, `harga`, `stok`, `foto`, `gallery`, `tipe_produk`, `created_at`, `updated_at`) VALUES
(1, 1, 'Kaos Hijau', 'Lorem Ipsum', '0.00', 0, 'products/01KB43RE10S448J8BSHKG78C3R.jpg', '[\"products/gallery/01KCR11EWMH8JMXRANHN09YQRE.jpg\", \"products/gallery/01KCR11EXSWBS5FJ5YXYMJSD47.jpg\", \"products/gallery/01KCR11EXYF6PD8QAWEATC5WXB.jpg\"]', 'ready', '2025-11-27 19:13:01', '2025-12-18 06:06:01'),
(2, 1, 'Kaos Biru', 'Lorem Ipsum', '0.00', 0, 'products/01KCQZTQ3BP7Q9DGV6916KYE3A.jpg', NULL, 'ready', '2025-12-18 05:44:52', '2025-12-18 05:44:52'),
(3, 1, 'Kaos Hitam', 'Lorem Ipsum', '0.00', 0, 'products/01KCR1SZRSXB4B7XZT1QQQW9DA.jpg', '[\"products/gallery/01KCR1SZX6QJ47V0BGDHZB7T3F.jpg\", \"products/gallery/01KCR1SZXFVAC31AZWM07VTEVK.jpg\"]', 'ready', '2025-12-18 06:19:25', '2025-12-18 06:19:25'),
(4, 2, 'Cardigan Hijau', 'Lorem Ipsum', '0.00', 0, 'products/01KCZSZB95FS7DZKFDRXVQRPRQ.jpg', '[\"products/gallery/01KCZSZBA90SSPWSSP6BY3QEN8.jpg\", \"products/gallery/01KCZSZBAFZD9WWSB4HV5HCR2V.jpg\"]', 'ready', '2025-12-21 06:36:27', '2025-12-21 06:36:27'),
(5, 1, 'Cardigan Biru', 'Lorem Ipsum', '0.00', 0, 'products/01KCZVAD2ZTY0AD8D06BAEX6NS.jpg', '[\"products/gallery/01KCZVAD38MSR3Z83MWD411287.jpg\", \"products/gallery/01KCZVAD3E752HGHFYDBTR3WB6.jpg\"]', 'ready', '2025-12-21 06:59:58', '2025-12-21 06:59:58'),
(6, 1, 'test', NULL, '0.00', 0, NULL, '[\"test.png\"]', 'ready', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `product_variants`
--

CREATE TABLE `product_variants` (
  `id` bigint UNSIGNED NOT NULL,
  `product_id` bigint UNSIGNED NOT NULL,
  `size` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `stock` int NOT NULL DEFAULT '0',
  `price_adjustment` decimal(10,2) NOT NULL DEFAULT '0.00',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `product_variants`
--

INSERT INTO `product_variants` (`id`, `product_id`, `size`, `stock`, `price_adjustment`, `created_at`, `updated_at`) VALUES
(1, 1, 'S', 7, '50000.00', '2025-11-27 19:13:29', '2026-04-10 07:56:52'),
(2, 1, 'M', 13, '60000.00', '2025-11-27 19:13:53', '2025-12-11 07:51:19'),
(3, 2, 'M', 5, '50000.00', '2025-12-18 05:45:54', '2025-12-18 05:45:54'),
(4, 2, 'L', 10, '60000.00', '2025-12-18 05:46:13', '2025-12-18 05:46:13');

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('1PmoFkQzUYOkwEFDlBUR6E8Zz7g2Ycv2Oo9CcEqt', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36 Edg/146.0.0.0', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoidnphSHJwZjNaN0o1TFoxaTNieXVRblZGRmhkTEZiSDlieGdNb05JRyI7czo3OiJzdWNjZXNzIjtzOjI2OiJBbmRhIHRlbGFoIGJlcmhhc2lsIGxvZ291dCI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJuZXciO2E6MDp7fXM6Mzoib2xkIjthOjE6e2k6MDtzOjc6InN1Y2Nlc3MiO319fQ==', 1775808737),
('CPMLmK1w1h02MO716VwBECiPylx2wfdBLMqBEhL3', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiRHZUT1duNFhuOXhlV2JiTHZPY1hXTHI3WGtMSmJmWk1jVEdRUVZzZSI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czozOiJ1cmwiO2E6MTp7czo4OiJpbnRlbmRlZCI7czoyNzoiaHR0cDovLzEyNy4wLjAuMTo4MDAwL2FkbWluIjt9czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzM6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9hZG1pbi9sb2dpbiI7fX0=', 1775808752),
('GCYCWZl9wzgtmuLVEhWnu6LwSXMePoJvoFCPIuKP', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoidWswWjRRNHFsQVpab09tUTJDMDVwV0ZhWTM4NjJhSHBRUlAyMFhmaiI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzM6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9hZG1pbi9sb2dpbiI7fX0=', 1775808692),
('tB3e4TQktvomRnQkWHT23VeeK8ogsUlgpjPm3Kit', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36 Edg/146.0.0.0', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiTjdJeEc1OFBaczRZSmNLTEI4dmZYWG0zc2xzOEkyM054d1BNQjJjYiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzI6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9jYXJ0L2NvdW50Ijt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1775830062),
('usGqHvp4dMBvZ18RqN3N1IOroBsYDuScRLHzSB8e', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36 Edg/146.0.0.0', 'YToyOntzOjY6Il90b2tlbiI7czo0MDoiWmdqUmhYWnRaVFpuVFh3b2VOcllySmpwSkZNUUtwZUxFRGJsSTRIbyI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1775808744);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` enum('admin','customer') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'customer',
  `alamat` text COLLATE utf8mb4_unicode_ci,
  `no_hp` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `role`, `alamat`, `no_hp`, `created_at`, `updated_at`) VALUES
(1, 'Admin', 'admin@butik.com', '$2y$12$j.OwsqhhPNUGgdrOFYjQKOVZgPKMdqUTvleNO.ZFh8FaY.v4fKfyu', 'admin', NULL, NULL, '2025-11-27 06:39:53', '2025-11-27 06:39:53'),
(2, 'User', 'user@butik.com', '$2y$12$Mrr8brwNU2jW0tot2TZeJ.Ttz0RgZGSGP2x2At/1SXeeUAxWRJHqS', 'customer', NULL, NULL, '2025-11-27 06:39:53', '2025-11-27 06:39:53');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `custom_requests`
--
ALTER TABLE `custom_requests`
  ADD PRIMARY KEY (`id`),
  ADD KEY `custom_requests_user_id_foreign` (`user_id`),
  ADD KEY `custom_requests_produk_id_foreign` (`produk_id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indexes for table `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `orders_user_id_foreign` (`user_id`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_items_order_id_foreign` (`order_id`),
  ADD KEY `order_items_product_id_foreign` (`product_id`),
  ADD KEY `order_items_custom_request_id_foreign` (`custom_request_id`),
  ADD KEY `order_items_variant_id_foreign` (`variant_id`);

--
-- Indexes for table `pembayaran`
--
ALTER TABLE `pembayaran`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pembayaran_order_id_foreign` (`order_id`);

--
-- Indexes for table `pengiriman`
--
ALTER TABLE `pengiriman`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pengiriman_order_id_foreign` (`order_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `products_category_id_foreign` (`category_id`);

--
-- Indexes for table `product_variants`
--
ALTER TABLE `product_variants`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_variants_product_id_foreign` (`product_id`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `custom_requests`
--
ALTER TABLE `custom_requests`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `pembayaran`
--
ALTER TABLE `pembayaran`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `pengiriman`
--
ALTER TABLE `pengiriman`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `product_variants`
--
ALTER TABLE `product_variants`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `custom_requests`
--
ALTER TABLE `custom_requests`
  ADD CONSTRAINT `custom_requests_produk_id_foreign` FOREIGN KEY (`produk_id`) REFERENCES `products` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `custom_requests_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_custom_request_id_foreign` FOREIGN KEY (`custom_request_id`) REFERENCES `custom_requests` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `order_items_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `order_items_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `order_items_variant_id_foreign` FOREIGN KEY (`variant_id`) REFERENCES `product_variants` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `pembayaran`
--
ALTER TABLE `pembayaran`
  ADD CONSTRAINT `pembayaran_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `pengiriman`
--
ALTER TABLE `pengiriman`
  ADD CONSTRAINT `pengiriman_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `product_variants`
--
ALTER TABLE `product_variants`
  ADD CONSTRAINT `product_variants_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
