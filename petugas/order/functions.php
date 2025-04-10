
<?php
require '../../koneksi.php';

function query($query) {
    global $conn;
    $rows = [];
    $result = mysqli_query($conn, $query);
    while($row = mysqli_fetch_assoc($result)){
        $rows[] = $row;
    }
    return $rows;    
}

function verifikasiOrder($id_order) {
    global $conn;
    
    try {
        mysqli_begin_transaction($conn);
        
        $query = "UPDATE order_tiket SET status = 'terverifikasi' WHERE id_order = '$id_order'";
        $result = mysqli_query($conn, $query);
        
        if (!$result) {
            throw new Exception("Error updating order status: " . mysqli_error($conn));
        }
        
        mysqli_commit($conn);
        return true;
    } catch (Exception $e) {
        mysqli_rollback($conn);
        error_log($e->getMessage());
        return false;
    }
}
// Fungsi untuk mendapatkan detail order
function getOrderDetail($id_order) {
    global $conn;
    $query = "SELECT ot.id_order, ot.tanggal_transaksi, ot.status, od.jumlah_tiket, od.total_harga, od.kelas, u.username AS nama_penumpang, jp.waktu_berangkat, jp.waktu_tiba, r.rute_asal, r.rute_tujuan, r.tanggal_pergi, m.nama_maskapai FROM order_tiket ot INNER JOIN order_detail od ON ot.id_order = od.id_order INNER JOIN user u ON od.id_user = u.id_user INNER JOIN jadwal_penerbangan jp ON od.id_penerbangan = jp.id_jadwal INNER JOIN rute r ON jp.id_rute = r.id_rute INNER JOIN maskapai m ON r.id_maskapai = m.id_maskapai WHERE ot.id_order = '$id_order' LIMIT 1";
    $result = mysqli_query($conn, $query);
    return mysqli_fetch_assoc($result);
}