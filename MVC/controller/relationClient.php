<?php
function afficherFAQ()
{
    require_once("./model/init.php");
    $cgu = getRegle("CGU");
    $politique = getRegle("Politique");
    require("./view/FAQ.php");
}

function afficheTableauBord(){
    require_once("./model/init.php");
    $cgu = getRegle("CGU");
    $politique = getRegle("Politique");
    require("./model/tableau_bord.php");
    $maisons = getMaisons();
    require("./view/tableauBord.php");
}

function getDonneesMaison(){
    require("./model/tableau_bord.php");
    $idMaison = $_POST["idMaison"];
    try{
        $pieces = getPieces($idMaison);
        $cemacs = getCemacs($idMaison);
        $context = buildCemacsContext($pieces, $cemacs);

        http_response_code(200);
        header('Content-Type: application/json; charset=UTF-8');
        print json_encode(array(
            'pieces' => $pieces,
            'cemacs' => $cemacs,
            'context' => $context
        ));
    }catch(Exception $exception){
        http_response_code(500);
        header('Content-Type: application/json; charset=UTF-8');
        print json_encode(array('error'=>true, 'message'=>$exception->getMessage()));
    }
}

function updateActionneurs(){
    require('./model/tableau_bord.php');
    $valeurs = $_POST['valeurs'];
    try{
        $status = updateProgrammes($valeurs);
        http_response_code(200);
        header('Content-Type: application/json; charset=UTF-8');
        print json_encode(array('returnStatus' => $status));
    }catch(Exception $exception){
        http_response_code(500);
        header('Content-Type: application/json; charset=UTF-8');
        print json_encode(array('error'=>true, 'message'=>$exception->getMessage()));
    }
}

function afficheGestionCompte()
{
  require_once("./model/init.php");
  $cgu = getRegle("CGU");
  $politique = getRegle("Politique");
  require("./model/tableau_bord.php");
  $maisons = getMaisons();
  require("./view/gestionMaisonPieceCapteur.php");
}

function getDonneesPiece(){
    require("./model/tableau_bord.php");
    $idPiece = $_POST["idPiece"];
    try{
        $cemacs = getCemacsInPiece($idPiece);

        http_response_code(200);
        header('Content-Type: application/json; charset=UTF-8');
        print json_encode(array(
            'cemacs' => $cemacs
        ));
    }catch(Exception $exception){
        http_response_code(500);
        header('Content-Type: application/json; charset=UTF-8');
        print json_encode(array('error'=>true, 'message'=>$exception->getMessage()));
    }
}

function getInfoMaison()
{
  require("./model/tableau_bord.php");
  $idMaison = $_POST["idMaison"];

  try{
    $maison = getInfoMaisonBD($idMaison);
    http_response_code(200);
    header('Content-Type: application/json; charset=UTF-8');
    print json_encode($maison);
  }
  catch(Exception $exception){
      http_response_code(500);
      header('Content-Type: application/json; charset=UTF-8');
      print json_encode(array('error'=>true, 'message'=>$exception->getMessage()));
  }
}

function getInfoPiece()
{
  require("./model/tableau_bord.php");
  $idPiece = $_POST["idPiece"];

  try{
    $piece = getInfoPieceBD($idPiece);
    http_response_code(200);
    header('Content-Type: application/json; charset=UTF-8');
    print json_encode($piece);
  }
  catch(Exception $exception){
      http_response_code(500);
      header('Content-Type: application/json; charset=UTF-8');
      print json_encode(array('error'=>true, 'message'=>$exception->getMessage()));
  }
}

function getInfoCapteur()
{
  require("./model/tableau_bord.php");
  $idCapteur = $_POST["idCapteur"];
  try{
    $capteur = getInfoCapteurBD($idCapteur);
    http_response_code(200);
    header('Content-Type: application/json; charset=UTF-8');
    print json_encode($capteur);
  }
  catch(Exception $exception){
      http_response_code(500);
      header('Content-Type: application/json; charset=UTF-8');
      print json_encode(array('error'=>true, 'message'=>$exception->getMessage()));
  }
}

