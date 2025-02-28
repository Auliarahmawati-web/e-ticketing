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
    <style>
        @media print {
            .no-print { display: none; }
        }
        .ticket {
            position: relative;
            border-radius: 20px;
            overflow: hidden;
            display: flex;
            align-items: center;
            border: 2px solid #1E3A8A;
            background-color: white;
        }
        .ticket::before, .ticket::after {
            content: "";
            position: absolute;
            width: 40px;
            height: 40px;
            background: white;
            border-radius: 50%;
        }
        .ticket::before {
            top: 50%;
            left: -20px;
            transform: translateY(-50%);
            box-shadow: -5px 0px 0px #1E3A8A;
        }
        .ticket::after {
            top: 50%;
            right: -20px;
            transform: translateY(-50%);
            box-shadow: 5px 0px 0px #1E3A8A;
        }
        .divider {
            width: 2px;
            background: repeating-linear-gradient(
                to bottom,
                black,
                black 5px,
                transparent 5px,
                transparent 10px
            );
            height: 100%;
        }
    </style>
</head>
<body class="flex flex-col justify-center items-center min-h-screen bg-gray-100 p-6">

    <div class="bg-white w-full max-w-2xl rounded-xl shadow-lg p-6 relative ticket">
            <div class="flex-1 p-3">
                <div class="flex items-center justify-between border-b pb-2">
                    <img src="assets/images/<?= $transaction['logo_maskapai']; ?>" 
                        alt="<?= $transaction['nama_maskapai']; ?>" class="w-16 h-auto">
                    <div class="text-right">
                        <h2 class="text-lg font-bold text-blue-600">AVIATICA</h2>
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
            
            <div class="divider"></div>
            
            <div class="w-full md:w-1/3 p-3 text-gray-700 text-center">
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
    
    <div class="mt-6">
        <button onclick="window.print()" 
                class="no-print px-6 py-3 bg-blue-500 text-white text-lg font-semibold rounded-lg shadow-md hover:bg-blue-600">
            Cetak Tiket
        </button>
    </div>
</body>
</html>