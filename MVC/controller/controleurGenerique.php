<?php
  function afficherAccueil()
  {
    if($_SESSION['type'] == "admin")
    {
      header("Location: " . "index.php?control=relationAdmin&action=afficheDonneesClients");
    }
    else
    {
      header("Location: " . "index.php?control=relationClient&action=afficheTableauBord");
    }
  }

  function deconnexion()
  {
    session_destroy();
    require("./view/indexVue.tpl");
  }
?>
