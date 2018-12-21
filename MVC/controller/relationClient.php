<?php
function afficherFAQ()
{
    require("./view/FAQ.php");
}

function afficheTableauBord(){
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

function afficheGestionCompte()
{
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

?>
