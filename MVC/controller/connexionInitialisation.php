<?php
  function page_connexion()
  {
    require_once("./model/init.php");
    $cgu = getRegle("CGU");
    $politique = getRegle("Politique");
    require("./view/indexVue.tpl");
  }

  function renvoi_page_connexion($message)
  {
    require_once("./model/init.php");
    $cgu = getRegle("CGU");
    $politique = getRegle("Politique");
    require("./view/indexVue.tpl");
  }

  function resetmdp()
  {
    require_once("./model/init.php");
    if(verifyUser($_POST['mailResetMdp']))
    {
      $newMdp = Genere_mdp(9);
      if(insere_mdp($newMdp,$_POST['mailResetMdp']))
      {
        send_mail_mdp($newMdp,$_POST['mailResetMdp']);
        $message = "Votre mot de passe a été réinitialisé";
      }
      else
      {
        $message = "erreur dans la modification de mot de passe";
      }
    }
    else
    {
      $message = "erreur dans le mail utilisateur";
    }
    renvoi_page_connexion($message);
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
        renvoi_page_connexion($message);
        break;
      case "ErrorUser":
        $message = "Utilisateur Inconnu";
        renvoi_page_connexion($message);
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
    page_connexion($message);
  }
?>
