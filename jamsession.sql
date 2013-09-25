-- phpMyAdmin SQL Dump
-- version 3.4.5
-- http://www.phpmyadmin.net
--
-- Client: localhost
-- Généré le : Mer 25 Septembre 2013 à 14:20
-- Version du serveur: 5.5.16
-- Version de PHP: 5.3.8

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de données: `jamsession`
--

-- --------------------------------------------------------

--
-- Structure de la table `emails`
--

CREATE TABLE IF NOT EXISTS `emails` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `jammeur_id` int(5) NOT NULL,
  `email` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=14 ;

--
-- Contenu de la table `emails`
--

INSERT INTO `emails` (`id`, `jammeur_id`, `email`) VALUES
(1, 1, 'victor.darde@gmail.com'),
(2, 2, 'RPagneux@vmstar.com'),
(3, 2, 'pagneux.raphael@gmail.com'),
(6, 3, 'dasandre@gmail.com'),
(7, 4, 'thomas.nieuviaert@gmail.com'),
(8, 5, 'Jerome.Billiard@vam-usa.com'),
(9, 5, 'jerome.billiard@gmail.com'),
(11, 6, 'marc.demanesse@gmail.com'),
(12, 8, 'david.ktorza@gmail.com'),
(13, 7, 'bechet.christophe@gmail.com');

-- --------------------------------------------------------

--
-- Structure de la table `fathers`
--

CREATE TABLE IF NOT EXISTS `fathers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `father_id` int(5) NOT NULL,
  `children_id` int(5) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=59 ;

--
-- Contenu de la table `fathers`
--

INSERT INTO `fathers` (`id`, `father_id`, `children_id`) VALUES
(42, 83, 179),
(43, 83, 181),
(44, 83, 183),
(45, 83, 186),
(46, 83, 187),
(47, 83, 188),
(48, 83, 190),
(49, 83, 192),
(50, 83, 196),
(51, 83, 197),
(52, 83, 198),
(53, 83, 201),
(54, 112, 212),
(55, 238, 292),
(56, 238, 294),
(57, 254, 300),
(58, 254, 301);

-- --------------------------------------------------------

--
-- Structure de la table `jammeurs`
--

CREATE TABLE IF NOT EXISTS `jammeurs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(15) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

--
-- Contenu de la table `jammeurs`
--

INSERT INTO `jammeurs` (`id`, `name`) VALUES
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
-- Structure de la table `keywords`
--

CREATE TABLE IF NOT EXISTS `keywords` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `keyword` varchar(30) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

--
-- Contenu de la table `keywords`
--

INSERT INTO `keywords` (`id`, `keyword`) VALUES
(1, 'kebab'),
(2, 'moitax'),
(3, 'barlouk'),
(4, 'zozo'),
(5, 'foutrabilité'),
(6, 'woke'),
(7, 'mcuc');

-- --------------------------------------------------------

--
-- Structure de la table `keywords_messages`
--

CREATE TABLE IF NOT EXISTS `keywords_messages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `keyword_id` int(5) NOT NULL,
  `message_id` int(5) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=11 ;

-- --------------------------------------------------------

--
-- Structure de la table `messages`
--

CREATE TABLE IF NOT EXISTS `messages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `jammeur_id` int(5) NOT NULL,
  `html` longtext NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=311 ;

--
-- Contenu de la table `messages`
--

