<?php
session_start();
require 'functions.php';
require '../../layouts/sidebar_petugas.php';

// Check if admin is logged in
if (!isset($_SESSION['username']) || $_SESSION['roles'] !== 'Admin') {
    header("Location: ../../auth/login/");
    exit;
}

// Handle verification process
if (isset($_POST['verify'])) {
    $id_order = $_POST['id_order'];
    if (verifikasiOrder($id_order)) {
        echo "<script>
                alert('Order berhasil diverifikasi!');
                window.location.href = 'index.php';
              </script>";
    } else {
        echo "<script>
                alert('Gagal memverifikasi order!');
              </script>";
    }
}

// Get active tab
$active_tab = isset($_GET['tab']) ? $_GET['tab'] : 'all';

// Prepare query based on active tab
$where_clause = "";
if ($active_tab === 'proses') {
    $where_clause = "WHERE ot.status = 'proses'";
} elseif ($active_tab === 'terverifikasi') {
    $where_clause = "WHERE ot.status = 'terverifikasi'";
}

// Handle search
if (!empty($_GET['search_penumpang'])) {
    $search_penumpang = $_GET['search_penumpang'];
    if ($where_clause) {
        $where_clause .= " AND u.nama_lengkap LIKE '%$search_penumpang%'";
    } else {
        $where_clause = "WHERE u.nama_lengkap LIKE '%$search_penumpang%'";
    }
}

