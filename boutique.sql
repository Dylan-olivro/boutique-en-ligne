-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : jeu. 22 juin 2023 à 13:19
-- Version du serveur : 8.0.31
-- Version de PHP : 8.0.26

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

DROP TABLE IF EXISTS `addresses`;
CREATE TABLE IF NOT EXISTS `addresses` (
  `address_id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `address_numero` int NOT NULL,
  `address_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `address_postcode` varchar(5) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `address_city` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `address_telephone` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `address_lastname` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `address_firstname` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`address_id`)
) ENGINE=InnoDB AUTO_INCREMENT=76 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `addresses`
--

INSERT INTO `addresses` (`address_id`, `user_id`, `address_numero`, `address_name`, `address_postcode`, `address_city`, `address_telephone`, `address_lastname`, `address_firstname`) VALUES
(67, 2, 323, 'dsdsds dsdsds d s ds ds ds ds d', '53535', 'DSDSDSDSD', '04 38 28 38 28', 'SDsdsd', 'Sdsdsd'),
(69, 1, 11, 'rue Leon Jouhaux', '55555', 'é\"(\'\"é\'(&\'', '09 03 03 03 03', 'Admin', 'Dylan'),
(70, 1, 232, 'dzeze', '22322', 'DSDSD', '09 03 03 03 03', 'Dsdsdsd', 'Sdsdsd'),
(71, 1, 75, 'rue Leon Jouhaux', '83200', 'TOULON', '06 43 17 21 20', 'Olivro', 'Dylan'),
(72, 1, 75, 'rue Leon Jouhaux', '83200', 'TOULON', '06 43 17 21 20', 'Olivro', 'Dylan'),
(73, 1, 43, 'zezezeeze ze ze', '43434', 'HHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHH', '04 38 28 38 28', 'Rerer', 'Rerer'),
(74, 1, 22, 'rue léon jouhaux', '23232', 'CHARENTE-MARITIME', '09 03 03 03 03', 'Sdsdsd', 'Sdsdsd'),
(75, 3, 1, 'rue rouge', '59856', 'JESAISPAS', '05 05 56 06 86', 'Robert', 'Pires');

-- --------------------------------------------------------

--
-- Structure de la table `carts`
--

