-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Jun 13, 2025 at 06:46 AM
-- Server version: 8.2.0
-- PHP Version: 8.2.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sembark`
--

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

DROP TABLE IF EXISTS `cache`;
CREATE TABLE IF NOT EXISTS `cache` (
  `key` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

DROP TABLE IF EXISTS `cache_locks`;
CREATE TABLE IF NOT EXISTS `cache_locks` (
  `key` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `companies`
--

DROP TABLE IF EXISTS `companies`;
CREATE TABLE IF NOT EXISTS `companies` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `companies`
--

INSERT INTO `companies` (`id`, `name`, `created_at`, `updated_at`) VALUES
(5, 'Acme Pvt Ltd', '2025-06-11 10:49:41', '2025-06-11 10:49:41'),
(6, 'EaseMyTrip', '2025-06-12 04:40:27', '2025-06-12 04:40:27'),
(7, 'Traveleva', '2025-06-12 04:41:59', '2025-06-12 04:41:59'),
(8, 'Nomadic Nest', '2025-06-12 04:42:39', '2025-06-12 04:42:39'),
(9, 'Voyasia', '2025-06-12 04:43:48', '2025-06-12 04:43:48'),
(10, 'Globetrail', '2025-06-12 04:44:07', '2025-06-12 04:44:07'),
(11, 'WanderWhiz', '2025-06-12 04:56:50', '2025-06-12 04:56:50'),
(12, 'SkyQuest', '2025-06-12 04:57:22', '2025-06-12 04:57:22'),
(13, 'Mystic Miles', '2025-06-12 04:58:05', '2025-06-12 04:58:05'),
(14, '- PathFinders', '2025-06-12 04:58:26', '2025-06-12 04:58:26'),
(15, 'HorizonHopper', '2025-06-12 04:58:52', '2025-06-12 04:58:52');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;
CREATE TABLE IF NOT EXISTS `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `uuid` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

DROP TABLE IF EXISTS `jobs`;
CREATE TABLE IF NOT EXISTS `jobs` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `queue` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint UNSIGNED NOT NULL,
  `reserved_at` int UNSIGNED DEFAULT NULL,
  `available_at` int UNSIGNED NOT NULL,
  `created_at` int UNSIGNED NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_index` (`queue`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

DROP TABLE IF EXISTS `job_batches`;
CREATE TABLE IF NOT EXISTS `job_batches` (
  `id` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext COLLATE utf8mb4_unicode_ci,
  `cancelled_at` int DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
CREATE TABLE IF NOT EXISTS `migrations` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `migration` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2025_06_11_141535_add_role_to_users_table', 1),
(5, '2025_06_11_141842_create_companies_table', 1),
(6, '2025_06_11_142857_add_company_id_to_users_table', 1),
(7, '2025_06_11_152756_create_short_urls_table', 2),
(8, '2025_06_12_043710_add_hits_to_short_urls_table', 3);

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

DROP TABLE IF EXISTS `password_reset_tokens`;
CREATE TABLE IF NOT EXISTS `password_reset_tokens` (
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

DROP TABLE IF EXISTS `sessions`;
CREATE TABLE IF NOT EXISTS `sessions` (
  `id` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('HQRAtlnTiwAiglBYn9SZKF4Cmofmk4nCQYGUdPGw', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/137.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiNmhGazV3UXpkUkpFYnpReW8wQUNla1V3U1BIQ1JkZ1dRdzRQMHQ5NyI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mzk6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9zdXBlcmFkbWluL2ludml0ZSI7fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjE7fQ==', 1749795117),
('uSun8fpDQI1x6mT07y7NidslLlAp9s0AElULLISH', 11, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:139.0) Gecko/20100101 Firefox/139.0', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiRWFVN3dlc1R4dDZEUWpuRXMzQ3NQZ0VDVFE5eWVZekpoNEZKMnFzTSI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mzc6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9hZG1pbi9kYXNoYm9hcmQiO31zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aToxMTt9', 1749795037),
('90S2hQin7Au55EHrX2B81BXGJ4tflvQjgdglzxjq', 12, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:139.0) Gecko/20100101 Firefox/139.0', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiUnhlTmxJRG9WZTY0Qm1TbGFWMDN2dms0ajRzd1hKUjZnSlVIbHh6NyI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjY6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC91cmxzIjt9czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6MTI7fQ==', 1749795090);

-- --------------------------------------------------------

--
-- Table structure for table `short_urls`
--

DROP TABLE IF EXISTS `short_urls`;
CREATE TABLE IF NOT EXISTS `short_urls` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` bigint UNSIGNED NOT NULL,
  `original_url` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `short_code` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `hits` bigint UNSIGNED NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `short_urls_short_code_unique` (`short_code`),
  KEY `short_urls_user_id_foreign` (`user_id`)
) ENGINE=MyISAM AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `short_urls`
--

