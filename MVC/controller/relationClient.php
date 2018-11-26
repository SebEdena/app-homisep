<?php
  function afficherFAQ()
  {
    require("./view/FAQ.php");
  }

  function afficherAccueil()
  {
    require("./view/consultationCapteurs.php");
  }

  function deconnexion()
  {
    session_destroy();
    require("./view/indexVue.tpl");
  }
?>
