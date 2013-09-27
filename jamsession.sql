-- phpMyAdmin SQL Dump
-- version 3.4.5
-- http://www.phpmyadmin.net
--
-- Client: localhost
-- Généré le : Ven 27 Septembre 2013 à 03:51
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
-- Structure de la table 'emails'
--

DROP TABLE IF EXISTS emails;
CREATE TABLE IF NOT EXISTS emails (
  id int(11) NOT NULL AUTO_INCREMENT,
  jammeur_id int(5) NOT NULL,
  email varchar(50) NOT NULL,
  PRIMARY KEY (id)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=18 ;

--
-- Contenu de la table 'emails'
--

INSERT INTO emails (id, jammeur_id, email) VALUES
(1, 1, 'victor.darde@gmail.com'),
(2, 2, 'RPagneux@vmstar.com'),
(3, 2, 'pagneux.raphael@gmail.com'),
(6, 3, 'dasandre@gmail.com'),
(7, 4, 'thomas.nieuviaert@gmail.com'),
(8, 5, 'jerome.billiard@vam-usa.com'),
(9, 5, 'jerome.billiard@gmail.com'),
(11, 6, 'marc.demanesse@gmail.com'),
(12, 8, 'david.ktorza@gmail.com'),
(13, 7, 'bechet.christophe@gmail.com'),
(14, 6, 'demanesse@bertin.fr'),
(15, 2, 'raphael.pagneux@lcie.fr'),
(16, 5, 'jerome.billiard@vstubos.com'),
(17, 3, 'ded2162@hotmail.com');

-- --------------------------------------------------------

--
-- Structure de la table 'fathers'
--

DROP TABLE IF EXISTS fathers;
CREATE TABLE IF NOT EXISTS fathers (
  id int(11) NOT NULL AUTO_INCREMENT,
  father_id int(5) NOT NULL,
  children_id int(5) NOT NULL,
  PRIMARY KEY (id)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5411 ;

-- --------------------------------------------------------

--
-- Structure de la table 'jammeurs'
--

DROP TABLE IF EXISTS jammeurs;
CREATE TABLE IF NOT EXISTS jammeurs (
  id int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(15) NOT NULL,
  PRIMARY KEY (id)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

--
-- Contenu de la table 'jammeurs'
--

INSERT INTO jammeurs (id, `name`) VALUES
(1, 'Victor'),
(2, 'Raphael'),
(3, 'Andre'),
(4, 'Thomas'),
(5, 'Jerome'),
(6, 'Marc'),
(7, 'Christophe'),
(8, 'David');

-- --------------------------------------------------------

--
-- Structure de la table 'keywords'
--

DROP TABLE IF EXISTS keywords;
CREATE TABLE IF NOT EXISTS keywords (
  id int(11) NOT NULL AUTO_INCREMENT,
  keyword varchar(30) NOT NULL,
  PRIMARY KEY (id)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

--
-- Contenu de la table 'keywords'
--

INSERT INTO keywords (id, keyword) VALUES
(1, 'kebab'),
(2, 'moitax'),
(3, 'barlouk'),
(4, 'zozo'),
(5, 'foutrabilité'),
(6, 'woke'),
(7, 'mcuc');

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=368 ;

-- --------------------------------------------------------

--
-- Structure de la table 'messages'
--

DROP TABLE IF EXISTS messages;
CREATE TABLE IF NOT EXISTS messages (
  id int(11) NOT NULL AUTO_INCREMENT,
  jammeur_id int(5) NOT NULL,
  html longtext NOT NULL,
  father_html mediumtext NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (id)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9722 ;

-- --------------------------------------------------------

--
-- Structure de la table 'users'
--

DROP TABLE IF EXISTS users;
CREATE TABLE IF NOT EXISTS users (
  id int(10) unsigned NOT NULL AUTO_INCREMENT,
  username varchar(50) DEFAULT NULL,
  `password` varchar(50) DEFAULT NULL,
  created datetime DEFAULT NULL,
  modified datetime DEFAULT NULL,
  PRIMARY KEY (id)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=15 ;

--
-- Contenu de la table 'users'
--

INSERT INTO users (id, username, `password`, created, modified) VALUES
(14, 'Bouaziz', 'a6e7ebf7b474938a1c44fa04a30668886610ee8e', '2013-09-24 17:19:00', '2013-09-24 17:19:00');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
