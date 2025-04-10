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
                 alert('Yay! data rute berhasil ditambahkan!')
                 window.location = 'index.php'
             </script>
         ";
     }else{
         echo "
             <script type='text/javascript'>
                 alert('Yhaa .. data rute gagal ditambahkan :(')
                 window.location = 'index.php'
             </script>
         ";
     }
 }
 
 $maskapai = query("SELECT * FROM maskapai");
 $kota = query("SELECT * FROM kota");
 
 
 ?>
 
 <?php require '../../layouts/sidebar_admin.php'; ?>
 
 <div class="flex items-center justify-center min-h-screen bg-white">
     <div class="bg-white p-8 rounded-lg shadow-2xl border border-gray-300 w-96">
         <h2 class="text-xl font-bold text-center mb-4">Tambah Rute</h2>
         
         <form action="" method="POST">
             <label for="id_maskapai" class="block text-sm font-medium">Nama Maskapai</label>
             <select name="id_maskapai" id="id_maskapai" class="w-full px-3 py-2 mt-1 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-400">
                 <?php foreach($maskapai as $data) : ?>
                 <option value="<?= $data["id_maskapai"]; ?>"><?= $data["nama_maskapai"]; ?></option>
                 <?php endforeach; ?>
             </select>
 
             <label for="rute_asal" class="block text-sm font-medium mt-4">Rute Asal</label>
             <select name="rute_asal" id="rute_asal" class="w-full px-3 py-2 mt-1 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-400">
                 <?php foreach($kota as $data) : ?>
                 <option value="<?= $data["nama_kota"]; ?>"><?= $data["nama_kota"]; ?></option>
                 <?php endforeach; ?>
             </select>
 
             <label for="rute_tujuan" class="block text-sm font-medium mt-4">Rute Tujuan</label>
             <select name="rute_tujuan" id="rute_tujuan" class="w-full px-3 py-2 mt-1 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-400">
                 <?php foreach($kota as $data) : ?>
                 <option value="<?= $data["nama_kota"]; ?>"><?= $data["nama_kota"]; ?></option>
                 <?php endforeach; ?>
             </select>
 
             <label for="tanggal_pergi" class="block text-sm font-medium mt-4">Tanggal Pergi</label>
             <input type="date" name="tanggal_pergi" id="tanggal_pergi" class="w-full px-3 py-2 mt-1 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-400">
 
             <button type="submit" name="tambah" class="w-full mt-6 bg-blue-500 text-white py-2 rounded-md shadow-md hover:bg-blue-600 transition duration-200">Tambah</button>
         </form>
     </div>
 </div>