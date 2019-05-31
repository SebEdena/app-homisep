<?php
  /**
   * fonction permettant de récupérer une règle
   * @param $regle le nom d'une règle souhaitée
   * @return retourne la règle souhaitée
   */
  function getRegle($regle){
    require("./model/config.php");
    $query = $database -> prepare('select * from regle where nomRegle = ?');
    $query -> bindParam(1,$regle);
    $query -> execute();

    $res = $query->fetchAll(PDO::FETCH_ASSOC);
    return $res;
  }

  /**
   * fonction permettant de générer un mot de passe
   * @param $size la taille souhaitée pour le mot de passe
   * @return retourne un mot de passe généré
   */
  function Genere_mdp($size)  {
      $mot_de_passe = "";
      $chiffres = array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9);
      $lettres = array("a", "b", "c", "d", "e", "f", "g", "h", "i", "j", "k", "l", "m", "n", "o", "p", "q", "r", "s", "t", "u", "v", "w", "x", "y", "z");
      $symboles = array(".", "@", "*", "!","?", "-");
      $decalage = 0;
      for($i=0; $i<$size; $i++)      {
          if (($i + $decalage)%3==0){
              $mot_de_passe .= ($i%2) ? strtoupper($lettres[array_rand($lettres)]) : $lettres[array_rand($lettres)];
          }else if(($i + $decalage)%3==1){
              $mot_de_passe .= $chiffres[array_rand($chiffres)];
          }else{
              $mot_de_passe .= $symboles[array_rand($symboles)];
          }
      }
      return $mot_de_passe;
  }

  /**
   * fonction permettant d'identifier un client
   * @param $mail l'adresse mail saisie
   * @return retourne vrai si le client existe / faux sinon
   */
  function verifyUser($mail){
    require("./model/config.php");
    $res = $database -> prepare('select * from client where client.mail = ?');
    $res -> bindParam(1, $mail);
    $res -> execute();
    $row = $res->fetch(PDO::FETCH_ASSOC);
    if(is_null($row['mail'])){
      return false;
    }
    else{
      return true;
    }
  }

  /**
   * fonction permettant d'identifier un administrateur
   * @param $mail l'adresse mail saisie
   * @return retourne vrai si l'administrateur existe / faux sinon
   */
  function verifyAdmin($mail)  {
    require("./model/config.php");
    $res = $database -> prepare('select * from administrateur where administrateur.mail = ?');
    $res -> bindParam(1, $mail);
    $res -> execute();
    $row = $res->fetch(PDO::FETCH_ASSOC);
    if(is_null($row['mail']))    {
      return false;
    }
    else{
      return true;
    }
  }

  /**
   * fonction permettant de mettre à jour le mot de passe de l'utilisateur
   * @param $mdp le mot de passe
   * @param $mail le mail de l'utilisateur
   * @return renvoie vrai si le changement de mot de passe a été fait / faux sinon
   */
  function insere_mdp($mdp,$mail){
    require("./model/config.php");
    $res = $database -> prepare('update client set passe = ? where mail = ?');
    $passHash = password_hash($mdp,PASSWORD_DEFAULT);
    $res -> bindParam(1, $passHash);
    $res -> bindParam(2, $mail);
    try{
      $res -> execute();
      return true;
    }
    catch(PDOException $exception){
      return false;
    }
  }

  /**
   * fonction permettant de mettre à jour le mot de passe de l'administrateur
   * @param $mdp le mot de passe
   * @param $mail le mail de l'utilisateur
   * @return renvoie vrai si le changement de mot de passe a été fait / faux sinon
   */
  function insere_mdp_admin($mdp,$mail){
    require("./model/config.php");
    $res = $database -> prepare('update administrateur set passe = ? where mail = ?');
    $passHash = password_hash($mdp,PASSWORD_DEFAULT);
    $res -> bindParam(1, $passHash);
    $res -> bindParam(2, $mail);
    try{
      $res -> execute();
      return true;
    }
    catch(PDOException $exception){
      return false;
    }
  }

  /**
   * fonction permettant l'envoi du mail de réinitialisation de mot de passe (source venant de PHPMailer)
   * @param $mdp le nouveau mot de passe de l'utilisateur
   * @param $mail le mail de l'utilisateur
   */
  function send_mail_mdp($mdp,$adresse)
  {
    require("./model/mailConfig.php");
    try {
        $mail->setFrom('homisep@free.fr', "L'équipe Homisep");
        $mail->addAddress($adresse);
        $mail->Subject = 'Réinitialisation de mot de passe';
        $mail->Body = 'Vous avez demandé la réinitialisation de votre mot de passe.</br> Nous vous communiquons votre mot de passe temporaire : ' . $mdp . ' </br> Cordialement </br> Equipe Homisep' ;
        $mail->send();
    }
    catch (Exception $e){
        echo $e->errorMessage();
    }
    catch (\Exception $e){
        echo $e->getMessage();
    }
  }

  function getDonneesServeur()
  {
      $ch = curl_init();
      curl_setopt($ch, CURLOPT_URL,"http://projets-tomcat.isep.fr:8080/appService/?ACTION=GETLOG&TEAM=G02A");
      curl_setopt($ch, CURLOPT_HEADER, FALSE);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
      $data = curl_exec($ch);
      curl_close($ch);
      return $data;
  }

  function sendData($data)
  {
      $dateMax = strtotime(getLastDate());
      $tableau = str_split($data,33);
      for($compteur = count($tableau) - 2; $compteur >= 0 ; $compteur--)
      {
          if($dateMax < strtotime(substr($tableau[$compteur],19,33)))
          {
              sendTrameToDB($tableau[$compteur]);
          }
          else
          {
              break;
          }
      }
      echo($compteur);
  }
