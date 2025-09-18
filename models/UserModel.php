<?php
require_once "MysqlDatabase.php";

class UserModel {
    private $db;

    public function __construct() {
        $this->db = new MysqlDatabase();
    }

    /**
     * Créer un nouvel utilisateur
     */
    public function createUser($nom, $email, $mot_de_passe, $role = "user") {
        $hash = password_hash($mot_de_passe, PASSWORD_BCRYPT);
    $sql = "INSERT INTO utilisateur (nom, email, mot_de_passe, role) VALUES (?, ?, ?, ?)";
        return $this->db->query($sql, [$nom, $email, $hash, $role]);
    }

    /**
     * Récupérer un utilisateur par son ID
     */
    public function getUserById($id) {
    $sql = "SELECT * FROM utilisateur WHERE id_utilisateur = ?";
        return $this->db->fetchOne($sql, [$id]);
    }

    /**
     * Récupérer un utilisateur par email
     */
    public function getUserByEmail($email) {
    $sql = "SELECT * FROM utilisateur WHERE email = ?";
        return $this->db->fetchOne($sql, [$email]);
    }

    /**
     * Authentifier un utilisateur
     */
    public function authenticate($email, $mot_de_passe) {
        $user = $this->getUserByEmail($email);
        if ($user && password_verify($mot_de_passe, $user['mot_de_passe'])) {
            $this->updateLastConnexion($user['id_utilisateur']);
            return $user;
        }
        return false;
    }

    /**
     * Mettre à jour un utilisateur
     */
    public function updateUser($id, $data) {
        $fields = [];
        $values = [];
        foreach ($data as $key => $value) {
            $fields[] = "$key = ?";
            $values[] = $value;
        }
        $values[] = $id;
    $sql = "UPDATE utilisateur SET " . implode(", ", $fields) . " WHERE id_utilisateur = ?";
        return $this->db->query($sql, $values);
    }

    /**
     * Supprimer un utilisateur
     */
    public function deleteUser($id) {
    $sql = "DELETE FROM utilisateur WHERE id_utilisateur = ?";
        return $this->db->query($sql, [$id]);
    }

    /**
     * Lister tous les utilisateurs
     */
    public function listUsers() {
    $sql = "SELECT * FROM utilisateur ORDER BY date_inscription DESC";
        return $this->db->fetchAll($sql);
    }

    /**
     * Mettre à jour la dernière connexion
     */
    public function updateLastConnexion($id) {
    $sql = "UPDATE utilisateur SET dernier_connexion = NOW() WHERE id_utilisateur = ?";
        return $this->db->query($sql, [$id]);
    }

    /**
     * Bannir un utilisateur
     */
    public function banUser($id) {
    $sql = "UPDATE utilisateur SET statut = 'banni' WHERE id_utilisateur = ?";
        return $this->db->query($sql, [$id]);
    }

    /**
     * Récupérer tous les administrateurs
     */
    public function getAdmins() {
    $sql = "SELECT * FROM utilisateur WHERE role = 'admin'";
        return $this->db->fetchAll($sql);
    }
}
?>