<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sidebar Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
</head>
<body class="bg-white">
<div class="h-screen w-64 bg-gray-100 text-gray-900 fixed flex flex-col p-4 space-y-4" id="sidebar">
    <div class="flex items-center space-x-3 p-4 border-b border-gray-300">
    <img src="/e-ticketing/assets/images/a.png" alt="Logo" class="h-16 w-16"> <!-- Logo diperbesar -->
<span class="text-2xl font-bold text-blue-600">Aviatica</span> <!-- Teks diperbesar dan warna diubah -->

    </div>
    <div class="flex flex-col space-y-2">
        <a href="/e-ticketing/petugas/konfirmasi.php/" class="flex items-center space-x-2 py-2 px-4 rounded hover:bg-gray-300">
            <i class="bi bi-house-door"></i><span>Konfirmasi Pembayaran</span>
        </a>
        <a href="/e-ticketing/petugas/pengguna/" class="flex items-center space-x-2 py-2 px-4 rounded hover:bg-gray-300">
            <i class="bi bi-person-lines-fill"></i><span>Cetak Tiket</span>
        </a>
        <a href="/e-ticketing/admin/maskapai/" class="flex items-center space-x-2 py-2 px-4 rounded hover:bg-gray-300">
            <i class="bi bi-airplane"></i><span>Data Jadwal</span>
        </a>
        <a href="/e-ticketing/admin/kota/" class="flex items-center space-x-2 py-2 px-4 rounded hover:bg-gray-300">
            <i class="bi bi-geo-alt"></i><span>History Pembayaran </span>
        </a>
        <a href="/e-ticketing/auth/login/index.php" class="flex items-center space-x-2 py-2 px-4 rounded hover:bg-gray-300"
           onclick="return confirm('Apakah Anda yakin ingin logout?')">
            <i class="bi bi-box-arrow-right"></i><span>Logout</span>
        </a>
    </div>
</div>
</body>
</html>
