<?php
session_start();
require 'koneksi.php';

function query($query){
    global $conn;
    $rows = [];
    $result = mysqli_query($conn, $query);
    while($row = mysqli_fetch_assoc($result)){
        $rows[] = $row;
    }
    return $rows;    
}

function checkout($data){
    global $conn; 
    
    try {
        mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
        mysqli_begin_transaction($conn);
        
        if (!isset($data["id_user"]) || empty($data["id_user"])) {
            throw new Exception("User ID is required");
        }
        
        if (!isset($_SESSION["cart"]) || empty($_SESSION["cart"])) {
            throw new Exception("Cart is empty");
        }

        $idOrder = uniqid();
        $tanggalTransaksi = date('Y-m-d');
        $struk = bin2hex(random_bytes(10));
        $status = "proses";
        
        error_log("Starting checkout process for order: " . $idOrder);
        
        $queryOrder = "INSERT INTO order_tiket (id_order, tanggal_transaksi, struk, status) 
                      VALUES ('$idOrder', '$tanggalTransaksi', '$struk', '$status')";
        $resultOrder = mysqli_query($conn, $queryOrder);
        
        if (!$resultOrder) {
            throw new Exception("Error inserting into order_tiket: " . mysqli_error($conn));
        }
        
        error_log("Successfully created order_tiket record");

        foreach($_SESSION["cart"] as $id_jadwal => $details) {
            $kuantitas = $details['quantity'];
            $kelas = $details['kelas']; // Enum class: First Class, Business Class, Economy Class
            
            if (!in_array($kelas, ['First Class', 'Business Class', 'Economy Class'])) {
                throw new Exception("Invalid ticket class selected");
            }
            
            error_log("Processing cart item - Jadwal ID: $id_jadwal, Quantity: $kuantitas, Class: $kelas");
            
            $tiket = query("SELECT * FROM jadwal_penerbangan 
                          INNER JOIN rute ON rute.id_rute = jadwal_penerbangan.id_rute 
                          INNER JOIN maskapai ON rute.id_maskapai = maskapai.id_maskapai 
                          WHERE id_jadwal = '$id_jadwal'");
            
            if (empty($tiket)) {
                throw new Exception("Ticket not found for ID: " . $id_jadwal);
            }
            
            $tiket = $tiket[0];
            $id_user = $data["id_user"];
            $totalHarga = $tiket["harga"] * $kuantitas;
            $sisaKapasitas = $tiket["kapasitas_kursi"] - $kuantitas;

            if ($sisaKapasitas < 0) {
                throw new Exception("Not enough seats available for ticket ID: " . $id_jadwal);
            }

            error_log("Inserting order_detail - User: $id_user, Jadwal: $id_jadwal, Order: $idOrder, Class: $kelas");
            
            $queryOrderDetail = "INSERT INTO order_detail 
                               (id_user, id_penerbangan, id_order, jumlah_tiket, total_harga, kelas) 
                               VALUES 
                               ('$id_user', '$id_jadwal', '$idOrder', '$kuantitas', '$totalHarga', '$kelas')";
            
            $resultOrderDetail = mysqli_query($conn, $queryOrderDetail);
            
            if (!$resultOrderDetail) {
                throw new Exception("Error inserting into order_detail: " . mysqli_error($conn));
            }

            error_log("Successfully inserted order_detail record");

            $updateKapasitas = mysqli_query($conn, "UPDATE jadwal_penerbangan 
                                                  SET kapasitas_kursi = '$sisaKapasitas' 
                                                  WHERE id_jadwal = '$id_jadwal'");
            
            if (!$updateKapasitas) {
                throw new Exception("Error updating seat capacity: " . mysqli_error($conn));
            }

            error_log("Successfully updated seat capacity");
        }
        
        mysqli_commit($conn);
        error_log("Transaction committed successfully");
        unset($_SESSION["cart"]);
        
        return true;
        
    } catch (Exception $e) {
        mysqli_rollback($conn);
        error_log("Checkout Error: " . $e->getMessage());
        error_log("SQL Error: " . mysqli_error($conn));
        return false;
    }
}
