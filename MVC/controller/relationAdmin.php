<?php
    function afficherAccueil()
    {
        require("./view/consultationDonneesClient.php");
    }

    function deconnexion()
    {
        session_destroy();
        require("./view/indexVue.tpl");
    }
?>
