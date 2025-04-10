<?php
session_start();
require 'koneksi.php';

if (!isset($_GET['id']) || !isset($_SESSION['cart'][$_GET['id']])) {
    echo "<script>alert('Data tidak ditemukan!'); window.location = 'cart.php';</script>";
    exit;
}

$id_jadwal = $_GET['id'];
$kuantitas = $_SESSION['cart'][$id_jadwal]['quantity'] ?? 1;
$kelas = $_SESSION['cart'][$id_jadwal]['kelas'] ?? 'Economy Class';

// Koneksi database langsung tanpa functions.php
$conn = mysqli_connect("localhost", "root", "", "e-ticketing");
$query = "SELECT * FROM jadwal_penerbangan 
          INNER JOIN rute ON rute.id_rute = jadwal_penerbangan.id_rute 
          INNER JOIN maskapai ON rute.id_maskapai = maskapai.id_maskapai 
          WHERE id_jadwal = '$id_jadwal'";
$result = mysqli_query($conn, $query);
$jadwalPenerbangan = mysqli_fetch_assoc($result);

if (!$jadwalPenerbangan) {
    echo "<script>alert('Jadwal tidak ditemukan!'); window.location = 'cart.php';</script>";
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $new_kuantitas = isset($_POST['kuantitas']) ? (int)$_POST['kuantitas'] : 1;
    $new_kelas = $_POST['kelas'] ?? 'Economy Class';

    // Perbarui harga berdasarkan kelas tiket
    $harga = $jadwalPenerbangan['harga'];
    if ($new_kelas == 'Business Class' || $new_kelas == 'First Class') {
        $harga *= 2;
    }
    
    // Simpan perubahan di session cart
    $_SESSION['cart'][$id_jadwal] = [
        'quantity' => $new_kuantitas,
        'kelas' => $new_kelas,
        'harga' => $harga
    ];

    echo "<script>alert('Tiket berhasil diperbarui!'); window.location = 'cart.php';</script>";
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Tiket</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
    <div class="container mx-auto px-6 py-8">
        <h1 class="text-3xl font-bold text-center mb-6">Edit Pemesanan Tiket</h1>
        
        <div class="max-w-lg mx-auto bg-white p-6 rounded-lg shadow-md">
            <form action="" method="POST">
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700">Nama Maskapai</label>
                    <input type="text" value="<?= $jadwalPenerbangan["nama_maskapai"]; ?>" class="w-full px-3 py-2 mt-1 border rounded-lg bg-gray-200" disabled>
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700">Rute</label>
                    <input type="text" value="<?= $jadwalPenerbangan["rute_asal"]; ?> - <?= $jadwalPenerbangan["rute_tujuan"]; ?>" class="w-full px-3 py-2 mt-1 border rounded-lg bg-gray-200" disabled>
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700">Tanggal Keberangkatan</label>
                    <input type="text" value="<?= $jadwalPenerbangan["tanggal_pergi"]; ?>" class="w-full px-3 py-2 mt-1 border rounded-lg bg-gray-200" disabled>
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700">Waktu Keberangkatan</label>
                    <input type="text" value="<?= $jadwalPenerbangan["waktu_berangkat"]; ?> - <?= $jadwalPenerbangan["waktu_tiba"]; ?>" class="w-full px-3 py-2 mt-1 border rounded-lg bg-gray-200" disabled>
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700">Jumlah Tiket</label>
                    <input type="number" name="kuantitas" value="<?= $kuantitas; ?>" min="1" class="w-full px-3 py-2 mt-1 border rounded-lg">
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700">Kelas</label>
                    <select name="kelas" class="w-full px-3 py-2 mt-1 border rounded-lg">
                        <option value="Economy Class" <?= ($kelas == 'Economy Class') ? 'selected' : ''; ?>>Economy Class</option>
                        <option value="Business Class" <?= ($kelas == 'Business Class') ? 'selected' : ''; ?>>Business Class (x2 Harga)</option>
                        <option value="First Class" <?= ($kelas == 'First Class') ? 'selected' : ''; ?>>First Class (x2 Harga)</option>
                    </select>
                </div>

                <div class="mt-6 text-right">
                    <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded transition">Simpan Perubahan</button>
                    <a href="cart.php" class="ml-2 bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded transition">Batal</a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
