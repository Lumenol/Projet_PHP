-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Client :  127.0.0.1
-- Généré le :  Lun 21 Décembre 2015 à 18:19
-- Version du serveur :  5.6.17
-- Version de PHP :  5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de données :  `garage`
--

-- --------------------------------------------------------

--
-- Structure de la table `client`
--

CREATE TABLE IF NOT EXISTS `client` (
  `nom` text NOT NULL,
  `prenom` text NOT NULL,
  `adresse` text NOT NULL,
  `numTel` int(10) NOT NULL,
  `dateNaiss` date NOT NULL,
  `id` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `emploidutemps`
--

CREATE TABLE IF NOT EXISTS `emploidutemps` (
  `jour` datetime NOT NULL,
  `idMeca` int(11) NOT NULL,
  `intervention` int(11) NOT NULL,
  `formation` date NOT NULL,
  PRIMARY KEY (`jour`,`idMeca`),
  UNIQUE KEY `formation` (`formation`),
  UNIQUE KEY `idMeca` (`idMeca`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `employe`
--

CREATE TABLE IF NOT EXISTS `employe` (
  `identifiant` int(11) NOT NULL,
  `mdp` varchar(11) NOT NULL,
  `categorie` enum('agent','mecanicien','directeur') NOT NULL,
  PRIMARY KEY (`identifiant`,`mdp`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `formation`
--

CREATE TABLE IF NOT EXISTS `formation` (
  `idMeca` int(11) NOT NULL,
  `dateFormation` date NOT NULL,
  PRIMARY KEY (`idMeca`,`dateFormation`),
  KEY `fk_edt` (`dateFormation`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `intervention`
--

CREATE TABLE IF NOT EXISTS `intervention` (
  `idInter` int(11) NOT NULL,
  `materiel` int(11) DEFAULT NULL,
  `prix` int(11) NOT NULL,
  `mecanicien` int(11) NOT NULL,
  `dateInter` date NOT NULL,
  PRIMARY KEY (`idInter`,`dateInter`),
  UNIQUE KEY `idInter` (`idInter`),
  UNIQUE KEY `mecanicien` (`mecanicien`),
  UNIQUE KEY `dateInter` (`dateInter`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `materiel`
--

CREATE TABLE IF NOT EXISTS `materiel` (
  `libelle` text NOT NULL,
  `idProd` int(11) NOT NULL,
  PRIMARY KEY (`idProd`),
  UNIQUE KEY `idProd` (`idProd`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `mecanicien`
--

CREATE TABLE IF NOT EXISTS `mecanicien` (
  `nom` char(11) NOT NULL,
  `identifiant` int(11) NOT NULL,
  `edt` int(11) NOT NULL,
  PRIMARY KEY (`nom`,`identifiant`),
  UNIQUE KEY `identifiant` (`identifiant`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `produit`
--

CREATE TABLE IF NOT EXISTS `produit` (
  `idProduit` int(11) NOT NULL,
  `idMateriel` int(11) NOT NULL,
  PRIMARY KEY (`idProduit`,`idMateriel`),
  UNIQUE KEY `idProduit` (`idProduit`),
  UNIQUE KEY `idMateriel` (`idMateriel`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `soldeclient`
--

CREATE TABLE IF NOT EXISTS `soldeclient` (
  `diffMax` int(11) NOT NULL,
  `diffEnCours` int(11) DEFAULT NULL,
  `etat` enum('à payer','à jour') NOT NULL,
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `intervention` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`,`etat`),
  UNIQUE KEY `UNIQUE` (`intervention`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `typeintervention`
--

CREATE TABLE IF NOT EXISTS `typeintervention` (
  `id` int(11) NOT NULL,
  `type` text NOT NULL,
  `materielinter` int(11) NOT NULL,
  PRIMARY KEY (`id`,`materielinter`),
  KEY `fk_materielinter` (`materielinter`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contraintes pour les tables exportées
--

--
-- Contraintes pour la table `employe`
--
ALTER TABLE `employe`
  ADD CONSTRAINT `fk_mecanicien` FOREIGN KEY (`identifiant`) REFERENCES `mecanicien` (`identifiant`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `formation`
--
ALTER TABLE `formation`
  ADD CONSTRAINT `fk_edt` FOREIGN KEY (`dateFormation`) REFERENCES `emploidutemps` (`formation`);

--
-- Contraintes pour la table `intervention`
--
ALTER TABLE `intervention`
  ADD CONSTRAINT `fk_meca` FOREIGN KEY (`mecanicien`) REFERENCES `mecanicien` (`identifiant`) ON UPDATE CASCADE;

--
-- Contraintes pour la table `materiel`
--
ALTER TABLE `materiel`
  ADD CONSTRAINT `fk_produit` FOREIGN KEY (`idProd`) REFERENCES `produit` (`idProduit`);

--
-- Contraintes pour la table `mecanicien`
--
ALTER TABLE `mecanicien`
  ADD CONSTRAINT `fk_emploidutemps` FOREIGN KEY (`identifiant`) REFERENCES `emploidutemps` (`idMeca`);

--
-- Contraintes pour la table `soldeclient`
--
ALTER TABLE `soldeclient`
  ADD CONSTRAINT `fk_idinter` FOREIGN KEY (`intervention`) REFERENCES `intervention` (`idInter`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_client` FOREIGN KEY (`id`) REFERENCES `client` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `typeintervention`
--
ALTER TABLE `typeintervention`
  ADD CONSTRAINT `fk_intervention` FOREIGN KEY (`id`) REFERENCES `intervention` (`idInter`) ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_materielinter` FOREIGN KEY (`materielinter`) REFERENCES `produit` (`idMateriel`) ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
