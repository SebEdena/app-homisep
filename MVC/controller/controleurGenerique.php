<?php
  function afficherAccueil()
  {
    if($_SESSION['admin'] == true)
    {
      header("Location: " . "index.php?control=relationAdmin&action=afficheDonneesClients");
    }
    else
    {
      header("Location: " . "index.php?control=relationClient&action=afficheTableauBord");
    }
  }

  function deconnexion()
  {
    session_destroy();
    require('./controller/connexionInitialisation.php');
    page_connexion("Vous vous êtes déconnectés");
  }
?>
