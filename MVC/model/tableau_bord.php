<?php

/**
 * fonction permettant de récupérer la liste des maisons
 * @return retourne la liste des maisons
 */
function getMaisons(){
    require('./model/config.php');
    require('./model/classes/maison.php');
    $query = $database -> prepare('select * from maison where idClient=? order by maisonPrincipale DESC');
    $query -> bindParam(1, $_SESSION["id"]);
    $query -> execute();

    $res = $query->fetchAll(PDO::FETCH_CLASS, 'Maison');
    return $res;
}

/**
 * fonction permettant de récupérer la liste des pièces
 * @param $idMaison l'identifiant de la maison
 * @return retourne la liste des pièces présentes dans la maison
 */
function getPieces($idMaison){
    require('./model/config.php');
    require('./model/classes/piece.php');
    $query = $database -> prepare('select p.* from piece p, maison m where p.idMaison=m.idMaison and m.idClient=? and p.idMaison=? order by p.nom');
    $query -> bindParam(1, $_SESSION["id"]);
    $query -> bindParam(2, $idMaison);
    $query -> execute();

    $res = $query->fetchAll(PDO::FETCH_ASSOC);

    foreach ($res as $key => $value) {
        $p = new Piece();
        $p -> fill($value);
        $res[$key] = $p->toArray();
    }
    return $res;
}

/**
 * fonction permettant de récupérer la liste des CeMacs présents dans la maison
 * @param $idMaison l'identifiant de la maison
 * @return retourne la liste des CeMacs
 */
function getCemacs($idMaison){
    require('./model/config.php');
    require('./model/classes/cemac.php');

    $query = $database -> prepare("select c.idCemac, c.numeroSerie, c.statut, c.idPiece, tc.categorie, tc.type, tc.exterieur, tc.libelleGroupBy, gp.*, pr.valeur AS valA, hr.valeur AS valC " .
        "from cemac c LEFT OUTER JOIN programme pr on ( pr.idCemac = c.idCemac and pr.dateDebut = (SELECT MAX(dateDebut) from programme pr2 where pr2.idCemac = c.idCemac )) ".
        "LEFT OUTER JOIN historique hr on ( hr.idCemac = c.idCemac and hr.date = (SELECT MAX(h2.date) FROM historique h2 WHERE h2.idCemac = c.idCemac )), typecapteur tc, grandeurphysique gp, piece p, maison m " .
        "where c.idTypeCapteur = tc.idTypeCapteur and tc.idGrandeurPhysique = gp.idGrandeurPhysique and c.idPiece = p.idPiece and p.idMaison = m.idMaison and m.idClient = ? and m.idMaison = ? order by c.idPiece, c.idCemac");
    $query -> bindParam(1, $_SESSION["id"]);
    $query -> bindParam(2, $idMaison);
    $query -> execute();

    $res = $query->fetchAll(PDO::FETCH_ASSOC);

    foreach ($res as $key => $value) {
        $p = new Cemac();
        $p -> fill($value);
        $res[$key] = $p->toArray();
    }
    return $res;
}

/**
 * fonction permettant de créer le contexte CeMac en récupérant toutes les informations pour l'affichage du tableau de bord
 * @param $pieces la liste des pièces
 * @param $cemacs la liste des CeMacs
 * @return retourne les données condensées pour le tableau de bord de l'utilisateur
 */
