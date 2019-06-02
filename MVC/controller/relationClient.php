<?php
  /**
   * contrôleur permettant l'affichage de la FAQ statique
   */
  function afficherFAQ(){
      require_once("./model/init.php");
      $cgu = getRegle("CGU");
      $politique = getRegle("Politique");
      $mention = getRegle("Mention");
      require("./view/FAQ.php");
  }

  function initControllerBD()
  {
      require_once("./model/init.php");
      $data = getDonneesServeur();
      if (strpos($data, 'ERREUR') == false)
      {
          sendData($data);
      }
      header("Location: " . "index.php?control=relationClient&action=afficheTableauBord");
  }
  /**
   * contrôleur permettant de faire l'affichage du tableau de bord
   */
  function afficheTableauBord(){
      require_once("./model/init.php");
      $cgu = getRegle("CGU");
      $politique = getRegle("Politique");
      $mention = getRegle("Mention");
      require("./model/tableau_bord.php");
      $maisons = getMaisons();
      require("./view/tableauBord.php");
  }

  /**
   * contrôleur permettant de récupérer des données de la maison
   */
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

  /**
   * contrôleur permettant la mise à jour des actionneurs
   */
  function updateActionneurs(){
      require('./model/tableau_bord.php');
      $valeurs = $_POST['valeurs'];
      try{
          $status = updateProgrammes($valeurs);
          prepareTrameActionneur($valeurs);
          http_response_code(200);
          header('Content-Type: application/json; charset=UTF-8');
          print json_encode(array('returnStatus' => $status));
      }catch(Exception $exception){
          http_response_code(500);
          header('Content-Type: application/json; charset=UTF-8');
          print json_encode(array('error'=>true, 'message'=>$exception->getMessage()));
      }
  }

  /**
   * contrôleur permettant l'affichage du gestionnaire de compte
   */
  function afficheGestionCompte(){
    require_once("./model/init.php");
    $cgu = getRegle("CGU");
    $politique = getRegle("Politique");
    $mention = getRegle("Mention");
    require("./model/tableau_bord.php");
    $maisons = getMaisons();
    $donnees = recupDonneesClient();
    require("./view/gestionMaisonPieceCapteur.php");
  }

  /**
   * contrôleur permettant de récupérer les données d'une pièce
   */
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

  /**
   * contrôleur permettant de récupérer des informations d'une maison
   */
  function getInfoMaison(){
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

  /**
   * contrôleur permettant de récupérer des informations d'une pièce
   */
  function getInfoPiece(){
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

  /**
   * contrôleur permettant de récupérer des informations d'un CeMac
   */
  function getInfoCapteur(){
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

  /**
   * contrôleur permettant de créer une nouvelle maison
   */
  function creerNouvelleMaison(){
    require("./model/tableau_bord.php");
    try{
      if($_POST["maisonPrincipale"] === "true"){
        $maisonPrincipale = b'1';
      }
      else{
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

  /**
   * contrôleur permettant de modifier des informations d'une maison
   */
  function modifierMaison(){
    require("./model/tableau_bord.php");
    try{
      if($_POST["maisonPrincipale"] === "true"){
        $maisonPrincipale = b'1';
      }
      else{
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

  /**
   * contrôleur permettant de supprimer une maison
   */
  function supprimerMaison(){
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

  /**
   * contrôleur permettant de créer une nouvelle pièce
   */
  function creerNouvellePiece(){
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

  /**
   * contrôleur permettant de modifier les informations d'une pièce
   */
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

  /**
   * contrôleur permettant de supprimer une pièce
   */
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

  /**
   * contrôleur permettant de créer un nouveau CeMac
   */
  function creerNouveauCemac(){
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

  /**
   * contrôleur permettant de modifier les informations d'un CeMac
   */
  function modifierCemac(){
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

  /**
   * contrôleur permettant de supprimer un CeMac
   */
  function supprimerCemac(){
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

  /**
   * contrôleur permettant de recharger les informations pour les maisons
   */
  function reloadMaison(){
    require("./model/tableau_bord.php");
    try{
      $maisons = getMaisonsAssoc();
      http_response_code(200);
      header('Content-Type: application/json; charset=UTF-8');
      print json_encode(array('maison' => $maisons));
    }
    catch(Exception $exception) {
        http_response_code(500);
        header('Content-Type: application/json; charset=UTF-8');
        print json_encode(array('error'=>true, 'message'=>$exception->getMessage()));
    }
  }

  /**
   * contrôleur permettant de recharger les informations pour les pièces
   */
  function reloadPiece(){
    require("./model/tableau_bord.php");
    try{
      $pieces = getPiecesAssoc($_POST["idMaison"]);
      http_response_code(200);
      header('Content-Type: application/json; charset=UTF-8');
      print json_encode(array('piece' => $pieces));
    }
    catch(Exception $exception){
        http_response_code(500);
        header('Content-Type: application/json; charset=UTF-8');
        print json_encode(array('error'=>true, 'message'=>$exception->getMessage()));
    }
  }

  /**
   * contrôleur permettant de recharger les informations pour les CeMac
   */
  function reloadCemac(){
    require("./model/tableau_bord.php");
    try{
      $cemacs = getCemacsAssoc($_POST["id"]);
      http_response_code(200);
      header('Content-Type: application/json; charset=UTF-8');
      print json_encode(array('cemac' => $cemacs));
    }
    catch(Exception $exception){
        http_response_code(500);
        header('Content-Type: application/json; charset=UTF-8');
        print json_encode(array('error'=>true, 'message'=>$exception->getMessage()));
    }
  }

  /**
   * contrôleur permettant de récuperer les options pour les types de CeMac
   */
  function recupererTypeCapteur(){
    require("./model/tableau_bord.php");
    try{
      $typeCapteur = getTypeCapteur($_POST["id"]);
      http_response_code(200);
      header('Content-Type: application/json; charset=UTF-8');
      print json_encode($typeCapteur);
    }
    catch(Exception $exception){
        http_response_code(500);
        header('Content-Type: application/json; charset=UTF-8');
        print json_encode(array('error'=>true, 'message'=>$exception->getMessage()));
    }
  }

  /**
   * contrôleur permettant de récuperer les données des clients
   */
  function recupDonneesClient(){
    require('./model/donneesClient.php');
    return recupererDonneesClient();
  }

  /**
   * contrôleur permettant d'actualiser les données du client
   */
  function actualiserDonneesClient(){
    require_once('./model/util.php');
    require('./model/donneesClient.php');

    $nom = traitementCaractereSpeciaux($_POST['lastname']);
    $prenom = traitementCaractereSpeciaux($_POST['firstname']);
    $bday = traitementCaractereSpeciaux($_POST['bdate']);
    $email = traitementCaractereSpeciaux($_POST['email']);
    $adresse = traitementCaractereSpeciaux($_POST['adress']);
    $ville = traitementCaractereSpeciaux($_POST['ville']);
    $codePostal = traitementCaractereSpeciaux($_POST['postal']);

    $id = $_SESSION['id'];
    $e = actuDonneesClient($nom, $prenom, $bday, $email, $adresse, $ville, $codePostal, $id);
    echo $e;
    header('Location: index.php?control=relationClient&action=afficheGestionCompte');
  }

  /**
   * contrôleur permettant d'actualiser le mot de passe du client
   */
  function actualiserMDP(){
    $ancienMdp = traitementCaractereSpeciaux($_POST['currentpsw']);
    $nouveauMdp = traitementCaractereSpeciaux($_POST['newpsw']);
    $verifieMdp = traitementCaractereSpeciaux($_POST['confirm_psw']);
  }

  /**
   * contrôleur permettant de récupérer les options de pièces
   */
  function recupererOptionsPiece(){
    require("./model/tableau_bord.php");
    try{
      $piece = getOptionsPieces($_POST["idMaison"],$_POST["idPiece"]);
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

  /**
   * contrôleur permettant de récupérer les options de maison
   */
  function recupererOptionsMaison(){
    require("./model/tableau_bord.php");
    try{
      $maison = getOptionsMaisons($_SESSION['id'], $_POST['idMaison']);
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

  /**
   * contrôleur permettant de préparer un message (un envoi de mail pour confirmer l'envoi de son message /
   * et l'insertion dans la base de données du message)
   */
  function setMessage(){
    require("./model/inscription.php");
    require_once("./model/util.php");

    $obj = $_POST["object"];
    $txt = $_POST["message"];
    $dest = $_SESSION["mail"];
    $nom = $_SESSION["nom"];
    $prenom = $_SESSION["prenom"];

    $mailConf = 'Bonjour,</br></br>Nous avons bien reçu votre demande :</br></br>     "'.
      $txt.'"</br></br>Nous vous répondrons dans les plus bref délais.';

    try {
      $status = inscrireMessage($obj, $txt);
      http_response_code(200);
      header('Content-Type: application/json; charset=UTF-8');
      sendMail($dest, $nom, $prenom, $obj, $mailConf);
      print json_encode($status);
    }
    catch(Exception $exception){
      http_response_code(500);
      header('Content-Type: application/json; charset=UTF-8');
      print json_encode(array('error'=>true, 'message'=>$exception->getMessage()));
    }
  }
?>
