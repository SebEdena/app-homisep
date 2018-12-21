<?php
  function page_connexion()
  {
    require("./view/indexVue.tpl");
  }

  function seConnecter()
  {
    require("./model/connexion.php");
    $etat = connexionUtilisateur($_POST['uname'],$_POST['psw']);
    switch($etat)
    {
      case "admin":
      case "client":
        require("./controller/controleurGenerique.php");
        afficherAccueil();
        break;
      case "ErrorMDP":
        $message = "Mot de passe incorrect";
        require("./view/indexVue.tpl");
        break;
      case "ErrorUser":
        $message = "Utilisateur Inconnu";
        require("./view/indexVue.tpl");
        break;
    }
    // if($etat  == "null")
    // {
    //   $message = "Utilisateur inconnu ou mot de passe refusé";
    //   require("./view/indexVue.tpl");
    // }
    // else
    // {
    //   if($etat == "admin")
    //   {
    //     require("./view/consultationDonneesClient.php");
    //   }
    //   else
    //   {
    //     require("./view/consultationCapteurs.php");
    //   }
    // }
  }

  function inscriptionClient()
  {
    require("./model/inscription.php");
    $message = inscrireClient($_POST['email'],$_POST['pass']);
    require("./view/indexVue.tpl");
  }
  function reset_mdp()
  {
    require ("./model/connexion.php");
    $mdp = Genere_mdp(8);
    
    require ("./view/indexVue.tpl");
  }
?>
