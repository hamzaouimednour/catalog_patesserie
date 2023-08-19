-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le :  ven. 17 jan. 2020 à 10:59
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
-- Base de données :  `catalog_patisserie`
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
  `status` int(10) UNSIGNED NOT NULL DEFAULT '1' COMMENT '1: Active, 0: Inactive',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `cp_company`
--

INSERT INTO `cp_company` (`id`, `company_name`, `description`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Takacim', '', 1, '2019-12-25 03:13:17', '2019-12-26 13:25:56');

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
  `name` varchar(255) DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `editor` tinyint(1) NOT NULL DEFAULT '0',
  `status` tinyint(3) UNSIGNED NOT NULL DEFAULT '1' COMMENT '1: Active, 0: Blocked',
  `last_login` datetime DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `cp_company_users`
--

INSERT INTO `cp_company_users` (`id`, `company_section_id`, `name`, `email`, `phone`, `password`, `editor`, `status`, `last_login`, `created_at`, `updated_at`) VALUES
(3, 1, 'test test', 'alooo@fgdfg.dd', '55555111', '$2y$10$Uijni2qnzX6ELqf0jwN55umKEqs3uNAiv6Q96nTtrtWDCcSPJjrle', 0, 1, NULL, '2019-12-30 23:23:01', '2019-12-31 00:21:06');

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

--
-- Déchargement des données de la table `cp_components`
--

INSERT INTO `cp_components` (`id`, `company_id`, `name`, `category`, `img`, `status`, `created_at`, `updated_at`) VALUES
(1, 1, 'test1', 'C', 'default.png', 1, '2020-01-17 06:22:03', '2020-01-17 06:22:03'),
(2, 1, 'test2', 'D', 'default.png', 1, '2020-01-17 06:22:09', '2020-01-17 06:22:09'),
(3, 1, 'test3', 'D', 'default.png', 1, '2020-01-17 06:22:19', '2020-01-17 06:22:19'),
(4, 1, 'test4', 'C', 'default.png', 1, '2020-01-17 06:22:25', '2020-01-17 06:22:25'),
(5, 1, 'test5', 'C', 'default.png', 1, '2020-01-17 06:22:31', '2020-01-17 06:22:31');

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

--
-- Déchargement des données de la table `cp_component_groups`
--

INSERT INTO `cp_component_groups` (`id`, `company_id`, `name`, `description`, `usage`, `status`, `created_at`, `updated_at`) VALUES
(1, 1, 'test', 'tes t test', 'M', 1, '2020-01-07 09:48:08', '2020-01-07 09:53:41');

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

--
-- Déchargement des données de la table `cp_customers`
--

INSERT INTO `cp_customers` (`id`, `name`, `phone`, `email`, `created_at`, `updated_at`) VALUES
(11, 'test2', 87654321, 'test2@test.tt', '2019-12-19 08:19:55', '2019-12-19 08:19:55');

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
(45, '2020_01_16_224122_add_default_to_product_components', 7);

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
  `acompte` double(7,3) DEFAULT NULL,
  `acompte_type` enum('C','E','T') DEFAULT NULL COMMENT 'C: Cheque, E: EspÃ¨ces , T: TÃ©lÃ©paiement',
  `total` double(7,3) NOT NULL,
  `instructions` text,
  `status` enum('P','M','R','D','L') NOT NULL DEFAULT 'P' COMMENT 'P: pending, M: making, R: ready, D: delivery, L: delivred',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
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
  `default_price` double(7,3) DEFAULT NULL,
  `description` text,
  `status` tinyint(4) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `cp_products`
--

INSERT INTO `cp_products` (`id`, `ref`, `company_id`, `name`, `price_by_size`, `default_price`, `description`, `status`, `created_at`, `updated_at`) VALUES
(14, 'test', 1, 'test test', 0, 100.000, 'testtesttest', 1, '2020-01-17 06:31:09', '2020-01-17 06:31:09'),
(15, 'testz', 1, 'test test', 0, 5.000, 'testtesttest', 1, '2020-01-17 06:32:05', '2020-01-17 06:32:05'),
(16, 'testza', 1, 'test test', 0, 5.000, 'testtesttest', 1, '2020-01-17 06:36:18', '2020-01-17 06:36:18');

-- --------------------------------------------------------

--
-- Structure de la table `cp_product_components`
--

CREATE TABLE `cp_product_components` (
  `id` int(10) UNSIGNED NOT NULL,
  `product_id` int(10) UNSIGNED NOT NULL,
  `component_id` int(10) UNSIGNED NOT NULL,
  `price_by_size` tinyint(1) NOT NULL,
  `default_price` double(7,3) NOT NULL,
  `img` varchar(200) DEFAULT NULL,
  `default` tinyint(4) NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `cp_product_components`
--

INSERT INTO `cp_product_components` (`id`, `product_id`, `component_id`, `price_by_size`, `default_price`, `img`, `default`, `status`) VALUES
(8, 14, 1, 1, 2.500, NULL, 1, 1),
(9, 14, 4, 1, 0.000, NULL, 0, 1),
(10, 14, 5, 1, 0.000, NULL, 0, 1),
(11, 15, 1, 1, 2.500, NULL, 1, 1),
(12, 15, 4, 1, 0.000, NULL, 0, 1),
(13, 15, 5, 1, 0.000, NULL, 0, 1),
(14, 16, 1, 1, 2.500, NULL, 1, 1),
(15, 16, 4, 1, 0.000, NULL, 0, 1),
(16, 16, 5, 1, 0.000, NULL, 0, 1),
(17, 16, 2, 0, 6.500, NULL, 1, 1),
(18, 16, 3, 0, 6.500, NULL, 0, 1);

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
  `price` double(7,3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `cp_product_component_prices`
--

INSERT INTO `cp_product_component_prices` (`id`, `product_component_id`, `size_id`, `price`) VALUES
(1, 8, 2, 2.500),
(2, 9, 3, 2.600),
(3, 10, 2, 2.700),
(4, 11, 2, 2.500),
(5, 12, 3, 2.600),
(6, 13, 2, 2.700),
(7, 14, 2, 2.500),
(8, 15, 3, 2.600),
(9, 16, 2, 2.700);

-- --------------------------------------------------------

--
-- Structure de la table `cp_product_imgs`
--

CREATE TABLE `cp_product_imgs` (
  `id` int(10) UNSIGNED NOT NULL,
  `product_id` int(10) UNSIGNED NOT NULL,
  `img` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `cp_product_imgs`
--

INSERT INTO `cp_product_imgs` (`id`, `product_id`, `img`) VALUES
(13, 14, '1579246269-b241acd552e10fc5.jpg'),
(14, 15, '1579246325-b241acd552e10fc5.jpg'),
(15, 16, '1579246578-b241acd552e10fc5.jpg');

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
  `price` double(7,3) NOT NULL,
  `default` tinyint(1) NOT NULL DEFAULT '0',
  `status` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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
(17, 14, 5, 1, NULL, NULL),
(18, 14, 6, 1, NULL, NULL),
(19, 15, 5, 1, NULL, NULL),
(20, 15, 6, 1, NULL, NULL),
(21, 16, 5, 1, NULL, NULL),
(22, 16, 6, 1, NULL, NULL);

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
(2, 1, '15 parts 22cm', 1, '2020-01-17 06:23:33', '2020-01-17 06:24:05'),
(3, 1, '30 parts 30cm', 1, '2020-01-17 06:23:45', '2020-01-17 06:23:45'),
(4, 1, '50 parts 110cm', 1, '2020-01-17 06:23:53', '2020-01-17 06:24:18');

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
(5, 1, 'Chocolat', 1, '2020-01-17 06:16:15', '2020-01-17 06:16:15'),
(6, 1, 'noisette', 1, '2020-01-17 06:24:52', '2020-01-17 06:24:52');

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
  ADD UNIQUE KEY `company_users_email_unique` (`email`),
  ADD UNIQUE KEY `company_users_phone_unique` (`phone`),
  ADD KEY `company_users_company_section_id_foreign` (`company_section_id`);

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
-- Index pour la table `cp_migrations`
--
ALTER TABLE `cp_migrations`
  ADD PRIMARY KEY (`id`);

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
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

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
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT pour la table `cp_components`
--
ALTER TABLE `cp_components`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT pour la table `cp_component_groups`
--
ALTER TABLE `cp_component_groups`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `cp_customers`
--
ALTER TABLE `cp_customers`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT pour la table `cp_migrations`
--
ALTER TABLE `cp_migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- AUTO_INCREMENT pour la table `cp_orders`
--
ALTER TABLE `cp_orders`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `cp_products`
--
ALTER TABLE `cp_products`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT pour la table `cp_product_components`
--
ALTER TABLE `cp_product_components`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT pour la table `cp_product_component_groups`
--
ALTER TABLE `cp_product_component_groups`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `cp_product_component_prices`
--
ALTER TABLE `cp_product_component_prices`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT pour la table `cp_product_imgs`
--
ALTER TABLE `cp_product_imgs`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT pour la table `cp_product_sales`
--
ALTER TABLE `cp_product_sales`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `cp_product_size_prices`
--
ALTER TABLE `cp_product_size_prices`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `cp_product_tags`
--
ALTER TABLE `cp_product_tags`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT pour la table `cp_sizes`
--
ALTER TABLE `cp_sizes`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT pour la table `cp_tags`
--
ALTER TABLE `cp_tags`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

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
  ADD CONSTRAINT `company_users_company_section_id_foreign` FOREIGN KEY (`company_section_id`) REFERENCES `cp_company_sections` (`id`);

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
  ADD CONSTRAINT `product_component_groups_component_group_id_foreign` FOREIGN KEY (`component_group_id`) REFERENCES `cp_component_groups` (`id`),
  ADD CONSTRAINT `product_component_groups_component_id_foreign` FOREIGN KEY (`component_id`) REFERENCES `cp_components` (`id`),
  ADD CONSTRAINT `product_component_groups_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `cp_products` (`id`);

--
-- Contraintes pour la table `cp_product_component_prices`
--
ALTER TABLE `cp_product_component_prices`
  ADD CONSTRAINT `product_component_prices_product_component_id_foreign` FOREIGN KEY (`product_component_id`) REFERENCES `cp_product_components` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `product_component_prices_size_id_foreign` FOREIGN KEY (`size_id`) REFERENCES `cp_sizes` (`id`);

--
-- Contraintes pour la table `cp_product_imgs`
--
ALTER TABLE `cp_product_imgs`
  ADD CONSTRAINT `product_imgs_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `cp_products` (`id`);

--
-- Contraintes pour la table `cp_product_sales`
--
ALTER TABLE `cp_product_sales`
  ADD CONSTRAINT `product_sales_company_section_id_foreign` FOREIGN KEY (`company_section_id`) REFERENCES `cp_company_sections` (`id`),
  ADD CONSTRAINT `product_sales_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `cp_products` (`id`);

--
-- Contraintes pour la table `cp_product_size_prices`
--
ALTER TABLE `cp_product_size_prices`
  ADD CONSTRAINT `product_size_prices_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `cp_products` (`id`),
  ADD CONSTRAINT `product_size_prices_size_id_foreign` FOREIGN KEY (`size_id`) REFERENCES `cp_sizes` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `cp_product_tags`
--
ALTER TABLE `cp_product_tags`
  ADD CONSTRAINT `product_tags_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `cp_products` (`id`),
  ADD CONSTRAINT `product_tags_tag_id_foreign` FOREIGN KEY (`tag_id`) REFERENCES `cp_tags` (`id`);

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
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
