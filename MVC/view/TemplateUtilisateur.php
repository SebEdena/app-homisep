<html>
    <head>
        <meta charset="utf-8" />
        <link rel="stylesheet" href="./view/css/basic_rules.css" />
        <link rel="stylesheet" href="./view/css/styleMenuUtil.css" />
	    <link rel="stylesheet" href="./view/css/styleFooter.css" />
        <?php foreach ($css as $value) { ?>
    	    <link rel="stylesheet" href="./view/css/<?= $value ?>" />
        <?php } ?>
        <title><?= $title ?></title>
    </head>

    <body>

		<ul id="menu">
		  <li class="logo"><img src="./view/img/LogoAPP.png" alt="Homisep" class="avatar"></li>
		  <li><a href="#home">Tableau de bord</a></li>
		  <li><a href="#account">Mon compte</a></li>
		  <li><a href="index.php?control=relationClient&action=afficherFAQ">F.A.Q</a></li>
		  <li class="logout"><a class="active" href="index.php?control=relationClient&action=deconnexion"><img src="./view/img/power_icon.png" class="logout_img">  Déconnexion</a></li>
		  <li class="logoutQuery"><a class="active" href="#indexUtilisateur"><img src="./view/img/power_icon.png" class="logoutQuery_img"></a></li>
		</ul>

        <?= $content ?>

    </body>

    <br/><footer class="footer">
        <p>&#9400; Homisep 2018, tous droits réservés.</p>
    </footer>
    <?php if(isset($modals)) { ?>
        <?= $modals ?>
    <?php } ?>
    <?php foreach ($js as $value) { ?>
        <script src="./view/js/<?= $value ?>" /></script>
    <?php } ?>
    <script><?= $jsonpage ?></script>
</html>
