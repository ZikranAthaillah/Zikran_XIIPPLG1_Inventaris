<?php 
$root = $_SERVER['DOCUMENT_ROOT'] . '/Zikran_XIIPPLG1_Inventaris';
include_once $root . '/views/layouts/header.php'; 

// 
if (!isset($barang_data) || empty($barang_data->id)) {
    echo "<script>alert('Error: Data barang tidak ditemukan!'); window.location.href='index.php?page=barang';</script>";
    exit();
}
?>

<div class="mb-6">
    <h1 class="text-3xl font-bold text-gray-800">Edit Barang</h1>
    <p class="text-gray-600">Perbarui informasi barang</p>
</div>

<div class="bg-white rounded-xl shadow-md p-6">
    <form id="barangForm" action="index.php?page=barang&action=edit" method="POST">
        <input type="hidden" name="id" value="<?php echo $barang_data->id; ?>">
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            
            <div>
                <label for="nama_barang" class="block text-sm font-medium text-gray-700 mb-2">Nama Barang *</label>
                <input type="text" id="nama_barang" name="nama_barang" 
                       value="<?php echo htmlspecialchars($barang_data->nama_barang); ?>"
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all"
                       required>
                <div id="nama_error" class="text-red-500 text-sm mt-1 hidden">Nama barang tidak boleh kosong</div>
            </div>

            
            <div>
                <label for="kategori_id" class="block text-sm font-medium text-gray-700 mb-2">Kategori *</label>
                <select id="kategori_id" name="kategori_id" 
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all"
                        required>
                    <option value="">Pilih Kategori</option>
                    <?php
                    $kategori = new Kategori($db);
                    $stmt = $kategori->read();
                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                        $selected = ($barang_data->kategori_id == $row['id']) ? 'selected' : '';
                        echo '<option value="' . $row['id'] . '" ' . $selected . '>' . $row['nama_kategori'] . '</option>';
                    }
                    ?>
                </select>
                <div id="kategori_error" class="text-red-500 text-sm mt-1 hidden">Pilih kategori barang</div>
            </div>

            
            <div>
                <label for="stok" class="block text-sm font-medium text-gray-700 mb-2">Stok *</label>
                <input type="number" id="stok" name="stok" min="0"
                       value="<?php echo $barang_data->stok; ?>"
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all"
                       required>
                <div id="stok_error" class="text-red-500 text-sm mt-1 hidden">Stok harus angka dan tidak boleh negatif</div>
            </div>

            
            <div>
                <label for="harga" class="block text-sm font-medium text-gray-700 mb-2">Harga (Rp) *</label>
                <input type="number" id="harga" name="harga" min="0" step="100"
                       value="<?php echo $barang_data->harga; ?>"
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all"
                       required>
                <div id="harga_error" class="text-red-500 text-sm mt-1 hidden">Harga harus angka dan tidak boleh negatif</div>
            </div>

            
            <div class="md:col-span-2">
                <label for="tanggal_masuk" class="block text-sm font-medium text-gray-700 mb-2">Tanggal Masuk *</label>
                <input type="date" id="tanggal_masuk" name="tanggal_masuk"
                       value="<?php echo $barang_data->tanggal_masuk; ?>"
                       class="w-full md:w-1/2 px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all"
                       required>
                <div id="tanggal_error" class="text-red-500 text-sm mt-1 hidden">Tanggal masuk tidak valid</div>
            </div>
        </div>

        <div class="mt-8 flex gap-3">
            <button type="submit" class="bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white px-6 py-2 rounded-lg font-medium transition-all duration-300 flex items-center">
                <i class="fas fa-save mr-2"></i>Update Barang
            </button>
            <a href="index.php?page=barang" class="bg-gray-300 hover:bg-gray-400 text-gray-800 px-6 py-2 rounded-lg font-medium transition-all duration-300 flex items-center">
                <i class="fas fa-arrow-left mr-2"></i>Kembali
            </a>
        </div>
    </form>
</div>

<script>
document.getElementById('barangForm').addEventListener('submit', function(e) {
    let isValid = true;
    
    const namaBarang = document.getElementById('nama_barang').value.trim();
    if (!namaBarang) {
        document.getElementById('nama_error').classList.remove('hidden');
        isValid = false;
    } else {
        document.getElementById('nama_error').classList.add('hidden');
    }
    
    const kategori = document.getElementById('kategori_id').value;
    if (!kategori) {
        document.getElementById('kategori_error').classList.remove('hidden');
        isValid = false;
    } else {
        document.getElementById('kategori_error').classList.add('hidden');
    }
    
    const stok = document.getElementById('stok').value;
    if (stok < 0 || isNaN(stok)) {
        document.getElementById('stok_error').classList.remove('hidden');
        isValid = false;
    } else {
        document.getElementById('stok_error').classList.add('hidden');
    }
    
    const harga = document.getElementById('harga').value;
    if (harga < 0 || isNaN(harga)) {
        document.getElementById('harga_error').classList.remove('hidden');
        isValid = false;
    } else {
        document.getElementById('harga_error').classList.add('hidden');
    }
    
    const tanggal = document.getElementById('tanggal_masuk').value;
    if (!tanggal) {
        document.getElementById('tanggal_error').classList.remove('hidden');
        isValid = false;
    } else {
        document.getElementById('tanggal_error').classList.add('hidden');
    }
    
    if (!isValid) {
        e.preventDefault();
    }
});
</script>

<?php include_once $root . '/views/layouts/footer.php'; ?>