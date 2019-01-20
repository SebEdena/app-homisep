<?php
  /**
   * fonction permettant l'authentifiaction d'un utilisateur
   * @param $username l'adresse mail de l'Utilisateur
   * @param $password le mot de passe saisi par l'utilisateur
   * @return retourne un booléen vrai si c'est un administrateur / faux : un client et un message d'erreur en cas d'échec d'authentifiaction
   */
function connexionUtilisateur($username,$password){
    require('./model/config.php');

    $admin = true;

    $res = $database -> prepare('select * from administrateur where administrateur.mail = ?');
    $res -> bindParam(1, $username);
    $res -> execute();
    $row = $res->fetch(PDO::FETCH_ASSOC);

    if(is_null($row['mail'])){
        $admin = false;

        $res = $database -> prepare('select * from client where client.mail = ?');
        $res -> bindParam(1, $username);
        $res -> execute();
        $row = $res->fetch(PDO::FETCH_ASSOC);
    }

    if($row['mail'] <> ""){
        if(password_verify($password,$row["passe"])){
            $_SESSION["mail"] = $row["mail"];
            $_SESSION["nom"] = $row["nom"];
            $_SESSION["prenom"] = $row["prenom"];
            $_SESSION["admin"] = $admin;
            $_SESSION["id"] = $admin?$row["idAdministrateur"]:$row["idClient"];
            return $admin?"admin":"client";
        }
        else{
            return "ErrorMDP";
        }
    }
    else{
        return "ErrorUser";
    }
}

?>
