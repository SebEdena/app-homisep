<?php
  function afficherFAQ()
  {
    require("./view/FAQ.tpl");
  }

  function afficherAccueil()
  {
    require("./view/TemplateUtilisateur.tpl");
  }

  function deconnexion()
  {
    session_destroy();
    require("./view/indexVue.tpl");
  }
?>
