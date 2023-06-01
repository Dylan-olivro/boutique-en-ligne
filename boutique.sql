-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : mer. 31 mai 2023 à 10:44
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
-- Structure de la table `adress`
--

DROP TABLE IF EXISTS `adress`;
CREATE TABLE IF NOT EXISTS `adress` (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_user` int NOT NULL,
  `numero` int NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `postcode` int NOT NULL,
  `city` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `adress`
--

INSERT INTO `adress` (`id`, `id_user`, `numero`, `name`, `postcode`, `city`) VALUES
(1, 1, 75, 'rue Leon Jouhaux', 83200, 'TOULON'),
(10, 43, 1212, 'DSSD', 2122, 'SDSD'),
(13, 1, 82, 'sjdkd\'\"é', 888, 'KSD'),
(14, 1, 67, '²ghg', 8787, 'GH');

-- --------------------------------------------------------

--
-- Structure de la table `cart`
--

DROP TABLE IF EXISTS `cart`;
CREATE TABLE IF NOT EXISTS `cart` (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_user` int NOT NULL,
  `id_item` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `cart`
--

INSERT INTO `cart` (`id`, `id_user`, `id_item`) VALUES
(4, 2, 4),
(5, 2, 1),
(6, 3, 3),
(7, 3, 3),
(22, 1, 26);

-- --------------------------------------------------------

--
-- Structure de la table `category`
--

DROP TABLE IF EXISTS `category`;
CREATE TABLE IF NOT EXISTS `category` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `id_parent` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=35 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
  `id` int NOT NULL AUTO_INCREMENT,
  `code` varchar(20) COLLATE utf8mb4_general_ci NOT NULL,
  `pourcentage` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `codes`
--

INSERT INTO `codes` (`id`, `code`, `pourcentage`) VALUES
(1, 'ruben', 100);

-- --------------------------------------------------------

--
-- Structure de la table `command`
--

DROP TABLE IF EXISTS `command`;
CREATE TABLE IF NOT EXISTS `command` (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_user` int NOT NULL,
  `date` datetime NOT NULL,
  `total` decimal(10,2) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `command`
--

INSERT INTO `command` (`id`, `id_user`, `date`, `total`) VALUES
(2, 1, '2023-05-30 11:19:38', '0.00'),
(3, 1, '2023-05-30 11:21:44', '0.00'),
(4, 1, '2023-05-30 11:47:33', '0.00'),
(5, 1, '2023-05-30 13:40:01', '0.00'),
(6, 1, '2023-05-30 13:40:38', '0.00'),
(7, 1, '2023-05-30 13:44:01', '74.98'),
(8, 1, '2023-05-30 13:44:38', '214.98');

-- --------------------------------------------------------

--
-- Structure de la table `image`
--

DROP TABLE IF EXISTS `image`;
CREATE TABLE IF NOT EXISTS `image` (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_item` int NOT NULL,
  `name_image` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `main` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=42 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `image`
--

INSERT INTO `image` (`id`, `id_item`, `name_image`, `main`) VALUES
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
(41, 1, '64763182882463.61113165.webp', 0);

-- --------------------------------------------------------

--
-- Structure de la table `items`
--

DROP TABLE IF EXISTS `items`;
CREATE TABLE IF NOT EXISTS `items` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `description` text COLLATE utf8mb4_general_ci NOT NULL,
  `date` datetime NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `stock` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=42 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `items`
--

INSERT INTO `items` (`id`, `name`, `description`, `date`, `price`, `stock`) VALUES
(1, 'AMD Ryzen 5 5600X (3.7 GHz)', 'Processeur Socket AM4 - Hexa Core - Cache 35 Mo - Vermeer', '2023-05-30 14:55:55', '187.00', 500),
(2, 'DDR5 Corsair Vengeance - 32 Go (2 x 16 Go) 5200 MHz - CAS 40', 'MÃ©moire DDR5 - PC-41600 - Low-Profile', '2023-05-30 14:56:40', '179.00', 500),
(3, 'Intel Core i5-13600KF (3.5 GHz)', 'Processeur Socket 1700 - 14 coeurs - Cache 24 Mo - Raptor Lake - Ventirad non inclus', '2023-05-30 14:59:22', '369.00', 500),
(4, 'DDR5 Kingston Fury Beast Black - 32 Go (2 x 16 Go) 5600 MHz - CAS 40', 'MÃ©moire DDR5 - PC-44800 - Low-Profile', '2023-05-30 14:59:38', '159.00', 500),
(5, 'AMD Ryzen 5 5600 (3.5 GHz)', 'Processeur Socket AM4 - Hexa Core - Cache 35 Mo - Vermeer - Ventirad inclus', '2023-05-30 15:00:01', '169.00', 500),
(6, 'AMD Ryzen 7 5700X (3.4 GHz)', 'Processeur Socket AM4 - Octo Core - Cache 36 Mo - Vermeer - Ventirad non inclus', '2023-05-30 15:00:38', '244.00', 500),
(7, 'DDR4 G.Skill Trident Z RGB - 16 Go (2 x 8 Go) 3600 MHz - CAS 18', 'Kit Dual Channel - MÃ©moire DDR4 optimisÃ©e Intel - PC-28800 - LED RGB', '2023-05-30 15:00:56', '53.00', 500),
(8, 'Intel Core i5-12400F (2.5 GHz)', 'Processeur Socket 1700 - Hexa Core - Cache 18 Mo - Alder Lake - Ventirad inclus', '2023-05-30 15:01:46', '178.00', 500),
(9, 'DDR5 Crucial PRO - 32 Go (2 x 16 Go) 5600 MHz - CAS 46', 'MÃ©moire DDR5 - PC-44800 - Low-Profile - OptimisÃ©e AMD EXPO', '2023-05-30 15:02:16', '129.00', 500),
(10, 'DDR5 Textorm - 32 Go (2 x 16 Go) 4800 MHz - CAS 40', 'MÃ©moire DDR5 - PC-38400 - Low-Profile', '2023-05-30 15:03:09', '139.00', 500),
(11, 'Gainward GeForce RTX 4070 Ghost + Diablo IV offert !', 'Carte graphique - Avec backplate - Compatible VR', '2023-05-30 15:03:10', '610.00', 500),
(12, 'Asus Radeon RX 6650 XT DUAL O8G', 'Carte graphique - Refroidissement semi-passif (mode 0 dB) - Avec backplate - Compatible VR', '2023-05-30 15:03:57', '299.00', 500),
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
(24, 'ASRock B760M PG SONIC WIFI', 'Carte mÃ¨re mATX - Socket 1700 - Chipset Intel B760 - USB 3.1 Type C - SATA 6 Gb/s - M.2 - Wifi - LED intÃ©grÃ©es', '2023-05-30 15:09:21', '199.00', 500),
(25, 'Intel SSD 670P Series 2 To', 'SSD M.2 - PCI-Express 3.0 NVMe - Lecture max : 3500 Mo/s - Ecriture max : 2700 Mo/s - MÃ©moire QLC 3D4', '2023-05-30 15:09:57', '99.00', 500),
(26, 'Aerocool Lux RGB 750M - 750W', 'Alimentation PC CertifiÃ©e 80+ Bronze - Semi-Modulaire', '2023-05-30 15:10:05', '74.00', 500),
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
(39, 'Adaptateur USB 3.0 Type C MÃ¢le vers USB 3.0 Type A Femelle', 'Cet adaptateur adaptateur USB Type C MÃ¢le / USB 3.0 Type A Femelle permet de connecter tout accessoire ou pÃ©riphÃ©rique prÃ©vu pour de l\'USB C via un port USB 3.0 Type A.', '2023-05-30 15:28:12', '0.00', 500),
(40, 'CÃ¢ble SATA - 50 cm', 'CÃ¢ble SATA MÃ¢le / MÃ¢le', '2023-05-30 15:29:15', '5.00', 500),
(41, 'é&amp;èà&quot;ç&#039;&amp;&quot;éà&#039;è', 'è(&#039;è&quot;éç(éè&quot;&#039;àç&quot;è&#039;(à', '2023-05-30 21:04:52', '0.00', 500);

-- --------------------------------------------------------

--
-- Structure de la table `liaison_cart_command`
--

DROP TABLE IF EXISTS `liaison_cart_command`;
CREATE TABLE IF NOT EXISTS `liaison_cart_command` (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_item` int NOT NULL,
  `id_command` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `liaison_cart_command`
--

INSERT INTO `liaison_cart_command` (`id`, `id_item`, `id_command`) VALUES
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
(16, 3, 8);

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
) ENGINE=InnoDB AUTO_INCREMENT=42 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
(41, 41, 0);

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `email` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `lastname` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `firstname` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `role` tinyint NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=46 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`id`, `email`, `lastname`, `firstname`, `password`, `role`) VALUES
(1, 'admin@laplateforme.io', 'admin', 'admin', '$2y$10$uFx8wvlAhgmw93DDzIno/O/w5g2JN20kXPwvC83HnKWfsdG1y4Fd6', 2),
(2, 'dylan@gmail.com', 'dylan', 'dylan', '$2y$10$tNWkG3pj51SovDx3dtUzMO.8z.kjTDt4w5NlVtxYhItsDbJFrVoAi', 1),
(3, 'charles@gmail.com', 'charles', 'charles', '$2y$10$VQv69RMVPjKQ/ywJ7Rexje8ZbyoQnU5qWx/tNdWFJuJdWbdAQjxAy', 1),
(43, 'test@laplateforme.io', 'test', 'test', '$2y$10$WlEaL/qLA.if9MmeF7Sv1O13ZGCR6FbjslsY7MlRv5FZlhv0VRHdK', 0),
(44, 'a@a.com', 'a', 'a', '$2y$10$.Vcm4lUDwH.ReZykIA08r.Eaf1aTr2pG917YNMhU4PNHRon6SLrqK', 0),
(45, 'b@b.fr', 'b', 'b', '$2y$10$05svi32Xuvgd2S5HrpMNoud1WdPsGA8XK8N9aVdIDuDpCnVdJZk1S', 0);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
