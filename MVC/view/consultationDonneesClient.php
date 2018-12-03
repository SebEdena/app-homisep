<?php
    $title = "Espace administrateur - Données client";
    $css = [
        "styleModal.css"
    ];
    $js = [
        "modal.js"
    ];
    $modals = '
        <div class="modal-bg">
            <div class="modal" id="Modal1">
                <div class="modal-head">
                    <span class="modal-close">&times;</span>
                    <h2>Contact</h2>
                </div>
                <div class="modal-body">
                    <p>Bonjour</p>
                </div>
            </div>
        </div>
    ';
    $jsonpage = '
        document.querySelector("#modalBtn").onclick = function(){
            displayModal("#Modal1");
        };
    ';
?>
<?php ob_start(); ?>
    <h1>Données Client</h1>
    <div id="content">
      <form>
        <label>Liste des Clients : </label>
        <input input type="text" placeholder="Entrez un nom, ou un prénom" name="nameClient"></imput>
        <button type="submit">Rechercher</button>
      </form>
      <form>
        <button>Nouveau Client</button>
      </form>
      <div>
        <table>
          <tr>
            <th>N°Client</th>
            <th>Email</th>
            <th>Nom</th>
            <th>Prénom</th>
            <th>Adresse</th>
          </tr>
          <?php foreach ($clients as $client) { ?>
              <td><?= $client->getId();?></td>
              <td><?= $client->getMail();?></td>
              <td><?= $client->getNom();?></td>
              <td><?= $client->getPrenom();?></td>
              <td><?= $client->getAdresse();?></td>
          <?php } ?>

        </table>
      </div>
    </div>
<?php $content = ob_get_clean(); ?>
<?php require("./view/templateAdmin.php"); ?>
