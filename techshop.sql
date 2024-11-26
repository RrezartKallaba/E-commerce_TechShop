-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Nov 26, 2024 at 01:27 PM
-- Server version: 8.3.0
-- PHP Version: 8.2.18

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `techshop`
--
CREATE DATABASE IF NOT EXISTS `techshop` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci;
USE `techshop`;

-- --------------------------------------------------------

--
-- Table structure for table `admin_msg_live_support`
--

DROP TABLE IF EXISTS `admin_msg_live_support`;
CREATE TABLE IF NOT EXISTS `admin_msg_live_support` (
  `id` int NOT NULL AUTO_INCREMENT,
  `admin_id` int NOT NULL,
  `status` varchar(20) DEFAULT NULL,
  `user_id` int DEFAULT NULL,
  `admin_fullname` varchar(255) DEFAULT NULL,
  `admin_email` varchar(255) DEFAULT NULL,
  `message` text,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=MyISAM AUTO_INCREMENT=79 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `admin_msg_live_support`
--

INSERT INTO `admin_msg_live_support` (`id`, `admin_id`, `status`, `user_id`, `admin_fullname`, `admin_email`, `message`, `created_at`) VALUES
(78, 1, 'admin', 12, 'Rrezart Kallaba', 'rrezartkallaba@gmail.com', 'Pershendetje User', '2023-10-22 01:42:40');

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

DROP TABLE IF EXISTS `cart`;
CREATE TABLE IF NOT EXISTS `cart` (
  `cart_id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `product_id` int NOT NULL,
  `image` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `quantity` int NOT NULL DEFAULT '1',
  PRIMARY KEY (`cart_id`),
  KEY `user_id` (`user_id`),
  KEY `product_id` (`product_id`)
) ENGINE=MyISAM AUTO_INCREMENT=263 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `code_forgot_password`
--

DROP TABLE IF EXISTS `code_forgot_password`;
CREATE TABLE IF NOT EXISTS `code_forgot_password` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `email` varchar(50) NOT NULL,
  `random_code` varchar(6) NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `attempts` int NOT NULL DEFAULT '3',
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `contactform`
--

DROP TABLE IF EXISTS `contactform`;
CREATE TABLE IF NOT EXISTS `contactform` (
  `id` int NOT NULL AUTO_INCREMENT,
  `first_name` varchar(25) NOT NULL,
  `last_name` varchar(25) NOT NULL,
  `email` varchar(50) NOT NULL,
  `phone` varchar(25) NOT NULL,
  `message` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=20 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `contactform`
--

INSERT INTO `contactform` (`id`, `first_name`, `last_name`, `email`, `phone`, `message`) VALUES
(18, 'Melyssa', 'Thornton', 'kexoqaqut@gmail.com', '223112123123123', 'Ab proident velit'),
(19, 'Steel', 'Hudson', 'sytef@mailinator.com', '333333333', 'Nisi enim natus veli');

-- --------------------------------------------------------

--
-- Table structure for table `favorite_products`
--

DROP TABLE IF EXISTS `favorite_products`;
CREATE TABLE IF NOT EXISTS `favorite_products` (
  `favorite_id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `product_id` int NOT NULL,
  `favorite` enum('Yes','No') NOT NULL DEFAULT 'No',
  PRIMARY KEY (`favorite_id`),
  KEY `user_id` (`user_id`),
  KEY `product_id` (`product_id`)
) ENGINE=MyISAM AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `favorite_products`
--

INSERT INTO `favorite_products` (`favorite_id`, `user_id`, `product_id`, `favorite`) VALUES
(6, 12, 48, 'Yes'),
(5, 2, 2, 'Yes'),
(4, 2, 1, 'Yes'),
(7, 12, 2, 'Yes'),
(8, 12, 1, 'Yes'),
(9, 15, 2, 'Yes'),
(10, 12, 50, 'No'),
(11, 12, 52, 'No'),
(12, 12, 54, 'Yes');

-- --------------------------------------------------------

--
-- Table structure for table `live_support`
--

DROP TABLE IF EXISTS `live_support`;
CREATE TABLE IF NOT EXISTS `live_support` (
  `id` int NOT NULL AUTO_INCREMENT,
  `status` varchar(20) NOT NULL,
  `user_id` int NOT NULL,
  `user_fullname` varchar(255) NOT NULL,
  `user_email` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=399 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `live_support`
--

INSERT INTO `live_support` (`id`, `status`, `user_id`, `user_fullname`, `user_email`, `message`, `created_at`) VALUES
(398, 'user', 12, 'User User', 'user@gmail.com', 'Pershendetje Admin', '2023-10-22 01:42:35');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

DROP TABLE IF EXISTS `orders`;
CREATE TABLE IF NOT EXISTS `orders` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `product_id` varchar(255) NOT NULL,
  `quantity` text NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `address` varchar(100) NOT NULL,
  `country` varchar(100) NOT NULL,
  `city` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `payment` varchar(10) NOT NULL,
  `totalprice` decimal(10,2) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `product_id` (`product_id`(250))
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `product_id`, `quantity`, `first_name`, `last_name`, `address`, `country`, `city`, `email`, `phone`, `payment`, `totalprice`) VALUES
(1, 12, '53', '1', 'Scarlett', 'Haney', 'Eos veritatis eos a', 'Kosovo', 'Mamushë', 'rrezartkallaba@gmail.com', '122121212', 'Cash', 1364.49);

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

DROP TABLE IF EXISTS `products`;
CREATE TABLE IF NOT EXISTS `products` (
  `id` int NOT NULL AUTO_INCREMENT,
  `image` varchar(255) DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `quantity` int NOT NULL,
  `category` enum('Laptop','Phone') NOT NULL,
  `rating` int NOT NULL,
  `is_hidden` enum('Yes','No') NOT NULL DEFAULT 'No',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=55 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `image`, `name`, `description`, `price`, `quantity`, `category`, `rating`, `is_hidden`) VALUES
(1, '64e0e40c936d3.png', 'Apple Macbook Pro 14\", M2 Pro 10-Core, 16GB, 512GB, 16-Core GPU, Space Grey ', 'Performance tailored for professionals. The new MacBook Pro comes with a 14\" display and pushes the imaginative boundaries to a new level with its performance. The significantly improved architecture of the M2 Pro simply has the brute power for all your creative ideas. Thus, they offer multiple performance in all areas compared to the previous generation MacBook Pro. In the case of this M2 Pro chipset variant, there are 10 processing cores along with a 16-core GPU and a 16-core Neural Engine for machine learning applications.', 2099.00, 5, 'Laptop', 4, 'No'),
(2, '64e0e4012fc87.png', 'Apple MacBook Air 13.3\", M1 8-core, 8GB, 256GB, 7-core GPU, Space Grey', 'Apple MacBook Air 13 is designed to fit all your specific requirements. The laptop maintains high performance, very practical features and is lighter and thinner than its predecessors. Work efficiently and have maximum fun with this series of laptops. The accessory comes equipped with an 8-core Apple M1 processor, which is combined with 8GB of RAM memory, a 13.3\" screen, WQXGA quality and a resolution of 2560 x 1600 pixels.', 999.00, 5, 'Laptop', 5, 'No'),
(54, 'phone4.png', 'Apple iPhone 14 Pro, 256GB, Deep Purple', 'First-class design, durability, functions and technology, all this and much more is hidden in the Apple iPhone 14 Pro model. Dynamic Island is an interactive and engaging iPhone experience for all notifications, alerts and activities. Dynamic Island displays important information, tells you what music is playing, incoming FaceTime calls and more, all without interfering with what you\re doing. 6.1\" OLED Super Retina XDR display with support for the full range of technologies takes care of the top image of the iPhone 14 Pro.', 1499.00, 3, 'Laptop', 3, 'No'),
(53, 'phone3.png', 'Apple iPhone 14 Plus, 256GB, Purple,resolution of 2778x1284 px', 'Design, quality and durability, all this and much more is hidden in the Apple iPhone 14 Plus model. The 6.7 OLED Super Retina XDR screen with support for True Tone technology, which adapts the screen to the ambient light conditions, takes care of the top image of the iPhone 14 Plus, saving your eyes. The screen has a resolution of 2778x1284 pixels at 458 ppi.iPhone The 14 Plus boasts the iOS 16 operating system and the powerful A15 Bionic chip.', 1349.00, 3, 'Laptop', 5, 'No'),
(46, '64e6c03ee6933.png', 'Apple MacBook Air 13.6, M2 8-core, 8GB, 512GB, 10-core GPU, Silver', 'Apple has improved performance, video and sound over the next generation with the M1 chip. MacBook Air 13 (M2) is thinner, lighter and still has great durability and completely smooth operation. With the new MacBook Air (M2), you get even more performance for demanding applications, such as high-definition video editing, graphic design and other creative applications.', 1499.00, 1, 'Laptop', 4, 'No'),
(47, '64e6c135e7de4.png', 'Apple MacBook Air 15\", M2 8-Core CPU, 8GB, 256GB, 10-Core GPU, Midnight', 'With MacBook Air 15.3”, equipped with a stunning Liquid Retina display, you have more space for everything you love. The MacBook Air 15 (M2) represents a masterful combination of lightness and thinness, yet maintains unquestionable durability and completely silent operation. With the new MacBook Air (M2), youll achieve unprecedented performance for demanding tasks, such as high-definition video editing, graphic design, and other creative applications.', 1479.00, 4, 'Laptop', 4, 'No'),
(52, 'phone2.png', 'Apple iPhone 12, 128GB, Green, \r\nresolution of 2532 × 1170 px', 'Apple iPhone 12 is powered by a powerful A14 Bionic chip with the latest generation Neural Engine and higher machine learning performance. Internal memory with a capacity of 128 GB is ready for the system, data and applications. The 6.1\" Super Retina XDR screen with OLED technology and TrueTone has a resolution of 2532 × 1170 px', 919.00, 2, 'Laptop', 4, 'No'),
(50, '64e6c3cd010c7.png', 'Apple MacBook Pro 16\", M2 Pro 12-Core, 16GB, 512GB, 19-Core GPU, Silver', 'Performance tailored for professionals. The new MacBook Pro comes with a 16.2\" display and its performance pushes the imaginary boundaries to a new level. The significantly improved architecture of the M2 Pro simply has the brute power for all your creative ideas. And what you notice at first glance its elegant design with an emphasis on quality workmanship.', 2649.00, 2, 'Laptop', 5, 'No');

-- --------------------------------------------------------

--
-- Table structure for table `reviews`
--

DROP TABLE IF EXISTS `reviews`;
CREATE TABLE IF NOT EXISTS `reviews` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `product_id` int NOT NULL,
  `review` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `product_id` (`product_id`)
) ENGINE=MyISAM AUTO_INCREMENT=146 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `reviews`
--

