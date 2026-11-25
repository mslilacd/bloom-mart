-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 22, 2026 at 04:19 PM
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
-- Database: `bloom_mart`
--

-- --------------------------------------------------------

--
-- Table structure for table `attendance`
--

CREATE TABLE `attendance` (
  `attendance_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `attendance_date` date DEFAULT NULL,
  `time_in` time DEFAULT NULL,
  `time_out` time DEFAULT NULL,
  `total_hours` decimal(5,2) DEFAULT 0.00
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `attendance`
--

INSERT INTO `attendance` (`attendance_id`, `user_id`, `attendance_date`, `time_in`, `time_out`, `total_hours`) VALUES
(2, 2, '2026-07-18', '02:47:09', '02:48:21', 0.02),
(3, 3, '2026-07-18', '08:00:00', NULL, 0.00),
(4, 3, '2026-07-22', '13:32:44', '14:09:53', 0.62),
(5, 3, '2026-07-21', '13:00:00', NULL, 0.00),
(6, 6, '2026-07-22', '04:12:07', '04:21:49', 0.16),
(7, 7, '2026-07-22', '06:35:01', '06:35:06', 0.00),
(8, 8, '2026-07-22', '10:00:00', NULL, 0.00),
(9, 8, '2026-07-23', '10:25:37', '10:26:17', 0.01),
(10, 8, '2026-07-21', '10:27:00', NULL, 0.00),
(11, 9, '2026-07-23', '13:50:05', NULL, 0.00),
(12, 3, '2026-07-23', '15:11:00', '15:12:17', 0.02),
(13, 12, '2026-07-23', '15:31:37', '15:31:45', 0.00),
(14, 12, '2026-07-22', '10:31:00', NULL, 0.00),
(15, 13, '2026-07-23', '22:42:10', '22:43:41', 0.03),
(16, 14, '2026-07-24', '04:04:24', '04:04:37', 0.00),
(17, 15, '2026-07-24', '11:35:46', '11:40:13', 0.07),
(18, 15, '2026-07-23', '12:36:00', NULL, 0.00);

-- --------------------------------------------------------

--
-- Table structure for table `attendance_verifications`
--

CREATE TABLE `attendance_verifications` (
  `verification_id` int(11) NOT NULL,
  `attendance_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `request_type` enum('time_in','time_out') NOT NULL,
  `requested_time` time NOT NULL,
  `reason` varchar(255) NOT NULL,
  `status` enum('pending','approved','rejected') NOT NULL DEFAULT 'pending',
  `admin_remark` varchar(255) DEFAULT NULL,
  `requested_at` datetime NOT NULL DEFAULT current_timestamp(),
  `reviewed_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `attendance_verifications`
--

INSERT INTO `attendance_verifications` (`verification_id`, `attendance_id`, `user_id`, `request_type`, `requested_time`, `reason`, `status`, `admin_remark`, `requested_at`, `reviewed_at`) VALUES
(1, 3, 3, 'time_in', '08:00:00', 'network problem', 'approved', 'Duly Noted. Approved by: Supervisor', '2026-07-18 04:27:33', '2026-07-18 04:43:08'),
(2, 5, 3, 'time_in', '13:00:00', 'Forgot to time in due to rushing', 'approved', 'Approved by Admin', '2026-07-22 13:34:05', '2026-07-22 14:09:25'),
(3, 8, 8, 'time_in', '10:00:00', 'Forgot to Time in', 'approved', 'Approved by Admin', '2026-07-23 06:59:38', '2026-07-23 07:00:13'),
(4, 10, 8, 'time_in', '10:27:00', 'sick and tired and sleepy', 'approved', 'Approved by Admin', '2026-07-23 10:28:49', '2026-07-23 10:30:48'),
(5, 12, 3, 'time_in', '15:11:00', 'hiiiiiiiiii penat', 'approved', 'Approved by Admin', '2026-07-23 15:11:39', '2026-07-23 15:21:17'),
(6, 14, 12, 'time_in', '10:31:00', 'Forgot to Time in', 'approved', 'Approved by Admin', '2026-07-23 15:32:36', '2026-07-23 15:33:17'),
(7, 18, 15, 'time_in', '12:36:00', 'forgot to time in', 'approved', 'Approved by Admin', '2026-07-24 11:36:59', '2026-07-24 11:39:47');

-- --------------------------------------------------------

--
-- Table structure for table `schedules`
--

CREATE TABLE `schedules` (
  `schedule_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `schedule_date` date NOT NULL,
  `shift` varchar(50) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `start_time` time DEFAULT NULL,
  `end_time` time DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `schedules`
--

INSERT INTO `schedules` (`schedule_id`, `user_id`, `schedule_date`, `shift`, `description`, `start_time`, `end_time`) VALUES
(6, 8, '2026-07-24', 'Afternoon', 'All Day Cashier', '08:00:00', '22:00:00'),
(8, 12, '2026-07-25', 'Morning', 'Morning Cashier', '08:30:00', '10:30:00'),
(9, 13, '2026-07-27', 'Afternoon', NULL, '10:40:00', '14:40:00'),
(10, 5, '2026-07-24', 'Full Day', 'All Day Cashier', '08:00:00', '22:30:00'),
(11, 14, '2026-07-24', 'Full Day', 'unpacking new items', '08:33:00', '22:00:00'),
(12, 15, '2026-07-24', 'Morning', 'Cashier', '08:00:00', '14:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `ic_number` varchar(20) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `role` enum('admin','assistant') NOT NULL,
  `password` varchar(255) NOT NULL,
  `status` enum('active','inactive') DEFAULT 'active',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `type` varchar(50) NOT NULL DEFAULT 'Full-Time',
  `start_date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `name`, `ic_number`, `email`, `phone`, `role`, `password`, `status`, `created_at`, `type`, `start_date`) VALUES
(1, 'Admin Bloom', '000000000000', 'admin@bloom.com', '+60123456789', 'admin', '0e7517141fb53f21ee439b355b5a1d0a', 'active', '2026-07-05 07:08:36', 'Full-Time', NULL),
(2, 'ALIA NABILAH', '040904060126', 'bella@bloom.com', '01111555093', 'assistant', '8a5c81d64eadf256b052d9aa9146fd6c', 'active', '2026-07-05 08:16:14', 'Full-Time', NULL),
(3, 'NUZUL IQKHWAN BIN ABDUL RAHMAN', '010203040506', 'nuzul@bloom.com', '+60135936411', 'assistant', '97e7f2612ea21c71c764069e1264ad59', 'active', '2026-07-17 19:21:58', 'Full-Time', '2026-07-18'),
(5, 'AIZATUL SHARMILAH BINTI JAMALUDIN', '051010120200', 'aiza@bloom.com', NULL, 'assistant', '$2y$12$ijaduwKN6n9jFvRos..2V.RJKC3B52SdwCiTjuJHhWfixn.TbPrrS', 'active', '2026-07-22 08:07:02', 'Full-Time', NULL),
(6, 'aiza', '050505120303', 'yaa@bloom.com', NULL, 'assistant', '$2y$12$Ncy5BCPGNjwpW9NQ8SlF6OBW6pJN5LURXUun/TcDFrwETr7tc7aQO', 'inactive', '2026-07-22 08:08:53', 'Full-Time', NULL),
(7, 'NICOLE MARSHA', '010203120304', 'nicole@bloom.com', '01126278834', 'assistant', 'e10adc3949ba59abbe56e057f20f883e', 'inactive', '2026-07-22 20:03:05', 'Full-Time', '2026-07-22'),
(8, 'AIZATUL SHAKIRAH BINTI JAMALUDIN', '010203120300', 'kira@bloom.com', '0112839485', 'assistant', 'e10adc3949ba59abbe56e057f20f883e', 'active', '2026-07-22 22:57:15', 'Full-Time', '2026-07-23'),
(9, 'AIZATUL SHAFIQAH BINTI JAMALUDIN', '0405031204050', 'aizatul@bloom.com', '01163847625', 'assistant', '$2y$12$Kn5T7dMmFXhIu.k8RPcCfeZqiQax90BpOmt0g7UzpefE8f.qWjkwq', 'active', '2026-07-23 02:50:33', 'Full-Time', '2026-07-22'),
(10, 'ASNA DINI', '0703231203055', 'asna@bloom.com', '0112789463', 'assistant', '$2y$12$alncokNQlzLbYOahhx/0UO7wKCJtjjlSRQDKCUKO8yjB4Ak4owbcK', 'inactive', '2026-07-23 03:30:47', 'Full-Time', '2026-07-25'),
(11, 'balqis humaira', '050111101212', 'bael@bloom.com', '0183875672', 'assistant', '$2y$12$s6OmAqJiPcw/dRROZExpjum.eSist24Y7cLXxhLyYH9/8ntorAj72', 'inactive', '2026-07-23 07:13:46', 'Full-Time', '2026-07-23'),
(12, 'John Doe', '01126784759', 'john@bloom.com', '01127653849', 'assistant', '$2y$12$HodvawMQDF9GFY8q5zbGGepddVj9yF7zw2Bs4QRSslXjhsxTP2y06', 'inactive', '2026-07-23 07:28:15', 'Full-Time', '2026-07-24'),
(13, 'NADIN', '0923040300', 'nadin@bloom.com', '01127384467', 'assistant', '$2y$12$vXjK5oaEmI3DH3E2zjrwKeYANd5dDmAYSpqniqggX7b5yilE87NzS', 'active', '2026-07-23 14:39:10', 'Full-Time', '2026-07-25'),
(14, 'Layla', '010312120400', 'layla@bloom.com', '0112784958', 'assistant', '$2y$12$mdlIA5g7yIYqBAy3JM8e4ufe9C/C885cILaVaq0sgPbysvg/LsYLG', 'active', '2026-07-23 19:32:36', 'Full-Time', '2026-07-24'),
(15, 'SOFEA AMALYN', '0102638767', 'sofea@bloom.com', '01165786654', 'assistant', '$2y$12$.hX4vi5W3vHrWtnTKTN4BOaD1N.scQMwyyuusUCfxXP14i3P9ipC6', 'active', '2026-07-24 03:24:53', 'Full-Time', '2026-07-24');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `attendance`
--
ALTER TABLE `attendance`
  ADD PRIMARY KEY (`attendance_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `attendance_verifications`
--
ALTER TABLE `attendance_verifications`
  ADD PRIMARY KEY (`verification_id`),
  ADD KEY `fk_verification_attendance` (`attendance_id`),
  ADD KEY `fk_verification_user` (`user_id`);

--
-- Indexes for table `schedules`
--
ALTER TABLE `schedules`
  ADD PRIMARY KEY (`schedule_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `ic_number` (`ic_number`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `attendance`
--
ALTER TABLE `attendance`
  MODIFY `attendance_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `attendance_verifications`
--
ALTER TABLE `attendance_verifications`
  MODIFY `verification_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `schedules`
--
ALTER TABLE `schedules`
  MODIFY `schedule_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `attendance`
--
ALTER TABLE `attendance`
  ADD CONSTRAINT `attendance_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `attendance_verifications`
--
ALTER TABLE `attendance_verifications`
  ADD CONSTRAINT `fk_verification_attendance` FOREIGN KEY (`attendance_id`) REFERENCES `attendance` (`attendance_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_verification_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE;

--
-- Constraints for table `schedules`
--
ALTER TABLE `schedules`
  ADD CONSTRAINT `schedules_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
