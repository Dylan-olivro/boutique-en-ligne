-- phpMyAdmin SQL Dump
-- version 5.1.3
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost:3306
-- Généré le : mer. 17 mai 2023 à 14:03
-- Version du serveur : 5.5.68-MariaDB
-- Version de PHP : 7.4.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `dylan-olivro_boutique`
--

-- --------------------------------------------------------

--
-- Structure de la table `category`
--

CREATE TABLE `category` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `id_parent` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

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
-- Structure de la table `items`
--

CREATE TABLE `items` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `date` datetime NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `stock` int(11) NOT NULL,
  `image` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `items`
--

INSERT INTO `items` (`id`, `name`, `description`, `date`, `price`, `stock`, `image`) VALUES
(1, 'Ducky Channel One 2 Mini RGB Blanc (Cherry MX Blue) (AZERTY)', 'Clavier Gamer mécanique - Rétroéclairage RGB - Switch Cherry MX Blue', '2023-05-17 13:24:15', '114.99', 500, 'assets/img_item/'),
(2, 'Razer Basilisk v3', 'Souris Gamer optique - Résolution ajustable 26 000 dpi - 11 boutons programmables', '2023-05-17 13:24:20', '69.99', 500, 'assets/img_item/'),
(3, 'Ducky Channel One 2 Mini RGB Noir (Cherry MX Speed Silver) (AZERTY)', 'Clavier Gamer mécanique - Rétroéclairage RGB - Switch Cherry MX Speed Silver', '2023-05-17 13:25:09', '114.99', 500, 'assets/img_item/'),
(4, 'Razer Cynosa Lite (AZERTY)', 'Clavier Gamer - Rétroéclairage 16.8 millions de couleurs - Anti-ghosting', '2023-05-17 13:26:08', '34.99', 500, 'assets/img_item/'),
(5, 'Logitech G502 HERO', 'Souris Gamer optique - Résolution ajustable 100 à  16 000 dpi - 11 boutons programmables', '2023-05-17 13:26:21', '49.99', 500, 'assets/img_item/'),
(6, 'Razer Ornata V3 X (AZERTY)', 'Clavier Gamer - Switchs membrane silencieux - RGB', '2023-05-17 13:26:51', '49.99', 500, 'assets/img_item/'),
(7, 'Razer Viper Ultimate + Dock de recharge', 'Souris Gamer optique sans-fil - Résolution jusqu\'à  20 000 dpi - 8 boutons programmables', '2023-05-17 13:27:17', '109.99', 500, 'assets/img_item/'),
(8, 'Speedlink Ludicium (AZERTY)', 'Clavier Gamer', '2023-05-17 13:27:18', '9.99', 500, 'assets/img_item/'),
(9, 'Spirit Of Gamer Pro-K5 (AZERTY)', 'Clavier Gamer - Rétroéclairage 16.8 millions de couleurs - Anti-ghosting - Touches semi-mécaniques', '2023-05-17 13:27:45', '24.99', 500, 'assets/img_item/'),
(10, 'Logitech G910 Orion Spectrum (Romer-G) (AZERTY)', 'Clavier Gamer mécanique - Rétroéclairage 16.8M de couleurs touche par touche - Switches Romer-G', '2023-05-17 13:28:55', '79.99', 500, 'assets/img_item/'),
(11, 'Razer Naga Trinity', 'Souris Gamer optique - Résolution ajustable 16000 DPI - Jusqu\'à  19 boutons programmables - 3 faces latérales interchangeables', '2023-05-17 13:30:43', '79.99', 500, 'assets/img_item/'),
(12, 'Ducky Channel One 3 TKL Yellow (Cherry MX Blue) (AZERTY)', 'Clavier Gamer mécanique - Rétroéclairage RGB - Switch Cherry MX Blue - Format TKL', '2023-05-17 13:31:16', '169.99', 500, 'assets/img_item/'),
(13, 'Cooler Master MM720 - Matte Black', 'Souris Gamer optique - Résolution ajustable 16000 DPI - RGB - 6 boutons - 49 grammes', '2023-05-17 13:32:31', '49.99', 500, 'assets/img_item/'),
(14, 'Roccat Kone PRO - Noir', 'Souris Gamer optique - Résolution ajustable jusqu\'à  19000 dpi - RGB', '2023-05-17 13:33:23', '49.99', 500, 'assets/img_item/'),
(15, 'Logitech G PRO X + Réduction avec le code MOANA', 'Casque-micro gamer 2.0 - PC - USB ou 1 x Jack 3.5 mm - Carte Son externe', '2023-05-17 13:34:12', '99.99', 500, 'assets/img_item/'),
(16, 'Cooler Master MM720 - Matte White', 'Souris Gamer optique - Résolution ajustable 16000 DPI - RGB - 6 boutons - 49 grammes', '2023-05-17 13:34:28', '49.99', 500, 'assets/img_item/'),
(17, 'Steelseries Arctis 9 - Noir', 'Casque-micro gamer Sans-fil DTS 2.0 - PC / PS4 - USB', '2023-05-17 13:34:47', '149.99', 500, 'assets/img_item/'),
(18, 'Astro A10 Gris / Rouge + Réduction avec le code MOANA', 'Casque-micro gamer - PC / PS4 / Xbox One / Mobiles / Switch - Jack 3.5 mm', '2023-05-17 13:35:36', '49.99', 500, 'assets/img_item/'),
(19, 'Fox Spirit GHS 7.1', 'Casque-micro Gamer - PC - USB - Son surround virtuel 7.1', '2023-05-17 13:36:05', '24.99', 500, 'assets/img_item/'),
(20, 'Logitech G435 Lightspeed - Bleu', 'Casque-micro gamer Sans fil Dolby Atmos - PC / PS4 / PS5 - USB', '2023-05-17 13:36:48', '74.99', 500, 'assets/img_item/'),
(21, 'Razer Deathadder v2', 'Souris Gamer optique - Résolution ajustable jusqu\'à  20 000 dpi - 8 boutons programmables - RGB', '2023-05-17 13:37:19', '49.99', 500, 'assets/img_item/'),
(22, 'Ducky Channel One 3 Fuji (Cherry MX Black) (AZERTY)', 'Clavier Gamer mécanique - Switch Cherry MX Black', '2023-05-17 13:41:02', '149.99', 500, 'assets/img_item/');

