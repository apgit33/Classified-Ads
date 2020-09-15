-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le :  mer. 09 sep. 2020 à 15:00
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
  `a_title` varchar(65) NOT NULL,
  `a_desc` mediumtext NOT NULL,
  `a_price` float DEFAULT NULL,
  `a_image_url` varchar(60) NOT NULL,
  `a_unique_id` varchar(255) DEFAULT NULL,
  `a_validate` tinyint(1) NOT NULL DEFAULT '0',
  `a_date_create` date NOT NULL,
  `a_date_validate` date DEFAULT NULL,
  `a_pdf` varchar(65) NOT NULL,
  `a_c_id` int(11) NOT NULL,
  `a_u_id` int(11) NOT NULL,
  PRIMARY KEY (`a_id`),
  KEY `a_c_id` (`a_c_id`),
  KEY `a_u_id` (`a_u_id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `ca_ad`
--

INSERT INTO `ca_ad` (`a_id`, `a_title`, `a_desc`, `a_price`, `a_image_url`, `a_unique_id`, `a_validate`, `a_date_create`, `a_date_validate`, `a_pdf`, `a_c_id`, `a_u_id`) VALUES
(2, 'Souris blanche', 'Souris blanche femelle', 2.99, 'assets/medias/default.jpeg', 'ef76a7f791862c99792fe8c20ed50d9681853c03', 1, '2020-09-09', '2020-09-09', 'assets/medias/1/2.pdf', 3, 1),
(3, 'Souris verte', 'Souris verte à 3 pattes', 1.99, 'assets/medias/default.jpeg', '2940a74796c4c63c0367c675e1fc48a9213e3165', 1, '2020-09-09', '2020-09-09', 'assets/medias/1/3.pdf', 3, 1),
(4, 'Souris noire', 'Souris noire', 1.99, 'assets/medias/default.jpeg', '9310e38ba7d1ed752159bddef135144f854c63b6', 1, '2020-09-09', '2020-09-09', 'assets/medias/1/4.pdf', 3, 1),
(5, 'Audi en pièce', 'Pièces détachées', 1.99, 'assets/medias/default.jpeg', 'b520b7e12c6ed397e8b59b8beec1ddcc3eb62dd1', 1, '2020-09-09', '2020-09-09', 'assets/medias/1/5.pdf', 1, 1),
(6, 'Lamborghini Aventador', 'Neuve tombé du camion', 350000, 'assets/medias/default.jpeg', '7274a55b6da6c35a86c262fcba800d4e3abcf1d1', 1, '2020-09-09', '2020-09-09', 'assets/medias/1/6.pdf', 1, 1),
(7, 'Hochet', 'hochet pour bébé 3 mois', 5, 'assets/medias/default.jpeg', 'c59b3284bdce819dbbd79474469e8dbaddc1a488', 1, '2020-09-09', '2020-09-09', 'assets/medias/1/7.pdf', 8, 1),
(8, 'Hochet', 'hochet pour bébé 5 mois', 5.55, 'assets/medias/default.jpeg', 'c389a34162c9baedcfe26c1bd58140fdbb55ce2d', 1, '2020-09-09', '2020-09-09', 'assets/medias/1/8.pdf', 8, 1),
(9, 'Stage développement web', 'Stage de 2 mois dans une start-up', 800, 'assets/medias/default.jpeg', '980e73b427636146fd943eeb75424522ad0e10a5', 1, '2020-09-09', '2020-09-09', 'assets/medias/1/9.pdf', 6, 1),
(10, 'CDD développement web', 'CDD 3 mois', 1200, 'assets/medias/default.jpeg', 'a433e6147f35e8b4acb727258b209091741a02c4', 1, '2020-09-09', '2020-09-09', 'assets/medias/1/10.pdf', 6, 1),
(11, 'CDI secrétaire', 'CDI de remplacement', 1200, 'assets/medias/default.jpeg', '8a47237bf084a54db7dcbb02fbec7ff3aed66f82', 1, '2020-09-09', '2020-09-09', 'assets/medias/1/11.pdf', 6, 1),
(12, 'Week end hawai', 'Week end bungalow hawai, les pieds dans l\'eau', 12000, 'assets/medias/default.jpeg', '1e51cafc10c8ccae272110510049e7cc8ecfc46f', 1, '2020-09-09', '2020-09-09', 'assets/medias/1/12.pdf', 5, 1),
(13, 'Week end belgique', 'Week end gastronomique', 300, 'assets/medias/default.jpeg', '808828ae1fe2841cc76b462ca696e1acf500e36c', 1, '2020-09-09', '2020-09-09', 'assets/medias/1/13.pdf', 5, 1);

-- --------------------------------------------------------

--
-- Structure de la table `ca_category`
--

DROP TABLE IF EXISTS `ca_category`;
CREATE TABLE IF NOT EXISTS `ca_category` (
  `c_id` int(11) NOT NULL AUTO_INCREMENT,
  `c_name` varchar(45) NOT NULL,
  PRIMARY KEY (`c_id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `ca_category`
--

INSERT INTO `ca_category` (`c_id`, `c_name`) VALUES
(1, 'Vehicles'),
(2, 'Services'),
(3, 'Animals'),
(4, 'Housing'),
(5, 'Vacation'),
(6, 'Jobs'),
(7, 'Business pro'),
(8, 'Other');

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
(1, 'adrienpaturot@yahoo.fr', 'Jean', 'Jean', '0614478930');

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
