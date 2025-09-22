<?php

namespace Model;

class MysqlDatabase extends \Model\Database {
    private $conn;

    /**
     * Connexion (hérite de Database)
     */
    public function __construct() {
        $this->conn = $this->connect();
    }

    /**
     * Démarrer une transaction
     */
    public function beginTransaction() {
        return $this->conn->beginTransaction();
    }

    /**
     * Valider une transaction
     */
    public function commit() {
        return $this->conn->commit();
    }

    /**
     * Annuler une transaction
     */
    public function rollback() {
        return $this->conn->rollBack();
    }

    /**
     * Récupérer l’ID du dernier enregistrement inséré
     */
    public function lastInsertId() {
        return $this->conn->lastInsertId();
    }

    /**
     * Exécuter une requête avec paramètres
     */
    public function query($sql, $params = []) {
        $stmt = $this->conn->prepare($sql);
        $stmt->execute($params);
        return $stmt;
    }
}
?>