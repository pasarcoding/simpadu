-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Waktu pembuatan: 01 Des 2025 pada 07.41
-- Versi server: 11.8.3-MariaDB-log
-- Versi PHP: 7.2.34

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `u166613184_sipandu`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `appearance_menus`
--

CREATE TABLE `appearance_menus` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `parent_id` bigint(20) UNSIGNED DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `url` text DEFAULT NULL,
  `type` varchar(255) NOT NULL,
  `behaviour_target` varchar(255) NOT NULL,
  `page_origin` varchar(255) NOT NULL,
  `appearance_page_id` bigint(20) UNSIGNED DEFAULT NULL,
  `default_page_id` varchar(255) DEFAULT NULL,
  `order` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `appearance_menus`
--

INSERT INTO `appearance_menus` (`id`, `parent_id`, `name`, `url`, `type`, `behaviour_target`, `page_origin`, `appearance_page_id`, `default_page_id`, `order`, `created_at`, `updated_at`) VALUES
(1, NULL, 'Profil Desa', NULL, 'header', 'keep', 'in', NULL, 'um-0', '1', '2025-11-28 14:40:37', '2025-11-28 14:40:37'),
(2, 1, 'Aparatur Desa', NULL, 'header', 'keep', 'in', NULL, 'um-1', '1', '2025-11-28 14:40:37', '2025-11-28 14:40:37'),
(3, 1, 'Sejarah Desa', NULL, 'header', 'keep', 'in', NULL, 'um-2', '2', '2025-11-28 14:40:37', '2025-11-28 14:40:37'),
(4, 1, 'Visi & Misi Desa', NULL, 'header', 'keep', 'in', NULL, 'um-3', '3', '2025-11-28 14:40:37', '2025-11-28 14:40:37'),
(5, NULL, 'Informasi Desa', NULL, 'header', 'keep', 'in', NULL, 'um-0', '2', '2025-11-28 14:40:37', '2025-11-28 14:40:37'),
(6, 5, 'Pengumuman', NULL, 'header', 'keep', 'in', NULL, 'um-4', '1', '2025-11-28 14:40:37', '2025-11-28 14:40:37'),
(7, 5, 'Berita', NULL, 'header', 'keep', 'in', NULL, 'um-5', '2', '2025-11-28 14:40:37', '2025-11-28 14:40:37'),
(8, NULL, 'Data Statistik', NULL, 'header', 'keep', 'in', NULL, 'um-6', '3', '2025-11-28 14:40:37', '2025-11-28 14:40:37'),
(9, NULL, 'Kontak', NULL, 'header', 'keep', 'in', NULL, 'um-7', '4', '2025-11-28 14:40:37', '2025-11-28 14:40:37'),
(10, NULL, 'Pengumuman', NULL, 'footer', 'keep', 'in', NULL, 'um-4', '5', '2025-11-28 14:40:37', '2025-11-28 14:40:37'),
(11, NULL, 'Visi & Misi Desa', NULL, 'footer', 'keep', 'in', NULL, 'um-3', '6', '2025-11-28 14:40:37', '2025-11-28 14:40:37'),
(12, NULL, 'Sejarah Desa', NULL, 'footer', 'keep', 'in', NULL, 'um-2', '7', '2025-11-28 14:40:37', '2025-11-28 14:40:37'),
(13, NULL, 'Aparatur Desa', NULL, 'footer', 'keep', 'in', NULL, 'um-1', '8', '2025-11-28 14:40:37', '2025-11-28 14:40:37'),
(14, NULL, 'Produk Desa', NULL, 'footer', 'keep', 'in', NULL, 'um-8', '9', '2025-11-28 14:40:37', '2025-11-28 14:40:37');

-- --------------------------------------------------------

--
-- Struktur dari tabel `appearance_pages`
--

CREATE TABLE `appearance_pages` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `budgets`
--

CREATE TABLE `budgets` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `account_name` varchar(255) NOT NULL,
  `bank_name` varchar(255) NOT NULL,
  `bank_number` varchar(255) NOT NULL,
  `type` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `critique_suggestions`
--

