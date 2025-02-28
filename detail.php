<?php 
require 'layouts/navbar.php';

$id = $_GET['id'];

$jadwal = query("SELECT * FROM jadwal_penerbangan 
    INNER JOIN rute ON rute.id_rute = jadwal_penerbangan.id_rute 
    INNER JOIN maskapai ON rute.id_maskapai = maskapai.id_maskapai 
    WHERE id_jadwal = '$id'")[0];
?>

<div class="max-w-4xl mx-auto px-6 py-8">
    <h1 class="text-3xl font-bold mb-6 text-center">Detail Jadwal Penerbangan</h1>
    <div class="bg-white rounded-lg shadow-lg p-6 flex flex-col md:flex-row">
        <!-- Bagian Kiri: Logo dan Tanggal -->
        <div class="md:w-1/3 flex flex-col items-center justify-center border-b md:border-b-0 md:border-r border-gray-200 pr-4">
            <img src="assets/images/<?= $jadwal['logo_maskapai']; ?>" alt="<?= $jadwal['nama_maskapai']; ?>" class="w-32 h-32 object-contain">
            <p class="mt-4 text-sm text-gray-500"><?= date('d M Y', strtotime($jadwal['tanggal_pergi'])) ?></p>
        </div>
        <!-- Bagian Kanan: Detail Penerbangan dan Form Pemesanan -->
        <div class="md:w-2/3 md:pl-6 mt-4 md:mt-0">
            <div class="space-y-3">
                <p><span class="font-semibold">Nama Maskapai:</span> <?= $jadwal['nama_maskapai']; ?></p>
                <p><span class="font-semibold">Rute:</span> <?= $jadwal['rute_asal']; ?> - <?= $jadwal['rute_tujuan']; ?></p>
                <p><span class="font-semibold">Waktu Berangkat:</span> <?= $jadwal['waktu_berangkat']; ?></p>
                <p><span class="font-semibold">Waktu Tiba:</span> <?= $jadwal['waktu_tiba']; ?></p>
                <p><span class="font-semibold">Harga:</span> Rp <?= number_format($jadwal['harga']); ?></p>
                <p><span class="font-semibold">Kapasitas Kursi:</span> <?= $jadwal['kapasitas_kursi']; ?></p>
            </div>
            <!-- Form Pemesanan Tiket -->
            <div class="mt-6">
                <form action="" method="POST" class="flex flex-col sm:flex-row items-center gap-4">
                    <label for="qty" class="block text-sm font-medium text-gray-700">Jumlah Tiket:</label>
                    <input type="number" name="qty" id="qty" value="1" min="1" class="w-20 border border-gray-300 rounded px-2 py-1 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <button type="submit" name="pesan" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded transition-colors duration-300">Pesan</button>
                </form>
            </div>
        </div>
    </div>
</div>

<?php 

if(isset($_POST['pesan'])){
    if($_POST['qty'] > $jadwal['kapasitas_kursi']){
        echo "
            <script type='text/javascript'>
                alert('Mohon maaf kuantitas yang kamu pesan melebihi kuantitas yang tersedia!')
                window.location = 'index.php'
            </script>
        ";
    }else if($_POST['qty'] <= 0){
        echo "
            <script type='text/javascript'>
                alert('Beli setidak-nya 1 tiket, ya!');
                window.location = 'index.php'
            </script>
        ";
    }else{
        $qty = $_POST['qty'];
        $_SESSION['cart'][$id] = $qty;
        echo "<script type='text/javascript'>window.location = 'cart.php'</script>";
    }
}

?>