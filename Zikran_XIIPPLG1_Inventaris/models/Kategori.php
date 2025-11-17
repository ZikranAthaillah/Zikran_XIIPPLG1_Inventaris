<?php
class Kategori {
    private $conn;
    private $table_name = "categories";

    public $id;
    public $nama_kategori;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function read() {
        $query = "SELECT * FROM " . $this->table_name . " ORDER BY nama_kategori";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    public function readOne() {
        try {
            $query = "SELECT id, nama_kategori FROM " . $this->table_name . " WHERE id = ? LIMIT 1";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(1, $this->id);
            $stmt->execute();
            
            if ($stmt->rowCount() > 0) {
                $row = $stmt->fetch(PDO::FETCH_ASSOC);
                $this->id = $row['id'];
                $this->nama_kategori = $row['nama_kategori'];
                return true;
            } else {
                return false;
            }
        } catch (PDOException $e) {
            error_log("Error in readOne: " . $e->getMessage());
            return false;
        }
    }

    public function create() {
        try {
            $query = "INSERT INTO " . $this->table_name . " SET nama_kategori = :nama_kategori";
            $stmt = $this->conn->prepare($query);
            
            $this->nama_kategori = htmlspecialchars(strip_tags($this->nama_kategori));
            $stmt->bindParam(":nama_kategori", $this->nama_kategori);
            
            return $stmt->execute();
        } catch (PDOException $e) {
            error_log("Error in create: " . $e->getMessage());
            return false;
        }
    }

    public function update() {
        try {
            $query = "UPDATE " . $this->table_name . " SET nama_kategori = :nama_kategori WHERE id = :id";
            $stmt = $this->conn->prepare($query);
            
            $this->nama_kategori = htmlspecialchars(strip_tags($this->nama_kategori));
            $this->id = htmlspecialchars(strip_tags($this->id));
            
            $stmt->bindParam(":nama_kategori", $this->nama_kategori);
            $stmt->bindParam(":id", $this->id);
            
            return $stmt->execute();
        } catch (PDOException $e) {
            error_log("Error in update: " . $e->getMessage());
            return false;
        }
    }

    public function delete() {
        try {
            // 
            $check_query = "SELECT COUNT(*) as total FROM items WHERE kategori_id = ?";
            $check_stmt = $this->conn->prepare($check_query);
            $check_stmt->bindParam(1, $this->id);
            $check_stmt->execute();
            $result = $check_stmt->fetch(PDO::FETCH_ASSOC);
            
            if ($result['total'] > 0) {
                // 
                return false;
            }
            
            $query = "DELETE FROM " . $this->table_name . " WHERE id = ?";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(1, $this->id);
            
            return $stmt->execute();
        } catch (PDOException $e) {
            error_log("Error in delete: " . $e->getMessage());
            return false;
        }
    }
}
?>