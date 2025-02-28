<?php

session_start();
require 'functions.php';

if(!isset($_SESSION["username"])){
    echo "
    <script type='text/javascript'>
        alert('Silahkan login terlebih dahulu, ya!');
        window.location = '../../auth/login/index.php';
    </script>
    ";
}

if(isset($_POST["tambah"])){
    if(tambah($_POST) > 0 ){
        echo "
            <script type='text/javascript'>
                alert('Yay! data maskapai berhasil ditambahkan!')
                window.location = 'index.php'
            </script>
        ";
    }else{
        echo "
            <script type='text/javascript'>
                alert('Yhaa .. data maskapai gagal ditambahkan :(')
                window.location = 'index.php'
            </script>
        ";
    }
}



?>

<?php require '../../layouts/sidebar_admin.php'; ?>

<div class="flex items-center justify-center min-h-screen bg-white">
    <div class="bg-white p-8 rounded-lg shadow-2xl border border-gray-300 w-96">
        <h2 class="text-xl font-bold text-center mb-4">Tambah Maskapai</h2>
        
        <form action="" method="POST" enctype="multipart/form-data">
            <label for="logo_maskapai" class="block text-sm font-medium">Logo Maskapai</label>
            <input type="file" name="logo_maskapai" id="logo_maskapai" class="w-full px-3 py-2 mt-1 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-400">

            <label for="nama_maskapai" class="block text-sm font-medium mt-4">Nama Maskapai</label>
            <input type="text" name="nama_maskapai" id="nama_maskapai" class="w-full px-3 py-2 mt-1 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-400">

            <button type="submit" name="tambah" class="w-full mt-6 bg-blue-500 text-white py-2 rounded-md shadow-md hover:bg-blue-600 transition duration-200">Tambah</button>
        </form>
    </div>
</div>
