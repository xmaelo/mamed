-- phpMyAdmin SQL Dump
-- version 3.5.1
-- http://www.phpmyadmin.net
--
-- Client: localhost
-- Généré le: Mer 22 Novembre 2017 à 10:12
-- Version du serveur: 5.5.24-log
-- Version de PHP: 5.4.3

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de données: `diabete`
--

-- --------------------------------------------------------

--
-- Structure de la table `diabete`
--

CREATE TABLE IF NOT EXISTS `diabete` (
  `iddiabete` int(11) NOT NULL AUTO_INCREMENT,
  `type` varchar(100) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `date_save` date DEFAULT NULL,
  `lisible` tinyint(1) DEFAULT '1',
  PRIMARY KEY (`iddiabete`),
  UNIQUE KEY `iddiabete_UNIQUE` (`iddiabete`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=12 ;

--
-- Contenu de la table `diabete`
--

INSERT INTO `diabete` (`iddiabete`, `type`, `description`, `date_save`, `lisible`) VALUES
(4, 'Type1', 'Diabete de type 1', '2017-11-11', 1),
(5, 'Type2', 'Diabete de type 2', '2017-11-11', 1),
(6, 'Type3', 'Diabete de type 3', '2017-11-11', 1),
(7, 'Type4', 'Diabete de type 4', '2017-11-11', 1);

-- --------------------------------------------------------

--
-- Structure de la table `journal`
--

CREATE TABLE IF NOT EXISTS `journal` (
  `idjournal` int(11) NOT NULL AUTO_INCREMENT,
  `heure` time NOT NULL,
  `mesure_idmesure` int(11) NOT NULL,
  `valeur` float DEFAULT NULL,
  `insuline` float DEFAULT NULL,
  `insuline2` float NOT NULL,
  `pression_arterielle` varchar(100) DEFAULT NULL,
  `acetone` float NOT NULL,
  `hba1c` float DEFAULT NULL,
  `notes` text NOT NULL,
  `date_save` date DEFAULT NULL,
  `lisible` tinyint(1) DEFAULT '1',
  `patient_idpatient` int(11) NOT NULL,
  PRIMARY KEY (`idjournal`),
  UNIQUE KEY `idjournal_UNIQUE` (`idjournal`),
  KEY `fk_journal_patient1_idx` (`patient_idpatient`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=9 ;

-- --------------------------------------------------------

--
-- Structure de la table `medecin`
--

CREATE TABLE IF NOT EXISTS `medecin` (
  `idmedecin` int(11) NOT NULL AUTO_INCREMENT,
  `nombre_max_patient` int(11) DEFAULT NULL,
  `etat` tinyint(1) NOT NULL DEFAULT '1',
  `date_save` date DEFAULT NULL,
  `lisible` tinyint(1) DEFAULT '1',
  `specialite_idspecialite` int(11) NOT NULL,
  `anciennete` int(11) NOT NULL,
  `personne_idpersonne` int(11) NOT NULL,
  PRIMARY KEY (`idmedecin`),
  UNIQUE KEY `idmedecin_UNIQUE` (`idmedecin`),
  KEY `fk_medecin_specialite_idx` (`specialite_idspecialite`),
  KEY `fk_medecin_personne1_idx` (`personne_idpersonne`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `message`
--

CREATE TABLE IF NOT EXISTS `message` (
  `idmessage` int(11) NOT NULL AUTO_INCREMENT,
  `message` varchar(255) DEFAULT NULL,
  `date_save` date DEFAULT NULL,
  `heure` time DEFAULT NULL,
  `etat` tinyint(1) DEFAULT NULL,
  `lisible` tinyint(1) DEFAULT '1',
  `patient_idpatient` int(11) NOT NULL,
  `medecin_idmedecin` int(11) NOT NULL,
  PRIMARY KEY (`idmessage`),
  KEY `fk_message_patient1_idx` (`patient_idpatient`),
  KEY `fk_message_medecin1_idx` (`medecin_idmedecin`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `mesure`
--

CREATE TABLE IF NOT EXISTS `mesure` (
  `idmesure` int(11) NOT NULL AUTO_INCREMENT,
  `libelle` varchar(100) NOT NULL,
  PRIMARY KEY (`idmesure`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=9 ;

--
-- Contenu de la table `mesure`
--

INSERT INTO `mesure` (`idmesure`, `libelle`) VALUES
(1, 'Au lever'),
(2, 'Avant le petit dejeuner'),
(3, 'Apres le petit dejeuner'),
(4, 'Avant le dejeuner'),
(5, 'Apres le dejeuner'),
(6, 'Avant le diner'),
(7, 'Apres le diner'),
(8, 'Au coucher');

-- --------------------------------------------------------

--
-- Structure de la table `mesure_patient`
--

CREATE TABLE IF NOT EXISTS `mesure_patient` (
  `idmesure_patient` int(11) NOT NULL AUTO_INCREMENT,
  `patient_idpatient` int(11) NOT NULL,
  `mesure_idmesure` int(11) NOT NULL,
  `etat` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`idmesure_patient`),
  KEY `patient_idpatient` (`patient_idpatient`),
  KEY `mesure_idmesure` (`mesure_idmesure`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=9 ;

-- --------------------------------------------------------

--
-- Structure de la table `patient`
--

CREATE TABLE IF NOT EXISTS `patient` (
  `idpatient` int(11) NOT NULL AUTO_INCREMENT,
  `poids` float NOT NULL,
  `taille` float NOT NULL,
  `imc` float DEFAULT NULL,
  `interpretation` varchar(100) NOT NULL,
  `nom_contact_urgence` varchar(255) NOT NULL,
  `telephone_contact_urgence` varchar(45) NOT NULL,
  `etat` tinyint(1) DEFAULT '1',
  `date_save` date DEFAULT NULL,
  `lisible` tinyint(1) DEFAULT '1',
  `diabete_iddiabete` int(11) NOT NULL,
  `personne_idpersonne` int(11) NOT NULL,
  PRIMARY KEY (`idpatient`),
  UNIQUE KEY `idpatient_UNIQUE` (`idpatient`),
  KEY `fk_patient_diabete1_idx` (`diabete_iddiabete`),
  KEY `fk_patient_personne1_idx` (`personne_idpersonne`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=69 ;

-- --------------------------------------------------------

--
-- Structure de la table `patient_has_medecin`
--

CREATE TABLE IF NOT EXISTS `patient_has_medecin` (
  `idpatient_has_medecin` int(11) NOT NULL AUTO_INCREMENT,
  `patient_idpatient` int(11) NOT NULL,
  `medecin_idmedecin` int(11) NOT NULL,
  `etat` tinyint(1) NOT NULL DEFAULT '1',
  `date_save` date DEFAULT NULL,
  PRIMARY KEY (`idpatient_has_medecin`),
  UNIQUE KEY `idpatient_idpatient_UNIQUE` (`idpatient_has_medecin`),
  KEY `fk_patient_has_medecin_medecin1_idx` (`medecin_idmedecin`),
  KEY `fk_patient_has_medecin_patient1_idx` (`patient_idpatient`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `personne`
--

CREATE TABLE IF NOT EXISTS `personne` (
  `idpersonne` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(100) NOT NULL,
  `prenom` varchar(100) DEFAULT NULL,
  `datenaiss` date NOT NULL,
  `sexe` varchar(10) NOT NULL,
  `adresse` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `telephone1` varchar(45) NOT NULL,
  `telephone2` varchar(45) DEFAULT NULL,
  `photo` varchar(100) DEFAULT NULL,
  `date_save` date DEFAULT NULL,
  `lisible` tinyint(1) DEFAULT '1',
  PRIMARY KEY (`idpersonne`),
  UNIQUE KEY `idpersonne_UNIQUE` (`idpersonne`),
  UNIQUE KEY `email_UNIQUE` (`email`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=89 ;

--
-- Contenu de la table `personne`
--

INSERT INTO `personne` (`idpersonne`, `nom`, `prenom`, `datenaiss`, `sexe`, `adresse`, `email`, `telephone1`, `telephone2`, `photo`, `date_save`, `lisible`) VALUES
(22, 'MBA', 'Sonny', '1990-11-14', 'M', 'ACACIA', 'mba@gmail.com', '676544214', '679021182', NULL, '2017-11-14', 1);

-- --------------------------------------------------------

--
-- Structure de la table `preference`
--

CREATE TABLE IF NOT EXISTS `preference` (
  `idpreference` int(11) NOT NULL AUTO_INCREMENT,
  `patient_idpatient` int(11) NOT NULL,
  `rapel_controle_apres_repas` time NOT NULL,
  `alarme_preventive` time NOT NULL,
  `au_lever` tinyint(1) NOT NULL,
  PRIMARY KEY (`idpreference`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `specialite`
--

CREATE TABLE IF NOT EXISTS `specialite` (
  `idspecialite` int(11) NOT NULL AUTO_INCREMENT,
  `libelle` varchar(100) NOT NULL,
  `description_specialite` varchar(255) DEFAULT NULL,
  `date_save` date DEFAULT NULL,
  `lisible` tinyint(1) DEFAULT '1',
  PRIMARY KEY (`idspecialite`),
  UNIQUE KEY `idspecialite_UNIQUE` (`idspecialite`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Contenu de la table `specialite`
--

INSERT INTO `specialite` (`idspecialite`, `libelle`, `description_specialite`, `date_save`, `lisible`) VALUES
(1, 'Diabetologue', NULL, '2017-11-13', 1),
(2, 'Generaliste', NULL, '2017-11-13', 1),
(3, 'Nutritionniste', '', '2017-11-13', 1),
(4, 'Autres', NULL, '2017-11-13', 1);

-- --------------------------------------------------------

--
-- Structure de la table `unite`
--

CREATE TABLE IF NOT EXISTS `unite` (
  `idunite` int(11) NOT NULL AUTO_INCREMENT,
  `libelle` varchar(10) NOT NULL,
  PRIMARY KEY (`idunite`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Contenu de la table `unite`
--

INSERT INTO `unite` (`idunite`, `libelle`) VALUES
(2, 'g/l'),
(3, 'mg/dl'),
(4, 'mmol/l');

-- --------------------------------------------------------

--
-- Structure de la table `unite_patient`
--

CREATE TABLE IF NOT EXISTS `unite_patient` (
  `idunite_patient` int(11) NOT NULL AUTO_INCREMENT,
  `patient_idpatient` int(11) NOT NULL,
  `unite_idunite` int(11) NOT NULL,
  `heure_apres_repas` time NOT NULL,
  `alarme_preventive` time NOT NULL,
  PRIMARY KEY (`idunite_patient`),
  UNIQUE KEY `patient_idpatient_2` (`patient_idpatient`),
  KEY `patient_idpatient` (`patient_idpatient`),
  KEY `unite_idunite` (`unite_idunite`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=25 ;

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `idusers` int(11) NOT NULL AUTO_INCREMENT COMMENT 'auto incrementing user_id of each user, unique index',
  `login` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT 'user''s password in salted and hashed format',
  `etat` tinyint(1) NOT NULL DEFAULT '0',
  `date_save` date NOT NULL,
  `lisible` tinyint(1) NOT NULL DEFAULT '1',
  `personne_idpersonne` int(11) NOT NULL,
  `role` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `code` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`idusers`),
  UNIQUE KEY `code` (`code`),
  KEY `personne_idpersonne` (`personne_idpersonne`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='user data' AUTO_INCREMENT=64 ;

--
-- Contenu de la table `users`
--

INSERT INTO `users` (`idusers`, `login`, `password`, `etat`, `date_save`, `lisible`, `personne_idpersonne`, `role`, `code`) VALUES
(1, 'mba@gmail.com', '$2y$10$MPVHzZ2ZPOWmtUUGCq3RXu31OTB.jo7M9LZ7PmPQYmgETSNn19ejO', 1, '2016-12-19', 1, 22, 'Administrateur', '');

--
-- Contraintes pour les tables exportées
--

--
-- Contraintes pour la table `journal`
--
ALTER TABLE `journal`
  ADD CONSTRAINT `journal_ibfk_1` FOREIGN KEY (`patient_idpatient`) REFERENCES `patient` (`idpatient`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `medecin`
--
ALTER TABLE `medecin`
  ADD CONSTRAINT `fk_medecin_specialite` FOREIGN KEY (`specialite_idspecialite`) REFERENCES `specialite` (`idspecialite`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `medecin_ibfk_1` FOREIGN KEY (`personne_idpersonne`) REFERENCES `personne` (`idpersonne`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `message`
--
ALTER TABLE `message`
  ADD CONSTRAINT `fk_message_medecin1` FOREIGN KEY (`medecin_idmedecin`) REFERENCES `medecin` (`idmedecin`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_message_patient1` FOREIGN KEY (`patient_idpatient`) REFERENCES `patient` (`idpatient`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Contraintes pour la table `mesure_patient`
--
ALTER TABLE `mesure_patient`
  ADD CONSTRAINT `mesure_patient_ibfk_1` FOREIGN KEY (`patient_idpatient`) REFERENCES `patient` (`idpatient`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `mesure_patient_ibfk_2` FOREIGN KEY (`mesure_idmesure`) REFERENCES `mesure` (`idmesure`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `patient`
--
ALTER TABLE `patient`
  ADD CONSTRAINT `fk_patient_diabete1` FOREIGN KEY (`diabete_iddiabete`) REFERENCES `diabete` (`iddiabete`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `patient_ibfk_1` FOREIGN KEY (`personne_idpersonne`) REFERENCES `personne` (`idpersonne`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `patient_has_medecin`
--
ALTER TABLE `patient_has_medecin`
  ADD CONSTRAINT `patient_has_medecin_ibfk_1` FOREIGN KEY (`patient_idpatient`) REFERENCES `patient` (`idpatient`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `patient_has_medecin_ibfk_2` FOREIGN KEY (`medecin_idmedecin`) REFERENCES `medecin` (`idmedecin`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `unite_patient`
--
ALTER TABLE `unite_patient`
  ADD CONSTRAINT `unite_patient_ibfk_1` FOREIGN KEY (`patient_idpatient`) REFERENCES `patient` (`idpatient`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `unite_patient_ibfk_2` FOREIGN KEY (`unite_idunite`) REFERENCES `unite` (`idunite`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`personne_idpersonne`) REFERENCES `personne` (`idpersonne`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
