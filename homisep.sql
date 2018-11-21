-- phpMyAdmin SQL Dump
-- version 4.5.4.1
-- http://www.phpmyadmin.net
--
-- Client :  localhost
-- Généré le :  Mer 21 Novembre 2018 à 19:54
-- Version du serveur :  5.7.11
-- Version de PHP :  5.6.18

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

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
  `statut` varchar(255) NOT NULL,
  `idTypeCapteur` int(11) NOT NULL,
  `idGrandeurPhysique` int(11) NOT NULL,
  `idPiece` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

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
(5, NULL, NULL, NULL, NULL, NULL, 'laurent@isep.fr', '$2y$10$I8tQPOD3Mjs4Bz4.1yAz8e/puk/ZoQRI9tH9Ianrv3pkGqa1oRLQy', NULL, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `grandeurphysique`
--

CREATE TABLE `grandeurphysique` (
  `idGrandeurPhysique` int(11) NOT NULL,
  `nom` varchar(255) DEFAULT NULL,
  `symbole` varchar(5) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

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
  `codePostale` int(5) NOT NULL,
  `idClient` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `message`
--

CREATE TABLE `message` (
  `idMessage` int(11) NOT NULL,
  `sujet` varchar(255) NOT NULL,
  `objet` varchar(255) NOT NULL,
  `texte` varchar(1000) NOT NULL,
  `idClient` int(11) NOT NULL,
  `idAdministrateur` int(11) DEFAULT NULL,
  `idTypeSujet` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

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

-- --------------------------------------------------------

--
-- Structure de la table `programme`
--

CREATE TABLE `programme` (
  `idProgramme` int(11) NOT NULL,
  `dateDebut` datetime NOT NULL,
  `dateFin` datetime NOT NULL,
  `valeur` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `programmecemac`
--

CREATE TABLE `programmecemac` (
  `idCemac` int(11) NOT NULL,
  `idProgramme` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

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
  `nom` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

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
  ADD KEY `Fk_Cemac_GrandeurPhysique` (`idGrandeurPhysique`),
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
  ADD PRIMARY KEY (`idProgramme`);

--
-- Index pour la table `programmecemac`
--
ALTER TABLE `programmecemac`
  ADD PRIMARY KEY (`idCemac`,`idProgramme`),
  ADD KEY `Fk_ProgrammeCemac_Programme` (`idProgramme`);

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
  ADD PRIMARY KEY (`idTypeCapteur`);

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
  MODIFY `idCemac` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `client`
--
ALTER TABLE `client`
  MODIFY `idClient` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT pour la table `grandeurphysique`
--
ALTER TABLE `grandeurphysique`
  MODIFY `idGrandeurPhysique` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `historique`
--
ALTER TABLE `historique`
  MODIFY `idHistorique` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `maison`
--
ALTER TABLE `maison`
  MODIFY `idMaison` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `message`
--
ALTER TABLE `message`
  MODIFY `idMessage` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `piece`
--
ALTER TABLE `piece`
  MODIFY `idPiece` int(11) NOT NULL AUTO_INCREMENT;
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
  MODIFY `idTypeCapteur` int(11) NOT NULL AUTO_INCREMENT;
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
  ADD CONSTRAINT `Fk_Cemac_GrandeurPhysique` FOREIGN KEY (`idGrandeurPhysique`) REFERENCES `grandeurphysique` (`idGrandeurPhysique`) ON DELETE CASCADE,
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
ALTER TABLE `programmecemac`
  ADD CONSTRAINT `Fk_ProgrammeCemac_Cemac` FOREIGN KEY (`idCemac`) REFERENCES `cemac` (`idCemac`) ON DELETE CASCADE,
  ADD CONSTRAINT `Fk_ProgrammeCemac_Programme` FOREIGN KEY (`idProgramme`) REFERENCES `programme` (`idProgramme`) ON DELETE CASCADE;

--
-- Contraintes pour la table `reponse`
--
ALTER TABLE `reponse`
  ADD CONSTRAINT `Fk_Reponse_Message` FOREIGN KEY (`idMessage`) REFERENCES `message` (`idMessage`) ON DELETE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
