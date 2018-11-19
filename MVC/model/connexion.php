<?php
  function connexionUtilisateur($username,$password,$selecteur)
  {
    $database = new PDO('mysql:host=localhost;dbname=homisep', "root", "root");
    if($selecteur == "admin")
    {
      $res = $database -> prepare('select * from administrateur where administrateur.mail = ?');
    }
    else
    {
      $res = $database -> prepare('select * from client client.mail = ?');
    }

    $res -> bindParam(1, $username);

    $res -> execute();

    while ($row = $res->fetch(PDO::FETCH_ASSOC))
    {
      echo($row);
    }
  }

?>
