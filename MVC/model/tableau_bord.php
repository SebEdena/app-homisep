<?php

function getMaisons()
{
    require('./model/config.php');
    require('./model/classes/maison.php');
    $query = $database -> prepare('select * from maison where idClient=?');
    $query -> bindParam(1, $_SESSION["id"]);
    $query -> execute();

    $res = $query->fetchAll(PDO::FETCH_CLASS, 'Maison');
    return $res;
}

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

function getCemacs($idMaison){
    require('./model/config.php');
    require('./model/classes/cemac.php');

    $query = $database -> prepare('select c.idCemac, c.numeroSerie, c.statut, c.idPiece, tc.categorie, tc.type, tc.exterieur, tc.libelleGroupBy, gp.nom, gp.symbole from cemac c, typecapteur tc, grandeurphysique gp, piece p, maison m where c.idTypeCapteur = tc.idTypeCapteur and tc.idGrandeurPhysique = gp.idGrandeurPhysique and c.idPiece = p.idPiece and p.idMaison = m.idMaison and m.idClient = ? and m.idMaison = ? order by c.idPiece, c.idCemac');
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

        if(!isset($context[$piece][$categ][$ext])){
            $context[$piece][$categ][$ext] = array(
                'actionneur' => array(),
                'capteur' => array(),
                'cemacs' => array(),
                'statut' => true,
                'libelleGroupBy' => $libelle
            );
        }
        array_push($context[$piece][$categ][$ext][$capt], $id);
        array_push($context[$piece][$categ][$ext]['cemacs'], $id);
        $context[$piece][$categ][$ext]['statut'] = $context[$piece][$categ][$ext]['statut'] && $statut;
    }
    return $context;
}


