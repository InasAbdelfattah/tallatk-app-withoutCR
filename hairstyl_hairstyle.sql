-- phpMyAdmin SQL Dump
-- version 4.7.7
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Sep 04, 2018 at 07:45 AM
-- Server version: 5.6.40
-- PHP Version: 5.6.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `hairstyl_hairstyle`
--

-- --------------------------------------------------------

--
-- Table structure for table `abilities`
--

CREATE TABLE `abilities` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `title` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `entity_id` int(10) UNSIGNED DEFAULT NULL,
  `entity_type` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `only_owned` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `abilities`
--

INSERT INTO `abilities` (`id`, `name`, `title`, `entity_id`, `entity_type`, `only_owned`, `created_at`, `updated_at`) VALUES
(1, '*', 'جميع الصلاحيات', NULL, '*', 0, NULL, NULL),
(6, 'users_manage', 'ادارة المستخدمين', NULL, NULL, 0, '2018-03-22 07:42:41', '2018-03-22 07:42:41'),
(7, 'admin_manage', 'ادارة التطبيق', NULL, NULL, 0, '2018-03-22 07:42:41', '2018-03-22 07:42:41'),
(8, 'content_manage', 'ادارة المحتوى', NULL, NULL, 0, '2018-03-22 07:42:41', '2018-03-22 07:42:41'),
(9, 'setting_manage', 'الاعدادات', NULL, NULL, 0, '2018-03-22 07:42:41', '2018-03-22 07:42:41'),
(10, 'contact_manage', 'ادارة التواصل مع التطبيق', NULL, NULL, 0, '2018-03-22 07:42:41', '2018-03-22 07:42:41'),
(18, '*', NULL, NULL, NULL, 0, '2018-05-23 09:01:09', '2018-05-23 09:01:09'),
(19, 'orders_manage', 'ادارة الحجوزات', NULL, NULL, 0, '2018-03-22 07:42:41', '2018-03-22 07:42:41'),
(20, 'statistics_manage', 'مشاهدة الاحصائيات', NULL, NULL, 0, '2018-03-22 07:42:41', '2018-03-22 07:42:41');

-- --------------------------------------------------------

--
-- Table structure for table `abuses`
--

CREATE TABLE `abuses` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `company_id` int(11) NOT NULL,
  `abuseable_id` int(11) NOT NULL,
  `abuseable_type` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `text` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_adopt` tinyint(4) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `assigned_roles`
--

CREATE TABLE `assigned_roles` (
  `role_id` int(10) UNSIGNED NOT NULL,
  `entity_id` int(10) UNSIGNED NOT NULL,
  `entity_type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `assigned_roles`
--

INSERT INTO `assigned_roles` (`role_id`, `entity_id`, `entity_type`) VALUES
(3, 85, 'App\\User'),
(3, 6, 'App\\User'),
(3, 84, 'App\\User'),
(1, 1, 'App\\User'),
(3, 136, 'App\\User'),
(3, 137, 'App\\User'),
(3, 149, 'App\\User'),
(11, 150, 'App\\User');

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `name_ar` varchar(255) NOT NULL,
  `name_en` varchar(255) NOT NULL,
  `description_ar` varchar(255) DEFAULT NULL,
  `description_en` varchar(255) DEFAULT NULL,
  `target_gender` tinyint(4) NOT NULL,
  `parent_id` int(11) NOT NULL,
  `image` varchar(100) NOT NULL,
  `is_active` tinyint(4) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name_ar`, `name_en`, `description_ar`, `description_en`, `target_gender`, `parent_id`, `image`, `is_active`, `created_at`, `updated_at`, `deleted_at`) VALUES
(14, 'قص  شعر', 'hair cut', 'جديده', 'new', 2, 0, 'http://hairstyleapp-sa.com/files/categories/1535548887.vV5P5EzqSWYsnWkRnYqiimages.jpg', 1, '2018-08-29 13:24:57', '2018-08-29 13:24:57', '2018-08-29 13:24:57'),
(15, 'قص  شعر', 'hair cut', 'خدمه جديده', 'new service', 2, 0, 'http://hairstyleapp-sa.com/files/categories/1535549169.unJM9vKBbeIbcLn4NAgUimages.jpg', 1, '2018-08-29 13:26:54', '2018-08-29 13:26:54', '2018-08-29 13:26:54'),
(16, 'قص  شعر', 'hair cut', 'خدمه جديده', 'new service', 2, 0, 'http://hairstyleapp-sa.com/files/categories/1535549262.EXBLFnBoq2sbJbMDQKuTimages.jpg', 1, '2018-08-29 13:27:42', '2018-08-29 13:27:42', NULL),
(17, 'خدمات عامه', 'general services', 'خدمات', 'services', 2, 0, 'http://hairstyleapp-sa.com/files/categories/1535833230.y9KL6f2JgaS3Tqjy5Rt6test pic.jpg', 1, '2018-09-01 20:20:30', '2018-09-01 20:20:30', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `centers`
--

CREATE TABLE `centers` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `place` enum('home','center') COLLATE utf8mb4_unicode_ci NOT NULL,
  `lat` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `lng` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_accepted` tinyint(1) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `type` enum('person','center') COLLATE utf8mb4_unicode_ci NOT NULL,
  `document_photo` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `city_id` int(10) UNSIGNED NOT NULL,
  `category_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cities`
--

