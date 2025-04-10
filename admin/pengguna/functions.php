<?php

require '../../koneksi.php';

function query($query){

    global $conn;

    $rows = [];

    $result = mysqli_query($conn, $query);

    while($row = mysqli_fetch_assoc($result)){
        $rows[] = $row;
    }

    return $rows;    
}

function tambah($data){

    global $conn;
    $username = htmlspecialchars($data["username"]);
    $email = htmlspecialchars($data["email"]);
    $password = htmlspecialchars($data["password"]);
    $roles = htmlspecialchars($data["roles"]);

    $query = "INSERT INTO user VALUES (NULL, '$username', '$email', '$password', '$roles')";
    mysqli_query($conn, $query);

    return mysqli_affected_rows($conn);
}

function hapus($id){
    global $conn; 
    mysqli_query($conn, "DELETE FROM user WHERE id_user = '$id'");
    return mysqli_affected_rows($conn);
}

function edit($data){
    global $conn;
    
    $id = htmlspecialchars($data["id_user"]);
    $username = htmlspecialchars($data["username"]);
    $email = htmlspecialchars($data["email"]);
    $password = htmlspecialchars($data["password"]);
    $roles = htmlspecialchars($data["roles"]);

    $query = "UPDATE user SET
    username = '$username',
    email = '$email',
    password = '$password',
    roles = '$roles' WHERE id_user = '$id'";

    mysqli_query($conn, $query);
    return mysqli_affected_rows($conn);
}