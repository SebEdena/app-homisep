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

function Genere_mdp($size)
{
    $mot_de_passe = "";
    $chiffres = array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9);
    $lettres = array("a", "b", "c", "d", "e", "f", "g", "h", "i", "j", "k", "l", "m", "n", "o", "p", "q", "r", "s", "t", "u", "v", "w", "x", "y", "z");
    $symboles = array(".", "@", "*", "!","?", "-");
    $decalage = 0;
    for($i=0;$i<$size;$i++)
    {
        if (($i + $decalage)%3==0){
            $mot_de_passe .= ($i%2) ? strtoupper($lettres[array_rand($lettres)]) : $lettres[array_rand($lettres)];
        }else if(($i + $decalage)%3==1){
            $mot_de_passe .= $chiffres[array_rand($chiffres)];
        }else{
            $mot_de_passe .= $symboles[array_rand($symboles)];
        }
    }
    return $mot_de_passe;
}
?>
