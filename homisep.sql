-- phpMyAdmin SQL Dump
-- version 4.5.4.1
-- http://www.phpmyadmin.net
--
-- Client :  localhost
-- Généré le :  Mar 27 Novembre 2018 à 14:42
-- Version du serveur :  5.7.11
-- Version de PHP :  5.6.18

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

drop database if exists `homisep`;
create database `homisep` CHARSET=utf8;
use `homisep`;
--
-- Base de données :  `homisep`
--

-- --------------------------------------------------------

--
-- Structure de la table `administrateur`
--

CREATE TABLE `administrateur` (
  `idAdministrateur` int(11) NOT NULL,
  `nom` varchar(255) DEFAULT NULL,
  `prenom` varchar(255) DEFAULT NULL,
  `mail` varchar(255) NOT NULL,
  `passe` varchar(255) NOT NULL,
  `idTypeAdministrateur` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `administrateur`
--

INSERT INTO `administrateur` (`idAdministrateur`, `nom`, `prenom`, `mail`, `passe`, `idTypeAdministrateur`) VALUES
(1, '', '', 'root@root.fr', '$2y$10$KIoLAUEkypidFWfnWmeIQeej.c02ESdlnr2T0dszTd.6xb0WqDanG', NULL);

-- --------------------------------------------------------

--
-- Structure de la table `cemac`
--

CREATE TABLE `cemac` (
  `idCemac` int(11) NOT NULL,
  `numeroSerie` varchar(255) NOT NULL,
  `statut` bit(1) NOT NULL,
  `idTypeCapteur` int(11) NOT NULL,
  `idPiece` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `cemac`
--

INSERT INTO `cemac` (`idCemac`, `numeroSerie`, `statut`, `idTypeCapteur`, `idPiece`) VALUES
(1, 'X474103', b'1', 5, 1),
(2, 'X450017', b'1', 2, 1),
(3, 'X310070', b'0', 1, 2),
(4, 'X123456', b'0', 3, 2),
(5, 'X812288', b'1', 4, 3),
(6, 'X255320', b'1', 7, 3),
(7, 'X402500', b'1', 7, 4),
(8, 'X536111', b'0', 1, 5),
(9, 'X647222', b'0', 3, 5),
(10, 'X758333', b'1', 1, 4),
(11, 'X869444', b'1', 2, 4),
(12, 'X970555', b'1', 3, 4);

-- --------------------------------------------------------

--
-- Structure de la table `client`
--

CREATE TABLE `client` (
  `idClient` int(11) NOT NULL,
  `nom` varchar(255) DEFAULT NULL,
  `prenom` varchar(255) DEFAULT NULL,
  `adresse` varchar(255) DEFAULT NULL,
  `ville` varchar(255) DEFAULT NULL,
  `codePostal` int(5) DEFAULT NULL,
  `mail` varchar(255) NOT NULL,
  `passe` varchar(255) NOT NULL,
  `dateNaissance` date DEFAULT NULL,
  `dateCreation` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `client`
--

INSERT INTO `client` (`idClient`, `nom`, `prenom`, `adresse`, `ville`, `codePostal`, `mail`, `passe`, `dateNaissance`, `dateCreation`) VALUES
(5, "Yu", "Laurent", NULL, NULL, NULL, 'laurent@isep.fr', '$2y$10$I8tQPOD3Mjs4Bz4.1yAz8e/puk/ZoQRI9tH9Ianrv3pkGqa1oRLQy', NULL, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `grandeurphysique`
--

CREATE TABLE `grandeurphysique` (
  `idGrandeurPhysique` int(11) NOT NULL,
  `nom` varchar(255) DEFAULT NULL,
  `symbole` varchar(5) DEFAULT NULL,
  `pas` float DEFAULT 1,
  `borneInf` float DEFAULT 0,
  `borneSup` float DEFAULT 100
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `grandeurphysique`
--

INSERT INTO `grandeurphysique` (`idGrandeurPhysique`, `nom`, `symbole`, `pas`, `borneInf`, `borneSup`) VALUES
(1, 'Celsius', '°C', 0.5, 5, 35),
(2, 'Pourcentage', '%', 5, 0, 100);

-- --------------------------------------------------------

--
-- Structure de la table `historique`
--

CREATE TABLE `historique` (
  `idHistorique` int(11) NOT NULL,
  `dateReleve` date NOT NULL,
  `valeurReleve` float NOT NULL,
  `idCemac` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `maison`
--

CREATE TABLE `maison` (
  `idMaison` int(11) NOT NULL,
  `adresse` varchar(255) NOT NULL,
  `ville` varchar(255) NOT NULL,
  `codePostal` int(5) NOT NULL,
  `idClient` int(11) NOT NULL,
  `maisonPrincipale` bit(1) NOT NULL DEFAULT b'0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `maison`
--

INSERT INTO `maison` (`idMaison`, `adresse`, `ville`, `codePostal`, `idClient`,`maisonPrincipale`) VALUES
(1, '143 avenue de Versailles', 'Paris', 75016, 5, b'1'),
(2, '106 Faubourg Poissonnière', 'Paris', 75010, 5, b'0');

-- --------------------------------------------------------

--
-- Structure de la table `message`
--

CREATE TABLE `message` (
  `idMessage` int(11) NOT NULL,
  `sujet` varchar(255) DEFAULT NULL,
  `objet` varchar(255) NOT NULL,
  `texte` varchar(1000) NOT NULL,
  `idClient` int(11) NOT NULL,
  `idAdministrateur` int(11) DEFAULT NULL,
  `idTypeSujet` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `message`
--

INSERT INTO `message` (`idMessage`, `objet`, `texte`, `idClient`) VALUES
(1, 'Bug', "Aidez moi il n'y a plus rien qui fonctionne !", 5),
(2, 'Recrutement', "J'aimerais travailler avec vous.", 5);

-- --------------------------------------------------------

--
-- Structure de la table `piece`
--

CREATE TABLE `piece` (
  `idPiece` int(11) NOT NULL,
  `nom` varchar(255) NOT NULL,
  `idMaison` int(11) NOT NULL,
  `idTypePiece` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `piece`
--

INSERT INTO `piece` (`idPiece`, `nom`, `idMaison`, `idTypePiece`) VALUES
(1, 'Salon', 1, NULL),
(2, 'Chambre', 1, NULL),
(3, 'Salle de Bain', 1, NULL),
(4, 'Salle de classe', 2, NULL),
(5, 'Amphithéâtre Olympe de Gouges', 2, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `programme`
--

CREATE TABLE `programme` (
  `idProgramme` int(11) NOT NULL,
  `dateDebut` datetime NOT NULL,
  `dateFin` datetime DEFAULT NULL,
  `valeur` float NOT NULL,
  `idCemac` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `piece`
--
INSERT INTO `programme` (`idProgramme`, `dateDebut`, `valeur`, `idCemac`) VALUES
(1, '2019-01-14 10:00:00', 65, 4),
(2, '2019-01-14 10:00:00', 100, 6),
(3, '2019-01-14 10:00:00', 20, 7),
(4, '2019-01-14 10:00:00', 40, 9),
(5, '2019-01-14 10:00:00', 50, 12);

-- --------------------------------------------------------

--
-- Structure de la table `regles`
--

CREATE TABLE `regle` (
  `idRegle` int(11) NOT NULL,
  `nomRegle` varchar(50) NOT NULL,
  `dateMiseJour` datetime,
  `texteRegle` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `regles`
--
INSERT INTO `regle` (`idRegle`, `nomRegle`, `dateMiseJour`, `texteRegle`) VALUES
(1, 'CGU', '2019-01-15 10:00:00', "Condition générale d'utilisation"),
(2, 'Politique', '2019-01-15 10:00:00', 'Politique de confidentialité');

-- --------------------------------------------------------

--
-- Structure de la table `reponse`
--

CREATE TABLE `reponse` (
  `idReponse` int(11) NOT NULL,
  `texte` varchar(1000) NOT NULL,
  `dateReponse` date NOT NULL,
  `idMessage` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `typeadministrateur`
--

CREATE TABLE `typeadministrateur` (
  `idTypeAdministrateur` int(11) NOT NULL,
  `nom` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `typecapteur`
--

CREATE TABLE `typecapteur` (
  `idTypeCapteur` int(11) NOT NULL,
  `categorie` varchar(20) NOT NULL,
  `type` varchar(20) NOT NULL,
  `exterieur` varchar(5) NOT NULL,
  `libelleGroupBy` varchar(25) NOT NULL,
  `idGrandeurPhysique` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `typecapteur`
--

INSERT INTO `typecapteur` (`idTypeCapteur`, `categorie`, `type`, `exterieur`, `libelleGroupBy`, `idGrandeurPhysique`) VALUES
(1, 'lum', 'capteur', 'int', 'Luminosité Int.', 2),
(2, 'lum', 'capteur', 'ext', 'Luminosité Ext.', 2),
(3, 'lum', 'actionneur', 'int', 'Luminosité Int.', 2),
(4, 'temp', 'capteur', 'int', 'Température Int.', 1),
(5, 'temp', 'capteur', 'ext', 'Température Ext.', 1),
(6, 'temp', 'actionneur', 'int', 'Température Int.', 1),
(7, 'shut', 'actionneur', 'int', 'Volets', 2);

-- --------------------------------------------------------

--
-- Structure de la table `typepiece`
--

CREATE TABLE `typepiece` (
  `idTypePiece` int(11) NOT NULL,
  `nom` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `typesujet`
--

CREATE TABLE `typesujet` (
  `idTypeSujet` int(11) NOT NULL,
  `nom` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Index pour les tables exportées
--

--
-- Index pour la table `administrateur`
--
ALTER TABLE `administrateur`
  ADD PRIMARY KEY (`idAdministrateur`),
  ADD KEY `Fk_Administrateur_Type` (`idTypeAdministrateur`);

--
-- Index pour la table `cemac`
--
ALTER TABLE `cemac`
  ADD PRIMARY KEY (`idCemac`),
  ADD KEY `Fk_Cemac_TypeCapteur` (`idTypeCapteur`),
  ADD KEY `Fk_Cemac_Piece` (`idPiece`);

--
-- Index pour la table `client`
--
ALTER TABLE `client`
  ADD PRIMARY KEY (`idClient`),
  ADD UNIQUE KEY `mail` (`mail`);

--
-- Index pour la table `grandeurphysique`
--
ALTER TABLE `grandeurphysique`
  ADD PRIMARY KEY (`idGrandeurPhysique`);

--
-- Index pour la table `historique`
--
ALTER TABLE `historique`
  ADD PRIMARY KEY (`idHistorique`),
  ADD KEY `Fk_Historique_Cemac` (`idCemac`);

--
-- Index pour la table `maison`
--
ALTER TABLE `maison`
  ADD PRIMARY KEY (`idMaison`),
  ADD KEY `Fk_Maison_Client` (`idClient`);

--
-- Index pour la table `message`
--
ALTER TABLE `message`
  ADD PRIMARY KEY (`idMessage`),
  ADD KEY `Fk_Message_Client` (`idClient`),
  ADD KEY `Fk_Message_Administrateur` (`idAdministrateur`),
  ADD KEY `Fk_Message_Sujet` (`idTypeSujet`);

--
-- Index pour la table `piece`
--
ALTER TABLE `piece`
  ADD PRIMARY KEY (`idPiece`),
  ADD KEY `Fk_Piece_Maison` (`idMaison`),
  ADD KEY `Fk_Piece_TypePiece` (`idTypePiece`);

--
-- Index pour la table `programme`
--
ALTER TABLE `programme`
  ADD PRIMARY KEY (`idProgramme`),
  ADD KEY `Fk_Programme_Cemac` (`idCemac`);

--
-- Index pour la table `reponse`
--
ALTER TABLE `reponse`
  ADD PRIMARY KEY (`idReponse`),
  ADD KEY `Fk_Reponse_Message` (`idMessage`);

--
-- Index pour la table `typeadministrateur`
--
ALTER TABLE `typeadministrateur`
  ADD PRIMARY KEY (`idTypeAdministrateur`);

--
-- Index pour la table `typecapteur`
--
ALTER TABLE `typecapteur`
  ADD PRIMARY KEY (`idTypeCapteur`),
  ADD KEY `Fk_Typecapteur_GrandeurPhysique` (`idGrandeurPhysique`);

--
-- Index pour la table `typepiece`
--
ALTER TABLE `typepiece`
  ADD PRIMARY KEY (`idTypePiece`);

--
-- Index pour la table `typesujet`
--
ALTER TABLE `typesujet`
  ADD PRIMARY KEY (`idTypeSujet`);

--
-- AUTO_INCREMENT pour les tables exportées
--

--
-- AUTO_INCREMENT pour la table `administrateur`
--
ALTER TABLE `administrateur`
  MODIFY `idAdministrateur` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT pour la table `cemac`
--
ALTER TABLE `cemac`
  MODIFY `idCemac` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT pour la table `client`
--
ALTER TABLE `client`
  MODIFY `idClient` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT pour la table `grandeurphysique`
--
ALTER TABLE `grandeurphysique`
  MODIFY `idGrandeurPhysique` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT pour la table `historique`
--
ALTER TABLE `historique`
  MODIFY `idHistorique` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `maison`
--
ALTER TABLE `maison`
  MODIFY `idMaison` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT pour la table `message`
--
ALTER TABLE `message`
  MODIFY `idMessage` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `piece`
--
ALTER TABLE `piece`
  MODIFY `idPiece` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT pour la table `programme`
--
ALTER TABLE `programme`
  MODIFY `idProgramme` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `reponse`
--
ALTER TABLE `reponse`
  MODIFY `idReponse` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `typeadministrateur`
--
ALTER TABLE `typeadministrateur`
  MODIFY `idTypeAdministrateur` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `typecapteur`
--
ALTER TABLE `typecapteur`
  MODIFY `idTypeCapteur` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT pour la table `typepiece`
--
ALTER TABLE `typepiece`
  MODIFY `idTypePiece` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `typesujet`
--
ALTER TABLE `typesujet`
  MODIFY `idTypeSujet` int(11) NOT NULL AUTO_INCREMENT;
--
-- Contraintes pour les tables exportées
--

--
-- Contraintes pour la table `administrateur`
--
ALTER TABLE `administrateur`
  ADD CONSTRAINT `Fk_Administrateur_Type` FOREIGN KEY (`idTypeAdministrateur`) REFERENCES `typeadministrateur` (`idTypeAdministrateur`) ON DELETE CASCADE;

--
-- Contraintes pour la table `cemac`
--
ALTER TABLE `cemac`
  ADD CONSTRAINT `Fk_Cemac_Piece` FOREIGN KEY (`idPiece`) REFERENCES `piece` (`idPiece`) ON DELETE CASCADE,
  ADD CONSTRAINT `Fk_Cemac_TypeCapteur` FOREIGN KEY (`idTypeCapteur`) REFERENCES `typecapteur` (`idTypeCapteur`) ON DELETE CASCADE;

--
-- Contraintes pour la table `historique`
--
ALTER TABLE `historique`
  ADD CONSTRAINT `Fk_Historique_Cemac` FOREIGN KEY (`idCemac`) REFERENCES `cemac` (`idCemac`) ON DELETE CASCADE;

--
-- Contraintes pour la table `maison`
--
ALTER TABLE `maison`
  ADD CONSTRAINT `Fk_Maison_Client` FOREIGN KEY (`idClient`) REFERENCES `client` (`idClient`) ON DELETE CASCADE;

--
-- Contraintes pour la table `message`
--
ALTER TABLE `message`
  ADD CONSTRAINT `Fk_Message_Administrateur` FOREIGN KEY (`idAdministrateur`) REFERENCES `administrateur` (`idAdministrateur`) ON DELETE CASCADE,
  ADD CONSTRAINT `Fk_Message_Client` FOREIGN KEY (`idClient`) REFERENCES `client` (`idClient`) ON DELETE CASCADE,
  ADD CONSTRAINT `Fk_Message_Sujet` FOREIGN KEY (`idTypeSujet`) REFERENCES `typesujet` (`idTypeSujet`) ON DELETE CASCADE;

--
-- Contraintes pour la table `piece`
--
ALTER TABLE `piece`
  ADD CONSTRAINT `Fk_Piece_Maison` FOREIGN KEY (`idMaison`) REFERENCES `maison` (`idMaison`) ON DELETE CASCADE,
  ADD CONSTRAINT `Fk_Piece_TypePiece` FOREIGN KEY (`idTypePiece`) REFERENCES `typepiece` (`idTypePiece`) ON DELETE CASCADE;

--
-- Contraintes pour la table `programmecemac`
--
ALTER TABLE `programme`
  ADD CONSTRAINT `Fk_Programme_Cemac` FOREIGN KEY (`idCemac`) REFERENCES `cemac` (`idCemac`) ON DELETE CASCADE;

--
-- Contraintes pour la table `reponse`
--
ALTER TABLE `reponse`
  ADD CONSTRAINT `Fk_Reponse_Message` FOREIGN KEY (`idMessage`) REFERENCES `message` (`idMessage`) ON DELETE CASCADE;

--
-- Contraintes pour la table `typecapteur`
--
ALTER TABLE `typecapteur`
  ADD CONSTRAINT `Fk_Typecapteur_GrandeurPhysique` FOREIGN KEY (`idGrandeurPhysique`) REFERENCES `grandeurphysique` (`idGrandeurPhysique`) ON DELETE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
