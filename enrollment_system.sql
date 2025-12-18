-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 18, 2025 at 03:25 AM
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
-- Database: `enrollment_system`
--

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cache`
--

INSERT INTO `cache` (`key`, `value`, `expiration`) VALUES
('your-app-name-cache-livewire-rate-limiter:16d36dff9abd246c67dfac3e63b993a169af77e6', 'i:1;', 1765925436),
('your-app-name-cache-livewire-rate-limiter:16d36dff9abd246c67dfac3e63b993a169af77e6:timer', 'i:1765925436;', 1765925436);

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `curricula`
--

CREATE TABLE `curricula` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `curriculum` text NOT NULL,
  `status` varchar(255) NOT NULL,
  `program_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `curricula`
--

INSERT INTO `curricula` (`id`, `created_at`, `updated_at`, `curriculum`, `status`, `program_id`) VALUES
(1, '2025-12-16 01:09:23', '2025-12-16 01:09:23', '2016-17', 'inactive', 1),
(2, '2025-12-16 01:09:23', '2025-12-16 01:09:23', '2018-19', 'inactive', 1),
(3, '2025-12-16 01:09:23', '2025-12-16 01:09:23', '2021-22', 'active', 1),
(4, '2025-12-16 01:09:23', '2025-12-16 01:09:23', '2016-17', 'inactive', 2),
(5, '2025-12-16 01:09:23', '2025-12-16 01:09:23', '2018-19', 'inactive', 2),
(6, '2025-12-16 01:09:23', '2025-12-16 01:09:23', '2021-22', 'active', 2),
(7, '2025-12-16 01:09:23', '2025-12-16 01:09:23', '2016-17', 'inactive', 3),
(8, '2025-12-16 01:09:23', '2025-12-16 01:09:23', '2018-19', 'inactive', 3),
(9, '2025-12-16 01:09:23', '2025-12-16 01:09:23', '2021-22', 'active', 3),
(10, '2025-12-16 01:09:23', '2025-12-16 01:09:23', '2016-17', 'inactive', 4),
(11, '2025-12-16 01:09:23', '2025-12-16 01:09:23', '2018-19', 'inactive', 4),
(12, '2025-12-16 01:09:23', '2025-12-16 01:09:23', '2021-22', 'active', 4),
(13, '2025-12-16 01:09:23', '2025-12-16 01:09:23', '2016-17', 'inactive', 5),
(14, '2025-12-16 01:09:23', '2025-12-16 01:09:23', '2018-19', 'inactive', 5),
(15, '2025-12-16 01:09:23', '2025-12-16 01:09:23', '2021-22', 'active', 5),
(16, '2025-12-16 01:09:23', '2025-12-16 01:09:23', '2016-17', 'inactive', 6),
(17, '2025-12-16 01:09:23', '2025-12-16 01:09:23', '2018-19', 'inactive', 6),
(18, '2025-12-16 01:09:23', '2025-12-16 01:09:23', '2021-22', 'active', 6),
(19, '2025-12-16 01:09:23', '2025-12-16 01:09:23', '2016-17', 'inactive', 7),
(20, '2025-12-16 01:09:23', '2025-12-16 01:09:23', '2018-19', 'inactive', 7),
(21, '2025-12-16 01:09:23', '2025-12-16 01:09:23', '2021-22', 'active', 7),
(22, '2025-12-16 01:09:23', '2025-12-16 01:09:23', '2016-17', 'inactive', 8),
(23, '2025-12-16 01:09:23', '2025-12-16 01:09:23', '2018-19', 'inactive', 8),
(24, '2025-12-16 01:09:23', '2025-12-16 01:09:23', '2021-22', 'active', 8),
(25, '2025-12-16 01:09:23', '2025-12-16 01:09:23', '2016-17', 'inactive', 9),
(26, '2025-12-16 01:09:23', '2025-12-16 01:09:23', '2018-19', 'inactive', 9),
(27, '2025-12-16 01:09:23', '2025-12-16 01:09:23', '2021-22', 'active', 9),
(28, '2025-12-16 01:09:23', '2025-12-16 01:09:23', '2016-17', 'inactive', 10),
(29, '2025-12-16 01:09:23', '2025-12-16 01:09:23', '2018-19', 'inactive', 10),
(30, '2025-12-16 01:09:23', '2025-12-16 01:09:23', '2021-22', 'active', 10),
(31, '2025-12-16 01:09:23', '2025-12-16 01:09:23', '2016-17', 'inactive', 11),
(32, '2025-12-16 01:09:23', '2025-12-16 01:09:23', '2018-19', 'inactive', 11),
(33, '2025-12-16 01:09:23', '2025-12-16 01:09:23', '2021-22', 'active', 11),
(34, '2025-12-16 01:09:23', '2025-12-16 01:09:23', '2016-17', 'inactive', 12),
(35, '2025-12-16 01:09:23', '2025-12-16 01:09:23', '2018-19', 'inactive', 12),
(36, '2025-12-16 01:09:23', '2025-12-16 01:09:23', '2021-22', 'active', 12),
(37, '2025-12-16 01:09:23', '2025-12-16 01:09:23', '2016-17', 'inactive', 13),
(38, '2025-12-16 01:09:23', '2025-12-16 01:09:23', '2018-19', 'inactive', 13),
(39, '2025-12-16 01:09:23', '2025-12-16 01:09:23', '2021-22', 'active', 13),
(40, '2025-12-16 01:09:23', '2025-12-16 01:09:23', '2016-17', 'inactive', 14),
(41, '2025-12-16 01:09:23', '2025-12-16 01:09:23', '2018-19', 'inactive', 14),
(42, '2025-12-16 01:09:23', '2025-12-16 01:09:23', '2021-22', 'active', 14),
(43, '2025-12-16 01:09:23', '2025-12-16 01:09:23', '2016-17', 'inactive', 15),
(44, '2025-12-16 01:09:23', '2025-12-16 01:09:23', '2018-19', 'inactive', 15),
(45, '2025-12-16 01:09:23', '2025-12-16 01:09:23', '2021-22', 'active', 15),
(46, '2025-12-16 01:09:23', '2025-12-16 01:09:23', '2016-17', 'inactive', 16),
(47, '2025-12-16 01:09:23', '2025-12-16 01:09:23', '2018-19', 'inactive', 16),
(48, '2025-12-16 01:09:23', '2025-12-16 01:09:23', '2021-22', 'active', 16),
(49, '2025-12-16 01:09:23', '2025-12-16 01:09:23', '2016-17', 'inactive', 17),
(50, '2025-12-16 01:09:23', '2025-12-16 01:09:23', '2018-19', 'inactive', 17),
(51, '2025-12-16 01:09:23', '2025-12-16 01:09:23', '2021-22', 'active', 17),
(52, '2025-12-16 01:09:23', '2025-12-16 01:09:23', '2016-17', 'inactive', 18),
(53, '2025-12-16 01:09:23', '2025-12-16 01:09:23', '2018-19', 'inactive', 18),
(54, '2025-12-16 01:09:23', '2025-12-16 01:09:23', '2021-22', 'active', 18);

