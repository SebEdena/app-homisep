<?php

/**
 * Classe Message permettant de décrire l'objet Message
 */
class Message {
    private $idMessage;
    private $objet;
    private $texte;
    private $idClient;
    private $idAdmininistrateur;

    /**
     * fonction permettant de récupérer l'identifiant du message
     * @return retourne l'identifiant du messgae
     */
    public function getId(){
        return (int) $this->idMessage;
    }

    /**
     * fonction permettant de récupérer l'objet du messgae
     * @return retourne l'objet du message
     */
    public function getObjet(){
        return $this->objet;
    }

    /**
     * fonction permettant de récupérer le texte du message
     * @return retourne le texte du message
     */
    public function getTexte(){
        return $this->texte;
    }

    /**
     * fonction permettant de récupérer l'identifiant de l'auteur
     * @return retourne l'identifiant du client
     */
    public function getIdClient(){
        return (int) $this->idClient;
    }

    /**
     * fonction permettant de récupérer l'identifiant de l'administrateur
     * @return retourne l'identifiant de l'administrateur
     */
    public function getIdAdministrateur(){
        return (int) $this->idAdministrateur;
    }
}
?>