//      $typeTrame = substr($donnees,0,1);
//      $objet = substr($donnees,1,5);
//      $req = substr($donnees,5,6);
//      $numCeMac = substr($donnees,7,9);
//      $time = substr($donnees,13,17);
//      $crc = substr($donnees,17,19);
//$mois = substr($donnees,23,25);
//$jour = substr($donnees,25,27);
//$heure = substr($donnees,27,29);
//$minute = substr($donnees,29,31);
//$seconde = substr($donnees,31,33);

  function sendTrameToDB($donnees)
  {
      $typeCeMac = substr($donnees,6,1);
      $valeur = hexdec(substr($donnees,9,4));
      $date = substr($donnees,19,14);
      $idCeMac = getIdCeMac($typeCeMac);
      require("./model/config.php");
      $query = $database -> prepare('insert into historique(dateReleve, valeurReleve, idCemac) values (?,?,?);');
      $query -> bindparam(1, $date);
      $query -> bindparam(2, $valeur);
      $query -> bindparam(3, $idCeMac);
      try{
          $query -> execute();
      }
      catch (PDOException $exception)
      {

      }
  }

  function getLastDate()
  {
      require("./model/config.php");
      $query = $database -> prepare('SELECT MAX(dateReleve) AS start_date FROM historique');
      $query -> execute();

      $res = $query->fetchAll(PDO::FETCH_ASSOC);
      $dateMax = $res[0]['start_date'];
      if(!is_null($dateMax))
      {
          $dateMax = str_replace("-","",$dateMax);
          $dateMax = str_replace(":","", $dateMax);
      }
      else
      {
          $dateMax = "20190521163624";
      }
      return $dateMax;
  }

  function getIdCeMac($donnees)
  {
      $donnees = translateCeMacToServer($donnees);
      if(strcmp($donnees,"4")||strcmp($donnees,"6"))
      {
          require("./model/config.php");
          $query = $database -> prepare('select * from cemac where idTypeCapteur = ? and numeroSerie sounds like \'G02A\';');
          $query -> bindparam(1,$donnees);
          $query -> execute();
          $res = $query->fetchAll(PDO::FETCH_ASSOC);
          return $res[0]['idCemac'];
      }
      else
      {
          return "0";
      }
  }

  function translateCeMacToServer($donnees)
  {
      switch($donnees)
      {
          case "3":
              return "4";
          case "5":
              return "6";
          default:
              return "0";
      }
  }
?>
