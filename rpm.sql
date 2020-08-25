-- phpMyAdmin SQL Dump
-- version 4.9.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 19 Feb 2020 pada 15.15
-- Versi server: 10.4.8-MariaDB
-- Versi PHP: 7.3.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `rpm`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `admins`
--

CREATE TABLE `admins` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `avatar` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'avatars/default.jpg',
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `admins`
--

INSERT INTO `admins` (`id`, `name`, `address`, `phone`, `avatar`, `user_id`, `created_at`, `updated_at`) VALUES
(1, 'administrator', 'jl perpasan', '085746575', 'avatars/default.jpg', 1, '2020-02-18 04:24:16', '2020-02-18 04:24:16'),
(2, 'sub administrator', 'jl halimau', '08522541236', 'avatars/default.jpg', 2, '2020-02-18 04:24:16', '2020-02-18 04:24:16');

-- --------------------------------------------------------

--
-- Struktur dari tabel `categories`
--

CREATE TABLE `categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `categories`
--

INSERT INTO `categories` (`id`, `name`, `slug`, `created_at`, `updated_at`) VALUES
(1, 'sport', 'sport', '2020-02-18 04:24:16', '2020-02-18 04:24:16'),
(2, 'politic', 'politic', '2020-02-18 04:24:16', '2020-02-18 04:24:16'),
(3, 'comedy', 'comedy', '2020-02-18 04:24:16', '2020-02-18 04:24:16'),
(4, 'love', 'love', '2020-02-18 04:24:16', '2020-02-18 04:24:16'),
(5, 'romance', 'romance', '2020-02-18 04:24:16', '2020-02-18 04:24:16'),
(6, 'disaster', 'disaster', '2020-02-18 04:24:16', '2020-02-18 04:24:16'),
(7, 'religi', 'religi', '2020-02-18 04:24:16', '2020-02-18 04:24:16'),
(8, 'food', 'food', '2020-02-18 04:24:16', '2020-02-18 04:24:16'),
(9, 'goverment', 'goverment', '2020-02-18 04:24:16', '2020-02-18 04:24:16');

-- --------------------------------------------------------

--
-- Struktur dari tabel `category_event`
--

CREATE TABLE `category_event` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `event_id` bigint(20) UNSIGNED NOT NULL,
  `category_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `category_event`
--

