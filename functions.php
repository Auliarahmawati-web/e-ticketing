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
        // Enable error reporting for debugging
        mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
        
        // Start transaction
        mysqli_begin_transaction($conn);
        
        // Validate user ID exists
        if (!isset($data["id_user"]) || empty($data["id_user"])) {
            throw new Exception("User ID is required");
        }
        
        // Validate cart is not empty
        if (!isset($_SESSION["cart"]) || empty($_SESSION["cart"])) {
            throw new Exception("Cart is empty");
        }

        $idOrder = uniqid();
        $tanggalTransaksi = date('Y-m-d');
        $struk = bin2hex(random_bytes(10));
        $status = "proses"; // Initial status
        
        // Debug log
        error_log("Starting checkout process for order: " . $idOrder);
        
        // Insert into order_tiket with status
        $queryOrder = "INSERT INTO order_tiket (id_order, tanggal_transaksi, struk, status) 
                      VALUES ('$idOrder', '$tanggalTransaksi', '$struk', '$status')";
        $resultOrder = mysqli_query($conn, $queryOrder);
        
        if (!$resultOrder) {
            throw new Exception("Error inserting into order_tiket: " . mysqli_error($conn));
        }
        
        error_log("Successfully created order_tiket record");

        // Process each item in cart
        foreach($_SESSION["cart"] as $id_jadwal => $kuantitas) {
            error_log("Processing cart item - Jadwal ID: $id_jadwal, Quantity: $kuantitas");
            
            // Get ticket details
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

            error_log("Inserting order_detail - User: $id_user, Jadwal: $id_jadwal, Order: $idOrder");
            
            // Insert into order_detail (using id_jadwal as id_penerbangan)
            $queryOrderDetail = "INSERT INTO order_detail 
                               (id_user, id_penerbangan, id_order, jumlah_tiket, total_harga) 
                               VALUES 
                               ('$id_user', '$id_jadwal', '$idOrder', '$kuantitas', '$totalHarga')";
            
            $resultOrderDetail = mysqli_query($conn, $queryOrderDetail);
            
            if (!$resultOrderDetail) {
                throw new Exception("Error inserting into order_detail: " . mysqli_error($conn));
            }

            error_log("Successfully inserted order_detail record");

            // Update seat capacity
            $updateKapasitas = mysqli_query($conn, "UPDATE jadwal_penerbangan 
                                                  SET kapasitas_kursi = '$sisaKapasitas' 
                                                  WHERE id_jadwal = '$id_jadwal'");
            
            if (!$updateKapasitas) {
                throw new Exception("Error updating seat capacity: " . mysqli_error($conn));
            }

            error_log("Successfully updated seat capacity");
        }
        
        // If we get here, everything succeeded. Commit the transaction
        mysqli_commit($conn);
        error_log("Transaction committed successfully");
        
        // Clear the cart
        unset($_SESSION["cart"]);
        
        return true;
        
    } catch (Exception $e) {
        // Something went wrong, rollback the transaction
        mysqli_rollback($conn);
        error_log("Checkout Error: " . $e->getMessage());
        error_log("SQL Error: " . mysqli_error($conn));
        return false;
    }
}
