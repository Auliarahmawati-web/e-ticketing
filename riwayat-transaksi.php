<?php 
require 'layouts/navbar.php';

// Check if user is logged in
if (!isset($_SESSION['id_user'])) {
    header("Location: auth/login/");
    exit;
}

$id_user = $_SESSION['id_user'];

// Get all transactions for the current user
$transactions = query("SELECT 
    ot.id_order,
    ot.tanggal_transaksi,
    ot.struk,
    ot.status,
    od.jumlah_tiket,
    od.total_harga,
    jp.waktu_berangkat,
    jp.waktu_tiba,
    r.rute_asal,
    r.rute_tujuan,
    r.tanggal_pergi,
    m.nama_maskapai,
    m.logo_maskapai
FROM order_tiket ot
INNER JOIN order_detail od ON ot.id_order = od.id_order
INNER JOIN jadwal_penerbangan jp ON od.id_penerbangan = jp.id_jadwal
INNER JOIN rute r ON jp.id_rute = r.id_rute
INNER JOIN maskapai m ON r.id_maskapai = m.id_maskapai
WHERE od.id_user = '$id_user'
ORDER BY ot.tanggal_transaksi DESC");
?>

<div class="container mx-auto px-6 py-8">
    <h1 class="text-3xl font-bold text-center mb-6">Riwayat Transaksi</h1>

    <?php if (empty($transactions)): ?>
        <div class="text-center text-gray-600">
            <p>Belum ada riwayat transaksi.</p>
        </div>
    <?php else: ?>
        <div class="mt-6 relative overflow-x-auto shadow-md sm:rounded-lg">
            <table class="w-full text-sm text-left text-gray-500">
                <thead class="text-xs text-gray-700 uppercase bg-gray-300">
                    <tr>
                        <th class="px-6 py-3">No</th>
                        <th class="px-6 py-3">ID Order</th>
                        <th class="px-6 py-3">Tanggal Transaksi</th>
                        <th class="px-6 py-3">Maskapai</th>
                        <th class="px-6 py-3">Rute</th>
                        <th class="px-6 py-3">Tanggal Pergi</th>
                        <th class="px-6 py-3">Waktu</th>
                        <th class="px-6 py-3 text-center">Jumlah Tiket</th>
                        <th class="px-6 py-3 text-right">Total Harga</th>
                        <th class="px-6 py-3 text-center">Status</th>
                        <th class="px-6 py-3 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <?php $no = 1; ?>
                    <?php foreach ($transactions as $transaction): ?>
                        <tr class="hover:bg-gray-100 text-sm">
                            <td class="px-6 py-4 text-gray-700 text-center"> <?= $no++; ?> </td>
                            <td class="px-6 py-4 text-gray-700 font-medium"> <?= $transaction['id_order']; ?> </td>
                            <td class="px-6 py-4 text-gray-700"> <?= date('d/m/Y', strtotime($transaction['tanggal_transaksi'])); ?> </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center">
                                    <?php if ($transaction['logo_maskapai']): ?>
                                        <img src="assets/images/<?= $transaction['logo_maskapai']; ?>" 
                                             alt="<?= $transaction['nama_maskapai']; ?>" 
                                             class="w-8 h-8 mr-2">
                                    <?php endif; ?>
                                    <?= $transaction['nama_maskapai']; ?>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-gray-700"> <?= $transaction['rute_asal']; ?> - <?= $transaction['rute_tujuan']; ?> </td>
                            <td class="px-6 py-4 text-gray-700"> <?= date('d/m/Y', strtotime($transaction['tanggal_pergi'])); ?> </td>
                            <td class="px-6 py-4 text-gray-700">
                                <?= date('H:i', strtotime($transaction['waktu_berangkat'])); ?> - 
                                <?= date('H:i', strtotime($transaction['waktu_tiba'])); ?>
                            </td>
                            <td class="px-6 py-4 text-center text-gray-700"> <?= $transaction['jumlah_tiket']; ?> </td>
                            <td class="px-6 py-4 text-right text-gray-700">Rp <?= number_format($transaction['total_harga']); ?> </td>
                            <td class="px-6 py-4 text-center">
                            <span class="px-3 py-1 font-semibold 
                                <?= $transaction['status'] === 'proses' ? 'text-yellow-500 bg-yellow-100' : 'text-green-500 bg-green-100'; ?> 
                                rounded-full text-sm flex items-center justify-center w-fit mx-auto">
                                <?= ucfirst($transaction['status'] === 'proses' ? 'Tiket dalam proses' : 'Tiket terverifikasi'); ?>
                            </span>
                            <td class="px-6 py-4 text-center">
                            <?php if ($transaction['status'] === 'terverifikasi'): ?>
                                <a href="cetak.php?id_order=<?= $transaction['id_order']; ?>" 
                                class="px-3 py-1 text-white bg-blue-500 hover:bg-blue-600 rounded text-sm">
                                Cetak
                                </a>
                            <?php endif; ?>
                        </td>

                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>
</div>

