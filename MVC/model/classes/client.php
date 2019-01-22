<?php

/**
 * Classe Client permettant de décrire l'objet Client
 */
  class Client{
    private $idClient;
    private $nom;
    private $prenom;
    private $adresse;
    private $ville;
    private $codePostal;
    private $mail;
    private $dateNaissance;
    private $dateCreation;

    /**
     * fonction permettant de récupérer l'identifiant du client
     * @return retourne l'identifiant du client
     */
    public function getId(){
      return $this->idClient;
    }

    /**
     * fonction permettant de récupérer le nom du client
     * @return retourne le nom du client
     */
    public function getNom(){
      return $this->nom;
    }

    /**
     * fonction permettant de récupérer le prenom du client
     * @return retourne le prénom du client
     */
    public function getPrenom(){
      return $this->prenom;
    }

    /**
     * fonction permettant de récupérer l'adresse du client
     * @return retourne l'adresse du client
     */
    public function getAdresse(){
        return $this->adresse;
    }

    /**
     * fonction permettant de récupérer la ville du client
     * @return retourne la ville du client
     */
    public function getVille(){
        return $this->ville;
    }

    /**
     * fonction permettant de récupérer le code postal du client
     * @return retourne le code postal du client
     */
    public function getCodePostal(){
        return $this->codePostal;
    }

    /**
     * fonction permettant de récupérer l'adresse mail du client
     * @return retourne l'adresse mail du client
     */
    public function getMail(){
      return $this->mail;
    }

    /**
     * fonction permettant de récupérer la date de naissance du client
     * @return retourne la date de naissance du client
     */
    public function getDateNaissance()    {
      return $this->dateNaissance;
    }

    /**
     * fonction permettant de récupérer la date de création du compte client
     * @return retourne la date de création du compte client
     */
    public function getDateCreation()    {
      return $this->dateCreation;
    }
  }
?>
