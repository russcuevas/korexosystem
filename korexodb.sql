-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 23, 2026 at 04:38 PM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `korexodb`
--

-- --------------------------------------------------------

--
-- Table structure for table `carts`
--

CREATE TABLE `carts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `reference_number` varchar(255) NOT NULL,
  `menu_id` bigint(20) UNSIGNED NOT NULL,
  `is_rice_menu` bigint(20) UNSIGNED DEFAULT NULL,
  `is_add_ons_menu` bigint(20) UNSIGNED DEFAULT NULL,
  `size` varchar(255) DEFAULT NULL,
  `quantity` int(11) NOT NULL DEFAULT 1,
  `price` decimal(8,2) NOT NULL DEFAULT 0.00,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `category_pic` varchar(255) DEFAULT NULL,
  `category_name` varchar(255) NOT NULL,
  `is_rice_menu` tinyint(1) NOT NULL DEFAULT 0,
  `is_add_ons_menu` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `category_pic`, `category_name`, `is_rice_menu`, `is_add_ons_menu`, `created_at`, `updated_at`) VALUES
(1, 'deviled-eggs.gif', 'Appetizers', 0, 0, '2026-02-23 15:36:59', '2026-02-23 15:36:59'),
(2, 'soup.gif', 'Soup', 0, 0, '2026-02-23 15:36:59', '2026-02-23 15:36:59'),
(3, 'healthy-meal.gif', 'Main', 0, 0, '2026-02-23 15:36:59', '2026-02-23 15:36:59'),
(4, 'corn.gif', 'Sides', 0, 0, '2026-02-23 15:36:59', '2026-02-23 15:36:59'),
(5, 'pancake.gif', 'Dessert', 0, 0, '2026-02-23 15:36:59', '2026-02-23 15:36:59'),
(6, NULL, 'Rice', 1, 0, '2026-02-23 15:36:59', '2026-02-23 15:36:59'),
(7, NULL, 'Drinks', 0, 1, '2026-02-23 15:36:59', '2026-02-23 15:36:59');

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
-- Table structure for table `menus`
--

CREATE TABLE `menus` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `category_id` bigint(20) UNSIGNED NOT NULL,
  `menu_pic` varchar(255) DEFAULT NULL,
  `menu_name` varchar(255) NOT NULL,
  `menu_price` decimal(8,2) NOT NULL,
  `ingredients` text DEFAULT NULL,
  `stock_number` int(11) NOT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'available',
  `is_rice_menu` tinyint(1) NOT NULL DEFAULT 0,
  `is_add_ons_menu` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `menus`
--

INSERT INTO `menus` (`id`, `category_id`, `menu_pic`, `menu_name`, `menu_price`, `ingredients`, `stock_number`, `status`, `is_rice_menu`, `is_add_ons_menu`, `created_at`, `updated_at`) VALUES
(1, 1, 'que.png', 'Kimchi Chicken Quezadilla', '0.00', '\n                    <h6><i>2 servings</i></h6>\n                    <ul>\n                        <li>Kimchi - ½ cup</li>\n                        <li>Chicken Breast - 1 small size</li>\n                        <li>Pita Wrap - 2 pcs.</li>\n                        <li>Gochujang - 2 tbsp</li>\n                        <li>Cheese - 100/50 grams</li>\n                        <li>Cayenne Pepper - 2 tsp</li>\n                        <li>Garlic Powder - 2 tsp</li>\n                        <li>Honey - 2 tsp</li>\n                        <li>Oil - 1 tbsp</li>\n                        <li>Salt and pepper to taste</li>\n                    </ul>\n                ', 250, 'available', 0, 0, '2026-02-23 15:36:59', '2026-02-23 15:36:59'),
(2, 1, 'cajun.png', 'Cajun Corn Elote', '0.00', '\n                    <h6><i>3 servings</i></h6>\n                    <ul>\n                        <li>Sweet Corn - 1 large size</li>\n                        <li>Mayonnaise - ¼ cup</li>\n                        <li>Parmesan Cheese - 2 tbsp</li>\n                        <li>Chili Powder - 1 tsp</li>\n                        <li>Cajun Powder - 1 tbsp</li>\n                        <li>Cilantro - 1 tsp</li>\n                    </ul>\n                ', 250, 'available', 0, 0, '2026-02-23 15:36:59', '2026-02-23 15:36:59'),
(3, 2, 'tofu-stew.png', 'Tofu Stew', '0.00', '\n        <h6><i>10-15 Servings</i></h6>\n        <ul>\n            <li>Firm Korean Tofu - 1 pack</li>\n            <li>Thin Sliced Pork Belly - ½ kg</li>\n            <li>Chili powder - 2 tbsp</li>\n            <li>Shrimp Paste - 4 tbsp</li>\n            <li>Kimchi - 1 cup</li>\n            <li>Scallions - 3 haba</li>\n            <li>Shitake - 1 pack</li>\n            <li>Enoki - 1 pack</li>\n            <li>Egg - 2 xl</li>\n            <li>Garlic - 1 bulb</li>\n            <li>Sesame Oil - 4 tbsp</li>\n            <li>Salt and pepper to taste</li>\n        </ul>\n    ', 250, 'available', 0, 0, '2026-02-23 15:36:59', '2026-02-23 15:36:59'),
(4, 2, 'chicken-torilla.png', 'Chicken Tortilla Soup', '0.00', '\n                    <h6><i>8 - 10 Servings</i></h6>\n                    <ul>\n                        <li>Carrots - 2 medium size</li>\n                        <li>Celery stalks - 2 pcs</li>\n                        <li>Tomato - 4 medium size</li>\n                        <li>Chicken w/ bones - 1 kg</li>\n                        <li>Corn Kernels - 2 cups</li>\n                        <li>Black Beans - 2 cups</li>\n                        <li>Cumin - 1 tsp</li>\n                        <li>Paprika - 1 tsp</li>\n                        <li>Cilantro - 2 pcs</li>\n                        <li>Green bell pepper - 1 pc</li>\n                        <li>Bay Leaves - 2 pcs</li>\n                        <li>Onion - 1 medium size</li>\n                        <li>Garlic - bulb</li>\n                        <li>Oil - 3 tbsp</li>\n                        <li>Pita wrap - 5 pcs.</li>\n                        <li>Salt and pepper to taste</li>\n                    </ul>\n                ', 250, 'available', 0, 0, '2026-02-23 15:36:59', '2026-02-23 15:36:59'),
(5, 3, NULL, 'Salsa Strips', '0.00', '\n        <h6><i>3 Servings</i></h6>\n        <ul>\n            <li>Beef - 450g</li>\n            <li>Tomato - 4 pcs</li>\n            <li>Onion - 3 pcs</li>\n            <li>Cilantro - 3 pcs</li>\n            <li>Calamansi - 5 pcs</li>\n            <li>Oil - 3 tbsp</li>\n            <li>Salt and Pepper - to taste</li>\n        </ul>\n    ', 250, 'available', 0, 0, '2026-02-23 15:36:59', '2026-02-23 15:36:59'),
(6, 3, NULL, 'Bulgogi Strips', '0.00', '\n        <h6><i>3 Servings</i></h6>\n        <ul>\n            <li>Beef - 450g</li>\n            <li>Gochujang - 3 tbsp</li>\n            <li>Soy Sauce - 2 tbsp</li>\n            <li>Honey - 1 tbsp</li>\n            <li>Sesame Oil - 1 tbsp</li>\n            <li>Garlic - 4 cloves</li>\n            <li>Onion - 1 medium size</li>\n            <li>Salt and Pepper - to taste</li>\n        </ul>\n    ', 250, 'available', 0, 0, '2026-02-23 15:36:59', '2026-02-23 15:36:59'),
(7, 4, 'marble.png', 'Potato Marble', '0.00', NULL, 250, 'available', 0, 0, '2026-02-23 15:36:59', '2026-02-23 15:36:59'),
(8, 5, 'dessert.png', 'Watermelon Bingsu with Cheesecake', '0.00', '\n        <h6><i>2–3 Servings (Bingsu)</i></h6>\n        <ul>\n            <li>Fresh Milk (Emborg) - 1 Liter</li>\n            <li>Condensed Milk (Cowbell) - ½ can</li>\n            <li>Watermelon - ½ kg</li>\n            <li>Watermelon Syrup (ZNW) - 1 tsp</li>\n        </ul>\n\n        <h6><i>10–12 Servings (Cheesecake)</i></h6>\n        <ul>\n            <li>Crushed Graham - ¾ cup</li>\n            <li>Butter - 4 tbsp</li>\n            <li>Cream Cheese - 1 block</li>\n            <li>All Purpose Cream - ½ cup</li>\n            <li>Vanilla (McCormick) - ½ tsp</li>\n            <li>Powdered Sugar - 6 tbsp</li>\n            <li>Gelatin (Knox) - ½ sachet</li>\n            <li>Salt - ½ tsp</li>\n        </ul>\n    ', 250, 'available', 0, 0, '2026-02-23 15:36:59', '2026-02-23 15:36:59'),
(9, 6, NULL, 'Plain Rice', '0.00', NULL, 250, 'available', 1, 0, '2026-02-23 15:36:59', '2026-02-23 15:36:59'),
(10, 6, NULL, 'Kimchi Fried Rice', '0.00', '\n        <h6><i>3 Servings</i></h6>\n        <ul>\n            <li>Kimchi - 1 cup</li>\n            <li>Egg - 2 XL</li>\n            <li>Butter - 1 tbsp</li>\n            <li>Soy Sauce - 1 tbsp</li>\n            <li>Sesame Oil - 1 tbsp</li>\n            <li>Garlic - 5 cloves</li>\n            <li>Rice - 3 cups</li>\n            <li>Sesame Seeds - for toppings</li>\n            <li>Salt - to taste</li>\n        </ul>\n    ', 250, 'available', 1, 0, '2026-02-23 15:36:59', '2026-02-23 15:36:59'),
(11, 6, NULL, 'Mexican Rice', '0.00', '\n        <h6><i>3 Servings</i></h6>\n        <ul>\n            <li>Chorizo - ½ cup</li>\n            <li>Red Bell Pepper - ½ cup</li>\n            <li>Kernel Corn - ½ cup</li>\n            <li>Beef Cube - 1 ½ tsp</li>\n            <li>Chili Powder - 1 tsp</li>\n            <li>Cumin - ½ tsp</li>\n            <li>Cilantro - 2 tbsp</li>\n            <li>Garlic - 5 cloves</li>\n            <li>Calamansi - drizzle</li>\n            <li>Salt and Pepper - to taste</li>\n            <li>Oil - 3 tbsp</li>\n        </ul>\n    ', 250, 'available', 1, 0, '2026-02-23 15:36:59', '2026-02-23 15:36:59'),
(12, 7, 'ice-tea.png', 'Koretea [Juice]', '0.00', NULL, 250, 'available', 0, 1, '2026-02-23 15:36:59', '2026-02-23 15:36:59'),
(13, 7, 'spa.png', 'Spanish Latte', '0.00', NULL, 250, 'available', 0, 1, '2026-02-23 15:36:59', '2026-02-23 15:36:59'),
(14, 7, 'ame.png', 'Americano', '0.00', NULL, 250, 'available', 0, 1, '2026-02-23 15:36:59', '2026-02-23 15:36:59'),
(15, 7, 'capu.png', 'Cappuccino', '0.00', NULL, 250, 'available', 0, 1, '2026-02-23 15:36:59', '2026-02-23 15:36:59');

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
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_reset_tokens_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(5, '2026_02_12_132640_create_tickets_table', 1),
(6, '2026_02_12_221535_create_categories_table', 1),
(7, '2026_02_14_230905_create_menus_table', 1),
(8, '2026_02_15_222340_create_carts_table', 1),
(9, '2026_02_16_222605_create_orders_table', 1),
(10, '2026_02_17_155928_create_reservations_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `reference_number` varchar(255) NOT NULL,
  `menu_id` bigint(20) UNSIGNED NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `fullname` varchar(255) DEFAULT NULL,
  `is_rice_menu` bigint(20) UNSIGNED DEFAULT NULL,
  `is_add_ons_menu` bigint(20) UNSIGNED DEFAULT NULL,
  `size` varchar(255) DEFAULT NULL,
  `is_served` tinyint(1) NOT NULL DEFAULT 0,
  `quantity` int(11) NOT NULL DEFAULT 1,
  `price` decimal(8,2) NOT NULL DEFAULT 0.00,
  `status` varchar(255) NOT NULL DEFAULT 'Placed order',
  `reserved_at` datetime DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `reservations`
--

CREATE TABLE `reservations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `time_slot` varchar(255) NOT NULL,
  `available_slots` int(11) NOT NULL DEFAULT 20,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `reservations`
