-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 19, 2026 at 01:48 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `afritechs`
--

-- --------------------------------------------------------

--
-- Table structure for table `afritechs_banners`
--

CREATE TABLE `afritechs_banners` (
  `id` int(11) NOT NULL,
  `page` varchar(20) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `afritechs_banners`
--

INSERT INTO `afritechs_banners` (`id`, `page`, `title`, `description`, `image`, `created_at`, `updated_at`) VALUES
(1, 'Our Services', 'tt', 'tt desc', '01M06Z9PKXAM811B6FPDWV7JER.jpg', '2026-08-17 04:14:23', '2026-08-16 22:52:25'),
(2, 'Projects', 'tt', 'tt desc', 'img', '2026-08-17 04:19:22', '2026-08-17 04:19:22'),
(3, 'About', 'tt', 'tt desc', 'img', '2026-08-17 04:20:16', '2026-08-17 04:20:16'),
(4, 'Contact Us', 'tt', 'tt desc', 'img', '2026-08-17 04:20:58', '2026-08-17 04:20:58');

-- --------------------------------------------------------

--
-- Table structure for table `afritechs_brands`
--

CREATE TABLE `afritechs_brands` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `slug` varchar(255) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `afritechs_brands`
--

INSERT INTO `afritechs_brands` (`id`, `title`, `slug`, `image`, `is_active`, `created_at`, `updated_at`) VALUES
(3, 'Brand1', 'brand1', '01M07JJE38KSG8GRA2W3EW15MH.jpg', 1, '2026-08-17 04:29:14', '2026-08-17 04:29:14');

-- --------------------------------------------------------

--
-- Table structure for table `afritechs_cache`
--

CREATE TABLE `afritechs_cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `afritechs_cache`
--

INSERT INTO `afritechs_cache` (`key`, `value`, `expiration`) VALUES
('afri-techs-cache-356a192b7913b04c54574d18c28d46e6395428ab', 'i:3;', 1786968459),
('afri-techs-cache-356a192b7913b04c54574d18c28d46e6395428ab:timer', 'i:1786968459;', 1786968459),
('afri-techs-cache-livewire-rate-limiter:16d36dff9abd246c67dfac3e63b993a169af77e6', 'i:1;', 1787025104),
('afri-techs-cache-livewire-rate-limiter:16d36dff9abd246c67dfac3e63b993a169af77e6:timer', 'i:1787025104;', 1787025104);

-- --------------------------------------------------------

--
-- Table structure for table `afritechs_cache_locks`
--

CREATE TABLE `afritechs_cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `afritechs_careers`
--

CREATE TABLE `afritechs_careers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `type` enum('job_listing','graduate_programme','internship') NOT NULL,
  `description` text DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `location` varchar(255) DEFAULT NULL,
  `application_deadline` date DEFAULT NULL,
  `application_url` varchar(500) DEFAULT NULL,
  `featured_status` tinyint(1) NOT NULL DEFAULT 0,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `afritechs_careers`
--

INSERT INTO `afritechs_careers` (`id`, `title`, `type`, `description`, `image`, `location`, `application_deadline`, `application_url`, `featured_status`, `status`, `created_at`, `updated_at`) VALUES
(2, 'eeed', 'graduate_programme', '<p>wwws</p>', '01KZZSSYPV2GYP8MCJ2MVKXPNW.jpg', 'ff', '2026-08-15', 'http://127.0.0.1:8000/admin/careers/create', 1, 1, '2026-08-14 04:01:45', '2026-08-14 04:01:45');

-- --------------------------------------------------------

--
-- Table structure for table `afritechs_categories`
--

CREATE TABLE `afritechs_categories` (
  `id` int(11) NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `slug` varchar(255) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `afritechs_categories`
--

INSERT INTO `afritechs_categories` (`id`, `title`, `slug`, `image`, `created_at`, `updated_at`) VALUES
(4, 'Cat1', 'cat1', '01M07JHNJKP7KBT788BA8Q7JV5.jpg', '2026-08-17 04:28:49', '2026-08-17 04:28:49');

-- --------------------------------------------------------

--
-- Table structure for table `afritechs_contacts`
--

CREATE TABLE `afritechs_contacts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `address` varchar(255) DEFAULT NULL,
  `map_link` text DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `whatsapp` varchar(255) DEFAULT NULL,
  `opening_hours` varchar(255) DEFAULT NULL,
  `facebook` varchar(255) DEFAULT NULL,
  `twitter` varchar(255) DEFAULT NULL,
  `instagram` varchar(255) DEFAULT NULL,
  `linkedin` varchar(255) DEFAULT NULL,
  `youtube` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `afritechs_contacts`
--

INSERT INTO `afritechs_contacts` (`id`, `address`, `map_link`, `phone`, `email`, `whatsapp`, `opening_hours`, `facebook`, `twitter`, `instagram`, `linkedin`, `youtube`, `created_at`, `updated_at`) VALUES
(1, '<p>Address123</p>', NULL, '+971 55 10 82 212', 'abc1@gmail.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-07-02 10:53:19', '2026-08-14 05:28:09');

-- --------------------------------------------------------

--
-- Table structure for table `afritechs_failed_jobs`
--

CREATE TABLE `afritechs_failed_jobs` (
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
-- Table structure for table `afritechs_hero_sliders`
--

CREATE TABLE `afritechs_hero_sliders` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `afritechs_hero_sliders`
--

INSERT INTO `afritechs_hero_sliders` (`id`, `title`, `description`, `image`, `status`, `created_at`, `updated_at`) VALUES
(3, 'Title1', 'Desc1', 'hero-sliders/01KZTBA0NA3CT54HZPPDXEB370.jpg', 1, '2026-08-12 01:12:11', '2026-08-12 01:12:11'),
(5, 'qq', 'ww', 'hero-sliders/01KZTBPCX8PWYSX7R4VR8YJHKF.webp', 1, '2026-08-12 01:18:57', '2026-08-12 01:18:57');

-- --------------------------------------------------------

--
-- Table structure for table `afritechs_jobs`
--

CREATE TABLE `afritechs_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `afritechs_job_batches`
--

CREATE TABLE `afritechs_job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `afritechs_migrations`
--

CREATE TABLE `afritechs_migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `afritechs_migrations`
--

INSERT INTO `afritechs_migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `afritechs_news`
--

CREATE TABLE `afritechs_news` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `slug` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `afritechs_news`
--

INSERT INTO `afritechs_news` (`id`, `title`, `slug`, `description`, `image`, `status`, `created_at`, `updated_at`) VALUES
(2, 'hbhvb', 'hbhvb', 'VVYV', 'news/01KZWNMM6M96G7WATSM7KJY3Y4.jpg', 1, '2026-08-12 22:51:13', '2026-08-12 22:51:13');

-- --------------------------------------------------------

--
-- Table structure for table `afritechs_pages`
--

CREATE TABLE `afritechs_pages` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `cms_title` varchar(255) DEFAULT NULL,
  `content1` text DEFAULT NULL,
  `content2` text DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `afritechs_pages`
--

INSERT INTO `afritechs_pages` (`id`, `title`, `cms_title`, `content1`, `content2`, `image`, `created_at`, `updated_at`) VALUES
(1, 'Home-Our Advantages', 'Our Advantages1', 'content1', NULL, NULL, '2026-08-18 04:26:36', '2026-08-17 23:05:28');

-- --------------------------------------------------------

--
-- Table structure for table `afritechs_password_reset_tokens`
--

CREATE TABLE `afritechs_password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `afritechs_products`
--

CREATE TABLE `afritechs_products` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `category_id` int(11) DEFAULT NULL,
  `brand_id` bigint(20) UNSIGNED DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `slug` varchar(255) DEFAULT NULL,
  `sku` varchar(100) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `price` decimal(12,2) DEFAULT NULL,
  `sale_price` decimal(12,2) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `meta_title` varchar(255) DEFAULT NULL,
  `meta_desc` text DEFAULT NULL,
  `meta_key` varchar(255) DEFAULT NULL,
  `featured_status` tinyint(1) NOT NULL DEFAULT 0,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `afritechs_products`
--

INSERT INTO `afritechs_products` (`id`, `category_id`, `brand_id`, `title`, `slug`, `sku`, `description`, `price`, `sale_price`, `image`, `meta_title`, `meta_desc`, `meta_key`, `featured_status`, `is_active`, `created_at`, `updated_at`) VALUES
(2, 4, 3, 'Product1', 'product1', 'ss', '<p>Product1 Desc1</p>', 1200.00, 1100.00, 'products/01M07JWP2NGPT0V0EGB69BQ8AB.jpg', 'm11', '<p>m1</p>', 'm22', 1, 1, '2026-08-17 04:34:50', '2026-08-17 23:22:55');

-- --------------------------------------------------------

--
-- Table structure for table `afritechs_product_faqs`
--

CREATE TABLE `afritechs_product_faqs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `question` varchar(255) DEFAULT NULL,
  `answer` text DEFAULT NULL,
  `sort_order` int(11) NOT NULL DEFAULT 0,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `afritechs_product_faqs`
--

INSERT INTO `afritechs_product_faqs` (`id`, `product_id`, `question`, `answer`, `sort_order`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 2, 'Question12', '<p>Answer1</p>', 1, 1, '2026-08-17 04:43:00', '2026-08-17 04:43:18');

-- --------------------------------------------------------

--
-- Table structure for table `afritechs_product_images`
--

CREATE TABLE `afritechs_product_images` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `sort_order` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `afritechs_product_images`
--

INSERT INTO `afritechs_product_images` (`id`, `product_id`, `image`, `sort_order`, `created_at`, `updated_at`) VALUES
(1, 2, 'products/gallery/01M07JWP3K9P1WHN1SY786592D.jpg', 1, '2026-08-17 04:34:50', '2026-08-17 04:34:50'),
(2, 2, 'products/gallery/01M07JWP3NFSKMY0QW9V15E006.jpg', 2, '2026-08-17 04:34:50', '2026-08-17 04:34:50');

-- --------------------------------------------------------

--
-- Table structure for table `afritechs_product_specifications`
--

CREATE TABLE `afritechs_product_specifications` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `value` varchar(255) DEFAULT NULL,
  `sort_order` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `afritechs_product_specifications`
--

INSERT INTO `afritechs_product_specifications` (`id`, `product_id`, `name`, `value`, `sort_order`, `created_at`, `updated_at`) VALUES
(1, 2, 'name1', 'value1', 1, '2026-08-17 04:34:50', '2026-08-17 04:34:50'),
(2, 2, 'name2', 'value2', 2, '2026-08-17 04:34:50', '2026-08-17 04:34:50');

-- --------------------------------------------------------

--
-- Table structure for table `afritechs_projects`
--

CREATE TABLE `afritechs_projects` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `service_id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `slug` varchar(255) DEFAULT NULL,
  `location` varchar(255) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `meta_title` varchar(255) DEFAULT NULL,
  `meta_desc` text DEFAULT NULL,
  `meta_key` varchar(255) DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `afritechs_projects`
--

INSERT INTO `afritechs_projects` (`id`, `service_id`, `title`, `slug`, `location`, `image`, `description`, `meta_title`, `meta_desc`, `meta_key`, `status`, `created_at`, `updated_at`) VALUES
(1, 3, 'Project122', 'project122', 'loc1', 'projects/01M07SXDZ3RC7E9ZPTMYBYXBYN.jpg', '<p>Project1 desc</p>', 'm1', '<p>m12</p>', 'm13', 1, '2026-08-17 06:37:35', '2026-08-17 06:37:59');

-- --------------------------------------------------------

--
-- Table structure for table `afritechs_project_images`
--

CREATE TABLE `afritechs_project_images` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `project_id` bigint(20) UNSIGNED NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `sort_order` int(11) NOT NULL DEFAULT 0,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `afritechs_project_images`
--

INSERT INTO `afritechs_project_images` (`id`, `project_id`, `image`, `sort_order`, `status`, `created_at`, `updated_at`) VALUES
(1, 1, 'projects/gallery/01M07SXDZMA6HZ35R9SZGPTB1Z.jpg', 1, 1, '2026-08-17 06:37:35', '2026-08-17 06:37:35'),
(2, 1, 'projects/gallery/01M07SXDZPTPB1WHRCCGBHN4GZ.jpg', 2, 1, '2026-08-17 06:37:35', '2026-08-17 06:37:35');

-- --------------------------------------------------------

--
-- Table structure for table `afritechs_seos`
--

CREATE TABLE `afritechs_seos` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `meta_title` varchar(255) NOT NULL,
  `meta_desc` text DEFAULT NULL,
  `meta_key` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `afritechs_seos`
--

INSERT INTO `afritechs_seos` (`id`, `title`, `meta_title`, `meta_desc`, `meta_key`, `created_at`, `updated_at`) VALUES
(1, 'Home', 'Afri-Techs1', '<p>desc1</p>', 'dfddf', '2026-07-06 06:12:35', '2026-08-17 22:52:16'),
(2, 'Products', 'mt', 'mdesc', 'mkey', '2026-08-18 04:02:50', '2026-08-18 04:02:50'),
(3, 'Our Services', 'our-services', 'desc1', 'mkey1', '2026-08-18 03:59:31', '2026-08-18 03:59:31'),
(4, 'Projects', 'mt', 'mdesc', 'mkey', '2026-08-18 04:00:44', '2026-08-18 04:00:44'),
(5, 'About', 'mt', 'mdesc', 'mkey', '2026-08-18 04:03:43', '2026-08-18 04:03:43'),
(6, 'Contact Us', 'mt', 'mdesc', 'mkey', '2026-08-18 04:04:23', '2026-08-18 04:04:23');

-- --------------------------------------------------------

--
-- Table structure for table `afritechs_services`
--

CREATE TABLE `afritechs_services` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `slug` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `meta_title` varchar(255) DEFAULT NULL,
  `meta_desc` text DEFAULT NULL,
  `meta_key` varchar(255) DEFAULT NULL,
  `featured_status` tinyint(1) NOT NULL DEFAULT 0,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `afritechs_services`
--

INSERT INTO `afritechs_services` (`id`, `title`, `slug`, `description`, `image`, `meta_title`, `meta_desc`, `meta_key`, `featured_status`, `status`, `created_at`, `updated_at`) VALUES
(3, 'u hbhb', 'u-hbhb', '<p>kokokk</p>', 'services/01M07NQGCKBV5SFTG3A7VXAVW0.jpg', 'mm', '<p>mm1</p>', 'mm2', 1, 1, '2026-08-17 05:24:26', '2026-08-17 05:55:27');

-- --------------------------------------------------------

--
-- Table structure for table `afritechs_sessions`
--

CREATE TABLE `afritechs_sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `afritechs_sessions`
--

INSERT INTO `afritechs_sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('dx8mHAsa7KeWmc3htHBPy2bkzSIRkK4PybkSPc8L', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:153.0) Gecko/20100101 Firefox/153.0', 'YTo4OntzOjY6Il90b2tlbiI7czo0MDoicmR1TWpLUXo5anRTMEZDS2xnejlkaFlPWXVEQmw0dTJOaHR4R1pObSI7czozOiJ1cmwiO2E6MDp7fXM6OToiX3ByZXZpb3VzIjthOjI6e3M6MzoidXJsIjtzOjI3OiJodHRwOi8vMTI3LjAuMC4xOjgwMDAvYWRtaW4iO3M6NToicm91dGUiO3M6MzA6ImZpbGFtZW50LmFkbWluLnBhZ2VzLmRhc2hib2FyZCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjE7czoxNzoicGFzc3dvcmRfaGFzaF93ZWIiO3M6NjQ6IjA1Yjg1NTVjYjc4Yzk2ZDQ5OGNjZmI0YjgwZDE4ODdhOTU2Nzg1ZTE3YTQwOTE3YjNkZWRlOTdiY2I0YzQ0YzQiO3M6NjoidGFibGVzIjthOjM6e3M6NDA6IjcwODBjNzI4NTVkZjJmZmEzNjU0Yjk0OTliODUzNzFmX2NvbHVtbnMiO2E6Nzp7aTowO2E6Nzp7czo0OiJ0eXBlIjtzOjY6ImNvbHVtbiI7czo0OiJuYW1lIjtzOjI6ImlkIjtzOjU6ImxhYmVsIjtzOjI6IklEIjtzOjg6ImlzSGlkZGVuIjtiOjA7czo5OiJpc1RvZ2dsZWQiO2I6MTtzOjEyOiJpc1RvZ2dsZWFibGUiO2I6MDtzOjI0OiJpc1RvZ2dsZWRIaWRkZW5CeURlZmF1bHQiO047fWk6MTthOjc6e3M6NDoidHlwZSI7czo2OiJjb2x1bW4iO3M6NDoibmFtZSI7czo1OiJ0aXRsZSI7czo1OiJsYWJlbCI7czoxMDoiUGFnZSBUaXRsZSI7czo4OiJpc0hpZGRlbiI7YjowO3M6OToiaXNUb2dnbGVkIjtiOjE7czoxMjoiaXNUb2dnbGVhYmxlIjtiOjA7czoyNDoiaXNUb2dnbGVkSGlkZGVuQnlEZWZhdWx0IjtOO31pOjI7YTo3OntzOjQ6InR5cGUiO3M6NjoiY29sdW1uIjtzOjQ6Im5hbWUiO3M6MTA6Im1ldGFfdGl0bGUiO3M6NToibGFiZWwiO3M6MTA6Ik1ldGEgVGl0bGUiO3M6ODoiaXNIaWRkZW4iO2I6MDtzOjk6ImlzVG9nZ2xlZCI7YjoxO3M6MTI6ImlzVG9nZ2xlYWJsZSI7YjowO3M6MjQ6ImlzVG9nZ2xlZEhpZGRlbkJ5RGVmYXVsdCI7Tjt9aTozO2E6Nzp7czo0OiJ0eXBlIjtzOjY6ImNvbHVtbiI7czo0OiJuYW1lIjtzOjk6Im1ldGFfZGVzYyI7czo1OiJsYWJlbCI7czoxNjoiTWV0YSBEZXNjcmlwdGlvbiI7czo4OiJpc0hpZGRlbiI7YjowO3M6OToiaXNUb2dnbGVkIjtiOjE7czoxMjoiaXNUb2dnbGVhYmxlIjtiOjA7czoyNDoiaXNUb2dnbGVkSGlkZGVuQnlEZWZhdWx0IjtOO31pOjQ7YTo3OntzOjQ6InR5cGUiO3M6NjoiY29sdW1uIjtzOjQ6Im5hbWUiO3M6ODoibWV0YV9rZXkiO3M6NToibGFiZWwiO3M6MTM6Ik1ldGEgS2V5d29yZHMiO3M6ODoiaXNIaWRkZW4iO2I6MDtzOjk6ImlzVG9nZ2xlZCI7YjoxO3M6MTI6ImlzVG9nZ2xlYWJsZSI7YjowO3M6MjQ6ImlzVG9nZ2xlZEhpZGRlbkJ5RGVmYXVsdCI7Tjt9aTo1O2E6Nzp7czo0OiJ0eXBlIjtzOjY6ImNvbHVtbiI7czo0OiJuYW1lIjtzOjEwOiJjcmVhdGVkX2F0IjtzOjU6ImxhYmVsIjtzOjc6IkNyZWF0ZWQiO3M6ODoiaXNIaWRkZW4iO2I6MDtzOjk6ImlzVG9nZ2xlZCI7YjoxO3M6MTI6ImlzVG9nZ2xlYWJsZSI7YjowO3M6MjQ6ImlzVG9nZ2xlZEhpZGRlbkJ5RGVmYXVsdCI7Tjt9aTo2O2E6Nzp7czo0OiJ0eXBlIjtzOjY6ImNvbHVtbiI7czo0OiJuYW1lIjtzOjEwOiJ1cGRhdGVkX2F0IjtzOjU6ImxhYmVsIjtzOjc6IlVwZGF0ZWQiO3M6ODoiaXNIaWRkZW4iO2I6MDtzOjk6ImlzVG9nZ2xlZCI7YjoxO3M6MTI6ImlzVG9nZ2xlYWJsZSI7YjowO3M6MjQ6ImlzVG9nZ2xlZEhpZGRlbkJ5RGVmYXVsdCI7Tjt9fXM6NDA6Ijk3OTJiNmRlNTczMTU2ZWMwNDVlYTgxODgxYmUzZDNkX2NvbHVtbnMiO2E6NTp7aTowO2E6Nzp7czo0OiJ0eXBlIjtzOjY6ImNvbHVtbiI7czo0OiJuYW1lIjtzOjU6InRpdGxlIjtzOjU6ImxhYmVsIjtzOjU6IlRpdGxlIjtzOjg6ImlzSGlkZGVuIjtiOjA7czo5OiJpc1RvZ2dsZWQiO2I6MTtzOjEyOiJpc1RvZ2dsZWFibGUiO2I6MDtzOjI0OiJpc1RvZ2dsZWRIaWRkZW5CeURlZmF1bHQiO047fWk6MTthOjc6e3M6NDoidHlwZSI7czo2OiJjb2x1bW4iO3M6NDoibmFtZSI7czo5OiJjbXNfdGl0bGUiO3M6NToibGFiZWwiO3M6OToiQ21zIHRpdGxlIjtzOjg6ImlzSGlkZGVuIjtiOjA7czo5OiJpc1RvZ2dsZWQiO2I6MTtzOjEyOiJpc1RvZ2dsZWFibGUiO2I6MDtzOjI0OiJpc1RvZ2dsZWRIaWRkZW5CeURlZmF1bHQiO047fWk6MjthOjc6e3M6NDoidHlwZSI7czo2OiJjb2x1bW4iO3M6NDoibmFtZSI7czo1OiJpbWFnZSI7czo1OiJsYWJlbCI7czo1OiJJbWFnZSI7czo4OiJpc0hpZGRlbiI7YjowO3M6OToiaXNUb2dnbGVkIjtiOjE7czoxMjoiaXNUb2dnbGVhYmxlIjtiOjA7czoyNDoiaXNUb2dnbGVkSGlkZGVuQnlEZWZhdWx0IjtOO31pOjM7YTo3OntzOjQ6InR5cGUiO3M6NjoiY29sdW1uIjtzOjQ6Im5hbWUiO3M6MTA6ImNyZWF0ZWRfYXQiO3M6NToibGFiZWwiO3M6MTA6IkNyZWF0ZWQgYXQiO3M6ODoiaXNIaWRkZW4iO2I6MDtzOjk6ImlzVG9nZ2xlZCI7YjowO3M6MTI6ImlzVG9nZ2xlYWJsZSI7YjoxO3M6MjQ6ImlzVG9nZ2xlZEhpZGRlbkJ5RGVmYXVsdCI7YjoxO31pOjQ7YTo3OntzOjQ6InR5cGUiO3M6NjoiY29sdW1uIjtzOjQ6Im5hbWUiO3M6MTA6InVwZGF0ZWRfYXQiO3M6NToibGFiZWwiO3M6MTA6IlVwZGF0ZWQgYXQiO3M6ODoiaXNIaWRkZW4iO2I6MDtzOjk6ImlzVG9nZ2xlZCI7YjowO3M6MTI6ImlzVG9nZ2xlYWJsZSI7YjoxO3M6MjQ6ImlzVG9nZ2xlZEhpZGRlbkJ5RGVmYXVsdCI7YjoxO319czo0MDoiOGZhYzZlYjFjZWMyNjgwM2IzZjdmYjQ0MGEyNzExMWJfY29sdW1ucyI7YTo5OntpOjA7YTo3OntzOjQ6InR5cGUiO3M6NjoiY29sdW1uIjtzOjQ6Im5hbWUiO3M6NToiaW1hZ2UiO3M6NToibGFiZWwiO3M6NToiSW1hZ2UiO3M6ODoiaXNIaWRkZW4iO2I6MDtzOjk6ImlzVG9nZ2xlZCI7YjoxO3M6MTI6ImlzVG9nZ2xlYWJsZSI7YjowO3M6MjQ6ImlzVG9nZ2xlZEhpZGRlbkJ5RGVmYXVsdCI7Tjt9aToxO2E6Nzp7czo0OiJ0eXBlIjtzOjY6ImNvbHVtbiI7czo0OiJuYW1lIjtzOjU6InRpdGxlIjtzOjU6ImxhYmVsIjtzOjc6IlByb2R1Y3QiO3M6ODoiaXNIaWRkZW4iO2I6MDtzOjk6ImlzVG9nZ2xlZCI7YjoxO3M6MTI6ImlzVG9nZ2xlYWJsZSI7YjowO3M6MjQ6ImlzVG9nZ2xlZEhpZGRlbkJ5RGVmYXVsdCI7Tjt9aToyO2E6Nzp7czo0OiJ0eXBlIjtzOjY6ImNvbHVtbiI7czo0OiJuYW1lIjtzOjE0OiJjYXRlZ29yeS50aXRsZSI7czo1OiJsYWJlbCI7czo4OiJDYXRlZ29yeSI7czo4OiJpc0hpZGRlbiI7YjowO3M6OToiaXNUb2dnbGVkIjtiOjE7czoxMjoiaXNUb2dnbGVhYmxlIjtiOjA7czoyNDoiaXNUb2dnbGVkSGlkZGVuQnlEZWZhdWx0IjtOO31pOjM7YTo3OntzOjQ6InR5cGUiO3M6NjoiY29sdW1uIjtzOjQ6Im5hbWUiO3M6MTE6ImJyYW5kLnRpdGxlIjtzOjU6ImxhYmVsIjtzOjU6IkJyYW5kIjtzOjg6ImlzSGlkZGVuIjtiOjA7czo5OiJpc1RvZ2dsZWQiO2I6MTtzOjEyOiJpc1RvZ2dsZWFibGUiO2I6MDtzOjI0OiJpc1RvZ2dsZWRIaWRkZW5CeURlZmF1bHQiO047fWk6NDthOjc6e3M6NDoidHlwZSI7czo2OiJjb2x1bW4iO3M6NDoibmFtZSI7czozOiJza3UiO3M6NToibGFiZWwiO3M6MzoiU0tVIjtzOjg6ImlzSGlkZGVuIjtiOjA7czo5OiJpc1RvZ2dsZWQiO2I6MTtzOjEyOiJpc1RvZ2dsZWFibGUiO2I6MDtzOjI0OiJpc1RvZ2dsZWRIaWRkZW5CeURlZmF1bHQiO047fWk6NTthOjc6e3M6NDoidHlwZSI7czo2OiJjb2x1bW4iO3M6NDoibmFtZSI7czo1OiJwcmljZSI7czo1OiJsYWJlbCI7czo1OiJQcmljZSI7czo4OiJpc0hpZGRlbiI7YjowO3M6OToiaXNUb2dnbGVkIjtiOjE7czoxMjoiaXNUb2dnbGVhYmxlIjtiOjA7czoyNDoiaXNUb2dnbGVkSGlkZGVuQnlEZWZhdWx0IjtOO31pOjY7YTo3OntzOjQ6InR5cGUiO3M6NjoiY29sdW1uIjtzOjQ6Im5hbWUiO3M6MTA6InNhbGVfcHJpY2UiO3M6NToibGFiZWwiO3M6MTA6IlNhbGUgUHJpY2UiO3M6ODoiaXNIaWRkZW4iO2I6MDtzOjk6ImlzVG9nZ2xlZCI7YjoxO3M6MTI6ImlzVG9nZ2xlYWJsZSI7YjowO3M6MjQ6ImlzVG9nZ2xlZEhpZGRlbkJ5RGVmYXVsdCI7Tjt9aTo3O2E6Nzp7czo0OiJ0eXBlIjtzOjY6ImNvbHVtbiI7czo0OiJuYW1lIjtzOjk6ImlzX2FjdGl2ZSI7czo1OiJsYWJlbCI7czo2OiJBY3RpdmUiO3M6ODoiaXNIaWRkZW4iO2I6MDtzOjk6ImlzVG9nZ2xlZCI7YjoxO3M6MTI6ImlzVG9nZ2xlYWJsZSI7YjowO3M6MjQ6ImlzVG9nZ2xlZEhpZGRlbkJ5RGVmYXVsdCI7Tjt9aTo4O2E6Nzp7czo0OiJ0eXBlIjtzOjY6ImNvbHVtbiI7czo0OiJuYW1lIjtzOjEwOiJjcmVhdGVkX2F0IjtzOjU6ImxhYmVsIjtzOjc6IkNyZWF0ZWQiO3M6ODoiaXNIaWRkZW4iO2I6MDtzOjk6ImlzVG9nZ2xlZCI7YjowO3M6MTI6ImlzVG9nZ2xlYWJsZSI7YjoxO3M6MjQ6ImlzVG9nZ2xlZEhpZGRlbkJ5RGVmYXVsdCI7YjoxO319fXM6ODoiZmlsYW1lbnQiO2E6MDp7fX0=', 1787028836);

-- --------------------------------------------------------

--
-- Table structure for table `afritechs_testimonials`
--

CREATE TABLE `afritechs_testimonials` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `afritechs_testimonials`
--

INSERT INTO `afritechs_testimonials` (`id`, `name`, `description`, `image`, `created_at`, `updated_at`) VALUES
(13, 'Test12', 'Test1 Desc', 'testimonials/01KZTXRCCDH692DR4JV38JSTRS.jpg', '2026-08-12 06:34:36', '2026-08-12 22:34:30');

-- --------------------------------------------------------

--
-- Table structure for table `afritechs_users`
--

CREATE TABLE `afritechs_users` (
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
-- Dumping data for table `afritechs_users`
--

INSERT INTO `afritechs_users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Administrator', 'admin@gmail.com', NULL, '$2y$12$xKxz6DFOLbDfEkShwdFWI.jtiAfr1P/tLC7xtPrlsY7A73W5INWrC', NULL, '2026-08-11 23:15:52', '2026-08-12 02:34:05');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `afritechs_banners`
--
ALTER TABLE `afritechs_banners`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `afritechs_brands`
--
ALTER TABLE `afritechs_brands`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `afritechs_slug_unique` (`slug`);

--
-- Indexes for table `afritechs_cache`
--
ALTER TABLE `afritechs_cache`
  ADD PRIMARY KEY (`key`),
  ADD KEY `afritechs_cache_expiration_index` (`expiration`);

--
-- Indexes for table `afritechs_cache_locks`
--
ALTER TABLE `afritechs_cache_locks`
  ADD PRIMARY KEY (`key`),
  ADD KEY `afritechs_cache_locks_expiration_index` (`expiration`);

--
-- Indexes for table `afritechs_careers`
--
ALTER TABLE `afritechs_careers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `afritechs_categories`
--
ALTER TABLE `afritechs_categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `afritechs_categories_slug_unique` (`slug`);

--
-- Indexes for table `afritechs_failed_jobs`
--
ALTER TABLE `afritechs_failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `afritechs_failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `afritechs_hero_sliders`
--
ALTER TABLE `afritechs_hero_sliders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `afritechs_jobs`
--
ALTER TABLE `afritechs_jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `afritechs_jobs_queue_index` (`queue`);

--
-- Indexes for table `afritechs_job_batches`
--
ALTER TABLE `afritechs_job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `afritechs_migrations`
--
ALTER TABLE `afritechs_migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `afritechs_news`
--
ALTER TABLE `afritechs_news`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slug` (`slug`);

--
-- Indexes for table `afritechs_pages`
--
ALTER TABLE `afritechs_pages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `afritechs_password_reset_tokens`
--
ALTER TABLE `afritechs_password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `afritechs_products`
--
ALTER TABLE `afritechs_products`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `afritechs_products_slug_unique` (`slug`),
  ADD KEY `afritechs_products_category_id_index` (`category_id`),
  ADD KEY `afritechs_products_brand_id_index` (`brand_id`);

--
-- Indexes for table `afritechs_product_faqs`
--
ALTER TABLE `afritechs_product_faqs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `afritechs_product_faqs_product_id_index` (`product_id`);

--
-- Indexes for table `afritechs_product_images`
--
ALTER TABLE `afritechs_product_images`
  ADD PRIMARY KEY (`id`),
  ADD KEY `afritechs_product_images_product_id_index` (`product_id`);

--
-- Indexes for table `afritechs_product_specifications`
--
ALTER TABLE `afritechs_product_specifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `afritechs_product_specifications_product_id_index` (`product_id`);

--
-- Indexes for table `afritechs_projects`
--
ALTER TABLE `afritechs_projects`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `projects_slug_unique` (`slug`),
  ADD KEY `fk_projects_service` (`service_id`);

--
-- Indexes for table `afritechs_project_images`
--
ALTER TABLE `afritechs_project_images`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_project_galleries_project` (`project_id`);

--
-- Indexes for table `afritechs_seos`
--
ALTER TABLE `afritechs_seos`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `afritechs_services`
--
ALTER TABLE `afritechs_services`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slug` (`slug`);

--
-- Indexes for table `afritechs_sessions`
--
ALTER TABLE `afritechs_sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `afritechs_sessions_user_id_index` (`user_id`),
  ADD KEY `afritechs_sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `afritechs_testimonials`
--
ALTER TABLE `afritechs_testimonials`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `afritechs_users`
--
ALTER TABLE `afritechs_users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `afritechs_users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `afritechs_banners`
--
ALTER TABLE `afritechs_banners`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `afritechs_brands`
--
ALTER TABLE `afritechs_brands`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `afritechs_careers`
--
ALTER TABLE `afritechs_careers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `afritechs_categories`
--
ALTER TABLE `afritechs_categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `afritechs_failed_jobs`
--
ALTER TABLE `afritechs_failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `afritechs_hero_sliders`
--
ALTER TABLE `afritechs_hero_sliders`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `afritechs_jobs`
--
ALTER TABLE `afritechs_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `afritechs_migrations`
--
ALTER TABLE `afritechs_migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `afritechs_news`
--
ALTER TABLE `afritechs_news`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `afritechs_pages`
--
ALTER TABLE `afritechs_pages`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `afritechs_products`
--
ALTER TABLE `afritechs_products`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `afritechs_product_faqs`
--
ALTER TABLE `afritechs_product_faqs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `afritechs_product_images`
--
ALTER TABLE `afritechs_product_images`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `afritechs_product_specifications`
--
ALTER TABLE `afritechs_product_specifications`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `afritechs_projects`
--
ALTER TABLE `afritechs_projects`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `afritechs_project_images`
--
ALTER TABLE `afritechs_project_images`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `afritechs_seos`
--
ALTER TABLE `afritechs_seos`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `afritechs_services`
--
ALTER TABLE `afritechs_services`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `afritechs_testimonials`
--
ALTER TABLE `afritechs_testimonials`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `afritechs_users`
--
ALTER TABLE `afritechs_users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `afritechs_products`
--
ALTER TABLE `afritechs_products`
  ADD CONSTRAINT `afritechs_products_brand_id_foreign` FOREIGN KEY (`brand_id`) REFERENCES `afritechs_brands` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `afritechs_products_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `afritechs_categories` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `afritechs_product_faqs`
--
ALTER TABLE `afritechs_product_faqs`
  ADD CONSTRAINT `afritechs_product_faqs_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `afritechs_products` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `afritechs_product_images`
--
ALTER TABLE `afritechs_product_images`
  ADD CONSTRAINT `afritechs_product_images_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `afritechs_products` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `afritechs_product_specifications`
--
ALTER TABLE `afritechs_product_specifications`
  ADD CONSTRAINT `afritechs_product_specifications_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `afritechs_products` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `afritechs_projects`
--
ALTER TABLE `afritechs_projects`
  ADD CONSTRAINT `fk_projects_service` FOREIGN KEY (`service_id`) REFERENCES `afritechs_services` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `afritechs_project_images`
--
ALTER TABLE `afritechs_project_images`
  ADD CONSTRAINT `fk_project_galleries_project` FOREIGN KEY (`project_id`) REFERENCES `afritechs_projects` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
