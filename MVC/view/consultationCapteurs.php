<?php
    $title = "Espace utilisateur - Vue générale";
    $css = [
        "styleModal.css"
    ];
    $js = [
        "modal.js"
    ];
    $modals = '
        <div class="modal-bg">
            <div class="modal" id="Modal1">
                <div class="modal-head">
                    <span class="modal-close">&times;</span>
                    <h2>Contact</h2>
                </div>
                <div class="modal-body">
                    <p>Bonjour</p>
                </div>
            </div>
        </div>
    ';
    $jsonpage = '
        document.querySelector("#modalBtn").onclick = function(){
            displayModal("#Modal1");
        };
    ';
?>
<?php ob_start(); ?>
    <h1>BONJOUR</h1>
    <button id="ModalBtn">LE modal</button>
<?php $content = ob_get_clean(); ?>
<?php require("./view/templateUtilisateur.php"); ?>
