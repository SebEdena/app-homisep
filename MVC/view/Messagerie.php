<?php
$title = "Espace administrateur - Messagerie";
$css = [
  "styleMessagerie.css"
];
$js = [];
$modals = null;
$jsonpage = null;
?>
<?php ob_start(); ?>

<h1 class="titre">Messagerie</h1>

<div>
    <?php foreach ($demandes as $message) {
        foreach (getClientDem($message->getId()) as $client) {
          echo $client->getPrenom();
          echo $client->getNom();
          echo $client->getMail();
          echo $message->getObjet();
          echo $message->getTexte();
        }
      }
      ?>
</div>

<?php $content = ob_get_clean(); ?>
<?php require("./view/templateAdmin.php"); ?>
