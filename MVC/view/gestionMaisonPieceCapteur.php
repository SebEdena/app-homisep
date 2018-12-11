<!DOCTYPE html>
<?php
    $title = "Espace utilisateur - Vue générale";
    $css = [
        "styleOnglet.css",
        "styleMaisonPieceCapteur.css",
    ];
    $js = [
        "onglet.js",
        "accordion.js",
    ];
    $modals = null;
    $jsonpage = null;
?>
<?php ob_start(); ?>
	<div class="tabcontainer">
		<div class="tablist">
			<a class="tablink" id="defaultOpen">Coordonnées</a>
			<a class="tablink">Maison & Capteur</a>
		</div>
		<div class="tabcontent">
			<div class="tabpage">
				<h1>Coordonnées</h1>
				<p>N/A</p>
			</div>
			<div class="tabpage">
        <div class="label-left">
  				<label>Maison :</label>
          <select>
            <option></option>
            <option>Test maison 1</option>
          </select>
        </div>
        <div class="gridContainerMaisonPieceCapteur">
          <label class="header" id="headerPiece">Pièce</label>
          <div id="piece">
            Pièce
          </div>
          <label class="header" id="headerCapteur">Capteurs / Effecteurs</label>
          <div id="capteur">
            Capteurs
          </div>
          <label class="header" id="headerAjout">Ajout</label>
          <div id="ajout">
						<div class="tabcontainer">
							<div class="tablist">
								<a class="tablink" id="defaultOpen">Maison</a>
								<a class="tablink">Pièce</a>
								<a class="tablink">Capteur</a>
							</div>
							<div class="tabcontent">
								<div class="tabpage">
									<form action="index.php?control=relationClient&action=ajoutMaison" method="post">
                    <h1>Ajout Maison</h1>
                    <label for="adresse">Adresse :</label>
                    <input type="text" placeholder="Entrez l'adresse" name="adresse" required></input>
                    <label for="ville">Ville :</label>
                    <input type="text" placeholder="Entrez la ville" name="ville" required></input>
                    <label for="codePostal">Adresse :</label>
                    <input type="text" placeholder="Entrez l'adresse" name="codePostal" required></input>
                  </form>
								</div>
								<div class="tabpage">
									<h1>Piece</h1>
								</div>
								<div class="tabpage">
									<h1>Capteur</h1>
								</div>
							</div>
						</div>
          </div>
        </div>
			</div>
	<div class="boutonRight">
		<button>Annuler</button>
		<button>Modifier</button>
		<button>Valider</button>
	</div>
</div>
</div>
<?php $content = ob_get_clean(); ?>
<?php require("./view/templateUtilisateur.php"); ?>