CREATE TABLE `critique_suggestions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `subject` text NOT NULL,
  `content` text NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `e_letter_submissions`
--

CREATE TABLE `e_letter_submissions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `e_letter_template_id` bigint(20) UNSIGNED NOT NULL,
  `resident_id` bigint(20) UNSIGNED DEFAULT NULL,
  `national_id` varchar(255) NOT NULL,
  `letter_number` varchar(255) NOT NULL,
  `list_variable_with_values` text NOT NULL,
  `whatsapp_number` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `e_letter_templates`
--

CREATE TABLE `e_letter_templates` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `last_sequence_number` bigint(20) UNSIGNED NOT NULL DEFAULT 0,
  `padding_sequence_length` tinyint(3) UNSIGNED NOT NULL DEFAULT 1,
  `list_variables` text NOT NULL,
  `file` text NOT NULL,
  `status` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `e_letter_templates`
--

INSERT INTO `e_letter_templates` (`id`, `name`, `last_sequence_number`, `padding_sequence_length`, `list_variables`, `file`, `status`, `created_at`, `updated_at`) VALUES
(2, 'SURAT IZIN KERAMAIAN', 108, 3, '[{\"variable\":\"text::nama_penduduk(Nama Lengkap)\",\"format\":\"text\",\"name\":\"nama_penduduk\",\"label\":\"Nama Lengkap\"},{\"variable\":\"text::tempat_lahir_penduduk(Tempat Lahir)\",\"format\":\"text\",\"name\":\"tempat_lahir_penduduk\",\"label\":\"Tempat Lahir\"},{\"variable\":\"text::tanggal_lahir_penduduk(Tanggal Lahir)\",\"format\":\"text\",\"name\":\"tanggal_lahir_penduduk\",\"label\":\"Tanggal Lahir\"},{\"variable\":\"text::kewarganegaraan_penduduk(Kewarganegaraan)\",\"format\":\"text\",\"name\":\"kewarganegaraan_penduduk\",\"label\":\"Kewarganegaraan\"},{\"variable\":\"text::nik_penduduk(NIK)\",\"format\":\"text\",\"name\":\"nik_penduduk\",\"label\":\"NIK\"},{\"variable\":\"text::alamat_penduduk(Alamat)\",\"format\":\"text\",\"name\":\"alamat_penduduk\",\"label\":\"Alamat\"},{\"variable\":\"text::dusun_penduduk(Dusun)\",\"format\":\"text\",\"name\":\"dusun_penduduk\",\"label\":\"Dusun\"},{\"variable\":\"text::nama_acara(Nama Acara)\",\"format\":\"text\",\"name\":\"nama_acara\",\"label\":\"Nama Acara\"},{\"variable\":\"text::dari_tanggal(Acara Dari tanggal)\",\"format\":\"text\",\"name\":\"dari_tanggal\",\"label\":\"Acara Dari tanggal\"},{\"variable\":\"text::sampai_tanggal(Acara Sampai Tanggal)\",\"format\":\"text\",\"name\":\"sampai_tanggal\",\"label\":\"Acara Sampai Tanggal\"},{\"variable\":\"text::nama_hiburan(Nama Hiburan(Jaranan))\",\"format\":\"text\",\"name\":\"nama_hiburan\",\"label\":\"Nama Hiburan(Jaranan)\"},{\"variable\":\"image::pengantar_rt(Surat Pengantar R)\",\"format\":\"image\",\"name\":\"pengantar_rt\",\"label\":\"Surat Pengantar R\"}]', 'e_letter_template/s8HaFNxnJ3SSrN5QAnLfxYx7GNxTv97feCh6t4GZ.docx', 'active', '2025-11-30 04:35:50', '2025-12-01 00:44:53');

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
-- Struktur dari tabel `galleries`
--

CREATE TABLE `galleries` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `informations`
--

