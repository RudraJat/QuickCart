<?php
class Database {
    private $host = 'localhost:4307';
    private $dbname = 'ecommerce_db';
    private $username = 'root';
    private $password = '';
    private $pdo;

    public function getConnection() {
        try {
            if (!$this->pdo) {
                $this->pdo = new PDO("mysql:host=$this->host;dbname=$this->dbname", 
                                    $this->username, 
                                    $this->password);
                $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $this->pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
            }
            return $this->pdo;
        } catch(PDOException $e) {
            die("Connection failed: " . $e->getMessage());
        }
    }
}
?>