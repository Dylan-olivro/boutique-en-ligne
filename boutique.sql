-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : mar. 16 mai 2023 à 10:13
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `items`
--

INSERT INTO `items` (`id`, `name`, `description`, `date`, `price`, `stock`, `image`) VALUES
(1, 'Corsair K55 RGB PRO (AZERTY)', 'Clavier Gamer - Rétroéclairage 16.8M de couleurs - Anti-ghosting', '2023-05-15 10:33:19', '64.99', 1000, ''),
(16, 'Logitech G502 HERO', 'Souris Gamer optique - Résolution ajustable 100 à 16 000 dpi - 11 boutons programmables', '2023-05-15 13:54:39', '49.99', 500, '');

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
(1, 1, 5),
(10, 16, 6);

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
  `role` tinyint(4) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT pour la table `liaison_items_category`
--
ALTER TABLE `liaison_items_category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
