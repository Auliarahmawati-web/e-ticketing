<?php
session_start();
require 'functions.php';

if (!isset($_SESSION["username"])) {
echo "<script type='text/javascript'> alert('Silahkan login terlebih dahulu, ya!'); window.location = '../../auth/login/index.php'; </script>";
exit();
}

$id = $_GET["id"];

if (hapusOrderDetail($id) > 0) {
echo "<script>alert('Data berhasil dihapus!'); window.location = 'index.php';</script>";
} else {
echo "<script>alert('Data gagal dihapus!'); window.location = 'index.php';</script>";
}
?>