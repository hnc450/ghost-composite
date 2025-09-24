<?php
namespace Model;
class ProjetModel extends BaseModel {
    public function __construct($db = null) {
        $this->db = $db ?? new \Model\MysqlDatabase();
    }

    /**
     * Créer un nouveau projet
     */
    public function createProjet($titre, $description, $categorie, $fichier_zip, $prix = 0) {
        $sql = "INSERT INTO projet (titre, description, categorie, fichier_zip, prix) 
                VALUES (?, ?, ?, ?, ?)";
        return $this->db->query($sql, [$titre, $description, $categorie, $fichier_zip, $prix]);
    }

    /**
     * Récupérer un projet par ID
     */
    public function getProjetById($id) {
        $sql = "SELECT * FROM projet WHERE id_projet = ?";
        return $this->db->fetchOne($sql, [$id]);
    }

    /**
     * Lister tous les projets
     */
    public function listProjets() {
        $sql = "SELECT * FROM projet ORDER BY id_projet DESC";
        return $this->db->fetchAll($sql);
    }

    /**
     * Lister les projets freemium
     */
    public function listFreemiumProjets() {
        $sql = "SELECT * FROM projet WHERE categorie = 'freemium'";
        return $this->db->fetchAll($sql);
    }

    /**
     * Lister les projets premium
     */
    public function listPremiumProjets() {
        $sql = "SELECT * FROM projet WHERE categorie = 'premium'";
        return $this->db->fetchAll($sql);
    }

    /**
     * Mettre à jour un projet
     */
    public function updateProjet($id, $data) {
        $fields = [];
        $values = [];
        foreach ($data as $key => $value) {
            $fields[] = "$key = ?";
            $values[] = $value;
        }
        $values[] = $id;
        $sql = "UPDATE projet SET " . implode(", ", $fields) . " WHERE id_projet = ?";
        return $this->db->query($sql, $values);
    }

    /**
     * Supprimer un projet
     */
    public function deleteProjet($id) {
        $sql = "DELETE FROM projet WHERE id_projet = ?";
        return $this->db->query($sql, [$id]);
    }
}
?>