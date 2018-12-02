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

?>
