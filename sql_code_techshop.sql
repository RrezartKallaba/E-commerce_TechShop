-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Aug 25, 2023 at 05:08 PM
-- Server version: 8.0.31
-- PHP Version: 8.0.26

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
) ENGINE=MyISAM AUTO_INCREMENT=88 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `cart`
--

INSERT INTO `cart` (`cart_id`, `user_id`, `product_id`, `image`, `name`, `price`, `quantity`) VALUES
(63, 8, 1, '64e0e40c936d3.png', 'Apple Macbook Pro 14\", M2 Pro 10-Core, 16GB, 512GB, 16-Core GPU, Space Grey ', '2099.00', 1),
(64, 8, 2, '64e0e4012fc87.png', 'Apple MacBook Air 13.3\", M1 8-core, 8GB, 256GB, 7-core GPU, Space Grey', '999.00', 2);

-- --------------------------------------------------------

--
-- Table structure for table `contactform`
--

DROP TABLE IF EXISTS `contactform`;
CREATE TABLE IF NOT EXISTS `contactform` (
  `id` int NOT NULL AUTO_INCREMENT,
  `first_name` varchar(25) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `last_name` varchar(25) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `email` varchar(50) NOT NULL,
  `phone` varchar(25) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `message` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `favorite_products`
--

DROP TABLE IF EXISTS `favorite_products`;
CREATE TABLE IF NOT EXISTS `favorite_products` (
  `favorite_id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `product_id` int NOT NULL,
  `favorite` enum('Yes','No') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL DEFAULT 'No',
  PRIMARY KEY (`favorite_id`),
  KEY `user_id` (`user_id`),
  KEY `product_id` (`product_id`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `favorite_products`
--

INSERT INTO `favorite_products` (`favorite_id`, `user_id`, `product_id`, `favorite`) VALUES
(6, 12, 48, 'Yes'),
(5, 2, 2, 'Yes'),
(4, 2, 1, 'No'),
(7, 12, 2, 'Yes');

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
  `first_name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `last_name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `address` varchar(100) NOT NULL,
  `country` varchar(100) NOT NULL,
  `city` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `phone` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `payment` varchar(10) NOT NULL,
  `totalprice` decimal(10,2) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `product_id` (`product_id`(250))
) ENGINE=MyISAM AUTO_INCREMENT=87 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `product_id`, `quantity`, `first_name`, `last_name`, `address`, `country`, `city`, `email`, `phone`, `payment`, `totalprice`) VALUES
(86, 12, '2', '1', 'Rrezart', 'Kallaba', 'Suahreke', 'Kosovo', 'Prishtinë', 'rrezartkallaba@gmail.com', '049123123', 'Cash', '1010.99'),
(85, 12, '1,2', '1,1', 'Rrezart', 'Kallaba', 'Suhareke', 'Kosovo', 'Therandë', 'rrezartkallaba@gmail.com', '1232312', 'Cash', '3130.98'),
(84, 12, '2,54,1,53,46,47,48,52,50', '2,3,5,3,1,4,2,2,2', 'Rrezart', 'Kallaba', 'Suhareke', 'Kosovo', 'Therandë', 'rrezartkallaba@gmail.com', '049123123', 'Cash', '38691.06'),
(83, 2, '1', '1', 'User', 'User', 'Suhareke', 'Kosovo', 'Deçan', 'rrezartkallaba@gmail.com', '12312323', 'Cash', '2121.99'),
(82, 2, '2', '1', 'Test', 'Test', 'Suhareke', 'Kosovo', 'Deçan', 'rrezartkallaba@gmail.com', '12212', 'Cash', '1010.99');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

DROP TABLE IF EXISTS `products`;
CREATE TABLE IF NOT EXISTS `products` (
  `id` int NOT NULL AUTO_INCREMENT,
  `image` varchar(255) DEFAULT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `quantity` int NOT NULL,
  `category` enum('Laptop','Phone') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `rating` int NOT NULL,
  `is_hidden` enum('Yes','No') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL DEFAULT 'No',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=56 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `image`, `name`, `description`, `price`, `quantity`, `category`, `rating`, `is_hidden`) VALUES
(1, '64e0e40c936d3.png', 'Apple Macbook Pro 14\", M2 Pro 10-Core, 16GB, 512GB, 16-Core GPU, Space Grey ', 'Performance tailored for professionals. The new MacBook Pro comes with a 14\" display and pushes the imaginative boundaries to a new level with its performance. The significantly improved architecture of the M2 Pro simply has the brute power for all your creative ideas. Thus, they offer multiple performance in all areas compared to the previous generation MacBook Pro. In the case of this M2 Pro chipset variant, there are 10 processing cores along with a 16-core GPU and a 16-core Neural Engine for machine learning applications.', '2099.00', 5, 'Laptop', 4, 'Yes'),
(2, '64e0e4012fc87.png', 'Apple MacBook Air 13.3\", M1 8-core, 8GB, 256GB, 7-core GPU, Space Grey', 'Apple MacBook Air 13 is designed to fit all your specific requirements. The laptop maintains high performance, very practical features and is lighter and thinner than its predecessors. Work efficiently and have maximum fun with this series of laptops. The accessory comes equipped with an 8-core Apple M1 processor, which is combined with 8GB of RAM memory, a 13.3\" screen, WQXGA quality and a resolution of 2560 x 1600 pixels.', '999.00', 2, 'Laptop', 3, 'Yes'),
(54, 'phone4.png', 'Apple iPhone 14 Pro, 256GB, Deep Purple', 'First-class design, durability, functions and technology, all this and much more is hidden in the Apple iPhone 14 Pro model. Dynamic Island is an interactive and engaging iPhone experience for all notifications, alerts and activities. Dynamic Island displays important information, tells you what music is playing, incoming FaceTime calls and more, all without interfering with what you\'re doing. 6.1\" OLED Super Retina XDR display with support for the full range of technologies takes care of the top image of the iPhone 14 Pro.', '1499.00', 3, 'Laptop', 3, 'Yes'),
(53, 'phone3.png', 'Apple iPhone 14 Plus, 256GB, Purple,resolution of 2778x1284 px', 'Design, quality and durability, all this and much more is hidden in the Apple iPhone 14 Plus model. The 6.7\" OLED Super Retina XDR screen with support for True Tone technology, which adapts the screen to the ambient light conditions, takes care of the top image of the iPhone 14 Plus, saving your eyes. The screen has a resolution of 2778x1284 pixels at 458 ppi.iPhone The 14 Plus boasts the iOS 16 operating system and the powerful A15 Bionic chip.', '1349.00', 3, 'Laptop', 5, 'Yes'),
(46, '64e6c03ee6933.png', 'Apple MacBook Air 13.6\", M2 8-core, 8GB, 512GB, 10-core GPU, Silver', 'Apple has improved performance, video and sound over the next generation with the M1 chip. MacBook Air 13 (M2) is thinner, lighter and still has great durability and completely smooth operation. With the new MacBook Air (M2), you get even more performance for demanding applications, such as high-definition video editing, graphic design and other creative applications.', '1499.00', 1, 'Laptop', 4, 'Yes'),
(47, '64e6c135e7de4.png', 'Apple MacBook Air 15\", M2 8-Core CPU, 8GB, 256GB, 10-Core GPU, Midnight', 'With MacBook Air 15.3”, equipped with a stunning Liquid Retina display, you have more space for everything you love. The MacBook Air 15 (M2) represents a masterful combination of lightness and thinness, yet maintains unquestionable durability and completely silent operation. With the new MacBook Air (M2), you\'ll achieve unprecedented performance for demanding tasks, such as high-definition video editing, graphic design, and other creative applications.', '1479.00', 4, 'Laptop', 4, 'No'),
(48, '64e6c23fd594d.png', 'Apple iPhone 14 Pro, 128GB, Deep Purple', 'First-class design, durability, functions and technology, all this and much more is hidden in the Apple iPhone 14 Pro model. Dynamic Island is an interactive and engaging iPhone experience for all notifications, alerts and activities. Dynamic Island displays important information, tells you what music is playing, incoming FaceTime calls and more.', '1359.00', 2, 'Laptop', 5, 'No'),
(52, 'phone2.png', 'Apple iPhone 12, 128GB, Green, \r\nresolution of 2532 × 1170 px', 'Apple iPhone 12 is powered by a powerful A14 Bionic chip with the latest generation Neural Engine and higher machine learning performance. Internal memory with a capacity of 128 GB is ready for the system, data and applications. The 6.1\" Super Retina XDR screen with OLED technology and TrueTone has a resolution of 2532 × 1170 px', '919.00', 2, 'Laptop', 4, 'No'),
(50, '64e6c3cd010c7.png', 'Apple MacBook Pro 16\", M2 Pro 12-Core, 16GB, 512GB, 19-Core GPU, Silver', 'Performance tailored for professionals. The new MacBook Pro comes with a 16.2\" display and its performance pushes the imaginary boundaries to a new level. The significantly improved architecture of the M2 Pro simply has the brute power for all your creative ideas. And what you notice at first glance it\'s elegant design with an emphasis on quality workmanship.', '2649.00', 2, 'Laptop', 5, 'No');

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
) ENGINE=MyISAM AUTO_INCREMENT=139 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

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
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `time_datelogin`
--

INSERT INTO `time_datelogin` (`id`, `user_id`, `user_email`, `status`, `time`, `date`) VALUES
(1, 12, 'user@gmail.com', 'user', '18:49:05', '2023-08-25'),
(2, 1, 'rrezartkallaba@gmail.com', 'admin', '19:06:54', '2023-08-25');

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
  `status` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL DEFAULT 'user',
  `is_banned` enum('Yes','No') NOT NULL DEFAULT 'No',
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=MyISAM AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `first_name`, `last_name`, `email`, `phone`, `address`, `image`, `password`, `status`, `is_banned`) VALUES
(1, 'Rrezart', 'Kallaba', 'rrezartkallaba@gmail.com', '049123123', 'Suhareke', 'user.png', 'cfb4e4cff35327725d186b2ab037b2876bcdcbed97798ef30896f6b1a26c6888', 'admin', 'No'),
(12, 'User', 'Test', 'user@gmail.com', '123456789', 'Viena', 'user.png', 'ef797c8118f02dfb649607dd5d3f8c7623048c9c063d532cc95c5ed7a898a64f', 'user', 'No');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
