-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 21, 2025 at 04:31 PM
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
-- Database: `ecommerce`
--

-- --------------------------------------------------------

--
-- Table structure for table `addresses`
--

CREATE TABLE `addresses` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `locality` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `country` varchar(255) NOT NULL,
  `state` varchar(255) NOT NULL,
  `city` varchar(255) NOT NULL,
  `landmark` varchar(255) DEFAULT NULL,
  `zipcode` varchar(255) NOT NULL,
  `type` varchar(255) NOT NULL DEFAULT 'home',
  `is_default` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `addresses`
--

INSERT INTO `addresses` (`id`, `user_id`, `name`, `phone`, `locality`, `address`, `country`, `state`, `city`, `landmark`, `zipcode`, `type`, `is_default`, `created_at`, `updated_at`) VALUES
(1, 1, 'Bharat Prajapati', '09824115971', 'Naroda', 'C/2 Yamuna Nagar Society', 'India', 'Gujarat', 'Ahmedabad', 'Ahmedabad', '382330', 'home', 1, '2025-07-18 04:41:18', '2025-07-18 04:41:18'),
(2, 2, 'jiagrPrajapati', '09824115971', 'Naroda', 'C/2 Yamuna Nagar Society', 'India', 'Gujarat', 'Ahmedabad', 'Ahmedabad', '382330', 'home', 1, '2025-07-18 23:33:15', '2025-07-18 23:33:15'),
(3, 4, 'rahul', '9638524578', 'Glasgow', '12 Post Road', 'UK', 'Scotland', 'Glasgow', 'Glasgow', '963563', 'home', 1, '2025-07-19 06:53:13', '2025-07-19 06:53:13'),
(4, 3, 'vijay', '8546989563', 'marin drive', '89 red bunglow', 'India', 'Maharastra', 'Mumbai', 'marin drive', '578999', 'home', 1, '2025-07-19 07:08:27', '2025-07-19 07:08:27');

-- --------------------------------------------------------

--
-- Table structure for table `brands`
--

CREATE TABLE `brands` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `image` text NOT NULL,
  `status` enum('Active','Inactive') NOT NULL DEFAULT 'Active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `brands`
--

INSERT INTO `brands` (`id`, `name`, `slug`, `image`, `status`, `created_at`, `updated_at`) VALUES
(6, 'demo', 'demo', '1751647059.download.jpg', 'Active', '2025-07-04 11:07:39', '2025-07-04 11:07:39'),
(7, 'Bharat', 'bharat', '1751647132.A-Simple-Computer-Network.png', 'Inactive', '2025-07-04 11:08:52', '2025-07-04 11:13:49'),
(8, 'test', 'test', '1751686234.A-Simple-Computer-Network.png', 'Active', '2025-07-04 22:00:34', '2025-07-04 22:00:34'),
(9, 'test-1', 'test-1', '1751686370.A-Simple-Computer-Network.png', 'Active', '2025-07-04 22:02:50', '2025-07-04 22:02:50'),
(10, 'sdsds', 'sdsds', '1751686433.A-Simple-Computer-Network.png', 'Active', '2025-07-04 22:03:53', '2025-07-04 22:03:53'),
(11, 'sdsdsdsd', 'sdsdsdsd', '1751686465.A-Simple-Computer-Network.png', 'Active', '2025-07-04 22:04:25', '2025-07-04 22:04:25'),
(12, 'ffff', 'ffff', '1751686520.A-Simple-Computer-Network.png', 'Active', '2025-07-04 22:05:20', '2025-07-04 22:05:20');

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cache`
--

INSERT INTO `cache` (`key`, `value`, `expiration`) VALUES
('laravel_cache_admin@gmail.com|127.0.0.1', 'i:1;', 1752922107),
('laravel_cache_admin@gmail.com|127.0.0.1:timer', 'i:1752922107;', 1752922107),
('laravel_cache_sachiin@gmail.com|127.0.0.1', 'i:2;', 1752924597),
('laravel_cache_sachiin@gmail.com|127.0.0.1:timer', 'i:1752924597;', 1752924597),
('laravel_cache_vbh@gmail.com|127.0.0.1', 'i:1;', 1752924299),
('laravel_cache_vbh@gmail.com|127.0.0.1:timer', 'i:1752924298;', 1752924298);

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `image` text NOT NULL,
  `status` enum('Active','Inactive') NOT NULL DEFAULT 'Active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `slug`, `image`, `status`, `created_at`, `updated_at`) VALUES
(2, 'category-2', 'category-2', '1752910610.png', 'Active', '2025-07-05 07:18:25', '2025-07-19 02:06:50'),
(3, 'category-1', 'category-1', '1752910585.png', 'Active', '2025-07-12 03:12:20', '2025-07-19 02:06:25'),
(4, 'category-3', 'category-3', '1752910645.category_3.png', 'Active', '2025-07-19 02:07:25', '2025-07-19 02:07:25'),
(5, 'category-4', 'category-4', '1752910667.category_4.png', 'Active', '2025-07-19 02:07:47', '2025-07-19 02:07:47'),
(6, 'category-5', 'category-5', '1752910687.category_5.png', 'Active', '2025-07-19 02:08:07', '2025-07-19 02:08:07'),
(7, 'category-6', 'category-6', '1752910707.category_6.png', 'Active', '2025-07-19 02:08:27', '2025-07-19 02:08:27'),
(8, 'category-7', 'category-7', '1752910731.category_7.png', 'Active', '2025-07-19 02:08:51', '2025-07-19 02:08:51'),
(9, 'category-8', 'category-8', '1752910752.category_8.png', 'Active', '2025-07-19 02:09:12', '2025-07-19 02:09:12'),
(10, 'category-9', 'category-9', '1752910776.category_9.jpg', 'Active', '2025-07-19 02:09:36', '2025-07-19 02:09:36'),
(11, 'category-10', 'category-10', '1752910794.category_10.jpg', 'Active', '2025-07-19 02:09:54', '2025-07-19 02:09:54');

-- --------------------------------------------------------

--
-- Table structure for table `contacts`
--

CREATE TABLE `contacts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `message` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `contacts`
--

