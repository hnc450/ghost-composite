<?php
namespace Model;

class PayementModel extends BaseModel {
    public function __construct($db = null) {
        $this->db = $db ?? new \Model\MysqlDatabase();
    }

    /**
     * Créer un nouveau paiement
     */
    public function createPayement($id_utilisateur, $id_projet, $montant, $methode, $statut = "en_attente") {
        $sql = "INSERT INTO paiement (id_utilisateur, id_projet, montant, methode, statut, date_paiement) 
                VALUES (?, ?, ?, ?, ?, NOW())";
        return $this->db->query($sql, [$id_utilisateur, $id_projet, $montant, $methode, $statut]);
    }

    /**
     * Récupérer un paiement par ID
     */
    public function getPayementById($id) {
        $sql = "SELECT * FROM paiement WHERE id_paiement = ?";
        return $this->db->fetchOne($sql, [$id]);
    }

    /**
     * Récupérer tous les paiements d’un utilisateur
     */
    public function getPayementsByUser($id_utilisateur) {
        $sql = "SELECT p.*, pr.titre 
                FROM paiement p 
                JOIN projet pr ON p.id_projet = pr.id_projet
                WHERE p.id_utilisateur = ? 
                ORDER BY p.date_paiement DESC";
        return $this->db->fetchAll($sql, [$id_utilisateur]);
    }

    /**
     * Récupérer tous les paiements
     */
    public function listPayements() {
        $sql = "SELECT p.*, u.nom, pr.titre 
                FROM paiement p
                JOIN utilisateur u ON p.id_utilisateur = u.id_utilisateur
                JOIN projet pr ON p.id_projet = pr.id_projet
                ORDER BY p.date_paiement DESC";
        return $this->db->fetchAll($sql);
    }

    /**
     * Mettre à jour le statut d’un paiement (validé, refusé, en_attente)
     */
    public function updatePayementStatus($id, $statut) {
        $sql = "UPDATE paiement SET statut = ? WHERE id_paiement = ?";
        return $this->db->query($sql, [$statut, $id]);
    }

    /**
     * Supprimer un paiement
     */
    public function deletePayement($id) {
        $sql = "DELETE FROM paiement WHERE id_paiement = ?";
        return $this->db->query($sql, [$id]);
    }
}
?>