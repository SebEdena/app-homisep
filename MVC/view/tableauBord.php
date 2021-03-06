<?php
    $title = "Espace utilisateur - Vue générale";
    $css = [
        "styleOnglet.css",
        "styleAccordion.css",
        "styleTableauBord.css"
    ];
    $js = [
        "onglet.js",
        "accordion.js",
        "tableauBord.js"
    ];
    $modals = null;
    $jsonpage = null;
?>
<?php ob_start(); ?>
    <h1>Tableau de bord</h1>
    <?php if(count($maisons) == 0){?>
            <div id="noMaison">
              <h1>Pas de Maisons</h1>
            </div>
    <?php }else{ ?>
    <div id="actions-content">
        <label for="house-select">Maison : </label>
        <select id="house-select">
            <?php foreach ($maisons as $maison) { ?>
                <option value="<?=$maison->getId()?>"><?= $maison->getAdresse()." - ".
                $maison->getVille()." - ".$maison->getCodePostal()?></option>
            <?php } ?>
        </select>
        <button id="save-tdb">Enregistrer les modifications</button>
    </div>
    <div class="tabcontainer">
        <div class="tablist">
            <a class="tablink defaultOpen" id="tablink-gen">Vue générale</a>
            <a class="tablink" id="tablink-lum">Luminosité</a>
            <a class="tablink" id="tablink-temp">Chauffage</a>
            <a class="tablink" id="tablink-shut">Volets</a>
        </div>
        <div class="tabcontent">
            <div class="tabpage" id="tabpage-gen">
            </div>
            <div class="tabpage" id="tabpage-lum">
            </div>
            <div class="tabpage" id="tabpage-temp">
            </div>
            <div class="tabpage" id="tabpage-shut">
            </div>
        </div>
    </div>
  <?php } ?>
<?php $content = ob_get_clean(); ?>
<?php require("./view/templateUtilisateur.php"); ?>