CREATE TABLE `informations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `thumbnail` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `item_budgets`
--

CREATE TABLE `item_budgets` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `budget_id` bigint(20) UNSIGNED NOT NULL,
  `nominal` varchar(255) NOT NULL,
  `type` varchar(255) NOT NULL,
  `note` text NOT NULL,
  `payment_at` date NOT NULL,
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
(5, '2025_10_24_095744_create_residents_table', 1),
(6, '2025_10_25_135810_create_informations_table', 1),
(7, '2025_10_27_115818_create_news_table', 1),
(8, '2025_10_27_120659_create_news_comments_table', 1),
(9, '2025_10_27_135150_create_village_official_greetings_table', 1),
(10, '2025_10_27_135157_create_village_official_members_table', 1),
(11, '2025_10_28_135450_create_galleries_table', 1),
(12, '2025_10_28_151206_create_budgets_table', 1),
(13, '2025_10_28_151235_create_item_budgets_table', 1),
(14, '2025_10_29_072053_create_synergy_programs_table', 1),
(15, '2025_10_29_075100_create_products_table', 1),
(16, '2025_10_29_124802_create_appearance_pages_table', 1),
(17, '2025_10_29_124803_create_appearance_menus_table', 1),
(18, '2025_10_31_122740_create_permission_tables', 1),
(19, '2025_11_07_061629_create_e_letter_templates_table', 1),
(20, '2025_11_07_061653_create_e_letter_submissions_table', 1),
(21, '2025_11_08_120023_create_village_official_histories_table', 1),
(22, '2025_11_08_120229_create_village_official_vision_missions_table', 1),
(23, '2025_11_15_123909_create_settings_table', 1),
(24, '2025_11_17_122654_create_critique_suggestions_table', 1),
(25, '2025_11_25_122134_create_resident_forms_table', 1),
(26, '2025_11_26_042421_create_resident_form_values_table', 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `model_has_permissions`
--

CREATE TABLE `model_has_permissions` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(255) NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `model_has_roles`
--

CREATE TABLE `model_has_roles` (
  `role_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(255) NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `model_has_roles`
--

INSERT INTO `model_has_roles` (`role_id`, `model_type`, `model_id`) VALUES
(1, 'App\\Models\\User', 1),
(2, 'App\\Models\\User', 2);

-- --------------------------------------------------------

--
-- Struktur dari tabel `news`
--

CREATE TABLE `news` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `thumbnail` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL,
  `views` bigint(20) UNSIGNED NOT NULL DEFAULT 0,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `news_comments`
--

CREATE TABLE `news_comments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `news_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `website` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
-- Struktur dari tabel `permissions`
--

CREATE TABLE `permissions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `guard_name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `permissions`
--