DROP TABLE IF EXISTS `carts`;
CREATE TABLE IF NOT EXISTS `carts` (
  `cart_id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `product_id` int NOT NULL,
  `cart_quantity` int NOT NULL,
  PRIMARY KEY (`cart_id`)
) ENGINE=InnoDB AUTO_INCREMENT=180 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `carts`
--

INSERT INTO `carts` (`cart_id`, `user_id`, `product_id`, `cart_quantity`) VALUES
(178, 1, 11, 1),
(179, 3, 81, 1);

-- --------------------------------------------------------

--
-- Structure de la table `category`
--

DROP TABLE IF EXISTS `category`;
CREATE TABLE IF NOT EXISTS `category` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `id_parent` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=36 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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

DROP TABLE IF EXISTS `codes`;
CREATE TABLE IF NOT EXISTS `codes` (
  `code_id` int NOT NULL AUTO_INCREMENT,
  `code_name` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `code_discount` int NOT NULL,
  PRIMARY KEY (`code_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `codes`
--

INSERT INTO `codes` (`code_id`, `code_name`, `code_discount`) VALUES
(1, 'TEST', 50),
(2, 'DYLAN', 5);

-- --------------------------------------------------------

--
-- Structure de la table `comments`
--

DROP TABLE IF EXISTS `comments`;
CREATE TABLE IF NOT EXISTS `comments` (
  `comment_id` int NOT NULL AUTO_INCREMENT,
  `comment_text` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `user_id` int NOT NULL,
  `product_id` int NOT NULL,
  `comment_rating` int NOT NULL,
  `comment_date` datetime NOT NULL,
  PRIMARY KEY (`comment_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `images`
--

DROP TABLE IF EXISTS `images`;
CREATE TABLE IF NOT EXISTS `images` (
  `image_id` int NOT NULL AUTO_INCREMENT,
  `product_id` int NOT NULL,
  `image_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `image_main` tinyint(1) NOT NULL,
  PRIMARY KEY (`image_id`)
) ENGINE=InnoDB AUTO_INCREMENT=92 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
(41, 41, '647db830190526.65326082.webp', 1),
(42, 42, '647db8b8631494.79841844.webp', 1),
(43, 43, '647db9114facc9.90564917.webp', 1),
(44, 44, '647dbb26230313.91667445.webp', 1),
(45, 45, '647dbb914633b2.20544283.webp', 1),
(46, 46, '647dbc188b0322.98354838.webp', 1),
(47, 47, '647dbc5f8352f6.28499876.webp', 1),
(48, 48, '647dbcb62d08f6.12455867.webp', 1),
(49, 49, '647dbd11a1a6f2.16599963.webp', 1),
(50, 50, '647dbd56c51ec0.24611577.webp', 1),
(51, 51, '647dbdd6b28dc2.12774162.webp', 1),
(52, 52, '647dbe191c2aa1.69772170.webp', 1),
(53, 53, '647dbe405702d0.73058166.webp', 1),
(54, 54, '647dbe717ae6f6.81590917.webp', 1),
(55, 55, '647dbe9f7a27a6.01626457.webp', 1),
(56, 56, '647dbf8838bfe1.06514061.webp', 1),
(57, 57, '647dbfb6526088.87868565.webp', 1),
(58, 58, '647dbfebd57c25.04496645.webp', 1),
(59, 59, '647dc02af1c930.30293305.webp', 1),
(60, 60, '647dc05da14127.96542276.webp', 1),
(61, 61, '647dc6846d3db2.52408469.webp', 1),
(62, 62, '647dc6ee4012f8.20787127.webp', 1),
(63, 63, '647dc7674cc440.40414929.webp', 1),
(64, 64, '647dc7bc2b8a37.44748485.webp', 1),
(65, 65, '647dc7ecb57e07.27266019.webp', 1),
(66, 66, '647dc873e269b9.74115384.webp', 1),
(67, 67, '647dc8cf8a0cf1.11162955.webp', 1),
(68, 68, '647dc9192d8650.87282564.webp', 1),
(69, 69, '647dc98c739007.98867136.webp', 1),
(70, 70, '647dc9bf7d1718.78985970.webp', 1),
(71, 71, '647dcd820b5258.69459175.webp', 1),
(72, 72, '647dcdaced2c52.99995750.webp', 1),
(73, 73, '647dcdf3e80bf0.70175634.webp', 1),
(74, 74, '647dce27f385e4.14024574.webp', 1),
(75, 75, '647dce62958227.74650575.webp', 1),
(76, 76, '647dcf7d885253.72507626.webp', 1),
(77, 77, '647de227ea7a98.13456286.webp', 1),
(78, 78, '647de2766fb051.57911815.webp', 1),
(79, 79, '647de2ac86e255.73652149.webp', 1),
(80, 80, '647de301a622c5.23234838.webp', 1),
(81, 81, '647de33d2d8243.02548093.webp', 1),
(82, 82, '647de41672e2f3.90197345.webp', 1),
(83, 83, '647de456bcd721.12728928.webp', 1),
(84, 84, '647de496d44333.39107281.webp', 1),
(85, 85, '647de4d54a16d6.45854373.webp', 1),
(86, 86, '647de5092e2ed4.76711433.webp', 1),
(87, 87, '648061a5d8aee3.05534749.webp', 1),
(88, 88, '64806261f03c56.25167608.webp', 1),
(89, 89, '6480632785e858.43310530.webp', 1);

-- --------------------------------------------------------

--
-- Structure de la table `liaison_items_category`
--

DROP TABLE IF EXISTS `liaison_items_category`;
CREATE TABLE IF NOT EXISTS `liaison_items_category` (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_item` int NOT NULL,
  `id_category` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=105 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
(41, 41, 5),
(42, 42, 5),
(43, 43, 5),
(44, 44, 5),
(45, 45, 5),
(46, 46, 6),
(47, 47, 6),
(48, 48, 6),
(49, 49, 6),
(50, 50, 6),
(51, 51, 7),
(52, 52, 7),
(53, 53, 7),
(54, 54, 7),
(55, 55, 7),
(56, 56, 8),
(57, 57, 8),
(58, 58, 8),
(59, 59, 8),
(60, 60, 8),
(61, 61, 10),
(62, 62, 10),
(63, 63, 10),
(64, 64, 10),
(65, 65, 10),
(66, 66, 9),
(67, 67, 9),
(68, 68, 9),
(69, 69, 9),
(70, 70, 9),
(71, 71, 18),
(72, 72, 18),
(73, 73, 18),
(74, 74, 18),
(75, 75, 18),
(76, 76, 18),
(77, 77, 23),
(78, 78, 23),
(79, 79, 23),
(80, 80, 23),
(81, 81, 23),
(82, 82, 24),
(83, 83, 24),
(84, 84, 24),
(85, 85, 24),
(86, 86, 24),
(87, 87, 25),
(88, 88, 25),
(89, 89, 25),
(91, 91, 25),
(92, 92, 25),
(93, 93, 0),
(94, 94, 25),
(95, 95, 25),
(97, 97, 29),
(98, 98, 25),
(99, 99, 0),
(100, 100, 0);

-- --------------------------------------------------------

--
-- Structure de la table `liaison_product_order`
--

DROP TABLE IF EXISTS `liaison_product_order`;
CREATE TABLE IF NOT EXISTS `liaison_product_order` (
  `id` int NOT NULL AUTO_INCREMENT,
  `product_id` int NOT NULL,
  `order_id` int NOT NULL,
  `product_quantity` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `liaison_product_order`
--

INSERT INTO `liaison_product_order` (`id`, `product_id`, `order_id`, `product_quantity`) VALUES
(1, 11, 1, 4),
(2, 47, 1, 3),
(3, 56, 1, 3),
(4, 74, 1, 1),
(5, 5, 2, 3),
(6, 12, 2, 1),
(7, 65, 2, 2),
(8, 81, 2, 2),
(9, 87, 2, 4);

-- --------------------------------------------------------

--
-- Structure de la table `orders`
--

DROP TABLE IF EXISTS `orders`;
CREATE TABLE IF NOT EXISTS `orders` (
  `order_id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `order_date` datetime NOT NULL,
  `order_total` decimal(10,2) NOT NULL,
  `order_address` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `order_number` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`order_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `orders`
--

INSERT INTO `orders` (`order_id`, `user_id`, `order_date`, `order_total`, `order_address`, `order_number`) VALUES
(1, 1, '2023-06-22 12:25:55', '3173.00', '11 rue Leon Jouhaux, 55555 é\"(\'\"é\'(&\'', '64943DD33AB0F4-28739591'),
(2, 49, '2023-06-22 13:08:34', '8478.00', '', '649447D3016741-18889447');

-- --------------------------------------------------------

--
-- Structure de la table `products`
--

DROP TABLE IF EXISTS `products`;
CREATE TABLE IF NOT EXISTS `products` (
  `product_id` int NOT NULL AUTO_INCREMENT,
  `product_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `product_description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `product_date` datetime NOT NULL,
  `product_price` decimal(10,2) NOT NULL,
  `product_stock` int NOT NULL,
  PRIMARY KEY (`product_id`)
) ENGINE=InnoDB AUTO_INCREMENT=105 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `products`
--

INSERT INTO `products` (`product_id`, `product_name`, `product_description`, `product_date`, `product_price`, `product_stock`) VALUES
(1, 'AMD Ryzen 5 5600X (3.7 GHz)', 'Processeur Socket AM4 - Hexa Core - Cache 35 Mo - Vermeer', '2023-05-30 14:55:55', '187.00', 500),
(2, 'DDR5 Corsair Vengeance - 32 Go (2 x 16 Go) 5200 MHz - CAS 40', 'Mémoire DDR5 - PC-41600 - Low-Profile', '2023-05-30 14:56:40', '179.00', 496),
(3, 'Intel Core i5-13600KF (3.5 GHz)', 'Processeur Socket 1700 - 14 coeurs - Cache 24 Mo - Raptor Lake - Ventirad non inclus', '2023-05-30 14:59:22', '369.00', 500),
(4, 'DDR5 Kingston Fury Beast Black - 32 Go (2 x 16 Go) 5600 MHz - CAS 40', 'Mémoire DDR5 - PC-44800 - Low-Profile', '2023-05-30 14:59:38', '159.00', 500),
(5, 'AMD Ryzen 5 5600 (3.5 GHz)', 'Processeur Socket AM4 - Hexa Core - Cache 35 Mo - Vermeer - Ventirad inclus', '2023-05-30 15:00:01', '169.00', 495),
(6, 'AMD Ryzen 7 5700X (3.4 GHz)', 'Processeur Socket AM4 - Octo Core - Cache 36 Mo - Vermeer - Ventirad non inclus', '2023-05-30 15:00:38', '244.00', 500),
(7, 'DDR4 G.Skill Trident Z RGB - 16 Go (2 x 8 Go) 3600 MHz - CAS 18', 'Kit Dual Channel - Mémoire DDR4 Optimisée Intel - PC-28800 - LED RGB', '2023-05-30 15:00:56', '53.00', 500),
(8, 'Intel Core i5-12400F (2.5 GHz)', 'Processeur Socket 1700 - Hexa Core - Cache 18 Mo - Alder Lake - Ventirad inclus', '2023-05-30 15:01:46', '178.00', 500),
(9, 'DDR5 Crucial PRO - 32 Go (2 x 16 Go) 5600 MHz - CAS 46', 'Mémoire DDR5 - PC-44800 - Low-Profile - Optimisée AMD EXPO', '2023-05-30 15:02:16', '129.00', 500),
(10, 'DDR5 Textorm - 32 Go (2 x 16 Go) 4800 MHz - CAS 40', 'Mémoire DDR5 - PC-38400 - Low-Profile', '2023-05-30 15:03:09', '139.00', 500),
(11, 'Gainward GeForce RTX 4070 Ghost + Diablo IV offert !', 'Carte graphique - Avec backplate - Compatible VR', '2023-05-30 15:03:10', '610.00', 496),
(12, 'Asus Radeon RX 6650 XT DUAL O8G', 'Carte graphique - Refroidissement semi-passif (mode 0 dB) - Avec backplate - Compatible VR', '2023-05-30 15:03:57', '299.00', 499),
(13, 'Gigabyte Radeon RX 6700 XT EAGLE', 'Carte graphique PCI-Express - Refroidissement semi-passif (mode 0 dB) - Avec backplate - Compatible VR', '2023-05-30 15:04:46', '338.00', 500),
(14, 'Samsung Série 970 EVO Plus 2 To', 'SSD M.2 - PCI-Express 3.0 NVMe - Contrôleur Samsung Phoenix - Lecture max : 3500 Mo/s - Ecriture max : 3300 Mo/s - Mémoire TLC 3D', '2023-05-30 15:05:00', '99.00', 500),
(15, 'KFA2 GeForce RTX 3060 Ti (1-Click OC) (LHR)', 'Carte graphique overclockée - Refroidissement semi-passif (mode 0 dB) - Avec backplate - Compatible VR - Mémoire GDDR6', '2023-05-30 15:05:17', '319.00', 500),
(16, 'KFA2 GeForce GTX 1630 EX (1-Click OC)', 'Carte graphique - Compatible VR', '2023-05-30 15:06:01', '112.00', 499),
(17, 'Crucial P3 1 To', 'SSD M.2 - PCI-Express 3.0 NVMe - Lecture max : 3500 Mo/s - Ecriture max : 3000 Mo/s - Mémoire QLC', '2023-05-30 15:06:11', '51.00', 500),
(18, 'ASUS ROG STRIX B760-F GAMING WIFI', 'Carte mère ATX - Socket 1700 - Chipset Intel B760 - USB 3.2 Type C - SATA 6 Gb/s - M.2 - WiFi - LEDs intégrées', '2023-05-30 15:06:54', '249.00', 500),
(19, 'ASUS ROG STRIX B760-A GAMING WIFI DDR4 + opération COD Modern Warfare 2', 'Carte mère ATX - Socket 1700 - Chipset Intel B760 - USB 3.2 Type C - SATA 6 Gb/s - M.2 - WiFi - LEDs intégrées', '2023-05-30 15:07:35', '229.00', 500),
(20, 'Kingston NV2 1 To', 'SSD M.2 - PCI-Express 4.0 NVMe - Lecture Max : 3500 Mo/s - Ecriture max : 2100 Mo/s - Mémoire QLC 3D', '2023-05-30 15:07:42', '52.00', 500),
(21, 'GIGABYTE B760 GAMING X DDR4', 'Carte mère ATX - Socket 1700 - Chipset Intel B760 - USB 3.1 - SATA 6 Gb/s - M.2', '2023-05-30 15:08:11', '149.00', 500),
(22, 'Fox Spirit PM18 240 Go', 'SSD M.2 - PCI-Express 3.0 NVMe - Contrôleur Silicon Motion SM2263XT - Lecture max : 3400 Mo/s - Ecriture max : 1200 Mo/s - Mémoire TLC 3D', '2023-05-30 15:08:35', '17.00', 500),
(23, 'MSI PRO Z690-P DDR4', 'Carte mère ATX - Socket 1700 - Chipset Intel Z690 - USB 3.2 Type C - SATA 6 Gb/s - M.2', '2023-05-30 15:08:47', '199.00', 500),
(24, 'ASRock B760M PG SONIC WIFI', 'Carte mère mATX - Socket 1700 - Chipset Intel B760 - USB 3.1 Type C - SATA 6 Gb/s - M.2 - Wifi - LED intégrées', '2023-05-30 15:09:21', '199.00', 500),
(25, 'Intel SSD 670P Series 2 To', 'SSD M.2 - PCI-Express 3.0 NVMe - Lecture max : 3500 Mo/s - Ecriture max : 2700 Mo/s - Mémoire QLC 3D4', '2023-05-30 15:09:57', '99.00', 500),
(26, 'Aerocool Lux RGB 750M - 750W', 'Alimentation PC Certifiée 80+ Bronze - Semi-Modulaire', '2023-05-30 15:10:05', '74.00', 500),
(27, 'MSI MPG A850G PCIE5 - 850W', 'Alimentation PC Certifiée 80+ Gold - Modulaire - Semi-passive - ATX 3.0', '2023-05-30 15:11:16', '139.00', 500),
(28, 'Corsair CV650 - 650W', 'Alimentation PC Certifiée 80+ Bronze', '2023-05-30 15:11:52', '89.00', 500),
(29, 'be quiet! Pure Wings 2 PWM - 120 mm', 'Ventilateur boitier - PWM - 1500 RPM - 20.2 dB - Jusqu\'à  51.4 CFM', '2023-05-30 15:12:04', '10.00', 500),
(30, 'Corsair CX550F RGB (Blanc) - 550W', 'Alimentation PC Certifiée 80+ Bronze - Modulaire', '2023-05-30 15:12:28', '79.00', 500),
(31, 'Arctic P12 PWM PST - Blanc', 'Ventilateur boîtier - PWM - 200 à  1800 RPM - 22,5 dB - 56,3 CFM', '2023-05-30 15:13:21', '6.00', 500),
(32, 'Cooler Master V750 Gold I - 750W', 'Alimentation PC Certifiée 80+ Gold - Modulaire - ATX 3.0', '2023-05-30 15:13:53', '199.00', 500),
(33, 'Cooler Master SickleFlow 120 ARGB - 120 mm', 'Ventilateur boitier - PWM - 650 à  1800 RPM - 27 dB - 62 CFM', '2023-05-30 15:14:34', '16.00', 500),
(34, 'Cooler Master MasterFan MF120 Halo - 120 mm - Blanc', 'Ventilateur boitier - PWM - 650 à  1800 RPM - 30 dB - 47.2 CFM', '2023-05-30 15:17:00', '15.00', 500),
(35, 'In Win Saturn ASN140 - 140 mm', 'Ventilateur boitier - PWM - 500-1400 RPM - 36 dB - 93.97 CFM', '2023-05-30 15:18:03', '12.00', 500),
(36, 'Câbles ethernet RJ45 CAT6 F/UTP - Noir - 3 Mètres - Textorm', 'Mâle / Mâle', '2023-05-30 15:20:51', '6.00', 500),
(37, 'Câbles ethernet RJ45 CAT6 U/UTP - Blanc - 5 Mètres - Textorm', 'Mâle / Mâle', '2023-05-30 15:22:09', '7.00', 500),
(38, 'Câbles USB 3.0 Type A - 1.8 mètre - Bleu', 'Câbles USB 3.0 Type A Mâle/Mâle', '2023-05-30 15:25:18', '8.00', 500),
(39, 'Adaptateur USB 3.0 Type C Mâle vers USB 3.0 Type A Femelle', 'Cet adaptateur adaptateur USB Type C Mâle / USB 3.0 Type A Femelle permet de connecter tout accessoire ou périphérique prévu pour de l\'USB C via un port USB 3.0 Type A.', '2023-05-30 15:28:12', '0.00', 498),
(40, 'Câbles SATA - 50 cm', 'Câbles SATA Mâle / Mâle', '2023-05-30 15:29:15', '5.00', 500),
(41, 'Ducky Channel One 2 Mini RGB Blanc (Cherry MX Blue) (AZERTY)', 'Clavier Gamer mécanique - Rétroéclairage RGB - Switch Cherry MX Blue', '2023-06-05 12:25:52', '114.00', 500),
(42, 'Logitech G910 Orion Spectrum (Romer-G) (AZERTY)', 'Clavier Gamer mécanique - Rétroéclairage 16.8M de couleurs touche par touche - Switches Romer-G', '2023-06-05 12:28:08', '79.00', 500),
(43, 'Razer Ornata V3 X (AZERTY)', 'Clavier Gamer - Switchs membrane silencieux - RGB', '2023-06-05 12:29:37', '49.00', 500),
(44, 'Speedlink Ludicium (AZERTY)', 'Clavier Gamer', '2023-06-05 12:38:30', '9.00', 500),
(45, 'Roccat Vulcan Pro (Switch Titan Optique Tactile) (AZERTY)', 'Clavier Gamer mécanique - Rétroéclairage AIMO 16.8 M de couleurs - Switches Roccat Titan Optique Tactile - Repose-poignets détachable', '2023-06-05 12:40:17', '99.00', 500),
(46, 'Logitech G502 HERO', 'Souris Gamer optique - Résolution ajustable 100 à  16 000 dpi - 11 boutons programmables', '2023-06-05 12:42:32', '49.00', 500),
(47, 'Razer Basilisk v3', 'Souris Gamer optique - Résolution ajustable 26 000 dpi - 11 boutons programmables', '2023-06-05 12:43:43', '69.00', 497),
(48, 'Cooler Master MM720 - Matte Black', 'Souris Gamer optique - Résolution ajustable 16000 DPI - RGB - 6 boutons - 49 grammes', '2023-06-05 12:45:10', '49.00', 500),
(49, 'MSI Gaming M99', 'Souris Gamer optique - Résolution ajustable 4000 dpi - 7 boutons - Rétroéclairage RGB', '2023-06-05 12:46:41', '24.00', 500),
(50, 'SteelSeries Prime+', 'Souris Gamer optique - Résolution ajustable jusqu\'à  18 000 dpi - 5 boutons programmables', '2023-06-05 12:47:50', '39.00', 500),
(51, 'Asus TUF VG27AQ Adaptive Sync + 1 jeu au choix offert sur Gamesplanet !', 'Moniteur 27&quot; IPS 165 Hz - HDR - 2560 x 1440 px (QHD) - 1 ms - DisplayPort / HDMI - Pied réglable + Rotation - Bords extra-fins - Compatible G-Sync', '2023-06-05 12:49:58', '389.00', 500),
(52, 'AOC 24G2SPAE', 'Moniteur 23.6&quot; IPS 165 Hz - Full HD - 1 ms MPRT - DisplayPort / HDMI / VGA - Bords fins', '2023-06-05 12:51:05', '169.00', 500),
(53, 'Iiyama G-Master G2470HSU-B1 FreeSync', 'Moniteur 23.8&quot; IPS LED 165 Hz - Full HD - 0.8 ms MPRT - DisplayPort / HDMI - HP intégrés - Bords extra-fins - Hub USB', '2023-06-05 12:51:44', '179.00', 500),
(54, 'AOC CQ27G2U/BK Adaptive Sync (dalle incurvée) + 1 jeu au choix offert sur Gamesplanet !', 'Moniteur 27&quot; VA 144 Hz - 2560 x 1440 px (QHD) - 1 ms - DisplayPort / HDMI (x2) - Pied réglable - Bords extra-fins - Hub USB', '2023-06-05 12:52:33', '279.00', 500),
(55, 'Gigabyte M28U VRR + 1 jeu au choix offert sur Gamesplanet !', 'Moniteur 28&quot; IPS 144 Hz - HDR 400 - 3840 x 2160 px (Ultra HD 4K) - 1 ms - DisplayPort / HDMI 2.1 (x2) - Pied réglable - Bords extra-fins - Hub USB - Switch KVM intégré', '2023-06-05 12:53:19', '589.00', 490),
(56, 'Blue Yeti USB Blackout', 'Microphone Gamer - PC - USB', '2023-06-05 12:57:12', '139.00', 497),
(57, 'Streamplify Mic Arm', 'Microphone USB - cardioäde - 2 modes de sortie audio - fonction mise en sourdine - Rétroéclairage RGB - filtre pop - bras de montage', '2023-06-05 12:57:58', '99.00', 500),
(58, 'HyperX Quadcast S', 'Microphone pour PC - USB', '2023-06-05 12:58:51', '159.00', 500),
(59, 'Razer Seiren Mini - Mercury', 'Microphone PC - USB', '2023-06-05 12:59:54', '49.00', 500),
(60, 'Elgato Wave DX', 'Microphone streaming - Cardioäde - XLR 3 broches', '2023-06-05 13:00:45', '129.00', 500),
(61, 'AVerMedia Live Streamer', 'Webcam Full HD 1080p', '2023-06-05 13:27:00', '56.00', 500),
(62, 'Logitech HD Pro Webcam C920 Refresh', 'Webcam Full HD 1080p - Résolution photo 15 Mpx', '2023-06-05 13:28:46', '99.00', 500),
(63, 'Microsoft Modern Webcam', 'Webcam Full HD 1080p - HDR et True Look - Certifiée Microsoft Teams', '2023-06-05 13:30:47', '65.00', 500),
(64, 'Razer Kiyo', 'Webcam HD 720p/60fps - Résolution photo 4 Mpx', '2023-06-05 13:32:12', '89.00', 500),
(65, 'Logitech Streamcam - Graphite', 'Stream Cam - Webcam Full HD 60 fps', '2023-06-05 13:33:00', '139.00', 498),
(66, 'Logitech G PRO X', 'Casque-micro gamer 2.0 - PC - USB ou 1 x Jack 3.5 mm - Carte Son externe', '2023-06-05 13:35:15', '99.00', 500),
(67, 'HyperX Cloud II - Gun Metal', 'Casque-micro gamer 7.1 - PC / PS4 - USB ou 1 x Jack 3.5 mm', '2023-06-05 13:36:47', '89.00', 500),
(68, 'Steelseries Arctis 9 - Noir', 'Steelseries Arctis 9 - Noir', '2023-06-05 13:38:01', '149.00', 500),
(69, 'Astro A10 Gris / Rouge', 'Casque-micro gamer - PC / PS4 / Xbox One / Mobiles / Switch - Jack 3.5 mm', '2023-06-05 13:39:56', '49.00', 500),
(70, 'Fox Spirit GHS 7.1', 'Casque-micro Gamer - PC - USB - Son surround virtuel 7.1', '2023-06-05 13:40:47', '24.00', 500),
(71, 'Aerocool Cylon Mini - Blanc', 'Boitier PC Mini Tour - mATX / Mini-ITX - USB 3.0 - Avec fenêtre (pleine taille)', '2023-06-05 13:56:50', '39.00', 500),
(72, 'Zalman S2 TG', 'Boitier PC Moyen Tour - ATX / mATX / Mini-ITX - USB 3.0 - Avec fenêtre (pleine taille)', '2023-06-05 13:57:32', '49.00', 500),
(73, 'Corsair 4000D Airflow - Noir', 'Boitier PC Moyen Tour - E-ATX / ATX / mATX / Mini-ITX - USB 3.1 Type C - Avec fenêtre (pleine taille)', '2023-06-05 13:58:43', '99.00', 500),
(74, 'NZXT H5 Flow - Blanc', 'Boitier PC Moyen Tour - ATX / mATX / Mini-ITX - USB 3.1 Type C - Avec fenêtre (pleine taille)', '2023-06-05 13:59:35', '109.00', 499),
(75, 'Mars Gaming MC-ART - Blanc', 'Boitier PC Moyen Tour - ATX / micro-ATX / Mini-ITX - USB 3.0 - Avec fenêtre (pleine taille)', '2023-06-05 14:00:34', '51.00', 500),
(76, 'Antec NX210', 'Boitier PC Moyen Tour - ATX / mATX / Mini-ITX - USB 3.0 - Avec fenêtre (pleine taille)', '2023-06-05 14:05:17', '69.00', 500),
(77, 'ASUS TUF Gaming F17 (TUF707ZC-HX023) + 1 jeu au choix offert sur Gamesplanet !', 'PC Portable Gamer 17.3&quot; Full HD (1920 x 1080) 144 Hz - Intel Core i5-12500H 12-Core 3.3 GHz - 16 Go DDR4 - SSD 512 Go - Nvidia GeForce RTX 3050 - 2.6 Kg - Sans Windows', '2023-06-05 15:24:55', '999.00', 500),
(78, 'Gigabyte G5 (GE-51FR263SH) + 1 jeu au choix offert sur Gamesplanet !', 'PC Portable Gamer 15.6&quot; Full HD (1920 x 1080) 144 Hz - Intel Core i5-12500H 12-Core 3.3 Ghz - 8 Go DDR4 - SSD 512 Go - Nvidia GeForce RTX 3050 - 1.9 Kg - Windows 11', '2023-06-05 15:26:14', '829.00', 498),
(79, 'MSI Thin GF63 (12UDX-242FR) + 1 jeu au choix offert sur Gamesplanet !', 'PC Portable Gamer 15.6\'\' Full HD (1920 x 1080) 144 Hz - Intel Core i5-12450H Octo-Core 3,3 GHz - 8 Go DDR4 - SSD 512 Go - Nvidia GeForce RTX 3050 - 1.9 Kg - Windows 11', '2023-06-05 15:27:08', '849.00', 500),
(80, 'Acer Nitro 5 (AN517-54-53A2) + 1 jeu au choix offert sur Gamesplanet !', 'PC Portable Gamer 17.3\'\' Full HD (1920 x 1080) 144 Hz - Intel Core i5-11400H Hexa-Core 2.7 GHz - 16 Go DDR4 - SSD 512 Go - Nvidia GeForce RTX 3050 - 2.7 Kg - Windows 11', '2023-06-05 15:28:33', '1079.00', 500),
(81, 'ASUS ROG Strix G17 (G713PV-LL047W) + 1 jeu au choix offert sur Gamesplanet !', 'PC Portable Gamer 17.3&quot; QHD (2560 x 1440) 240 Hz - AMD Ryzen 9 7845HX 12-Core 3 GHz - 16 Go DDR5 - SSD 1 To - Nvidia GeForce RTX 4060 - 2.8 Kg - Windows 11', '2023-06-05 15:29:33', '2299.00', 476),
(82, 'AKRacing Core EX - Rouge / Noir', 'Fauteuil Gamer - Tissu - Accoudoirs 3D réglables - Assise inclinable - Poids supporté 150 Kg', '2023-06-05 15:33:10', '249.00', 500),
(83, 'DXRacer Air R1S (rose)', 'Fauteuil Gamer - Maille respirante - Accoudoirs 3D réglables - Dossier inclinable jusqu\'à  135°- Poids supporté 114 kg', '2023-06-05 15:34:14', '289.00', 500),
(84, 'Noblechairs Icon - Noir / Bleu', 'Fauteuil Gamer - Simili Cuir - Accoudoirs 4D réglables - Poids supporté 150 Kg', '2023-06-05 15:35:18', '389.00', 500),
(85, 'Noblechairs Epic - White Edition', 'Fauteuil Gamer - Simili Cuir Hybride - Accoudoirs 4D réglables - Poids supporté 120 Kg', '2023-06-05 15:36:21', '429.00', 500),
(86, 'Vertagear S-line SL2000 - Noir / Rouge', 'Vertagear S-line SL2000 - Noir / Rouge', '2023-06-05 15:37:13', '214.00', 500),
(87, 'HTC VIVE PRO 2', 'Casque de réalité virtuelle - 5120 x 2880 - 120 Hz', '2023-06-07 12:53:25', '699.00', 496),
(88, 'HTC Station de base 2.0', 'Station de base pour VIVE Pro et VIVE Pro Eye', '2023-06-07 12:56:33', '199.00', 500),
(89, 'HTC Tracker 3.0', 'Détecteur de mouvement polyvalent pour HTC Vive', '2023-06-07 12:59:51', '139.00', 500);

-- --------------------------------------------------------

--
-- Structure de la table `responses`
--

DROP TABLE IF EXISTS `responses`;
CREATE TABLE IF NOT EXISTS `responses` (
  `response_id` int NOT NULL AUTO_INCREMENT,
  `response_text` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `comment_id` int NOT NULL,
  `response_user_id` int NOT NULL,
  `response_date` datetime NOT NULL,
  PRIMARY KEY (`response_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `responses`
--

INSERT INTO `responses` (`response_id`, `response_text`, `comment_id`, `response_user_id`, `response_date`) VALUES
(1, 'reponse', 11, 1, '2023-06-21 14:19:01');

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `user_id` int NOT NULL AUTO_INCREMENT,
  `user_email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `user_lastname` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `user_firstname` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `user_password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `user_role` tinyint NOT NULL DEFAULT '0',
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=94 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`user_id`, `user_email`, `user_lastname`, `user_firstname`, `user_password`, `user_role`) VALUES
(1, 'admin@laplateforme.io', 'Admin', 'Admin', '$2y$10$uFx8wvlAhgmw93DDzIno/O/w5g2JN20kXPwvC83HnKWfsdG1y4Fd6', 2),
(2, 'dylan@gmail.com', 'dylan', 'dylan', '$2y$10$tNWkG3pj51SovDx3dtUzMO.8z.kjTDt4w5NlVtxYhItsDbJFrVoAi', 1),
(3, 'charles@gmail.com', 'charles', 'charles', '$2y$10$VQv69RMVPjKQ/ywJ7Rexje8ZbyoQnU5qWx/tNdWFJuJdWbdAQjxAy', 1),
(43, 'test@laplateforme.io', 'test', 'test', '$2y$10$WlEaL/qLA.if9MmeF7Sv1O13ZGCR6FbjslsY7MlRv5FZlhv0VRHdK', 1),
(49, 'b@b.fr', 'bb', 'bb', '$2y$10$OFSZfMcmq192gGTUxUEBdObkYcMYu5v2yZHSUyHxqC4xbvKFdirI2', 0),
(87, 'admidn@laplateforme.io', 'pp', 'pp', '$2y$10$iybsGiZvjkopzeWt4N5XX.j6fxb.bgRT3tgy7sUeOYB3kTPpe1hn2', 0),
(88, 'admicdn@laplateforme.io', 'ccc', 'cc', '$2y$10$TMkH9irjSUspWb38DO8J7evMry70jy6Tplba5LUgW/GTRmWpsNZLO', 0),
(89, 'dylansskk@gmail.com', 'kk', 'kk', '$2y$10$sErVcqZaE1/a4ym6u2ZFhuQqpakhq2pehUSR3/CQ9aMhixiwrhdAi', 0),
(90, 'adminj@laplateforme.io', 'aaa', 'aaa', '$2y$10$5SCNj2ii5gUzCKLe7wsUaOSegM5q5UjTvjnCNQEpCQgzm0xb8jo1y', 0),
(91, 'aadmin@laplateforme.io', 'aa', 'aa', '$2y$10$tJQwMqIBQk9Qky4soVoZP.Wn.Yh2KHoMM2JMM0yF1E4GwA1Xs4sSi', 0),
(92, 'adsmin@laplateforme.io', 'ss', 's', '$2y$10$GPEwWFZHrtqyXs0y0Ce69e5QZizyPhylzbgPOPtHrc1ixV5bYQLb.', 0),
(93, 'w@laplateforme.io', 'ww', 'w', '$2y$10$tNc7uR0bjh4tA1Gkx7rveuYLuuXmAb/mqBx90p4xEq1ij8x2DQLEy', 0);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
