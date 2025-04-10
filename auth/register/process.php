<?php
require '../../koneksi.php';

$nama_lengkap = $_POST['email'];
$username = $_POST['username'];
$password = $_POST['password'];
$roles = 'penumpang';

$query = mysqli_query($conn, "INSERT INTO user (email, username, password, roles) VALUES ('$nama_lengkap', '$username', '$password', '$roles')");

if($query) {
    echo "<script>alert('Registrasi berhasil! Silakan login.'); window.location='../login/index.php';</script>";
} else {
    echo "<script>alert('Registrasi gagal!'); window.location='index.php';</script>";
}
?>