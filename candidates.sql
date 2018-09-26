-- phpMyAdmin SQL Dump
-- version 4.8.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 24, 2018 at 12:15 PM
-- Server version: 10.1.34-MariaDB
-- PHP Version: 7.2.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `cona_dbase`
--

-- --------------------------------------------------------

--
-- Table structure for table `candidates`
--

CREATE TABLE `candidates` (
  `id` int(10) UNSIGNED NOT NULL,
  `firstname` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `middlename` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `lastname` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `birthdate` date NOT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `landline` varchar(15) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mobile` varchar(15) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `candidate_for` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `incumbent` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sma` text COLLATE utf8mb4_unicode_ci,
  `province_id` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `district_id` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `city_id` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `signed_by_lp` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cos_id` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `candidates`
--

INSERT INTO `candidates` (`id`, `firstname`, `middlename`, `lastname`, `birthdate`, `address`, `email`, `landline`, `mobile`, `candidate_for`, `incumbent`, `sma`, `province_id`, `district_id`, `city_id`, `signed_by_lp`, `cos_id`, `created_at`, `updated_at`) VALUES
(9, 'Rey', 'Jonas', 'Curimatmat', '1918-05-02', '40-60 Rainbow drive, Goodwill, Sucat', 'reyjonas.curimatmat@bcdpinpoint.com', '09433390649', '9433390649', 'City Mayor', NULL, '{\"facebook\":null,\"twitter\":null,\"instagram\":null,\"website\":null}', '0712', NULL, 'TAGBILARAN CITY', NULL, '1537341784', '2018-09-18 23:23:04', '2018-09-18 23:23:04'),
(11, 'Rey', 'Jonas', 'Curimatmat', '1918-05-02', '40-60 Rainbow drive, Goodwill, Sucat', 'reyjonas.curimatmat12@bcdpinpoint.com', '09433390649', '9433390649', 'Vice Governor', NULL, '{\"facebook\":null,\"twitter\":null,\"instagram\":null,\"website\":null}', '0129', NULL, 'VIGAN CITY', '1', '1537341784', '2018-09-18 23:23:04', '2018-09-18 23:23:04'),
(13, 'Heywazzap', 'Jonas', 'Doney', '1918-05-02', '40-60 Rainbow drive, Goodwill, Sucat', 'reyjonas.curimatmat12312@bcdpinpoint.com', '09433390649', '9433390649', 'Vice Governor', NULL, '{\"facebook\":null,\"twitter\":null,\"instagram\":null,\"website\":null}', '0231', NULL, 'CAUAYAN CITY', '1', '1537341784', '2018-09-18 23:23:04', '2018-09-18 23:23:04'),
(14, 'Vince', 'Ginoo', 'Recto', '1918-05-02', '40-60 Rainbow drive, Goodwill, Sucat', 'VinceLuis.Recto@bcdpinpoint.com', '09433390649', '9433390649', 'City Councilor', NULL, '{\"facebook\":null,\"twitter\":null,\"instagram\":null,\"website\":null}', '1374-06', 'District 1', 'MANILA CITY', '2', '1537341784', '2018-09-18 23:23:04', '2018-09-18 23:23:04'),
(15, 'Xandy', 'Pata', 'Liit', '1918-05-02', '40-60 Rainbow drive, Goodwill, Sucat', 'suandy@bcdpinpoint.com', '09433390649', '9433390649', 'City Councilor', NULL, '{\"facebook\":null,\"twitter\":null,\"instagram\":null,\"website\":null}', '1602-01', '', 'BUTUAN CITY', '1', '1537341784', '2018-09-18 23:23:04', '2018-09-18 23:23:04');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `candidates`
--
ALTER TABLE `candidates`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `candidates_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `candidates`
--
ALTER TABLE `candidates`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
