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
                alert('Yay! data pengguna berhasil ditambahkan!');
                window.location = 'index.php';
            </script>
        ";
    }else{
        echo "
            <script type='text/javascript'>
                alert('Yhaa .. data pengguna gagal ditambahkan :(');
                window.location = 'index.php';
            </script>
        ";
    }
}

?>

<?php require '../../layouts/sidebar_admin.php'; ?>

<div class="flex items-center justify-center min-h-screen bg-white">
    <div class="bg-white p-8 rounded-lg shadow-2xl border border-gray-300 w-96">
        <h2 class="text-xl font-bold text-center mb-4">Tambah Petugas</h2>
        
        <form action="" method="POST">
            <label for="username" class="block text-sm font-medium">Username</label>
            <input type="text" name="username" id="username" class="w-full px-3 py-2 mt-1 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-400">

            <label for="email" class="block text-sm font-medium mt-4">Email</label>
            <input type="text" name="email" id="email" class="w-full px-3 py-2 mt-1 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-400">

            <label for="password" class="block text-sm font-medium mt-4">Password</label>
            <input type="password" name="password" id="password" class="w-full px-3 py-2 mt-1 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-400">

            <label for="roles" class="block text-sm font-medium mt-4">Roles</label>
            <select name="roles" id="roles" class="w-full px-3 py-2 mt-1 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-400">
                <option value="Petugas">Petugas</option>
                <option value="Admin">Admin</option>
            </select>

            <button type="submit" name="tambah" class="w-full mt-6 bg-blue-500 text-white py-2 rounded-md shadow-md hover:bg-blue-600 transition duration-200">Tambah</button>
        </form>
    </div>
</div>
