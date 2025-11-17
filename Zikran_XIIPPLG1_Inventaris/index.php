<?php
session_start();

// Include database and models
include_once 'config/database.php';
include_once 'models/Barang.php';
include_once 'models/Kategori.php';
include_once 'controllers/BarangController.php';
include_once 'controllers/KategoriController.php';

// Initialize database connection
$database = new Database();
$db = $database->getConnection();

// Route handling
$page = isset($_GET['page']) ? $_GET['page'] : 'barang';
$action = isset($_GET['action']) ? $_GET['action'] : 'index';

if ($page == 'barang') {
    $controller = new BarangController($db);
    switch ($action) {
        case 'create':
            $controller->create();
            break;
        case 'edit':
            $controller->edit();
            break;
        case 'delete':
            $controller->delete();
            break;
        default:
            $controller->index();
            break;
    }
// Di file index.php, pastikan routing untuk update ada
} elseif ($page == 'kategori') {
    $controller = new KategoriController($db);
    switch ($action) {
        case 'create':
            $controller->create();
            break;
        case 'edit':
            $controller->edit();
            break;
        case 'update':  // PASTIKAN INI ADA!
            $controller->edit(); // atau buat method update() terpisah
            break;
        case 'delete':
            $controller->delete();
            break;
        default:
            $controller->index();
            break;
    }
}
?>