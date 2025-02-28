<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Halaman Login</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
</head>
<body class="flex justify-center items-center h-screen bg-gray-100">
    <div class="bg-white p-8 rounded-lg shadow-lg w-full max-w-md text-center">
        <h3 class="text-blue-600 font-bold text-2xl">Aviatica</h3>
        <h4 class="text-gray-700 text-lg mb-4">Login to your account</h4>
        <form action="process.php" method="POST" class="text-left">
            <label for="username" class="block text-gray-600">Username</label>
            <div class="flex items-center border rounded-lg px-3 py-2 mb-3">
                <i class="bi bi-person text-gray-500"></i>
                <input type="text" name="username" id="username" class="w-full ml-2 outline-none" placeholder="Enter your username" required>
            </div>
            
            <label for="password" class="block text-gray-600">Password</label>
            <div class="flex items-center border rounded-lg px-3 py-2 mb-3">
                <i class="bi bi-lock text-gray-500"></i>
                <input type="password" name="password" id="password" class="w-full ml-2 outline-none" placeholder="Enter your password" required>
            </div>
            
            <button type="submit" name="login" class="w-full bg-blue-600 text-white py-2 rounded-lg hover:bg-blue-700 flex items-center justify-center gap-2">
                <i class="bi bi-box-arrow-in-right"></i> Login
            </button>
        </form>
        
        <div class="mt-4">
            <p class="text-gray-600">Belum punya akun? <a href="../register/index.php" class="text-blue-600 hover:underline">Daftar di sini</a></p>
        </div>
    </div>
</body>
</html>
