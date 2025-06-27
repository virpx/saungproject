-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 15 Jun 2025 pada 09.34
-- Versi server: 10.4.32-MariaDB
-- Versi PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `dms`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `blogs`
--

CREATE TABLE `blogs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `judul` varchar(255) NOT NULL,
  `desc` text NOT NULL,
  `image` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `categories`
--

CREATE TABLE `categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `categories`
--

INSERT INTO `categories` (`id`, `name`, `description`, `image`, `created_at`, `updated_at`) VALUES
(1, 'Makanan', 'Kategori untuk semua jenis makanan yang tersedia di menu.', 'makanan.jpg', '2025-06-09 05:21:16', '2025-06-09 05:21:16'),
(2, 'Minuman', 'Kategori untuk semua jenis minuman yang tersedia di menu.', 'minuman.jpg', '2025-06-09 05:21:16', '2025-06-09 05:21:16'),
(3, 'Cemilan', 'Kategori untuk semua jenis cemilan yang tersedia di menu.', 'cemilan.jpg', '2025-06-09 05:21:16', '2025-06-09 05:21:16');

-- --------------------------------------------------------

--
-- Struktur dari tabel `category_menu`
--

CREATE TABLE `category_menu` (
  `category_id` bigint(20) UNSIGNED NOT NULL,
  `menu_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `item_similarities`
--

CREATE TABLE `item_similarities` (
  `menu_id_1` varchar(255) NOT NULL,
  `menu_id_2` varchar(255) NOT NULL,
  `similarity_score` decimal(8,4) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `item_similarities`
--

INSERT INTO `item_similarities` (`menu_id_1`, `menu_id_2`, `similarity_score`, `created_at`, `updated_at`) VALUES
('DMSEs Teh Manis', 'DMSJus Alpukat', 0.5774, '2025-06-13 09:00:03', '2025-06-13 09:00:03'),
('DMSJus Alpukat', 'DMSEs Teh Manis', 0.5774, '2025-06-13 09:00:03', '2025-06-13 09:00:03'),
('DMSEs Teh Manis', 'DMSKopi Susu', 0.6667, '2025-06-13 09:00:03', '2025-06-13 09:00:03'),
('DMSKopi Susu', 'DMSEs Teh Manis', 0.6667, '2025-06-13 09:00:03', '2025-06-13 09:00:03'),
('DMSEs Teh Manis', 'TAX10', 0.5774, '2025-06-13 09:00:03', '2025-06-13 09:00:03'),
('TAX10', 'DMSEs Teh Manis', 0.5774, '2025-06-13 09:00:03', '2025-06-13 09:00:03'),
('DMSEs Teh Manis', 'DMSNasi Goreng Spesial', 0.2582, '2025-06-13 09:00:03', '2025-06-13 09:00:03'),
('DMSNasi Goreng Spesial', 'DMSEs Teh Manis', 0.2582, '2025-06-13 09:00:03', '2025-06-13 09:00:03'),
('DMSJus Alpukat', 'DMSKopi Susu', 0.5774, '2025-06-13 09:00:03', '2025-06-13 09:00:03'),
('DMSKopi Susu', 'DMSJus Alpukat', 0.5774, '2025-06-13 09:00:03', '2025-06-13 09:00:03'),
('DMSJus Alpukat', 'TAX10', 0.3333, '2025-06-13 09:00:03', '2025-06-13 09:00:03'),
('TAX10', 'DMSJus Alpukat', 0.3333, '2025-06-13 09:00:03', '2025-06-13 09:00:03'),
('DMSKopi Susu', 'TAX10', 0.5774, '2025-06-13 09:00:03', '2025-06-13 09:00:03'),
('TAX10', 'DMSKopi Susu', 0.5774, '2025-06-13 09:00:03', '2025-06-13 09:00:03'),
('DMSKopi Susu', 'DMSKeripik Singkong', 0.5774, '2025-06-13 09:00:03', '2025-06-13 09:00:03'),
('DMSKeripik Singkong', 'DMSKopi Susu', 0.5774, '2025-06-13 09:00:03', '2025-06-13 09:00:03'),
('DMSKopi Susu', 'DMSPisang Goreng', 0.4082, '2025-06-13 09:00:03', '2025-06-13 09:00:03'),
('DMSPisang Goreng', 'DMSKopi Susu', 0.4082, '2025-06-13 09:00:03', '2025-06-13 09:00:03'),
('TAX10', 'DMSNasi Goreng Spesial', 0.7454, '2025-06-13 09:00:03', '2025-06-13 09:00:03'),
('DMSNasi Goreng Spesial', 'TAX10', 0.7454, '2025-06-13 09:00:03', '2025-06-13 09:00:03'),
('TAX10', 'DMSMie Ayam Bakso', 0.5774, '2025-06-13 09:00:03', '2025-06-13 09:00:03'),
('DMSMie Ayam Bakso', 'TAX10', 0.5774, '2025-06-13 09:00:03', '2025-06-13 09:00:03'),
('TAX10', 'DMSKeripik Singkong', 0.3333, '2025-06-13 09:00:03', '2025-06-13 09:00:03'),
('DMSKeripik Singkong', 'TAX10', 0.3333, '2025-06-13 09:00:03', '2025-06-13 09:00:03'),
('TAX10', 'DMSPisang Goreng', 0.4714, '2025-06-13 09:00:03', '2025-06-13 09:00:03'),
('DMSPisang Goreng', 'TAX10', 0.4714, '2025-06-13 09:00:03', '2025-06-13 09:00:03'),
('DMSNasi Goreng Spesial', 'DMSMie Ayam Bakso', 0.5164, '2025-06-13 09:00:03', '2025-06-13 09:00:03'),
('DMSMie Ayam Bakso', 'DMSNasi Goreng Spesial', 0.5164, '2025-06-13 09:00:03', '2025-06-13 09:00:03'),
('DMSNasi Goreng Spesial', 'DMSPisang Goreng', 0.3162, '2025-06-13 09:00:03', '2025-06-13 09:00:03'),
('DMSPisang Goreng', 'DMSNasi Goreng Spesial', 0.3162, '2025-06-13 09:00:03', '2025-06-13 09:00:03'),
('DMSKeripik Singkong', 'DMSPisang Goreng', 0.7071, '2025-06-13 09:00:03', '2025-06-13 09:00:03'),
('DMSPisang Goreng', 'DMSKeripik Singkong', 0.7071, '2025-06-13 09:00:03', '2025-06-13 09:00:03'),
('DMS004', 'DMS005', 0.5774, '2025-06-14 23:40:26', '2025-06-14 23:40:26'),
('DMS005', 'DMS004', 0.5774, '2025-06-14 23:40:26', '2025-06-14 23:40:26'),
('DMS004', 'DMS006', 0.6667, '2025-06-14 23:40:26', '2025-06-14 23:40:26'),
('DMS006', 'DMS004', 0.6667, '2025-06-14 23:40:26', '2025-06-14 23:40:26'),
('DMS004', 'TAX10', 0.5774, '2025-06-14 23:40:26', '2025-06-14 23:40:26'),
('TAX10', 'DMS004', 0.5774, '2025-06-14 23:40:26', '2025-06-14 23:40:26'),
('DMS004', 'DMS001', 0.2582, '2025-06-14 23:40:26', '2025-06-14 23:40:26'),
('DMS001', 'DMS004', 0.2582, '2025-06-14 23:40:26', '2025-06-14 23:40:26'),
('DMS005', 'DMS006', 0.5774, '2025-06-14 23:40:26', '2025-06-14 23:40:26'),
('DMS006', 'DMS005', 0.5774, '2025-06-14 23:40:26', '2025-06-14 23:40:26'),
('DMS005', 'TAX10', 0.3333, '2025-06-14 23:40:26', '2025-06-14 23:40:26'),
('TAX10', 'DMS005', 0.3333, '2025-06-14 23:40:26', '2025-06-14 23:40:26'),
('DMS006', 'TAX10', 0.5774, '2025-06-14 23:40:26', '2025-06-14 23:40:26'),
('TAX10', 'DMS006', 0.5774, '2025-06-14 23:40:26', '2025-06-14 23:40:26'),
('DMS006', 'DMS007', 0.5774, '2025-06-14 23:40:26', '2025-06-14 23:40:26'),
('DMS007', 'DMS006', 0.5774, '2025-06-14 23:40:26', '2025-06-14 23:40:26'),
('DMS006', 'DMS008', 0.4082, '2025-06-14 23:40:26', '2025-06-14 23:40:26'),
('DMS008', 'DMS006', 0.4082, '2025-06-14 23:40:26', '2025-06-14 23:40:26'),
('TAX10', 'DMS001', 0.7454, '2025-06-14 23:40:26', '2025-06-14 23:40:26'),
('DMS001', 'TAX10', 0.7454, '2025-06-14 23:40:26', '2025-06-14 23:40:26'),
('TAX10', 'DMS002', 0.5774, '2025-06-14 23:40:26', '2025-06-14 23:40:26'),
('DMS002', 'TAX10', 0.5774, '2025-06-14 23:40:26', '2025-06-14 23:40:26'),
('TAX10', 'DMS007', 0.3333, '2025-06-14 23:40:26', '2025-06-14 23:40:26'),
('DMS007', 'TAX10', 0.3333, '2025-06-14 23:40:26', '2025-06-14 23:40:26'),
('TAX10', 'DMS008', 0.4714, '2025-06-14 23:40:26', '2025-06-14 23:40:26'),
('DMS008', 'TAX10', 0.4714, '2025-06-14 23:40:26', '2025-06-14 23:40:26'),
('DMS001', 'DMS002', 0.5164, '2025-06-14 23:40:26', '2025-06-14 23:40:26'),
('DMS002', 'DMS001', 0.5164, '2025-06-14 23:40:26', '2025-06-14 23:40:26'),
('DMS001', 'DMS008', 0.3162, '2025-06-14 23:40:26', '2025-06-14 23:40:26'),
('DMS008', 'DMS001', 0.3162, '2025-06-14 23:40:26', '2025-06-14 23:40:26'),
('DMS007', 'DMS008', 0.7071, '2025-06-14 23:40:26', '2025-06-14 23:40:26'),
('DMS008', 'DMS007', 0.7071, '2025-06-14 23:40:26', '2025-06-14 23:40:26');

-- --------------------------------------------------------

--
-- Struktur dari tabel `kokis`
--

CREATE TABLE `kokis` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `no_hp` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` varchar(255) NOT NULL DEFAULT 'koki',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `status` enum('pending','active','rejected') NOT NULL DEFAULT 'pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `kokis`
--

INSERT INTO `kokis` (`id`, `name`, `email`, `no_hp`, `password`, `role`, `created_at`, `updated_at`, `status`) VALUES
(1, 'ko', 'ko@gmail.com', '0808070', '$2y$10$jK/COgnuuyLmFbinlCZbTu7k7oSjca4x0rv0VKY0jjRDOUnhwZ81W', 'koki', '2025-06-09 05:49:12', '2025-06-09 05:50:32', 'active');

-- --------------------------------------------------------

--
-- Struktur dari tabel `menus`
--

CREATE TABLE `menus` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `sku` varchar(255) DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `image` varchar(255) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `category_id` bigint(20) UNSIGNED DEFAULT NULL,
  `tingkatpedas` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `menus`
--

INSERT INTO `menus` (`id`, `sku`, `name`, `description`, `image`, `price`, `category_id`, `tingkatpedas`, `created_at`, `updated_at`) VALUES
(1, 'DMS001', 'Nasi Goreng Spesial', 'Nasi goreng dengan telur, ayam, dan kerupuk.', 'nasi_goreng.jpg', 25000.00, 1, 'Sedang', '2025-06-09 05:21:16', '2025-06-09 05:21:16'),
(2, 'DMS002', 'Mie Ayam Bakso', 'Mie ayam dengan tambahan bakso sapi dan sayuran segar.', 'mie_ayam_bakso.jpg', 22000.00, 1, 'Rendah', '2025-06-09 05:21:16', '2025-06-09 05:21:16'),
(3, 'DMS003', 'Sate Ayam', 'Sate ayam bumbu kacang, disajikan dengan lontong.', 'sate_ayam.jpg', 20000.00, 1, 'Sedang', '2025-06-09 05:21:16', '2025-06-09 05:21:16'),
(4, 'DMS004', 'Es Teh Manis', 'Minuman es teh manis segar.', 'es_teh_manis.jpg', 6000.00, 2, NULL, '2025-06-09 05:21:16', '2025-06-09 05:21:16'),
(5, 'DMS005', 'Jus Alpukat', 'Jus alpukat segar dengan susu coklat.', 'jus_alpukat.jpg', 15000.00, 2, NULL, '2025-06-09 05:21:16', '2025-06-09 05:21:16'),
(6, 'DMS006', 'Kopi Susu', 'Kopi hitam dengan susu kental manis.', 'kopi_susu.jpg', 12000.00, 2, NULL, '2025-06-09 05:21:16', '2025-06-09 05:21:16'),
(7, 'DMS007', 'Keripik Singkong', 'Keripik singkong renyah, cocok untuk cemilan.', 'keripik_singkong.jpg', 8000.00, 3, 'Rendah', '2025-06-09 05:21:16', '2025-06-09 05:21:16'),
(8, 'DMS008', 'Pisang Goreng', 'Pisang goreng manis, disajikan hangat.', 'pisang_goreng.jpg', 10000.00, 3, NULL, '2025-06-09 05:21:16', '2025-06-09 05:21:16');

-- --------------------------------------------------------

--
-- Struktur dari tabel `menu_order`
--

CREATE TABLE `menu_order` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `menu_id` bigint(20) UNSIGNED NOT NULL,
  `order_id` bigint(20) UNSIGNED NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `quantity` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_reset_tokens_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(5, '2023_03_28_120957_create_categories_table', 1),
(6, '2023_03_28_121049_create_menus_table', 1),
(7, '2023_03_28_121103_create_tables_table', 1),
(8, '2023_03_28_121132_create_reservations_table', 1),
(9, '2023_04_12_213033_create_category_menu_table', 1),
(10, '2025_03_19_030433_add_tingkat_pedas_to_menus_table', 1),
(11, '2025_03_19_030912_add_category_id_to_menus_table', 1),
(12, '2025_03_22_044542_create_orders_table', 1),
(13, '2025_03_22_092433_create_menu_order_table', 1),
(14, '2025_03_24_045747_add_payment_status_to_orders_table', 1),
(15, '2025_05_13_033609_add_role_to_users_table', 1),
(16, '2025_05_13_051943_add_status_to_koki_table', 1),
(17, '2025_05_19_162110_create_blogs_table', 1),
(18, '2025_05_27_000000_create_transactions_table', 1),
(19, '2025_05_28_000001_create_payment_transactions_table', 1),
(20, '2025_05_28_000002_create_order_items_table', 1),
(21, '2025_05_28_181740_create_total_fee_table', 1),
(22, '2025_05_29_063955_create_checkout_url_to_payment_transactions_table', 1),
(23, '2025_05_29_125638_create_fee_merchant_and_fee_customer_table', 1),
(24, '2025_05_29_134320_create_amount_for_order_table', 1),
(25, '2025_05_29_140742_create_tax_for_order_table', 1),
(26, '2025_05_29_144735_create_amount_received_table', 1),
(27, '2025_05_30_151226_create_add_qris_url_to_payment_transactions_table', 1),
(28, '2025_06_01_161800_add_reservation_id_to_orders_table', 1),
(29, '2025_06_01_170000_add_menu_items_to_orders_table', 1),
(30, '2025_06_12_234902_create_user_menu_interactions_table', 2),
(33, '2025_06_13_005524_create_item_similarities_table', 3),
(34, '2025_06_13_031911_add_sku_to_menus_table', 4),
(35, '2025_06_15_054952_add_menu_id_to_order_items_table', 5);

-- --------------------------------------------------------

--
-- Struktur dari tabel `orders`
--

CREATE TABLE `orders` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `reservation_id` bigint(20) UNSIGNED DEFAULT NULL,
  `menu_items` text DEFAULT NULL,
  `customer_name` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `table_id` bigint(20) UNSIGNED NOT NULL,
  `total_price` decimal(10,2) DEFAULT NULL,
  `amount` int(11) NOT NULL DEFAULT 0 COMMENT 'Total amount for the order',
  `tax` decimal(15,2) NOT NULL DEFAULT 0.00 COMMENT 'Tax amount for the order',
  `note` text DEFAULT NULL,
  `payment_status` enum('pending','completed','failed') NOT NULL DEFAULT 'pending',
  `qris_screenshot` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `orders`
--

INSERT INTO `orders` (`id`, `reservation_id`, `menu_items`, `customer_name`, `phone`, `email`, `table_id`, `total_price`, `amount`, `tax`, `note`, `payment_status`, `qris_screenshot`, `created_at`, `updated_at`) VALUES
(1, 1, '[\"4\",\"5\",\"6\"]', 'Muhammad Fadilah', '0808070', 'muhammaddimasfadilla06@gmail.com', 3, 36300.00, 36300, 3300.00, NULL, 'pending', 'qrcodes/1.png', '2025-06-09 06:14:15', '2025-06-09 06:14:17'),
(2, NULL, NULL, 'ko', '0808070', 'ko@gmail.com', 2, 51700.00, 51700, 0.00, 'sdxadzd', 'pending', 'qrcodes/2.png', '2025-06-09 07:21:29', '2025-06-09 07:21:30'),
(3, NULL, NULL, 'Muhammad Dimas Fadilah', '085717504909', 'muhammaddimasfadilla06@gmail.com', 2, 51700.00, 51700, 0.00, 'sdcsdv', 'pending', 'qrcodes/3.png', '2025-06-09 07:23:18', '2025-06-09 07:23:19'),
(4, NULL, NULL, 'Muhammad Dimas Fadilah', '085717504909', 'muhammaddimasfadilla06@gmail.com', 2, 19800.00, 19800, 0.00, 'sdcsdv', 'pending', 'qrcodes/4.png', '2025-06-09 07:59:14', '2025-06-09 07:59:16'),
(5, NULL, NULL, 'Muhammad Dimas Fadilah', '085717504909', 'muhammaddimasfadilla06@gmail.com', 2, 34100.00, 34100, 0.00, 'sdcsdv', 'pending', 'qrcodes/5.png', '2025-06-09 08:30:40', '2025-06-09 08:30:43'),
(6, NULL, NULL, 'Muhammad Dimas Fadilah', '085717504909', 'muhammaddimasfadilla06@gmail.com', 2, 27500.00, 27500, 0.00, 'sdcsdv', 'pending', 'qrcodes/6.png', '2025-06-09 08:32:36', '2025-06-09 08:32:37'),
(7, NULL, NULL, 'Muhammad Dimas Fadilah', '087817584136', 'muhammaddimasfadilla06@gmail.com', 1, 24200.00, 24200, 0.00, 'saDA', 'pending', 'qrcodes/7.png', '2025-06-09 08:50:31', '2025-06-09 08:50:32'),
(8, 2, '[\"6\",\"7\",\"8\"]', 'Muhammad Fadilah', '0808070', 'muhammaddimasfadilla06@gmail.com', 2, 33000.00, 33000, 3000.00, NULL, 'pending', 'qrcodes/8.png', '2025-06-12 18:52:57', '2025-06-12 18:52:59'),
(9, NULL, NULL, 'Muhammad Dimas Fadilah', '087817584136', 'muhammaddimasfadilla06@gmail.com', 1, 38500.00, 38500, 0.00, 'C', 'pending', 'qrcodes/9.png', '2025-06-12 18:56:17', '2025-06-12 18:56:18');

-- --------------------------------------------------------

--
-- Struktur dari tabel `order_items`
--

CREATE TABLE `order_items` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `order_id` bigint(20) UNSIGNED NOT NULL,
  `menu_id` bigint(20) UNSIGNED DEFAULT NULL,
  `sku` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `price` decimal(15,2) NOT NULL,
  `quantity` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `order_items`
--

INSERT INTO `order_items` (`id`, `order_id`, `menu_id`, `sku`, `name`, `price`, `quantity`, `created_at`, `updated_at`) VALUES
(1, 1, 4, 'DMS004', 'Es Teh Manis', 6000.00, 1, '2025-06-09 06:14:15', '2025-06-09 06:14:15'),
(2, 1, 5, 'DMS005', 'Jus Alpukat', 15000.00, 1, '2025-06-09 06:14:15', '2025-06-09 06:14:15'),
(3, 1, 6, 'DMS006', 'Kopi Susu', 12000.00, 1, '2025-06-09 06:14:15', '2025-06-09 06:14:15'),
(4, 1, NULL, 'TAX10', 'Pajak 10%', 3300.00, 1, '2025-06-09 06:14:15', '2025-06-09 06:14:15'),
(5, 2, 1, 'DMS001', 'Nasi Goreng Spesial', 25000.00, 1, '2025-06-09 07:21:29', '2025-06-09 07:21:29'),
(6, 2, 2, 'DMS002', 'Mie Ayam Bakso', 22000.00, 1, '2025-06-09 07:21:29', '2025-06-09 07:21:29'),
(7, 2, NULL, 'TAX10', 'Pajak 10%', 4700.00, 1, '2025-06-09 07:21:29', '2025-06-09 07:21:29'),
(8, 3, 1, 'DMS001', 'Nasi Goreng Spesial', 25000.00, 1, '2025-06-09 07:23:18', '2025-06-09 07:23:18'),
(9, 3, 2, 'DMS002', 'Mie Ayam Bakso', 22000.00, 1, '2025-06-09 07:23:18', '2025-06-09 07:23:18'),
(10, 3, NULL, 'TAX10', 'Pajak 10%', 4700.00, 1, '2025-06-09 07:23:18', '2025-06-09 07:23:18'),
(11, 4, 4, 'DMS004', 'Es Teh Manis', 6000.00, 1, '2025-06-09 07:59:14', '2025-06-09 07:59:14'),
(12, 4, 6, 'DMS006', 'Kopi Susu', 12000.00, 1, '2025-06-09 07:59:14', '2025-06-09 07:59:14'),
(13, 4, NULL, 'TAX10', 'Pajak 10%', 1800.00, 1, '2025-06-09 07:59:14', '2025-06-09 07:59:14'),
(14, 5, 1, 'DMS001', 'Nasi Goreng Spesial', 25000.00, 1, '2025-06-09 08:30:40', '2025-06-09 08:30:40'),
(15, 5, 4, 'DMS004', 'Es Teh Manis', 6000.00, 1, '2025-06-09 08:30:40', '2025-06-09 08:30:40'),
(16, 5, NULL, 'TAX10', 'Pajak 10%', 3100.00, 1, '2025-06-09 08:30:40', '2025-06-09 08:30:40'),
(17, 6, 1, 'DMS001', 'Nasi Goreng Spesial', 25000.00, 1, '2025-06-09 08:32:36', '2025-06-09 08:32:36'),
(18, 6, NULL, 'TAX10', 'Pajak 10%', 2500.00, 1, '2025-06-09 08:32:36', '2025-06-09 08:32:36'),
(19, 7, 2, 'DMS002', 'Mie Ayam Bakso', 22000.00, 1, '2025-06-09 08:50:31', '2025-06-09 08:50:31'),
(20, 7, NULL, 'TAX10', 'Pajak 10%', 2200.00, 1, '2025-06-09 08:50:31', '2025-06-09 08:50:31'),
(21, 8, 6, 'DMS006', 'Kopi Susu', 12000.00, 1, '2025-06-12 18:52:57', '2025-06-12 18:52:57'),
(22, 8, 7, 'DMS007', 'Keripik Singkong', 8000.00, 1, '2025-06-12 18:52:57', '2025-06-12 18:52:57'),
(23, 8, 8, 'DMS008', 'Pisang Goreng', 10000.00, 1, '2025-06-12 18:52:57', '2025-06-12 18:52:57'),
(24, 8, NULL, 'TAX10', 'Pajak 10%', 3000.00, 1, '2025-06-12 18:52:57', '2025-06-12 18:52:57'),
(25, 9, 1, 'DMS001', 'Nasi Goreng Spesial', 25000.00, 1, '2025-06-12 18:56:17', '2025-06-12 18:56:17'),
(26, 9, 8, 'DMS008', 'Pisang Goreng', 10000.00, 1, '2025-06-12 18:56:17', '2025-06-12 18:56:17'),
(27, 9, NULL, 'TAX10', 'Pajak 10%', 3500.00, 1, '2025-06-12 18:56:17', '2025-06-12 18:56:17');

-- --------------------------------------------------------

--
-- Struktur dari tabel `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `payment_transactions`
--

CREATE TABLE `payment_transactions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `order_id` bigint(20) UNSIGNED NOT NULL,
  `merchant_ref` varchar(255) NOT NULL,
  `payment_channel` varchar(255) NOT NULL,
  `amount` decimal(15,2) NOT NULL,
  `fee_merchant` decimal(15,2) NOT NULL DEFAULT 0.00 COMMENT 'Fee charged to merchant',
  `fee_customer` decimal(15,2) NOT NULL DEFAULT 0.00 COMMENT 'Fee charged to customer',
  `total_fee` decimal(15,2) DEFAULT 0.00 COMMENT 'Total biaya transaksi termasuk biaya layanan dan pajak',
  `customer_name` varchar(255) NOT NULL,
  `customer_email` varchar(255) NOT NULL,
  `customer_phone` varchar(255) NOT NULL,
  `order_items` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`order_items`)),
  `callback_url` varchar(255) DEFAULT NULL,
  `return_url` varchar(255) DEFAULT NULL,
  `checkout_url` varchar(255) DEFAULT NULL COMMENT 'URL untuk melanjutkan ke proses pembayaran',
  `expired_time` bigint(20) UNSIGNED NOT NULL,
  `signature` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'pending',
  `amount_received` decimal(10,2) NOT NULL,
  `payment_response` text DEFAULT NULL,
  `qris_url` varchar(255) DEFAULT NULL COMMENT 'QRIS URL for payment transactions',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `payment_transactions`
