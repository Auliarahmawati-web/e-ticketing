<?php
require '../../koneksi.php'; // Pastikan koneksi ke database sudah benar

// Fungsi untuk mendapatkan semua order detail
function query($query) {
global $conn;
$result = mysqli_query($conn, $query);
$rows = [];
while ($row = mysqli_fetch_assoc($result)) {
$rows[] = $row;
}
return $rows;
}

function tambahOrderDetail($data) {
global $conn;
$id_user = mysqli_real_escape_string($conn, $data["id_user"]);
$id_penerbangan = mysqli_real_escape_string($conn, $data["id_penerbangan"]);
$id_order = mysqli_real_escape_string($conn, $data["id_order"]);
$jumlah_tiket = mysqli_real_escape_string($conn, $data["jumlah_tiket"]);
$total_harga = mysqli_real_escape_string($conn, $data["total_harga"]);

// Validasi id_user
$check_user = mysqli_query($conn, "SELECT * FROM user WHERE id_user = '$id_user'");
if (mysqli_num_rows($check_user) == 0) {
echo "<script>alert('ID User tidak ditemukan!');</script>";
return 0; // Menghentikan eksekusi jika id_user tidak valid
}

// Validasi id_penerbangan
$check_penerbangan = mysqli_query($conn, "SELECT * FROM jadwal_penerbangan WHERE id_jadwal = '$id_penerbangan'");
if (mysqli_num_rows($check_penerbangan) == 0) {
echo "<script>alert('ID Penerbangan tidak ditemukan!');</script>";
return 0; // Menghentikan eksekusi jika id_penerbangan tidak valid
}

// Validasi id_order
$check_order = mysqli_query($conn, "SELECT * FROM order_tiket WHERE id_order = '$id_order'");
if (mysqli_num_rows($check_order) == 0) {
echo "<script>alert('ID Order tidak ditemukan!');</script>";
return 0; // Menghentikan eksekusi jika id_order tidak valid
}

$query = "INSERT INTO order_detail (id_user, id_penerbangan, id_order, jumlah_tiket, total_harga) VALUES (?, ?, ?, ?, ?)";
$stmt = mysqli_prepare($conn, $query);
mysqli_stmt_bind_param($stmt, "sssis", $id_user, $id_penerbangan, $id_order, $jumlah_tiket, $total_harga);
mysqli_stmt_execute($stmt);

return mysqli_stmt_affected_rows($stmt);
}
// Fungsi untuk mendapatkan order detail berdasarkan ID
function getOrderDetailById($id) {
global $conn;
$query = "SELECT * FROM order_detail WHERE id_order_detail = ?";
$stmt = mysqli_prepare($conn, $query);
mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
return mysqli_fetch_assoc($result);
}

// Fungsi untuk memperbarui order detail
function editOrderDetail($data) {
global $conn;
$id_order_detail = mysqli_real_escape_string($conn, $data["id_order_detail"]);
$id_user = mysqli_real_escape_string($conn, $data["id_user"]);
$id_penerbangan = mysqli_real_escape_string($conn, $data["id_penerbangan"]);
$id_order = mysqli_real_escape_string($conn, $data["id_order"]);
$jumlah_tiket = mysqli_real_escape_string($conn, $data["jumlah_tiket"]);
$total_harga = mysqli_real_escape_string($conn, $data["total_harga"]);

// Validasi id_user
$check_user = mysqli_query($conn, "SELECT * FROM user WHERE id_user = '$id_user'");
if (mysqli_num_rows($check_user) == 0) {
echo "<script>alert('ID User tidak ditemukan!');</script>";
return 0; // Menghentikan eksekusi jika id_user tidak valid
}

// Validasi id_penerbangan
$check_penerbangan = mysqli_query($conn, "SELECT * FROM jadwal_penerbangan WHERE id_jadwal = '$id_penerbangan'");
if (mysqli_num_rows($check_penerbangan) == 0) {
echo "<script>alert('ID Penerbangan tidak ditemukan!');</script>";
return 0; // Menghentikan eksekusi jika id_penerbangan tidak valid
}

// Validasi id_order
$check_order = mysqli_query($conn, "SELECT * FROM order_tiket WHERE id_order = '$id_order'");
if (mysqli_num_rows($check_order) == 0) {
echo "<script>alert('ID Order tidak ditemukan!');</script>";
return 0; // Menghentikan eksekusi jika id_order tidak valid
}

$query = "UPDATE order_detail SET id_user = ?, id_penerbangan = ?, id_order = ?, jumlah_tiket = ?, total_harga = ? WHERE id_order_detail = ?";
$stmt = mysqli_prepare($conn, $query);
mysqli_stmt_bind_param($stmt, "ssssis", $id_user, $id_penerbangan, $id_order, $jumlah_tiket, $total_harga, $id_order_detail);
mysqli_stmt_execute($stmt);

return mysqli_stmt_affected_rows($stmt);
}

// Fungsi untuk menghapus order detail
function hapusOrderDetail($id) {
global $conn;
$query = "DELETE FROM order_detail WHERE id_order_detail = ?";
$stmt = mysqli_prepare($conn, $query);
mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);
return mysqli_stmt_affected_rows($stmt);
}
?>