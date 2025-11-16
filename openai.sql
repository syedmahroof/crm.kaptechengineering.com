-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: May 31, 2025 at 07:09 AM
-- Server version: 9.3.0
-- PHP Version: 8.4.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `openai`
--

-- --------------------------------------------------------

--
-- Table structure for table `activities`
--

CREATE TABLE `activities` (
  `id` bigint UNSIGNED NOT NULL,
  `project_id` bigint UNSIGNED NOT NULL,
  `events` json NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `bank_statement_uploads`
--

CREATE TABLE `bank_statement_uploads` (
  `id` bigint UNSIGNED NOT NULL,
  `file_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `file_path` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `file_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `file_size` int DEFAULT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `bank_title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `error_message` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `fcs_data` json DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `bank_statement_uploads`
--

INSERT INTO `bank_statement_uploads` (`id`, `file_name`, `file_path`, `file_type`, `file_size`, `status`, `bank_title`, `error_message`, `created_at`, `updated_at`, `fcs_data`) VALUES
(57, '3month_statement_10_transactions.pdf', 'storage/app/bank_statements/82MgLjh5hZ4JRd0cyMW3qp0EE8j4tDDMi4Ze8SA3.pdf', 'pdf', 2871, 'completed', NULL, NULL, '2025-05-30 13:51:32', '2025-05-30 13:52:05', NULL),
(59, '3month_statement_10_transactions.pdf', 'storage/app/bank_statements/7FoFnMhL9hErQ98aGjpv8va0KufYrGTvbFUfUPVk.pdf', 'pdf', 2871, 'completed', NULL, NULL, '2025-05-31 01:17:57', '2025-05-31 01:18:19', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
-- Table structure for table `diagnoses`
--

CREATE TABLE `diagnoses` (
  `id` bigint UNSIGNED NOT NULL,
  `inventory_id` bigint UNSIGNED NOT NULL,
  `suit_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `notes` text COLLATE utf8mb4_unicode_ci,
  `started_at` timestamp NULL DEFAULT NULL,
  `ended_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `result_data` json DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
-- Table structure for table `fcs_data`
--

CREATE TABLE `fcs_data` (
  `id` bigint UNSIGNED NOT NULL,
  `bank_statement_id` bigint UNSIGNED NOT NULL,
  `metrics` json DEFAULT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'draft',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `inventories`
--

CREATE TABLE `inventories` (
  `id` bigint UNSIGNED NOT NULL,
  `imei` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `year` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'available',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` int NOT NULL DEFAULT '0',
  `reserved_at` int UNSIGNED DEFAULT NULL,
  `available_at` int UNSIGNED NOT NULL,
  `created_at` int UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `jobs`
--

INSERT INTO `jobs` (`id`, `queue`, `payload`, `attempts`, `reserved_at`, `available_at`, `created_at`) VALUES
(24252, 'default', '{\"uuid\":\"b3fdebbd-a551-4e68-abd3-982ebbb58bf8\",\"displayName\":\"App\\\\Jobs\\\\ProcessBankStatementJob\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":1748625532,\"data\":{\"commandName\":\"App\\\\Jobs\\\\ProcessBankStatementJob\",\"command\":\"O:32:\\\"App\\\\Jobs\\\\ProcessBankStatementJob\\\":3:{s:11:\\\"\\u0000*\\u0000uploadId\\\";i:28;s:11:\\\"\\u0000*\\u0000filePath\\\";s:72:\\\"storage\\/app\\/bank_statements\\/7ByM72U4u4Qu2fwKpl5y6CCPKw5BaKlWZMnR8JWJ.pdf\\\";s:11:\\\"\\u0000*\\u0000fileType\\\";s:3:\\\"pdf\\\";}\"}}', 9, 1748622372, 1748622309, 1748622309),
(24253, 'default', '{\"uuid\":\"45feed43-1dca-4a00-a12b-85229b4aba44\",\"displayName\":\"App\\\\Jobs\\\\ProcessBankStatementJob\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":1748624840,\"data\":{\"commandName\":\"App\\\\Jobs\\\\ProcessBankStatementJob\",\"command\":\"O:32:\\\"App\\\\Jobs\\\\ProcessBankStatementJob\\\":3:{s:11:\\\"\\u0000*\\u0000uploadId\\\";i:25;s:11:\\\"\\u0000*\\u0000filePath\\\";s:72:\\\"storage\\/app\\/bank_statements\\/ssRLQvGpImCxj02ci6redsfn1fJEnRFuTO9bdqxl.pdf\\\";s:11:\\\"\\u0000*\\u0000fileType\\\";s:3:\\\"pdf\\\";}\"}}', 5862, NULL, 1748622309, 1748622309),
(24254, 'default', '{\"uuid\":\"0525228f-ec53-4a45-8279-7235d85e81c3\",\"displayName\":\"App\\\\Jobs\\\\ProcessBankStatementJob\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":1748624345,\"data\":{\"commandName\":\"App\\\\Jobs\\\\ProcessBankStatementJob\",\"command\":\"O:32:\\\"App\\\\Jobs\\\\ProcessBankStatementJob\\\":3:{s:11:\\\"\\u0000*\\u0000uploadId\\\";i:22;s:11:\\\"\\u0000*\\u0000filePath\\\";s:72:\\\"storage\\/app\\/bank_statements\\/hG2q7lojPReE8463CAaBiOPYICu901rH78jbqgBb.pdf\\\";s:11:\\\"\\u0000*\\u0000fileType\\\";s:3:\\\"pdf\\\";}\"}}', 6118, NULL, 1748622309, 1748622309),
(24255, 'default', '{\"uuid\":\"18193829-29de-49ee-8e13-30f941559efb\",\"displayName\":\"App\\\\Jobs\\\\ProcessBankStatementJob\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":1748624474,\"data\":{\"commandName\":\"App\\\\Jobs\\\\ProcessBankStatementJob\",\"command\":\"O:32:\\\"App\\\\Jobs\\\\ProcessBankStatementJob\\\":3:{s:11:\\\"\\u0000*\\u0000uploadId\\\";i:23;s:11:\\\"\\u0000*\\u0000filePath\\\";s:72:\\\"storage\\/app\\/bank_statements\\/sJuZ3wB2XY1lWcTAik3Qt3dfFHaMjQQTv72usRJt.pdf\\\";s:11:\\\"\\u0000*\\u0000fileType\\\";s:3:\\\"pdf\\\";}\"}}', 6119, NULL, 1748622309, 1748622309),
(24256, 'default', '{\"uuid\":\"ec8ac0bd-0af4-4228-a96d-d52ca13a5095\",\"displayName\":\"App\\\\Jobs\\\\ProcessBankStatementJob\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":1748624739,\"data\":{\"commandName\":\"App\\\\Jobs\\\\ProcessBankStatementJob\",\"command\":\"O:32:\\\"App\\\\Jobs\\\\ProcessBankStatementJob\\\":3:{s:11:\\\"\\u0000*\\u0000uploadId\\\";i:24;s:11:\\\"\\u0000*\\u0000filePath\\\";s:72:\\\"storage\\/app\\/bank_statements\\/MF4Wgqq5tyHLm4ZCW5qWtIW2px1B56zVUyOXrc2P.pdf\\\";s:11:\\\"\\u0000*\\u0000fileType\\\";s:3:\\\"pdf\\\";}\"}}', 6118, NULL, 1748622309, 1748622309),
(24257, 'default', '{\"uuid\":\"c4d6cd30-7927-4bd6-b84c-9acf9ab77155\",\"displayName\":\"App\\\\Jobs\\\\ProcessBankStatementJob\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":1748625417,\"data\":{\"commandName\":\"App\\\\Jobs\\\\ProcessBankStatementJob\",\"command\":\"O:32:\\\"App\\\\Jobs\\\\ProcessBankStatementJob\\\":3:{s:11:\\\"\\u0000*\\u0000uploadId\\\";i:27;s:11:\\\"\\u0000*\\u0000filePath\\\";s:72:\\\"storage\\/app\\/bank_statements\\/XFfOSeH1LFMX2ZfDMRh0mKsSfeOFLHoIUvvMqZJP.pdf\\\";s:11:\\\"\\u0000*\\u0000fileType\\\";s:3:\\\"pdf\\\";}\"}}', 10, NULL, 1748622309, 1748622309),
(24258, 'default', '{\"uuid\":\"db63654a-c055-45a4-a1b9-e4eaeeea671f\",\"displayName\":\"App\\\\Jobs\\\\ProcessBankStatementJob\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":1748625311,\"data\":{\"commandName\":\"App\\\\Jobs\\\\ProcessBankStatementJob\",\"command\":\"O:32:\\\"App\\\\Jobs\\\\ProcessBankStatementJob\\\":3:{s:11:\\\"\\u0000*\\u0000uploadId\\\";i:26;s:11:\\\"\\u0000*\\u0000filePath\\\";s:72:\\\"storage\\/app\\/bank_statements\\/v6fCzMSmgHlqDtyiVxPj9DwREqzQU7K38qy4DiuY.pdf\\\";s:11:\\\"\\u0000*\\u0000fileType\\\";s:3:\\\"pdf\\\";}\"}}', 12, NULL, 1748622309, 1748622309),
(24259, 'default', '{\"uuid\":\"8d1f02e1-2aa5-4963-b10d-60f612f90def\",\"displayName\":\"App\\\\Jobs\\\\ProcessBankStatementJob\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":1748625718,\"data\":{\"commandName\":\"App\\\\Jobs\\\\ProcessBankStatementJob\",\"command\":\"O:32:\\\"App\\\\Jobs\\\\ProcessBankStatementJob\\\":3:{s:11:\\\"\\u0000*\\u0000uploadId\\\";i:29;s:11:\\\"\\u0000*\\u0000filePath\\\";s:72:\\\"storage\\/app\\/bank_statements\\/fKJA2TD6bRDSnUmH8KUHZsxoNpNQDXdHD8k6sY2A.pdf\\\";s:11:\\\"\\u0000*\\u0000fileType\\\";s:3:\\\"pdf\\\";}\"}}', 3, NULL, 1748622343, 1748622343),
(24260, 'default', '{\"uuid\":\"64388607-871f-464d-bd74-db3d112f96df\",\"displayName\":\"App\\\\Jobs\\\\ProcessBankStatementJob\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":1748625788,\"data\":{\"commandName\":\"App\\\\Jobs\\\\ProcessBankStatementJob\",\"command\":\"O:32:\\\"App\\\\Jobs\\\\ProcessBankStatementJob\\\":3:{s:11:\\\"\\u0000*\\u0000uploadId\\\";i:30;s:11:\\\"\\u0000*\\u0000filePath\\\";s:72:\\\"storage\\/app\\/bank_statements\\/MPhIrWiVB5saFXzbUgfdyw4Yd5ihAUOK0yQ03PJT.pdf\\\";s:11:\\\"\\u0000*\\u0000fileType\\\";s:3:\\\"pdf\\\";}\"}}', 2, NULL, 1748622372, 1748622372);

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
(4, '2025_01_16_213821_create_projects_table', 1),
(5, '2025_01_16_221857_create_pages_table', 1),
(6, '2025_01_17_221326_create_activities_table', 1),
(7, '2025_03_22_053229_create_inventories_table', 1),
(8, '2025_03_22_053415_create_diagnoses_table', 1),
(9, '2025_03_22_053503_create_results_table', 1),
(10, '2025_03_22_064436_alter_suit_id_in_diagnoses_table', 1),
(11, '2025_04_28_085723_create_suits_table', 1),
(12, '2025_04_28_093805_add_model_year_image_to_inventories_table', 1),
(13, '2025_04_28_094646_add_result_data_to_diagnoses_table', 1),
(14, '2025_05_30_114914_create_bank_statement_uploads_table', 2),
(15, '2025_05_30_114916_create_processed_bank_statements_table', 2),
(16, '2025_05_30_add_fcs_data_to_processed_bank_statements', 3),
(17, '2025_05_30_155819_add_retry_count_to_bank_statement_uploads', 4),
(18, '2025_05_30_160759_fix_jobs_attempts_column', 5),
(19, '2025_05_30_163343_update_processed_bank_statements_make_summary_nullable', 6),
(20, '2025_05_30_164125_add_fcs_data_to_bank_statement_uploads', 7),
(21, '2025_05_30_create_fcs_data_table', 8),
(22, '2025_05_30_add_fcs_columns_to_processed_bank_statements', 9),
(23, '2025_05_31_add_bank_title_to_bank_statement_uploads', 10);

-- --------------------------------------------------------

--
-- Table structure for table `pages`
--

CREATE TABLE `pages` (
  `id` bigint UNSIGNED NOT NULL,
  `project_id` bigint UNSIGNED NOT NULL,
  `path` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `bucket` datetime NOT NULL,
  `views` bigint UNSIGNED NOT NULL,
  `average_time` int NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `processed_bank_statements`
--

CREATE TABLE `processed_bank_statements` (
  `id` bigint UNSIGNED NOT NULL,
  `upload_id` bigint UNSIGNED NOT NULL,
  `account_info` json DEFAULT NULL,
  `transactions` json DEFAULT NULL,
  `summary` text COLLATE utf8mb4_unicode_ci,
  `total_credits` decimal(15,2) DEFAULT NULL,
  `total_debits` decimal(15,2) DEFAULT NULL,
  `period_start` date DEFAULT NULL,
  `period_end` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `fcs_data` json DEFAULT NULL,
  `fcs_metrics` json DEFAULT NULL,
  `fcs_status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'draft'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `processed_bank_statements`
--

INSERT INTO `processed_bank_statements` (`id`, `upload_id`, `account_info`, `transactions`, `summary`, `total_credits`, `total_debits`, `period_start`, `period_end`, `created_at`, `updated_at`, `fcs_data`, `fcs_metrics`, `fcs_status`) VALUES
(14, 57, '\"{\\\"account_number\\\":null,\\\"account_holder\\\":null,\\\"bank_name\\\":\\\"Example Bank Ltd\\\"}\"', '\"[{\\\"date\\\":\\\"01 Feb 2025\\\",\\\"description\\\":\\\"Consulting Income Received at ConsultCo, 33 Insight Rd, Advisory City, AC9 0PQ\\\",\\\"amount\\\":2209.83,\\\"balance\\\":56226.88,\\\"transaction_type\\\":\\\"credit\\\",\\\"category\\\":\\\"income\\\"},{\\\"date\\\":\\\"01 Jan 2025\\\",\\\"description\\\":\\\"Interest Earned - Savings at Savings Acct, Example Bank, 500 Finance Rd, Sample City, SC12 3AB\\\",\\\"amount\\\":1793.6,\\\"balance\\\":41927.67,\\\"transaction_type\\\":\\\"credit\\\",\\\"category\\\":\\\"interest\\\"},{\\\"date\\\":\\\"01 Mar 2025\\\",\\\"description\\\":\\\"Direct Debit - Phone Bill at MobileCo, 45 Telecom Ave, Phone City, PC3 4ZY\\\",\\\"amount\\\":-409.42,\\\"balance\\\":28906.95,\\\"transaction_type\\\":\\\"debit\\\",\\\"category\\\":\\\"payment\\\"},{\\\"date\\\":\\\"02 Feb 2025\\\",\\\"description\\\":\\\"COGS Payment - Raw Materials at RawMat Inc, 55 Industrial Pkwy, Factory Town, FT8 9GH\\\",\\\"amount\\\":-1260.09,\\\"balance\\\":61023.16,\\\"transaction_type\\\":\\\"debit\\\",\\\"category\\\":\\\"payment\\\"},{\\\"date\\\":\\\"02 Feb 2025\\\",\\\"description\\\":\\\"COGS Payment - Raw Materials at RawMat Inc, 55 Industrial Pkwy, Factory Town, FT8 9GH\\\",\\\"amount\\\":-421.52,\\\"balance\\\":54643.53,\\\"transaction_type\\\":\\\"debit\\\",\\\"category\\\":\\\"payment\\\"},{\\\"date\\\":\\\"02 Jan 2025\\\",\\\"description\\\":\\\"Direct Debit - Phone Bill at MobileCo, 45 Telecom Ave, Phone City, PC3 4ZY\\\",\\\"amount\\\":-837.07,\\\"balance\\\":40134.07,\\\"transaction_type\\\":\\\"debit\\\",\\\"category\\\":\\\"payment\\\"},{\\\"date\\\":\\\"03 Feb 2025\\\",\\\"description\\\":\\\"Office Rent - Q1 2025 at Landlord, 50 Property St, Real Estate City, RE1 2ST\\\",\\\"amount\\\":-394.17,\\\"balance\\\":64237.96,\\\"transaction_type\\\":\\\"debit\\\",\\\"category\\\":\\\"payment\\\"},{\\\"date\\\":\\\"03 Jan 2025\\\",\\\"description\\\":\\\"Bank Fee - Monthly Maintenance at Example Bank HQ, 500 Finance Rd, Sample City, SC12 3AB\\\",\\\"amount\\\":-1177.18,\\\"balance\\\":38421.26,\\\"transaction_type\\\":\\\"debit\\\",\\\"category\\\":\\\"fee\\\"},{\\\"date\\\":\\\"03 Mar 2025\\\",\\\"description\\\":\\\"Interest Earned - Savings at Savings Acct, Example Bank, 500 Finance Rd, Sample City, SC12 3AB\\\",\\\"amount\\\":1453.1,\\\"balance\\\":41405.49,\\\"transaction_type\\\":\\\"credit\\\",\\\"category\\\":\\\"interest\\\"},{\\\"date\\\":\\\"03 Mar 2025\\\",\\\"description\\\":\\\"Travel Expense - Taxi Ride at City Taxi, 22 Cab Ln, Transit City, TC7 8LM\\\",\\\"amount\\\":-981.06,\\\"balance\\\":60283.65,\\\"transaction_type\\\":\\\"debit\\\",\\\"category\\\":\\\"payment\\\"}]\"', NULL, 5456.53, 4103.44, NULL, NULL, '2025-05-30 13:52:05', '2025-05-30 13:52:42', NULL, '{\"revenue\": {\"feb\": 2209.83, \"jan\": 1793.6, \"mar\": 1453.1, \"total\": 5456.53}, \"nsf_fees\": {\"feb\": 0, \"jan\": 0, \"mar\": 0, \"total\": 0}, \"adjustments\": {\"feb\": 0, \"jan\": 1177.18, \"mar\": 0, \"total\": 1177.18}, \"negative_days\": {\"feb\": 0, \"jan\": 0, \"mar\": 0, \"total\": 0}, \"deposits_count\": {\"feb\": 1, \"jan\": 1, \"mar\": 1, \"total\": 3}, \"ending_balance\": {\"feb\": 64237.96, \"jan\": 38421.26, \"mar\": 60283.65, \"total\": 162942.87}}', 'draft'),
(15, 59, '\"{\\\"account_number\\\":null,\\\"account_holder\\\":null,\\\"bank_name\\\":\\\"Example Bank Ltd\\\"}\"', '\"[{\\\"date\\\":\\\"01 Feb 2025\\\",\\\"description\\\":\\\"Consulting Income Received at ConsultCo, 33 Insight Rd, Advisory City, AC9 0PQ\\\",\\\"amount\\\":2209.83,\\\"balance\\\":56226.88,\\\"transaction_type\\\":\\\"credit\\\",\\\"category\\\":\\\"income\\\"},{\\\"date\\\":\\\"01 Jan 2025\\\",\\\"description\\\":\\\"Interest Earned - Savings at Savings Acct, Example Bank, 500 Finance Rd, Sample City, SC12 3AB\\\",\\\"amount\\\":1793.6,\\\"balance\\\":41927.67,\\\"transaction_type\\\":\\\"credit\\\",\\\"category\\\":\\\"interest\\\"},{\\\"date\\\":\\\"01 Mar 2025\\\",\\\"description\\\":\\\"Direct Debit - Phone Bill at MobileCo, 45 Telecom Ave, Phone City, PC3 4ZY\\\",\\\"amount\\\":-409.42,\\\"balance\\\":28906.95,\\\"transaction_type\\\":\\\"debit\\\",\\\"category\\\":\\\"payment\\\"},{\\\"date\\\":\\\"02 Feb 2025\\\",\\\"description\\\":\\\"COGS Payment - Raw Materials at RawMat Inc, 55 Industrial Pkwy, Factory Town, FT8 9GH\\\",\\\"amount\\\":-1260.09,\\\"balance\\\":61023.16,\\\"transaction_type\\\":\\\"debit\\\",\\\"category\\\":\\\"payment\\\"},{\\\"date\\\":\\\"02 Feb 2025\\\",\\\"description\\\":\\\"COGS Payment - Raw Materials at RawMat Inc, 55 Industrial Pkwy, Factory Town, FT8 9GH\\\",\\\"amount\\\":-421.52,\\\"balance\\\":54643.53,\\\"transaction_type\\\":\\\"debit\\\",\\\"category\\\":\\\"payment\\\"},{\\\"date\\\":\\\"02 Jan 2025\\\",\\\"description\\\":\\\"Direct Debit - Phone Bill at MobileCo, 45 Telecom Ave, Phone City, PC3 4ZY\\\",\\\"amount\\\":-837.07,\\\"balance\\\":40134.07,\\\"transaction_type\\\":\\\"debit\\\",\\\"category\\\":\\\"payment\\\"},{\\\"date\\\":\\\"03 Feb 2025\\\",\\\"description\\\":\\\"Office Rent - Q1 2025 at Landlord, 50 Property St, Real Estate City, RE1 2ST\\\",\\\"amount\\\":-394.17,\\\"balance\\\":64237.96,\\\"transaction_type\\\":\\\"debit\\\",\\\"category\\\":\\\"payment\\\"},{\\\"date\\\":\\\"03 Jan 2025\\\",\\\"description\\\":\\\"Bank Fee - Monthly Maintenance at Example Bank HQ, 500 Finance Rd, Sample City, SC12 3AB\\\",\\\"amount\\\":-1177.18,\\\"balance\\\":38421.26,\\\"transaction_type\\\":\\\"debit\\\",\\\"category\\\":\\\"fee\\\"},{\\\"date\\\":\\\"03 Mar 2025\\\",\\\"description\\\":\\\"Interest Earned - Savings at Savings Acct, Example Bank, 500 Finance Rd, Sample City, SC12 3AB\\\",\\\"amount\\\":1453.1,\\\"balance\\\":41405.49,\\\"transaction_type\\\":\\\"credit\\\",\\\"category\\\":\\\"interest\\\"},{\\\"date\\\":\\\"03 Mar 2025\\\",\\\"description\\\":\\\"Travel Expense - Taxi Ride at City Taxi, 22 Cab Ln, Transit City, TC7 8LM\\\",\\\"amount\\\":-981.06,\\\"balance\\\":60283.65,\\\"transaction_type\\\":\\\"debit\\\",\\\"category\\\":\\\"expense\\\"}]\"', NULL, 5456.53, 4003.44, NULL, NULL, '2025-05-31 01:18:19', '2025-05-31 01:18:19', NULL, NULL, 'draft');

-- --------------------------------------------------------

--
-- Table structure for table `projects`
--

CREATE TABLE `projects` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `results`
--

CREATE TABLE `results` (
  `id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
('hkxo0qIVLaJgJun46wCp7y27Lgg28oO40G7aoYu3', 1, '127.0.0.1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 'YTo1OntzOjY6Il90b2tlbiI7czo0MDoidUJ2ZWtxMHhXQUNSWElzNnY0akpBRnJKRUhkQ3ZYVjFtZUtQQ3JKcyI7czozOiJ1cmwiO2E6MDp7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6OToiX3ByZXZpb3VzIjthOjE6e3M6MzoidXJsIjtzOjMwOiJodHRwczovL2dzeC1wb2MudGVzdC9kYXNoYm9hcmQiO31zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aToxO30=', 1748675360);

-- --------------------------------------------------------

--
-- Table structure for table `suits`
--

CREATE TABLE `suits` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Syed', 'mahroof917@gmail.com', '2025-05-30 08:38:04', '$2y$12$Wx.UyB4CyERhvCe/SQI8bOr0IjrlmhKGjRUKurAnSEPObVrKHX6RK', NULL, '2025-05-30 03:07:53', '2025-05-30 03:07:53');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `activities`
--
ALTER TABLE `activities`
  ADD PRIMARY KEY (`id`),
  ADD KEY `activities_project_id_foreign` (`project_id`);

--
-- Indexes for table `bank_statement_uploads`
--
ALTER TABLE `bank_statement_uploads`
  ADD PRIMARY KEY (`id`);

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
-- Indexes for table `diagnoses`
--
ALTER TABLE `diagnoses`
  ADD PRIMARY KEY (`id`),
  ADD KEY `diagnoses_inventory_id_foreign` (`inventory_id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `fcs_data`
--
ALTER TABLE `fcs_data`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fcs_data_bank_statement_id_foreign` (`bank_statement_id`);

--
-- Indexes for table `inventories`
--
ALTER TABLE `inventories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `inventories_imei_unique` (`imei`);

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
-- Indexes for table `pages`
--
ALTER TABLE `pages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pages_project_id_foreign` (`project_id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `processed_bank_statements`
--
ALTER TABLE `processed_bank_statements`
  ADD PRIMARY KEY (`id`),
  ADD KEY `processed_bank_statements_upload_id_foreign` (`upload_id`);

--
-- Indexes for table `projects`
--
ALTER TABLE `projects`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `projects_user_id_name_unique` (`user_id`,`name`);

--
-- Indexes for table `results`
--
ALTER TABLE `results`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `suits`
--
ALTER TABLE `suits`
  ADD PRIMARY KEY (`id`);

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
-- AUTO_INCREMENT for table `activities`
--
ALTER TABLE `activities`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `bank_statement_uploads`
--
ALTER TABLE `bank_statement_uploads`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=60;

--
-- AUTO_INCREMENT for table `diagnoses`
--
ALTER TABLE `diagnoses`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `fcs_data`
--
ALTER TABLE `fcs_data`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `inventories`
--
ALTER TABLE `inventories`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24261;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `pages`
--
ALTER TABLE `pages`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `processed_bank_statements`
--
ALTER TABLE `processed_bank_statements`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `projects`
--
ALTER TABLE `projects`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `results`
--
ALTER TABLE `results`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `suits`
--
ALTER TABLE `suits`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `activities`
--
ALTER TABLE `activities`
  ADD CONSTRAINT `activities_project_id_foreign` FOREIGN KEY (`project_id`) REFERENCES `projects` (`id`);

--
-- Constraints for table `diagnoses`
--
ALTER TABLE `diagnoses`
  ADD CONSTRAINT `diagnoses_inventory_id_foreign` FOREIGN KEY (`inventory_id`) REFERENCES `inventories` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `fcs_data`
--
ALTER TABLE `fcs_data`
  ADD CONSTRAINT `fcs_data_bank_statement_id_foreign` FOREIGN KEY (`bank_statement_id`) REFERENCES `processed_bank_statements` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `pages`
--
ALTER TABLE `pages`
  ADD CONSTRAINT `pages_project_id_foreign` FOREIGN KEY (`project_id`) REFERENCES `projects` (`id`);

--
-- Constraints for table `processed_bank_statements`
--
ALTER TABLE `processed_bank_statements`
  ADD CONSTRAINT `processed_bank_statements_upload_id_foreign` FOREIGN KEY (`upload_id`) REFERENCES `bank_statement_uploads` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `projects`
--
ALTER TABLE `projects`
  ADD CONSTRAINT `projects_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
