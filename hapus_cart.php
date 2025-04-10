<?php
session_start();

// Pastikan parameter ID tersedia
if (!isset($_GET['id'])) {
    echo "<script>alert('ID tidak valid!'); window.location = 'cart.php';</script>";
    exit;
}

$id_jadwal = $_GET['id'];

// Periksa apakah item ada di cart
if (isset($_SESSION['cart'][$id_jadwal])) {
    unset($_SESSION['cart'][$id_jadwal]); // Hapus item dari sesi cart
    
    // Jika keranjang kosong, hapus seluruh sesi cart
    if (empty($_SESSION['cart'])) {
        unset($_SESSION['cart']);
    }
    
    echo "<script>alert('Item berhasil dihapus!'); window.location = 'cart.php';</script>";
} else {
    echo "<script>alert('Item tidak ditemukan!'); window.location = 'cart.php';</script>";
}
?>