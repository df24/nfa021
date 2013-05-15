-- phpMyAdmin SQL Dump
-- version 3.4.11.1deb1
-- http://www.phpmyadmin.net
--
-- Client: localhost
-- Généré le: Mer 15 Mai 2013 à 11:26
-- Version du serveur: 5.5.31
-- Version de PHP: 5.4.6-1ubuntu1.2

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
  `accroche` varchar(500) DEFAULT NULL,
  `contenu` text,
  `datePublicationDebut` date DEFAULT NULL,
  `datePublicationFin` date DEFAULT NULL,
  `dateCreation` datetime NOT NULL,
  `ordre` int(11) DEFAULT NULL,
  `etat` enum('brouillon','valid') DEFAULT NULL,
  `visibilite` enum('publique','privee') DEFAULT NULL,
  `idactuRubrique` int(10) unsigned NOT NULL,
  `iduser` int(10) unsigned NOT NULL,
  PRIMARY KEY (`idactu`),
  KEY `fk_actu_actuRubrique_idx` (`idactuRubrique`),
  KEY `fk_actu_user1_idx` (`iduser`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Contenu de la table `actu`
--

INSERT INTO `actu` (`idactu`, `titre`, `accroche`, `contenu`, `datePublicationDebut`, `datePublicationFin`, `dateCreation`, `ordre`, `etat`, `visibilite`, `idactuRubrique`, `iduser`) VALUES
(2, 'titre test actu user 1', NULL, NULL, NULL, NULL, '2013-05-14 00:00:00', NULL, NULL, NULL, 1, 1),
(3, 'Cacoo est un outil ergonomique de dessin en ligne qui vous permet de créer tout un panel de diagrammes', NULL, NULL, NULL, NULL, '2013-05-11 00:00:00', NULL, NULL, NULL, 1, 1);

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Contenu de la table `actuRubrique`
--

INSERT INTO `actuRubrique` (`idactuRubrique`, `libelle`, `iduser`) VALUES
(1, 'rubrique défaut', 1);

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
  PRIMARY KEY (`iduser`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Contenu de la table `user`
--

INSERT INTO `user` (`iduser`, `nom`, `email`, `pwd`, `actif`) VALUES
(1, 'jfk', 'jfk@toto.com', 'jfk', 'oui');

--
-- Contraintes pour les tables exportées
--

--
-- Contraintes pour la table `actu`
--
ALTER TABLE `actu`
  ADD CONSTRAINT `fk_actu_actuRubrique` FOREIGN KEY (`idactuRubrique`) REFERENCES `actuRubrique` (`idactuRubrique`) ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_actu_user1` FOREIGN KEY (`iduser`) REFERENCES `user` (`iduser`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `actuRubrique`
--
ALTER TABLE `actuRubrique`
  ADD CONSTRAINT `fk_actuRubrique_user1` FOREIGN KEY (`iduser`) REFERENCES `user` (`iduser`) ON DELETE CASCADE ON UPDATE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
