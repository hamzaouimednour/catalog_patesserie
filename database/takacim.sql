-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le :  mer. 11 mars 2020 à 16:57
-- Version du serveur :  10.1.38-MariaDB
-- Version de PHP :  5.6.40

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `takacim`
--

-- --------------------------------------------------------

--
-- Structure de la table `cp_administrators`
--

CREATE TABLE `cp_administrators` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `cp_company`
--

CREATE TABLE `cp_company` (
  `id` int(10) UNSIGNED NOT NULL,
  `company_name` varchar(255) NOT NULL,
  `description` text,
  `address` text NOT NULL,
  `phone` int(8) DEFAULT NULL,
  `status` int(10) UNSIGNED NOT NULL DEFAULT '1' COMMENT '1: Active, 0: Inactive',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `cp_company`
--

INSERT INTO `cp_company` (`id`, `company_name`, `description`, `address`, `phone`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Takacim', '', '', NULL, 1, '2019-12-25 03:13:17', '2019-12-26 13:25:56');

-- --------------------------------------------------------

--
-- Structure de la table `cp_company_administrations`
--

CREATE TABLE `cp_company_administrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `company_id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `cp_company_sections`
--

CREATE TABLE `cp_company_sections` (
  `id` int(10) UNSIGNED NOT NULL,
  `company_id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `ville` varchar(100) DEFAULT NULL,
  `section` enum('S','F') NOT NULL COMMENT 'S: Sales Point, F: Factory',
  `status` tinyint(3) UNSIGNED NOT NULL DEFAULT '1' COMMENT '1: Enabled, 0: Disabled',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `cp_company_sections`
--

INSERT INTO `cp_company_sections` (`id`, `company_id`, `name`, `ville`, `section`, `status`, `created_at`, `updated_at`) VALUES
(1, 1, 'dfgdfgc', 'sfax', 'S', 1, '2019-12-29 23:03:07', '2019-12-30 00:13:31');

-- --------------------------------------------------------

--
-- Structure de la table `cp_company_users`
--

CREATE TABLE `cp_company_users` (
  `id` int(10) UNSIGNED NOT NULL,
  `company_section_id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `cp_company_users`
--

INSERT INTO `cp_company_users` (`id`, `company_section_id`, `user_id`, `created_at`, `updated_at`) VALUES
(20, 1, 2, '2020-03-11 08:02:43', '2020-03-11 08:02:43'),
(21, 1, 3, '2020-03-11 09:19:06', '2020-03-11 09:19:06');

-- --------------------------------------------------------

--
-- Structure de la table `cp_components`
--

CREATE TABLE `cp_components` (
  `id` int(10) UNSIGNED NOT NULL,
  `company_id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `category` enum('C','D') NOT NULL COMMENT 'C: component, D: Decoration',
  `img` varchar(255) DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `cp_component_groups`
--

CREATE TABLE `cp_component_groups` (
  `id` int(10) UNSIGNED NOT NULL,
  `company_id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text,
  `usage` enum('M','S') NOT NULL COMMENT 'M: multiple, S: single',
  `status` tinyint(4) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `cp_customers`
--

CREATE TABLE `cp_customers` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(200) NOT NULL,
  `phone` int(10) UNSIGNED NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `cp_group_permissions`
--

CREATE TABLE `cp_group_permissions` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(200) NOT NULL,
  `company_id` int(10) UNSIGNED NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `cp_group_permissions`
--

INSERT INTO `cp_group_permissions` (`id`, `name`, `company_id`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Administration d\'entreprise', 1, 1, '2020-03-11 07:58:39', '2020-03-11 07:58:39'),
(2, 'vendeuse', 1, 1, '2020-03-11 09:18:12', '2020-03-11 09:18:12');

-- --------------------------------------------------------

--
-- Structure de la table `cp_migrations`
--

CREATE TABLE `cp_migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `cp_migrations`
--

INSERT INTO `cp_migrations` (`id`, `migration`, `batch`) VALUES
(21, '2019_12_03_133130_create_administrators_table', 1),
(22, '2019_12_03_133217_create_customers_table', 1),
(23, '2019_12_03_133318_create_company_table', 1),
(24, '2019_12_03_133412_create_company_administrations_table', 1),
(25, '2019_12_03_133457_create_company_sections_table', 1),
(26, '2019_12_03_133542_create_company_users_table', 1),
(27, '2019_12_03_133646_create_products_table', 1),
(28, '2019_12_03_133800_create_product_imgs_table', 1),
(29, '2019_12_03_133912_create_product_sales_table', 1),
(30, '2019_12_03_134003_create_tags_table', 1),
(31, '2019_12_03_134047_create_product_tags_table', 1),
(32, '2019_12_03_134119_create_sizes_table', 1),
(33, '2019_12_03_134218_create_product_size_prices_table', 1),
(34, '2019_12_03_134319_create_components_table', 1),
(35, '2019_12_03_134351_create_product_components_table', 1),
(36, '2019_12_03_134535_create_product_component_prices_table', 1),
(37, '2019_12_03_134611_create_component_groups_table', 1),
(38, '2019_12_03_134648_create_product_component_groups_table', 1),
(39, '2019_12_03_134742_create_orders_table', 1),
(40, '2020_01_05_063627_add_img_to_components', 2),
(41, '2020_01_07_071302_add_created_at_to_sizes', 3),
(42, '2020_01_07_081001_add_desc_to_component_groups', 4),
(43, '2020_01_07_081413_add_usage_to_component_groups', 5),
(44, '2020_01_07_110546_add_desc_to_products', 6),
(45, '2020_01_16_224122_add_default_to_product_components', 7),
(46, '2020_01_17_132236_add_softdelete_to_products', 8),
(47, '2020_02_15_053904_add_thumb_to_product_imgs', 9),
(48, '2020_02_26_114552_add_order_num_to_orders', 9);

-- --------------------------------------------------------

--
-- Structure de la table `cp_modules`
--

CREATE TABLE `cp_modules` (
  `id` int(10) UNSIGNED NOT NULL,
  `module` varchar(200) NOT NULL,
  `controller` varchar(255) NOT NULL,
  `actions` varchar(255) DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `cp_modules`
--

INSERT INTO `cp_modules` (`id`, `module`, `controller`, `actions`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Produits', 'products', '[\"A\",\"M\",\"D\"]', 1, NULL, '2020-03-11 09:02:16'),
(2, 'CatÃ©gories', 'tags', '[\"A\",\"M\",\"D\"]', 1, NULL, NULL),
(3, 'Dimensions', 'sizes', '[\"A\",\"M\",\"D\"]', 1, NULL, NULL),
(4, 'Composants', 'components', '[\"A\",\"M\",\"D\"]', 1, NULL, NULL),
(5, 'Commandes', 'orders', '[\"A\",\"M\",\"D\",\"P\"]', 1, NULL, '2020-03-11 09:03:25'),
(6, 'Utilisateurs', 'users', '[\"A\",\"M\",\"D\"]', 1, NULL, NULL),
(7, 'Sections d\'entreprise', 'company-sections', '[\"A\",\"M\",\"D\"]', 1, NULL, NULL),
(8, 'Informations d\'entreprise', 'company', '[\"M\"]', 1, NULL, NULL),
(9, 'Groupes d\'autorisations', 'module-groups', '[\"A\",\"M\",\"D\"]', 1, NULL, NULL),
(10, 'Autorisations', 'user-permissions', '[\"A\",\"M\",\"D\"]', 1, '2020-03-10 23:11:35', '2020-03-10 23:11:35');

-- --------------------------------------------------------

--
-- Structure de la table `cp_module_groups`
--

CREATE TABLE `cp_module_groups` (
  `id` int(10) UNSIGNED NOT NULL,
  `module_id` int(10) UNSIGNED NOT NULL,
  `group_id` int(10) UNSIGNED NOT NULL,
  `actions` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `cp_module_groups`
--

INSERT INTO `cp_module_groups` (`id`, `module_id`, `group_id`, `actions`, `created_at`, `updated_at`) VALUES
(1, 1, 1, '[\"A\",\"M\",\"D\"]', '2020-03-11 07:58:39', '2020-03-11 07:58:39'),
(2, 2, 1, '[\"A\",\"M\",\"D\"]', '2020-03-11 07:58:39', '2020-03-11 07:58:39'),
(3, 3, 1, '[\"A\",\"M\",\"D\"]', '2020-03-11 07:58:39', '2020-03-11 07:58:39'),
(4, 4, 1, '[\"A\",\"M\",\"D\"]', '2020-03-11 07:58:39', '2020-03-11 07:58:39'),
(5, 5, 1, '[\"A\",\"M\",\"P\"]', '2020-03-11 07:58:39', '2020-03-11 07:58:39'),
(6, 6, 1, '[\"A\",\"M\",\"D\"]', '2020-03-11 07:58:39', '2020-03-11 07:58:39'),
(7, 7, 1, '[\"A\",\"M\",\"D\"]', '2020-03-11 07:58:39', '2020-03-11 07:58:39'),
(8, 8, 1, '[\"M\"]', '2020-03-11 07:58:39', '2020-03-11 07:58:39'),
(9, 9, 1, '[\"A\",\"M\",\"D\"]', '2020-03-11 07:58:39', '2020-03-11 07:58:39'),
(10, 10, 1, '[\"A\",\"M\",\"D\"]', '2020-03-11 07:58:39', '2020-03-11 07:58:39'),
(11, 5, 2, '[\"A\",\"M\",\"P\"]', '2020-03-11 09:18:12', '2020-03-11 09:18:12');

-- --------------------------------------------------------

--
-- Structure de la table `cp_orders`
--

CREATE TABLE `cp_orders` (
  `id` int(10) UNSIGNED NOT NULL,
  `customer_id` int(10) UNSIGNED NOT NULL,
  `company_id` int(10) UNSIGNED NOT NULL,
  `special` tinyint(1) DEFAULT '0',
  `product_components` longtext,
  `delivery_date` datetime DEFAULT NULL,
  `delivery_mode` enum('S','C') NOT NULL DEFAULT 'C' COMMENT 'S : delivery by Society, C : Delivery by Customer',
  `delivery_point` enum('S','A') NOT NULL DEFAULT 'S' COMMENT 'S : Same Sales point, A : Another Sales point',
  `acompte` double(10,3) DEFAULT NULL,
  `acompte_type` enum('C','E','T') DEFAULT NULL COMMENT 'C: Cheque, E: EspÃ¨ces , T: TÃ©lÃ©paiement',
  `total` double(10,3) NOT NULL,
  `instructions` text,
  `status` enum('P','M','R','D','L','C') NOT NULL DEFAULT 'P' COMMENT 'P: pending, M: making, R: ready, D: delivery, L: delivred',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `order_num` varchar(255) DEFAULT NULL,
  `cautionnement` double(10,3) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `cp_products`
--

CREATE TABLE `cp_products` (
  `id` int(10) UNSIGNED NOT NULL,
  `ref` varchar(100) DEFAULT NULL,
  `company_id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `price_by_size` tinyint(1) NOT NULL DEFAULT '0',
  `default_price` double(10,3) DEFAULT NULL,
  `description` text,
  `status` tinyint(4) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `cp_products`
--

INSERT INTO `cp_products` (`id`, `ref`, `company_id`, `name`, `price_by_size`, `default_price`, `description`, `status`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'GP001', 1, 'OpÃ©ra', 1, 33.000, '. Biscuit Joconde \r\n. crÃ©mÃ© au beurre cafÃ©\r\n. Ganache au chocolat', 1, '2020-01-22 13:35:22', '2020-03-04 11:17:03', NULL),
(2, 'GP002', 1, 'Macaron chocolat pistache', 1, 45.000, '. Macaron chocolat\r\n. crÃ©mÃ© pistache\r\n. macaron pistache\r\n. mousse chocolat', 1, '2020-01-22 13:42:47', '2020-02-19 09:04:34', NULL),
(3, 'GP003', 1, 'Favorita', 1, 33.000, '. Mousse chocolat blanc\r\n. croquant pistache\r\n. Mousse framboise\r\n. Biscuit pistache\r\n. Framboise', 1, '2020-01-22 13:53:43', '2020-02-19 09:04:19', NULL),
(4, 'GP004', 1, 'Macaron pistache', 1, 45.000, '. Croquant noisette\r\n. Macaron pistache\r\n. crÃ©mÃ© pistache', 1, '2020-01-22 14:02:50', '2020-03-04 07:39:20', NULL),
(5, 'GP005', 1, 'Nougatine', 1, 37.000, '. Biscuit noisette\r\n. Croquant pralinÃ©\r\n. CrÃ©mÃ© pralinÃ©', 1, '2020-01-23 07:32:21', '2020-02-11 10:22:51', NULL),
(6, 'GP007', 1, 'TrÃ©sor', 1, 45.000, '. Croquant pralinÃ© fruit secs\r\n. Biscuit noisette\r\n. crÃ©mÃ© pistache\r\n. crÃ©mÃ© pralinÃ©', 1, '2020-01-23 07:50:00', '2020-02-19 09:05:21', NULL),
(7, 'GP008', 1, 'ForÃªt noire', 1, 29.000, '. Biscuit chocolat\r\n. crÃ©mÃ© fraÃ®che\r\n. fruit de saison', 1, '2020-01-23 07:59:30', '2020-02-19 09:05:39', NULL),
(8, 'GP009', 1, 'Moka', 1, 29.000, '. Biscuit amande chocolat\r\n. crÃ©mÃ© au beurre cafÃ©\r\n. mousse chocolat', 1, '2020-01-23 08:09:14', '2020-02-20 09:20:18', NULL),
(9, 'GP010', 1, 'Noisette', 1, 29.000, '. Biscuit vanille\r\n. crÃ©mÃ© de noisette \r\n. Croquant noisette', 1, '2020-01-23 08:17:13', '2020-02-20 09:22:05', NULL),
(10, 'GP011', 1, 'Plaisir gourmande', 1, 45.000, '. Croquant noisette\r\n. Biscuit moelleux noisette\r\n. CrÃ©meux chocolat au lait noisette \r\n. Amande effilÃ©es', 1, '2020-01-23 08:46:44', '2020-01-23 08:46:44', NULL),
(11, 'GP012', 1, 'Caramel chocolat', 1, 42.900, '. Biscuit amande caramel\r\n. CrÃ©meux chocolat au lait\r\n. CrÃ©mÃ© de praline amande', 1, '2020-01-23 09:04:33', '2020-02-03 09:42:48', NULL),
(12, 'GP013', 1, 'Nougat chocolat', 1, 37.000, '. Biscuit aux noisette \r\n. mousse chocolat \r\n. crÃ©mÃ© de pralinÃ©\r\n. crÃ©meuse chocolat au lait \r\n. Croquant pralinÃ©', 1, '2020-01-23 09:26:38', '2020-02-20 09:23:03', NULL),
(13, 'GP014', 1, 'DÃ©sir chocolat', 1, 33.000, '. Croquant chocolat', 1, '2020-01-23 10:27:01', '2020-02-11 13:03:33', NULL),
(14, 'GP015', 1, 'Charlotte chocolat', 1, 29.000, '. Chocolat', 1, '2020-01-23 10:51:11', '2020-02-20 09:23:37', NULL),
(15, 'GP016', 1, 'Feuille d\'automne', 1, 33.000, '. chocolat', 1, '2020-01-23 12:04:19', '2020-02-20 09:23:56', NULL),
(16, 'GP017', 1, 'Mars', 1, 37.000, '. Noisette caramÃ©lisÃ©e\r\n. chocolat', 1, '2020-01-23 12:20:35', '2020-01-23 12:20:35', NULL),
(17, 'GP018', 1, 'Noisette nougat', 1, 37.000, '.Noisette nougat', 1, '2020-01-23 12:37:37', '2020-03-04 07:41:34', NULL),
(18, 'GP019', 1, 'Snickers', 1, 37.000, '. Croquant caramel', 1, '2020-01-23 12:53:13', '2020-02-20 09:24:41', NULL),
(19, 'GP020', 1, 'Tendresse', 1, 37.000, '. Croquant amande\r\n. chocolat caramel', 1, '2020-01-23 13:20:56', '2020-02-20 09:25:02', NULL),
(20, 'GP021', 1, 'SucÃ©s', 1, 33.000, '. Noisette chocolat', 1, '2020-01-23 13:29:02', '2020-02-20 09:25:22', NULL),
(21, 'GP022', 1, 'Charlotte aux fruite', 1, 29.000, '. Biscuit cuillÃ¨re\r\n. crÃ©mÃ© mousseline \r\n. crÃ©mÃ© fraÃ®che\r\n. fruit de saison', 1, '2020-01-23 14:00:35', '2020-02-20 09:25:42', NULL),
(22, 'GP023', 1, 'SuprÃªme caramel', 1, 33.000, '. caramel', 1, '2020-01-23 14:24:29', '2020-02-20 09:25:59', NULL),
(23, 'GP024', 1, 'Othello', 1, 33.000, '. Noisette chocolat', 1, '2020-01-24 09:13:36', '2020-03-04 07:45:20', NULL),
(24, 'GP025', 1, 'Noisette pistache', 1, 33.000, '. Noisette pistache', 1, '2020-01-24 09:25:33', '2020-02-11 13:50:09', NULL),
(25, 'GP026', 1, 'Othello marbrÃ©', 1, 33.000, '. Noisette chocolat', 1, '2020-01-24 09:35:20', '2020-02-11 10:22:23', NULL),
(26, 'GP027', 1, 'Noisette fekia', 1, 29.000, '. Noisette', 1, '2020-01-24 09:45:26', '2020-02-20 09:27:01', NULL),
(27, 'B400', 1, 'Tentation', 1, 52.000, '. Noisette chocolat', 1, '2020-01-24 13:17:01', '2020-02-20 09:27:43', NULL),
(28, 'B401', 1, 'La mÃ¨re de famille', 1, 52.000, '. pistache', 1, '2020-01-24 13:20:41', '2020-02-20 09:28:00', NULL),
(29, 'B402', 1, 'La croustillante', 1, 52.000, '. Noisette', 1, '2020-01-24 13:45:56', '2020-02-20 09:28:25', NULL),
(30, 'B403', 1, 'Charme d\'orient', 1, 52.000, '. Nougat \r\n. Pistache', 1, '2020-01-25 06:52:03', '2020-01-25 06:52:03', NULL),
(31, 'B404', 1, 'Cote d\'or', 1, 52.000, '. Nougat\r\n. Chocolat', 1, '2020-01-25 07:15:52', '2020-02-20 09:30:22', NULL),
(32, 'B405', 1, 'Royal chocolat', 1, 52.000, '. Chocolat', 1, '2020-01-25 07:35:15', '2020-02-20 09:43:37', NULL),
(33, 'B406', 1, 'L\'arabe d\'or', 1, 52.000, '. Nougat pistache', 1, '2020-01-25 07:42:54', '2020-02-20 09:43:58', NULL),
(34, 'B407', 1, 'Le chocolat', 1, 52.000, '. Chocolat', 1, '2020-01-25 07:45:21', '2020-02-20 09:44:23', NULL),
(35, 'B408', 1, 'LumiÃ©re', 1, 52.000, '. Chocolat', 1, '2020-01-25 08:01:32', '2020-02-20 09:44:46', NULL),
(36, 'B409', 1, 'Gouttes d\'or', 1, 52.000, '. Nougat', 1, '2020-01-25 08:06:32', '2020-02-20 09:45:04', NULL),
(37, 'B410', 1, 'snikers', 1, 52.000, '. Caramel \r\n. Chocolat', 1, '2020-01-25 08:26:23', '2020-02-20 09:45:47', NULL),
(38, 'B411', 1, 'Papaye', 1, 52.000, '. Chocolat au lait\r\n. Croquant pralinÃ©', 1, '2020-01-25 08:28:51', '2020-02-20 09:46:03', NULL),
(39, 'B412', 1, 'Mars', 1, 52.000, '. Chocolat \r\n. Noisette', 1, '2020-01-25 08:31:05', '2020-02-20 09:47:47', NULL),
(40, 'B4130', 1, 'SidÃ©ral', 1, 52.000, '. Chocolat\r\n. Nougat', 1, '2020-01-25 08:33:01', '2020-02-20 09:46:25', NULL),
(41, 'B414', 1, 'La maison du chocolat', 1, 52.000, '. Chocolat noir\r\n. Chocolat au lait \r\n. Chocolat blanc', 1, '2020-01-25 08:35:44', '2020-02-20 09:47:11', NULL),
(42, 'PT100', 1, 'Mille nuit pistache', 0, 42.000, 'NB: PCS/KG â‰ƒ 60', 1, '2020-02-01 10:55:06', '2020-02-20 09:50:24', NULL),
(43, 'PT101', 1, 'Baklawa bent el bey', 0, 40.000, 'NB: PCS/KG â‰ƒ 50', 1, '2020-02-03 07:15:40', '2020-02-20 09:51:05', NULL),
(44, 'PT102', 1, 'Kaaber pistache pignon', 0, 75.000, 'NB: PCS/KG â‰ƒ 80', 1, '2020-02-03 07:18:39', '2020-02-20 09:51:47', NULL),
(45, 'PT103', 1, 'Bjaouia', 1, 40.000, 'NB: PCS/KG â‰ƒ 50', 1, '2020-02-03 07:21:27', '2020-02-08 07:14:48', NULL),
(46, 'PT104', 1, 'Chapeau soltane', 0, 59.000, 'NB: PCS/KG â‰ƒ 40', 1, '2020-02-03 07:24:49', '2020-02-20 09:52:27', NULL),
(47, 'PT105', 1, 'Kaaber amande', 0, 40.000, 'NB: PCS/KG â‰ƒ 45', 1, '2020-02-03 07:27:34', '2020-02-20 09:52:55', NULL),
(48, 'PT106', 1, 'Sanboussa', 0, 40.000, 'NB: PCS/KG â‰ƒ 80', 1, '2020-02-03 07:28:54', '2020-02-20 09:53:21', NULL),
(49, 'PT107', 1, 'Samssa amande', 1, 36.000, 'NB: PCS/KG â‰ƒ 35', 1, '2020-02-03 10:29:17', '2020-02-03 10:29:17', NULL),
(50, 'PT108', 1, 'Samssa noisette', 0, 42.000, 'NB: PCS/KG â‰ƒ 35', 1, '2020-02-03 10:31:07', '2020-02-20 09:54:06', NULL),
(51, 'PT109', 1, 'Samssa pistache', 0, 65.000, 'NB: PCS/KG â‰ƒ 40', 1, '2020-02-03 10:32:46', '2020-02-20 09:54:40', NULL),
(52, 'PT110', 1, 'Kaak mnakkech pistache', 0, 59.000, 'NB: PCS/KG â‰ƒ 80', 1, '2020-02-03 12:27:14', '2020-02-20 09:55:19', NULL),
(53, 'PT111', 1, 'Kaak anbaer', 0, 40.000, 'NB: PCS/KG â‰ƒ 45', 1, '2020-02-03 12:29:46', '2020-02-20 09:55:50', NULL),
(54, 'PT112', 1, 'Baklawa fekia', 0, 45.000, 'NB: PCS/KG â‰ƒ 40', 1, '2020-02-03 12:31:07', '2020-02-20 09:56:23', NULL),
(55, 'PT113', 1, 'Baklawa louz noisette', 0, 40.000, 'NB: PCS/KG â‰ƒ 40', 1, '2020-02-03 12:32:55', '2020-02-20 09:56:53', NULL),
(56, 'PT114', 1, 'Baklawa louz', 0, 39.000, 'NB: PCS/KG â‰ƒ 40', 1, '2020-02-03 12:34:01', '2020-02-20 09:57:18', NULL),
(57, 'PT115', 1, 'Kaak warka pistache', 0, 59.000, 'NB: PCS/KG â‰ƒ 70', 1, '2020-02-03 12:37:09', '2020-02-20 09:58:07', NULL),
(58, 'PT116', 1, 'Twagen pistache', 0, 59.000, 'NB: PCS/KG â‰ƒ 80', 1, '2020-02-03 13:14:15', '2020-02-20 09:58:43', NULL),
(59, 'PT117', 1, 'Warda pistache', 0, 59.000, 'NB: PCS/KG â‰ƒ 45', 1, '2020-02-03 13:17:03', '2020-02-20 09:59:14', NULL),
(60, 'PT118', 1, 'Kaak louz', 0, 40.000, 'NB: PCS/KG â‰ƒ 45', 1, '2020-02-03 13:20:21', '2020-02-20 09:59:44', NULL),
(61, 'PT119', 1, 'Raisins', 0, 40.000, 'NB: PCS/KG â‰ƒ 65', 1, '2020-02-03 13:21:59', '2020-02-20 10:00:15', NULL),
(62, 'PT120', 1, 'Twegen', 0, 40.000, 'NB: PCS/KG â‰ƒ 55', 1, '2020-02-04 07:22:41', '2020-02-20 10:00:42', NULL),
(63, 'PT121', 1, 'Coccinelle aux noix', 0, 40.000, 'NB: PCS/KG â‰ƒ 50', 1, '2020-02-04 07:25:10', '2020-02-20 10:01:13', NULL),
(64, 'PT122', 1, 'Kaaber pistache', 0, 65.000, 'NB: PCS/KG â‰ƒ 60', 1, '2020-02-04 07:27:38', '2020-02-20 10:01:41', NULL),
(65, 'PT123', 1, 'Adlya pistache', 0, 59.000, 'NB: PCS/KG â‰ƒ 60', 1, '2020-02-04 07:40:41', '2020-02-20 10:02:12', NULL),
(66, 'PT124', 1, 'Swaguer pistache bel warka', 0, 59.000, 'NB: PCS/KG â‰ƒ 40', 1, '2020-02-04 07:51:23', '2020-02-20 10:02:40', NULL),
(67, 'PT125', 1, 'Kaak mlabess', 0, 40.000, 'NB: PCS/KG â‰ƒ 50', 1, '2020-02-04 07:53:19', '2020-02-20 10:03:04', NULL),
(68, 'PT126', 1, 'Bouquet pistache', 0, 59.000, 'NB: PCS/KG â‰ƒ 50', 1, '2020-02-04 07:55:02', '2020-02-20 10:03:32', NULL),
(69, 'PT127', 1, 'Kaak meloui', 0, 40.000, 'NB: PCS/KG â‰ƒ 50', 1, '2020-02-04 07:57:25', '2020-02-20 10:04:00', NULL),
(70, 'PT128', 1, 'Kaak mnakkech', 0, 40.000, 'NB: PCS/KG â‰ƒ 60', 1, '2020-02-04 08:00:10', '2020-02-20 10:04:43', NULL),
(71, 'PT129', 1, 'Dawama pistache', 0, 59.000, 'NB: PCS/KG â‰ƒ 50', 1, '2020-02-04 08:09:58', '2020-02-20 10:05:28', NULL),
(72, 'PT130', 1, 'Dawama amande', 0, 40.000, 'NB: PCS/KG â‰ƒ 45', 1, '2020-02-04 08:11:17', '2020-02-20 10:05:56', NULL),
(73, 'PT131', 1, 'Kaak fosdek bondek', 0, 59.000, 'NB: PCS/KG â‰ƒ 50', 1, '2020-02-04 08:13:21', '2020-02-20 10:06:30', NULL),
(74, 'PT132', 1, 'Noix ovale', 0, 40.000, 'NB: PCS/KG â‰ƒ 40', 1, '2020-02-04 08:14:41', '2020-02-20 10:07:49', NULL),
(75, 'PT133', 1, 'Mlabess noisette', 0, 40.000, 'NB: PCS/KG â‰ƒ 60', 1, '2020-02-04 08:16:33', '2020-02-20 10:08:31', NULL),
(76, 'PT134', 1, 'Swaguer pistache', 0, 59.000, 'NB: PCS/KG â‰ƒ 50', 1, '2020-02-04 08:18:08', '2020-02-20 10:08:56', NULL),
(77, 'PT135', 1, 'Puit d\'amour', 0, 59.000, 'NB: PCS/KG â‰ƒ50', 1, '2020-02-04 08:40:49', '2020-02-20 10:09:20', NULL),
(78, 'PT136', 1, 'Bjaouia chocolat', 0, 40.000, 'NB: PCS/KG â‰ƒ 45', 1, '2020-02-04 08:42:24', '2020-02-20 10:09:49', NULL),
(79, 'PT137', 1, 'Kaaber amande', 0, 40.000, 'NB: PCS/KG â‰ƒ 60', 1, '2020-02-04 08:47:17', '2020-02-20 10:10:14', NULL),
(80, 'PT138', 1, 'Swaguer chocolat', 0, 40.000, 'NB: PCS/KG â‰ƒ 55', 1, '2020-02-04 08:49:49', '2020-02-20 10:10:37', NULL),
(81, 'PT139', 1, 'Mlabess pistache', 0, 59.000, 'NB: PCS/KG â‰ƒ 80', 1, '2020-02-04 09:01:50', '2020-02-20 10:11:12', NULL),
(82, 'PT140', 1, 'Freten pistache', 0, 59.000, 'NB: PCS/KG â‰ƒ 50', 1, '2020-02-04 09:04:25', '2020-02-20 10:11:41', NULL),
(83, 'PT141', 1, 'Mlabess louz', 1, 40.000, 'NB: PCS/KG â‰ƒ 50', 1, '2020-02-04 09:13:30', '2020-02-08 07:55:19', NULL),
(84, 'PT142', 1, 'Kaaber citron', 0, 40.000, 'NB: PCS/KG â‰ƒ 60', 1, '2020-02-04 09:14:49', '2020-02-20 10:12:35', NULL),
(85, 'PT143', 1, 'Rondelle pistache amande', 0, 59.000, 'NB: PCS/KG â‰ƒ 40', 1, '2020-02-04 09:16:37', '2020-02-20 10:12:59', NULL),
(86, 'PT144', 1, 'Ain sbaniouria', 0, 40.000, 'NB: PCS/KG â‰ƒ 50', 1, '2020-02-04 09:47:38', '2020-02-20 10:13:35', NULL),
(87, 'PT145', 1, 'Kaak warka', 0, 40.000, 'NB: PCS/KG â‰ƒ45', 1, '2020-02-04 10:13:29', '2020-02-20 10:14:01', NULL),
(88, 'PT146', 1, 'Naoura', 0, 59.000, 'NB: PCS/KG â‰ƒ 40', 1, '2020-02-04 10:21:21', '2020-02-20 10:14:29', NULL),
(89, 'PT147', 1, 'Nejma pistache', 0, 59.000, 'NB: PCS/KG â‰ƒ 40', 1, '2020-02-04 10:23:49', '2020-02-20 10:15:08', NULL),
(90, 'PT148', 1, 'Couffin amande', 0, 40.000, 'NB: PCS/KG â‰ƒ 50', 1, '2020-02-04 11:39:16', '2020-02-20 10:15:41', NULL),
(91, 'PT149', 1, 'Mille nuit chocolat', 0, 42.000, 'NB: PCS/KG â‰ƒ 60', 1, '2020-02-04 11:43:43', '2020-02-20 10:16:42', NULL),
(92, 'PT150', 1, 'Mlabess coeur louz', 0, 40.000, 'NB: PCS/KG â‰ƒ 75', 1, '2020-02-04 12:21:57', '2020-02-20 10:17:06', NULL),
(93, 'PT151', 1, 'Mlabess carrÃ© louz', 0, 40.000, 'NB: PCS/KG â‰ƒ 70', 1, '2020-02-04 12:38:35', '2020-02-20 10:17:27', NULL),
(94, 'PT152', 1, 'Citron nawara', 0, 40.000, 'NB: PCS/KG â‰ƒ 80', 1, '2020-02-04 13:12:45', '2020-02-20 10:17:52', NULL),
(95, 'PT153', 1, 'Kaak mnakkech pistache', 0, 59.000, 'NB: PCS/KG â‰ƒ 80', 1, '2020-02-20 10:21:30', '2020-02-20 10:21:30', NULL),
(96, 'SA100', 1, 'Croquette royale', 0, 3.900, NULL, 1, '2020-02-20 10:26:59', '2020-02-20 10:27:47', NULL),
(97, 'SA101', 1, 'CuillÃ¨re fromage blanc', 0, 0.000, NULL, 1, '2020-02-20 10:31:42', '2020-02-20 10:31:42', NULL),
(98, 'SA102', 1, 'Choux bÃ©chamel / poulet/ champignon', 0, 36.000, 'NB: PCS/KG â‰ƒ44', 1, '2020-02-20 10:35:17', '2020-03-05 10:24:25', NULL),
(99, 'SA103', 1, 'Croissant au thon', 0, 36.000, 'NB: PCS/KG â‰ƒ 80', 1, '2020-02-20 10:37:53', '2020-03-05 10:23:57', NULL),
(100, 'SA104', 1, 'PÃ¢tÃ©e aux noix et fromage blanc', 0, 39.000, 'NB: PCS/KG â‰ƒ 75', 1, '2020-02-20 10:42:17', '2020-02-20 10:42:17', NULL),
(101, 'SA 105', 1, 'Croquette au saumon', 0, 44.000, 'NB: PCS/KG â‰ƒ 26', 1, '2020-02-20 10:44:31', '2020-03-05 10:24:47', NULL),
(102, 'SA106', 1, 'CarrÃ© viande', 0, 36.000, 'NB: PCS/KG â‰ƒ 40', 1, '2020-02-20 10:46:51', '2020-03-05 10:25:29', NULL),
(103, 'SA107', 1, 'CarrÃ© fromage /saumon', 0, 59.000, 'NB: PCS/KG â‰ƒ 45', 1, '2020-02-20 11:02:46', '2020-02-20 11:02:46', NULL),
(104, 'SA108', 1, 'Vol- au vent fromage', 0, 36.000, 'NB: PCS/KG â‰ƒ 40', 1, '2020-02-20 12:04:18', '2020-03-05 10:26:19', NULL),
(105, 'SA109', 1, 'Barquette viande', 0, 36.000, 'NB: PCS/KG â‰ƒ 35', 1, '2020-02-20 12:10:00', '2020-02-20 12:10:00', NULL),
(106, 'SA110', 1, 'Tarte aux champignon', 0, 36.000, 'NB: PCS/KG â‰ƒ 45', 1, '2020-02-20 12:12:43', '2020-02-20 12:12:43', NULL),
(107, 'SA111', 1, 'banadhej', 0, 36.000, 'NB: PCS/KG â‰ƒ 50', 1, '2020-02-20 12:34:59', '2020-02-20 12:34:59', NULL),
(108, 'SA112', 1, 'Tarte poulet', 0, 36.000, 'NB: PCS/KG â‰ƒ 60', 1, '2020-02-20 12:36:41', '2020-02-20 12:36:41', NULL),
(109, 'SA113', 1, 'Pizza', 0, 36.000, 'NB: PCS/KG â‰ƒ 52', 1, '2020-02-20 12:41:09', '2020-02-20 12:41:09', NULL),
(110, 'SA114', 1, 'Chawarma crevette', 0, 39.000, 'NB: PCS/KG â‰ƒ 50', 1, '2020-02-20 12:46:53', '2020-03-05 10:27:13', NULL),
(111, 'SA115', 1, 'Pizza ronde', 0, 36.000, 'NB: PCS/KG â‰ƒ 60', 1, '2020-02-20 12:48:30', '2020-02-20 12:48:30', NULL),
(112, 'SA116', 1, 'CanapÃ© crevette', 0, 49.000, 'NB: PCS/KG â‰ƒ 75', 1, '2020-02-20 12:50:04', '2020-02-20 12:50:04', NULL),
(113, 'SA117', 1, 'Brochette double poulet fromage', 0, 3.400, NULL, 1, '2020-02-20 13:00:27', '2020-02-20 13:00:27', NULL),
(114, 'SA118', 1, 'Brochette fromage /saumon/ escalope', 0, 3.400, NULL, 1, '2020-02-20 13:03:05', '2020-02-20 13:04:20', NULL),
(115, 'SA119', 1, 'CanapÃ© saumon', 0, 59.000, 'NB: PCS/KG â‰ƒ 102', 1, '2020-02-20 13:08:18', '2020-02-20 13:08:18', NULL),
(116, 'SA120', 1, 'Vol- au vent poulet champignon', 0, 36.000, 'NB: PCS/KG â‰ƒ 40', 1, '2020-02-20 13:11:45', '2020-02-20 13:11:45', NULL),
(117, 'SA121', 1, 'Quiche', 0, 36.000, 'NB: PCS/KG â‰ƒ 50', 1, '2020-02-20 13:14:37', '2020-02-20 13:14:37', NULL),
(118, 'SA122', 1, 'Tarte fromage', 0, 36.000, 'NB: PCS/KG â‰ƒ 54', 1, '2020-02-20 13:16:01', '2020-02-20 13:16:01', NULL),
(119, 'SA123', 1, 'RoulÃ© Ã©pinard /fromage / saumon', 0, 44.000, 'NB: PCS/KG â‰ƒ 38', 1, '2020-02-20 13:17:30', '2020-02-20 13:17:30', NULL),
(120, 'SA124', 1, 'Mini sandwiche au salami', 0, 36.000, 'NB: PCS/KG â‰ƒ 28', 1, '2020-02-20 13:24:26', '2020-02-20 13:24:26', NULL),
(121, 'SA125', 1, 'PÃ¢tÃ©e viande', 0, 36.000, 'NB: PCS/KG â‰ƒ 60', 1, '2020-02-20 13:27:14', '2020-02-20 13:27:14', NULL),
(122, 'SA126', 1, 'Barquette ojja crevette', 0, 36.000, 'NB: PCS/KG â‰ƒ 31', 1, '2020-02-20 13:30:26', '2020-02-20 13:30:26', NULL),
(123, 'SA127', 1, 'Choux crevette', 0, 36.000, 'NB: PCS/KG â‰ƒ 44', 1, '2020-02-20 13:35:37', '2020-02-20 13:35:37', NULL),
(124, 'SA128', 1, 'Boulette pistache', 0, 49.000, 'NB: PCS/KG â‰ƒ 75', 1, '2020-02-20 13:40:43', '2020-02-20 13:40:43', NULL),
(125, 'SA129', 1, 'Brochette poulet fromage', 0, 3.100, NULL, 1, '2020-02-20 13:43:09', '2020-02-20 13:43:09', NULL),
(126, 'SA130', 1, 'Tarte Ã©pinard', 0, 36.000, 'NB: PCS/KG â‰ƒ 42', 1, '2020-02-20 13:45:09', '2020-02-20 13:45:09', NULL),
(127, 'SA131', 1, 'Chaussant poulet', 0, 36.000, 'NB: PCS/KG â‰ƒ 56', 1, '2020-02-20 13:48:35', '2020-02-20 13:48:35', NULL),
(128, 'SA132', 1, 'FeuilletÃ© crevette ( tajin)', 0, 39.000, 'NB: PCS/KG â‰ƒ 30', 1, '2020-02-20 13:57:20', '2020-02-20 13:57:20', NULL),
(129, 'SA133', 1, 'Pizza carrÃ©e', 0, 36.000, 'NB: PCS/KG â‰ƒ 50', 1, '2020-02-20 14:02:45', '2020-02-20 14:02:45', NULL),
(130, 'SA134', 1, 'Pizza barquette', 0, 36.000, 'NB: PCS/KG â‰ƒ 50', 1, '2020-02-20 14:04:27', '2020-02-20 14:04:27', NULL),
(131, 'SA135', 1, 'Mini sandwiche au thon', 0, 36.000, 'NB: PCS/KG â‰ƒ 28', 1, '2020-02-20 14:14:23', '2020-02-20 14:14:23', NULL),
(132, 'SA136', 1, 'FeuilletÃ© bÃ©chamel /olive', 0, 36.000, 'NB: PCS/KG â‰ƒ 50', 1, '2020-02-20 14:16:17', '2020-02-20 14:16:17', NULL),
(133, 'SA137', 1, 'Bouchette piment thon', 0, 36.000, 'NB: PCS/KG â‰ƒ 42', 1, '2020-02-21 07:48:58', '2020-02-21 07:48:58', NULL),
(134, 'SA138', 1, 'BouchÃ©e goutta/ epinard', 0, 36.000, 'NB: PCS/KG â‰ƒ 45', 1, '2020-02-21 12:06:18', '2020-02-21 12:06:18', NULL),
(135, 'SA139', 1, 'Brochette samssa salÃ©e', 0, 2.800, NULL, 1, '2020-02-21 12:08:52', '2020-02-21 12:08:52', NULL),
(136, 'SA140', 1, 'RoulÃ©e', 0, 36.000, 'NB: PCS/KG â‰ƒ 41', 1, '2020-02-21 12:10:42', '2020-02-21 12:10:42', NULL),
(137, 'SA141', 1, 'Tarte goutta / thon', 0, 36.000, 'NB: PCS/KG â‰ƒ 40', 1, '2020-02-21 12:12:46', '2020-02-21 12:12:46', NULL),
(138, 'SA142', 1, 'Sorra crevette / goutta', 0, 36.000, 'NB: PCS/KG â‰ƒ 63', 1, '2020-02-21 12:14:48', '2020-02-21 12:14:48', NULL),
(139, 'SA143', 1, 'Boulette viande', 0, 39.000, 'NB: PCS/KG â‰ƒ 36', 1, '2020-02-21 12:16:08', '2020-02-21 12:16:08', NULL),
(140, 'SA144', 1, 'PÃ¢tÃ©e thon', 0, 36.000, 'NB: PCS/KG â‰ƒ 60', 1, '2020-02-21 12:18:44', '2020-02-21 12:18:44', NULL),
(141, 'SA145', 1, 'Croquette pÃ©cheur', 0, 39.000, 'NB: PCS/KG â‰ƒ 34', 1, '2020-02-21 12:21:12', '2020-02-21 12:21:12', NULL),
(142, 'SA146', 1, 'Choux salade mechouia', 0, 36.000, 'NB: PCS/KG â‰ƒ 45', 1, '2020-02-21 12:23:15', '2020-02-21 12:23:15', NULL),
(143, 'SA147', 1, 'FricassÃ©', 0, 36.000, 'NB: PCS/KG â‰ƒ 28', 1, '2020-02-21 12:25:59', '2020-02-21 12:25:59', NULL),
(144, 'SA148', 1, 'Chawarma tastira', 0, 36.000, 'NB: PCS/KG â‰ƒ 40', 1, '2020-02-24 12:54:43', '2020-02-24 12:54:43', NULL),
(145, 'SA149', 1, 'Verrines poulet champignon', 0, 2.800, NULL, 1, '2020-02-24 12:56:32', '2020-02-24 12:56:32', NULL),
(146, 'SA150', 1, 'CrÃªpe', 0, 36.000, 'NB: PCS/KG â‰ƒ33', 1, '2020-02-24 13:42:01', '2020-03-04 12:37:48', NULL),
(147, 'SA151', 1, 'Pyramide fromage', 0, 36.000, 'NB: PCS/KG â‰ƒ 45', 1, '2020-02-24 14:00:46', '2020-02-24 14:00:46', NULL),
(148, 'SA152', 1, 'Chaux spÃ©cial', 0, 39.000, 'NB: PCS/KG â‰ƒ 45', 1, '2020-02-24 14:03:12', '2020-02-24 14:03:12', NULL),
(149, 'SA153', 1, 'Verrines crevette', 0, 3.100, NULL, 1, '2020-02-24 14:05:59', '2020-02-24 14:05:59', NULL),
(150, 'SA154', 1, 'Malsouka crevette', 0, 59.000, 'NB: PCS/KG â‰ƒ 32', 1, '2020-02-24 14:10:47', '2020-02-24 14:10:47', NULL),
(151, 'SA155', 1, 'Verrine escalope fruit sec', 0, 3.100, NULL, 1, '2020-02-25 07:15:07', '2020-02-25 07:15:07', NULL),
(152, 'SA156', 1, 'Verrine saumon', 0, 3.100, NULL, 1, '2020-02-25 07:57:25', '2020-02-25 09:05:45', NULL),
(153, 'SA157', 1, 'Pizza berbÃ¨re', 0, 39.000, 'NB: PCS/KG â‰ƒ 55', 1, '2020-02-25 07:59:07', '2020-02-25 07:59:07', NULL),
(154, 'SA158', 1, 'Verrines crevette royale', 0, 4.500, NULL, 1, '2020-02-25 09:05:01', '2020-03-05 10:28:10', NULL),
(155, 'SA159', 1, 'Verrines mousse de fromage et escalope olive', 0, 3.900, NULL, 1, '2020-02-25 09:07:35', '2020-02-25 09:07:35', NULL),
(156, 'SA160', 1, 'Vol au vent crevette', 0, 36.000, 'NB: PCS/KG â‰ƒ 38', 1, '2020-02-25 09:09:28', '2020-03-04 12:33:56', NULL),
(157, 'SA161', 1, 'CanapÃ© crevette', 0, 49.000, 'NB: PCS/KG â‰ƒ 75', 1, '2020-02-25 09:10:42', '2020-02-25 09:10:42', NULL),
(158, 'SA162', 1, 'Ressort', 0, 39.000, 'NB: PCS/KG â‰ƒ 100', 1, '2020-02-25 09:11:39', '2020-02-25 09:11:39', NULL),
(159, 'SA163', 1, 'pÃ¢tÃ©e olive farcie', 0, 39.000, 'NB: PCS/KG â‰ƒ 60', 1, '2020-02-25 09:17:26', '2020-03-04 12:33:21', NULL),
(160, 'SA164', 1, 'Verrines crÃªpe aux fromage', 0, 3.100, NULL, 1, '2020-02-25 09:18:54', '2020-02-25 09:18:54', NULL),
(161, 'SA165', 1, 'Mini sandwiche hamburger', 0, 39.000, 'NB: PCS/KG â‰ƒ 24', 1, '2020-02-25 09:29:33', '2020-03-09 07:49:44', NULL),
(162, 'SA166', 1, 'Mini sandwiche escalope', 0, 39.000, 'NB: PCS/KG â‰ƒ 24', 1, '2020-02-25 09:30:56', '2020-03-09 07:50:09', NULL);

-- --------------------------------------------------------

--
-- Structure de la table `cp_product_components`
--

CREATE TABLE `cp_product_components` (
  `id` int(10) UNSIGNED NOT NULL,
  `product_id` int(10) UNSIGNED NOT NULL,
  `component_id` int(10) UNSIGNED NOT NULL,
  `price_by_size` tinyint(1) NOT NULL,
  `default_price` double(10,3) NOT NULL,
  `img` varchar(200) DEFAULT NULL,
  `default` tinyint(4) NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `cp_product_component_groups`
--

CREATE TABLE `cp_product_component_groups` (
  `id` int(10) UNSIGNED NOT NULL,
  `product_id` int(10) UNSIGNED NOT NULL,
  `component_id` int(10) UNSIGNED NOT NULL,
  `component_group_id` int(10) UNSIGNED NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '1',
  `usage` enum('O','F') NOT NULL DEFAULT 'O' COMMENT 'O: obligatoire, F: facultative',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `cp_product_component_prices`
--

CREATE TABLE `cp_product_component_prices` (
  `id` int(10) UNSIGNED NOT NULL,
  `product_component_id` int(10) UNSIGNED NOT NULL,
  `size_id` int(10) UNSIGNED NOT NULL,
  `price` double(10,3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `cp_product_imgs`
--

CREATE TABLE `cp_product_imgs` (
  `id` int(10) UNSIGNED NOT NULL,
  `product_id` int(10) UNSIGNED NOT NULL,
  `img` varchar(255) NOT NULL,
  `thumb` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `cp_product_imgs`
--

INSERT INTO `cp_product_imgs` (`id`, `product_id`, `img`, `thumb`) VALUES
(10, 10, '1579772804-cb939d7846a7141e.jpg', 0),
(16, 16, '1579785635-9f2cc24d47b9ca2e.jpg', 0),
(30, 30, '1579938723-04c56ec8dcd73b42.jpg', 0),
(49, 49, '1580729357-fc04b9a7ea480dd9.jpg', 0),
(102, 45, '1581149688-b95941836058ecf7.jpg', 0),
(138, 83, '1581152119-28f239c42c65fbc9.jpg', 0),
(151, 25, '1581420143-07ba7df13bf94a4d.jpg', 0),
(174, 24, '1581432609-5bbaf1e205d33d2f.jpg', 0),
(188, 3, '1582106659-b0f3fe144f2d3959.jpg', 0),
(189, 2, '1582106674-2f229e1c927c68e4.jpg', 0),
(191, 6, '1582106721-b9070dbb6065e236.jpg', 0),
(192, 7, '1582106739-a81a15bc59593204.jpg', 0),
(193, 8, '1582194018-1fae45febe83fbec.jpg', 0),
(194, 5, '1582194080-3a304db85560bc90.jpg', 0),
(195, 9, '1582194125-3ad84db31d167ccb.jpg', 0),
(196, 12, '1582194183-6631cd929736ea55.jpg', 0),
(198, 14, '1582194217-f26f463e10f2afe8.jpg', 0),
(199, 15, '1582194236-4d1062463fdcb3a3.jpg', 0),
(200, 18, '1582194281-bc8d49ab4c352266.jpg', 0),
(201, 19, '1582194302-6a70c9a44457d57b.jpg', 0),
(202, 20, '1582194322-b95941836058ecf7.jpg', 0),
(203, 21, '1582194342-ca2bc5f7b3c385c1.jpg', 0),
(204, 22, '1582194359-9d363a0bc798b3fe.jpg', 0),
(205, 26, '1582194421-bbcb8db011e3c785.jpg', 0),
(206, 27, '1582194463-fc75ce5578e5b321.jpg', 0),
(207, 28, '1582194480-07ba7df13bf94a4d.jpg', 0),
(208, 29, '1582194505-2d5275b418eedf79.jpg', 0),
(209, 31, '1582194622-6631cd929736ea55.jpg', 0),
(210, 32, '1582195417-bc8d49ab4c352266.jpg', 0),
(211, 33, '1582195438-6a70c9a44457d57b.jpg', 0),
(212, 34, '1582195463-5bbaf1e205d33d2f.jpg', 0),
(213, 35, '1582195486-3ad84db31d167ccb.jpg', 0),
(214, 36, '1582195504-61d4863532fcdf3d.jpg', 0),
(215, 37, '1582195547-89c1c59239194747.jpg', 0),
(216, 38, '1582195563-4a0fc61afe78645c.jpg', 0),
(217, 40, '1582195585-b9070dbb6065e236.jpg', 0),
(218, 41, '1582195631-f26f463e10f2afe8.jpg', 0),
(219, 39, '1582195667-3a304db85560bc90.jpg', 0),
(220, 42, '1582195824-3a304db85560bc90.jpg', 0),
(221, 43, '1582195865-3fa37e26bb8866b3.jpg', 0),
(222, 44, '1582195907-4a0fc61afe78645c.jpg', 0),
(223, 46, '1582195947-2d5275b418eedf79.jpg', 0),
(224, 47, '1582195975-bbcb8db011e3c785.jpg', 0),
(225, 48, '1582196001-1f089a03844b3733.jpg', 0),
(226, 50, '1582196046-a81a15bc59593204.jpg', 0),
(227, 51, '1582196080-e4658d95a1b1ae5b.jpg', 0),
(228, 52, '1582196119-6aaaaa3e35b593dc.jpg', 0),
(229, 53, '1582196150-c0446a5bb062710c.jpg', 0),
(230, 54, '1582196182-ada171e90d82fada.jpg', 0),
(231, 55, '1582196213-cbe10612bb28fef1.jpg', 0),
(232, 56, '1582196238-2f229e1c927c68e4.jpg', 0),
(233, 57, '1582196287-bf875e4a063d0f6e.jpg', 0),
(234, 58, '1582196323-b95941836058ecf7.jpg', 0),
(235, 59, '1582196354-12c9e23acf75f428.jpg', 0),
(236, 60, '1582196384-196a6a523485cf61.jpg', 0),
(237, 61, '1582196415-b9070dbb6065e236.jpg', 0),
(238, 62, '1582196442-89c1c59239194747.jpg', 0),
(239, 63, '1582196473-a7e935b7205737df.jpg', 0),
(240, 64, '1582196501-9d363a0bc798b3fe.jpg', 0),
(241, 65, '1582196532-07ba7df13bf94a4d.jpg', 0),
(242, 66, '1582196560-4d1062463fdcb3a3.jpg', 0),
(243, 67, '1582196584-5bbaf1e205d33d2f.jpg', 0),
(244, 68, '1582196612-26b9f5bf642f4bca.jpg', 0),
(245, 69, '1582196640-0babc18a6863c882.jpg', 0),
(246, 70, '1582196683-98fd5df4e1a51013.jpg', 0),
(247, 71, '1582196712-b42511a9b2ba9670.jpg', 0),
(248, 72, '1582196756-b0f3fe144f2d3959.jpg', 0),
(249, 73, '1582196790-334e0574bdb2c5d7.jpg', 0),
(251, 74, '1582196869-b9ca221d51e5edf8.jpg', 0),
(252, 75, '1582196911-6a70c9a44457d57b.jpg', 0),
(253, 76, '1582196936-992f3dfa1aa8be78.jpg', 0),
(254, 77, '1582196960-61d4863532fcdf3d.jpg', 0),
(255, 78, '1582196989-9f2cc24d47b9ca2e.jpg', 0),
(256, 79, '1582197014-bbcb8db011e3c785.jpg', 0),
(257, 80, '1582197037-28f239c42c65fbc9.jpg', 0),
(258, 81, '1582197072-f89dd62884b4928a.jpg', 0),
(259, 82, '1582197101-f26f463e10f2afe8.jpg', 0),
(260, 84, '1582197155-3ad84db31d167ccb.jpg', 0),
(261, 85, '1582197179-fc75ce5578e5b321.jpg', 0),
(262, 86, '1582197215-28556214733679cd.jpg', 0),
(263, 87, '1582197241-7d32162043bdf49f.jpg', 0),
(264, 88, '1582197269-392751a172227d65.jpg', 0),
(265, 89, '1582197308-fc04b9a7ea480dd9.jpg', 0),
(266, 90, '1582197341-6a70c9a44457d57b.jpg', 0),
(267, 91, '1582197402-6d6afe42fe5ff8e3.jpg', 0),
(268, 92, '1582197426-4e8e55e8fa38db7f.jpg', 0),
(269, 93, '1582197447-cd6015f13e12a26a.jpg', 0),
(270, 94, '1582197472-0826859a7c963c52.jpg', 0),
(271, 95, '1582197690-7b0e99cb34431254.jpg', 0),
(273, 96, '1582198067-4d1062463fdcb3a3.jpg', 0),
(274, 97, '1582198302-9d363a0bc798b3fe.jpg', 0),
(277, 100, '1582198937-ada171e90d82fada.jpg', 0),
(280, 103, '1582200166-ca2bc5f7b3c385c1.jpg', 0),
(282, 105, '1582204200-bf875e4a063d0f6e.jpg', 0),
(283, 106, '1582204363-7b0e99cb34431254.jpg', 0),
(284, 107, '1582205699-cde79a110acba199.jpg', 0),
(285, 108, '1582205801-8b3f8d9f1d8e50c6.jpg', 0),
(286, 109, '1582206069-0babc18a6863c882.jpg', 0),
(288, 111, '1582206510-6631cd929736ea55.jpg', 0),
(289, 112, '1582206604-196a6a523485cf61.jpg', 0),
(290, 113, '1582207227-4c163a194e1ad124.jpg', 0),
(292, 114, '1582207460-2f229e1c927c68e4.jpg', 0),
(293, 115, '1582207698-26b9f5bf642f4bca.jpg', 0),
(294, 116, '1582207905-7d32162043bdf49f.jpg', 0),
(295, 117, '1582208077-0d42cd9c1342cf60.jpg', 0),
(296, 118, '1582208161-8b3f8d9f1d8e50c6.jpg', 0),
(297, 119, '1582208250-07ba7df13bf94a4d.jpg', 0),
(298, 120, '1582208666-b9ca221d51e5edf8.jpg', 0),
(299, 121, '1582208834-34e511866891cbb5.jpg', 0),
(300, 122, '1582209026-a81a15bc59593204.jpg', 0),
(301, 123, '1582209337-b0f3fe144f2d3959.jpg', 0),
(302, 124, '1582209643-fc75ce5578e5b321.jpg', 0),
(303, 125, '1582209789-bbcb8db011e3c785.jpg', 0),
(304, 126, '1582209909-89c1c59239194747.jpg', 0),
(305, 127, '1582210115-28556214733679cd.jpg', 0),
(306, 128, '1582210640-ce3c560c44c02a5a.jpg', 0),
(307, 129, '1582210965-b42511a9b2ba9670.jpg', 0),
(308, 130, '1582211067-98fd5df4e1a51013.jpg', 0),
(309, 131, '1582211663-3a304db85560bc90.jpg', 0),
(310, 132, '1582211777-8a9d918d737fd140.jpg', 0),
(311, 133, '1582274938-334e0574bdb2c5d7.jpg', 0),
(312, 134, '1582290378-da5f057e39beaae2.jpg', 0),
(313, 135, '1582290532-dba93a2bc914774a.jpg', 0),
(314, 136, '1582290642-1fae45febe83fbec.jpg', 0),
(315, 137, '1582290766-0d42cd9c1342cf60.jpg', 0),
(316, 138, '1582290888-f26f463e10f2afe8.jpg', 0),
(317, 139, '1582290968-61d4863532fcdf3d.jpg', 0),
(318, 140, '1582291124-6a70c9a44457d57b.jpg', 0),
(319, 141, '1582291272-fc04b9a7ea480dd9.jpg', 0),
(320, 142, '1582291395-7a3359b02d973d64.jpg', 0),
(321, 143, '1582291559-bc8d49ab4c352266.jpg', 0),
(322, 144, '1582552483-cd6015f13e12a26a.jpg', 0),
(323, 145, '1582552592-ec7bea35f2662e71.jpg', 0),
(325, 147, '1582556446-4e8e55e8fa38db7f.jpg', 0),
(326, 148, '1582556592-5acb31db8c9dec10.jpg', 0),
(327, 149, '1582556759-1f089a03844b3733.jpg', 0),
(328, 150, '1582557047-bdd11e2efed5e37e.jpg', 0),
(329, 151, '1582618507-4a0fc61afe78645c.jpg', 0),
(331, 153, '1582621147-3fa37e26bb8866b3.jpg', 0),
(335, 152, '1582625145-cbe10612bb28fef1.jpg', 0),
(336, 155, '1582625255-90e39e12bcb7f54e.jpg', 0),
(338, 157, '1582625442-40492a21f5c12b6c.jpg', 0),
(339, 158, '1582625499-d9f425a697961c77.jpg', 0),
(341, 160, '1582625934-9ba97dee6b8041d4.jpg', 0),
(344, 4, '1583311159-ada171e90d82fada.jpg', 1),
(345, 17, '1583311294-172bfdfd24f43fde.jpg', 1),
(347, 13, '1583311349-4a0fc61afe78645c.jpg', 1),
(350, 11, '1583311457-392751a172227d65.jpg', 1),
(351, 23, '1583311520-b42511a9b2ba9670.jpg', 1),
(355, 1, '1583324223-dba93a2bc914774a.jpg', 1),
(357, 159, '1583328801-2c46a5ad9fa0f802.jpg', 1),
(358, 156, '1583328836-eac6aa1aeb00b541.jpg', 1),
(359, 146, '1583329068-6aaaaa3e35b593dc.jpg', 1),
(360, 99, '1583407436-3ad84db31d167ccb.jpg', 1),
(361, 98, '1583407464-12c9e23acf75f428.jpg', 1),
(362, 101, '1583407487-5bbaf1e205d33d2f.jpg', 1),
(363, 102, '1583407529-b95941836058ecf7.jpg', 1),
(364, 104, '1583407579-6d6afe42fe5ff8e3.jpg', 1),
(365, 110, '1583407633-a7e935b7205737df.jpg', 1),
(366, 154, '1583407690-ea09be0940db8943.jpg', 1),
(367, 161, '1583743784-557ff5a99fcefb35.jpg', 1),
(368, 162, '1583743809-faf9e9a170fbda62.jpg', 1);

-- --------------------------------------------------------

--
-- Structure de la table `cp_product_sales`
--

CREATE TABLE `cp_product_sales` (
  `id` int(10) UNSIGNED NOT NULL,
  `product_id` int(10) UNSIGNED NOT NULL,
  `company_section_id` int(10) UNSIGNED NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `cp_product_size_prices`
--

CREATE TABLE `cp_product_size_prices` (
  `id` int(10) UNSIGNED NOT NULL,
  `product_id` int(10) UNSIGNED NOT NULL,
  `size_id` int(10) UNSIGNED NOT NULL,
  `price` double(10,3) NOT NULL,
  `default` tinyint(1) NOT NULL DEFAULT '0',
  `status` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `cp_product_size_prices`
--

INSERT INTO `cp_product_size_prices` (`id`, `product_id`, `size_id`, `price`, `default`, `status`) VALUES
(190, 10, 25, 45.000, 1, 1),
(191, 10, 26, 55.000, 0, 1),
(192, 10, 27, 62.000, 0, 1),
(193, 10, 12, 74.000, 0, 1),
(194, 10, 13, 88.000, 0, 1),
(195, 10, 29, 110.000, 0, 1),
(196, 10, 8, 160.000, 0, 1),
(197, 10, 30, 210.000, 0, 1),
(198, 10, 11, 280.000, 0, 1),
(199, 10, 19, 530.000, 0, 1),
(200, 10, 40, 670.000, 0, 1),
(201, 10, 31, 880.000, 0, 1),
(202, 10, 21, 1100.000, 0, 1),
(203, 10, 22, 1360.000, 0, 1),
(204, 10, 23, 1480.000, 0, 1),
(205, 10, 24, 1680.000, 0, 1),
(206, 10, 28, 48.000, 0, 1),
(207, 10, 36, 58.000, 0, 1),
(208, 10, 37, 65.000, 0, 1),
(209, 10, 38, 77.000, 0, 1),
(210, 10, 39, 92.000, 0, 1),
(316, 16, 25, 37.000, 1, 1),
(317, 16, 26, 42.000, 0, 1),
(318, 16, 27, 48.000, 0, 1),
(319, 16, 12, 55.000, 0, 1),
(320, 16, 13, 64.000, 0, 1),
(321, 16, 29, 90.000, 0, 1),
(322, 16, 8, 130.000, 0, 1),
(323, 16, 9, 170.000, 0, 1),
(324, 16, 11, 240.000, 0, 1),
(325, 16, 19, 445.000, 0, 1),
(326, 16, 40, 550.000, 0, 1),
(327, 16, 20, 760.000, 0, 1),
(328, 16, 21, 890.000, 0, 1),
(329, 16, 22, 1040.000, 0, 1),
(330, 16, 23, 1290.000, 0, 1),
(331, 16, 24, 1460.000, 0, 1),
(332, 16, 28, 40.000, 0, 1),
(333, 16, 36, 45.000, 0, 1),
(334, 16, 37, 51.000, 0, 1),
(335, 16, 38, 58.000, 0, 1),
(336, 16, 39, 68.000, 0, 1),
(553, 30, 41, 52.000, 1, 1),
(554, 30, 42, 32.000, 0, 1),
(1129, 24, 25, 33.000, 1, 1),
(1130, 24, 26, 37.000, 0, 1),
(1131, 24, 27, 42.000, 0, 1),
(1132, 24, 12, 48.000, 0, 1),
(1133, 24, 13, 55.000, 0, 1),
(1134, 24, 29, 80.000, 0, 1),
(1135, 24, 8, 120.000, 0, 1),
(1136, 24, 9, 150.000, 0, 1),
(1137, 24, 11, 220.000, 0, 1),
(1138, 24, 19, 425.000, 0, 1),
(1139, 24, 40, 510.000, 0, 1),
(1140, 24, 31, 640.000, 0, 1),
(1141, 24, 21, 770.000, 0, 1),
(1142, 24, 22, 910.000, 0, 1),
(1143, 24, 23, 1150.000, 0, 1),
(1144, 24, 24, 1330.000, 0, 1),
(1145, 24, 28, 36.000, 0, 1),
(1146, 24, 36, 40.000, 0, 1),
(1147, 24, 37, 45.000, 0, 1),
(1148, 24, 38, 51.000, 0, 1),
(1149, 24, 39, 58.000, 0, 1),
(1197, 3, 25, 33.000, 1, 1),
(1198, 3, 26, 37.000, 0, 1),
(1199, 3, 27, 42.000, 0, 1),
(1200, 3, 12, 48.000, 0, 1),
(1201, 3, 13, 55.000, 0, 1),
(1202, 3, 29, 80.000, 0, 1),
(1203, 3, 8, 120.000, 0, 1),
(1204, 3, 30, 150.000, 0, 1),
(1205, 3, 18, 220.000, 0, 1),
(1206, 3, 19, 425.000, 0, 1),
(1207, 3, 40, 510.000, 0, 1),
(1208, 3, 31, 640.000, 0, 1),
(1209, 3, 21, 770.000, 0, 1),
(1210, 3, 22, 910.000, 0, 1),
(1211, 3, 23, 1150.000, 0, 1),
(1212, 3, 24, 1330.000, 0, 1),
(1213, 3, 28, 36.000, 0, 1),
(1214, 3, 36, 40.000, 0, 1),
(1215, 3, 37, 45.000, 0, 1),
(1216, 3, 38, 51.000, 0, 1),
(1217, 3, 39, 58.000, 0, 1),
(1218, 2, 25, 45.000, 1, 1),
(1219, 2, 26, 55.000, 0, 1),
(1220, 2, 27, 62.000, 0, 1),
(1221, 2, 12, 74.000, 0, 1),
(1222, 2, 13, 88.000, 0, 1),
(1223, 2, 29, 110.000, 0, 1),
(1224, 2, 8, 160.000, 0, 1),
(1225, 2, 9, 210.000, 0, 1),
(1226, 2, 18, 280.000, 0, 1),
(1227, 2, 19, 530.000, 0, 1),
(1228, 2, 40, 670.000, 0, 1),
(1229, 2, 31, 880.000, 0, 1),
(1230, 2, 21, 1100.000, 0, 1),
(1231, 2, 33, 1360.000, 0, 1),
(1232, 2, 23, 1480.000, 0, 1),
(1233, 2, 24, 1680.000, 0, 1),
(1234, 2, 28, 48.000, 0, 1),
(1235, 2, 36, 58.000, 0, 1),
(1236, 2, 37, 65.000, 0, 1),
(1237, 2, 38, 77.000, 0, 1),
(1238, 2, 39, 92.000, 0, 1),
(1260, 6, 25, 45.000, 1, 1),
(1261, 6, 26, 55.000, 0, 1),
(1262, 6, 27, 62.000, 0, 1),
(1263, 6, 12, 74.000, 0, 1),
(1264, 6, 13, 88.000, 0, 1),
(1265, 6, 29, 110.000, 0, 1),
(1266, 6, 8, 160.000, 0, 1),
(1267, 6, 9, 210.000, 0, 1),
(1268, 6, 11, 280.000, 0, 1),
(1269, 6, 19, 530.000, 0, 1),
(1270, 6, 40, 670.000, 0, 1),
(1271, 6, 31, 880.000, 0, 1),
(1272, 6, 21, 1100.000, 0, 1),
(1273, 6, 22, 1360.000, 0, 1),
(1274, 6, 23, 1480.000, 0, 1),
(1275, 6, 24, 1680.000, 0, 1),
(1276, 6, 28, 48.000, 0, 1),
(1277, 6, 36, 58.000, 0, 1),
(1278, 6, 37, 65.000, 0, 1),
(1279, 6, 38, 77.000, 0, 1),
(1280, 6, 39, 92.000, 0, 1),
(1281, 7, 25, 29.000, 1, 1),
(1282, 7, 26, 33.000, 0, 1),
(1283, 7, 27, 39.000, 0, 1),
(1284, 7, 12, 45.000, 0, 1),
(1285, 7, 13, 52.000, 0, 1),
(1286, 7, 29, 70.000, 0, 1),
(1287, 7, 8, 95.000, 0, 1),
(1288, 7, 9, 125.000, 0, 1),
(1289, 7, 11, 185.000, 0, 1),
(1290, 7, 19, 325.000, 0, 1),
(1291, 7, 40, 410.000, 0, 1),
(1292, 7, 31, 560.000, 0, 1),
(1293, 7, 21, 630.000, 0, 1),
(1294, 7, 22, 730.000, 0, 1),
(1295, 7, 23, 930.000, 0, 1),
(1296, 7, 24, 1160.000, 0, 1),
(1297, 7, 28, 32.000, 0, 1),
(1298, 7, 36, 36.000, 0, 1),
(1299, 7, 37, 42.000, 0, 1),
(1300, 7, 38, 48.000, 0, 1),
(1301, 7, 39, 55.000, 0, 1),
(1302, 8, 25, 29.000, 1, 1),
(1303, 8, 26, 33.000, 0, 1),
(1304, 8, 27, 39.000, 0, 1),
(1305, 8, 12, 45.000, 0, 1),
(1306, 8, 13, 52.000, 0, 1),
(1307, 8, 29, 70.000, 0, 1),
(1308, 8, 8, 95.000, 0, 1),
(1309, 8, 9, 125.000, 0, 1),
(1310, 8, 11, 185.000, 0, 1),
(1311, 8, 19, 325.000, 0, 1),
(1312, 8, 40, 410.000, 0, 1),
(1313, 8, 31, 560.000, 0, 1),
(1314, 8, 21, 630.000, 0, 1),
(1315, 8, 22, 730.000, 0, 1),
(1316, 8, 23, 930.000, 0, 1),
(1317, 8, 24, 1160.000, 0, 1),
(1318, 8, 28, 32.000, 0, 1),
(1319, 8, 36, 36.000, 0, 1),
(1320, 8, 37, 42.000, 0, 1),
(1321, 8, 38, 48.000, 0, 1),
(1322, 8, 39, 55.000, 0, 1),
(1323, 9, 25, 29.000, 1, 1),
(1324, 9, 26, 33.000, 0, 1),
(1325, 9, 27, 39.000, 0, 1),
(1326, 9, 12, 45.000, 0, 1),
(1327, 9, 13, 52.000, 0, 1),
(1328, 9, 29, 70.000, 0, 1),
(1329, 9, 8, 95.000, 0, 1),
(1330, 9, 9, 125.000, 0, 1),
(1331, 9, 11, 185.000, 0, 1),
(1332, 9, 19, 325.000, 0, 1),
(1333, 9, 40, 410.000, 0, 1),
(1334, 9, 20, 560.000, 0, 1),
(1335, 9, 21, 630.000, 0, 1),
(1336, 9, 22, 730.000, 0, 1),
(1337, 9, 23, 930.000, 0, 1),
(1338, 9, 24, 1160.000, 0, 1),
(1339, 9, 28, 32.000, 0, 1),
(1340, 9, 36, 36.000, 0, 1),
(1341, 9, 37, 42.000, 0, 1),
(1342, 9, 38, 48.000, 0, 1),
(1343, 9, 39, 55.000, 0, 1),
(1344, 12, 25, 37.000, 1, 1),
(1345, 12, 26, 42.000, 0, 1),
(1346, 12, 27, 48.000, 0, 1),
(1347, 12, 12, 55.000, 0, 1),
(1348, 12, 13, 64.000, 0, 1),
(1349, 12, 29, 90.000, 0, 1),
(1350, 12, 8, 130.000, 0, 1),
(1351, 12, 9, 170.000, 0, 1),
(1352, 12, 11, 240.000, 0, 1),
(1353, 12, 19, 445.000, 0, 1),
(1354, 12, 40, 550.000, 0, 1),
(1355, 12, 31, 760.000, 0, 1),
(1356, 12, 21, 890.000, 0, 1),
(1357, 12, 22, 1040.000, 0, 1),
(1358, 12, 23, 1290.000, 0, 1),
(1359, 12, 24, 1460.000, 0, 1),
(1360, 12, 28, 40.000, 0, 1),
(1361, 12, 36, 45.000, 0, 1),
(1362, 12, 37, 51.000, 0, 1),
(1363, 12, 38, 58.000, 0, 1),
(1364, 12, 39, 68.000, 0, 1),
(1365, 14, 25, 29.000, 1, 1),
(1366, 14, 26, 33.000, 0, 1),
(1367, 14, 27, 39.000, 0, 1),
(1368, 14, 12, 45.000, 0, 1),
(1369, 14, 13, 52.000, 0, 1),
(1370, 14, 29, 70.000, 0, 1),
(1371, 14, 8, 95.000, 0, 1),
(1372, 14, 30, 125.000, 0, 1),
(1373, 14, 11, 185.000, 0, 1),
(1374, 14, 19, 325.000, 0, 1),
(1375, 14, 40, 410.000, 0, 1),
(1376, 14, 31, 560.000, 0, 1),
(1377, 14, 21, 630.000, 0, 1),
(1378, 14, 22, 730.000, 0, 1),
(1379, 14, 23, 930.000, 0, 1),
(1380, 14, 24, 1160.000, 0, 1),
(1381, 14, 28, 32.000, 0, 1),
(1382, 14, 36, 36.000, 0, 1),
(1383, 14, 37, 42.000, 0, 1),
(1384, 14, 38, 48.000, 0, 1),
(1385, 14, 39, 55.000, 0, 1),
(1386, 15, 25, 33.000, 1, 1),
(1387, 15, 26, 37.000, 0, 1),
(1388, 15, 27, 42.000, 0, 1),
(1389, 15, 12, 48.000, 0, 1),
(1390, 15, 13, 55.000, 0, 1),
(1391, 15, 29, 80.000, 0, 1),
(1392, 15, 8, 120.000, 0, 1),
(1393, 15, 9, 150.000, 0, 1),
(1394, 15, 11, 220.000, 0, 1),
(1395, 15, 19, 425.000, 0, 1),
(1396, 15, 40, 510.000, 0, 1),
(1397, 15, 20, 640.000, 0, 1),
(1398, 15, 21, 770.000, 0, 1),
(1399, 15, 22, 910.000, 0, 1),
(1400, 15, 23, 1150.000, 0, 1),
(1401, 15, 24, 1330.000, 0, 1),
(1402, 15, 28, 36.000, 0, 1),
(1403, 15, 36, 40.000, 0, 1),
(1404, 15, 37, 45.000, 0, 1),
(1405, 15, 38, 51.000, 0, 1),
(1406, 15, 39, 58.000, 0, 1),
(1407, 18, 25, 37.000, 1, 1),
(1408, 18, 26, 42.000, 0, 1),
(1409, 18, 27, 48.000, 0, 1),
(1410, 18, 12, 55.000, 0, 1),
(1411, 18, 13, 64.000, 0, 1),
(1412, 18, 29, 90.000, 0, 1),
(1413, 18, 8, 130.000, 0, 1),
(1414, 18, 9, 170.000, 0, 1),
(1415, 18, 11, 240.000, 0, 1),
(1416, 18, 19, 445.000, 0, 1),
(1417, 18, 40, 550.000, 0, 1),
(1418, 18, 31, 760.000, 0, 1),
(1419, 18, 21, 890.000, 0, 1),
(1420, 18, 22, 1040.000, 0, 1),
(1421, 18, 23, 1290.000, 0, 1),
(1422, 18, 24, 1460.000, 0, 1),
(1423, 18, 28, 400.000, 0, 1),
(1424, 18, 36, 45.000, 0, 1),
(1425, 18, 37, 51.000, 0, 1),
(1426, 18, 38, 58.000, 0, 1),
(1427, 18, 39, 68.000, 0, 1),
(1428, 19, 25, 37.000, 1, 1),
(1429, 19, 26, 42.000, 0, 1),
(1430, 19, 27, 48.000, 0, 1),
(1431, 19, 12, 55.000, 0, 1),
(1432, 19, 13, 64.000, 0, 1),
(1433, 19, 29, 90.000, 0, 1),
(1434, 19, 8, 130.000, 0, 1),
(1435, 19, 30, 170.000, 0, 1),
(1436, 19, 11, 240.000, 0, 1),
(1437, 19, 19, 445.000, 0, 1),
(1438, 19, 40, 550.000, 0, 1),
(1439, 19, 31, 760.000, 0, 1),
(1440, 19, 21, 890.000, 0, 1),
(1441, 19, 22, 1040.000, 0, 1),
(1442, 19, 23, 1290.000, 0, 1),
(1443, 19, 24, 1460.000, 0, 1),
(1444, 19, 28, 40.000, 0, 1),
(1445, 19, 36, 45.000, 0, 1),
(1446, 19, 37, 51.000, 0, 1),
(1447, 19, 38, 58.000, 0, 1),
(1448, 19, 39, 68.000, 0, 1),
(1449, 20, 25, 33.000, 1, 1),
(1450, 20, 26, 37.000, 0, 1),
(1451, 20, 27, 42.000, 0, 1),
(1452, 20, 12, 48.000, 0, 1),
(1453, 20, 13, 55.000, 0, 1),
(1454, 20, 29, 80.000, 0, 1),
(1455, 20, 8, 120.000, 0, 1),
(1456, 20, 9, 150.000, 0, 1),
(1457, 20, 11, 220.000, 0, 1),
(1458, 20, 19, 425.000, 0, 1),
(1459, 20, 40, 510.000, 0, 1),
(1460, 20, 20, 640.000, 0, 1),
(1461, 20, 21, 770.000, 0, 1),
(1462, 20, 22, 910.000, 0, 1),
(1463, 20, 23, 1150.000, 0, 1),
(1464, 20, 24, 1330.000, 0, 1),
(1465, 20, 28, 36.000, 0, 1),
(1466, 20, 36, 40.000, 0, 1),
(1467, 20, 37, 45.000, 0, 1),
(1468, 20, 38, 51.000, 0, 1),
(1469, 20, 39, 58.000, 0, 1),
(1470, 21, 25, 29.000, 1, 1),
(1471, 21, 26, 33.000, 0, 1),
(1472, 21, 27, 39.000, 0, 1),
(1473, 21, 12, 45.000, 0, 1),
(1474, 21, 13, 52.000, 0, 1),
(1475, 21, 29, 70.000, 0, 1),
(1476, 21, 8, 95.000, 0, 1),
(1477, 21, 30, 125.000, 0, 1),
(1478, 21, 11, 185.000, 0, 1),
(1479, 21, 19, 325.000, 0, 1),
(1480, 21, 40, 410.000, 0, 1),
(1481, 21, 31, 560.000, 0, 1),
(1482, 21, 21, 630.000, 0, 1),
(1483, 21, 22, 730.000, 0, 1),
(1484, 21, 23, 930.000, 0, 1),
(1485, 21, 24, 1160.000, 0, 1),
(1486, 21, 28, 32.000, 0, 1),
(1487, 21, 36, 36.000, 0, 1),
(1488, 21, 37, 42.000, 0, 1),
(1489, 21, 38, 48.000, 0, 1),
(1490, 21, 39, 55.000, 0, 1),
(1491, 22, 25, 33.000, 1, 1),
(1492, 22, 26, 37.000, 0, 1),
(1493, 22, 27, 42.000, 0, 1),
(1494, 22, 12, 48.000, 0, 1),
(1495, 22, 13, 55.000, 0, 1),
(1496, 22, 29, 80.000, 0, 1),
(1497, 22, 8, 120.000, 0, 1),
(1498, 22, 30, 150.000, 0, 1),
(1499, 22, 11, 220.000, 0, 1),
(1500, 22, 19, 425.000, 0, 1),
(1501, 22, 40, 510.000, 0, 1),
(1502, 22, 31, 640.000, 0, 1),
(1503, 22, 21, 770.000, 0, 1),
(1504, 22, 23, 910.000, 0, 1),
(1505, 22, 22, 1150.000, 0, 1),
(1506, 22, 24, 1330.000, 0, 1),
(1507, 22, 28, 36.000, 0, 1),
(1508, 22, 36, 40.000, 0, 1),
(1509, 22, 37, 45.000, 0, 1),
(1510, 22, 38, 51.000, 0, 1),
(1511, 22, 39, 58.000, 0, 1),
(1512, 26, 25, 29.000, 1, 1),
(1513, 26, 26, 33.000, 0, 1),
(1514, 26, 27, 39.000, 0, 1),
(1515, 26, 12, 45.000, 0, 1),
(1516, 26, 13, 52.000, 0, 1),
(1517, 26, 29, 70.000, 0, 1),
(1518, 26, 8, 95.000, 0, 1),
(1519, 26, 9, 125.000, 0, 1),
(1520, 26, 11, 185.000, 0, 1),
(1521, 26, 19, 325.000, 0, 1),
(1522, 26, 40, 410.000, 0, 1),
(1523, 26, 20, 560.000, 0, 1),
(1524, 26, 21, 630.000, 0, 1),
(1525, 26, 22, 730.000, 0, 1),
(1526, 26, 23, 930.000, 0, 1),
(1527, 26, 24, 1160.000, 0, 1),
(1528, 26, 28, 32.000, 0, 1),
(1529, 26, 36, 36.000, 0, 1),
(1530, 26, 37, 42.000, 0, 1),
(1531, 26, 38, 48.000, 0, 1),
(1532, 26, 39, 55.000, 0, 1),
(1533, 27, 41, 52.000, 1, 1),
(1534, 27, 42, 32.000, 0, 1),
(1535, 28, 41, 52.000, 1, 1),
(1536, 28, 42, 32.000, 0, 1),
(1537, 29, 41, 52.000, 1, 1),
(1538, 29, 42, 32.000, 0, 1),
(1539, 31, 41, 52.000, 1, 1),
(1540, 31, 42, 32.000, 0, 1),
(1541, 32, 41, 52.000, 1, 1),
(1542, 32, 42, 32.000, 0, 1),
(1543, 33, 41, 52.000, 1, 1),
(1544, 33, 42, 32.000, 0, 1),
(1545, 34, 41, 52.000, 1, 1),
(1546, 34, 42, 32.000, 0, 1),
(1547, 35, 41, 52.000, 1, 1),
(1548, 35, 42, 32.000, 0, 1),
(1549, 36, 41, 52.000, 1, 1),
(1550, 36, 42, 32.000, 0, 1),
(1551, 37, 41, 52.000, 1, 1),
(1552, 37, 42, 32.000, 0, 1),
(1553, 38, 41, 52.000, 1, 1),
(1554, 38, 42, 32.000, 0, 1),
(1555, 40, 41, 52.000, 1, 1),
(1556, 40, 42, 32.000, 0, 1),
(1557, 41, 41, 52.000, 1, 1),
(1558, 41, 42, 32.000, 0, 1),
(1559, 39, 41, 52.000, 1, 1),
(1560, 39, 42, 32.000, 0, 1),
(1582, 4, 25, 45.000, 1, 1),
(1583, 4, 26, 55.000, 0, 1),
(1584, 4, 27, 62.000, 0, 1),
(1585, 4, 12, 74.000, 0, 1),
(1586, 4, 13, 88.000, 0, 1),
(1587, 4, 29, 110.000, 0, 1),
(1588, 4, 8, 160.000, 0, 1),
(1589, 4, 9, 210.000, 0, 1),
(1590, 4, 11, 280.000, 0, 1),
(1591, 4, 19, 530.000, 0, 1),
(1592, 4, 40, 67.000, 0, 1),
(1593, 4, 31, 880.000, 0, 1),
(1594, 4, 21, 1100.000, 0, 1),
(1595, 4, 22, 1360.000, 0, 1),
(1596, 4, 23, 1480.000, 0, 1),
(1597, 4, 24, 1680.000, 0, 1),
(1598, 4, 28, 48.000, 0, 1),
(1599, 4, 36, 58.000, 0, 1),
(1600, 4, 37, 65.000, 0, 1),
(1601, 4, 38, 77.000, 0, 1),
(1602, 4, 39, 92.000, 0, 1),
(1603, 17, 25, 37.000, 1, 1),
(1604, 17, 26, 42.000, 0, 1),
(1605, 17, 27, 48.000, 0, 1),
(1606, 17, 12, 55.000, 0, 1),
(1607, 17, 13, 64.000, 0, 1),
(1608, 17, 29, 90.000, 0, 1),
(1609, 17, 8, 130.000, 0, 1),
(1610, 17, 9, 170.000, 0, 1),
(1611, 17, 11, 240.000, 0, 1),
(1612, 17, 19, 445.000, 0, 1),
(1613, 17, 40, 550.000, 0, 1),
(1614, 17, 31, 760.000, 0, 1),
(1615, 17, 21, 890.000, 0, 1),
(1616, 17, 22, 1040.000, 0, 1),
(1617, 17, 23, 1290.000, 0, 1),
(1618, 17, 24, 1460.000, 0, 1),
(1619, 17, 28, 40.000, 0, 1),
(1620, 17, 36, 45.000, 0, 1),
(1621, 17, 37, 51.000, 0, 1),
(1622, 17, 38, 58.000, 0, 1),
(1623, 17, 39, 68.000, 0, 1),
(1624, 23, 25, 33.000, 1, 1),
(1625, 23, 26, 37.000, 0, 1),
(1626, 23, 27, 42.000, 0, 1),
(1627, 23, 12, 48.000, 0, 1),
(1628, 23, 13, 55.000, 0, 1),
(1629, 23, 29, 80.000, 0, 1),
(1630, 23, 8, 120.000, 0, 1),
(1631, 23, 9, 150.000, 0, 1),
(1632, 23, 11, 220.000, 0, 1),
(1633, 23, 19, 425.000, 0, 1),
(1634, 23, 40, 510.000, 0, 1),
(1635, 23, 31, 640.000, 0, 1),
(1636, 23, 21, 770.000, 0, 1),
(1637, 23, 22, 910.000, 0, 1),
(1638, 23, 34, 1150.000, 0, 1),
(1639, 23, 24, 1330.000, 0, 1),
(1640, 23, 28, 36.000, 0, 1),
(1641, 23, 36, 40.000, 0, 1),
(1642, 23, 37, 45.000, 0, 1),
(1643, 23, 38, 51.000, 0, 1),
(1644, 23, 39, 58.000, 0, 1),
(1708, 1, 25, 33.000, 1, 1),
(1709, 1, 26, 37.000, 0, 1),
(1710, 1, 27, 42.000, 0, 1),
(1711, 1, 12, 48.000, 0, 1),
(1712, 1, 13, 55.000, 0, 1),
(1713, 1, 29, 80.000, 0, 1),
(1714, 1, 8, 120.000, 0, 1),
(1715, 1, 30, 150.000, 0, 1),
(1716, 1, 11, 220.000, 0, 1),
(1717, 1, 19, 425.000, 0, 1),
(1718, 1, 40, 510.000, 0, 1),
(1719, 1, 31, 640.000, 0, 1),
(1720, 1, 21, 770.000, 0, 1),
(1721, 1, 22, 910.000, 0, 1),
(1722, 1, 34, 1150.000, 0, 1),
(1723, 1, 35, 1330.000, 0, 1),
(1724, 1, 28, 36.000, 0, 1),
(1725, 1, 36, 40.000, 0, 1),
(1726, 1, 37, 45.000, 0, 1),
(1727, 1, 38, 51.000, 0, 1),
(1728, 1, 39, 58.000, 0, 1);

-- --------------------------------------------------------

--
-- Structure de la table `cp_product_tags`
--

CREATE TABLE `cp_product_tags` (
  `id` int(10) UNSIGNED NOT NULL,
  `product_id` int(10) UNSIGNED NOT NULL,
  `tag_id` int(10) UNSIGNED NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `cp_product_tags`
--

INSERT INTO `cp_product_tags` (`id`, `product_id`, `tag_id`, `status`, `created_at`, `updated_at`) VALUES
(5, 5, 3, 1, NULL, NULL),
(10, 10, 3, 1, NULL, NULL),
(11, 11, 3, 1, NULL, NULL),
(13, 13, 3, 1, NULL, NULL),
(16, 16, 3, 1, NULL, NULL),
(25, 25, 3, 1, NULL, NULL),
(30, 30, 4, 1, NULL, NULL),
(51, 49, 6, 1, NULL, NULL),
(104, 45, 6, 1, NULL, NULL),
(140, 83, 6, 1, NULL, NULL),
(168, 24, 3, 1, NULL, NULL),
(184, 3, 3, 1, NULL, NULL),
(185, 2, 3, 1, NULL, NULL),
(187, 6, 3, 1, NULL, NULL),
(188, 7, 3, 1, NULL, NULL),
(189, 8, 3, 1, NULL, NULL),
(190, 9, 3, 1, NULL, NULL),
(191, 12, 3, 1, NULL, NULL),
(192, 14, 3, 1, NULL, NULL),
(193, 15, 3, 1, NULL, NULL),
(194, 18, 3, 1, NULL, NULL),
(195, 19, 3, 1, NULL, NULL),
(196, 20, 3, 1, NULL, NULL),
(197, 21, 3, 1, NULL, NULL),
(198, 22, 3, 1, NULL, NULL),
(199, 26, 3, 1, NULL, NULL),
(200, 27, 4, 1, NULL, NULL),
(201, 28, 4, 1, NULL, NULL),
(202, 29, 4, 1, NULL, NULL),
(203, 31, 4, 1, NULL, NULL),
(204, 32, 4, 1, NULL, NULL),
(205, 33, 4, 1, NULL, NULL),
(206, 34, 4, 1, NULL, NULL),
(207, 35, 4, 1, NULL, NULL),
(208, 36, 4, 1, NULL, NULL),
(209, 37, 4, 1, NULL, NULL),
(210, 38, 3, 1, NULL, NULL),
(211, 38, 4, 1, NULL, NULL),
(212, 40, 4, 1, NULL, NULL),
(213, 41, 4, 1, NULL, NULL),
(214, 39, 4, 1, NULL, NULL),
(215, 42, 6, 1, NULL, NULL),
(216, 43, 6, 1, NULL, NULL),
(217, 44, 6, 1, NULL, NULL),
(218, 46, 6, 1, NULL, NULL),
(219, 47, 6, 1, NULL, NULL),
(220, 48, 6, 1, NULL, NULL),
(221, 50, 6, 1, NULL, NULL),
(222, 51, 6, 1, NULL, NULL),
(223, 52, 6, 1, NULL, NULL),
(224, 53, 6, 1, NULL, NULL),
(225, 54, 6, 1, NULL, NULL),
(226, 55, 6, 1, NULL, NULL),
(227, 56, 6, 1, NULL, NULL),
(228, 57, 6, 1, NULL, NULL),
(229, 58, 6, 1, NULL, NULL),
(230, 59, 6, 1, NULL, NULL),
(231, 60, 6, 1, NULL, NULL),
(232, 61, 6, 1, NULL, NULL),
(233, 62, 6, 1, NULL, NULL),
(234, 63, 6, 1, NULL, NULL),
(235, 64, 6, 1, NULL, NULL),
(236, 65, 6, 1, NULL, NULL),
(237, 66, 6, 1, NULL, NULL),
(238, 67, 6, 1, NULL, NULL),
(239, 68, 6, 1, NULL, NULL),
(240, 69, 6, 1, NULL, NULL),
(241, 70, 6, 1, NULL, NULL),
(243, 71, 6, 1, NULL, NULL),
(244, 72, 6, 1, NULL, NULL),
(245, 73, 6, 1, NULL, NULL),
(247, 74, 6, 1, NULL, NULL),
(248, 75, 6, 1, NULL, NULL),
(249, 76, 6, 1, NULL, NULL),
(250, 77, 6, 1, NULL, NULL),
(251, 78, 6, 1, NULL, NULL),
(252, 79, 6, 1, NULL, NULL),
(253, 80, 6, 1, NULL, NULL),
(254, 81, 6, 1, NULL, NULL),
(255, 82, 6, 1, NULL, NULL),
(256, 84, 6, 1, NULL, NULL),
(257, 85, 6, 1, NULL, NULL),
(258, 86, 6, 1, NULL, NULL),
(259, 87, 6, 1, NULL, NULL),
(260, 88, 6, 1, NULL, NULL),
(261, 89, 6, 1, NULL, NULL),
(262, 90, 6, 1, NULL, NULL),
(263, 91, 6, 1, NULL, NULL),
(264, 92, 6, 1, NULL, NULL),
(265, 93, 6, 1, NULL, NULL),
(266, 94, 6, 1, NULL, NULL),
(267, 95, 6, 1, NULL, NULL),
(269, 96, 7, 1, NULL, NULL),
(270, 97, 7, 1, NULL, NULL),
(273, 100, 7, 1, NULL, NULL),
(276, 103, 6, 1, NULL, NULL),
(278, 105, 7, 1, NULL, NULL),
(279, 106, 7, 1, NULL, NULL),
(280, 107, 7, 1, NULL, NULL),
(281, 108, 7, 1, NULL, NULL),
(282, 109, 7, 1, NULL, NULL),
(284, 111, 7, 1, NULL, NULL),
(285, 112, 7, 1, NULL, NULL),
(286, 113, 7, 1, NULL, NULL),
(288, 114, 7, 1, NULL, NULL),
(289, 115, 7, 1, NULL, NULL),
(290, 116, 7, 1, NULL, NULL),
(291, 117, 7, 1, NULL, NULL),
(292, 118, 7, 1, NULL, NULL),
(293, 119, 7, 1, NULL, NULL),
(294, 120, 7, 1, NULL, NULL),
(295, 121, 7, 1, NULL, NULL),
(296, 122, 7, 1, NULL, NULL),
(297, 123, 7, 1, NULL, NULL),
(298, 124, 7, 1, NULL, NULL),
(299, 125, 7, 1, NULL, NULL),
(300, 126, 7, 1, NULL, NULL),
(301, 127, 7, 1, NULL, NULL),
(302, 128, 7, 1, NULL, NULL),
(303, 129, 7, 1, NULL, NULL),
(304, 130, 7, 1, NULL, NULL),
(305, 131, 7, 1, NULL, NULL),
(306, 132, 7, 1, NULL, NULL),
(307, 133, 7, 1, NULL, NULL),
(308, 134, 7, 1, NULL, NULL),
(309, 135, 7, 1, NULL, NULL),
(310, 136, 7, 1, NULL, NULL),
(311, 137, 7, 1, NULL, NULL),
(312, 138, 7, 1, NULL, NULL),
(313, 139, 7, 1, NULL, NULL),
(314, 140, 7, 1, NULL, NULL),
(315, 141, 7, 1, NULL, NULL),
(316, 142, 7, 1, NULL, NULL),
(317, 143, 7, 1, NULL, NULL),
(318, 144, 7, 1, NULL, NULL),
(319, 145, 7, 1, NULL, NULL),
(321, 147, 7, 1, NULL, NULL),
(322, 148, 7, 1, NULL, NULL),
(323, 149, 7, 1, NULL, NULL),
(324, 150, 7, 1, NULL, NULL),
(325, 151, 7, 1, NULL, NULL),
(327, 153, 7, 1, NULL, NULL),
(331, 152, 7, 1, NULL, NULL),
(332, 155, 7, 1, NULL, NULL),
(334, 157, 7, 1, NULL, NULL),
(335, 158, 7, 1, NULL, NULL),
(337, 160, 7, 1, NULL, NULL),
(341, 4, 3, 1, NULL, NULL),
(342, 17, 3, 1, NULL, NULL),
(343, 23, 3, 1, NULL, NULL),
(347, 1, 3, 1, NULL, NULL),
(349, 159, 7, 1, NULL, NULL),
(350, 156, 7, 1, NULL, NULL),
(351, 146, 7, 1, NULL, NULL),
(352, 99, 7, 1, NULL, NULL),
(353, 98, 7, 1, NULL, NULL),
(354, 101, 7, 1, NULL, NULL),
(355, 102, 7, 1, NULL, NULL),
(356, 104, 7, 1, NULL, NULL),
(357, 110, 7, 1, NULL, NULL),
(358, 154, 7, 1, NULL, NULL),
(359, 161, 7, 1, NULL, NULL),
(360, 162, 7, 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `cp_sizes`
--

CREATE TABLE `cp_sizes` (
  `id` int(10) UNSIGNED NOT NULL,
  `company_id` int(10) UNSIGNED NOT NULL,
  `size_name` varchar(200) NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `cp_sizes`
--

INSERT INTO `cp_sizes` (`id`, `company_id`, `size_name`, `status`, `created_at`, `updated_at`) VALUES
(1, 1, '20/20', 1, '2020-01-18 06:53:56', '2020-01-27 09:36:47'),
(2, 1, '30/30-H4', 1, '2020-01-18 10:33:45', '2020-01-18 10:33:45'),
(3, 1, '30/40-H4', 1, '2020-01-18 10:34:24', '2020-01-18 10:34:24'),
(4, 1, '40/40-H4', 1, '2020-01-18 10:34:40', '2020-01-18 10:34:40'),
(5, 1, '60/40-H4', 1, '2020-01-18 10:34:57', '2020-01-18 10:34:57'),
(6, 1, '20/30-H5', 1, '2020-01-18 10:35:46', '2020-01-18 10:35:46'),
(7, 1, '30/30-H5', 1, '2020-01-18 10:36:04', '2020-01-18 10:36:04'),
(8, 1, '30/40', 1, '2020-01-18 10:36:15', '2020-01-21 09:49:52'),
(9, 1, '40/40', 1, '2020-01-18 10:36:24', '2020-01-21 09:49:37'),
(11, 1, '60/40', 1, '2020-01-18 10:42:36', '2020-01-21 09:49:11'),
(12, 1, 'Ã˜24cm', 1, '2020-01-18 10:49:42', '2020-01-27 09:37:14'),
(13, 1, 'Ã˜28-H3.5', 1, '2020-01-18 10:49:54', '2020-01-18 10:49:54'),
(14, 1, 'Ã˜24-H6', 1, '2020-01-18 10:50:15', '2020-01-18 10:50:15'),
(15, 1, 'Ã˜24-H5', 1, '2020-01-21 08:58:38', '2020-01-21 08:58:38'),
(16, 1, 'Ã˜28-H5', 1, '2020-01-21 08:59:03', '2020-01-21 08:59:03'),
(17, 1, 'Ã˜28-H6', 1, '2020-01-21 09:47:35', '2020-01-21 09:47:35'),
(18, 1, '60/40', 1, '2020-01-21 09:47:43', '2020-01-21 09:47:43'),
(19, 1, '60/60', 1, '2020-01-21 09:51:14', '2020-01-21 09:51:14'),
(20, 1, '80/80', 1, '2020-01-21 09:51:21', '2020-01-21 09:51:21'),
(21, 1, '1m/80cm', 1, '2020-01-21 09:51:50', '2020-01-21 09:51:50'),
(22, 1, '1m/1m', 1, '2020-01-21 09:52:07', '2020-01-21 09:52:07'),
(23, 1, '1m/1.2m', 1, '2020-01-21 09:52:17', '2020-01-21 09:52:17'),
(24, 1, '1.2m/1.2m', 1, '2020-01-21 09:52:34', '2020-01-21 09:52:34'),
(25, 1, 'Ã˜18(6p)', 1, '2020-01-21 09:53:14', '2020-01-21 09:53:14'),
(26, 1, 'Ã˜20(8p)', 1, '2020-01-21 09:53:54', '2020-01-21 09:53:54'),
(27, 1, 'Ã˜22(10p)', 1, '2020-01-21 09:54:34', '2020-01-21 09:54:34'),
(28, 1, 'â™¥ (6p)', 1, '2020-01-21 09:57:37', '2020-01-21 09:57:37'),
(29, 1, '30/30cm', 1, '2020-01-22 12:35:35', '2020-01-27 09:45:58'),
(30, 1, '40/40', 1, '2020-01-22 12:35:58', '2020-01-22 12:35:58'),
(31, 1, '80/80', 1, '2020-01-22 12:36:21', '2020-01-22 12:36:21'),
(32, 1, '1m/80cm', 1, '2020-01-22 12:36:37', '2020-01-22 12:36:37'),
(33, 1, '1m/1m', 1, '2020-01-22 12:36:53', '2020-01-22 12:36:53'),
(34, 1, '1m/1.2m', 1, '2020-01-22 12:37:04', '2020-01-22 12:37:04'),
(35, 1, '1.2m/1.2m', 1, '2020-01-22 12:37:13', '2020-01-22 12:37:13'),
(36, 1, 'â™¥(8p)', 1, '2020-01-22 12:38:11', '2020-01-22 12:38:11'),
(37, 1, 'â™¥(10)', 1, '2020-01-22 12:38:22', '2020-01-22 12:38:22'),
(38, 1, 'â™¥(12)', 1, '2020-01-22 12:38:46', '2020-01-22 12:38:46'),
(39, 1, 'â™¥(15)', 1, '2020-01-22 12:38:59', '2020-01-22 12:38:59'),
(40, 1, '60/80', 1, '2020-01-22 12:44:49', '2020-01-22 12:44:49'),
(41, 1, 'GM', 1, '2020-01-24 12:06:24', '2020-01-24 12:06:24'),
(42, 1, 'MM', 1, '2020-01-24 12:06:34', '2020-01-24 12:06:34'),
(43, 1, '2 Ã‰TAGE (30H10/24H10)', 1, '2020-01-27 12:17:33', '2020-01-27 12:19:22');

-- --------------------------------------------------------

--
-- Structure de la table `cp_tags`
--

CREATE TABLE `cp_tags` (
  `id` int(10) UNSIGNED NOT NULL,
  `company_id` int(10) UNSIGNED NOT NULL,
  `name` varchar(100) NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `cp_tags`
--

INSERT INTO `cp_tags` (`id`, `company_id`, `name`, `status`, `created_at`, `updated_at`) VALUES
(3, 1, 'Entremet', 1, '2020-01-18 06:49:48', '2020-01-18 06:49:48'),
(4, 1, 'Buches', 1, '2020-01-24 10:06:27', '2020-01-24 10:06:27'),
(5, 1, 'GÃ¢teaux anniversaire enfants', 1, '2020-01-27 07:00:18', '2020-01-27 07:00:18'),
(6, 1, 'GÃ¢teaux tunisien', 1, '2020-02-01 10:30:37', '2020-02-01 10:30:37'),
(7, 1, 'Sales', 1, '2020-02-13 07:02:20', '2020-02-13 07:02:20');

-- --------------------------------------------------------

--
-- Structure de la table `cp_users`
--

CREATE TABLE `cp_users` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `phone` int(10) UNSIGNED DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `status` tinyint(3) UNSIGNED NOT NULL DEFAULT '1' COMMENT '1: Active, 0: Blocked',
  `is_admin` tinyint(4) NOT NULL DEFAULT '0',
  `last_login` datetime DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `cp_users`
--

INSERT INTO `cp_users` (`id`, `name`, `username`, `email`, `phone`, `password`, `status`, `is_admin`, `last_login`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'ABS Administrator', 'abs_administrator', NULL, 11111111, '$2y$10$XVhxM.7GP3KO1efgsHkwce9WTQexkjirBvJzkFuRxeGbtR9huiJRm', 1, 1, NULL, 'Nl8iErH7AWIyQVxuTIemuF9miuNCu43gMsaILtWRF7Tk1SGrwHueNbTKvk8p', NULL, NULL),
(2, 'Admin Takacim', 'takacim', NULL, 0, '$2y$10$9Tvf9s7crQ5Qwmf5xkchZeCEm1A2XTgK.A23ey9CqALEYHN7KyHEm', 1, 0, NULL, 'vFFBrG1vAoi7EPC86ZhUawnxujMRnvvNNd2QT1vWvIevKIPU3oGolo0odkep', '2020-03-11 08:02:42', '2020-03-11 08:02:42'),
(3, 'vendeuse test', 'vendeuse', NULL, 22222222, '$2y$10$ldmfNCRW9DE//Q.K7Wax.O7FjhvdYq.G5M.X4xfhtVNgZV3e0I0QO', 1, 0, NULL, 'XgoDpE0nvFs8pIcPzsmDRhkYTHQME8HQhbvickT3qnlAZmI3WgRC5lpVjfcM', '2020-03-11 09:19:06', '2020-03-11 09:19:06');

-- --------------------------------------------------------

--
-- Structure de la table `cp_user_permissions`
--

CREATE TABLE `cp_user_permissions` (
  `id` int(10) UNSIGNED NOT NULL,
  `group_id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `cp_user_permissions`
--

INSERT INTO `cp_user_permissions` (`id`, `group_id`, `user_id`, `status`, `created_at`, `updated_at`) VALUES
(1, 1, 2, 1, '2020-03-11 08:03:05', '2020-03-11 08:03:05'),
(2, 2, 3, 1, '2020-03-11 09:19:40', '2020-03-11 09:19:40');

-- --------------------------------------------------------

--
-- Structure de la table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `cp_administrators`
--
ALTER TABLE `cp_administrators`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `administrators_email_unique` (`email`);

--
-- Index pour la table `cp_company`
--
ALTER TABLE `cp_company`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `cp_company_administrations`
--
ALTER TABLE `cp_company_administrations`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `company_administrations_email_unique` (`email`),
  ADD UNIQUE KEY `company_administrations_phone_unique` (`phone`),
  ADD KEY `company_administrations_company_id_foreign` (`company_id`);

--
-- Index pour la table `cp_company_sections`
--
ALTER TABLE `cp_company_sections`
  ADD PRIMARY KEY (`id`),
  ADD KEY `company_sections_company_id_foreign` (`company_id`);

--
-- Index pour la table `cp_company_users`
--
ALTER TABLE `cp_company_users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `company_users_company_section_id_foreign` (`company_section_id`),
  ADD KEY `company_users_user_id_foreign` (`user_id`);

--
-- Index pour la table `cp_components`
--
ALTER TABLE `cp_components`
  ADD PRIMARY KEY (`id`),
  ADD KEY `components_company_id_foreign` (`company_id`);

--
-- Index pour la table `cp_component_groups`
--
ALTER TABLE `cp_component_groups`
  ADD PRIMARY KEY (`id`),
  ADD KEY `component_groups_company_id_foreign` (`company_id`);

--
-- Index pour la table `cp_customers`
--
ALTER TABLE `cp_customers`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `cp_group_permissions`
--
ALTER TABLE `cp_group_permissions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `group_permissions_company_id_foreign` (`company_id`);

--
-- Index pour la table `cp_migrations`
--
ALTER TABLE `cp_migrations`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `cp_modules`
--
ALTER TABLE `cp_modules`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `cp_module_groups`
--
ALTER TABLE `cp_module_groups`
  ADD PRIMARY KEY (`id`),
  ADD KEY `module_groups_module_id_foreign` (`module_id`),
  ADD KEY `module_groups_group_id_foreign` (`group_id`);

--
-- Index pour la table `cp_orders`
--
ALTER TABLE `cp_orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `orders_customer_id_foreign` (`customer_id`),
  ADD KEY `orders_company_id_foreign` (`company_id`);

--
-- Index pour la table `cp_products`
--
ALTER TABLE `cp_products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `products_company_id_foreign` (`company_id`);

--
-- Index pour la table `cp_product_components`
--
ALTER TABLE `cp_product_components`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_components_product_id_foreign` (`product_id`),
  ADD KEY `product_components_component_id_foreign` (`component_id`);

--
-- Index pour la table `cp_product_component_groups`
--
ALTER TABLE `cp_product_component_groups`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_component_groups_product_id_foreign` (`product_id`),
  ADD KEY `product_component_groups_component_id_foreign` (`component_id`),
  ADD KEY `product_component_groups_component_group_id_foreign` (`component_group_id`);

--
-- Index pour la table `cp_product_component_prices`
--
ALTER TABLE `cp_product_component_prices`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_component_prices_product_component_id_foreign` (`product_component_id`),
  ADD KEY `product_component_prices_size_id_foreign` (`size_id`);

--
-- Index pour la table `cp_product_imgs`
--
ALTER TABLE `cp_product_imgs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_imgs_product_id_foreign` (`product_id`);

--
-- Index pour la table `cp_product_sales`
--
ALTER TABLE `cp_product_sales`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_sales_product_id_foreign` (`product_id`),
  ADD KEY `product_sales_company_section_id_foreign` (`company_section_id`);

--
-- Index pour la table `cp_product_size_prices`
--
ALTER TABLE `cp_product_size_prices`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_size_prices_product_id_foreign` (`product_id`),
  ADD KEY `product_size_prices_size_id_foreign` (`size_id`);

--
-- Index pour la table `cp_product_tags`
--
ALTER TABLE `cp_product_tags`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_tags_product_id_foreign` (`product_id`),
  ADD KEY `product_tags_tag_id_foreign` (`tag_id`);

--
-- Index pour la table `cp_sizes`
--
ALTER TABLE `cp_sizes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sizes_company_id_foreign` (`company_id`);

--
-- Index pour la table `cp_tags`
--
ALTER TABLE `cp_tags`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tags_company_id_foreign` (`company_id`);

--
-- Index pour la table `cp_users`
--
ALTER TABLE `cp_users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_username_unique` (`username`),
  ADD UNIQUE KEY `users_phone_unique` (`phone`) USING BTREE;

--
-- Index pour la table `cp_user_permissions`
--
ALTER TABLE `cp_user_permissions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_permissions_user_id_foreign` (`user_id`),
  ADD KEY `user_permissions_group_id_foreign` (`group_id`);

--
-- Index pour la table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `cp_administrators`
--
ALTER TABLE `cp_administrators`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `cp_company`
--
ALTER TABLE `cp_company`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `cp_company_administrations`
--
ALTER TABLE `cp_company_administrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `cp_company_sections`
--
ALTER TABLE `cp_company_sections`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `cp_company_users`
--
ALTER TABLE `cp_company_users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT pour la table `cp_components`
--
ALTER TABLE `cp_components`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `cp_component_groups`
--
ALTER TABLE `cp_component_groups`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `cp_customers`
--
ALTER TABLE `cp_customers`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `cp_group_permissions`
--
ALTER TABLE `cp_group_permissions`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `cp_migrations`
--
ALTER TABLE `cp_migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

--
-- AUTO_INCREMENT pour la table `cp_modules`
--
ALTER TABLE `cp_modules`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT pour la table `cp_module_groups`
--
ALTER TABLE `cp_module_groups`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT pour la table `cp_orders`
--
ALTER TABLE `cp_orders`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `cp_products`
--
ALTER TABLE `cp_products`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=163;

--
-- AUTO_INCREMENT pour la table `cp_product_components`
--
ALTER TABLE `cp_product_components`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `cp_product_component_groups`
--
ALTER TABLE `cp_product_component_groups`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `cp_product_component_prices`
--
ALTER TABLE `cp_product_component_prices`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `cp_product_imgs`
--
ALTER TABLE `cp_product_imgs`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=369;

--
-- AUTO_INCREMENT pour la table `cp_product_sales`
--
ALTER TABLE `cp_product_sales`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `cp_product_size_prices`
--
ALTER TABLE `cp_product_size_prices`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1729;

--
-- AUTO_INCREMENT pour la table `cp_product_tags`
--
ALTER TABLE `cp_product_tags`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=361;

--
-- AUTO_INCREMENT pour la table `cp_sizes`
--
ALTER TABLE `cp_sizes`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- AUTO_INCREMENT pour la table `cp_tags`
--
ALTER TABLE `cp_tags`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT pour la table `cp_users`
--
ALTER TABLE `cp_users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT pour la table `cp_user_permissions`
--
ALTER TABLE `cp_user_permissions`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `cp_company_administrations`
--
ALTER TABLE `cp_company_administrations`
  ADD CONSTRAINT `company_administrations_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `cp_company` (`id`);

--
-- Contraintes pour la table `cp_company_sections`
--
ALTER TABLE `cp_company_sections`
  ADD CONSTRAINT `company_sections_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `cp_company` (`id`);

--
-- Contraintes pour la table `cp_company_users`
--
ALTER TABLE `cp_company_users`
  ADD CONSTRAINT `company_users_company_section_id_foreign` FOREIGN KEY (`company_section_id`) REFERENCES `cp_company_sections` (`id`),
  ADD CONSTRAINT `company_users_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `cp_users` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `cp_components`
--
ALTER TABLE `cp_components`
  ADD CONSTRAINT `components_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `cp_company` (`id`);

--
-- Contraintes pour la table `cp_component_groups`
--
ALTER TABLE `cp_component_groups`
  ADD CONSTRAINT `component_groups_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `cp_company` (`id`);

--
-- Contraintes pour la table `cp_group_permissions`
--
ALTER TABLE `cp_group_permissions`
  ADD CONSTRAINT `group_permissions_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `cp_company` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `cp_module_groups`
--
ALTER TABLE `cp_module_groups`
  ADD CONSTRAINT `module_groups_group_id_foreign` FOREIGN KEY (`group_id`) REFERENCES `cp_group_permissions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `module_groups_module_id_foreign` FOREIGN KEY (`module_id`) REFERENCES `cp_modules` (`id`);

--
-- Contraintes pour la table `cp_orders`
--
ALTER TABLE `cp_orders`
  ADD CONSTRAINT `orders_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `cp_company` (`id`),
  ADD CONSTRAINT `orders_customer_id_foreign` FOREIGN KEY (`customer_id`) REFERENCES `cp_customers` (`id`);

--
-- Contraintes pour la table `cp_products`
--
ALTER TABLE `cp_products`
  ADD CONSTRAINT `products_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `cp_company` (`id`);

--
-- Contraintes pour la table `cp_product_components`
--
ALTER TABLE `cp_product_components`
  ADD CONSTRAINT `product_components_component_id_foreign` FOREIGN KEY (`component_id`) REFERENCES `cp_components` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `product_components_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `cp_products` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `cp_product_component_groups`
--
ALTER TABLE `cp_product_component_groups`
  ADD CONSTRAINT `product_component_groups_component_group_id_foreign` FOREIGN KEY (`component_group_id`) REFERENCES `cp_component_groups` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `product_component_groups_component_id_foreign` FOREIGN KEY (`component_id`) REFERENCES `cp_components` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `product_component_groups_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `cp_products` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `cp_product_component_prices`
--
ALTER TABLE `cp_product_component_prices`
  ADD CONSTRAINT `product_component_prices_product_component_id_foreign` FOREIGN KEY (`product_component_id`) REFERENCES `cp_product_components` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `product_component_prices_size_id_foreign` FOREIGN KEY (`size_id`) REFERENCES `cp_sizes` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `cp_product_imgs`
--
ALTER TABLE `cp_product_imgs`
  ADD CONSTRAINT `product_imgs_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `cp_products` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `cp_product_sales`
--
ALTER TABLE `cp_product_sales`
  ADD CONSTRAINT `product_sales_company_section_id_foreign` FOREIGN KEY (`company_section_id`) REFERENCES `cp_company_sections` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `product_sales_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `cp_products` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `cp_product_size_prices`
--
ALTER TABLE `cp_product_size_prices`
  ADD CONSTRAINT `product_size_prices_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `cp_products` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `product_size_prices_size_id_foreign` FOREIGN KEY (`size_id`) REFERENCES `cp_sizes` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `cp_product_tags`
--
ALTER TABLE `cp_product_tags`
  ADD CONSTRAINT `product_tags_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `cp_products` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `product_tags_tag_id_foreign` FOREIGN KEY (`tag_id`) REFERENCES `cp_tags` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `cp_sizes`
--
ALTER TABLE `cp_sizes`
  ADD CONSTRAINT `sizes_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `cp_company` (`id`);

--
-- Contraintes pour la table `cp_tags`
--
ALTER TABLE `cp_tags`
  ADD CONSTRAINT `tags_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `cp_company` (`id`);

--
-- Contraintes pour la table `cp_user_permissions`
--
ALTER TABLE `cp_user_permissions`
  ADD CONSTRAINT `user_permissions_group_id_foreign` FOREIGN KEY (`group_id`) REFERENCES `cp_group_permissions` (`id`),
  ADD CONSTRAINT `user_permissions_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `cp_users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
