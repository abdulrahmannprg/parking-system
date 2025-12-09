-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Nov 19, 2025 at 03:28 PM
-- Server version: 9.1.0
-- PHP Version: 8.3.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ss`
--

-- --------------------------------------------------------

--
-- Table structure for table `bookings`
--

DROP TABLE IF EXISTS `bookings`;
CREATE TABLE IF NOT EXISTS `bookings` (
  `id` int NOT NULL AUTO_INCREMENT,
  `customer_name` varchar(100) NOT NULL,
  `car_number` varchar(20) NOT NULL,
  `phone_number` varchar(20) NOT NULL,
  `duration` int NOT NULL,
  `spot_id` int NOT NULL,
  `booking_time` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `rating` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `spot_id` (`spot_id`)
) ENGINE=MyISAM AUTO_INCREMENT=27 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `bookings`
--

INSERT INTO `bookings` (`id`, `customer_name`, `car_number`, `phone_number`, `duration`, `spot_id`, `booking_time`, `rating`) VALUES
(25, 'hgfgf', '2233', '3333', 3, 24, '2025-11-18 16:41:58', NULL),
(24, 'يبلفلفل', '333', '333', 5, 26, '2025-11-18 16:34:58', NULL),
(23, '2344', '233', '0596298662', 2, 22, '2025-11-18 16:32:13', NULL),
(21, 'ييي', '34', '0596298660', 3, 20, '2025-11-18 16:27:48', NULL),
(22, 'يبلفلفل', '23444', '3455', 2, 21, '2025-11-18 16:29:32', NULL),
(20, 'محمد ', '233', '0596298111', 4, 17, '2025-11-18 16:27:05', NULL),
(19, 'alii', '2222', '0596298662', 3, 19, '2025-11-18 16:24:27', NULL),
(18, 'alii', '234', '0596298622', 2, 16, '2025-11-18 16:23:11', NULL),
(17, 'محمد ', '234', '0596298622', 4, 15, '2025-11-18 16:22:47', NULL),
(16, 'عبدالله', '123', '0596298622', 12, 18, '2025-11-18 16:21:03', NULL),
(26, 'يبلفلفل', '2334', '56', 3, 23, '2025-11-18 16:44:53', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `parking_spots`
--

DROP TABLE IF EXISTS `parking_spots`;
CREATE TABLE IF NOT EXISTS `parking_spots` (
  `id` int NOT NULL AUTO_INCREMENT,
  `spot_number` varchar(20) NOT NULL,
  `status` enum('available','booked') DEFAULT 'available',
  `is_vip` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=28 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `parking_spots`
--

INSERT INTO `parking_spots` (`id`, `spot_number`, `status`, `is_vip`) VALUES
(10, 'A1', 'booked', 1),
(2, 'A2', 'booked', 0),
(3, 'A3', 'booked', 0),
(4, 'B1', 'booked', 0),
(5, 'B2', 'booked', 0),
(6, 'A1', 'booked', 1),
(7, 'A2', 'booked', 1),
(8, 'B1', 'booked', 0),
(9, 'B2', 'booked', 0),
(11, 'A2', 'booked', 1),
(12, 'B1', 'booked', 0),
(13, 'B2', 'booked', 0),
(14, 'A1', 'booked', 1),
(15, 'A2', 'booked', 1),
(16, 'A3', 'booked', 1),
(17, 'A4', 'booked', 1),
(18, 'B1', 'booked', 0),
(19, 'B2', 'booked', 0),
(20, 'B3', 'booked', 0),
(21, 'B4', 'booked', 0),
(22, 'A5', 'booked', 1),
(23, 'A6', 'booked', 1),
(24, 'A7', 'booked', 1),
(25, 'A5', 'available', 1),
(26, 'A6', 'booked', 1),
(27, 'A7', 'available', 1);

-- --------------------------------------------------------

--
-- Table structure for table `reviews`
--

DROP TABLE IF EXISTS `reviews`;
CREATE TABLE IF NOT EXISTS `reviews` (
  `id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(255) NOT NULL,
  `review` text NOT NULL,
  `rating` int NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(191) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','driver') NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `role`, `created_at`) VALUES
(1, 'admin_user', '$2y$10$efUhVvF8QORmOxI1bWSTCe6OQBS0xdngxdbLSXK5Od2Vts.XUq1IC', 'admin', '2025-11-17 12:46:06'),
(2, 'driver_user', '$2y$10$LmFaf4ESHZvTjAQW6WAMe.42ntqsxyonK/Qj0EsG4ygO1EobkD5DC', 'driver', '2025-11-17 12:46:06');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