-- --------------------------------------------------------

--
-- Table structure for table `departments`
--

CREATE TABLE `departments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `code` text NOT NULL,
  `description` text NOT NULL,
  `status` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `departments`
--

INSERT INTO `departments` (`id`, `created_at`, `updated_at`, `code`, `description`, `status`) VALUES
(1, '2025-12-16 01:08:16', '2025-12-17 05:06:05', 'ELEM', 'Elementary Department', 'active'),
(2, '2025-12-16 01:08:17', '2025-12-16 01:08:17', 'JHS', 'Junior High School Department', 'active'),
(3, '2025-12-16 01:08:17', '2025-12-16 01:08:17', 'SHS', 'Senior High School Department', 'active');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
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
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
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
-- Table structure for table `job_batches`
--

CREATE TABLE `job_batches` (
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
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2025_12_06_162707_departments_table', 1),
(5, '2025_12_06_162717_programs_table', 1),
(6, '2025_12_06_162834_curricula_table', 1),
(7, '2025_12_06_162844_subjects_table', 1),
(8, '2025_12_06_162910_semesters_table', 1),
(9, '2025_12_06_162912_prospectuses_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `programs`
--

CREATE TABLE `programs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `code` text NOT NULL,
  `description` text NOT NULL,
  `status` varchar(255) NOT NULL,
  `department_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `programs`
--

INSERT INTO `programs` (`id`, `created_at`, `updated_at`, `code`, `description`, `status`, `department_id`) VALUES
(1, '2025-12-16 01:08:58', '2025-12-16 01:08:58', 'G1', 'Grade 1 - Elementary', 'active', 1),
(2, '2025-12-16 01:08:58', '2025-12-16 01:08:58', 'G2', 'Grade 2 - Elementary', 'active', 1),
(3, '2025-12-16 01:08:58', '2025-12-16 01:08:58', 'G3', 'Grade 3 - Elementary', 'active', 1),
(4, '2025-12-16 01:08:58', '2025-12-16 01:08:58', 'G4', 'Grade 4 - Elementary', 'active', 1),
(5, '2025-12-16 01:08:58', '2025-12-16 01:08:58', 'G5', 'Grade 5 - Elementary', 'active', 1),
(6, '2025-12-16 01:08:58', '2025-12-16 01:08:58', 'G6', 'Grade 6 - Elementary', 'active', 1),
(7, '2025-12-16 01:08:58', '2025-12-16 01:08:58', 'G7', 'Grade 7 - Junior High School', 'active', 2),
(8, '2025-12-16 01:08:58', '2025-12-16 01:08:58', 'G8', 'Grade 8 - Junior High School', 'active', 2),
(9, '2025-12-16 01:08:58', '2025-12-16 01:08:58', 'G9', 'Grade 9 - Junior High School', 'active', 2),
(10, '2025-12-16 01:08:58', '2025-12-16 01:08:58', 'G10', 'Grade 10 - Junior High School', 'active', 2),
(11, '2025-12-16 01:08:58', '2025-12-16 01:08:58', 'STEM11', 'Grade 11 - STEM Strand', 'active', 3),
(12, '2025-12-16 01:08:58', '2025-12-16 01:08:58', 'STEM12', 'Grade 12 - STEM Strand', 'active', 3),
(13, '2025-12-16 01:08:58', '2025-12-16 01:08:58', 'ABM11', 'Grade 11 - ABM Strand', 'active', 3),
(14, '2025-12-16 01:08:58', '2025-12-16 01:08:58', 'ABM12', 'Grade 12 - ABM Strand', 'active', 3),
(15, '2025-12-16 01:08:58', '2025-12-16 01:08:58', 'GAS11', 'Grade 11 - GAS Strand', 'active', 3),
(16, '2025-12-16 01:08:58', '2025-12-16 01:08:58', 'GAS12', 'Grade 12 - GAS Strand', 'active', 3),
(17, '2025-12-16 01:08:58', '2025-12-16 01:08:58', 'HUMSS11', 'Grade 11 - HUMSS Strand', 'active', 3),
(18, '2025-12-16 01:08:58', '2025-12-16 01:08:58', 'HUMSS12', 'Grade 12 - HUMSS Strand', 'active', 3);

-- --------------------------------------------------------

--
-- Table structure for table `prospectuses`
--

CREATE TABLE `prospectuses` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `curriculum_id` bigint(20) UNSIGNED DEFAULT NULL,
  `semester_id` bigint(20) UNSIGNED DEFAULT NULL,
  `subject_id` bigint(20) UNSIGNED DEFAULT NULL,
  `status` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `prospectuses`
--

INSERT INTO `prospectuses` (`id`, `created_at`, `updated_at`, `curriculum_id`, `semester_id`, `subject_id`, `status`) VALUES
(1, '2025-12-17 08:28:09', '2025-12-17 08:28:09', 1, 1, 1, 'active'),
(2, '2025-12-17 08:28:09', '2025-12-17 08:28:09', 1, 2, 2, 'active'),
(3, '2025-12-17 08:28:09', '2025-12-17 08:28:09', 1, 3, 3, 'active'),
(4, '2025-12-17 08:28:09', '2025-12-17 08:28:09', 1, 4, 4, 'active'),
(5, '2025-12-17 08:28:09', '2025-12-17 08:28:09', 1, 5, 1, 'active'),
(6, '2025-12-17 08:28:09', '2025-12-17 08:28:09', 1, 5, 2, 'active'),
(7, '2025-12-17 08:28:09', '2025-12-17 08:28:09', 1, 5, 3, 'active'),
(8, '2025-12-17 08:28:09', '2025-12-17 08:28:09', 1, 5, 4, 'active'),
(9, '2025-12-17 17:59:05', '2025-12-17 17:59:05', 3, 1, 2, 'active'),
(10, '2025-12-17 18:01:31', '2025-12-17 18:01:31', 3, 1, 3, 'active'),
(11, '2025-12-17 18:01:43', '2025-12-17 18:01:43', 3, 2, 3, 'active'),
(13, '2025-12-17 18:02:11', '2025-12-17 18:02:11', 3, 2, 4, 'active'),
(14, '2025-12-17 18:02:28', '2025-12-17 18:02:28', 3, 3, 4, 'active'),
(15, '2025-12-17 18:19:23', '2025-12-17 18:19:23', 3, 3, 1, 'active');

-- --------------------------------------------------------

--
-- Table structure for table `semesters`
--

CREATE TABLE `semesters` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `code` text NOT NULL,
  `description` varchar(100) NOT NULL,
  `academic_year` varchar(100) NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `status` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `semesters`
--

INSERT INTO `semesters` (`id`, `created_at`, `updated_at`, `code`, `description`, `academic_year`, `start_date`, `end_date`, `status`) VALUES
(1, '2025-12-16 01:33:35', '2025-12-16 01:33:35', 'E-Q1 25-26', 'Elementary Quarter 1', '2025 - 2026', '2025-06-01', '2025-08-15', 'active'),
(2, '2025-12-16 01:33:35', '2025-12-16 01:33:35', 'E-Q2 25-26', 'Elementary Quarter 2', '2025 - 2026', '2025-08-16', '2025-10-31', 'active'),
(3, '2025-12-16 01:33:35', '2025-12-16 01:33:35', 'E-Q3 25-26', 'Elementary Quarter 3', '2025 - 2026', '2025-11-01', '2026-01-15', 'active'),
(4, '2025-12-16 01:33:35', '2025-12-16 01:33:35', 'E-Q4 25-26', 'Elementary Quarter 4', '2025 - 2026', '2026-01-16', '2026-03-31', 'active'),
(5, '2025-12-16 01:33:35', '2025-12-16 01:33:35', 'E-SUMMER 25-26', 'Elementary Summer', '2025 - 2026', '2026-04-01', '2026-05-31', 'active'),
(6, '2025-12-16 01:33:35', '2025-12-16 01:33:35', 'J-Q1 25-26', 'Junior High School Quarter 1', '2025 - 2026', '2025-06-01', '2025-08-15', 'active'),
(7, '2025-12-16 01:33:35', '2025-12-16 01:33:35', 'J-Q2 25-26', 'Junior High School Quarter 2', '2025 - 2026', '2025-08-16', '2025-10-31', 'active'),
(8, '2025-12-16 01:33:35', '2025-12-16 01:33:35', 'J-Q3 25-26', 'Junior High School Quarter 3', '2025 - 2026', '2025-11-01', '2026-01-15', 'active'),
(9, '2025-12-16 01:33:35', '2025-12-16 01:33:35', 'J-Q4 25-26', 'Junior High School Quarter 4', '2025 - 2026', '2026-01-16', '2026-03-31', 'active'),
(10, '2025-12-16 01:33:35', '2025-12-16 01:33:35', 'J-SUMMER 25-26', 'Junior High School Summer', '2025 - 2026', '2026-04-01', '2026-05-31', 'active'),
(11, '2025-12-16 01:33:35', '2025-12-16 01:33:35', '1st 25-26', 'Senior High School 1st Semester', '2025 - 2026', '2025-06-01', '2025-10-31', 'active'),
(12, '2025-12-16 01:33:35', '2025-12-16 01:33:35', '2nd 25-26', 'Senior High School 2nd Semester', '2025 - 2026', '2025-11-01', '2026-03-31', 'active'),
(13, '2025-12-16 01:33:35', '2025-12-16 01:33:35', 'SUMMER 25-26', 'Senior High School Summer', '2025 - 2026', '2026-04-01', '2026-05-31', 'active'),
(14, '2025-12-16 01:34:00', '2025-12-16 01:34:00', 'E-Q1 23-24', 'Elementary Quarter 1', '2023 - 2024', '2023-06-01', '2023-08-15', 'inactive'),
(15, '2025-12-16 01:34:00', '2025-12-16 01:34:00', 'E-Q2 23-24', 'Elementary Quarter 2', '2023 - 2024', '2023-08-16', '2023-10-31', 'inactive'),
(16, '2025-12-16 01:34:00', '2025-12-16 01:34:00', 'E-Q3 23-24', 'Elementary Quarter 3', '2023 - 2024', '2023-11-01', '2024-01-15', 'inactive'),
(17, '2025-12-16 01:34:00', '2025-12-16 01:34:00', 'E-Q4 23-24', 'Elementary Quarter 4', '2023 - 2024', '2024-01-16', '2024-03-31', 'inactive'),
(18, '2025-12-16 01:34:00', '2025-12-16 01:34:00', 'E-SUMMER 23-24', 'Elementary Summer', '2023 - 2024', '2024-04-01', '2024-05-31', 'inactive'),
(19, '2025-12-16 01:34:00', '2025-12-16 01:34:00', 'E-Q1 24-25', 'Elementary Quarter 1', '2024 - 2025', '2024-06-01', '2024-08-15', 'inactive'),
(20, '2025-12-16 01:34:00', '2025-12-16 01:34:00', 'E-Q2 24-25', 'Elementary Quarter 2', '2024 - 2025', '2024-08-16', '2024-10-31', 'inactive'),
(21, '2025-12-16 01:34:00', '2025-12-16 01:34:00', 'E-Q3 24-25', 'Elementary Quarter 3', '2024 - 2025', '2024-11-01', '2025-01-15', 'inactive'),
(22, '2025-12-16 01:34:00', '2025-12-16 01:34:00', 'E-Q4 24-25', 'Elementary Quarter 4', '2024 - 2025', '2025-01-16', '2025-03-31', 'inactive'),
(23, '2025-12-16 01:34:00', '2025-12-16 01:34:00', 'E-SUMMER 24-25', 'Elementary Summer', '2024 - 2025', '2025-04-01', '2025-05-31', 'inactive'),
(24, '2025-12-16 01:34:00', '2025-12-16 01:34:00', 'J-Q1 23-24', 'Junior High School Quarter 1', '2023 - 2024', '2023-06-01', '2023-08-15', 'inactive'),
(25, '2025-12-16 01:34:00', '2025-12-16 01:34:00', 'J-Q2 23-24', 'Junior High School Quarter 2', '2023 - 2024', '2023-08-16', '2023-10-31', 'inactive'),
(26, '2025-12-16 01:34:00', '2025-12-16 01:34:00', 'J-Q3 23-24', 'Junior High School Quarter 3', '2023 - 2024', '2023-11-01', '2024-01-15', 'inactive'),
(27, '2025-12-16 01:34:00', '2025-12-16 01:34:00', 'J-Q4 23-24', 'Junior High School Quarter 4', '2023 - 2024', '2024-01-16', '2024-03-31', 'inactive'),
(28, '2025-12-16 01:34:00', '2025-12-16 01:34:00', 'J-SUMMER 23-24', 'Junior High School Summer', '2023 - 2024', '2024-04-01', '2024-05-31', 'inactive'),
(29, '2025-12-16 01:34:00', '2025-12-16 01:34:00', 'J-Q1 24-25', 'Junior High School Quarter 1', '2024 - 2025', '2024-06-01', '2024-08-15', 'inactive'),
(30, '2025-12-16 01:34:00', '2025-12-16 01:34:00', 'J-Q2 24-25', 'Junior High School Quarter 2', '2024 - 2025', '2024-08-16', '2024-10-31', 'inactive'),
(31, '2025-12-16 01:34:00', '2025-12-16 01:34:00', 'J-Q3 24-25', 'Junior High School Quarter 3', '2024 - 2025', '2024-11-01', '2025-01-15', 'inactive'),
(32, '2025-12-16 01:34:00', '2025-12-16 01:34:00', 'J-Q4 24-25', 'Junior High School Quarter 4', '2024 - 2025', '2025-01-16', '2025-03-31', 'inactive'),
(33, '2025-12-16 01:34:00', '2025-12-16 01:34:00', 'J-SUMMER 24-25', 'Junior High School Summer', '2024 - 2025', '2025-04-01', '2025-05-31', 'inactive'),
(34, '2025-12-16 01:34:00', '2025-12-16 01:34:00', '1st 23-24', 'Senior High School 1st Semester', '2023 - 2024', '2023-06-01', '2023-10-31', 'inactive'),
(35, '2025-12-16 01:34:00', '2025-12-16 01:34:00', '2nd 23-24', 'Senior High School 2nd Semester', '2023 - 2024', '2023-11-01', '2024-03-31', 'inactive'),
(36, '2025-12-16 01:34:00', '2025-12-16 01:34:00', 'SUMMER 23-24', 'Senior High School Summer', '2023 - 2024', '2024-04-01', '2024-05-31', 'inactive'),
(37, '2025-12-16 01:34:00', '2025-12-16 01:34:00', '1st 24-25', 'Senior High School 1st Semester', '2024 - 2025', '2024-06-01', '2024-10-31', 'inactive'),
(38, '2025-12-16 01:34:00', '2025-12-16 01:34:00', '2nd 24-25', 'Senior High School 2nd Semester', '2024 - 2025', '2024-11-01', '2025-03-31', 'inactive'),
(39, '2025-12-16 01:34:00', '2025-12-16 01:34:00', 'SUMMER 24-25', 'Senior High School Summer', '2024 - 2025', '2025-04-01', '2025-05-31', 'inactive');

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('e0gUfEoOtgy4u6jKOQ8zcyIAOsDOuemiZaJ9mlis', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiTmpUZklrOTNiTm1CRmxwWnM4a1pZV0VSMmUwbGlneHJGcVdiQnByWSI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6OTE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9yZWdpc3RyYXIvcHJvc3BlY3R1c2VzL3NlYXJjaD9hY2FkZW1pY195ZWFyPTIwMjUlMjAtJTIwMjAyNiZwcm9ncmFtPTEiO3M6NToicm91dGUiO3M6Mjc6InJlZ2lzdHJhci5wcm9zcGVjdHVzLnNlYXJjaCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1766024643);

-- --------------------------------------------------------

--
-- Table structure for table `subjects`
--

CREATE TABLE `subjects` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `code` text NOT NULL,
  `description` text NOT NULL,
  `unit` int(11) NOT NULL,
  `lech` int(11) NOT NULL,
  `lecu` int(11) NOT NULL,
  `labh` int(11) NOT NULL,
  `labu` int(11) NOT NULL,
  `type` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `subjects`
--

INSERT INTO `subjects` (`id`, `created_at`, `updated_at`, `code`, `description`, `unit`, `lech`, `lecu`, `labh`, `labu`, `type`, `status`) VALUES
(1, '2025-12-16 01:58:48', '2025-12-16 01:58:48', 'ENG-1', 'English 1', 5, 5, 5, 0, 0, 'lec', 'active'),
(2, '2025-12-16 01:58:48', '2025-12-16 01:58:48', 'FIL-1', 'Filipino 1', 5, 5, 5, 0, 0, 'lec', 'active'),
(3, '2025-12-16 01:58:48', '2025-12-16 01:58:48', 'MAT-1', 'Math 1', 5, 5, 5, 0, 0, 'lec', 'active'),
(4, '2025-12-16 01:58:48', '2025-12-16 01:58:48', 'SCI-1', 'Science 1', 5, 5, 5, 0, 0, 'lec', 'active'),
(5, '2025-12-16 01:58:48', '2025-12-16 01:58:48', 'ENG-2', 'English 2', 5, 5, 5, 0, 0, 'lec', 'active'),
(6, '2025-12-16 01:58:48', '2025-12-16 01:58:48', 'FIL-2', 'Filipino 2', 5, 5, 5, 0, 0, 'lec', 'active'),
(7, '2025-12-16 01:58:48', '2025-12-16 01:58:48', 'MAT-2', 'Math 2', 5, 5, 5, 0, 0, 'lec', 'active'),
(8, '2025-12-16 01:58:48', '2025-12-16 01:58:48', 'SCI-2', 'Science 2', 5, 5, 5, 0, 0, 'lec', 'active'),
(9, '2025-12-16 01:58:48', '2025-12-16 01:58:48', 'ENG-3', 'English 3', 5, 5, 5, 0, 0, 'lec', 'active'),
(10, '2025-12-16 01:58:48', '2025-12-16 01:58:48', 'FIL-3', 'Filipino 3', 5, 5, 5, 0, 0, 'lec', 'active'),
(11, '2025-12-16 01:58:48', '2025-12-16 01:58:48', 'MAT-3', 'Math 3', 5, 5, 5, 0, 0, 'lec', 'active'),
(12, '2025-12-16 01:58:48', '2025-12-16 01:58:48', 'SCI-3', 'Science 3', 5, 5, 5, 0, 0, 'lec', 'active'),
(13, '2025-12-16 01:58:48', '2025-12-16 01:58:48', 'ENG-4', 'English 4', 5, 5, 5, 0, 0, 'lec', 'active'),
(14, '2025-12-16 01:58:48', '2025-12-16 01:58:48', 'FIL-4', 'Filipino 4', 5, 5, 5, 0, 0, 'lec', 'active'),
(15, '2025-12-16 01:58:48', '2025-12-16 01:58:48', 'MAT-4', 'Math 4', 5, 5, 5, 0, 0, 'lec', 'active'),
(16, '2025-12-16 01:58:48', '2025-12-16 01:58:48', 'SCI-4', 'Science 4', 5, 5, 5, 0, 0, 'lec', 'active'),
(17, '2025-12-16 01:58:48', '2025-12-16 01:58:48', 'ENG-5', 'English 5', 5, 5, 5, 0, 0, 'lec', 'active'),
(18, '2025-12-16 01:58:48', '2025-12-16 01:58:48', 'FIL-5', 'Filipino 5', 5, 5, 5, 0, 0, 'lec', 'active'),
(19, '2025-12-16 01:58:48', '2025-12-16 01:58:48', 'MAT-5', 'Math 5', 5, 5, 5, 0, 0, 'lec', 'active'),
(20, '2025-12-16 01:58:48', '2025-12-16 01:58:48', 'SCI-5', 'Science 5', 5, 5, 5, 0, 0, 'lec', 'active'),
(21, '2025-12-16 01:58:48', '2025-12-16 01:58:48', 'ENG-6', 'English 6', 5, 5, 5, 0, 0, 'lec', 'active'),
(22, '2025-12-16 01:58:48', '2025-12-16 01:58:48', 'FIL-6', 'Filipino 6', 5, 5, 5, 0, 0, 'lec', 'active'),
(23, '2025-12-16 01:58:48', '2025-12-16 01:58:48', 'MAT-6', 'Math 6', 5, 5, 5, 0, 0, 'lec', 'active'),
(24, '2025-12-16 01:58:48', '2025-12-16 01:58:48', 'SCI-6', 'Science 6', 5, 5, 5, 0, 0, 'lec', 'active'),
(25, '2025-12-16 01:58:48', '2025-12-16 01:58:48', 'ENG-7', 'English 7', 5, 5, 5, 0, 0, 'lec', 'active'),
(26, '2025-12-16 01:58:48', '2025-12-16 01:58:48', 'FIL-7', 'Filipino 7', 5, 5, 5, 0, 0, 'lec', 'active'),
(27, '2025-12-16 01:58:48', '2025-12-16 01:58:48', 'MAT-7', 'Math 7', 5, 5, 5, 0, 0, 'lec', 'active'),
(28, '2025-12-16 01:58:48', '2025-12-16 01:58:48', 'SCI-7', 'Science 7', 5, 5, 5, 0, 0, 'lec', 'active'),
(29, '2025-12-16 01:58:48', '2025-12-16 01:58:48', 'ENG-8', 'English 8', 5, 5, 5, 0, 0, 'lec', 'active'),
(30, '2025-12-16 01:58:48', '2025-12-16 01:58:48', 'FIL-8', 'Filipino 8', 5, 5, 5, 0, 0, 'lec', 'active'),
(31, '2025-12-16 01:58:48', '2025-12-16 01:58:48', 'MAT-8', 'Math 8', 5, 5, 5, 0, 0, 'lec', 'active'),
(32, '2025-12-16 01:58:48', '2025-12-16 01:58:48', 'SCI-8', 'Science 8', 5, 5, 5, 0, 0, 'lec', 'active'),
(33, '2025-12-16 01:58:48', '2025-12-16 01:58:48', 'ENG-9', 'English 9', 5, 5, 5, 0, 0, 'lec', 'active'),
(34, '2025-12-16 01:58:48', '2025-12-16 01:58:48', 'FIL-9', 'Filipino 9', 5, 5, 5, 0, 0, 'lec', 'active'),
(35, '2025-12-16 01:58:48', '2025-12-16 01:58:48', 'MAT-9', 'Math 9', 5, 5, 5, 0, 0, 'lec', 'active'),
(36, '2025-12-16 01:58:48', '2025-12-16 01:58:48', 'SCI-9', 'Science 9', 5, 5, 5, 0, 0, 'lec', 'active'),
(37, '2025-12-16 01:58:48', '2025-12-16 01:58:48', 'ENG-10', 'English 10', 5, 5, 5, 0, 0, 'lec', 'active'),
(38, '2025-12-16 01:58:48', '2025-12-16 01:58:48', 'FIL-10', 'Filipino 10', 5, 5, 5, 0, 0, 'lec', 'active'),
(39, '2025-12-16 01:58:48', '2025-12-16 01:58:48', 'MAT-10', 'Math 10', 5, 5, 5, 0, 0, 'lec', 'active'),
(40, '2025-12-16 01:58:48', '2025-12-16 01:58:48', 'SCI-10', 'Science 10', 5, 5, 5, 0, 0, 'lec', 'active'),
(41, '2025-12-16 01:58:48', '2025-12-16 01:58:48', 'STE-Physics-11', 'Physics (STEM) 11', 3, 2, 2, 1, 1, 'lec lab', 'active'),
(42, '2025-12-16 01:58:48', '2025-12-16 01:58:48', 'STE-Chemistry-11', 'Chemistry (STEM) 11', 3, 2, 2, 1, 1, 'lec lab', 'active'),
(43, '2025-12-16 01:58:48', '2025-12-16 01:58:48', 'STE-Biology-11', 'Biology (STEM) 11', 3, 2, 2, 1, 1, 'lec lab', 'active'),
(44, '2025-12-16 01:58:48', '2025-12-16 01:58:48', 'STE-Calculus-11', 'Calculus (STEM) 11', 3, 2, 2, 1, 1, 'lec lab', 'active'),
(45, '2025-12-16 01:58:48', '2025-12-16 01:58:48', 'STE-Statistics-11', 'Statistics (STEM) 11', 3, 2, 2, 1, 1, 'lec lab', 'active'),
(46, '2025-12-16 01:58:48', '2025-12-16 01:58:48', 'ABM-Accounting-11', 'Accounting (ABM) 11', 3, 2, 2, 1, 1, 'lec lab', 'active'),
(47, '2025-12-16 01:58:48', '2025-12-16 01:58:48', 'ABM-Business Math-11', 'Business Math (ABM) 11', 3, 2, 2, 1, 1, 'lec lab', 'active'),
(48, '2025-12-16 01:58:48', '2025-12-16 01:58:48', 'ABM-Economics-11', 'Economics (ABM) 11', 3, 2, 2, 1, 1, 'lec lab', 'active'),
(49, '2025-12-16 01:58:48', '2025-12-16 01:58:48', 'ABM-Marketing-11', 'Marketing (ABM) 11', 3, 2, 2, 1, 1, 'lec lab', 'active'),
(50, '2025-12-16 01:58:48', '2025-12-16 01:58:48', 'ABM-Entrepreneurship-11', 'Entrepreneurship (ABM) 11', 3, 2, 2, 1, 1, 'lec lab', 'active'),
(51, '2025-12-16 01:58:48', '2025-12-16 01:58:48', 'HUM-Sociology-11', 'Sociology (HUMSS) 11', 3, 2, 2, 1, 1, 'lec lab', 'active'),
(52, '2025-12-16 01:58:48', '2025-12-16 01:58:48', 'HUM-Philosophy-11', 'Philosophy (HUMSS) 11', 3, 2, 2, 1, 1, 'lec lab', 'active'),
(53, '2025-12-16 01:58:48', '2025-12-16 01:58:48', 'HUM-Politics-11', 'Politics (HUMSS) 11', 3, 2, 2, 1, 1, 'lec lab', 'active'),
(54, '2025-12-16 01:58:48', '2025-12-16 01:58:48', 'HUM-Psychology-11', 'Psychology (HUMSS) 11', 3, 2, 2, 1, 1, 'lec lab', 'active'),
(55, '2025-12-16 01:58:48', '2025-12-16 01:58:48', 'HUM-Creative Writing-11', 'Creative Writing (HUMSS) 11', 3, 2, 2, 1, 1, 'lec lab', 'active'),
(56, '2025-12-16 01:58:48', '2025-12-16 01:58:48', 'GAS-Media Literacy-11', 'Media Literacy (GAS) 11', 3, 2, 2, 1, 1, 'lec lab', 'active'),
(57, '2025-12-16 01:58:48', '2025-12-16 01:58:48', 'GAS-Practical Research-11', 'Practical Research (GAS) 11', 3, 2, 2, 1, 1, 'lec lab', 'active'),
(58, '2025-12-16 01:58:48', '2025-12-16 01:58:48', 'GAS-ICT-11', 'ICT (GAS) 11', 3, 2, 2, 1, 1, 'lec lab', 'active'),
(59, '2025-12-16 01:58:48', '2025-12-16 01:58:48', 'GAS-PE-11', 'PE (GAS) 11', 3, 2, 2, 1, 1, 'lec lab', 'active'),
(60, '2025-12-16 01:58:48', '2025-12-16 01:58:48', 'GAS-Arts-11', 'Arts (GAS) 11', 3, 2, 2, 1, 1, 'lec lab', 'active'),
(61, '2025-12-16 01:58:48', '2025-12-16 01:58:48', 'STE-Physics-12', 'Physics (STEM) 12', 3, 2, 2, 1, 1, 'lec lab', 'active'),
(62, '2025-12-16 01:58:48', '2025-12-16 01:58:48', 'STE-Chemistry-12', 'Chemistry (STEM) 12', 3, 2, 2, 1, 1, 'lec lab', 'active'),
(63, '2025-12-16 01:58:48', '2025-12-16 01:58:48', 'STE-Biology-12', 'Biology (STEM) 12', 3, 2, 2, 1, 1, 'lec lab', 'active'),
(64, '2025-12-16 01:58:48', '2025-12-16 01:58:48', 'STE-Calculus-12', 'Calculus (STEM) 12', 3, 2, 2, 1, 1, 'lec lab', 'active'),
(65, '2025-12-16 01:58:48', '2025-12-16 01:58:48', 'STE-Statistics-12', 'Statistics (STEM) 12', 3, 2, 2, 1, 1, 'lec lab', 'active'),
(66, '2025-12-16 01:58:48', '2025-12-16 01:58:48', 'ABM-Accounting-12', 'Accounting (ABM) 12', 3, 2, 2, 1, 1, 'lec lab', 'active'),
(67, '2025-12-16 01:58:48', '2025-12-16 01:58:48', 'ABM-Business Math-12', 'Business Math (ABM) 12', 3, 2, 2, 1, 1, 'lec lab', 'active'),
(68, '2025-12-16 01:58:48', '2025-12-16 01:58:48', 'ABM-Economics-12', 'Economics (ABM) 12', 3, 2, 2, 1, 1, 'lec lab', 'active'),
(69, '2025-12-16 01:58:48', '2025-12-16 01:58:48', 'ABM-Marketing-12', 'Marketing (ABM) 12', 3, 2, 2, 1, 1, 'lec lab', 'active'),
(70, '2025-12-16 01:58:48', '2025-12-16 01:58:48', 'ABM-Entrepreneurship-12', 'Entrepreneurship (ABM) 12', 3, 2, 2, 1, 1, 'lec lab', 'active'),
(71, '2025-12-16 01:58:48', '2025-12-16 01:58:48', 'HUM-Sociology-12', 'Sociology (HUMSS) 12', 3, 2, 2, 1, 1, 'lec lab', 'active'),
(72, '2025-12-16 01:58:48', '2025-12-16 01:58:48', 'HUM-Philosophy-12', 'Philosophy (HUMSS) 12', 3, 2, 2, 1, 1, 'lec lab', 'active'),
(73, '2025-12-16 01:58:48', '2025-12-16 01:58:48', 'HUM-Politics-12', 'Politics (HUMSS) 12', 3, 2, 2, 1, 1, 'lec lab', 'active'),
(74, '2025-12-16 01:58:48', '2025-12-16 01:58:48', 'HUM-Psychology-12', 'Psychology (HUMSS) 12', 3, 2, 2, 1, 1, 'lec lab', 'active'),
(75, '2025-12-16 01:58:48', '2025-12-16 01:58:48', 'HUM-Creative Writing-12', 'Creative Writing (HUMSS) 12', 3, 2, 2, 1, 1, 'lec lab', 'active'),
(76, '2025-12-16 01:58:48', '2025-12-16 01:58:48', 'GAS-Media Literacy-12', 'Media Literacy (GAS) 12', 3, 2, 2, 1, 1, 'lec lab', 'active'),
(77, '2025-12-16 01:58:48', '2025-12-16 01:58:48', 'GAS-Practical Research-12', 'Practical Research (GAS) 12', 3, 2, 2, 1, 1, 'lec lab', 'active'),
(78, '2025-12-16 01:58:48', '2025-12-16 01:58:48', 'GAS-ICT-12', 'ICT (GAS) 12', 3, 2, 2, 1, 1, 'lec lab', 'active'),
(79, '2025-12-16 01:58:48', '2025-12-16 01:58:48', 'GAS-PE-12', 'PE (GAS) 12', 3, 2, 2, 1, 1, 'lec lab', 'active'),
(80, '2025-12-16 01:58:48', '2025-12-16 01:58:48', 'GAS-Arts-12', 'Arts (GAS) 12', 3, 2, 2, 1, 1, 'lec lab', 'active');

-- --------------------------------------------------------

--
-- Table structure for table `users`
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
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Registrar', 'registrar@gmail.com', '2025-12-16 01:06:46', '$2y$12$U6YgbKbq5xFnuXL7c/xiiuv30dwTNICxh7Jh9LqcUzjPQCGQA.mIa', 'CoTAsPwHHt7c344eoyMPMY2eFX3XGhylZ62QbdCi3N5i6N65DZ1aDhuIMqR9', '2025-12-16 01:06:46', '2025-12-16 01:06:46'),
(2, 'Accounting', 'accounting@gmail.com', '2025-12-16 01:06:47', '$2y$12$0AWwMqjz03P8kaqIkjoTY.xtXaN7qi0KP.kyIGSCC7gQ.FOXGWUwm', NULL, '2025-12-16 01:06:47', '2025-12-16 01:06:47');

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
-- Indexes for table `curricula`
--
ALTER TABLE `curricula`
  ADD PRIMARY KEY (`id`),
  ADD KEY `curricula_program_id_foreign` (`program_id`);

--
-- Indexes for table `departments`
--
ALTER TABLE `departments`
  ADD PRIMARY KEY (`id`);

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
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `programs`
--
ALTER TABLE `programs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `programs_department_id_foreign` (`department_id`);