INSERT INTO `permissions` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(1, 'dashboard_view', 'web', '2025-11-28 14:40:37', '2025-11-28 14:40:37'),
(2, 'resident_view', 'web', '2025-11-28 14:40:37', '2025-11-28 14:40:37'),
(3, 'resident_create', 'web', '2025-11-28 14:40:37', '2025-11-28 14:40:37'),
(4, 'resident_edit', 'web', '2025-11-28 14:40:37', '2025-11-28 14:40:37'),
(5, 'resident_delete', 'web', '2025-11-28 14:40:37', '2025-11-28 14:40:37'),
(6, 'resident_detail_view', 'web', '2025-11-28 14:40:37', '2025-11-28 14:40:37'),
(7, 'resident_import_view', 'web', '2025-11-28 14:40:37', '2025-11-28 14:40:37'),
(8, 'resident_export_view', 'web', '2025-11-28 14:40:37', '2025-11-28 14:40:37'),
(9, 'resident_form_view', 'web', '2025-11-28 14:40:37', '2025-11-28 14:40:37'),
(10, 'resident_form_create', 'web', '2025-11-28 14:40:37', '2025-11-28 14:40:37'),
(11, 'resident_form_edit', 'web', '2025-11-28 14:40:37', '2025-11-28 14:40:37'),
(12, 'resident_form_delete', 'web', '2025-11-28 14:40:37', '2025-11-28 14:40:37'),
(13, 'information_view', 'web', '2025-11-28 14:40:37', '2025-11-28 14:40:37'),
(14, 'information_create', 'web', '2025-11-28 14:40:37', '2025-11-28 14:40:37'),
(15, 'information_edit', 'web', '2025-11-28 14:40:37', '2025-11-28 14:40:37'),
(16, 'information_delete', 'web', '2025-11-28 14:40:37', '2025-11-28 14:40:37'),
(17, 'news_view', 'web', '2025-11-28 14:40:37', '2025-11-28 14:40:37'),
(18, 'news_create', 'web', '2025-11-28 14:40:37', '2025-11-28 14:40:37'),
(19, 'news_edit', 'web', '2025-11-28 14:40:37', '2025-11-28 14:40:37'),
(20, 'news_delete', 'web', '2025-11-28 14:40:37', '2025-11-28 14:40:37'),
(21, 'news_comment_view', 'web', '2025-11-28 14:40:37', '2025-11-28 14:40:37'),
(22, 'news_comment_delete', 'web', '2025-11-28 14:40:37', '2025-11-28 14:40:37'),
(23, 'village_official_greeting_view', 'web', '2025-11-28 14:40:37', '2025-11-28 14:40:37'),
(24, 'village_official_greeting_edit', 'web', '2025-11-28 14:40:37', '2025-11-28 14:40:37'),
(25, 'village_official_greeting_delete', 'web', '2025-11-28 14:40:37', '2025-11-28 14:40:37'),
(26, 'village_official_history_view', 'web', '2025-11-28 14:40:37', '2025-11-28 14:40:37'),
(27, 'village_official_history_edit', 'web', '2025-11-28 14:40:37', '2025-11-28 14:40:37'),
(28, 'village_official_history_delete', 'web', '2025-11-28 14:40:37', '2025-11-28 14:40:37'),
(29, 'village_official_vision_mission_view', 'web', '2025-11-28 14:40:37', '2025-11-28 14:40:37'),
(30, 'village_official_vision_mission_edit', 'web', '2025-11-28 14:40:37', '2025-11-28 14:40:37'),
(31, 'village_official_vision_mission_delete', 'web', '2025-11-28 14:40:37', '2025-11-28 14:40:37'),
(32, 'village_official_member_view', 'web', '2025-11-28 14:40:37', '2025-11-28 14:40:37'),
(33, 'village_official_member_create', 'web', '2025-11-28 14:40:37', '2025-11-28 14:40:37'),
(34, 'village_official_member_edit', 'web', '2025-11-28 14:40:37', '2025-11-28 14:40:37'),
(35, 'village_official_member_delete', 'web', '2025-11-28 14:40:37', '2025-11-28 14:40:37'),
(36, 'gallery_view', 'web', '2025-11-28 14:40:37', '2025-11-28 14:40:37'),
(37, 'gallery_create', 'web', '2025-11-28 14:40:37', '2025-11-28 14:40:37'),
(38, 'gallery_delete', 'web', '2025-11-28 14:40:37', '2025-11-28 14:40:37'),
(39, 'budget_view', 'web', '2025-11-28 14:40:37', '2025-11-28 14:40:37'),
(40, 'budget_create', 'web', '2025-11-28 14:40:37', '2025-11-28 14:40:37'),
(41, 'budget_edit', 'web', '2025-11-28 14:40:37', '2025-11-28 14:40:37'),
(42, 'budget_delete', 'web', '2025-11-28 14:40:37', '2025-11-28 14:40:37'),
(43, 'budget_detail_view', 'web', '2025-11-28 14:40:37', '2025-11-28 14:40:37'),
(44, 'budget_detail_create', 'web', '2025-11-28 14:40:37', '2025-11-28 14:40:37'),
(45, 'budget_detail_delete', 'web', '2025-11-28 14:40:37', '2025-11-28 14:40:37'),
(46, 'synergy_program_view', 'web', '2025-11-28 14:40:37', '2025-11-28 14:40:37'),
(47, 'synergy_program_create', 'web', '2025-11-28 14:40:37', '2025-11-28 14:40:37'),
(48, 'synergy_program_delete', 'web', '2025-11-28 14:40:37', '2025-11-28 14:40:37'),
(49, 'product_view', 'web', '2025-11-28 14:40:37', '2025-11-28 14:40:37'),
(50, 'product_create', 'web', '2025-11-28 14:40:37', '2025-11-28 14:40:37'),
(51, 'product_edit', 'web', '2025-11-28 14:40:37', '2025-11-28 14:40:37'),
(52, 'product_delete', 'web', '2025-11-28 14:40:37', '2025-11-28 14:40:37'),
(53, 'appearance_menu_view', 'web', '2025-11-28 14:40:37', '2025-11-28 14:40:37'),
(54, 'appearance_menu_create', 'web', '2025-11-28 14:40:37', '2025-11-28 14:40:37'),
(55, 'appearance_menu_edit', 'web', '2025-11-28 14:40:37', '2025-11-28 14:40:37'),
(56, 'appearance_menu_delete', 'web', '2025-11-28 14:40:37', '2025-11-28 14:40:37'),
(57, 'appearance_page_view', 'web', '2025-11-28 14:40:37', '2025-11-28 14:40:37'),
(58, 'appearance_page_create', 'web', '2025-11-28 14:40:37', '2025-11-28 14:40:37'),
(59, 'appearance_page_edit', 'web', '2025-11-28 14:40:37', '2025-11-28 14:40:37'),
(60, 'appearance_page_delete', 'web', '2025-11-28 14:40:37', '2025-11-28 14:40:37'),
(61, 'access_user_view', 'web', '2025-11-28 14:40:37', '2025-11-28 14:40:37'),
(62, 'access_user_create', 'web', '2025-11-28 14:40:37', '2025-11-28 14:40:37'),
(63, 'access_user_edit', 'web', '2025-11-28 14:40:37', '2025-11-28 14:40:37'),
(64, 'access_user_delete', 'web', '2025-11-28 14:40:37', '2025-11-28 14:40:37'),
(65, 'access_role_permission_view', 'web', '2025-11-28 14:40:37', '2025-11-28 14:40:37'),
(66, 'access_role_permission_create', 'web', '2025-11-28 14:40:37', '2025-11-28 14:40:37'),
(67, 'access_role_permission_edit', 'web', '2025-11-28 14:40:37', '2025-11-28 14:40:37'),
(68, 'access_role_permission_delete', 'web', '2025-11-28 14:40:37', '2025-11-28 14:40:37'),
(69, 'e_letter_template_view', 'web', '2025-11-28 14:40:37', '2025-11-28 14:40:37'),
(70, 'e_letter_template_create', 'web', '2025-11-28 14:40:37', '2025-11-28 14:40:37'),
(71, 'e_letter_template_edit', 'web', '2025-11-28 14:40:37', '2025-11-28 14:40:37'),
(72, 'e_letter_template_delete', 'web', '2025-11-28 14:40:37', '2025-11-28 14:40:37'),
(73, 'e_letter_submission_view', 'web', '2025-11-28 14:40:37', '2025-11-28 14:40:37'),
(74, 'e_letter_submission_edit', 'web', '2025-11-28 14:40:37', '2025-11-28 14:40:37'),
(75, 'e_letter_submission_delete', 'web', '2025-11-28 14:40:37', '2025-11-28 14:40:37'),
(76, 'e_letter_submission_detail_view', 'web', '2025-11-28 14:40:37', '2025-11-28 14:40:37'),
(77, 'critique_suggestion_view', 'web', '2025-11-28 14:40:37', '2025-11-28 14:40:37'),
(78, 'critique_suggestion_delete', 'web', '2025-11-28 14:40:37', '2025-11-28 14:40:37'),
(79, 'setting_manage', 'web', '2025-11-28 14:40:37', '2025-11-28 14:40:37');

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
-- Struktur dari tabel `products`
--

