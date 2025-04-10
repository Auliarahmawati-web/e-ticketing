<?php 
require 'functions.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Aviatica</title>
  <!-- Sertakan Tailwind CSS melalui CDN -->
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="pt-16"> <!-- Tambahkan padding agar konten tidak tertutup navbar -->
  <nav class="bg-gray-100 shadow fixed top-0 left-0 w-full z-50">
    <div class="max-w-7xl mx-auto px-4">
      <div class="flex justify-between items-center py-4">

       <!-- Navbar Brand -->
        <div class="flex-shrink-0">
          <a href="#" class="flex items-center space-x-3 text-3xl font-bold text-blue-600">
            <img src="assets/images/a.png" alt="Logo Aviatica" class="h-12 w-12 object-cover rounded-full">
            <span class="text-3xl">Aviatica</span>
          </a>
        </div>
 
        <!-- Desktop Menu -->
        <div class="hidden md:flex md:items-center">
          <div class="ml-10 flex items-baseline space-x-6">
            <a href="index.php" class="text-gray-600 hover:text-blue-500 px-3 py-2 rounded-md text-sm font-medium">Home</a>
            <a href="cart.php" class="text-gray-600 hover:text-blue-500 px-3 py-2 rounded-md text-sm font-medium">Cart</a>
            <a href="riwayat-transaksi.php" class="text-gray-600 hover:text-blue-500 px-3 py-2 rounded-md text-sm font-medium">History Transaksi</a>
          </div>
        </div>
        
        <!-- Authentication -->
        <div class="hidden md:flex md:items-center">
          <?php if(isset($_SESSION['username'])) : ?>
            <span class="text-gray-600 mr-4">Halo, selamat datang <?= $_SESSION['username']; ?></span>
            <a href="logout.php" class="px-3 py-2 bg-blue-500 text-white rounded-md text-sm font-medium hover:bg-blue-600">Logout</a>
          <?php else : ?>
            <a href="auth/login/" class="px-3 py-2 bg-blue-500 text-white rounded-md text-sm font-medium hover:bg-blue-600 mr-2">Login</a>
            <a href="auth/register/" class="px-3 py-2 bg-green-500 text-white rounded-md text-sm font-medium hover:bg-green-600">Register</a>
          <?php endif; ?>
        </div>
        
        <!-- Mobile Menu Button -->
        <div class="md:hidden">
          <button id="mobile-menu-button" class="text-gray-600 hover:text-blue-500 focus:outline-none">
            <svg class="h-6 w-6 fill-current" viewBox="0 0 24 24">
              <path fill-rule="evenodd" d="M4 5h16v2H4zM4 11h16v2H4zM4 17h16v2H4z" />
            </svg>
          </button>
        </div>
      </div>
    </div>
    <!-- Mobile Menu -->
    <div id="mobile-menu" class="md:hidden hidden">
      <div class="px-2 pt-2 pb-3 space-y-1 sm:px-3">
        <a href="index.php" class="block text-gray-600 hover:text-blue-500 px-3 py-2 rounded-md text-base font-medium">Home</a>
        <a href="cart.php" class="block text-gray-600 hover:text-blue-500 px-3 py-2 rounded-md text-base font-medium">Cart</a>
        <a href="riwayat-transaksi.php" class="block text-gray-600 hover:text-blue-500 px-3 py-2 rounded-md text-base font-medium">History Transaksi</a>
      </div>
      <div class="border-t border-gray-200 pt-4 pb-3">
        <div class="px-2">
          <?php if(isset($_SESSION['username'])) : ?>
            <span class="block text-gray-600 mb-2">Halo, selamat datang <?= $_SESSION['nama_lengkap']; ?></span>
            <a href="logout.php" class="block px-3 py-2 bg-blue-500 text-white rounded-md text-base font-medium hover:bg-blue-600">Logout</a>
          <?php else : ?>
            <a href="auth/login/" class="block px-3 py-2 bg-blue-500 text-white rounded-md text-base font-medium hover:bg-blue-600 mb-2">Login</a>
            <a href="auth/register/" class="block px-3 py-2 bg-green-500 text-white rounded-md text-base font-medium hover:bg-green-600">Register</a>
          <?php endif; ?>
        </div>
      </div>
    </div>
  </nav>

  <!-- Script Toggle Mobile Menu -->
  <script>
    const mobileMenuButton = document.getElementById('mobile-menu-button');
    const mobileMenu = document.getElementById('mobile-menu');

    mobileMenuButton.addEventListener('click', () => {
      mobileMenu.classList.toggle('hidden');
    });
  </script>
</body>
</html>