<?php

  function inscrireClient($email,$passe)
  {
    require('./model/config.php');
    $query = $database -> prepare('insert into client(`mail`,`passe`) values(?,?)');
    $query -> bindParam(1,$email);
    $passHash = password_hash($passe,PASSWORD_DEFAULT);
    $query -> bindParam(2,$passHash);
    if($query -> execute())
    {
      return "Client.e créé.e";
    }
    else
    {
      return "Client.e déjà existant.e";
    }
  }
?>
