-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : ven. 20 sep. 2024 à 10:02
-- Version du serveur : 8.3.0
-- Version de PHP : 8.3.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `zooarcadia`
--

-- --------------------------------------------------------

--
-- Structure de la table `animals`
--

DROP TABLE IF EXISTS `animals`;
CREATE TABLE IF NOT EXISTS `animals` (
  `id` int NOT NULL AUTO_INCREMENT,
  `animal_name` varchar(255) NOT NULL,
  `habitat_name` varchar(255) NOT NULL,
  `species` varchar(255) NOT NULL,
  `age` varchar(255) DEFAULT NULL,
  `weight` varchar(255) DEFAULT NULL,
  `food` varchar(255) NOT NULL,
  `last_meal` varchar(2500) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `food_quantity` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `health_comment` text NOT NULL,
  `private_comment` text NOT NULL,
  `unité_nourriture` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `animals`
--

INSERT INTO `animals` (`id`, `animal_name`, `habitat_name`, `species`, `age`, `weight`, `food`, `last_meal`, `food_quantity`, `health_comment`, `private_comment`, `unité_nourriture`) VALUES
(1, 'kong', 'La Savane', 'Eléphant', '30 ', '5 000 ', 'Fruits, racines, feuilles', '2024-09-18T00:20', '200 ', 'très bonne santé', '...', 'kg'),
(2, 'Kali', 'La Savane', 'Rhinocéros ', '20 ', '3 000 ', 'Fruits, racines, feuilles, baies', '2024-09-18T00:22', '50 ', 'très bonne santé', '...', 'kg'),
(3, 'Keo', 'La Savane', 'Babouin', '15 ', '22', 'Fruits, feuilles', '2024-09-18T00:13', '5', 'très bonne santé', '...', 'kg'),
(4, 'Nola et Nalo', 'La Savane', 'lionceau', '1 ', '35', 'Viandes Rouges', '2024-09-18T00:06', '70 ', 'très bonne santé', '...', 'kg'),
(5, 'Zita', 'La Savane', 'Girafe', '5', '930 ', 'Fruits, racines, feuilles, baies', '2024-09-18T00:30', '50 ', 'très bonne santé', '...', 'kg'),
(6, 'Pépito', 'La Savane', 'Lion', '12', '200', 'Viandes Rouges', '2024-09-17T23:44', '40', 'très bonne santé', '...', 'kg'),
(7, 'Unaï', 'La Savane', 'Babouin', '5', '18', 'Fruits, racines, feuilles, baies', '2024-09-18T00:35', '550', 'Blessures à l\'épaule droite, point de suture ', '...', 'grammes'),
(8, 'Lanac', 'La Savane', 'Autruche', '18', '97', 'Fruits, racines, feuilles, baies, vers', '2024-09-18T00:38', '7', '', '', 'kg'),
(9, 'Sabi', 'La Savane', 'Lémur Cattas', '4', '2', 'Fruits, feuilles', '2024-09-18T00:40', '320', 'Très bonne santé', '', 'grammes'),
(10, 'Napou', 'La Savane', 'Bébé Rhinocéros ', '1', '97', 'Lait, feuille', '2024-09-18T00:42', '8', '', '', 'Litre'),
(11, 'Sno', 'La Savane', 'Zébre', '8', '350', 'Fruits, racines, feuilles, baies', '2024-09-18T00:43', '5', 'Très bonne santé', 'Attention, travaux à prévoir pour sont environnement ', 'kg'),
(12, 'Bob', 'La Jungle', 'singe', '11', '35 kg', 'Fruits, graines , feuilles, baies', '2024-09-18T09:39', '5', 'Rhume de puis le 15 sept 24', '...', 'grammes'),
(13, 'Miki', 'La Jungle', 'Orang-outan', '9', '35', 'Fruits, racines, feuilles, baies', '2024-09-17T09:47', '500', '...', '...', 'grammes'),
(14, 'Bingo', 'La Jungle', 'Perroquet', '5', '2,3', 'Baies, graines, plantes.', '2024-09-17T11:11', '130', 'Plumage à contrôler', '...', 'grammes'),
(15, 'Diego', 'La Jungle', 'Orang-outan', '5', '35', 'Fruits, racines, feuilles, baies', '2024-09-18T11:15', '5', '', '', 'grammes'),
(16, 'Marin', 'La Jungle', 'Tamarin empereur ', '7', '0,35', 'Fruits, racines, feuilles, baies', '2024-09-18T11:18', '50 ', '', '', 'grammes');

--
-- Déclencheurs `animals`
--
DROP TRIGGER IF EXISTS `after_animal_insert`;
DELIMITER $$
CREATE TRIGGER `after_animal_insert` AFTER INSERT ON `animals` FOR EACH ROW BEGIN
    INSERT INTO animal_likes (id, animal_name) VALUES (NEW.id, NEW.animal_name);
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Structure de la table `animal_likes`
--

DROP TABLE IF EXISTS `animal_likes`;
CREATE TABLE IF NOT EXISTS `animal_likes` (
  `id` int NOT NULL AUTO_INCREMENT,
  `animal_name` varchar(2500) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `likes` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MEMORY AUTO_INCREMENT=23 DEFAULT CHARSET=utf8mb4 CHECKSUM=1 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

--
-- Déchargement des données de la table `animal_likes`
--

INSERT INTO `animal_likes` (`id`, `animal_name`, `likes`) VALUES
(1, 'kong', 70),
(2, 'Kali', 30),
(3, 'Keo', 14),
(6, 'Pépito', 24),
(5, 'Zita', 17),
(4, 'Nola et Nalo', 7),
(8, 'Lanac', 9),
(7, 'Unaï', 8),
(9, 'Sabi', 10),
(10, 'Napou', 9),
(11, 'Sno', 10),
(12, 'Bob', 152),
(13, 'Miki', 51),
(14, 'Bingo', 27),
(15, 'Diego', 17),
(16, 'Marin', 12),
(17, '', 7),
(18, '', 5),
(19, '', 1),
(20, '', 1),
(22, '', 5);

-- --------------------------------------------------------

--
-- Structure de la table `avis`
--

DROP TABLE IF EXISTS `avis`;
CREATE TABLE IF NOT EXISTS `avis` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nom` varchar(255) NOT NULL,
  `age` int DEFAULT NULL,
  `note` int NOT NULL,
  `avis` text NOT NULL,
  `status` varchar(50) DEFAULT 'en attente',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=19 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `avis`
--

INSERT INTO `avis` (`id`, `nom`, `age`, `note`, `avis`, `status`) VALUES
(12, 'zsefsve', 0, 4, 'caefcaec', 'validé'),
(13, 'wdfbsfdgnsrtbnqsrtb', NULL, 4, 'qtbqetbqetrbqetbqrtb', 'validé'),
(14, 'wdfbsfdgnsrtbnqsrtb', NULL, 4, 'qtbqetbqetrbqetbqrtb', 'validé'),
(15, 'wdfbsfdgnsrtbnqsrtb', NULL, 4, 'qtbqetbqetrbqetbqrtb', 'validé'),
(16, 'wdfbsfdgnsrtbnqsrtb', NULL, 4, 'qtbqetbqetrbqetbqrtb', 'validé'),
(17, 'Julien ', NULL, 5, 'zetergergv', 'en attente'),
(18, 'Julien ', NULL, 5, 'zetergergv', 'en attente');

-- --------------------------------------------------------

--
-- Structure de la table `employe`
--

DROP TABLE IF EXISTS `employe`;
CREATE TABLE IF NOT EXISTS `employe` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `position` varchar(255) NOT NULL,
  `role` varchar(50) NOT NULL,
  `habitat` varchar(50) DEFAULT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(2500) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `employe`
--

INSERT INTO `employe` (`id`, `name`, `position`, `role`, `habitat`, `username`, `password`, `email`) VALUES
(1, 'José', 'Administrateur', 'admin', 'admin', 'jose_admin', 'Password.123!', 'contact@zoo-arcadia.fr'),
(2, 'Vincent', 'vétérinaire', 'employé', 'services', 'Vince_veto', 'Vince.12345!', 'devcodejusap@gmail.com'),
(3, 'Thibault', 'vétérinaire', 'vétérinaire', 'Tous', 'Thibault-veto', 'TITI.12345!', 'devcodejusap@gmail.com'),
(4, 'Claire', 'soignante', 'employé', 'savane', 'Claire_savane', 'Claire.12345!', 'devcodejusap@gmail.com'),
(5, 'Elya', 'soignante', 'employé', 'jungle', 'Elya_jungle', 'Elya.12345!', 'devcodejusap@gmail.com'),
(6, 'julien', 'soignant', 'employé', 'marais', 'Julien_marais', 'Julien.12345!', 'devcodejusap@gmail.com');

-- --------------------------------------------------------

--
-- Structure de la table `habitats`
--

DROP TABLE IF EXISTS `habitats`;
CREATE TABLE IF NOT EXISTS `habitats` (
  `id` int NOT NULL AUTO_INCREMENT,
  `habitat_name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `habitats`
--

INSERT INTO `habitats` (`id`, `habitat_name`) VALUES
(1, 'Savane'),
(2, 'Jungle'),
(3, 'Marais');

-- --------------------------------------------------------

--
-- Structure de la table `registration_requests`
--

DROP TABLE IF EXISTS `registration_requests`;
CREATE TABLE IF NOT EXISTS `registration_requests` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `role` enum('employe','veterinaire') DEFAULT NULL,
  `status` enum('pending','approved','rejected') DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=27 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `services`
--

DROP TABLE IF EXISTS `services`;
CREATE TABLE IF NOT EXISTS `services` (
  `id` int NOT NULL AUTO_INCREMENT,
  `service_name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `services`
--

INSERT INTO `services` (`id`, `service_name`) VALUES
(1, 'Express Arcadia'),
(2, 'Restaurant'),
(3, 'Visite guidée'),
(5, 'Nurserie');

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `role`) VALUES
(1, 'admin', '12345', 'admin');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
