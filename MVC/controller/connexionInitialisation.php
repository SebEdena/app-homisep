<?php
  function page_connexion()
  {
    require("./view/indexVue.tpl");
  }

  function seConnecter()
  {
      require("./model/connexion.php");
      connexionUtilisateur($_POST['uname'],$_POST['psw'],$_POST['selector']);
  }
?>
