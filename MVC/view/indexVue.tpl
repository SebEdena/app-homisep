<html>
<head>
  <meta charset="utf-8" />
  <link rel="stylesheet" href="./view/css/styleModalInscription.css" />
  <link rel="stylesheet" href="./view/css/styleModal.css" />
  <link rel="stylesheet" href="./view/css/styleConnexion.css" />
  <script src="./view/js/confMDPmodal.js"></script>
  <title>Bienvenue - Homisep</title>
</head>

<body>
  <h1 id="conn">Page de connexion</h1>
  <form action="index.php?control=connexionInitialisation&action=seConnecter" method="post">
    <div class="imgcontainer">
      <img src="./view/img/LogoAPP.png" alt="Homisep" class="avatar">
    </div>

    <div class="container">

      <label for="uname"><b>Identifiant</b></label><form>
        <div class="radio-group">
          <input type="radio" id="option-one" name="selector" value="client" checked><label for="option-one">Client</label>
          <input type="radio" id="option-three" name="selector" value="admin"><label for="option-three">Administrateur</label>
        </div>
      </form>
      <input type="text" placeholder="Entrez votre identifiant" name="uname" required>

      <label for="psw"><b>Mot de passe</b></label>
      <input type="password" placeholder="Entrez votre mot de passe" name="psw" required>

      <button type="submit">Se connecter</button>

      <span ><a href="#" id="modalBtn">Créer un nouvel utilisateur</a></span>
    </div>

  </form>

  <div class="modal-bg">
    <div class="modal" id="Modal1">
      <div class="modal-head">
        <span class="modal-close">&times;</span>
        <h1>Formulaire d'inscription</h1>
      </div>
      <div class="modal-body">
        <div class="module">
          <form name="inscr" class="form" action="index.php?control=connexionInitialisation&action=inscriptionClient">
            <label>Adresse email</label><input type="email" placeholder="Entrez votre adresse mail" class="textbox" required/>
            <label>Mot de passe</label><input type="password" placeholder="Entrez votre mot de passe" class="textbox" id="pass" required/>
            <input type="password" placeholder="Confirmez votre mot de passe" class="textbox" id="confirm_pass" required/>
            <input type="submit" value="S'enregistrer" class="button" onclick="validate();"/>
          </form>
        </div>
      </div>
    </div>
  </div>

</body>

<footer class="footer">
  <p>&#9400; Homisep 2018, tous droits réservés.</p>
</footer>

<script>
  document.querySelector('#modalBtn').onclick = function(){
    displayModal("#Modal1");
  };
</script>
<script src="./view/js/modal.js"></script>

</html>
