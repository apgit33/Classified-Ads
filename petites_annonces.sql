-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le :  lun. 24 août 2020 à 13:57
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
-- Base de données :  `petites_annonces`
--

-- --------------------------------------------------------

--
-- Structure de la table `pa_ad`
--

DROP TABLE IF EXISTS `pa_ad`;
CREATE TABLE IF NOT EXISTS `pa_ad` (
  `a_id` int(11) NOT NULL AUTO_INCREMENT,
  `a_desc` mediumtext NOT NULL,
  `a_image_url` varchar(60) NOT NULL,
  `a_image_name` varchar(45) NOT NULL,
  `a_unique_id` varchar(60) NOT NULL,
  `a_validate` tinyint(1) NOT NULL,
  `a_date_create` date NOT NULL,
  `a_date_validate` date NOT NULL,
  `a_c_id` int(11) NOT NULL,
  `a_u_id` int(11) NOT NULL,
  PRIMARY KEY (`a_id`),
  KEY `a_c_id` (`a_c_id`),
  KEY `a_u_id` (`a_u_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `pa_category`
--

DROP TABLE IF EXISTS `pa_category`;
CREATE TABLE IF NOT EXISTS `pa_category` (
  `c_id` int(11) NOT NULL AUTO_INCREMENT,
  `c_name` varchar(45) NOT NULL,
  PRIMARY KEY (`c_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `pa_user`
--

DROP TABLE IF EXISTS `pa_user`;
CREATE TABLE IF NOT EXISTS `pa_user` (
  `u_id` int(11) NOT NULL AUTO_INCREMENT,
  `u_mail` varchar(60) NOT NULL,
  `u_first_name` varchar(45) NOT NULL,
  `u_lasy_name` varchar(45) NOT NULL,
  `u_phone` varchar(10) NOT NULL,
  PRIMARY KEY (`u_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `pa_ad`
--
ALTER TABLE `pa_ad`
  ADD CONSTRAINT `pa_ad_ibfk_1` FOREIGN KEY (`a_c_id`) REFERENCES `pa_category` (`c_id`),
  ADD CONSTRAINT `pa_ad_ibfk_2` FOREIGN KEY (`a_u_id`) REFERENCES `pa_user` (`u_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