--
-- Indexes for table `prospectuses`
--
ALTER TABLE `prospectuses`
  ADD PRIMARY KEY (`id`),
  ADD KEY `prospectuses_curriculum_id_foreign` (`curriculum_id`),
  ADD KEY `prospectuses_semester_id_foreign` (`semester_id`),
  ADD KEY `prospectuses_subject_id_foreign` (`subject_id`);

--
-- Indexes for table `semesters`
--
ALTER TABLE `semesters`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `subjects`
--
ALTER TABLE `subjects`
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
-- AUTO_INCREMENT for table `curricula`
--
ALTER TABLE `curricula`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=55;

--
-- AUTO_INCREMENT for table `departments`
--
ALTER TABLE `departments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `programs`
--
ALTER TABLE `programs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `prospectuses`
--
ALTER TABLE `prospectuses`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `semesters`
--
ALTER TABLE `semesters`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT for table `subjects`
--
ALTER TABLE `subjects`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=82;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `curricula`
--
ALTER TABLE `curricula`
  ADD CONSTRAINT `curricula_program_id_foreign` FOREIGN KEY (`program_id`) REFERENCES `programs` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `programs`
--
ALTER TABLE `programs`
  ADD CONSTRAINT `programs_department_id_foreign` FOREIGN KEY (`department_id`) REFERENCES `departments` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `prospectuses`
--
ALTER TABLE `prospectuses`
  ADD CONSTRAINT `prospectuses_curriculum_id_foreign` FOREIGN KEY (`curriculum_id`) REFERENCES `curricula` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `prospectuses_semester_id_foreign` FOREIGN KEY (`semester_id`) REFERENCES `semesters` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `prospectuses_subject_id_foreign` FOREIGN KEY (`subject_id`) REFERENCES `subjects` (`id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
