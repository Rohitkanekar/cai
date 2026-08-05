-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: sql306.infinityfree.com
-- Generation Time: Jul 27, 2026 at 05:07 AM
-- Server version: 11.4.12-MariaDB
-- PHP Version: 7.2.22

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `if0_42478964_cai`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin_users`
--

CREATE TABLE `admin_users` (
  `id` int(11) NOT NULL,
  `full_name` varchar(100) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(150) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin_users`
--

INSERT INTO `admin_users` (`id`, `full_name`, `username`, `email`, `password`, `created_at`) VALUES
(1, 'Rohit Kanekar', 'rohit', 'kanekarrohit26@gmail.com', '$2y$10$SBpiaZfsdCML.pqdhN/yLu7f1FxhhQvQLz6mj1aPOu/LCGezrrUdK', '2026-07-18 07:07:13');

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `name` varchar(150) NOT NULL,
  `slug` varchar(150) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `status` tinyint(1) DEFAULT 1,
  `sort_order` int(11) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `slug`, `image`, `status`, `sort_order`, `created_at`) VALUES
(3, 'benches', 'benches', '1784371903_6a5b5abf16aea.webp', 1, 2, '2026-07-18 10:51:43'),
(6, 'statues', 'statues', '1784373319_6a5b6047f06a9.webp', 1, 3, '2026-07-18 11:15:19'),
(8, 'grc', 'grc', '1784373845_6a5b6255ca8e4.webp', 1, 1, '2026-07-18 11:24:05'),
(9, 'planters', 'planters', '1784374343_6a5b6447ad4ad.webp', 1, 0, '2026-07-18 11:32:23');

-- --------------------------------------------------------

--
-- Table structure for table `enquiries`
--

