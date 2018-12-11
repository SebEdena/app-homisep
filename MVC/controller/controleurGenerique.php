<?php
  function afficherAccueil()
  {
    if($_SESSION['admin'] == true)
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
