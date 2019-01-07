<?php
  function afficheDonneesClients()
  {
    require("./model/donneesClient.php");
    $clients = getClients();
    require("./view/consultationDonneesClient.php");
  }

  function afficheMessagerie()
  {
    require("./model/demandesClient.php");
    $demandes = getDemandes();
    require("./view/Messagerie.php");
  }
?>
