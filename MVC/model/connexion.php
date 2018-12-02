<?php

function connexionUtilisateur($username,$password,$selecteur)
{
    require('./model/config.php');
    $admin = false;
    if($selecteur == "admin")
    {
        $res = $database -> prepare('select * from administrateur where administrateur.mail = ?');
        $admin = true;
    }
    else
    {
        $res = $database -> prepare('select * from client where client.mail = ?');
    }

    $res -> bindParam(1, $username);

    $res -> execute();
    $row = $res->fetch(PDO::FETCH_ASSOC);
    if($row['mail'] <> "")
    {
        if(password_verify($password,$row["passe"]))
        {
            $_SESSION["mail"] = $row["mail"];
            $_SESSION["type"] = $selecteur;
            $_SESSION["id"] = $admin?$row["idAdministrateur"]:$row["idClient"];
            return $selecteur;
        }
        else
        {
            return "ErrorMDP";
        }
    }
    else
    {
        return "ErrorUser";
    }

}

?>