CREATE TABLE `products` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `price` varchar(255) NOT NULL,
  `whatsapp_number` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `image` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `residents`
--

CREATE TABLE `residents` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `national_id` varchar(255) NOT NULL,
  `full_name` varchar(255) NOT NULL,
  `gender` varchar(255) NOT NULL,
  `birth_place` varchar(255) NOT NULL,
  `birth_date` date NOT NULL,
  `religion` varchar(255) NOT NULL,
  `job` varchar(255) NOT NULL,
  `other_job` varchar(255) DEFAULT NULL,
  `last_education` varchar(255) NOT NULL,
  `marital_status` varchar(255) NOT NULL,
  `family_relationship` varchar(255) NOT NULL,
  `family_card_number` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `rt` varchar(255) NOT NULL,
  `rw` varchar(255) NOT NULL,
  `hamlet_village` varchar(255) DEFAULT NULL,
  `death_status` varchar(255) NOT NULL,
  `transfer_date` date DEFAULT NULL,
  `citizenship` varchar(255) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `resident_forms`
--

CREATE TABLE `resident_forms` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` text NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `resident_form_values`
--

CREATE TABLE `resident_form_values` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `resident_id` bigint(20) UNSIGNED NOT NULL,
  `resident_form_id` bigint(20) UNSIGNED NOT NULL,
  `value` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `roles`
--

CREATE TABLE `roles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `guard_name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `roles`
--

INSERT INTO `roles` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(1, 'admin', 'web', '2025-11-28 14:40:37', '2025-11-28 14:40:37'),
(2, 'admin penduduk', 'web', '2025-11-30 04:45:37', '2025-11-30 04:45:37');

-- --------------------------------------------------------

--
-- Struktur dari tabel `role_has_permissions`
--

CREATE TABLE `role_has_permissions` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `role_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `role_has_permissions`
--

