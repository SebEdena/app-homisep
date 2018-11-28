<html>
    <head>
        <meta charset="utf-8" />
        <link rel="icon" type="image/png" href="./view/img/LogoAPP.png" />
        <link rel="stylesheet" href="./view/css/basic_rules.css" />
        <link rel="stylesheet" href="./view/css/styleMenuAdmin.css" />
	    <link rel="stylesheet" href="./view/css/styleFooter.css" />
        <?php foreach ($css as $value) { ?>
            <link rel="stylesheet" href="./view/css/<?= $value ?>" />
        <?php } ?>
        <title><?= $title ?></title>
    </head>

    <body>

		<ul id="#menu">
		  <li class ="logo"><img src="./view/img/LogoAPP_short.png" alt="Homisep" class="avatar"></li>
		  <li><a href="#home">Données</a></li>
		  <li><a href="#account">Messagerie</a></li>
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

    <br/><footer class="footer">
        <p>&#9400; Homisep 2018, tous droits réservés.</p>
    </footer>
    <?php if(isset($modals)) { ?>
      <?= $modals ?>
    <?php } ?>
    <script src="./view/js/jquery-3.3.1.min.js"></script>
    <script src="./view/js/logo.js"></script>
    <?php foreach ($js as $value) { ?>
      <script src="./view/js/<?= $value ?>" /></script>
    <?php } ?>
    <?php if(isset($jsonpage)) { ?>
      <script><?= $jsonpage ?></script>
    <?php } ?>
</html>
