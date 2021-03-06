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
                <h1 class="title">Données Client</h1>
                <form action="index.php?control=relationClient&action=actualiserDonneesClient" method="post">
                    <div class="row">
                        <div class="col-1">
                            <label for="lname">Nom</label>
                        </div>
                        <div class="col-2">
                            <input type="text" id="lname" name="lastname" placeholder="Nom"<?php if(null!==($donnees->getNom())){?>value="<?php echo $donnees->getNom()?><?php } ?>">
                        </div>
                        <div class="col-3">
                            <label for="fname">Prénom</label>
                        </div>
                        <div class="col-4">
                            <input type="text" id="fname" name="firstname" placeholder="Prénom"<?php if(null!==($donnees->getPrenom())){?>value="<?php echo $donnees->getPrenom()?><?php } ?>">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-1">
                            <label for="date">Date de Naissance</label>
                        </div>
                        <div class="col-2">
                            <input type="date" id="bdate" name="bdate" placeholder="Date de Naissance"<?php if(null!==($donnees->getDateNaissance())){?>value="<?php echo $donnees->getDateNaissance()?><?php } ?>">
                        </div>
                        <div class="col-3">
                            <label for="eMail">eMail</label>
                        </div>
                        <div class="col-4">
                            <input type="text" id="mail" name="email" placeholder="eMail"<?php if(null!==($donnees->getMail())){?>value="<?php echo $donnees->getMail()?><?php } ?>" disabled>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-1">
                            <label for="adress">Adresse principale</label>
                        </div>
                        <div class="col-2">
                            <input type="text" id="adress" name="adress" placeholder="Adresse"<?php if(null!==($donnees->getAdresse())){?>value="<?php echo $donnees->getAdresse()?><?php } ?>">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-1">
                            <label for="ville">Ville</label>
                        </div>
                        <div class="col-2">
                            <input type="text" id="ville" name="ville" placeholder="Ville"<?php if(null!==($donnees->getVille())){?>value="<?php echo $donnees->getVille()?><?php } ?>">
                        </div>
                        <div class="col-3">
                            <label for="postal">Code Postal</label>
                        </div>
                        <div class="col-4">
                            <input type="text" id="postal" name="postal" placeholder="Code Postal"<?php if(null!==($donnees->getCodePostal())){?>value="<?php echo $donnees->getCodePostal()?><?php } ?>">
                        </div>
                    </div>

                    <div class="row">
                        <button class="bouton1" type="submit">Valider</button>
                        <button class="bouton1" type="reset">Annuler</button>
                    </div>
                </div>



                <div class="dataUser-container container2">
                    <h1 class="title">Changer le Mot de Passe</h1>
                    <form onsubmit="vaildate(event);">
                        <label class="entry" for="currentpsw">Ancien Mot de Passe</label>
                        <input  type="text" id="cpsw" name="currentpsw" placeholder="Ancien mot de passe"> <br/>
                        <label class="entry" for="newpsw">Nouveau Mot de Passe</label>
                        <input  type="text" id="pass" name="npsw" placeholder="Nouveau mot de passe"> <br/>
                        <label class="entry" for="newpsw">Nouveau Mot de Passe</label>
                        <input  type="text" id="confirm_pass" name="confirm_psw" placeholder="Confirmer le nouveau mot de passe">
                        <button class="bouton3" type="submit">Valider</button> <br/>
                    </form>
                </div>

                <div class="dataUser-container container3">
                    <h1 class="title">Demandes</h1>
                    <div id="actionsRapides">
                        <button class="bouton2">Changement de coordonnées sensibles</button>
                        <button class="bouton2">Ajout de maison</button>
                        <button class="bouton2">Suppression de maison</button>
                        <button class="bouton2">Suppression de compte</button>
                    </div>
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
                                        <label for="codePostal">Code Postal :</label>
                                        <input type="text" id="maisonCodePostal" placeholder="Entrez le code postal" name="codePostal" value="">
                                        <label for="maisonPrincipale" >Maison Principale :</label>
                                        <input type="checkbox" id="maisonPrincipale" name="maisonPrincipale">
                                        <div class="boutonRight">
                                            <button type="button" onclick="deleteFunction('maison')">Supprimer</button>
                                            <button type="button" onclick="backFunction('maison')">Annuler</button>
                                            <button type="button" onclick="eraseFunction('maison')">Nouveau</button>
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
                                        <select id="pieceMaison"></select>
                                        <div class="boutonRight">
                                            <button type="button" onclick="deleteFunction('piece')">Supprimer</button>
                                            <button type="button" onclick="backFunction('piece')">Annuler</button>
                                            <button type="button" onclick="eraseFunction('piece')">Nouveau</button>
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
                                        <select id="typeCemac"></select>
                                        <label for="pieceCemac">Piece : </label>
                                        <select id="pieceCemac"></select>
                                        <div class="boutonRight">
                                            <button type="button" onclick="deleteFunction('cemac')">Supprimer</button>
                                            <button type="button" onclick="backFunction('cemac')">Annuler</button>
                                            <button type="button" onclick="eraseFunction('cemac')">Nouveau</button>
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
