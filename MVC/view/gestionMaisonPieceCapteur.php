<!DOCTYPE html>
<?php
    $title = "Espace utilisateur - Vue générale";
    $css = [
        "styleOnglet.css",
        "styleMaisonPieceCapteur.css",
        "styleGCU.css"
    ];
    $js = [
        "onglet.js",
        "accordion.js",
        "gestionMaisonPieceCapteur.js"
    ];
    $modals = null;
    $jsonpage = null;
?>
<?php ob_start(); ?>
	<div class="tabcontainer">
		<div class="tablist">
			<a class="tablink defaultOpen" id="tabpage-Coordonnees">Coordonnées</a>
			<a class="tablink" id="tabpage-MaisonCapteur">Maison & Capteur</a>
		</div>
		<div class="tabcontent">
			<div class="tabpage" id="tabpage-Coordonnees">
        <div class="dataUser-container container1" >
          <h1 class="title">Connexion</h1>
          <form>
            <div class="row">
              <div class="col-1">
                <label for="lname">Nom</label>
              </div>
              <div class="col-2">
                <input type="text" id="lname" name="lastname" placeholder="Nom">
              </div>
              <div class="col-3">
                <label for="fname">Prénom</label>
              </div>
              <div class="col-4">
                <input type="text" id="fname" name="firstname" placeholder="Prénom">
              </div>

            </div>
            <div class="row">
              <div class="col-1">
                <label for="eMail">eMail</label>
              </div>
              <div class="email">
                <input type="text" id="mail" name="eMail" placeholder="eMail">
              </div>
            </div>

            <div class="row">
              <div class="col-1">
                <label for="date">Date de Naissance</label>
              </div>
              <div class="col-2">
                <input type="date" id="bdate" name="date" placeholder="Date de Naissance">
              </div>
              <div class="col-3">
                <label for="ntel">Numéro de tel</label>
              </div>
              <div class="col-4">
                <input type="Number" id="numtel" name="tel" placeholder="Numéro de tel">
              </div>
            </div>
            <div class="row">
              <button class="bouton1" type="reset">Annuler</button>
              <button class="bouton1" type="submit">Valider</button>
            </div>
          </div>


          <div class="dataUser-container container2">
            <h1 class="title">Changer le Mot de Passe</h1>
            <form onsubmit="vaildate(event);">
                <label class="entry" for="currentpsw">Ancien Mot de Passe</label>
                <input  type="text" id="cpsw" name="currentpsw" placeholder="Ancien Mot de Passe">
                <label class="entry" for="newpsw">Nouveau Mot de Passe</label>
                <input  type="text" id="pass" name="npsw" placeholder="Nouveau Mot de Passe">
                <label class="entry" for="newpsw">Nouveau Mot de Passe</label>
                <input  type="text" id="confirm_pass" name="confirm_psw" placeholder="Ancien Mot de Passe">
                <button class="bouton3" type="submit">Valider</button>
            </form>
          </div>

          <div class="dataUser-container container3">
            <h1 class="title">Demandes</h1>
            <form onsubmit="vaildate(event);">
              <button class="bouton2">Changement de coordonnées sensibles</button>
              <button class="bouton2">Ajout de maison</button>
              <button class="bouton2">Suppression de maison</button>
              <button class="bouton2">Suppression de compte</button>
            </form>
          </div>
        </div>
        <div class="tabpage" id="tabpage-MaisonCapteur">
          <div class="label-left">
			      <label for="house-select-gestion">Maison :</label>
            <?php if(count($maisons) == 0){?><h1>Pas de maison enregistrée</h1><?php }
            else {
            ?>
            <select id="house-select-gestion">
            <?php foreach ($maisons as $maison) { ?>
                <option value="<?=$maison->getId()?>"><?= $maison->getAdresse()." - ".
                $maison->getVille()." - ".$maison->getCodePostal()?></option>
            <?php } ?>
            </select>
          <?php } ?>
          </div>
          <div class="gridContainerMaisonPieceCapteur">
            <label class="header" id="headerPiece">Pièce</label>
            <div id="piece">
            </div>
            <label class="header" id="headerCemac">Cemacs</label>
            <div id="cemac">
            </div>
            <label class="header" id="headerInformation">Information</label>
            <div id="information">
			        <div class="tabcontainer">
			         <div class="tablist">
								<a class="tablink defaultOpen" id="tabpage-Maison">Maison</a>
								<a class="tablink" id="tabpage-Piece">Pièce</a>
								<a class="tablink" id="tabpage-Cemac">Cemacs</a>
	            </div>
							<div class="tabcontent">
								<div class="tabpage" id="tabpage-Maison">
									<form class="ajoutFormulaire" id="maisonForm" action="" method="post">
                    <input type="text" class="hiddenId" id="maisonId" name="idMaison">
                    <label for="adresse">Adresse :</label>
                    <input type="text" id="maisonAdresse" placeholder="Entrez l'adresse" name="adresse" value="">
                    <label for="ville">Ville :</label>
                    <input type="text" id="maisonVille" placeholder="Entrez la ville" name="ville" value="">
                    <label for="codePostal">CodePostal :</label>
                    <input type="text" id="maisonCodePostal" placeholder="Entrez le code postal" name="codePostal" value="">
                    <div class="boutonRight">
                      <button type="button" onclick="backFunction('maison')">Annuler</button>
                      <button type="button" onclick="deleteFunction('maison')">Nouveau</button>
                      <button type="button" onclick="validateFunction('maison')">Valider</button>
                  	</div>
                  </form>
								</div>
								<div class="tabpage" id="tabpage-Piece">
                  <form class="ajoutFormulaire" id="pieceForm" action="" method="post">
                    <input type="text" class="hiddenId" id="pieceId" name="idPiece">
                    <label for="pieceNom">Nom :</label>
                    <input type="text" id="pieceNom" placeholder="Entrez le nom" name="nomPiece" value="">
                    <label for="pieceMaison">Adresse de la maison :</label>
                    <input type="text" id="pieceMaison" placeholder="Entrez l'adresse de la maison" name="pieceMaison" value="">
                    <div class="boutonRight">
                      <button type="button" onclick="backFunction('piece')">Annuler</button>
                      <button type="button" onclick="deleteFunction('piece')">Nouveau</button>
                      <button type="button" onclick="validateFunction('piece')">Valider</button>
                  	</div>
                  </form>
								</div>
								<div class="tabpage" id="tabpage-Cemac">
                  <form class="ajoutFormulaire" id="CemacForm" action="" method="post">
                    <input type="text" class="hiddenId" id="cemacId" name="idCemac">
                    <label for="numSerieCemac">Numéro de série :</label>
                    <input type="text" id="numSerieCemac" placeholder="Entrez le numéro" name="numSerieCemac" value="">
                    <label for="statusCapteur">Statut : </label>
                    <input type="text" id="statusCemac" placeholder="statusCemac" name="statusCemac" value="">
                    <label for="typeCemac">Type Cemac : </label>
                    <input type="text" id="typeCemac" placeholder="Entrez le type de Cemac" name="typeCemac" value="">
                    <label for="property">Propriété : </label>
                    <input type="text" id="property" placeholder="Entrez le type" name="property" value="">
                    <label for="pieceCemac">Piece : </label>
                    <input type="text" id="pieceCemac" placeholder="Entrez le nom d'une pièce" name="pieceCemac" value="">
                    <div class="boutonRight">
                      <button type="button" onclick="backFunction('cemac')">Annuler</button>
                      <button type="button" onclick="deleteFunction('cemac')">Nouveau</button>
                      <button type="button" onclick="validateFunction('cemac')">Valider</button>
                  	</div>
                  </form>
								</div>
							</div>
						</div>
          </div>
        </div>
			</div>
    </div>
  </div>
<?php $content = ob_get_clean(); ?>
<?php require("./view/templateUtilisateur.php"); ?>
