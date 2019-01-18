<?php

function connexionUtilisateur($username,$password)
{
    require('./model/config.php');

    $admin = true;

    $res = $database -> prepare('select * from administrateur where administrateur.mail = ?');
    $res -> bindParam(1, $username);
    $res -> execute();
    $row = $res->fetch(PDO::FETCH_ASSOC);

    if(is_null($row['mail']))
    {
        $admin = false;

        $res = $database -> prepare('select * from client where client.mail = ?');
        $res -> bindParam(1, $username);
        $res -> execute();
        $row = $res->fetch(PDO::FETCH_ASSOC);
    }

    if($row['mail'] <> "")
    {
        if(password_verify($password,$row["passe"]))
        {
            $_SESSION["mail"] = $row["mail"];
            $_SESSION["nom"] = $row["nom"];
            $_SESSION["prenom"] = $row["prenom"];
            $_SESSION["admin"] = $admin;
            $_SESSION["id"] = $admin?$row["idAdministrateur"]:$row["idClient"];
            return $admin?"admin":"client";
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