CREATE TABLE `cities` (
  `id` int(10) UNSIGNED NOT NULL,
  `created_by` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cities`
--

INSERT INTO `cities` (`id`, `created_by`, `created_at`, `updated_at`, `deleted_at`) VALUES
(17, 1, '2018-08-30 09:56:17', '2018-08-30 09:56:17', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `city_translations`
--

CREATE TABLE `city_translations` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `city_id` int(10) UNSIGNED NOT NULL,
  `locale` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `city_translations`
--

INSERT INTO `city_translations` (`id`, `name`, `city_id`, `locale`, `created_at`, `updated_at`) VALUES
(37, 'مصر', 15, 'ar', NULL, NULL),
(38, 'egypt', 15, 'en', NULL, NULL),
(39, 'مكه', 16, 'ar', NULL, NULL),
(40, 'Makka', 16, 'en', NULL, NULL),
(41, 'الرياض', 17, 'ar', NULL, NULL),
(42, 'Reyad', 17, 'en', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `parent_id` bigint(20) NOT NULL DEFAULT '0',
  `user_id` bigint(20) NOT NULL DEFAULT '0',
  `commentable_id` bigint(20) NOT NULL,
  `commentable_type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `comment` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_active` tinyint(4) NOT NULL DEFAULT '1',
  `is_approve` tinyint(4) NOT NULL DEFAULT '0',
  `is_suspend` tinyint(4) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`id`, `parent_id`, `user_id`, `commentable_id`, `commentable_type`, `comment`, `is_active`, `is_approve`, `is_suspend`, `created_at`, `updated_at`) VALUES
(181, 0, 154, 83, 'App\\Company', 'Hello', 1, 0, 0, '2018-09-03 20:59:49', '2018-09-03 20:59:49'),
(182, 0, 152, 83, 'App\\Company', 'Hello', 1, 0, 0, '2018-09-03 21:00:56', '2018-09-03 21:00:56');

-- --------------------------------------------------------

--
-- Table structure for table `companies`
--

CREATE TABLE `companies` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `nameAr` varchar(100) CHARACTER SET utf8 DEFAULT NULL,
  `is_comment` tinyint(1) NOT NULL DEFAULT '1',
  `category_id` int(11) DEFAULT NULL,
  `phone` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `place` tinyint(4) DEFAULT NULL,
  `type` tinyint(4) NOT NULL,
  `document_photo` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_rate` tinyint(1) NOT NULL DEFAULT '1',
  `description` longtext COLLATE utf8mb4_unicode_ci,
  `city_id` int(11) NOT NULL,
  `district_id` int(11) DEFAULT NULL,
  `address` text COLLATE utf8mb4_unicode_ci,
  `facebook` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `twitter` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `google` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `lat` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `lng` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_agree` tinyint(1) NOT NULL DEFAULT '0',
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `image` text COLLATE utf8mb4_unicode_ci,
  `visits_count` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `companies`
--

INSERT INTO `companies` (`id`, `name`, `user_id`, `nameAr`, `is_comment`, `category_id`, `phone`, `place`, `type`, `document_photo`, `is_rate`, `description`, `city_id`, `district_id`, `address`, `facebook`, `twitter`, `google`, `lat`, `lng`, `is_agree`, `is_active`, `created_at`, `updated_at`, `image`, `visits_count`) VALUES
(82, '', 151, '', 1, NULL, '', 0, 1, '', 1, NULL, 2, NULL, '', '', '', '', '', '', 0, 0, '2018-09-02 09:19:58', '2018-09-02 09:19:58', NULL, NULL),
(83, '', 154, '', 1, NULL, '', 0, 0, '1535968044.8spZPKKTntvCwMvScqwWimage.jpg', 1, NULL, 17, NULL, 'Hy El-Gamaa, Mit Badr Khamees, Mansoura, Dakahlia Governorate, Egypt', '', '', '', '31.0350345', '31.3576028', 0, 0, '2018-09-03 09:47:24', '2018-09-04 12:40:36', '1535971220.RinuGusrPFqLqjeiZ0eQimage.jpg', 14);

-- --------------------------------------------------------

--
-- Table structure for table `company_translations`
--

CREATE TABLE `company_translations` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `company_id` int(10) UNSIGNED NOT NULL,
  `locale` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `company_translations`
--

INSERT INTO `company_translations` (`id`, `name`, `description`, `company_id`, `locale`, `created_at`, `updated_at`) VALUES
(90, 'ahmed', '', 82, 'ar', NULL, NULL),
(91, 'ahmed', '', 82, 'en', NULL, NULL),
(92, 'Hair style centre', 'Test', 83, 'ar', NULL, NULL),
(93, 'Hair style centre', '', 83, 'en', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `company_work_days`
--

CREATE TABLE `company_work_days` (
  `id` int(10) UNSIGNED NOT NULL,
  `day` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `from` time NOT NULL,
  `to` time NOT NULL,
  `company_id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `company_work_days`
--

INSERT INTO `company_work_days` (`id`, `day`, `from`, `to`, `company_id`, `created_at`, `updated_at`) VALUES
(310, 'Sun', '09:00:00', '23:00:00', 83, '2018-09-03 10:40:20', '2018-09-03 10:40:20'),
(311, 'Mon', '09:00:00', '23:00:00', 83, '2018-09-03 10:40:20', '2018-09-03 10:40:20'),
(312, 'Tue', '09:00:00', '23:00:00', 83, '2018-09-03 10:40:20', '2018-09-03 10:40:20'),
(313, 'Wed', '09:00:00', '23:00:00', 83, '2018-09-03 10:40:20', '2018-09-03 10:40:20'),
(314, 'Thu', '09:00:00', '23:00:00', 83, '2018-09-03 10:40:20', '2018-09-03 10:40:20');

-- --------------------------------------------------------

--
-- Table structure for table `contact_us`
--

CREATE TABLE `contact_us` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `text` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `msg_type` enum('complain','suggest','other') COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `devices`
--

CREATE TABLE `devices` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `device` longtext NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `devices`
--

INSERT INTO `devices` (`id`, `user_id`, `device`, `created_at`, `updated_at`) VALUES
(380, 152, 'cfYRSBDdsJM:APA91bEonbHRMVhMwtHkptTqQhLJjbXHP9nmSqQ0C6pLTyazRTiiqmb08Nm0GxOXbEk4hLYIi6uNMfVuQ-y1rTZL0nZfXZboBaFs13J_mYkLjTK0ssK-08jz8QfQZpLpaRzZi8HlDxuz', '2018-09-03 08:44:22', '2018-09-03 08:44:22'),
(386, 154, 'cfYRSBDdsJM:APA91bEonbHRMVhMwtHkptTqQhLJjbXHP9nmSqQ0C6pLTyazRTiiqmb08Nm0GxOXbEk4hLYIi6uNMfVuQ-y1rTZL0nZfXZboBaFs13J_mYkLjTK0ssK-08jz8QfQZpLpaRzZi8HlDxuz', '2018-09-03 11:04:34', '2018-09-03 11:04:34'),
(387, 152, 'fuioqV2oE4o:APA91bHpC9or2iR-_GxKMYqaYmzmqt_cYvvtvBG2hby1R2k1TP47eSEivE00TPjRVjdMRsLL60s2JpJ1--hLuUXT7mv5pvxxLQk0KTlUwf6KVMNjh7sggONgSVENDD1y9yolbiknFcq4', '2018-09-03 21:00:31', '2018-09-03 21:00:31'),
(388, 152, 'c3T7uT2WwEY:APA91bH9f9NNWFBnLAVpO8_UjJAlv38d93Lb6a5DkdjXfzxg0qqqzDBGRRqiKdbLgHj5sMG5K5_92eximb8WOBBpZfL7paT6HTwknfwF59vTc3vaoNj8GPSS72S9tM66bnymLwj3CsQP', '2018-09-04 08:55:43', '2018-09-04 08:55:43');

-- --------------------------------------------------------

--
-- Table structure for table `districts`
--

CREATE TABLE `districts` (
  `id` int(10) UNSIGNED NOT NULL,
  `created_by` int(10) UNSIGNED NOT NULL,
  `city_id` int(10) UNSIGNED NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `districts`
--

INSERT INTO `districts` (`id`, `created_by`, `city_id`, `deleted_at`, `created_at`, `updated_at`) VALUES
(4, 1, 17, NULL, '2018-08-30 10:25:02', '2018-08-30 10:25:02');

-- --------------------------------------------------------

--
-- Table structure for table `district_translations`
--

CREATE TABLE `district_translations` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `district_id` int(10) UNSIGNED NOT NULL,
  `locale` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `district_translations`
--

INSERT INTO `district_translations` (`id`, `name`, `district_id`, `locale`, `created_at`, `updated_at`) VALUES
(25, 'حي 1', 4, 'ar', NULL, NULL),
(26, 'area 1', 4, 'en', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `favourites`
--

CREATE TABLE `favourites` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `company_id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `financial_accounts`
--

CREATE TABLE `financial_accounts` (
  `id` int(11) NOT NULL,
  `company_id` int(11) NOT NULL,
  `orders_count` varchar(100) NOT NULL,
  `net_app_ratio` varchar(100) NOT NULL,
  `pay_status` tinyint(4) NOT NULL,
  `pay_doc` varchar(100) NOT NULL,
  `is_confirmed` tinyint(4) NOT NULL,
  `paid` varchar(100) NOT NULL DEFAULT '0',
  `transfered_money` varchar(100) NOT NULL DEFAULT '0',
  `last_transfered_money` varchar(100) DEFAULT '0',
  `remain` varchar(100) NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `images`
--

CREATE TABLE `images` (
  `id` int(11) NOT NULL,
  `service_id` int(11) NOT NULL,
  `imageable_id` varchar(100) NOT NULL,
  `imageable_type` varchar(100) NOT NULL,
  `image` varchar(100) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `management_levels`
--

CREATE TABLE `management_levels` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `items` longtext NOT NULL,
  `created_by` int(11) NOT NULL,
  `status` tinyint(4) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2018_03_05_000432_create_cities_table', 1),
(4, '2018_03_05_010806_create_districts_table', 1),
(5, '2018_03_05_013450_create_centers_table', 1),
(6, '2018_03_05_072831_create_service_types_table', 1),
(7, '2018_03_05_073229_create_service_type_translations_table', 1),
(8, '2018_03_05_082443_create_services_table', 1),
(9, '2018_03_05_082608_create_service_translations_table', 1),
(10, '2018_03_05_090443_create_contact_us_table', 1),
(11, '2018_03_05_091907_create_comments_table', 1),
(12, '2018_03_05_092255_create_rates_table', 1),
(13, '2018_03_05_092929_create_favourites_table', 1),
(14, '2018_03_05_100758_create_city_translations_table', 1),
(15, '2018_03_05_110915_create_district_translations_table', 1),
(16, '2018_03_05_115328_create_center_work_days_table', 1),
(17, '2018_03_05_115602_create_user_invitations_table', 1),
(18, '2018_03_05_115745_create_orders_table', 1),
(19, '2018_03_05_121823_create_reports_table', 1),
(20, '2018_03_05_144248_create_app_ratios_table', 1),
(21, '2018_03_06_093324_create_center_translations_table', 1),
(22, '2018_03_07_111626_create_bouncer_tables', 2),
(23, '2016_06_01_000001_create_oauth_auth_codes_table', 3),
(24, '2016_06_01_000002_create_oauth_access_tokens_table', 3),
(25, '2016_06_01_000003_create_oauth_refresh_tokens_table', 3),
(26, '2016_06_01_000004_create_oauth_clients_table', 3),
(27, '2016_06_01_000005_create_oauth_personal_access_clients_table', 3);

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` int(11) NOT NULL,
  `msg` varchar(1000) NOT NULL,
  `title` varchar(100) DEFAULT NULL,
  `image` varchar(100) DEFAULT NULL,
  `to_user` varchar(100) NOT NULL,
  `notif_type` varchar(100) DEFAULT NULL,
  `type` varchar(100) NOT NULL,
  `target_id` int(11) DEFAULT NULL,
  `is_seen` tinyint(4) NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `notifications`
--

INSERT INTO `notifications` (`id`, `msg`, `title`, `image`, `to_user`, `notif_type`, `type`, `target_id`, `is_seen`, `created_at`, `updated_at`) VALUES
(103, 'Hello', 'Hair style centre', '', '154', 'comment', 'single', NULL, 0, '2018-09-03 20:59:49', '2018-09-03 20:59:49'),
(104, 'Hello', 'Hala', '', '154', 'comment', 'single', NULL, 0, '2018-09-03 21:00:56', '2018-09-03 21:00:56');

-- --------------------------------------------------------

--
-- Table structure for table `oauth_access_tokens`
--

CREATE TABLE `oauth_access_tokens` (
  `id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `client_id` int(11) NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `scopes` text COLLATE utf8mb4_unicode_ci,
  `revoked` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `expires_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `oauth_access_tokens`
--

INSERT INTO `oauth_access_tokens` (`id`, `user_id`, `client_id`, `name`, `scopes`, `revoked`, `created_at`, `updated_at`, `expires_at`) VALUES
('01e64e049ee5728d2ba1662333592745998254c9f8d4dfae4e8dae7cbcb43bcbe098a5b278fcd213', 130, 3, 'Test', '[]', 0, '2018-06-19 07:53:48', '2018-06-19 07:53:48', '2019-06-19 10:53:48'),
('0b3b74a37d827af509e0022a50b1658529580ba09694d2058f98106fba0a85237a38c157f0a0793e', 79, 3, 'clza', '[]', 0, '2018-04-16 07:26:08', '2018-04-16 07:26:08', '2019-04-16 10:26:08'),
('0f3781dd765ce089bf546c0996286a4d5cd4a65af32cee19d8d5c85eca9620729f4df37e58179408', 146, 3, 'Beauty center', '[]', 0, '2018-08-02 10:40:42', '2018-08-02 10:40:42', '2019-08-02 13:40:42'),
('0fabb4b22f6853cfea88ad6aaa522f1f4bef84606e277f7b6eaabae694303b7c6bf8fb2805d4b66f', 81, 3, 'note', '[]', 0, '2018-06-18 22:54:58', '2018-06-18 22:54:58', '2019-06-19 01:54:58'),
('10e500b66f9340412d52d7af6ed9d5597db8b417040603420882b6b53943cbba9a2f496617e24a07', 80, 3, 'clza', '[]', 0, '2018-04-16 08:14:19', '2018-04-16 08:14:19', '2019-04-16 11:14:19'),
('1357f1f6f24cf8bafe5950c5f4e21dc0050cd3307da08d9e8cda0cd6f5ecc45bdc3f4ef9098c0be9', 89, 3, 'Test', '[]', 0, '2018-05-20 08:14:57', '2018-05-20 08:14:57', '2019-05-20 11:14:57'),
('146ad86667bb32536435efbf853785ec5a391afaa745897417c79fed1b601b7e4a000bba0f15e62c', 113, 3, 'انا', '[]', 0, '2018-06-04 04:22:01', '2018-06-04 04:22:01', '2019-06-04 07:22:01'),
('146fd8e3f2c9eafb7a27632d446312277b3b2753fc80a2d19f8269bf7da0210aeaf9c112ae9436dd', 102, 3, 'Test', '[]', 0, '2018-05-28 07:31:36', '2018-05-28 07:31:36', '2019-05-28 10:31:36'),
('14be7578a73f9c816f49c627ec2ead157c58664cb61e3da3fbed7a7d7886e313f7549274197fb78f', 105, 3, 'Testtest', '[]', 0, '2018-05-30 09:48:39', '2018-05-30 09:48:39', '2019-05-30 12:48:39'),
('14cf4f8ec199120b40de5a2aab4f732634494e7aaa8d04033e7feb02c9ff5442717dc12802ed7b43', 106, 3, 'طلتتك', '[]', 0, '2018-06-10 09:42:02', '2018-06-10 09:42:02', '2019-06-10 12:42:02'),
('164c0eafb912834485aa140eaf94181bafa9e084006ce0274a3dcea457b408f84af31200532b318e', 128, 3, 'Ttt', '[]', 0, '2018-06-10 12:11:46', '2018-06-10 12:11:46', '2019-06-10 15:11:46'),
('16ac57f8d72dfa3b325a9db2fd7eec210ff969c0b7973957d5c790c8d4c44617efb78458ef0b60c8', 112, 3, 'انا', '[]', 0, '2018-06-04 04:21:25', '2018-06-04 04:21:25', '2019-06-04 07:21:25'),
('173dbc539cfe17d520c1cda51b5fdf1907c7536fd4307b6bf124969d6d05b6cbdfb998ab6bce5d36', 106, 3, 'طلتك', '[]', 0, '2018-05-30 12:40:49', '2018-05-30 12:40:49', '2019-05-30 15:40:49'),
('1785369852407039b7824492b88fd1e46d6d4c5b0d8930bbbf8e74c8e4c39b8406ab04c55f65f47a', 111, 3, 'talla username', '[]', 0, '2018-06-03 11:22:10', '2018-06-03 11:22:10', '2019-06-03 14:22:10'),
('1a62db8af3a40f8b914bf099d5f1318c10166470ac412b01d1f570712f8ebe470fd247b933e40cda', 130, 3, 'Test', '[]', 0, '2018-06-19 07:53:31', '2018-06-19 07:53:31', '2019-06-19 10:53:31'),
('1b70827a551d0b57a83289cf71f89190b61f0b66889a6705009cc07c323a1d349fb464569613c973', 95, 3, 'Test providers', '[]', 0, '2018-05-20 12:24:49', '2018-05-20 12:24:49', '2019-05-20 15:24:49'),
('266fe5055df87424c22a261a121372dd0eee2e3160bb3a3efcb11db31ff6113a01ad3dc388b45a81', 66, 3, 'ramy', '[]', 0, '2018-04-12 05:56:32', '2018-04-12 05:56:32', '2019-04-12 08:56:32'),
('27891ef06abb23301fac1577da587f17409fb684ba1289554490e0eb0f763846e118896a1ee22629', 144, 3, 'Mohamed', '[]', 0, '2018-07-09 07:31:59', '2018-07-09 07:31:59', '2019-07-09 10:31:59'),
('2c7a9b76c7584c6abfb7729ba431a8ca236aacfd9630a4826108738bf918c76b5de5461fbf1478f4', 123, 3, 'New', '[]', 0, '2018-06-10 08:44:49', '2018-06-10 08:44:49', '2019-06-10 11:44:49'),
('2dceb54623675f384df9084c5d9f4235135607d1da0962e41f96b88adc923f82feab830f8d5e9681', 67, 3, 'webway', '[]', 0, '2018-04-12 06:26:23', '2018-04-12 06:26:23', '2019-04-12 09:26:23'),
('2f6e314c77ed3a5e4581791b4d02cf07bf159603baee935dece389bb81efd2203231d73b4655f2bb', 101, 3, 'Test22', '[]', 0, '2018-05-26 12:00:27', '2018-05-26 12:00:27', '2019-05-26 15:00:27'),
('33c4bcbedfe584dc83654da447c68beb17017ae89851795042850a72a29640db0c5d09e9a964fe67', 68, 3, 'web', '[]', 0, '2018-04-12 06:32:39', '2018-04-12 06:32:39', '2019-04-12 09:32:39'),
('35760bbd1c6df3db8e817c0547799636aa5ce5f67cf7652ab82f7dfd05fae236ef6615ea632dd4a8', 51, 3, 'Maher', '[]', 0, '2018-04-05 05:27:41', '2018-04-05 05:27:41', '2019-04-05 08:27:41'),
('3aa649801b6dbb8e507e9766b5b880558da503949c28b159b4f93c411cfaf9e36e1237341a1fd1e8', 56, 3, 'Ramiii', '[]', 0, '2018-04-05 05:52:05', '2018-04-05 05:52:05', '2019-04-05 08:52:05'),
('3cab831d6f32a76170c52c6c14a7e4bdf0c1edcfd72266e871f4090cc1c5d2e6a946982436a63de9', 130, 3, 'Test', '[]', 0, '2018-06-28 12:38:19', '2018-06-28 12:38:19', '2019-06-28 15:38:19'),
('3d7cdca151d6c1e6395af45172c58eb3f90a3d59d46f9f6e45ecf2070191418735bf471565697541', 4, 3, 'inas', '[]', 0, '2018-06-18 22:52:56', '2018-06-18 22:52:56', '2019-06-19 01:52:56'),
('408447b22e688ed22af284f479817cfd3d59586d30e5fc18a6b3f24d9a285b549a8588291e9ec4c0', 154, 3, 'Hair style centre', '[]', 0, '2018-09-03 09:47:24', '2018-09-03 09:47:24', '2019-09-03 12:47:24'),
('41cee8c43fa2580d393c657e5828283131871a9037b3ad9b6cfaa60c309e0c6b11fc1e19028fb1d0', 64, 3, 'www', '[]', 0, '2018-04-11 11:06:28', '2018-04-11 11:06:28', '2019-04-11 14:06:28'),
('4626848af5de662594cf7a719c4cf90e493a1b531e6d858a2435d20c1fa036833467047b0bdf31f3', 110, 3, 'talla name', '[]', 0, '2018-06-03 09:36:41', '2018-06-03 09:36:41', '2019-06-03 12:36:41'),
('47e3bd559d319e27caddb90adae619481ff19effb0410fe1368442a6bbc4abc51b1e785a82e38aca', 156, 3, 'Hggg', '[]', 0, '2018-09-04 12:33:33', '2018-09-04 12:33:33', '2019-09-04 15:33:33'),
('48c412bc1f3c9061fc31be30a2b6233d0c888632f6799becfd60a4327db0a0f5bf4642e87b0fc35a', 81, 3, 'note', '[]', 0, '2018-06-28 12:35:00', '2018-06-28 12:35:00', '2019-06-28 15:35:00'),
('4ad0f686d4174cd8e196580a9d869fd6578c379a974f81336b8d7115fa8b5febdfbfbc85adfdf7de', 4, 3, 'inas', '[]', 0, '2018-06-05 11:55:07', '2018-06-05 11:55:07', '2019-06-05 14:55:07'),
('5035d7b8e54c1da7b99b8828ef9a4ee088cba83451bd30b6b632bece9e73451f63b1992e7191c1e3', 97, 3, 'الامل', '[]', 0, '2018-05-23 12:12:03', '2018-05-23 12:12:03', '2019-05-23 15:12:03'),
('527ef3ece8b5af0b8f67a255f06274f4fcb6c6e569a6e37920e36a2a45b893e3f4d5602d1348c37a', 148, 3, 'Dyxgfufu', '[]', 0, '2018-08-06 13:21:14', '2018-08-06 13:21:14', '2019-08-06 16:21:14'),
('540891a0c4a6ba8e739a747584797283249286a5fd8d5532bc494298d2a20c7d7a2681db0bb389d9', 98, 3, 'Test', '[]', 0, '2018-05-26 10:25:46', '2018-05-26 10:25:46', '2019-05-26 13:25:46'),
('548621587de9df081cf160bbfb97a6ed1bb6204f4489920fa6130029b539379b3872c60616c6b59f', 109, 3, 'aaa', '[]', 0, '2018-05-31 08:13:19', '2018-05-31 08:13:19', '2019-05-31 11:13:19'),
('5716eeb2233ea27ebd971f8b99cedcbc9b6b74b8211432544b2bd78a119f29c8a9427fdc44039d7f', 52, 3, 'Hassan', '[]', 0, '2018-04-05 05:32:57', '2018-04-05 05:32:57', '2019-04-05 08:32:57'),
('5895490cba4a03b2fc0e906755d143058175c1de98a62c0cadc6be2aebeeb5f7bc449698e6c912ed', 49, 3, 'ahmed', '[]', 0, '2018-04-05 04:36:09', '2018-04-05 04:36:09', '2019-04-05 07:36:09'),
('5a41817a9088ff876ed1448b1b466461e1d65aae6229d9794f9f2164858c8a55fcd7f881d03934d4', 42, 3, 'ahmed', '[]', 0, '2018-04-02 11:31:32', '2018-04-02 11:31:32', '2019-04-02 14:31:32'),
('5c6d028f433446a0a449eb7012fd003a514ee50dff79495dce4ce103cdcdbb8c4355a7a52a64124d', 155, 3, 'Nour', '[]', 0, '2018-09-03 09:52:03', '2018-09-03 09:52:03', '2019-09-03 12:52:03'),
('5ed2816df919c147472741a527f33649ff08bacb211897e2794d3234113c99cb4e0ded16217b0bb3', 83, 3, 'Test', '[]', 0, '2018-05-02 09:14:01', '2018-05-02 09:14:01', '2019-05-02 12:14:01'),
('605a74c47486393faceb4c3d5f6e8f5934242b11824178523b3d703a0c785e33b834e5217ed3f5d3', 53, 3, 'Omar', '[]', 0, '2018-04-05 05:37:42', '2018-04-05 05:37:42', '2019-04-05 08:37:42'),
('63cc22d7d0ed078a857ec1cb1758e7ed50d4600ab9282342ae0c0f219a4b6a6e6778971e72e2f2f3', 35, 3, 'samir', '[]', 0, '2018-03-28 06:57:10', '2018-03-28 06:57:10', '2019-03-28 08:57:10'),
('657d52ff88145b5ce8628076cf60c027854030116f831ad82a60a4debcdf3734a40a8d1793fba5d7', 41, 3, 'ahmed', '[]', 0, '2018-04-02 11:30:19', '2018-04-02 11:30:19', '2019-04-02 14:30:19'),
('65d5ce5712c38f44c79052e84655ebdd153735d2b79167671bb8358bdfa6e7a5001f537c349620e8', 43, 3, 'ahmed', '[]', 0, '2018-04-02 11:32:40', '2018-04-02 11:32:40', '2019-04-02 14:32:40'),
('6934cbc78d23598a9eed7519706b0ab4d7f1284e02a47c0a779091a8014d80e94b9f5c762814e1e6', 141, 3, 'Tahani', '[]', 0, '2018-07-01 15:12:35', '2018-07-01 15:12:35', '2019-07-01 18:12:35'),
('69806442d8ec24e2373f1e1fd15df5b292ee172d9019ba01b5a41a262e5a39d4bf1af702dc7b8258', 129, 3, 'Test', '[]', 0, '2018-06-10 13:07:51', '2018-06-10 13:07:51', '2019-06-10 16:07:51'),
('6e30d668dd6aabfcd7ba32825e0928f1a77780621f8a8a6c7a4a0e498bc85156c70135d12b94781f', 74, 3, 'dspy', '[]', 0, '2018-04-14 08:11:18', '2018-04-14 08:11:18', '2019-04-14 11:11:18'),
('74a8254cba283e372175b6f8306bcd1fb5ed593077bc3bae07ecc87ca96f02342e1da11d5f16b004', 60, 3, 'ahmed', '[]', 0, '2018-04-11 10:03:33', '2018-04-11 10:03:33', '2019-04-11 13:03:33'),
('75e314b483527e5e87ea7a50bc53d6b2a5ec54918951e98cb2e79ef7fe3cf420ef3112dcb2ec4b0b', 48, 3, 'ahmed', '[]', 0, '2018-04-05 04:19:48', '2018-04-05 04:19:48', '2019-04-05 07:19:48'),
('76eb74ca102205d7b53602d461c71c1c0bab0d2bb7e6865d92f7fcce5315d7e05cf14dde7b91079f', 130, 3, 'Test', '[]', 0, '2018-06-10 13:19:37', '2018-06-10 13:19:37', '2019-06-10 16:19:37'),
('77abf963d75a42f3138086c287e61b22ab6e44841770168a9a8e18691e198b4bc0de2e4726c0b9b8', 127, 3, 'Maher', '[]', 0, '2018-06-10 11:50:23', '2018-06-10 11:50:23', '2019-06-10 14:50:23'),
('798b594e41a8d88f8e36fd3e960242e9c7a7c1143ce9fcf3d6efaf0f74bd401718269d19d630e3b6', 40, 3, 'ahmed', '[]', 0, '2018-04-02 08:28:59', '2018-04-02 08:28:59', '2019-04-02 11:28:59'),
('7ace342ec2ee96fab961b6ca6af55e0a63bc4808a64ec7fd718731dda536655f6231b6b79e7b4153', 71, 3, 'siteprovider', '[]', 0, '2018-04-12 09:26:30', '2018-04-12 09:26:30', '2019-04-12 12:26:30'),
('7d867fd980a3dc8abdc589f273ba7d58d058ee48a101cc72523de3091b2de57f311408337067605f', 117, 3, 'ddd', '[]', 0, '2018-06-04 12:33:42', '2018-06-04 12:33:42', '2019-06-04 15:33:42'),
('7dc05e58d48c92eb3ad96cb7b152974475d002f08d02c4fa280fc66520dd6b150bfa185bd6b8183c', 4, 3, 'inas', '[]', 0, '2018-06-06 07:52:02', '2018-06-06 07:52:02', '2019-06-06 10:52:02'),
('80224c9d0624918439fdade3bc48b9829876eb2a7b0a6bb6753b6d6e7063f8c17a17c208f69fb2e8', 133, 3, 'Ahmed', '[]', 0, '2018-06-11 11:12:57', '2018-06-11 11:12:57', '2019-06-11 14:12:57'),
('83e4355c87c3e8314cd3cba51fc4b4e458346f933a141c7702004cacff3baad6cd639e1222675027', 107, 3, 'Mohamed', '[]', 0, '2018-05-30 12:54:02', '2018-05-30 12:54:02', '2019-05-30 15:54:02'),
('843fa5faaa0f319993fd554014d64e190602e3780f64a01db5ef85db1927ffab11c19443bf187189', 132, 3, 'Fff', '[]', 0, '2018-06-11 09:04:49', '2018-06-11 09:04:49', '2019-06-11 12:04:49'),
('8748082a218439d8a7abe7f307e64bd11e1783d2d5e7aff56073857d4ab99646522e456bb3649d45', 77, 3, 'saned', '[]', 0, '2018-04-16 05:50:50', '2018-04-16 05:50:50', '2019-04-16 08:50:50'),
('876dcb0a3d4c2b0d0beda4a8e6f9850f550bdc29e2cbe69123885fa2bb4944b03377160d84b737cc', 50, 3, 'ahmed', '[]', 0, '2018-04-05 04:42:37', '2018-04-05 04:42:37', '2019-04-05 07:42:37'),
('88d4d23aa349a4e1874c472c116bd9e84f6f835191f062f386e031e390efbf3149e1c263c36fe146', 39, 3, 'ahmed', '[]', 0, '2018-04-02 08:26:26', '2018-04-02 08:26:26', '2019-04-02 11:26:26'),
('8a6950ad3dc0901aa52646d0f55395ffdad62e4ea4bdc9052370fff4858e255d9bd4f64cdd6a4e0c', 92, 3, 'Test', '[]', 0, '2018-05-20 10:47:48', '2018-05-20 10:47:48', '2019-05-20 13:47:48'),
('8a7faf778450bfcd90213a3f8c09b6aa48ea5ca63c86997ff14f121b56380842af12d1a2435aa92a', 139, 3, 'Ahmed', '[]', 0, '2018-06-27 18:06:16', '2018-06-27 18:06:16', '2019-06-27 21:06:16'),
('8ba2dd84598bd1876ea9d8a384f600b0bb4781643c5a533e9aba63677066f8170383896ff634a363', 72, 3, 'ahmed', '[]', 0, '2018-04-14 06:55:26', '2018-04-14 06:55:26', '2019-04-14 09:55:26'),
('8d7a993780f376cdcb74c660c0d89ec8280c1482550585f484fc7af755b2e52771e067c14af93ead', 120, 3, 'انتي اجمل', '[]', 0, '2018-06-06 18:34:46', '2018-06-06 18:34:46', '2019-06-06 21:34:46'),
('8f29854756dd7b0d7d18f5431bd67431b72f900b35ad16da8359812f87de6dcc54b46911922bd22b', 63, 3, 'market', '[]', 0, '2018-04-11 10:57:02', '2018-04-11 10:57:02', '2019-04-11 13:57:02'),
('9428ce709ee9159017aaf7754827b9a2334963dfd01f5c4bd9096e0314295b40e71ed8b11f73bce6', 103, 3, 'Test', '[]', 0, '2018-05-29 07:22:14', '2018-05-29 07:22:14', '2019-05-29 10:22:14'),
('97c289f7f232e3076e284029f320884eb3e4f929b7f982bd7d5ea3d3a9752a9346bcadc534cd4b67', 88, 3, 'ahmed', '[]', 0, '2018-05-16 13:11:12', '2018-05-16 13:11:12', '2019-05-16 16:11:12'),
('98d09eb84ee7dd49c1fceeafcea4e03b50dd7810ca725fc14a21dbfe33eca1126314b713f99d84f5', 142, 3, 'Saned', '[]', 0, '2018-07-03 14:51:33', '2018-07-03 14:51:33', '2019-07-03 17:51:33'),
('a0e3e016c7dce8e7853f589c0795f88d74d7ce4dbcbad4e2ca9497917eb2f75263c6afada0d60822', 73, 3, 'ahmed', '[]', 0, '2018-04-14 06:55:46', '2018-04-14 06:55:46', '2019-04-14 09:55:46'),
('a1c50e9246027bbfc8c905670c8cff835f6c7f91287c1da4895960ba6ca45c958c08c53e03a9d9a3', 122, 3, 'Test', '[]', 0, '2018-06-10 07:56:02', '2018-06-10 07:56:02', '2019-06-10 10:56:02'),
('a3e6f18b44ca4c738715deb0df84c92338117df54f6630ce3c62915f1efc482ae7c1b928050d5b01', 62, 3, 'global', '[]', 0, '2018-04-11 10:35:44', '2018-04-11 10:35:44', '2019-04-11 13:35:44'),
('a4bd21c3c0ac3db4695c16577a90a452330b95ef6a332714e54a1c3ef956cffaa76b1cc27399b4ef', 125, 3, 'New33', '[]', 0, '2018-06-10 09:11:37', '2018-06-10 09:11:37', '2019-06-10 12:11:37'),
('a6b13bdea29cea9544816d0f0bf87e9d1ad64911069e86292e4100cc5cad03a07e55ac1ae6f34d4f', 37, 3, 'hamed', '[]', 0, '2018-03-28 07:02:11', '2018-03-28 07:02:11', '2019-03-28 09:02:11'),
('a80a25aebd5b966271e7fde89ab0b5532352bd9b5ffa1c862128c1e6dbea7262c238be8a69339d31', 80, 3, 'مركز حلاقة', '[]', 0, '2018-06-26 13:01:08', '2018-06-26 13:01:08', '2019-06-26 16:01:08'),
('ab763f29f09c7b448859a49fe5596ecb305a3b4eba231bf53fa8996de0782b1993fad6fe19b0872c', 126, 3, 'Test', '[]', 0, '2018-06-10 09:37:53', '2018-06-10 09:37:53', '2019-06-10 12:37:53'),
('abd9d3c4e740c4527436d4f3a0384823219043342542c0f7715bf1500211f9d5a1ea5d4d8bd064d3', 151, 3, 'ahmed', '[]', 0, '2018-09-02 09:19:58', '2018-09-02 09:19:58', '2019-09-02 12:19:58'),
('aec6122d45e7f1cc1610c07bfa45eec0043fb5865de421b021049c43910fbcfafc6f42c949df4bf6', 116, 3, 'test', '[]', 0, '2018-06-04 11:34:19', '2018-06-04 11:34:19', '2019-06-04 14:34:19'),
('aecf2a0ef63da47f3197b566140c65a90fc91e78e7686675f64df3d89b195bf20b0e29813ce0bfd3', 143, 3, 'Tahani', '[]', 0, '2018-07-04 00:22:54', '2018-07-04 00:22:54', '2019-07-04 03:22:54'),
('afe56ec141c31d3c801253beeeb17e492709c62d96028492ec97115ed6cef08b23474381f05052a7', 57, 3, 'global', '[]', 0, '2018-04-11 09:29:11', '2018-04-11 09:29:11', '2019-04-11 12:29:11'),
('b174a7eed91a729ad8e54ac650597328c022709d1e1b540318b1873800dc18229454ebae0b64fc5d', 108, 3, 'aaa', '[]', 0, '2018-05-31 08:11:59', '2018-05-31 08:11:59', '2019-05-31 11:11:59'),
('b7385cb5a8da635d2fa8036bf218fe95827af4e1d453a96e7bb9a8df7eabf35e6ec0ba61452944e3', 145, 3, 'Gogo', '[]', 0, '2018-07-09 08:21:46', '2018-07-09 08:21:46', '2019-07-09 11:21:46'),
('b7765c55ae312057a8b663eaf028cc118b51dbde85d980ec226272550ffc3ed105904c4ff0102e6e', 115, 3, 'طلتتتكم', '[]', 0, '2018-06-04 05:40:47', '2018-06-04 05:40:47', '2019-06-04 08:40:47'),
('b89f2ac7b2357831f0a2bc806928f228708cab0d4b2f919c9bedd9dacf8f34feab0f0567d8a5766e', 134, 3, 'Ghada', '[]', 0, '2018-06-11 12:41:24', '2018-06-11 12:41:24', '2019-06-11 15:41:24'),
('b9bce25573808604c3c097fbddcba8d14afc47bc8010627a0538dfa1c320a0be4d6388755495f552', 106, 3, 'طلتك', '[]', 0, '2018-06-06 11:34:52', '2018-06-06 11:34:52', '2019-06-06 14:34:52'),
('ba5811021a54e7b6edbe35bf6a121e1cac16e2ad10fa7840bd56b92cabc128392ac95dcc59e373f8', 114, 3, 'Tahani', '[]', 0, '2018-06-04 04:32:19', '2018-06-04 04:32:19', '2019-06-04 07:32:19'),
('be27f0e65942777246d45272e5864cc8ab616034b9bb5f189f088e1d45ecb8956c00ef46b7fc4b56', 69, 3, 'ahmed33', '[]', 0, '2018-04-12 06:53:12', '2018-04-12 06:53:12', '2019-04-12 09:53:12'),
('bf0ea57655ed54d85df40ad5af67f433877e9dea88a2e07eae6d7edd81eab3b4b0e207052cfba410', 94, 3, 'Test providers', '[]', 0, '2018-05-20 12:02:03', '2018-05-20 12:02:03', '2019-05-20 15:02:03'),
('bf28c843eec83158f019fc7cf515260e841b82875f14865b4605fd82c108d475f143d089e43303c0', 65, 3, 'ahmed', '[]', 0, '2018-04-11 11:18:04', '2018-04-11 11:18:04', '2019-04-11 14:18:04'),
('c0c8f4ee3079491041da5c8dde0e8184fd843ba7c33e1fb9b9947b1a6c57dd603408cb3b1672f53c', 90, 3, 'Test', '[]', 0, '2018-05-20 08:40:56', '2018-05-20 08:40:56', '2019-05-20 11:40:56'),
('c2e922c6751c0417d0a875431ef031e29275f69c751e23823f026a8f6dee0d3908dc000f2a573fe2', 75, 3, 'front', '[]', 0, '2018-04-14 08:20:18', '2018-04-14 08:20:18', '2019-04-14 11:20:18'),
('c45f5b031f7d8eccf5f54bc626df18ca4cb221490650e2097c958bd7b90c8d0050944f6af1cdc6f7', 100, 3, 'Test', '[]', 0, '2018-05-26 11:01:57', '2018-05-26 11:01:57', '2019-05-26 14:01:57'),
('c51ec77bfc7418bb834ef95f99f3ac1b8d588add00594a7c83ab5243ef829394c1e2d4c83a222b4c', 104, 3, 'Test', '[]', 0, '2018-05-29 07:30:19', '2018-05-29 07:30:19', '2019-05-29 10:30:19'),
('c56778b22d8a3bbcc463599d04359f6f0ebdd002bc132599128f11e40cb908268e8f9bc2e702093d', 76, 3, 'sss', '[]', 0, '2018-04-15 09:40:23', '2018-04-15 09:40:23', '2019-04-15 12:40:23'),
('c82a89bffab6c92a2504fc8d7e2a40fd07faf82d6cb12901180c294d83c890895362b709e0b8043b', 111, 3, 'talla name', '[]', 0, '2018-06-03 09:38:39', '2018-06-03 09:38:39', '2019-06-03 12:38:39'),
('c96fd3af8d76c1847599b5d2f13b29f521c888fdf690a646b6e8f615421f95f7330dd3a11c22089d', 119, 3, 'Manar', '[]', 0, '2018-06-06 12:35:32', '2018-06-06 12:35:32', '2019-06-06 15:35:32'),
('cb3da787d8614d4de4b7220680868e9956c69c4089f7e94881aba9ddec3e4dbe45ec802533122c30', 96, 3, 'Mohamed', '[]', 0, '2018-05-23 12:04:02', '2018-05-23 12:04:02', '2019-05-23 15:04:02'),
('d42c630ee55071077935d2e0b20277023ce79b331b69ba08ec4dd3cb9fa26cdfa76ee8369319afec', 87, 3, 'Tttrtttrrrtrr', '[]', 0, '2018-05-09 14:25:06', '2018-05-09 14:25:06', '2019-05-09 17:25:06'),
('d4d9c6cf33d29eac2699fd5b9fadfcca32d8cc3b243f3b7cdb9c1ced021223c5731afeafd71a4d10', 1, 3, 'test', '[]', 0, '2018-03-28 06:39:24', '2018-03-28 06:39:24', '2019-03-28 08:39:24'),
('d55998048bc6601a332c6d80d482f13322a56e19dcdfcc7b4edfa656f281fdd62349bc6fac450384', 135, 3, 'Ghada', '[]', 0, '2018-06-11 12:43:06', '2018-06-11 12:43:06', '2019-06-11 15:43:06'),
('d57437884d9cfec1865d788ab94911c2874ea61f673c43bc62828fec662fa5093e2d83bbb1379161', 152, 3, 'Hala', '[]', 0, '2018-09-03 08:43:35', '2018-09-03 08:43:35', '2019-09-03 11:43:35'),
('d5fae7ae59a8be2fb6d8e4cb4015bb290fc912e3bef8f45fde4b5c80116a6359f977e835bdfd8208', 59, 3, 'ahmed', '[]', 0, '2018-04-11 10:02:44', '2018-04-11 10:02:44', '2019-04-11 13:02:44'),
('d8207f60088ba628e45645289e5a2c627123e4cd51e379ee11509bd78d162b57f4e036a6258b431b', 58, 3, 'saned', '[]', 0, '2018-04-11 09:30:50', '2018-04-11 09:30:50', '2019-04-11 12:30:50'),
('dcf60e159b7f2dd7eb9810049bd0339d24d6ee27c767fa56e0cc886ae3f56924f1e078b5fe90189e', 121, 3, 'Areej', '[]', 0, '2018-06-10 02:03:34', '2018-06-10 02:03:34', '2019-06-10 05:03:34'),
('dd255f642c7be80bfc1bc59f508d97642b52b0b11480f4fdbcc06878193712361fe2b22128dbdd2c', 82, 3, 'Dawood', '[]', 0, '2018-05-01 10:15:35', '2018-05-01 10:15:35', '2019-05-01 13:15:35'),
('ddde0d17db38e55cace0625c739133eda34c2f2178185e870261247fabe6c1468d40df2246109738', 91, 3, 'Test', '[]', 0, '2018-05-20 09:17:36', '2018-05-20 09:17:36', '2019-05-20 12:17:36'),
('de2c2d01350c6873804dc2237772efea34c357db0c61d23ccac29574bf8c7822faba5a0f578120f7', 140, 3, 'Areej', '[]', 0, '2018-07-01 15:07:33', '2018-07-01 15:07:33', '2019-07-01 18:07:33'),
('def14bd5db3e80c9a399b78ad81d2e571ce7c065ad67504a8c91c8345854823b18b7d9e74052c6a4', 138, 3, 'Test', '[]', 0, '2018-06-27 09:24:11', '2018-06-27 09:24:11', '2019-06-27 12:24:11'),
('e12780a2656bf7e4edaaf78afda72d1d5d814f25dcc310343f99c444ec7438a9a7f6b69ae08c44b9', 55, 3, 'Ramii', '[]', 0, '2018-04-05 05:44:20', '2018-04-05 05:44:20', '2019-04-05 08:44:20'),
('e3c4523895b501e9c6368811c143586ea495dfa9685c2d30ea87711789231ea5aee53c19dfcc0a6f', 38, 3, 'ahmed', '[]', 0, '2018-04-02 08:21:53', '2018-04-02 08:21:53', '2019-04-02 11:21:53'),
('e3ce7aa15b0a75c281fa85844800dc81dc12c5234bb7db1bc7e1a42c549f7305047412dd539faba6', 93, 3, 'Test providers', '[]', 0, '2018-05-20 11:49:20', '2018-05-20 11:49:20', '2019-05-20 14:49:20'),
('e419bf949e00c2800fcdac83d7a64fd2016fa47f4e20c28088a534ad55bbdc9e3bd7860db6c013c4', 54, 3, 'Ramy', '[]', 0, '2018-04-05 05:42:00', '2018-04-05 05:42:00', '2019-04-05 08:42:00'),
('e481afea837a2daccc358eeea4ae2f38064715e1700dce73504fc77922e23311ce4a162e4576bd2f', 70, 3, 'talla site', '[]', 0, '2018-04-12 08:25:17', '2018-04-12 08:25:17', '2019-04-12 11:25:17'),
('e50a37577c8a9f04896ebe1a7b246b458f7ce697468cc653f72669e759b7f8257831c18caed218e4', 81, 3, 'note', '[]', 0, '2018-04-16 10:32:21', '2018-04-16 10:32:21', '2019-04-16 13:32:21'),
('e57b9a6c4fd185d77b935b15358524d6b34f3c4963378435f4ddafa0a95a65eb1be29fcd95933e71', 118, 3, 'ddd', '[]', 0, '2018-06-04 12:35:44', '2018-06-04 12:35:44', '2019-06-04 15:35:44'),
('e8cca2bf1bc3043021a1d190a62fa73f5413873b47ef666def701e5dbfb72e61838fbf6294acc1ae', 147, 3, 'Gghh', '[]', 0, '2018-08-06 12:03:05', '2018-08-06 12:03:05', '2019-08-06 15:03:05'),
('eb705e91d2f4142de70f2d5583a9c81b6c1bbf41251d09a2896a2e05794a500321e17a6f5ec49814', 106, 3, 'طلتك', '[]', 0, '2018-06-06 11:34:12', '2018-06-06 11:34:12', '2019-06-06 14:34:12'),
('ecd88001aba1145af603ba9b1ccc66abaf0e883fbfdd0b2ed99483c991776d281b2018cfb3ff6366', 111, 3, 'talla username', '[]', 0, '2018-06-03 11:21:21', '2018-06-03 11:21:21', '2019-06-03 14:21:21'),
('f19073369c34179e9ee1d094f503924a81059bbf3f3d553a2856cbe921c140fefa063fb9b9c53a4f', 36, 3, 'hamed', '[]', 0, '2018-03-28 07:01:02', '2018-03-28 07:01:02', '2019-03-28 09:01:02'),
('f4786d2152e5cc8d5458ccebf446fc28788ca4fe8007f29c8f8ed6312fdc40d7599ae45de44a375d', 124, 3, 'New2', '[]', 0, '2018-06-10 08:53:58', '2018-06-10 08:53:58', '2019-06-10 11:53:58'),
('f5c29b696d8eb886109409f0afaecfa62c94558ce1ba10c6b3498d984b5da1d4d3e5f5485e6bff3a', 99, 3, 'Test', '[]', 0, '2018-05-26 10:58:28', '2018-05-26 10:58:28', '2019-05-26 13:58:28'),
('f5df2bc8267823e3212dfcec9cfa4a35842f78e6a5569decd7d1fc4606f7abc24d27729509835743', 131, 3, 'Ttuuj', '[]', 0, '2018-06-11 08:21:51', '2018-06-11 08:21:51', '2019-06-11 11:21:51'),
('f61261746d6c745c007e382b50fc91ea0af36cae98617d79bb1bd17076ea7217a7f31ede72e14f9c', 86, 3, 'Ttrrr', '[]', 0, '2018-05-09 14:11:37', '2018-05-09 14:11:37', '2019-05-09 17:11:37'),
('f6dd0a0da59ebc55df065f84c7a267017ceb5dc0766c8eeddcf31a80a8a80cd20500e39825d51470', 80, 3, 'مركز حلاقة', '[]', 0, '2018-06-26 13:02:40', '2018-06-26 13:02:40', '2019-06-26 16:02:40'),
('f8c6c9d19bf1032b690f01cc59b711fb23c73b41d1974f1bf11ec9ce678f5dbb3c3df3a735467daa', 153, 3, 'Ahmed', '[]', 0, '2018-09-03 09:39:18', '2018-09-03 09:39:18', '2019-09-03 12:39:18'),
('f927c3d1527627813bf830ca3499fe2dfbffdf3972c2bd683b24203aff4a6ce73440663fb6dd2136', 61, 3, 'saned', '[]', 0, '2018-04-11 10:15:04', '2018-04-11 10:15:04', '2019-04-11 13:15:04'),
('fbd33987da53dba67e97e789cfcc4e5a004bc2355d04cbb2e6a0d60fee1660c752433a1a3db6df41', 78, 3, 'clza', '[]', 0, '2018-04-16 07:23:19', '2018-04-16 07:23:19', '2019-04-16 10:23:19'),
('ff33b48e35443c2ec325e6f4dba6479e96bac5fad057df0169191cd40e020c862adee3dcbbc07929', 4, 3, 'inas', '[]', 0, '2018-06-28 12:34:09', '2018-06-28 12:34:09', '2019-06-28 15:34:09');

-- --------------------------------------------------------

--
-- Table structure for table `oauth_auth_codes`
--

CREATE TABLE `oauth_auth_codes` (
  `id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` int(11) NOT NULL,
  `client_id` int(11) NOT NULL,
  `scopes` text COLLATE utf8mb4_unicode_ci,
  `revoked` tinyint(1) NOT NULL,
  `expires_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `oauth_clients`
--

CREATE TABLE `oauth_clients` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `secret` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `redirect` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `personal_access_client` tinyint(1) NOT NULL,
  `password_client` tinyint(1) NOT NULL,
  `revoked` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `oauth_clients`
--

INSERT INTO `oauth_clients` (`id`, `user_id`, `name`, `secret`, `redirect`, `personal_access_client`, `password_client`, `revoked`, `created_at`, `updated_at`) VALUES
(1, NULL, 'Laravel Personal Access Client', 'axxcWXlWJWioDgCvWVuAf2Crw0uGldP5gKV7ulco', 'http://localhost', 1, 0, 0, '2018-03-27 12:15:13', '2018-03-27 12:15:13'),
(2, NULL, 'Laravel Password Grant Client', '47iKwN6RMt9OH1MEFp4w0jndZq5vmon1VAlqlVrJ', 'http://localhost', 0, 1, 0, '2018-03-27 12:15:13', '2018-03-27 12:15:13'),
(3, NULL, 'Laravel Personal Access Client', 'Q0tamyjFvHwIxTVKla4ClQsrIAyndGjHeBCi9zb7', 'http://localhost', 1, 0, 0, '2018-03-28 05:27:33', '2018-03-28 05:27:33'),
(4, NULL, 'Laravel Password Grant Client', '2MoIiKSoQGqJhK62QaOkPP2YiyTLQXSEUsQQR9FY', 'http://localhost', 0, 1, 0, '2018-03-28 05:27:34', '2018-03-28 05:27:34');

-- --------------------------------------------------------

--
-- Table structure for table `oauth_personal_access_clients`
--

CREATE TABLE `oauth_personal_access_clients` (
  `id` int(10) UNSIGNED NOT NULL,
  `client_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `oauth_personal_access_clients`
--

INSERT INTO `oauth_personal_access_clients` (`id`, `client_id`, `created_at`, `updated_at`) VALUES
(1, 1, '2018-03-27 12:15:13', '2018-03-27 12:15:13'),
(2, 3, '2018-03-28 05:27:33', '2018-03-28 05:27:33');

-- --------------------------------------------------------

--
-- Table structure for table `oauth_refresh_tokens`
--

CREATE TABLE `oauth_refresh_tokens` (
  `id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `access_token_id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `revoked` tinyint(1) NOT NULL,
  `expires_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(10) UNSIGNED NOT NULL,
  `gender` enum('male','female') COLLATE utf8mb4_unicode_ci NOT NULL,
  `place` enum('home','center') COLLATE utf8mb4_unicode_ci NOT NULL,
  `order_date` date NOT NULL,
  `order_time` time NOT NULL,
  `notes` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `lat` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `lng` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `price` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `min_cost` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `max_cost` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `discount_accept` tinyint(1) NOT NULL,
  `discount` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `net_price` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `app_ratio` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT '0',
  `user_id` int(10) UNSIGNED NOT NULL,
  `service_id` int(10) UNSIGNED NOT NULL,
  `company_id` int(11) UNSIGNED NOT NULL,
  `provider_id` int(10) UNSIGNED NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `user_is_finished` tinyint(1) NOT NULL DEFAULT '0',
  `is_considered` tinyint(4) NOT NULL DEFAULT '0',
  `refuse_reasons` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `refuse_type` tinyint(4) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `cancel_reason` varchar(1000) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `service_type` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `gender`, `place`, `order_date`, `order_time`, `notes`, `lat`, `lng`, `address`, `price`, `min_cost`, `max_cost`, `discount_accept`, `discount`, `net_price`, `app_ratio`, `user_id`, `service_id`, `company_id`, `provider_id`, `status`, `user_is_finished`, `is_considered`, `refuse_reasons`, `refuse_type`, `created_at`, `updated_at`, `cancel_reason`, `service_type`) VALUES
(6, 'male', 'home', '2018-09-05', '10:00:00', '', '12.23558', '12.2546987', 'ryad - sa', NULL, NULL, NULL, 1, '', '0', '0', 156, 88, 83, 154, 0, 0, 0, '', 0, '2018-09-04 12:50:18', '2018-09-04 12:50:18', NULL, NULL),
(7, 'male', 'home', '2018-09-05', '10:00:00', '', '12.23558', '12.2546987', 'ryad - sa', NULL, NULL, NULL, 1, '', '0', '0', 156, 88, 83, 154, 0, 0, 0, '', 0, '2018-09-04 12:52:42', '2018-09-04 12:52:42', NULL, NULL),
(8, 'male', 'home', '2018-09-05', '10:00:00', '', '12.23558', '12.2546987', 'ryad - sa', NULL, NULL, NULL, 1, '', '0', '0', 156, 88, 83, 154, 0, 0, 0, '', 0, '2018-09-04 12:53:54', '2018-09-04 12:53:54', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `order_available_times`
--

CREATE TABLE `order_available_times` (
  `id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `day` varchar(100) NOT NULL,
  `time` time NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `order_services`
--

CREATE TABLE `order_services` (
  `id` int(11) NOT NULL,
  `service_id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `price` varchar(100) DEFAULT NULL,
  `min_cost` varchar(100) DEFAULT NULL,
  `max_cost` varchar(100) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `password_resets`
--

INSERT INTO `password_resets` (`email`, `token`, `created_at`) VALUES
('saned@saned.sa', '$2y$10$OmPv64VryVn3y92noWZw2.8j4ZqSVv9Ygc/UrziOxBuJZ6ShJPQ/G', '2018-05-23 07:48:10'),
('inas.abdelfatah7@gmail.com', '$2y$10$1EmGg5.ql8Q5of.QPUn6zOTHn5aQrWO0SH4UZCi7058jARubvc/YS', '2018-06-10 09:44:29');

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

CREATE TABLE `permissions` (
  `ability_id` int(10) UNSIGNED NOT NULL,
  `entity_id` int(10) UNSIGNED NOT NULL,
  `entity_type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `forbidden` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `permissions`
--

INSERT INTO `permissions` (`ability_id`, `entity_id`, `entity_type`, `forbidden`) VALUES
(1, 1, 'roles', 0),
(1, 5, 'roles', 0),
(6, 1, 'App\\User', 0),
(9, 7, 'roles', 0),
(10, 7, 'roles', 0),
(1, 8, 'roles', 0),
(6, 8, 'roles', 0),
(6, 3, 'roles', 0),
(7, 3, 'roles', 0),
(8, 3, 'roles', 0),
(9, 3, 'roles', 0),
(10, 3, 'roles', 0),
(19, 3, 'roles', 0),
(20, 3, 'roles', 0),
(6, 9, 'roles', 0),
(7, 9, 'roles', 0),
(8, 9, 'roles', 0),
(9, 9, 'roles', 0),
(10, 9, 'roles', 0),
(19, 9, 'roles', 0),
(20, 9, 'roles', 0),
(9, 10, 'roles', 0),
(10, 10, 'roles', 0),
(20, 10, 'roles', 0),
(6, 12, 'roles', 0),
(7, 12, 'roles', 0),
(8, 12, 'roles', 0),
(9, 12, 'roles', 0),
(10, 12, 'roles', 0),
(19, 12, 'roles', 0),
(20, 12, 'roles', 0),
(6, 1, 'roles', 0),
(7, 1, 'roles', 0),
(8, 1, 'roles', 0),
(9, 1, 'roles', 0),
(10, 1, 'roles', 0),
(19, 1, 'roles', 0),
(20, 1, 'roles', 0),
(7, 11, 'roles', 0),
(6, 11, 'roles', 0);

-- --------------------------------------------------------

--
-- Table structure for table `rates`
--

CREATE TABLE `rates` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `company_id` int(10) UNSIGNED NOT NULL,
  `order_id` int(11) NOT NULL,
  `rate` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `rate_from` enum('user','provider') COLLATE utf8mb4_unicode_ci NOT NULL,
  `price` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` tinyint(4) NOT NULL DEFAULT '0',
  `comment` varchar(1000) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `rates`
--

INSERT INTO `rates` (`id`, `user_id`, `company_id`, `order_id`, `rate`, `rate_from`, `price`, `type`, `comment`, `created_at`, `updated_at`) VALUES
(8, 154, 83, 0, '3', '', '', 0, NULL, '2018-09-03 21:00:08', '2018-09-03 21:00:08'),
(9, 152, 83, 0, '4', '', '', 0, NULL, '2018-09-03 21:00:47', '2018-09-03 21:00:47');

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `title` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `level` int(10) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `title`, `level`, `created_at`, `updated_at`) VALUES
(1, 'owner', 'المدير التنفيذى', NULL, '2018-05-23 08:54:43', '2018-05-23 09:01:09'),
(3, 'مدن كنترول', 'مدن كنترول', NULL, '2018-03-22 06:36:28', '2018-03-22 06:36:28'),
(11, 'ادارة المستخدمين', NULL, NULL, '2018-08-30 10:30:21', '2018-08-30 10:30:21');

-- --------------------------------------------------------

--
-- Table structure for table `services`
--

CREATE TABLE `services` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `gender_type` enum('male','female','both') COLLATE utf8mb4_unicode_ci NOT NULL,
  `provider_type` enum('male','female') COLLATE utf8mb4_unicode_ci NOT NULL,
  `service_place` enum('center','home','both') COLLATE utf8mb4_unicode_ci NOT NULL,
  `serviceType_id` int(10) UNSIGNED NOT NULL,
  `provider_id` int(10) UNSIGNED NOT NULL,
  `company_id` int(10) UNSIGNED NOT NULL,
  `district_id` int(10) UNSIGNED NOT NULL,
  `price` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `min_cost` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `max_cost` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `photo` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `seen_count` bigint(20) UNSIGNED NOT NULL,
  `status` tinyint(4) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `services`
--

INSERT INTO `services` (`id`, `name`, `description`, `gender_type`, `provider_type`, `service_place`, `serviceType_id`, `provider_id`, `company_id`, `district_id`, `price`, `min_cost`, `max_cost`, `photo`, `seen_count`, `status`, `created_at`, `updated_at`) VALUES
(88, '', '', 'both', 'male', 'both', 17, 154, 83, 0, NULL, '100', '500', '1535971051.RyTYFabU7n2rOEiNMHxNimage.jpg', 0, 0, '2018-09-03 10:37:25', '2018-09-03 10:37:31');

-- --------------------------------------------------------

--
-- Table structure for table `service_translations`
--

CREATE TABLE `service_translations` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `service_id` int(10) UNSIGNED NOT NULL,
  `locale` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `service_translations`
--

INSERT INTO `service_translations` (`id`, `name`, `description`, `service_id`, `locale`, `created_at`, `updated_at`) VALUES
(101, 'Hair care', 'Beauty', 88, 'ar', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `service_types`
--

CREATE TABLE `service_types` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `gender_type` enum('male','female','both') COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_by` int(10) UNSIGNED NOT NULL,
  `status` tinyint(4) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `service_type_translations`
--

CREATE TABLE `service_type_translations` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `service_type_id` int(10) UNSIGNED NOT NULL,
  `locale` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `id` int(11) NOT NULL,
  `key` varchar(255) NOT NULL,
  `body` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `key`, `body`, `created_at`, `updated_at`) VALUES
(29, 'terms_ar', '<p>بنود الاستخدام&nbsp;</p>', '2018-08-30 13:31:52', '2018-08-30 13:31:52'),
(30, 'terms_en', '<p>terms and conditions&nbsp;</p>', '2018-08-30 13:31:52', '2018-08-30 13:31:52'),
(31, 'about_app_desc_ar', '<p>اختبار عن التطبيق&nbsp;</p>', '2018-09-04 09:39:17', '2018-09-04 09:39:17'),
(32, 'about_app_desc_en', '<p>about us&nbsp;</p>', '2018-08-30 13:33:19', '2018-08-30 13:33:19'),
(33, 'facebook', 'facebook.com', '2018-08-30 13:44:44', '2018-08-30 13:44:44'),
(34, 'twitter', 'twitter.com', '2018-08-30 13:44:44', '2018-08-30 13:44:44'),
(35, 'instagram', 'instgram.com', '2018-08-30 13:44:44', '2018-08-30 13:44:44'),
(36, 'googlePlus', 'googleplus.com', '2018-08-30 13:44:44', '2018-08-30 13:44:44');

-- --------------------------------------------------------

--
-- Table structure for table `supports`
--

CREATE TABLE `supports` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `email` varchar(100) NOT NULL,
  `phone` varchar(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `parent_id` int(11) NOT NULL,
  `type` tinyint(4) NOT NULL,
  `reply_type` tinyint(4) NOT NULL,
  `message` longtext NOT NULL,
  `is_read` tinyint(4) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `supports`
--

INSERT INTO `supports` (`id`, `user_id`, `email`, `phone`, `name`, `parent_id`, `type`, `reply_type`, `message`, `is_read`, `created_at`, `updated_at`) VALUES
(48, 0, '', '0512345678', 'Hello', 0, 1, 0, 'Hello', 1, '2018-09-03 22:08:58', '2018-09-03 22:08:58'),
(49, 0, '', '0512345678', 'محمد داوود', 0, 1, 0, 'رسالة', 0, '2018-09-04 09:40:56', '2018-09-04 09:40:56');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `username` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `gender` enum('male','female') COLLATE utf8mb4_unicode_ci NOT NULL,
  `code` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `action_code` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `lat` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `lng` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `city` int(11) NOT NULL,
  `is_invited` tinyint(1) NOT NULL,
  `is_active` tinyint(1) NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `api_token` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `is_suspend` tinyint(4) NOT NULL,
  `is_online` tinyint(4) NOT NULL,
  `is_user` tinyint(4) NOT NULL,
  `is_provider` tinyint(4) NOT NULL,
  `reject_reason` text COLLATE utf8mb4_unicode_ci,
  `is_approved` tinyint(4) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `username`, `phone`, `email`, `password`, `image`, `gender`, `code`, `action_code`, `address`, `lat`, `lng`, `city`, `is_invited`, `is_active`, `remember_token`, `api_token`, `created_at`, `updated_at`, `is_suspend`, `is_online`, `is_user`, `is_provider`, `reject_reason`, `is_approved`) VALUES
(1, 'سند أعمالك', 'سند', '0502769823', 'saned@saned.sa', '$2y$10$o0gsHIi/NmllQjabz99VPuegeoe2woA46vZTRyeKL1mUCFccNeAfW', '1528109577.U5tNaNOoECxcsoH8e77Ytest pic.jpg', 'female', '', '1234', 'lll', '', '', 0, 0, 1, 'HS2uhh1MnSiON5WqvKdVFnc3E8oxOIn6kDVnDf4JQDyxfhrbinoaYK4mD4BZ', '', '2018-03-06 22:00:00', '2018-06-12 08:48:15', 0, 0, 0, 0, '', 0),
(149, 'mohamed', 'mo', '0510000007', 'm@m.com', '$2y$10$gsrGTXO.1yrrZjVpumyAs.9fJ2j6TibKYpoTlDcR5o82aN8D.zEUW', '1535624971.6j9uhqlfCPHwoPacDUDKtest photo.jpg', 'male', '17715954', '1771', 'test', '', '', 0, 0, 1, 'eqQvQhrSutQlke2t7f8y2w5M8T9WAZm6QepaDLyy', 'zL3qJEwy7xM6ik9pRoj45LOblnbfr5AcoAt2cBrGU4BD5B9WMQVofXvbIxnU', '2018-08-30 10:29:31', '2018-08-30 10:29:31', 0, 0, 0, 0, NULL, 0),
(150, 'ahmed', 'ahmed', '0510000006', 'n@n.com', '$2y$10$faXTHCPLB7iG/h6KsXejnOCYD/v4dkbynwXWObz1PzgAQNJWMzIx2', '1535625274.Z2Z2NkxPWQIaeRslvxZTtest photo.jpg', 'male', '79662844', '7966', '', '', '', 0, 0, 0, 'BvAsqmtg9H8e3ps45k9jba0ntxPkLKU5a6Dqt1YoFlKLsOmxqFtfzc6aflqH', 'vExboWIjh0Xp512DlzusRoaJINDuYxnCVW0EpiBeMPq9PGFEpd4WmrVfnwup', '2018-08-30 10:34:34', '2018-08-30 11:27:13', 0, 0, 0, 0, NULL, 0),
(152, 'Hala', '', '0512345678', 'mm@m.com', '$2y$10$U.gdsFV6xd0XR0vOUrVKPe8QtKokumaRL5OfVr9Z78pyQMzhqPdNK', '1535965181.hMiDwAmWk5MjnsFMxFCyimage.jpg', 'male', '1952', '7508', '', '', '', 17, 1, 1, NULL, 'WCgeX2s2zOvLHP4JD2Ky2zkYUqEpf2kliHEhQIOwbxK4oLj6JqXUPbMWoYpD', '2018-09-03 08:43:35', '2018-09-03 09:08:20', 0, 0, 1, 0, NULL, 0),
(153, 'Ahmed', '', '0523456789', '', '$2y$10$FYcZpPA7Lq/C.m5TOiPxM.Ni3KEskrqC3BsCw5QjZNy9UiPYSDRIq', '', 'male', '7085', '2861', '', '', '', 0, 0, 1, NULL, 'O2Pus8lUsIpAqvlmn7slVQio3Fe6P0jnlZ0vIeYxEKMZgmDWFoBzMiCLenlR', '2018-09-03 09:39:18', '2018-09-03 09:39:41', 0, 0, 1, 0, NULL, 0),
(154, 'Hair style centre', '', '0511114444', 's@s.com', '$2y$10$3OeI94cR/o0J4IyizcILG.lrcmM27QbJVzqZlDpKjbvjyQxYvlXQ.', '1535971220.f7lxVd7GfH7mplTThLO1image.jpg', 'male', '9137', '3674', '', '', '', 17, 0, 1, NULL, 'JVBZVpDgQ6dsCiHh0ayIdsUxemE3mW7NVLPXtjPeLXBkjoF8XNaWELtrlgSR', '2018-09-03 09:47:24', '2018-09-03 11:04:01', 0, 0, 1, 1, '', 1),
(155, 'Nour', '', '0511112222', '', '$2y$10$OyFoaJK2w0O7vr2HyNwncOE8Mb4PJyq/zkWCIBrAdWnWQwbmI3jfi', '', 'male', '6666', '3491', '', '', '', 0, 0, 1, NULL, 'S7N9Ng7ChuurD09QAbrRMwjUxEgYR50N4d3oObx1FpzswgzK0LfwImQf75za', '2018-09-03 09:52:03', '2018-09-03 09:52:40', 0, 0, 1, 0, NULL, 0),
(156, 'Hggg', '', '0510000005', '', '$2y$10$yqavrfERI.ldKy2pI.u.nu9G1QaI1cYiYenS/Wk0a5io7b.qXYGee', '', '', '5007', '4161', '', '', '', 0, 0, 0, NULL, 'UhwR17VL60I2Vm0h2mVvIdt05d1kPLzbGjoiSVCdnYOtXzwSbXfYruGxblbG', '2018-09-04 12:33:33', '2018-09-04 12:33:33', 0, 0, 1, 0, NULL, 0);

-- --------------------------------------------------------

--
-- Table structure for table `user_discounts`
--

CREATE TABLE `user_discounts` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `created_by` int(11) NOT NULL,
  `registered_users_no` int(11) NOT NULL,
  `discount` varchar(100) NOT NULL,
  `max_orders` int(11) NOT NULL,
  `from_date` date NOT NULL,
  `to_date` date NOT NULL,
  `is_reset` tinyint(4) NOT NULL DEFAULT '0',
  `is_used` int(4) NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `user_invitations`
--

CREATE TABLE `user_invitations` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `invited_by` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `abilities`
--
ALTER TABLE `abilities`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `abilities_unique_index` (`name`,`entity_id`,`entity_type`,`only_owned`);

--
-- Indexes for table `abuses`
--
ALTER TABLE `abuses`
  ADD PRIMARY KEY (`id`),
  ADD KEY `reports_user_id_foreign` (`user_id`);

--
-- Indexes for table `assigned_roles`
--
ALTER TABLE `assigned_roles`
  ADD KEY `assigned_roles_entity_id_entity_type_index` (`entity_id`,`entity_type`),
  ADD KEY `assigned_roles_role_id_index` (`role_id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `centers`
--
ALTER TABLE `centers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `centers_phone_unique` (`phone`),
  ADD KEY `centers_user_id_foreign` (`user_id`),
  ADD KEY `centers_city_id_foreign` (`city_id`);

--
-- Indexes for table `cities`
--
ALTER TABLE `cities`
  ADD PRIMARY KEY (`id`),
  ADD KEY `cities_created_by_foreign` (`created_by`);

--
-- Indexes for table `city_translations`
--
ALTER TABLE `city_translations`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `city_translations_city_id_locale_unique` (`city_id`,`locale`),
  ADD KEY `city_translations_locale_index` (`locale`);

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `comments_commentable_id_index` (`commentable_id`),
  ADD KEY `comments_commentable_type_index` (`commentable_type`);

--
-- Indexes for table `companies`
--
ALTER TABLE `companies`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `company_translations`
--
ALTER TABLE `company_translations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `company_work_days`
--
ALTER TABLE `company_work_days`
  ADD PRIMARY KEY (`id`),
  ADD KEY `company_work_days_company_id_foreign` (`company_id`);

--
-- Indexes for table `contact_us`
--
ALTER TABLE `contact_us`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `devices`
--
ALTER TABLE `devices`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `districts`
--
ALTER TABLE `districts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `districts_created_by_foreign` (`created_by`),
  ADD KEY `districts_city_id_foreign` (`city_id`);

--
-- Indexes for table `district_translations`
--
ALTER TABLE `district_translations`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `district_translations_district_id_locale_unique` (`district_id`,`locale`),
  ADD KEY `district_translations_locale_index` (`locale`);

--
-- Indexes for table `favourites`
--
ALTER TABLE `favourites`
  ADD PRIMARY KEY (`id`),
  ADD KEY `favourites_user_id_foreign` (`user_id`),
  ADD KEY `favourites_company_id_foreign` (`company_id`) USING BTREE;

--
-- Indexes for table `financial_accounts`
--
ALTER TABLE `financial_accounts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `images`
--
ALTER TABLE `images`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `management_levels`
--
ALTER TABLE `management_levels`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `oauth_access_tokens`
--
ALTER TABLE `oauth_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD KEY `oauth_access_tokens_user_id_index` (`user_id`);

--
-- Indexes for table `oauth_auth_codes`
--
ALTER TABLE `oauth_auth_codes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `oauth_clients`
--
ALTER TABLE `oauth_clients`
  ADD PRIMARY KEY (`id`),
  ADD KEY `oauth_clients_user_id_index` (`user_id`);

--
-- Indexes for table `oauth_personal_access_clients`
--
ALTER TABLE `oauth_personal_access_clients`
  ADD PRIMARY KEY (`id`),
  ADD KEY `oauth_personal_access_clients_client_id_index` (`client_id`);

--
-- Indexes for table `oauth_refresh_tokens`
--
ALTER TABLE `oauth_refresh_tokens`
  ADD PRIMARY KEY (`id`),
  ADD KEY `oauth_refresh_tokens_access_token_id_index` (`access_token_id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `orders_user_id_foreign` (`user_id`),
  ADD KEY `company_id` (`company_id`),
  ADD KEY `provider_id` (`provider_id`);

--
-- Indexes for table `order_available_times`
--
ALTER TABLE `order_available_times`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `order_services`
--
ALTER TABLE `order_services`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `permissions`
--
ALTER TABLE `permissions`
  ADD KEY `permissions_entity_id_entity_type_index` (`entity_id`,`entity_type`),
  ADD KEY `permissions_ability_id_index` (`ability_id`);

--
-- Indexes for table `rates`
--
ALTER TABLE `rates`
  ADD PRIMARY KEY (`id`),
  ADD KEY `rates_user_id_foreign` (`user_id`),
  ADD KEY `rates_company_id_foreign` (`company_id`) USING BTREE;

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `roles_name_unique` (`name`);

--
-- Indexes for table `services`
--
ALTER TABLE `services`
  ADD PRIMARY KEY (`id`),
  ADD KEY `services_provider_id_foreign` (`provider_id`),
  ADD KEY `services_company_id_foreign` (`company_id`) USING BTREE;

--
-- Indexes for table `service_translations`
--
ALTER TABLE `service_translations`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `service_translations_service_id_locale_unique` (`service_id`,`locale`),
  ADD KEY `service_translations_locale_index` (`locale`);

--
-- Indexes for table `service_types`
--
ALTER TABLE `service_types`
  ADD PRIMARY KEY (`id`),
  ADD KEY `service_types_created_by_foreign` (`created_by`);

--
-- Indexes for table `service_type_translations`
--
ALTER TABLE `service_type_translations`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `service_type_translations_service_type_id_locale_unique` (`service_type_id`,`locale`),
  ADD KEY `service_type_translations_locale_index` (`locale`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `supports`
--
ALTER TABLE `supports`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_phone_unique` (`phone`);

--
-- Indexes for table `user_discounts`
--
ALTER TABLE `user_discounts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_invitations`
--
ALTER TABLE `user_invitations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_invitations_user_id_foreign` (`user_id`),
  ADD KEY `user_invitations_invited_by_foreign` (`invited_by`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `abilities`
--
ALTER TABLE `abilities`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `abuses`
--
ALTER TABLE `abuses`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `centers`
--
ALTER TABLE `centers`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cities`
--
ALTER TABLE `cities`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `city_translations`
--
ALTER TABLE `city_translations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=183;

--
-- AUTO_INCREMENT for table `companies`
--
ALTER TABLE `companies`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=84;

--
-- AUTO_INCREMENT for table `company_translations`
--
ALTER TABLE `company_translations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=94;

--
-- AUTO_INCREMENT for table `company_work_days`
--
ALTER TABLE `company_work_days`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=315;

--
-- AUTO_INCREMENT for table `contact_us`
--
ALTER TABLE `contact_us`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `devices`
--
ALTER TABLE `devices`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=390;

--
-- AUTO_INCREMENT for table `districts`
--
ALTER TABLE `districts`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `district_translations`
--
ALTER TABLE `district_translations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `favourites`
--
ALTER TABLE `favourites`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT for table `financial_accounts`
--
ALTER TABLE `financial_accounts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `images`
--
ALTER TABLE `images`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `management_levels`
--
ALTER TABLE `management_levels`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=105;

--
-- AUTO_INCREMENT for table `oauth_clients`
--
ALTER TABLE `oauth_clients`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `oauth_personal_access_clients`
--
ALTER TABLE `oauth_personal_access_clients`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `order_available_times`
--
ALTER TABLE `order_available_times`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `order_services`
--
ALTER TABLE `order_services`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `rates`
--
ALTER TABLE `rates`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `services`
--
ALTER TABLE `services`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=89;

--
-- AUTO_INCREMENT for table `service_translations`
--
ALTER TABLE `service_translations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=102;

--
-- AUTO_INCREMENT for table `service_types`
--
ALTER TABLE `service_types`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `service_type_translations`
--
ALTER TABLE `service_type_translations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT for table `supports`
--
ALTER TABLE `supports`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=157;

--
-- AUTO_INCREMENT for table `user_discounts`
--
ALTER TABLE `user_discounts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=157;

--
-- AUTO_INCREMENT for table `user_invitations`
--
ALTER TABLE `user_invitations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `abuses`
--
ALTER TABLE `abuses`
  ADD CONSTRAINT `reports_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `assigned_roles`
--
ALTER TABLE `assigned_roles`
  ADD CONSTRAINT `assigned_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `centers`
--
ALTER TABLE `centers`
  ADD CONSTRAINT `centers_city_id_foreign` FOREIGN KEY (`city_id`) REFERENCES `cities` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `centers_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `cities`
--
ALTER TABLE `cities`
  ADD CONSTRAINT `cities_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `company_work_days`
--
ALTER TABLE `company_work_days`
  ADD CONSTRAINT `company_work_days_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `districts`
--
ALTER TABLE `districts`
  ADD CONSTRAINT `districts_city_id_foreign` FOREIGN KEY (`city_id`) REFERENCES `cities` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `districts_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `favourites`
--
ALTER TABLE `favourites`
  ADD CONSTRAINT `favourites_center_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `favourites_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `orders_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `permissions`
--
ALTER TABLE `permissions`
  ADD CONSTRAINT `permissions_ability_id_foreign` FOREIGN KEY (`ability_id`) REFERENCES `abilities` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `rates`
--
ALTER TABLE `rates`
  ADD CONSTRAINT `rates_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `rates_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `services`
--
ALTER TABLE `services`
  ADD CONSTRAINT `services_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `services_provider_id_foreign` FOREIGN KEY (`provider_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `service_types`
--
ALTER TABLE `service_types`
  ADD CONSTRAINT `service_types_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `user_invitations`
--
ALTER TABLE `user_invitations`
  ADD CONSTRAINT `user_invitations_invited_by_foreign` FOREIGN KEY (`invited_by`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `user_invitations_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
