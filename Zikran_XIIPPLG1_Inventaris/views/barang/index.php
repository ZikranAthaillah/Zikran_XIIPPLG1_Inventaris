<?php 
$root = $_SERVER['DOCUMENT_ROOT'] . '/Zikran_XIIPPLG1_Inventaris';
include_once $root . '/views/layouts/header.php'; 

// 
echo "<!-- DEBUG: Start of barang index -->";
?>

<div class="mb-6">
    <h1 class="text-3xl font-bold text-gray-800">Daftar Barang</h1>
    <p class="text-gray-600">Kelola inventaris barang di gudang</p>
</div>


<div class="bg-white rounded-xl shadow-md p-6 mb-6">
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div class="flex-1">
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <i class="fas fa-search text-gray-400"></i>
                </div>
                <input type="text" id="searchInput" placeholder="Cari nama barang..." 
                       class="pl-10 pr-4 py-2 w-full border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all">
            </div>
        </div>
        <div class="flex gap-3">
            <select id="categoryFilter" class="border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                <option value="">Semua Kategori</option>
                <?php
                $kategori = new Kategori($db);
                $stmt = $kategori->read();
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    echo '<option value="' . $row['id'] . '">' . $row['nama_kategori'] . '</option>';
                }
                ?>
            </select>
            <a href="index.php?page=barang&action=create" 
               class="bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white px-4 py-2 rounded-lg font-medium transition-all duration-300 flex items-center">
                <i class="fas fa-plus mr-2"></i>Tambah Barang
            </a>
        </div>
    </div>
</div>


<div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4 mb-4">
    <h3 class="font-bold text-yellow-800">🔍 DEBUG INFO:</h3>
    <?php
    $barang = new Barang($db);
    $stmt = $barang->read();
    $total_barang = $stmt->rowCount();
    echo "<p>Total barang dalam database: <strong>" . $total_barang . "</strong></p>";
    
    // 
    $stmt = $barang->read();
    echo "<p>3 Barang terbaru:</p>";
    $count = 0;
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        if ($count < 3) {
            echo "<div class='text-sm'>- ID: " . $row['id'] . " | " . $row['nama_barang'] . " | Stok: " . $row['stok'] . "</div>";
            $count++;
        } else {
            break;
        }
    }
    
    // 
    if (isset($_SESSION['message'])) {
        echo "<p class='mt-2'>Session Message: <strong>" . $_SESSION['message'] . "</strong></p>";
    }
    ?>
</div>


<div class="bg-white rounded-xl shadow-md overflow-hidden">
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Barang</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kategori</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Stok</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Harga</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal Masuk</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                </tr>
            </thead>
            <tbody id="tableBody" class="bg-white divide-y divide-gray-200">
                <?php
                $barang = new Barang($db);
                $stmt = $barang->read();
                
                if ($stmt->rowCount() > 0) {
                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                        echo '<tr class="hover:bg-gray-50 transition-colors">';
                        echo '<td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">' . $row['id'] . '</td>';
                        echo '<td class="px-6 py-4 whitespace-nowrap">';
                        echo '<div class="text-sm font-medium text-gray-900 barang-nama">' . $row['nama_barang'] . '</div>';
                        echo '</td>';
                        echo '<td class="px-6 py-4 whitespace-nowrap">';
                        echo '<span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800 kategori-nama">' . $row['nama_kategori'] . '</span>';
                        echo '</td>';
                        echo '<td class="px-6 py-4 whitespace-nowrap">';
                        echo '<div class="text-sm text-gray-900">' . $row['stok'] . '</div>';
                        echo '</td>';
                        echo '<td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">Rp ' . number_format($row['harga'], 0, ',', '.') . '</td>';
                        echo '<td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">' . date('d M Y', strtotime($row['tanggal_masuk'])) . '</td>';
                        echo '<td class="px-6 py-4 whitespace-nowrap text-sm font-medium">';
                        echo '<a href="index.php?page=barang&action=edit&id=' . $row['id'] . '" class="text-blue-600 hover:text-blue-900 mr-3"><i class="fas fa-edit"></i></a>';
                        echo '<a href="#" onclick="confirmDelete(' . $row['id'] . ')" class="text-red-600 hover:text-red-900"><i class="fas fa-trash"></i></a>';
                        echo '</td>';
                        echo '</tr>';
                    }
                } else {
                    echo '<tr>';
                    echo '<td colspan="7" class="px-6 py-4 text-center text-gray-500">';
                    echo '<i class="fas fa-inbox mr-2"></i>Belum ada data barang';
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
                <p class="text-sm text-gray-500">Apakah Anda yakin ingin menghapus barang ini?</p>
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
let itemIdToDelete = null;

function confirmDelete(id) {
    itemIdToDelete = id;
    document.getElementById('deleteModal').classList.remove('hidden');
}

function closeModal() {
    document.getElementById('deleteModal').classList.add('hidden');
    itemIdToDelete = null;
}

document.getElementById('cancelDelete').addEventListener('click', closeModal);
document.getElementById('confirmDelete').addEventListener('click', function() {
    if (itemIdToDelete) {
        window.location.href = 'index.php?page=barang&action=delete&id=' + itemIdToDelete;
    }
});

// 
let searchTimeout;
document.getElementById('searchInput').addEventListener('input', function(e) {
    clearTimeout(searchTimeout);
    searchTimeout = setTimeout(() => {
        const searchTerm = e.target.value.toLowerCase();
        const rows = document.querySelectorAll('#tableBody tr');
        
        rows.forEach(row => {
            const itemName = row.querySelector('.barang-nama').textContent.toLowerCase();
            if (itemName.includes(searchTerm)) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    }, 300);
});

// 
document.getElementById('categoryFilter').addEventListener('change', function(e) {
    const categoryId = e.target.value;
    const rows = document.querySelectorAll('#tableBody tr');
    
    rows.forEach(row => {
        if (!categoryId) {
            row.style.display = '';
        } else {
            const rowCategory = row.querySelector('.kategori-nama').textContent;
            const categoryOptions = document.getElementById('categoryFilter').options;
            let selectedCategoryName = '';
            
            for (let option of categoryOptions) {
                if (option.value === categoryId) {
                    selectedCategoryName = option.text;
                    break;
                }
            }
            
            if (rowCategory === selectedCategoryName) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        }
    });
});
</script>

<?php include_once $root . '/views/layouts/footer.php'; ?>