function buildCemacsContext($pieces, $cemacs){
    $context = array();
    foreach ($pieces as $piece) {
        $context[$piece['id']] = array(
            'lum' => array(
                'int' => null,
                'ext' => null
            ),
            'temp' => array(
                'int' => null,
                'ext' => null
            ),
            'shut' => array(
                'int' => null
            )
        );
    }
    foreach ($cemacs as $cemac) {
        $id = $cemac['id'];
        $piece = $cemac['idPiece'];
        $categ = $cemac['typeCapteur']['categorie'];
        $ext = $cemac['typeCapteur']['exterieur'];
        $capt = $cemac['typeCapteur']['type'];
        $statut = (boolean) $cemac['statut'];
        $libelle = $cemac['typeCapteur']['libelleGroupBy'];
        $valeur = isset($cemac['typeCapteur']['valeur'])?(float)$cemac['typeCapteur']['valeur']:null;
        $grandeur = $cemac['typeCapteur']['grandeur'];

        if(!isset($context[$piece][$categ][$ext])){
            $context[$piece][$categ][$ext] = array(
                'actionneur' => array(),
                'capteur' => array(),
                'cemacs' => array(),
                'statut' => true,
                'moyActionneur' => null,
                'libelleGroupBy' => $libelle,
                'typeCapteur' => "" . $categ . $ext,
                'grandeur' => $grandeur
            );
        }
        array_push($context[$piece][$categ][$ext][$capt], $id);
        array_push($context[$piece][$categ][$ext]['cemacs'], $id);
        $context[$piece][$categ][$ext]['statut'] = $context[$piece][$categ][$ext]['statut'] && $statut;
        if(isset($valeur)){
            if($context[$piece][$categ][$ext]['moyActionneur'] == null){
                $context[$piece][$categ][$ext]['moyActionneur'] = $valeur;
            }else{
                $context[$piece][$categ][$ext]['moyActionneur'] += $valeur;
            }
        }
    }
    foreach($pieces as $piece){
        foreach($context[$piece['id']] as $categ){
            if(isset($categ['int'])){
                if(count($categ['int']['actionneur']) > 0){
                    $categ['int']['moyActionneur'] = $categ['int']['moyActionneur']/count($categ['int']['actionneur']);
                }else{
                    $categ['int']['moyActionneur'] = null;
                }
            }
            if(isset($categ['ext'])){
                if(count($categ['ext']['actionneur']) > 0){
                    $categ['ext']['moyActionneur'] = $categ['ext']['moyActionneur']/count($categ['ext']['actionneur']);
                }else{
                    $categ['ext']['moyActionneur'] = null;
                }
            }
        }
    }
    return $context;
}

/**
 * fonction permettant de récupérer les CeMacs présents dans une pièce
 * @param $idPiece l'identifiant de la pièce
 * @return retourne la liste des CeMacs de la pièce
 */
function getCemacsInPiece($idPiece){
    require('./model/config.php');
    require('./model/classes/cemac.php');

    $query = $database -> prepare('select c.idCemac, c.numeroSerie, c.statut, c.idPiece, tc.categorie, tc.type, tc.exterieur, tc.libelleGroupBy, gp.nom, gp.symbole, gp.pas, gp.borneInf, gp.borneSup, pr.valeur from cemac c LEFT OUTER JOIN programme pr on ( pr.idCemac = c.idCemac and pr.dateDebut = (SELECT MAX(dateDebut) from programme where idCemac = c.idCemac )), typecapteur tc, grandeurphysique gp, piece p where c.idTypeCapteur = tc.idTypeCapteur and tc.idGrandeurPhysique = gp.idGrandeurPhysique and c.idPiece = p.idPiece and p.idPiece = ? order by c.idCemac');
    $query -> bindParam(1, $idPiece);
    $query -> execute();

    $res = $query->fetchAll(PDO::FETCH_ASSOC);

    foreach ($res as $key => $value) {
        $p = new Cemac();
        $p -> fill($value);
        $res[$key] = $p->toArray();
    }
    return $res;
}

/**
 * fonction permettant de récupérer les informations de la maison
 * @param $idMaison l'identifiant de la maison
 * @return retourne les informations de la maison
 */
function getInfoMaisonBD($idMaison){
    require('./model/config.php');
    require('./model/classes/maison.php');
    $query = $database -> prepare('select * from maison where idMaison= ?');
    $query -> bindParam(1, $idMaison);
    $query -> execute();

    $res = $query->fetchAll(PDO::FETCH_ASSOC);
    return $res;
}

