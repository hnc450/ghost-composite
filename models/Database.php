<?php
namespace Model;
class Database {
    private $host = "localhost";      // hôte
    private $dbname; // nom de la base
    private $username;       // utilisateur MySQL
    private $password;           // mot de passe MySQL
    private $port;               // port MySQL
    private $conn;                    // objet PDO
    private $config; 

    /**
     * Connexion à la base de données
     */
    public function connect() {
        // Charger la configuration
        $this->config = require dirname(__DIR__). DIRECTORY_SEPARATOR .'config'. DIRECTORY_SEPARATOR.'config.php';
        $this->dbname = $this->config['DB_NAME'];
        $this->username = $this->config['DB_USER'];
        $this->password = $this->config['DB_PASSWORD'];
        $this->port = $this->config['DB_PORT'];
        $this->conn = null;
        try {
            $dsn = "mysql:host=" . $this->host . ";port=" . $this->port . ";dbname=" . $this->dbname . ";charset=utf8mb4";
            $this->conn = new \PDO($dsn, $this->username, $this->password);
            // Options de sécurité et performance
            $this->conn->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
            $this->conn->setAttribute(\PDO::ATTR_DEFAULT_FETCH_MODE, \PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            die("Erreur de connexion : " . $e->getMessage());
        }
        return $this->conn;
    }

    /**
     * Fermer la connexion
     */
    public function disconnect() {
        $this->conn = null;
    }

    /**
     * Exécuter une requête avec paramètres (SELECT, INSERT, UPDATE, DELETE)
     */
    public function query($sql, $params = []) {
        $stmt = $this->conn->prepare($sql);
        $stmt->execute($params);
        return $stmt;
    }

    /**
     * Récupérer plusieurs enregistrements
     */
    public function fetchAll($sql, $params = []) {
        $stmt = $this->query($sql, $params);
        return $stmt->fetchAll();
    }

    /**
     * Récupérer un seul enregistrement
     */
    public function fetchOne($sql, $params = []) {
        $stmt = $this->query($sql, $params);
        return $stmt->fetch();
    }

    /**
     * Exécuter une requête INSERT/UPDATE/DELETE
     */
    public function execute($sql, $params = []) {
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute($params);
    }

    /**
     * Récupérer le dernier ID inséré
     */
    public function lastInsertId() {
        return $this->conn->lastInsertId();
    }
}
?>