function getCemacsInPiece($idPiece)
{
  require('./model/config.php');
  require('./model/classes/cemac.php');

  $query = $database -> prepare('select c.idCemac, c.numeroSerie, c.statut, c.idPiece, tc.categorie, tc.type, tc.exterieur, tc.libelleGroupBy, gp.nom, gp.symbole from cemac c, typecapteur tc, grandeurphysique gp, piece p where c.idTypeCapteur = tc.idTypeCapteur and tc.idGrandeurPhysique = gp.idGrandeurPhysique and c.idPiece = p.idPiece and p.idPiece = ? order by c.idCemac');
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

function getInfoMaisonBD($idMaison)
{
    require('./model/config.php');
    require('./model/classes/maison.php');
    $query = $database -> prepare('select * from maison where idMaison= ?');
    $query -> bindParam(1, $idMaison);
    $query -> execute();

    $res = $query->fetchAll(PDO::FETCH_ASSOC);
    return $res;
}

function getInfoPieceBD($idPiece)
{
  require('./model/config.php');
  require('./model/classes/maison.php');
  $query = $database -> prepare('select * from piece, maison where piece.idPiece= ? and piece.idMaison = maison.idMaison');
  $query -> bindParam(1, $idPiece);
  $query -> execute();

  $res = $query->fetchAll(PDO::FETCH_ASSOC);
  return $res;
}

function getInfoCapteurBD($idCapteur)
{
  require('./model/config.php');
  require('./model/classes/cemac.php');
  $query = $database -> prepare('select c.idCemac, c.numeroSerie, c.statut, c.idPiece, tc.idTypeCapteur, tc.categorie, tc.type, tc.exterieur, tc.libelleGroupBy, gp.nom, gp.symbole, p.nom from piece p, cemac c, typecapteur tc, grandeurphysique gp where c.idTypeCapteur = tc.idTypeCapteur and tc.idGrandeurPhysique = gp.idGrandeurPhysique and c.idCemac = ? and c.idPiece = p.idPiece');
  $query -> bindParam(1, $idCapteur);
  $query -> execute();
  $res = $query->fetchAll(PDO::FETCH_ASSOC);
  return $res;
}

function getMaisonsAssoc()
{
    require('./model/config.php');
    $query = $database -> prepare('select * from maison where idClient=? order by maisonPrincipale DESC');
    $query -> bindParam(1, $_SESSION["id"]);
    $query -> execute();
    $res = $query->fetchAll(PDO::FETCH_ASSOC);
    return $res;
}
function getPiecesAssoc($idPiece)
{
    require('./model/config.php');
    $query = $database -> prepare('select * from piece where idMaison=?');
    $query -> bindParam(1, $idPiece);
    $query -> execute();
    $res = $query->fetchAll(PDO::FETCH_ASSOC);
    return $res;
}
function getCemacsAssoc($idPiece)
{
    require('./model/config.php');
    $query = $database -> prepare('select c.idCemac, c.numeroSerie, c.statut, tc.idTypeCapteur, tc.categorie, tc.type, tc.exterieur, tc.libelleGroupBy, gp.nom, gp.symbole from cemac c, typecapteur tc, grandeurphysique gp where c.idTypeCapteur = tc.idTypeCapteur and tc.idGrandeurPhysique = gp.idGrandeurPhysique and c.idPiece = ?');
    $query -> bindParam(1, $idPiece);
    $query -> execute();
    $res = $query->fetchAll(PDO::FETCH_ASSOC);
    return $res;
}

function creerNouvelleMaisonBD($idClient,$adresse,$ville,$codePostal)
{
  require("./model/util.php");
  require("./model/config.php");
  $adresse = traitementCaractereSpeciaux($adresse);
  $ville = traitementCaractereSpeciaux($ville);
  $codePostal = traitementCaractereSpeciaux($codePostal);
  $query = $database -> prepare('insert into maison(adresse,ville,codePostal,idClient) values(?,?,?,?)');
  $query -> bindParam(1,$adresse);
  $query -> bindParam(2,$ville);
  $query -> bindParam(3,$codePostal);
  $query -> bindParam(4,$idClient);
  try
  {
    $query -> execute();
    return true;
  }
  catch(PDOException $exception)
  {
    return false;
  }
}
function modifierMaisonBD($idMaison,$adresse,$ville,$codePostal)
{
  require("./model/util.php");
  require("./model/config.php");
  $idMaison = traitementCaractereSpeciaux($idMaison);
  $adresse = traitementCaractereSpeciaux($adresse);
  $ville = traitementCaractereSpeciaux($ville);
  $codePostal = traitementCaractereSpeciaux($codePostal);
  $query = $database -> prepare('update maison set adresse = ?, ville = ?, codePostal = ? where idMaison = ?');
  $query -> bindParam(1,$adresse);
  $query -> bindParam(2,$ville);
  $query -> bindParam(3,$codePostal);
  $query -> bindParam(4,$idMaison);
  try
  {
    $query -> execute();
    return true;
  }
  catch(PDOException $exception)
  {
    return false;
  }
}
function supprimerMaisonBD($idMaison)
{
  require('./model/config.php');
  $query = $database -> prepare('delete from maison where idMaison = ?');
  $query -> bindParam(1, $idMaison);
  try
  {
    $query -> execute();
    return true;
  }
  catch(PDOException $exception)
  {
    return false;
  }
}
function creerNouvellePieceBD($idMaison,$nom)
{
  require("./model/util.php");
  require("./model/config.php");
  $idMaison = traitementCaractereSpeciaux($idMaison);
  $nom = traitementCaractereSpeciaux($nom);
  $query = $database -> prepare('insert into piece(nom,idMaison) values(?,?)');
  $query -> bindParam(1,$nom);
  $query -> bindParam(2,$idMaison);
  try
  {
    $query -> execute();
    return true;
  }
  catch(PDOException $exception)
  {
    echo($exception);
    return false;
  }
}
function modifierPieceBD($idPiece,$nom,$idMaison)
{
  require("./model/util.php");
  require("./model/config.php");
  $idPiece = traitementCaractereSpeciaux($idPiece);
  $nom = traitementCaractereSpeciaux($nom);
  $query = $database -> prepare('update piece set nom = ?, idMaison = ? where idPiece = ?');
  $query -> bindParam(1,$nom);
  $query -> bindParam(2,$idMaison);
  $query -> bindParam(3,$idPiece);
  try
  {
    $query -> execute();
    return true;
  }
  catch(PDOException $exception)
  {
    return false;
  }
}
function supprimerPieceBD($idPiece)
{
  require('./model/config.php');
  $query = $database -> prepare('delete from piece where idPiece = ?');
  $query -> bindParam(1, $idPiece);
  try
  {
    $query -> execute();
    return true;
  }
  catch(PDOException $exception)
  {
    return false;
  }
}
function creerNouveauCemacBD($numSerieCemac,$idTypeCapteur,$idPiece)
{
  require("./model/util.php");
  require("./model/config.php");
  $numSerieCemac = traitementCaractereSpeciaux($numSerieCemac);
  $idTypeCapteur = traitementCaractereSpeciaux($idTypeCapteur);
  $idPiece = traitementCaractereSpeciaux($idPiece);
  $query = $database -> prepare('insert into cemac(numeroSerie,statut,idTypeCapteur,idPiece) values(?,1,?,?)');
  $query -> bindParam(1,$numSerieCemac);
  $query -> bindParam(2,$idTypeCapteur);
  $query -> bindParam(3,$idPiece);
  try
  {
    $query -> execute();
    return true;
  }
  catch(PDOException $exception)
  {
    echo($exception);
    return false;
  }
}
function modifierCemacBD($id,$num,$type,$idPiece)
{
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
  try
  {
    $query -> execute();
    return true;
  }
  catch(PDOException $exception)
  {
    return false;
  }
}
function supprimerCemacBD($idCemac)
{
  require('./model/config.php');
  $query = $database -> prepare('delete from cemac where idCemac = ?');
  $query -> bindParam(1, $idCemac);
  try
  {
    $query -> execute();
    return true;
  }
  catch(PDOException $exception)
  {
    return false;
  }
}

function getTypeCapteur($idTypeCapteur)
{
  require('./model/config.php');
  $query = $database -> prepare('select * from typecapteur where idTypeCapteur <> ?');
  $query -> bindParam(1, $idTypeCapteur);
  $query -> execute();
  $res = $query->fetchAll(PDO::FETCH_ASSOC);
  return $res;
}

function getOptionsPieces($idMaison, $idPiece)
{
  require('./model/config.php');
  $query = $database -> prepare('select * from piece where idPiece <> ? and idMaison = ?');
  $query -> bindParam(1, $idPiece);
  $query -> bindParam(2, $idMaison);
  $query -> execute();
  $res = $query-> fetchAll(PDO::FETCH_ASSOC);
  return $res;
}

function getOptionsMaisons($idClient, $idMaison)
{
  require('./model/config.php');
  $query = $database -> prepare('select * from maison where idMaison <> ? and idClient = ?');
  $query -> bindParam(1, $idMaison);
  $query -> bindParam(2, $idClient);
  $query -> execute();
  $res = $query-> fetchAll(PDO::FETCH_ASSOC);
  return $res;
}
?>
