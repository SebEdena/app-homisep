<?php
function afficherFAQ()
{
    require("./view/FAQ.php");
}

function afficheTableauBord(){
    require("./model/tableau_bord.php");
    $maisons = getMaisons();
    require("./view/tableauBord.php");
}

function getDonneesMaison(){
    require("./model/tableau_bord.php");
    $idMaison = $_POST["idMaison"];
    try{
        $pieces = getPieces($idMaison);
        $cemacs = getCemacs($idMaison);
        $context = buildCemacsContext($pieces, $cemacs);

        http_response_code(200);
        header('Content-Type: application/json; charset=UTF-8');
        print json_encode(array(
            'pieces' => $pieces,
            'cemacs' => $cemacs,
            'context' => $context
        ));
    }catch(Exception $exception){
        http_response_code(500);
        header('Content-Type: application/json; charset=UTF-8');
        print json_encode(array('error'=>true, 'message'=>$exception->getMessage()));
    }
}

function afficheGestionCompte()
{
  require("./view/gestionMaisonPieceCapteur.php");
}
?>
