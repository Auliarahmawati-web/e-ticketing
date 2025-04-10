<?php
require 'functions.php';

// Pastikan pengguna masuk
if (!isset($_SESSION['id_user'])) {
    header("Location: auth/login/");
    exit;
}

if (!isset($_GET['id_order'])) {
    die("ID order tidak ditemukan.");
}

$id_order = $_GET['id_order'];

// Ambil detail transaksi
$transaction = query("SELECT 
    ot.id_order,
    ot.tanggal_transaksi,
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
WHERE ot.id_order = '$id_order'
LIMIT 1")[0];

if (!$transaction) {
    die("Transaksi tidak ditemukan.");
}
?>
    <!DOCTYPE html>
<html lang="id"> 
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Boarding Pass</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <style>
    @media print {
        .no-print { display: none; }
        body {
            -webkit-print-color-adjust: exact;
            print-color-adjust: exact;
        }
    }
    </style>
</head>
<body class="flex flex-col justify-center items-center min-h-screen bg-gray-100 p-6">
    
    <!-- Container Tiket -->
    <div id="ticket" class="bg-white w-full max-w-2xl rounded-xl shadow-lg overflow-hidden">
        <!-- Header -->
        <div class="bg-blue-400 text-white p-4 flex justify-between items-center">
            <h2 class="text-3xl font-serif familly font-extrabold text-white">AVIATICA</h2>
            <i class="bi bi-airplane-engines-fill text-4xl"></i>
        </div>

        <div class="flex border-t border-dashed border-gray-400">
            <!-- Bagian Kiri -->
            <div class="flex-1 p-4">
                <div class="flex items-center justify-between border-b pb-2">
                    <img src="assets/images/<?= $transaction['logo_maskapai']; ?>" 
                        alt="<?= $transaction['nama_maskapai']; ?>" class="w-16 h-auto">
                    <div class="text-right">
                        <h2 class="text-2xl font-bold text-gray-700"><?= $_SESSION['username']; ?></h2>
                        <p class="text-gray-500 text-sm">First Class</p>
                    </div>
                </div>
                <div class="mt-3 grid grid-cols-2 gap-2 text-gray-700 text-sm">
                    <div><strong>ID Order:</strong> <?= $transaction['id_order']; ?></div>
                    <div><strong>Tanggal:</strong> <?= date('d/m/Y', strtotime($transaction['tanggal_pergi'])); ?></div>
                    <div><strong>Maskapai:</strong> <?= $transaction['nama_maskapai']; ?></div>
                    <div><strong>Jumlah Tiket:</strong> <?= $transaction['jumlah_tiket']; ?></div>
                    <div><strong>Asal:</strong> <?= $transaction['rute_asal']; ?></div>
                    <div><strong>Tujuan:</strong> <?= $transaction['rute_tujuan']; ?></div>
                    <div><strong>Waktu:</strong> <?= date('H:i', strtotime($transaction['waktu_berangkat'])); ?> - 
                        <?= date('H:i', strtotime($transaction['waktu_tiba'])); ?></div>
                    <div><strong>Total Harga:</strong> Rp <?= number_format($transaction['total_harga']); ?></div>
                </div>
            </div>
            
            <div class="border-dashed border-gray-400 border-l-2 min-h-[200px]"></div>
            
            <!-- Bagian Kanan -->
            <div class="w-full md:w-1/3 p-4 text-gray-700 text-center">
                <h2 class="text-md font-bold text-gray-700">BOARDING PASS</h2>
                <div class="mt-1 text-sm">
                    <p><strong>ID Order:</strong> <?= $transaction['id_order']; ?></p>
                    <p><strong>Asal:</strong> <?= $transaction['rute_asal']; ?></p>
                    <p><strong>Tujuan:</strong> <?= $transaction['rute_tujuan']; ?></p>
                    <p><strong>Waktu:</strong> <?= date('H:i', strtotime($transaction['waktu_berangkat'])); ?></p>
                </div>
                <div class="mt-3 flex justify-center">
                    <img src="/e-ticketing/assets/images/code.png" alt="Barcode" class="h-16">
                </div>
            </div>
        </div>
    </div>
    
    <!-- Tombol Cetak & Simpan -->
    <div class="mt-6 flex space-x-4">
        <button onclick="window.print()" 
                class="no-print px-6 py-3 bg-blue-500 text-white text-lg font-semibold rounded-lg shadow-md hover:bg-blue-600">
            Cetak Tiket
        </button>

        <button onclick="downloadTicket()" 
                class="no-print px-6 py-3 bg-green-500 text-white text-lg font-semibold rounded-lg shadow-md hover:bg-green-600">
            Simpan sebagai Gambar
        </button>
    </div>


    <!-- Script untuk Menyimpan sebagai Gambar -->
    <script>
        function downloadTicket() {
            const ticketElement = document.getElementById("ticket");

            html2canvas(ticketElement, { scale: 2 }).then(canvas => {
                let link = document.createElement("a");
                link.href = canvas.toDataURL("image/png");
                link.download = "boarding-pass.png";
                link.click();
            });
        }
    </script>

</body>
</html>
