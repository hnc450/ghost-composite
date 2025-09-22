<?php
namespace Model;

class DownloadModel extends \Model\BaseModel {
  
    public function __construct() {
        $this->db = new \Model\MysqlDatabase();
    }

    /**
     * Enregistrer un téléchargement
     */
    public function createDownload($id_utilisateur, $id_projet) {
        $sql = "INSERT INTO telechargement (id_utilisateur, id_projet, date_telechargement) 
                VALUES (?, ?, NOW())";
        return $this->db->query($sql, [$id_utilisateur, $id_projet]);
    }

    /**
     * Récupérer un téléchargement par ID
     */
    public function getDownloadById($id) {
        $sql = "SELECT * FROM telechargement WHERE id_telechargement = ?";
        return $this->db->fetchOne($sql, [$id]);
    }

    /**
     * Lister tous les téléchargements d’un utilisateur
     */
    public function getDownloadsByUser($id_utilisateur) {
        $sql = "SELECT d.*, p.titre 
                FROM telechargement d
                JOIN projet p ON d.id_projet = p.id_projet
                WHERE d.id_utilisateur = ?
                ORDER BY d.date_telechargement DESC";
        return $this->db->fetchAll($sql, [$id_utilisateur]);
    }

    /**
     * Lister tous les téléchargements d’un projet
     */
    public function getDownloadsByProject($id_projet) {
        $sql = "SELECT d.*, u.nom 
                FROM telechargement d
                JOIN utilisateur u ON d.id_utilisateur = u.id_utilisateur
                WHERE d.id_projet = ?
                ORDER BY d.date_telechargement DESC";
        return $this->db->fetchAll($sql, [$id_projet]);
    }

    /**
     * Lister tous les téléchargements
     */
    public function listDownloads() {
        $sql = "SELECT d.*, u.nom, p.titre 
                FROM telechargement d
                JOIN utilisateur u ON d.id_utilisateur = u.id_utilisateur
                JOIN projet p ON d.id_projet = p.id_projet
                ORDER BY d.date_telechargement DESC";
        return $this->db->fetchAll($sql);
    }

    /**
     * Supprimer un téléchargement
     */
    public function deleteDownload($id) {
        $sql = "DELETE FROM telechargement WHERE id_telechargement = ?";
        return $this->db->query($sql, [$id]);
    }
}
?>