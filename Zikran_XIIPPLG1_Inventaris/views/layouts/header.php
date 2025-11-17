<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Manajemen Inventaris</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .nav-link {
            color: white;
            padding: 0.5rem 0.75rem;
            border-radius: 0.375rem;
            font-size: 0.875rem;
            font-weight: 500;
            transition: all 0.3s;
            display: inline-flex;
            align-items: center;
        }
        .nav-link:hover {
            background-color: rgba(234, 179, 8, 0.3);
        }
        .nav-link.active {
            background-color: #eab308;
        }
    </style>
</head>
<body class="bg-gray-50">
    
    <nav class="bg-gradient-to-r from-yellow-500 via-amber-500 to-orange-500 shadow-lg">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <div class="flex-shrink-0 flex items-center">
                        <i class="fas fa-boxes text-white text-2xl mr-3"></i>
                        <span class="text-white font-bold text-xl">InventarisLe</span>
                    </div>
                    <div class="hidden md:ml-6 md:flex md:space-x-4">
                        <a href="index.php?page=barang" class="nav-link <?php echo (!isset($_GET['page']) || $_GET['page'] == 'barang') ? 'active' : ''; ?>">
                            <i class="fas fa-box mr-2"></i>Barang
                        </a>
                        <a href="index.php?page=kategori" class="nav-link <?php echo (isset($_GET['page']) && $_GET['page'] == 'kategori') ? 'active' : ''; ?>">
                            <i class="fas fa-tags mr-2"></i>Kategori
                        </a>
                    </div>
                </div>
                <div class="flex items-center">
                    
                </div>
            </div>
        </div>
    </nav>
    
    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
        <?php if (isset($_SESSION['message'])): ?>
            <div id="notification" class="bg-yellow-100 border border-yellow-400 text-yellow-800 px-4 py-3 rounded relative mb-4 transition-all duration-300" role="alert">
                <span class="block sm:inline"><?php echo $_SESSION['message']; ?></span>
                <span class="absolute top-0 bottom-0 right-0 px-4 py-3">
                    <svg class="fill-current h-6 w-6 text-yellow-600" role="button" onclick="this.parentElement.parentElement.style.display='none'" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                        <title>Close</title>
                        <path d="M14.348 14.849a1.2 1.2 0 0 1-1.697 0L10 11.819l-2.651 3.029a1.2 1.2 0 1 1-1.697-1.697l2.758-3.15-2.759-3.152a1.2 1.2 0 1 1 1.697-1.697L10 8.183l2.651-3.031a1.2 1.2 0 1 1 1.697 1.697l-2.758 3.152 2.758 3.15a1.2 1.2 0 0 1 0 1.698z"/>
                    </svg>
                </span>
            </div>
            <?php unset($_SESSION['message']); ?>
        <?php endif; ?>
</body>
</html>