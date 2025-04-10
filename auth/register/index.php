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
        <form action="process.php" method="POST" class="text-left" onsubmit="return validateForm()">
            <label for="email" class="block text-gray-600">Email</label>
            <div class="flex items-center border rounded-lg px-3 py-2 mb-3">
                <i class="bi bi-person-circle text-gray-500"></i>
                <input type="text" name="email" id="email" class="w-full ml-2 outline-none" required>
            </div>
            
            <label for="username" class="block text-gray-600">Username</label>
            <div class="flex items-center border rounded-lg px-3 py-2 mb-3">
                <i class="bi bi-person text-gray-500"></i>
                <input type="text" name="username" id="username" class="w-full ml-2 outline-none" required>
            </div>
            
            <label for="password" class="block text-gray-600">Password</label>
            <div class="flex items-center border rounded-lg px-3 py-2 mb-3 relative">
                <i class="bi bi-key text-gray-500"></i>
                <input type="password" name="password" id="password" class="w-full ml-2 outline-none" required>
                <i class="bi bi-eye-slash text-gray-500 cursor-pointer ml-2 absolute right-3" id="togglePassword" onclick="togglePassword()"></i>
            </div>
            <p id="passwordError" class="text-red-600 text-sm hidden">Password harus minimal 5 karakter!</p>

    
            <!-- Hidden input untuk mengirimkan nilai roles ke backend -->
            <input type="hidden" name="roles" value="penumpang">

            
            <button type="submit" name="register" class="w-full bg-blue-600 text-white py-2 rounded-lg hover:bg-blue-700 flex items-center justify-center gap-2">
                <i class="bi bi-box-arrow-in-right"></i> Register
            </button>
        </form>
        
        <div class="mt-4">
            <p class="text-gray-600">Sudah punya akun? <a href="../login/index.php" class="text-blue-600 hover:underline">Login di sini</a></p>
        </div>
    </div>

    <script>
        // Fungsi untuk validasi password minimal 5 karakter
        function validateForm() {
            var password = document.getElementById("password").value;
            var passwordError = document.getElementById("passwordError");

            if (password.length < 5) {
                passwordError.classList.remove("hidden"); // Menampilkan pesan error
                return false; // Mencegah form dikirim
            } else {
                passwordError.classList.add("hidden");
                return true;
            }
        }

        // Fungsi untuk menampilkan atau menyembunyikan password
        function togglePassword() {
            var passwordInput = document.getElementById("password");
            var toggleIcon = document.getElementById("togglePassword");

            if (passwordInput.type === "password") {
                passwordInput.type = "text"; // Tampilkan password
                toggleIcon.classList.remove("bi-eye-slash");
                toggleIcon.classList.add("bi-eye");
            } else {
                passwordInput.type = "password"; // Sembunyikan password
                toggleIcon.classList.remove("bi-eye");
                toggleIcon.classList.add("bi-eye-slash");
            }
        }
    </script>
</body>
</html>