/**
 * fonction permettant de récupérer les informations de la pièce
 * @param $idPiece l'identifiant de la pièce
 * @return retourne les informations de la pièce
 */
function getInfoPieceBD($idPiece){
    require('./model/config.php');
    require('./model/classes/maison.php');
    $query = $database -> prepare('select * from piece, maison where piece.idPiece= ? and piece.idMaison = maison.idMaison');
    $query -> bindParam(1, $idPiece);
    $query -> execute();

    $res = $query->fetchAll(PDO::FETCH_ASSOC);
    return $res;
}

/**
 * fonction permettant de récupérer les informations du CeMac
 * @param $idCapteur l'identifiant du CeMac
 * @return retourne les informations du CeMac
 */
function getInfoCapteurBD($idCapteur){
    require('./model/config.php');
    require_once('./model/classes/cemac.php');
    $query = $database -> prepare('select c.idCemac, c.numeroSerie, c.statut, c.idPiece, tc.idTypeCapteur, tc.categorie, tc.type, tc.exterieur, tc.libelleGroupBy, gp.nom, gp.symbole, p.nom from piece p, cemac c, typecapteur tc, grandeurphysique gp where c.idTypeCapteur = tc.idTypeCapteur and tc.idGrandeurPhysique = gp.idGrandeurPhysique and c.idCemac = ? and c.idPiece = p.idPiece');
    $query -> bindParam(1, $idCapteur);
    $query -> execute();
    $res = $query->fetchAll(PDO::FETCH_ASSOC);
    return $res;
}

/**
 * fonction permettant de récupérer la liste des maisons du client connecté
 * @return retourne la liste des maisons
 */
function getMaisonsAssoc(){
    require('./model/config.php');
    $query = $database -> prepare('select * from maison where idClient=? order by maisonPrincipale DESC');
    $query -> bindParam(1, $_SESSION["id"]);
    $query -> execute();
    $res = $query->fetchAll(PDO::FETCH_ASSOC);
    return $res;
}

/**
 * fonction permettant de récupérer la liste des pièces de la maison
 * @param $idMaison l'identifiant de la maison
 * @return retourne la liste des pièces
 */
function getPiecesAssoc($idMaison){
    require('./model/config.php');
    $query = $database -> prepare('select * from piece where idMaison=?');
    $query -> bindParam(1, $idMaison);
    $query -> execute();
    $res = $query->fetchAll(PDO::FETCH_ASSOC);
    return $res;
}

/**
 * fonction permettant de récupérer la liste des CeMacs de la pièce
 * @param $idPiece l'identifiant de la pièce
 * @return retourne la liste des CeMacs
 */
function getCemacsAssoc($idPiece){
    require('./model/config.php');
    $query = $database -> prepare('select c.idCemac, c.numeroSerie, c.statut, tc.idTypeCapteur, tc.categorie, tc.type, tc.exterieur, tc.libelleGroupBy, gp.nom, gp.symbole from cemac c, typecapteur tc, grandeurphysique gp where c.idTypeCapteur = tc.idTypeCapteur and tc.idGrandeurPhysique = gp.idGrandeurPhysique and c.idPiece = ?');
    $query -> bindParam(1, $idPiece);
    $query -> execute();
    $res = $query->fetchAll(PDO::FETCH_ASSOC);
    return $res;
}

/**
 * fonction permettant de mettre à jour les valeurs des Actionneurs
 * @param $valeurs la valeur souhaitée
 * @return retourne vrai si la mise à jour a été faite
 */
function updateProgrammes($valeurs){
    if(count($valeurs) == 0) return false;
    require('/model/config.php');
    $date = date('Y-m-d H:i:s');
    $sql = "INSERT INTO `programme` (`idCemac`, `dateDebut`, `valeur`) VALUES (?,?,?)";
    $query = $database->prepare($sql);
    foreach($valeurs as $valeur){
        $query->execute(array($valeur['idCemac'], $date, $valeur['valeur']));
    }
    return true;
}

