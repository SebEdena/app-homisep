<html>
<head>
  <meta charset="utf-8" />
  <link rel="stylesheet" href="./view/css/basic_rules.css" />
  <link rel="stylesheet" href="./view/css/styleModal.css"/>
  <link rel="stylesheet" href="./view/css/styleConnexion.css"/>
  <link rel="stylesheet" href="./view/css/styleFooter.css"/>
  <script src="./view/js/confMDPmodal.js"></script>
  <title>Bienvenue - Homisep</title>
</head>

<body>
  <ul id="menu">
    <h1 id="conn">Bienvenue</h1>
    <img src="./view/img/LogoAPP_short.png" alt="Homisep" class="avatar">
  </ul>
  <div class="page">
    <form action="index.php?control=connexionInitialisation&action=seConnecter" method="post" onsubmit="validate(event);">
      <h1>Connexion</h1>
      <div class="container">

        <label for="uname"><b>Identifiant</b></label>
        <input type="text" placeholder="Entrez votre identifiant" name="uname" required>

        <label for="psw"><b>Mot de passe</b></label>
        <input type="password" placeholder="Entrez votre mot de passe" name="psw" required>

        <button type="submit">Se connecter</button>
          <p id="status_msg">
              <?php if(isset($message)) echo($message); ?>
          </p>
      </div>

    </form>

    <form class="inscri" action="index.php?control=connexionInitialisation&action=inscriptionClient" method="post" onsubmit="validate(event);">
      <h1>Formulaire d'inscription</h1>
      <div class="container">

        <label>Numéro de CeMAC</label>
        <input type="number" placeholder="Entrez votre numéro de CeMAC acquis" name="num" required/>
        <label>Adresse email</label>
        <input type="email" placeholder="Entrez votre adresse mail" name="email" required/>
        <label>Mot de passe</label>
        <input type="password" placeholder="Entrez votre mot de passe" class="textbox" id="pass" name="pass"
        pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="Doit contenir au moins un nombre, une minuscule, une majuscule et au moins 8 caractères ou plus."required/>
        <input type="password" placeholder="Confirmez votre mot de passe" class="textbox" id="confirm_pass" required/>
        <input class="inp-cbx" id="cbx" type="checkbox" style="display: none;"/>
        <label class="cbx" for="cbx"><span>
            <svg width="12px" height="10px" viewbox="0 0 12 10">
              <polyline points="1.5 6 4.5 9 10.5 1"></polyline>
            </svg></span>
            <span id="cgu">J'ai lu et j'accepte les <a href="#">CGU</a> et la <a href="#">politique de confidentialité</a></span></label>
        <button type="submit">S'enregistrer</button>
      </div>

    </form>
  </div>

</body>

<footer class="footer">
  <p>&#9400; Homisep 2018, tous droits réservés.</p>
</footer>


<script src="./view/js/modal.js"></script>

</html>
