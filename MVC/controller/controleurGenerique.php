<?php
  function afficherAccueil()
  {
    if($_SESSION['type'] == "admin")
    {
      require("./view/consultationDonneesClient.php");
    }
    else
    {
      require("./view/consultationCapteurs.php");
    }
  }

  function deconnexion()
  {
    session_destroy();
    require("./view/indexVue.tpl");
  }
?>
