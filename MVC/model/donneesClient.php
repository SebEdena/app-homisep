<?php

  /**
   * fonction permettant de récupérer la liste des clients
   * @return retourne la liste des clients
   */
  function getClients(){
      require('./model/config.php');
      require_once('./model/classes/client.php');
      $query = $database -> prepare('select * from client');

      $query -> execute();

      $res = $query->fetchAll(PDO::FETCH_CLASS, 'Client');
      return $res;
  }

  /**
   * fonciton permettant de récupérer les données du client connecté
   * @return retourne les données du client
   */
  function recupererDonneesClient(){
  	require('./model/config.php');
    require('./model/classes/client.php');

    try {
      $id = $_SESSION['id'];
      $query = $database -> prepare('SELECT * FROM client WHERE idClient = ?');
      $query -> bindParam(1, $id);
      $query -> execute();

      $res = $query->fetchAll(PDO::FETCH_CLASS, 'Client');
      return $res[0];
    }
    catch(PDOException $Exception) {
      return false;
    }
  }

  /**
   * fonction permettant d'actualiser les données du client
   * @param $nom le nom du client
   * @param $prenom le prénom du client
   * @param $bday la date de naissance du client
   * @param $email l'adresse mail du client
   * @param $adresse l'adresse du client
   * @param $ville la ville du client
   * @param $codePostal le code postal du client
   * @param $id l'identifiant du client
   * @return retourne vrai si la mise à jour est faite, une exception s'il y a une erreur
   */
  function actuDonneesClient($nom, $prenom, $bday, $email, $adresse, $ville, $codePostal, $id){
    require('./model/config.php');
    require_once('./model/util.php');
    try {
      $query = $database -> prepare('UPDATE client SET nom = ?, prenom = ?, dateNaissance = ?, adresse = ?, ville = ?, codePostal = ? WHERE idClient = ?');
      $query -> bindParam(1, $nom);
      $query -> bindParam(2, $prenom);
      $query -> bindParam(3, $bday);
      $query -> bindParam(4, $adresse);
      $query -> bindParam(5, $ville);
      $query -> bindParam(6, $codePostal);
      $query -> bindParam(7, $id);


      $query -> execute();
    }
    catch(PDOException $Exception) {
      echo($Exception);
      return $Exception;
    }
    return true;
  }

function actuMotDePasse()
{}

?>
