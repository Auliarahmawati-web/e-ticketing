<?php
session_start();
require 'functions.php';

// Pastikan ada data yang dikirim melalui POST
if (isset($_POST['pesan'])) {
    $id_jadwal = $_POST['id_jadwal']; // Ambil id jadwal penerbangan
    $qty = $_POST['qty']; // Ambil kuantitas tiket yang dipesan

    // Ambil data jadwal penerbangan berdasarkan id_jadwal
    $jadwal = query("SELECT * FROM jadwal_penerbangan 
                     INNER JOIN rute ON rute.id_rute = jadwal_penerbangan.id_rute 
                     INNER JOIN maskapai ON rute.id_maskapai = maskapai.id_maskapai 
                     WHERE id_jadwal = '$id_jadwal'");

    if (!$jadwal) {
        echo "<script>alert('Jadwal penerbangan tidak ditemukan!'); window.location = 'index.php';</script>";
        exit;
    }

    // Ambil kapasitas kursi dari jadwal penerbangan
    $kapasitasKursi = $jadwal[0]['kapasitas_kursi'];

    // Cek apakah kuantitas yang dipesan melebihi kapasitas
    if ($qty > $kapasitasKursi) {
        echo "<script>alert('Kuantitas melebihi kapasitas kursi yang tersedia!'); window.location = 'index.php';</script>";
    } else if ($qty <= 0) {
        // Cek jika kuantitas kurang dari 1
        echo "<script>alert('Mohon beli setidaknya 1 tiket!'); window.location = 'index.php';</script>";
    } else {
        // Jika valid, simpan data ke session cart
        $_SESSION['cart'][$id_jadwal] = $qty;
        echo "<script>window.location = 'cart.php';</script>";
    }
} else {
    // Jika tombol submit tidak ditekan, redirect ke halaman utama
    echo "<script>window.location = 'index.php';</script>";
}
?>