INSERT INTO `role_has_permissions` (`permission_id`, `role_id`) VALUES
(1, 1),
(2, 1),
(3, 1),
(4, 1),
(5, 1),
(6, 1),
(7, 1),
(8, 1),
(9, 1),
(10, 1),
(11, 1),
(12, 1),
(13, 1),
(14, 1),
(15, 1),
(16, 1),
(17, 1),
(18, 1),
(19, 1),
(20, 1),
(21, 1),
(22, 1),
(23, 1),
(24, 1),
(25, 1),
(26, 1),
(27, 1),
(28, 1),
(29, 1),
(30, 1),
(31, 1),
(32, 1),
(33, 1),
(34, 1),
(35, 1),
(36, 1),
(37, 1),
(38, 1),
(39, 1),
(40, 1),
(41, 1),
(42, 1),
(43, 1),
(44, 1),
(45, 1),
(46, 1),
(47, 1),
(48, 1),
(49, 1),
(50, 1),
(51, 1),
(52, 1),
(53, 1),
(54, 1),
(55, 1),
(56, 1),
(57, 1),
(58, 1),
(59, 1),
(60, 1),
(61, 1),
(62, 1),
(63, 1),
(64, 1),
(65, 1),
(66, 1),
(67, 1),
(68, 1),
(69, 1),
(70, 1),
(71, 1),
(72, 1),
(73, 1),
(74, 1),
(75, 1),
(76, 1),
(77, 1),
(78, 1),
(79, 1),
(1, 2),
(2, 2),
(3, 2),
(4, 2),
(5, 2),
(6, 2),
(7, 2),
(8, 2),
(9, 2),
(10, 2),
(11, 2),
(12, 2);

-- --------------------------------------------------------

--
-- Struktur dari tabel `settings`
--

CREATE TABLE `settings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `key` varchar(255) NOT NULL,
  `value` text NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `settings`
--

INSERT INTO `settings` (`id`, `key`, `value`, `created_at`, `updated_at`) VALUES
(1, 'appearance', '{\"color_primary\":\"#15aa3d\",\"color_secondary\":\"#ec8544\",\"color_accent\":\"#219ad0\",\"background_banner\":null}', '2025-11-28 14:40:37', '2025-11-28 14:40:37'),
(2, 'e_letter', '{\"success\":\"Yth. Bapak\\/Ibu *${nama_penduduk}*,\\r\\nNIK: *${nik_penduduk}*,\\r\\n\\r\\nKami informasikan bahwa permohonan surat *${jenis_surat}* Anda telah *SELESAI* diproses.\\r\\n\\r\\nNomor Surat: *${nomor_surat}*\\r\\n\\r\\nSurat Anda dapat diambil langsung di Kantor Desa\\/Kelurahan.\\r\\n\\r\\nMohon tunjukkan kartu identitas Anda saat pengambilan. Terima kasih.\\r\\n\\r\\nHormat kami,\\r\\n*${aplikasi}*\",\"reject\":\"Yth. Bapak\\/Ibu *${nama_penduduk}*,\\r\\nNIK: *${nik_penduduk}*,\\r\\n\\r\\nKami informasikan bahwa permohonan surat *${jenis_surat}* Anda *DITOLAK\\/DIBATALKAN* karena:\\r\\n\\r\\n*Alasan Penolakan:*\\r\\n[Sebutkan alasan yang jelas, cth: Dokumen KK yang dilampirkan kadaluarsa \\/ Persyaratan belum lengkap].\\r\\n\\r\\nSilakan perbaiki persyaratan dan ajukan kembali permohonan Anda.\\r\\n\\r\\nHormat kami,\\r\\n*${aplikasi}*\"}', '2025-11-28 14:40:37', '2025-11-28 14:40:37'),
(3, 'app', '{\"name\":\"PEMERINTAH DESA TEGALSARI\",\"logo\":\"setting\\/TNpycic4WwzJQrRVYD1lQIi6vrEtLFudFzSzePPA.jpg\",\"description\":\"Pemerintah Desa Tegalsai, Kecamatan Tegalsari, Kabupaten Banyuwangi\"}', '2025-11-30 03:41:29', '2025-11-30 03:41:29');

-- --------------------------------------------------------

--
-- Struktur dari tabel `synergy_programs`
--

CREATE TABLE `synergy_programs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL,
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
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Administrator', 'admin@admin.com', NULL, '$2y$12$3RhtsWwQbTb.oUBBoI5pMOjAJsDAvzGDcOmm7SE4sP.eAwe3b2N5q', NULL, '2025-11-28 14:40:37', '2025-11-28 14:40:37'),
(2, 'ADMIN PENDUDUK', 'theivhan@gmail.com', NULL, '$2y$12$vItBPR5CbqRVGZ7oVkXhc.1jTMq9PSTxNq5Rn.wU8x76yAIUQWJ7.', NULL, '2025-11-30 04:45:52', '2025-11-30 04:45:52');

