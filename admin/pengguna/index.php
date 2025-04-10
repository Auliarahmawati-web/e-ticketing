<?php
session_start();
require 'functions.php';

// Cek apakah pengguna sudah login
if (!isset($_SESSION["username"])) {
    echo "<script>
        alert('Silahkan login terlebih dahulu, ya!');
        window.location = '../../auth/login/index.php';
    </script>";
    exit;
}

// Ambil parameter pencarian
$search = isset($_GET['search']) ? trim($_GET['search']) : '';
$query = "SELECT * FROM user WHERE roles IN ('Petugas', 'Penumpang', 'Admin')";

if (!empty($search)) {
    $query .= " AND nama_lengkap LIKE '%" . mysqli_real_escape_string($conn, $search) . "%'";
}

$pengguna = query($query);

// Include sidebar
if (file_exists('../../layouts/sidebar_admin.php')) {
    require '../../layouts/sidebar_admin.php';
} else {
    die("File sidebar_admin.php tidak ditemukan.");
}
?>

<div class="p-6 bg-white lg:ml-64 overflow-x-auto">
    <h1 class="text-2xl font-bold mb-4">Halo, <?= htmlspecialchars($_SESSION["email"]); ?></h1>
    <h2 class="text-xl font-semibold mb-6">Halaman Pengguna</h2>

    <div class="flex mb-4">
        <a href="tambah.php" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Tambah</a>
        <form method="GET" class="ml-auto">
            <input type="text" name="search" placeholder="Cari Nama Lengkap..." class="px-4 py-2 border rounded-lg" value="<?= htmlspecialchars($search); ?>">
            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Cari</button>
        </form>
    </div>

    <div class="mt-6 relative overflow-x-auto shadow-md sm:rounded-lg">
        <table class="w-full text-sm text-left text-gray-500">
            <thead class="text-xs text-gray-700 uppercase bg-gray-300">
                <tr>
                    <th class="px-6 py-3">No</th>
                    <th class="px-6 py-3">Username</th>
                    <th class="px-6 py-3">Email</th>
                    <th class="px-6 py-3">Roles</th>
                    <th class="px-6 py-3">Aksi</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                <?php if (!empty($pengguna)) : ?>
                    <?php $no = 1; ?>
                    <?php foreach ($pengguna as $data) : ?>
                        <tr class="hover:bg-gray-100 text-sm">
                            <td class="px-6 py-4 text-gray-700 text-center"> <?= $no++; ?> </td>
                            <td class="px-6 py-4 text-gray-700 font-medium"> <?= htmlspecialchars($data["username"]); ?> </td>
                            <td class="px-6 py-4 text-gray-700"> <?= htmlspecialchars($data["email"]); ?> </td>
                            <td class="px-6 py-4 text-center">
                                <span class="px-3 py-1 font-semibold <?= $data['roles'] == 'Admin' ? 'text-red-500' : ($data['roles'] == 'Penumpang' ? 'text-green-500' : 'text-black'); ?>">
                                    <?= ucfirst(htmlspecialchars($data["roles"])); ?>
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex space-x-2">
                                    <a href="edit.php?id=<?= $data["id_user"]; ?>" 
                                       class="bg-blue-500 text-white px-3 py-1 rounded-lg hover:bg-blue-700 transition">Edit</a>
                                    <a href="hapus.php?id=<?= $data["id_user"]; ?>" 
                                       class="bg-red-500 text-white px-3 py-1 rounded-lg hover:bg-red-700 transition" 
                                       onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">Hapus</a>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else : ?>
                    <tr>
                        <td colspan="5" class="px-6 py-4 text-center text-gray-500">Tidak ada data ditemukan.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?php require '../../layouts/footer2.php'; ?>
</div>