INSERT INTO `messages` (`id`, `jammeur_id`, `html`, `timestamp`) VALUES
(238, 3, 'pour moi le mode berserk se dÃ©clenche souvent quand je suis foncedÃ©, je\r\n suis\r\nbcp plus relachÃ© au niveau du poignet donc Ã§a passe bcp mieux. mais je \r\nvois\r\nce que tu veux dire, ya des jours ou Ã§a chie un peu et puis des fois tu t\r\ne\r\nmets a jouer et ta limpression d''etre une star. faudrait que je menregistre\r\npour savoir si c qu''une impression ou si c vraiment mieux. je suis sur le\r\npoint de finir vicarious de tool, elle cartonne bien. le dÃ©but est assez\r\nhypnotique, bien trippant a jouer foncedÃ©', '2008-06-17 13:53:52'),
(239, 8, 'That s a hell of a jam !\r\n\r\nBon, sinon, hier soir je me suis bien fait plez ! je suis reste chez moi (c\r\ne\r\nqui m est pas arrive depuis helskinki en 1971) etant encore un peu creuve\r\n(et sous le coup d un petit retour de champs, j ai jamais fait des reves\r\naussi chelou que cette nuit). J''ai donc passe ma soiree sur la gratte. Bon,\r\nje sais que cette remarque va concerner qu une petite partie des jammeurs,\r\nmais a cela je pose la question: est-ce que ca vous arrive, apres avoir\r\nlaisse quelques jours la gratte (ou la basse, ou le saxo ou ce que vous\r\nvoulez) vous vous y collez un peu serieusement et la (des fois, ca arrive\r\npas souvent) , BIM, il se passe un truc chelou, un genre mode Berserk qui s\r\ne\r\ndeclenche; genre vous jouez comme vous jouez tres tres rarement, tous les\r\nmorceaux passent carrement, c''est hyper fluide... Ca cartonne tellement ces\r\nmoments la. Total je voulais me pieuter vers 11h et a 1h du mat j etais\r\ntoujours pas au lit, mais putain je le regrette pas...', '2008-06-17 13:45:35'),
(240, 3, 'troiz, batard', '2008-06-17 12:30:11'),
(241, 8, 'EHEHEH, qui est ce qui fait ses allers/retours en business ?', '2008-06-17 12:10:50'),
(242, 8, 'deuz.. batard pop, je suis sur que t etais pas au taff...\r\nbon au moins j ai pense a l annif de gg...\r\n\r\n\r\n\r\nLe 17 juin \r08 08:47, Thomas Nieuviaert <thomas.nieuviaert@gmail.com a\r\nÃ©crit :\r\n\r\n men i fuckin'' missed gg''s birthday\r\n happy birthday dude', '2008-06-17 11:54:40'),
(243, 4, 'men i fuckin'' missed gg''s birthday\r\nhappy birthday dude', '2008-06-17 11:47:52'),
(244, 3, 'bon il est tard la, jme casse putain', '2008-06-16 22:09:22'),
(245, 8, 'yep\r\nToute la semaine en fait, mais je bosse le reste du temps\r\n\r\n\r08/6/18 Victor Darde <victor.darde@gmail.com:\r\n\r\n j''ai pas bien capte ton mail avec les week end David. 18-19-\r juillet,\r\n t''es a barcelone?', '2008-06-18 18:12:50'),
(246, 1, 'j''ai pas bien capte ton mail avec les week end David. 18-19-\r juillet, t''e\r\ns\r\na barcelone?', '2008-06-18 17:59:29'),
(247, 1, 'mcuc\r\n\r\n\r08/6/17 Pagneux, Raphael <RPagneux@vmstar.com:\r\n\r\n J ai decale ma pause du dejeuner pour voir les 30 premieres minutes85\r\n difficiles de faire pire comme combinaison blessure+carton rouge+ peno\r\n\r\n\r\n\r\n Reste plus qu a esperer que domenech lache une sextape avec sa meuf pour \r\nse\r\n faire pardonner\r\n\r\n\r\n\r\n Raphael Pagneux\r\n V&M STAR\r\n 8603 Sheldon Rd.\r\n Houston, TX 77049\r\n phone: 281-456-6007\r\n cell: 832-729-1723\r\n rpagneux@vmstar.com', '2008-06-18 17:51:11'),
(248, 3, 'putain g trop envie de lacher des enormes caisses depuis ce matin mais ya l\r\ne\r\nstagiaire', '2008-06-18 17:19:38'),
(249, 3, 'ah batard', '2008-06-18 16:37:35'),
(250, 8, 'sorry no', '2008-06-18 16:05:59'),
(251, 3, 'tu penses quya moyen quon squatte chez ta pote oupa?', '2008-06-18 15:54:11'),
(252, 8, 't inquiete je me fais bien chier tout seul... j avais deja prevenu ma copin\r\ne\r\na berlin.. classe.', '2008-06-18 15:27:48'),
(253, 3, 'putain tu fais chier la...', '2008-06-18 15:19:09'),
(254, 8, 'hep hep, gaffe avec Barcelone, la, il faut que je confirme les dates vu que\r\nje serai souvent a Paris...\r\nles we dispos sont:\r\n\r\n12 - 13 - 14 juillet\r\n12 - \r juillet (j''arrive vendredi, y a moyen d y aller ensemble)\r\n2 - 3 aout\r\n9 - 10 aout (meme remarque)\r\n15 - 16 - 17 aout\r\n23 - 24 aout (meme remarque)\r\n11 - 12 -13 - 14 septembre\r\n\r - 21 septembre (meme remarque)\r\n27 - 28 septembre\r\n\r\napres c est le chomdu, donc ou je suis disponible a 100% ou je suis pas la\r\ndu tout', '2008-06-18 15:17:05'),
(255, 8, 'Aaah, merde !\r\nj avais pas calcule mais le 7 c est l anniv de ma soeur, je lui ai dit que\r\nje serai la...\r\n\r\nSA RACE...', '2008-06-18 15:12:55'),
(256, 3, 'berlin c du 5 au 7 il me semble\r\npour ibiza, c pas lenvie qui me manque mais les thunes, a voir. je veux d\r\nÃ©ja\r\nessayer de venir a bcn 2 semaines avant donc bon', '2008-06-18 15:11:50'),
(257, 8, 'c est quand le we a berlin deja ? va falloir reserver la..\r\nsinon j ai envie de proposer le we du 15 aout a IBIZA les filles .. grosses\r\nboites de nuits, nana dÃ©colorÃ©es en mini jupe sous ecstasy, alcool dans\r\n les\r\nquartiers VIP... des volontaires ?', '2008-06-18 15:08:37'),
(258, 8, 'n appartient qu a toi de venir croquer en meme temps..', '2008-06-18 15:01:18'),
(259, 3, 'ok mec je sais plus si t''es un vrai pote la avec tout ce que tu viens de me\r\nmettre dans la gueule', '2008-06-18 14:52:29'),
(260, 8, 'bah elle est arrivÃ©e ici cette semaine et a pas l intention de se barrer\r\navant un moment. Elle a dit qu''elle cuisinerait pour ce week end...', '2008-06-18 14:49:12'),
(261, 3, 'pfff a tous les coups je vais devoir bosser moi', '2008-06-18 14:49:00'),
(262, 8, 'ah, et : we de 4 jours pour la Saint Jean. Feux sur la plage. ca aussi ca v\r\na\r\nEAtre tres tres buen...', '2008-06-18 14:48:15'),
(263, 8, '30BA de prÃ©vu pour ce week end. 2 jours de Festival Electro plein air. C\r\na va\r\nEAtre mons-tru-eux.', '2008-06-18 14:47:37'),
(264, 3, 'clair, ma pote marie jeanne c cassÃ©e comme une pute, je sais pas quand je\r\n la\r\nreverrai', '2008-06-18 14:46:31'),
(265, 8, 't''inquiete. c''est dans des moments comme ca qu''on reconnait les vrais\r\npotes..', '2008-06-18 14:43:25'),
(266, 3, 'ouais ct assez rude. merci detre la buddy', '2008-06-18 14:36:41'),
(267, 8, 'bon mec, on aura fait 2 demi journÃ©es de jam en tEAte E0 tEAte... Je p\r\neux t\r\nappeller Wilson ?', '2008-06-18 14:04:15'),
(268, 8, 'nan, c''etait un gars assez grand sur un skate, mais comme tout est un peu\r\nexagere avec les champis bah il paraissait immense', '2008-06-18 13:53:15'),
(269, 3, 'nan, vous etiez au zoo et ct une girafe mec', '2008-06-18 13:43:48'),
(270, 8, 'bah t as pas differentes tailles pour les kits de culture... sinon ouais ! \r\na\r\nun moment on a vu un gars de 5 m samedi, c''etait ouf !!', '2008-06-18 13:40:54'),
(271, 3, 'ta ptet vu un peu trop grand alors', '2008-06-18 13:38:59'),
(272, 8, 'bah tu peux les garder aux frigos quelques jours, mais la y en a trop pour\r\nque je les consomme frais. je suis en train de faire secher la premiere\r\nrecolte et j en ai une deuxieme qui arrive a maturite. Enfin quoi qu il en\r\nsoit j en ai assez pour me faire de la maille et d avoir ma conso assurÃ©e\r\n...', '2008-06-18 13:31:53'),
(273, 3, 'bah tu peux pas les garder au frigo?', '2008-06-18 13:14:16'),
(274, 8, 'Bon... vous auriez pas des potes interesses par des champis des fois ? j en\r\nai pour 3 vies la... tarifs competitifs', '2008-06-18 13:12:58'),
(275, 3, 'oui c bien ce que je voulais dire', '2008-06-18 12:47:25'),
(276, 8, 'bah, en plus la nana est naturellement comme ca donc je peux pas trop lui e\r\nn\r\nvouloir. C''est pas comme si elle me sortait "ce soir tu me prends les\r\nfesses" puis qu''elle me collait une grosse beigne si j''essayais de la\r\ntoucher... Donc en fait je me fais juste du mal parce que je suis un porc..\r\n.', '2008-06-18 12:44:19'),
(277, 3, 'deuz! haha je vois que rien a changÃ©. en meme tps si tu continues c soit \r\nque\r\nt''es maso soit que tu kiffes. je dirai que tu kiffes. a moins que...\r\nbeau but de thierry henry hier! et domenech qui la demande en mariage c du\r\ngrand art', '2008-06-18 12:34:42'),
(278, 8, 'Oooh. Sinon:\r\nJe rentre hier soir (vers 1h30, bien envie de me pieuter) apres avoir tis\r\nÃ©\r\nun coup chez un pote. Et la BIM ! Nera, dans ma piaule, allongÃ©e sur MON \r\nLIT\r\n!! en train de mater un truc sur mon ordi ! Nan mais n''importe quoi !! Je\r\nm''allonge a cotÃ©, on tchatche pas mal, j''arrive E0 lui caler une main su\r\nr la\r\ncuisse que je maintiens un bon quart d''heure... et avant que je manoeuvre\r\nun truc plus osÃ© elle me sort son "bon, a demain" et elle va se pieuter.\r\nElle me prend vraiment pour un con, et ce qui me vener c est que dans ce\r\ngenre de situation c''est ni plus ni moins ce que je suis...\r\n\r\n\r\n\r\n\r\n\r08/6/18 David Ktorza <david.ktorza@gmail.com:\r\n\r\n preum''s\r\n putain de soleil aujourd hui, ca fait plez\r\n\r\n\r\n Le 17 juin \r08 23:38, Jerome Billiard <Jerome.Billiard@vam-usa.com a\r\n Ã©crit :\r\n\r\n ah oui, et pour les geeks, noubliez pas de dl firefox 3 aujourdhui.\r\n\r\n Jerome Billiard\r\n VAM USA\r\n 19210 E.Hardy Rd\r\n Houston, TX 77073\r\n phone: 281-230-5729\r\n cell: 713-494-4353\r\n jerome.billiard@vam-usa.com', '2008-06-18 12:13:50'),
(279, 8, 'preum''s\r\nputain de soleil aujourd hui, ca fait plez', '2008-06-18 12:06:52'),
(280, 4, 'en meme temps domenech en sextape il pourrait etre avec nathalie portman ca\r\nme la couperai severe je crois\r\n\r\n\r08/6/17 Pagneux, Raphael <RPagneux@vmstar.com:\r\n\r\n J ai decale ma pause du dejeuner pour voir les 30 premieres minutes85\r\n difficiles de faire pire comme combinaison blessure+carton rouge+ peno\r\n\r\n\r\n\r\n Reste plus qu a esperer que domenech lache une sextape avec sa meuf pour \r\nse\r\n faire pardonner\r\n\r\n\r\n\r\n Raphael Pagneux\r\n V&M STAR\r\n 8603 Sheldon Rd.\r\n Houston, TX 77049\r\n phone: 281-456-6007\r\n cell: 832-729-1723\r\n rpagneux@vmstar.com', '2008-06-18 00:40:27'),
(281, 4, 'putain mais bite ribery blessÃ© remplacÃ© par nasri, abidal expulsÃ© pen\r\nalty\r\nremplacement de nasri par boumsong cest nimp or what?', '2008-06-18 00:37:36'),
(282, 3, 'putain en ce moment je me barre de plus en plus tard foutre\r\n\r\n\r08/6/17 Pagneux, Raphael <RPagneux@vmstar.com:\r\n\r\n Oki\r\n\r\n\r\n\r\n Je viens de m inscrire a l AI , j espere que c est pas seulement le repai\r\nre\r\n de denis mongy et consort , et que y a aussi des mec de 30 ans genre gord\r\non\r\n gekko qui cheche une jeune recrue ambitieuse 85\r\n\r\n\r\n\r\n Raphael Pagneux\r\n V&M STAR\r\n 8603 Sheldon Rd.\r\n Houston, TX 77049\r\n phone: 281-456-6007\r\n cell: 832-729-1723\r\n rpagneux@vmstar.com', '2008-06-17 22:25:36'),
(283, 3, 'ils nous avaient envoyÃ© un pdf avec je crois. tu peux le redemander a un \r\nmec\r\ndu cri', '2008-06-17 21:32:11'),
(284, 8, 'TIME MARCHES ON (on..) !!!\r\nTrop tard mec, deja envoye et je me barre...', '2008-06-17 21:07:27'),
(285, 3, 'to whom it may concern?', '2008-06-17 21:05:07'),
(286, 8, 'hmmm, une ford mustang de 3 ou 4 ans avec 25 000 bornes ici ca coute quand\r\nmeme la bagatelle de 40K80... ils se font pas chier...', '2008-06-17 20:56:16'),
(287, 8, 'c''est clair ! bon, c''etait la version WRC dans ma tete, mais c est pas le\r\nmeme prix je pense...\r\n\r\n\r\n\r08/6/17 Pagneux, Raphael <RPagneux@vmstar.com:\r\n\r\n He c est buene ca une imprezza\r\n\r\n Prends une 350Z , de loin la nuit ca ressemble a une audi TT85\r\n\r\n\r\n\r\n Raphael Pagneux\r\n V&M STAR\r\n 8603 Sheldon Rd.\r\n Houston, TX 77049\r\n phone: 281-456-6007\r\n cell: 832-729-1723\r\n rpagneux@vmstar.com', '2008-06-17 20:43:34'),
(288, 8, 'c''est tres tres utile un pick up ...\r\nsinon une voiture de rally, genre Subaru Impresa ou un truc comme ca.. quan\r\nd\r\nj etais gamin et que je chiquait tout le monde a GT, je m etais jurÃ© d\r\nacheter cette bagnole, ou une Nissan Skyline...', '2008-06-17 20:31:54'),
(289, 8, 'Sinon, grosse performance d un fournisseur de convoyeurs:\r\non a commandÃ© 10 pieces de fixations des rampes, il en envoie 4 avec un m\r\not\r\ngenre "on en avait pas plus donc on vous a mis des longueurs de chaine a la\r\nplace".. WTF ??? Je fais comment, j''attache les rampes en enroulant la\r\nchaine ??? N''importe quoi ! Genre tu commandes une pizza et le mec te sort\r\n"dÃ©solÃ©, y avait plus de Regina, alors je vous ai mis des lasagnes epin\r\nards\r\na la place...". C''est ouf !!', '2008-06-17 20:22:25'),
(290, 8, 'ils ont ressorti la fiat 500. pour moi ca sera ca ou une mini (je kiffe\r\ncette voiture. tu choppes juste en t arretant au feu rouge)\r\npour mon Dear M. je peux aller me faire mettre sinon, j ai limpression...\r\n\r\n\r\n\r\n\r08/6/17 Pagneux, Raphael <RPagneux@vmstar.com:\r\n\r\n Hey mec ! t es ne paris 12 ! big up bro ! moi aussi !\r\n\r\n\r\n\r\n Raphael Pagneux\r\n V&M STAR\r\n 8603 Sheldon Rd.\r\n Houston, TX 77049\r\n phone: 281-456-6007\r\n cell: 832-729-1723\r\n rpagneux@vmstar.com', '2008-06-17 20:19:31'),
(291, 3, 'ct pas du tout Ã§a que je voulais dire, je voulais juste partager la cultu\r\nre\r\net parler portugais.\r\n\r\nLe 19 juin \r08 15:02, Marc DEMANESSE <demanesse@bertin.fr a Ã©crit :\r\n\r\n hÃ©hÃ© j''en attendais pas moins de toi. Pour info elle est haute comme \r\n3\r\n pommes, j''ai essayÃ© de la chopper et je me suis mangÃ© le mur de l''ex \r\navec\r\n qui elle Ã©tait restÃ©e 10 ans (10 ans, foutre !), qu''il l''avait plaqu\r\nÃ©e 3\r\n mois avant mon insidieuse tentative, et avec qui elle espÃ©rait se remet\r\ntre\r\n aprE8s son retour de Nouvelle ZÃ©lande.\r\n\r\n\r\n Andre Da Silva a Ã©crit :\r\n\r\n nan, en fait c ptet moi qui Ã©tait a louest et qui ai racontÃ© de la me\r\nrde.\r\n je laisserai le soin aux autres de juger.\r\n bon sinon marco, moi je peux men occuper de ta copine portugaise, elle se\r\n sentira comme a la maison\r\n\r\n Le 19 juin \r08 14:31, Marc DEMANESSE <demanesse@bertin.fr a Ã©crit :\r\n\r\n Bon comment ca va la dedans ? DD j''ai rien compris E0 ton message sur l\r\ne\r\n fait que je mette une heure E0 taper un message mais c''est pas grave je\r\n suis\r\n particuliE8rement E0 la rue aujourd''hui. Pfff la j''ai envie de dormir \r\nd''une\r\n force. Je lis une doc sur l''optimisation de la formation des petits cycl\r\nones\r\n mais va bien falloir que je passe E0 l''action, gnnnnn.\r\n\r\n En aout E0 Barca vous allez prendre cher non ? touristiquement et\r\n chaudement parlant...\r\n\r\n Je reviens sur hier. Yavait aussi le big boss Bertin comme je disais. Je\r\n savais qu''il Ã©tait bien sympa et j''ai pu le vÃ©rifier. En plus il fai\r\nt bien\r\n attention E0 son look l''enfoirÃ© et il bombe le torse comme un ouf, c''\r\nest\r\n marrant. Genre 45 ans, bien baraque qui fait rever les mÃ©nagE8res. T''\r\nas\r\n l''impression qu''il va dÃ©chirer son t shirt avec ses pecs, la classe qu\r\noi...\r\n Bon sinon il a pas mis un but, c''Ã©tait plutot tout dans le style.\r\n\r\n Enfin j''ai une copine d''origine portuguaise de Toronto que j''apprÃ©cie\r\n Ã©normÃ©ment qui vient en Europe E0 partir du 26 juin. Elle pense res\r\nter en\r\n Espagne/Portugal et passer sur Paris aprE8s. Mais j''ai peur que Ã§a le\r\n fasse\r\n pas vu que je suis deux jours E0 la Seyne sur Mer, deux jours E0 Marse\r\nille et\r\n deux jours E0 Munich et aprE8s c''est les Solidays... Ca me ferait supe\r\nr\r\n plaisir de la revoir sÃ©rieux.\r\n\r\n\r\n Andre Da Silva a Ã©crit :\r\n\r\n putain, il fait trop beau, j''ai tellement pas envie de bosser...\r\n je voudrais juste fumer un bÃ©do et mallonger dans l''herbe putain\r\n putain', '2008-06-19 18:07:49'),
(292, 3, 'Les informations contenues dans ce message Ã©lectronique peuvent EAtre de\r\n nature confidentielle et soumises E0 une obligation de secret. Elles sont\r\n destinÃ©es E0 l''usage exclusif du rÃ©el destinataire. Si vous n''EAtes\r\n pas le rÃ©el destinataire ou si vous recevez ce message par erreur, merci\r\n de nous le notifier immÃ©diatement en le retournant E0 l''adresse de son \r\nÃ©metteur.\r\n\r\nThe information contained in this e-mail may be privileged and\r\n confidential. It is intended for the exclusive use of the designated\r\n recipients named above. If you are not the intended recipient or if you\r\n receive this e-mail in error, please notify us immediatly and return the\r\n original message at the address of the sender.\r\n--_Boundary_KsIdMflzUpdBWbNhihSg--', '2008-06-19 18:02:36'),
(293, 3, 'nan, en fait c ptet moi qui Ã©tait a louest et qui ai racontÃ© de la merd\r\ne. je\r\nlaisserai le soin aux autres de juger.\r\nbon sinon marco, moi je peux men occuper de ta copine portugaise, elle se\r\nsentira comme a la maison\r\n\r\nLe 19 juin \r08 14:31, Marc DEMANESSE <demanesse@bertin.fr a Ã©crit :\r\n\r\n Bon comment ca va la dedans ? DD j''ai rien compris E0 ton message sur le\r\n fait que je mette une heure E0 taper un message mais c''est pas grave je \r\nsuis\r\n particuliE8rement E0 la rue aujourd''hui. Pfff la j''ai envie de dormir d\r\n''une\r\n force. Je lis une doc sur l''optimisation de la formation des petits cyclo\r\nnes\r\n mais va bien falloir que je passe E0 l''action, gnnnnn.\r\n\r\n En aout E0 Barca vous allez prendre cher non ? touristiquement et chaude\r\nment\r\n parlant...\r\n\r\n Je reviens sur hier. Yavait aussi le big boss Bertin comme je disais. Je\r\n savais qu''il Ã©tait bien sympa et j''ai pu le vÃ©rifier. En plus il fait\r\n bien\r\n attention E0 son look l''enfoirÃ© et il bombe le torse comme un ouf, c''e\r\nst\r\n marrant. Genre 45 ans, bien baraque qui fait rever les mÃ©nagE8res. T''a\r\ns\r\n l''impression qu''il va dÃ©chirer son t shirt avec ses pecs, la classe quo\r\ni...\r\n Bon sinon il a pas mis un but, c''Ã©tait plutot tout dans le style.\r\n\r\n Enfin j''ai une copine d''origine portuguaise de Toronto que j''apprÃ©cie\r\n Ã©normÃ©ment qui vient en Europe E0 partir du 26 juin. Elle pense rest\r\ner en\r\n Espagne/Portugal et passer sur Paris aprE8s. Mais j''ai peur que Ã§a le \r\nfasse\r\n pas vu que je suis deux jours E0 la Seyne sur Mer, deux jours E0 Marsei\r\nlle et\r\n deux jours E0 Munich et aprE8s c''est les Solidays... Ca me ferait super\r\n plaisir de la revoir sÃ©rieux.\r\n\r\n\r\n\r\n Andre Da Silva a Ã©crit :\r\n\r\n putain, il fait trop beau, j''ai tellement pas envie de bosser...\r\n je voudrais juste fumer un bÃ©do et mallonger dans l''herbe putain\r\n putain', '2008-06-19 17:35:25'),
(294, 3, 'Les informations contenues dans ce message Ã©lectronique peuvent EAtre de\r\n nature confidentielle et soumises E0 une obligation de secret. Elles sont\r\n destinÃ©es E0 l''usage exclusif du rÃ©el destinataire. Si vous n''EAtes\r\n pas le rÃ©el destinataire ou si vous recevez ce message par erreur, merci\r\n de nous le notifier immÃ©diatement en le retournant E0 l''adresse de son \r\nÃ©metteur.\r\n\r\nThe information contained in this e-mail may be privileged and\r\n confidential. It is intended for the exclusive use of the designated\r\n recipients named above. If you are not the intended recipient or if you\r\n receive this e-mail in error, please notify us immediatly and return the\r\n original message at the address of the sender.\r\n--_Boundary_xHNAPiojs5htDTi0261J--', '2008-06-19 17:31:22'),
(295, 3, 'putain, il fait trop beau, j''ai tellement pas envie de bosser...\r\nje voudrais juste fumer un bÃ©do et mallonger dans l''herbe putain\r\nputain', '2008-06-19 17:27:15'),
(296, 1, 'it''s done.\r\n 1 Aug 14:\r KF8benhavn 1 Aug 17:10 Barcelona JK34  **\r\n **\r\n\r\nHjemrejse SF8ndag 03 August \r08\r\nAfg Tider Fra Ank Tider Til Flight  3 Aug 18:35 Barcelona 3 Aug 21:30\r\nKF8benhavn JK31', '2008-06-19 17:01:57'),
(297, 3, 'vasy champion', '2008-06-19 16:57:14'),
(298, 1, 'ok, moi j''achete tout de suite, car j''ai un peu peur de me faire carotte', '2008-06-19 16:55:44'),
(299, 3, 'moi je vais attendre d''etre payÃ© (dans 3-4 jours) mais ouais ce sera bon\r\npour ce weekend la', '2008-06-19 16:54:12'),
(300, 1, 'je viens d''avoir David au telephone. il m''a confirme que c''etait bon pour c\r\ne\r\nweek end, et il m''a dit qu''on trouverait un moyen pour que t''ailles a\r\nl''aeroport. peut etre qu''il devra aller a la Ferte ce lundi la, et du coup\r\ntu prends un taxi de la boite, ou alors tu raques tes \r 80 de taxi. bref,\r\n y\r\naura toujours une solution. on achete?', '2008-06-19 16:52:30'),
(301, 1, 'je viens d''avoir David au telephone. il m''a confirme que c''etait bon pour c\r\ne\r\nweek end, et il m''a dit qu''on trouverait un moyen pour que t''ailles a\r\nl''aeroport. peut etre qu''il devra aller a la Ferte ce lundi la, et du coup\r\ntu prends un taxi de la boite, ou alors tu raques tes \r 80 de taxi. bref,\r\n y\r\naura toujours une solution. on achete?', '2008-06-19 16:51:50'),
(302, 1, 'j''arrive vendredi a 17h et je repars dimanche 18h30', '2008-06-19 16:22:53'),
(303, 3, 'c quoi tes horaires toi?', '2008-06-19 15:27:00'),
(304, 1, 'ca fait un peu chier. david a peut etre une solution, genre des bus de nuit\r\n.\r\nmais il faudrait que j''achete vite fait, c''est pour ca que j''essaie de\r\nbouger un peu le droguÃ©', '2008-06-19 15:09:07'),
(305, 3, 't''es au taquet!\r\nj''ai regardÃ© les horaires, le premier bus part a 5h30 donc c mort. j\r\nprendrai le dernier a 00h15 je pense', '2008-06-19 15:07:46'),
(306, 1, 'il repond pas, j''ai envoye un texto. peut etre que marco est au courant pou\r\nr\r\nles horaires', '2008-06-19 15:05:40'),
(307, 3, 'je pense que je vais devoir prendre le dernier bus, le dimanche soir, et\r\npioncer 4-5 heures a laeroport', '2008-06-19 15:02:33'),
(308, 1, 'je passe un coup de fil a david pour lui demander', '2008-06-19 15:00:11'),
(309, 3, 'putain le premier aerobus est a 5h30. bitch', '2008-06-19 14:58:51'),
(310, 3, 'si mais c 9080 de plus', '2008-06-19 14:51:59');

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(50) DEFAULT NULL,
  `password` varchar(50) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=15 ;

--
-- Contenu de la table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `created`, `modified`) VALUES
(14, 'Bouaziz', 'a6e7ebf7b474938a1c44fa04a30668886610ee8e', '2013-09-24 17:19:00', '2013-09-24 17:19:00');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
