<?php
session_start();

// Cek apakah sesi sudah dimulai sebelumnya
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require '../layouts/sidebar_admin.php';

// Koneksi ke database (gantilah sesuai dengan konfigurasi database-mu)
$conn = new mysqli("localhost", "root", "", "e-ticketing");

// Cek koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

if (!isset($_SESSION["username"])) {
    echo "<script>alert('Silahkan login terlebih dahulu, ya!'); window.location = '../auth/login/index.php';</script>";
    exit;
}

// Mengambil data statistik dari database
$tiket_terjual = $conn->query("SELECT SUM(jumlah_tiket) AS total FROM order_detail")->fetch_assoc()['total'] ?? 0;
$jumlah_penumpang = $conn->query("SELECT COUNT(DISTINCT id_user) AS total FROM order_detail")->fetch_assoc()['total'] ?? 0;
$jumlah_verifikasi = $conn->query("SELECT COUNT(*) AS total FROM order_tiket WHERE status='terverifikasi'")->fetch_assoc()['total'] ?? 0;
$total_pendapatan = $conn->query("SELECT SUM(total_harga) AS total FROM order_detail")->fetch_assoc()['total'] ?? 0;
$persen_verifikasi = ($tiket_terjual > 0) ? ($jumlah_verifikasi / $tiket_terjual) * 100 : 0;
?>

<body class="bg-white">
    <div class="flex">
        <div class="w-64 min-h-screen bg-white shadow-md">
            <?php require '../layouts/sidebar_admin.php'; ?>
        </div>
        <div class="flex-1 p-8 bg-white min-h-screen">
    <h1 class="text-2xl font-bold text-gray-900 text-center">Dashboard Aviatica</h1>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mt-8">
        
 <!-- Card TIKET TERJUAL -->
<div class="card bg-white p-6 rounded-lg shadow-xl border-l-4 border-blue-500">
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-gray-600 text-sm font-semibold">TIKET TERJUAL</h2>
            <p class="text-2xl font-bold text-gray-800 counter" data-target="<?= $tiket_terjual; ?>">0</p>
        </div>
        <i class="bi bi-calendar text-4xl text-gray-300"></i>
    </div>
</div>

<!-- Card JUMLAH PENUMPANG -->
<div class="card bg-white p-6 rounded-lg shadow-xl border-l-4 border-green-500">
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-gray-600 text-sm font-semibold">JUMLAH NAMA PENUMPANG</h2>
            <p class="text-2xl font-bold text-gray-800 counter" data-target="<?= $jumlah_penumpang; ?>">0</p>
        </div>
        <i class="bi bi-person-plus text-4xl text-gray-300"></i>
    </div>
</div>

<!-- Card JUMLAH VERIFIKASI -->
<div class="card bg-white p-6 rounded-lg shadow-xl border-l-4 border-teal-500">
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-gray-600 text-sm font-semibold">JUMLAH VERIFIKASI</h2>
            <p class="text-2xl font-bold text-gray-800 counter" data-target="<?= $persen_verifikasi; ?>" data-unit="%">0%</p>
            <div class="mt-2 w-full bg-gray-200 rounded-full h-2.5 shadow-inner">
                <div class="bg-teal-500 h-2.5 rounded-full shadow-md progress-bar" data-width="<?= $persen_verifikasi; ?>%" style="width: 0%;"></div>
            </div>
        </div>
        <i class="bi bi-clipboard-check text-4xl text-gray-300"></i>
    </div>
</div>

<!-- Card TOTAL PENDAPATAN -->
<div class="card bg-white p-6 rounded-lg shadow-xl border-l-4 border-yellow-500">
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-gray-600 text-sm font-semibold">TOTAL PENDAPATAN</h2>
            <p class="text-2xl font-bold text-gray-800 counter currency" data-target="<?= $total_pendapatan; ?>">Rp 0</p>
        </div>
        <i class="bi bi-cash text-4xl text-gray-300"></i>
    </div>
</div>


</body>

<?php
// Tutup koneksi database
$conn->close();
?>
<style>
/* Animasi fade-in dan slide-up */
.card {
    opacity: 0;
    transform: translateY(30px);
    transition: opacity 0.6s ease-out, transform 0.6s ease-out;
}

/* Animasi saat elemen muncul */
.card.show {
    opacity: 1;
    transform: translateY(0);
}
</style>
<!-- Tambahkan GSAP CDN -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>
<!-- JavaScript untuk Animasi -->
<script>
document.addEventListener("DOMContentLoaded", function () {
    const cards = document.querySelectorAll(".card");
    const counters = document.querySelectorAll(".counter");
    const speed = 100;

    // Animasi fade-in + slide-up untuk card
    const observer = new IntersectionObserver(entries => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add("show");
            }
        });
    }, { threshold: 0.2 });

    cards.forEach(card => observer.observe(card));

    // Animasi counter angka naik
    counters.forEach(counter => {
        const updateCount = () => {
            const target = +counter.getAttribute("data-target");
            let count = 0;
            const increment = target / speed;

            const timer = setInterval(() => {
                count += increment;
                if (count >= target) {
                    count = target;
                    clearInterval(timer);
                }
                if (counter.classList.contains("currency")) {
                    counter.textContent = "Rp " + new Intl.NumberFormat("id-ID").format(Math.floor(count));
                } else {
                    counter.textContent = Math.floor(count) + (counter.dataset.unit || "");
                }
            }, 15);
        };
        updateCount();
    });

    // Animasi progress bar
    const progressBars = document.querySelectorAll(".progress-bar");
    progressBars.forEach(bar => {
        const width = bar.getAttribute("data-width");
        bar.style.width = width;
    });
});
</script>
</body>