INSERT INTO `contacts` (`id`, `user_id`, `name`, `email`, `phone`, `message`, `created_at`, `updated_at`) VALUES
(1, 2, 'Bharat Prajapati', 'jb.prajapati079@gmail.com', '09824115971', 'niceone', '2025-07-19 03:12:08', '2025-07-19 03:12:08');

-- --------------------------------------------------------

--
-- Table structure for table `coupons`
--

CREATE TABLE `coupons` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `code` varchar(255) NOT NULL,
  `type` enum('fixed','percent') NOT NULL,
  `value` decimal(8,2) NOT NULL,
  `cart_value` decimal(8,2) NOT NULL,
  `expiry_date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `coupons`
--

INSERT INTO `coupons` (`id`, `code`, `type`, `value`, `cart_value`, `expiry_date`, `created_at`, `updated_at`) VALUES
(1, 'off-1', 'fixed', 30.00, 150.00, '2025-07-31 07:16:00', '2025-07-13 01:47:18', '2025-07-13 01:47:18'),
(2, 'off-2', 'percent', 45.00, 150.00, '2025-07-31 07:17:00', '2025-07-13 01:47:52', '2025-07-18 00:11:27');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(7, '0001_01_01_000000_create_users_table', 1),
(8, '0001_01_01_000001_create_cache_table', 1),
(9, '0001_01_01_000002_create_jobs_table', 1),
(10, '2025_07_04_130133_create_brands_table', 2),
(11, '2025_07_05_034807_create_categories_table', 3),
(12, '2025_07_05_040600_create_products_table', 4),
(14, '2025_07_13_034422_create_coupons_table', 5),
(19, '2025_07_18_042108_create_orders_table', 6),
(20, '2025_07_18_042114_create_order_items_table', 6),
(21, '2025_07_18_042122_create_addresses_table', 6),
(24, '2025_07_18_042132_create_transactions_table', 7),
(25, '2025_07_18_134419_create_slides_table', 8),
(26, '2025_07_19_081613_create_contacts_table', 9),
(27, '2025_07_21_131235_create_sizes_table', 10);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `order_id` bigint(20) UNSIGNED NOT NULL,
  `subtotal` decimal(10,2) NOT NULL,
  `discount` decimal(10,2) NOT NULL DEFAULT 0.00,
  `discount_amount` decimal(10,2) NOT NULL DEFAULT 0.00,
  `tax` decimal(10,2) DEFAULT NULL,
  `total` decimal(10,2) NOT NULL,
  `name` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `locality` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `country` varchar(255) NOT NULL,
  `state` varchar(255) NOT NULL,
  `city` varchar(255) NOT NULL,
  `landmark` varchar(255) DEFAULT NULL,
  `zipcode` varchar(255) NOT NULL,
  `type` varchar(255) NOT NULL DEFAULT 'home',
  `status` enum('ordered','delivered','canceled') NOT NULL DEFAULT 'ordered',
  `is_shipping_different` tinyint(1) NOT NULL DEFAULT 0,
  `delivered_date` timestamp NULL DEFAULT NULL,
  `canceled_date` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `order_id`, `subtotal`, `discount`, `discount_amount`, `tax`, `total`, `name`, `phone`, `locality`, `address`, `country`, `state`, `city`, `landmark`, `zipcode`, `type`, `status`, `is_shipping_different`, `delivered_date`, `canceled_date`, `created_at`, `updated_at`) VALUES
(1, 1, 9931, 629.00, 0.00, 0.00, NULL, 629.00, 'Bharat Prajapati', '09824115971', 'Naroda', 'C/2 Yamuna Nagar Society', 'India', 'Gujarat', 'Ahmedabad', 'Ahmedabad', '382330', 'home', 'canceled', 0, '2025-07-18 13:17:44', '2025-07-18 13:22:09', '2025-07-18 04:41:18', '2025-07-18 07:52:09'),
(6, 1, 3308, 90.00, 0.00, 0.00, NULL, 90.00, 'Bharat Prajapati', '09824115971', 'Naroda', 'C/2 Yamuna Nagar Society', 'India', 'Gujarat', 'Ahmedabad', 'Ahmedabad', '382330', 'home', 'delivered', 0, '2025-07-19 04:15:51', '2025-07-18 13:05:43', '2025-07-18 04:52:16', '2025-07-18 22:45:51'),
(12, 2, 9135, 539.00, 0.00, 0.00, NULL, 539.00, 'jiagrPrajapati', '09824115971', 'Naroda', 'C/2 Yamuna Nagar Society', 'India', 'Gujarat', 'Ahmedabad', 'Ahmedabad', '382330', 'home', 'delivered', 0, '2025-07-19 05:48:41', NULL, '2025-07-18 23:33:16', '2025-07-19 00:18:41'),
(13, 2, 5272, 1548.00, 0.00, 0.00, NULL, 1548.00, 'jiagrPrajapati', '09824115971', 'Naroda', 'C/2 Yamuna Nagar Society', 'India', 'Gujarat', 'Ahmedabad', 'Ahmedabad', '382330', 'home', 'canceled', 0, NULL, '2025-07-19 12:40:31', '2025-07-18 23:38:37', '2025-07-19 07:10:31'),
(14, 4, 8013, 449.00, 0.00, 0.00, NULL, 449.00, 'rahul', '9638524578', 'Glasgow', '12 Post Road', 'UK', 'Scotland', 'Glasgow', 'Glasgow', '963563', 'home', 'canceled', 0, NULL, '2025-07-19 12:40:37', '2025-07-19 06:53:13', '2025-07-19 07:10:37'),
(15, 4, 4486, 41997.00, 0.00, 0.00, NULL, 41997.00, 'rahul', '9638524578', 'Glasgow', '12 Post Road', 'UK', 'Scotland', 'Glasgow', 'Glasgow', '963563', 'home', 'ordered', 0, NULL, NULL, '2025-07-19 06:56:29', '2025-07-19 06:56:29'),
(16, 4, 7201, 27998.00, 0.00, 0.00, NULL, 27998.00, 'rahul', '9638524578', 'Glasgow', '12 Post Road', 'UK', 'Scotland', 'Glasgow', 'Glasgow', '963563', 'home', 'delivered', 0, '2025-07-19 12:40:51', NULL, '2025-07-19 07:02:26', '2025-07-19 07:10:51'),
(17, 4, 8239, 27998.00, 0.00, 0.00, NULL, 27998.00, 'rahul', '9638524578', 'Glasgow', '12 Post Road', 'UK', 'Scotland', 'Glasgow', 'Glasgow', '963563', 'home', 'delivered', 0, '2025-07-19 12:40:45', NULL, '2025-07-19 07:03:27', '2025-07-19 07:10:45'),
(18, 3, 2863, 2695.00, 0.00, 0.00, NULL, 2695.00, 'vijay', '8546989563', 'marin drive', '89 red bunglow', 'India', 'Maharastra', 'Mumbai', 'marin drive', '578999', 'home', 'ordered', 0, NULL, NULL, '2025-07-19 07:08:27', '2025-07-19 07:08:27'),
(19, 3, 2611, 69995.00, 0.00, 0.00, NULL, 69995.00, 'vijay', '8546989563', 'marin drive', '89 red bunglow', 'India', 'Maharastra', 'Mumbai', 'marin drive', '578999', 'home', 'ordered', 0, NULL, NULL, '2025-07-19 07:09:16', '2025-07-19 07:09:16'),
(20, 3, 4325, 90.00, 0.00, 0.00, NULL, 90.00, 'vijay', '8546989563', 'marin drive', '89 red bunglow', 'India', 'Maharastra', 'Mumbai', 'marin drive', '578999', 'home', 'ordered', 0, NULL, NULL, '2025-07-20 23:37:33', '2025-07-20 23:37:33'),
(21, 3, 8320, 90.00, 0.00, 0.00, NULL, 90.00, 'vijay', '8546989563', 'marin drive', '89 red bunglow', 'India', 'Maharastra', 'Mumbai', 'marin drive', '578999', 'home', 'ordered', 0, NULL, NULL, '2025-07-20 23:40:42', '2025-07-20 23:40:42'),
(22, 3, 4305, 90.00, 0.00, 0.00, NULL, 90.00, 'vijay', '8546989563', 'marin drive', '89 red bunglow', 'India', 'Maharastra', 'Mumbai', 'marin drive', '578999', 'home', 'ordered', 0, NULL, NULL, '2025-07-20 23:43:15', '2025-07-20 23:43:15'),
(23, 3, 3877, 90.00, 30.00, 30.00, NULL, 60.00, 'vijay', '8546989563', 'marin drive', '89 red bunglow', 'India', 'Maharastra', 'Mumbai', 'marin drive', '578999', 'home', 'ordered', 0, NULL, NULL, '2025-07-20 23:44:28', '2025-07-20 23:44:28'),
(24, 3, 7081, 2066.00, 45.00, 929.70, NULL, 1136.30, 'vijay', '8546989563', 'marin drive', '89 red bunglow', 'India', 'Maharastra', 'Mumbai', 'marin drive', '578999', 'home', 'ordered', 0, NULL, NULL, '2025-07-20 23:48:13', '2025-07-20 23:48:13'),
(25, 3, 8969, 3545.00, 30.00, 30.00, NULL, 3515.00, 'vijay', '8546989563', 'marin drive', '89 red bunglow', 'India', 'Maharastra', 'Mumbai', 'marin drive', '578999', 'home', 'ordered', 0, NULL, NULL, '2025-07-21 00:02:27', '2025-07-21 00:02:27'),
(26, 3, 3083, 60281.00, 30.00, 30.00, NULL, 60251.00, 'vijay', '8546989563', 'marin drive', '89 red bunglow', 'India', 'Maharastra', 'Mumbai', 'marin drive', '578999', 'home', 'ordered', 0, NULL, NULL, '2025-07-21 00:08:08', '2025-07-21 00:08:08'),
(27, 3, 6612, 90.00, 0.00, 0.00, NULL, 90.00, 'vijay', '8546989563', 'marin drive', '89 red bunglow', 'India', 'Maharastra', 'Mumbai', 'marin drive', '578999', 'home', 'ordered', 0, NULL, NULL, '2025-07-21 00:10:59', '2025-07-21 00:10:59'),
(28, 3, 2099, 90.00, 0.00, 0.00, NULL, 90.00, 'vijay', '8546989563', 'marin drive', '89 red bunglow', 'India', 'Maharastra', 'Mumbai', 'marin drive', '578999', 'home', 'ordered', 0, NULL, NULL, '2025-07-21 00:19:37', '2025-07-21 00:19:37'),
(29, 3, 2678, 90.00, 0.00, 0.00, NULL, 90.00, 'vijay', '8546989563', 'marin drive', '89 red bunglow', 'India', 'Maharastra', 'Mumbai', 'marin drive', '578999', 'home', 'ordered', 0, NULL, NULL, '2025-07-21 00:24:20', '2025-07-21 00:24:20'),
(30, 3, 9377, 90.00, 0.00, 0.00, NULL, 90.00, 'vijay', '8546989563', 'marin drive', '89 red bunglow', 'India', 'Maharastra', 'Mumbai', 'marin drive', '578999', 'home', 'ordered', 0, NULL, NULL, '2025-07-21 00:48:37', '2025-07-21 00:48:37'),
(31, 3, 6859, 90.00, 0.00, 0.00, NULL, 90.00, 'vijay', '8546989563', 'marin drive', '89 red bunglow', 'India', 'Maharastra', 'Mumbai', 'marin drive', '578999', 'home', 'ordered', 0, NULL, NULL, '2025-07-21 00:49:32', '2025-07-21 00:49:32');

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `order_id` bigint(20) UNSIGNED NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `qty` int(11) NOT NULL,
  `options` text DEFAULT NULL,
  `rstatus` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`id`, `product_id`, `order_id`, `price`, `qty`, `options`, `rstatus`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 90.00, 2, NULL, 0, '2025-07-18 04:41:18', '2025-07-18 04:41:18'),
(2, 2, 1, 449.00, 1, NULL, 0, '2025-07-18 04:41:18', '2025-07-18 04:41:18'),
(11, 1, 6, 90.00, 1, NULL, 0, '2025-07-18 04:52:16', '2025-07-18 04:52:16'),
(18, 1, 12, 90.00, 1, NULL, 0, '2025-07-18 23:33:16', '2025-07-18 23:33:16'),
(19, 2, 12, 449.00, 1, NULL, 0, '2025-07-18 23:33:16', '2025-07-18 23:33:16'),
(20, 2, 13, 449.00, 1, NULL, 0, '2025-07-18 23:38:37', '2025-07-18 23:38:37'),
(21, 3, 13, 1099.00, 1, NULL, 0, '2025-07-18 23:38:37', '2025-07-18 23:38:37'),
(22, 2, 14, 449.00, 1, NULL, 0, '2025-07-19 06:53:13', '2025-07-19 06:53:13'),
(23, 5, 15, 13999.00, 3, NULL, 0, '2025-07-19 06:56:29', '2025-07-19 06:56:29'),
(24, 5, 16, 13999.00, 2, NULL, 0, '2025-07-19 07:02:26', '2025-07-19 07:02:26'),
(25, 5, 17, 13999.00, 2, NULL, 0, '2025-07-19 07:03:28', '2025-07-19 07:03:28'),
(26, 1, 18, 90.00, 5, NULL, 0, '2025-07-19 07:08:27', '2025-07-19 07:08:27'),
(27, 2, 18, 449.00, 5, NULL, 0, '2025-07-19 07:08:28', '2025-07-19 07:08:28'),
(28, 5, 19, 13999.00, 5, NULL, 0, '2025-07-19 07:09:16', '2025-07-19 07:09:16'),
(29, 1, 20, 90.00, 1, NULL, 0, '2025-07-20 23:37:33', '2025-07-20 23:37:33'),
(30, 1, 21, 90.00, 1, NULL, 0, '2025-07-20 23:40:42', '2025-07-20 23:40:42'),
(31, 1, 22, 90.00, 1, NULL, 0, '2025-07-20 23:43:15', '2025-07-20 23:43:15'),
(32, 1, 23, 90.00, 1, NULL, 0, '2025-07-20 23:44:28', '2025-07-20 23:44:28'),
(33, 1, 24, 90.00, 3, NULL, 0, '2025-07-20 23:48:13', '2025-07-20 23:48:13'),
(34, 2, 24, 449.00, 4, NULL, 0, '2025-07-20 23:48:13', '2025-07-20 23:48:13'),
(35, 3, 25, 1099.00, 2, NULL, 0, '2025-07-21 00:02:27', '2025-07-21 00:02:27'),
(36, 2, 25, 449.00, 3, NULL, 0, '2025-07-21 00:02:27', '2025-07-21 00:02:27'),
(37, 1, 26, 90.00, 1, NULL, 0, '2025-07-21 00:08:08', '2025-07-21 00:08:08'),
(38, 2, 26, 449.00, 2, NULL, 0, '2025-07-21 00:08:08', '2025-07-21 00:08:08'),
(39, 3, 26, 1099.00, 3, NULL, 0, '2025-07-21 00:08:08', '2025-07-21 00:08:08'),
(40, 5, 26, 13999.00, 4, NULL, 0, '2025-07-21 00:08:08', '2025-07-21 00:08:08'),
(41, 1, 27, 90.00, 1, NULL, 0, '2025-07-21 00:10:59', '2025-07-21 00:10:59'),
(42, 1, 28, 90.00, 1, NULL, 0, '2025-07-21 00:19:37', '2025-07-21 00:19:37'),
(43, 1, 29, 90.00, 1, NULL, 0, '2025-07-21 00:24:20', '2025-07-21 00:24:20'),
(44, 1, 30, 90.00, 1, NULL, 0, '2025-07-21 00:48:37', '2025-07-21 00:48:37'),
(45, 1, 31, 90.00, 1, NULL, 0, '2025-07-21 00:49:32', '2025-07-21 00:49:32');

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `category_id` bigint(20) UNSIGNED NOT NULL,
  `brand_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `short_description` text DEFAULT NULL,
  `description` text DEFAULT NULL,
  `quantity` int(11) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `sale_price` decimal(10,2) DEFAULT NULL,
  `SKU` varchar(255) DEFAULT NULL,
  `stock_status` enum('in_stock','out_of_stock') NOT NULL,
  `featured` tinyint(1) NOT NULL DEFAULT 0,
  `size` int(11) NOT NULL,
  `image` varchar(255) NOT NULL,
  `gallery` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`gallery`)),
  `status` enum('Active','Inactive') NOT NULL DEFAULT 'Active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `category_id`, `brand_id`, `name`, `slug`, `short_description`, `description`, `quantity`, `price`, `sale_price`, `SKU`, `stock_status`, `featured`, `size`, `image`, `gallery`, `status`, `created_at`, `updated_at`) VALUES
