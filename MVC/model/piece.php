<?php
class Piece {
    private $idPiece;
    private $nom;
    private $idMaison;
    private $idTypePiece;

    public function fill($data){
        $this->idPiece = (int) $data['idPiece'];
        $this->nom = $data['nom'];
        $this->idMaison = (int) $data['idMaison'];
        $this->idTypePiece = (int) $data['idTypePiece'];
    }

    public function getId(){
        return $this->idPiece;
    }

    public function getNom(){
        return $this->nom;
    }

    public function getIdMaison(){
        return $this->idMaison;
    }

    public function getIdTypePiece(){
        return $this->idTypePiece;
    }

    public function toArray(){
        return array('id' => $this->getId(),
                     'nom' => $this->getNom(),
                     'idMaison' => $this->getIdMaison(),
                     'idTypePiece' => $this->getIdTypePiece());
    }
}
?>
