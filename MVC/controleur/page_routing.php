<?php
  function page_connexion()
  {
    require("./vue/indexVue.tpl");
  }

  function seConnecter()
  {
      require("./modele/connexion.php");
      connexionUtilisateur($_POST['uname'],$_POST['psw'],$_POST['selector']);
  }
?>
