-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 12, 2025 at 04:33 PM
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
-- Database: `greenlife`
--

-- --------------------------------------------------------

--
-- Table structure for table `bookings`
--

CREATE TABLE `bookings` (
  `id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `therapist_id` int(11) NOT NULL,
  `service` varchar(100) NOT NULL,
  `booking_date` date NOT NULL,
  `booking_time` time NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `bookings`
--

INSERT INTO `bookings` (`id`, `customer_id`, `therapist_id`, `service`, `booking_date`, `booking_time`, `created_at`) VALUES
(5, 10, 1, 'Ayurveda', '2025-09-08', '14:00:00', '2025-09-07 14:22:15'),
(43, 10, 4, 'Physiotherapy', '2025-09-24', '15:00:00', '2025-09-08 11:44:56'),
(45, 10, 2, 'Yoga', '2025-09-28', '09:00:00', '2025-09-08 11:55:13'),
(48, 10, 3, 'Nutrition', '2025-09-17', '11:00:00', '2025-09-08 12:06:22'),
(49, 10, 3, 'Yoga', '2025-10-03', '09:00:00', '2025-09-12 00:44:15'),
(50, 10, 3, 'Yoga', '2025-10-07', '09:00:00', '2025-09-12 10:06:51'),
(51, 10, 5, 'Physiotherapy', '2025-10-01', '14:00:00', '2025-09-12 14:22:47');

-- --------------------------------------------------------

--
-- Table structure for table `inquiries`
--

CREATE TABLE `inquiries` (
  `id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `type` varchar(50) NOT NULL,
  `subject` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `response` text DEFAULT NULL,
  `status` enum('pending','answered') DEFAULT 'pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `responded_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `inquiries`
--

INSERT INTO `inquiries` (`id`, `customer_id`, `type`, `subject`, `message`, `response`, `status`, `created_at`, `responded_at`) VALUES
(14, 10, 'ayurveda', 'Test', 'Tes12345', NULL, 'pending', '2025-09-12 07:04:07', NULL),
(15, 10, 'yoga', 'Test 123', 'Test 123123', 'done', 'answered', '2025-09-12 07:04:41', '2025-09-12 10:48:17'),
(16, 10, 'ayurveda', 'Test Subject', 'Test Message', NULL, 'pending', '2025-09-12 10:35:07', NULL),
(17, 10, 'yoga', 'Need Direct therapist contact number', 'Test', 'Yes Please you may concat this number anytime - 0750353808', 'answered', '2025-09-12 14:23:43', '2025-09-12 14:26:49');

-- --------------------------------------------------------

--
-- Table structure for table `programmes`
--

CREATE TABLE `programmes` (
  `id` int(11) NOT NULL,
  `programme_name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `programmes`
--

INSERT INTO `programmes` (`id`, `programme_name`) VALUES
(1, 'Programme 1'),
(2, 'Programme 2'),
(3, 'Programme 3');

-- --------------------------------------------------------

--
-- Table structure for table `registrations`
--

CREATE TABLE `registrations` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `programme_id` int(11) NOT NULL,
  `status` enum('registered','cancelled') NOT NULL DEFAULT 'registered',
  `notes` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `registrations`
--

INSERT INTO `registrations` (`id`, `user_id`, `programme_id`, `status`, `notes`, `created_at`) VALUES
(7, 10, 2, 'registered', NULL, '2025-09-10 09:48:30'),
(8, 10, 3, 'registered', NULL, '2025-09-10 12:06:32'),
(10, 1, 2, 'registered', NULL, '2025-09-12 00:36:56'),
(11, 10, 1, 'registered', NULL, '2025-09-12 10:22:50');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `legalid` varchar(20) NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `role` varchar(20) DEFAULT 'customer',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `legalid`, `phone`, `email`, `password`, `role`, `created_at`) VALUES
(1, 'Admin User', 'ADMIN001', NULL, 'admin@example.com', '$2y$10$2AHYaAXk1lGq1YR3E1WXTu/qTHm6LxZOkzyeLEpMRMJaX.5P8V.7W', 'admin', '2025-09-07 01:47:34'),
(2, 'Dr. Pradeepan Sivaliingam', 'THERA001', NULL, 'service01therapist@greenlife.com', '$2y$10$2AHYaAXk1lGq1YR3E1WXTu/qTHm6LxZOkzyeLEpMRMJaX.5P8V.7W', 'therapist', '2025-09-07 01:47:34'),
(3, 'Mrs.Lakna Kiriela', 'THERA002', NULL, 'service02therapist@greenlife.com', '$2y$10$2AHYaAXk1lGq1YR3E1WXTu/qTHm6LxZOkzyeLEpMRMJaX.5P8V.7W', 'therapist', '2025-09-07 01:47:34'),
(4, 'Dr. Oshane Soyza', 'THERA003', NULL, 'service03therapist@greenlife.com', '$2y$10$2AHYaAXk1lGq1YR3E1WXTu/qTHm6LxZOkzyeLEpMRMJaX.5P8V.7W', 'therapist', '2025-09-07 01:47:34'),
(5, 'Dr. Tharindu Perera', 'THERA004', NULL, 'service04therapist@greenlife.com', '$2y$10$2AHYaAXk1lGq1YR3E1WXTu/qTHm6LxZOkzyeLEpMRMJaX.5P8V.7W', 'therapist', '2025-09-07 01:47:34'),
(10, 'Yathushan', '981070747V', '0750353808', 'yathushan666@gmail.com', '$2y$10$fTU/IjudQFD61yjwBtgGHeOiONvzs9Fw2M/5/hidi//P/4hay9Zq.', 'customer', '2025-09-07 03:02:37'),
(11, 'Yathushan', '9814578187V', '0750353808', 'yathushan666@gmail.com', '$2y$10$wIqNYmkkr8X0GFJssEX56uywP4AG0AVj9kBvypt0zp3Azu3ChqG0y', 'customer', '2025-09-09 17:07:39'),
(13, 'Amisha Danansooriya', '981040745V', '0750147408', 'Amisha@gmail.com', '$2y$10$bBY.yfpmVUt52MuhSViJaem8BRANKopg9SGKuS2H5ay1KUeEVuzom', 'customer', '2025-09-12 09:29:28'),
(16, 'Admin User1', 'user_68c3fb9785c99', NULL, 'Admin1@example.com', '$2y$10$FO7RcbL9/19Id8Eu/7dlLe2OMmsejaEgPgn.0cEF62JpO3jgoIX6y', 'admin', '2025-09-12 10:53:11'),
(17, 'Dr. Thanushiya', 'user_68c3fca5e657a', NULL, 'service05therapist@greenlife.com', '$2y$10$qXbNBFVVisKsoTIq93UM1Ohw70v6Y9sdv2pO0AA0dfqCkmoc33/0u', 'therapist', '2025-09-12 10:57:41'),
(18, 'Thanushiya Thavaraja', 'user_68c42d54a1d0f', NULL, 'Thanu@gmail.com', '$2y$10$A/rcUotAZUz0wCCl.1BTHuBcy1aqjZhAy5JI6FdW706xypj1C3.z2', 'admin', '2025-09-12 14:25:24');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bookings`
--
ALTER TABLE `bookings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `customer_id` (`customer_id`),
  ADD KEY `therapist_id` (`therapist_id`);

--
-- Indexes for table `inquiries`
--
ALTER TABLE `inquiries`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_inquiries_user` (`customer_id`);

--
-- Indexes for table `programmes`
--
ALTER TABLE `programmes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `registrations`
--
ALTER TABLE `registrations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_user` (`user_id`),
  ADD KEY `idx_programme` (`programme_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `legalid` (`legalid`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bookings`
--
ALTER TABLE `bookings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;

--
-- AUTO_INCREMENT for table `inquiries`
--
ALTER TABLE `inquiries`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `programmes`
--
ALTER TABLE `programmes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `registrations`
--
ALTER TABLE `registrations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `bookings`
--
ALTER TABLE `bookings`
  ADD CONSTRAINT `bookings_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `bookings_ibfk_2` FOREIGN KEY (`therapist_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `inquiries`
--
ALTER TABLE `inquiries`
  ADD CONSTRAINT `fk_inquiries_user` FOREIGN KEY (`customer_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `registrations`
--
ALTER TABLE `registrations`
  ADD CONSTRAINT `fk_reg_programme` FOREIGN KEY (`programme_id`) REFERENCES `programmes` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_reg_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
