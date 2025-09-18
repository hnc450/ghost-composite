<?php
require_once "MysqlDatabase.php";

class UserModuleModel {
    private $db;

    public function __construct() {
        $this->db = new MysqlDatabase();
    }

    /**
     * Ajouter un module suivi par un utilisateur
     */
    public function addUserModule($id_utilisateur, $id_module) {
        $sql = "INSERT INTO user_module (id_utilisateur, id_module, date_suivi) VALUES (?, ?, NOW())";
        return $this->db->query($sql, [$id_utilisateur, $id_module]);
    }

    /**
     * Supprimer un module suivi par un utilisateur
     */
    public function deleteUserModule($id_utilisateur, $id_module) {
        $sql = "DELETE FROM user_module WHERE id_utilisateur = ? AND id_module = ?";
        return $this->db->query($sql, [$id_utilisateur, $id_module]);
    }

    /**
     * Lister tous les modules suivis par un utilisateur
     */
    public function getModulesByUser($id_utilisateur) {
        $sql = "SELECT um.*, m.nom, m.niveau 
                FROM user_module um
                JOIN module m ON um.id_module = m.id_module
                WHERE um.id_utilisateur = ?
                ORDER BY um.date_suivi DESC";
        return $this->db->fetchAll($sql, [$id_utilisateur]);
    }

    /**
     * Lister tous les utilisateurs qui suivent un module
     */
    public function getUsersByModule($id_module) {
        $sql = "SELECT um.*, u.nom, u.email 
                FROM user_module um
                JOIN utilisateur u ON um.id_utilisateur = u.id_utilisateur
                WHERE um.id_module = ?
                ORDER BY um.date_suivi DESC";
        return $this->db->fetchAll($sql, [$id_module]);
    }

    /**
     * Vérifier si un utilisateur suit déjà un module
     */
    public function isUserFollowingModule($id_utilisateur, $id_module) {
        $sql = "SELECT * FROM user_module WHERE id_utilisateur = ? AND id_module = ?";
        $result = $this->db->fetchOne($sql, [$id_utilisateur, $id_module]);
        return !empty($result);
    }
}
?>