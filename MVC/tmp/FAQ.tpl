<html>
    <head>
        <meta charset="utf-8" />
        <link rel="stylesheet" href="./view/css/basic_rules.css" />
        <link rel="stylesheet" href="./view/css/styleMenuUtil.css" />
        <link rel="stylesheet" href="./view/css/styleFAQ.css" />
	      <link rel="stylesheet" href="./view/css/styleFooter.css" />

        <title>Espace client - Homisep</title>
    </head>

    <body>

		<ul>
		  <li class ="logo"><img src="./view/img/LogoAPP.png" alt="Homisep" class="avatar"></a></li>
		  <li><a href="#home">Tableau de bord</a></li>
		  <li><a href="#account">Mon compte</a></li>
		  <li><a href="#contact">F.A.Q</a></li>
		  <li class="logout"><a class="active" href="index.php?control=relationClient&action=deconnexion"><img src="./view/img/power_icon.png" class="logout_img">  Déconnexion</a></li>
		  <li class="logoutQuery"><a class="active" href="index.php?control=relationClient&action=deconnexion"><img src="./view/img/power_icon.png" class="logoutQuery_img"></a></li>
		</ul>

		<h1 class="titre">Foire aux questions</h1>
		<button class="contactbutton"> Nous contacter </button>

		<section class="faq-section">
			<input type="checkbox" id="q1">
			<label for="q1">Comment déclarer une panne ?</label>
			<p>Pour déclarer une panne, il faut contacter le support pour cela veuillez suivre les étapes suivantes :</p>
			<p>1. Cliquez sur le bouton "Nous contacter" ci-dessus.</br>2. Remplissez les champs avec des informations précises.
			</br>3. Un technicien prendra en charge votre requête sous 24H !</p>
		</section>
		<section class="faq-section">
			<input type="checkbox" id="q2">
			<label for="q2">Comment suivre l'évolution des relevés de sa maison ?</label>
			<p>Homisep vous propose de suivre en temps réel les valeurs relevés par tous vos capteurs...</p>
			<p>Un historique des relevés est disponible dans les paramètres de visualisation dans le tableau de bord. Il existe plusieurs sortes d'historique :
			<br/>1. Un historique par pièce pour suivre l'évolution de sa maison de façon plus précise<br/>2. Un historique général par thème (température, luminosité...) pour suivre l'évolution de sa maison.
			<br/>3. Et enfin un historique unique à chaque capteur..</p>
		</section>
		<section class="faq-section">
			<input type="checkbox" id="q3">
			<label for="q3">Ceci est une question test ?</label>
			<p>... Le début de la réponse test test...</p>
			<p>... Suite de la réponse et paragraphes optionnels test test...</p>
		</section>
		<section class="faq-section">
			<input type="checkbox" id="q4">
			<label for="q4">Question ?</label>
			<p>... Le début de la réponse ...</p>
			<p>... Suite de la réponse et paragraphes optionnels ...</p>
		</section>
		<section class="faq-section">
			<input type="checkbox" id="q5">
			<label for="q5">Question ?</label>
			<p>... Le début de la réponse ...</p>
			<p>... Suite de la réponse et paragraphes optionnels ...</p>
		</section>

    </body>

    <br/><footer class="footer">
        <p>&#9400; Homisep 2018, tous droits réservés.</p>
    </footer>
</html>
