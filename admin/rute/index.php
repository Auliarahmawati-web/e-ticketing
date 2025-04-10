<?php
 session_start();
 require 'functions.php';
 
 if (!isset($_SESSION["username"])) {
     echo "
     <script type='text/javascript'>
         alert('Silahkan login terlebih dahulu, ya!');
         window.location = '../../auth/login/index.php';
     </script>
     ";
 }
 
 $search = isset($_GET['search']) ? trim($_GET['search']) : '';
 $query = "SELECT * FROM rute INNER JOIN maskapai ON maskapai.id_maskapai = rute.id_maskapai";
 
 if ($search !== '') {
     $query .= " WHERE nama_maskapai LIKE '%$search%'";
 }
 
 $query .= " ORDER BY rute_asal";
 $rute = query($query);
 ?>
 
 <?php require '../../layouts/sidebar_admin.php'; ?>
 
 <div class="p-6 bg-white lg:ml-64 overflow-x-auto">
     <h1 class="text-2xl font-bold mb-4">Halo, <?= $_SESSION["email"]; ?></h1>
     <h2 class="text-xl font-semibold mb-6">Halaman Data Rute</h2>
 
     <div class="flex mb-4">
         <a href="tambah.php" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Tambah</a>
         <form method="GET" class="ml-auto">
             <input type="text" name="search" placeholder="Cari Nama Maskapai..." class="px-4 py-2 border rounded-lg" value="<?= htmlspecialchars($search); ?>">
             <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Cari</button>
         </form>
     </div>
 
     <div class="mt-6 relative overflow-x-auto shadow-md sm:rounded-lg">
         <table class="w-full text-sm text-left text-gray-500">
             <thead class="text-xs text-gray-700 uppercase bg-gray-300">
                 <tr>
                     <th class="px-6 py-3">No</th>
                     <th class="px-6 py-3">Nama Maskapai</th>
                     <th class="px-6 py-3">Rute Asal</th>
                     <th class="px-6 py-3">Rute Tujuan</th>
                     <th class="px-6 py-3">Tanggal Pergi</th>
                     <th class="px-6 py-3">Aksi</th>
                 </tr>
             </thead>
             <tbody class="bg-white divide-y divide-gray-200">
                 <?php $no = 1; ?>
                 <?php foreach ($rute as $data) : ?>
                     <tr class="hover:bg-gray-100 text-sm">
                         <td class="px-6 py-4 text-gray-700 text-center"> <?= $no; ?> </td>
                         <td class="px-6 py-4 text-gray-700 font-medium"> <?= $data["nama_maskapai"]; ?> </td>
                         <td class="px-6 py-4 text-gray-700"> <?= $data["rute_asal"]; ?> </td>
                         <td class="px-6 py-4 text-gray-700"> <?= $data["rute_tujuan"]; ?> </td>
                         <td class="px-6 py-4 text-gray-700"> <?= $data["tanggal_pergi"]; ?> </td>
                         <td class="px-6 py-4">
                             <div class="flex space-x-2">
                                 <a href="edit.php?id=<?= $data["id_rute"]; ?>" 
                                    class="bg-blue-500 text-white px-3 py-1 rounded-lg hover:bg-blue-700 transition">Edit</a>
                                 <a href="hapus.php?id=<?= $data["id_rute"]; ?>" 
                                    class="bg-red-500 text-white px-3 py-1 rounded-lg hover:bg-red-700 transition" 
                                    onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">Hapus</a>
                             </div>
                         </td>
                     </tr>
                     <?php $no++; ?>
                 <?php endforeach; ?>
             </tbody>
         </table>
     </div>
 </div>

 <?php require '../../layouts/footer2.php'; ?>
</div>