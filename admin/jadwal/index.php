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

$search = isset($_GET['search']) ? $_GET['search'] : '';
$jadwal = query("SELECT * FROM jadwal_penerbangan 
INNER JOIN rute ON rute.id_rute = jadwal_penerbangan.id_rute 
INNER JOIN maskapai ON rute.id_maskapai = maskapai.id_maskapai 
WHERE maskapai.nama_maskapai LIKE '%$search%' 
ORDER BY tanggal_pergi, waktu_berangkat");
?>

<?php require '../../layouts/sidebar_admin.php'; ?>

<div class="p-6 bg-white lg:ml-64 overflow-x-auto">
    <h1 class="text-2xl font-bold mb-4">Halo, <?= $_SESSION["email"]; ?></h1>
    <h2 class="text-xl font-semibold mb-6">Halaman Jadwal Penerbangan</h2>

    <div class="flex items-center justify-between">
    <a href="tambah.php" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Tambah</a>
    
    <form method="GET" class="flex items-center space-x-2">
        <input type="text" name="search" placeholder="Cari Nama Maskapai..." class="border px-3 py-2 rounded focus:outline-none focus:ring-2 focus:ring-blue-300">
        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Cari</button>
    </form>
</div>


    <div class="mt-6 relative overflow-x-auto shadow-md sm:rounded-lg">
        <table class="w-full text-sm text-left text-gray-500">
            <thead class="text-xs text-gray-700 uppercase bg-gray-300">
                <tr>
                    <th class="px-6 py-3">No</th>
                    <th class="px-6 py-3">Nama Maskapai</th>
                    <th class="px-6 py-3">Kapasitas</th>
                    <th class="px-6 py-3">Rute Asal</th>
                    <th class="px-6 py-3">Rute Tujuan</th>
                    <th class="px-6 py-3">Tanggal Pergi</th>
                    <th class="px-6 py-3">Waktu Berangkat</th>
                    <th class="px-6 py-3">Waktu Tiba</th>
                    <th class="px-6 py-3">Harga</th>
                    <th class="px-6 py-3">Aksi</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                <?php $no = 1; ?>
                <?php foreach ($jadwal as $data) : ?>
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 text-gray-700"> <?= $no++; ?> </td>
                        <td class="px-6 py-4 text-gray-700 font-medium"> <?= $data["nama_maskapai"]; ?> </td>
                        <td class="px-6 py-4 text-gray-700"> <?= $data["kapasitas_kursi"]; ?> </td>
                        <td class="px-6 py-4 text-gray-700"> <?= $data["rute_asal"]; ?> </td>
                        <td class="px-6 py-4 text-gray-700"> <?= $data["rute_tujuan"]; ?> </td>
                        <td class="px-6 py-4 text-gray-700"> <?= $data["tanggal_pergi"]; ?> </td>
                        <td class="px-6 py-4 text-gray-700"> <?= $data["waktu_berangkat"]; ?> </td>
                        <td class="px-6 py-4 text-gray-700"> <?= $data["waktu_tiba"]; ?> </td>
                        <td class="px-6 py-4 font-semibold text-green-600"> Rp <?= number_format($data["harga"]); ?> </td>
                        <td class="px-6 py-4">
                            <div class="flex space-x-2">
                                <a href="edit.php?id=<?= $data["id_jadwal"]; ?>" 
                                   class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded text-sm">Edit</a>
                                <a href="hapus.php?id=<?= $data["id_jadwal"]; ?>" 
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

<?php require '../../layouts/footer2.php'; ?>
</div>