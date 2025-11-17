<?php 
$root = $_SERVER['DOCUMENT_ROOT'] . '/Zikran_XIIPPLG1_Inventaris';
include_once $root . '/views/layouts/header.php'; 
?>

<div class="mb-6">
    <h1 class="text-3xl font-bold text-gray-800">Daftar Kategori</h1>
    <p class="text-gray-600">Kelola kategori barang</p>
</div>

<div class="bg-white rounded-xl shadow-md p-6 mb-6">
    <div class="flex justify-between items-center">
        <div class="text-gray-600">
            Total <span class="font-bold"><?php 
                $kategori = new Kategori($db);
                $stmt = $kategori->read();
                echo $stmt->rowCount(); 
            ?></span> kategori
        </div>
        <a href="index.php?page=kategori&action=create" 
           class="bg-gradient-to-r from-green-500 to-green-600 hover:from-green-600 hover:to-green-700 text-white px-4 py-2 rounded-lg font-medium transition-all duration-300 flex items-center">
            <i class="fas fa-plus mr-2"></i>Tambah Kategori
        </a>
    </div>
</div>

<div class="bg-white rounded-xl shadow-md overflow-hidden">
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Kategori</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal Dibuat</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                <?php
                $kategori = new Kategori($db);
                $stmt = $kategori->read();
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    echo '<tr class="hover:bg-gray-50 transition-colors">';
                    echo '<td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">' . $row['id'] . '</td>';
                    echo '<td class="px-6 py-4 whitespace-nowrap">';
                    echo '<div class="text-sm font-medium text-gray-900">' . $row['nama_kategori'] . '</div>';
                    echo '</td>';
                    echo '<td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">' . date('d M Y', strtotime($row['created_at'])) . '</td>';
                    echo '<td class="px-6 py-4 whitespace-nowrap text-sm font-medium">';
                    echo '<a href="index.php?page=kategori&action=edit&id=' . $row['id'] . '" class="text-blue-600 hover:text-blue-900 mr-3"><i class="fas fa-edit"></i> Edit</a>';
                    echo '<a href="#" onclick="confirmDelete(' . $row['id'] . ')" class="text-red-600 hover:text-red-900"><i class="fas fa-trash"></i> Hapus</a>';
                    echo '</td>';
                    echo '</tr>';
                }
                ?>
            </tbody>
        </table>
    </div>
</div>


<div id="deleteModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <div class="mt-3 text-center">
            <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-red-100">
                <i class="fas fa-exclamation-triangle text-red-600 text-xl"></i>
            </div>
            <h3 class="text-lg leading-6 font-medium text-gray-900 mt-2">Konfirmasi Hapus</h3>
            <div class="mt-2 px-7 py-3">
                <p class="text-sm text-gray-500">Apakah Anda yakin ingin menghapus kategori ini?</p>
            </div>
            <div class="items-center px-4 py-3">
                <button id="cancelDelete" class="px-4 py-2 bg-gray-300 text-gray-800 text-base font-medium rounded-md w-24 shadow-sm hover:bg-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-300 mr-2">
                    Batal
                </button>
                <button id="confirmDelete" class="px-4 py-2 bg-red-600 text-white text-base font-medium rounded-md w-24 shadow-sm hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-300">
                    Hapus
                </button>
            </div>
        </div>
    </div>
</div>

<script>
let kategoriIdToDelete = null;

function confirmDelete(id) {
    kategoriIdToDelete = id;
    document.getElementById('deleteModal').classList.remove('hidden');
}

function closeModal() {
    document.getElementById('deleteModal').classList.add('hidden');
    kategoriIdToDelete = null;
}

document.getElementById('cancelDelete').addEventListener('click', closeModal);
document.getElementById('confirmDelete').addEventListener('click', function() {
    if (kategoriIdToDelete) {
        window.location.href = 'index.php?page=kategori&action=delete&id=' + kategoriIdToDelete;
    }
});
</script>

<?php include_once $root . '/views/layouts/footer.php'; ?>