function prepareTrameActionneur($valeurs)
{
    if(count($valeurs) != 0)
    {
        foreach($valeurs as $valeur)
        {
            require_once("./model/util.php");
            $idTypeCapteur = getInfoCapteurBD($valeur['idCemac'])[0]['idTypeCapteur'];
            $idTypeCapteur = translateServerToCeMac($idTypeCapteur);
            if($idTypeCapteur != 0)
            {
                $valeurCapteur = str_pad(dechex($valeur['valeur']), 4, "0", STR_PAD_LEFT);
                $trame = "1G02A2a01" . $valeurCapteur;
                $trame = $trame . createCRC($trame);
                sendTrameActionneur($trame);
            }
        }
    }
}

function createCRC($trame)
{
    $tableau = unpack("C*",$trame);
    $valeur = array_reduce($tableau, "sum");
    $valeur = $valeur % 256;
    return dechex($valeur);
}

function sum($carry, $item)
{
    $carry += $item;
    return $carry;
}

function sendTrameActionneur($trame)
{
    $ch = curl_init();
    $address = "http://projets-tomcat.isep.fr:8080/appService/?ACTION=COMMAND&TEAM=G02A&TRAME=".$trame;
    curl_setopt($ch, CURLOPT_URL, $address);
    curl_setopt($ch, CURLOPT_HEADER, FALSE);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
    $data = curl_exec($ch);
    curl_close($ch);
    if(strpos($data, 'ERREUR') == false )
    {
        return true;
    }
    else
    {
        return false;
    }

}

/**
 * fonction permettant la création d'une maison
 * @param $idClient l'identifiant du client
 * @param $adresse l'adresse de la maison
 * @param $ville la ville de la maison
 * @param $codePostal le code postal de la maison
 * @param $maisonPrincipale booléen disant s'il s'agit de la maison principale ou non
 * @return renvoie vrai si la création est ok faux sinon
 */
function creerNouvelleMaisonBD($idClient,$adresse,$ville,$codePostal,$maisonPrincipale){
    require("./model/util.php");
    require("./model/config.php");
    $adresse = traitementCaractereSpeciaux($adresse);
    $ville = traitementCaractereSpeciaux($ville);
    $codePostal = traitementCaractereSpeciaux($codePostal);
    $query = $database -> prepare('insert into maison(adresse,ville,codePostal,idClient,maisonPrincipale) values(?,?,?,?,?)');
    $query -> bindParam(1,$adresse);
    $query -> bindParam(2,$ville);
    $query -> bindParam(3,$codePostal);
    $query -> bindParam(4,$idClient);
    $query -> bindParam(5,$maisonPrincipale);
    if($maisonPrincipale){
        deleteTrueMaisonPrincipale();
    }
    try{
        $query -> execute();
        return true;
    }
    catch(PDOException $exception){
        return false;
    }
}

/**
 * fonction permettant la modification des informations d'une maison
 * @param $idMaison l'identifiant de la maison
 * @param $adresse l'adresse de la maison
 * @param $ville la ville de la maison
 * @param $codePostal le code postal de la maison
 * @param $maisonPrincipale booléen disant s'il s'agit de la maison principale ou non
 * @return renvoie vrai si la création est ok faux sinon
 */
function modifierMaisonBD($idMaison,$adresse,$ville,$codePostal,$maisonPrincipale){
    require("./model/util.php");
    require("./model/config.php");
    $idMaison = traitementCaractereSpeciaux($idMaison);
    $adresse = traitementCaractereSpeciaux($adresse);
    $ville = traitementCaractereSpeciaux($ville);
    $codePostal = traitementCaractereSpeciaux($codePostal);
    $query = $database -> prepare('update maison set adresse = ?, ville = ?, codePostal = ?, maisonPrincipale = ? where idMaison = ?');
    $query -> bindParam(1,$adresse);
    $query -> bindParam(2,$ville);
    $query -> bindParam(3,$codePostal);
    $query -> bindParam(4,$maisonPrincipale);
    $query -> bindParam(5,$idMaison);
    if($maisonPrincipale){
        deleteTrueMaisonPrincipale();
    }
    try{
        $query -> execute();
        return true;
    }
    catch(PDOException $exception){
        echo($exception);
        return false;
    }
}