INSERT INTO `short_urls` (`id`, `user_id`, `original_url`, `short_code`, `created_at`, `updated_at`, `hits`) VALUES
(1, 12, 'https://laravel.com', 'pEMnun', '2025-06-11 11:14:24', '2025-06-12 08:05:52', 1),
(2, 11, 'https://sembark.com/travel-software/features/best-itinerary-builder', '19y5Bf', '2025-06-12 06:58:12', '2025-06-12 06:58:12', 0),
(3, 12, 'https://example.com/dummy1', 'C1udYV', '2025-06-12 06:59:30', '2025-06-12 08:05:52', 1),
(4, 12, 'https://example.com/dummy2', '2mnhlN', '2025-06-12 06:59:38', '2025-06-12 08:05:51', 1),
(5, 12, 'https://example.com/dummy3', 'f42BBx', '2025-06-12 06:59:44', '2025-06-12 08:05:51', 1),
(6, 12, 'https://example.com/dummy4', 'HJROkM', '2025-06-12 06:59:52', '2025-06-12 08:05:50', 1),
(7, 12, 'https://example.com/dummy5', 'JFpYgg', '2025-06-12 06:59:57', '2025-06-12 08:06:00', 9),
(8, 11, 'https://example.com/dummy6', 'Yuojx6', '2025-06-12 07:05:05', '2025-06-12 07:05:05', 0),
(9, 11, 'https://example.com/dummy7', 'anp8mO', '2025-06-12 07:05:12', '2025-06-12 07:05:12', 0),
(10, 11, 'https://example.com/dummy8', 'mFul36', '2025-06-12 07:05:18', '2025-06-12 07:05:18', 0),
(11, 11, 'https://example.com/dummy9', 'sFHy0Q', '2025-06-12 07:05:24', '2025-06-12 07:05:24', 0),
(12, 11, 'https://example.com/dummy10', 'C0lGDS', '2025-06-12 07:05:30', '2025-06-12 07:05:30', 0);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `role` enum('superadmin','admin','member') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'member',
  `company_id` bigint UNSIGNED DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`),
  KEY `users_company_id_foreign` (`company_id`)
) ENGINE=MyISAM AUTO_INCREMENT=33 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`, `role`, `company_id`) VALUES
(1, 'Super Admin', 'superadmin@example.com', NULL, '$2y$12$43U1KlMaswJW8jA3.zANje6TaSFG/aHIYdxiqP7XkRDEQiuXQfaC2', 'aXOoudxeX2xzNt08l67SibtZdT0lHZ6fAf8ARSvcHunwSRidcVQBIvo846yc', '2025-06-11 09:33:15', '2025-06-11 09:33:15', 'superadmin', NULL),
(15, 'admin3', 'admin3@example.com', NULL, '$2y$12$HiZXWRVivAparpoMGCQSsuc8.txfM.zMXP5ex/zKiOymZynkygpYW', NULL, '2025-06-12 04:42:40', '2025-06-12 04:42:40', 'admin', 8),
(11, 'John Doe', 'admin@gmail.com', NULL, '$2y$12$EB8tP/C2MdUQ1gDIttAcsOOQdEPC1rPXICeYbdkYaaNfAJHlr1NDK', 'JILOn1ekF8156pgtOH7IX5mWHAMwTtqH22NOPasHbASAn0in9qOXGPS9MjSD', '2025-06-11 10:49:42', '2025-06-11 10:49:42', 'admin', 5),
(12, 'member1', 'deepti@gmail.com', NULL, '$2y$12$bgoRW6iFtfQGFQrG0g2Mnu.8j4H7Y8nIswI1pEW29ITKsZnA6YJIm', 'gn9TX8vVKH3Y3HDEzoYtmhrQRAniseiOhWTe1DuPW50Nx0FCywFAPEt1ojiX', '2025-06-11 10:53:34', '2025-06-11 10:53:34', 'member', 5),
(13, 'Admin', 'admin1@example.com', NULL, '$2y$12$EfAuPOypq/0f7qgaEZKKgOktKjAPClFh4Wtbt5sscu/bqIJWBmOMa', NULL, '2025-06-12 04:40:28', '2025-06-12 04:40:28', 'admin', 6),
(14, 'admin2', 'admin2@example.com', NULL, '$2y$12$8CnBpU1ixRpSho1Y6WtPt.7223GxFEavVsJKOcx461URuWfVlUXDy', NULL, '2025-06-12 04:41:59', '2025-06-12 04:41:59', 'admin', 7),
(16, 'admin4', 'admin4@example.com', NULL, '$2y$12$aqurMAIMl5I6CkZKmHJOb.cXB0ACzg9PImw5i5d53WK47PyHx1bEG', NULL, '2025-06-12 04:43:48', '2025-06-12 04:43:48', 'admin', 9),
(17, 'admin5', 'admin5@example.com', NULL, '$2y$12$tD2e0JvJ5/RN4WB/xEobQ.2IxGTLl080/TgRbL3P4GFKWASePpymq', NULL, '2025-06-12 04:44:07', '2025-06-12 04:44:07', 'admin', 10),
(18, 'admin6', 'admin6@example.com', NULL, '$2y$12$rHYHq9I4V.zTEdqt.pqJWuJ82Cobas5wcwgX2S5WqVkKIxGBF6Cim', NULL, '2025-06-12 04:56:50', '2025-06-12 04:56:50', 'admin', 11),
(19, 'admin7', 'admin7@example.com', NULL, '$2y$12$9fh3JPk05CNNOw2gXueVC.X/m1Z3rX7OTZU2ZWViK5E0alTVWSuMm', NULL, '2025-06-12 04:57:22', '2025-06-12 04:57:22', 'admin', 12),
(20, 'admin8', 'admin8@example.com', NULL, '$2y$12$jADTTRPMpUQaymkm.vcAjuC3RrgP0sG5gYdUOBqmXv7KOiSVdf2y.', NULL, '2025-06-12 04:58:05', '2025-06-12 04:58:05', 'admin', 13),
(21, 'admin9', 'admin9@example.com', NULL, '$2y$12$os0uail1AP2K6sIlVxlDwe87KNmZ75aVWBc64K9ZFacbXvOd/4B/C', NULL, '2025-06-12 04:58:26', '2025-06-12 04:58:26', 'admin', 14),
(22, 'admin10', 'admin10@example.com', NULL, '$2y$12$KWJ0Bz6dLKm3OIKSG.h3c.eujNsoPuAU71rsna1xbIqPnUZaxUKnq', NULL, '2025-06-12 04:58:52', '2025-06-12 04:58:52', 'admin', 15),
(23, 'member2', 'member2@gmail.com', NULL, '$2y$12$0wK8QSQBrSQavZRWMUEk5.brkQ9Jl/CPqBo5x3xkbQ.a2Tpx5Ud4u', NULL, '2025-06-12 06:05:36', '2025-06-12 06:05:36', 'member', 5),
(24, 'member3', 'member3@gmail.com', NULL, '$2y$12$uG0RN.zz85De1wSF92UJVucMv.0.ulCDvzJDMig35FtnDRo25UQ3O', NULL, '2025-06-12 06:07:59', '2025-06-12 06:07:59', 'member', 5),
(25, 'member4', 'member4@gmail.com', NULL, '$2y$12$tI9/WFMTvVYgFoJNdeMtF.tDRsTlChvNwoKO58nEHc5wRwxAm4EIu', NULL, '2025-06-12 06:08:27', '2025-06-12 06:08:27', 'member', 5),
(26, 'member5', 'member5@gmail.com', NULL, '$2y$12$YTdF/WlqtzOdvRGtr/hZeOmXfYhbXn6v1iQW/0JUM2DVp6K4/DOQa', NULL, '2025-06-12 06:08:48', '2025-06-12 06:08:48', 'member', 5),
(27, 'member6', 'member6@gmail.com', NULL, '$2y$12$WuTSYajJEWU2KagEdrliM.P9oxqbox7UjlV2rxPvLLTHF/iphGLK.', NULL, '2025-06-12 06:09:07', '2025-06-12 06:09:07', 'member', 5),
(28, 'member7', 'member7@gmail.com', NULL, '$2y$12$rhLtGpQkd2KBJXtaOcG2guHlqSKiITo7VpdRleS05sAJYItFbmI5u', NULL, '2025-06-12 06:09:34', '2025-06-12 06:09:34', 'member', 5),
(29, 'member8', 'member8@gmail.com', NULL, '$2y$12$DQus0SldtJe1RPOMeZTUfuyb0XtYRknDZNNJR6dEIxonUkBIkYbN.', NULL, '2025-06-12 06:10:01', '2025-06-12 06:10:01', 'member', 5),
(30, 'member9', 'member9@gmail.com', NULL, '$2y$12$ViYOtn6fciwjj4oz4P0bfuligCteaAv4xbZXadDyz1kGiAEG3jCMG', NULL, '2025-06-12 06:10:20', '2025-06-12 06:10:20', 'member', 5),
(31, 'member10', 'member10@gmail.com', NULL, '$2y$12$dXSXX9U5CYJssNNFp3qNDe/4/0KeNDRFe.LPxhuMWsWUaNrTIe45a', NULL, '2025-06-12 06:10:55', '2025-06-12 06:10:55', 'member', 5),
(32, 'member11', 'member11@gmail.com', NULL, '$2y$12$ed2uaVTJcH./0Plbl2KD9epqAf1dKtR7pTroZqCT5KfgjrJSw.TlG', NULL, '2025-06-12 06:11:17', '2025-06-12 06:11:17', 'member', 5);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
