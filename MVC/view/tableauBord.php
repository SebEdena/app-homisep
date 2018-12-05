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
    <label for="house-select">Maison : </label>
    <select id="house-select">
        <?php foreach ($maisons as $maison) { ?>
            <option value="<?=$maison->getId()?>"><?= $maison->getAdresse()." - ".
            $maison->getVille()." - ".$maison->getCodePostal()?></option>
        <?php } ?>
    </select>
    <div class="tabcontainer">
        <div class="tablist">
            <a class="tablink defaultOpen" id="gen-tab">Vue générale</a>
            <a class="tablink" id="gen-lux">Luminosité</a>
            <a class="tablink" id="gen-heat">Chauffage</a>
            <a class="tablink" id="gen-shut">Volets</a>
        </div>
        <div class="tabcontent">
            <div class="tabpage">
            </div>
            <div class="tabpage">
            </div>
            <div class="tabpage">
            </div>
            <div class="tabpage">
            </div>
        </div>
    </div>
<?php $content = ob_get_clean(); ?>
<?php require("./view/templateUtilisateur.php"); ?>
