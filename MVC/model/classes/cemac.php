<?php

  /**
   * Classe CeMac permettant de décrire l'objet CeMac
   */
class CeMac{
    private $idCemac;
    private $numeroSerie;
    private $statut;
    private $typeCapteur;
    private $idPiece;

    /**
     * constructeur de l'objet CeMac
     * @param $data contenant toutes les données d'un CeMac
     */
    public function fill($data){
        $this->idCemac = (int) $data['idCemac'];
        $this->numeroSerie = $data['numeroSerie'];
        $this->statut = (boolean) ($data['statut']);
        $this->typeCapteur = array(
            'categorie' => $data['categorie'],
            'type' => $data['type'],
            'exterieur' => $data['exterieur'],
            'grandeur' => array(
                'nom' => $data['nom'],
                'symbole' => $data['symbole'],
                'pas' => (float)$data['pas'],
                'borneInf' => (float)$data['borneInf'],
                'borneSup' => (float)$data['borneSup']
            ),
            'libelleGroupBy' => $data['libelleGroupBy'],
            'valeur' => (float)$data['valeur']
        );
        $this->idPiece = (int) $data['idPiece'];
    }
    /**
     * fonction permettant de récupérer l'identifiant du client
     * @return retourne l'identifiant CeMac
     */
    public function getId(){
        return $this->idCemac;
    }

    /**
     * fonction permettant de récupérer le numéro de série
     * @return retourne le numéro de série du CeMac
     */
    public function getNumeroSerie(){
        return $this->numeroSerie;
    }

    /**
     * fonction permettant de récupérer le statut du CeMac
     * @return retourne le statut du CeMac
     */
    public function getStatut(){
        return $this->statut;
    }

    /**
     * fonction permettant de récupérer le type du capteur
     * @return retourne le type de capteur
     */
    public function getTypeCapteur(){
        return $this->typeCapteur;
    }

    /**
     * fonction permettant de récupérer l'identifiant de la pièce dont il est placé
     * @return retourne l'identifiant de la pièce
     */
    public function getIdPiece(){
        return $this->idPiece;
    }

    /**
     * fonction permettant de récupérer les données du CeMac en arrray
     * @return retourne un array contenant les informations du CeMac
     */
    public function toArray(){
        return array(
            'id' => $this->getId(),
            'numeroSerie' => $this->getNumeroSerie(),
            'statut' => $this->getStatut(),
            'typeCapteur' => $this->getTypeCapteur(),
            'idPiece' => $this->getIdPiece()
        );
    }
}
?>
