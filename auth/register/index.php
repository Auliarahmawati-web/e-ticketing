<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
</head>
<body class="flex justify-center items-center h-screen bg-gray-100">
    <div class="bg-white p-8 rounded-lg shadow-lg w-full max-w-md text-center">
        <h3 class="text-blue-600 font-bold text-2xl">Aviatica</h3>
        <h4 class="text-gray-700 text-lg mb-4">Register an Account</h4>
        <form action="process.php" method="POST" class="text-left">
            <label for="nama_lengkap" class="block text-gray-600">Full Name</label>
            <div class="flex items-center border rounded-lg px-3 py-2 mb-3">
                <i class="bi bi-person-circle text-gray-500"></i>
                <input type="text" name="nama_lengkap" id="nama_lengkap" class="w-full ml-2 outline-none" required>
            </div>
            
            <label for="username" class="block text-gray-600">Username</label>
            <div class="flex items-center border rounded-lg px-3 py-2 mb-3">
                <i class="bi bi-person text-gray-500"></i>
                <input type="text" name="username" id="username" class="w-full ml-2 outline-none" required>
            </div>
            
            <label for="password" class="block text-gray-600">Password</label>
            <div class="flex items-center border rounded-lg px-3 py-2 mb-3">
                <i class="bi bi-key text-gray-500"></i>
                <input type="password" name="password" id="password" class="w-full ml-2 outline-none" required>
            </div>
            
            <label for="roles" class="block text-gray-600">Role</label>
            <div class="flex items-center border rounded-lg px-3 py-2 mb-3">
                <i class="bi bi-person-badge text-gray-500"></i>
                <select name="roles" id="roles" class="w-full ml-2 outline-none bg-transparent" required>
                    <option value="Penumpang">Penumpang</option>
                    <option value="Petugas">Petugas</option>
                    <option value="Admin">Admin</option>
                </select>
            </div>
            
            <button type="submit" name="register" class="w-full bg-blue-600 text-white py-2 rounded-lg hover:bg-blue-700 flex items-center justify-center gap-2">
                <i class="bi bi-box-arrow-in-right"></i> Register
            </button>
        </form>
        
        <div class="mt-4">
            <p class="text-gray-600">Sudah punya akun? <a href="../login/index.php" class="text-blue-600 hover:underline">Login di sini</a></p>
        </div>
    </div>
</body>
</html>