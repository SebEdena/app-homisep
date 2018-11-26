<?php
  function page_connexion()
  {
    require("./view/indexVue.tpl");
  }

  function seConnecter()
  {
    require("./model/connexion.php");
    $etat = connexionUtilisateur($_POST['uname'],$_POST['psw'],$_POST['selector']);
    if($etat  == "null")
    {
      echo("connexion refusée");
      require("./view/indexVue.tpl");
    }
    else
    {
      if($etat == "client")
      {
        require("./view/consultationCapteurs.php");
      }
      else
      {
        require("./view/TemplateAdmin.tpl");
      }
    }
  }

  function inscriptionClient()
  {
    require("./model/inscription.php");
    inscrireClient($_POST['email'],$_POST['pass']);
    page_connexion();
  }
?>
