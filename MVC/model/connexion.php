<?php
  function connexionUtilisateur($username,$password,$selecteur)
  {
    require('./model/config.php');
    $database = new PDO($db_host,$db_user, $db_pass);
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
    if($row['mail'] <> "")
    {
      if(password_verify($password,$row["passe"]))
      {
        $_SESSION["mail"] = $row["mail"];
        $_SESSION["type"] = $selecteur;
        return $selecteur;
      }
      else
      {
        return "ErrorMDP";
      }
    }
    else
    {
      return "ErrorUser";
    }

  }

?>