function creerNouvelleMaison()
{
  require("./model/tableau_bord.php");
  try{
    if($_POST["maisonPrincipale"] === "true")
    {
      $maisonPrincipale = b'1';
    }
    else
    {
      $maisonPrincipale = b'0';
    }
    $status = creerNouvelleMaisonBD($_SESSION["id"],$_POST["adresse"],$_POST["ville"],$_POST["codePostal"],$maisonPrincipale);
    http_response_code(200);
    header('Content-Type: application/json; charset=UTF-8');
    print json_encode($status);
  }
  catch(Exception $exception){
      http_response_code(500);
      header('Content-Type: application/json; charset=UTF-8');
      print json_encode(array('error'=>true, 'message'=>$exception->getMessage()));
  }
}
function modifierMaison()
{
  require("./model/tableau_bord.php");
  try{
    if($_POST["maisonPrincipale"] === "true")
    {
      $maisonPrincipale = b'1';
    }
    else
    {
      $maisonPrincipale = b'0';
    }
    $status = modifierMaisonBD($_POST["id"],$_POST["adresse"],$_POST["ville"],$_POST["codePostal"],$maisonPrincipale);
    http_response_code(200);
    header('Content-Type: application/json; charset=UTF-8');
    print json_encode($status);
  }
  catch(Exception $exception){
      http_response_code(500);
      header('Content-Type: application/json; charset=UTF-8');
      print json_encode(array('error'=>true, 'message'=>$exception->getMessage()));
  }
}
function supprimerMaison()
{
  require("./model/tableau_bord.php");
  try{
    $status = supprimerMaisonBD($_POST["id"]);
    http_response_code(200);
    header('Content-Type: application/json; charset=UTF-8');
    print json_encode($status);
  }
  catch(Exception $exception){
      http_response_code(500);
      header('Content-Type: application/json; charset=UTF-8');
      print json_encode(array('error'=>true, 'message'=>$exception->getMessage()));
  }
}
function creerNouvellePiece()
{
  require("./model/tableau_bord.php");
  try{
    $status = creerNouvellePieceBD($_POST["idMaison"],$_POST["nom"]);
    http_response_code(200);
    header('Content-Type: application/json; charset=UTF-8');
    print json_encode($status);
  }
  catch(Exception $exception){
      http_response_code(500);
      header('Content-Type: application/json; charset=UTF-8');
      print json_encode(array('error'=>true, 'message'=>$exception->getMessage()));
  }
}
function modifierPiece()
{
  require("./model/tableau_bord.php");
  try{
    $status = modifierPieceBD($_POST["id"],$_POST["nom"],$_POST["idMaison"]);
    http_response_code(200);
    header('Content-Type: application/json; charset=UTF-8');
    print json_encode($status);
  }
  catch(Exception $exception){
      http_response_code(500);
      header('Content-Type: application/json; charset=UTF-8');
      print json_encode(array('error'=>true, 'message'=>$exception->getMessage()));
  }
}
function supprimerPiece()
{
  require("./model/tableau_bord.php");
  try{
    $status = supprimerPieceBD($_POST["id"]);
    http_response_code(200);
    header('Content-Type: application/json; charset=UTF-8');
    print json_encode($status);
  }
  catch(Exception $exception){
      http_response_code(500);
      header('Content-Type: application/json; charset=UTF-8');
      print json_encode(array('error'=>true, 'message'=>$exception->getMessage()));
  }
}
function creerNouveauCemac()
{
  require("./model/tableau_bord.php");
  try{
    $statut = creerNouveauCemacBD($_POST['numSerieCemac'],$_POST['typeCemac'],$_POST['idPiece']);
    http_response_code(200);
    header('Content-Type: application/json; charset=UTF-8');
    print json_encode($statut);
  }
  catch(Exception $exception){
      http_response_code(500);
      header('Content-Type: application/json; charset=UTF-8');
      print json_encode(array('error'=>true, 'message'=>$exception->getMessage()));
  }
}
function modifierCemac()
{
  require("./model/tableau_bord.php");
  try{
    $status = modifierCemacBD($_POST["id"],$_POST["numSerieCemac"],$_POST["typeCemac"],$_POST["idPiece"]);
    http_response_code(200);
    header('Content-Type: application/json; charset=UTF-8');
    print json_encode($status);
  }
  catch(Exception $exception){
      http_response_code(500);
      header('Content-Type: application/json; charset=UTF-8');
      print json_encode(array('error'=>true, 'message'=>$exception->getMessage()));
  }
}
function supprimerCemac()
{
  require("./model/tableau_bord.php");
  try{
    $status = supprimerCemacBD($_POST["id"]);
    http_response_code(200);
    header('Content-Type: application/json; charset=UTF-8');
    print json_encode($status);
  }
  catch(Exception $exception){
      http_response_code(500);
      header('Content-Type: application/json; charset=UTF-8');
      print json_encode(array('error'=>true, 'message'=>$exception->getMessage()));
  }
}
function reloadMaison()
{
  require("./model/tableau_bord.php");
  try{
    $maisons = getMaisonsAssoc();
    http_response_code(200);
    header('Content-Type: application/json; charset=UTF-8');
    print json_encode(array('maison' => $maisons));
  }
  catch(Exception $exception)
  {
      http_response_code(500);
      header('Content-Type: application/json; charset=UTF-8');
      print json_encode(array('error'=>true, 'message'=>$exception->getMessage()));
  }
}
function reloadPiece()
{
  require("./model/tableau_bord.php");
  try{
    $pieces = getPiecesAssoc($_POST["idMaison"]);
    http_response_code(200);
    header('Content-Type: application/json; charset=UTF-8');
    print json_encode(array('piece' => $pieces));
  }
  catch(Exception $exception)
  {
      http_response_code(500);
      header('Content-Type: application/json; charset=UTF-8');
      print json_encode(array('error'=>true, 'message'=>$exception->getMessage()));
  }
}
function reloadCemac()
{
  require("./model/tableau_bord.php");
  try{
    $cemacs = getCemacsAssoc($_POST["id"]);
    http_response_code(200);
    header('Content-Type: application/json; charset=UTF-8');
    print json_encode(array('cemac' => $cemacs));
  }
  catch(Exception $exception)
  {
      http_response_code(500);
      header('Content-Type: application/json; charset=UTF-8');
      print json_encode(array('error'=>true, 'message'=>$exception->getMessage()));
  }
}

