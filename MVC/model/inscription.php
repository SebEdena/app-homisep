<?php

  function inscrireClient($email,$passe)
  {
    require('./model/util.php');
    require('./model/config.php');

    $email = traitementCaractereSpeciaux($email);
    $passe = traitementCaractereSpeciaux($passe);

    $query = $database -> prepare('insert into client(`mail`,`passe`) values(?,?)');
    $query -> bindParam(1,$email);
    $passHash = password_hash($passe,PASSWORD_DEFAULT);
    $query -> bindParam(2,$passHash);
    try
    {
      $query -> execute();
      return "Client.e créé.e";
    }
    catch(PDOException $exception)
    {
      if ($exception->getCode() == 23000) //violation de clé unique
      {
        return "Client.e déjà existant.e";
      }
      else
      {
        return "Erreur de traitement";
      }
    }
  }

  function inscrireMessage($objet, $texte){
    require("./model/util.php");
    require('./model/config.php');
    
    $idClient = $_SESSION['id'];
    $objet = traitementCaractereSpeciaux($objet);
    $texte = traitementCaractereSpeciaux($texte);

    $query = $database -> prepare('insert into message(`objet`,`texte`,`idClient`) values(?,?,?)');
    $query -> bindParam(1,$objet);
    $query -> bindParam(2,$texte);
    $query -> bindParam(3,$idClient);

    $query -> execute();
    return true;

  }
?>
