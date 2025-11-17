<?php
class Database {
    private $host = "localhost";
    private $db_name = "inventaris";
    private $username = "root";
    private $password = "";
    public $conn;

    public function getConnection() {
        $this->conn = null;
        try {
            $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->password);
            $this->conn->exec("set names utf8");
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
            
            // 
            $this->conn->query("SELECT 1");
            
        } catch(PDOException $exception) {
            echo "<div style='background: red; color: white; padding: 20px; margin: 10px;'>";
            echo "<h3>Database Connection Error:</h3>";
            echo "Message: " . $exception->getMessage() . "<br>";
            echo "Host: " . $this->host . "<br>";
            echo "Database: " . $this->db_name . "<br>";
            echo "Username: " . $this->username . "<br>";
            echo "Please check your database configuration.";
            echo "</div>";
            exit();
        }
        return $this->conn;
    }
}
?>