<?php
  function page_connexion()
  {
    require("./vue/indexVue.tpl");
  }

  function seConnecter()
  {
      require("./modele/connexion.php");
      echo($_POST['selector']);
      connexionUtilisateur($_POST['uname'],$_POST['psw']);
  }
?>
