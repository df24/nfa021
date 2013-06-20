-- phpMyAdmin SQL Dump
-- version 3.5.8.1deb1
-- http://www.phpmyadmin.net
--
-- Client: localhost
-- Généré le: Jeu 20 Juin 2013 à 15:43
-- Version du serveur: 5.5.31-0ubuntu0.13.04.1
-- Version de PHP: 5.4.9-4ubuntu2.1

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de données: `nfa021`
--

-- --------------------------------------------------------

--
-- Structure de la table `actu`
--

CREATE TABLE IF NOT EXISTS `actu` (
  `idactu` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `titre` varchar(255) NOT NULL,
  `contenu` text,
  `datePublicationDebut` date DEFAULT NULL,
  `datePublicationFin` date DEFAULT NULL,
  `dateCreation` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `ordre` int(11) DEFAULT NULL,
  `etat` enum('brouillon','valid') DEFAULT 'brouillon',
  `idactuRubrique` int(10) unsigned NOT NULL,
  `iduser` int(10) unsigned NOT NULL,
  PRIMARY KEY (`idactu`),
  KEY `fk_actu_actuRubrique_idx` (`idactuRubrique`),
  KEY `fk_actu_user1_idx` (`iduser`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=13 ;

-- --------------------------------------------------------

--
-- Structure de la table `actuRubrique`
--

CREATE TABLE IF NOT EXISTS `actuRubrique` (
  `idactuRubrique` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `libelle` varchar(255) NOT NULL,
  `iduser` int(10) unsigned NOT NULL,
  PRIMARY KEY (`idactuRubrique`),
  KEY `fk_actuRubrique_user1_idx` (`iduser`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=12 ;

-- --------------------------------------------------------

--
-- Structure de la table `commentaire`
--

CREATE TABLE IF NOT EXISTS `commentaire` (
  `idcommentaire` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `commentaire` varchar(500) NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `idactu` int(10) unsigned NOT NULL,
  `iduser` int(10) unsigned NOT NULL,
  PRIMARY KEY (`idcommentaire`),
  KEY `fk_commentaire_actu_idx` (`idactu`),
  KEY `fk_commentaire_user1_idx` (`iduser`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `log`
--

CREATE TABLE IF NOT EXISTS `log` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `stamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `type` varchar(45) NOT NULL,
  `iduser` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_log_user1_idx` (`iduser`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `iduser` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `nom` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `pwd` varchar(8) NOT NULL,
  `actif` enum('non','oui') NOT NULL,
  PRIMARY KEY (`iduser`),
  UNIQUE KEY `mailUnique` (`email`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=31 ;

--
-- Contenu de la table `user`
--

INSERT INTO `user` (`iduser`, `nom`, `email`, `pwd`, `actif`) VALUES
(1, 'ADMINISTRATEUR', 'admin@df-info.com', 'admin', 'oui');

--
-- Contraintes pour les tables exportées
--

--
-- Contraintes pour la table `actu`
--
ALTER TABLE `actu`
  ADD CONSTRAINT `actu_ibfk_1` FOREIGN KEY (`idactuRubrique`) REFERENCES `actuRubrique` (`idactuRubrique`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_actu_user1` FOREIGN KEY (`iduser`) REFERENCES `user` (`iduser`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `actuRubrique`
--
ALTER TABLE `actuRubrique`
  ADD CONSTRAINT `actuRubrique_ibfk_1` FOREIGN KEY (`iduser`) REFERENCES `user` (`iduser`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Contraintes pour la table `commentaire`
--
ALTER TABLE `commentaire`
  ADD CONSTRAINT `commentaire_ibfk_3` FOREIGN KEY (`iduser`) REFERENCES `user` (`iduser`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `commentaire_ibfk_1` FOREIGN KEY (`idactu`) REFERENCES `actu` (`idactu`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `log`
--
ALTER TABLE `log`
  ADD CONSTRAINT `log_ibfk_1` FOREIGN KEY (`iduser`) REFERENCES `user` (`iduser`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
