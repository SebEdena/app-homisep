<?php

  function getClients()
  {
      require('./model/config.php');
      require_once('./model/classes/client.php');
      $query = $database -> prepare('select * from client');

      $query -> execute();

      $res = $query->fetchAll(PDO::FETCH_CLASS, 'Client');
      return $res;
  }




function recupererDonneesClient()
{
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


function actuDonneesClient($nom, $prenom, $bday, $email, $adresse, $ville, $codePostal, $id)
{
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
