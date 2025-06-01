-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : dim. 01 juin 2025 à 19:11
-- Version du serveur : 9.1.0
-- Version de PHP : 8.4.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `zooarcadiaa_zoo`
--

-- --------------------------------------------------------

--
-- Structure de la table `animals`
--

DROP TABLE IF EXISTS `animals`;
CREATE TABLE IF NOT EXISTS `animals` (
  `id` int NOT NULL AUTO_INCREMENT,
  `animal_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `habitat_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `species` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `age` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `weight` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `food` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_meal` varchar(2500) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `food_quantity` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `health_comment` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `private_comment` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `unité_nourriture` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image_url` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `veterinaire` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=20 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `animals`
--

INSERT INTO `animals` (`id`, `animal_name`, `habitat_name`, `species`, `age`, `weight`, `food`, `last_meal`, `food_quantity`, `health_comment`, `private_comment`, `unité_nourriture`, `image_url`, `veterinaire`) VALUES
(1, 'kong', 'La Savane', 'Eléphant', '30 ', '5 000 ', 'Fruits, racines, feuilles', '2024-09-18T00:20', '200 ', 'très bonne santé', '...', 'kg', 'image\\savane\\elephant-7036431_1280.webp', NULL),
(2, 'Kali', 'La Savane', 'Rhinocéros ', '20 ', '3 000 ', 'Fruits, racines, feuilles, baies', '2024-09-18T00:22', '50 ', 'très bonne santé', '...', 'kg', 'image/savane/animal-2407297_1280.webp', NULL),
(3, 'Keo', 'La Savane', 'Babouin', '15 ', '22', 'Fruits, feuilles', '2024-09-18T00:13', '5', 'Malade depuis deux jours', '...', 'kg', 'image\\savane\\animal-396289_1280.webp', NULL),
(4, 'Nola et Nalo', 'La Savane', 'lionceau', '1 ', '35', 'Viandes Rouges', '2024-09-18T00:06', '70 ', 'très bonne santé', '...', 'kg', 'image\\savane\\Design sans titre (17).webp', NULL),
(5, 'Zita', 'La Savane', 'Girafe', '5', '930 ', 'Fruits, racines, feuilles, baies', '2024-09-18T00:30', '50 ', 'très bonne santé', '...', 'kg', 'image\\savane\\giraffe-2222908_1280.webp', NULL),
(6, 'Pépito', 'La Savane', 'Lion', '12', '200', 'Viandes Rouges', '2024-09-17T23:44', '40', 'très bonne santé', '...', 'kg', 'image\\savane\\Design sans titre (19).webp', NULL),
(7, 'Unaï', 'La Savane', 'Babouin', '5', '18', 'Fruits, racines, feuilles, baies', '2024-09-18T00:35', '550', 'Blessures à l\'épaule droite, point de suture ', '...', 'grammes', 'image\\savane\\mandrill-monkey-7514702_1280.webp', NULL),
(8, 'Lanac', 'La Savane', 'Autruche', '18', '97', 'Fruits, racines, feuilles, baies, vers', '2024-09-18T00:38', '7', '', '', 'kg', 'image\\savane\\ostrich-8579501_1280.webp', NULL),
(9, 'Sabi', 'La Savane', 'Lémur Cattas', '4', '2', 'Fruits, feuilles', '2024-09-18T00:40', '320', 'Très bonne santé', '', 'grammes', 'image\\savane\\lemurs-1010643_1280.webp', NULL),
(10, 'Napou', 'La Savane', 'Bébé Rhinocéros ', '1', '97', 'Lait, feuille', '2024-09-18T00:42', '8', '', '', 'Litre', 'image\\savane\\year-end_giving_hero.webp', NULL),
(11, 'Sno', 'La Savane', 'Zébre', '8', '350', 'Fruits, racines, feuilles, baies', '2024-09-18T00:43', '5', 'Très bonne santé', 'Attention, travaux à prévoir pour son environnement ', 'kg', 'image\\savane\\zebras-4258909_1280.webp', NULL),
(12, 'Bob', 'La Jungle', 'singe', '11', '35 kg', 'Fruits, graines , feuilles, baies', '2024-09-18T09:39', '5', 'Rhume de puis le 15 sept 24', '...', 'grammes', 'image\\jungle\\singe1.webp', NULL),
(13, 'Miki', 'La Jungle', 'Orang-outan', '9', '35', 'Fruits, racines, feuilles, baies', '2024-09-17T09:47', '500', 'il se porte très bien aujourd\'hui', '...', 'grammes', 'image\\jungle\\orangutan-8665012_1280.webp', NULL),
(14, 'Bingo', 'La Jungle', 'Perroquet', '5', '2,3', 'Baies, graines, plantes.', '2024-09-17T11:11', '130', 'Plumage à contrôler', '...', 'grammes', 'image\\jungle\\bird-406776_1280.webp', NULL),
(15, 'Diego', 'La Jungle', 'Orang-outan', '5', '35', 'Fruits, racines, feuilles, baies', '2024-09-18T11:15', '5', '', '', 'grammes', 'image\\jungle\\friendly-three-4602625_1280.webp', NULL),
(16, 'Marin', 'La Marais', 'Tamarin empereur ', '7', '0,35', 'Fruits, racines, feuilles, baies', '2024-09-18T11:18', '50 ', '', '', 'grammes', 'image\\marais\\Design sans titre (28).webp', NULL),
(17, 'Ninous', 'La Jungle', 'Gorille', '5', '230 Kg', 'Fruit ', '', '', 'tout va bien', 'nouveau arrivant !!! Bienvenue', '', 'image\\habitats\\Design sans titre (18).webp', NULL);

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
  `id` int NOT NULL,
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
(6, 'Pépito', 25),
(5, 'Zita', 17),
(4, 'Nola et Nalo', 7),
(8, 'Lanac', 10),
(7, 'Unaï', 9),
(9, 'Sabi', 11),
(10, 'Napou', 10),
(11, 'Sno', 10),
(12, 'Bob', 153),
(13, 'Miki', 52),
(14, 'Bingo', 28),
(15, 'Diego', 18),
(16, 'Marin', 17);

-- --------------------------------------------------------

--
-- Structure de la table `avis`
--

DROP TABLE IF EXISTS `avis`;
CREATE TABLE IF NOT EXISTS `avis` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nom` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `note` int NOT NULL,
  `avis` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT 'en attente',
  `titre` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=24 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `avis`
--

INSERT INTO `avis` (`id`, `nom`, `note`, `avis`, `status`, `titre`) VALUES
(22, 'Thomas Petit', 4, 'Un zoo magnifique dans un cadre verdoyant. C\'est très agréable de se promener et de découvrir les animaux. Seul petit bémol, il manquait un peu d\'ombre à certains endroits lors de notre visite en plein été.\" ', 'valide', 'Cadre verdoyant!!!'),
(21, 'Caroline Monté', 5, 'Nous avons passé une excellente journée au Zoo Arcadia. Les enfants ont appris beaucoup de choses sur les animaux et la conservation. Les aires de jeux sont un vrai plus pour les plus jeunes. On recommande vivement !', 'valide', 'Journée magnifique'),
(19, 'Claire', 3, 'Bonjour, visite en famille magnifique !!!', 'valide', 'retour de séjour '),
(20, 'florence', 4, 'Magnifique zoo les animaux reçoivent beaucoup d\'amour et il le rendent', 'valide', 'visite guidée'),
(23, ' Julie Roubau', 5, 'J\'ai été agréablement surpris par la propreté du parc et la variété des espèces présentées. C\'est un endroit idéal pour passer un après-midi enrichissant. Le personnel est très accueillant et donne de bonnes informations.', 'en attente', 'Surprise !!!');

-- --------------------------------------------------------

--
-- Structure de la table `compterendus`
--

DROP TABLE IF EXISTS `compterendus`;
CREATE TABLE IF NOT EXISTS `compterendus` (
  `id` int NOT NULL AUTO_INCREMENT,
  `animal_id` int DEFAULT NULL,
  `veterinaire` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `date_visite` datetime DEFAULT NULL,
  `compte_rendu` text COLLATE utf8mb4_unicode_ci,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `employe`
--

DROP TABLE IF EXISTS `employe`;
CREATE TABLE IF NOT EXISTS `employe` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `position` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `habitat_name` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `username` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(2500) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `employe`
--

INSERT INTO `employe` (`id`, `name`, `position`, `role`, `habitat_name`, `username`, `password`, `email`) VALUES
(1, 'José', 'Administrateur', 'admin', NULL, 'jose_admin', '$2y$12$FhegUY/bHRufjodaV24FOeWDITJVVYjf55a8C9cwa6NnCHIN.nwK6', 'contact@zoo-arcadia.fr'),
(2, 'Vincent', 'vétérinaire', 'veterinaire', 'La Jungle', 'Vince_veto', '$2y$12$WmY7vZ64cdDkGYmi9ERLbOHmIhV/sqaK5wSFSNq5wYgq0RDPfz9r2', 'devcodejusap@gmail.com'),
(3, 'Thibault', 'vétérinaire', 'veterinaire', 'La Savane', 'Thibault-veto', '$2y$12$4SRrLSDdLBqulUiUTxCPqOzmBtMDsF2muCxFaOlGNOesrU6VBvp5K', 'devcodejusap@gmail.com'),
(4, 'Claire', 'soignante', 'employe', 'La Savane', 'Claire_savane', '$2y$12$Om6Lg4eZ/wLYs2mSgwPCgOC0dODJsLeq6VfkhMiSq0RIF.t1YBcYi', 'devcodejusap@gmail.com'),
(5, 'Elya', 'vétérinaire', 'veterinaire', 'La Marais', 'Elya_jungle', '$2y$12$77thGus.Ow2BOonpQGHXlubm6.0l9yzkQDwx6wfRr/Lt8MMLSPR3y', 'devcodejusap@gmail.com'),
(6, 'julien', 'soignant', 'employe', 'La Marais', 'Julien_marais', '$2y$12$TgxQGA9.1k.dwpiwiaLnr.q5oVRuPMFDQfE5lN.1qKK3m.RTZJ70i', 'devcodejusap@gmail.com');

-- --------------------------------------------------------

--
-- Structure de la table `events`
--

DROP TABLE IF EXISTS `events`;
CREATE TABLE IF NOT EXISTS `events` (
  `id` int NOT NULL AUTO_INCREMENT,
  `Titre` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Description` text COLLATE utf8mb4_unicode_ci,
  `Date` date DEFAULT NULL,
  `Lieu` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `Articles` text COLLATE utf8mb4_unicode_ci,
  `Photos` text COLLATE utf8mb4_unicode_ci,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `habitats`
--

DROP TABLE IF EXISTS `habitats`;
CREATE TABLE IF NOT EXISTS `habitats` (
  `id` int NOT NULL AUTO_INCREMENT,
  `habitat_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `image_url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `habitats`
--

INSERT INTO `habitats` (`id`, `habitat_name`, `description`, `image_url`) VALUES
(1, 'La Savane', 'La savane est un habitat caractérisé par des plaines herbeuses et des arbres épars. Vous pouvez y voir des animaux tels que les lions, les éléphants et les girafes.', 'image\\habitats\\Design sans titre (19).webp'),
(2, 'La Jungle', 'La jungle est un habitat caractérisé par des forêts denses et des végétaux luxuriants. Vous pouvez y voir des animaux tels que les singes, les oiseaux et les reptiles.', 'image\\habitats\\Jungle.webp'),
(3, 'La Marais', 'Le marais est un habitat caractérisé par des zones humides et des végétaux aquatiques. Vous pouvez y voir des animaux tels que les alligators, les grenouilles et les poissons.', 'image\\habitats\\Marais.webp');

-- --------------------------------------------------------

--
-- Structure de la table `messages`
--

DROP TABLE IF EXISTS `messages`;
CREATE TABLE IF NOT EXISTS `messages` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `message` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `messages`
--

INSERT INTO `messages` (`id`, `name`, `email`, `message`, `created_at`) VALUES
(1, 'le Nir', 'devcodejusap@gmail.com', 'Bonjour , j\'aimerais vous rencontre pour faire un reportage photos de votre ZOO . \nCordialement Mr Le Nir', '2025-06-01 17:33:41');

-- --------------------------------------------------------

--
-- Structure de la table `registration_requests`
--

DROP TABLE IF EXISTS `registration_requests`;
CREATE TABLE IF NOT EXISTS `registration_requests` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `role` enum('employe','veterinaire') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('pending','approved','rejected') COLLATE utf8mb4_unicode_ci DEFAULT 'pending',
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
  `service_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `paragraph` text COLLATE utf8mb4_unicode_ci,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `services`
--

INSERT INTO `services` (`id`, `service_name`, `paragraph`) VALUES
(1, 'Express Arcadia', 'Le Express Arcadia est un service emblématique du Zoo Arcadia qui propose aux visiteurs une expérience unique de découverte du parc à bord d\'un petit train. Cette balade pittoresque permet aux familles de se relaxer tout en explorant les divers habitats du zoo, tels que la savane africaine, les marais luxuriants, et la jungle dense. Le trajet en train offre une perspective différente et agréable sur la faune et la flore, rendant la visite à la fois éducative et divertissante. En plus de faciliter l\'accès aux différentes sections du zoo, l\'Express Arcadia est conçu pour être une aventure mémorable, permettant aux visiteurs de profiter pleinement de leur journée tout en découvrant les merveilles de la nature à un rythme tranquille.'),
(2, 'Restaurant', 'Le restaurant du Zoo Arcadia propose une expérience culinaire unique où les visiteurs peuvent profiter d\'une pause gourmande tout en étant proches des animaux. Situé stratégiquement pour offrir une vue imprenable sur les paysages enchanteurs du zoo, le restaurant met en avant une cuisine qui utilise des produits locaux frais. Le cadre du restaurant permet aux visiteurs de se sentir connectés à la nature environnante, rendant chaque repas mémorable et immersif'),
(3, 'La nurserie du Zoo', 'La nurserie du Zoo Arcadia est un lieu fascinant où les visiteurs peuvent découvrir les premiers stades de la vie animale dans un cadre sécurisé et éducatif. Cette installation spéciale est dédiée aux soins et à l\'élevage des jeunes animaux, offrant un aperçu unique de leur développement et des efforts de conservation déployés par le zoo. Les visiteurs ont l\'occasion d\'observer de près les nourrissons animaux, tels que les bébés mammifères, oiseaux et reptiles, tout en apprenant sur les soins spécifiques dont ils ont besoin. La nurserie est non seulement un espace de découverte, mais aussi un centre d\'éducation où les experts partagent leurs connaissances sur l\'importance de la protection des espèces et des habitats naturels. Cette expérience immersive permet aux visiteurs de se connecter avec la faune de manière significative, tout en soutenant les initiatives de conservation du Zoo'),
(4, 'La visite des habitats avec guide gratuit', 'Le Zoo Arcadia offre aux visiteurs une opportunité exceptionnelle de découvrir la diversité du monde animal de manière approfondie et interactive. Accompagnés par un guide expérimenté, les participants explorent les différents habitats recréés dans le zoo, tels que la savane africaine, la forêt tropicale et les zones humides. Chaque visite est enrichie par des explications détaillées sur les caractéristiques uniques des animaux, leur comportement, et les efforts de conservation en cours. Cette expérience éducative permet aux visiteurs de poser des questions et d\'obtenir des réponses personnalisées, rendant la visite à la fois informative et engageante. En offrant ces visites guidées gratuitement, le Zoo Arcadia s\'engage à sensibiliser le public à la biodiversité et à l\'importance de la protection des espèces dans leur milieu naturel.\n\n');

-- --------------------------------------------------------

--
-- Structure de la table `service_images`
--

DROP TABLE IF EXISTS `service_images`;
CREATE TABLE IF NOT EXISTS `service_images` (
  `id` int NOT NULL AUTO_INCREMENT,
  `service_id` int NOT NULL,
  `image_url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `alt_text` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `service_id` (`service_id`)
) ENGINE=MyISAM AUTO_INCREMENT=23 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `service_images`
--

INSERT INTO `service_images` (`id`, `service_id`, `image_url`, `alt_text`) VALUES
(1, 1, 'image/services/Arcadia-expresse.webp', 'Express Arcadia photo'),
(2, 1, 'image/services/Capture_d\'écran_2024-05-07_232710.webp', 'Express Arcadia photo'),
(3, 1, 'image/services/longleat-gallery-12.webp', 'Express Arcadia photo'),
(4, 1, 'image/services/Untitled-design---2022-08-22T162725.484.webp', 'Express Arcadia photo'),
(5, 1, 'image/services/Untitled-design---2022-08-22T162807.835.webp', 'Express Arcadia photo'),
(6, 1, 'image/services/Untitled-design---2022-08-22T162821.651.webp', 'Express Arcadia photo'),
(7, 2, 'image/services/Capture_d\'écran_2024-05-08_092727.webp', 'Restaurant photo'),
(8, 2, 'image/services/Capture_d\'écran_2024-05-08_092825.webp', 'Restaurant photo'),
(9, 2, 'image/services/Capture_d\'écran_2024-05-08_093305.webp', 'Restaurant photo'),
(10, 2, 'image/services/https___s3.eu-west-3.amazonaws.com_images.zoobeauval.com_kilimandjaro-3-5eda083db8c76.webp', 'Restaurant photo'),
(11, 3, 'image/services/guide2.webp', 'La nurserie du Zoo photo'),
(12, 3, 'image/services/guide5.webp', 'La nurserie du Zoo photo'),
(13, 3, 'image/services/pexels-freestockpro-1003848.webp', 'La nurserie du Zoo photo'),
(14, 3, 'image/services/pexels-jared-butler-1321877-2538270.webp', 'La nurserie du Zoo photo'),
(15, 3, 'image/services/pexels-prasanthdas-1670413.webp', 'La nurserie du Zoo photo'),
(16, 3, 'image/services/pexels-richard-low-hong-33206323-7348812.webp', 'La nurserie du Zoo photo'),
(17, 3, 'image/services/pexels-tasveerwala-2861847.webp', 'La nurserie du Zoo photo'),
(18, 3, 'image/services/rhino-8816631_1280.webp', 'La nurserie du Zoo photo'),
(19, 4, 'image/services/guide3.webp', 'La visite des habitats avec guide gratuit photo'),
(20, 4, 'image/services/guide4.webp', 'La visite des habitats avec guide gratuit photo'),
(21, 4, 'image/services/guide6.webp', 'La visite des habitats avec guide gratuit photo'),
(22, 4, 'image/services/guide7.webp', 'La visite des habitats avec guide gratuit photo');

-- --------------------------------------------------------

--
-- Structure de la table `visitors`
--

DROP TABLE IF EXISTS `visitors`;
CREATE TABLE IF NOT EXISTS `visitors` (
  `id` int NOT NULL AUTO_INCREMENT,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `visit_date` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `visitors`
--

INSERT INTO `visitors` (`id`, `ip_address`, `visit_date`) VALUES
(1, NULL, '2025-06-01 19:40:07'),
(2, NULL, '2025-06-01 19:40:34'),
(3, NULL, '2025-06-01 19:41:50'),
(4, NULL, '2025-06-01 19:52:23');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