/**
 * fonction permettant la suppression d'une maison
 * @param $idMaison l'identifiant de la maison
 * @return renvoie vrai si la création est ok faux sinon
 */
function supprimerMaisonBD($idMaison){
    require('./model/config.php');
    $query = $database -> prepare('delete from maison where idMaison = ?');
    $query -> bindParam(1, $idMaison);
    try{
        $query -> execute();
        return true;
    }
    catch(PDOException $exception){
        return false;
    }
}

/**
 * fonction permettant la création d'une nouvelle pièce dans la maison
 * @param $idMaison l'identifiant de la maison
 * @param $nom le nom de la pièce
 * @return renvoie vrai si le traitement a été réalisé faux sinon
 */
function creerNouvellePieceBD($idMaison,$nom){
    require("./model/util.php");
    require("./model/config.php");
    $idMaison = traitementCaractereSpeciaux($idMaison);
    $nom = traitementCaractereSpeciaux($nom);
    $query = $database -> prepare('insert into piece(nom,idMaison) values(?,?)');
    $query -> bindParam(1,$nom);
    $query -> bindParam(2,$idMaison);
    try{
        $query -> execute();
        return true;
    }
    catch(PDOException $exception){
        echo($exception);
        return false;
    }
}

/**
 * fonction permettant la modification d'une pièce dans la maison
 * @param $idMaison l'identifiant de la nouvelle maison
 * @param $idPiece l'identifiant de la pièce
 * @param $nom le nom de la pièce
 * @return renvoie vrai si le traitement a été réalisé faux sinon
 */
function modifierPieceBD($idPiece,$nom,$idMaison){
    require("./model/util.php");
    require("./model/config.php");
    $idPiece = traitementCaractereSpeciaux($idPiece);
    $nom = traitementCaractereSpeciaux($nom);
    $query = $database -> prepare('update piece set nom = ?, idMaison = ? where idPiece = ?');
    $query -> bindParam(1,$nom);
    $query -> bindParam(2,$idMaison);
    $query -> bindParam(3,$idPiece);
    try{
        $query -> execute();
        return true;
    }
    catch(PDOException $exception){
        return false;
    }
}

/**
 * fonction permettant de supprimer une pièce
 * @param $idPiece l'identifiant de la pièce
 * @return renvoie vrai si le traitement a été réalisé faux sinon
 */
function supprimerPieceBD($idPiece){
    require('./model/config.php');
    $query = $database -> prepare('delete from piece where idPiece = ?');
    $query -> bindParam(1, $idPiece);
    try{
        $query -> execute();
        return true;
    }
    catch(PDOException $exception){
        return false;
    }
}

/**
 * fonction permettant de créer un CeMac
 * @param $numSerieCemac le numéro de série du CeMac
 * @param $idTypeCapteur l'identifiant du type de capteur
 * @param $idPiece l'identifiant de la pièce où est placé le CeMac
 * @return renvoie vrai si le traitement a été réalisé faux sinon
 */
function creerNouveauCemacBD($numSerieCemac,$idTypeCapteur,$idPiece){
    require("./model/util.php");
    require("./model/config.php");
    $numSerieCemac = traitementCaractereSpeciaux($numSerieCemac);
    $idTypeCapteur = traitementCaractereSpeciaux($idTypeCapteur);
    $idPiece = traitementCaractereSpeciaux($idPiece);
    $query = $database -> prepare('insert into cemac(numeroSerie,statut,idTypeCapteur,idPiece) values(?,1,?,?)');
    $query -> bindParam(1,$numSerieCemac);
    $query -> bindParam(2,$idTypeCapteur);
    $query -> bindParam(3,$idPiece);
    try{
        $query -> execute();
        return true;
    }
    catch(PDOException $exception){
        return false;
    }
}

