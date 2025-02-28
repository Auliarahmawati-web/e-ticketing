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

$id = $_GET["id"];
$pengguna = query("SELECT * FROM user WHERE id_user = '$id'")[0];

if(isset($_POST["edit"])){
    if(edit($_POST) > 0 ){
        echo "
            <script type='text/javascript'>
                alert('Yay! data pengguna berhasil diedit!')
                window.location = 'index.php'
            </script>
        ";
    }else{
        echo "
            <script type='text/javascript'>
                alert('Yhaa .. data pengguna gagal diedit :(')
                window.location = 'index.php'
            </script>
        ";
    }
}



?>

<?php require '../../layouts/sidebar_admin.php'; ?>

<div class="flex items-center justify-center min-h-screen bg-white">
    <div class="bg-white p-8 rounded-lg shadow-2xl border border-gray-300 w-96">
        <h2 class="text-xl font-bold text-center mb-4">Edit Petugas</h2>
        
        <form action="" method="POST">
            <input type="hidden" name="id_user" value="<?= htmlspecialchars($pengguna["id_user"]); ?>">

            <label for="username" class="block text-sm font-medium">Username</label>
            <input type="text" name="username" id="username" class="w-full px-3 py-2 mt-1 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-400" value="<?= htmlspecialchars($pengguna["username"]); ?>">

            <label for="nama_lengkap" class="block text-sm font-medium mt-4">Nama Lengkap</label>
            <input type="text" name="nama_lengkap" id="nama_lengkap" class="w-full px-3 py-2 mt-1 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-400" value="<?= htmlspecialchars($pengguna["nama_lengkap"]); ?>">

            <label for="password" class="block text-sm font-medium mt-4">Password</label>
            <input type="password" name="password" id="password" class="w-full px-3 py-2 mt-1 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-400" value="<?= htmlspecialchars($pengguna["password"]); ?>">

            <label for="roles" class="block text-sm font-medium mt-4">Roles</label>
            <select name="roles" id="roles" class="w-full px-3 py-2 mt-1 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-400">
                <option value="<?= htmlspecialchars($pengguna["roles"]); ?>" selected><?= htmlspecialchars($pengguna["roles"]); ?></option>
                <option value="Petugas">Petugas</option>
                <option value="Penumpang">Penumpang</option>
            </select>

            <button type="submit" name="edit" class="w-full mt-6 bg-blue-500 text-white py-2 rounded-md shadow-md hover:bg-blue-600 transition duration-200">Edit</button>
        </form>
    </div>
</div>
