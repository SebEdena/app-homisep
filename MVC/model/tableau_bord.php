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

?>