--

INSERT INTO `reservations` (`id`, `time_slot`, `available_slots`, `created_at`, `updated_at`) VALUES
(1, '10:00 AM', 45, '2026-02-23 15:36:59', '2026-02-23 15:36:59'),
(2, '11:00 AM', 45, '2026-02-23 15:36:59', '2026-02-23 15:36:59'),
(3, '12:00 PM', 45, '2026-02-23 15:36:59', '2026-02-23 15:36:59'),
(4, '1:00 PM', 45, '2026-02-23 15:36:59', '2026-02-23 15:36:59'),
(5, '2:00PM', 45, '2026-02-23 15:36:59', '2026-02-23 15:36:59');

-- --------------------------------------------------------

--
-- Table structure for table `tickets`
--

CREATE TABLE `tickets` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `reference_number` varchar(255) NOT NULL,
  `is_used` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tickets`
--

INSERT INTO `tickets` (`id`, `reference_number`, `is_used`, `created_at`, `updated_at`) VALUES
(1, '100482', 0, '2026-02-23 15:36:58', '2026-02-23 15:36:58'),
(2, '100739', 0, '2026-02-23 15:36:58', '2026-02-23 15:36:58'),
(3, '101256', 0, '2026-02-23 15:36:58', '2026-02-23 15:36:58'),
(4, '101894', 0, '2026-02-23 15:36:58', '2026-02-23 15:36:58'),
(5, '102367', 0, '2026-02-23 15:36:58', '2026-02-23 15:36:58'),
(6, '102945', 0, '2026-02-23 15:36:58', '2026-02-23 15:36:58'),
(7, '103128', 0, '2026-02-23 15:36:58', '2026-02-23 15:36:58'),
(8, '103764', 0, '2026-02-23 15:36:58', '2026-02-23 15:36:58'),
(9, '104209', 0, '2026-02-23 15:36:58', '2026-02-23 15:36:58'),
(10, '104857', 0, '2026-02-23 15:36:58', '2026-02-23 15:36:58'),
(11, '105316', 0, '2026-02-23 15:36:58', '2026-02-23 15:36:58'),
(12, '105942', 0, '2026-02-23 15:36:58', '2026-02-23 15:36:58'),
(13, '106283', 0, '2026-02-23 15:36:58', '2026-02-23 15:36:58'),
(14, '106759', 0, '2026-02-23 15:36:58', '2026-02-23 15:36:58'),
(15, '107124', 0, '2026-02-23 15:36:58', '2026-02-23 15:36:58'),
(16, '107638', 0, '2026-02-23 15:36:58', '2026-02-23 15:36:58'),
(17, '108205', 0, '2026-02-23 15:36:58', '2026-02-23 15:36:58'),
(18, '108947', 0, '2026-02-23 15:36:58', '2026-02-23 15:36:58'),
(19, '109316', 0, '2026-02-23 15:36:58', '2026-02-23 15:36:58'),
(20, '109852', 0, '2026-02-23 15:36:58', '2026-02-23 15:36:58'),
(21, '110274', 0, '2026-02-23 15:36:58', '2026-02-23 15:36:58'),
(22, '110893', 0, '2026-02-23 15:36:58', '2026-02-23 15:36:58'),
(23, '111560', 0, '2026-02-23 15:36:58', '2026-02-23 15:36:58'),
(24, '112348', 0, '2026-02-23 15:36:58', '2026-02-23 15:36:58'),
(25, '113027', 0, '2026-02-23 15:36:58', '2026-02-23 15:36:58'),
(26, '113694', 0, '2026-02-23 15:36:58', '2026-02-23 15:36:58'),
(27, '114205', 0, '2026-02-23 15:36:58', '2026-02-23 15:36:58'),
(28, '114879', 0, '2026-02-23 15:36:58', '2026-02-23 15:36:58'),
(29, '115326', 0, '2026-02-23 15:36:58', '2026-02-23 15:36:58'),
(30, '115940', 0, '2026-02-23 15:36:58', '2026-02-23 15:36:58'),
(31, '116283', 0, '2026-02-23 15:36:58', '2026-02-23 15:36:58'),
(32, '116759', 0, '2026-02-23 15:36:58', '2026-02-23 15:36:58'),
(33, '117402', 0, '2026-02-23 15:36:58', '2026-02-23 15:36:58'),
(34, '117985', 0, '2026-02-23 15:36:58', '2026-02-23 15:36:58'),
(35, '118346', 0, '2026-02-23 15:36:58', '2026-02-23 15:36:58'),
(36, '118902', 0, '2026-02-23 15:36:58', '2026-02-23 15:36:58'),
(37, '119478', 0, '2026-02-23 15:36:58', '2026-02-23 15:36:58'),
(38, '120365', 0, '2026-02-23 15:36:58', '2026-02-23 15:36:58'),
(39, '120947', 0, '2026-02-23 15:36:58', '2026-02-23 15:36:58'),
(40, '121583', 0, '2026-02-23 15:36:58', '2026-02-23 15:36:58'),
(41, '122046', 0, '2026-02-23 15:36:58', '2026-02-23 15:36:58'),
(42, '122739', 0, '2026-02-23 15:36:58', '2026-02-23 15:36:58'),
(43, '123508', 0, '2026-02-23 15:36:58', '2026-02-23 15:36:58'),
(44, '124176', 0, '2026-02-23 15:36:58', '2026-02-23 15:36:58'),
(45, '124895', 0, '2026-02-23 15:36:58', '2026-02-23 15:36:58'),
(46, '125364', 0, '2026-02-23 15:36:58', '2026-02-23 15:36:58'),
(47, '125907', 0, '2026-02-23 15:36:58', '2026-02-23 15:36:58'),
(48, '126438', 0, '2026-02-23 15:36:58', '2026-02-23 15:36:58'),
(49, '126975', 0, '2026-02-23 15:36:58', '2026-02-23 15:36:58'),
(50, '127504', 0, '2026-02-23 15:36:58', '2026-02-23 15:36:58'),
(51, '128163', 0, '2026-02-23 15:36:58', '2026-02-23 15:36:58'),
(52, '128749', 0, '2026-02-23 15:36:58', '2026-02-23 15:36:58'),
(53, '129305', 0, '2026-02-23 15:36:58', '2026-02-23 15:36:58'),
(54, '129864', 0, '2026-02-23 15:36:58', '2026-02-23 15:36:58'),
(55, '130257', 0, '2026-02-23 15:36:58', '2026-02-23 15:36:58'),
(56, '130948', 0, '2026-02-23 15:36:58', '2026-02-23 15:36:58'),
(57, '131576', 0, '2026-02-23 15:36:58', '2026-02-23 15:36:58'),
(58, '132048', 0, '2026-02-23 15:36:58', '2026-02-23 15:36:58'),
(59, '132769', 0, '2026-02-23 15:36:58', '2026-02-23 15:36:58'),
(60, '133415', 0, '2026-02-23 15:36:58', '2026-02-23 15:36:58'),
(61, '134082', 0, '2026-02-23 15:36:58', '2026-02-23 15:36:58'),
(62, '134796', 0, '2026-02-23 15:36:58', '2026-02-23 15:36:58'),
(63, '135208', 0, '2026-02-23 15:36:58', '2026-02-23 15:36:58'),
(64, '135947', 0, '2026-02-23 15:36:58', '2026-02-23 15:36:58'),
(65, '136584', 0, '2026-02-23 15:36:58', '2026-02-23 15:36:58'),
(66, '137026', 0, '2026-02-23 15:36:58', '2026-02-23 15:36:58'),
(67, '137895', 0, '2026-02-23 15:36:58', '2026-02-23 15:36:58'),
(68, '138407', 0, '2026-02-23 15:36:58', '2026-02-23 15:36:58'),
(69, '138962', 0, '2026-02-23 15:36:58', '2026-02-23 15:36:58'),
(70, '139524', 0, '2026-02-23 15:36:58', '2026-02-23 15:36:58'),
(71, '140163', 0, '2026-02-23 15:36:58', '2026-02-23 15:36:58'),
(72, '140789', 0, '2026-02-23 15:36:58', '2026-02-23 15:36:58'),
(73, '141256', 0, '2026-02-23 15:36:58', '2026-02-23 15:36:58'),
(74, '141983', 0, '2026-02-23 15:36:58', '2026-02-23 15:36:58'),
(75, '142507', 0, '2026-02-23 15:36:58', '2026-02-23 15:36:58'),
(76, '143168', 0, '2026-02-23 15:36:58', '2026-02-23 15:36:58'),
(77, '143790', 0, '2026-02-23 15:36:58', '2026-02-23 15:36:58'),
(78, '144325', 0, '2026-02-23 15:36:58', '2026-02-23 15:36:58'),
(79, '144908', 0, '2026-02-23 15:36:58', '2026-02-23 15:36:58'),
(80, '145672', 0, '2026-02-23 15:36:58', '2026-02-23 15:36:58'),
(81, '146083', 0, '2026-02-23 15:36:58', '2026-02-23 15:36:58'),
(82, '146759', 0, '2026-02-23 15:36:58', '2026-02-23 15:36:58'),
(83, '147320', 0, '2026-02-23 15:36:58', '2026-02-23 15:36:58'),
(84, '147984', 0, '2026-02-23 15:36:58', '2026-02-23 15:36:58'),
(85, '148506', 0, '2026-02-23 15:36:58', '2026-02-23 15:36:58'),
(86, '149273', 0, '2026-02-23 15:36:58', '2026-02-23 15:36:58'),
(87, '149860', 0, '2026-02-23 15:36:58', '2026-02-23 15:36:58'),
(88, '150294', 0, '2026-02-23 15:36:58', '2026-02-23 15:36:58'),
(89, '150873', 0, '2026-02-23 15:36:58', '2026-02-23 15:36:58'),
(90, '151426', 0, '2026-02-23 15:36:58', '2026-02-23 15:36:58'),
(91, '152038', 0, '2026-02-23 15:36:58', '2026-02-23 15:36:58'),
(92, '152794', 0, '2026-02-23 15:36:58', '2026-02-23 15:36:58'),
(93, '153260', 0, '2026-02-23 15:36:58', '2026-02-23 15:36:58'),
(94, '153947', 0, '2026-02-23 15:36:58', '2026-02-23 15:36:58'),
(95, '154682', 0, '2026-02-23 15:36:58', '2026-02-23 15:36:58'),
(96, '155039', 0, '2026-02-23 15:36:58', '2026-02-23 15:36:58'),
(97, '155748', 0, '2026-02-23 15:36:58', '2026-02-23 15:36:58'),
(98, '156204', 0, '2026-02-23 15:36:58', '2026-02-23 15:36:58'),
(99, '156983', 0, '2026-02-23 15:36:58', '2026-02-23 15:36:58'),
(100, '157640', 0, '2026-02-23 15:36:58', '2026-02-23 15:36:58'),
(101, '158206', 0, '2026-02-23 15:36:58', '2026-02-23 15:36:58'),
(102, '158974', 0, '2026-02-23 15:36:58', '2026-02-23 15:36:58'),
(103, '159302', 0, '2026-02-23 15:36:58', '2026-02-23 15:36:58'),
(104, '159867', 0, '2026-02-23 15:36:58', '2026-02-23 15:36:58'),
(105, '160428', 0, '2026-02-23 15:36:58', '2026-02-23 15:36:58'),
(106, '160953', 0, '2026-02-23 15:36:58', '2026-02-23 15:36:58'),
(107, '161704', 0, '2026-02-23 15:36:58', '2026-02-23 15:36:58'),
(108, '162385', 0, '2026-02-23 15:36:58', '2026-02-23 15:36:58'),
(109, '162947', 0, '2026-02-23 15:36:58', '2026-02-23 15:36:58'),
(110, '163508', 0, '2026-02-23 15:36:58', '2026-02-23 15:36:58'),
(111, '164270', 0, '2026-02-23 15:36:58', '2026-02-23 15:36:58'),
(112, '164859', 0, '2026-02-23 15:36:58', '2026-02-23 15:36:58'),
(113, '165304', 0, '2026-02-23 15:36:58', '2026-02-23 15:36:58'),
(114, '165972', 0, '2026-02-23 15:36:58', '2026-02-23 15:36:58'),
(115, '166481', 0, '2026-02-23 15:36:58', '2026-02-23 15:36:58'),
(116, '167039', 0, '2026-02-23 15:36:58', '2026-02-23 15:36:58'),
(117, '167854', 0, '2026-02-23 15:36:58', '2026-02-23 15:36:58'),
(118, '168206', 0, '2026-02-23 15:36:58', '2026-02-23 15:36:58'),
(119, '168975', 0, '2026-02-23 15:36:58', '2026-02-23 15:36:58'),
(120, '169403', 0, '2026-02-23 15:36:58', '2026-02-23 15:36:58'),
(121, '170258', 0, '2026-02-23 15:36:58', '2026-02-23 15:36:58'),
(122, '170894', 0, '2026-02-23 15:36:58', '2026-02-23 15:36:58'),
(123, '171360', 0, '2026-02-23 15:36:58', '2026-02-23 15:36:58'),
(124, '171948', 0, '2026-02-23 15:36:58', '2026-02-23 15:36:58'),
(125, '172503', 0, '2026-02-23 15:36:58', '2026-02-23 15:36:58'),
(126, '173086', 0, '2026-02-23 15:36:58', '2026-02-23 15:36:58'),
(127, '173749', 0, '2026-02-23 15:36:58', '2026-02-23 15:36:58'),
(128, '174205', 0, '2026-02-23 15:36:58', '2026-02-23 15:36:58'),
(129, '174968', 0, '2026-02-23 15:36:58', '2026-02-23 15:36:58'),
(130, '175302', 0, '2026-02-23 15:36:58', '2026-02-23 15:36:58'),
(131, '176084', 0, '2026-02-23 15:36:58', '2026-02-23 15:36:58'),
(132, '176759', 0, '2026-02-23 15:36:58', '2026-02-23 15:36:58'),
(133, '177308', 0, '2026-02-23 15:36:58', '2026-02-23 15:36:58'),
(134, '177945', 0, '2026-02-23 15:36:58', '2026-02-23 15:36:58'),
(135, '178603', 0, '2026-02-23 15:36:58', '2026-02-23 15:36:58'),
(136, '179204', 0, '2026-02-23 15:36:58', '2026-02-23 15:36:58'),
(137, '179856', 0, '2026-02-23 15:36:58', '2026-02-23 15:36:58'),
(138, '180394', 0, '2026-02-23 15:36:58', '2026-02-23 15:36:58'),
(139, '180967', 0, '2026-02-23 15:36:58', '2026-02-23 15:36:58'),
(140, '181520', 0, '2026-02-23 15:36:58', '2026-02-23 15:36:58'),
(141, '181947', 0, '2026-02-23 15:36:58', '2026-02-23 15:36:58'),
(142, '182503', 0, '2026-02-23 15:36:58', '2026-02-23 15:36:58'),
(143, '182764', 0, '2026-02-23 15:36:58', '2026-02-23 15:36:58'),
(144, '183290', 0, '2026-02-23 15:36:58', '2026-02-23 15:36:58'),
(145, '183857', 0, '2026-02-23 15:36:58', '2026-02-23 15:36:58'),
(146, '184206', 0, '2026-02-23 15:36:58', '2026-02-23 15:36:58'),
(147, '184973', 0, '2026-02-23 15:36:58', '2026-02-23 15:36:58'),
(148, '185304', 0, '2026-02-23 15:36:58', '2026-02-23 15:36:58'),
(149, '185869', 0, '2026-02-23 15:36:58', '2026-02-23 15:36:58'),
(150, '186420', 0, '2026-02-23 15:36:58', '2026-02-23 15:36:58'),
(151, '186957', 0, '2026-02-23 15:36:58', '2026-02-23 15:36:58'),
(152, '187306', 0, '2026-02-23 15:36:58', '2026-02-23 15:36:58'),
(153, '187945', 0, '2026-02-23 15:36:58', '2026-02-23 15:36:58'),
(154, '188260', 0, '2026-02-23 15:36:58', '2026-02-23 15:36:58'),
(155, '188739', 0, '2026-02-23 15:36:58', '2026-02-23 15:36:58'),
(156, '189504', 0, '2026-02-23 15:36:58', '2026-02-23 15:36:58'),
(157, '189862', 0, '2026-02-23 15:36:58', '2026-02-23 15:36:58'),
(158, '190247', 0, '2026-02-23 15:36:58', '2026-02-23 15:36:58'),
(159, '190856', 0, '2026-02-23 15:36:58', '2026-02-23 15:36:58'),
(160, '191304', 0, '2026-02-23 15:36:58', '2026-02-23 15:36:58'),
(161, '191978', 0, '2026-02-23 15:36:58', '2026-02-23 15:36:58'),
(162, '192506', 0, '2026-02-23 15:36:58', '2026-02-23 15:36:58'),
(163, '192847', 0, '2026-02-23 15:36:58', '2026-02-23 15:36:58'),
(164, '193260', 0, '2026-02-23 15:36:58', '2026-02-23 15:36:58'),
(165, '193975', 0, '2026-02-23 15:36:58', '2026-02-23 15:36:58'),
(166, '194308', 0, '2026-02-23 15:36:58', '2026-02-23 15:36:58'),
(167, '194862', 0, '2026-02-23 15:36:58', '2026-02-23 15:36:58'),
(168, '195417', 0, '2026-02-23 15:36:58', '2026-02-23 15:36:58'),
(169, '195983', 0, '2026-02-23 15:36:58', '2026-02-23 15:36:58'),
(170, '196240', 0, '2026-02-23 15:36:58', '2026-02-23 15:36:58'),
(171, '196875', 0, '2026-02-23 15:36:58', '2026-02-23 15:36:58'),
(172, '197304', 0, '2026-02-23 15:36:58', '2026-02-23 15:36:58'),
(173, '197856', 0, '2026-02-23 15:36:58', '2026-02-23 15:36:58'),
(174, '198420', 0, '2026-02-23 15:36:58', '2026-02-23 15:36:58'),
(175, '198973', 0, '2026-02-23 15:36:58', '2026-02-23 15:36:58'),
(176, '199305', 0, '2026-02-23 15:36:58', '2026-02-23 15:36:58'),
(177, '199864', 0, '2026-02-23 15:36:58', '2026-02-23 15:36:58'),
(178, '200417', 0, '2026-02-23 15:36:58', '2026-02-23 15:36:58'),
(179, '200968', 0, '2026-02-23 15:36:58', '2026-02-23 15:36:58'),
(180, '201305', 0, '2026-02-23 15:36:58', '2026-02-23 15:36:58'),
(181, '201874', 0, '2026-02-23 15:36:58', '2026-02-23 15:36:58'),
(182, '202460', 0, '2026-02-23 15:36:58', '2026-02-23 15:36:58'),
(183, '202983', 0, '2026-02-23 15:36:58', '2026-02-23 15:36:58'),
(184, '203517', 0, '2026-02-23 15:36:58', '2026-02-23 15:36:58'),
(185, '203864', 0, '2026-02-23 15:36:58', '2026-02-23 15:36:58'),
(186, '204309', 0, '2026-02-23 15:36:58', '2026-02-23 15:36:58'),
(187, '204875', 0, '2026-02-23 15:36:58', '2026-02-23 15:36:58'),
(188, '205318', 0, '2026-02-23 15:36:58', '2026-02-23 15:36:58'),
(189, '205964', 0, '2026-02-23 15:36:58', '2026-02-23 15:36:58'),
(190, '206407', 0, '2026-02-23 15:36:59', '2026-02-23 15:36:59'),
(191, '206985', 0, '2026-02-23 15:36:59', '2026-02-23 15:36:59'),
(192, '207346', 0, '2026-02-23 15:36:59', '2026-02-23 15:36:59'),
(193, '207894', 0, '2026-02-23 15:36:59', '2026-02-23 15:36:59'),
(194, '208360', 0, '2026-02-23 15:36:59', '2026-02-23 15:36:59'),
(195, '208947', 0, '2026-02-23 15:36:59', '2026-02-23 15:36:59'),
(196, '209503', 0, '2026-02-23 15:36:59', '2026-02-23 15:36:59'),
(197, '209874', 0, '2026-02-23 15:36:59', '2026-02-23 15:36:59'),
(198, '210368', 0, '2026-02-23 15:36:59', '2026-02-23 15:36:59'),
(199, '210957', 0, '2026-02-23 15:36:59', '2026-02-23 15:36:59'),
(200, '211304', 0, '2026-02-23 15:36:59', '2026-02-23 15:36:59'),
(201, '211869', 0, '2026-02-23 15:36:59', '2026-02-23 15:36:59'),
(202, '212405', 0, '2026-02-23 15:36:59', '2026-02-23 15:36:59'),
(203, '212973', 0, '2026-02-23 15:36:59', '2026-02-23 15:36:59'),
(204, '213506', 0, '2026-02-23 15:36:59', '2026-02-23 15:36:59'),
(205, '213948', 0, '2026-02-23 15:36:59', '2026-02-23 15:36:59'),
(206, '214360', 0, '2026-02-23 15:36:59', '2026-02-23 15:36:59'),
(207, '214895', 0, '2026-02-23 15:36:59', '2026-02-23 15:36:59'),
(208, '215407', 0, '2026-02-23 15:36:59', '2026-02-23 15:36:59'),
(209, '215968', 0, '2026-02-23 15:36:59', '2026-02-23 15:36:59'),
(210, '216304', 0, '2026-02-23 15:36:59', '2026-02-23 15:36:59'),
(211, '216879', 0, '2026-02-23 15:36:59', '2026-02-23 15:36:59'),
(212, '217450', 0, '2026-02-23 15:36:59', '2026-02-23 15:36:59'),
(213, '217983', 0, '2026-02-23 15:36:59', '2026-02-23 15:36:59'),
(214, '218506', 0, '2026-02-23 15:36:59', '2026-02-23 15:36:59'),
(215, '218947', 0, '2026-02-23 15:36:59', '2026-02-23 15:36:59'),
(216, '219360', 0, '2026-02-23 15:36:59', '2026-02-23 15:36:59'),
(217, '219875', 0, '2026-02-23 15:36:59', '2026-02-23 15:36:59'),
(218, '220406', 0, '2026-02-23 15:36:59', '2026-02-23 15:36:59'),
(219, '220958', 0, '2026-02-23 15:36:59', '2026-02-23 15:36:59'),
(220, '221304', 0, '2026-02-23 15:36:59', '2026-02-23 15:36:59'),
(221, '221876', 0, '2026-02-23 15:36:59', '2026-02-23 15:36:59'),
(222, '222450', 0, '2026-02-23 15:36:59', '2026-02-23 15:36:59'),
(223, '222983', 0, '2026-02-23 15:36:59', '2026-02-23 15:36:59'),
(224, '223506', 0, '2026-02-23 15:36:59', '2026-02-23 15:36:59'),
(225, '223947', 0, '2026-02-23 15:36:59', '2026-02-23 15:36:59'),
(226, '224360', 0, '2026-02-23 15:36:59', '2026-02-23 15:36:59'),
(227, '224875', 0, '2026-02-23 15:36:59', '2026-02-23 15:36:59'),
(228, '225408', 0, '2026-02-23 15:36:59', '2026-02-23 15:36:59'),
(229, '225964', 0, '2026-02-23 15:36:59', '2026-02-23 15:36:59'),
(230, '226305', 0, '2026-02-23 15:36:59', '2026-02-23 15:36:59'),
(231, '482731', 0, '2026-02-23 15:36:59', '2026-02-23 15:36:59'),
(232, '905164', 0, '2026-02-23 15:36:59', '2026-02-23 15:36:59'),
(233, '317859', 0, '2026-02-23 15:36:59', '2026-02-23 15:36:59'),
(234, '764203', 0, '2026-02-23 15:36:59', '2026-02-23 15:36:59'),
(235, '198642', 0, '2026-02-23 15:36:59', '2026-02-23 15:36:59'),
(236, '553907', 0, '2026-02-23 15:36:59', '2026-02-23 15:36:59'),
(237, '820416', 0, '2026-02-23 15:36:59', '2026-02-23 15:36:59'),
(238, '639275', 0, '2026-02-23 15:36:59', '2026-02-23 15:36:59'),
(239, '471308', 0, '2026-02-23 15:36:59', '2026-02-23 15:36:59'),
(240, '256794', 0, '2026-02-23 15:36:59', '2026-02-23 15:36:59'),
(241, '903582', 0, '2026-02-23 15:36:59', '2026-02-23 15:36:59'),
(242, '140967', 0, '2026-02-23 15:36:59', '2026-02-23 15:36:59'),
(243, '728451', 0, '2026-02-23 15:36:59', '2026-02-23 15:36:59'),
(244, '365219', 0, '2026-02-23 15:36:59', '2026-02-23 15:36:59'),
(245, '594873', 0, '2026-02-23 15:36:59', '2026-02-23 15:36:59'),
(246, '812640', 0, '2026-02-23 15:36:59', '2026-02-23 15:36:59'),
(247, '279531', 0, '2026-02-23 15:36:59', '2026-02-23 15:36:59'),
(248, '436985', 0, '2026-02-23 15:36:59', '2026-02-23 15:36:59'),
(249, '751024', 0, '2026-02-23 15:36:59', '2026-02-23 15:36:59'),
(250, '668390', 0, '2026-02-23 15:36:59', '2026-02-23 15:36:59');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Yssabelle Sordan', 'yssabelle27sordan@gmail.com', NULL, '$2y$10$fmX1jeZt2.WbVFSgK24EU.UxUMyfvPb8lbSiQ0fLTKE/97XRCMcUu', NULL, '2026-02-23 15:36:59', '2026-02-23 15:36:59');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `carts`
--
ALTER TABLE `carts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `carts_menu_id_foreign` (`menu_id`),
  ADD KEY `carts_is_rice_menu_foreign` (`is_rice_menu`),
  ADD KEY `carts_is_add_ons_menu_foreign` (`is_add_ons_menu`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `categories_category_name_unique` (`category_name`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `menus`
--
ALTER TABLE `menus`
  ADD PRIMARY KEY (`id`),
  ADD KEY `menus_category_id_foreign` (`category_id`);

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
  ADD KEY `orders_menu_id_foreign` (`menu_id`),
  ADD KEY `orders_is_rice_menu_foreign` (`is_rice_menu`),
  ADD KEY `orders_is_add_ons_menu_foreign` (`is_add_ons_menu`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `reservations`
--
ALTER TABLE `reservations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tickets`
--
ALTER TABLE `tickets`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `tickets_reference_number_unique` (`reference_number`);

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
-- AUTO_INCREMENT for table `carts`
--
ALTER TABLE `carts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `menus`
--
ALTER TABLE `menus`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `reservations`
--
ALTER TABLE `reservations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `tickets`
--
ALTER TABLE `tickets`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=251;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `carts`
--
ALTER TABLE `carts`
  ADD CONSTRAINT `carts_is_add_ons_menu_foreign` FOREIGN KEY (`is_add_ons_menu`) REFERENCES `menus` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `carts_is_rice_menu_foreign` FOREIGN KEY (`is_rice_menu`) REFERENCES `menus` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `carts_menu_id_foreign` FOREIGN KEY (`menu_id`) REFERENCES `menus` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `menus`
--
ALTER TABLE `menus`
  ADD CONSTRAINT `menus_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_is_add_ons_menu_foreign` FOREIGN KEY (`is_add_ons_menu`) REFERENCES `menus` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `orders_is_rice_menu_foreign` FOREIGN KEY (`is_rice_menu`) REFERENCES `menus` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `orders_menu_id_foreign` FOREIGN KEY (`menu_id`) REFERENCES `menus` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
