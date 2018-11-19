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
      $res = $database -> prepare('select * from client where client.mail = ?');
    }

    $res -> bindParam(1, $username);

    $res -> execute();
    $row = $res->fetch(PDO::FETCH_ASSOC);
    if(password_verify($password,$row["passe"]))
    {
      echo(1);
    }
    else
    {
      echo(0);
    }
  }

?>