--

INSERT INTO `payment_transactions` (`id`, `order_id`, `merchant_ref`, `payment_channel`, `amount`, `fee_merchant`, `fee_customer`, `total_fee`, `customer_name`, `customer_email`, `customer_phone`, `order_items`, `callback_url`, `return_url`, `checkout_url`, `expired_time`, `signature`, `status`, `amount_received`, `payment_response`, `qris_url`, `created_at`, `updated_at`) VALUES
(1, 1, 'order-1', 'QRIS', 36300.00, 1005.00, 0.00, 1005.00, 'Muhammad Fadilah', 'muhammaddimasfadilla06@gmail.com', '0808070', '[{\"menu_id\":\"DMS4\",\"sku\":\"DMSEs Teh Manis\",\"name\":\"Es Teh Manis\",\"price\":\"6000.00\",\"quantity\":1},{\"menu_id\":\"DMS5\",\"sku\":\"DMSJus Alpukat\",\"name\":\"Jus Alpukat\",\"price\":\"15000.00\",\"quantity\":1},{\"menu_id\":\"DMS6\",\"sku\":\"DMSKopi Susu\",\"name\":\"Kopi Susu\",\"price\":\"12000.00\",\"quantity\":1},{\"sku\":\"TAX10\",\"name\":\"Pajak 10%\",\"price\":3300,\"quantity\":1}]', 'http://127.0.0.1:8000/callback/tripay', NULL, 'https://tripay.co.id/checkout/DEV-T409892436571T8HW', 1749476656, 'edb8d0a2fb488cdc768ca68d5661cd1b439fe1e4284ada1a16bea8e930686def', 'UNPAID', 35295.00, '\"{\\\"success\\\":true,\\\"message\\\":\\\"\\\",\\\"data\\\":{\\\"reference\\\":\\\"DEV-T409892436571T8HW\\\",\\\"merchant_ref\\\":\\\"order-1\\\",\\\"payment_selection_type\\\":\\\"static\\\",\\\"payment_method\\\":\\\"QRIS\\\",\\\"payment_name\\\":\\\"QRIS by ShopeePay\\\",\\\"customer_name\\\":\\\"Muhammad Fadilah\\\",\\\"customer_email\\\":\\\"muhammaddimasfadilla06@gmail.com\\\",\\\"customer_phone\\\":null,\\\"callback_url\\\":\\\"http:\\\\\\/\\\\\\/127.0.0.1:8000\\\\\\/callback\\\\\\/tripay\\\",\\\"return_url\\\":null,\\\"amount\\\":36300,\\\"fee_merchant\\\":1005,\\\"fee_customer\\\":0,\\\"total_fee\\\":1005,\\\"amount_received\\\":35295,\\\"pay_code\\\":null,\\\"pay_url\\\":null,\\\"checkout_url\\\":\\\"https:\\\\\\/\\\\\\/tripay.co.id\\\\\\/checkout\\\\\\/DEV-T409892436571T8HW\\\",\\\"status\\\":\\\"UNPAID\\\",\\\"expired_time\\\":1749476656,\\\"order_items\\\":[{\\\"sku\\\":\\\"DMSEs Teh Manis\\\",\\\"name\\\":\\\"Es Teh Manis\\\",\\\"price\\\":6000,\\\"quantity\\\":1,\\\"subtotal\\\":6000,\\\"product_url\\\":null,\\\"image_url\\\":null},{\\\"sku\\\":\\\"DMSJus Alpukat\\\",\\\"name\\\":\\\"Jus Alpukat\\\",\\\"price\\\":15000,\\\"quantity\\\":1,\\\"subtotal\\\":15000,\\\"product_url\\\":null,\\\"image_url\\\":null},{\\\"sku\\\":\\\"DMSKopi Susu\\\",\\\"name\\\":\\\"Kopi Susu\\\",\\\"price\\\":12000,\\\"quantity\\\":1,\\\"subtotal\\\":12000,\\\"product_url\\\":null,\\\"image_url\\\":null},{\\\"sku\\\":\\\"TAX10\\\",\\\"name\\\":\\\"Pajak 10%\\\",\\\"price\\\":3300,\\\"quantity\\\":1,\\\"subtotal\\\":3300,\\\"product_url\\\":null,\\\"image_url\\\":null}],\\\"instructions\\\":[{\\\"title\\\":\\\"Pembayaran via QRIS (ShopeePay)\\\",\\\"steps\\\":[\\\"Masuk ke aplikasi dompet digital Anda yang telah mendukung QRIS\\\",\\\"Pindai\\\\\\/Scan QR Code yang tersedia\\\",\\\"Akan muncul detail transaksi. Pastikan data transaksi sudah sesuai\\\",\\\"Selesaikan proses pembayaran Anda\\\",\\\"Transaksi selesai. Simpan bukti pembayaran Anda\\\"]},{\\\"title\\\":\\\"Pembayaran via QRIS (Mobile)\\\",\\\"steps\\\":[\\\"Download QR Code pada invoice\\\",\\\"Masuk ke aplikasi dompet digital Anda yang telah mendukung QRIS\\\",\\\"Upload QR Code yang telah di download tadi\\\",\\\"Akan muncul detail transaksi. Pastikan data transaksi sudah sesuai\\\",\\\"Selesaikan proses pembayaran Anda\\\",\\\"Transaksi selesai. Simpan bukti pembayaran Anda\\\"]}],\\\"qr_string\\\":\\\"SANDBOX MODE\\\",\\\"qr_url\\\":\\\"https:\\\\\\/\\\\\\/tripay.co.id\\\\\\/qr\\\\\\/DEV-T409892436571T8HW\\\"}}\"', NULL, '2025-06-09 06:14:17', '2025-06-09 06:14:17'),
(2, 2, 'order-2', 'ALFAMART', 51700.00, 3500.00, 0.00, 3500.00, 'ko', 'ko@gmail.com', '0808070', '[{\"menu_id\":1,\"sku\":\"DMSNasi Goreng Spesial\",\"name\":\"Nasi Goreng Spesial\",\"price\":\"25000.00\",\"quantity\":1},{\"menu_id\":2,\"sku\":\"DMSMie Ayam Bakso\",\"name\":\"Mie Ayam Bakso\",\"price\":\"22000.00\",\"quantity\":1},{\"sku\":\"TAX10\",\"name\":\"Pajak 10%\",\"price\":4700,\"quantity\":1}]', 'http://127.0.0.1:8000/callback/tripay', NULL, 'https://tripay.co.id/checkout/DEV-T40989243685DFBTV', 1749482550, '8d27e96417ddd95f5d663cf63d2dbcda3c0ebc8cbfd99e6c8bd213c4e1dc9498', 'UNPAID', 48200.00, '\"{\\\"success\\\":true,\\\"message\\\":\\\"\\\",\\\"data\\\":{\\\"reference\\\":\\\"DEV-T40989243685DFBTV\\\",\\\"merchant_ref\\\":\\\"order-2\\\",\\\"payment_selection_type\\\":\\\"static\\\",\\\"payment_method\\\":\\\"ALFAMART\\\",\\\"payment_name\\\":\\\"Alfamart\\\",\\\"customer_name\\\":\\\"ko\\\",\\\"customer_email\\\":\\\"ko@gmail.com\\\",\\\"customer_phone\\\":null,\\\"callback_url\\\":\\\"http:\\\\\\/\\\\\\/127.0.0.1:8000\\\\\\/callback\\\\\\/tripay\\\",\\\"return_url\\\":null,\\\"amount\\\":51700,\\\"fee_merchant\\\":3500,\\\"fee_customer\\\":0,\\\"total_fee\\\":3500,\\\"amount_received\\\":48200,\\\"pay_code\\\":\\\"631391521125714\\\",\\\"pay_url\\\":null,\\\"checkout_url\\\":\\\"https:\\\\\\/\\\\\\/tripay.co.id\\\\\\/checkout\\\\\\/DEV-T40989243685DFBTV\\\",\\\"status\\\":\\\"UNPAID\\\",\\\"expired_time\\\":1749482550,\\\"order_items\\\":[{\\\"sku\\\":\\\"DMSNasi Goreng Spesial\\\",\\\"name\\\":\\\"Nasi Goreng Spesial\\\",\\\"price\\\":25000,\\\"quantity\\\":1,\\\"subtotal\\\":25000,\\\"product_url\\\":null,\\\"image_url\\\":null},{\\\"sku\\\":\\\"DMSMie Ayam Bakso\\\",\\\"name\\\":\\\"Mie Ayam Bakso\\\",\\\"price\\\":22000,\\\"quantity\\\":1,\\\"subtotal\\\":22000,\\\"product_url\\\":null,\\\"image_url\\\":null},{\\\"sku\\\":\\\"TAX10\\\",\\\"name\\\":\\\"Pajak 10%\\\",\\\"price\\\":4700,\\\"quantity\\\":1,\\\"subtotal\\\":4700,\\\"product_url\\\":null,\\\"image_url\\\":null}],\\\"instructions\\\":[{\\\"title\\\":\\\"Pembayaran via ALFAMART\\\",\\\"steps\\\":[\\\"Datang ke Alfamart\\\",\\\"Sampaikan ke kasir ingin melakukan pembayaran aplikasi <b>Linkita<\\\\\\/b>\\\",\\\"Berikan kode bayar (<b>631391521125714<\\\\\\/b>) ke kasir\\\",\\\"Bayar sesuai jumlah yang diinfokan oleh kasir\\\",\\\"Simpan struk bukti pembayaran Anda\\\"]}]}}\"', NULL, '2025-06-09 07:21:30', '2025-06-09 07:21:30'),
(3, 3, 'order-3', 'DANA', 51700.00, 1551.00, 0.00, 1551.00, 'Muhammad Dimas Fadilah', 'muhammaddimasfadilla06@gmail.com', '085717504909', '[{\"menu_id\":1,\"sku\":\"DMSNasi Goreng Spesial\",\"name\":\"Nasi Goreng Spesial\",\"price\":\"25000.00\",\"quantity\":1},{\"menu_id\":2,\"sku\":\"DMSMie Ayam Bakso\",\"name\":\"Mie Ayam Bakso\",\"price\":\"22000.00\",\"quantity\":1},{\"sku\":\"TAX10\",\"name\":\"Pajak 10%\",\"price\":4700,\"quantity\":1}]', 'http://127.0.0.1:8000/callback/tripay', NULL, 'https://tripay.co.id/checkout/DEV-T40989243687HUJKT', 1749480798, '5f0a08ead4d4018a5c4de71bd4f408e0e0134814b216cf03b6e01c2796edc326', 'UNPAID', 50149.00, '\"{\\\"success\\\":true,\\\"message\\\":\\\"\\\",\\\"data\\\":{\\\"reference\\\":\\\"DEV-T40989243687HUJKT\\\",\\\"merchant_ref\\\":\\\"order-3\\\",\\\"payment_selection_type\\\":\\\"static\\\",\\\"payment_method\\\":\\\"DANA\\\",\\\"payment_name\\\":\\\"DANA\\\",\\\"customer_name\\\":\\\"Muhammad Dimas Fadilah\\\",\\\"customer_email\\\":\\\"muhammaddimasfadilla06@gmail.com\\\",\\\"customer_phone\\\":\\\"085717504909\\\",\\\"callback_url\\\":\\\"http:\\\\\\/\\\\\\/127.0.0.1:8000\\\\\\/callback\\\\\\/tripay\\\",\\\"return_url\\\":null,\\\"amount\\\":51700,\\\"fee_merchant\\\":1551,\\\"fee_customer\\\":0,\\\"total_fee\\\":1551,\\\"amount_received\\\":50149,\\\"pay_code\\\":null,\\\"pay_url\\\":\\\"https:\\\\\\/\\\\\\/tripay.co.id\\\\\\/checkout\\\\\\/DEV-T40989243687HUJKT\\\",\\\"checkout_url\\\":\\\"https:\\\\\\/\\\\\\/tripay.co.id\\\\\\/checkout\\\\\\/DEV-T40989243687HUJKT\\\",\\\"status\\\":\\\"UNPAID\\\",\\\"expired_time\\\":1749480798,\\\"order_items\\\":[{\\\"sku\\\":\\\"DMSNasi Goreng Spesial\\\",\\\"name\\\":\\\"Nasi Goreng Spesial\\\",\\\"price\\\":25000,\\\"quantity\\\":1,\\\"subtotal\\\":25000,\\\"product_url\\\":null,\\\"image_url\\\":null},{\\\"sku\\\":\\\"DMSMie Ayam Bakso\\\",\\\"name\\\":\\\"Mie Ayam Bakso\\\",\\\"price\\\":22000,\\\"quantity\\\":1,\\\"subtotal\\\":22000,\\\"product_url\\\":null,\\\"image_url\\\":null},{\\\"sku\\\":\\\"TAX10\\\",\\\"name\\\":\\\"Pajak 10%\\\",\\\"price\\\":4700,\\\"quantity\\\":1,\\\"subtotal\\\":4700,\\\"product_url\\\":null,\\\"image_url\\\":null}],\\\"instructions\\\":[{\\\"title\\\":\\\"Pembayaran via DANA\\\",\\\"steps\\\":[\\\"Klik tombol Lanjutkan Pembayaran\\\",\\\"Anda akan dipindah ke Halaman Pembayaran DANA \\\",\\\"Pastikan saldo DANA anda cukup\\\",\\\"Masukkan nomor handpone yang terdaftar pada akun DANA\\\",\\\"Anda akan diminta untuk memasukkan PIN DANA Anda\\\",\\\"Kemudian anda akan diminta untuk memasukkan kode OTP yang dikirim ke nomor DANA\\\",\\\"Kemudian akan muncul detail tansaksi pastikan sudah sesuai dengan transaksi yang ingin anda bayar\\\",\\\"Klik tombol <b>PAY<\\\\\\/b>\\\",\\\"Transaksi selesai. Simpan bukti pembayaran Anda\\\"]}]}}\"', NULL, '2025-06-09 07:23:19', '2025-06-09 07:23:19'),
(4, 4, 'order-4', 'QRIS', 19800.00, 889.00, 0.00, 889.00, 'Muhammad Dimas Fadilah', 'muhammaddimasfadilla06@gmail.com', '085717504909', '[{\"menu_id\":4,\"sku\":\"DMSEs Teh Manis\",\"name\":\"Es Teh Manis\",\"price\":\"6000.00\",\"quantity\":1},{\"menu_id\":6,\"sku\":\"DMSKopi Susu\",\"name\":\"Kopi Susu\",\"price\":\"12000.00\",\"quantity\":1},{\"sku\":\"TAX10\",\"name\":\"Pajak 10%\",\"price\":1800,\"quantity\":1}]', 'http://127.0.0.1:8000/callback/tripay', NULL, 'https://tripay.co.id/checkout/DEV-T40989243691DSWQ4', 1749482954, 'ac6f68bcfc6fcf51f40b46ba9961852a38beecf0a7bde12d1c9912f85c0751c7', 'UNPAID', 18911.00, '\"{\\\"success\\\":true,\\\"message\\\":\\\"\\\",\\\"data\\\":{\\\"reference\\\":\\\"DEV-T40989243691DSWQ4\\\",\\\"merchant_ref\\\":\\\"order-4\\\",\\\"payment_selection_type\\\":\\\"static\\\",\\\"payment_method\\\":\\\"QRIS\\\",\\\"payment_name\\\":\\\"QRIS by ShopeePay\\\",\\\"customer_name\\\":\\\"Muhammad Dimas Fadilah\\\",\\\"customer_email\\\":\\\"muhammaddimasfadilla06@gmail.com\\\",\\\"customer_phone\\\":\\\"085717504909\\\",\\\"callback_url\\\":\\\"http:\\\\\\/\\\\\\/127.0.0.1:8000\\\\\\/callback\\\\\\/tripay\\\",\\\"return_url\\\":null,\\\"amount\\\":19800,\\\"fee_merchant\\\":889,\\\"fee_customer\\\":0,\\\"total_fee\\\":889,\\\"amount_received\\\":18911,\\\"pay_code\\\":null,\\\"pay_url\\\":null,\\\"checkout_url\\\":\\\"https:\\\\\\/\\\\\\/tripay.co.id\\\\\\/checkout\\\\\\/DEV-T40989243691DSWQ4\\\",\\\"status\\\":\\\"UNPAID\\\",\\\"expired_time\\\":1749482954,\\\"order_items\\\":[{\\\"sku\\\":\\\"DMSEs Teh Manis\\\",\\\"name\\\":\\\"Es Teh Manis\\\",\\\"price\\\":6000,\\\"quantity\\\":1,\\\"subtotal\\\":6000,\\\"product_url\\\":null,\\\"image_url\\\":null},{\\\"sku\\\":\\\"DMSKopi Susu\\\",\\\"name\\\":\\\"Kopi Susu\\\",\\\"price\\\":12000,\\\"quantity\\\":1,\\\"subtotal\\\":12000,\\\"product_url\\\":null,\\\"image_url\\\":null},{\\\"sku\\\":\\\"TAX10\\\",\\\"name\\\":\\\"Pajak 10%\\\",\\\"price\\\":1800,\\\"quantity\\\":1,\\\"subtotal\\\":1800,\\\"product_url\\\":null,\\\"image_url\\\":null}],\\\"instructions\\\":[{\\\"title\\\":\\\"Pembayaran via QRIS (ShopeePay)\\\",\\\"steps\\\":[\\\"Masuk ke aplikasi dompet digital Anda yang telah mendukung QRIS\\\",\\\"Pindai\\\\\\/Scan QR Code yang tersedia\\\",\\\"Akan muncul detail transaksi. Pastikan data transaksi sudah sesuai\\\",\\\"Selesaikan proses pembayaran Anda\\\",\\\"Transaksi selesai. Simpan bukti pembayaran Anda\\\"]},{\\\"title\\\":\\\"Pembayaran via QRIS (Mobile)\\\",\\\"steps\\\":[\\\"Download QR Code pada invoice\\\",\\\"Masuk ke aplikasi dompet digital Anda yang telah mendukung QRIS\\\",\\\"Upload QR Code yang telah di download tadi\\\",\\\"Akan muncul detail transaksi. Pastikan data transaksi sudah sesuai\\\",\\\"Selesaikan proses pembayaran Anda\\\",\\\"Transaksi selesai. Simpan bukti pembayaran Anda\\\"]}],\\\"qr_string\\\":\\\"SANDBOX MODE\\\",\\\"qr_url\\\":\\\"https:\\\\\\/\\\\\\/tripay.co.id\\\\\\/qr\\\\\\/DEV-T40989243691DSWQ4\\\"}}\"', NULL, '2025-06-09 07:59:15', '2025-06-09 07:59:15'),
(5, 5, 'order-5', 'QRIS', 34100.00, 989.00, 0.00, 989.00, 'Muhammad Dimas Fadilah', 'muhammaddimasfadilla06@gmail.com', '085717504909', '[{\"menu_id\":1,\"sku\":\"DMSNasi Goreng Spesial\",\"name\":\"Nasi Goreng Spesial\",\"price\":\"25000.00\",\"quantity\":1},{\"menu_id\":4,\"sku\":\"DMSEs Teh Manis\",\"name\":\"Es Teh Manis\",\"price\":\"6000.00\",\"quantity\":1},{\"sku\":\"TAX10\",\"name\":\"Pajak 10%\",\"price\":3100,\"quantity\":1}]', 'http://127.0.0.1:8000/callback/tripay', NULL, 'https://tripay.co.id/checkout/DEV-T40989243696PJTZS', 1749484841, '27d7f47bb3e6a19da0f071b9bd230bf0be842138207a40f1a105acc1bce2f030', 'UNPAID', 33111.00, '\"{\\\"success\\\":true,\\\"message\\\":\\\"\\\",\\\"data\\\":{\\\"reference\\\":\\\"DEV-T40989243696PJTZS\\\",\\\"merchant_ref\\\":\\\"order-5\\\",\\\"payment_selection_type\\\":\\\"static\\\",\\\"payment_method\\\":\\\"QRIS\\\",\\\"payment_name\\\":\\\"QRIS by ShopeePay\\\",\\\"customer_name\\\":\\\"Muhammad Dimas Fadilah\\\",\\\"customer_email\\\":\\\"muhammaddimasfadilla06@gmail.com\\\",\\\"customer_phone\\\":\\\"085717504909\\\",\\\"callback_url\\\":\\\"http:\\\\\\/\\\\\\/127.0.0.1:8000\\\\\\/callback\\\\\\/tripay\\\",\\\"return_url\\\":null,\\\"amount\\\":34100,\\\"fee_merchant\\\":989,\\\"fee_customer\\\":0,\\\"total_fee\\\":989,\\\"amount_received\\\":33111,\\\"pay_code\\\":null,\\\"pay_url\\\":null,\\\"checkout_url\\\":\\\"https:\\\\\\/\\\\\\/tripay.co.id\\\\\\/checkout\\\\\\/DEV-T40989243696PJTZS\\\",\\\"status\\\":\\\"UNPAID\\\",\\\"expired_time\\\":1749484841,\\\"order_items\\\":[{\\\"sku\\\":\\\"DMSNasi Goreng Spesial\\\",\\\"name\\\":\\\"Nasi Goreng Spesial\\\",\\\"price\\\":25000,\\\"quantity\\\":1,\\\"subtotal\\\":25000,\\\"product_url\\\":null,\\\"image_url\\\":null},{\\\"sku\\\":\\\"DMSEs Teh Manis\\\",\\\"name\\\":\\\"Es Teh Manis\\\",\\\"price\\\":6000,\\\"quantity\\\":1,\\\"subtotal\\\":6000,\\\"product_url\\\":null,\\\"image_url\\\":null},{\\\"sku\\\":\\\"TAX10\\\",\\\"name\\\":\\\"Pajak 10%\\\",\\\"price\\\":3100,\\\"quantity\\\":1,\\\"subtotal\\\":3100,\\\"product_url\\\":null,\\\"image_url\\\":null}],\\\"instructions\\\":[{\\\"title\\\":\\\"Pembayaran via QRIS (ShopeePay)\\\",\\\"steps\\\":[\\\"Masuk ke aplikasi dompet digital Anda yang telah mendukung QRIS\\\",\\\"Pindai\\\\\\/Scan QR Code yang tersedia\\\",\\\"Akan muncul detail transaksi. Pastikan data transaksi sudah sesuai\\\",\\\"Selesaikan proses pembayaran Anda\\\",\\\"Transaksi selesai. Simpan bukti pembayaran Anda\\\"]},{\\\"title\\\":\\\"Pembayaran via QRIS (Mobile)\\\",\\\"steps\\\":[\\\"Download QR Code pada invoice\\\",\\\"Masuk ke aplikasi dompet digital Anda yang telah mendukung QRIS\\\",\\\"Upload QR Code yang telah di download tadi\\\",\\\"Akan muncul detail transaksi. Pastikan data transaksi sudah sesuai\\\",\\\"Selesaikan proses pembayaran Anda\\\",\\\"Transaksi selesai. Simpan bukti pembayaran Anda\\\"]}],\\\"qr_string\\\":\\\"SANDBOX MODE\\\",\\\"qr_url\\\":\\\"https:\\\\\\/\\\\\\/tripay.co.id\\\\\\/qr\\\\\\/DEV-T40989243696PJTZS\\\"}}\"', NULL, '2025-06-09 08:30:42', '2025-06-09 08:30:42'),
(6, 6, 'order-6', 'SHOPEEPAY', 27500.00, 1000.00, 0.00, 1000.00, 'Muhammad Dimas Fadilah', 'muhammaddimasfadilla06@gmail.com', '085717504909', '[{\"menu_id\":1,\"sku\":\"DMSNasi Goreng Spesial\",\"name\":\"Nasi Goreng Spesial\",\"price\":\"25000.00\",\"quantity\":1},{\"sku\":\"TAX10\",\"name\":\"Pajak 10%\",\"price\":2500,\"quantity\":1}]', 'http://127.0.0.1:8000/callback/tripay', NULL, 'https://tripay.co.id/checkout/DEV-T40989243697XCOLV', 1749484956, 'bc1d572d88e70816103635b75a1505589263e0da3da8cfeefb381bb7b95e0934', 'UNPAID', 26500.00, '\"{\\\"success\\\":true,\\\"message\\\":\\\"\\\",\\\"data\\\":{\\\"reference\\\":\\\"DEV-T40989243697XCOLV\\\",\\\"merchant_ref\\\":\\\"order-6\\\",\\\"payment_selection_type\\\":\\\"static\\\",\\\"payment_method\\\":\\\"SHOPEEPAY\\\",\\\"payment_name\\\":\\\"ShopeePay\\\",\\\"customer_name\\\":\\\"Muhammad Dimas Fadilah\\\",\\\"customer_email\\\":\\\"muhammaddimasfadilla06@gmail.com\\\",\\\"customer_phone\\\":\\\"085717504909\\\",\\\"callback_url\\\":\\\"http:\\\\\\/\\\\\\/127.0.0.1:8000\\\\\\/callback\\\\\\/tripay\\\",\\\"return_url\\\":null,\\\"amount\\\":27500,\\\"fee_merchant\\\":1000,\\\"fee_customer\\\":0,\\\"total_fee\\\":1000,\\\"amount_received\\\":26500,\\\"pay_code\\\":null,\\\"pay_url\\\":\\\"https:\\\\\\/\\\\\\/tripay.co.id\\\\\\/checkout\\\\\\/DEV-T40989243697XCOLV\\\",\\\"checkout_url\\\":\\\"https:\\\\\\/\\\\\\/tripay.co.id\\\\\\/checkout\\\\\\/DEV-T40989243697XCOLV\\\",\\\"status\\\":\\\"UNPAID\\\",\\\"expired_time\\\":1749484956,\\\"order_items\\\":[{\\\"sku\\\":\\\"DMSNasi Goreng Spesial\\\",\\\"name\\\":\\\"Nasi Goreng Spesial\\\",\\\"price\\\":25000,\\\"quantity\\\":1,\\\"subtotal\\\":25000,\\\"product_url\\\":null,\\\"image_url\\\":null},{\\\"sku\\\":\\\"TAX10\\\",\\\"name\\\":\\\"Pajak 10%\\\",\\\"price\\\":2500,\\\"quantity\\\":1,\\\"subtotal\\\":2500,\\\"product_url\\\":null,\\\"image_url\\\":null}],\\\"instructions\\\":[{\\\"title\\\":\\\"Pembayaran via ShopeePay\\\",\\\"steps\\\":[\\\"Klik tombol Lanjutkan Pembayaran\\\",\\\"Anda akan dialihkan ke aplikasi Shopee\\\",\\\"Akan muncul detail transaksi. Pastikan data transaksi sudah sesuai\\\",\\\"Klik tombol <b>Bayar<\\\\\\/b> dan masukkan <b>PIN<\\\\\\/b>\\\",\\\"Transaksi selesai. Simpan bukti pembayaran Anda\\\"]}]}}\"', NULL, '2025-06-09 08:32:37', '2025-06-09 08:32:37'),
(7, 7, 'order-7', 'DANA', 24200.00, 1000.00, 0.00, 1000.00, 'Muhammad Dimas Fadilah', 'muhammaddimasfadilla06@gmail.com', '087817584136', '[{\"menu_id\":2,\"sku\":\"DMSMie Ayam Bakso\",\"name\":\"Mie Ayam Bakso\",\"price\":\"22000.00\",\"quantity\":1},{\"sku\":\"TAX10\",\"name\":\"Pajak 10%\",\"price\":2200,\"quantity\":1}]', 'http://127.0.0.1:8000/callback/tripay', NULL, 'https://tripay.co.id/checkout/DEV-T40989243698FMLMR', 1749486031, '9c3fa119a57955d7f0234b53240edb8e0444cef7d8071db733423cb1ad29e111', 'UNPAID', 23200.00, '\"{\\\"success\\\":true,\\\"message\\\":\\\"\\\",\\\"data\\\":{\\\"reference\\\":\\\"DEV-T40989243698FMLMR\\\",\\\"merchant_ref\\\":\\\"order-7\\\",\\\"payment_selection_type\\\":\\\"static\\\",\\\"payment_method\\\":\\\"DANA\\\",\\\"payment_name\\\":\\\"DANA\\\",\\\"customer_name\\\":\\\"Muhammad Dimas Fadilah\\\",\\\"customer_email\\\":\\\"muhammaddimasfadilla06@gmail.com\\\",\\\"customer_phone\\\":\\\"087817584136\\\",\\\"callback_url\\\":\\\"http:\\\\\\/\\\\\\/127.0.0.1:8000\\\\\\/callback\\\\\\/tripay\\\",\\\"return_url\\\":null,\\\"amount\\\":24200,\\\"fee_merchant\\\":1000,\\\"fee_customer\\\":0,\\\"total_fee\\\":1000,\\\"amount_received\\\":23200,\\\"pay_code\\\":null,\\\"pay_url\\\":\\\"https:\\\\\\/\\\\\\/tripay.co.id\\\\\\/checkout\\\\\\/DEV-T40989243698FMLMR\\\",\\\"checkout_url\\\":\\\"https:\\\\\\/\\\\\\/tripay.co.id\\\\\\/checkout\\\\\\/DEV-T40989243698FMLMR\\\",\\\"status\\\":\\\"UNPAID\\\",\\\"expired_time\\\":1749486031,\\\"order_items\\\":[{\\\"sku\\\":\\\"DMSMie Ayam Bakso\\\",\\\"name\\\":\\\"Mie Ayam Bakso\\\",\\\"price\\\":22000,\\\"quantity\\\":1,\\\"subtotal\\\":22000,\\\"product_url\\\":null,\\\"image_url\\\":null},{\\\"sku\\\":\\\"TAX10\\\",\\\"name\\\":\\\"Pajak 10%\\\",\\\"price\\\":2200,\\\"quantity\\\":1,\\\"subtotal\\\":2200,\\\"product_url\\\":null,\\\"image_url\\\":null}],\\\"instructions\\\":[{\\\"title\\\":\\\"Pembayaran via DANA\\\",\\\"steps\\\":[\\\"Klik tombol Lanjutkan Pembayaran\\\",\\\"Anda akan dipindah ke Halaman Pembayaran DANA \\\",\\\"Pastikan saldo DANA anda cukup\\\",\\\"Masukkan nomor handpone yang terdaftar pada akun DANA\\\",\\\"Anda akan diminta untuk memasukkan PIN DANA Anda\\\",\\\"Kemudian anda akan diminta untuk memasukkan kode OTP yang dikirim ke nomor DANA\\\",\\\"Kemudian akan muncul detail tansaksi pastikan sudah sesuai dengan transaksi yang ingin anda bayar\\\",\\\"Klik tombol <b>PAY<\\\\\\/b>\\\",\\\"Transaksi selesai. Simpan bukti pembayaran Anda\\\"]}]}}\"', NULL, '2025-06-09 08:50:32', '2025-06-09 08:50:32'),
(8, 8, 'order-8', 'QRIS', 33000.00, 981.00, 0.00, 981.00, 'Muhammad Fadilah', 'muhammaddimasfadilla06@gmail.com', '0808070', '[{\"menu_id\":\"DMS6\",\"sku\":\"DMSKopi Susu\",\"name\":\"Kopi Susu\",\"price\":\"12000.00\",\"quantity\":1},{\"menu_id\":\"DMS7\",\"sku\":\"DMSKeripik Singkong\",\"name\":\"Keripik Singkong\",\"price\":\"8000.00\",\"quantity\":1},{\"menu_id\":\"DMS8\",\"sku\":\"DMSPisang Goreng\",\"name\":\"Pisang Goreng\",\"price\":\"10000.00\",\"quantity\":1},{\"sku\":\"TAX10\",\"name\":\"Pajak 10%\",\"price\":3000,\"quantity\":1}]', 'http://127.0.0.1:8000/callback/tripay', NULL, 'https://tripay.co.id/checkout/DEV-T40989245442MEAYS', 1749781377, 'd5a6488c27e7cde45ca2de77c33457f736f0480132b5127a0060b3192b8d3763', 'UNPAID', 32019.00, '\"{\\\"success\\\":true,\\\"message\\\":\\\"\\\",\\\"data\\\":{\\\"reference\\\":\\\"DEV-T40989245442MEAYS\\\",\\\"merchant_ref\\\":\\\"order-8\\\",\\\"payment_selection_type\\\":\\\"static\\\",\\\"payment_method\\\":\\\"QRIS\\\",\\\"payment_name\\\":\\\"QRIS by ShopeePay\\\",\\\"customer_name\\\":\\\"Muhammad Fadilah\\\",\\\"customer_email\\\":\\\"muhammaddimasfadilla06@gmail.com\\\",\\\"customer_phone\\\":null,\\\"callback_url\\\":\\\"http:\\\\\\/\\\\\\/127.0.0.1:8000\\\\\\/callback\\\\\\/tripay\\\",\\\"return_url\\\":null,\\\"amount\\\":33000,\\\"fee_merchant\\\":981,\\\"fee_customer\\\":0,\\\"total_fee\\\":981,\\\"amount_received\\\":32019,\\\"pay_code\\\":null,\\\"pay_url\\\":null,\\\"checkout_url\\\":\\\"https:\\\\\\/\\\\\\/tripay.co.id\\\\\\/checkout\\\\\\/DEV-T40989245442MEAYS\\\",\\\"status\\\":\\\"UNPAID\\\",\\\"expired_time\\\":1749781377,\\\"order_items\\\":[{\\\"sku\\\":\\\"DMSKopi Susu\\\",\\\"name\\\":\\\"Kopi Susu\\\",\\\"price\\\":12000,\\\"quantity\\\":1,\\\"subtotal\\\":12000,\\\"product_url\\\":null,\\\"image_url\\\":null},{\\\"sku\\\":\\\"DMSKeripik Singkong\\\",\\\"name\\\":\\\"Keripik Singkong\\\",\\\"price\\\":8000,\\\"quantity\\\":1,\\\"subtotal\\\":8000,\\\"product_url\\\":null,\\\"image_url\\\":null},{\\\"sku\\\":\\\"DMSPisang Goreng\\\",\\\"name\\\":\\\"Pisang Goreng\\\",\\\"price\\\":10000,\\\"quantity\\\":1,\\\"subtotal\\\":10000,\\\"product_url\\\":null,\\\"image_url\\\":null},{\\\"sku\\\":\\\"TAX10\\\",\\\"name\\\":\\\"Pajak 10%\\\",\\\"price\\\":3000,\\\"quantity\\\":1,\\\"subtotal\\\":3000,\\\"product_url\\\":null,\\\"image_url\\\":null}],\\\"instructions\\\":[{\\\"title\\\":\\\"Pembayaran via QRIS (ShopeePay)\\\",\\\"steps\\\":[\\\"Masuk ke aplikasi dompet digital Anda yang telah mendukung QRIS\\\",\\\"Pindai\\\\\\/Scan QR Code yang tersedia\\\",\\\"Akan muncul detail transaksi. Pastikan data transaksi sudah sesuai\\\",\\\"Selesaikan proses pembayaran Anda\\\",\\\"Transaksi selesai. Simpan bukti pembayaran Anda\\\"]},{\\\"title\\\":\\\"Pembayaran via QRIS (Mobile)\\\",\\\"steps\\\":[\\\"Download QR Code pada invoice\\\",\\\"Masuk ke aplikasi dompet digital Anda yang telah mendukung QRIS\\\",\\\"Upload QR Code yang telah di download tadi\\\",\\\"Akan muncul detail transaksi. Pastikan data transaksi sudah sesuai\\\",\\\"Selesaikan proses pembayaran Anda\\\",\\\"Transaksi selesai. Simpan bukti pembayaran Anda\\\"]}],\\\"qr_string\\\":\\\"SANDBOX MODE\\\",\\\"qr_url\\\":\\\"https:\\\\\\/\\\\\\/tripay.co.id\\\\\\/qr\\\\\\/DEV-T40989245442MEAYS\\\"}}\"', NULL, '2025-06-12 18:52:58', '2025-06-12 18:52:58'),
(9, 9, 'order-9', 'DANA', 38500.00, 1155.00, 0.00, 1155.00, 'Muhammad Dimas Fadilah', 'muhammaddimasfadilla06@gmail.com', '087817584136', '[{\"menu_id\":1,\"sku\":\"DMSNasi Goreng Spesial\",\"name\":\"Nasi Goreng Spesial\",\"price\":\"25000.00\",\"quantity\":1},{\"menu_id\":8,\"sku\":\"DMSPisang Goreng\",\"name\":\"Pisang Goreng\",\"price\":\"10000.00\",\"quantity\":1},{\"sku\":\"TAX10\",\"name\":\"Pajak 10%\",\"price\":3500,\"quantity\":1}]', 'http://127.0.0.1:8000/callback/tripay', NULL, 'https://tripay.co.id/checkout/DEV-T40989245444SZKHN', 1749781577, 'bcd1926622319bbf7c5e48973f56b3872b1f9e5853d929958b1a887fe3c3dbb8', 'UNPAID', 37345.00, '\"{\\\"success\\\":true,\\\"message\\\":\\\"\\\",\\\"data\\\":{\\\"reference\\\":\\\"DEV-T40989245444SZKHN\\\",\\\"merchant_ref\\\":\\\"order-9\\\",\\\"payment_selection_type\\\":\\\"static\\\",\\\"payment_method\\\":\\\"DANA\\\",\\\"payment_name\\\":\\\"DANA\\\",\\\"customer_name\\\":\\\"Muhammad Dimas Fadilah\\\",\\\"customer_email\\\":\\\"muhammaddimasfadilla06@gmail.com\\\",\\\"customer_phone\\\":\\\"087817584136\\\",\\\"callback_url\\\":\\\"http:\\\\\\/\\\\\\/127.0.0.1:8000\\\\\\/callback\\\\\\/tripay\\\",\\\"return_url\\\":null,\\\"amount\\\":38500,\\\"fee_merchant\\\":1155,\\\"fee_customer\\\":0,\\\"total_fee\\\":1155,\\\"amount_received\\\":37345,\\\"pay_code\\\":null,\\\"pay_url\\\":\\\"https:\\\\\\/\\\\\\/tripay.co.id\\\\\\/checkout\\\\\\/DEV-T40989245444SZKHN\\\",\\\"checkout_url\\\":\\\"https:\\\\\\/\\\\\\/tripay.co.id\\\\\\/checkout\\\\\\/DEV-T40989245444SZKHN\\\",\\\"status\\\":\\\"UNPAID\\\",\\\"expired_time\\\":1749781577,\\\"order_items\\\":[{\\\"sku\\\":\\\"DMSNasi Goreng Spesial\\\",\\\"name\\\":\\\"Nasi Goreng Spesial\\\",\\\"price\\\":25000,\\\"quantity\\\":1,\\\"subtotal\\\":25000,\\\"product_url\\\":null,\\\"image_url\\\":null},{\\\"sku\\\":\\\"DMSPisang Goreng\\\",\\\"name\\\":\\\"Pisang Goreng\\\",\\\"price\\\":10000,\\\"quantity\\\":1,\\\"subtotal\\\":10000,\\\"product_url\\\":null,\\\"image_url\\\":null},{\\\"sku\\\":\\\"TAX10\\\",\\\"name\\\":\\\"Pajak 10%\\\",\\\"price\\\":3500,\\\"quantity\\\":1,\\\"subtotal\\\":3500,\\\"product_url\\\":null,\\\"image_url\\\":null}],\\\"instructions\\\":[{\\\"title\\\":\\\"Pembayaran via DANA\\\",\\\"steps\\\":[\\\"Klik tombol Lanjutkan Pembayaran\\\",\\\"Anda akan dipindah ke Halaman Pembayaran DANA \\\",\\\"Pastikan saldo DANA anda cukup\\\",\\\"Masukkan nomor handpone yang terdaftar pada akun DANA\\\",\\\"Anda akan diminta untuk memasukkan PIN DANA Anda\\\",\\\"Kemudian anda akan diminta untuk memasukkan kode OTP yang dikirim ke nomor DANA\\\",\\\"Kemudian akan muncul detail tansaksi pastikan sudah sesuai dengan transaksi yang ingin anda bayar\\\",\\\"Klik tombol <b>PAY<\\\\\\/b>\\\",\\\"Transaksi selesai. Simpan bukti pembayaran Anda\\\"]}]}}\"', NULL, '2025-06-12 18:56:18', '2025-06-12 18:56:18');

