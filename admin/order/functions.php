
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