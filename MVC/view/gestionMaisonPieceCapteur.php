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
				<h1>Coordonnées</h1>
				<p>N/A</p>
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
          <label class="header" id="headerCapteur">Capteurs / Effecteurs</label>
          <div id="capteur">
          </div>
          <label class="header" id="headerInformation">Information</label>
          <div id="information">
						<div class="tabcontainer">
							<div class="tablist">
								<a class="tablink defaultOpen" id="tabpage-Maison">Maison</a>
								<a class="tablink" id="tabpage-Piece">Pièce</a>
								<a class="tablink" id="tabpage-Capteur">Capteur</a>
							</div>
							<div class="tabcontent">
								<div class="tabpage" id="tabpage-Maison">
									<form class="ajoutFormulaire" id="maisonForm" action="" method="post">
                    <label for="adresse">Adresse :</label>
                    <input type="text" id="maisonAdresse" placeholder="Entrez l'adresse" name="adresse" value="">
                    <label for="ville">Ville :</label>
                    <input type="text" id="maisonVille" placeholder="Entrez la ville" name="ville" value="">
                    <label for="codePostal">Adresse :</label>
                    <input type="text" id="maisonCodePostal" placeholder="Entrez le code postal" name="codePostal" value="">
                    <div class="boutonRight">
                      <button>Annuler</button>
                      <button>Modifier</button>
                      <button>Valider</button>
                  	</div>
                  </form>
								</div>
								<div class="tabpage" id="tabpage-Piece">
                  <form class="ajoutFormulaire" id="pieceForm" action="" method="post">
                    <label for="adresse">Nom :</label>
                    <input type="text" id="pieceNom" placeholder="Entrez le nom" name="nomPiece" value="">
                    <div class="boutonRight">
                      <button>Annuler</button>
                      <button>Modifier</button>
                      <button>Valider</button>
                  	</div>
                  </form>
								</div>
								<div class="tabpage" id="tabpage-Capteur">
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
