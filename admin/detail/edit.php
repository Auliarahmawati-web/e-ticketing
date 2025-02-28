<?php
session_start();
require '../../koneksi.php';
require 'functions.php';

if (!isset($_SESSION["username"])) {
echo "<script>alert('Silahkan login terlebih dahulu!'); window.location='../../auth/login/index.php';</script>";
exit();
}

$id = $_GET['id'] ?? null;
$order_detail = getOrderDetailById($id);

if (!$order_detail) {
echo "<script>alert('Data tidak ditemukan!'); window.location='index.php';</script>";
exit();
}

$penerbangan = query("SELECT * FROM jadwal_penerbangan");
$order_tiket = query("SELECT * FROM order_tiket");
$users = query("SELECT * FROM user");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
if (editOrderDetail($_POST) > 0) {
echo "<script>alert('Data berhasil diubah!'); window.location = 'index.php';</script>";
} else {
echo "<script>alert('Data gagal diubah!');</script>";
}
}
?>

<?php require '../../layouts/sidebar_admin.php'; ?>


<div class="flex items-center justify-center min-h-screen bg-white">
    <div class="bg-white p-8 rounded-lg shadow-2xl border border-gray-300 w-96">
        <h2 class="text-xl font-bold text-center mb-4">Edit Order Detail</h2>
        
        <form method="POST">
            <input type="hidden" name="id_order_detail" value="<?= htmlspecialchars($order_detail['id_order_detail']); ?>">

            <label for="id_user" class="block text-sm font-medium">ID User</label>
            <select name="id_user" id="id_user" class="w-full px-3 py-2 mt-1 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-400">
                <?php foreach ($users as $user): ?>
                    <option value="<?= htmlspecialchars($user['id_user']); ?>" <?= $user['id_user'] == $order_detail['id_user'] ? 'selected' : ''; ?>>
                        <?= htmlspecialchars($user['id_user'] . ' - ' . $user['nama_lengkap']); ?>
                    </option>
                <?php endforeach; ?>
            </select>

            <label for="id_penerbangan" class="block text-sm font-medium mt-4">ID Penerbangan</label>
            <select name="id_penerbangan" id="id_penerbangan" class="w-full px-3 py-2 mt-1 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-400">
                <?php if (empty($penerbangan)) : ?>
                    <option value="" disabled>No penerbangan available</option>
                <?php else : ?>
                    <?php foreach ($penerbangan as $p): ?>
                        <option value="<?= htmlspecialchars($p['id_jadwal']); ?>" <?= isset($order_detail['id_penerbangan']) && $p['id_jadwal'] == $order_detail['id_penerbangan'] ? 'selected' : ''; ?>>
                            <?= htmlspecialchars($p['id_jadwal'] . ' - ' . ($p['nama_penerbangan'] ?? '')); ?>
                        </option>
                    <?php endforeach; ?>
                <?php endif; ?>
            </select>

            <label for="id_order" class="block text-sm font-medium mt-4">ID Order</label>
            <select name="id_order" id="id_order" class="w-full px-3 py-2 mt-1 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-400">
                <?php foreach ($order_tiket as $order): ?>
                    <option value="<?= htmlspecialchars($order['id_order']); ?>" <?= $order['id_order'] == $order_detail['id_order'] ? 'selected' : ''; ?>>
                        <?= htmlspecialchars($order['id_order']); ?>
                    </option>
                <?php endforeach; ?>
            </select>

            <label for="jumlah_tiket" class="block text-sm font-medium mt-4">Jumlah Tiket</label>
            <input type="number" name="jumlah_tiket" id="jumlah_tiket" value="<?= htmlspecialchars($order_detail['jumlah_tiket']); ?>" 
                class="w-full px-3 py-2 mt-1 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-400" required>

            <label for="total_harga" class="block text-sm font-medium mt-4">Total Harga</label>
            <input type="number" name="total_harga" id="total_harga" value="<?= htmlspecialchars($order_detail['total_harga']); ?>" 
                class="w-full px-3 py-2 mt-1 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-400" required>

            <button type="submit" class="w-full mt-6 bg-blue-500 text-white py-2 rounded-md shadow-md hover:bg-blue-600 transition duration-200">Simpan Perubahan</button>
        </form>
    </div>
</div>
