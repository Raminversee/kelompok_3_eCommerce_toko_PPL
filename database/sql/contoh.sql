-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Versi server:                 8.4.3 - MySQL Community Server - GPL
-- OS Server:                    Win64
-- HeidiSQL Versi:               12.8.0.6908
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

-- membuang struktur untuk table contoh.detail_pesanans
CREATE TABLE IF NOT EXISTS `detail_pesanans` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `pesanan_id` bigint unsigned NOT NULL,
  `produk_id` bigint unsigned DEFAULT NULL,
  `nama_produk` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `sku` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `qty` int NOT NULL,
  `harga` decimal(12,2) NOT NULL,
  `subtotal` decimal(12,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `detail_pesanans_pesanan_id_foreign` (`pesanan_id`),
  KEY `detail_pesanans_produk_id_foreign` (`produk_id`),
  CONSTRAINT `detail_pesanans_pesanan_id_foreign` FOREIGN KEY (`pesanan_id`) REFERENCES `pesanans` (`id`) ON DELETE CASCADE,
  CONSTRAINT `detail_pesanans_produk_id_foreign` FOREIGN KEY (`produk_id`) REFERENCES `produks` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Membuang data untuk tabel contoh.detail_pesanans: ~0 rows (lebih kurang)
INSERT INTO `detail_pesanans` (`id`, `pesanan_id`, `produk_id`, `nama_produk`, `sku`, `qty`, `harga`, `subtotal`, `created_at`, `updated_at`) VALUES
	(3, 3, 3, 'shower', 'SHOWER-SS-002', 1, 520000.00, 520000.00, '2026-05-01 20:38:33', '2026-05-01 20:38:33');

-- membuang struktur untuk table contoh.failed_jobs
CREATE TABLE IF NOT EXISTS `failed_jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Membuang data untuk tabel contoh.failed_jobs: ~0 rows (lebih kurang)

-- membuang struktur untuk table contoh.keranjangs
CREATE TABLE IF NOT EXISTS `keranjangs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned NOT NULL,
  `produk_id` bigint unsigned NOT NULL,
  `qty` int NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `keranjangs_user_id_produk_id_unique` (`user_id`,`produk_id`),
  KEY `keranjangs_produk_id_foreign` (`produk_id`),
  CONSTRAINT `keranjangs_produk_id_foreign` FOREIGN KEY (`produk_id`) REFERENCES `produks` (`id`) ON DELETE CASCADE,
  CONSTRAINT `keranjangs_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Membuang data untuk tabel contoh.keranjangs: ~0 rows (lebih kurang)
INSERT INTO `keranjangs` (`id`, `user_id`, `produk_id`, `qty`, `created_at`, `updated_at`) VALUES
	(17, 2, 1, 11, '2026-05-02 19:20:53', '2026-05-02 19:23:29');

-- membuang struktur untuk table contoh.migrations
CREATE TABLE IF NOT EXISTS `migrations` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Membuang data untuk tabel contoh.migrations: ~7 rows (lebih kurang)
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
	(1, '2014_10_12_000000_create_users_table', 1),
	(2, '2014_10_12_100000_create_password_resets_table', 1),
	(3, '2019_08_19_000000_create_failed_jobs_table', 1),
	(4, '2019_12_14_000001_create_personal_access_tokens_table', 1),
	(5, '2026_04_26_110659_create_produks_table', 1),
	(6, '2026_04_26_113006_add_spesifikasi_to_produks_table', 1),
	(7, '2026_04_26_161517_create_keranjangs_table', 1),
	(8, '2026_04_26_161651_create_pesanans_table', 1),
	(9, '2026_04_26_161708_create_detail_pesanans_table', 1),
	(10, '2026_04_27_065644_add_is_admin_to_users_table', 2),
	(11, '2026_04_27_073750_add_min_stok_to_produks_table', 3),
	(12, '2026_04_28_003612_add_profile_fields_to_users_table', 4),
	(13, '2026_04_28_013538_add_extra_fields_to_produks_table', 5),
	(14, '2026_04_29_080240_add_foto_to_users_table', 6),
	(15, '2026_05_02_034602_create_promos_table', 7),
	(16, '2026_05_02_035502_create_vouchers_table', 8),
	(17, '2026_05_04_013124_create_suppliers_table', 9),
	(18, '2026_05_04_013741_add_supplier_id_to_produks_table', 9);

-- membuang struktur untuk table contoh.password_resets
CREATE TABLE IF NOT EXISTS `password_resets` (
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Membuang data untuk tabel contoh.password_resets: ~0 rows (lebih kurang)

-- membuang struktur untuk table contoh.personal_access_tokens
CREATE TABLE IF NOT EXISTS `personal_access_tokens` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint unsigned NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Membuang data untuk tabel contoh.personal_access_tokens: ~0 rows (lebih kurang)

-- membuang struktur untuk table contoh.pesanans
CREATE TABLE IF NOT EXISTS `pesanans` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `kode_pesanan` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint unsigned NOT NULL,
  `nama_penerima` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `telepon` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `alamat` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `kota` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `provinsi` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `kode_pos` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `subtotal` decimal(12,2) NOT NULL DEFAULT '0.00',
  `ongkir` decimal(12,2) NOT NULL DEFAULT '50000.00',
  `total` decimal(12,2) NOT NULL DEFAULT '0.00',
  `voucher_kode` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `diskon` decimal(15,2) NOT NULL DEFAULT '0.00',
  `status` enum('menunggu_pembayaran','menunggu_verifikasi','diproses','dikirim','selesai','dibatalkan') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'menunggu_pembayaran',
  `bukti_transfer` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bukti_uploaded_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `pesanans_kode_pesanan_unique` (`kode_pesanan`),
  KEY `pesanans_user_id_foreign` (`user_id`),
  CONSTRAINT `pesanans_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Membuang data untuk tabel contoh.pesanans: ~0 rows (lebih kurang)
INSERT INTO `pesanans` (`id`, `kode_pesanan`, `user_id`, `nama_penerima`, `telepon`, `alamat`, `kota`, `provinsi`, `kode_pos`, `subtotal`, `ongkir`, `total`, `voucher_kode`, `diskon`, `status`, `bukti_transfer`, `bukti_uploaded_at`, `created_at`, `updated_at`) VALUES
	(3, 'PBS-20260502-D5357', 2, 'ikhsan', '0872283528353', 'Jl. Raya Tugu Proklamasi, R.Dengklok Sel., Kec. R.Dengklok, Karawang, Jawa Barat 41352', 'karawang', 'jawa barat', '41352', 520000.00, 50000.00, 570000.00, NULL, 0.00, 'selesai', 'bukti_transfer/EEqVyAMOohBKRCpJWhglWVGDIEAZGL4W2I2DWejy.jpg', '2026-05-01 20:40:04', '2026-05-01 20:38:33', '2026-05-01 20:40:51');

-- membuang struktur untuk table contoh.produks
CREATE TABLE IF NOT EXISTS `produks` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `supplier_id` bigint unsigned DEFAULT NULL,
  `nama` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `sku` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `kategori` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `deskripsi` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `spesifikasi` json DEFAULT NULL,
  `harga` decimal(12,2) NOT NULL,
  `harga_coret` decimal(12,2) DEFAULT NULL,
  `diskon_persen` int DEFAULT NULL,
  `stok` int NOT NULL DEFAULT '0',
  `min_stok` int NOT NULL DEFAULT '10',
  `gambar` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_published` tinyint(1) NOT NULL DEFAULT '1',
  `berat` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `dimensi` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `material` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_promo` tinyint(1) NOT NULL DEFAULT '0',
  `is_new` tinyint(1) NOT NULL DEFAULT '0',
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `produks_slug_unique` (`slug`),
  UNIQUE KEY `produks_sku_unique` (`sku`),
  KEY `produks_supplier_id_foreign` (`supplier_id`),
  CONSTRAINT `produks_supplier_id_foreign` FOREIGN KEY (`supplier_id`) REFERENCES `suppliers` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Membuang data untuk tabel contoh.produks: ~3 rows (lebih kurang)
INSERT INTO `produks` (`id`, `supplier_id`, `nama`, `slug`, `sku`, `kategori`, `deskripsi`, `spesifikasi`, `harga`, `harga_coret`, `diskon_persen`, `stok`, `min_stok`, `gambar`, `is_published`, `berat`, `dimensi`, `material`, `is_promo`, `is_new`, `is_active`, `created_at`, `updated_at`) VALUES
	(1, NULL, 'kran', 'keran', 'KRN-SS-001', 'Kran & Shower', 'test', NULL, 52000.00, NULL, NULL, 16, 10, 'produk/yd4DtVU9uuucyGd0D4Xcdv5IwZvW7o39ZQ7PagY1.jpg', 1, NULL, NULL, NULL, 0, 0, 1, '2026-04-27 20:29:41', '2026-04-29 22:13:02'),
	(3, NULL, 'shower', 'shower-2', 'SHOWER-SS-002', 'Kran & Shower', 'tes', NULL, 520000.00, NULL, NULL, 519, 10, 'produk/1777521525_shower2.jfif', 1, NULL, NULL, NULL, 0, 0, 1, '2026-04-29 20:58:45', '2026-05-01 20:38:33'),
	(4, NULL, 'tutup closet', 'tutup-closet', 'TUTUP CLOSET 01', 'Dudukan Kloset', 'coba', NULL, 220000.00, NULL, NULL, 120, 10, 'produk/1777523098_tutup closet.jfif', 1, NULL, NULL, NULL, 0, 0, 1, '2026-04-29 21:24:58', '2026-04-29 21:24:58');

-- membuang struktur untuk table contoh.promos
CREATE TABLE IF NOT EXISTS `promos` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `judul` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `deskripsi` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `gambar` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `badge_text` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'cth: HEMAT 20%, GRATIS ONGKIR',
  `badge_color` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'red' COMMENT 'red, blue, green, orange',
  `tanggal_mulai` date DEFAULT NULL,
  `tanggal_selesai` date DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `urutan` int NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `promos_slug_unique` (`slug`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Membuang data untuk tabel contoh.promos: ~0 rows (lebih kurang)
INSERT INTO `promos` (`id`, `judul`, `slug`, `deskripsi`, `gambar`, `badge_text`, `badge_color`, `tanggal_mulai`, `tanggal_selesai`, `is_active`, `urutan`, `created_at`, `updated_at`) VALUES
	(1, 'diskon 20 ribu', 'produk-murah-1777696238', 'kode voucher 021545', 'promo/ikUsSd7XD71UuZIefGIb8upRqAWQ2IbUJarNagzq.jpg', 'hemat banget', 'red', '2026-05-02', '2026-05-06', 1, 1, '2026-05-01 21:30:38', '2026-05-02 20:34:41');

-- membuang struktur untuk table contoh.users
CREATE TABLE IF NOT EXISTS `users` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `telepon` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `alamat` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `is_admin` tinyint(1) NOT NULL DEFAULT '0',
  `phone` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `foto` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `last_login_at` timestamp NULL DEFAULT NULL,
  `role` enum('pelanggan','admin') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pelanggan',
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Membuang data untuk tabel contoh.users: ~0 rows (lebih kurang)
INSERT INTO `users` (`id`, `name`, `email`, `telepon`, `alamat`, `is_admin`, `phone`, `address`, `foto`, `is_active`, `last_login_at`, `role`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
	(2, 'ikhsan', 'ikhsan1@gmail.com', NULL, NULL, 0, NULL, NULL, 'users/79TeoXqmjL0rRrJs5xgjRXcSLeDFlFiGxUEV3Pf6.png', 1, '2026-05-02 20:34:50', 'pelanggan', NULL, '$2y$10$k0ZOvPcM8jYIb7ppm76LAulXojhXdU8jVw8ZZKepBTHYd865/aj5a', 'kjjOnURCjFjbiP6hgJcTfZMEpE85mVZtO0jg4FPQa1g9skOOEtE39tU0SGEo', '2026-04-28 02:59:46', '2026-05-02 20:34:50'),
	(4, 'admin', 'admin@gmail.com', NULL, NULL, 0, '087877438920', NULL, NULL, 1, '2026-05-05 04:50:47', 'admin', NULL, '$2y$10$7qBhPBEFNorSmtgOy1S.oOe.HHXBHA0XSuFcWVBTTroesZZcCMHCK', NULL, '2026-04-29 21:20:19', '2026-05-05 04:50:47');

-- membuang struktur untuk table contoh.vouchers
CREATE TABLE IF NOT EXISTS `vouchers` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `kode` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `tipe` enum('persen','nominal') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'nominal',
  `nilai` decimal(15,2) NOT NULL,
  `min_belanja` decimal(15,2) NOT NULL DEFAULT '0.00',
  `maks_diskon` decimal(15,2) DEFAULT NULL,
  `kuota` int DEFAULT NULL,
  `terpakai` int NOT NULL DEFAULT '0',
  `tanggal_mulai` date DEFAULT NULL,
  `tanggal_selesai` date DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `vouchers_kode_unique` (`kode`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Membuang data untuk tabel contoh.vouchers: ~1 rows (lebih kurang)
INSERT INTO `vouchers` (`id`, `kode`, `nama`, `tipe`, `nilai`, `min_belanja`, `maks_diskon`, `kuota`, `terpakai`, `tanggal_mulai`, `tanggal_selesai`, `is_active`, `created_at`, `updated_at`) VALUES
	(2, '021545', 'ongkir murah', 'nominal', 20000.00, 200000.00, NULL, 2, 0, '2026-05-03', '2026-05-05', 1, '2026-05-02 19:19:57', '2026-05-02 19:19:57');

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
