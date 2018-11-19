SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

use homisep;
--
-- Base de données :  `Homisep`
--
Create table `TypeAdministrateur`
(
	`idTypeAdministrateur` int(11) not null primary key auto_increment,
	`nom` varchar(255) not null
)ENGINE=InnoDB DEFAULT CHARSET=utf8;
    
CREATE TABLE `Administrateur`
(
	`idAdministrateur` int(11) NOT NULL primary key auto_increment,
	`nom` varchar(255) NOT NULL,
	`prenom` varchar(255) NOT NULL,
	`mail` varchar(255) NOT NULL,
	`passe` varchar(255) NOT NULL,
	`idTypeAdministrateur` int(11)
)ENGINE=InnoDB DEFAULT CHARSET=utf8;

Alter table `Administrateur`
	add constraint `Fk_Administrateur_Type`  foreign key (`idTypeAdministrateur`) references `TypeAdministrateur`(`idTypeAdministrateur`) on delete cascade;

CREATE TABLE `Client` 
(
	`idClient` int(11) NOT NULL primary key auto_increment,
	`nom` varchar(255) NOT NULL,
	`prenom` varchar(255) NOT NULL,
	`adresse` varchar(255),
	`ville` varchar(255) NOT NULL,
	`codePostal` int(5) DEFAULT NULL,
	`mail` varchar(255) NOT NULL,
	`passe` varchar(255) NOT NULL,
	`dateNaissance` Date not null,
	`dateCreation` Date not null
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
	
Create table `TypeSujet`
(
	`idTypeSujet` int(11) not null primary key auto_increment,
	`nom` varchar(255) not null
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `Message`
(
	`idMessage` int (11) NOT NULL primary key auto_increment,
	`sujet` varchar(255) NOT NULL,
	`objet` varchar(255) not null,
	`texte` varchar(1000) not null,
	`idClient` int (11) not null,
	`idAdministrateur` int(11),
	`idTypeSujet` int(11) not null
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

alter table `Message`
	add constraint `Fk_Message_Client` foreign key (`idClient`) references `Client`(`idClient`) on delete cascade,
	add constraint `Fk_Message_Administrateur` foreign key (`idAdministrateur`) references `Administrateur`(`idAdministrateur`) on delete cascade,
	add constraint `Fk_Message_Sujet` foreign key (`idTypeSujet`) references `TypeSujet`(`idTypeSujet`) on delete cascade;
	
Create table `Reponse`
(
	`idReponse` int (11) not null primary key auto_increment,
	`texte` varchar(1000) not null,
	`dateReponse` date not null,
	`idMessage` int(11) not null
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

alter table `Reponse`
	add constraint `Fk_Reponse_Message` foreign key (`idMessage`) references `Message`(`idMessage`) on delete cascade;

CREATE TABLE `Maison`
(
	`idMaison` int(11) not null primary key auto_increment,
	`adresse` varchar(255) not null,
	`ville` varchar(255) not null,
	`codePostale` int(5) not null,
	`idClient` int(11) not null
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

alter table `Maison`
	add constraint `Fk_Maison_Client` foreign key (`idClient`) references `Client`(`idClient`) on delete cascade;

Create table `TypePiece`
(
	`idTypePiece` int(11) not null primary key auto_increment,
	`nom` varchar(255) not null
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `Piece`
(
	`idPiece` int(11) not null primary key auto_increment,
	`nom` varchar(255) not null,
	`idMaison` int(11) not null,
	`idTypePiece` int(11)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

alter table `Piece`
	add constraint `Fk_Piece_Maison` foreign key (`idMaison`) references `Maison`(`idMaison`) on delete cascade,
	add constraint `Fk_Piece_TypePiece` foreign key  (`idTypePiece`) references `TypePiece`(`idTypePiece`) on delete cascade;

-- STATUT = EFFECTEUR / CAPTEUR
-- TYPE = CAPTEUR de température / EFFECTEUR Volet

Create table `TypeCapteur`
(
	`idTypeCapteur` int(11) not null primary key auto_increment,
	`nom` varchar(255) not null
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

Create table `GrandeurPhysique`
(
	`idGrandeurPhysique` int(11) not null primary key auto_increment,
	`nom` Varchar(255),
	`symbole` varchar(5)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `Cemac`
(
	`idCemac` int(11) not null primary key auto_increment,
	`nom` varchar(255) not null,
	`statut` varchar(255) not null,
	`idTypeCapteur` int(11) not null,
	`idGrandeurPhysique` int(11) not null
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

alter table `Cemac`
	add constraint `Fk_Cemac_TypeCapteur` foreign key (`idTypeCapteur`) references `TypeCapteur`(`idTypeCapteur`) on delete cascade,
	add constraint `Fk_Cemac_GrandeurPhysique` foreign key (`idGrandeurPhysique`) references `GrandeurPhysique`(`idGrandeurPhysique`) on delete cascade;
	
CREATE TABLE `Historique`
(
	`idHistorique` int(11) not null primary key auto_increment,
	`dateReleve` Date not null,
	`valeurReleve` float(11) not null,
	`idCemac` int(11) not null
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

Alter table `Historique`
	add constraint `Fk_Historique_Cemac` foreign key (`idCemac`) references `Cemac`(`idCemac`) on delete cascade;

CREATE TABLE `Programme`
(
	`idProgramme` int(11) not null primary key auto_increment,
	`dateDebut` Datetime not null,
	`dateFin` Datetime not null,
	`valeur` float(11) not null
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
	
Create table `ProgrammeCemac`
(
	`idCemac` int(11) not null,
	`idProgramme` int(11) not null
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

alter table `ProgrammeCemac`
	add primary key(`idCemac`,`idProgramme`),
	add constraint `Fk_ProgrammeCemac_Cemac` foreign key (`idCemac`) references `Cemac`(`idCemac`) on delete cascade,
	add constraint `Fk_ProgrammeCemac_Programme` foreign key (`idProgramme`) references `Programme`(`idProgramme`) on delete cascade;