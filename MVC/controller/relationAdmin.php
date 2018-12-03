<?php
  function afficheDonneesClients()
  {
    require("./model/donneesClient.php");
    $clients = getClients();
    require("./view/consultationDonneesClient.php");
  }
?>