-- --------------------------------------------------------

--
-- Structure de la table `liaison_items_category`
--

CREATE TABLE `liaison_items_category` (
  `id` int(11) NOT NULL,
  `id_item` int(11) NOT NULL,
  `id_category` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `liaison_items_category`
--

INSERT INTO `liaison_items_category` (`id`, `id_item`, `id_category`) VALUES
(1, 1, 5),
(2, 2, 6),
(3, 3, 5),
(4, 4, 5),
(5, 5, 6),
(6, 6, 5),
(7, 7, 6),
(8, 8, 5),
(9, 9, 5),
(10, 10, 5),
(11, 11, 6),
(12, 12, 5),
(13, 13, 6),
(14, 14, 6),
(15, 15, 9),
(16, 16, 6),
(17, 17, 9),
(18, 18, 9),
(19, 19, 9),
(20, 20, 9),
(21, 21, 6),
(22, 22, 5);

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `lastname` varchar(255) NOT NULL,
  `firstname` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` tinyint(4) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`id`, `email`, `lastname`, `firstname`, `password`, `role`) VALUES
(1, 'admin@laplateforme.io', 'admin', 'admin', '$2y$10$5PC7BhLTTxbEajUTBWGcieJZoW/HQwsQeHZnGJh7EtmTPh.CfnzWy', 2),
(2, 'dylan@gmail.com', 'dylan', 'dylan', '$2y$10$tNWkG3pj51SovDx3dtUzMO.8z.kjTDt4w5NlVtxYhItsDbJFrVoAi', 1),
(3, 'charles@gmail.com', 'charles', 'charles', '$2y$10$VQv69RMVPjKQ/ywJ7Rexje8ZbyoQnU5qWx/tNdWFJuJdWbdAQjxAy', 1),
(43, 'test@laplateforme.io', 'test', 'test', '$2y$10$WlEaL/qLA.if9MmeF7Sv1O13ZGCR6FbjslsY7MlRv5FZlhv0VRHdK', 0);

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `items`
--
ALTER TABLE `items`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `liaison_items_category`
--
ALTER TABLE `liaison_items_category`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `category`
--
ALTER TABLE `category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT pour la table `items`
--
ALTER TABLE `items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT pour la table `liaison_items_category`
--
ALTER TABLE `liaison_items_category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