CREATE TABLE `enquiries` (
  `id` int(11) NOT NULL,
  `customer_name` varchar(150) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `email` varchar(150) NOT NULL,
  `subject` varchar(255) DEFAULT NULL,
  `message` text DEFAULT NULL,
  `customer_address` text DEFAULT NULL,
  `source` varchar(255) DEFAULT NULL,
  `product_name` varchar(255) DEFAULT NULL,
  `product_category` varchar(100) DEFAULT NULL,
  `product_material` varchar(100) DEFAULT NULL,
  `product_size` varchar(100) DEFAULT NULL,
  `product_price` decimal(12,2) DEFAULT NULL,
  `product_length` varchar(100) DEFAULT NULL,
  `product_breadth` varchar(100) DEFAULT NULL,
  `product_height` varchar(100) DEFAULT NULL,
  `product_color` varchar(100) DEFAULT NULL,
  `product_finish` varchar(100) DEFAULT NULL,
  `product_image` varchar(500) DEFAULT NULL,
  `product_url` varchar(500) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `enquiries`
--

INSERT INTO `enquiries` (`id`, `customer_name`, `phone`, `email`, `subject`, `message`, `customer_address`, `source`, `product_name`, `product_category`, `product_material`, `product_size`, `product_price`, `product_length`, `product_breadth`, `product_height`, `product_color`, `product_finish`, `product_image`, `product_url`, `created_at`) VALUES
(1, 'Rohit Rajendra Kanekar', '9029999120', 'kanekarrohit26@gmail.com', 'Quotation', 'Send us a message and we\'ll respond as soon as possible.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-07-17 09:21:09'),
(2, 'Rohit Rajendra Kanekar', '9029999120', 'kanekarrohit26@gmail.com', 'Matrix FRP Planter MX4R5', 'We\'d love to hear from you\nSend us a message and we\'ll respond as soon as possible.', NULL, NULL, 'Matrix FRP Planter MX4R5', 'planters', 'FRP (Fiber Reinforced Plastic)', 'Large', '10381.00', '450 mm (18\")', '450 mm (18\")', '650 mm (26\")', 'Customizable', 'Matte', NULL, NULL, '2026-07-17 09:21:54'),
(4, 'Rohit Kanekar', '9029999120', 'kanekarrohit26@gmail.com', 'Testing', 'This is a backend test.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-07-17 09:25:39'),
(5, 'Rohit Rajendra Kanekar', '9029999120', 'kanekarrohit26@gmail.com', 'New Website Enquiry', 'Send us a message and we\'ll respond as soon as possible.', NULL, NULL, 'Matrix FRP Planter MX4R5', 'planters', 'FRP (Fiber Reinforced Plastic)', 'Large', '10381.00', '450 mm (18\")', '450 mm (18\")', '650 mm (26\")', 'Customizable', 'Matte', NULL, NULL, '2026-07-17 09:59:19'),
(6, 'Rohit Rajendra Kanekar', '9029999120', 'kanekarrohit26@gmail.com', 'White Architectural GRC Jali', 'We\'d love to hear from you\nSend us a message and we\'ll respond as soon as possible.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-07-17 10:10:24'),
(7, 'Rohit Rajendra Kanekar', '9029999120', 'kanekarrohit@gmail.com', 'Bench', 'oon as possible.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-07-17 10:14:58'),
(8, 'Rohit Rajendra Kanekar', '9029999120', 'kanekarrohit26@gmail.com', 'Hati', 'oon as possible.oon as possible.oon as possible.oon as possible.', NULL, NULL, 'FRP Elephant Statue', 'statues', 'FRP (Fiberglass Reinforced Plastic)', '4.5 Feet', '15000.00', NULL, NULL, NULL, 'Dark Brown / Charcoal', 'Metallic Lacquered Finish', NULL, NULL, '2026-07-17 10:18:54'),
(9, 'Rohit Rajendra Kanekar', '9029999120', 'kanekarrohit26@gmail.com', 'Quotation', 'We\'d love to hear from you\nSend us a message and we\'ll respond as soon as possible.', NULL, NULL, 'FRP Elephant Statue', 'statues', 'FRP (Fiberglass Reinforced Plastic)', '4.5 Feet', '15000.00', NULL, NULL, NULL, 'Dark Brown / Charcoal', 'Metallic Lacquered Finish', NULL, NULL, '2026-07-17 10:20:24'),
(10, 'Rohit Rajendra Kanekar', '9029999120', 'kanekarrohit26@gmail.com', 'Classic Park Concrete Bench', 'Send us a message and we\'ll respond as soon as possible.', NULL, NULL, 'Classic Park Concrete Bench', 'benches', 'Precast Concrete', '3 Feet', '7500.00', NULL, NULL, NULL, 'Granite Grey', 'Smooth Matte', NULL, NULL, '2026-07-17 10:23:54'),
(11, 'Rohit Rajendra Kanekar', '9029999120', 'kanekarrohit26@gmail.com', 'Modernist Plaza Concrete Bench', 'Modernist Plaza Concrete Bench', NULL, NULL, 'Modernist Plaza Concrete Bench', 'benches', 'Precast Concrete', '3 Feet', '7500.00', NULL, NULL, NULL, 'Bright Orange', 'Acid Washed', NULL, NULL, '2026-07-17 10:32:21'),
(12, 'Rohit Rajendra Kanekar', '9029999120', 'kanekarrohit26@gmail.com', 'Matrix FRP Planter MX2S9', 'Matrix FRP Planter MX2S9', NULL, NULL, 'Matrix FRP Planter MX2S9', 'planters', 'FRP (Fiber Reinforced Plastic)', 'Large', '13213.00', '350 mm (14\")', '350 mm (14\")', '1210 mm (49\")', 'Customizable', 'Matte', NULL, NULL, '2026-07-17 10:33:36'),
(13, 'Rohit Rajendra Kanekar', '9029999120', 'kanekarrohit26@gmail.com', 'Matrix FRP Planter MX4R41', 'Send us a message and we\'ll respond as soon as possible.', NULL, NULL, 'Matrix FRP Planter MX4R41', 'planters', 'FRP (Fiber Reinforced Plastic)', 'Medium', '5906.00', '430 mm (17\")', '430 mm (17\")', '470 mm (19\")', 'Customizable', 'Stone Texture', NULL, NULL, '2026-07-17 10:46:17'),
(14, 'Rohit Rajendra Kanekar', '9029999120', 'kanekarrohit26@gmail.com', 'Matrix FRP Planter MX3R2', 'Matrix FRP Planter MX3R2', NULL, NULL, 'Matrix FRP Planter MX3R2', 'planters', 'FRP (Fiber Reinforced Plastic)', 'Large', '5844.00', '530 mm (21\")', '530 mm (21\")', '250 mm (10\")', 'Customizable', 'Matte', NULL, NULL, '2026-07-17 12:06:54'),
(15, 'Rohit Rajendra Kanekar', '9029999120', 'kanekarrohit26@gmail.com', 'Bench', 'We welcome you to visit our office and explore our premium range of architectural concrete products, GRC solutions, FRP products, landscape furniture, and customized outdoor décor.', NULL, NULL, 'Matrix FRP Planter MX3R2', 'planters', 'FRP (Fiber Reinforced Plastic)', 'Large', '5844.00', '530 mm (21\")', '530 mm (21\")', '250 mm (10\")', 'Customizable', 'Matte', NULL, NULL, '2026-07-17 12:21:15'),
(16, 'Rohit Rajendra Kanekar', '9029999120', 'kanekarrohit26@gmail.com', 'Quotation', 'We\'d love to hear from you\nSend us a message and we\'ll respond as soon as possible.', NULL, NULL, 'Matrix FRP Planter MX3R2', 'planters', 'FRP (Fiber Reinforced Plastic)', 'Large', '5844.00', '530 mm (21\")', '530 mm (21\")', '250 mm (10\")', 'Customizable', 'Matte', NULL, NULL, '2026-07-17 12:24:29'),
(17, 'Rohit Rajendra Kanekar', '9029999120', 'kanekarrohit26@gmail.com', 'Quotation', 'Send us a message and we\'ll respond as soon as possible.', NULL, NULL, 'Radha Krishna Statue', 'statues', 'Premium White Alabaster Marble', '8 x 9 Inch', '35000.00', NULL, NULL, NULL, 'Light Blue, Yellow and Green', 'Polished Gloss with Hand-painted Details', NULL, NULL, '2026-07-17 12:27:36'),
(18, 'Rohit Rajendra Kanekar', '9029999120', 'kanekarrohit26@gmail.com', 'Matrix FRP Planter MX4R5', 'Send us a message and we\'ll respond as soon as possible.', NULL, NULL, 'Matrix FRP Planter MX4R5', 'planters', 'FRP (Fiber Reinforced Plastic)', 'Large', '10381.00', '450 mm (18\")', '450 mm (18\")', '650 mm (26\")', 'Customizable', 'Matte', NULL, NULL, '2026-07-17 12:32:34'),
(19, 'Rohit Rajendra Kanekar', '9029999120', 'kanekarrohit26@gmail.com', 'Matrix FRP Planter MX2S9', 'Send us a message and we\'ll respond as soon as possible.', NULL, NULL, 'Matrix FRP Planter MX2S9', 'planters', 'FRP (Fiber Reinforced Plastic)', 'Large', '13213.00', '350 mm (14\")', '350 mm (14\")', '1210 mm (49\")', 'Customizable', 'Matte', NULL, NULL, '2026-07-17 12:36:42'),
(20, 'bharat', '9867704727', 'contact.concreteartsindia@gmail.com', 'grc jaali', 'grc material', NULL, NULL, 'White Architectural GRC Jali', 'grc', 'Glass Reinforced Concrete', 'Custom', '450.00', NULL, NULL, NULL, 'Terracotta / Light Red Sandstone', 'Smooth Matte', NULL, NULL, '2026-07-17 12:50:40'),
(21, 'Rohit Rajendra Kanekar', '9029999120', 'kanekarrohit26@gmail.com', 'Modernist Plaza Concrete Bench', 'We\'d love to hear from you\nSend us a message and we\'ll respond as soon as possible.', NULL, NULL, 'Modernist Plaza Concrete Bench', 'benches', 'Precast Concrete', '3 Feet', '7500.00', NULL, NULL, NULL, 'Bright Orange', 'Acid Washed', NULL, NULL, '2026-07-17 13:01:44'),
(22, 'Rohit Rajendra Kanekar', '9029999120', 'kanekarrohit26@gmail.com', 'Matrix FRP Planter MX3R1', 'Send us a message and we\'ll respond as soon as possible.', NULL, NULL, 'Matrix FRP Planter MX3R1', 'planters', 'FRP (Fiber Reinforced Plastic)', 'Medium', '4538.00', '310 mm (13\")', '310 mm (13\")', '400 mm (16\")', 'Customizable', 'Matte', NULL, NULL, '2026-07-18 04:14:31'),
(23, 'Rohit Rajendra Kanekar', '9029999120', 'kanekarrohit26@gmail.com', 'Matrix FRP Planter MX1S8', 'We\'d love to hear from you\nSend us a message and we\'ll respond as soon as possible.', NULL, NULL, 'Matrix FRP Planter MX1S8', 'planters', 'FRP (Fiber Reinforced Plastic)', 'Large', '25250.00', '450 mm (18\")', '450 mm (18\")', '1510 mm (61\")', 'Customizable', 'Matte', NULL, NULL, '2026-07-18 05:09:43'),
(24, 'Rohit Rajendra Kanekar', '9029999120', 'kanekarrohit26@gmail.com', 'Matrix FRP Planter MX3R1', 'Matrix FRP Planter MX3R1', NULL, NULL, 'Matrix FRP Planter MX3R1', 'planters', 'FRP (Fiber Reinforced Plastic)', 'Large', '7563.00', '450 mm (18\")', '450 mm (18\")', '520 mm (21\")', 'Customizable', 'Matte', NULL, NULL, '2026-07-18 05:31:26'),
(25, 'Rohit Rajendra Kanekar', '9029999120', 'kanekarrohit26@gmail.com', 'Matrix FRP Planter MX3R1', 'We\'d love to hear from you\nSend us a message and we\'ll respond as soon as possible.', NULL, NULL, 'Matrix FRP Planter MX3R1', 'planters', 'FRP (Fiber Reinforced Plastic)', 'Large', '7563.00', '450 mm (18\")', '450 mm (18\")', '520 mm (21\")', 'Customizable', 'Matte', NULL, NULL, '2026-07-18 05:33:49'),
(26, 'Rohit Rajendra Kanekar', '9029999120', 'kanekarrohit26@gmail.com', 'Matrix FRP Planter MX3R1', 'We\'d love to hear from you\nSend us a message and we\'ll respond as soon as possible.', NULL, NULL, 'Matrix FRP Planter MX3R1', 'planters', 'FRP (Fiber Reinforced Plastic)', 'Large', '7563.00', '450 mm (18\")', '450 mm (18\")', '520 mm (21\")', 'Customizable', 'Matte', NULL, NULL, '2026-07-18 05:36:42'),
(27, 'Rohit Rajendra Kanekar', '9029999120', 'kanekarrohit26@gmail.com', 'Quotation', 'We\'d love to hear from you\nSend us a message and we\'ll respond as soon as possible.', NULL, NULL, 'Matrix FRP Planter MX3R1', 'planters', 'FRP (Fiber Reinforced Plastic)', 'Large', '7563.00', '450 mm (18\")', '450 mm (18\")', '520 mm (21\")', 'Customizable', 'Matte', NULL, NULL, '2026-07-18 05:39:17'),
(28, 'Rohit Rajendra Kanekar', '9029999120', 'kanekarrohit26@gmail.com', 'Matrix FRP Planter MX3R1', 'We\'d love to hear from you\nSend us a message and we\'ll respond as soon as possible.', NULL, NULL, 'Matrix FRP Planter MX3R1', 'planters', 'FRP (Fiber Reinforced Plastic)', 'Large', '7563.00', '450 mm (18\")', '450 mm (18\")', '520 mm (21\")', 'Customizable', 'Matte', NULL, NULL, '2026-07-18 05:44:40'),
(29, 'Rohit Rajendra Kanekar', '9029999120', 'kanekarrohit26@gmail.com', 'Get In Touch', 'We\'d love to hear from you\nSend us a message and we\'ll respond as soon as possible.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-07-18 05:51:44'),
(31, 'Rohit Rajendra Kanekar', '9029999120', 'kanekarrohit26@gmail.com', 'Classic Park Concrete Bench', 'Classic Park Concrete Bench', NULL, NULL, 'Classic Park Concrete Bench', 'benches', 'Precast Concrete', '3 Feet', '7500.00', NULL, NULL, NULL, 'Granite Grey', 'Smooth Matte', NULL, NULL, '2026-07-18 05:52:55'),
(32, 'Rohit Rajendra Kanekar', '9029999120', 'kanekarrohit26@gmail.com', 'Quotation', 'New enquiry', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-07-18 05:54:35'),
(33, 'Rohit Rajendra Kanekar', '9029999120', 'kanekarrohit26@gmail.com', 'Executive Slatted Concrete Bench', 'We\'d love to hear from you\nSend us a message and we\'ll respond as soon as possible.', NULL, NULL, 'Executive Slatted Concrete Bench', 'benches', 'Precast Concrete', '4 Feet', '7500.00', NULL, NULL, NULL, 'Grey / Lime Green', 'Slatted Textured', NULL, NULL, '2026-07-18 05:55:40'),
(34, 'Rohit Rajendra Kanekar', '9029999120', 'kanekarrohit26@gmail.com', 'Get In Touch', 'We\'d love to hear from you\nSend us a message and we\'ll respond as soon as possible.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-07-18 05:59:13'),
(37, 'Rohit Rajendra Kanekar', '9029999120', 'kanekarrohit26@gmail.com', 'New Website Enquiry 22 July', 'We\'d love to hear from you\nSend us a message and we\'ll respond as soon as possible.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-07-22 06:22:51'),
(40, 'Rohit Kanekar', '9029999120', 'kanekarrohit26@gmail.com', 'Testing', 'This is a backend test.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-07-22 11:03:24'),
(41, 'Rohit Kanekar', '9029999120', 'kanekarrohit26@gmail.com', 'Testing', 'This is a backend test.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-07-22 11:06:06'),
(42, 'Rohit Kanekar', '9029999120', 'kanekarrohit26@gmail.com', 'Testing', 'This is a backend test.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-07-22 11:22:59'),
(43, 'Rohit Rajendra Kanekar', '9029999120', 'kanekarrohit26@gmail.com', '23 July 26 Enquiry', 'We\'d love to hear from you\nSend us a message and we\'ll respond as soon as possible.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-07-23 07:37:05'),
(44, 'Rohit Rajendra Kanekar', '9029999120', 'kanekarrohit26@gmail.com', 'Quotation', 'We\'d love to hear from you\nSend us a message and we\'ll respond as soon as possible.', NULL, NULL, 'Velvet FRP Planter VT3R62', 'planters', 'FRP (Fiber Reinforced Plastic)', 'Large', '7920.00', '500 mm (20)', '500 mm (20)', '380 mm (15)', 'Customizable', 'Velvet Texture', NULL, NULL, '2026-07-23 09:23:42'),
(45, 'Rohit Rajendra Kanekar', '9029999120', 'kanekarrohit26@gmail.com', 'Velvet FRP Planter VT3R62', 'We\'d love to hear from you\nSend us a message and we\'ll respond as soon as possible.', NULL, NULL, 'Velvet FRP Planter VT3R62', 'planters', 'FRP (Fiber Reinforced Plastic)', 'Large', '7920.00', '500 mm (20)', '500 mm (20)', '380 mm (15)', 'Customizable', 'Velvet Texture', NULL, NULL, '2026-07-23 09:30:15'),
(46, 'Rohit Rajendra Kanekar', '9029999120', 'kanekarrohit26@gmail.com', 'Velvet FRP Planter VT3R62', 'We\'d love to hear from you\nSend us a message and we\'ll respond as soon as possible.', NULL, NULL, 'Velvet FRP Planter VT3R62', 'planters', 'FRP (Fiber Reinforced Plastic)', 'Large', '7920.00', '500 mm (20)', '500 mm (20)', '380 mm (15)', 'Customizable', 'Velvet Texture', NULL, NULL, '2026-07-23 09:35:06'),
(47, 'Rohit Rajendra Kanekar', '9029999120', 'kanekarrohit26@gmail.com', 'Velvet FRP Planter VT3R62', 'We\'d love to hear from you\nSend us a message and we\'ll respond as soon as possible.', NULL, NULL, 'Velvet FRP Planter VT3R62', 'planters', 'FRP (Fiber Reinforced Plastic)', 'Large', '7920.00', '500 mm (20)', '500 mm (20)', '380 mm (15)', 'Customizable', 'Velvet Texture', NULL, NULL, '2026-07-23 09:36:51'),
(50, 'Rohit Rajendra Kanekar', '9029999120', 'kanekarrohit26@gmail.com', 'Radha Krishna Statue', 'We\'d love to hear from you\nSend us a message and we\'ll respond as soon as possible.', NULL, NULL, 'Radha Krishna Statue', 'statues', 'Premium White Alabaster Marble', '', '50000.00', NULL, NULL, NULL, 'Light Blue, Yellow and Green', 'Polished Gloss with Hand-painted Details', 'http://concreteartsindia.infinityfree.io/images/products/statues/radha-krishna-statue.webp', NULL, '2026-07-24 04:59:49'),
(51, 'Rohit Rajendra Kanekar', '9029999120', 'kanekarrohit26@gmail.com', 'Velvet FRP Planter VT4R61', 'We\'d love to hear from you\nSend us a message and we\'ll respond as soon as possible.', NULL, NULL, 'Velvet FRP Planter VT4R61', 'planters', 'FRP (Fiber Reinforced Plastic)', 'Large', '9023.00', '550 mm (22)', '550 mm (22)', '520 mm (20)', 'Customizable', 'Velvet Texture', 'http://concreteartsindia.infinityfree.io/images/products/planters/planter92.webp', NULL, '2026-07-24 05:04:07'),
(52, 'Rohit Rajendra Kanekar', '9029999120', 'kanekarrohit26@gmail.com', 'Royal FRP Planter RY3R57', 'We\'d love to hear from you\nSend us a message and we\'ll respond as soon as possible.', NULL, NULL, 'Royal FRP Planter RY3R57', 'planters', 'FRP (Fiber Reinforced Plastic)', 'Large', '5657.00', '550 mm (22)', '550 mm (22)', '250 mm (10)', 'Customizable', 'Royal Stone Texture', 'http://concreteartsindia.infinityfree.io/images/products/planters/planter88.webp', NULL, '2026-07-24 05:06:21'),
(53, 'Rohit Rajendra Kanekar', '9029999120', 'kanekarrohit26@gmail.com', 'Metro Transit Concrete Bench', 'We\'d love to hear from you\nSend us a message and we\'ll respond as soon as possible.', NULL, NULL, 'Metro Transit Concrete Bench', 'benches', 'Precast Concrete', '', '7500.00', NULL, NULL, NULL, 'Muted Purple-Brown / Mahogany', 'Ultra Smooth Anti-graffiti', 'http://concreteartsindia.infinityfree.io/images/products/benches/bench12.webp', NULL, '2026-07-24 05:08:21'),
(54, 'Rohit Rajendra Kanekar', '9029999120', 'kanekarrohit26@gmail.com', 'Quotation', 'We\'d love to hear from you\nSend us a message and we\'ll respond as soon as possible.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-07-24 05:14:22'),
(55, 'Rohit Rajendra Kanekar', '9029999120', 'kanekarrohit26@gmail.com', 'Meadow View Concrete Bench', 'We\'d love to hear from you\nSend us a message and we\'ll respond as soon as possible.', NULL, NULL, 'Meadow View Concrete Bench', 'benches', 'Precast Concrete', '', '7500.00', NULL, NULL, NULL, 'Reddish Brown / Terracotta', 'Natural Textured', 'http://concreteartsindia.infinityfree.io/images/products/benches/bench13.webp', NULL, '2026-07-24 05:15:16'),
(65, 'Rohit Rajendra Kanekar', '9029999120', 'kanekarrohit26@gmail.com', 'Quotation', 'Vista Point Concrete Bench', 'Tembhipada Road\nAbove Pipeline', 'Instagram', 'Vista Point Concrete Bench', 'benches', 'Precast Concrete', '', '7500.00', NULL, NULL, NULL, 'Dark Timber Brown', 'Polished Terrazzo Style', 'https://concreteartsindia.infinityfree.io/images/products/benches/bench10.webp', NULL, '2026-07-25 05:23:51'),
(66, 'Rohit Rajendra Kanekar', '9029999120', 'kanekarrohit26@gmail.com', 'Quotation', 'Send us a message and we\'ll respond as soon as possible.', 'Tembhipada Road\nAbove Pipeline', 'Facebook', 'Velvet FRP Planter VT3R64', 'planters', 'FRP (Fiber Reinforced Plastic)', 'Small', '8195.00', '230 mm (9)', '230 mm (9)', '260 mm (10)', 'Customizable', 'Velvet Texture', 'https://concreteartsindia.infinityfree.io/images/products/planters/planter95.webp', NULL, '2026-07-25 05:27:12'),
(67, 'Rohit Rajendra Kanekar', '9029999120', 'kanekarrohit26@gmail.com', 'Quotation', 'Velvet FRP Planter VT3R64', 'Tembhipada Road\nAbove Pipeline', 'Instagram', 'Velvet FRP Planter VT3R64', 'planters', 'FRP (Fiber Reinforced Plastic)', 'Small', '8195.00', '230 mm (9)', '230 mm (9)', '260 mm (10)', 'Customizable', 'Velvet Texture', 'https://concreteartsindia.infinityfree.io/images/products/planters/planter95.webp', NULL, '2026-07-25 06:30:57'),
(68, 'Rohit Rajendra Kanekar', '9029999120', 'kanekarrohit26@gmail.com', 'Quotation', 'We\'d love to hear from you\nSend us a message and we\'ll respond as soon as possible.', 'Tembhipada Road\nAbove Pipeline', 'YouTube', 'Velvet FRP Planter VT3R64', 'planters', 'FRP (Fiber Reinforced Plastic)', 'Small', '2980.00', '230 mm (9)', '230 mm (9)', '260 mm (10)', 'Customizable', 'Velvet Texture', 'https://concreteartsindia.infinityfree.io/images/products/planters/planter95.webp', NULL, '2026-07-25 06:34:26');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `sku` varchar(100) DEFAULT NULL,
  `item_code` varchar(100) DEFAULT NULL,
  `catalog` varchar(100) DEFAULT NULL,
  `series` varchar(100) DEFAULT NULL,
  `description` longtext DEFAULT NULL,
  `material` varchar(100) DEFAULT NULL,
  `shape` varchar(100) DEFAULT NULL,
  `color` varchar(100) DEFAULT NULL,
  `finish` varchar(100) DEFAULT NULL,
  `thumbnail` varchar(255) DEFAULT NULL,
  `featured` tinyint(1) DEFAULT 0,
  `status` tinyint(1) DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `category_id`, `name`, `slug`, `sku`, `item_code`, `catalog`, `series`, `description`, `material`, `shape`, `color`, `finish`, `thumbnail`, `featured`, `status`, `created_at`, `updated_at`) VALUES
(1, 8, 'White Architectural GRC Jali', 'white-architectural-grc-jali', '', '', '', '', 'Premium White GRC Jali manufactured using high-grade Glass Reinforced Concrete. Ideal for luxury building façades, balconies, compound walls, and striking architectural elevations. Highly lightweight, durable, and suitable for both indoor and outdoor applications.', 'Glass Reinforced Concrete', '', 'Terracotta / Light Red Sandstone', 'Smooth Matte', 'images/products/grc/grc1.webp', 0, 1, '2026-07-18 12:54:02', '2026-07-18 12:54:02'),
(2, 8, 'Geometric Cube GRC Jali (100mm)', 'geometric-cube-grc-jali-100mm', '', '', '', '', 'A modern geometric GRC Jali showcasing a cubical matrix. Designed for cutting-edge contemporary architectural projects, this pattern provides exceptional ventilation and unique shadow-casting while keeping modern structures cool.', 'Glass Reinforced Concrete', '', 'Natural Cement Grey / Cool Slate Grey', 'Concrete Raw Finish', 'images/products/grc/grc2.webp', 0, 1, '2026-07-18 12:54:02', '2026-07-18 12:54:02'),
(3, 8, 'Islamic Lattice GRC Jali (100mm)', 'islamic-lattice-grc-jali-100mm', '', '', '', '', 'Features a classic, intricate Islamic geometric star-and-lattice layout. This highly artistic GRC panel brings a traditional heritage touch to modern mosques, premium villas, and spiritual institutional architectures.', 'Glass Reinforced Concrete', '', 'Off-White / Cream', 'Fine Sandblast', 'images/products/grc/grc3.webp', 0, 1, '2026-07-18 12:54:02', '2026-07-18 12:54:02'),
(4, 8, 'Diamond Mesh GRC Jali (100mm)', 'diamond-mesh-grc-jali-100mm', '', '', '', '', 'An elegant, continuous diamond crisscross pattern that provides a perfect balance of privacy and natural illumination. Excellent choice for multi-story office building exteriors and residential balcony panels.', 'Glass Reinforced Concrete', '', 'Off-White / Crisp White', 'Natural Exposed Concrete', 'images/products/grc/grc4.webp', 0, 1, '2026-07-18 12:54:02', '2026-07-18 12:54:02'),
(5, 8, 'Contemporary Square GRC Jali (100mm)', 'contemporary-square-grc-jali-100mm', '', '', '', '', 'Symmetrical modern grid layout optimized for clean lines and high-speed air circulation. Highly suitable for structural ventilation ducts, HVAC shafts, parking lot screens, and loft interior partitions.', 'Glass Reinforced Concrete', '', 'Terracotta / Light Red Sandstone', 'Smooth Concrete', 'images/products/grc/grc5.webp', 0, 1, '2026-07-18 12:54:02', '2026-07-18 12:54:02'),
(6, 8, 'Linear Stripes GRC Jali (100mm)', 'linear-stripes-grc-jali-100mm', '', '', '', '', 'Features clean, repetitive parallel linear cutouts. Acts as a brilliant architectural sunshade/louver system that reduces indoor HVAC cooling loads by cutting down direct solar heat gain.', 'Glass Reinforced Concrete', '', 'Off-White / Ivory White', 'Acid Washed', 'images/products/grc/grc6.webp', 0, 1, '2026-07-18 12:54:02', '2026-07-18 12:54:02'),
(7, 8, 'Classic Cross GRC Jali (100mm)', 'classic-cross-grc-jali-100mm', '', '', '', '', 'A classic cross (X-pattern) layout reminiscent of vintage colonial structures and Mediterranean villas. Blends effortlessly with earthy landscape stones and rustic boundary wall designs.', 'Glass Reinforced Concrete', '', 'Muted Mustard Yellow / Ochre', 'Textured Stone Finish', 'images/products/grc/grc7.webp', 0, 1, '2026-07-18 12:54:02', '2026-07-18 12:54:02'),
(8, 8, 'Star Matrix GRC Jali (100mm)', 'star-matrix-grc-jali-100mm', '', '', '', '', 'A dense, geometric arrangement of interlocking stars. Specifically engineered as an accent design element for luxurious hotel lobbies, wedding venues, and high-profile residential entry structures.', 'Glass Reinforced Concrete', '', 'Pure White', 'Satin Smooth', 'images/products/grc/grc8.webp', 0, 1, '2026-07-18 12:54:02', '2026-07-18 12:54:02'),
(9, 8, 'Hexagonal Cellular GRC Jali (100mm)', 'hexagonal-cellular-grc-jali-100mm', '', '', '', '', 'An organic, honeycomb-inspired cell pattern. Combining biophilic design principles with structural concrete durability, it is highly favored for certified green building designs and IT park installations.', 'Glass Reinforced Concrete', '', 'Beige / Light Sandstone', 'Industrial Matte', 'images/products/grc/grc9.webp', 0, 1, '2026-07-18 12:54:02', '2026-07-18 12:54:02'),
(10, 3, 'Classic Park Concrete Bench', 'classic-park-concrete-bench-without-arm-rest', '', '', '', '', 'Premium precast concrete bench manufactured for traditional outdoor parks, public gardens, and open landscapes. Designed with an ergonomic backrest for comfortable public seating and long-lasting elemental durability.', 'Precast Concrete', '', 'Granite Grey', 'Smooth Matte', 'images/products/benches/bench1.webp', 0, 1, '2026-07-18 12:54:02', '2026-07-18 12:54:02'),
(11, 3, 'Executive Slatted Concrete Bench', 'executive-slatted-concrete-bench-with-arm-rest', '', '', '', '', 'Heavy-duty precast concrete bench with integrated armrests and structured slat-back design. Perfect choice for elite commercial property entries, urban spaces, corporate courtyards, and premium residential layouts.', 'Precast Concrete', '', 'Grey / Lime Green', 'Slatted Textured', 'images/products/benches/bench2.webp', 0, 1, '2026-07-18 12:54:02', '2026-07-18 12:54:02'),
(12, 3, 'Contemporary Garden Concrete Bench', 'contemporary-garden-concrete-bench', '', '', '', '', 'Sleek and minimalist modern concrete bench curated explicitly for high-end boutique hotels, modern residential villa lawns, and contemporary architecture landscapes.', 'Precast Concrete', '', 'Dark Blue / Navy', 'Polished Gloss', 'images/products/benches/bench3.webp', 0, 1, '2026-07-18 12:54:02', '2026-07-18 12:54:02'),
(13, 3, 'Urban Landscape Concrete Bench', 'urban-landscape-concrete-bench', '', '', '', '', 'Robust structural bench engineered to withstand massive daily foot traffic loads in metro stations, public plazas, urban streetscapes, and busy downtown walkways.', 'Precast Concrete', '', 'Light Purple / Lavender', 'Industrial Rough', 'images/products/benches/bench4.webp', 0, 1, '2026-07-18 12:54:02', '2026-07-18 12:54:02'),
(14, 3, 'Traditional Boulevard Concrete Bench', 'traditional-boulevard-concrete-bench', '', '', '', '', 'Features a classic European boulevard aesthetic with a warm terracotta clay tint color profile. Perfectly fits heritage pathways, walking trails, and botanical gardens.', 'Precast Concrete', '', 'Dark Slate Grey / Teal Grey', 'Rustic Matte', 'images/products/benches/bench5.webp', 0, 1, '2026-07-18 12:54:02', '2026-07-18 12:54:02'),
(15, 3, 'Modernist Plaza Concrete Bench', 'modernist-plaza-concrete-bench', '', '', '', '', 'Features a striking geometric presentation with an acid-washed finish texture that reveals subtle underlying aggregates. Enhances museums, high-tech parks, and corporate plazas.', 'Precast Concrete', '', 'Bright Orange', 'Acid Washed', 'images/products/benches/bench6.webp', 0, 1, '2026-07-18 12:54:02', '2026-07-18 12:54:02'),
(16, 3, 'Ornate Heritage Concrete Bench', 'ornate-heritage-concrete-bench', '', '', '', '', 'Designed with deep artistic moldings on the structural legs and back frame panel, echoing old-world luxury Indian palace architectural patterns.', 'Precast Concrete', '', 'Dark Greyish-Brown', 'Intricately Molded Antique', 'images/products/benches/bench7.webp', 0, 1, '2026-07-18 12:54:02', '2026-07-18 12:54:02'),
(17, 3, 'Rustic Parkside Concrete Bench', 'rustic-parkside-concrete-bench', '', '', '', '', 'Offers the warm, traditional visual appeal of a thick natural timber plank structure combined with the lifetime permanence and zero-rot capability of reinforced precast concrete.', 'Precast Concrete', '', 'Turquoise / Aqua Teal', 'Faux Wood-Grain Textured', 'images/products/benches/bench8.webp', 0, 1, '2026-07-18 12:54:02', '2026-07-18 12:54:02'),
(18, 3, 'Eco-Lite Garden Concrete Bench', 'eco-lite-garden-concrete-bench', '', '', '', '', 'A smart, cost-effective lightweight concrete composite model variation designed for easy shifting and flexible backyard installations without needing crane cranes or heavy crews.', 'Lightweight Precast Composite', '', 'Dark Timber Brown', 'Smooth Pored Fine Finish', 'images/products/benches/bench9.webp', 0, 1, '2026-07-18 12:54:02', '2026-07-18 12:54:02'),
(19, 3, 'Vista Point Concrete Bench', 'vista-point-concrete-bench', '', '', '', '', 'Perfect seating match for high altitude mountain view points, coastal marine drive promenades, and scenic highway overlook stops.', 'Precast Concrete', '', 'Dark Timber Brown', 'Polished Terrazzo Style', 'images/products/benches/bench10.webp', 0, 1, '2026-07-18 12:54:02', '2026-07-18 12:54:02'),
(20, 3, 'Compact Courtyard Concrete Bench', 'compact-courtyard-concrete-bench', '', '', '', '', 'A specially shortened spatial layout design configuration optimized for tight urban balconies, small rooftop gardens, patio paths, and narrow home courtyard corners.', 'Precast Concrete', '', 'Dark Timber Brown', 'Satin Soft Finish', 'images/products/benches/bench11.webp', 0, 1, '2026-07-18 12:54:02', '2026-07-18 12:54:02'),
(21, 3, 'Metro Transit Concrete Bench', 'metro-transit-concrete-bench', '', '', '', '', 'Utility grade infrastructure bench with anti-graffiti top layering designed intentionally for bus terminals, train railway platforms, and public transport interchanges.', 'Precast Concrete', '', 'Muted Purple-Brown / Mahogany', 'Ultra Smooth Anti-graffiti', 'images/products/benches/bench12.webp', 0, 1, '2026-07-18 12:54:02', '2026-07-18 12:54:02'),
(22, 3, 'Meadow View Concrete Bench', 'meadow-view-concrete-bench', '', '', '', '', 'Features organic styling curves and muted raw earth blend coloration to disappear effortlessly into natural farmhouse orchards, large meadows, and organic fields.', 'Precast Concrete', '', 'Reddish Brown / Terracotta', 'Natural Textured', 'images/products/benches/bench13.webp', 0, 1, '2026-07-18 12:54:02', '2026-07-18 12:54:02'),
(23, 3, 'Commercial Promenade Concrete Bench', 'commercial-promenade-concrete-bench', '', '', '', '', 'Premium industrial grade shopping mall boardwalk seating. Clean lines with a micro quartz particle reflective configuration that shimmers under nighttime public streetlights.', 'Precast Concrete', '', 'Dark Timber Brown', 'Semi-gloss Fine aggregate', 'images/products/benches/bench14.webp', 0, 1, '2026-07-18 12:54:02', '2026-07-18 12:54:02'),
(24, 3, 'Minimalist Esplanade Concrete Bench', 'minimalist-esplanade-concrete-bench', '', '', '', '', 'Eliminates all visual clutter. A perfectly balanced crisp design offering high performance minimal profiles ideal for open art exhibition lawns and upscale smart-city spaces.', 'Precast Concrete', '', 'Dark Charcoal Grey / Timber Brown', 'Ultra Fine Sandblast', 'images/products/benches/bench15.webp', 0, 1, '2026-07-18 12:54:02', '2026-07-18 12:54:02'),
(25, 3, 'Botanical Sanctuary Concrete Bench', 'botanical-sanctuary-concrete-bench', '', '', '', '', 'Tailored visually for floral hot-houses, botanical sanctuaries, and private rose gardens. Coloration prevents high glare under direct bright greenhouse solar glass arrays.', 'Precast Concrete', '', 'Natural Cement Grey / Light Grey', 'Soft Leaf Stamped Texture', 'images/products/benches/bench16.webp', 0, 1, '2026-07-18 12:54:02', '2026-07-18 12:54:02'),
(26, 6, 'FRP Elephant Statue', 'frp-elephant-statue', '', '', '', '', 'Exquisite royal heritage FRP Elephant Statue cast in high-density Fiberglass Reinforced Plastic. Showcases intricate traditional Indian ceremonial drapery details, meticulously finished in weathered bronze and gold leaf paint. Highly weather-proof and structured for grand outdoor entranceways.', 'FRP (Fiberglass Reinforced Plastic)', '', 'Dark Brown / Charcoal', 'Metallic Lacquered Finish', 'images/products/statues/frp-elephant-statue.webp', 0, 1, '2026-07-18 12:54:02', '2026-07-18 12:54:02'),
(27, 6, 'Radha Krishna Statue', 'radha-krishna-statue', '', '', '', '', 'Divine Radha Krishna Murti hand-carved from select single-block white alabaster marble. Highlighted with soft sky blue garments and fine gold-lining brushwork, this piece brings peaceful spiritual energy to residential altars and temples alike.', 'Premium White Alabaster Marble', '', 'Light Blue, Yellow and Green', 'Polished Gloss with Hand-painted Details', 'images/products/statues/radha-krishna-statue.webp', 0, 1, '2026-07-18 12:54:02', '2026-07-18 12:54:02'),
(28, 6, 'FRP Meditating Buddha Statue', 'frp-meditating-buddha-statue', '', '', '', '', 'Zen-inspired sitting Meditating Buddha Statue cast in high-grade lightweight FRP. Finished with a natural sandstone texture that perfectly mimics heavy stone block carvings without the weight, making it a stellar addition to peaceful outdoor garden walks.', 'FRP (Fiber Reinforced Plastic)', '', 'Metallic Bronze / Copper', 'Matte Stone Textured', 'images/products/statues/buddha-statue-1.webp', 0, 1, '2026-07-18 12:54:02', '2026-07-18 12:54:02'),
(29, 6, 'FRP Dhyana Mudra Buddha Statue', 'frp-dhyana-mudra-buddha-statue', '', '', '', '', 'Stunning Dhyana Mudra Buddha statue capturing the classic hand gesture of deep concentration. Cast using robust fiberglass resins and finished with an antique verdigris copper patina that beautifully matches outdoor flora and water fountain bodies.', 'FRP (Fiber Reinforced Plastic)', '', 'Soft Peach / Light Orange', 'Verdigris Metallic Patina', 'images/products/statues/buddha-statue-2.webp', 0, 1, '2026-07-18 12:54:02', '2026-07-18 12:54:02'),
(30, 6, 'FRP Meditating Shiva Statue (6ft)', 'frp-meditating-shiva-statue-6ft', '', '', '', '', 'Grand 6-foot tall representation of Lord Shiva sitting in deep Himalayan padmasana dhyāna. Engineered utilizing premium-grade, reinforced fiberglass fibers to survive intense summer sun, rainfall, and winter frost without cracking.', 'FRP (Fiber Reinforced Plastic)', '', 'Metallic Copper / Rose Gold', 'Stone Matte Wash', 'images/products/statues/shiva-1.webp', 0, 1, '2026-07-18 12:54:02', '2026-07-18 12:54:02'),
(31, 6, 'FRP Blessing Lord Shiva Statue', 'frp-blessing-lord-shiva-statue', '', '', '', '', 'Majestic 6-foot Lord Shiva statue showcasing the Abhaya Mudra (blessing of fearlessness). Meticulously hand-colored in warm, earthy terracotta-ochre tones, creating a highly welcoming focal point for yoga schools, health spas, and spiritual sanctuaries.', 'FRP (Fiber Reinforced Plastic)', '', 'Dark Bronze / Metallic Brown', 'Polished Hand-painted Lacquer', 'images/products/statues/shiva-2.webp', 0, 1, '2026-07-18 12:54:02', '2026-07-18 12:54:02'),
(32, 6, 'FRP Adiyogi Style Shiva Statue', 'frp-adiyogi-style-shiva-statue', '', '', '', '', 'Stunning modern Adiyogi-inspired Lord Shiva statue finished in a sleek, solid white tone. Blends ancient yogic iconography with contemporary geometric line carving, making it a beautiful statement piece for modern fitness studios and zen parks.', 'FRP (Fiber Reinforced Plastic)', '', 'Solid White', 'Semi-Gloss Powdered Satin', 'images/products/statues/shiva-3.webp', 0, 1, '2026-07-18 12:54:02', '2026-07-18 12:54:02'),
(33, 6, 'FRP Mahadev Meditation Statue', 'frp-mahadev-meditation-statue', '', '', '', '', 'A breathtaking 6-foot Mahadev meditation sculpture hand-finished in pearlescent alabaster white with subtle blue accenting. Engineered with marine-grade fiberglass resin shells, perfect for humid pool decks and harsh tropical climates.', 'FRP (Fiber Reinforced Plastic)', '', 'Sky Blue', 'Premium Semi-gloss Pearlescent', 'images/products/statues/shiva-4.webp', 0, 1, '2026-07-18 12:54:02', '2026-07-18 12:54:02'),
(34, 9, 'Matrix FRP Planter MX3R1', 'matrix-frp-planter-mx3r1', 'MX3R1', 'MX3R1', 'Catalog I', 'MATRIX SERIES', 'Premium Matrix FRP Planter crafted with lightweight, high-tensile Fiber Reinforced Plastic. Ideal for enhancing luxury residential spaces, corporate offices, hotels, and contemporary outdoor landscaping. Durable construction that effortlessly handles both indoor and outdoor environments.', 'FRP (Fiber Reinforced Plastic)', 'Round', 'Customizable', 'Matte', 'images/products/planters/planter34.webp', 0, 1, '2026-07-18 12:54:02', '2026-07-18 12:54:02'),
(35, 9, 'Matrix FRP Planter MX3R2', 'matrix-frp-planter-mx3r2', 'MX3R2', 'MX3R2', 'Catalog I', 'MATRIX SERIES', 'Premium Matrix FRP Planter crafted with lightweight, high-tensile Fiber Reinforced Plastic. Ideal for enhancing luxury residential spaces, corporate offices, hotels, and contemporary outdoor landscaping. Durable construction that effortlessly handles both indoor and outdoor environments.', 'FRP (Fiber Reinforced Plastic)', 'Round', 'Customizable', 'Matte', 'images/products/planters/planter35.webp', 0, 1, '2026-07-18 12:54:02', '2026-07-18 12:54:02'),
(36, 9, 'Matrix FRP Planter MX3R3', 'matrix-frp-planter-mx3r3', 'MX3R3', 'MX3R3', 'Catalog I', 'MATRIX SERIES', 'Premium Matrix FRP Planter crafted with lightweight, high-tensile Fiber Reinforced Plastic. Ideal for enhancing luxury residential spaces, corporate offices, hotels, and contemporary outdoor landscaping. Durable construction that effortlessly handles both indoor and outdoor environments.', 'FRP (Fiber Reinforced Plastic)', 'Round', 'Customizable', 'Matte', 'images/products/planters/planter36.webp', 0, 1, '2026-07-18 12:54:02', '2026-07-18 12:54:02'),
(37, 9, 'Matrix FRP Planter MX3R4', 'matrix-frp-planter-mx3r4', 'MX3R4', 'MX3R4', 'Catalog I', 'MATRIX SERIES', 'Premium Matrix FRP Planter crafted with lightweight, high-tensile Fiber Reinforced Plastic. Ideal for enhancing luxury residential spaces, corporate offices, hotels, and contemporary outdoor landscaping. Durable construction that effortlessly handles both indoor and outdoor environments.', 'FRP (Fiber Reinforced Plastic)', 'Round', 'Customizable', 'Matte', 'images/products/planters/planter37.webp', 0, 1, '2026-07-18 12:54:02', '2026-07-18 12:54:02'),
(38, 9, 'Matrix FRP Planter MX4R5', 'matrix-frp-planter-mx4r5', 'MX4R5', 'MX4R5', 'Catalog I', 'MATRIX SERIES', 'Premium Matrix FRP Planter crafted with lightweight, high-tensile Fiber Reinforced Plastic. Ideal for enhancing luxury residential spaces, corporate offices, hotels, and contemporary outdoor landscaping. Durable construction that effortlessly handles both indoor and outdoor environments.', 'FRP (Fiber Reinforced Plastic)', 'Round', 'Customizable', 'Matte', 'images/products/planters/planter38.webp', 0, 1, '2026-07-18 12:54:02', '2026-07-18 12:54:02'),
(39, 9, 'Matrix FRP Planter MX3O6', 'matrix-frp-planter-mx3o6', 'MX3O6', 'MX3O6', 'Catalog I', 'MATRIX SERIES', 'Premium Matrix FRP Planter crafted with lightweight, high-tensile Fiber Reinforced Plastic. Ideal for enhancing luxury residential spaces, corporate offices, hotels, and contemporary outdoor landscaping. Durable construction that effortlessly handles both indoor and outdoor environments.', 'FRP (Fiber Reinforced Plastic)', 'Oval', 'Customizable', 'Matte', 'images/products/planters/planter39.webp', 0, 1, '2026-07-18 12:54:02', '2026-07-18 12:54:02'),
(40, 9, 'Matrix FRP Planter MX3R7', 'matrix-frp-planter-mx3r7', 'MX3R7', 'MX3R7', 'Catalog I', 'MATRIX SERIES', 'Premium Matrix FRP Planter crafted with lightweight, high-tensile Fiber Reinforced Plastic. Ideal for enhancing luxury residential spaces, corporate offices, hotels, and contemporary outdoor landscaping. Durable construction that effortlessly handles both indoor and outdoor environments.', 'FRP (Fiber Reinforced Plastic)', 'Round', 'Customizable', 'Matte', 'images/products/planters/planter40.webp', 0, 1, '2026-07-18 12:54:02', '2026-07-18 12:54:02');
INSERT INTO `products` (`id`, `category_id`, `name`, `slug`, `sku`, `item_code`, `catalog`, `series`, `description`, `material`, `shape`, `color`, `finish`, `thumbnail`, `featured`, `status`, `created_at`, `updated_at`) VALUES
(41, 9, 'Matrix FRP Planter MX1S8', 'matrix-frp-planter-mx1s8', 'MX1S8', 'MX1S8', 'Catalog I', 'MATRIX SERIES', 'Premium Matrix FRP Planter crafted with lightweight, high-tensile Fiber Reinforced Plastic. Ideal for enhancing luxury residential spaces, corporate offices, hotels, and contemporary outdoor landscaping. Durable construction that effortlessly handles both indoor and outdoor environments.', 'FRP (Fiber Reinforced Plastic)', 'Square', 'Customizable', 'Matte', 'images/products/planters/planter41.webp', 0, 1, '2026-07-18 12:54:02', '2026-07-18 12:54:02'),
(42, 9, 'Matrix FRP Planter MX2S9', 'matrix-frp-planter-mx2s9', 'MX2S9', 'MX2S9', 'Catalog I', 'MATRIX SERIES', 'Premium Matrix FRP Planter crafted with lightweight, high-tensile Fiber Reinforced Plastic. Ideal for enhancing luxury residential spaces, corporate offices, hotels, and contemporary outdoor landscaping. Durable construction that effortlessly handles both indoor and outdoor environments.', 'FRP (Fiber Reinforced Plastic)', 'Square', 'Customizable', 'Matte', 'images/products/planters/planter42.webp', 0, 1, '2026-07-18 12:54:02', '2026-07-18 12:54:02'),
(43, 9, 'Matrix FRP Planter MX2R37', 'matrix-frp-planter-mx2r37', 'MX2R37', 'MX2R37', 'Catalog II', 'MATRIX SERIES', 'Premium Matrix FRP Planter crafted with lightweight, high-tensile Fiber Reinforced Plastic. Ideal for enhancing luxury residential spaces, corporate offices, hotels, and contemporary outdoor landscaping. Durable construction that effortlessly handles both indoor and outdoor environments.', 'FRP (Fiber Reinforced Plastic)', 'Round', 'Customizable', 'Matte', 'images/products/planters/planter43.webp', 0, 1, '2026-07-18 12:54:02', '2026-07-18 12:54:02'),
(44, 9, 'Rock FRP Planter RC4S10', 'rock-frp-planter-rc4s10', 'RC4S10', 'RC4S10', 'Catalog I', 'ROCK SERIES', 'Premium Rock FRP Planter capturing a detailed organic texture via sturdy Fiber Reinforced Plastic. Perfect for adding a rustic, natural aesthetic to outdoor patios, themed rock gardens, resort landscapes, and modern bohemian indoor spaces.', 'FRP (Fiber Reinforced Plastic)', 'Square', 'Customizable', 'Stone Texture', 'images/products/planters/planter44.webp', 0, 1, '2026-07-18 12:54:02', '2026-07-18 12:54:02'),
(45, 9, 'Rock FRP Planter RC3R11', 'rock-frp-planter-rc3r11', 'RC3R11', 'RC3R11', 'Catalog I', 'ROCK SERIES', 'Premium Rock FRP Planter capturing a detailed organic texture via sturdy Fiber Reinforced Plastic. Perfect for adding a rustic, natural aesthetic to outdoor patios, themed rock gardens, resort landscapes, and modern bohemian indoor spaces.', 'FRP (Fiber Reinforced Plastic)', 'Round', 'Customizable', 'Stone Texture', 'images/products/planters/planter45.webp', 0, 1, '2026-07-18 12:54:02', '2026-07-18 12:54:02'),
(46, 9, 'Rock FRP Planter RC3R12', 'rock-frp-planter-rc3r12', 'RC3R12', 'RC3R12', 'Catalog I', 'ROCK SERIES', 'Premium Rock FRP Planter capturing a detailed organic texture via sturdy Fiber Reinforced Plastic. Perfect for adding a rustic, natural aesthetic to outdoor patios, themed rock gardens, resort landscapes, and modern bohemian indoor spaces.', 'FRP (Fiber Reinforced Plastic)', 'Round', 'Customizable', 'Stone Texture', 'images/products/planters/planter46.webp', 0, 1, '2026-07-18 12:54:02', '2026-07-18 12:54:02'),
(47, 9, 'Rock FRP Planter RC4R13', 'rock-frp-planter-rc4r13', 'RC4R13', 'RC4R13', 'Catalog I', 'ROCK SERIES', 'Premium Rock FRP Planter capturing a detailed organic texture via sturdy Fiber Reinforced Plastic. Perfect for adding a rustic, natural aesthetic to outdoor patios, themed rock gardens, resort landscapes, and modern bohemian indoor spaces.', 'FRP (Fiber Reinforced Plastic)', 'Round', 'Customizable', 'Stone Texture', 'images/products/planters/planter47.webp', 0, 1, '2026-07-18 12:54:02', '2026-07-18 12:54:02'),
(48, 9, 'Rock FRP Planter RC3R14', 'rock-frp-planter-rc3r14', 'RC3R14', 'RC3R14', 'Catalog I', 'ROCK SERIES', 'Premium Rock FRP Planter capturing a detailed organic texture via sturdy Fiber Reinforced Plastic. Perfect for adding a rustic, natural aesthetic to outdoor patios, themed rock gardens, resort landscapes, and modern bohemian indoor spaces.', 'FRP (Fiber Reinforced Plastic)', 'Round', 'Customizable', 'Stone Texture', 'images/products/planters/planter48.webp', 0, 1, '2026-07-18 12:54:02', '2026-07-18 12:54:02'),
(49, 9, 'Rock FRP Planter RC4R15', 'rock-frp-planter-rc4r15', 'RC4R15', 'RC4R15', 'Catalog I', 'ROCK SERIES', 'Premium Rock FRP Planter capturing a detailed organic texture via sturdy Fiber Reinforced Plastic. Perfect for adding a rustic, natural aesthetic to outdoor patios, themed rock gardens, resort landscapes, and modern bohemian indoor spaces.', 'FRP (Fiber Reinforced Plastic)', 'Round', 'Customizable', 'Stone Texture', 'images/products/planters/planter49.webp', 0, 1, '2026-07-18 12:54:02', '2026-07-18 12:54:02'),
(50, 9, 'Rock FRP Planter RC4R16', 'rock-frp-planter-rc4r16', 'RC4R16', 'RC4R16', 'Catalog I', 'ROCK SERIES', 'Premium Rock FRP Planter capturing a detailed organic texture via sturdy Fiber Reinforced Plastic. Perfect for adding a rustic, natural aesthetic to outdoor patios, themed rock gardens, resort landscapes, and modern bohemian indoor spaces.', 'FRP (Fiber Reinforced Plastic)', 'Round', 'Customizable', 'Stone Texture', 'images/products/planters/planter50.webp', 0, 1, '2026-07-18 12:54:02', '2026-07-18 12:54:02'),
(51, 9, 'Rock FRP Planter RC3R17', 'rock-frp-planter-rc3r17', 'RC3R17', 'RC3R17', 'Catalog I', 'ROCK SERIES', 'Premium Rock FRP Planter capturing a detailed organic texture via sturdy Fiber Reinforced Plastic. Perfect for adding a rustic, natural aesthetic to outdoor patios, themed rock gardens, resort landscapes, and modern bohemian indoor spaces.', 'FRP (Fiber Reinforced Plastic)', 'Round', 'Customizable', 'Stone Texture', 'images/products/planters/planter51.webp', 0, 1, '2026-07-18 12:54:02', '2026-07-18 12:54:02'),
(52, 9, 'Rock FRP Planter RC4S18', 'rock-frp-planter-rc4s18', 'RC4S18', 'RC4S18', 'Catalog I', 'ROCK SERIES', 'Premium Rock FRP Planter capturing a detailed organic texture via sturdy Fiber Reinforced Plastic. Perfect for adding a rustic, natural aesthetic to outdoor patios, themed rock gardens, resort landscapes, and modern bohemian indoor spaces.', 'FRP (Fiber Reinforced Plastic)', 'Square', 'Customizable', 'Stone Texture', 'images/products/planters/planter52.webp', 0, 1, '2026-07-18 12:54:02', '2026-07-18 12:54:02'),
(53, 9, 'Rough Stone FRP Planter RO4R19', 'rough-stone-frp-planter-ro4r19', 'RO4R19', 'RO4R19', 'Catalog I', 'ROUGH STONE SERIES', 'Premium Rough Stone FRP Planter delivering a rugged, coarse stone aesthetic using durable Fiber Reinforced Plastic. Designed to seamlessly withstand outdoor exposure in courtyard gardens, architectural entryways, and texturally rich interiors.', 'FRP (Fiber Reinforced Plastic)', 'Round', 'Customizable', 'Stone Texture', 'images/products/planters/planter53.webp', 0, 1, '2026-07-18 12:54:02', '2026-07-18 12:54:02'),
(54, 9, 'Rough Stone FRP Planter RO4S20', 'rough-stone-frp-planter-ro4s20', 'RO4S20', 'RO4S20', 'Catalog I', 'ROUGH STONE SERIES', 'Premium Rough Stone FRP Planter delivering a rugged, coarse stone aesthetic using durable Fiber Reinforced Plastic. Designed to seamlessly withstand outdoor exposure in courtyard gardens, architectural entryways, and texturally rich interiors.', 'FRP (Fiber Reinforced Plastic)', 'Square', 'Customizable', 'Stone Texture', 'images/products/planters/planter54.webp', 0, 1, '2026-07-18 12:54:02', '2026-07-18 12:54:02'),
(55, 9, 'Rough Stone FRP Planter RO4R21', 'rough-stone-frp-planter-ro4r21', 'RO4R21', 'RO4R21', 'Catalog I', 'ROUGH STONE SERIES', 'Premium Rough Stone FRP Planter delivering a rugged, coarse stone aesthetic using durable Fiber Reinforced Plastic. Designed to seamlessly withstand outdoor exposure in courtyard gardens, architectural entryways, and texturally rich interiors.', 'FRP (Fiber Reinforced Plastic)', 'Round', 'Customizable', 'Stone Texture', 'images/products/planters/planter55.webp', 0, 1, '2026-07-18 12:54:02', '2026-07-18 12:54:02'),
(56, 9, 'Rough Stone FRP Planter RO3R22', 'rough-stone-frp-planter-ro3r22', 'RO3R22', 'RO3R22', 'Catalog I', 'ROUGH STONE SERIES', 'Premium Rough Stone FRP Planter delivering a rugged, coarse stone aesthetic using durable Fiber Reinforced Plastic. Designed to seamlessly withstand outdoor exposure in courtyard gardens, architectural entryways, and texturally rich interiors.', 'FRP (Fiber Reinforced Plastic)', 'Round', 'Customizable', 'Stone Texture', 'images/products/planters/planter56.webp', 0, 1, '2026-07-18 12:54:02', '2026-07-18 12:54:02'),
(57, 9, 'Rough Stone FRP Planter RO4R23', 'rough-stone-frp-planter-ro4r23', 'RO4R23', 'RO4R23', 'Catalog I', 'ROUGH STONE SERIES', 'Premium Rough Stone FRP Planter delivering a rugged, coarse stone aesthetic using durable Fiber Reinforced Plastic. Designed to seamlessly withstand outdoor exposure in courtyard gardens, architectural entryways, and texturally rich interiors.', 'FRP (Fiber Reinforced Plastic)', 'Round', 'Customizable', 'Stone Texture', 'images/products/planters/planter57.webp', 0, 1, '2026-07-18 12:54:02', '2026-07-18 12:54:02'),
(58, 9, 'Rough Stone FRP Planter RO3R24', 'rough-stone-frp-planter-ro3r24', 'RO3R24', 'RO3R24', 'Catalog I', 'ROUGH STONE SERIES', 'Premium Rough Stone FRP Planter delivering a rugged, coarse stone aesthetic using durable Fiber Reinforced Plastic. Designed to seamlessly withstand outdoor exposure in courtyard gardens, architectural entryways, and texturally rich interiors.', 'FRP (Fiber Reinforced Plastic)', 'Round', 'Customizable', 'Stone Texture', 'images/products/planters/planter58.webp', 0, 1, '2026-07-18 12:54:02', '2026-07-18 12:54:02'),
(59, 9, 'Rough Stone FRP Planter RO3R25', 'rough-stone-frp-planter-ro3r25', 'RO3R25', 'RO3R25', 'Catalog I', 'ROUGH STONE SERIES', 'Premium Rough Stone FRP Planter delivering a rugged, coarse stone aesthetic using durable Fiber Reinforced Plastic. Designed to seamlessly withstand outdoor exposure in courtyard gardens, architectural entryways, and texturally rich interiors.', 'FRP (Fiber Reinforced Plastic)', 'Round', 'Customizable', 'Stone Texture', 'images/products/planters/planter59.webp', 0, 1, '2026-07-18 12:54:02', '2026-07-18 12:54:02'),
(60, 9, 'Rough Stone FRP Planter RO2O26', 'rough-stone-frp-planter-ro2o26', 'RO2O26', 'RO2O26', 'Catalog I', 'ROUGH STONE SERIES', 'Premium Rough Stone FRP Planter delivering a rugged, coarse stone aesthetic using durable Fiber Reinforced Plastic. Designed to seamlessly withstand outdoor exposure in courtyard gardens, architectural entryways, and texturally rich interiors.', 'FRP (Fiber Reinforced Plastic)', 'Oval', 'Customizable', 'Stone Texture', 'images/products/planters/planter60.webp', 0, 1, '2026-07-18 12:54:02', '2026-07-18 12:54:02'),
(61, 9, 'Rough Stone FRP Planter RO2P27', 'rough-stone-frp-planter-ro2p27', 'RO2P27', 'RO2P27', 'Catalog I', 'ROUGH STONE SERIES', 'Premium Rough Stone FRP Planter delivering a rugged, coarse stone aesthetic using durable Fiber Reinforced Plastic. Designed to seamlessly withstand outdoor exposure in courtyard gardens, architectural entryways, and texturally rich interiors.', 'FRP (Fiber Reinforced Plastic)', 'Rectangle', 'Customizable', 'Stone Texture', 'images/products/planters/planter61.webp', 0, 1, '2026-07-18 12:54:02', '2026-07-18 12:54:02'),
(62, 9, 'Royal FRP Planter RY4R28', 'royal-frp-planter-ry4r28', 'RY4R28', 'RY4R28', 'Catalog I', 'ROYAL SERIES', 'Exquisite Royal FRP Planter exhibiting a prestigious stately design achieved through premium-grade Fiber Reinforced Plastic. The ultimate architectural statement piece for luxury estate entryways, upscale hotel lobbies, banquets, and grand patios.', 'FRP (Fiber Reinforced Plastic)', 'Round', 'Customizable', 'Premium Matte', 'images/products/planters/planter62.webp', 0, 1, '2026-07-18 12:54:02', '2026-07-18 12:54:02'),
(63, 9, 'Royal FRP Planter RY3O29', 'royal-frp-planter-ry3o29', 'RY3O29', 'RY3O29', 'Catalog I', 'ROYAL SERIES', 'Exquisite Royal FRP Planter exhibiting a prestigious stately design achieved through premium-grade Fiber Reinforced Plastic. The ultimate architectural statement piece for luxury estate entryways, upscale hotel lobbies, banquets, and grand patios.', 'FRP (Fiber Reinforced Plastic)', 'Oval', 'Customizable', 'Premium Matte', 'images/products/planters/planter63.webp', 0, 1, '2026-07-18 12:54:02', '2026-07-18 12:54:02'),
(64, 9, 'Royal FRP Planter RY4R30', 'royal-frp-planter-ry4r30', 'RY4R30', 'RY4R30', 'Catalog I', 'ROYAL SERIES', 'Exquisite Royal FRP Planter exhibiting a prestigious stately design achieved through premium-grade Fiber Reinforced Plastic. The ultimate architectural statement piece for luxury estate entryways, upscale hotel lobbies, banquets, and grand patios.', 'FRP (Fiber Reinforced Plastic)', 'Round', 'Customizable', 'Premium Matte', 'images/products/planters/planter64.webp', 0, 1, '2026-07-18 12:54:02', '2026-07-18 12:54:02'),
(65, 9, 'Royal FRP Planter RY4R31', 'royal-frp-planter-ry4r31', 'RY4R31', 'RY4R31', 'Catalog I', 'ROYAL SERIES', 'Exquisite Royal FRP Planter exhibiting a prestigious stately design achieved through premium-grade Fiber Reinforced Plastic. The ultimate architectural statement piece for luxury estate entryways, upscale hotel lobbies, banquets, and grand patios.', 'FRP (Fiber Reinforced Plastic)', 'Round', 'Customizable', 'Premium Matte', 'images/products/planters/planter65.webp', 0, 1, '2026-07-18 12:54:02', '2026-07-18 12:54:02'),
(66, 9, 'Timber FRP Planter TB4R32', 'timber-frp-planter-tb4r32', 'TB4R32', 'TB4R32', 'Catalog I', 'TIMBER SERIES', 'Natural Timber FRP Planter masterfully mimicking detailed organic wood grain utilizing long-lasting Fiber Reinforced Plastic. Brings the warm aesthetic of real timber to balconies, botanical spaces, porches, and decks without the risk of rotting or splitting.', 'FRP (Fiber Reinforced Plastic)', 'Round', 'Customizable', 'Wood Texture', 'images/products/planters/planter66.webp', 0, 1, '2026-07-18 12:54:02', '2026-07-18 12:54:02'),
(67, 9, 'Tiny FRP Planter TY3R33', 'tiny-frp-planter-ty3r33', 'TY3R33', 'TY3R33', 'Catalog I', 'TINY SERIES', 'Natural Tiny FRP Planter masterfully mimicking detailed organic wood grain utilizing long-lasting Fiber Reinforced Plastic. Brings the warm aesthetic of real timber to compact spaces, balconies, botanical nooks, porches, and decks without the risk of rotting or splitting.', 'FRP (Fiber Reinforced Plastic)', 'Round', 'Customizable', 'Wood Texture', 'images/products/planters/planter67.webp', 0, 1, '2026-07-18 12:54:02', '2026-07-18 12:54:02'),
(68, 9, 'Velvet FRP Planter VT4R34', 'velvet-frp-planter-vt4r34', 'VT4R34', 'VT4R34', 'Catalog II', 'VELVET SERIES', 'Premium Velvet Series FRP planter featuring a contemporary stone texture finish. Designed for indoor and outdoor landscaping while offering exceptional durability and lightweight construction.', 'FRP (Fiber Reinforced Plastic)', 'Round', 'Customizable', 'Stone Texture', 'images/products/planters/planter68.webp', 0, 1, '2026-07-18 12:54:02', '2026-07-18 12:54:02'),
(69, 9, 'Velvet FRP Planter VT4R35', 'velvet-frp-planter-vt4r35', 'VT4R35', 'VT4R35', 'Catalog II', 'VELVET SERIES', 'Elegant tall Velvet Series FRP planter designed to create striking landscape focal points with superior durability and weather resistance.', 'FRP (Fiber Reinforced Plastic)', 'Round', 'Customizable', 'Stone Texture', 'images/products/planters/planter69.webp', 0, 1, '2026-07-18 12:54:02', '2026-07-18 12:54:02'),
(70, 9, 'Velvet FRP Planter VT3RE36', 'velvet-frp-planter-vt3re36', 'VT3RE36', 'VT3RE36', 'Catalog II', 'VELVET SERIES', 'Modern rectangular Velvet Series FRP planter with contemporary styling, ideal for commercial landscapes, balconies and premium outdoor spaces.', 'FRP (Fiber Reinforced Plastic)', 'Rectangular', 'Customizable', 'Stone Texture', 'images/products/planters/planter70.webp', 0, 1, '2026-07-18 12:54:02', '2026-07-18 12:54:02'),
(71, 9, 'Matrix FRP Planter MX3R38', 'matrix-frp-planter-mx3r38', 'MX3R38', 'MX3R38', 'Catalog II', 'MATRIX SERIES', 'Modern Matrix Series FRP planter with a contemporary stone texture finish. Crafted from premium Fiber Reinforced Plastic for lightweight handling, exceptional durability, and long-lasting outdoor performance.', 'FRP (Fiber Reinforced Plastic)', 'Round', 'Customizable', 'Stone Texture', 'images/products/planters/planter71.webp', 0, 1, '2026-07-18 12:54:02', '2026-07-18 12:54:02'),
(72, 9, 'Matrix FRP Planter MX3R39', 'matrix-frp-planter-mx3r39', 'MX3R39', 'MX3R39', 'Catalog II', 'MATRIX SERIES', 'Elegant Matrix Series FRP planter designed with a sophisticated stone texture finish. Ideal for residential gardens, commercial landscapes, terraces, balconies, and entrance décor.', 'FRP (Fiber Reinforced Plastic)', 'Round', 'Customizable', 'Stone Texture', 'images/products/planters/planter72.webp', 0, 1, '2026-07-18 12:54:02', '2026-07-18 12:54:02'),
(73, 9, 'Matrix FRP Planter MX3R40', 'matrix-frp-planter-mx3r40', 'MX3R40', 'MX3R40', 'Catalog II', 'MATRIX SERIES', 'Contemporary Matrix Series FRP planter featuring a clean geometric profile with a premium stone texture finish. Manufactured using high-quality Fiber Reinforced Plastic to provide superior durability, lightweight handling, and long-lasting performance for residential and commercial landscaping projects.', 'FRP (Fiber Reinforced Plastic)', 'Round', 'Customizable', 'Stone Texture', 'images/products/planters/planter73.webp', 0, 1, '2026-07-18 12:54:02', '2026-07-18 12:54:02'),
(74, 9, 'Matrix FRP Planter MX4R41', 'matrix-frp-planter-mx4r41', 'MX4R41', 'MX4R41', 'Catalog II', 'MATRIX SERIES', 'Premium Matrix Series FRP planter featuring a contemporary stone texture finish. Manufactured using high-quality Fiber Reinforced Plastic to deliver outstanding durability, lightweight construction, and long-lasting performance for residential and commercial landscapes.', 'FRP (Fiber Reinforced Plastic)', 'Round', 'Customizable', 'Stone Texture', 'images/products/planters/planter74.webp', 0, 1, '2026-07-18 12:54:02', '2026-07-18 12:54:02'),
(75, 9, 'Matrix FRP Planter MX3R42', 'matrix-frp-planter-mx3r42', 'MX3R42', 'MX3R42', 'Catalog II', 'MATRIX SERIES', 'Elegant Matrix Series FRP planter with a refined stone texture finish. Designed for modern indoor and outdoor spaces, this lightweight yet durable planter offers excellent weather resistance and timeless contemporary styling.', 'FRP (Fiber Reinforced Plastic)', 'Round', 'Customizable', 'Stone Texture', 'images/products/planters/planter75.webp', 0, 1, '2026-07-18 12:54:02', '2026-07-18 12:54:02'),
(76, 9, 'Matrix FRP Planter MX3R43', 'matrix-frp-planter-mx3r43', 'MX3R43', 'MX3R43', 'Catalog II', 'MATRIX SERIES', 'Modern Matrix Series FRP planter with a premium stone texture finish, designed to complement contemporary indoor and outdoor spaces. Made from high-quality Fiber Reinforced Plastic, it offers exceptional durability, lightweight handling, UV resistance, and long-lasting performance in all weather conditions.', 'FRP (Fiber Reinforced Plastic)', 'Round', 'Customizable', 'Stone Texture', 'images/products/planters/planter76.webp', 0, 1, '2026-07-18 12:54:02', '2026-07-18 12:54:02');
INSERT INTO `products` (`id`, `category_id`, `name`, `slug`, `sku`, `item_code`, `catalog`, `series`, `description`, `material`, `shape`, `color`, `finish`, `thumbnail`, `featured`, `status`, `created_at`, `updated_at`) VALUES
(77, 9, 'Matrix FRP Planter MX4S44', 'matrix-frp-planter-mx4s44', 'MX4S44', 'MX4S44', 'Catalog II', 'MATRIX SERIES', 'Premium Matrix Series FRP square planter featuring a clean geometric design with an elegant stone texture finish. Manufactured from high-quality Fiber Reinforced Plastic, it provides excellent durability, lightweight construction, UV resistance, and weather protection, making it ideal for residential gardens, commercial landscapes, patios, entrances, and interior décor.', 'FRP (Fiber Reinforced Plastic)', 'Square', 'Customizable', 'Stone Texture', 'images/products/planters/planter77.webp', 0, 1, '2026-07-18 12:54:02', '2026-07-18 12:54:02'),
(78, 9, 'Matrix FRP Planter MX3R45', 'matrix-frp-planter-mx3r45', 'MX3R45', 'MX3R45', 'Catalog II', 'MATRIX SERIES', 'Elegant Matrix Series FRP planter featuring a tall contemporary profile with a premium stone texture finish. Crafted from high-quality Fiber Reinforced Plastic, it is lightweight, durable, UV resistant, and suitable for both indoor and outdoor landscaping applications.', 'FRP (Fiber Reinforced Plastic)', 'Round', 'Customizable', 'Stone Texture', 'images/products/planters/planter78.webp', 0, 1, '2026-07-18 12:54:02', '2026-07-18 12:54:02'),
(79, 9, 'Matrix FRP Planter MX4R46', 'matrix-frp-planter-mx4r46', 'MX4R46', 'MX4R46', 'Catalog II', 'MATRIX SERIES', 'Premium Matrix Series FRP planter featuring a contemporary stone texture finish. Manufactured using high-quality Fiber Reinforced Plastic, it offers excellent durability, lightweight construction, UV resistance, and weatherproof performance, making it suitable for gardens, patios, balconies, commercial landscapes, and interior décor.', 'FRP (Fiber Reinforced Plastic)', 'Round', 'Customizable', 'Stone Texture', 'images/products/planters/planter79.webp', 0, 1, '2026-07-18 12:54:02', '2026-07-18 12:54:02'),
(80, 9, 'Matrix FRP Planter MX3R47', 'matrix-frp-planter-mx3r47', 'MX3R47', 'MX3R47', 'Catalog II', 'MATRIX SERIES', 'Stylish Matrix Series FRP planter featuring a sleek vertical profile with a premium stone texture finish. Manufactured from high-quality Fiber Reinforced Plastic, it combines lightweight construction, exceptional durability, UV protection, and weather resistance, making it ideal for residential gardens, commercial landscapes, entrances, patios, balconies, and indoor décor.', 'FRP (Fiber Reinforced Plastic)', 'Round', 'Customizable', 'Stone Texture', 'images/products/planters/planter80.webp', 0, 1, '2026-07-18 12:54:02', '2026-07-18 12:54:02'),
(81, 9, 'Rock FRP Planter RC4R49', 'rock-frp-planter-rc4r49', 'RC4R49', 'RC4R49', 'Catalog II', 'ROCK SERIES', 'Premium Rock Series FRP planter featuring an authentic rock texture finish that blends naturally into landscape designs. Manufactured from high-quality Fiber Reinforced Plastic, it offers exceptional durability, lightweight construction, UV resistance, and all-weather performance for both indoor and outdoor applications.', 'FRP (Fiber Reinforced Plastic)', 'Round', 'Customizable', 'Rock Texture', 'images/products/planters/planter81.webp', 0, 1, '2026-07-18 12:54:02', '2026-07-18 12:54:02'),
(82, 9, 'Rough Stone FRP Planter RO3R51', 'rough-stone-frp-planter-ro3r51', 'RO3R51', 'RO3R51', 'Catalog II', 'ROUGH STONE SERIES', 'Premium Rough Stone Series FRP planter featuring an authentic rough stone texture that adds a natural aesthetic to gardens, patios, commercial landscapes, and indoor spaces. Crafted from high-quality Fiber Reinforced Plastic, it offers exceptional durability, lightweight construction, UV resistance, and long-lasting all-weather performance.', 'FRP (Fiber Reinforced Plastic)', 'Round', 'Customizable', 'Rough Stone Texture', 'images/products/planters/planter82.webp', 0, 1, '2026-07-18 12:54:02', '2026-07-18 12:54:02'),
(83, 9, 'Rough Stone FRP Planter RO3R52', 'rough-stone-frp-planter-ro3r52', 'RO3R52', 'RO3R52', 'Catalog II', 'ROUGH STONE SERIES', 'Premium Rough Stone Series FRP planter featuring a realistic rough stone texture that complements modern and natural landscapes. Manufactured using high-quality Fiber Reinforced Plastic, it offers exceptional durability, lightweight construction, UV resistance, and weatherproof performance, making it ideal for residential gardens, commercial landscapes, terraces, patios, and indoor décor.', 'FRP (Fiber Reinforced Plastic)', 'Round', 'Customizable', 'Rough Stone Texture', 'images/products/planters/planter83.webp', 0, 1, '2026-07-18 12:54:02', '2026-07-18 12:54:02'),
(84, 9, 'Rough Stone FRP Planter RO3R53', 'rough-stone-frp-planter-ro3r53', 'RO3R53', 'RO3R53', 'Catalog II', 'ROUGH STONE SERIES', 'Premium Rough Stone Series FRP planter featuring a natural rough stone texture that blends beautifully with contemporary and traditional landscapes. Manufactured from high-quality Fiber Reinforced Plastic, it offers exceptional durability, lightweight construction, UV protection, and weather resistance for long-lasting indoor and outdoor use.', 'FRP (Fiber Reinforced Plastic)', 'Round', 'Customizable', 'Rough Stone Texture', 'images/products/planters/planter84.webp', 0, 1, '2026-07-18 12:54:02', '2026-07-18 12:54:02'),
(85, 9, 'Royal FRP Planter RY3R54', 'royal-frp-planter-ry3r54', 'RY3R54', 'RY3R54', 'Catalog II', 'ROYAL SERIES', 'Elegant Royal Series FRP planter featuring a premium royal stone texture finish that adds sophistication to residential and commercial landscapes. Crafted from high-quality Fiber Reinforced Plastic, it offers lightweight construction, exceptional durability, UV resistance, and all-weather performance for indoor and outdoor applications.', 'FRP (Fiber Reinforced Plastic)', 'Round', 'Customizable', 'Royal Stone Texture', 'images/products/planters/planter85.webp', 0, 1, '2026-07-18 12:54:02', '2026-07-18 12:54:02'),
(86, 9, 'Royal FRP Planter RY3R55', 'royal-frp-planter-ry3r55', 'RY3R55', 'RY3R55', 'Catalog II', 'ROYAL SERIES', 'Elegant Royal Series FRP planter featuring a premium royal stone texture finish that enhances modern and traditional landscapes. Manufactured from high-quality Fiber Reinforced Plastic, it provides lightweight construction, superior durability, UV protection, and excellent weather resistance for long-lasting indoor and outdoor use.', 'FRP (Fiber Reinforced Plastic)', 'Round', 'Customizable', 'Royal Stone Texture', 'images/products/planters/planter86.webp', 0, 1, '2026-07-18 12:54:02', '2026-07-18 12:54:02'),
(87, 9, 'Royal FRP Planter RY3R56', 'royal-frp-planter-ry3r56', 'RY3R56', 'RY3R56', 'Catalog II', 'ROYAL SERIES', 'Premium Royal Series FRP planter featuring an elegant royal stone texture finish that adds sophistication to residential gardens, commercial landscapes, patios, balconies, and indoor décor. Manufactured from high-quality Fiber Reinforced Plastic, it combines lightweight construction, exceptional durability, UV resistance, and weatherproof performance for long-lasting beauty.', 'FRP (Fiber Reinforced Plastic)', 'Round', 'Customizable', 'Royal Stone Texture', 'images/products/planters/planter87.webp', 0, 1, '2026-07-18 12:54:02', '2026-07-18 12:54:02'),
(88, 9, 'Royal FRP Planter RY3R57', 'royal-frp-planter-ry3r57', 'RY3R57', 'RY3R57', 'Catalog II', 'ROYAL SERIES', 'Premium Royal Series FRP planter featuring a luxurious royal stone texture finish with a wide, shallow profile that enhances contemporary and classic landscape designs. Crafted from high-quality Fiber Reinforced Plastic, it provides excellent durability, lightweight construction, UV protection, and weather resistance for long-lasting indoor and outdoor use.', 'FRP (Fiber Reinforced Plastic)', 'Round', 'Customizable', 'Royal Stone Texture', 'images/products/planters/planter88.webp', 0, 1, '2026-07-18 12:54:02', '2026-07-18 12:54:02'),
(89, 9, 'Royal FRP Planter RY3R58', 'royal-frp-planter-ry3r58', 'RY3R58', 'RY3R58', 'Catalog II', 'ROYAL SERIES', 'Premium Royal Series FRP planter featuring a sophisticated royal stone texture finish that enhances modern and classic landscapes alike. Manufactured from high-quality Fiber Reinforced Plastic, it offers lightweight construction, exceptional durability, UV resistance, and weatherproof performance, making it ideal for gardens, patios, balconies, commercial spaces, and indoor décor.', 'FRP (Fiber Reinforced Plastic)', 'Round', 'Customizable', 'Royal Stone Texture', 'images/products/planters/planter89.webp', 0, 1, '2026-07-18 12:54:02', '2026-07-18 12:54:02'),
(90, 9, 'Royal FRP Planter RY4S59', 'royal-frp-planter-ry4s59', 'RY4S59', 'RY4S59', 'Catalog II', 'ROYAL SERIES', 'Premium Royal Series FRP square planter featuring a luxurious royal stone texture finish. Crafted from high-quality Fiber Reinforced Plastic, it offers exceptional durability, lightweight construction, UV protection, and weather resistance, making it ideal for premium residential, hospitality, commercial, and landscape applications.', 'FRP (Fiber Reinforced Plastic)', 'Square', 'Customizable', 'Royal Stone Texture', 'images/products/planters/planter90.webp', 0, 1, '2026-07-18 12:54:02', '2026-07-18 12:54:02'),
(91, 9, 'Royal FRP Planter RY4R60', 'royal-frp-planter-ry4r60', 'RY4R60', 'RY4R60', 'Catalog II', 'ROYAL SERIES', 'Premium Royal Series FRP planter featuring a luxurious royal stone texture finish. Manufactured using high-quality Fiber Reinforced Plastic, it offers lightweight construction, exceptional durability, UV protection, and weather resistance, making it ideal for residential gardens, commercial landscapes, hotels, patios, entrances, and indoor décor.', 'FRP (Fiber Reinforced Plastic)', 'Round', 'Customizable', 'Royal Stone Texture', 'images/products/planters/planter91.webp', 0, 1, '2026-07-18 12:54:02', '2026-07-18 12:54:02'),
(92, 9, 'Velvet FRP Planter VT4R61', 'velvet-frp-planter-vt4r61', 'VT4R61', 'VT4R61', 'Catalog II', 'VELVET SERIES', 'Premium Velvet Series FRP planter featuring a refined velvet texture finish that enhances both contemporary and luxury landscapes. Manufactured from high-quality Fiber Reinforced Plastic, it offers lightweight construction, exceptional durability, UV resistance, and weatherproof performance, making it ideal for gardens, patios, balconies, hotels, commercial spaces, and indoor décor.', 'FRP (Fiber Reinforced Plastic)', 'Round', 'Customizable', 'Velvet Texture', 'images/products/planters/planter92.webp', 0, 1, '2026-07-18 12:54:02', '2026-07-18 12:54:02'),
(93, 9, 'Velvet FRP Planter VT3R62', 'velvet-frp-planter-vt3r62', 'VT3R62', 'VT3R62', 'Catalog II', 'VELVET SERIES', 'Premium Velvet Series FRP planter featuring a sophisticated velvet texture finish that complements contemporary and luxury landscapes. Crafted from high-quality Fiber Reinforced Plastic, it provides lightweight construction, superior durability, UV protection, and excellent weather resistance, making it ideal for residential gardens, commercial spaces, patios, balconies, and indoor décor.', 'FRP (Fiber Reinforced Plastic)', 'Round', 'Customizable', 'Velvet Texture', 'images/products/planters/planter93.webp', 0, 1, '2026-07-18 12:54:03', '2026-07-18 12:54:03'),
(94, 9, 'Velvet FRP Planter VT3R63', 'velvet-frp-planter-vt3r63', 'VT3R63', 'VT3R63', 'Catalog II', 'VELVET SERIES', 'Premium Velvet Series FRP planter featuring an elegant velvet texture finish that blends modern aesthetics with lasting durability. Manufactured from high-quality Fiber Reinforced Plastic, it offers lightweight construction, UV protection, weather resistance, and superior strength, making it suitable for residential gardens, commercial landscapes, patios, balconies, hotels, and indoor décor.', 'FRP (Fiber Reinforced Plastic)', 'Round', 'Customizable', 'Velvet Texture', 'images/products/planters/planter94.webp', 0, 1, '2026-07-18 12:54:03', '2026-07-18 12:54:03'),
(95, 9, 'Velvet FRP Planter VT3R64', 'velvet-frp-planter-vt3r64', 'VT3R64', 'VT3R64', 'Catalog II', 'VELVET SERIES', 'Premium Velvet Series FRP planter featuring a luxurious velvet texture finish that blends modern elegance with exceptional durability. Manufactured from high-quality Fiber Reinforced Plastic, it offers lightweight construction, UV protection, weather resistance, and long-lasting performance for residential gardens, commercial landscapes, patios, balconies, hotels, and indoor décor.', 'FRP (Fiber Reinforced Plastic)', 'Round', 'Customizable', 'Velvet Texture', 'images/products/planters/planter95.webp', 0, 1, '2026-07-18 12:54:03', '2026-07-18 12:54:03');

-- --------------------------------------------------------

--
-- Table structure for table `product_features`
--

CREATE TABLE `product_features` (
  `id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `feature` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `product_features`
--

INSERT INTO `product_features` (`id`, `product_id`, `feature`, `created_at`) VALUES
(141, 34, 'Weather Resistant', '2026-07-22 05:08:45'),
(142, 34, 'UV Protected', '2026-07-22 05:08:45'),
(143, 34, 'Lightweight Construction', '2026-07-22 05:08:45'),
(144, 34, 'High Tensile Strength', '2026-07-22 05:08:45'),
(145, 35, 'Weather Resistant', '2026-07-22 05:08:45'),
(146, 35, 'UV Protected', '2026-07-22 05:08:45'),
(147, 35, 'Lightweight Construction', '2026-07-22 05:08:45'),
(148, 35, 'High Tensile Strength', '2026-07-22 05:08:45'),
(149, 36, 'Weather Resistant', '2026-07-22 05:08:45'),
(150, 36, 'UV Protected', '2026-07-22 05:08:45'),
(151, 36, 'Lightweight Construction', '2026-07-22 05:08:45'),
(152, 36, 'High Tensile Strength', '2026-07-22 05:08:45'),
(153, 37, 'Weather Resistant', '2026-07-22 05:08:45'),
(154, 37, 'UV Protected', '2026-07-22 05:08:45'),
(155, 37, 'Lightweight Construction', '2026-07-22 05:08:45'),
(156, 37, 'High Tensile Strength', '2026-07-22 05:08:45'),
(157, 38, 'Weather Resistant', '2026-07-22 05:08:45'),
(158, 38, 'UV Protected', '2026-07-22 05:08:45'),
(159, 38, 'Lightweight Construction', '2026-07-22 05:08:45'),
(160, 38, 'High Tensile Strength', '2026-07-22 05:08:45'),
(161, 39, 'Weather Resistant', '2026-07-22 05:08:45'),
(162, 39, 'UV Protected', '2026-07-22 05:08:45'),
(163, 39, 'Lightweight Construction', '2026-07-22 05:08:45'),
(164, 39, 'High Tensile Strength', '2026-07-22 05:08:45'),
(165, 40, 'Weather Resistant', '2026-07-22 05:08:45'),
(166, 40, 'UV Protected', '2026-07-22 05:08:45'),
(167, 40, 'Lightweight Construction', '2026-07-22 05:08:45'),
(168, 40, 'High Tensile Strength', '2026-07-22 05:08:45'),
(169, 41, 'Weather Resistant', '2026-07-22 05:08:45'),
(170, 41, 'UV Protected', '2026-07-22 05:08:45'),
(171, 41, 'Lightweight Construction', '2026-07-22 05:08:45'),
(172, 41, 'High Tensile Strength', '2026-07-22 05:08:45'),
(173, 42, 'Weather Resistant', '2026-07-22 05:08:45'),
(174, 42, 'UV Protected', '2026-07-22 05:08:45'),
(175, 42, 'Lightweight Construction', '2026-07-22 05:08:45'),
(176, 42, 'High Tensile Strength', '2026-07-22 05:08:45'),
(177, 43, 'Weather Resistant', '2026-07-22 05:08:45'),
(178, 43, 'UV Protected', '2026-07-22 05:08:45'),
(179, 43, 'Lightweight Construction', '2026-07-22 05:08:45'),
(180, 43, 'High Tensile Strength', '2026-07-22 05:08:45'),
(181, 44, 'Weather Resistant', '2026-07-22 05:08:45'),
(182, 44, 'UV Protected', '2026-07-22 05:08:45'),
(183, 44, 'Lightweight Construction', '2026-07-22 05:08:45'),
(184, 44, 'High Tensile Strength', '2026-07-22 05:08:45'),
(185, 44, 'Organic Rock-like Finish', '2026-07-22 05:08:45'),
(186, 45, 'Weather Resistant', '2026-07-22 05:08:45'),
(187, 45, 'UV Protected', '2026-07-22 05:08:45'),
(188, 45, 'Lightweight Construction', '2026-07-22 05:08:45'),
(189, 45, 'High Tensile Strength', '2026-07-22 05:08:45'),
(190, 45, 'Organic Rock-like Finish', '2026-07-22 05:08:45'),
(191, 46, 'Weather Resistant', '2026-07-22 05:08:45'),
(192, 46, 'UV Protected', '2026-07-22 05:08:45'),
(193, 46, 'Lightweight Construction', '2026-07-22 05:08:45'),
(194, 46, 'High Tensile Strength', '2026-07-22 05:08:45'),
(195, 46, 'Organic Rock-like Finish', '2026-07-22 05:08:45'),
(196, 47, 'Weather Resistant', '2026-07-22 05:08:45'),
(197, 47, 'UV Protected', '2026-07-22 05:08:45'),
(198, 47, 'Lightweight Construction', '2026-07-22 05:08:45'),
(199, 47, 'High Tensile Strength', '2026-07-22 05:08:45'),
(200, 47, 'Organic Rock-like Finish', '2026-07-22 05:08:45'),
(201, 48, 'Weather Resistant', '2026-07-22 05:08:45'),
(202, 48, 'UV Protected', '2026-07-22 05:08:45'),
(203, 48, 'Lightweight Construction', '2026-07-22 05:08:45'),
(204, 48, 'High Tensile Strength', '2026-07-22 05:08:45'),
(205, 48, 'Organic Rock-like Finish', '2026-07-22 05:08:45'),
(206, 49, 'Weather Resistant', '2026-07-22 05:08:45'),
(207, 49, 'UV Protected', '2026-07-22 05:08:45'),
(208, 49, 'Lightweight Construction', '2026-07-22 05:08:45'),
(209, 49, 'High Tensile Strength', '2026-07-22 05:08:45'),
(210, 49, 'Organic Rock-like Finish', '2026-07-22 05:08:45'),
(211, 50, 'Weather Resistant', '2026-07-22 05:08:45'),
(212, 50, 'UV Protected', '2026-07-22 05:08:45'),
(213, 50, 'Lightweight Construction', '2026-07-22 05:08:45'),
(214, 50, 'High Tensile Strength', '2026-07-22 05:08:45'),
(215, 50, 'Organic Rock-like Finish', '2026-07-22 05:08:45'),
(216, 51, 'Weather Resistant', '2026-07-22 05:08:45'),
(217, 51, 'UV Protected', '2026-07-22 05:08:45'),
(218, 51, 'Lightweight Construction', '2026-07-22 05:08:45'),
(219, 51, 'High Tensile Strength', '2026-07-22 05:08:45'),
(220, 51, 'Organic Rock-like Finish', '2026-07-22 05:08:45'),
(221, 52, 'Weather Resistant', '2026-07-22 05:08:45'),
(222, 52, 'UV Protected', '2026-07-22 05:08:46'),
(223, 52, 'Lightweight Construction', '2026-07-22 05:08:46'),
(224, 52, 'High Tensile Strength', '2026-07-22 05:08:46'),
(225, 52, 'Organic Rock-like Finish', '2026-07-22 05:08:46'),
(226, 53, 'Weather Resistant', '2026-07-22 05:08:46'),
(227, 53, 'UV Protected', '2026-07-22 05:08:46'),
(228, 53, 'Lightweight Construction', '2026-07-22 05:08:46'),
(229, 53, 'High Tensile Strength', '2026-07-22 05:08:46'),
(230, 53, 'Chiseled Stone Finish', '2026-07-22 05:08:46'),
(231, 54, 'Weather Resistant', '2026-07-22 05:08:46'),
(232, 54, 'UV Protected', '2026-07-22 05:08:46'),
(233, 54, 'Lightweight Construction', '2026-07-22 05:08:46'),
(234, 54, 'High Tensile Strength', '2026-07-22 05:08:46'),
(235, 54, 'Chiseled Stone Finish', '2026-07-22 05:08:46'),
(236, 55, 'Weather Resistant', '2026-07-22 05:08:46'),
(237, 55, 'UV Protected', '2026-07-22 05:08:46'),
(238, 55, 'Lightweight Construction', '2026-07-22 05:08:46'),
(239, 55, 'High Tensile Strength', '2026-07-22 05:08:46'),
(240, 55, 'Chiseled Stone Finish', '2026-07-22 05:08:46'),
(241, 56, 'Weather Resistant', '2026-07-22 05:08:46'),
(242, 56, 'UV Protected', '2026-07-22 05:08:46'),
(243, 56, 'Lightweight Construction', '2026-07-22 05:08:46'),
(244, 56, 'High Tensile Strength', '2026-07-22 05:08:46'),
(245, 56, 'Chiseled Stone Finish', '2026-07-22 05:08:46'),
(246, 57, 'Weather Resistant', '2026-07-22 05:08:46'),
(247, 57, 'UV Protected', '2026-07-22 05:08:46'),
(248, 57, 'Lightweight Construction', '2026-07-22 05:08:46'),
(249, 57, 'High Tensile Strength', '2026-07-22 05:08:46'),
(250, 57, 'Chiseled Stone Finish', '2026-07-22 05:08:46'),
(251, 58, 'Weather Resistant', '2026-07-22 05:08:46'),
(252, 58, 'UV Protected', '2026-07-22 05:08:46'),
(253, 58, 'Lightweight Construction', '2026-07-22 05:08:46'),
(254, 58, 'High Tensile Strength', '2026-07-22 05:08:46'),
(255, 58, 'Chiseled Stone Finish', '2026-07-22 05:08:46'),
(256, 59, 'Weather Resistant', '2026-07-22 05:08:46'),
(257, 59, 'UV Protected', '2026-07-22 05:08:46'),
(258, 59, 'Lightweight Construction', '2026-07-22 05:08:46'),
(259, 59, 'High Tensile Strength', '2026-07-22 05:08:46'),
(260, 59, 'Chiseled Stone Finish', '2026-07-22 05:08:46'),
(261, 60, 'Weather Resistant', '2026-07-22 05:08:46'),
(262, 60, 'UV Protected', '2026-07-22 05:08:46'),
(263, 60, 'Lightweight Construction', '2026-07-22 05:08:46'),
(264, 60, 'High Tensile Strength', '2026-07-22 05:08:46'),
(265, 60, 'Chiseled Stone Finish', '2026-07-22 05:08:46'),
(266, 61, 'Weather Resistant', '2026-07-22 05:08:46'),
(267, 61, 'UV Protected', '2026-07-22 05:08:46'),
(268, 61, 'Lightweight Construction', '2026-07-22 05:08:46'),
(269, 61, 'High Tensile Strength', '2026-07-22 05:08:46'),
(270, 61, 'Chiseled Stone Finish', '2026-07-22 05:08:46'),
(271, 62, 'Weather Resistant', '2026-07-22 05:08:46'),
(272, 62, 'UV Protected', '2026-07-22 05:08:46'),
(273, 62, 'Lightweight Construction', '2026-07-22 05:08:46'),
(274, 62, 'High Tensile Strength', '2026-07-22 05:08:46'),
(275, 62, 'Premium Matte Finish Decor', '2026-07-22 05:08:46'),
(276, 63, 'Weather Resistant', '2026-07-22 05:08:46'),
(277, 63, 'UV Protected', '2026-07-22 05:08:46'),
(278, 63, 'Lightweight Construction', '2026-07-22 05:08:46'),
(279, 63, 'High Tensile Strength', '2026-07-22 05:08:46'),
(280, 63, 'Premium Matte Finish Decor', '2026-07-22 05:08:46'),
(281, 64, 'Weather Resistant', '2026-07-22 05:08:46'),
(282, 64, 'UV Protected', '2026-07-22 05:08:46'),
(283, 64, 'Lightweight Construction', '2026-07-22 05:08:46'),
(284, 64, 'High Tensile Strength', '2026-07-22 05:08:46'),
(285, 64, 'Premium Matte Finish Decor', '2026-07-22 05:08:46'),
(286, 65, 'Weather Resistant', '2026-07-22 05:08:46'),
(287, 65, 'UV Protected', '2026-07-22 05:08:46'),
(288, 65, 'Lightweight Construction', '2026-07-22 05:08:46'),
(289, 65, 'High Tensile Strength', '2026-07-22 05:08:46'),
(290, 65, 'Premium Matte Finish Decor', '2026-07-22 05:08:46'),
(291, 66, 'Weather Resistant', '2026-07-22 05:08:46'),
(292, 66, 'UV Protected', '2026-07-22 05:08:46'),
(293, 66, 'Lightweight Construction', '2026-07-22 05:08:46'),
(294, 66, 'High Tensile Strength', '2026-07-22 05:08:46'),
(295, 66, 'Faux Wood Grain Texture', '2026-07-22 05:08:46'),
(296, 67, 'Weather Resistant', '2026-07-22 05:08:46'),
(297, 67, 'UV Protected', '2026-07-22 05:08:46'),
(298, 67, 'Lightweight Construction', '2026-07-22 05:08:46'),
(299, 67, 'High Tensile Strength', '2026-07-22 05:08:46'),
(300, 67, 'Faux Wood Grain Texture', '2026-07-22 05:08:46'),
(301, 68, 'Weather Resistant', '2026-07-22 05:08:46'),
(302, 68, 'UV Protected', '2026-07-22 05:08:46'),
(303, 68, 'Lightweight Construction', '2026-07-22 05:08:46'),
(304, 68, 'High Strength FRP', '2026-07-22 05:08:46'),
(305, 68, 'Stone Texture Finish', '2026-07-22 05:08:46'),
(306, 69, 'Weather Resistant', '2026-07-22 05:08:46'),
(307, 69, 'UV Protected', '2026-07-22 05:08:46'),
(308, 69, 'Lightweight Construction', '2026-07-22 05:08:46'),
(309, 69, 'High Strength FRP', '2026-07-22 05:08:46'),
(310, 69, 'Elegant Tall Design', '2026-07-22 05:08:46'),
(311, 70, 'Weather Resistant', '2026-07-22 05:08:46'),
(312, 70, 'UV Protected', '2026-07-22 05:08:46'),
(313, 70, 'Lightweight Construction', '2026-07-22 05:08:46'),
(314, 70, 'High Strength FRP', '2026-07-22 05:08:46'),
(315, 70, 'Rectangular Modern Design', '2026-07-22 05:08:46'),
(316, 71, 'Weather Resistant', '2026-07-22 05:08:46'),
(317, 71, 'UV Protected', '2026-07-22 05:08:46'),
(318, 71, 'Lightweight Construction', '2026-07-22 05:08:46'),
(319, 71, 'High Tensile Strength', '2026-07-22 05:08:46'),
(320, 71, 'Premium Stone Texture', '2026-07-22 05:08:46'),
(321, 72, 'Weather Resistant', '2026-07-22 05:08:46'),
(322, 72, 'UV Protected', '2026-07-22 05:08:46'),
(323, 72, 'Lightweight Construction', '2026-07-22 05:08:46'),
(324, 72, 'Fade Resistant', '2026-07-22 05:08:46'),
(325, 72, 'Premium Stone Texture', '2026-07-22 05:08:46'),
(326, 73, 'Weather Resistant', '2026-07-22 05:08:46'),
(327, 73, 'UV Protected', '2026-07-22 05:08:46'),
(328, 73, 'Lightweight Construction', '2026-07-22 05:08:46'),
(329, 73, 'High Tensile Strength', '2026-07-22 05:08:46'),
(330, 73, 'Premium Stone Texture Finish', '2026-07-22 05:08:46'),
(331, 74, 'Weather Resistant', '2026-07-22 05:08:46'),
(332, 74, 'UV Protected', '2026-07-22 05:08:46'),
(333, 74, 'Lightweight Construction', '2026-07-22 05:08:46'),
(334, 74, 'High Tensile Strength', '2026-07-22 05:08:46'),
(335, 74, 'Premium Stone Texture Finish', '2026-07-22 05:08:46'),
(336, 75, 'Weather Resistant', '2026-07-22 05:08:46'),
(337, 75, 'UV Protected', '2026-07-22 05:08:46'),
(338, 75, 'Lightweight Construction', '2026-07-22 05:08:46'),
(339, 75, 'High Tensile Strength', '2026-07-22 05:08:46'),
(340, 75, 'Premium Stone Texture Finish', '2026-07-22 05:08:46'),
(341, 76, 'Weather Resistant', '2026-07-22 05:08:46'),
(342, 76, 'UV Protected', '2026-07-22 05:08:46'),
(343, 76, 'Lightweight Construction', '2026-07-22 05:08:46'),
(344, 76, 'High Tensile Strength', '2026-07-22 05:08:46'),
(345, 76, 'Premium Stone Texture Finish', '2026-07-22 05:08:46'),
(346, 77, 'Weather Resistant', '2026-07-22 05:08:46'),
(347, 77, 'UV Protected', '2026-07-22 05:08:46'),
(348, 77, 'Lightweight Construction', '2026-07-22 05:08:46'),
(349, 77, 'High Tensile Strength', '2026-07-22 05:08:46'),
(350, 77, 'Premium Stone Texture Finish', '2026-07-22 05:08:46'),
(351, 78, 'Weather Resistant', '2026-07-22 05:08:46'),
(352, 78, 'UV Protected', '2026-07-22 05:08:46'),
(353, 78, 'Lightweight Construction', '2026-07-22 05:08:46'),
(354, 78, 'High Tensile Strength', '2026-07-22 05:08:46'),
(355, 78, 'Premium Stone Texture Finish', '2026-07-22 05:08:46'),
(356, 79, 'Weather Resistant', '2026-07-22 05:08:46'),
(357, 79, 'UV Protected', '2026-07-22 05:08:46'),
(358, 79, 'Lightweight Construction', '2026-07-22 05:08:46'),
(359, 79, 'High Tensile Strength', '2026-07-22 05:08:46'),
(360, 79, 'Premium Stone Texture Finish', '2026-07-22 05:08:46'),
(361, 80, 'Weather Resistant', '2026-07-22 05:08:46'),
(362, 80, 'UV Protected', '2026-07-22 05:08:46'),
(363, 80, 'Lightweight Construction', '2026-07-22 05:08:46'),
(364, 80, 'High Tensile Strength', '2026-07-22 05:08:46'),
(365, 80, 'Premium Stone Texture Finish', '2026-07-22 05:08:46'),
(366, 81, 'Weather Resistant', '2026-07-22 05:08:46'),
(367, 81, 'UV Protected', '2026-07-22 05:08:46'),
(368, 81, 'Lightweight Construction', '2026-07-22 05:08:46'),
(369, 81, 'High Tensile Strength', '2026-07-22 05:08:46'),
(370, 81, 'Natural Rock Texture Finish', '2026-07-22 05:08:46'),
(371, 82, 'Weather Resistant', '2026-07-22 05:08:46'),
(372, 82, 'UV Protected', '2026-07-22 05:08:46'),
(373, 82, 'Lightweight Construction', '2026-07-22 05:08:46'),
(374, 82, 'High Tensile Strength', '2026-07-22 05:08:46'),
(375, 82, 'Authentic Rough Stone Texture', '2026-07-22 05:08:46'),
(376, 83, 'Weather Resistant', '2026-07-22 05:08:46'),
(377, 83, 'UV Protected', '2026-07-22 05:08:46'),
(378, 83, 'Lightweight Construction', '2026-07-22 05:08:46'),
(379, 83, 'High Tensile Strength', '2026-07-22 05:08:46'),
(380, 83, 'Authentic Rough Stone Texture', '2026-07-22 05:08:46'),
(381, 84, 'Weather Resistant', '2026-07-22 05:08:46'),
(382, 84, 'UV Protected', '2026-07-22 05:08:46'),
(383, 84, 'Lightweight Construction', '2026-07-22 05:08:46'),
(384, 84, 'High Tensile Strength', '2026-07-22 05:08:46'),
(385, 84, 'Authentic Rough Stone Texture', '2026-07-22 05:08:46'),
(386, 85, 'Weather Resistant', '2026-07-22 05:08:46'),
(387, 85, 'UV Protected', '2026-07-22 05:08:46'),
(388, 85, 'Lightweight Construction', '2026-07-22 05:08:46'),
(389, 85, 'High Tensile Strength', '2026-07-22 05:08:46'),
(390, 85, 'Premium Royal Stone Texture', '2026-07-22 05:08:46'),
(391, 86, 'Weather Resistant', '2026-07-22 05:08:46'),
(392, 86, 'UV Protected', '2026-07-22 05:08:46'),
(393, 86, 'Lightweight Construction', '2026-07-22 05:08:46'),
(394, 86, 'High Tensile Strength', '2026-07-22 05:08:46'),
(395, 86, 'Premium Royal Stone Texture', '2026-07-22 05:08:46'),
(396, 87, 'Weather Resistant', '2026-07-22 05:08:46'),
(397, 87, 'UV Protected', '2026-07-22 05:08:46'),
(398, 87, 'Lightweight Construction', '2026-07-22 05:08:46'),
(399, 87, 'High Tensile Strength', '2026-07-22 05:08:46'),
(400, 87, 'Premium Royal Stone Texture', '2026-07-22 05:08:46'),
(401, 88, 'Weather Resistant', '2026-07-22 05:08:46'),
(402, 88, 'UV Protected', '2026-07-22 05:08:46'),
(403, 88, 'Lightweight Construction', '2026-07-22 05:08:46'),
(404, 88, 'High Tensile Strength', '2026-07-22 05:08:46'),
(405, 88, 'Premium Royal Stone Texture', '2026-07-22 05:08:46'),
(406, 89, 'Weather Resistant', '2026-07-22 05:08:46'),
(407, 89, 'UV Protected', '2026-07-22 05:08:46'),
(408, 89, 'Lightweight Construction', '2026-07-22 05:08:46'),
(409, 89, 'High Tensile Strength', '2026-07-22 05:08:46'),
(410, 89, 'Premium Royal Stone Texture', '2026-07-22 05:08:46'),
(411, 90, 'Weather Resistant', '2026-07-22 05:08:46'),
(412, 90, 'UV Protected', '2026-07-22 05:08:46'),
(413, 90, 'Lightweight Construction', '2026-07-22 05:08:46'),
(414, 90, 'High Tensile Strength', '2026-07-22 05:08:46'),
(415, 90, 'Premium Royal Stone Texture', '2026-07-22 05:08:46'),
(416, 91, 'Weather Resistant', '2026-07-22 05:08:46'),
(417, 91, 'UV Protected', '2026-07-22 05:08:46'),
(418, 91, 'Lightweight Construction', '2026-07-22 05:08:46'),
(419, 91, 'High Tensile Strength', '2026-07-22 05:08:46'),
(420, 91, 'Premium Royal Stone Texture', '2026-07-22 05:08:46'),
(421, 92, 'Weather Resistant', '2026-07-22 05:08:46'),
(422, 92, 'UV Protected', '2026-07-22 05:08:46'),
(423, 92, 'Lightweight Construction', '2026-07-22 05:08:46'),
(424, 92, 'High Tensile Strength', '2026-07-22 05:08:46'),
(425, 92, 'Premium Velvet Texture Finish', '2026-07-22 05:08:46'),
(426, 93, 'Weather Resistant', '2026-07-22 05:08:46'),
(427, 93, 'UV Protected', '2026-07-22 05:08:46'),
(428, 93, 'Lightweight Construction', '2026-07-22 05:08:46'),
(429, 93, 'High Tensile Strength', '2026-07-22 05:08:46'),
(430, 93, 'Premium Velvet Texture Finish', '2026-07-22 05:08:46'),
(431, 94, 'Weather Resistant', '2026-07-22 05:08:46'),
(432, 94, 'UV Protected', '2026-07-22 05:08:46'),
(433, 94, 'Lightweight Construction', '2026-07-22 05:08:46'),
(434, 94, 'High Tensile Strength', '2026-07-22 05:08:46'),
(435, 94, 'Premium Velvet Texture Finish', '2026-07-22 05:08:46'),
(436, 95, 'Weather Resistant', '2026-07-22 05:08:46'),
(437, 95, 'UV Protected', '2026-07-22 05:08:46'),
(438, 95, 'Lightweight Construction', '2026-07-22 05:08:46'),
(439, 95, 'High Tensile Strength', '2026-07-22 05:08:46'),
(440, 95, 'Premium Velvet Texture Finish', '2026-07-22 05:08:46'),
(464, 1, 'Weather Resistant', '2026-07-23 06:20:42'),
(465, 1, 'UV Protected', '2026-07-23 06:20:42'),
(466, 1, 'Lightweight Construction', '2026-07-23 06:20:42'),
(467, 1, 'High Tensile Strength', '2026-07-23 06:20:42'),
(468, 2, 'High Structural Strength', '2026-07-23 06:20:50'),
(469, 2, 'Crack Resistant', '2026-07-23 06:20:50'),
(470, 2, 'Excellent Wind Ventilation', '2026-07-23 06:20:50'),
(471, 2, 'Modern Cubical Aesthetic', '2026-07-23 06:20:50'),
(472, 3, 'Traditional Islamic Patterns', '2026-07-23 06:20:58'),
(473, 3, 'Premium Sharp Edge Mold Detail', '2026-07-23 06:20:58'),
(474, 3, 'High Flame Retardancy', '2026-07-23 06:20:58'),
(475, 3, 'Eco-Friendly Mineral Binder', '2026-07-23 06:20:58'),
(476, 4, 'Optimal Privacy Shielding', '2026-07-23 06:21:04'),
(477, 4, 'Structural Anti-sag Properties', '2026-07-23 06:21:04'),
(478, 4, 'Low Thermal Expansion', '2026-07-23 06:21:04'),
(479, 4, 'Easy Bolt-on Frame Installation', '2026-07-23 06:21:04'),
(484, 5, 'Symmetrical Clean Lines', '2026-07-23 06:21:21'),
(485, 5, 'Maximum Ventilation Open Area', '2026-07-23 06:21:21'),
(486, 5, 'Heavy Impact Resistance', '2026-07-23 06:21:21'),
(487, 5, 'Low Dust Retention Design', '2026-07-23 06:21:21'),
(488, 6, 'Passive Solar Heating Control', '2026-07-23 06:21:31'),
(489, 6, 'Minimalist Linear Design', '2026-07-23 06:21:31'),
(490, 6, 'Excellent High-altitude Wind Tolerance', '2026-07-23 06:21:31'),
(491, 6, 'Alkali-resistant Glass Fiber Core', '2026-07-23 06:21:31'),
(492, 7, 'Timeless Mediterranean Look', '2026-07-23 06:21:39'),
(493, 7, 'Thick Reinforced Ribs', '2026-07-23 06:21:39'),
(494, 7, 'High Freeze-Thaw Durability', '2026-07-23 06:21:39'),
(495, 7, 'Fungus and Moss Repelling Surface', '2026-07-23 06:21:39'),
(496, 8, 'Stunning Kaleidoscope Shadow Play', '2026-07-23 06:21:50'),
(497, 8, 'Extremely Low Shrinkage Compound', '2026-07-23 06:21:50'),
(498, 8, 'High Flexural Strength Performance', '2026-07-23 06:21:50'),
(499, 8, 'Pre-drilled Anchor Points', '2026-07-23 06:21:50'),
(504, 9, 'Biophilic Honeycomb Design', '2026-07-23 06:22:06'),
(505, 9, 'Excellent Lightweight Structural Integrity', '2026-07-23 06:22:06'),
(506, 9, 'High Sound-damping Characteristics', '2026-07-23 06:22:06'),
(507, 9, 'Zero Deflection Under High Air Pressure', '2026-07-23 06:22:06'),
(508, 10, 'Heavy-duty Precast Build', '2026-07-23 06:22:16'),
(509, 10, 'Ergonomic Back Support', '2026-07-23 06:22:16'),
(510, 10, 'All-weather Resistant', '2026-07-23 06:22:16'),
(511, 10, 'Vandalism Proof', '2026-07-23 06:22:16'),
(512, 11, 'Integrated Arm Rest Comfort', '2026-07-23 06:22:26'),
(513, 11, 'Modern Slatted Finish', '2026-07-23 06:22:26'),
(514, 11, 'Anti-skid Texture Surface', '2026-07-23 06:22:26'),
(515, 11, 'High Weight Tolerance', '2026-07-23 06:22:26'),
(516, 12, 'Minimalist Design Lines', '2026-07-23 06:22:36'),
(517, 12, 'Premium Sandstone Appearance', '2026-07-23 06:22:36'),
(518, 12, 'Low Liquid Absorption', '2026-07-23 06:22:36'),
(519, 12, 'UV Degradation Proof', '2026-07-23 06:22:36'),
(520, 13, 'Industrial Strength Core', '2026-07-23 06:22:44'),
(521, 13, 'Vandal and Impact Resistant', '2026-07-23 06:22:44'),
(522, 13, 'Zero Base Anchoring Required', '2026-07-23 06:22:44'),
(523, 13, 'Efflorescence Free Coating', '2026-07-23 06:22:44'),
(524, 14, 'Classic Boulevard Styling', '2026-07-23 06:22:52');
INSERT INTO `product_features` (`id`, `product_id`, `feature`, `created_at`) VALUES
(525, 14, 'Rich Terracotta Coloring', '2026-07-23 06:22:52'),
(526, 14, 'Thick Structural Rebar Reinforcement', '2026-07-23 06:22:52'),
(527, 14, 'Deep Seat Base Depth', '2026-07-23 06:22:52'),
(528, 15, 'Striking Angular Profile', '2026-07-23 06:23:00'),
(529, 15, 'Exposed Micro-aggregate Texture', '2026-07-23 06:23:00'),
(530, 15, 'Stain and Spill Resistant Protection', '2026-07-23 06:23:00'),
(531, 15, 'Monolithic Component Alignment', '2026-07-23 06:23:00'),
(532, 16, 'Intricate Ornamental Motifs', '2026-07-23 06:23:09'),
(533, 16, 'Vintage Accent Color Coating', '2026-07-23 06:23:09'),
(534, 16, 'High-fidelity Mold Clarity', '2026-07-23 06:23:09'),
(535, 16, 'Premium Structural Concrete Blend', '2026-07-23 06:23:09'),
(536, 17, 'Ultra-realistic Wood Grain Texture', '2026-07-23 06:23:17'),
(537, 17, 'No Splintering or Rot Risks', '2026-07-23 06:23:17'),
(538, 17, 'Deep Penetrating Color Pigment', '2026-07-23 06:23:17'),
(539, 17, 'Termite and Moisture Proof', '2026-07-23 06:23:17'),
(540, 18, 'Optimized Weight Structural Core', '2026-07-23 06:23:24'),
(541, 18, 'Easy Multi-person Manual Lift Setup', '2026-07-23 06:23:24'),
(542, 18, 'Highly Budget-friendly Price Tier', '2026-07-23 06:23:24'),
(543, 18, 'Eco-conscious Mineral Binder Base', '2026-07-23 06:23:24'),
(544, 19, 'High Wind Load Base Support', '2026-07-23 06:23:32'),
(545, 19, 'Marine Atmospheric Protection Coating', '2026-07-23 06:23:32'),
(546, 19, 'Vibrant Distinct Perimeter Highlights', '2026-07-23 06:23:32'),
(547, 19, 'Anti-erosion Aggregate Build', '2026-07-23 06:23:32'),
(552, 20, 'Space Saving Slim Profile Layout', '2026-07-23 06:23:48'),
(553, 20, 'Highly Ergonomic Upright Back Angle', '2026-07-23 06:23:48'),
(554, 20, 'Extremely Competitive Introductory Price', '2026-07-23 06:23:48'),
(555, 20, 'Quick Clean Surface Treatment', '2026-07-23 06:23:48'),
(556, 21, 'Anti-Graffiti Hard Top Layer', '2026-07-23 06:23:57'),
(557, 21, 'Boltable Ground Plate Interface Slots', '2026-07-23 06:23:57'),
(558, 21, 'High Scuff Scratch Deflection', '2026-07-23 06:23:57'),
(559, 21, 'Massive structural density index', '2026-07-23 06:23:57'),
(560, 22, 'Organic Blending Hue Mix', '2026-07-23 06:24:06'),
(561, 22, 'Gentle Sloped Seating Base Structure', '2026-07-23 06:24:06'),
(562, 22, 'Moss and Lichen Friendly Surface Texture', '2026-07-23 06:24:06'),
(563, 22, 'High Cold Frost Fracture Resilience', '2026-07-23 06:24:06'),
(564, 23, 'Quartz Aggregates Reflective Mix', '2026-07-23 06:24:16'),
(565, 23, 'Premium Oil Stain Repulsion Layer', '2026-07-23 06:24:16'),
(566, 23, 'Extra Broad Seat Width', '2026-07-23 06:24:16'),
(567, 23, 'Heavy Mass Base Stability', '2026-07-23 06:24:16'),
(568, 24, 'Ultra-fine Sandblasted Texture', '2026-07-23 06:24:23'),
(569, 24, 'No Visual Hardware or Joining Lines', '2026-07-23 06:24:23'),
(570, 24, 'High Hydrophobic Exterior Defense Coating', '2026-07-23 06:24:23'),
(571, 24, 'Excellent Price-to-Value Proportion', '2026-07-23 06:24:23'),
(572, 25, 'Low Solar Heat Absorption Pigment', '2026-07-23 06:24:34'),
(573, 25, 'Anti-fungal Organic Top Treatment', '2026-07-23 06:24:34'),
(574, 25, 'Soft Curved Armless Outlines', '2026-07-23 06:24:34'),
(575, 25, 'Reinforced Carbon Mesh Structural Internals', '2026-07-23 06:24:34'),
(576, 26, 'High-Density Premium FRP', '2026-07-23 06:24:48'),
(577, 26, 'All-Weather UV Resistant Paint', '2026-07-23 06:24:48'),
(578, 26, 'Lightweight Structural Strength', '2026-07-23 06:24:48'),
(579, 26, 'Intricate Royal Drapery Carvings', '2026-07-23 06:24:48'),
(580, 26, 'Anti-Toppling Base Plate Support', '2026-07-23 06:24:48'),
(581, 27, 'Premium Pure Marble Construction', '2026-07-23 06:25:30'),
(582, 27, 'Elegant Hand-Painted Details', '2026-07-23 06:25:30'),
(583, 27, 'Vibrant Non-Toxic Accents', '2026-07-23 06:25:30'),
(584, 27, 'Excellent Face Expression Precision', '2026-07-23 06:25:30'),
(585, 27, 'Stain-resistant Polished Surface', '2026-07-23 06:25:30'),
(586, 28, 'Mimics Natural Sandstone Texture', '2026-07-23 06:25:42'),
(587, 28, 'Highly Resistant to Algae and Moss', '2026-07-23 06:25:42'),
(588, 28, 'Hollow Lightweight Core for Easy Shifting', '2026-07-23 06:25:42'),
(589, 28, 'UV-Stabilized Fading Protection', '2026-07-23 06:25:42'),
(590, 28, 'Zen Meditational Posing', '2026-07-23 06:25:42'),
(591, 29, 'Realistic Oxidized Copper Look', '2026-07-23 06:25:53'),
(592, 29, 'Dhyana Mudra (Gestation of Meditation)', '2026-07-23 06:25:53'),
(593, 29, 'High Water and Chlorine Resistance', '2026-07-23 06:25:53'),
(594, 29, 'Ideal for Water Feature Accents', '2026-07-23 06:25:53'),
(595, 29, 'Easy Wash-down Maintenance', '2026-07-23 06:25:53'),
(596, 30, 'Colossal 6ft Landscape Presence', '2026-07-23 06:26:05'),
(597, 30, 'Reinforced Fiberglass Shell', '2026-07-23 06:26:05'),
(598, 30, 'Stunning Ascetic Ash Detailing', '2026-07-23 06:26:05'),
(599, 30, 'High Wind-load Structural Base', '2026-07-23 06:26:05'),
(600, 30, 'Highly Stable Outdoor Anchor Slots', '2026-07-23 06:26:05'),
(617, 31, 'Blessing Gesture (Abhaya Mudra)', '2026-07-23 06:57:23'),
(618, 31, 'Vibrant Ochre Earth Tone Finish', '2026-07-23 06:57:23'),
(619, 31, 'Non-corrosive Structural Internals', '2026-07-23 06:57:23'),
(620, 31, 'Shatter-proof Polymer Composition', '2026-07-23 06:57:23'),
(621, 31, 'Smooth Matte Topseal Coat', '2026-07-23 06:57:23'),
(627, 32, 'Contemporary Adiyogi Portraiture', '2026-07-23 06:57:46'),
(628, 32, 'Monolithic White Aesthetics', '2026-07-23 06:57:46'),
(629, 32, 'Resistant to Hard-water Spotting', '2026-07-23 06:57:46'),
(630, 32, 'Reinforced Core against Structural Flex', '2026-07-23 06:57:46'),
(631, 32, 'Smooth Seamless Joint Lines', '2026-07-23 06:57:46'),
(632, 33, 'Marine-Grade Weather Resistance', '2026-07-23 06:57:55'),
(633, 33, 'Pearlescent Sky Blue Spiritual Aura', '2026-07-23 06:57:55'),
(634, 33, 'Anti-chlorine and Salinity-proof Shell', '2026-07-23 06:57:55'),
(635, 33, 'Thick Reinforced Base Support Plates', '2026-07-23 06:57:55'),
(636, 33, 'Detailed Snake and Crescent Moon Carvings', '2026-07-23 06:57:55');

-- --------------------------------------------------------

--
-- Table structure for table `product_images`
--

CREATE TABLE `product_images` (
  `id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `image` varchar(255) NOT NULL,
  `alt_text` varchar(255) DEFAULT NULL,
  `is_thumbnail` tinyint(1) DEFAULT 0,
  `sort_order` int(11) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `product_images`
--

INSERT INTO `product_images` (`id`, `product_id`, `image`, `alt_text`, `is_thumbnail`, `sort_order`, `created_at`) VALUES
(1, 1, 'images/products/grc/grc1.webp', 'White Architectural GRC Jali', 1, 1, '2026-07-22 05:40:25'),
(2, 2, 'images/products/grc/grc2.webp', 'Geometric Cube GRC Jali (100mm)', 1, 1, '2026-07-22 05:40:25'),
(3, 3, 'images/products/grc/grc3.webp', 'Islamic Lattice GRC Jali (100mm)', 1, 1, '2026-07-22 05:40:25'),
(4, 4, 'images/products/grc/grc4.webp', 'Diamond Mesh GRC Jali (100mm)', 1, 1, '2026-07-22 05:40:25'),
(5, 5, 'images/products/grc/grc5.webp', 'Contemporary Square GRC Jali (100mm)', 1, 1, '2026-07-22 05:40:25'),
(6, 6, 'images/products/grc/grc6.webp', 'Linear Stripes GRC Jali (100mm)', 1, 1, '2026-07-22 05:40:25'),
(7, 7, 'images/products/grc/grc7.webp', 'Classic Cross GRC Jali (100mm)', 1, 1, '2026-07-22 05:40:25'),
(8, 8, 'images/products/grc/grc8.webp', 'Star Matrix GRC Jali (100mm)', 1, 1, '2026-07-22 05:40:25'),
(9, 9, 'images/products/grc/grc9.webp', 'Hexagonal Cellular GRC Jali (100mm)', 1, 1, '2026-07-22 05:40:25'),
(10, 10, 'images/products/benches/bench1.webp', 'Classic Park Concrete Bench', 1, 1, '2026-07-22 05:40:25'),
(11, 11, 'images/products/benches/bench2.webp', 'Executive Slatted Concrete Bench', 1, 1, '2026-07-22 05:40:25'),
(12, 12, 'images/products/benches/bench3.webp', 'Contemporary Garden Concrete Bench', 1, 1, '2026-07-22 05:40:25'),
(13, 13, 'images/products/benches/bench4.webp', 'Urban Landscape Concrete Bench', 1, 1, '2026-07-22 05:40:25'),
(14, 14, 'images/products/benches/bench5.webp', 'Traditional Boulevard Concrete Bench', 1, 1, '2026-07-22 05:40:25'),
(15, 15, 'images/products/benches/bench6.webp', 'Modernist Plaza Concrete Bench', 1, 1, '2026-07-22 05:40:25'),
(16, 16, 'images/products/benches/bench7.webp', 'Ornate Heritage Concrete Bench', 1, 1, '2026-07-22 05:40:25'),
(17, 17, 'images/products/benches/bench8.webp', 'Rustic Parkside Concrete Bench', 1, 1, '2026-07-22 05:40:25'),
(18, 18, 'images/products/benches/bench9.webp', 'Eco-Lite Garden Concrete Bench', 1, 1, '2026-07-22 05:40:25'),
(19, 19, 'images/products/benches/bench10.webp', 'Vista Point Concrete Bench', 1, 1, '2026-07-22 05:40:25'),
(20, 20, 'images/products/benches/bench11.webp', 'Compact Courtyard Concrete Bench', 1, 1, '2026-07-22 05:40:25'),
(21, 21, 'images/products/benches/bench12.webp', 'Metro Transit Concrete Bench', 1, 1, '2026-07-22 05:40:25'),
(22, 22, 'images/products/benches/bench13.webp', 'Meadow View Concrete Bench', 1, 1, '2026-07-22 05:40:25'),
(23, 23, 'images/products/benches/bench14.webp', 'Commercial Promenade Concrete Bench', 1, 1, '2026-07-22 05:40:25'),
(24, 24, 'images/products/benches/bench15.webp', 'Minimalist Esplanade Concrete Bench', 1, 1, '2026-07-22 05:40:25'),
(25, 25, 'images/products/benches/bench16.webp', 'Botanical Sanctuary Concrete Bench', 1, 1, '2026-07-22 05:40:25'),
(26, 26, 'images/products/statues/frp-elephant-statue.webp', 'FRP Elephant Statue', 1, 1, '2026-07-22 05:40:25'),
(27, 27, 'images/products/statues/radha-krishna-statue.webp', 'Radha Krishna Statue', 1, 1, '2026-07-22 05:40:25'),
(28, 28, 'images/products/statues/buddha-statue-1.webp', 'FRP Meditating Buddha Statue', 1, 1, '2026-07-22 05:40:25'),
(29, 29, 'images/products/statues/buddha-statue-2.webp', 'FRP Dhyana Mudra Buddha Statue', 1, 1, '2026-07-22 05:40:25'),
(30, 30, 'images/products/statues/shiva-1.webp', 'FRP Meditating Shiva Statue (6ft)', 1, 1, '2026-07-22 05:40:25'),
(31, 31, 'images/products/statues/shiva-2.webp', 'FRP Blessing Lord Shiva Statue', 1, 1, '2026-07-22 05:40:25'),
(32, 32, 'images/products/statues/shiva-3.webp', 'FRP Adiyogi Style Shiva Statue', 1, 1, '2026-07-22 05:40:25'),
(33, 33, 'images/products/statues/shiva-4.webp', 'FRP Mahadev Meditation Statue', 1, 1, '2026-07-22 05:40:25'),
(34, 34, 'images/products/planters/planter34.webp', 'Matrix FRP Planter MX3R1', 1, 1, '2026-07-22 05:40:25'),
(35, 35, 'images/products/planters/planter35.webp', 'Matrix FRP Planter MX3R2', 1, 1, '2026-07-22 05:40:25'),
(36, 36, 'images/products/planters/planter36.webp', 'Matrix FRP Planter MX3R3', 1, 1, '2026-07-22 05:40:25'),
(37, 37, 'images/products/planters/planter37.webp', 'Matrix FRP Planter MX3R4', 1, 1, '2026-07-22 05:40:25'),
(38, 38, 'images/products/planters/planter38.webp', 'Matrix FRP Planter MX4R5', 1, 1, '2026-07-22 05:40:25'),
(39, 39, 'images/products/planters/planter39.webp', 'Matrix FRP Planter MX3O6', 1, 1, '2026-07-22 05:40:25'),
(40, 40, 'images/products/planters/planter40.webp', 'Matrix FRP Planter MX3R7', 1, 1, '2026-07-22 05:40:25'),
(41, 41, 'images/products/planters/planter41.webp', 'Matrix FRP Planter MX1S8', 1, 1, '2026-07-22 05:40:25'),
(42, 42, 'images/products/planters/planter42.webp', 'Matrix FRP Planter MX2S9', 1, 1, '2026-07-22 05:40:25'),
(43, 43, 'images/products/planters/planter43.webp', 'Matrix FRP Planter MX2R37', 1, 1, '2026-07-22 05:40:25'),
(44, 44, 'images/products/planters/planter44.webp', 'Rock FRP Planter RC4S10', 1, 1, '2026-07-22 05:40:25'),
(45, 45, 'images/products/planters/planter45.webp', 'Rock FRP Planter RC3R11', 1, 1, '2026-07-22 05:40:25'),
(46, 46, 'images/products/planters/planter46.webp', 'Rock FRP Planter RC3R12', 1, 1, '2026-07-22 05:40:25'),
(47, 47, 'images/products/planters/planter47.webp', 'Rock FRP Planter RC4R13', 1, 1, '2026-07-22 05:40:25'),
(48, 48, 'images/products/planters/planter48.webp', 'Rock FRP Planter RC3R14', 1, 1, '2026-07-22 05:40:25'),
(49, 49, 'images/products/planters/planter49.webp', 'Rock FRP Planter RC4R15', 1, 1, '2026-07-22 05:40:25'),
(50, 50, 'images/products/planters/planter50.webp', 'Rock FRP Planter RC4R16', 1, 1, '2026-07-22 05:40:25'),
(51, 51, 'images/products/planters/planter51.webp', 'Rock FRP Planter RC3R17', 1, 1, '2026-07-22 05:40:25'),
(52, 52, 'images/products/planters/planter52.webp', 'Rock FRP Planter RC4S18', 1, 1, '2026-07-22 05:40:25'),
(53, 53, 'images/products/planters/planter53.webp', 'Rough Stone FRP Planter RO4R19', 1, 1, '2026-07-22 05:40:25'),
(54, 54, 'images/products/planters/planter54.webp', 'Rough Stone FRP Planter RO4S20', 1, 1, '2026-07-22 05:40:25'),
(55, 55, 'images/products/planters/planter55.webp', 'Rough Stone FRP Planter RO4R21', 1, 1, '2026-07-22 05:40:25'),
(56, 56, 'images/products/planters/planter56.webp', 'Rough Stone FRP Planter RO3R22', 1, 1, '2026-07-22 05:40:25'),
(57, 57, 'images/products/planters/planter57.webp', 'Rough Stone FRP Planter RO4R23', 1, 1, '2026-07-22 05:40:25'),
(58, 58, 'images/products/planters/planter58.webp', 'Rough Stone FRP Planter RO3R24', 1, 1, '2026-07-22 05:40:25'),
(59, 59, 'images/products/planters/planter59.webp', 'Rough Stone FRP Planter RO3R25', 1, 1, '2026-07-22 05:40:25'),
(60, 60, 'images/products/planters/planter60.webp', 'Rough Stone FRP Planter RO2O26', 1, 1, '2026-07-22 05:40:25'),
(61, 61, 'images/products/planters/planter61.webp', 'Rough Stone FRP Planter RO2P27', 1, 1, '2026-07-22 05:40:25'),
(62, 62, 'images/products/planters/planter62.webp', 'Royal FRP Planter RY4R28', 1, 1, '2026-07-22 05:40:25'),
(63, 63, 'images/products/planters/planter63.webp', 'Royal FRP Planter RY3O29', 1, 1, '2026-07-22 05:40:25'),
(64, 64, 'images/products/planters/planter64.webp', 'Royal FRP Planter RY4R30', 1, 1, '2026-07-22 05:40:25'),
(65, 65, 'images/products/planters/planter65.webp', 'Royal FRP Planter RY4R31', 1, 1, '2026-07-22 05:40:25'),
(66, 66, 'images/products/planters/planter66.webp', 'Timber FRP Planter TB4R32', 1, 1, '2026-07-22 05:40:25'),
(67, 67, 'images/products/planters/planter67.webp', 'Tiny FRP Planter TY3R33', 1, 1, '2026-07-22 05:40:25'),
(68, 68, 'images/products/planters/planter68.webp', 'Velvet FRP Planter VT4R34', 1, 1, '2026-07-22 05:40:25'),
(69, 69, 'images/products/planters/planter69.webp', 'Velvet FRP Planter VT4R35', 1, 1, '2026-07-22 05:40:25'),
(70, 70, 'images/products/planters/planter70.webp', 'Velvet FRP Planter VT3RE36', 1, 1, '2026-07-22 05:40:25'),
(71, 71, 'images/products/planters/planter71.webp', 'Matrix FRP Planter MX3R38', 1, 1, '2026-07-22 05:40:25'),
(72, 72, 'images/products/planters/planter72.webp', 'Matrix FRP Planter MX3R39', 1, 1, '2026-07-22 05:40:25'),
(73, 73, 'images/products/planters/planter73.webp', 'Matrix FRP Planter MX3R40', 1, 1, '2026-07-22 05:40:25'),
(74, 74, 'images/products/planters/planter74.webp', 'Matrix FRP Planter MX4R41', 1, 1, '2026-07-22 05:40:25'),
(75, 75, 'images/products/planters/planter75.webp', 'Matrix FRP Planter MX3R42', 1, 1, '2026-07-22 05:40:25'),
(76, 76, 'images/products/planters/planter76.webp', 'Matrix FRP Planter MX3R43', 1, 1, '2026-07-22 05:40:25'),
(77, 77, 'images/products/planters/planter77.webp', 'Matrix FRP Planter MX4S44', 1, 1, '2026-07-22 05:40:25'),
(78, 78, 'images/products/planters/planter78.webp', 'Matrix FRP Planter MX3R45', 1, 1, '2026-07-22 05:40:25'),
(79, 79, 'images/products/planters/planter79.webp', 'Matrix FRP Planter MX4R46', 1, 1, '2026-07-22 05:40:25'),
(80, 80, 'images/products/planters/planter80.webp', 'Matrix FRP Planter MX3R47', 1, 1, '2026-07-22 05:40:25'),
(81, 81, 'images/products/planters/planter81.webp', 'Rock FRP Planter RC4R49', 1, 1, '2026-07-22 05:40:25'),
(82, 82, 'images/products/planters/planter82.webp', 'Rough Stone FRP Planter RO3R51', 1, 1, '2026-07-22 05:40:25'),
(83, 83, 'images/products/planters/planter83.webp', 'Rough Stone FRP Planter RO3R52', 1, 1, '2026-07-22 05:40:25'),
(84, 84, 'images/products/planters/planter84.webp', 'Rough Stone FRP Planter RO3R53', 1, 1, '2026-07-22 05:40:25'),
(85, 85, 'images/products/planters/planter85.webp', 'Royal FRP Planter RY3R54', 1, 1, '2026-07-22 05:40:25'),
(86, 86, 'images/products/planters/planter86.webp', 'Royal FRP Planter RY3R55', 1, 1, '2026-07-22 05:40:25'),
(87, 87, 'images/products/planters/planter87.webp', 'Royal FRP Planter RY3R56', 1, 1, '2026-07-22 05:40:25'),
(88, 88, 'images/products/planters/planter88.webp', 'Royal FRP Planter RY3R57', 1, 1, '2026-07-22 05:40:25'),
(89, 89, 'images/products/planters/planter89.webp', 'Royal FRP Planter RY3R58', 1, 1, '2026-07-22 05:40:25'),
(90, 90, 'images/products/planters/planter90.webp', 'Royal FRP Planter RY4S59', 1, 1, '2026-07-22 05:40:25'),
(91, 91, 'images/products/planters/planter91.webp', 'Royal FRP Planter RY4R60', 1, 1, '2026-07-22 05:40:25'),
(92, 92, 'images/products/planters/planter92.webp', 'Velvet FRP Planter VT4R61', 1, 1, '2026-07-22 05:40:25'),
(93, 93, 'images/products/planters/planter93.webp', 'Velvet FRP Planter VT3R62', 1, 1, '2026-07-22 05:40:25'),
(94, 94, 'images/products/planters/planter94.webp', 'Velvet FRP Planter VT3R63', 1, 1, '2026-07-22 05:40:25'),
(95, 95, 'images/products/planters/planter95.webp', 'Velvet FRP Planter VT3R64', 1, 1, '2026-07-22 05:40:25');

-- --------------------------------------------------------

--
-- Table structure for table `product_seo`
--

CREATE TABLE `product_seo` (
  `id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `meta_title` varchar(255) DEFAULT NULL,
  `meta_description` text DEFAULT NULL,
  `meta_keywords` text DEFAULT NULL,
  `canonical_url` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `product_seo`
--

INSERT INTO `product_seo` (`id`, `product_id`, `meta_title`, `meta_description`, `meta_keywords`, `canonical_url`, `created_at`, `updated_at`) VALUES
(1, 1, 'White Architectural GRC Jali Manufacturer | Concrete Arts India', 'Premium white GRC Jali for building facades and elevations. Lightweight, weather-resistant Glass Reinforced Concrete custom manufactured in India.', 'White GRC Jali, Architectural Jali, Glass Reinforced Concrete, Facade Design', NULL, '2026-07-22 05:19:54', '2026-07-22 05:19:54'),
(2, 2, 'Geometric Cube GRC Jali (100mm) | Concrete Arts India', 'Modern geometric cube pattern GRC Jali. 100mm thickness offers superior depth, structural strength, and ventilation for modern facades.', 'Geometric GRC Jali, Cube Jali Design, 100mm GRC Panel, Concrete Arts India', NULL, '2026-07-22 05:19:54', '2026-07-22 05:19:54'),
(3, 3, 'Islamic Lattice GRC Jali 100mm | Concrete Arts India', 'Buy traditional Islamic lattice GRC Jali screens. Intricate geometric designs perfect for religious spaces and luxury heritage elevations.', 'Islamic GRC Jali, Mughal Jali Screen, Traditional Concrete Grilles', NULL, '2026-07-22 05:19:54', '2026-07-22 05:19:54'),
(4, 4, 'Diamond Mesh GRC Jali Manufacturer | Concrete Arts India', 'Premium Diamond Mesh pattern GRC Jali panels. Ideal for multi-story residential building balconies and architectural privacy screens.', 'Diamond GRC Jali, Privacy Screen Jali, Crisscross Concrete Panel', NULL, '2026-07-22 05:19:54', '2026-07-22 05:19:54'),
(5, 5, 'Contemporary Square GRC Jali 100mm | Concrete Arts India', 'Grid-style contemporary square GRC Jali panels. Designed for optimum airflow, parking structures, and industrial-modern facades.', 'Square Grid Jali, Modern GRC Panel, Ventilation Jali Screen', NULL, '2026-07-22 05:19:54', '2026-07-22 05:19:54'),
(6, 6, 'Linear Stripes GRC Jali Louvers | Concrete Arts India', 'Linear GRC Jali panels designed for modern architectural sunshades. Mitigates building solar heat gain while retaining beautiful aesthetics.', 'Linear GRC Jali, Concrete Sunshade Louver, Striped Facade Screen', NULL, '2026-07-22 05:19:54', '2026-07-22 05:19:54'),
(7, 7, 'Classic Cross GRC Jali Mediterranean Style | Concrete Arts India', 'Shop classic cross pattern GRC Jali. Durable colonial and Mediterranean style concrete grilles ideal for bungalows and boundary walls.', 'Cross GRC Jali, X Pattern Jali, Colonial Balustrade alternative', NULL, '2026-07-22 05:19:54', '2026-07-22 05:19:54'),
(8, 8, 'Star Matrix GRC Jali Panel | Concrete Arts India', 'Intricate star matrix GRC Jali screens for hotels and luxury resorts. Hand-finished premium fiberglass concrete designs.', 'Star GRC Jali, Luxury Facade Screen, Resort Architectural Panels', NULL, '2026-07-22 05:19:54', '2026-07-22 05:19:54'),
(9, 9, 'Hexagonal Cellular GRC Jali (Honeycomb) | Concrete Arts India', 'Biophilic hexagonal honeycomb GRC Jali panels. Ideal for modern commercial IT park facades and eco-friendly structures.', 'Hexagonal Jali, Honeycomb GRC Screen, Biophilic Facade Design', NULL, '2026-07-22 05:19:54', '2026-07-22 05:19:54'),
(10, 10, 'Classic Park Concrete Bench Manufacturer | Concrete Arts India', 'Buy classic precast concrete park benches without armrests. Ideal for municipal parks, public walkways, and large gardens.', 'Classic Concrete Bench, Park Bench, Precast Garden Seating, Concrete Arts India', NULL, '2026-07-22 05:19:54', '2026-07-22 05:19:54'),
(11, 11, 'Executive Slatted Concrete Bench with Arm Rest | Concrete Arts India', 'Premium commercial grade concrete slatted benches featuring heavy duty structural armrests for ultimate public utility.', 'Slatted Concrete Bench, Armrest Concrete Bench, Commercial Outdoor Seating', NULL, '2026-07-22 05:19:54', '2026-07-22 05:19:54'),
(12, 12, 'Contemporary Garden Concrete Bench Online | Concrete Arts India', 'Shop design-forward contemporary sandstone look garden concrete benches. Tailor-made for luxury villas and private lawns.', 'Contemporary Concrete Bench, Modern Garden Bench, Luxury Outdoor Furniture', NULL, '2026-07-22 05:19:54', '2026-07-22 05:19:54'),
(13, 13, 'Urban Landscape Concrete Bench for Public Spaces | Concrete Arts India', 'High-durability urban landscape concrete seating solutions engineered specifically for high-density metropolitan spaces.', 'Urban Street Bench, Public Plaza Seating, Heavy Duty Stone Bench', NULL, '2026-07-22 05:19:54', '2026-07-22 05:19:54'),
(14, 14, 'Traditional Boulevard Concrete Bench Supplier | Concrete Arts India', 'Add time-tested European street elegance with our Terracotta hue Traditional Boulevard Precast Concrete Benches.', 'Boulevard Bench, Terracotta Concrete Bench, Heritage Walkway Seating', NULL, '2026-07-22 05:19:54', '2026-07-22 05:19:54'),
(15, 15, 'Modernist Plaza Concrete Bench Manufacturer | Concrete Arts India', 'Architectural grade modernist plaza concrete benches featuring geometric minimalist styles and advanced structural strength.', 'Modernist Concrete Bench, Plaza Seating, Architectural Outdoor Furniture', NULL, '2026-07-22 05:19:54', '2026-07-22 05:19:54'),
(16, 16, 'Ornate Heritage Concrete Bench Factory | Concrete Arts India', 'Ornate structural concrete benches mimicking classical antique patterns. Perfect for luxury resorts and historic preservation sites.', 'Ornate Bench, Heritage Concrete Bench, Antique Style Park Bench', NULL, '2026-07-22 05:19:54', '2026-07-22 05:19:54'),
(17, 17, 'Rustic Wood-Look Concrete Bench | Concrete Arts India', 'Get the warmth of timber wood grain with the unbreakable life span of reinforced precast stone concrete technology.', 'Faux Wood Concrete Bench, Rustic Park Bench, Wood Texture Garden Seating', NULL, '2026-07-22 05:19:54', '2026-07-22 05:19:54'),
(18, 18, 'Eco-Lite Budget Garden Concrete Bench | Concrete Arts India', 'Affordable and highly dynamic lightweight structural concrete benches suited perfectly for backyards and domestic lawns.', 'Lightweight Concrete Bench, Affordable Garden Seat, Eco Friendly Bench', NULL, '2026-07-22 05:19:54', '2026-07-22 05:19:54'),
(19, 19, 'Vista Point Scenic Concrete Bench | Concrete Arts India', 'Heavy-duty coastal and hilltop weatherproof concrete benches built to survive extreme humidity and high winds.', 'Vista Bench, Coastal Promenade Seat, Weatherproof Bench', NULL, '2026-07-22 05:19:54', '2026-07-22 05:19:54'),
(20, 20, 'Compact Courtyard Concrete Bench | Concrete Arts India', 'Space-optimized, small footprint concrete garden benches ideal for narrow passages, terraces, and balconies.', 'Small Concrete Bench, Balcony Seating, Compact Courtyard Furniture', NULL, '2026-07-22 05:19:54', '2026-07-22 05:19:54'),
(21, 21, 'Metro Transit Public Concrete Bench | Concrete Arts India', 'Infrastructure grade platform concrete seating solutions engineered for railway stations and metro networks.', 'Transit Bench, Railway Platform Seating, Bus Stop Bench', NULL, '2026-07-22 05:19:54', '2026-07-22 05:19:54'),
(22, 22, 'Meadow View Farmhouse Concrete Bench | Concrete Arts India', 'Earthy colored, naturally textured concrete benches built for farmhouses, orchards, and country resorts.', 'Meadow Bench, Farmhouse Concrete Seat, Natural Stone Bench', NULL, '2026-07-22 05:19:54', '2026-07-22 05:19:54'),
(23, 23, 'Commercial Promenade Mall Bench | Concrete Arts India', 'High-end quartz finish precast concrete benches tailored for shopping complex promenades and high streets.', 'Promenade Bench, Mall Concrete Seating, Retail Space Outdoor Furniture', NULL, '2026-07-22 05:19:54', '2026-07-22 05:19:54'),
(24, 24, 'Minimalist Esplanade Concrete Bench | Concrete Arts India', 'Sandblasted minimal style dark grey concrete benches. Perfect statement element for clean contemporary architecture layouts.', 'Minimalist Bench, Sandblasted Concrete Seat, Slate Grey Outdoor Bench', NULL, '2026-07-22 05:19:54', '2026-07-22 05:19:54'),
(25, 25, 'Botanical Sanctuary Garden Bench | Concrete Arts India', 'Shop low-glare, anti-fungal precast concrete seating solutions specialized for plant nurseries and botanical parks.', 'Botanical Garden Bench, Greenhouse Seating, Sage Green Concrete Bench', NULL, '2026-07-22 05:19:54', '2026-07-22 05:19:54'),
(26, 26, 'FRP Royal Elephant Statue Outdoor Decor | Concrete Arts India', 'Buy life-sized and ornamental FRP Elephant Statues for hotel entrances, lawns, and resorts. Weatherproof fiberglass construction with antique gold finishes.', 'FRP Elephant Statue, Fiberglass Animal Sculpture, Resort Entrance Decor, Garden Elephant Statue', NULL, '2026-07-22 05:19:54', '2026-07-22 05:19:54'),
(27, 27, 'Radha Krishna Marble Statue for Home Temple | Concrete Arts India', 'Beautiful hand-carved Radha Krishna marble statue featuring fine blue detailing. Ideal size for home altars, spiritual rooms, and temple shrines.', 'Radha Krishna Murti, Marble Radha Krishna Statue, Home Temple Puja Idols', NULL, '2026-07-22 05:19:54', '2026-07-22 05:19:54'),
(28, 28, 'FRP Meditating Buddha Statue (21 Inch) | Concrete Arts India', 'Shop traditional Zen sitting Buddha statue made of durable, lightweight fiber-reinforced plastic. Perfect for outdoor garden patios and yoga studios.', 'FRP Buddha Statue, Garden Buddha Sculpture, Zen Meditation Decor, Fiberglass Buddha', NULL, '2026-07-22 05:19:54', '2026-07-22 05:19:54'),
(29, 29, 'Dhyana Mudra FRP Buddha Statue Patina Finish | Concrete Arts India', 'Beautiful 21-inch Dhyana Mudra Buddha statue in a gorgeous copper patina finish. Ideal for water fountains, ponds, and backyard garden landscapes.', 'Dhyana Mudra Buddha, Patina Finish Statue, Pond Buddha Statue, FRP Spiritual Art', NULL, '2026-07-22 05:19:54', '2026-07-22 05:19:54'),
(30, 30, '6ft Meditating Shiva FRP Statue for Temples | Concrete Arts India', 'Shop our large 6-foot meditating Shiva statue. Sculpted in deep yogic dhyana posture, perfect for large lawns, ashram landscapes, and temples.', '6 Feet Shiva Statue, Large FRP Shiva Idol, Ashram Outdoor Sculptures, Meditating Shiva Murti', NULL, '2026-07-22 05:19:54', '2026-07-22 05:19:54'),
(31, 31, '6ft Blessing Lord Shiva FRP Statue | Concrete Arts India', 'Premium 6ft Shiva statue depicting the protective Abhaya blessing gesture. Weatherproof polymer-resin build for commercial resorts and home estates.', 'Abhaya Mudra Shiva Statue, Terracotta Lord Shiva Murti, Blessing Shiva Sculpture', NULL, '2026-07-22 05:19:54', '2026-07-22 05:19:54'),
(32, 32, 'Adiyogi Style Shiva FRP Statue (6ft) | Concrete Arts India', 'Exquisite Adiyogi style Lord Shiva statue in deep slate black finish. Ideal centerpiece for modern wellness spaces, gardens, and yoga sanctuaries.', 'Adiyogi Shiva Statue, Black Shiva Murti, Modern Spiritual Sculptures, 6 Feet Adiyogi Idol', NULL, '2026-07-22 05:19:54', '2026-07-22 05:19:54'),
(33, 33, 'Mahadev Meditation Sky Blue FRP Statue | Concrete Arts India', 'Marine-grade 6ft Mahadev meditation statue in sky blue. Engineered to survive extreme humidity, water features, and intense weather.', 'Sky Blue Shiva Statue, Mahadev Meditation Idol, Fiberglass Lord Shiva Murti, Water Feature Statues', NULL, '2026-07-22 05:19:54', '2026-07-22 05:19:54'),
(34, 34, 'Matrix FRP Planter MX3R1 Manufacturer | Concrete Arts India', 'Premium round Matrix FRP planter for luxury interiors and outdoor landscapes. Durable, lightweight, and weather-resistant planter manufactured in India.', 'Matrix FRP Planter, FRP Round Planter, Fiber Reinforced Plastic Planter, Luxury Garden Planter', NULL, '2026-07-22 05:19:54', '2026-07-22 05:19:54'),
(35, 35, 'Matrix FRP Planter MX3R2 Manufacturer | Concrete Arts India', 'Premium round Matrix FRP planter for luxury interiors and outdoor landscapes. Durable, lightweight, and weather-resistant planter manufactured in India.', 'Matrix FRP Planter, FRP Round Planter, Fiber Reinforced Plastic Planter, Luxury Garden Planter', NULL, '2026-07-22 05:19:54', '2026-07-22 05:19:54'),
(36, 36, 'Matrix FRP Planter MX3R3 Manufacturer | Concrete Arts India', 'Premium round Matrix FRP planter for luxury interiors and outdoor landscapes. Durable, lightweight, and weather-resistant planter manufactured in India.', 'Matrix FRP Planter, FRP Round Planter, Fiber Reinforced Plastic Planter, Luxury Garden Planter', NULL, '2026-07-22 05:19:54', '2026-07-22 05:19:54'),
(37, 37, 'Matrix FRP Planter MX3R4 Manufacturer | Concrete Arts India', 'Premium round Matrix FRP planter for luxury interiors and outdoor landscapes. Durable, lightweight, and weather-resistant planter manufactured in India.', 'Matrix FRP Planter, FRP Round Planter, Fiber Reinforced Plastic Planter, Luxury Garden Planter', NULL, '2026-07-22 05:19:54', '2026-07-22 05:19:54'),
(38, 38, 'Matrix FRP Planter MX4R5 Manufacturer | Concrete Arts India', 'Premium round Matrix FRP planter for luxury interiors and outdoor landscapes. Durable, lightweight, and weather-resistant planter manufactured in India.', 'Matrix FRP Planter, FRP Round Planter, Fiber Reinforced Plastic Planter, Luxury Garden Planter', NULL, '2026-07-22 05:19:54', '2026-07-22 05:19:54'),
(39, 39, 'Matrix FRP Planter MX3O6 Manufacturer | Concrete Arts India', 'Premium oval Matrix FRP planter for luxury interiors and outdoor landscapes. Durable, lightweight, and weather-resistant planter manufactured in India.', 'Matrix FRP Planter, FRP Oval Planter, Fiber Reinforced Plastic Planter, Luxury Garden Planter', NULL, '2026-07-22 05:19:54', '2026-07-22 05:19:54'),
(40, 40, 'Matrix FRP Planter MX3R7 Manufacturer | Concrete Arts India', 'Premium round Matrix FRP planter for luxury interiors and outdoor landscapes. Durable, lightweight, and weather-resistant planter manufactured in India.', 'Matrix FRP Planter, FRP Round Planter, Fiber Reinforced Plastic Planter, Luxury Garden Planter', NULL, '2026-07-22 05:19:54', '2026-07-22 05:19:54'),
(41, 41, 'Matrix FRP Planter MX1S8 Manufacturer | Concrete Arts India', 'Premium square Matrix FRP planter for luxury interiors and outdoor landscapes. Durable, lightweight, and weather-resistant planter manufactured in India.', 'Matrix FRP Planter, FRP Square Planter, Fiber Reinforced Plastic Planter, Luxury Garden Planter', NULL, '2026-07-22 05:19:54', '2026-07-22 05:19:54'),
(42, 42, 'Matrix FRP Planter MX2S9 Manufacturer | Concrete Arts India', 'Premium square Matrix FRP planter for luxury interiors and outdoor landscapes. Durable, lightweight, and weather-resistant planter manufactured in India.', 'Matrix FRP Planter, FRP Square Planter, Fiber Reinforced Plastic Planter, Luxury Garden Planter', NULL, '2026-07-22 05:19:54', '2026-07-22 05:19:54'),
(43, 43, 'Matrix FRP Planter MX2R37 Manufacturer | Concrete Arts India', 'Premium round Matrix FRP planter for luxury interiors and outdoor landscapes. Durable, lightweight, and weather-resistant planter manufactured in India.', 'Matrix FRP Planter, FRP Round Planter, Fiber Reinforced Plastic Planter, Luxury Garden Planter', NULL, '2026-07-22 05:19:54', '2026-07-22 05:19:54'),
(44, 44, 'Rock FRP Planter RC4S10 Manufacturer | Concrete Arts India', 'Premium rustic Rock FRP planter with authentic stone texture. Durable, lightweight Fiber Reinforced Plastic design by Concrete Arts India.', 'Rock FRP Planter, FRP Stone Planter, Rustic Garden Planter, Textured Square Planter', NULL, '2026-07-22 05:19:54', '2026-07-22 05:19:54'),
(45, 45, 'Rock FRP Planter RC3R11 Manufacturer | Concrete Arts India', 'Premium rustic Rock FRP planter with authentic stone texture. Durable, lightweight Fiber Reinforced Plastic design by Concrete Arts India.', 'Rock FRP Planter, FRP Stone Planter, Rustic Garden Planter, Textured Square Planter', NULL, '2026-07-22 05:19:54', '2026-07-22 05:19:54'),
(46, 46, 'Rock FRP Planter RC3R12 Manufacturer | Concrete Arts India', 'Premium rustic Rock FRP planter with authentic stone texture. Durable, lightweight Fiber Reinforced Plastic design by Concrete Arts India.', 'Rock FRP Planter, FRP Stone Planter, Rustic Garden Planter, Textured Square Planter', NULL, '2026-07-22 05:19:54', '2026-07-22 05:19:54'),
(47, 47, 'Rock FRP Planter RC4R13 Manufacturer | Concrete Arts India', 'Premium rustic Rock FRP planter with authentic stone texture. Durable, lightweight Fiber Reinforced Plastic design by Concrete Arts India.', 'Rock FRP Planter, FRP Stone Planter, Rustic Garden Planter, Textured Square Planter', NULL, '2026-07-22 05:19:54', '2026-07-22 05:19:54'),
(48, 48, 'Rock FRP Planter RC3R14 Manufacturer | Concrete Arts India', 'Premium rustic Rock FRP planter with authentic stone texture. Durable, lightweight Fiber Reinforced Plastic design by Concrete Arts India.', 'Rock FRP Planter, FRP Stone Planter, Rustic Garden Planter, Textured Square Planter', NULL, '2026-07-22 05:19:54', '2026-07-22 05:19:54'),
(49, 49, 'Rock FRP Planter RC4R15 Manufacturer | Concrete Arts India', 'Premium rustic Rock FRP planter with authentic stone texture. Durable, lightweight Fiber Reinforced Plastic design by Concrete Arts India.', 'Rock FRP Planter, FRP Stone Planter, Rustic Garden Planter, Textured Square Planter', NULL, '2026-07-22 05:19:54', '2026-07-22 05:19:54'),
(50, 50, 'Rock FRP Planter RC4R16 Manufacturer | Concrete Arts India', 'Premium rustic Rock FRP planter with authentic stone texture. Durable, lightweight Fiber Reinforced Plastic design by Concrete Arts India.', 'Rock FRP Planter, FRP Stone Planter, Rustic Garden Planter, Textured Square Planter', NULL, '2026-07-22 05:19:54', '2026-07-22 05:19:54'),
(51, 51, 'Rock FRP Planter RC3R17 Manufacturer | Concrete Arts India', 'Premium rustic Rock FRP planter with authentic stone texture. Durable, lightweight Fiber Reinforced Plastic design by Concrete Arts India.', 'Rock FRP Planter, FRP Stone Planter, Rustic Garden Planter, Textured Square Planter', NULL, '2026-07-22 05:19:54', '2026-07-22 05:19:54'),
(52, 52, 'Rock FRP Planter RC4S18 Manufacturer | Concrete Arts India', 'Premium rustic Rock FRP planter with authentic stone texture. Durable, lightweight Fiber Reinforced Plastic design by Concrete Arts India.', 'Rock FRP Planter, FRP Stone Planter, Rustic Garden Planter, Textured Square Planter', NULL, '2026-07-22 05:19:54', '2026-07-22 05:19:54'),
(53, 53, 'Rough Stone FRP Planter RO4R19 Manufacturer | Concrete Arts India', 'Premium chiseled Rough Stone FRP planter for high-end landscapes. Lightweight, ultra-durable Fiber Reinforced Plastic construction by Concrete Arts India.', 'Rough Stone Planter, FRP Faux Stone Planter, Coarse Texture Planter, Round Rustic Planter', NULL, '2026-07-22 05:19:54', '2026-07-22 05:19:54'),
(54, 54, 'Rough Stone FRP Planter RO4S20 Manufacturer | Concrete Arts India', 'Premium chiseled Rough Stone FRP planter for high-end landscapes. Lightweight, ultra-durable Fiber Reinforced Plastic construction by Concrete Arts India.', 'Rough Stone Planter, FRP Faux Stone Planter, Coarse Texture Planter, Round Rustic Planter', NULL, '2026-07-22 05:19:54', '2026-07-22 05:19:54'),
(55, 55, 'Rough Stone FRP Planter RO4R21 Manufacturer | Concrete Arts India', 'Premium chiseled Rough Stone FRP planter for high-end landscapes. Lightweight, ultra-durable Fiber Reinforced Plastic construction by Concrete Arts India.', 'Rough Stone Planter, FRP Faux Stone Planter, Coarse Texture Planter, Round Rustic Planter', NULL, '2026-07-22 05:19:54', '2026-07-22 05:19:54'),
(56, 56, 'Rough Stone FRP Planter RO3R22 Manufacturer | Concrete Arts India', 'Premium chiseled Rough Stone FRP planter for high-end landscapes. Lightweight, ultra-durable Fiber Reinforced Plastic construction by Concrete Arts India.', 'Rough Stone Planter, FRP Faux Stone Planter, Coarse Texture Planter, Round Rustic Planter', NULL, '2026-07-22 05:19:54', '2026-07-22 05:19:54'),
(57, 57, 'Rough Stone FRP Planter RO4R23 Manufacturer | Concrete Arts India', 'Premium chiseled Rough Stone FRP planter for high-end landscapes. Lightweight, ultra-durable Fiber Reinforced Plastic construction by Concrete Arts India.', 'Rough Stone Planter, FRP Faux Stone Planter, Coarse Texture Planter, Round Rustic Planter', NULL, '2026-07-22 05:19:54', '2026-07-22 05:19:54');
INSERT INTO `product_seo` (`id`, `product_id`, `meta_title`, `meta_description`, `meta_keywords`, `canonical_url`, `created_at`, `updated_at`) VALUES
(58, 58, 'Rough Stone FRP Planter RO3R24 Manufacturer | Concrete Arts India', 'Premium chiseled Rough Stone FRP planter for high-end landscapes. Lightweight, ultra-durable Fiber Reinforced Plastic construction by Concrete Arts India.', 'Rough Stone Planter, FRP Faux Stone Planter, Coarse Texture Planter, Round Rustic Planter', NULL, '2026-07-22 05:19:54', '2026-07-22 05:19:54'),
(59, 59, 'Rough Stone FRP Planter RO3R25 Manufacturer | Concrete Arts India', 'Premium chiseled Rough Stone FRP planter for high-end landscapes. Lightweight, ultra-durable Fiber Reinforced Plastic construction by Concrete Arts India.', 'Rough Stone Planter, FRP Faux Stone Planter, Coarse Texture Planter, Round Rustic Planter', NULL, '2026-07-22 05:19:54', '2026-07-22 05:19:54'),
(60, 60, 'Rough Stone FRP Planter RO2O26 Manufacturer | Concrete Arts India', 'Premium chiseled Rough Stone FRP planter for high-end landscapes. Lightweight, ultra-durable Fiber Reinforced Plastic construction by Concrete Arts India.', 'Rough Stone Planter, FRP Faux Stone Planter, Coarse Texture Planter, Round Rustic Planter', NULL, '2026-07-22 05:19:54', '2026-07-22 05:19:54'),
(61, 61, 'Rough Stone FRP Planter RO2P27 Manufacturer | Concrete Arts India', 'Premium chiseled Rough Stone FRP planter for high-end landscapes. Lightweight, ultra-durable Fiber Reinforced Plastic construction by Concrete Arts India.', 'Rough Stone Planter, FRP Faux Stone Planter, Coarse Texture Planter, Round Rustic Planter', NULL, '2026-07-22 05:19:54', '2026-07-22 05:19:54'),
(62, 62, 'Royal FRP Planter RY4R28 Manufacturer | Concrete Arts India', 'Luxury Royal FRP planter with premium matte styling. Stately architectural planter crafted in high-strength Fiber Reinforced Plastic.', 'Royal FRP Planter, Premium Luxury Planter, Hotel Lobby Planter, Elegant Round Planter', NULL, '2026-07-22 05:19:54', '2026-07-22 05:19:54'),
(63, 63, 'Royal FRP Planter RY3O29 Manufacturer | Concrete Arts India', 'Luxury Royal FRP planter with premium matte styling. Stately architectural planter crafted in high-strength Fiber Reinforced Plastic.', 'Royal FRP Planter, Premium Luxury Planter, Hotel Lobby Planter, Elegant Round Planter', NULL, '2026-07-22 05:19:54', '2026-07-22 05:19:54'),
(64, 64, 'Royal FRP Planter RY4R30 Manufacturer | Concrete Arts India', 'Luxury Royal FRP planter with premium matte styling. Stately architectural planter crafted in high-strength Fiber Reinforced Plastic.', 'Royal FRP Planter, Premium Luxury Planter, Hotel Lobby Planter, Elegant Round Planter', NULL, '2026-07-22 05:19:54', '2026-07-22 05:19:54'),
(65, 65, 'Royal FRP Planter RY4R31 Manufacturer | Concrete Arts India', 'Luxury Royal FRP planter with premium matte styling. Stately architectural planter crafted in high-strength Fiber Reinforced Plastic.', 'Royal FRP Planter, Premium Luxury Planter, Hotel Lobby Planter, Elegant Round Planter', NULL, '2026-07-22 05:19:54', '2026-07-22 05:19:54'),
(66, 66, 'Timber FRP Planter TB4R32 Manufacturer | Concrete Arts India', 'Natural Timber FRP planter mimicking realistic wood grains. Rot-proof, ultra-lightweight Fiber Reinforced Plastic planter by Concrete Arts India.', 'Timber FRP Planter, Wood Grain Planter, FRP Wooden Look Planter, Round Patio Planter', NULL, '2026-07-22 05:19:54', '2026-07-22 05:19:54'),
(67, 67, 'Tiny FRP Planter TY3R33 Manufacturer | Concrete Arts India', 'Natural Tiny FRP planter mimicking realistic wood grains. Rot-proof, ultra-lightweight Fiber Reinforced Plastic planter by Concrete Arts India.', 'Tiny FRP Planter, Wood Grain Planter, FRP Wooden Look Planter, Round Patio Planter', NULL, '2026-07-22 05:19:54', '2026-07-22 05:19:54'),
(68, 68, 'Velvet FRP Planter VT4R34 Manufacturer | Concrete Arts India', 'Premium Velvet Series FRP planter with modern stone texture finish for residential and commercial landscapes.', 'Velvet FRP Planter, Stone Texture Planter, Outdoor FRP Planter, Modern Garden Planter', NULL, '2026-07-22 05:19:54', '2026-07-22 05:19:54'),
(69, 69, 'Velvet FRP Planter VT4R35 Manufacturer | Concrete Arts India', 'Tall Velvet Series FRP planter suitable for luxury landscapes, entrances and commercial interiors.', 'Tall FRP Planter, Velvet Series Planter, Commercial Planter, Outdoor FRP Pot', NULL, '2026-07-22 05:19:54', '2026-07-22 05:19:54'),
(70, 70, 'Velvet FRP Planter VT3RE36 Manufacturer | Concrete Arts India', 'Rectangular Velvet Series FRP planter for modern residential and commercial landscaping projects.', 'Rectangular FRP Planter, Velvet Series Planter, Modern Planter, Commercial Landscape Planter', NULL, '2026-07-22 05:19:54', '2026-07-22 05:19:54'),
(71, 71, 'Matrix FRP Planter MX3R38 Manufacturer | Concrete Arts India', 'Premium Matrix Series FRP planter with modern stone texture finish for indoor and outdoor landscaping.', 'Matrix FRP Planter, MX3R38 Planter, Modern FRP Planter, Round Garden Planter', NULL, '2026-07-22 05:19:54', '2026-07-22 05:19:54'),
(72, 72, 'Matrix FRP Planter MX3R39 Manufacturer | Concrete Arts India', 'Modern Matrix Series FRP planter featuring durable stone texture finish for premium landscaping applications.', 'Matrix FRP Planter, MX3R39 Planter, Decorative FRP Planter, Outdoor Garden Pot', NULL, '2026-07-22 05:19:54', '2026-07-22 05:19:54'),
(73, 73, 'Matrix FRP Planter MX3R40 Manufacturer | Concrete Arts India', 'Modern Matrix Series FRP planter MX3R40 with premium stone texture finish for indoor and outdoor landscaping applications.', 'Matrix FRP Planter, MX3R40 Planter, Modern FRP Planter, Round Garden Planter', NULL, '2026-07-22 05:19:54', '2026-07-22 05:19:54'),
(74, 74, 'Matrix FRP Planter MX4R41 Manufacturer | Concrete Arts India', 'Premium Matrix Series FRP planter MX4R41 with elegant stone texture finish for indoor and outdoor landscaping.', 'Matrix FRP Planter, MX4R41 Planter, Round FRP Planter, Modern Garden Planter', NULL, '2026-07-22 05:19:54', '2026-07-22 05:19:54'),
(75, 75, 'Matrix FRP Planter MX3R42 Manufacturer | Concrete Arts India', 'Modern Matrix Series FRP planter MX3R42 featuring premium stone texture finish for residential and commercial landscaping.', 'Matrix FRP Planter, MX3R42 Planter, Modern FRP Planter, Stone Texture Garden Pot', NULL, '2026-07-22 05:19:54', '2026-07-22 05:19:54'),
(76, 76, 'Matrix FRP Planter MX3R43 Manufacturer | Concrete Arts India', 'Premium Matrix Series FRP planter MX3R43 featuring a durable stone texture finish for residential and commercial landscaping applications.', 'Matrix FRP Planter, MX3R43 Planter, Modern FRP Planter, Round Garden Planter', NULL, '2026-07-22 05:19:54', '2026-07-22 05:19:54'),
(77, 77, 'Matrix FRP Planter MX4S44 Manufacturer | Concrete Arts India', 'Premium Matrix Series square FRP planter MX4S44 with durable stone texture finish for indoor and outdoor landscaping applications.', 'Matrix FRP Planter, MX4S44 Planter, Square FRP Planter, Modern Garden Planter', NULL, '2026-07-22 05:19:54', '2026-07-22 05:19:54'),
(78, 78, 'Matrix FRP Planter MX3R45 Manufacturer | Concrete Arts India', 'Modern Matrix Series FRP planter MX3R45 with premium stone texture finish, perfect for residential and commercial landscaping projects.', 'Matrix FRP Planter, MX3R45 Planter, Tall FRP Planter, Modern Garden Planter', NULL, '2026-07-22 05:19:54', '2026-07-22 05:19:54'),
(79, 79, 'Matrix FRP Planter MX4R46 Manufacturer | Concrete Arts India', 'Premium Matrix Series FRP planter MX4R46 with elegant stone texture finish for residential and commercial landscaping applications.', 'Matrix FRP Planter, MX4R46 Planter, Modern FRP Planter, Stone Texture Garden Planter', NULL, '2026-07-22 05:19:54', '2026-07-22 05:19:54'),
(80, 80, 'Matrix FRP Planter MX3R47 Manufacturer | Concrete Arts India', 'Premium Matrix Series FRP planter MX3R47 with elegant stone texture finish for indoor and outdoor landscaping applications.', 'Matrix FRP Planter, MX3R47 Planter, Tall FRP Planter, Modern Garden Planter', NULL, '2026-07-22 05:19:54', '2026-07-22 05:19:54'),
(81, 81, 'Rock FRP Planter RC4R49 Manufacturer | Concrete Arts India', 'Premium Rock Series FRP planter RC4R49 with realistic rock texture finish for residential and commercial landscaping applications.', 'Rock FRP Planter, RC4R49 Planter, Rock Texture Planter, Outdoor Garden Planter', NULL, '2026-07-22 05:19:54', '2026-07-22 05:19:54'),
(82, 82, 'Rough Stone FRP Planter RO3R51 Manufacturer | Concrete Arts India', 'Premium Rough Stone Series FRP planter RO3R51 with realistic rough stone texture finish for indoor and outdoor landscaping.', 'Rough Stone FRP Planter, RO3R51 Planter, Stone Texture Planter, Outdoor Garden Planter', NULL, '2026-07-22 05:19:54', '2026-07-22 05:19:54'),
(83, 83, 'Rough Stone FRP Planter RO3R52 Manufacturer | Concrete Arts India', 'Premium Rough Stone Series FRP planter RO3R52 with authentic rough stone texture finish for indoor and outdoor landscaping applications.', 'Rough Stone FRP Planter, RO3R52 Planter, Stone Texture Planter, Outdoor Garden Planter', NULL, '2026-07-22 05:19:54', '2026-07-22 05:19:54'),
(84, 84, 'Rough Stone FRP Planter RO3R53 Manufacturer | Concrete Arts India', 'Premium Rough Stone Series FRP planter RO3R53 with realistic rough stone texture finish for residential and commercial landscaping.', 'Rough Stone FRP Planter, RO3R53 Planter, Stone Texture Planter, Outdoor Garden Planter', NULL, '2026-07-22 05:19:54', '2026-07-22 05:19:54'),
(85, 85, 'Royal FRP Planter RY3R54 Manufacturer | Concrete Arts India', 'Premium Royal Series FRP planter RY3R54 with elegant royal stone texture finish for indoor and outdoor landscaping.', 'Royal FRP Planter, RY3R54 Planter, Luxury Garden Planter, Stone Texture FRP Planter', NULL, '2026-07-22 05:19:54', '2026-07-22 05:19:54'),
(86, 86, 'Royal FRP Planter RY3R55 Manufacturer | Concrete Arts India', 'Premium Royal Series FRP planter RY3R55 with elegant royal stone texture finish for residential and commercial landscaping applications.', 'Royal FRP Planter, RY3R55 Planter, Luxury Garden Planter, Stone Texture FRP Planter', NULL, '2026-07-22 05:19:54', '2026-07-22 05:19:54'),
(87, 87, 'Royal FRP Planter RY3R56 Manufacturer | Concrete Arts India', 'Premium Royal Series FRP planter RY3R56 with elegant royal stone texture finish for indoor and outdoor landscaping applications.', 'Royal FRP Planter, RY3R56 Planter, Luxury Garden Planter, Stone Texture FRP Planter', NULL, '2026-07-22 05:19:54', '2026-07-22 05:19:54'),
(88, 88, 'Royal FRP Planter RY3R57 Manufacturer | Concrete Arts India', 'Premium Royal Series FRP planter RY3R57 with elegant royal stone texture finish for residential and commercial landscaping.', 'Royal FRP Planter, RY3R57 Planter, Luxury Garden Planter, Shallow FRP Planter', NULL, '2026-07-22 05:19:54', '2026-07-22 05:19:54'),
(89, 89, 'Royal FRP Planter RY3R58 Manufacturer | Concrete Arts India', 'Premium Royal Series FRP planter RY3R58 with elegant royal stone texture finish for residential and commercial landscaping applications.', 'Royal FRP Planter, RY3R58 Planter, Luxury Garden Planter, Stone Texture FRP Planter', NULL, '2026-07-22 05:19:54', '2026-07-22 05:19:54'),
(90, 90, 'Royal FRP Planter RY4S59 Manufacturer | Concrete Arts India', 'Premium Royal Series square FRP planter RY4S59 with elegant royal stone texture finish for indoor and outdoor landscaping.', 'Royal FRP Planter, RY4S59 Planter, Square FRP Planter, Luxury Garden Planter', NULL, '2026-07-22 05:19:54', '2026-07-22 05:19:54'),
(91, 91, 'Royal FRP Planter RY4R60 Manufacturer | Concrete Arts India', 'Premium Royal Series FRP planter RY4R60 with elegant royal stone texture finish for indoor and outdoor landscaping.', 'Royal FRP Planter, RY4R60 Planter, Luxury Garden Planter, Round FRP Planter', NULL, '2026-07-22 05:19:54', '2026-07-22 05:19:54'),
(92, 92, 'Velvet FRP Planter VT4R61 Manufacturer | Concrete Arts India', 'Premium Velvet Series FRP planter VT4R61 with elegant velvet texture finish for indoor and outdoor landscaping applications.', 'Velvet FRP Planter, VT4R61 Planter, Round FRP Planter, Luxury Garden Planter', NULL, '2026-07-22 05:19:54', '2026-07-22 05:19:54'),
(93, 93, 'Velvet FRP Planter VT3R62 Manufacturer | Concrete Arts India', 'Premium Velvet Series FRP planter VT3R62 with elegant velvet texture finish for indoor and outdoor landscaping applications.', 'Velvet FRP Planter, VT3R62 Planter, Round FRP Planter, Luxury Garden Planter', NULL, '2026-07-22 05:19:54', '2026-07-22 05:19:54'),
(94, 94, 'Velvet FRP Planter VT3R63 Manufacturer | Concrete Arts India', 'Premium Velvet Series FRP planter VT3R63 with elegant velvet texture finish for indoor and outdoor landscaping applications.', 'Velvet FRP Planter, VT3R63 Planter, Round FRP Planter, Luxury Garden Planter', NULL, '2026-07-22 05:19:54', '2026-07-22 05:19:54'),
(95, 95, 'Velvet FRP Planter VT3R64 Manufacturer | Concrete Arts India', 'Premium Velvet Series FRP planter VT3R64 with elegant velvet texture finish for indoor and outdoor landscaping applications.', 'Velvet FRP Planter, VT3R64 Planter, Round FRP Planter, Luxury Garden Planter', NULL, '2026-07-22 05:19:54', '2026-07-22 05:19:54');

-- --------------------------------------------------------

--
-- Table structure for table `product_sizes`
--

CREATE TABLE `product_sizes` (
  `id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `size` varchar(100) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `length_mm` decimal(10,2) DEFAULT NULL,
  `length_inch` decimal(10,2) DEFAULT NULL,
  `breadth_mm` decimal(10,2) DEFAULT NULL,
  `breadth_inch` decimal(10,2) DEFAULT NULL,
  `height_mm` decimal(10,2) DEFAULT NULL,
  `height_inch` decimal(10,2) DEFAULT NULL,
  `sort_order` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `product_sizes`
--

INSERT INTO `product_sizes` (`id`, `product_id`, `size`, `price`, `length_mm`, `length_inch`, `breadth_mm`, `breadth_inch`, `height_mm`, `height_inch`, `sort_order`) VALUES
(1, 34, 'Large', '7563.00', '450.00', '18.00', '450.00', '18.00', '520.00', '21.00', 1),
(2, 34, 'Medium', '4538.00', '310.00', '13.00', '310.00', '13.00', '400.00', '16.00', 2),
(3, 34, 'Small', '2750.00', '220.00', '9.00', '220.00', '9.00', '270.00', '11.00', 3),
(4, 35, 'Large', '5844.00', '530.00', '21.00', '530.00', '21.00', '250.00', '10.00', 1),
(5, 35, 'Medium', '3506.00', '430.00', '17.00', '430.00', '17.00', '180.00', '7.00', 2),
(6, 35, 'Small', '2125.00', '300.00', '12.00', '300.00', '12.00', '120.00', '5.00', 3),
(7, 36, 'Large', '8044.00', '490.00', '20.00', '490.00', '20.00', '560.00', '23.00', 1),
(8, 36, 'Medium', '4826.00', '350.00', '14.00', '350.00', '14.00', '420.00', '17.00', 2),
(9, 36, 'Small', '2925.00', '260.00', '11.00', '260.00', '11.00', '320.00', '13.00', 3),
(10, 37, 'Large', '8044.00', '430.00', '17.00', '430.00', '17.00', '780.00', '31.00', 1),
(11, 37, 'Medium', '4826.00', '310.00', '13.00', '310.00', '13.00', '620.00', '25.00', 2),
(12, 37, 'Small', '2925.00', '250.00', '10.00', '250.00', '10.00', '470.00', '19.00', 3),
(13, 38, 'Large', '10381.00', '450.00', '18.00', '450.00', '18.00', '650.00', '26.00', 1),
(14, 38, 'Medium', '6229.00', '370.00', '15.00', '370.00', '15.00', '570.00', '23.00', 2),
(15, 38, 'Small', '3775.00', '300.00', '12.00', '300.00', '12.00', '470.00', '19.00', 3),
(16, 38, 'Extra Small', '2831.00', '240.00', '10.00', '240.00', '10.00', '380.00', '15.00', 4),
(17, 39, 'Large', '5225.00', '600.00', '24.00', '600.00', '24.00', '500.00', '20.00', 1),
(18, 39, 'Medium', '3135.00', '440.00', '18.00', '440.00', '18.00', '370.00', '15.00', 2),
(19, 39, 'Small', '1900.00', '330.00', '13.00', '330.00', '13.00', '280.00', '11.00', 3),
(20, 40, 'Large', '9281.00', '530.00', '21.00', '530.00', '21.00', '690.00', '28.00', 1),
(21, 40, 'Medium', '5569.00', '400.00', '16.00', '400.00', '16.00', '540.00', '22.00', 2),
(22, 40, 'Small', '3375.00', '310.00', '13.00', '310.00', '13.00', '410.00', '17.00', 3),
(23, 41, 'Large', '25250.00', '450.00', '18.00', '450.00', '18.00', '1510.00', '61.00', 1),
(24, 42, 'Large', '13213.00', '350.00', '14.00', '350.00', '14.00', '1210.00', '49.00', 1),
(25, 42, 'Medium', '6229.00', '285.00', '12.00', '280.00', '11.00', '1020.00', '41.00', 2),
(26, 43, 'Large', '7306.00', '500.00', '20.00', '500.00', '20.00', '400.00', '16.00', 1),
(27, 43, 'Medium', '3404.00', '380.00', '15.00', '380.00', '15.00', '300.00', '12.00', 2),
(28, 44, 'Large', '12031.00', '520.00', '21.00', '520.00', '21.00', '530.00', '21.00', 1),
(29, 44, 'Medium', '7219.00', '445.00', '18.00', '440.00', '18.00', '450.00', '18.00', 2),
(30, 44, 'Small', '4375.00', '370.00', '15.00', '370.00', '15.00', '370.00', '15.00', 3),
(31, 44, 'Extra Small', '3281.00', '300.00', '12.00', '300.00', '12.00', '300.00', '12.00', 4),
(32, 45, 'Large', '6531.00', '490.00', '20.00', '490.00', '20.00', '410.00', '17.00', 1),
(33, 45, 'Medium', '3919.00', '360.00', '14.00', '360.00', '14.00', '310.00', '13.00', 2),
(34, 45, 'Small', '2375.00', '280.00', '11.00', '280.00', '11.00', '220.00', '9.00', 3),
(35, 46, 'Large', '6531.00', '430.00', '17.00', '430.00', '17.00', '480.00', '19.00', 1),
(36, 46, 'Medium', '3919.00', '360.00', '14.00', '360.00', '14.00', '420.00', '17.00', 2),
(37, 46, 'Small', '2375.00', '280.00', '11.00', '280.00', '11.00', '330.00', '13.00', 3),
(38, 47, 'Large', '9281.00', '540.00', '22.00', '540.00', '22.00', '500.00', '20.00', 1),
(39, 47, 'Medium', '5569.00', '440.00', '18.00', '440.00', '18.00', '410.00', '17.00', 2),
(40, 47, 'Small', '3375.00', '370.00', '15.00', '370.00', '15.00', '360.00', '15.00', 3),
(41, 47, 'Extra Small', '2531.00', '280.00', '11.00', '280.00', '11.00', '260.00', '10.00', 4),
(42, 48, 'Large', '7761.00', '520.00', '21.00', '520.00', '21.00', '430.00', '17.00', 1),
(43, 48, 'Medium', '4657.00', '400.00', '16.00', '400.00', '16.00', '330.00', '13.00', 2),
(44, 48, 'Small', '2822.00', '300.00', '12.00', '300.00', '12.00', '250.00', '10.00', 3),
(45, 49, 'Large', '9763.00', '500.00', '20.00', '490.00', '20.00', '500.00', '20.00', 1),
(46, 49, 'Medium', '6213.00', '420.00', '17.00', '410.00', '17.00', '420.00', '17.00', 2),
(47, 49, 'Small', '3550.00', '360.00', '14.00', '350.00', '14.00', '360.00', '14.00', 3),
(48, 49, 'Extra Small', '2663.00', '260.00', '10.00', '250.00', '10.00', '260.00', '10.00', 4),
(49, 50, 'Large', '9023.00', '550.00', '22.00', '480.00', '19.00', '550.00', '22.00', 1),
(50, 50, 'Medium', '5742.00', '440.00', '18.00', '390.00', '16.00', '440.00', '18.00', 2),
(51, 50, 'Small', '3281.00', '350.00', '14.00', '300.00', '12.00', '350.00', '14.00', 3),
(52, 50, 'Extra Small', '2461.00', '270.00', '11.00', '240.00', '10.00', '270.00', '11.00', 4),
(53, 51, 'Large', '7527.00', '480.00', '19.00', '550.00', '22.00', '480.00', '19.00', 1),
(54, 51, 'Medium', '4106.00', '360.00', '14.00', '430.00', '17.00', '360.00', '14.00', 2),
(55, 51, 'Small', '2737.00', '270.00', '11.00', '350.00', '14.00', '270.00', '11.00', 3),
(56, 52, 'Large', '12031.00', '520.00', '21.00', '520.00', '21.00', '520.00', '21.00', 1),
(57, 52, 'Medium', '7656.00', '440.00', '18.00', '440.00', '18.00', '440.00', '18.00', 2),
(58, 52, 'Small', '4375.00', '370.00', '15.00', '370.00', '15.00', '370.00', '15.00', 3),
(59, 52, 'Extra Small', '3281.00', '300.00', '12.00', '300.00', '12.00', '300.00', '12.00', 4),
(60, 53, 'Large', '9075.00', '560.00', '23.00', '560.00', '23.00', '610.00', '24.00', 1),
(61, 53, 'Medium', '5445.00', '410.00', '17.00', '410.00', '17.00', '460.00', '19.00', 2),
(62, 53, 'Small', '3300.00', '280.00', '11.00', '280.00', '11.00', '310.00', '13.00', 3),
(63, 53, 'Extra Small', '2475.00', '190.00', '8.00', '190.00', '8.00', '210.00', '9.00', 4),
(64, 54, 'Large', '12031.00', '530.00', '21.00', '530.00', '21.00', '510.00', '20.00', 1),
(65, 54, 'Medium', '7219.00', '410.00', '17.00', '410.00', '17.00', '450.00', '18.00', 2),
(66, 54, 'Small', '4375.00', '390.00', '16.00', '390.00', '16.00', '380.00', '15.00', 3),
(67, 54, 'Extra Small', '3281.00', '310.00', '13.00', '310.00', '13.00', '310.00', '13.00', 4),
(68, 55, 'Large', '9281.00', '550.00', '21.00', '550.00', '21.00', '500.00', '20.00', 1),
(69, 55, 'Medium', '5569.00', '440.00', '18.00', '440.00', '18.00', '410.00', '17.00', 2),
(70, 55, 'Small', '3375.00', '370.00', '15.00', '370.00', '15.00', '340.00', '14.00', 3),
(71, 55, 'Extra Small', '2531.00', '300.00', '12.00', '300.00', '12.00', '280.00', '11.00', 4),
(72, 56, 'Large', '8388.00', '510.00', '20.00', '510.00', '20.00', '420.00', '17.00', 1),
(73, 56, 'Medium', '5033.00', '400.00', '16.00', '400.00', '16.00', '320.00', '13.00', 2),
(74, 56, 'Small', '3050.00', '310.00', '13.00', '310.00', '13.00', '250.00', '10.00', 3),
(75, 57, 'Large', '9281.00', '560.00', '23.00', '560.00', '23.00', '530.00', '21.00', 1),
(76, 57, 'Medium', '5569.00', '460.00', '19.00', '460.00', '19.00', '460.00', '19.00', 2),
(77, 57, 'Small', '3375.00', '360.00', '14.00', '360.00', '14.00', '320.00', '13.00', 3),
(78, 57, 'Extra Small', '2531.00', '260.00', '10.00', '260.00', '10.00', '250.00', '10.00', 4),
(79, 58, 'Large', '6050.00', '560.00', '23.00', '560.00', '23.00', '270.00', '11.00', 1),
(80, 58, 'Medium', '3630.00', '440.00', '18.00', '440.00', '18.00', '180.00', '7.00', 2),
(81, 58, 'Small', '2200.00', '300.00', '12.00', '300.00', '12.00', '150.00', '6.00', 3),
(82, 59, 'Large', '6050.00', '620.00', '25.00', '620.00', '25.00', '260.00', '10.00', 1),
(83, 59, 'Medium', '3630.00', '500.00', '20.00', '500.00', '20.00', '180.00', '7.00', 2),
(84, 59, 'Small', '2200.00', '350.00', '14.00', '350.00', '14.00', '130.00', '5.00', 3),
(85, 60, 'Large', '11825.00', '910.00', '36.00', '400.00', '16.00', '450.00', '18.00', 1),
(86, 60, 'Medium', '7095.00', '700.00', '28.00', '300.00', '12.00', '350.00', '14.00', 2),
(87, 61, 'Large', '11344.00', '910.00', '36.00', '400.00', '16.00', '450.00', '18.00', 1),
(88, 61, 'Medium', '6806.00', '700.00', '28.00', '300.00', '12.00', '350.00', '14.00', 2),
(89, 62, 'Large', '12513.00', '530.00', '21.00', '530.00', '21.00', '700.00', '28.00', 1),
(90, 62, 'Medium', '7508.00', '420.00', '17.00', '420.00', '17.00', '560.00', '22.00', 2),
(91, 62, 'Small', '4550.00', '330.00', '13.00', '330.00', '13.00', '440.00', '18.00', 3),
(92, 62, 'Extra Small', '3413.00', '260.00', '10.00', '260.00', '10.00', '350.00', '14.00', 4),
(93, 63, 'Large', '10863.00', '770.00', '31.00', '500.00', '20.00', '390.00', '16.00', 1),
(94, 63, 'Medium', '6518.00', '600.00', '24.00', '390.00', '16.00', '300.00', '12.00', 2),
(95, 63, 'Small', '3950.00', '450.00', '18.00', '290.00', '12.00', '220.00', '9.00', 3),
(96, 64, 'Large', '9281.00', '530.00', '21.00', '530.00', '21.00', '490.00', '20.00', 1),
(97, 64, 'Medium', '5569.00', '420.00', '17.00', '420.00', '17.00', '410.00', '17.00', 2),
(98, 64, 'Small', '3375.00', '350.00', '14.00', '350.00', '14.00', '340.00', '14.00', 3),
(99, 64, 'Extra Small', '2531.00', '280.00', '11.00', '280.00', '11.00', '270.00', '11.00', 4),
(100, 65, 'Large', '8869.00', '550.00', '22.00', '550.00', '22.00', '450.00', '18.00', 1),
(101, 65, 'Medium', '5321.00', '440.00', '18.00', '440.00', '18.00', '350.00', '14.00', 2),
(102, 65, 'Small', '3225.00', '370.00', '15.00', '370.00', '15.00', '300.00', '12.00', 3),
(103, 65, 'Extra Small', '2419.00', '300.00', '12.00', '300.00', '12.00', '240.00', '10.00', 4),
(104, 66, 'Large', '11069.00', '550.00', '22.00', '550.00', '22.00', '510.00', '20.00', 1),
(105, 66, 'Medium', '6641.00', '440.00', '18.00', '440.00', '18.00', '400.00', '16.00', 2),
(106, 66, 'Small', '4025.00', '370.00', '15.00', '370.00', '15.00', '340.00', '14.00', 3),
(107, 66, 'Extra Small', '3019.00', '300.00', '12.00', '300.00', '12.00', '280.00', '11.00', 4),
(108, 67, 'Large', '6944.00', '530.00', '21.00', '530.00', '21.00', '380.00', '15.00', 1),
(109, 67, 'Medium', '4166.00', '400.00', '16.00', '400.00', '16.00', '280.00', '11.00', 2),
(110, 67, 'Small', '2525.00', '300.00', '12.00', '280.00', '11.00', '200.00', '8.00', 3),
(111, 68, 'Large', '9075.00', '560.00', '23.00', '560.00', '23.00', '610.00', '24.00', 1),
(112, 68, 'Medium', '5445.00', '410.00', '17.00', '410.00', '17.00', '460.00', '19.00', 2),
(113, 68, 'Small', '3300.00', '280.00', '11.00', '280.00', '11.00', '310.00', '13.00', 3),
(114, 68, 'Extra Small', '2475.00', '190.00', '8.00', '190.00', '8.00', '210.00', '9.00', 4),
(115, 69, 'Large', '12719.00', '550.00', '22.00', '550.00', '22.00', '1010.00', '40.00', 1),
(116, 69, 'Medium', '7653.00', '420.00', '17.00', '420.00', '17.00', '780.00', '31.00', 2),
(117, 69, 'Small', '4625.00', '320.00', '13.00', '320.00', '13.00', '620.00', '25.00', 3),
(118, 69, 'Extra Small', '3469.00', '240.00', '10.00', '240.00', '10.00', '470.00', '19.00', 4),
(119, 70, 'Large', '11619.00', '900.00', '36.00', '490.00', '20.00', '370.00', '15.00', 1),
(120, 70, 'Medium', '6971.00', '730.00', '29.00', '350.00', '14.00', '320.00', '13.00', 2),
(121, 70, 'Small', '4225.00', '590.00', '24.00', '240.00', '10.00', '280.00', '11.00', 3),
(122, 71, 'Large', '7563.00', '450.00', '18.00', '450.00', '18.00', '500.00', '20.00', 1),
(123, 71, 'Medium', '4125.00', '330.00', '13.00', '330.00', '13.00', '370.00', '15.00', 2),
(124, 71, 'Small', '2750.00', '230.00', '9.00', '230.00', '9.00', '260.00', '10.00', 3),
(125, 72, 'Large', '5844.00', '550.00', '22.00', '550.00', '22.00', '600.00', '24.00', 1),
(126, 72, 'Medium', '3188.00', '440.00', '18.00', '440.00', '18.00', '480.00', '19.00', 2),
(127, 72, 'Small', '2125.00', '310.00', '12.00', '310.00', '12.00', '340.00', '13.00', 3),
(128, 73, 'Large', '8044.00', '550.00', '22.00', '550.00', '22.00', '550.00', '22.00', 1),
(129, 73, 'Medium', '4388.00', '370.00', '15.00', '370.00', '15.00', '370.00', '15.00', 2),
(130, 73, 'Small', '2925.00', '250.00', '10.00', '250.00', '10.00', '250.00', '10.00', 3),
(131, 74, 'Large', '9281.00', '530.00', '21.00', '530.00', '21.00', '570.00', '22.00', 1),
(132, 74, 'Medium', '5906.00', '430.00', '17.00', '430.00', '17.00', '470.00', '19.00', 2),
(133, 74, 'Small', '3375.00', '350.00', '14.00', '350.00', '14.00', '400.00', '16.00', 3),
(134, 74, 'Extra Small', '2531.00', '240.00', '10.00', '240.00', '10.00', '280.00', '11.00', 4),
(135, 75, 'Large', '7807.00', '490.00', '20.00', '490.00', '20.00', '550.00', '22.00', 1),
(136, 75, 'Medium', '4259.00', '370.00', '15.00', '370.00', '15.00', '410.00', '16.00', 2),
(137, 75, 'Small', '2839.00', '270.00', '11.00', '270.00', '11.00', '310.00', '12.00', 3),
(138, 76, 'Large', '6732.00', '490.00', '20.00', '490.00', '20.00', '540.00', '21.00', 1),
(139, 76, 'Medium', '3672.00', '380.00', '15.00', '380.00', '15.00', '410.00', '16.00', 2),
(140, 76, 'Small', '2440.00', '290.00', '11.00', '290.00', '11.00', '320.00', '13.00', 3),
(141, 77, 'Large', '12031.00', '520.00', '20.00', '520.00', '20.00', '520.00', '20.00', 1),
(142, 77, 'Medium', '7656.00', '440.00', '17.00', '440.00', '17.00', '440.00', '17.00', 2),
(143, 77, 'Small', '4375.00', '370.00', '15.00', '370.00', '15.00', '370.00', '15.00', 3),
(144, 77, 'Extra Small', '3281.00', '300.00', '12.00', '300.00', '12.00', '300.00', '12.00', 4),
(145, 78, 'Large', '7838.00', '420.00', '17.00', '420.00', '17.00', '790.00', '31.00', 1),
(146, 78, 'Medium', '4275.00', '320.00', '13.00', '320.00', '13.00', '620.00', '25.00', 2),
(147, 78, 'Small', '2450.00', '250.00', '10.00', '250.00', '10.00', '460.00', '18.00', 3),
(148, 79, 'Large', '9763.00', '500.00', '20.00', '500.00', '20.00', '490.00', '19.00', 1),
(149, 79, 'Medium', '6213.00', '420.00', '17.00', '420.00', '17.00', '410.00', '16.00', 2),
(150, 79, 'Small', '3550.00', '360.00', '14.00', '360.00', '14.00', '350.00', '14.00', 3),
(151, 79, 'Extra Small', '2663.00', '260.00', '10.00', '260.00', '10.00', '250.00', '10.00', 4),
(152, 80, 'Large', '7838.00', '420.00', '17.00', '420.00', '17.00', '770.00', '30.00', 1),
(153, 80, 'Medium', '4275.00', '350.00', '14.00', '350.00', '14.00', '650.00', '26.00', 2),
(154, 80, 'Small', '2450.00', '250.00', '10.00', '250.00', '10.00', '460.00', '18.00', 3),
(155, 81, 'Large', '9023.00', '550.00', '22.00', '550.00', '22.00', '480.00', '19.00', 1),
(156, 81, 'Medium', '5742.00', '440.00', '18.00', '440.00', '18.00', '390.00', '15.00', 2),
(157, 81, 'Small', '3281.00', '350.00', '14.00', '350.00', '14.00', '300.00', '12.00', 3),
(158, 81, 'Extra Small', '2461.00', '270.00', '11.00', '270.00', '11.00', '240.00', '9.00', 4),
(159, 82, 'Large', '7761.00', '550.00', '22.00', '550.00', '22.00', '410.00', '16.00', 1),
(160, 82, 'Medium', '4233.00', '420.00', '17.00', '420.00', '17.00', '350.00', '14.00', 2),
(161, 82, 'Small', '2822.00', '350.00', '14.00', '350.00', '14.00', '250.00', '10.00', 3),
(162, 83, 'Large', '7920.00', '520.00', '20.00', '520.00', '20.00', '410.00', '16.00', 1),
(163, 83, 'Medium', '4320.00', '450.00', '18.00', '450.00', '18.00', '310.00', '12.00', 2),
(164, 83, 'Small', '2880.00', '300.00', '12.00', '300.00', '12.00', '230.00', '9.00', 3),
(165, 84, 'Large', '7920.00', '520.00', '20.00', '520.00', '20.00', '410.00', '16.00', 1),
(166, 84, 'Medium', '4320.00', '450.00', '18.00', '450.00', '18.00', '310.00', '12.00', 2),
(167, 84, 'Small', '2880.00', '300.00', '12.00', '300.00', '12.00', '230.00', '9.00', 3),
(168, 85, 'Large', '8322.00', '490.00', '19.00', '490.00', '19.00', '610.00', '24.00', 1),
(169, 85, 'Medium', '4539.00', '360.00', '14.00', '360.00', '14.00', '450.00', '18.00', 2),
(170, 85, 'Small', '3026.00', '250.00', '10.00', '250.00', '10.00', '310.00', '12.00', 3),
(171, 86, 'Large', '7527.00', '480.00', '19.00', '480.00', '19.00', '550.00', '22.00', 1),
(172, 86, 'Medium', '4106.00', '360.00', '14.00', '360.00', '14.00', '430.00', '17.00', 2),
(173, 86, 'Small', '2737.00', '270.00', '11.00', '270.00', '11.00', '350.00', '14.00', 3),
(174, 87, 'Large', '7761.00', '530.00', '21.00', '530.00', '21.00', '370.00', '15.00', 1),
(175, 87, 'Medium', '4233.00', '390.00', '16.00', '390.00', '16.00', '270.00', '11.00', 2),
(176, 87, 'Small', '2822.00', '260.00', '10.00', '260.00', '10.00', '180.00', '7.00', 3),
(177, 88, 'Large', '5657.00', '550.00', '22.00', '550.00', '22.00', '250.00', '10.00', 1),
(178, 88, 'Medium', '3086.00', '430.00', '17.00', '430.00', '17.00', '180.00', '7.00', 2),
(179, 88, 'Small', '2057.00', '310.00', '12.00', '310.00', '12.00', '120.00', '5.00', 3),
(180, 89, 'Large', '7920.00', '550.00', '22.00', '550.00', '22.00', '390.00', '15.00', 1),
(181, 89, 'Medium', '4320.00', '410.00', '16.00', '410.00', '16.00', '300.00', '12.00', 2),
(182, 89, 'Small', '2880.00', '310.00', '12.00', '310.00', '12.00', '230.00', '9.00', 3),
(183, 90, 'Large', '12031.00', '520.00', '20.00', '520.00', '20.00', '520.00', '20.00', 1),
(184, 90, 'Medium', '7656.00', '440.00', '17.00', '440.00', '17.00', '440.00', '17.00', 2),
(185, 90, 'Small', '4375.00', '370.00', '15.00', '370.00', '15.00', '370.00', '15.00', 3),
(186, 90, 'Extra Small', '3281.00', '300.00', '12.00', '300.00', '12.00', '300.00', '12.00', 4),
(187, 91, 'Large', '9763.00', '500.00', '20.00', '500.00', '20.00', '490.00', '19.00', 1),
(188, 91, 'Medium', '6213.00', '420.00', '17.00', '420.00', '17.00', '410.00', '16.00', 2),
(189, 91, 'Small', '3550.00', '330.00', '13.00', '330.00', '13.00', '320.00', '13.00', 3),
(190, 91, 'Extra Small', '2663.00', '260.00', '10.00', '260.00', '10.00', '250.00', '10.00', 4),
(191, 92, 'Large', '9023.00', '550.00', '22.00', '550.00', '22.00', '520.00', '20.00', 1),
(192, 92, 'Medium', '5742.00', '460.00', '18.00', '460.00', '18.00', '450.00', '18.00', 2),
(193, 92, 'Small', '3281.00', '350.00', '14.00', '350.00', '14.00', '310.00', '12.00', 3),
(194, 92, 'Extra Small', '2461.00', '260.00', '10.00', '260.00', '10.00', '250.00', '10.00', 4),
(195, 93, 'Large', '7920.00', '500.00', '20.00', '500.00', '20.00', '380.00', '15.00', 1),
(196, 93, 'Medium', '4320.00', '370.00', '15.00', '370.00', '15.00', '290.00', '11.00', 2),
(197, 93, 'Small', '2880.00', '290.00', '11.00', '290.00', '11.00', '220.00', '9.00', 3),
(198, 94, 'Large', '8044.00', '490.00', '19.00', '490.00', '19.00', '550.00', '22.00', 1),
(199, 94, 'Medium', '4388.00', '360.00', '14.00', '360.00', '14.00', '410.00', '16.00', 2),
(200, 94, 'Small', '2952.00', '270.00', '11.00', '270.00', '11.00', '310.00', '12.00', 3),
(201, 95, 'Large', '8195.00', '440.00', '17.00', '440.00', '17.00', '490.00', '19.00', 1),
(202, 95, 'Medium', '4470.00', '320.00', '13.00', '320.00', '13.00', '360.00', '14.00', 2),
(203, 95, 'Small', '2980.00', '230.00', '9.00', '230.00', '9.00', '260.00', '10.00', 3),
(211, 1, '', '450.00', '0.00', NULL, '0.00', NULL, '0.00', NULL, 0),
(212, 2, '', '450.00', '0.00', NULL, '0.00', NULL, '0.00', NULL, 0),
(213, 3, '', '450.00', '0.00', NULL, '0.00', NULL, '0.00', NULL, 0),
(214, 4, '', '450.00', '0.00', NULL, '0.00', NULL, '0.00', NULL, 0),
(215, 5, '', '450.00', '0.00', NULL, '0.00', NULL, '0.00', NULL, 0),
(216, 6, '', '450.00', '0.00', NULL, '0.00', NULL, '0.00', NULL, 0),
(217, 7, '', '450.00', '0.00', NULL, '0.00', NULL, '0.00', NULL, 0),
(218, 8, '', '450.00', '0.00', NULL, '0.00', NULL, '0.00', NULL, 0),
(219, 9, '', '450.00', '0.00', NULL, '0.00', NULL, '0.00', NULL, 0),
(220, 10, '', '7500.00', '0.00', NULL, '0.00', NULL, '0.00', NULL, 0),
(221, 11, '', '7500.00', '0.00', NULL, '0.00', NULL, '0.00', NULL, 0),
(222, 12, '', '7500.00', '0.00', NULL, '0.00', NULL, '0.00', NULL, 0),
(223, 13, '', '7500.00', '0.00', NULL, '0.00', NULL, '0.00', NULL, 0),
(224, 14, '', '7500.00', '0.00', NULL, '0.00', NULL, '0.00', NULL, 0),
(225, 15, '', '7500.00', '0.00', NULL, '0.00', NULL, '0.00', NULL, 0),
(226, 16, '', '7500.00', '0.00', NULL, '0.00', NULL, '0.00', NULL, 0),
(227, 17, '', '7500.00', '0.00', NULL, '0.00', NULL, '0.00', NULL, 0),
(228, 18, '', '7500.00', '0.00', NULL, '0.00', NULL, '0.00', NULL, 0),
(229, 19, '', '7500.00', '0.00', NULL, '0.00', NULL, '0.00', NULL, 0),
(230, 20, '', '7500.00', '0.00', NULL, '0.00', NULL, '0.00', NULL, 0),
(231, 21, '', '7500.00', '0.00', NULL, '0.00', NULL, '0.00', NULL, 0),
(232, 22, '', '7500.00', '0.00', NULL, '0.00', NULL, '0.00', NULL, 0),
(233, 23, '', '7500.00', '0.00', NULL, '0.00', NULL, '0.00', NULL, 0),
(234, 24, '', '7500.00', '0.00', NULL, '0.00', NULL, '0.00', NULL, 0);
INSERT INTO `product_sizes` (`id`, `product_id`, `size`, `price`, `length_mm`, `length_inch`, `breadth_mm`, `breadth_inch`, `height_mm`, `height_inch`, `sort_order`) VALUES
(235, 25, '', '7500.00', '0.00', NULL, '0.00', NULL, '0.00', NULL, 0),
(236, 26, '', '50000.00', '0.00', NULL, '0.00', NULL, '0.00', NULL, 0),
(237, 27, '', '50000.00', '0.00', NULL, '0.00', NULL, '0.00', NULL, 0),
(238, 28, '', '50000.00', '0.00', NULL, '0.00', NULL, '0.00', NULL, 0),
(239, 29, '', '50000.00', '0.00', NULL, '0.00', NULL, '0.00', NULL, 0),
(240, 30, '', '50000.00', '0.00', NULL, '0.00', NULL, '0.00', NULL, 0),
(241, 32, '', '50000.00', '0.00', NULL, '0.00', NULL, '0.00', NULL, 0),
(242, 33, '', '50000.00', '0.00', NULL, '0.00', NULL, '0.00', NULL, 0),
(243, 31, '', '50000.00', '0.00', NULL, '0.00', NULL, '0.00', NULL, 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin_users`
--
ALTER TABLE `admin_users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slug` (`slug`);

--
-- Indexes for table `enquiries`
--
ALTER TABLE `enquiries`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_phone` (`phone`),
  ADD KEY `idx_email` (`email`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slug` (`slug`),
  ADD KEY `category_id` (`category_id`);

--
-- Indexes for table `product_features`
--
ALTER TABLE `product_features`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_product_features_product` (`product_id`);

--
-- Indexes for table `product_images`
--
ALTER TABLE `product_images`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `product_seo`
--
ALTER TABLE `product_seo`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_product_seo_product` (`product_id`);

--
-- Indexes for table `product_sizes`
--
ALTER TABLE `product_sizes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_id` (`product_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin_users`
--
ALTER TABLE `admin_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `enquiries`
--
ALTER TABLE `enquiries`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=69;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=100;

--
-- AUTO_INCREMENT for table `product_features`
--
ALTER TABLE `product_features`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=639;

--
-- AUTO_INCREMENT for table `product_images`
--
ALTER TABLE `product_images`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=100;

--
-- AUTO_INCREMENT for table `product_seo`
--
ALTER TABLE `product_seo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=100;

--
-- AUTO_INCREMENT for table `product_sizes`
--
ALTER TABLE `product_sizes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=244;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `product_features`
--
ALTER TABLE `product_features`
  ADD CONSTRAINT `fk_product_features_product` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `product_images`
--
ALTER TABLE `product_images`
  ADD CONSTRAINT `product_images_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `product_seo`
--
ALTER TABLE `product_seo`
  ADD CONSTRAINT `fk_product_seo_product` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `product_sizes`
--
ALTER TABLE `product_sizes`
  ADD CONSTRAINT `product_sizes_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
