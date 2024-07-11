-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : dim. 30 avr. 2023 à 16:32
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
-- Base de données : `bureau_emploi`
--

-- --------------------------------------------------------

--
-- Structure de la table `competence`
--

DROP TABLE IF EXISTS `competence`;
CREATE TABLE IF NOT EXISTS `competence` (
  `code_competence` int NOT NULL AUTO_INCREMENT,
  `libelle_competence` varchar(30) NOT NULL,
  PRIMARY KEY (`code_competence`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `competence`
--

INSERT INTO `competence` (`code_competence`, `libelle_competence`) VALUES
(0, ''),
(1, 'communication'),
(2, 'Résolution de problèmes'),
(3, 'Leadership'),
(4, 'Travail d\'equipe'),
(5, 'organisation et planification');

-- --------------------------------------------------------

--
-- Structure de la table `competence_demandeur`
--

DROP TABLE IF EXISTS `competence_demandeur`;
CREATE TABLE IF NOT EXISTS `competence_demandeur` (
  `CIN` varchar(10) NOT NULL,
  `code_competence` int NOT NULL,
  KEY `CIN` (`CIN`),
  KEY `code_competence` (`code_competence`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `competence_demandeur`
--

INSERT INTO `competence_demandeur` (`CIN`, `code_competence`) VALUES
('12345678', 1),
('12345679', 2),
('98765432', 3),
('54789632', 5);

-- --------------------------------------------------------

--
-- Structure de la table `condidature`
--

DROP TABLE IF EXISTS `condidature`;
CREATE TABLE IF NOT EXISTS `condidature` (
  `CIN` varchar(10) NOT NULL,
  `code_offre_emploi` int NOT NULL,
  `etat_condidature` int NOT NULL COMMENT '1:attente , 0:refus , 2 :acceptation',
  `date_condidature` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  KEY `CIN` (`CIN`),
  KEY `code_offre_emploi` (`code_offre_emploi`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `condidature`
--

INSERT INTO `condidature` (`CIN`, `code_offre_emploi`, `etat_condidature`, `date_condidature`) VALUES
('12345678', 4, 2, '2023-04-30 14:47:33'),
('12345678', 9, 1, '2023-04-30 14:47:36'),
('12345678', 5, 0, '2023-04-30 14:47:43');

-- --------------------------------------------------------

--
-- Structure de la table `demandeur_cv`
--

DROP TABLE IF EXISTS `demandeur_cv`;
CREATE TABLE IF NOT EXISTS `demandeur_cv` (
  `CIN` varchar(10) NOT NULL,
  `nom` varchar(30) NOT NULL,
  `prenom` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `pseudo` varchar(30) NOT NULL,
  `pass_word` varchar(30) NOT NULL,
  `photo` longblob NOT NULL,
  `date_naissance` date NOT NULL,
  `etat_civil` int NOT NULL COMMENT '0 celibataire,1 marié, 2:veuf',
  `adresse` varchar(100) NOT NULL,
  `num_telephone` int NOT NULL,
  `nombre_annees_experience` int NOT NULL,
  `code_universite` int NOT NULL,
  PRIMARY KEY (`CIN`),
  KEY `code_universite` (`code_universite`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `demandeur_cv`
--

INSERT INTO `demandeur_cv` (`CIN`, `nom`, `prenom`, `pseudo`, `pass_word`, `photo`, `date_naissance`, `etat_civil`, `adresse`, `num_telephone`, `nombre_annees_experience`, `code_universite`) VALUES
('12345678', 'yassine', 'madhi', 'yass', 'azertyui', '', '2002-10-18', 1, '4534', 97321456, 3, 1),
('12345679', 'jsfs', 'mod', 'yasi', 'azertyui', '', '2021-11-12', 1, 'reza', 65478932, 5, 1),
('54789632', 'ather', 'mod', 'you', 'azertyui', '', '2021-12-02', 1, '1100', 74125896, 3, 4),
('98765432', 'traa', 'fal9a', 'ya', 'azertyui', '', '2021-03-13', 2, '4566', 96325874, 6, 5);

-- --------------------------------------------------------

--
-- Structure de la table `diplome`
--

DROP TABLE IF EXISTS `diplome`;
CREATE TABLE IF NOT EXISTS `diplome` (
  `code_diplome` int NOT NULL AUTO_INCREMENT,
  `libelle_diplome` varchar(30) NOT NULL,
  PRIMARY KEY (`code_diplome`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `diplome`
--

INSERT INTO `diplome` (`code_diplome`, `libelle_diplome`) VALUES
(0, ''),
(1, 'LNBI'),
(2, 'LNSG'),
(3, 'LNSE'),
(4, 'LNSI'),
(5, 'LNBIS');

-- --------------------------------------------------------

--
-- Structure de la table `diplome_demandeur`
--

DROP TABLE IF EXISTS `diplome_demandeur`;
CREATE TABLE IF NOT EXISTS `diplome_demandeur` (
  `CIN` varchar(10) NOT NULL,
  `code_diplome` int NOT NULL,
  KEY `CIN` (`CIN`),
  KEY `code_diplome` (`code_diplome`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `diplome_demandeur`
--

INSERT INTO `diplome_demandeur` (`CIN`, `code_diplome`) VALUES
('12345678', 1),
('12345679', 1),
('98765432', 5),
('54789632', 5);

-- --------------------------------------------------------

--
-- Structure de la table `employeur`
--

DROP TABLE IF EXISTS `employeur`;
CREATE TABLE IF NOT EXISTS `employeur` (
  `code_registre_commerce` varchar(20) NOT NULL,
  `nom_entreprise` varchar(30) NOT NULL,
  `nom_gerant` varchar(30) NOT NULL,
  `prenom_gerant` varchar(30) NOT NULL,
  `pseudo` varchar(20) NOT NULL,
  `pass_word` varchar(20) NOT NULL,
  PRIMARY KEY (`code_registre_commerce`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `employeur`
--

INSERT INTO `employeur` (`code_registre_commerce`, `nom_entreprise`, `nom_gerant`, `prenom_gerant`, `pseudo`, `pass_word`) VALUES
('2222', 'yasgames', 'hassen', 'lakhder', 'game', 'qsdfghjkl'),
('2223', 'kachaigam', 'hsin', 'hmed', 'kaga', 'qsdfghjkl');

-- --------------------------------------------------------

--
-- Structure de la table `employeur_offre`
--

DROP TABLE IF EXISTS `employeur_offre`;
CREATE TABLE IF NOT EXISTS `employeur_offre` (
  `code_registre_commerce` varchar(20) NOT NULL,
  `code_offre_emploi` int NOT NULL,
  KEY `code_registre_commerce` (`code_registre_commerce`),
  KEY `code_offre_emploi` (`code_offre_emploi`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `employeur_offre`
--

INSERT INTO `employeur_offre` (`code_registre_commerce`, `code_offre_emploi`) VALUES
('2222', 4),
('2222', 5),
('2222', 6),
('2223', 7),
('2223', 8),
('2223', 9);

-- --------------------------------------------------------

--
-- Structure de la table `offre_competance`
--

DROP TABLE IF EXISTS `offre_competance`;
CREATE TABLE IF NOT EXISTS `offre_competance` (
  `code_offre_emploi` int NOT NULL,
  `code_competence` int NOT NULL,
  KEY `code_offre__emploi` (`code_offre_emploi`),
  KEY `code_competence` (`code_competence`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `offre_competance`
--

INSERT INTO `offre_competance` (`code_offre_emploi`, `code_competence`) VALUES
(4, 1),
(5, 2),
(6, 4),
(7, 5),
(8, 3),
(9, 2);

-- --------------------------------------------------------

--
-- Structure de la table `offre_emploi`
--

DROP TABLE IF EXISTS `offre_emploi`;
CREATE TABLE IF NOT EXISTS `offre_emploi` (
  `code_offre_emploi` int NOT NULL AUTO_INCREMENT,
  `Titre` varchar(30) NOT NULL,
  `descript` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `code_diplome` int NOT NULL,
  `nombre_annee_experience` int NOT NULL,
  `salaire_propose` int NOT NULL,
  PRIMARY KEY (`code_offre_emploi`),
  KEY `code_diplome` (`code_diplome`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `offre_emploi`
--

INSERT INTO `offre_emploi` (`code_offre_emploi`, `Titre`, `descript`, `code_diplome`, `nombre_annee_experience`, `salaire_propose`) VALUES
(0, '', '', 0, 0, 0),
(4, 'CEO', 'dbfdfbdfb', 1, 3, 2000),
(5, 'DEF', 'fvvd fvb gb', 1, 3, 2100),
(6, 'DEV', 'dcqdsvdfvfd', 5, 3, 2000),
(7, 'CEY', 'dvsdfvsdfb', 5, 3, 2200),
(8, 'DEV', 'vsrbbg g bgb', 5, 3, 2300),
(9, 'DER', 'hzrhebhb', 1, 3, 2500);

-- --------------------------------------------------------

--
-- Structure de la table `universite`
--

DROP TABLE IF EXISTS `universite`;
CREATE TABLE IF NOT EXISTS `universite` (
  `code_universite` int NOT NULL AUTO_INCREMENT,
  `libelle_universite` varchar(30) NOT NULL,
  PRIMARY KEY (`code_universite`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `universite`
--

INSERT INTO `universite` (`code_universite`, `libelle_universite`) VALUES
(0, ''),
(1, 'ISG'),
(2, 'ESEN'),
(3, 'ISAM'),
(4, 'FSEG'),
(5, 'IHEC');

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `competence_demandeur`
--
ALTER TABLE `competence_demandeur`
  ADD CONSTRAINT `competence_demandeur_ibfk_2` FOREIGN KEY (`CIN`) REFERENCES `demandeur_cv` (`CIN`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `competence_demandeur_ibfk_3` FOREIGN KEY (`code_competence`) REFERENCES `competence` (`code_competence`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Contraintes pour la table `condidature`
--
ALTER TABLE `condidature`
  ADD CONSTRAINT `condidature_ibfk_1` FOREIGN KEY (`CIN`) REFERENCES `demandeur_cv` (`CIN`),
  ADD CONSTRAINT `condidature_ibfk_2` FOREIGN KEY (`code_offre_emploi`) REFERENCES `offre_emploi` (`code_offre_emploi`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Contraintes pour la table `demandeur_cv`
--
ALTER TABLE `demandeur_cv`
  ADD CONSTRAINT `demandeur_cv_ibfk_1` FOREIGN KEY (`code_universite`) REFERENCES `universite` (`code_universite`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Contraintes pour la table `diplome_demandeur`
--
ALTER TABLE `diplome_demandeur`
  ADD CONSTRAINT `diplome_demandeur_ibfk_2` FOREIGN KEY (`CIN`) REFERENCES `demandeur_cv` (`CIN`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `diplome_demandeur_ibfk_3` FOREIGN KEY (`code_diplome`) REFERENCES `diplome` (`code_diplome`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Contraintes pour la table `employeur_offre`
--
ALTER TABLE `employeur_offre`
  ADD CONSTRAINT `employeur_offre_ibfk_1` FOREIGN KEY (`code_registre_commerce`) REFERENCES `employeur` (`code_registre_commerce`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `employeur_offre_ibfk_2` FOREIGN KEY (`code_offre_emploi`) REFERENCES `offre_emploi` (`code_offre_emploi`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Contraintes pour la table `offre_competance`
--
ALTER TABLE `offre_competance`
  ADD CONSTRAINT `offre_competance_ibfk_3` FOREIGN KEY (`code_offre_emploi`) REFERENCES `offre_emploi` (`code_offre_emploi`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `offre_competance_ibfk_4` FOREIGN KEY (`code_competence`) REFERENCES `competence` (`code_competence`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Contraintes pour la table `offre_emploi`
--
ALTER TABLE `offre_emploi`
  ADD CONSTRAINT `offre_emploi_ibfk_1` FOREIGN KEY (`code_diplome`) REFERENCES `diplome` (`code_diplome`) ON DELETE RESTRICT ON UPDATE RESTRICT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
