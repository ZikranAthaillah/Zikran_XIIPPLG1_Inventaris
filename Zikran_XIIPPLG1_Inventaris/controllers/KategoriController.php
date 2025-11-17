<?php
class KategoriController {
    private $kategori;
    private $db;

    public function __construct($database) {
        $this->db = $database;
        $this->kategori = new Kategori($database);
    }

    public function index() {
        $db = $this->db;
        include 'views/kategori/index.php';
    }

    public function create() {
        $db = $this->db;
        if ($_POST) {
            $this->kategori->nama_kategori = $_POST['nama_kategori'];
            
            if ($this->kategori->create()) {
                $_SESSION['message'] = "Kategori berhasil ditambahkan!";
                header("Location: index.php?page=kategori");
                exit();
            } else {
                $_SESSION['message'] = "Gagal menambahkan kategori!";
            }
        }
        include 'views/kategori/create.php';
    }

    public function edit() {
        $db = $this->db;
        
        // 
        if ($_POST && isset($_POST['id'])) {
            $this->kategori->id = $_POST['id'];
            $this->kategori->nama_kategori = $_POST['nama_kategori'];
            
            if ($this->kategori->update()) {
                $_SESSION['message'] = "Kategori berhasil diperbarui!";
                header("Location: index.php?page=kategori");
                exit();
            } else {
                $_SESSION['message'] = "Gagal memperbarui kategori!";
            }
        }
        
        // 
        if (isset($_GET['id'])) {
            $this->kategori->id = $_GET['id'];
            if ($this->kategori->readOne()) {
                $kategori_data = $this->kategori;
                include 'views/kategori/edit.php';
            } else {
                $_SESSION['message'] = "Kategori tidak ditemukan!";
                header("Location: index.php?page=kategori");
                exit();
            }
        } else {
            $_SESSION['message'] = "ID kategori tidak valid!";
            header("Location: index.php?page=kategori");
            exit();
        }
    }

    public function delete() {
        if (isset($_GET['id'])) {
            $this->kategori->id = $_GET['id'];
            if ($this->kategori->delete()) {
                $_SESSION['message'] = "Kategori berhasil dihapus!";
            } else {
                $_SESSION['message'] = "Gagal menghapus kategori! Kategori mungkin masih digunakan oleh barang.";
            }
        }
        header("Location: index.php?page=kategori");
        exit();
    }
}
?>