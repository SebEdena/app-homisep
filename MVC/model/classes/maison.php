<?php

/**
 * Classe Maison permettant de décrire l'objet Maison
 */
class Maison {
    private $idMaison;
    private $adresse;
    private $ville;
    private $codePostal;
    private $idClient;

    /**
     * fonction permetttant de récupérer l'identifiant de la maison
     * @return retourne l'identifiant de la maison
     */
    public function getId(){
        return (int) $this->idMaison;
    }

    /**
     * fonction permettant de récupérer l'adresse de la maison
     * @return retourne l'adresse de la maison
     */
    public function getAdresse(){
        return $this->adresse;
    }

    /**
     * fonction permettant de récupérer la ville de la maison
     * @return retourne la ville de la maison
     */
    public function getVille(){
        return $this->ville;
    }

    /**
     * fonction permettant de récupérer le code postal de la maison
     * @return retourne le code postal de la maison
     */
    public function getCodePostal(){
        return $this->codePostal;
    }

    /**
     * fonction permettant de récupérer l'identifiant du propriétaire
     * @return retourne l'identifiant du propriétaire
     */
    public function getIdClient(){
        return (int) $this->idClient;
    }
}
?>
