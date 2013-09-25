-- phpMyAdmin SQL Dump
-- version 3.4.5
-- http://www.phpmyadmin.net
--
-- Client: localhost
-- Généré le : Mer 25 Septembre 2013 à 18:22
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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=15 ;

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
(14, 6, 'demanesse@bertin.fr');

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=465 ;

--
-- Contenu de la table 'fathers'
--

INSERT INTO fathers (id, father_id, children_id) VALUES
(278, 644, 643),
(279, 649, 644),
(280, 646, 645),
(281, 647, 646),
(282, 652, 653),
(283, 653, 654),
(284, 654, 655),
(285, 657, 621),
(286, 657, 622),
(287, 660, 650),
(288, 655, 656),
(289, 624, 657),
(290, 660, 658),
(291, 660, 659),
(292, 661, 660),
(293, 662, 661),
(294, 663, 662),
(295, 664, 663),
(296, 666, 664),
(297, 666, 665),
(298, 667, 666),
(299, 668, 667),
(300, 669, 668),
(301, 670, 669),
(302, 671, 670),
(303, 672, 671),
(304, 673, 672),
(305, 674, 673),
(306, 675, 674),
(307, 676, 675),
(308, 677, 676),
(309, 678, 677),
(310, 679, 678),
(311, 680, 679),
(312, 681, 680),
(313, 682, 681),
(314, 683, 682),
(315, 684, 683),
(316, 685, 684),
(317, 686, 685),
(318, 689, 686),
(319, 656, 687),
(320, 690, 689),
(321, 691, 690),
(322, 692, 691),
(323, 693, 692),
(324, 694, 693),
(325, 696, 694),
(326, 696, 695),
(327, 697, 696),
(328, 698, 697),
(329, 702, 698),
(330, 702, 701),
(331, 705, 703),
(332, 705, 704),
(333, 706, 705),
(334, 707, 706),
(335, 709, 707),
(336, 711, 710),
(337, 712, 711),
(338, 716, 712),
(339, 714, 713),
(340, 716, 714),
(341, 716, 715),
(342, 722, 721),
(343, 723, 722),
(344, 731, 726),
(345, 731, 728),
(346, 795, 649),
(347, 757, 717),
(348, 759, 718),
(349, 761, 719),
(350, 763, 720),
(351, 788, 723),
(352, 789, 731),
(353, 780, 736),
(354, 789, 737),
(355, 787, 739),
(356, 788, 741),
(357, 789, 742),
(358, 789, 743),
(359, 745, 744),
(360, 748, 745),
(361, 748, 746),
(362, 748, 747),
(363, 749, 748),
(364, 927, 749),
(365, 928, 750),
(366, 930, 751),
(367, 930, 752),
(368, 931, 756),
(369, 932, 757),
(370, 933, 759),
(371, 936, 765),
(372, 945, 775),
(373, 953, 786),
(374, 955, 787),
(375, 956, 788),
(376, 872, 789),
(377, 880, 790),
(378, 795, 794),
(379, 796, 795),
(380, 799, 796),
(381, 799, 797),
(382, 802, 798),
(383, 802, 799),
(384, 802, 800),
(385, 806, 801),
(386, 806, 802),
(387, 806, 803),
(388, 806, 804),
(389, 806, 805),
(390, 811, 810),
(391, 812, 811),
(392, 864, 863),
(393, 795, 865),
(394, 795, 866),
(395, 869, 867),
(396, 869, 868),
(397, 795, 871),
(398, 920, 872),
(399, 920, 874),
(400, 920, 876),
(401, 920, 877),
(402, 920, 878),
(403, 920, 879),
(404, 920, 880),
(405, 920, 881),
(406, 920, 882),
(407, 920, 883),
(408, 920, 884),
(409, 920, 885),
(410, 920, 886),
(411, 920, 887),
(412, 920, 888),
(413, 920, 889),
(414, 920, 890),
(415, 920, 891),
(416, 920, 892),
(417, 920, 893),
(418, 920, 894),
(419, 920, 895),
(420, 920, 896),
(421, 920, 897),
(422, 920, 898),
(423, 920, 899),
(424, 920, 900),
(425, 920, 901),
(426, 920, 902),
(427, 920, 903),
(428, 920, 904),
(429, 920, 905),
(430, 920, 906),
(431, 920, 907),
(432, 920, 908),
(433, 920, 909),
(434, 920, 910),
(435, 920, 911),
(436, 920, 912),
(437, 920, 915),
(438, 920, 916),
(439, 920, 917),
(440, 920, 918),
(441, 920, 919),
(442, 921, 920),
(443, 923, 921),
(444, 924, 922),
(445, 926, 923),
(446, 926, 924),
(447, 926, 925),
(448, 930, 926),
(449, 928, 927),
(450, 930, 928),
(451, 932, 931),
(452, 759, 932),
(453, 761, 933),
(454, 936, 935),
(455, 937, 936),
(456, 956, 937),
(457, 945, 940),
(458, 945, 942),
(459, 789, 945),
(460, 789, 951),
(461, 955, 953),
(462, 956, 955),
(463, 872, 956),
(464, 872, 957);

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=74 ;

--
-- Contenu de la table 'keywords_messages'
--

INSERT INTO keywords_messages (id, keyword_id, message_id) VALUES
(41, 7, 882),
(42, 7, 883),
(43, 7, 884),
(44, 7, 885),
(45, 7, 886),
(46, 7, 887),
(47, 7, 888),
(48, 7, 889),
(49, 7, 890),
(50, 7, 891),
(51, 7, 892),
(52, 7, 893),
(53, 7, 894),
(54, 7, 895),
(55, 7, 896),
(56, 7, 897),
(57, 7, 898),
(58, 7, 899),
(59, 7, 900),
(60, 7, 901),
(61, 7, 902),
(62, 7, 903),
(63, 7, 904),
(64, 7, 905),
(65, 7, 906),
(66, 7, 907),
(67, 7, 908),
(68, 7, 909),
(69, 7, 910),
(70, 7, 911),
(71, 7, 912),
(72, 7, 915),
(73, 7, 916);

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=958 ;

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
