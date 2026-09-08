-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : mar. 08 sep. 2026 à 06:45
-- Version du serveur : 8.3.0
-- Version de PHP : 8.4.24

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `ecf2_lucas`
--

-- --------------------------------------------------------

--
-- Structure de la table `absence`
--

DROP TABLE IF EXISTS `absence`;
CREATE TABLE IF NOT EXISTS `absence` (
  `id` int NOT NULL AUTO_INCREMENT,
  `date` date NOT NULL,
  `proof_path` varchar(255) DEFAULT NULL,
  `intern_id` int NOT NULL,
  `reason_id` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_765AE0C9525DD4B4` (`intern_id`),
  KEY `IDX_765AE0C959BB1592` (`reason_id`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `absence`
--

INSERT INTO `absence` (`id`, `date`, `proof_path`, `intern_id`, `reason_id`) VALUES
(13, '2026-09-01', NULL, 25, 10),
(14, '2026-09-02', NULL, 25, 10),
(15, '2026-09-03', NULL, 25, 10),
(16, '2026-09-08', NULL, 25, 10),
(17, '2026-09-09', NULL, 25, 10),
(18, '2026-09-10', NULL, 25, 10),
(19, '2026-09-04', NULL, 26, 9),
(20, '2026-09-05', NULL, 27, 11),
(21, '2026-09-11', NULL, 28, 12),
(22, '2026-09-12', NULL, 26, 10),
(23, '2026-09-15', NULL, 29, 9),
(24, '2026-09-16', NULL, 29, 9);

-- --------------------------------------------------------

--
-- Structure de la table `doctrine_migration_versions`
--

DROP TABLE IF EXISTS `doctrine_migration_versions`;
CREATE TABLE IF NOT EXISTS `doctrine_migration_versions` (
  `version` varchar(191) NOT NULL,
  `executed_at` datetime DEFAULT NULL,
  `execution_time` int DEFAULT NULL,
  PRIMARY KEY (`version`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `doctrine_migration_versions`
--

INSERT INTO `doctrine_migration_versions` (`version`, `executed_at`, `execution_time`) VALUES
('DoctrineMigrations\\Version20260903075716', '2026-09-03 12:35:02', 204),
('DoctrineMigrations\\Version20260903092418', '2026-09-03 12:35:02', 22),
('DoctrineMigrations\\Version20260903122750', '2026-09-03 12:35:02', 22);

-- --------------------------------------------------------

--
-- Structure de la table `intern`
--

DROP TABLE IF EXISTS `intern`;
CREATE TABLE IF NOT EXISTS `intern` (
  `id` int NOT NULL AUTO_INCREMENT,
  `first_name` varchar(100) NOT NULL,
  `last_name` varchar(100) NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `photo_path` varchar(255) DEFAULT NULL,
  `afpa_number` varchar(20) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_A5795F363809C87A` (`afpa_number`)
) ENGINE=InnoDB AUTO_INCREMENT=37 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `intern`
--

INSERT INTO `intern` (`id`, `first_name`, `last_name`, `phone`, `photo_path`, `afpa_number`) VALUES
(25, 'Adila', 'Kehlaoui', '0601020304', 'adila-6a9e5f9e248c6.webp', '22116576'),
(26, 'Mohammed', 'Benerroua', '0611121314', 'mohammed-6a9e643dd4858.webp', '26020093'),
(27, 'Ghislène', 'Bellia', '0621222324', 'ghislene-6a9e6449cc17c.webp', '26020095'),
(28, 'Aurèle', 'Camps', '0631323334', 'aurele-6a9e645352f06.webp', '26020096'),
(29, 'Nelly', 'Fabre', '0641424344', 'nelly-6a9e645be0113.webp', '26020097'),
(30, 'Sarah', 'Casabianca', '0651525354', 'sarah-6a9e6464dc15f.webp', '26020141'),
(31, 'Juan', 'Rojas Cuicas', '0661626364', 'juan-6a9e646fd9a61.webp', '26020143'),
(32, 'Lucas', 'Merlet', '0671727374', 'lucas-6a9e647988c11.webp', '26020156'),
(33, 'Nemo', 'Capitaine', '0681828384', 'nemo-6a9e648283451.webp', '26020263'),
(34, 'Nathanael', 'Kenzey', '0691929394', 'nathanael-6a9e648d73890.webp', '26020268'),
(35, 'Anthony', 'Lutard', '0602030405', 'anthony-6a9e649468101.webp', '26020916'),
(36, 'Mélanie', 'Saez', '0612131415', 'melanie-6a9e649a84c14.webp', '26028145');

-- --------------------------------------------------------

--
-- Structure de la table `messenger_messages`
--

DROP TABLE IF EXISTS `messenger_messages`;
CREATE TABLE IF NOT EXISTS `messenger_messages` (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `body` longtext NOT NULL,
  `headers` longtext NOT NULL,
  `queue_name` varchar(190) NOT NULL,
  `created_at` datetime NOT NULL,
  `available_at` datetime NOT NULL,
  `delivered_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_75EA56E0FB7336F0E3BD61CE16BA31DBBF396750` (`queue_name`,`available_at`,`delivered_at`,`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `reason`
--

DROP TABLE IF EXISTS `reason`;
CREATE TABLE IF NOT EXISTS `reason` (
  `id` int NOT NULL AUTO_INCREMENT,
  `label` varchar(50) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_3BB8880CEA750E8` (`label`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `reason`
--

INSERT INTO `reason` (`id`, `label`) VALUES
(11, 'Absence légale'),
(12, 'Accident du travail'),
(9, 'Maladie'),
(10, 'Sans motif');

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `id` int NOT NULL AUTO_INCREMENT,
  `login` varchar(180) NOT NULL,
  `roles` json NOT NULL,
  `password` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_IDENTIFIER_LOGIN` (`login`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `user`
--

INSERT INTO `user` (`id`, `login`, `roles`, `password`) VALUES
(3, 'ADMINAFPA', '[\"ROLE_ADMIN\"]', '$2y$13$fBOY9UpNNgyH0/OMoiGgReMlDaW7mLROFioiCzKIciFzFVANKAgue');

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `absence`
--
ALTER TABLE `absence`
  ADD CONSTRAINT `FK_765AE0C9525DD4B4` FOREIGN KEY (`intern_id`) REFERENCES `intern` (`id`),
  ADD CONSTRAINT `FK_765AE0C959BB1592` FOREIGN KEY (`reason_id`) REFERENCES `reason` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
