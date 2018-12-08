<?php

function getMaisons()
{
    require('./model/config.php');
    require('./model/classes/maison.php');
    $query = $database -> prepare('select * from maison where idClient=?');
    $query -> bindParam(1, $_SESSION["id"]);
    $query -> execute();

    $res = $query->fetchAll(PDO::FETCH_CLASS, 'Maison');
    return $res;
}

function getPieces(int $idMaison){
    require('./model/config.php');
    require('./model/classes/piece.php');
    $query = $database -> prepare('select p.* from piece p, maison m where p.idMaison=m.idMaison and m.idClient=? and p.idMaison=? order by p.nom');
    $query -> bindParam(1, $_SESSION["id"]);
    $query -> bindParam(2, $idMaison);
    $query -> execute();

    $res = $query->fetchAll(PDO::FETCH_ASSOC);

    foreach ($res as $key => $value) {
        $p = new Piece();
        $p -> fill($value);
        $res[$key] = $p->toArray();
    }

    return $res;
}

function getCemacs(int $idMaison){
    require('./model/config.php');
    require('./model/classes/cemac.php');

    $query = $database -> prepare('select c.idCemac, c.numeroSerie, c.statut, c.idPiece, tc.categorie, tc.type, tc.exterieur, tc.libelleGroupBy, gp.nom, gp.symbole from cemac c, typecapteur tc, grandeurphysique gp, piece p, maison m where c.idTypeCapteur = tc.idTypeCapteur and tc.idGrandeurPhysique = gp.idGrandeurPhysique and c.idPiece = p.idPiece and p.idMaison = m.idMaison and m.idClient = ? and m.idMaison = ? order by c.idPiece, c.idCemac');
    $query -> bindParam(1, $_SESSION["id"]);
    $query -> bindParam(2, $idMaison);
    $query -> execute();

    $res = $query->fetchAll(PDO::FETCH_ASSOC);

    foreach ($res as $key => $value) {
        $p = new Cemac();
        $p -> fill($value);
        $res[$key] = $p->toArray();
    }

    return $res;
}

function buildCemacsContext($pieces, $cemacs){
    $context = array();
    foreach ($pieces as $piece) {
        $context[$piece['id']] = array(
            'lum' => array(
                'int' => null,
                'ext' => null
            ),
            'temp' => array(
                'int' => null,
                'ext' => null
            ),
            'shut' => array(
                'int' => null
            )
        );
    }
    foreach ($cemacs as $cemac) {
        $id = $cemac['id'];
        $piece = $cemac['idPiece'];
        $categ = $cemac['typeCapteur']['categorie'];
        $ext = $cemac['typeCapteur']['exterieur'];
        $capt = $cemac['typeCapteur']['type'];
        $statut = (boolean) $cemac['statut'];
        $libelle = $cemac['typeCapteur']['libelleGroupBy'];

        if(!isset($context[$piece][$categ][$ext])){
            $context[$piece][$categ][$ext] = array(
                'actionneur' => array(),
                'capteur' => array(),
                'cemacs' => array(),
                'statut' => true,
                'libelleGroupBy' => $libelle
            );
        }
        array_push($context[$piece][$categ][$ext][$capt], $id);
        array_push($context[$piece][$categ][$ext]['cemacs'], $id);
        $context[$piece][$categ][$ext]['statut'] = $context[$piece][$categ][$ext]['statut'] && $statut;
    }
    return $context;
}

?>
