-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le :  mar. 01 sep. 2020 à 20:06
-- Version du serveur :  5.7.26
-- Version de PHP :  7.3.5

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `classified_ads`
--

-- --------------------------------------------------------

--
-- Structure de la table `ca_ad`
--

DROP TABLE IF EXISTS `ca_ad`;
CREATE TABLE IF NOT EXISTS `ca_ad` (
  `a_id` int(11) NOT NULL AUTO_INCREMENT,
  `a_desc` mediumtext NOT NULL,
  `a_price` float DEFAULT NULL,
  `a_image_url` varchar(60) NOT NULL,
  `a_unique_id` varchar(255) DEFAULT NULL,
  `a_validate` tinyint(1) NOT NULL DEFAULT '0',
  `a_date_create` date NOT NULL,
  `a_date_validate` date DEFAULT NULL,
  `a_c_id` int(11) NOT NULL,
  `a_u_id` int(11) NOT NULL,
  PRIMARY KEY (`a_id`),
  KEY `a_c_id` (`a_c_id`),
  KEY `a_u_id` (`a_u_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `ca_ad`
--

INSERT INTO `ca_ad` (`a_id`, `a_desc`, `a_price`, `a_image_url`, `a_unique_id`, `a_validate`, `a_date_create`, `a_date_validate`, `a_c_id`, `a_u_id`) VALUES
(1, 'Large house by the sea', NULL, 'medias/ads/1.jpg', NULL, 0, '2020-08-28', NULL, 4, 1);

-- --------------------------------------------------------

--
-- Structure de la table `ca_category`
--

DROP TABLE IF EXISTS `ca_category`;
CREATE TABLE IF NOT EXISTS `ca_category` (
  `c_id` int(11) NOT NULL AUTO_INCREMENT,
  `c_name` varchar(45) NOT NULL,
  PRIMARY KEY (`c_id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `ca_category`
--

INSERT INTO `ca_category` (`c_id`, `c_name`) VALUES
(1, 'Vehicle'),
(2, 'Garden'),
(3, 'Animals'),
(4, 'Housing'),
(5, 'Games'),
(6, 'Job'),
(7, 'Other');

-- --------------------------------------------------------

--
-- Structure de la table `ca_user`
--

DROP TABLE IF EXISTS `ca_user`;
CREATE TABLE IF NOT EXISTS `ca_user` (
  `u_id` int(11) NOT NULL AUTO_INCREMENT,
  `u_mail` varchar(60) NOT NULL,
  `u_first_name` varchar(45) NOT NULL,
  `u_last_name` varchar(45) NOT NULL,
  `u_phone` varchar(10) NOT NULL,
  PRIMARY KEY (`u_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `ca_user`
--

INSERT INTO `ca_user` (`u_id`, `u_mail`, `u_first_name`, `u_last_name`, `u_phone`) VALUES
(1, 'adrienpaturot@yahoo.fr', 'Adrien', 'Paturot', '0610074930');

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `ca_ad`
--
ALTER TABLE `ca_ad`
  ADD CONSTRAINT `ca_ad_ibfk_1` FOREIGN KEY (`a_c_id`) REFERENCES `ca_category` (`c_id`),
  ADD CONSTRAINT `ca_ad_ibfk_2` FOREIGN KEY (`a_u_id`) REFERENCES `ca_user` (`u_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
