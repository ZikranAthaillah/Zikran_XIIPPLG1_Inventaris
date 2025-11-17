<?php
class BarangController {
    private $barang;
    private $db;

    public function __construct($database) {
        $this->db = $database;
        $this->barang = new Barang($database);
    }

    public function index() {
        $db = $this->db;
        
        // 
        $search_keyword = '';
        $category_filter = '';
        
        if (isset($_GET['search']) && !empty($_GET['search'])) {
            $search_keyword = $_GET['search'];
        }
        
        if (isset($_GET['category']) && !empty($_GET['category'])) {
            $category_filter = $_GET['category'];
        }
        
        // 
        if (!empty($search_keyword) && !empty($category_filter)) {
            // 
            $stmt = $this->barang->search($search_keyword);
            $filtered_data = [];
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                if ($row['kategori_id'] == $category_filter) {
                    $filtered_data[] = $row;
                }
            }
        } elseif (!empty($search_keyword)) {
            // 
            $stmt = $this->barang->search($search_keyword);
        } elseif (!empty($category_filter)) {
            // 
            $stmt = $this->barang->filterByCategory($category_filter);
        } else {
            // 
            $stmt = $this->barang->read();
        }
        
        include 'views/barang/index.php';
    }

    public function create() {
        $db = $this->db;
        
        if ($_POST) {
            $this->barang->nama_barang = $_POST['nama_barang'];
            $this->barang->kategori_id = $_POST['kategori_id'];
            $this->barang->stok = $_POST['stok'];
            $this->barang->harga = $_POST['harga'];
            $this->barang->tanggal_masuk = $_POST['tanggal_masuk'];
            
            if ($this->barang->create()) {
                $_SESSION['message'] = "Barang berhasil ditambahkan!";
                header("Location: index.php?page=barang");
                exit();
            } else {
                $_SESSION['message'] = "Gagal menambahkan barang! Periksa data yang dimasukkan.";
            }
        }
        include 'views/barang/create.php';
    }

    public function edit() {
        $db = $this->db;
        
        // 
        if ($_POST && isset($_POST['id'])) {
            $this->barang->id = $_POST['id'];
            $this->barang->nama_barang = $_POST['nama_barang'];
            $this->barang->kategori_id = $_POST['kategori_id'];
            $this->barang->stok = $_POST['stok'];
            $this->barang->harga = $_POST['harga'];
            $this->barang->tanggal_masuk = $_POST['tanggal_masuk'];
            
            if ($this->barang->update()) {
                $_SESSION['message'] = "Barang berhasil diperbarui!";
                header("Location: index.php?page=barang");
                exit();
            } else {
                $_SESSION['message'] = "Gagal memperbarui barang!";
            }
        }
        
        // 
        if (isset($_GET['id'])) {
            $this->barang->id = $_GET['id'];
            if ($this->barang->readOne()) {
                $barang_data = $this->barang;
                include 'views/barang/edit.php';
            } else {
                $_SESSION['message'] = "Barang tidak ditemukan!";
                header("Location: index.php?page=barang");
                exit();
            }
        } else {
            $_SESSION['message'] = "ID barang tidak valid!";
            header("Location: index.php?page=barang");
            exit();
        }
    }

    public function delete() {
        if (isset($_GET['id'])) {
            $this->barang->id = $_GET['id'];
            if ($this->barang->delete()) {
                $_SESSION['message'] = "Barang berhasil dihapus!";
            } else {
                $_SESSION['message'] = "Gagal menghapus barang!";
            }
        }
        header("Location: index.php?page=barang");
        exit();
    }
}
?>