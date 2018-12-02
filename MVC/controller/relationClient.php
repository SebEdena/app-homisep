<?php
  function afficherFAQ()
  {
      require("./view/FAQ.php");
  }

  function afficheTableauBord(){
      require("./model/tableau_bord.php");
      $maisons = getMaisons();
      require("./view/tableauBord.php");
  }
?>
