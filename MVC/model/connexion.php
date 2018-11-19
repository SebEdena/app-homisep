<?php
  function connexionUtilisateur($username,$password,$selecteur)
  {
    $database = new PDO('mysql:host=localhost;dbname=homisep', "root", "root");
    if($selecteur == "admin")
    {
      $res = $database -> prepare('select * from administrateur where administrateur.mail = ? and administrateur.passe = ?');
    }
    else
    {
      $res = $database -> prepare('select * from client client.mail = ? and client.passe = ?');
    }

    echo(password_hash($password, PASSWORD_DEFAULT));

    $hashcode = password_hash($password, PASSWORD_DEFAULT);
    $res -> bindParam(1, $username);
    $res -> bindParam(2, $hashcode);

    $res -> execute();

    $queryResult = $res ->fetchAll();
  }

?>
