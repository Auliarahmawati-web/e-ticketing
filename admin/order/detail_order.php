<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require 'functions.php';
require '../../layouts/sidebar_admin.php';

// Periksa apakah admin sudah login
if (!isset($_SESSION['username']) || $_SESSION['roles'] !== 'Admin') {
    header("Location: ../auth/login/");
    exit;
}

// Periksa apakah id_order tersedia
if (!isset($_GET['id_order'])) {
    echo "<script>alert('ID Order tidak ditemukan!'); window.location.href = 'index.php';</script>";
    exit;
}

$id_order = $_GET['id_order'];
$order = getOrderDetail($id_order);

if (!$order) {
    echo "<script>alert('Data order tidak ditemukan!'); window.location.href = 'index.php';</script>";
    exit;
}
?>

<div class="p-6 bg-white lg:ml-64 overflow-x-auto">
    <h1 class="text-2xl font-bold mb-4">Halo, <?= $_SESSION["email"]; ?></h1>
    <h2 class="text-2xl mb-4">Detail Order #<?= $order['id_order']; ?></h2>
    <table class="w-full text-sm text-left text-gray-500">
    <thead class="text-xs text-gray-700 uppercase bg-gray-300">
        <tr>
            <th class="px-6 py-3">No</th>
            <th class="px-6 py-3">Nama Penumpang</th>
            <th class="px-6 py-3">Nama Maskapai</th>
            <th class="px-6 py-3">Rute Asal</th>
            <th class="px-6 py-3">Rute Tujuan</th>
            <th class="px-6 py-3">Tanggal Pergi</th>
            <th class="px-6 py-3">Waktu Berangkat</th>
            <th class="px-6 py-3">Waktu Tiba</th>
            <th class="px-6 py-3">Jumlah Tiket</th>
            <th class="px-6 py-3">Total Harga</th>
            <th class="px-6 py-3">Kelas</th>
            <th class="px-6 py-3">Status</th>
        </tr>
    </thead>
    <tbody class="bg-white divide-y divide-gray-200">
        <tr class="hover:bg-gray-50">
            <td class="px-6 py-4 text-gray-700">1</td>
            <td class="px-6 py-4 text-gray-700 font-medium"> <?= $order['nama_penumpang']; ?> </td>
            <td class="px-6 py-4 text-gray-700"> <?= $order['nama_maskapai']; ?> </td>
            <td class="px-6 py-4 text-gray-700"> <?= $order['rute_asal']; ?> </td>
            <td class="px-6 py-4 text-gray-700"> <?= $order['rute_tujuan']; ?> </td>
            <td class="px-6 py-4 text-gray-700"> <?= date('d/m/Y', strtotime($order['tanggal_pergi'])); ?> </td>
            <td class="px-6 py-4 text-gray-700"> <?= date('H:i', strtotime($order['waktu_berangkat'])); ?> </td>
            <td class="px-6 py-4 text-gray-700"> <?= date('H:i', strtotime($order['waktu_tiba'])); ?> </td>
            <td class="px-6 py-4 text-gray-700"> <?= $order['jumlah_tiket']; ?> </td>
            <td class="px-6 py-4 font-semibold text-green-600"> Rp <?= number_format($order['total_harga']); ?> </td>
            <td class="px-6 py-4 text-gray-700"> <?= $order['kelas']; ?> </td>
            <td class="px-6 py-4 text-green-600 font-semibold"> <?= ucfirst($order['status']); ?> </td>
        </tr>
    </tbody>
</table>

    <a href="index.php" class="mt-4 inline-block px-4 py-2 bg-gray-500 hover:bg-gray-600 text-white rounded-lg text-sm">Kembali</a>
</div>
