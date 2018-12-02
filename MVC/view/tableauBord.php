<?php
    $title = "Espace utilisateur - Vue générale";
    $css = [
        "styleOnglet.css",
        "styleTableauBord.css"
    ];
    $js = [
        "onglet.js"
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
            <a class="tablink" id="defaultOpen">Vue générale</a>
            <a class="tablink">Luminosité</a>
            <a class="tablink">Chauffage</a>
            <a class="tablink">Volets</a>
        </div>
        <div class="tabcontent">
            <div class="tabpage">
                <h1>London</h1>
                <p>London is the capital city of England.</p>
            </div>
            <div class="tabpage">
                <h1>Paris</h1>
                <p>Paris is the capital of France.</p>
            </div>
            <div class="tabpage">
                <h1>Tokyo</h1>
                <p>Tokyo is the capital of Japan.</p>
            </div>
            <div class="tabpage">
                <h1>Oslo</h1>
                <p>Oslo is the capital of Norway.</p>
            </div>
        </div>
    </div>
<?php $content = ob_get_clean(); ?>
<?php require("./view/templateUtilisateur.php"); ?>
