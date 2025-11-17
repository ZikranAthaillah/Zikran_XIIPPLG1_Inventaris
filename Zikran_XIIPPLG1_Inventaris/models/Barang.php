<?php
class Barang {
    private $conn;
    private $table_name = "items";

    public $id;
    public $nama_barang;
    public $kategori_id;
    public $stok;
    public $harga;
    public $tanggal_masuk;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function read() {
        $query = "SELECT i.*, c.nama_kategori 
                  FROM " . $this->table_name . " i 
                  LEFT JOIN categories c ON i.kategori_id = c.id 
                  ORDER BY i.id DESC"; // 
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    public function create() {
        // 
        $query = "INSERT INTO items (nama_barang, kategori_id, stok, harga, tanggal_masuk) 
                  VALUES (?, ?, ?, ?, ?)";
        
        $stmt = $this->conn->prepare($query);
        
        return $stmt->execute([
            $this->nama_barang,
            $this->kategori_id,
            $this->stok,
            $this->harga,
            $this->tanggal_masuk
        ]);
    }

    public function readOne() {
        $query = "SELECT i.*, c.nama_kategori 
                  FROM " . $this->table_name . " i 
                  LEFT JOIN categories c ON i.kategori_id = c.id 
                  WHERE i.id = ? LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->id);
        $stmt->execute();
        
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($row) {
            $this->id = $row['id'];
            $this->nama_barang = $row['nama_barang'];
            $this->kategori_id = $row['kategori_id'];
            $this->stok = $row['stok'];
            $this->harga = $row['harga'];
            $this->tanggal_masuk = $row['tanggal_masuk'];
            return true;
        }
        return false;
    }

    public function update() {
        $query = "UPDATE items 
                  SET nama_barang = ?, kategori_id = ?, stok = ?, harga = ?, tanggal_masuk = ?
                  WHERE id = ?";
        
        $stmt = $this->conn->prepare($query);
        
        return $stmt->execute([
            $this->nama_barang,
            $this->kategori_id,
            $this->stok,
            $this->harga,
            $this->tanggal_masuk,
            $this->id
        ]);
    }

    public function delete() {
        $query = "DELETE FROM items WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->id);
        return $stmt->execute();
    }

    public function search($keywords) {
        $query = "SELECT i.*, c.nama_kategori 
                  FROM items i 
                  LEFT JOIN categories c ON i.kategori_id = c.id 
                  WHERE i.nama_barang LIKE ? 
                  ORDER BY i.id DESC";
        
        $stmt = $this->conn->prepare($query);
        $keywords = "%{$keywords}%";
        $stmt->bindParam(1, $keywords);
        $stmt->execute();
        return $stmt;
    }

    public function filterByCategory($category_id) {
        $query = "SELECT i.*, c.nama_kategori 
                  FROM items i 
                  LEFT JOIN categories c ON i.kategori_id = c.id 
                  WHERE i.kategori_id = ? 
                  ORDER BY i.id DESC";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $category_id);
        $stmt->execute();
        return $stmt;
    }
}
?>