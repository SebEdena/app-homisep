<?php

  function actualiserDonnees() 
  {
    require('./model/util.php');
    require('./model/config.php');

    $nom = traitementCaractereSpeciaux($_POST['lastname']);
    $prenom = traitementCaractereSpeciaux($_POST['firstname']);
    $email = traitementCaractereSpeciaux($_POST['email']);
    $bdate = traitementCaractereSpeciaux($_POST['bdate']);
    $adresse = traitementCaractereSpeciaux($_POST['adress']);

    $query = $database -> prepare('UPDATE client(`nom`,`prenom`,`mail`,`dateNaissance`,`adresse`,``) values(?,?)');
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
?>
