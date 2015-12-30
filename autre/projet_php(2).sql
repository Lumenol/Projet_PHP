-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Client :  127.0.0.1
-- Généré le :  Mer 30 Décembre 2015 à 22:50
-- Version du serveur :  5.6.17
-- Version de PHP :  5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de données :  `projet_php`
--
CREATE DATABASE IF NOT EXISTS `projet_php` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `projet_php`;

-- --------------------------------------------------------

--
-- Structure de la table `client`
--

CREATE TABLE IF NOT EXISTS `client` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nom` text NOT NULL,
  `prenom` text NOT NULL,
  `adresse` text NOT NULL,
  `num_tel` text NOT NULL,
  `date_naissance` date NOT NULL,
  `credit` decimal(10,2) NOT NULL DEFAULT '0.00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

-- --------------------------------------------------------

--
-- Structure de la table `edt`
--

CREATE TABLE IF NOT EXISTS `edt` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` enum('intervention','formation','','') NOT NULL,
  `id_mecanicien` int(11) NOT NULL,
  `horaire` datetime NOT NULL,
  `id_intervention` int(11) DEFAULT NULL,
  `id_formation` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `id_mecanicien` (`id_mecanicien`,`id_intervention`,`id_formation`),
  KEY `id_intervention` (`id_intervention`),
  KEY `id_formation` (`id_formation`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=41 ;

-- --------------------------------------------------------

--
-- Structure de la table `employe`
--

CREATE TABLE IF NOT EXISTS `employe` (
  `id` varchar(20) NOT NULL,
  `mdp` text NOT NULL,
  `categorie` enum('agent','mecanicien','directeur','') NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `employe`
--

INSERT INTO `employe` (`id`, `mdp`, `categorie`) VALUES
('a', 'a', 'agent'),
('d', 'd', 'directeur'),
('m', 'm', 'mecanicien');

-- --------------------------------------------------------

--
-- Structure de la table `facture`
--

CREATE TABLE IF NOT EXISTS `facture` (
  `id_client` int(11) DEFAULT '0',
  `id_intervention` int(11) NOT NULL,
  `etat` enum('en attente de payment','en différé','payée','') CHARACTER SET utf8 COLLATE utf8_roman_ci NOT NULL DEFAULT 'en attente de payment',
  PRIMARY KEY (`id_intervention`),
  KEY `id_client` (`id_client`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `formation`
--

CREATE TABLE IF NOT EXISTS `formation` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_mecanicien` int(11) NOT NULL,
  `horaire` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id_mecanicien_2` (`id_mecanicien`),
  KEY `id_mecanicien_3` (`id_mecanicien`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=32 ;

-- --------------------------------------------------------

--
-- Structure de la table `intervention`
--

CREATE TABLE IF NOT EXISTS `intervention` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` int(11) DEFAULT '0',
  `id_mecanicien` int(11) DEFAULT NULL,
  `horaire` datetime NOT NULL,
  `id_client` int(11) DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `id_client` (`id_client`),
  KEY `type` (`type`),
  KEY `id_mecanicien` (`id_mecanicien`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=13 ;

-- --------------------------------------------------------

--
-- Structure de la table `materiel`
--

CREATE TABLE IF NOT EXISTS `materiel` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `libele` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

-- --------------------------------------------------------

--
-- Structure de la table `mecanicien`
--

CREATE TABLE IF NOT EXISTS `mecanicien` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nom` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

-- --------------------------------------------------------

--
-- Structure de la table `produit`
--

CREATE TABLE IF NOT EXISTS `produit` (
  `id_produit` int(11) NOT NULL,
  `id_materiel` int(11) NOT NULL,
  PRIMARY KEY (`id_produit`,`id_materiel`),
  KEY `fk_materiel` (`id_materiel`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `type_intervention`
--

CREATE TABLE IF NOT EXISTS `type_intervention` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` text NOT NULL,
  `prix` decimal(10,2) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

--
-- Contraintes pour les tables exportées
--

--
-- Contraintes pour la table `edt`
--
ALTER TABLE `edt`
  ADD CONSTRAINT `edt_ibfk_1` FOREIGN KEY (`id_mecanicien`) REFERENCES `mecanicien` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `edt_ibfk_2` FOREIGN KEY (`id_intervention`) REFERENCES `intervention` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `edt_ibfk_3` FOREIGN KEY (`id_formation`) REFERENCES `formation` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `facture`
--
ALTER TABLE `facture`
  ADD CONSTRAINT `facture_ibfk_1` FOREIGN KEY (`id_client`) REFERENCES `client` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `facture_ibfk_2` FOREIGN KEY (`id_intervention`) REFERENCES `intervention` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `formation`
--
ALTER TABLE `formation`
  ADD CONSTRAINT `formation_ibfk_1` FOREIGN KEY (`id_mecanicien`) REFERENCES `mecanicien` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `intervention`
--
ALTER TABLE `intervention`
  ADD CONSTRAINT `intervention_ibfk_1` FOREIGN KEY (`id_client`) REFERENCES `client` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `intervention_ibfk_2` FOREIGN KEY (`type`) REFERENCES `type_intervention` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `intervention_ibfk_3` FOREIGN KEY (`id_mecanicien`) REFERENCES `mecanicien` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Contraintes pour la table `produit`
--
ALTER TABLE `produit`
  ADD CONSTRAINT `fk_materiel` FOREIGN KEY (`id_materiel`) REFERENCES `materiel` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_type_intervention` FOREIGN KEY (`id_produit`) REFERENCES `type_intervention` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