function recupererTypeCapteur()
{
  require("./model/tableau_bord.php");
  try{
    $typeCapteur = getTypeCapteur($_POST["id"]);
    http_response_code(200);
    header('Content-Type: application/json; charset=UTF-8');
    print json_encode($typeCapteur);
  }
  catch(Exception $exception)
  {
      http_response_code(500);
      header('Content-Type: application/json; charset=UTF-8');
      print json_encode(array('error'=>true, 'message'=>$exception->getMessage()));
  }
}

function recupererOptionsPiece()
{
  require("./model/tableau_bord.php");
  try{
    $piece = getOptionsPieces($_POST["idMaison"],$_POST["idPiece"]);
    http_response_code(200);
    header('Content-Type: application/json; charset=UTF-8');
    print json_encode($piece);
  }
  catch(Exception $exception)
  {
      http_response_code(500);
      header('Content-Type: application/json; charset=UTF-8');
      print json_encode(array('error'=>true, 'message'=>$exception->getMessage()));
  }
}

function recupererOptionsMaison()
{
  require("./model/tableau_bord.php");
  try{
    $maison = getOptionsMaisons($_SESSION['id'], $_POST['idMaison']);
    http_response_code(200);
    header('Content-Type: application/json; charset=UTF-8');
    print json_encode($maison);
  }
  catch(Exception $exception)
  {
      http_response_code(500);
      header('Content-Type: application/json; charset=UTF-8');
      print json_encode(array('error'=>true, 'message'=>$exception->getMessage()));
  }
}

function setMessage(){
  require("./model/inscription.php");
  $obj = $_POST["object"];
  $txt = $_POST["message"];
  try {
    $status = inscrireMessage($obj, $txt);
    http_response_code(200);
    header('Content-Type: application/json; charset=UTF-8');
    print json_encode($status);
  }
  catch(Exception $exception){
    http_response_code(500);
    header('Content-Type: application/json; charset=UTF-8');
    print json_encode(array('error'=>true, 'message'=>$exception->getMessage()));
  }
}
?>