-- --------------------------------------------------------

--
-- Struktur dari tabel `village_official_greetings`
--

CREATE TABLE `village_official_greetings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `image` varchar(255) NOT NULL,
  `sign_image` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `village_official_histories`
--

CREATE TABLE `village_official_histories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `history` text NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `village_official_members`
--

CREATE TABLE `village_official_members` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `resident_id` bigint(20) UNSIGNED NOT NULL,
  `position` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `village_official_vision_missions`
--

CREATE TABLE `village_official_vision_missions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `vision` text NOT NULL,
  `mission` text NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `appearance_menus`
--
ALTER TABLE `appearance_menus`
  ADD PRIMARY KEY (`id`),
  ADD KEY `appearance_menus_parent_id_foreign` (`parent_id`),
  ADD KEY `appearance_menus_appearance_page_id_foreign` (`appearance_page_id`);

--
-- Indeks untuk tabel `appearance_pages`
--
ALTER TABLE `appearance_pages`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `budgets`
--
ALTER TABLE `budgets`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `critique_suggestions`
--
ALTER TABLE `critique_suggestions`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `e_letter_submissions`
--
ALTER TABLE `e_letter_submissions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `e_letter_submissions_e_letter_template_id_foreign` (`e_letter_template_id`),
  ADD KEY `e_letter_submissions_resident_id_foreign` (`resident_id`);

--
-- Indeks untuk tabel `e_letter_templates`
--
ALTER TABLE `e_letter_templates`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indeks untuk tabel `galleries`
--
ALTER TABLE `galleries`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `informations`
--
ALTER TABLE `informations`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `informations_slug_unique` (`slug`),
  ADD KEY `informations_user_id_foreign` (`user_id`);

--
-- Indeks untuk tabel `item_budgets`
--
ALTER TABLE `item_budgets`
  ADD PRIMARY KEY (`id`),
  ADD KEY `item_budgets_budget_id_foreign` (`budget_id`);

--
-- Indeks untuk tabel `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`model_id`,`model_type`),
  ADD KEY `model_has_permissions_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Indeks untuk tabel `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD PRIMARY KEY (`role_id`,`model_id`,`model_type`),
  ADD KEY `model_has_roles_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Indeks untuk tabel `news`
--
ALTER TABLE `news`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `news_slug_unique` (`slug`),
  ADD KEY `news_user_id_foreign` (`user_id`);

--
-- Indeks untuk tabel `news_comments`
--
ALTER TABLE `news_comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `news_comments_news_id_foreign` (`news_id`);

--
-- Indeks untuk tabel `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indeks untuk tabel `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `permissions_name_guard_name_unique` (`name`,`guard_name`);

--
-- Indeks untuk tabel `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indeks untuk tabel `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `residents`
--
ALTER TABLE `residents`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `residents_national_id_unique` (`national_id`);

--
-- Indeks untuk tabel `resident_forms`
--
ALTER TABLE `resident_forms`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `resident_form_values`
--
ALTER TABLE `resident_form_values`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `resident_form_values_resident_id_resident_form_id_unique` (`resident_id`,`resident_form_id`),
  ADD KEY `resident_form_values_resident_form_id_foreign` (`resident_form_id`);

--
-- Indeks untuk tabel `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `roles_name_guard_name_unique` (`name`,`guard_name`);

