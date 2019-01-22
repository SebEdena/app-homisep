<?php

  /**
   * fonction permettant l'inscription du client
   * @param $email l'adresse mail du client
   * @param $passe le mot de passe du client
   * @return renvoie un message
   */
  function inscrireClient($email,$passe){
    require('./model/util.php');
    require('./model/config.php');

    $email = traitementCaractereSpeciaux($email);
    $passe = traitementCaractereSpeciaux($passe);

    $query = $database -> prepare('insert into client(`mail`,`passe`) values(?,?)');
    $query -> bindParam(1,$email);
    $passHash = password_hash($passe,PASSWORD_DEFAULT);
    $query -> bindParam(2,$passHash);
    try{
      $query -> execute();
      return "Client.e créé.e";
    }
    catch(PDOException $exception){
      if ($exception->getCode() == 23000) //violation de clé unique{
        return "Client.e déjà existant.e";
      }
      else{
        return "Erreur de traitement";
      }
    }
  }

  /**
   * fonction permettant d'inscrire un message dans la base de données
   * @param $objet l'objet du message
   * @param $texte le texte du message
   * @return retourne vrai si ça fonction
   */
  function inscrireMessage($objet, $texte){
    require('./model/config.php');
    require_once("./model/util.php");

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

  /**
   * fonction permettant de répondre à un message dans la base de données
   * @param $objet l'objet du message
   * @param $texte le texte du message
   * @param $nom le nom de l'administrateur
   * @return retourne vrai
   */
  function repondreMessage($objet, $texte, $nom){
    require('./model/config.php');
    require_once("./model/util.php");

    $idAdm = $_SESSION['id'];
    $objet = traitementCaractereSpeciaux($objet);
    $texte = traitementCaractereSpeciaux($texte);
    $nomCli = traitementCaractereSpeciaux($nom);

    $query = $database -> prepare("UPDATE message SET `idAdministrateur`=? WHERE `objet`=? AND `texte`=?");
    $query -> bindParam(1,$idAdm);
    $query -> bindParam(2,$objet);
    $query -> bindParam(3,$texte);

    $query -> execute();
    return true;
  }
?>