INSERT INTO `reviews` (`id`, `user_id`, `product_id`, `review`) VALUES
(140, 12, 2, 'Produkti me i mire!'),
(144, 12, 47, ' vngf'),
(145, 12, 53, '4/5\r\n');

-- --------------------------------------------------------

--
-- Table structure for table `time_datelogin`
--

DROP TABLE IF EXISTS `time_datelogin`;
CREATE TABLE IF NOT EXISTS `time_datelogin` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `user_email` varchar(200) NOT NULL,
  `status` enum('user','admin') NOT NULL,
  `time` time NOT NULL,
  `date` date NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=MyISAM AUTO_INCREMENT=234 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `time_datelogin`
--

INSERT INTO `time_datelogin` (`id`, `user_id`, `user_email`, `status`, `time`, `date`) VALUES
(184, 1, 'rrezartkallaba@gmail.com', 'admin', '00:42:50', '2023-09-17'),
(183, 1, 'rrezartkallaba@gmail.com', 'admin', '00:15:12', '2023-09-17'),
(182, 1, 'rrezartkallaba@gmail.com', 'admin', '00:08:07', '2023-09-17'),
(181, 1, 'rrezartkallaba@gmail.com', 'admin', '21:55:23', '2023-09-17'),
(180, 1, 'rrezartkallaba@gmail.com', 'admin', '14:40:59', '2023-09-17'),
(179, 1, 'rrezartkallaba@gmail.com', 'admin', '14:40:35', '2023-09-17'),
(178, 1, 'rrezartkallaba@gmail.com', 'admin', '01:17:38', '2023-09-16'),
(177, 1, 'rrezartkallaba@gmail.com', 'admin', '01:02:45', '2023-09-16'),
(176, 1, 'rrezartkallaba@gmail.com', 'admin', '00:43:54', '2023-09-16'),
(175, 1, 'rrezartkallaba@gmail.com', 'admin', '23:58:46', '2023-09-16'),
(174, 1, 'rrezartkallaba@gmail.com', 'admin', '23:24:49', '2023-09-16'),
(173, 1, 'rrezartkallaba@gmail.com', 'admin', '03:16:38', '2023-09-16'),
(172, 1, 'rrezartkallaba@gmail.com', 'admin', '02:50:48', '2023-09-16'),
(171, 1, 'rrezartkallaba@gmail.com', 'admin', '01:47:36', '2023-09-15'),
(170, 1, 'rrezartkallaba@gmail.com', 'admin', '01:37:53', '2023-09-15'),
(169, 12, 'user@gmail.com', 'user', '00:46:56', '2023-09-15'),
(168, 1, 'rrezartkallaba@gmail.com', 'admin', '21:49:27', '2023-09-15'),
(167, 1, 'rrezartkallaba@gmail.com', 'admin', '21:44:14', '2023-09-15'),
(166, 12, 'user@gmail.com', 'user', '21:43:51', '2023-09-15'),
(165, 1, 'rrezartkallaba@gmail.com', 'admin', '19:00:59', '2023-09-15'),
(164, 1, 'rrezartkallaba@gmail.com', 'admin', '18:50:07', '2023-09-15'),
(163, 1, 'rrezartkallaba@gmail.com', 'admin', '18:40:09', '2023-09-15'),
(162, 1, 'rrezartkallaba@gmail.com', 'admin', '18:39:36', '2023-09-15'),
(161, 1, 'rrezartkallaba@gmail.com', 'admin', '17:55:53', '2023-09-15'),
(160, 12, 'user@gmail.com', 'user', '17:31:03', '2023-09-15'),
(159, 12, 'user@gmail.com', 'user', '17:22:18', '2023-09-15'),
(158, 12, 'user@gmail.com', 'user', '17:16:54', '2023-09-15'),
(157, 12, 'user@gmail.com', 'user', '16:52:19', '2023-09-15'),
(156, 12, 'user@gmail.com', 'user', '16:51:57', '2023-09-15'),
(155, 19, 'user019@gmail.com', 'user', '16:31:33', '2023-09-15'),
(154, 19, 'user019@gmail.com', 'user', '16:30:51', '2023-09-15'),
(153, 19, 'user019@gmail.com', 'user', '16:03:02', '2023-09-15'),
(152, 12, 'user@gmail.com', 'user', '02:06:06', '2023-09-15'),
(151, 12, 'user@gmail.com', 'user', '00:26:47', '2023-09-14'),
(150, 12, 'user@gmail.com', 'user', '00:24:15', '2023-09-14'),
(149, 12, 'user@gmail.com', 'user', '00:17:53', '2023-09-14'),
(148, 12, 'user@gmail.com', 'user', '16:52:02', '2023-09-13'),
(147, 12, 'user@gmail.com', 'user', '00:52:21', '2023-09-12'),
(146, 12, 'user@gmail.com', 'user', '00:42:56', '2023-09-12'),
(145, 18, 'user11@gmail.com', 'user', '00:35:35', '2023-09-12'),
(144, 17, 'user11@gmail.com', 'user', '00:32:02', '2023-09-12'),
(143, 16, 'user11@gmail.com', 'user', '00:29:47', '2023-09-12'),
(142, 16, 'user11@gmail.com', 'user', '00:29:35', '2023-09-12'),
(141, 12, 'user@gmail.com', 'user', '00:27:37', '2023-09-12'),
(140, 12, 'user@gmail.com', 'user', '00:22:43', '2023-09-12'),
(139, 12, 'user@gmail.com', 'user', '00:02:49', '2023-09-12'),
(138, 12, 'user@gmail.com', 'user', '00:02:20', '2023-09-12'),
(137, 12, 'user@gmail.com', 'user', '00:01:58', '2023-09-12'),
(136, 12, 'user@gmail.com', 'user', '00:01:44', '2023-09-12'),
(135, 12, 'user@gmail.com', 'user', '00:01:31', '2023-09-12'),
(134, 12, 'user@gmail.com', 'user', '00:01:12', '2023-09-12'),
(133, 12, 'user@gmail.com', 'user', '00:00:22', '2023-09-12'),
(132, 12, 'user@gmail.com', 'user', '23:50:36', '2023-09-12'),
(131, 12, 'user@gmail.com', 'user', '23:48:39', '2023-09-12'),
(130, 12, 'user@gmail.com', 'user', '23:47:45', '2023-09-12'),
(129, 12, 'user@gmail.com', 'user', '23:44:42', '2023-09-12'),
(128, 12, 'user@gmail.com', 'user', '23:40:59', '2023-09-12'),
(127, 12, 'user@gmail.com', 'user', '23:39:28', '2023-09-12'),
(126, 12, 'user@gmail.com', 'user', '23:38:25', '2023-09-12'),
(125, 12, 'user@gmail.com', 'user', '23:37:37', '2023-09-12'),
(124, 12, 'user@gmail.com', 'user', '23:35:53', '2023-09-12'),
(123, 12, 'user@gmail.com', 'user', '23:29:57', '2023-09-12'),
(122, 12, 'user@gmail.com', 'user', '22:48:25', '2023-09-12'),
(121, 12, 'user@gmail.com', 'user', '22:47:59', '2023-09-12'),
(120, 12, 'user@gmail.com', 'user', '20:08:42', '2023-09-12'),
(119, 12, 'user@gmail.com', 'user', '20:08:19', '2023-09-12'),
(118, 12, 'user@gmail.com', 'user', '20:05:44', '2023-09-12'),
(117, 12, 'user@gmail.com', 'user', '20:05:06', '2023-09-12'),
(116, 12, 'user@gmail.com', 'user', '20:02:05', '2023-09-12'),
(115, 12, 'user@gmail.com', 'user', '19:52:39', '2023-09-12'),
(114, 12, 'user@gmail.com', 'user', '19:51:44', '2023-09-12'),
(113, 12, 'user@gmail.com', 'user', '19:49:34', '2023-09-12'),
(185, 1, 'rrezartkallaba@gmail.com', 'admin', '03:29:37', '2023-09-23'),
(186, 1, 'rrezartkallaba@gmail.com', 'admin', '04:01:31', '2023-09-23'),
(187, 12, 'user@gmail.com', 'user', '11:31:04', '2023-09-23'),
(188, 1, 'rrezartkallaba@gmail.com', 'admin', '12:27:52', '2023-09-23'),
(189, 14, 'htaulant0@gmail.com', 'user', '12:34:08', '2023-09-23'),
(190, 1, 'rrezartkallaba@gmail.com', 'admin', '22:19:12', '2023-09-23'),
(191, 12, 'user@gmail.com', 'user', '14:46:29', '2023-09-24'),
(192, 12, 'user@gmail.com', 'user', '00:42:40', '2023-09-25'),
(193, 12, 'user@gmail.com', 'user', '00:51:42', '2023-09-25'),
(194, 14, 'htaulant0@gmail.com', 'user', '21:10:11', '2023-09-26'),
(195, 12, 'user@gmail.com', 'user', '21:42:32', '2023-09-26'),
(196, 12, 'user@gmail.com', 'user', '21:45:47', '2023-09-26'),
(197, 14, 'htaulant0@gmail.com', 'user', '22:06:46', '2023-09-26'),
(198, 12, 'user@gmail.com', 'user', '23:10:28', '2023-09-27'),
(199, 1, 'rrezartkallaba@gmail.com', 'admin', '16:31:27', '2023-10-07'),
(200, 12, 'user@gmail.com', 'user', '19:47:00', '2023-10-09'),
(201, 1, 'rrezartkallaba@gmail.com', 'admin', '11:05:06', '2023-10-12'),
(202, 12, 'user@gmail.com', 'user', '23:35:19', '2023-10-13'),
(203, 12, 'user@gmail.com', 'user', '22:03:24', '2023-10-15'),
(204, 12, 'user@gmail.com', 'user', '23:13:34', '2023-10-15'),
(205, 12, 'user@gmail.com', 'user', '23:57:08', '2023-10-15'),
(206, 12, 'user@gmail.com', 'user', '08:00:45', '2023-10-16'),
(207, 1, 'rrezartkallaba@gmail.com', 'admin', '08:07:39', '2023-10-16'),
(208, 1, 'rrezartkallaba@gmail.com', 'admin', '08:10:23', '2023-10-16'),
(209, 12, 'user@gmail.com', 'user', '16:50:25', '2023-10-17'),
(210, 1, 'rrezartkallaba@gmail.com', 'admin', '17:31:14', '2023-10-17'),
(211, 12, 'user@gmail.com', 'user', '17:32:18', '2023-10-17'),
(212, 12, 'user@gmail.com', 'user', '21:47:33', '2023-10-17'),
(213, 12, 'user@gmail.com', 'user', '21:50:43', '2023-10-17'),
(214, 12, 'user@gmail.com', 'user', '08:23:56', '2023-10-18'),
(215, 12, 'user@gmail.com', 'user', '08:31:52', '2023-10-18'),
(216, 1, 'rrezartkallaba@gmail.com', 'admin', '08:52:38', '2023-10-18'),
(217, 1, 'rrezartkallaba@gmail.com', 'admin', '09:23:44', '2023-10-18'),
(218, 12, 'user@gmail.com', 'user', '16:22:20', '2023-10-18'),
(219, 12, 'user@gmail.com', 'user', '22:13:35', '2023-10-20'),
(220, 1, 'rrezartkallaba@gmail.com', 'admin', '22:15:32', '2023-10-20'),
(221, 12, 'user@gmail.com', 'user', '22:36:47', '2023-10-20'),
(222, 1, 'rrezartkallaba@gmail.com', 'admin', '23:02:25', '2023-10-20'),
(223, 1, 'rrezartkallaba@gmail.com', 'admin', '23:28:10', '2023-10-20'),
(224, 1, 'rrezartkallaba@gmail.com', 'admin', '23:28:45', '2023-10-20'),
(225, 1, 'rrezartkallaba@gmail.com', 'admin', '01:02:45', '2023-10-20'),
(226, 1, 'rrezartkallaba@gmail.com', 'admin', '23:04:28', '2023-10-21'),
(227, 12, 'user@gmail.com', 'user', '23:04:38', '2023-10-21'),
(228, 1, 'rrezartkallaba@gmail.com', 'admin', '01:24:43', '2023-10-21'),
(229, 1, 'rrezartkallaba@gmail.com', 'admin', '14:53:13', '2024-11-21'),
(230, 12, 'user@gmail.com', 'user', '14:55:06', '2024-11-21'),
(231, 1, 'rrezartkallaba@gmail.com', 'admin', '14:59:40', '2024-11-21'),
(232, 12, 'user@gmail.com', 'user', '15:08:38', '2024-11-21'),
(233, 1, 'rrezartkallaba@gmail.com', 'admin', '15:11:20', '2024-11-26');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `address` varchar(100) NOT NULL,
  `image` varchar(100) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `status` varchar(10) NOT NULL DEFAULT 'user',
  `is_banned` enum('Yes','No') NOT NULL DEFAULT 'No',
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=MyISAM AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `first_name`, `last_name`, `email`, `phone`, `address`, `image`, `password`, `status`, `is_banned`) VALUES
(1, 'Rrezart', 'Kallaba', 'rrezartkallaba@gmail.com', '049123123', 'Suhareke', 'user.png', '6b0543c582a67f70f3792a0684729bed0de6a95b447416d2a512f938139ad6d0', 'admin', 'No'),
(12, 'User', 'User', 'user@gmail.com', '123456789', 'Suhareke', '650386bc7048c.jpg', 'ef797c8118f02dfb649607dd5d3f8c7623048c9c063d532cc95c5ed7a898a64f', 'user', 'No');

DELIMITER $$
--
-- Events
--
DROP EVENT IF EXISTS `CleanupExpiredCodes`$$
CREATE DEFINER=`root`@`localhost` EVENT `CleanupExpiredCodes` ON SCHEDULE EVERY 5 MINUTE STARTS '2023-09-23 01:15:00' ON COMPLETION NOT PRESERVE ENABLE DO BEGIN
    DELETE FROM code_forgot_password
    WHERE TIMESTAMPDIFF(MINUTE, created_at, NOW()) >= 15;
END$$

DELIMITER ;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