// Get orders
$orders = query("SELECT 
    ot.id_order,
    ot.tanggal_transaksi,
    ot.status,
    od.jumlah_tiket,
    od.total_harga,
    od.kelas,
    u.username as nama_penumpang,
    jp.waktu_berangkat,
    jp.waktu_tiba,
    r.rute_asal,
    r.rute_tujuan,
    r.tanggal_pergi,
    m.nama_maskapai,
    m.logo_maskapai
FROM order_tiket ot
INNER JOIN order_detail od ON ot.id_order = od.id_order
INNER JOIN user u ON od.id_user = u.id_user
INNER JOIN jadwal_penerbangan jp ON od.id_penerbangan = jp.id_jadwal
INNER JOIN rute r ON jp.id_rute = r.id_rute
INNER JOIN maskapai m ON r.id_maskapai = m.id_maskapai
$where_clause
ORDER BY ot.tanggal_transaksi DESC");
?>

<div class="p-6 bg-white lg:ml-64 overflow-x-auto">
    <h1 class="text-2xl font-bold mb-4">Halo, <?= $_SESSION["email"]; ?></h1>
    <h2 class="text-xl font-semibold mb-6">Halaman Order Tiket</h2>

    <div class="border-b border-gray-300 mb-4">
    <div class="flex justify-between items-center">
        <!-- Tabs -->
        <div class="flex space-x-6">
            <a href="?tab=all" class="px-4 py-2 border-b-2 <?= $active_tab === 'all' ? 'border-blue-600 text-blue-600' : 'border-transparent hover:text-gray-600 hover:border-gray-300' ?>">Semua Order</a>
            <a href="?tab=proses" class="px-4 py-2 border-b-2 <?= $active_tab === 'proses' ? 'border-blue-600 text-blue-600' : 'border-transparent hover:text-gray-600 hover:border-gray-300' ?>">Proses Verifikasi</a>
            <a href="?tab=terverifikasi" class="px-4 py-2 border-b-2 <?= $active_tab === 'terverifikasi' ? 'border-blue-600 text-blue-600' : 'border-transparent hover:text-gray-600 hover:border-gray-300' ?>">Terverifikasi</a>
        </div>

        <!-- Search and Add Button -->
        <div class="flex items-center space-x-3">
            <form action="" method="GET" class="flex items-center border-b border-gray-300 pb-2">
                <input type="text" name="search_penumpang" placeholder="Cari Nama Penumpang..." class="px-3 py-2 border rounded-lg focus:ring focus:ring-blue-200">
                <button type="submit" class="ml-2 px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">Cari</button>
            </form>
        </div>
    </div>
</div>


        <!-- Table -->
<div class="relative overflow-x-auto shadow-lg sm:rounded-lg">
    <table class="w-full text-sm text-left text-gray-600">
        <thead class="text-xs text-gray-700 uppercase bg-gray-200">
            <tr>
                <th scope="col" class="px-6 py-3">No</th>
                <th scope="col" class="px-6 py-3">ID Order</th>
                <th scope="col" class="px-6 py-3">Tanggal Transaksi</th>
                <th scope="col" class="px-6 py-3">Nama Penumpang</th>
                <th scope="col" class="px-6 py-3">Maskapai</th>
                <th scope="col" class="px-6 py-3">Rute</th>
                <th scope="col" class="px-6 py-3">Tanggal Pergi</th>
                <th scope="col" class="px-6 py-3">Waktu</th>
                <th scope="col" class="px-6 py-3">Jumlah Tiket</th>
                <th scope="col" class="px-6 py-3">Total Harga</th>
                <th scope="col" class="px-6 py-3">Kelas</th>
                <th scope="col" class="px-6 py-3">Status</th>
                <th scope="col" class="px-6 py-3">Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($orders)): ?>
                <tr class="bg-white border-b border-gray-300">
                    <td colspan="12" class="px-6 py-4 text-center text-gray-500">Tidak ada data order</td>
                </tr>
            <?php else: ?>
                <?php $no = 1; ?>
                <?php foreach ($orders as $order): ?>
                    <tr class="bg-white border-b border-gray-300 hover:bg-gray-100">
                        <td class="px-6 py-4 text-gray-700 text-center"><?= $no++; ?></td>
                        <td class="px-6 py-4 text-gray-700 font-medium"><?= $order['id_order']; ?></td>
                        <td class="px-6 py-4"><?= date('d/m/Y', strtotime($order['tanggal_transaksi'])); ?></td>
                        <td class="px-6 py-4 text-gray-700 font-medium"><?= $order['nama_penumpang']; ?></td>
                        <td class="px-6 py-4 flex items-center">
                            <?php if ($order['logo_maskapai']): ?>
                                <img src="../../assets/images/<?= $order['logo_maskapai']; ?>" 
                                     alt="<?= $order['nama_maskapai']; ?>" 
                                     class="w-8 h-8 mr-2 rounded-full">
                            <?php endif; ?>
                            <?= $order['nama_maskapai']; ?>
                        </td>
                        <td class="px-6 py-4"><?= $order['rute_asal']; ?> - <?= $order['rute_tujuan']; ?></td>
                        <td class="px-6 py-4"><?= date('d/m/Y', strtotime($order['tanggal_pergi'])); ?></td>
                        <td class="px-6 py-4">
                            <?= date('H:i', strtotime($order['waktu_berangkat'])); ?> - 
                            <?= date('H:i', strtotime($order['waktu_tiba'])); ?>
                        </td>
                        <td class="px-6 py-4"><?= $order['jumlah_tiket']; ?></td>
                        <td class="px-6 py-4">Rp <?= number_format($order['total_harga']); ?></td>
                        <td class="px-6 py-4"><?= $order['kelas']; ?></td>

                        <td class="px-6 py-4">
                            <?php if ($order['status'] === 'proses'): ?>
                                <span class="bg-yellow-100 text-yellow-800 text-xs font-medium px-3 py-1 rounded-lg">
                                    Proses
                                </span>
                            <?php else: ?>
                                <span class="bg-green-100 text-green-800 text-xs font-medium px-3 py-1 rounded-lg">
                                    Terverifikasi
                                </span>
                            <?php endif; ?>
                        </td>
                        <td class="px-6 py-4">
                        <?php if ($order['status'] === 'proses'): ?>
                            <form action="" method="POST" class="inline">
                                <input type="hidden" name="id_order" value="<?= $order['id_order']; ?>">
                                <button type="submit" 
                                        name="verify" 
                                        onclick="return confirm('Verifikasi order ini?')"
                                        class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm">
                                    Verifikasi
                                </button>
                            </form>
                        <?php else: ?>
                            <a href="detail_order.php?id_order=<?= $order['id_order']; ?>" 
                            class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg text-sm">
                            Detail
                            </a>
                        <?php endif; ?>
                    </td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</div>
