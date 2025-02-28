<?php
session_start();
require 'functions.php';

// Pastikan user sudah login
if (!isset($_SESSION["username"])) {
    echo "<script>alert('Silahkan login terlebih dahulu!'); window.location = '../../auth/login/index.php';</script>";
    exit;
}

// Proses form jika dikirim
if (isset($_POST["submit"])) {
    if (tambahOrderDetail($_POST) > 0) {
        echo "<script>alert('Data berhasil ditambahkan!'); window.location = 'index.php';</script>";
    } else {
        echo "<script>alert('Data gagal ditambahkan!'); window.location = 'index.php';</script>";
    }
}

// Ambil data dari database
$users = query("SELECT * FROM user");
$penerbangan = query("SELECT * FROM jadwal_penerbangan");
$order_tiket = query("SELECT * FROM order_tiket");
?>

<?php require '../../layouts/sidebar_admin.php'; ?>

<div class="flex items-center justify-center min-h-screen bg-white">
    <div class="bg-white p-8 rounded-lg shadow-2xl border border-gray-300 w-96">
        <h2 class="text-xl font-bold text-center mb-4">Tambah Order Detail</h2>
        
        <form action="" method="post">
            <label for="id_user" class="block text-sm font-medium">ID User</label>
            <select name="id_user" id="id_user" class="w-full px-3 py-2 mt-1 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-400" required>
                <option value="">Pilih ID User</option>
                <?php foreach ($users as $user): ?>
                    <option value="<?= htmlspecialchars($user['id_user']); ?>">
                        <?= htmlspecialchars($user['id_user'] . ' - ' . $user['nama_lengkap']); ?>
                    </option>
                <?php endforeach; ?>
            </select>

            <label for="id_penerbangan" class="block text-sm font-medium mt-4">ID Penerbangan</label>
            <select name="id_penerbangan" id="id_penerbangan" class="w-full px-3 py-2 mt-1 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-400" required>
                <option value="">Pilih ID Penerbangan</option>
                <?php foreach ($penerbangan as $p): ?>
                    <option value="<?= htmlspecialchars($p['id_jadwal']); ?>">
                        <?= htmlspecialchars($p['id_jadwal'] . (!empty($p['nama_penerbangan']) ? ' - ' . $p['nama_penerbangan'] : '')); ?>
                    </option>
                <?php endforeach; ?>
            </select>

            <label for="id_order" class="block text-sm font-medium mt-4">ID Order</label>
            <select name="id_order" id="id_order" class="w-full px-3 py-2 mt-1 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-400" required>
                <option value="">Pilih ID Order</option>
                <?php foreach ($order_tiket as $order): ?>
                    <option value="<?= htmlspecialchars($order['id_order']); ?>">
                        <?= htmlspecialchars($order['id_order']); ?>
                    </option>
                <?php endforeach; ?>
            </select>

            <label for="jumlah_tiket" class="block text-sm font-medium mt-4">Jumlah Tiket</label>
            <input type="number" name="jumlah_tiket" id="jumlah_tiket" class="w-full px-3 py-2 mt-1 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-400" required>

            <label for="total_harga" class="block text-sm font-medium mt-4">Total Harga</label>
            <input type="number" name="total_harga" id="total_harga" class="w-full px-3 py-2 mt-1 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-400" required>

            <button type="submit" name="submit" class="w-full mt-6 bg-blue-500 text-white py-2 rounded-md shadow-md hover:bg-blue-600 transition duration-200">Tambah</button>
        </form>
    </div>
</div>
