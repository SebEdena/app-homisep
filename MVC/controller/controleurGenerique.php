<?php
  /**
   * contrôleur permettant de rediriger vers le bon contrôleur pour la vue d'accueil
   */
  function afficherAccueil()
  {
    if($_SESSION['admin'] == true)
    {
      header("Location: " . "index.php?control=relationAdmin&action=afficheDonneesClients");
    }
    else
    {
      header("Location: " . "index.php?control=relationClient&action=initControllerBD");
    }
  }
  
  /**
   * contrôleur permettant la déconnexion d'un utilisateur
   */
  function deconnexion()
  {
    session_destroy();
    require('./controller/connexionInitialisation.php');
    page_connexion("Vous vous êtes déconnectés");
  }
?>
