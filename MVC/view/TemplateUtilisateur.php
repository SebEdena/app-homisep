<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <link rel="icon" type="image/png" href="./view/img/LogoAPP.png" />
    <link rel="stylesheet" href="./view/css/basic_rules.css" />
    <link rel="stylesheet" href="./view/css/styleMenuUtil.css" />
    <link rel="stylesheet" href="./view/css/styleModal.css" />
    <link rel="stylesheet" href="./view/css/styleContact.css" />
    <link rel="stylesheet" href="./view/css/styleFooter.css" />
    <?php foreach ($css as $value) { ?>
        <link rel="stylesheet" href="./view/css/<?= $value ?>" />
    <?php } ?>
    <title><?= $title ?></title>
</head>

<body>

    <ul id="menu">
        <li class="logo"><img src="./view/img/LogoAPP_short.png" alt="Homisep" class="avatar"></li>
        <li><a href="index.php?control=relationClient&action=afficheTableauBord">Tableau de bord</a></li>
        <li><a href="index.php?control=relationClient&action=afficheGestionCompte">Mon compte</a></li>
        <li><a href="index.php?control=relationClient&action=afficherFAQ">F.A.Q.</a></li>
        <li class="logout">
            <a href="index.php?control=controleurGenerique&action=deconnexion">
                <img src="./view/img/power_icon.png"></img>
                <div>Déconnexion</div>
            </a>
        </li>
    </ul>

    <div id="content">
        <?= $content ?>
    </div>

</body>

<br/>
<footer>
    <p>&#9400; 2018, Homisep un produit Domisep, tous droits réservés.</p>
</footer>

<div class="modal-bg">
    <div class="modal" id="modalcontact">
        <div class="modal-head">
            <span class="modal-close">&times;</span>
            <h1>Contact</h1>
        </div>
        <div class="modal-body">
          <form class="contact" action="#" method="post" onsubmit="contactReceived();">
            <div class="container">

              <label for="object" class="object"><b>Objet</b></label>
              <input id="object" type="text" placeholder="Entrez le sujet de votre demande" name="object" required>
              </br>
              <label for="message" class="message"><b>Demande</b></label>
              <textarea id="msg" placeholder="Entrez votre message" name="message" required></textarea>

              <button type="submit">Envoyer</button>
            </div>
          </form>
        </div>
    </div>
  </div>
<?php if(isset($modals)) { ?>
    <?= $modals ?>
<?php } ?>
<script src="./view/js/jquery-3.3.1.min.js"></script>
<script src="./view/js/logo.js"></script>
<script src="./view/js/modal.js"></script>
<?php foreach ($js as $value) { ?>
    <script src="./view/js/<?= $value ?>" /></script>
<?php } ?>
<?php if(isset($jsonpage)) { ?>
    <script><?= $jsonpage ?></script>
<?php } ?>
</html>
