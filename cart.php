<?php
require 'layouts/navbar.php';
?>

<div class="list-tiket-pesawat container mx-auto px-6 py-8">
    <h1 class="text-3xl font-bold text-center mb-6">List Pemesanan Tiket</h1>
    <?php if (empty($_SESSION["cart"])) { ?>
        <h1 class="text-xl text-center text-gray-600">Belum ada tiket yang kamu pesan!</h1>
    <?php } else { ?>
        <div class="overflow-x-auto">
            <form action="" method="POST">
                <div class="mb-4">
                    <label for="username" class="block text-sm font-medium text-gray-700">Nama Pemesan</label>
                    <?php if (!isset($_SESSION["id_user"])): ?>
                        <div class="text-red-500">Error: User ID not found in session!</div>
                    <?php endif; ?>
                    <input type="hidden" name="id_user" value="<?= $_SESSION["id_user"] ?? ''; ?>">
                    <input type="text" value="<?= $_SESSION["username"] ?? ''; ?>" class="w-full px-3 py-2 mt-1 border rounded-lg" disabled>
                </div>
                
                <div class="mt-6 relative overflow-x-auto shadow-md sm:rounded-lg">
                    <table class="w-full text-sm text-left text-gray-500">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-300">
                            <tr>
                                <th class="px-6 py-3">No</th>
                                <th class="px-6 py-3">Nama Maskapai</th>
                                <th class="px-6 py-3">Rute</th>
                                <th class="px-6 py-3">Tanggal Berangkat</th>
                                <th class="px-6 py-3">Waktu Keberangkatan</th>
                                <th class="px-6 py-3">Kelas</th>
                                <th class="px-6 py-3 text-right">Harga</th>
                                <th class="px-6 py-3 text-center">Kuantitas</th>
                                <th class="px-6 py-3 text-right">Total Harga</th>
                                <th class="px-6 py-3 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            <?php 
                            $no = 1; 
                            $grandTotal = 0;
                            foreach ($_SESSION["cart"] as $id_jadwal => $data) : 
                                if (!is_array($data)) {
                                    continue;
                                }
                                
                                $jadwalPenerbangan = query("SELECT * FROM jadwal_penerbangan 
                                    INNER JOIN rute ON rute.id_rute = jadwal_penerbangan.id_rute 
                                    INNER JOIN maskapai ON rute.id_maskapai = maskapai.id_maskapai 
                                    WHERE id_jadwal = '$id_jadwal'")[0];
                                
                                if (!$jadwalPenerbangan) {
                                    continue;
                                }
                                
                                $kelas = $data['kelas'] ?? 'Economy Class';
                                $kuantitas = $data['quantity'] ?? 1;
                                
                                $hargaDasar = $jadwalPenerbangan["harga"];
                                $hargaKelas = ($kelas == "Business Class" || $kelas == "First Class") ? $hargaDasar * 2 : $hargaDasar;
                                
                                $totalHarga = $hargaKelas * $kuantitas;
                                $grandTotal += $totalHarga;
                            ?>
                                <tr class="hover:bg-gray-100 text-sm">
                                    <td class="px-6 py-4 text-gray-700 text-center"> <?= $no; ?> </td>
                                    <td class="px-6 py-4 text-gray-700 font-medium"> <?= $jadwalPenerbangan["nama_maskapai"]; ?> </td>
                                    <td class="px-6 py-4 text-gray-700"> <?= $jadwalPenerbangan["rute_asal"]; ?> - <?= $jadwalPenerbangan["rute_tujuan"]; ?> </td>
                                    <td class="px-6 py-4 text-center"> <?= $jadwalPenerbangan["tanggal_pergi"]; ?> </td>
                                    <td class="px-6 py-4 text-gray-700"> <?= $jadwalPenerbangan["waktu_berangkat"]; ?> - <?= $jadwalPenerbangan["waktu_tiba"]; ?> </td>
                                    <td class="px-6 py-4 text-center"> <?= $kelas; ?> </td>
                                    <td class="px-6 py-4 text-right">Rp <?= number_format($hargaKelas); ?> </td>
                                    <td class="px-6 py-4 text-center"> <?= $kuantitas; ?> </td>
                                    <td class="px-6 py-4 text-right">Rp <?= number_format($totalHarga); ?> </td>
                                    <td class="px-6 py-4 text-center">
                                        <a href="edit_cart.php?id=<?= $id_jadwal; ?>" class="bg-blue-500 text-white px-3 py-1 rounded-lg hover:bg-blue-700 transition">Edit</a>
                                        <a href="hapus_cart.php?id=<?= $id_jadwal; ?>" class="bg-red-500 text-white px-3 py-1 rounded-lg hover:bg-red-700 transition" onclick="return confirm('Apakah Anda yakin ingin menghapus item ini?')">Hapus</a>
                                    </td>
                                </tr>
                                <?php $no++; ?>
                            <?php endforeach; ?>
                            <tr class="bg-gray-100">
                                <td class="px-6 py-4 font-semibold" colspan="8">Grand Total</td>
                                <td class="px-6 py-4 text-right font-semibold">Rp <?= number_format($grandTotal); ?></td>
                                <td class="px-6 py-4"></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="mt-4 text-right">
                    <button type="submit" name="checkout" class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded transition-colors duration-300">Checkout</button>
                </div>
            </form>
        </div>
    <?php } ?>
</div>

<?php
if (isset($_POST['checkout'])) {
    if (!isset($_POST['id_user']) || empty($_POST['id_user'])) {
        echo "<script>alert('Error: User ID is missing!');</script>";
        exit;
    }
    
    $result = checkout($_POST);
    if ($result === true) {
        echo "
        <script type='text/javascript'>
            alert('Checkout berhasil!');
            window.location = 'index.php';
        </script>";
    } else {
        echo "
        <script type='text/javascript'>
            alert('Checkout gagal! Silakan coba lagi.');
        </script>";
    }
}
?>