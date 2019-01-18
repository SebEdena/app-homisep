<?php
$title = "Espace administrateur - Messagerie";
$css = [
  "consultationDonnees.css",
  "styleMessagerie.css",
  "styleModal.css",
  "styleContact.css"
];
$js = [
  "modal.js"
];
$modals = null;
$jsonpage = null;
?>
<?php ob_start(); ?>

<h1 class="titre">Messagerie</h1>

<div>
  <table>
    <tr>
      <th>Prénom</th>
      <th>Nom</th>
      <th>Adresse mail</th>
      <th>Objet</th>
      <th>Demande</th>
      <th>Répondre</th>
    </tr>
    <?php foreach ($demandes as $message) {
      $client = getClientDem($message->getIdClient()); ?>
      <tr>
        <td><?= $client->getPrenom();?></td>
        <td><?= $client->getNom();?></td>
        <td><?= $client->getMail();?></td>
        <td><?= $message->getObjet();?></td>
        <td><?= $message->getTexte();?></td>
        <td>
        <?php if($message->getIdAdministrateur() == null){ ?>
          <button class="messagerie attendu" onclick="formMail('<?= addslashes($message->getObjet())?>','<?= addslashes($message->getTexte())?>','<?= addslashes($client->getMail())?>','<?= addslashes($client->getNom())?>','<?= addslashes($client->getPrenom())?>');">Répondre</button></td>
        <?php } else { ?>
          <button class="messagerie repondu" disabled>Répondu</button></td>
        <?php } ?>
      </tr>
    <?php } ?>
  </table>
</div>

<?php $content = ob_get_clean(); ?>
<?php require("./view/templateAdmin.php"); ?>
