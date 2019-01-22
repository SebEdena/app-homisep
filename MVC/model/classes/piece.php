<?php
/**
 * Classe Piece permettant de décrire l'objet Piece
 */
class Piece {
    private $idPiece;
    private $nom;
    private $idMaison;
    private $idTypePiece;

    /**
     * constructeur de l'objet pièce
     * @param $data contenant toutes les données d'une pièce
     */
    public function fill($data){
        $this->idPiece = (int) $data['idPiece'];
        $this->nom = $data['nom'];
        $this->idMaison = (int) $data['idMaison'];
        $this->idTypePiece = (int) $data['idTypePiece'];
    }

    /**
     * fonction permettant de récupérer l'identifiant de la pièce
     * @return retourne l'identifiant de la pièce
     */
    public function getId(){
        return $this->idPiece;
    }

    /**
     * fonction permettant de récupérer le nom de la pièce
     * @return retourne le nom de la pièce
     */
    public function getNom(){
        return $this->nom;
    }

    /**
     * fonction permettant de récupérer l'identifiant de la maison
     * @return retourne l'identifiant de la maison
     */
    public function getIdMaison(){
        return $this->idMaison;
    }

    /**
     * fonction permettant de récupérer l'identifiant du type de pièce
     * @return retourne l'identifiant du type de pièce
     */
    public function getIdTypePiece(){
        return $this->idTypePiece;
    }

    /**
     * fonction permettant de récupérer les informations de la pièce en array
     * @return retourne l'array contenant toutes les informations de la pièce
     */
    public function toArray(){
        return array('id' => $this->getId(),
                     'nom' => $this->getNom(),
                     'idMaison' => $this->getIdMaison(),
                     'idTypePiece' => $this->getIdTypePiece());
    }
}
?>
