-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Jun 02, 2023 at 01:51 PM
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
-- Database: `yii2advanced`
--

-- --------------------------------------------------------

--
-- Table structure for table `addresses`
--

DROP TABLE IF EXISTS `addresses`;
CREATE TABLE IF NOT EXISTS `addresses` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `country` varchar(255) NOT NULL,
  `city` varchar(255) NOT NULL,
  `street` varchar(255) NOT NULL,
  `location` decimal(10,7) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk-addresses-user_id` (`user_id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `addresses`
--

INSERT INTO `addresses` (`id`, `user_id`, `country`, `city`, `street`, `location`) VALUES
(1, 16, 'Lebanon', 'Tripoli', 'Azmi', '0.0000000'),
(2, 19, 'lebanon', 'beirut', 'Al hamra', '45.0000000'),
(3, 21, 'lebanon', 'beirut', 'Al hamra', '1.2222000');

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

DROP TABLE IF EXISTS `admins`;
CREATE TABLE IF NOT EXISTS `admins` (
  `id` int DEFAULT NULL,
  `firstname` varchar(255) NOT NULL,
  `lastname` varchar(255) NOT NULL,
  KEY `FK_admin_id` (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `firstname`, `lastname`) VALUES
(NULL, 'Hussein', 'Aref'),
(NULL, 'A', 'B'),
(12, 'AC', 'BD'),
(16, 'hamoudi', 'helwe');

-- --------------------------------------------------------

--
-- Table structure for table `carts`
--

DROP TABLE IF EXISTS `carts`;
CREATE TABLE IF NOT EXISTS `carts` (
  `id` int NOT NULL AUTO_INCREMENT,
  `customer_id` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk-carts-customer_id` (`customer_id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `carts`
--

INSERT INTO `carts` (`id`, `customer_id`) VALUES
(1, 16),
(2, 19),
(3, 21);

-- --------------------------------------------------------

--
-- Table structure for table `cart_items`
--

DROP TABLE IF EXISTS `cart_items`;
CREATE TABLE IF NOT EXISTS `cart_items` (
  `cart_id` int NOT NULL,
  `product_id` int NOT NULL,
  `quantity` int NOT NULL,
  PRIMARY KEY (`cart_id`,`product_id`),
  KEY `fk-cart_items-product_id` (`product_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

DROP TABLE IF EXISTS `categories`;
CREATE TABLE IF NOT EXISTS `categories` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `parent_id` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_parentid` (`parent_id`)
) ENGINE=MyISAM AUTO_INCREMENT=58 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `parent_id`) VALUES
(1, 'Computers', 0),
(2, 'Mobile Phones', 0),
(3, 'Televisions', 0),
(4, 'Cameras', 0),
(5, 'Audio', 0),
(6, 'Gaming', 0),
(7, 'Appliances', 0),
(8, 'Accessories', 0),
(9, 'Wearable Devices', 0),
(10, 'Home Electronics', 0),
(11, 'Laptops', 1),
(12, 'Desktops', 1),
(13, 'Tablets', 1),
(14, 'Accessories', 1),
(15, 'Smartphones', 2),
(16, 'Feature Phones', 2),
(17, 'Accessories', 2),
(18, 'LED TVs', 3),
(19, 'OLED TVs', 3),
(20, 'QLED TVs', 3),
(21, 'Smart TVs', 3),
(22, 'Accessories', 3),
(23, 'DSLR Cameras', 4),
(24, 'Mirrorless Cameras', 4),
(25, 'Point-and-Shoot Cameras', 4),
(26, 'Action Cameras', 4),
(27, 'Accessories', 4),
(28, 'Headphones', 5),
(29, 'Speakers', 5),
(30, 'Earphones', 5),
(31, 'Soundbars', 5),
(32, 'Home Theater Systems', 5),
(33, 'Consoles', 6),
(34, 'Video Games', 6),
(35, 'Gaming Accessories', 6),
(36, 'Gaming Laptops', 6),
(37, 'Gaming Headsets\r\n', 6),
(38, 'Refrigerators', 7),
(39, 'Washing Machines', 7),
(40, 'Air Conditioners', 7),
(41, 'Microwaves', 7),
(42, 'Vacuum Cleaners', 7),
(43, 'Cables and Adapters', 8),
(44, 'Chargers and Power Banks', 8),
(45, 'Cases and Covers', 8),
(46, 'Screen Protectors\r\n', 8),
(47, 'Memory Cards and USB Drives', 8),
(48, 'Smartwatches', 9),
(49, 'Fitness Trackers', 9),
(50, 'VR Headsets', 9),
(51, 'Smart Glasses\r\n', 9),
(52, 'Wearable Accessories', 9),
(53, 'Home Security Systems', 10),
(54, 'Smart Home Devices', 10),
(55, 'Home Entertainment Systems', 10),
(56, 'Home Automation', 10),
(57, 'Weather Stations', 10);

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

DROP TABLE IF EXISTS `customers`;
CREATE TABLE IF NOT EXISTS `customers` (
  `id` int DEFAULT NULL,
  `firstname` varchar(255) NOT NULL,
  `lastname` varchar(255) NOT NULL,
  KEY `FK_customer_id` (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`id`, `firstname`, `lastname`) VALUES
(18, 'mhamad', 'abbas'),
(16, 'mhamad', 'ali'),
(19, 'hussein', 'aref'),
(21, 'Ali', 'Ahmad');

-- --------------------------------------------------------

--
-- Table structure for table `migration`
--

DROP TABLE IF EXISTS `migration`;
CREATE TABLE IF NOT EXISTS `migration` (
  `version` varchar(180) NOT NULL,
  `apply_time` int DEFAULT NULL,
  PRIMARY KEY (`version`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `migration`
--

INSERT INTO `migration` (`version`, `apply_time`) VALUES
('m000000_000000_base', 1683619553),
('m130524_201442_init', 1683619559),
('m230517_063035_add_logo_supplier', 1684305268),
('m230523_083730_add_image_product', 1684831088),
('m230523_084016_add_image_product', 1684831260),
('m230523_084159_add_image_product', 1684831333),
('m230515_121734_add_order_address', 1684931369),
('m230516_070212_set_categories_parentid_default_null', 1684931369),
('m230516_070934_correct_timestamps_users_products', 1684931369);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

DROP TABLE IF EXISTS `orders`;
CREATE TABLE IF NOT EXISTS `orders` (
  `id` int NOT NULL AUTO_INCREMENT,
  `customer_id` int NOT NULL,
  `status` int NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `total_cost` decimal(10,2) NOT NULL,
  `country` varchar(255) NOT NULL,
  `city` varchar(255) NOT NULL,
  `street` varchar(255) NOT NULL,
  `location` decimal(10,7) DEFAULT NULL,
  `orderStatusId` int NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `fk-orders-customer_id` (`customer_id`),
  KEY `orderStatusId` (`orderStatusId`)
) ENGINE=MyISAM AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `customer_id`, `status`, `created_at`, `total_cost`, `country`, `city`, `street`, `location`, `orderStatusId`) VALUES
(1, 16, 0, '2023-05-29 07:01:33', '200.00', 'Lebanon', 'Tripoli', 'Azmi', '0.0000000', 1),
(2, 19, 0, '2023-05-29 11:56:35', '2599.00', 'lebanon', 'beirut', 'Al hamra', '45.0000000', 1),
(3, 19, 0, '2023-05-29 11:57:47', '2599.00', 'lebanon', 'beirut', 'Al hamra', '45.0000000', 1),
(4, 19, 0, '2023-05-29 12:19:37', '2599.00', 'lebanon', 'beirut', 'Al hamra', '45.0000000', 1),
(5, 19, 0, '2023-05-29 12:21:11', '2599.00', 'lebanon', 'beirut', 'Al hamra', '45.0000000', 1),
(6, 19, 0, '2023-05-29 12:21:25', '2599.00', 'lebanon', 'beirut', 'Al hamra', '45.0000000', 1),
(7, 19, 0, '2023-05-29 12:21:49', '2599.00', 'lebanon', 'beirut', 'Al hamra', '45.0000000', 1),
(8, 19, 0, '2023-05-29 12:22:46', '2599.00', 'lebanon', 'beirut', 'Al hamra', '45.0000000', 1),
(9, 19, 0, '2023-05-30 06:19:40', '2599.00', 'lebanon', 'beirut', 'Al hamra', '45.0000000', 1),
(10, 21, 0, '2023-06-01 06:11:58', '200.00', 'lebanon', 'beirut', 'Al hamra', '1.2222000', 1),
(11, 21, 0, '2023-06-01 07:41:12', '200.00', 'lebanon', 'beirut', 'Al hamra', '1.2222000', 1),
(12, 21, 0, '2023-06-01 09:10:10', '200.00', 'lebanon', 'beirut', 'Al hamra', '1.2222000', 1),
(13, 21, 0, '2023-06-01 09:13:12', '200.00', 'lebanon', 'beirut', 'Al hamra', '1.2222000', 1),
(14, 21, 0, '2023-06-01 09:33:13', '200.00', 'lebanon', 'beirut', 'Al hamra', '1.2222000', 2),
(15, 21, 0, '2023-06-01 09:45:51', '200.00', 'lebanon', 'beirut', 'Al hamra', '1.2222000', 4);

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

DROP TABLE IF EXISTS `order_items`;
CREATE TABLE IF NOT EXISTS `order_items` (
  `order_id` int NOT NULL,
  `quantity` int NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `product_id` int DEFAULT NULL,
  `product_details` json NOT NULL,
  KEY `fk-order_items-order_id` (`order_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`order_id`, `quantity`, `price`, `product_id`, `product_details`) VALUES
(1, 1, '200.00', NULL, 'null'),
(8, 1, '2599.00', 29, 'null'),
(9, 1, '2599.00', 29, '\"{\\\"name\\\":\\\"29\\\",\\\"price\\\":\\\"2599.00\\\",\\\"quantity\\\":\\\"1\\\",\\\"orderId\\\":9}\"'),
(10, 1, '200.00', 28, '\"{\\\"name\\\":\\\"Marvo Scorpion G980 Advanced Mechanical RGB Backlight Metal Gaming Mouse \\\\u2013 6000 DPI\\\",\\\"price\\\":\\\"200.00\\\",\\\"quantity\\\":\\\"1\\\",\\\"orderId\\\":10,\\\"productId\\\":\\\"28\\\"}\"'),
(11, 1, '200.00', 28, '\"{\\\"name\\\":\\\"Marvo Scorpion G980 Advanced Mechanical RGB Backlight Metal Gaming Mouse \\\\u2013 6000 DPI\\\",\\\"price\\\":\\\"200.00\\\",\\\"quantity\\\":\\\"1\\\",\\\"orderId\\\":11,\\\"productId\\\":\\\"28\\\",\\\"supplierId\\\":18}\"'),
(12, 1, '200.00', 28, '\"{\\\"name\\\":\\\"Marvo Scorpion G980 Advanced Mechanical RGB Backlight Metal Gaming Mouse \\\\u2013 6000 DPI\\\",\\\"price\\\":\\\"200.00\\\",\\\"quantity\\\":\\\"1\\\",\\\"orderId\\\":12,\\\"productId\\\":\\\"28\\\",\\\"supplierId\\\":\\\"18\\\"}\"'),
(13, 1, '200.00', 28, '\"{\\\"name\\\":\\\"Marvo Scorpion G980 Advanced Mechanical RGB Backlight Metal Gaming Mouse \\\\u2013 6000 DPI\\\",\\\"price\\\":\\\"200.00\\\",\\\"quantity\\\":\\\"1\\\",\\\"orderId\\\":13,\\\"productId\\\":\\\"28\\\",\\\"supplierId\\\":\\\"18\\\"}\"'),
(14, 1, '200.00', 28, '\"{\\\"id\\\":28,\\\"supplier_id\\\":18,\\\"category_id\\\":6,\\\"name\\\":\\\"Marvo Scorpion G980 Advanced Mechanical RGB Backlight Metal Gaming Mouse \\\\u2013 6000 DPI\\\",\\\"description\\\":\\\"Marvo Scorpion G980 Advanced Mechanical RGB Backlight Metal Gaming Mouse \\\\u2013 6000 DPI Dynamic ergonomics with adjustable palm rest length Full thumb rest and low-profile design Aluminium alloy chassis and scroll wheel Heavy-duty switches for main L\\\\/R buttons Advanced customization software and RGB backlight Dynamic RGB lighting with 10 light effect mode options\\\",\\\"price\\\":\\\"200.00\\\",\\\"status\\\":1,\\\"created_at\\\":\\\"2023-05-25 09:48:52\\\",\\\"updated_at\\\":\\\"2023-05-25 09:48:52\\\",\\\"image\\\":\\\"http:\\\\/\\\\/customer-shopndot.test\\\\/uploads\\\\\\\\products\\\\\\\\2023\\\\\\\\05\\\\/25\\\\/4996-4017-1894-1289-6484.jpg\\\"}\"'),
(15, 1, '200.00', 28, '\"{\\\"id\\\":28,\\\"supplier_id\\\":18,\\\"category_id\\\":6,\\\"name\\\":\\\"Marvo Scorpion G980 Advanced Mechanical RGB Backlight Metal Gaming Mouse \\\\u2013 6000 DPI\\\",\\\"description\\\":\\\"Marvo Scorpion G980 Advanced Mechanical RGB Backlight Metal Gaming Mouse \\\\u2013 6000 DPI Dynamic ergonomics with adjustable palm rest length Full thumb rest and low-profile design Aluminium alloy chassis and scroll wheel Heavy-duty switches for main L\\\\/R buttons Advanced customization software and RGB backlight Dynamic RGB lighting with 10 light effect mode options\\\",\\\"price\\\":\\\"200.00\\\",\\\"status\\\":1,\\\"created_at\\\":\\\"2023-05-25 09:48:52\\\",\\\"updated_at\\\":\\\"2023-05-25 09:48:52\\\",\\\"image\\\":\\\"http:\\\\/\\\\/customer-shopndot.test\\\\/uploads\\\\\\\\products\\\\\\\\2023\\\\\\\\05\\\\/25\\\\/4996-4017-1894-1289-6484.jpg\\\"}\"');

-- --------------------------------------------------------

--
-- Table structure for table `order_status`
--

DROP TABLE IF EXISTS `order_status`;
CREATE TABLE IF NOT EXISTS `order_status` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `color` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `order_status`
--

INSERT INTO `order_status` (`id`, `name`, `color`) VALUES
(1, 'Pending', '#f0ad4e'),
(2, 'Processing', '#5bc0de'),
(3, 'Shipped', '#0275d8'),
(4, 'Canceled', '#d9534f'),
(5, 'Complete', '#5cb85c');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

DROP TABLE IF EXISTS `products`;
CREATE TABLE IF NOT EXISTS `products` (
  `id` int NOT NULL AUTO_INCREMENT,
  `supplier_id` int NOT NULL,
  `category_id` int NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `status` smallint NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `image` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_products_supplier` (`supplier_id`),
  KEY `fk_products_category` (`category_id`)
) ENGINE=MyISAM AUTO_INCREMENT=30 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `socials`
--

DROP TABLE IF EXISTS `socials`;
CREATE TABLE IF NOT EXISTS `socials` (
  `id` int NOT NULL AUTO_INCREMENT,
  `supplier_id` int NOT NULL,
  `provider` varchar(255) NOT NULL,
  `link` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk-socials-supplier_id` (`supplier_id`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `socials`
--

INSERT INTO `socials` (`id`, `supplier_id`, `provider`, `link`) VALUES
(2, 18, 'facebook1', 'https://www.facebook.com/business/help/842191386156027?id=533228987210412'),
(3, 18, 'instagram', 'https://www.instagram.com/business/help/842191386156027?id=533228987210412'),
(4, 18, '1', '2'),
(5, 18, '3', '2'),
(6, 14, '', ''),
(7, 14, '', ''),
(8, 14, '', ''),
(9, 14, '', '');

-- --------------------------------------------------------

--
-- Table structure for table `suppliers`
--

DROP TABLE IF EXISTS `suppliers`;
CREATE TABLE IF NOT EXISTS `suppliers` (
  `id` int DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `logo` varchar(255) DEFAULT NULL,
  KEY `FK_supplier_id` (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `suppliers`
--

INSERT INTO `suppliers` (`id`, `name`, `logo`) VALUES
(9, 'store', 'Screenshot (1).png'),
(18, 'karim', 'http://customer-shopndot.test/uploads\\profile\\2023\\05/26/1295-8959-8048-5755-6466.png'),
(18, 'karim', 'http://customer-shopndot.test/uploads\\profile\\2023\\05/26/1295-8959-8048-5755-6466.png'),
(16, 'Hussein', 'Screenshot (23).png'),
(14, 'supp12', 'http://customer-shopndot.test/uploads\\profile\\2023\\05/29/5105-4500-7724-5006-4346.png'),
(13, 'Marwa', 'Screenshot (23).png'),
(12, 'supplier', 'Screenshot (24).png');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(255) COLLATE utf8mb3_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb3_unicode_ci NOT NULL,
  `phone` varchar(255) COLLATE utf8mb3_unicode_ci NOT NULL,
  `auth_key` varchar(32) COLLATE utf8mb3_unicode_ci NOT NULL,
  `password_hash` varchar(255) COLLATE utf8mb3_unicode_ci NOT NULL,
  `password_reset_token` varchar(255) COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `verification_token` varchar(255) COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `status` smallint NOT NULL DEFAULT '10',
  `type` varchar(255) COLLATE utf8mb3_unicode_ci NOT NULL DEFAULT 'customer',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `email` (`email`),
  UNIQUE KEY `phone` (`phone`),
  UNIQUE KEY `password_reset_token` (`password_reset_token`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `phone`, `auth_key`, `password_hash`, `password_reset_token`, `verification_token`, `status`, `type`, `created_at`, `updated_at`) VALUES
(1, 'user1', 'user@gmail.com', '', 'sqaPYZn2OTq8kkdNHfLlmqAIoYg3SpXL', '$2y$13$sfn2AYz6hnsKnmF3EONp2.INoE3tTF.fijxuJOs7xOvMvo8IdPAtC', NULL, '5tFMlOqWadvAQKuL-8E31Wy5QbPpvQYx_1683619848', 10, 'supplier', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(3, 'admin2', 'admin2@gmail.com', '236985', '', '$2y$13$NKv1AGOjv1f54yYddkSxte7E1OpEzeV8daGuspeACUtsks7RApCla', NULL, NULL, 10, 'supplier', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(5, 'admin3', 'admin3@gmail.com', '89652369', '', '$2y$13$KQwMmQRih3SoRQE23SouIu1dTgrcQOshXHAfnbxp8EGrKMmW/6Slq', NULL, NULL, 10, 'supplier', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(6, 'admin4', 'admin4@gmail.com', '55559966', '', '$2y$13$KQwMmQRih3SoRQE23SouIu1dTgrcQOshXHAfnbxp8EGrKMmW/6Slq', NULL, NULL, 10, 'supplier', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(9, 'supplier', 'admin6@gmail.com', '22222222', '', '$2y$13$YPQ4FUhKsY3qoDCnP44xFu3tRtp34NClJdAudpoKJT.QzbDHAoAee', NULL, NULL, 10, 'supplier', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(10, 'supplier12', 'supplier1@123', '654852', '', '$2y$13$XLm5NJmywtP.ixCylR/weeLYFqkGu2wD7RsobM9I/CH7rY8xe8Efa', NULL, NULL, 10, 'supplier', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(12, 'admin67', 'admin67@gmail.com', '71456632', '', '$2y$13$wewiHNFe3NHLiCelApOLbuj8xX4AdOz90/snLBLWAh.YfUBot6vkG', NULL, NULL, 10, 'supplier', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(13, 'admin55', 'admin55@gmail.com', '693325555', '', '$2y$13$TW.vhzVt9ttXahp5sOmeWup7uJMU1svzsSHkOTHwf0haB2jn22LMy', NULL, NULL, 10, 'supplier', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(14, 'admin13', 'admin13@gmail.com', '20103050', '', '$2y$13$8IqWc6E0FfEHUPp9IBa3S.5klKiSIOBXfvDk9jm5wwiPYo7vdTyTS', NULL, NULL, 10, 'supplier', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(15, 'admin523', 'admin523@gmail.com', '5155151551', '', '$2y$13$RRNLn3VlUgmMED36roRUpeeIdolvpBAWrFUxO5T9lAgOhvshKQ/s6', NULL, NULL, 9, 'admin', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(16, 'mhamad', 'mhamad@gmail.com', '589632569', '', '$2y$13$GQEuL4FQC6biM7Cjbc7LMOg3zZNY.MQcN5NNwRUAl56c8IXq2P10i', NULL, NULL, 10, 'customer', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(18, 'karim', 'karim@gmail.com', '12336985', '', '$2y$13$MXpn31j4uYMlwpXFx48BkeaIGRBLw.D0hrBagiFNAInHrbnakfzNe', NULL, NULL, 10, 'supplier', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(19, 'user2', 'user2@gmail.com', '123123123123123', 'pr0ACLv1BgVE_34Uxiw6GTe_BBfnvUoy', '$2y$13$F7eY9WxFHxkmXjZgpVe3E.5or/.vKbpjplMtyJrXKQNnCBWKmEIkq', NULL, NULL, 10, 'customer', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(20, 'user3', 'user3@gmail.com', '159852369', 'PPvOHmdR2aQy7UDR683OE2Sqe8eDxeIE', '$2y$13$F7eY9WxFHxkmXjZgpVe3E.5or/.vKbpjplMtyJrXKQNnCBWKmEIkq', NULL, NULL, 10, 'customer', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(21, 'asd', 'asd@gmail.com', '1234567898', '6BNkW-X9l8auMcFRQBboUv8pR7x7te0I', '$2y$13$fQSA5AP5v.DyYyfXc.iRve7C77lYcz2k05qOQQLN9YqTeINwpRQ4S', NULL, NULL, 10, 'customer', '0000-00-00 00:00:00', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `wishlist_items`
--

DROP TABLE IF EXISTS `wishlist_items`;
CREATE TABLE IF NOT EXISTS `wishlist_items` (
  `id` int NOT NULL AUTO_INCREMENT,
  `customer_id` int NOT NULL,
  `product_id` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk-wishlist-customerid` (`customer_id`),
  KEY `fk-wishlist-productid` (`product_id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `wishlist_items`
--

INSERT INTO `wishlist_items` (`id`, `customer_id`, `product_id`) VALUES
(4, 19, 29),
(5, 21, 28);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
