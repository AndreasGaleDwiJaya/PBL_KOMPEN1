-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Nov 19, 2024 at 03:17 PM
-- Server version: 8.0.30
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `pbl_kompen`
--

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
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_reset_tokens_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(5, '2024_11_19_051131_create_m_level_table,php', 1),
(6, '2024_11_19_051413_create_m_usermahasiswa_table', 1),
(7, '2024_11_19_051445_create_m_bidangkompetensi_table,php', 1),
(8, '2024_11_19_051536_create_m_useradt_table,php', 1),
(9, '2024_11_19_051809_create_m_daftarmahasiswaalpha_table', 1),
(10, '2024_11_19_120609_create_m_daftarmhsalpha_table', 2),
(12, '2024_11_19_120626_create_m_daftarmhskompen_table', 3);

-- --------------------------------------------------------

--
-- Table structure for table `m_bidangkompetensi`
--

CREATE TABLE `m_bidangkompetensi` (
  `bidkom_id` bigint UNSIGNED NOT NULL,
  `nama_bidkom` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `m_bidangkompetensi`
--

INSERT INTO `m_bidangkompetensi` (`bidkom_id`, `nama_bidkom`, `created_at`, `updated_at`) VALUES
(1, 'Programming', NULL, NULL),
(2, 'Analisis', NULL, NULL),
(3, 'UI/UX Designn', NULL, '2024-11-19 00:42:49');

-- --------------------------------------------------------

--
-- Table structure for table `m_daftarmhsalpha`
--

CREATE TABLE `m_daftarmhsalpha` (
  `daftarmhsalpha_id` bigint UNSIGNED NOT NULL,
  `mahasiswa_id` bigint UNSIGNED NOT NULL,
  `jumlah_jamalpha` int NOT NULL,
  `periode` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `prodi` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `m_daftarmhsalpha`
--

INSERT INTO `m_daftarmhsalpha` (`daftarmhsalpha_id`, `mahasiswa_id`, `jumlah_jamalpha`, `periode`, `prodi`, `created_at`, `updated_at`) VALUES
(1, 1, 23, 'Ganjil-2024', 'Sistem Informasi Bisnis', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `m_daftarmhskompen`
--

CREATE TABLE `m_daftarmhskompen` (
  `daftarmhskompen_id` bigint UNSIGNED NOT NULL,
  `daftarmhsalpha_id` bigint UNSIGNED NOT NULL,
  `jumlah_jam_telah_dikerjakan` int NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `m_daftarmhskompen`
--

INSERT INTO `m_daftarmhskompen` (`daftarmhskompen_id`, `daftarmhsalpha_id`, `jumlah_jam_telah_dikerjakan`, `created_at`, `updated_at`) VALUES
(1, 1, 15, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `m_level`
--

CREATE TABLE `m_level` (
  `level_id` bigint UNSIGNED NOT NULL,
  `level_kode` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `level_nama` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `m_level`
--

INSERT INTO `m_level` (`level_id`, `level_kode`, `level_nama`, `created_at`, `updated_at`) VALUES
(1, 'ADM', 'Administrator', NULL, NULL),
(2, 'MHS', 'Mahasiswa', NULL, NULL),
(3, 'DSN', 'Dosen', NULL, NULL),
(4, 'TNK', 'Tendik', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `m_useradt`
--

CREATE TABLE `m_useradt` (
  `adt_id` bigint UNSIGNED NOT NULL,
  `level_id` bigint UNSIGNED NOT NULL,
  `username` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nip` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `avatar` varchar(1000) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `m_useradt`
--

INSERT INTO `m_useradt` (`adt_id`, `level_id`, `username`, `nama`, `password`, `nip`, `avatar`, `email`, `created_at`, `updated_at`) VALUES
(1, 1, 'admin', 'Kadek Suarjana', '$2y$12$0d82b8HC1NgxPXDIrk.TfOEefwCdz83IcauGS/cgLwbdFe0HISScC', '1245678499', '', 'kadeksuwarjana@gmail.com', NULL, NULL),
(2, 3, 'dosen', 'Moch Zawaruddin', '$2y$12$VL.RU62Mpejj1a8gQyY9xO.6cGPLzW4A134ePXdCNea4NXtsRqwke', '1245678499', '', 'zawaruddin@gmail.com', NULL, NULL),
(3, 4, 'tendik', 'Supriyatno', '$2y$12$epbPfoVfa24G5KsumpkYluj.5nwUZ.vhbxFeFzklO7QI7r.4AFA22', '1245678499', '', 'supriyatno@gmail.com', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `m_usermahasiswa`
--

CREATE TABLE `m_usermahasiswa` (
  `mahasiswa_id` bigint UNSIGNED NOT NULL,
  `level_id` bigint UNSIGNED NOT NULL,
  `username` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nim` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `avatar` varchar(1000) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `m_usermahasiswa`
--

INSERT INTO `m_usermahasiswa` (`mahasiswa_id`, `level_id`, `username`, `nama`, `password`, `nim`, `avatar`, `email`, `created_at`, `updated_at`) VALUES
(1, 2, 'mahasiswa', 'Andreas Gale Dwi Jaya', '$2y$12$7fpEXd4uGVLXRHC6v2tCA.CsaM0y2p/z9sa4EYnEMEKO4WBdvQRPi', '2241760033', '', 'andreasgaledwijaya@gmail.com', NULL, NULL);

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
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
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
  `role` enum('admin','dosen','tendik','mahasiswa') COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('verify','active','banned') COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `m_bidangkompetensi`
--
ALTER TABLE `m_bidangkompetensi`
  ADD PRIMARY KEY (`bidkom_id`);

--
-- Indexes for table `m_daftarmhsalpha`
--
ALTER TABLE `m_daftarmhsalpha`
  ADD PRIMARY KEY (`daftarmhsalpha_id`),
  ADD KEY `m_daftarmhsalpha_mahasiswa_id_foreign` (`mahasiswa_id`);

--
-- Indexes for table `m_daftarmhskompen`
--
ALTER TABLE `m_daftarmhskompen`
  ADD PRIMARY KEY (`daftarmhskompen_id`),
  ADD KEY `m_daftarmhskompen_daftarmhsalpha_id_foreign` (`daftarmhsalpha_id`);

--
-- Indexes for table `m_level`
--
ALTER TABLE `m_level`
  ADD PRIMARY KEY (`level_id`),
  ADD UNIQUE KEY `m_level_level_kode_unique` (`level_kode`);

--
-- Indexes for table `m_useradt`
--
ALTER TABLE `m_useradt`
  ADD PRIMARY KEY (`adt_id`),
  ADD UNIQUE KEY `m_useradt_username_unique` (`username`),
  ADD KEY `m_useradt_level_id_index` (`level_id`);

--
-- Indexes for table `m_usermahasiswa`
--
ALTER TABLE `m_usermahasiswa`
  ADD PRIMARY KEY (`mahasiswa_id`),
  ADD UNIQUE KEY `m_usermahasiswa_username_unique` (`username`),
  ADD KEY `m_usermahasiswa_level_id_index` (`level_id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

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
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `m_bidangkompetensi`
--
ALTER TABLE `m_bidangkompetensi`
  MODIFY `bidkom_id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `m_daftarmhsalpha`
--
ALTER TABLE `m_daftarmhsalpha`
  MODIFY `daftarmhsalpha_id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `m_daftarmhskompen`
--
ALTER TABLE `m_daftarmhskompen`
  MODIFY `daftarmhskompen_id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `m_level`
--
ALTER TABLE `m_level`
  MODIFY `level_id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `m_useradt`
--
ALTER TABLE `m_useradt`
  MODIFY `adt_id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `m_usermahasiswa`
--
ALTER TABLE `m_usermahasiswa`
  MODIFY `mahasiswa_id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `m_daftarmhsalpha`
--
ALTER TABLE `m_daftarmhsalpha`
  ADD CONSTRAINT `m_daftarmhsalpha_mahasiswa_id_foreign` FOREIGN KEY (`mahasiswa_id`) REFERENCES `m_usermahasiswa` (`mahasiswa_id`);

--
-- Constraints for table `m_daftarmhskompen`
--
ALTER TABLE `m_daftarmhskompen`
  ADD CONSTRAINT `m_daftarmhskompen_daftarmhsalpha_id_foreign` FOREIGN KEY (`daftarmhsalpha_id`) REFERENCES `m_daftarmhsalpha` (`daftarmhsalpha_id`);

--
-- Constraints for table `m_useradt`
--
ALTER TABLE `m_useradt`
  ADD CONSTRAINT `m_useradt_level_id_foreign` FOREIGN KEY (`level_id`) REFERENCES `m_level` (`level_id`);

--
-- Constraints for table `m_usermahasiswa`
--
ALTER TABLE `m_usermahasiswa`
  ADD CONSTRAINT `m_usermahasiswa_level_id_foreign` FOREIGN KEY (`level_id`) REFERENCES `m_level` (`level_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
