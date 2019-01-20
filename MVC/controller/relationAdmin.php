<?php
  /**
   * contrôleur permettant de faire l'affichage des données des clients
   */
  function afficheDonneesClients()
  {
    require("./model/donneesClient.php");
    $clients = getClients();
    require("./view/consultationDonneesClient.php");
  }

  /**
   * contrôleur permettant de faire l'affichage de la messagerie
   */
  function afficheMessagerie()
  {
    require("./model/demandesClient.php");
    $demandes = getDemandes();
    require("./view/Messagerie.php");
  }

  /**
   * contrôleur permettant d'envoyer une réponse à un message
   */
  function sendMessage()
  {
    require_once("./model/util.php");
    require("./model/inscription.php");

    $obj = $_POST["object"];
    $txt = $_POST["message"];
    $rep = $_POST["reponse"];
    $dest = $_POST["mail"];
    $nom = $_POST["nom"];
    $prenom = $_POST["prenom"];

    $mailConf = 'Bonjour,</br></br>Nous vous remercions de nous avoir contacté :</br></br>     "'.
      $txt.'"</br></br> Voici la réponse de notre administrateur : </br></br>'.$rep;

    try {
      $status = repondreMessage($obj, $txt, $nom);
      sendMail($dest, $nom, $prenom, $obj, $mailConf);
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
