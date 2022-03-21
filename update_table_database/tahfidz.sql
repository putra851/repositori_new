-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 21, 2022 at 02:50 AM
-- Server version: 10.4.22-MariaDB
-- PHP Version: 8.0.15

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `epesantr_baqu`
--

-- --------------------------------------------------------

--
-- Table structure for table `tahfidz`
--

CREATE TABLE `tahfidz` (
  `tahfidz_id` int(11) NOT NULL,
  `tahfidz_period_id` int(11) NOT NULL,
  `tahfidz_student_id` int(11) NOT NULL,
  `tahfidz_date` date DEFAULT NULL,
  `tahfidz_new` text DEFAULT NULL,
  `tahfidz_ziyadah` text DEFAULT NULL,
  `tahfidz_tarir` text DEFAULT NULL,
  `tahfidz_arbaun` text DEFAULT NULL,
  `tahfidz_user_id` int(11) NOT NULL,
  `tahfidz_input_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `tahfidz_last_update` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tahfidz`
--

INSERT INTO `tahfidz` (`tahfidz_id`, `tahfidz_period_id`, `tahfidz_student_id`, `tahfidz_date`, `tahfidz_new`, `tahfidz_ziyadah`, `tahfidz_tarir`, `tahfidz_arbaun`, `tahfidz_user_id`, `tahfidz_input_date`, `tahfidz_last_update`) VALUES
(1, 1, 92, '2022-03-08', '1', 'Umi Yuhana', 'Umi Yuhana', 'Umi Yuhana', 32, '2022-03-08 12:45:20', '2022-03-08 12:45:20'),
(2, 1, 11, '2022-03-08', '3', 'Umi Yuhana', 'Umi Yuhana', 'Umi Yuhana', 32, '2022-03-08 12:46:25', '2022-03-08 12:46:25'),
(3, 1, 14, '2022-03-08', '1', 'Umi Yuhana', 'Umi Yuhana', 'Umi Yuhana', 32, '2022-03-08 12:46:56', '2022-03-08 12:46:56'),
(4, 1, 16, '2022-03-08', '2', 'Umi Yuhana', 'Umi Yuhana', 'Umi Yuhana', 32, '2022-03-08 12:47:25', '2022-03-08 12:47:25'),
(5, 1, 62, '2022-03-08', '1', 'Umi Yuhana', 'Umi Yuhana', 'Umi Yuhana', 32, '2022-03-08 12:48:19', '2022-03-08 12:48:19'),
(6, 1, 96, '2022-03-08', '5', 'Umi Yuhana', 'Umi Yuhana', 'Umi Yuhana', 32, '2022-03-08 12:49:06', '2022-03-08 12:49:06'),
(7, 1, 106, '2022-03-08', '2', 'Umi Yuhana', 'Umi Yuhana', 'Umi Yuhana', 32, '2022-03-08 12:49:58', '2022-03-08 12:49:58'),
(8, 1, 18, '2022-03-08', '1', 'Umi Yuhana', 'Umi Yuhana', 'Umi Yuhana', 32, '2022-03-08 12:50:29', '2022-03-08 12:50:29'),
(9, 1, 103, '2022-03-09', '10', 'Umi Yuhana', 'Umi Yuhana', 'Umi Yuhana', 32, '2022-03-09 15:42:47', '2022-03-09 15:42:47'),
(10, 1, 11, '2022-03-09', '10', 'Umi Yuhana', 'Umi Yuhana', 'Umi Yuhana', 32, '2022-03-09 15:43:22', '2022-03-09 15:43:22'),
(11, 1, 15, '2022-03-10', '2', 'Umi Yuhana', 'Umi Yuhana', 'Umi Yuhana', 32, '2022-03-11 01:12:33', '2022-03-11 01:12:33'),
(12, 1, 106, '2022-03-10', '2', 'Umi Yuhana', 'Umi Yuhana', 'Umi Yuhana', 32, '2022-03-11 01:13:01', '2022-03-11 01:13:01'),
(13, 1, 99, '2022-03-10', '2', 'Umi Yuhana', 'Umi Yuhana', 'Umi Yuhana', 32, '2022-03-11 01:13:28', '2022-03-11 01:13:28'),
(14, 1, 11, '2022-03-10', '10', 'Umi Yuhana', 'Umi Yuhana', 'Umi Yuhana', 32, '2022-03-11 01:15:26', '2022-03-11 01:15:26'),
(15, 1, 103, '2022-03-10', '10', 'Umi Yuhana', 'Umi Yuhana', 'Umi Yuhana', 32, '2022-03-11 01:15:57', '2022-03-11 01:15:57'),
(16, 1, 16, '2022-03-10', '2', 'Umi Yuhana', 'Umi Yuhana', 'Umi Yuhana', 32, '2022-03-11 04:31:44', '2022-03-11 04:31:44'),
(17, 1, 101, '2022-03-10', '2', 'Umi Yuhana', 'Umi Yuhana', 'Umi Yuhana', 32, '2022-03-11 04:32:40', '2022-03-11 04:32:40'),
(18, 1, 9, '2022-03-10', '5', 'Umi Yuhana', 'Umi Yuhana', 'Umi Yuhana', 32, '2022-03-11 04:34:43', '2022-03-11 04:34:43'),
(19, 1, 112, '2022-03-14', '5', 'Ali-Imron', 'Al-Baqarah', 'Al-kahf', 28, '2022-03-14 02:58:05', '2022-03-14 02:58:05');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tahfidz`
--
ALTER TABLE `tahfidz`
  ADD PRIMARY KEY (`tahfidz_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tahfidz`
--
ALTER TABLE `tahfidz`
  MODIFY `tahfidz_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