(1, 2, 9, 'product', 'product', NULL, NULL, 1, 120.00, 90.00, 'SKT1001', 'in_stock', 1, 1, '1751725752.product_0.jpg', '[\"1751725752_686936b85357c.jpg\"]', 'Active', '2025-07-05 08:59:12', '2025-07-05 08:59:12'),
(2, 3, 6, 'product-2', 'product-2', NULL, NULL, 5, 500.00, 449.00, 'SKT1002', 'in_stock', 0, 2, '1751725832.product_1.jpg', '[\"1751725832_68693708e8e7e.jpg\"]', 'Active', '2025-07-05 09:00:32', '2025-07-05 09:00:32'),
(3, 2, 9, 'prod-3', 'prod-3', NULL, NULL, 100, 1199.00, 1099.00, 'SKT1003', 'in_stock', 0, 3, '1751725904.product_2.jpg', '[\"1751725904_686937508a727.jpg\"]', 'Active', '2025-07-05 09:01:44', '2025-07-12 03:42:28'),
(5, 5, 10, 'product-4', 'product-4', NULL, NULL, 10, 15000.00, 13999.00, NULL, 'in_stock', 1, 4, '1753082785.jpg', '[]', 'Active', '2025-07-12 04:00:30', '2025-07-21 01:56:25'),
(6, 6, 6, 'product-5', 'product-5', NULL, NULL, 10, 150.00, NULL, NULL, 'in_stock', 0, 5, '1753082852.product-6.jpg', '[]', 'Active', '2025-07-21 01:57:32', '2025-07-21 01:58:50'),
(7, 7, 10, 'product-6', 'product-6', NULL, NULL, 12, 120.00, NULL, NULL, 'in_stock', 1, 6, '1753082899.product-7.jpg', '[]', 'Active', '2025-07-21 01:58:19', '2025-07-21 01:59:11'),
(8, 8, 11, 'product-7', 'product-7', NULL, NULL, 12, 188.50, NULL, NULL, 'in_stock', 0, 2, '1753083016.product-0-1.jpg', '[\"1753083016_687dec88707bb.jpg\"]', 'Active', '2025-07-21 02:00:16', '2025-07-21 02:00:16'),
(9, 9, 9, 'product-8', 'product-8', NULL, NULL, 150, 22.55, NULL, NULL, 'in_stock', 1, 4, '1753083061.product-8.jpg', '[]', 'Active', '2025-07-21 02:01:01', '2025-07-21 02:01:01'),
(10, 10, 12, 'product-9', 'product-9', NULL, NULL, 2000, 10.00, 0.00, NULL, 'in_stock', 0, 3, '1753083152.product-9.jpg', '[]', 'Active', '2025-07-21 02:02:32', '2025-07-21 02:02:32'),
(11, 11, 8, 'product-10', 'product-10', NULL, NULL, 55, 1000.00, NULL, NULL, 'in_stock', 1, 3, '1753083203.product-10.jpg', '[]', 'Active', '2025-07-21 02:03:23', '2025-07-21 08:08:47');

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('YdhFKBuYALMXkPZ4oBx4fbgBVkfPmFCtI82yq4Tu', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/109.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiamdIbzlsUDhBbVBjUzFmaHlpZnBFVFZDSllweXRMc1UyUXJ5b1R4UCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzY6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9zaG9wL3Byb2R1Y3QtOCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6NDoiY2FydCI7YToxOntzOjQ6ImNhcnQiO086Mjk6IklsbHVtaW5hdGVcU3VwcG9ydFxDb2xsZWN0aW9uIjoyOntzOjg6IgAqAGl0ZW1zIjthOjE6e3M6MzI6IjgwODgyMTg1MjA0MmQ4NzgwYjlmODYyYzM1YzQyYzY4IjtPOjM1OiJTdXJmc2lkZW1lZGlhXFNob3BwaW5nY2FydFxDYXJ0SXRlbSI6OTp7czo1OiJyb3dJZCI7czozMjoiODA4ODIxODUyMDQyZDg3ODBiOWY4NjJjMzVjNDJjNjgiO3M6MjoiaWQiO3M6MToiNyI7czozOiJxdHkiO3M6MToiMSI7czo0OiJuYW1lIjtzOjk6InByb2R1Y3QtNiI7czo1OiJwcmljZSI7ZDoxMjA7czo3OiJvcHRpb25zIjtPOjQyOiJTdXJmc2lkZW1lZGlhXFNob3BwaW5nY2FydFxDYXJ0SXRlbU9wdGlvbnMiOjI6e3M6ODoiACoAaXRlbXMiO2E6MDp7fXM6Mjg6IgAqAGVzY2FwZVdoZW5DYXN0aW5nVG9TdHJpbmciO2I6MDt9czo1MjoiAFN1cmZzaWRlbWVkaWFcU2hvcHBpbmdjYXJ0XENhcnRJdGVtAGFzc29jaWF0ZWRNb2RlbCI7czoxODoiQXBwXE1vZGVsc1xQcm9kdWN0IjtzOjQ0OiIAU3VyZnNpZGVtZWRpYVxTaG9wcGluZ2NhcnRcQ2FydEl0ZW0AdGF4UmF0ZSI7aToyMTtzOjQ0OiIAU3VyZnNpZGVtZWRpYVxTaG9wcGluZ2NhcnRcQ2FydEl0ZW0AaXNTYXZlZCI7YjowO319czoyODoiACoAZXNjYXBlV2hlbkNhc3RpbmdUb1N0cmluZyI7YjowO319fQ==', 1753107918),
('yLrulgPIjARN8wqhSrdHCHfOyz1dkbO5pnht645S', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/109.0.0.0 Safari/537.36', 'YTo1OntzOjY6Il90b2tlbiI7czo0MDoidHhtSkwzVU14MUxCNGplRGdxYk10ZzQ4ZVhTTjBDMVYwUnJBYWdmWSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzY6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9wcm9kdWN0L2VkaXQvMSI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6NDoiY2FydCI7YToxOntzOjQ6ImNhcnQiO086Mjk6IklsbHVtaW5hdGVcU3VwcG9ydFxDb2xsZWN0aW9uIjoyOntzOjg6IgAqAGl0ZW1zIjthOjE6e3M6MzI6IjM3MGQwODU4NTM2MGY1YzU2OGIxOGQxZjJlNGNhMWRmIjtPOjM1OiJTdXJmc2lkZW1lZGlhXFNob3BwaW5nY2FydFxDYXJ0SXRlbSI6OTp7czo1OiJyb3dJZCI7czozMjoiMzcwZDA4NTg1MzYwZjVjNTY4YjE4ZDFmMmU0Y2ExZGYiO3M6MjoiaWQiO3M6MToiMiI7czozOiJxdHkiO3M6MToiMSI7czo0OiJuYW1lIjtzOjk6InByb2R1Y3QtMiI7czo1OiJwcmljZSI7ZDo0NDk7czo3OiJvcHRpb25zIjtPOjQyOiJTdXJmc2lkZW1lZGlhXFNob3BwaW5nY2FydFxDYXJ0SXRlbU9wdGlvbnMiOjI6e3M6ODoiACoAaXRlbXMiO2E6MDp7fXM6Mjg6IgAqAGVzY2FwZVdoZW5DYXN0aW5nVG9TdHJpbmciO2I6MDt9czo1MjoiAFN1cmZzaWRlbWVkaWFcU2hvcHBpbmdjYXJ0XENhcnRJdGVtAGFzc29jaWF0ZWRNb2RlbCI7czoxODoiQXBwXE1vZGVsc1xQcm9kdWN0IjtzOjQ0OiIAU3VyZnNpZGVtZWRpYVxTaG9wcGluZ2NhcnRcQ2FydEl0ZW0AdGF4UmF0ZSI7aToyMTtzOjQ0OiIAU3VyZnNpZGVtZWRpYVxTaG9wcGluZ2NhcnRcQ2FydEl0ZW0AaXNTYXZlZCI7YjowO319czoyODoiACoAZXNjYXBlV2hlbkNhc3RpbmdUb1N0cmluZyI7YjowO319czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6MTt9', 1753105400);

-- --------------------------------------------------------

--
-- Table structure for table `sizes`
--

CREATE TABLE `sizes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sizes`
--

INSERT INTO `sizes` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'XS', '2025-07-21 08:07:07', '2025-07-21 08:07:07'),
(2, 'S', '2025-07-21 08:07:32', '2025-07-21 08:07:32'),
(3, 'M', '2025-07-21 08:07:41', '2025-07-21 08:07:41'),
(4, 'L', '2025-07-21 08:07:50', '2025-07-21 08:07:50'),
(5, 'XL', '2025-07-21 08:08:10', '2025-07-21 08:08:10'),
(6, 'XXL', '2025-07-21 08:08:23', '2025-07-21 08:08:23');

-- --------------------------------------------------------

--
-- Table structure for table `slides`
--

CREATE TABLE `slides` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tagline` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `subtitle` varchar(255) NOT NULL,
  `link` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  `status` enum('Active','Inactive') NOT NULL DEFAULT 'Active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `slides`
--

INSERT INTO `slides` (`id`, `tagline`, `title`, `subtitle`, `link`, `image`, `status`, `created_at`, `updated_at`) VALUES
(1, 'test', 'test', 'test', 'http://127.0.0.1:8000/shop', '1752848280.png', 'Active', '2025-07-18 08:33:15', '2025-07-18 08:48:00'),
(2, 'test2', 'test2', 'test2', 'http://127.0.0.1:8000/shop', '1752848298.png', 'Active', '2025-07-18 08:33:53', '2025-07-18 08:48:18');

-- --------------------------------------------------------

--
-- Table structure for table `transactions`
--

CREATE TABLE `transactions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `transaction_id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `order_id` bigint(20) UNSIGNED NOT NULL,
  `mode` enum('cod','card','paypal') NOT NULL,
  `status` enum('pending','approved','declined','refunded') NOT NULL DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `transactions`
--

INSERT INTO `transactions` (`id`, `transaction_id`, `user_id`, `order_id`, `mode`, `status`, `created_at`, `updated_at`) VALUES
(5, '221579227678', 1, 6, 'cod', 'pending', '2025-07-18 04:52:16', '2025-07-18 04:52:16'),
(10, '370287915798', 2, 12, 'cod', 'pending', '2025-07-18 23:33:16', '2025-07-18 23:33:16'),
(11, '105494418291', 2, 13, 'cod', 'pending', '2025-07-18 23:38:37', '2025-07-18 23:38:37'),
(12, '338327925555', 4, 14, 'cod', 'pending', '2025-07-19 06:53:13', '2025-07-19 06:53:13'),
(13, '117333988747', 4, 17, 'cod', 'pending', '2025-07-19 07:03:28', '2025-07-19 07:03:28'),
(14, '625719660896', 3, 18, 'cod', 'pending', '2025-07-19 07:08:28', '2025-07-19 07:08:28'),
(15, '896277629031', 3, 19, 'cod', 'pending', '2025-07-19 07:09:17', '2025-07-19 07:09:17'),
(16, '221308801827', 3, 20, 'cod', 'pending', '2025-07-20 23:37:33', '2025-07-20 23:37:33'),
(17, '674998766486', 3, 21, 'cod', 'pending', '2025-07-20 23:40:42', '2025-07-20 23:40:42'),
(18, '340956438814', 3, 22, 'cod', 'pending', '2025-07-20 23:43:15', '2025-07-20 23:43:15'),
(19, '280092564364', 3, 23, 'cod', 'pending', '2025-07-20 23:44:28', '2025-07-20 23:44:28'),
(20, '863116874564', 3, 24, 'cod', 'pending', '2025-07-20 23:48:13', '2025-07-20 23:48:13'),
(21, '946055756292', 3, 25, 'cod', 'pending', '2025-07-21 00:02:27', '2025-07-21 00:02:27'),
(22, '508981977469', 3, 26, 'cod', 'pending', '2025-07-21 00:08:08', '2025-07-21 00:08:08'),
(23, '781960394673', 3, 27, 'cod', 'pending', '2025-07-21 00:10:59', '2025-07-21 00:10:59'),
(24, '765372498604', 3, 28, 'cod', 'pending', '2025-07-21 00:19:37', '2025-07-21 00:19:37'),
(25, '923696558009', 3, 29, 'cod', 'pending', '2025-07-21 00:24:20', '2025-07-21 00:24:20'),
(26, '325944167964', 3, 30, 'cod', 'pending', '2025-07-21 00:48:37', '2025-07-21 00:48:37'),
(27, '860015972787', 3, 31, 'cod', 'pending', '2025-07-21 00:49:32', '2025-07-21 00:49:32');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `mobile` varchar(255) DEFAULT NULL,
  `role` enum('admin','user') NOT NULL DEFAULT 'user',
  `image` text DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `mobile`, `role`, `image`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Bharat Prajapati', 'jb.prajapati079@gmail.com', '9824115971', 'admin', '1752921109.jpg', '$2y$12$EVOuUvCvm/QlOUZgOTZEneEFrW79HW3mRofNlA1uhoD8nktVGOrv6', '1Fadtrofe26gg9pv5CtWJNkDjtvHhvREsX0tPIB16ZyepHXHsBzzjlAcnAQD', '2025-07-04 01:07:48', '2025-07-20 23:14:15'),
(2, 'bharat', 'bharat@gmail.com', NULL, 'user', '', '$2y$12$81hTKKvf.hm2HDWic8Y.XO2dBVlDVMn.TupK23POdh6WfamjOl0PS', '4KY8vxiuxEmo7JjhvJ4IpKhcZT7A9zaMX5greU3JmPaNBucMsOEIWpxr5PiS', '2025-07-04 02:16:22', '2025-07-20 23:09:02'),
(3, 'vijay patel', 'vijay@gmail.com', NULL, 'user', NULL, '$2y$12$ODPULFzhhU28bO86AGD8uO40Xk/lCR.y8p6zmyaCR0dzWGoCfRpjW', 'CicJIc5rgoW8RuwtW0SROz3TqIQdoaH0UxVufREydvySmCFt6PfMhPe6H7IT', '2025-07-19 05:31:15', '2025-07-20 23:20:44'),
(4, 'sachin', 'sachin@gmail.com', NULL, 'user', NULL, '$2y$12$dFTimmrLZbO83WIzDmNj1.NEkU01cpnzfmvb.5nxvEE5ifHlyDA1q', NULL, '2025-07-19 05:49:49', '2025-07-19 05:49:49');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `addresses`
--
ALTER TABLE `addresses`
  ADD PRIMARY KEY (`id`),
  ADD KEY `addresses_user_id_foreign` (`user_id`);

--
-- Indexes for table `brands`
--
ALTER TABLE `brands`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `brands_slug_unique` (`slug`);

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `categories_slug_unique` (`slug`);

--
-- Indexes for table `contacts`
--
ALTER TABLE `contacts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `contacts_user_id_foreign` (`user_id`);

--
-- Indexes for table `coupons`
--
ALTER TABLE `coupons`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indexes for table `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `orders_user_id_foreign` (`user_id`),
  ADD KEY `orders_status_index` (`status`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_items_product_id_foreign` (`product_id`),
  ADD KEY `order_items_order_id_foreign` (`order_id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `products_slug_unique` (`slug`),
  ADD UNIQUE KEY `products_sku_unique` (`SKU`),
  ADD KEY `products_category_id_foreign` (`category_id`),
  ADD KEY `products_brand_id_foreign` (`brand_id`),
  ADD KEY `products_featured_index` (`featured`),
  ADD KEY `products_status_index` (`status`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `sizes`
--
ALTER TABLE `sizes`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `sizes_name_unique` (`name`);

--
-- Indexes for table `slides`
--
ALTER TABLE `slides`
  ADD PRIMARY KEY (`id`),
  ADD KEY `slides_status_index` (`status`);

--
-- Indexes for table `transactions`
--
ALTER TABLE `transactions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `transactions_user_id_foreign` (`user_id`),
  ADD KEY `transactions_order_id_foreign` (`order_id`),
  ADD KEY `transactions_status_index` (`status`);

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
-- AUTO_INCREMENT for table `addresses`
--
ALTER TABLE `addresses`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `brands`
--
ALTER TABLE `brands`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `contacts`
--
ALTER TABLE `contacts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `coupons`
--
ALTER TABLE `coupons`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `sizes`
--
ALTER TABLE `sizes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `slides`
--
ALTER TABLE `slides`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `transactions`
--
ALTER TABLE `transactions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `addresses`
--
ALTER TABLE `addresses`
  ADD CONSTRAINT `addresses_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `contacts`
--
ALTER TABLE `contacts`
  ADD CONSTRAINT `contacts_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `order_items_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_brand_id_foreign` FOREIGN KEY (`brand_id`) REFERENCES `brands` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `products_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `transactions`
--
ALTER TABLE `transactions`
  ADD CONSTRAINT `transactions_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `transactions_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