-- --------------------------------------------------------

--
-- Struktur dari tabel `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `reservations`
--

CREATE TABLE `reservations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `tel_number` varchar(255) NOT NULL,
  `res_date` datetime NOT NULL,
  `table_id` bigint(20) UNSIGNED NOT NULL,
  `guest_number` int(11) NOT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `reservations`
--

INSERT INTO `reservations` (`id`, `first_name`, `last_name`, `email`, `tel_number`, `res_date`, `table_id`, `guest_number`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Muhammad', 'Fadilah', 'muhammaddimasfadilla06@gmail.com', '0808070', '2025-06-09 20:12:00', 3, 2, 'pending', '2025-06-09 06:14:15', '2025-06-09 06:14:15'),
(2, 'Muhammad', 'Fadilah', 'muhammaddimasfadilla06@gmail.com', '0808070', '2025-06-13 18:52:00', 2, 2, 'pending', '2025-06-12 18:52:57', '2025-06-12 18:52:57');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tables`
--

CREATE TABLE `tables` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `guest_number` int(11) NOT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'available',
  `location` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `tables`
--

INSERT INTO `tables` (`id`, `name`, `guest_number`, `status`, `location`, `created_at`, `updated_at`) VALUES
(1, 'Meja 1', 4, 'available', 'inside', '2025-06-09 05:21:16', '2025-06-09 05:21:16'),
(2, 'Meja 2', 2, 'available', 'outside', '2025-06-09 05:21:16', '2025-06-09 05:21:16'),
(3, 'Meja 3', 6, 'available', 'front', '2025-06-09 05:21:16', '2025-06-09 05:21:16'),
(4, 'Meja 4', 8, 'available', 'inside', '2025-06-09 05:21:16', '2025-06-09 05:21:16'),
(5, 'Meja 10', 12, 'available', 'inside', '2025-06-09 05:21:16', '2025-06-09 05:21:16');

-- --------------------------------------------------------

--
-- Struktur dari tabel `transactions`
--

CREATE TABLE `transactions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `order_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `amount` decimal(15,2) NOT NULL,
  `payment_type` varchar(255) DEFAULT NULL,
  `transaction_status` varchar(255) NOT NULL DEFAULT 'pending',
  `snap_token` varchar(255) DEFAULT NULL,
  `payment_response` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`payment_response`)),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `is_admin` tinyint(1) NOT NULL DEFAULT 0,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `is_admin`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Admin', 'admin@gmail.com', '2025-06-09 05:21:16', '$2y$10$t0sv20N/BeyrjkIm4wW8aeMXrlsGFladd1moZQ2GhCQeF2Gp6hJMW', 1, 'eREYP4N1lKGMOvEtDvQaKX4Zj9F9eNYuGUhfQ6CXYC5ubHmDH5NXNr4VymeG', '2025-06-09 05:21:16', '2025-06-09 05:21:16'),
(2, 'Demo User', 'demo@gmail.com', '2025-06-09 05:21:16', '$2y$10$IJlECKE1ZhZkcrpfs/6Stu7iw72KDeh4lnMubdyN7JjySmrS6hbUS', 0, 'jvQdhmsSGZ', '2025-06-09 05:21:16', '2025-06-09 05:21:16'),
(3, 'Admin', 'admin@example.com', NULL, '$2y$10$d38MYX3u/f2UqHV1BJyVfe9m.bQKBldBgsjY2IvxYnbS2CCWA63oW', 0, NULL, '2025-06-09 05:39:54', '2025-06-09 05:39:54');

-- --------------------------------------------------------

--
-- Struktur dari tabel `user_menu_rekomendasi`
--

CREATE TABLE `user_menu_rekomendasi` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `menu_id` bigint(20) UNSIGNED NOT NULL,
  `rating` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `blogs`
--
ALTER TABLE `blogs`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `category_menu`
--
ALTER TABLE `category_menu`
  ADD KEY `category_menu_category_id_foreign` (`category_id`),
  ADD KEY `category_menu_menu_id_foreign` (`menu_id`);

--
-- Indeks untuk tabel `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indeks untuk tabel `kokis`
--
ALTER TABLE `kokis`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `kokis_email_unique` (`email`);

--
-- Indeks untuk tabel `menus`
--
ALTER TABLE `menus`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `sku` (`sku`),
  ADD KEY `menus_category_id_foreign` (`category_id`);

--
-- Indeks untuk tabel `menu_order`
--
ALTER TABLE `menu_order`
  ADD PRIMARY KEY (`id`),
  ADD KEY `menu_order_menu_id_foreign` (`menu_id`),
  ADD KEY `menu_order_order_id_foreign` (`order_id`);

--
-- Indeks untuk tabel `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `orders_table_id_foreign` (`table_id`),
  ADD KEY `orders_reservation_id_foreign` (`reservation_id`);

--
-- Indeks untuk tabel `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_items_order_id_foreign` (`order_id`);

--
-- Indeks untuk tabel `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indeks untuk tabel `payment_transactions`
--
ALTER TABLE `payment_transactions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `payment_transactions_order_id_foreign` (`order_id`);

--
-- Indeks untuk tabel `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indeks untuk tabel `reservations`
--
ALTER TABLE `reservations`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `tables`
--
ALTER TABLE `tables`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `transactions`
--
ALTER TABLE `transactions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `transactions_order_id_foreign` (`order_id`),
  ADD KEY `transactions_user_id_foreign` (`user_id`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Indeks untuk tabel `user_menu_rekomendasi`
--
ALTER TABLE `user_menu_rekomendasi`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `blogs`
--
ALTER TABLE `blogs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `categories`
--
ALTER TABLE `categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `kokis`
--
ALTER TABLE `kokis`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `menus`
--
ALTER TABLE `menus`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT untuk tabel `menu_order`
--
ALTER TABLE `menu_order`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT untuk tabel `orders`
--
ALTER TABLE `orders`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT untuk tabel `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT untuk tabel `payment_transactions`
--
ALTER TABLE `payment_transactions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT untuk tabel `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `reservations`
--
ALTER TABLE `reservations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `tables`
--
ALTER TABLE `tables`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT untuk tabel `transactions`
--
ALTER TABLE `transactions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `user_menu_rekomendasi`
--
ALTER TABLE `user_menu_rekomendasi`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `category_menu`
--
ALTER TABLE `category_menu`
  ADD CONSTRAINT `category_menu_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`),
  ADD CONSTRAINT `category_menu_menu_id_foreign` FOREIGN KEY (`menu_id`) REFERENCES `menus` (`id`);

--
-- Ketidakleluasaan untuk tabel `menus`
--
ALTER TABLE `menus`
  ADD CONSTRAINT `menus_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `menu_order`
--
ALTER TABLE `menu_order`
  ADD CONSTRAINT `menu_order_menu_id_foreign` FOREIGN KEY (`menu_id`) REFERENCES `menus` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `menu_order_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_reservation_id_foreign` FOREIGN KEY (`reservation_id`) REFERENCES `reservations` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `orders_table_id_foreign` FOREIGN KEY (`table_id`) REFERENCES `tables` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `payment_transactions`
--
ALTER TABLE `payment_transactions`
  ADD CONSTRAINT `payment_transactions_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `transactions`
--
ALTER TABLE `transactions`
  ADD CONSTRAINT `transactions_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `transactions_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
