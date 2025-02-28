<?php

session_start();
require 'functions.php';

if(!isset($_SESSION["username"])){
    echo "
    <script type='text/javascript'>
        alert('Silahkan login terlebih dahulu, ya!');
        window.location = '../../auth/login/index.php';
    </script>
    ";
}

if(isset($_POST["tambah"])){
    if(tambah($_POST) > 0 ){
        echo "
            <script type='text/javascript'>
                alert('Yay! data jadwal penerbangan berhasil ditambahkan!')
                window.location = 'index.php'
            </script>
        ";
    }else{
        echo "
            <script type='text/javascript'>
                alert('Yhaa .. data jadwal penerbangan gagal ditambahkan :(')
                window.location = 'index.php'
            </script>
        ";
    }
}

$rute = query("SELECT * FROM rute INNER JOIN maskapai ON maskapai.id_maskapai = rute.id_maskapai");


?>

<?php require '../../layouts/sidebar_admin.php'; ?>

<div class="flex items-center justify-center min-h-screen bg-white">
    <div class="bg-white p-8 rounded-lg shadow-2xl border border-gray-300 w-96">
        <h2 class="text-xl font-bold text-center mb-4">Tambah Jadwal Penerbangan</h2>
        
        <form action="" method="POST">
            <label for="id_rute" class="block text-sm font-medium">Pilih Rute</label>
            <select name="id_rute" id="id_rute" class="w-full px-3 py-2 mt-1 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-400">
                <?php foreach($rute as $data) : ?>
                <option value="<?= $data["id_rute"]; ?>"><?= $data["nama_maskapai"]; ?> - <?= $data["rute_asal"]; ?> - <?= $data["rute_tujuan"]; ?></option>
                <?php endforeach; ?>
            </select>

            <label for="waktu_berangkat" class="block text-sm font-medium mt-4">Waktu Berangkat</label>
            <input type="time" name="waktu_berangkat" id="waktu_berangkat" class="w-full px-3 py-2 mt-1 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-400">

            <label for="waktu_tiba" class="block text-sm font-medium mt-4">Waktu Tiba</label>
            <input type="time" name="waktu_tiba" id="waktu_tiba" class="w-full px-3 py-2 mt-1 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-400">

            <label for="harga" class="block text-sm font-medium mt-4">Harga</label>
            <input type="number" name="harga" id="harga" class="w-full px-3 py-2 mt-1 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-400">

            <label for="kapasitas_kursi" class="block text-sm font-medium mt-4">Kapasitas Kursi</label>
            <input type="number" name="kapasitas_kursi" id="kapasitas_kursi" class="w-full px-3 py-2 mt-1 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-400">

            <button type="submit" name="tambah" class="w-full mt-6 bg-blue-500 text-white py-2 rounded-md shadow-md hover:bg-blue-600 transition duration-200">Tambah</button>
        </form>
    </div>
</div>