/**
 * fonction permettant de modifier un CeMac
 * @param $num le numéro de série du CeMac
 * @param $type l'identifiant du type de capteur
 * @param $idPiece l'identifiant de la pièce où est placé le CeMac
 * @return renvoie vrai si le traitement a été réalisé faux sinon
 */
function modifierCemacBD($id,$num,$type,$idPiece){
    require("./model/util.php");
    require("./model/config.php");
    $id = traitementCaractereSpeciaux($id);
    $num = traitementCaractereSpeciaux($num);
    $type = traitementCaractereSpeciaux($type);
    $query = $database -> prepare('update cemac set numeroSerie = ?, idTypeCapteur = ?, idPiece = ? where idCemac = ?');
    $query -> bindParam(1,$num);
    $query -> bindParam(2,$type);
    $query -> bindParam(3,$idPiece);
    $query -> bindParam(4,$id);
    try{
        $query -> execute();
        return true;
    }
    catch(PDOException $exception){
        return false;
    }
}

/**
 * fonction permettant de supprimer un CeMac
 * @param $idCemac l'identifiant du CeMac
 * @return renvoie vrai si le traitement a été réalisé faux sinon
 */
function supprimerCemacBD($idCemac){
    require('./model/config.php');
    $query = $database -> prepare('delete from cemac where idCemac = ?');
    $query -> bindParam(1, $idCemac);
    try{
        $query -> execute();
        return true;
    }
    catch(PDOException $exception){
        return false;
    }
}

/**
 * fonction permettant de récupérer les types de capteurs
 * @param $idTypeCapteur l'identifiant du type de capteur dont nous ne souhaitons pas avoir
 * @return renvoie la liste des types de capteurs
 */
function getTypeCapteur($idTypeCapteur){
    require('./model/config.php');
    $query = $database -> prepare('select * from typecapteur where idTypeCapteur <> ?');
    $query -> bindParam(1, $idTypeCapteur);
    $query -> execute();
    $res = $query->fetchAll(PDO::FETCH_ASSOC);
    return $res;
}

/**
 * fonction permettant de récupérer les pièces
 * @param $idPiece l'identifiant de la pièce dont nous ne souhaitons pas avoir
 * @param $idMaison l'identifiant de la maison
 * @return renvoie la liste des pièces de la maison
 */
function getOptionsPieces($idMaison, $idPiece){
    require('./model/config.php');
    $query = $database -> prepare('select * from piece where idPiece <> ? and idMaison = ?');
    $query -> bindParam(1, $idPiece);
    $query -> bindParam(2, $idMaison);
    $query -> execute();
    $res = $query-> fetchAll(PDO::FETCH_ASSOC);
    return $res;
}

/**
 * fonction permettant de récupérer la liste des maisons d'un client
 * @param $idMaison l'identifiant de la maison dont nous ne souhaitons pas avoir
 * @param $idClient l'identifiant du client
 * @return renvoie la liste des maison
 */
function getOptionsMaisons($idClient, $idMaison){
    require('./model/config.php');
    $query = $database -> prepare('select * from maison where idMaison <> ? and idClient = ?');
    $query -> bindParam(1, $idMaison);
    $query -> bindParam(2, $idClient);
    $query -> execute();
    $res = $query-> fetchAll(PDO::FETCH_ASSOC);
    return $res;
}

/**
 * fonction permettant de retirer le booléen de l'ancienne maison principale
 * quand une nouvelle maison est mise en tant que maison principale
 */
function deleteTrueMaisonPrincipale(){
    require('./model/config.php');
    $query = $database -> prepare('update maison set maisonPrincipale = 0 where maisonPrincipale = 1');
    $query -> execute();
}
?>