--
-- Indeks untuk tabel `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`role_id`),
  ADD KEY `role_has_permissions_role_id_foreign` (`role_id`);

--
-- Indeks untuk tabel `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `settings_key_unique` (`key`);

--
-- Indeks untuk tabel `synergy_programs`
--
ALTER TABLE `synergy_programs`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Indeks untuk tabel `village_official_greetings`
--
ALTER TABLE `village_official_greetings`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `village_official_histories`
--
ALTER TABLE `village_official_histories`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `village_official_members`
--
ALTER TABLE `village_official_members`
  ADD PRIMARY KEY (`id`),
  ADD KEY `village_official_members_resident_id_foreign` (`resident_id`);

--
-- Indeks untuk tabel `village_official_vision_missions`
--
ALTER TABLE `village_official_vision_missions`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `appearance_menus`
--
ALTER TABLE `appearance_menus`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT untuk tabel `appearance_pages`
--
ALTER TABLE `appearance_pages`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `budgets`
--
ALTER TABLE `budgets`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `critique_suggestions`
--
ALTER TABLE `critique_suggestions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `e_letter_submissions`
--
ALTER TABLE `e_letter_submissions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `e_letter_templates`
--
ALTER TABLE `e_letter_templates`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `galleries`
--
ALTER TABLE `galleries`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `informations`
--
ALTER TABLE `informations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `item_budgets`
--
ALTER TABLE `item_budgets`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT untuk tabel `news`
--
ALTER TABLE `news`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `news_comments`
--
ALTER TABLE `news_comments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=80;

--
-- AUTO_INCREMENT untuk tabel `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `products`
--
ALTER TABLE `products`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `residents`
--
ALTER TABLE `residents`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1001;

--
-- AUTO_INCREMENT untuk tabel `resident_forms`
--
ALTER TABLE `resident_forms`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `resident_form_values`
--
ALTER TABLE `resident_form_values`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `settings`
--
ALTER TABLE `settings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `synergy_programs`
--
ALTER TABLE `synergy_programs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `village_official_greetings`
--
ALTER TABLE `village_official_greetings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `village_official_histories`
--
ALTER TABLE `village_official_histories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `village_official_members`
--
ALTER TABLE `village_official_members`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `village_official_vision_missions`
--
ALTER TABLE `village_official_vision_missions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `appearance_menus`
--
ALTER TABLE `appearance_menus`
  ADD CONSTRAINT `appearance_menus_appearance_page_id_foreign` FOREIGN KEY (`appearance_page_id`) REFERENCES `appearance_pages` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `appearance_menus_parent_id_foreign` FOREIGN KEY (`parent_id`) REFERENCES `appearance_menus` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `e_letter_submissions`
--
ALTER TABLE `e_letter_submissions`
  ADD CONSTRAINT `e_letter_submissions_e_letter_template_id_foreign` FOREIGN KEY (`e_letter_template_id`) REFERENCES `e_letter_templates` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `e_letter_submissions_resident_id_foreign` FOREIGN KEY (`resident_id`) REFERENCES `residents` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `informations`
--
ALTER TABLE `informations`
  ADD CONSTRAINT `informations_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `item_budgets`
--
ALTER TABLE `item_budgets`
  ADD CONSTRAINT `item_budgets_budget_id_foreign` FOREIGN KEY (`budget_id`) REFERENCES `budgets` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD CONSTRAINT `model_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD CONSTRAINT `model_has_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `news`
--
ALTER TABLE `news`
  ADD CONSTRAINT `news_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `news_comments`
--
ALTER TABLE `news_comments`
  ADD CONSTRAINT `news_comments_news_id_foreign` FOREIGN KEY (`news_id`) REFERENCES `news` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `resident_form_values`
--
ALTER TABLE `resident_form_values`
  ADD CONSTRAINT `resident_form_values_resident_form_id_foreign` FOREIGN KEY (`resident_form_id`) REFERENCES `resident_forms` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `resident_form_values_resident_id_foreign` FOREIGN KEY (`resident_id`) REFERENCES `residents` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `village_official_members`
--
ALTER TABLE `village_official_members`
  ADD CONSTRAINT `village_official_members_resident_id_foreign` FOREIGN KEY (`resident_id`) REFERENCES `residents` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
