<?php
  function connexionUtilisateur($username,$password,$selecteur)
  {
    echo($username . "  ");
    echo($password . "  ");
    echo(password_hash($password, PASSWORD_DEFAULT). "  ");
    echo($selecteur);
  }

?>
