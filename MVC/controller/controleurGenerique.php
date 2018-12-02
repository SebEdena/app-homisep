<?php
  function afficherAccueil()
  {
    if($_SESSION['type'] == "admin")
    {
      require("./view/consultationDonneesClient.php");
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
