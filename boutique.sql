-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : jeu. 08 juin 2023 à 19:37
-- Version du serveur : 10.4.27-MariaDB
-- Version de PHP : 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `boutique`
--
CREATE DATABASE IF NOT EXISTS `boutique` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `boutique`;

-- --------------------------------------------------------

--
-- Structure de la table `addresses`
--

CREATE TABLE `addresses` (
  `address_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `address_numero` int(11) NOT NULL,
  `address_name` varchar(255) NOT NULL,
  `address_postcode` varchar(5) NOT NULL,
  `address_city` varchar(255) NOT NULL,
  `address_telephone` varchar(255) NOT NULL,
  `address_lastname` varchar(255) NOT NULL,
  `address_firstname` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `addresses`
--

INSERT INTO `addresses` (`address_id`, `user_id`, `address_numero`, `address_name`, `address_postcode`, `address_city`, `address_telephone`, `address_lastname`, `address_firstname`) VALUES
(10, 43, 1212, 'DSSD', '2122', 'SDSD', '', '', ''),
(15, 44, 1222, 'fddfskf', '22222', 'SDJFLKSJFLKS', '', '', ''),
(57, 1, 413, 'dsdsds', '87887', 'KFLDFDL', '06 5555 55 53', 'Hfjdjfd', 'Dsjdksd'),
(58, 1, 123, 'azerty', '12345', 'QSDSDF', '01 02 03 04 05', 'Dylan', 'Lmmlml');

-- --------------------------------------------------------

--
-- Structure de la table `carts`
--

CREATE TABLE `carts` (
  `cart_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `carts`
--

INSERT INTO `carts` (`cart_id`, `user_id`, `product_id`) VALUES
(4, 2, 4),
(5, 2, 1),
(6, 3, 3),
(7, 3, 3);

-- --------------------------------------------------------

--
-- Structure de la table `category`
--

CREATE TABLE `category` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `id_parent` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `category`
--

INSERT INTO `category` (`id`, `name`, `id_parent`) VALUES
(1, 'Périphériques', 0),
(2, 'Composants', 0),
(3, 'Ordinateurs', 0),
(4, 'Gaming', 0),
(5, 'Clavier', 1),
(6, 'Souris', 1),
(7, 'Ecran PC', 1),
(8, 'Micro', 1),
(9, 'Casque', 1),
(10, 'Webcam', 1),
(11, 'Processeur', 2),
(12, 'Carte Graphique', 2),
(13, 'Carte Mère', 2),
(14, 'Alimentation PC', 2),
(15, 'RAM', 2),
(16, 'Stockage', 2),
(17, 'Refroidissement Processeur', 2),
(18, 'Boitier PC', 2),
(19, 'Ventilateur boitier', 2),
(20, 'Connectique', 2),
(21, 'PC Gamer', 3),
(22, 'PC Portable', 3),
(23, 'PC Portable Gamer', 3),
(24, 'Fauteuil Gamer', 4),
(25, 'Casque VR', 4),
(26, 'Bureau Gamer', 4),
(27, 'Streaming', 4),
(28, 'Simulation', 4);

-- --------------------------------------------------------

--
-- Structure de la table `codes`
--

CREATE TABLE `codes` (
  `code_id` int(11) NOT NULL,
  `code_name` varchar(20) NOT NULL,
  `code_discount` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `codes`
--

INSERT INTO `codes` (`code_id`, `code_name`, `code_discount`) VALUES
(1, 'ruben', 100);

-- --------------------------------------------------------

--
-- Structure de la table `images`
--

CREATE TABLE `images` (
  `image_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `image_name` varchar(255) NOT NULL,
  `image_main` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `images`
--

INSERT INTO `images` (`image_id`, `product_id`, `image_name`, `image_main`) VALUES
(1, 1, '6475f25bc39867.89390332.webp', 1),
(2, 2, '6475f288a939c1.84595542.webp', 1),
(3, 3, '6475f32adc8467.87590281.webp', 1),
(4, 4, '6475f33a508b21.07253710.webp', 1),
(5, 5, '6475f351b73726.30009031.webp', 1),
(6, 6, '6475f37702e884.54651912.webp', 1),
(7, 7, '6475f388aa6d02.92142451.webp', 1),
(8, 8, '6475f3ba603cd6.35070928.webp', 1),
(9, 9, '6475f3d897b464.68007778.webp', 1),
(10, 10, '6475f40d3b5306.19647865.webp', 1),
(11, 11, '6475f40e9cf237.15696498.webp', 1),
(12, 12, '6475f43d221207.12281511.webp', 1),
(13, 13, '6475f46e87dd10.15202231.webp', 1),
(14, 14, '6475f47c31d7c1.15198495.webp', 1),
(15, 15, '6475f48d13b4b6.96340783.webp', 1),
(16, 16, '6475f4b9403e77.02661514.webp', 1),
(17, 17, '6475f4c394e2c7.08146105.webp', 1),
(18, 18, '6475f4ee20e653.95459564.webp', 1),
(19, 19, '6475f5172682d3.06974411.webp', 1),
(20, 20, '6475f51f033e19.38414829.webp', 1),
(21, 21, '6475f53b2a9415.57722934.webp', 1),
(22, 22, '6475f553f10617.15841543.webp', 1),
(23, 23, '6475f55f963d65.15443538.webp', 1),
(24, 24, '6475f581e1f5f4.07996046.webp', 1),
(25, 25, '6475f5a57afb27.55252751.webp', 1),
(26, 26, '6475f5ad53f2c3.26428752.webp', 1),
(27, 27, '6475f5f4effc73.30846859.webp', 1),
(28, 28, '6475f61818bf34.47033989.webp', 1),
(29, 29, '6475f6241a59c5.68146426.webp', 1),
(30, 30, '6475f63c732a58.96404055.webp', 1),
(31, 31, '6475f6714af812.58830566.webp', 1),
(32, 32, '6475f69177b669.93236334.webp', 1),
(33, 33, '6475f6ba3117c5.36343115.webp', 1),
(34, 34, '6475f74c186da3.18506273.webp', 1),
(35, 35, '6475f78b8ec398.16743558.webp', 1),
(36, 36, '6475f83364a400.50671739.webp', 1),
(37, 37, '6475f88147cb69.21746342.webp', 1),
(38, 38, '6475f93ea63453.70885077.webp', 1),
(39, 39, '6475f9ec7e1f89.02153181.webp', 1),
(40, 40, '6475fa2be299a6.01919868.webp', 1),
(41, 1, '64763182882463.61113165.webp', 0),
(42, 55, '648210b131c143.20582080.png', 1);

-- --------------------------------------------------------

--
-- Structure de la table `liaison_items_category`
--

CREATE TABLE `liaison_items_category` (
  `id` int(11) NOT NULL,
  `id_item` int(11) NOT NULL,
  `id_category` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `liaison_items_category`
--

INSERT INTO `liaison_items_category` (`id`, `id_item`, `id_category`) VALUES
(1, 1, 11),
(2, 2, 15),
(3, 3, 11),
(4, 4, 15),
(5, 5, 11),
(6, 6, 11),
(7, 7, 15),
(8, 8, 11),
(9, 9, 15),
(10, 10, 15),
(11, 11, 12),
(12, 12, 12),
(13, 13, 12),
(14, 14, 16),
(15, 15, 12),
(16, 16, 12),
(17, 17, 16),
(18, 18, 13),
(19, 19, 13),
(20, 20, 16),
(21, 21, 13),
(22, 22, 16),
(23, 23, 13),
(24, 24, 13),
(25, 25, 16),
(26, 26, 14),
(27, 27, 14),
(28, 28, 14),
(29, 29, 17),
(30, 30, 14),
(31, 31, 17),
(32, 32, 14),
(33, 33, 17),
(34, 34, 17),
(35, 35, 0),
(36, 36, 20),
(37, 37, 20),
(38, 38, 20),
(39, 39, 20),
(40, 40, 20),
(41, 41, 0),
(42, 42, 0),
(43, 51, 0),
(44, 52, 0),
(45, 53, 0),
(46, 54, 1),
(47, 55, 0);

-- --------------------------------------------------------

--
-- Structure de la table `liaison_product_order`
--

CREATE TABLE `liaison_product_order` (
  `id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `liaison_product_order`
--

INSERT INTO `liaison_product_order` (`id`, `product_id`, `order_id`) VALUES
(1, 1, 2),
(2, 2, 2),
(3, 3, 2),
(4, 1, 3),
(5, 2, 3),
(6, 3, 3),
(7, 20, 4),
(8, 16, 4),
(9, 16, 5),
(10, 19, 5),
(11, 16, 6),
(12, 19, 6),
(13, 16, 7),
(14, 19, 7),
(15, 15, 8),
(16, 3, 8),
(17, 26, 9),
(18, 39, 9),
(19, 24, 10),
(20, 19, 10),
(21, 1, 11),
(22, 1, 13),
(23, 1, 24),
(24, 1, 27),
(25, 26, 27),
(26, 26, 29),
(27, 26, 30),
(28, 26, 31),
(29, 26, 32),
(30, 26, 33),
(31, 26, 34),
(32, 6, 35),
(33, 12, 36),
(34, 6, 55),
(35, 12, 57),
(36, 5, 65),
(37, 5, 65),
(38, 5, 65),
(39, 5, 66),
(40, 5, 66),
(41, 5, 66),
(42, 5, 67),
(43, 5, 67),
(44, 5, 67),
(45, 24, 68),
(46, 39, 68);

-- --------------------------------------------------------

--
-- Structure de la table `orders`
--

CREATE TABLE `orders` (
  `order_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `order_date` datetime NOT NULL,
  `order_total` decimal(10,2) NOT NULL,
  `order_address` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `orders`
--

INSERT INTO `orders` (`order_id`, `user_id`, `order_date`, `order_total`, `order_address`) VALUES
(2, 1, '2023-05-30 11:19:38', '0.00', ''),
(3, 1, '2023-05-30 11:21:44', '0.00', ''),
(4, 1, '2023-05-30 11:47:33', '0.00', ''),
(5, 1, '2023-05-30 13:40:01', '0.00', ''),
(6, 1, '2023-05-30 13:40:38', '0.00', ''),
(7, 1, '2023-05-30 13:44:01', '74.98', ''),
(8, 1, '2023-05-30 13:44:38', '214.98', ''),
(9, 1, '2023-06-01 10:56:12', '74.00', ''),
(10, 1, '2023-06-01 10:58:47', '428.00', ''),
(11, 1, '2023-06-05 23:00:33', '187.00', ''),
(13, 1, '2023-06-05 23:12:34', '187.00', ''),
(24, 1, '2023-06-05 23:29:15', '187.00', ''),
(27, 1, '2023-06-05 23:39:17', '261.00', ''),
(55, 1, '2023-06-08 13:20:04', '244.00', '728 dfjdk,72382 JSDKJS'),
(56, 1, '2023-06-08 13:20:48', '0.00', '75 rue Leon Jouhaux,83200 TOULON'),
(57, 1, '2023-06-08 13:21:47', '299.00', '438 dsjkd,00200 SDKJLSDLS'),
(58, 1, '2023-06-08 13:25:37', '0.00', '438 dsjkd,00200 SDKJLSDLS'),
(59, 1, '2023-06-08 13:26:03', '0.00', '438 dsjkd,00200 SDKJLSDLS'),
(60, 1, '2023-06-08 13:26:05', '0.00', '438 dsjkd,00200 SDKJLSDLS'),
(61, 1, '2023-06-08 13:26:36', '0.00', '438 dsjkd,00200 SDKJLSDLS'),
(62, 1, '2023-06-08 13:26:54', '0.00', '438 dsjkd,00200 SDKJLSDLS'),
(63, 1, '2023-06-08 13:27:12', '0.00', '438 dsjkd,00200 SDKJLSDLS'),
(64, 1, '2023-06-08 13:27:41', '0.00', '438 dsjkd,00200 SDKJLSDLS'),
(65, 1, '2023-06-08 19:15:10', '0.00', ''),
(66, 1, '2023-06-08 19:16:06', '0.00', ''),
(67, 1, '2023-06-08 19:16:45', '507.00', '413 dsdsds, 87887 KFLDFDL'),
(68, 1, '2023-06-08 19:24:04', '199.00', '123 azerty, 12345 QSDSDF');

-- --------------------------------------------------------

--
-- Structure de la table `products`
--

CREATE TABLE `products` (
  `product_id` int(11) NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `product_description` text NOT NULL,
  `product_date` datetime NOT NULL,
  `product_price` decimal(10,2) NOT NULL,
  `product_stock` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `products`
--

INSERT INTO `products` (`product_id`, `product_name`, `product_description`, `product_date`, `product_price`, `product_stock`) VALUES
(1, 'AMD Ryzen 5 5600X (3.7 GHz)', 'Processeur Socket AM4 - Hexa Core - Cache 35 Mo - Vermeer', '2023-05-30 14:55:55', '187.00', 0),
(2, 'DDR5 Corsair Vengeance - 32 Go (2 x 16 Go) 5200 MHz - CAS 40', 'Mémoire DDR5 - PC-41600 - Low-Profile', '2023-05-30 14:56:40', '179.00', 500),
(3, 'Intel Core i5-13600KF (3.5 GHz)', 'Processeur Socket 1700 - 14 coeurs - Cache 24 Mo - Raptor Lake - Ventirad non inclus', '2023-05-30 14:59:22', '369.00', 500),
(4, 'DDR5 Kingston Fury Beast Black - 32 Go (2 x 16 Go) 5600 MHz - CAS 40', 'Mémoire DDR5 - PC-44800 - Low-Profile', '2023-05-30 14:59:38', '159.00', 500),
(5, 'AMD Ryzen 5 5600 (3.5 GHz)', 'Processeur Socket AM4 - Hexa Core - Cache 35 Mo - Vermeer - Ventirad inclus', '2023-05-30 15:00:01', '169.00', 498),
(6, 'AMD Ryzen 7 5700X (3.4 GHz)', 'Processeur Socket AM4 - Octo Core - Cache 36 Mo - Vermeer - Ventirad non inclus', '2023-05-30 15:00:38', '244.00', 498),
(7, 'DDR4 G.Skill Trident Z RGB - 16 Go (2 x 8 Go) 3600 MHz - CAS 18', 'Kit Dual Channel - MÃ©moire DDR4 optimisÃ©e Intel - PC-28800 - LED RGB', '2023-05-30 15:00:56', '53.00', 500),
(8, 'Intel Core i5-12400F (2.5 GHz)', 'Processeur Socket 1700 - Hexa Core - Cache 18 Mo - Alder Lake - Ventirad inclus', '2023-05-30 15:01:46', '178.00', 500),
(9, 'DDR5 Crucial PRO - 32 Go (2 x 16 Go) 5600 MHz - CAS 46', 'MÃ©moire DDR5 - PC-44800 - Low-Profile - OptimisÃ©e AMD EXPO', '2023-05-30 15:02:16', '129.00', 500),
(10, 'DDR5 Textorm - 32 Go (2 x 16 Go) 4800 MHz - CAS 40', 'MÃ©moire DDR5 - PC-38400 - Low-Profile', '2023-05-30 15:03:09', '139.00', 500),
(11, 'Gainward GeForce RTX 4070 Ghost + Diablo IV offert !', 'Carte graphique - Avec backplate - Compatible VR', '2023-05-30 15:03:10', '610.00', 500),
(12, 'Asus Radeon RX 6650 XT DUAL O8G', 'Carte graphique - Refroidissement semi-passif (mode 0 dB) - Avec backplate - Compatible VR', '2023-05-30 15:03:57', '299.00', 498),
(13, 'Gigabyte Radeon RX 6700 XT EAGLE', 'Carte graphique PCI-Express - Refroidissement semi-passif (mode 0 dB) - Avec backplate - Compatible VR', '2023-05-30 15:04:46', '338.00', 500),
(14, 'Samsung SÃ©rie 970 EVO Plus 2 To', 'SSD M.2 - PCI-Express 3.0 NVMe - ContrÃ´leur Samsung Phoenix - Lecture max : 3500 Mo/s - Ecriture max : 3300 Mo/s - MÃ©moire TLC 3D', '2023-05-30 15:05:00', '99.00', 500),
(15, 'KFA2 GeForce RTX 3060 Ti (1-Click OC) (LHR)', 'Carte graphique overclockÃ©e - Refroidissement semi-passif (mode 0 dB) - Avec backplate - Compatible VR - MÃ©moire GDDR6', '2023-05-30 15:05:17', '319.00', 500),
(16, 'KFA2 GeForce GTX 1630 EX (1-Click OC)', 'Carte graphique - Compatible VR', '2023-05-30 15:06:01', '112.00', 500),
(17, 'Crucial P3 1 To', 'SSD M.2 - PCI-Express 3.0 NVMe - Lecture max : 3500 Mo/s - Ecriture max : 3000 Mo/s - MÃ©moire QLC', '2023-05-30 15:06:11', '51.00', 500),
(18, 'ASUS ROG STRIX B760-F GAMING WIFI', 'Carte mÃ¨re ATX - Socket 1700 - Chipset Intel B760 - USB 3.2 Type C - SATA 6 Gb/s - M.2 - WiFi - LEDs intÃ©grÃ©es', '2023-05-30 15:06:54', '249.00', 500),
(19, 'ASUS ROG STRIX B760-A GAMING WIFI DDR4 + opÃ©ration COD Modern Warfare 2', 'Carte mÃ¨re ATX - Socket 1700 - Chipset Intel B760 - USB 3.2 Type C - SATA 6 Gb/s - M.2 - WiFi - LEDs intÃ©grÃ©es', '2023-05-30 15:07:35', '229.00', 500),
(20, 'Kingston NV2 1 To', 'SSD M.2 - PCI-Express 4.0 NVMe - Lecture Max : 3500 Mo/s - Ecriture max : 2100 Mo/s - MÃ©moire QLC 3D', '2023-05-30 15:07:42', '52.00', 500),
(21, 'GIGABYTE B760 GAMING X DDR4', 'Carte mÃ¨re ATX - Socket 1700 - Chipset Intel B760 - USB 3.1 - SATA 6 Gb/s - M.2', '2023-05-30 15:08:11', '149.00', 500),
(22, 'Fox Spirit PM18 240 Go', 'SSD M.2 - PCI-Express 3.0 NVMe - ContrÃ´leur Silicon Motion SM2263XT - Lecture max : 3400 Mo/s - Ecriture max : 1200 Mo/s - MÃ©moire TLC 3D', '2023-05-30 15:08:35', '17.00', 500),
(23, 'MSI PRO Z690-P DDR4', 'Carte mÃ¨re ATX - Socket 1700 - Chipset Intel Z690 - USB 3.2 Type C - SATA 6 Gb/s - M.2', '2023-05-30 15:08:47', '199.00', 500),
(24, 'ASRock B760M PG SONIC WIFI', 'Carte mÃ¨re mATX - Socket 1700 - Chipset Intel B760 - USB 3.1 Type C - SATA 6 Gb/s - M.2 - Wifi - LED intÃ©grÃ©es', '2023-05-30 15:09:21', '199.00', 499),
(25, 'Intel SSD 670P Series 2 To', 'SSD M.2 - PCI-Express 3.0 NVMe - Lecture max : 3500 Mo/s - Ecriture max : 2700 Mo/s - MÃ©moire QLC 3D4', '2023-05-30 15:09:57', '99.00', 500),
(26, 'Aerocool Lux RGB 750M - 750W', 'Alimentation PC CertifiÃ©e 80+ Bronze - Semi-Modulaire', '2023-05-30 15:10:05', '74.00', 497),
(27, 'MSI MPG A850G PCIE5 - 850W', 'Alimentation PC CertifiÃ©e 80+ Gold - Modulaire - Semi-passive - ATX 3.0', '2023-05-30 15:11:16', '139.00', 500),
(28, 'Corsair CV650 - 650W', 'Alimentation PC CertifiÃ©e 80+ Bronze', '2023-05-30 15:11:52', '89.00', 500),
(29, 'be quiet! Pure Wings 2 PWM - 120 mm', 'Ventilateur boitier - PWM - 1500 RPM - 20.2 dB - Jusqu\'Ã  51.4 CFM', '2023-05-30 15:12:04', '10.00', 500),
(30, 'Corsair CX550F RGB (Blanc) - 550W', 'Alimentation PC CertifiÃ©e 80+ Bronze - Modulaire', '2023-05-30 15:12:28', '79.00', 500),
(31, 'Arctic P12 PWM PST - Blanc', 'Ventilateur boÃ®tier - PWM - 200 Ã  1800 RPM - 22,5 dB - 56,3 CFM', '2023-05-30 15:13:21', '6.00', 500),
(32, 'Cooler Master V750 Gold I - 750W', 'Alimentation PC CertifiÃ©e 80+ Gold - Modulaire - ATX 3.0', '2023-05-30 15:13:53', '199.00', 500),
(33, 'Cooler Master SickleFlow 120 ARGB - 120 mm', 'Ventilateur boitier - PWM - 650 Ã  1800 RPM - 27 dB - 62 CFM', '2023-05-30 15:14:34', '16.00', 500),
(34, 'Cooler Master MasterFan MF120 Halo - 120 mm - Blanc', 'Ventilateur boitier - PWM - 650 Ã  1800 RPM - 30 dB - 47.2 CFM', '2023-05-30 15:17:00', '15.00', 500),
(35, 'In Win Saturn ASN140 - 140 mm', 'Ventilateur boitier - PWM - 500-1400 RPM - 36 dB - 93.97 CFM', '2023-05-30 15:18:03', '12.00', 500),
(36, 'CÃ¢ble ethernet RJ45 CAT6 F/UTP - Noir - 3 mÃ¨tres - Textorm', 'MÃ¢le / MÃ¢le', '2023-05-30 15:20:51', '6.00', 500),
(37, 'CÃ¢ble ethernet RJ45 CAT6 U/UTP - Blanc - 5 mÃ¨tres - Textorm', 'MÃ¢le / MÃ¢le', '2023-05-30 15:22:09', '7.00', 500),
(38, 'CÃ¢ble USB 3.0 Type A - 1.8 mÃ¨tre - Bleu', 'CÃ¢ble USB 3.0 Type A MÃ¢le/MÃ¢le', '2023-05-30 15:25:18', '8.00', 500),
(39, 'Adaptateur USB 3.0 Type C MÃ¢le vers USB 3.0 Type A Femelle', 'Cet adaptateur adaptateur USB Type C MÃ¢le / USB 3.0 Type A Femelle permet de connecter tout accessoire ou pÃ©riphÃ©rique prÃ©vu pour de l\'USB C via un port USB 3.0 Type A.', '2023-05-30 15:28:12', '0.00', 0),
(40, 'CÃ¢ble SATA - 50 cm', 'CÃ¢ble SATA MÃ¢le / MÃ¢le', '2023-05-30 15:29:15', '5.00', 500),
(43, '', '', '2023-06-08 19:26:12', '0.00', 500),
(44, '', '', '2023-06-08 19:26:32', '0.00', 500),
(45, '', '', '2023-06-08 19:26:55', '0.00', 500),
(46, '', '', '2023-06-08 19:27:09', '0.00', 500),
(47, '', '', '2023-06-08 19:27:37', '0.00', 500),
(48, '', '', '2023-06-08 19:27:48', '0.00', 500),
(49, '', '', '2023-06-08 19:28:25', '0.00', 500),
(50, '', '', '2023-06-08 19:29:24', '0.00', 500),
(51, '', '', '2023-06-08 19:30:51', '0.00', 500),
(52, '', '', '2023-06-08 19:31:25', '0.00', 500),
(53, 'SDSDSD', 'SDsds', '2023-06-08 19:31:51', '0.00', 500);

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `user_email` varchar(255) NOT NULL,
  `user_lastname` varchar(255) NOT NULL,
  `user_firstname` varchar(255) NOT NULL,
  `user_password` varchar(255) NOT NULL,
  `user_role` tinyint(4) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`user_id`, `user_email`, `user_lastname`, `user_firstname`, `user_password`, `user_role`) VALUES
(1, 'admin@laplateforme.io', 'admin', 'admin', '$2y$10$uFx8wvlAhgmw93DDzIno/O/w5g2JN20kXPwvC83HnKWfsdG1y4Fd6', 2),
(2, 'dylan@gmail.com', 'dylan', 'dylan', '$2y$10$tNWkG3pj51SovDx3dtUzMO.8z.kjTDt4w5NlVtxYhItsDbJFrVoAi', 1),
(3, 'charles@gmail.com', 'charles', 'charles', '$2y$10$VQv69RMVPjKQ/ywJ7Rexje8ZbyoQnU5qWx/tNdWFJuJdWbdAQjxAy', 1),
(43, 'test@laplateforme.io', 'test', 'test', '$2y$10$WlEaL/qLA.if9MmeF7Sv1O13ZGCR6FbjslsY7MlRv5FZlhv0VRHdK', 1),
(48, 'a@a.com', 'aa', 'aaaa', '', 0),
(49, 'b@b.fr', 'bb', 'bb', '$2y$10$OFSZfMcmq192gGTUxUEBdObkYcMYu5v2yZHSUyHxqC4xbvKFdirI2', 0),
(87, 'admidn@laplateforme.io', 'pp', 'pp', '$2y$10$iybsGiZvjkopzeWt4N5XX.j6fxb.bgRT3tgy7sUeOYB3kTPpe1hn2', 0),
(88, 'admicdn@laplateforme.io', 'ccc', 'cc', '$2y$10$TMkH9irjSUspWb38DO8J7evMry70jy6Tplba5LUgW/GTRmWpsNZLO', 0),
(89, 'dylansskk@gmail.com', 'kk', 'kk', '$2y$10$sErVcqZaE1/a4ym6u2ZFhuQqpakhq2pehUSR3/CQ9aMhixiwrhdAi', 0),
(90, 'adminj@laplateforme.io', 'aaa', 'aaa', '$2y$10$5SCNj2ii5gUzCKLe7wsUaOSegM5q5UjTvjnCNQEpCQgzm0xb8jo1y', 0),
(91, 'aadmin@laplateforme.io', 'aa', 'aa', '$2y$10$tJQwMqIBQk9Qky4soVoZP.Wn.Yh2KHoMM2JMM0yF1E4GwA1Xs4sSi', 0),
(92, 'adsmin@laplateforme.io', 'ss', 's', '$2y$10$GPEwWFZHrtqyXs0y0Ce69e5QZizyPhylzbgPOPtHrc1ixV5bYQLb.', 0),
(93, 'w@laplateforme.io', 'ww', 'ww', '$2y$10$tNc7uR0bjh4tA1Gkx7rveuYLuuXmAb/mqBx90p4xEq1ij8x2DQLEy', 0);

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `addresses`
--
ALTER TABLE `addresses`
  ADD PRIMARY KEY (`address_id`);

--
-- Index pour la table `carts`
--
ALTER TABLE `carts`
  ADD PRIMARY KEY (`cart_id`);

--
-- Index pour la table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `codes`
--
ALTER TABLE `codes`
  ADD PRIMARY KEY (`code_id`);

--
-- Index pour la table `images`
--
ALTER TABLE `images`
  ADD PRIMARY KEY (`image_id`);

--
-- Index pour la table `liaison_items_category`
--
ALTER TABLE `liaison_items_category`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `liaison_product_order`
--
ALTER TABLE `liaison_product_order`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`order_id`);

--
-- Index pour la table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`product_id`);

--
-- Index pour la table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `addresses`
--
ALTER TABLE `addresses`
  MODIFY `address_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=61;

--
-- AUTO_INCREMENT pour la table `carts`
--
ALTER TABLE `carts`
  MODIFY `cart_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=70;

--
-- AUTO_INCREMENT pour la table `category`
--
ALTER TABLE `category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT pour la table `codes`
--
ALTER TABLE `codes`
  MODIFY `code_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `images`
--
ALTER TABLE `images`
  MODIFY `image_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT pour la table `liaison_items_category`
--
ALTER TABLE `liaison_items_category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;

--
-- AUTO_INCREMENT pour la table `liaison_product_order`
--
ALTER TABLE `liaison_product_order`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- AUTO_INCREMENT pour la table `orders`
--
ALTER TABLE `orders`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=69;

--
-- AUTO_INCREMENT pour la table `products`
--
ALTER TABLE `products`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=56;

--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=94;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
