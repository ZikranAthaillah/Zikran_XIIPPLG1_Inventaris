<?php 
// 
$root = $_SERVER['DOCUMENT_ROOT'] . '/Zikran_XIIPPLG1_Inventaris';
include_once $root . '/views/layouts/header.php'; 
?>

<div class="mb-6">
    <h1 class="text-3xl font-bold text-gray-800">Tambah Kategori Baru</h1>
    <p class="text-gray-600">Tambahkan kategori baru untuk barang</p>
</div>

<div class="bg-white rounded-xl shadow-md p-6 max-w-md">
    <form id="kategoriForm" action="index.php?page=kategori&action=create" method="POST">
        <div class="mb-6">
            <label for="nama_kategori" class="block text-sm font-medium text-gray-700 mb-2">Nama Kategori *</label>
            <input type="text" id="nama_kategori" name="nama_kategori" 
                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all"
                   placeholder="Contoh: Elektronik, Furnitur, dll."
                   required>
            <div id="nama_error" class="text-red-500 text-sm mt-1 hidden">Nama kategori tidak boleh kosong</div>
        </div>

        <div class="flex gap-3">
            <button type="submit" class="bg-gradient-to-r from-green-500 to-green-600 hover:from-green-600 hover:to-green-700 text-white px-6 py-2 rounded-lg font-medium transition-all duration-300 flex items-center">
                <i class="fas fa-save mr-2"></i>Simpan Kategori
            </button>
            <a href="index.php?page=kategori" class="bg-gray-300 hover:bg-gray-400 text-gray-800 px-6 py-2 rounded-lg font-medium transition-all duration-300 flex items-center">
                <i class="fas fa-arrow-left mr-2"></i>Kembali
            </a>
        </div>
    </form>
</div>

<script>
document.getElementById('kategoriForm').addEventListener('submit', function(e) {
    const namaKategori = document.getElementById('nama_kategori').value.trim();
    
    if (!namaKategori) {
        document.getElementById('nama_error').classList.remove('hidden');
        e.preventDefault();
    } else {
        document.getElementById('nama_error').classList.add('hidden');
    }
});
</script>

<?php include_once $root . '/views/layouts/footer.php'; ?>