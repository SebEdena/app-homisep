<html>
    <head>
        <meta charset="utf-8" />
        <link rel="stylesheet" href="./view/css/styleConnexion.css"/>
        <title>Bienvenue - Homisep</title>
    </head>

    <body>
        <h1 id="conn">Page de connexion</h1>
        <form action="index.php?control=connexionInitialisation&action=seConnecter" method="post">
          <div class="imgcontainer">
            <img src="./view/img/LogoAPP.png" alt="Homisep" class="avatar">
          </div>

          <div class="container">

            <label for="uname"><b>Identifiant</b></label>
            <form>
              <div class="radio-group">
                <input type="radio" id="option-one" name="selector" value="client" checked><label for="option-one">Client</label>
                <input type="radio" id="option-three" name="selector" value="admin" ><label for="option-three">Administrateur</label>
              </div>
            </form>
            <input type="text" placeholder="Entrez votre identifiant" name="uname" required>

            <label for="psw"><b>Mot de passe</b></label>
            <input type="password" placeholder="Entrez votre mot de passe" name="psw" required>

            <button type="submit">Se connecter</button>

            <span><a href="#" class="psw">Créer un nouvel utilisateur</a></span>
          </div>
        </form>
    </body>

    <footer class="footer">
        <p>&#9400; Homisep 2018, tous droits réservés.</p>
    </footer>
</html>
