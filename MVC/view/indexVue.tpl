<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8" />
  <link rel="icon" type="image/png" href="./view/img/LogoAPP.png"/>
  <link rel="stylesheet" href="./view/css/basic_rules.css" />
  <link rel="stylesheet" href="./view/css/styleModal.css"/>
  <link rel="stylesheet" href="./view/css/styleConnexion.css"/>
  <link rel="stylesheet" href="./view/css/styleFooter.css"/>
  <script src="./view/js/confMDPmodal.js"></script>
  <script src="./view/js/jquery-3.3.1.min.js"></script>
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
        <a id="reset_mdp_link">Mot de passe oublié?</a>

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
            <span id="cgu">J'ai lu et j'accepte les <a href="#" id="contactCGU">CGU</a>  et la <a href="#" id="contactPolitique">politique de confidentialité</a></span></label>
        <button type="submit">S'enregistrer</button>
      </div>

    </form>
  </div>
  <div class="modal-bg">
      <div class="modal" id="modalresetmdp">
          <div class="modal-head">
              <span class="modal-close">&times;</span>
              <h2>Réinitialisation de mot de passe</h2>
          </div>
          <div class="modal-body">
            <form id="modal" action="index.php?control=connexionInitialisation&action=resetmdp" method="post">
              <label for="mailResetMdp">Saisissez votre adresse mail</label>
              <input id="mailResetMdp" type="email" name="mailResetMdp"></input>
              <button type="submit">Valider</button>
            </form>
          </div>
      </div>
      <div class="modal" id="modalCGU">
          <div class="modal-head">
              <span class="modal-close">&times;</span>
              <h1>CGU</h1>
          </div>
          <div class="modal-body">
            <div class="container">
              <div id="contentCGU">
                <?php if(isset($cgu)){echo($cgu[0]['texteRegle']);} ?>
              </div>
            </div>
          </div>
      </div>
      <div class="modal" id="modalPolitique">
          <div class="modal-head">
              <span class="modal-close">&times;</span>
              <h1>Politique confidentialité</h1>
          </div>
          <div class="modal-body">
            <div class="container">
              <?php if(isset($politique)){print_r($politique[0]['texteRegle']);} ?>
            </div>
          </div>
      </div>
    </div>
</body>
<br/>
<footer>
  <p>&#9400; 2018, Homisep un produit Domisep, tous droits réservés.</p>
</footer>
  <script src="./view/js/modal.js"></script>
  <script src="./view/js/cgu.js"></script>
  <script src="./view/js/connexion.js"></script>
</html>
