<?php
session_start();
require 'functions.php';

if (!isset($_SESSION["username"])) {
    echo "
    <script type='text/javascript'>
        alert('Silahkan login terlebih dahulu, ya!');
        window.location = '../../auth/login/index.php';
    </script>
    ";
}

$search = isset($_GET['search']) ? trim($_GET['search']) : '';
$query = "SELECT * FROM maskapai";

if ($search !== '') {
    $query .= " WHERE nama_maskapai LIKE '%$search%'";
}

$maskapai = query($query);
?>

<?php require '../../layouts/sidebar_admin.php'; ?>

<div class="p-6 bg-white lg:ml-64 overflow-x-auto">
    <h1 class="text-2xl font-bold mb-4">Halo, <?= $_SESSION["nama_lengkap"]; ?></h1>
    <h2 class="text-xl font-semibold mb-6">Halaman Maskapai</h2>

    <div class="flex mb-4">
        <a href="tambah.php" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Tambah</a>
        <form method="GET" class="ml-auto">
            <input type="text" name="search" placeholder="Cari Nama Maskapai..." class="px-4 py-2 border rounded-lg" value="<?= htmlspecialchars($search); ?>">
            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Cari</button>
        </form>
    </div>

    <div class="mt-6 relative overflow-x-auto shadow-md sm:rounded-lg">
        <table class="w-full text-sm text-left text-gray-500">
            <thead class="text-xs text-gray-700 uppercase bg-gray-300">
                <tr>
                    <th class="px-6 py-3">No</th>
                    <th class="px-6 py-3">Logo</th>
                    <th class="px-6 py-3">Nama Maskapai</th>
                    <th class="px-6 py-3">Aksi</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                <?php $no = 1; ?>
                <?php foreach ($maskapai as $data) : ?>
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4"> <?= $no++; ?> </td>
                        <td class="px-6 py-4">
                            <img src="../../assets/images/<?= $data["logo_maskapai"]; ?>" 
                                 class="w-10 h-10 rounded object-contain">
                        </td>
                        <td class="px-6 py-4 text-gray-700 font-medium"> <?= $data["nama_maskapai"]; ?> </td>
                        <td class="px-6 py-4">
                            <div class="flex space-x-2">
                                <a href="edit.php?id=<?= $data["id_maskapai"]; ?>" 
                                   class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded text-sm">Edit</a>
                                <a href="hapus.php?id=<?= $data["id_maskapai"]; ?>" 
                                   class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded text-sm" 
                                   onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">Hapus</a>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>