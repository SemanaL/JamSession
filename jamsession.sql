-- phpMyAdmin SQL Dump
-- version 3.4.5
-- http://www.phpmyadmin.net
--
-- Client: localhost
-- Généré le : Lun 23 Septembre 2013 à 16:29
-- Version du serveur: 5.5.16
-- Version de PHP: 5.3.8

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de données: 'jamsession'
--

-- --------------------------------------------------------

--
-- Structure de la table 'childrens'
--

DROP TABLE IF EXISTS childrens;
CREATE TABLE IF NOT EXISTS childrens (
  id int(11) NOT NULL AUTO_INCREMENT,
  message_id int(5) NOT NULL,
  PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table 'jammeurs'
--

DROP TABLE IF EXISTS jammeurs;
CREATE TABLE IF NOT EXISTS jammeurs (
  id int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(15) NOT NULL,
  email varchar(30) NOT NULL,
  PRIMARY KEY (id)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

--
-- Contenu de la table 'jammeurs'
--

INSERT INTO jammeurs (id, `name`, email) VALUES
(1, 'Victor', 'victor.darde@gmail.com'),
(2, 'Raphael', 'raphael.pagneux@gmail.com'),
(3, 'Andre', 'dasandre@gmail.com'),
(4, 'Thomas', 'thomas.nieuviaert@gmail.com'),
(5, 'Jerome', 'jerome.billiard@gmail.com'),
(6, 'Marc', 'marc.demanesse@gmail.com'),
(7, 'Christophe', 'bechet.christophe@gmail.com');

-- --------------------------------------------------------

--
-- Structure de la table 'keywords'
--

DROP TABLE IF EXISTS keywords;
CREATE TABLE IF NOT EXISTS keywords (
  id int(11) NOT NULL AUTO_INCREMENT,
  keyword varchar(30) NOT NULL,
  PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table 'keywords_messages'
--

DROP TABLE IF EXISTS keywords_messages;
CREATE TABLE IF NOT EXISTS keywords_messages (
  id int(11) NOT NULL AUTO_INCREMENT,
  keyword_id int(5) NOT NULL,
  message_id int(5) NOT NULL,
  PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table 'messages'
--

DROP TABLE IF EXISTS messages;
CREATE TABLE IF NOT EXISTS messages (
  id int(11) NOT NULL AUTO_INCREMENT,
  jammeur_id int(5) NOT NULL,
  html longtext NOT NULL,
  PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
