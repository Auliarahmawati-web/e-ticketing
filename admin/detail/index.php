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
    exit;
}

// Handle search
$search_query = "";
if (isset($_GET['search']) && !empty($_GET['search'])) {
    $search_query = $_GET['search'];
    $order_details = query("SELECT * FROM order_detail WHERE id_user LIKE '%$search_query%'");
} else {
    $order_details = query("SELECT * FROM order_detail");
}

?>

<?php require '../../layouts/sidebar_admin.php'; ?>

<div class="p-6 bg-white lg:ml-64 overflow-x-auto">
    <h1 class="text-2xl font-bold mb-4">Halo, <?= $_SESSION["nama_lengkap"]; ?></h1>
    <h2 class="text-xl font-semibold mb-6">Halaman Data Order Detail</h2>

    <div class="flex justify-between mb-4">
        <a href="tambah.php" class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600 transition duration-200">Tambah</a>

        <!-- Form Pencarian -->
        <form method="GET" class="flex space-x-2">
            <input type="text" name="search" placeholder="Cari ID User..." value="<?= htmlspecialchars($search_query); ?>"
                class="px-4 py-2 border border-gray-300 rounded-lg focus:ring focus:ring-blue-200 focus:outline-none">
            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600 transition duration-200">Cari</button>
        </form>
    </div>

    <div class="mt-6 relative overflow-x-auto shadow-md sm:rounded-lg">
        <table class="w-full text-sm text-left text-gray-500">
            <thead class="text-xs text-gray-700 uppercase bg-gray-300">
                <tr>
                    <th class="px-6 py-3">No</th>
                    <th class="px-6 py-3">ID User</th>
                    <th class="px-6 py-3">ID Penerbangan</th>
                    <th class="px-6 py-3">ID Order</th>
                    <th class="px-6 py-3">Jumlah Tiket</th>
                    <th class="px-6 py-3">Total Harga</th>
                    <th class="px-6 py-3 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($order_details)) : ?>
                    <tr class="bg-white border-b">
                        <td colspan="7" class="px-6 py-4 text-center">Tidak ada data order detail</td>
                    </tr>
                <?php else : ?>
                    <?php $no = 1; ?>
                    <?php foreach ($order_details as $data) : ?>
                        <tr class="bg-white border-b hover:bg-gray-50">
                            <td class="px-6 py-4 text-gray-700 text-center"><?= $no++; ?></td>
                            <td class="px-6 py-4 text-gray-700 font-medium"><?= htmlspecialchars($data["id_user"]); ?></td>
                            <td class="px-6 py-4 text-gray-700 font-medium"><?= htmlspecialchars($data["id_penerbangan"]); ?></td>
                            <td class="px-6 py-4 text-gray-700 font-medium"><?= htmlspecialchars($data["id_order"]); ?></td>
                            <td class="px-6 py-4 text-gray-700 text-center"><?= htmlspecialchars($data["jumlah_tiket"]); ?></td>
                            <td class="px-6 py-4 text-center font-semibold text-green-600">Rp <?= number_format($data["total_harga"], 0, ',', '.'); ?></td>
                            <td class="px-6 py-4 flex justify-center space-x-2">
                                <a href="edit.php?id=<?= $data["id_order_detail"]; ?>" class="bg-blue-500 text-white px-3 py-1 rounded-lg hover:bg-blue-700 transition duration-200">Edit</a>
                                <a href="hapus.php?id=<?= $data["id_order_detail"]; ?>" class="bg-red-500 text-white px-3 py-1 rounded-lg hover:bg-red-700 transition duration-200" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">Hapus</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
