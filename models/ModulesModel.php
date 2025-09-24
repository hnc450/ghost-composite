<?php
namespace Model;

class ModulesModel extends BaseModel {
    public function __construct($db = null) {
        $this->db = $db ?? new \Model\MysqlDatabase();
    }

    /**
     * Créer un nouveau module
     */
    public function createModule($nom, $description, $niveau = "facile") {
        $sql = "INSERT INTO module (nom, description, niveau) VALUES (?, ?, ?)";
        return $this->db->query($sql, [$nom, $description, $niveau]);
    }

    /**
     * Récupérer un module par ID
     */
    public function getModuleById($id) {
        $sql = "SELECT * FROM module WHERE id_module = ?";
        return $this->db->fetchOne($sql, [$id]);
    }

    /**
     * Lister tous les modules
     */
    public function listModules() {
        $sql = "SELECT * FROM module ORDER BY id_module DESC";
        return $this->db->fetchAll($sql);
    }

    /**
     * Mettre à jour un module
     */
    public function updateModule($id, $data) {
        $fields = [];
        $values = [];
        foreach ($data as $key => $value) {
            $fields[] = "$key = ?";
            $values[] = $value;
        }
        $values[] = $id;
        $sql = "UPDATE module SET " . implode(", ", $fields) . " WHERE id_module = ?";
        return $this->db->query($sql, $values);
    }

    /**
     * Supprimer un module
     */
    public function deleteModule($id) {
        $sql = "DELETE FROM module WHERE id_module = ?";
        return $this->db->query($sql, [$id]);
    }

    /**
     * Récupérer les modules par niveau (facile, moyen, difficile)
     */
    public function getModulesByLevel($niveau) {
        $sql = "SELECT * FROM module WHERE niveau = ?";
        return $this->db->fetchAll($sql, [$niveau]);
    }
}
?>