INSERT INTO `category_event` (`id`, `event_id`, `category_id`, `created_at`, `updated_at`) VALUES
(1, 1, 7, NULL, NULL),
(2, 1, 8, NULL, NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `category_news`
--

CREATE TABLE `category_news` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `news_id` bigint(20) UNSIGNED NOT NULL,
  `category_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `category_news`
--

INSERT INTO `category_news` (`id`, `news_id`, `category_id`, `created_at`, `updated_at`) VALUES
(1, 1, 1, NULL, NULL),
(2, 1, 4, NULL, NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `company`
--

CREATE TABLE `company` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `logo` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'logos/default.jpg',
  `description` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `profile` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `contact` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `contact_detail` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `company`
--

INSERT INTO `company` (`id`, `name`, `logo`, `description`, `profile`, `contact`, `contact_detail`, `created_at`, `updated_at`) VALUES
(1, 'PT Pertamina', 'logos/default.jpg', 'sddfg', 'profiles/LrsWXW8PHP2FljyDHZL073HIuvv3GRaHRcaXiIAk.pdf', 'ffff', NULL, '2020-02-18 04:24:16', '2020-02-18 07:12:41');

-- --------------------------------------------------------

--
-- Struktur dari tabel `distributors`
--

CREATE TABLE `distributors` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `member` enum('gold','silver','platinum') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `website` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `logo` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'logos/default.jpg',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `distributors`
--

INSERT INTO `distributors` (`id`, `name`, `member`, `address`, `phone`, `email`, `website`, `logo`, `created_at`, `updated_at`) VALUES
(1, 'PT. Pertamina', 'gold', 'jl cendana no 1', '08523212546', 'contact@pertamina.com', 'www.pertamina.com', 'logos/default.jpg', '2020-02-18 04:24:16', '2020-02-18 04:24:16'),
(2, 'PT Pupuk Kalimantan Timur', 'platinum', 'jl james simanjuntak', '085746575', 'contact@pupukkaltim.com', 'www.pupukkaltim.com', 'logos/default.jpg', '2020-02-18 04:24:16', '2020-02-18 04:24:16'),
(3, 'PT Badak LNG', 'silver', 'jl pangeran antasari', '08574656', 'contact@badaklng.com', 'www.badaklng.com', 'logos/default.jpg', '2020-02-18 04:24:16', '2020-02-18 04:24:16');

-- --------------------------------------------------------

--
-- Struktur dari tabel `employees`
--

CREATE TABLE `employees` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `avatar` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'avatars/default.jpg',
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `type` enum('owner','employee') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `distributor_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `employees`
--

INSERT INTO `employees` (`id`, `name`, `address`, `phone`, `avatar`, `user_id`, `type`, `distributor_id`, `created_at`, `updated_at`) VALUES
(1, 'owner pertamina', 'jl cendana putih', '08522541236', 'avatars/default.jpg', 3, 'owner', 1, '2020-02-18 04:24:16', '2020-02-18 04:24:16'),
(2, 'employee pertamina', 'jl cendrawasih', '08522541252', 'avatars/default.jpg', 4, 'employee', 1, '2020-02-18 04:24:16', '2020-02-18 04:24:16'),
(3, 'owner pupuk kaltim', 'jl kariangau no 5', '0852254147', 'avatars/default.jpg', 5, 'owner', 2, '2020-02-18 04:24:16', '2020-02-18 04:24:16'),
(4, 'employee pupuk kaltim', 'jl prapatan no 90', '08523265485', 'avatars/default.jpg', 6, 'employee', 2, '2020-02-18 04:24:16', '2020-02-18 04:24:16'),
(5, 'owner badak lng', 'jl pramuka 80', '08524511236', 'avatars/default.jpg', 7, 'owner', 3, '2020-02-18 04:24:16', '2020-02-18 04:24:16'),
(6, 'employee badak lng', 'jl perjuangan 60', '0852365471', 'avatars/default.jpg', 8, 'employee', 3, '2020-02-18 04:24:16', '2020-02-18 04:24:16');

-- --------------------------------------------------------

--
-- Struktur dari tabel `events`
--

CREATE TABLE `events` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'images/default.jpg',
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `view` bigint(20) NOT NULL DEFAULT 0,
  `created_by` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `events`
--

INSERT INTO `events` (`id`, `title`, `description`, `image`, `slug`, `view`, `created_by`, `created_at`, `updated_at`) VALUES
(1, 'Jaga Kekebalan Tubuh dengan Asupan Buah dan Sayur', '<p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Jika tingkat kekebalan tubuh Anda baik, maka kecil kemungkinannya terkena infeksi virus. Kekebalan tubuh atau imun dalam tubuh dapat dijaga dengan cara mengkonsumsi makanan mengandung vitamin C. \"Ketika berbicara mengenai sistem kekebalan tubuh, vitamin C adalah selebritas,\" kata Angel Planells, RD, juru bicara Academy of Nutrition and Dietetics yang berbasis di Seattle. “Namun, alih-alih meningkatkan asupan vitamin C saat Anda sakit, cobalah untuk mengonsumsinya rutin saat sehat,” lanjutnya. </p><p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Penelitian menunjukkan vitamin C bermanfaat untuk membantu orang lebih cepat pulih ketika terserang flu. Tak perlu langsung berbondong-bondong membeli suplemen vitamin C untuk menjaga imun dalam tubuh karena bisa mendapatkannya melalui sumber alami dari buah dan sayur berikut ini: </p><p>1. Jambu biji </p><p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Kandungan vitamin C dalam jambu biji adalah sebesar 206 mg, lebih tinggi dibandingkan dengan buah jeruk yang mengandung vitamin C sebesar 59-83 mg per satu buahnya. Kandungan seratnya juga tinggi. </p><p>2. Semangka </p><p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Satu buah semangka yang dibagi menjadi dua mengandung 270 mg kalium, 30 persen dari nilai harian vitamin A, dan 25 persen vitamin C. Kalori dalam semangka tidak banyak sama sekali. Satu buah semangka yang dibagi menjadi dua hanya mengandung 80 kalori. Semangka juga menyediakan vitamin B6 dan glutathione. Tubuh membutuhkan vitamin, nutrisi, dan senyawa seperti glutathione ini untuk fungsi kekebalan tubuh yang baik. </p><p>3. Pepaya</p><p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Pepaya adalah salah satu buah yang mengandung vitamin C. Satu buah papaya dapat memenuhi 224 persen kebutuhan vitamin C Anda. Pepaya juga memiliki enzim pernjernaan yang disebut papain yang memiliki efek inflamasi. Selain itu, Pepaya memiliki jumlah kalium, vitamin B, dan folat yang cukup, yang semuanya bermanfaat bagi kesehatan Anda secara keseluruhan.<br></p>', 'images/LAiTWx1yT2c5OfvUhMoma1TCps4NLaStK7yhGIFh.jpeg', 'jaga-kekebalan-tubuh-dengan-asupan-buah-dan-sayur', 1, 1, '2020-02-18 08:06:31', '2020-02-18 17:25:40');

-- --------------------------------------------------------

--
-- Struktur dari tabel `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_100000_create_password_resets_table', 1),
(2, '2016_06_01_000001_create_oauth_auth_codes_table', 1),
(3, '2016_06_01_000002_create_oauth_access_tokens_table', 1),
(4, '2016_06_01_000003_create_oauth_refresh_tokens_table', 1),
(5, '2016_06_01_000004_create_oauth_clients_table', 1),
(6, '2016_06_01_000005_create_oauth_personal_access_clients_table', 1),
(7, '2019_08_19_000000_create_failed_jobs_table', 1),
(8, '2020_02_10_095725_create_roles_table', 1),
(9, '2020_02_10_095727_create_distributors_table', 1),
(10, '2020_02_10_095748_create_users_table', 1),
(11, '2020_02_10_095840_create_employees_table', 1),
(12, '2020_02_10_095842_create_categories_table', 1),
(13, '2020_02_10_100442_create_news_table', 1),
(14, '2020_02_10_100455_create_events_table', 1),
(15, '2020_02_10_100621_create_category_event_table', 1),
(16, '2020_02_11_222349_create_category_news_table', 1),
(17, '2020_02_14_034600_create_promos_table', 1),
(18, '2020_02_14_034607_create_company_table', 1),
(19, '2020_02_17_110556_create_admins_table', 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `news`
--

CREATE TABLE `news` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'images/default.jpg',
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `view` bigint(20) NOT NULL DEFAULT 0,
  `created_by` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `news`
--

INSERT INTO `news` (`id`, `title`, `description`, `image`, `slug`, `view`, `created_by`, `created_at`, `updated_at`) VALUES
(1, 'Produksi Anjlok karena Virus Corona, iPhone Bisa Langka di Pasaran?', '<p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span style=\"color: rgb(42, 42, 42); font-family: Roboto, sans-serif; font-size: 14px;\">Mewabahnya virus <b>corona</b> berdampak terhadap produksi ponsel iPhone. Hal itu setelah pabrik-pabrik Apple di China tutup karena virus <b>corona</b>. Terkait kondisi ini, Apple telah memperingatkan kemungkinan kekurangan pasokan iPhone ke pasar global. Dikutip dari Guardian, Apple melalui rilis resminya Senin (17/2/2020) menyebut mereka kemungkinan gagal memenuhi target pendapatan kuartalannya sebesar 63-67 miliar dollar US atau sekitar Rp 857-911 triliun karena pasokan iPhone yang terbatas. Selain itu, permintaan pembelian ponsel mereka juga mengalami penurunan besar di China selama wabah virus corona. </span></p><p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span style=\"color: rgb(42, 42, 42); font-family: Roboto, sans-serif; font-size: 14px;\">Seperti diketahui, perusahaan yang didirikan Steve Jobs itu membuat sebagian besar iPhone dan produk lainnya di China. Penyebaran virus bernama Covid-19 itu telah menyebabkan perusahaan untuk sementara waktu menghentikan produksi dan menutup beberapa toko retail mereka di China. Namun beberapa toko Apple dibuka kembali pekan lalu dengan jam terbatas. \"Akibatnya, kami tidak berharap bisa memenuhi pendapatan yang kami targetkan untuk kuartal Maret,\" kata pernyataan pihak <u>Apple</u>.</span><br></p>', 'images/KsaZZpp3Pw93adNEfvQ7tMFoYibRoR5m0trIJeek.jpeg', 'produksi-anjlok-karena-virus-corona-iphone-bisa-langka-di-pasaran', 1, 1, '2020-02-18 07:49:47', '2020-02-18 17:23:28');

-- --------------------------------------------------------

--
-- Struktur dari tabel `oauth_access_tokens`
--

CREATE TABLE `oauth_access_tokens` (
  `id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `client_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `scopes` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `revoked` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `expires_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `oauth_access_tokens`
--

INSERT INTO `oauth_access_tokens` (`id`, `user_id`, `client_id`, `name`, `scopes`, `revoked`, `created_at`, `updated_at`, `expires_at`) VALUES
('340ac9787a90a4e57993bac3da203e2e252f90417d2d85ec2cb082e8087cd2e6dc228c521d165651', 3, 1, 'authToken', '[]', 0, '2020-02-18 17:33:53', '2020-02-18 17:33:53', '2021-02-19 01:33:53');

-- --------------------------------------------------------

--
-- Struktur dari tabel `oauth_auth_codes`
--

CREATE TABLE `oauth_auth_codes` (
  `id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `client_id` bigint(20) UNSIGNED NOT NULL,
  `scopes` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `revoked` tinyint(1) NOT NULL,
  `expires_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `oauth_clients`
--

CREATE TABLE `oauth_clients` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `secret` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `redirect` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `personal_access_client` tinyint(1) NOT NULL,
  `password_client` tinyint(1) NOT NULL,
  `revoked` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `oauth_clients`
--

INSERT INTO `oauth_clients` (`id`, `user_id`, `name`, `secret`, `redirect`, `personal_access_client`, `password_client`, `revoked`, `created_at`, `updated_at`) VALUES
(1, NULL, 'Laravel Personal Access Client', 'EEukW0lEynLSdhQUPS2gz0oOWMAXET2JfSXbGKuk', 'http://localhost', 1, 0, 0, '2020-02-18 17:33:37', '2020-02-18 17:33:37'),
(2, NULL, 'Laravel Password Grant Client', 'D8doKHF47FPjh8u9bmobQqlLCyu5kPdXcyzAzAD0', 'http://localhost', 0, 1, 0, '2020-02-18 17:33:37', '2020-02-18 17:33:37');

-- --------------------------------------------------------

--
-- Struktur dari tabel `oauth_personal_access_clients`
--

CREATE TABLE `oauth_personal_access_clients` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `client_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `oauth_personal_access_clients`
--

INSERT INTO `oauth_personal_access_clients` (`id`, `client_id`, `created_at`, `updated_at`) VALUES
(1, 1, '2020-02-18 17:33:37', '2020-02-18 17:33:37');

-- --------------------------------------------------------

--
-- Struktur dari tabel `oauth_refresh_tokens`
--

CREATE TABLE `oauth_refresh_tokens` (
  `id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `access_token_id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `revoked` tinyint(1) NOT NULL,
  `expires_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `promos`
--

CREATE TABLE `promos` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'images/default.jpg',
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `point` bigint(20) NOT NULL,
  `total` bigint(20) NOT NULL,
  `status` enum('normal','hot') COLLATE utf8mb4_unicode_ci NOT NULL,
  `view` bigint(20) NOT NULL DEFAULT 0,
  `created_by` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `promos`
--

INSERT INTO `promos` (`id`, `name`, `description`, `image`, `slug`, `point`, `total`, `status`, `view`, `created_by`, `created_at`, `updated_at`) VALUES
(1, 'Promo Hari Libur', 'Promo hari libur untuk kita semua', 'images/VX6b2DsZ5IsLLaTh8O45WnEj13ii7zsoT9PBSuiv.png', '', 100, 100, 'hot', 0, 1, '2020-02-18 08:13:16', '2020-02-18 08:13:16');

-- --------------------------------------------------------

--
-- Struktur dari tabel `roles`
--

CREATE TABLE `roles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `roles`
--

INSERT INTO `roles` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'admin', '2020-02-18 04:24:16', '2020-02-18 04:24:16'),
(2, 'adminsub', '2020-02-18 04:24:16', '2020-02-18 04:24:16'),
(3, 'distributor', '2020-02-18 04:24:16', '2020-02-18 04:24:16');

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role_id` bigint(20) UNSIGNED NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id`, `email`, `email_verified_at`, `password`, `role_id`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'admin@mail.com', NULL, '$2y$10$ssgUCs6Q8ayO3tBd9hIyUehCpIwUiWiLC5QShnAR.dj8gKRQLPBGu', 1, NULL, '2020-02-18 04:24:16', '2020-02-18 04:24:16'),
(2, 'subadmin@mail.com', NULL, '$2y$10$Dho.1uU65yv23fGlm9VLVO9m9bQ7ce0akX8B0Yts.6eG6ZmRLv7ve', 2, NULL, '2020-02-18 04:24:16', '2020-02-18 04:24:16'),
(3, 'ownerpertamina@mail.com', NULL, '$2y$10$yj9oBT8rOoOQtazHd1Iage12NAbEG/2/ci7xxr0emSJnrZQiWaAqq', 3, NULL, '2020-02-18 04:24:16', '2020-02-18 04:24:16'),
(4, 'employeepertamina@mail.com', NULL, '$2y$10$B6TjoqvtOmUSeR0G3zd62.ukNIK1XF1QKlDQpWjw1fe8RHC247hKi', 3, NULL, '2020-02-18 04:24:16', '2020-02-18 04:24:16'),
(5, 'ownerpupukkaltim@mail.com', NULL, '$2y$10$pQAyppe5v.yYB5UT7xVk2.LuecoI/Cab4HY3si2AgvCWG8MaoHJya', 3, NULL, '2020-02-18 04:24:16', '2020-02-18 04:24:16'),
(6, 'employeepupukkaltim@mail.com', NULL, '$2y$10$Ue0pRM8tPjbcSzltgq0ZLuZK8edD4c9tOaHGroQF9wPuT426koBlq', 3, NULL, '2020-02-18 04:24:16', '2020-02-18 04:24:16'),
(7, 'ownerbadaklng@mail.com', NULL, '$2y$10$ccnT1xW/Xe8mC5t.ZRwDMeMwU0UAv5rOa5MhbvWJo4UuF4XIXpznO', 3, NULL, '2020-02-18 04:24:16', '2020-02-18 04:24:16'),
(8, 'employeebadaklng@mail.com', NULL, '$2y$10$5mmCyNjsyCe9tSW8rom8FOgEwrRg2KAizOJI7/1s3DgfTrsC.a3F.', 3, NULL, '2020-02-18 04:24:16', '2020-02-18 04:24:16');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`),
  ADD KEY `admins_user_id_foreign` (`user_id`);

--
-- Indeks untuk tabel `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `category_event`
--
ALTER TABLE `category_event`
  ADD PRIMARY KEY (`id`),
  ADD KEY `category_event_event_id_foreign` (`event_id`),
  ADD KEY `category_event_category_id_foreign` (`category_id`);

--
-- Indeks untuk tabel `category_news`
--
ALTER TABLE `category_news`
  ADD PRIMARY KEY (`id`),
  ADD KEY `category_news_news_id_foreign` (`news_id`),
  ADD KEY `category_news_category_id_foreign` (`category_id`);

--
-- Indeks untuk tabel `company`
--
ALTER TABLE `company`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `distributors`
--
ALTER TABLE `distributors`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `employees`
--
ALTER TABLE `employees`
  ADD PRIMARY KEY (`id`),
  ADD KEY `employees_user_id_foreign` (`user_id`),
  ADD KEY `employees_distributor_id_foreign` (`distributor_id`);

--
-- Indeks untuk tabel `events`
--
ALTER TABLE `events`
  ADD PRIMARY KEY (`id`),
  ADD KEY `events_created_by_foreign` (`created_by`);

--
-- Indeks untuk tabel `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `news`
--
ALTER TABLE `news`
  ADD PRIMARY KEY (`id`),
  ADD KEY `news_created_by_foreign` (`created_by`);

--
-- Indeks untuk tabel `oauth_access_tokens`
--
ALTER TABLE `oauth_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD KEY `oauth_access_tokens_user_id_index` (`user_id`);

--
-- Indeks untuk tabel `oauth_auth_codes`
--
ALTER TABLE `oauth_auth_codes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `oauth_auth_codes_user_id_index` (`user_id`);

--
-- Indeks untuk tabel `oauth_clients`
--
ALTER TABLE `oauth_clients`
  ADD PRIMARY KEY (`id`),
  ADD KEY `oauth_clients_user_id_index` (`user_id`);

--
-- Indeks untuk tabel `oauth_personal_access_clients`
--
ALTER TABLE `oauth_personal_access_clients`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `oauth_refresh_tokens`
--
ALTER TABLE `oauth_refresh_tokens`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indeks untuk tabel `promos`
--
ALTER TABLE `promos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `promos_user_id_foreign` (`created_by`);

--
-- Indeks untuk tabel `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD KEY `users_role_id_foreign` (`role_id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `admins`
--
ALTER TABLE `admins`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `categories`
--
ALTER TABLE `categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT untuk tabel `category_event`
--
ALTER TABLE `category_event`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `category_news`
--
ALTER TABLE `category_news`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `company`
--
ALTER TABLE `company`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `distributors`
--
ALTER TABLE `distributors`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `employees`
--
ALTER TABLE `employees`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT untuk tabel `events`
--
ALTER TABLE `events`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT untuk tabel `news`
--
ALTER TABLE `news`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `oauth_clients`
--
ALTER TABLE `oauth_clients`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `oauth_personal_access_clients`
--
ALTER TABLE `oauth_personal_access_clients`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `promos`
--
ALTER TABLE `promos`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `admins`
--
ALTER TABLE `admins`
  ADD CONSTRAINT `admins_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `category_event`
--
ALTER TABLE `category_event`
  ADD CONSTRAINT `category_event_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `category_event_event_id_foreign` FOREIGN KEY (`event_id`) REFERENCES `events` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `category_news`
--
ALTER TABLE `category_news`
  ADD CONSTRAINT `category_news_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `category_news_news_id_foreign` FOREIGN KEY (`news_id`) REFERENCES `news` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `employees`
--
ALTER TABLE `employees`
  ADD CONSTRAINT `employees_distributor_id_foreign` FOREIGN KEY (`distributor_id`) REFERENCES `distributors` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `employees_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `events`
--
ALTER TABLE `events`
  ADD CONSTRAINT `events_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `news`
--
ALTER TABLE `news`
  ADD CONSTRAINT `news_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `promos`
--
ALTER TABLE `promos`
  ADD CONSTRAINT `promos_user_id_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
