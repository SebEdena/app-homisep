<?php
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

    public function getId()
    {
      return $this->idClient;
    }

    public function getNom()
    {
      return $this->nom;
    }

    public function getPrenom()
    {
      return $this->prenom;
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

    public function getMail()
    {
      return $this->mail;
    }

    public function getDateNaissance()
    {
      return $this->dateNaissance;
    }

    public function getDateCreation()
    {
      return $this->dateCreation;
    }
  }
?>
