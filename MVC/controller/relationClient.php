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

  function recupPieces(){
      require("./model/tableau_bord.php");
      $idMaison = $_POST["idMaison"];
      try{
          $result = getPieces($idMaison);
          http_response_code(200);
          header('Content-Type: application/json; charset=UTF-8');
          print json_encode($result);
      }catch(Exception $exception){
          http_response_code(500);
          header('Content-Type: application/json; charset=UTF-8');
          print json_encode(array('error'=>true, 'message'=>$exception));
      }
  }
?>
