<?php
class CeMac{
    private $idCemac;
    private $numeroSerie;
    private $statut;
    private $typeCapteur;
    private $idPiece;

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
                'symbole' => $data['symbole']
            ),
            'libelleGroupBy' => $data['libelleGroupBy']
        );
        $this->idPiece = (int) $data['idPiece'];
    }

    public function getId(){
        return $this->idCemac;
    }

    public function getNumeroSerie(){
        return $this->numeroSerie;
    }

    public function getStatut(){
        return $this->statut;
    }

    public function getTypeCapteur(){
        return $this->typeCapteur;
    }

    public function getIdPiece(){
        return $this->idPiece;
    }

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
