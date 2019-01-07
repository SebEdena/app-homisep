<?php
class Message {
    private $idMessage;
    private $objet;
    private $texte;
    private $idClient;
    private $idAdmininistrateur;

    public function getId(){
        return (int) $this->idMessage;
    }

    public function getObjet(){
        return $this->objet;
    }

    public function getTexte(){
        return $this->texte;
    }

    public function getIdClient(){
        return (int) $this->idClient;
    }

    public function getIdAdministrateur(){
        return (int) $this->idAdministrateur;
    }
}
?>
