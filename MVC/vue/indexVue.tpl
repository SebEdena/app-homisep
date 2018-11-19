<html>
    <head>
        <meta charset="utf-8" />
        <link rel="stylesheet" href="./vue/css/styleConnexion.css"/>
        <title>Bienvenue - Homisep</title>
    </head>

    <body>
        <h1 id="conn">Page de connexion</h1>
        <form action="action_page.php">
          <div class="imgcontainer">
            <img src="img/LogoAPP.png" alt="Homisep" class="avatar">
          </div>

          <div class="container">

            <label for="uname"><b>Identifiant</b></label><form>
              <div class="radio-group">
                <input type="radio" id="option-one" name="selector" checked><label for="option-one">Client</label>
                <input type="radio" id="option-three" name="selector"><label for="option-three">Administrateur</label>
              </div>
            </form>
            <input type="text" placeholder="Entrez votre identifiant" name="uname" required>

            <label for="psw"><b>Mot de passe</b></label>
            <input type="password" placeholder="Entrez votre mot de passe" name="psw" required>

            <button type="submit">Se connecter</button>

            <span ><a href="#" class="psw">Créer un nouvel utilisateur</a></span>
          </div>

        </form>
    </body>

    <footer class="footer">
        <p>&#9400; Homisep 2018, tous droits réservés.</p>
    </footer>
</html>
