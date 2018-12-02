<?php
class Maison {
    private $idMaison;
    private $adresse;
    private $ville;
    private $codePostal;
    private $idClient;

    public function getId(){
        return $this->idMaison;
    }

    public function getAdresse(){
        return $this->adresse;
    }

    public function getVille(){
        return $this->ville;
    }

    public function getCodePostal(){
        return $this->codePostal;
    }

    public function getIdClient(){
        return $this->idClient;
    }
}
?>
