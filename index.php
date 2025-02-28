<?php
require 'layouts/navbar.php';
require_once 'functions.php';

// Ambil daftar rute untuk dropdown
$ruteData = query("SELECT DISTINCT rute_asal, rute_tujuan FROM rute");

// Ambil input pencarian
$tanggal_pergi = isset($_GET['tanggal_pergi']) ? $_GET['tanggal_pergi'] : '';
$rute_asal = isset($_GET['rute_asal']) ? $_GET['rute_asal'] : '';
$rute_tujuan = isset($_GET['rute_tujuan']) ? $_GET['rute_tujuan'] : '';

// Hindari SQL Injection
$tanggal_pergi = mysqli_real_escape_string($conn, $tanggal_pergi);
$rute_asal = mysqli_real_escape_string($conn, $rute_asal);
$rute_tujuan = mysqli_real_escape_string($conn, $rute_tujuan);

// Pagination
$limit = 6; // Jumlah data per halaman
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $limit;

// Query untuk mendapatkan total data
$queryCount = "SELECT COUNT(*) as total FROM jadwal_penerbangan 
    INNER JOIN rute ON rute.id_rute = jadwal_penerbangan.id_rute 
    INNER JOIN maskapai ON rute.id_maskapai = maskapai.id_maskapai 
    WHERE 1=1";

if (!empty($tanggal_pergi)) {
    $queryCount .= " AND tanggal_pergi = '$tanggal_pergi'";
}
if (!empty($rute_asal)) {
    $queryCount .= " AND rute_asal = '$rute_asal'";
}
if (!empty($rute_tujuan)) {
    $queryCount .= " AND rute_tujuan = '$rute_tujuan'";
}

$totalData = query($queryCount)[0]['total'];
$totalPages = ceil($totalData / $limit);

// Query untuk mendapatkan daftar jadwal penerbangan dengan batasan halaman
$query = "SELECT * FROM jadwal_penerbangan 
    INNER JOIN rute ON rute.id_rute = jadwal_penerbangan.id_rute 
    INNER JOIN maskapai ON rute.id_maskapai = maskapai.id_maskapai 
    WHERE 1=1";

if (!empty($tanggal_pergi)) {
    $query .= " AND tanggal_pergi = '$tanggal_pergi'";
}
if (!empty($rute_asal)) {
    $query .= " AND rute_asal = '$rute_asal'";
}
if (!empty($rute_tujuan)) {
    $query .= " AND rute_tujuan = '$rute_tujuan'";
}

$query .= " LIMIT $limit OFFSET $offset";
$jadwal = query($query);
?>

<!-- Banner Slide Full Layar -->
<div class="relative w-full h-[500px] overflow-hidden animate-fadeIn">
    <div class="absolute inset-0 flex items-center justify-center">
        <div id="slider" class="flex w-full h-full transition-transform duration-500">
            <!-- Slide 1 -->
            <div class="w-full flex-shrink-0 min-w-full relative">
                <img src="/e-ticketing/assets/images/yo.jpg" class="w-full h-full object-cover animate-fadeInUp" alt="Batik Air">
                <div class="absolute inset-0 flex flex-col items-center justify-center text-white text-center bg-black bg-opacity-50 p-6 rounded-lg animate-fadeInDelay">
                    <h1 class="text-4xl font-bold drop-shadow-lg">Pesan Liburan Impian Anda</h1>
                    <p class="text-lg drop-shadow-md">Temukan penerbangan dan pengalaman perjalanan terbaik.</p>
                    <a href="#jadwal-penerbangan" class="mt-4 bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg shadow-lg transition scroll-link">Mulai Pesan</a>

                </div>
            </div>

            <!-- Slide 2 -->
            <div class="w-full flex-shrink-0 min-w-full relative">
                <img src="/e-ticketing/assets/images/oke.jpg" class="w-full h-full object-cover animate-fadeInUp" alt="Garuda Indonesia">
                <div class="absolute inset-0 flex flex-col items-center justify-center text-white text-center bg-black bg-opacity-50 p-6 rounded-lg animate-fadeInDelay">
                    <h1 class="text-4xl font-bold drop-shadow-lg">Jelajahi Destinasi Baru</h1>
                    <p class="text-lg drop-shadow-md">Eksplor dunia dengan penawaran terbaik.</p>
                    <a href="#jadwal-penerbangan" class="mt-4 bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg shadow-lg transition scroll-link">Mulai Pesan</a>

                </div>
            </div>
        </div>
    </div>

    <!-- Tombol Navigasi -->
    <button id="prev" class="absolute left-6 top-1/2 transform -translate-y-1/2 bg-gray-200 text-blue-900 p-3 rounded-full shadow-lg">❮</button>
    <button id="next" class="absolute right-6 top-1/2 transform -translate-y-1/2 bg-gray-200 text-blue-900 p-3 rounded-full shadow-lg">❯</button>

    <!-- Indikator Slide -->
    <div class="absolute bottom-6 left-1/2 transform -translate-x-1/2 flex space-x-2">
        <div class="dot w-3 h-3 bg-white rounded-full cursor-pointer"></div>
        <div class="dot w-3 h-3 bg-gray-400 rounded-full cursor-pointer"></div>
    </div>
</div>


<div class="max-w-[90%] mx-auto px-5 py-10">
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
        <!-- Card 1 -->
        <div class="bg-white shadow-lg rounded-lg overflow-hidden flex flex-col h-full transform transition duration-300 hover:scale-105 hover:shadow-2xl opacity-0" style="animation: fadeIn 0.8s ease-out forwards; animation-delay: 0.2s;">
            <img src="/e-ticketing/assets/images/orang.jpg" alt="Legroom" class="w-full h-56 object-cover">
            <div class="p-6 flex-1">
                <h2 class="text-lg font-bold text-blue-700">RUANG KAKI TAMBAHAN</h2>
                <p class="text-gray-600">Kursi di Kelas Ekonomi dan Bisnis kami telah menerima banyak pujian. Duduk, bersandar, dan bersantailah.</p>
            </div>
        </div>

        <!-- Card 2 -->
        <div class="bg-white shadow-lg rounded-lg overflow-hidden flex flex-col h-full transform transition duration-300 hover:scale-105 hover:shadow-2xl opacity-0" style="animation: fadeIn 0.8s ease-out forwards; animation-delay: 0.4s;">
            <img src="/e-ticketing/assets/images/bisnis.jpg" alt="Business Class" class="w-full h-56 object-cover">
            <div class="p-6 flex-1">
                <h2 class="text-lg font-bold text-blue-700">KELAS BISNIS</h2>
                <p class="text-gray-600">Bepergian dengan mewah dan nyaman dengan kursi kulit kami yang luas dan banyak manfaat lainnya.</p>
            </div>
        </div>

        <!-- Card 3 -->
        <div class="bg-white shadow-lg rounded-lg overflow-hidden flex flex-col h-full transform transition duration-300 hover:scale-105 hover:shadow-2xl opacity-0" style="animation: fadeIn 0.8s ease-out forwards; animation-delay: 0.6s;">
            <img src="/e-ticketing/assets/images/cepet.jpg" alt="Government Travel" class="w-full h-56 object-cover">
            <div class="p-6 flex-1">
                <h2 class="text-lg font-bold text-blue-700">JALUR CEPAT</h2>
                <p class="text-gray-600">Pesawat mempercepat proses keamanan, imigrasi, dan boarding bagi penumpang prioritas.</p>
            </div>
        </div>

        <!-- Card 4 -->
        <div class="bg-white shadow-lg rounded-lg overflow-hidden flex flex-col h-full transform transition duration-300 hover:scale-105 hover:shadow-2xl opacity-0" style="animation: fadeIn 0.8s ease-out forwards; animation-delay: 0.8s;">
            <img src="/e-ticketing/assets/images/pas.jpg" alt="Batik Air Magazine" class="w-full h-56 object-cover">
            <div class="p-6 flex-1">
                <h2 class="text-lg font-bold text-blue-700">PERSYARATAN MASUK DAN KELUAR</h2>
                <p class="text-gray-600">Pemeriksaan tiket, identitas, dan keamanan sebelum naik. Saat keluar, penumpang harus melalui imigrasi (jika internasional), mengambil bagasi, dan melewati bea cukai jika diperlukan.</p>
            </div>
        </div>
    </div>
</div>

<div id="jadwal-penerbangan" class="container mx-auto px-5 py-10">
    <div class="text-center">
        <h1 class="text-3xl font-bold text-blue-800">Jadwal Penerbangan</h1>
        <hr class="border-blue-400 w-1/4 mx-auto mt-2">
    </div>

    <!-- Form Pencarian -->
    <div class="mt-6 flex justify-center">
        <form method="GET" action="" class="w-full max-w-2xl grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            <input type="date" name="tanggal_pergi" value="<?= htmlspecialchars($tanggal_pergi); ?>" class="border p-2 rounded w-full">
            <select name="rute_asal" class="border p-2 rounded w-full">
                <option value="">Pilih Rute Asal</option>
                <?php foreach ($ruteData as $rute) : ?>
                    <option value="<?= $rute['rute_asal']; ?>" <?= $rute_asal == $rute['rute_asal'] ? 'selected' : ''; ?>>
                        <?= $rute['rute_asal']; ?>
                    </option>
                <?php endforeach; ?>
            </select>
            <select name="rute_tujuan" class="border p-2 rounded w-full">
                <option value="">Pilih Rute Tujuan</option>
                <?php foreach ($ruteData as $rute) : ?>
                    <option value="<?= $rute['rute_tujuan']; ?>" <?= $rute_tujuan == $rute['rute_tujuan'] ? 'selected' : ''; ?>>
                        <?= $rute['rute_tujuan']; ?>
                    </option>
                <?php endforeach; ?>
            </select>
            <button type="submit" class="bg-blue-500 text-white rounded text-sm hover:bg-blue-600 transition px-3 py-1.5">
                Cari
            </button>
        </form>
    </div> 

   <!-- List Jadwal Penerbangan -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mt-10">
    <?php if (empty($jadwal)) : ?>
        <p class="col-span-full text-center text-gray-600 animate-fade-in">
            Tidak ada jadwal penerbangan yang tersedia.
        </p>
    <?php else : ?>
        <?php foreach ($jadwal as $index => $data) : ?>
            <div class="bg-white shadow-md rounded-xl overflow-hidden border border-gray-200 transform transition-all duration-300 ease-out scale-95 hover:scale-100 animate-fade-in"
                 style="animation-delay: <?= $index * 100 ?>ms;">
                <div class="p-6">
                    <div class="flex items-center space-x-4">
                        <?php 
                        $logoPath = "assets/images/" . $data['logo_maskapai'];
                        if (file_exists($logoPath)) : ?>
                            <img src="<?= $logoPath; ?>" 
                                 alt="<?= htmlspecialchars($data['nama_maskapai']); ?>" 
                                 class="w-16 h-16 object-contain transition-transform duration-300 hover:scale-110">
                        <?php else : ?>
                            <div class="w-16 h-16 flex items-center justify-center bg-gray-200 rounded">
                                <span class="text-xs text-gray-500">No Image</span>
                            </div>
                        <?php endif; ?>
                        <div>
                            <h2 class="text-xl font-semibold text-blue-900"><?= htmlspecialchars($data['nama_maskapai']); ?></h2>
                            <p class="text-sm text-gray-500"><?= date('d M Y', strtotime($data['tanggal_pergi'])); ?></p>
                        </div>
                    </div>
                    <div class="mt-4">
                        <p class="text-lg font-medium text-gray-800">
                            <?= htmlspecialchars($data['rute_asal']); ?> → <?= htmlspecialchars($data['rute_tujuan']); ?>
                        </p>
                        <p class="text-gray-600"><?= htmlspecialchars($data['waktu_berangkat']); ?> - <?= htmlspecialchars($data['waktu_tiba']); ?></p>
                    </div>
                    <div class="mt-4 flex justify-between items-center">
                        <p class="text-lg font-bold text-green-600">
                            Rp <?= number_format($data['harga'], 0, ',', '.'); ?>
                        </p>
                        <a href="detail.php?id=<?= urlencode($data['id_jadwal']); ?>" 
                           class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600 transition-transform duration-300 hover:scale-110">
                            Lihat Detail
                        </a>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>


<!-- Pagination -->
<div class="mt-8 flex justify-center space-x-2">
        <?php for ($i = 1; $i <= $totalPages; $i++) : ?>
            <a href="?page=<?= $i; ?>&tanggal_pergi=<?= $tanggal_pergi; ?>&rute_asal=<?= $rute_asal; ?>&rute_tujuan=<?= $rute_tujuan; ?>"
               class="px-4 py-2 border rounded <?= ($i == $page) ? 'bg-blue-500 text-white' : 'bg-gray-200'; ?>">
                <?= $i; ?>
            </a>
        <?php endfor; ?>
    </div>
</div>

    
<!-- Lokasi -->
<div class="max-w-[90%] mx-auto px-5 py-10">
    <div class="max-w-4xl mx-auto text-center">
    <h1 class="text-3xl font-bold text-blue-800">Rute Map</h1>
    <hr class="border-blue-400 w-1/4 mx-auto mt-2">
    </div>

    <!-- Container dengan animasi scroll -->
    <div id="peta-container" class="opacity-0 transform translate-y-10 transition-all duration-1000 ease-in-out">
        <iframe 
            class="w-full h-96 mt-6 rounded-lg shadow-lg" 
            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d126918.85956570782!2d106.7048286765274!3d-6.214620674335816!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e69f157239c8e7d%3A0xe7cf31d0207a5d4a!2sJakarta!5e0!3m2!1sen!2sid!4v1616143211232!5m2!1sen!2sid" 
            allowfullscreen="" 
            loading="lazy" 
            referrerpolicy="no-referrer-when-downgrade">
        </iframe>
    </div>
</div>
<style>
@keyframes fadeIn {
    from { opacity: 0; transform: translateY(20px); }
    to { opacity: 1; transform: translateY(0); }
}
@keyframes fadeIn {
        from { opacity: 0; }
        to { opacity: 1; }
    }
    
    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .animate-fadeIn { animation: fadeIn 1s ease-out; }
    .animate-fadeInUp { animation: fadeInUp 1s ease-out; }
    .animate-fadeInDelay { animation: fadeIn 1.5s ease-out; }
    .fade-in {
    opacity: 0;
    transform: translateY(20px);
    transition: opacity 0.6s ease-out, transform 0.6s ease-out;
    }
    .fade-in.show {
        opacity: 1;
        transform: translateY(0);
    }
</style>
<script src="https://unpkg.com/@lottiefiles/lottie-player@latest/dist/lottie-player.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const slider = document.getElementById("slider");
        const slides = slider.children.length;
        const dots = document.querySelectorAll(".dot");
        let currentIndex = 0;
        let autoSlide;

        // Fungsi untuk memperbarui tampilan slider
        function updateSlider() {
            slider.style.transform = `translateX(-${currentIndex * 100}%)`;
            updateDots();
        }

        // Fungsi untuk memperbarui indikator (dots)
        function updateDots() {
            dots.forEach((dot, index) => {
                dot.classList.toggle("bg-white", index === currentIndex);
                dot.classList.toggle("bg-gray-400", index !== currentIndex);
            });
        }

        // Fungsi untuk menjalankan auto slide
        function startAutoSlide() {
            autoSlide = setInterval(() => {
                currentIndex = (currentIndex + 1) % slides;
                updateSlider();
            }, 5000);
        }

        // Hentikan auto-slide saat tombol ditekan
        function stopAutoSlide() {
            clearInterval(autoSlide);
            startAutoSlide(); // Restart auto-slide
        }

        // Tombol navigasi
        document.getElementById("next").addEventListener("click", () => {
            currentIndex = (currentIndex + 1) % slides;
            updateSlider();
            stopAutoSlide();
        });

        document.getElementById("prev").addEventListener("click", () => {
            currentIndex = (currentIndex - 1 + slides) % slides;
            updateSlider();
            stopAutoSlide();
        });

        // Klik pada indikator (dots)
        dots.forEach((dot, index) => {
            dot.addEventListener("click", () => {
                currentIndex = index;
                updateSlider();
                stopAutoSlide();
            });
        });

        // Mulai auto-slide saat halaman dimuat
        startAutoSlide();

        // Efek scroll ke "Jadwal Penerbangan"
        document.querySelectorAll('.scroll-link').forEach(link => {
            link.addEventListener('click', function (e) {
                e.preventDefault();
                const targetId = this.getAttribute('href').substring(1);
                const targetElement = document.getElementById(targetId);
                if (targetElement) {
                    window.scrollTo({
                        top: targetElement.offsetTop - 50,
                        behavior: 'smooth'
                    });
                }
            });
        });

        // Efek animasi fade-in untuk elemen peta saat terlihat di layar
        const peta = document.getElementById("peta-container");
        if (peta) {
            const observer = new IntersectionObserver(entries => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        peta.classList.add("opacity-100");
                    }
                });
            }, { threshold: 0.5 });

            observer.observe(peta);
        }
    });
    document.addEventListener("DOMContentLoaded", function () {
    const elements = document.querySelectorAll("[data-animate]");
    
    const observer = new IntersectionObserver(entries => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add("show");
                observer.unobserve(entry.target);
            }
        });
    }, { threshold: 0.2 });

    elements.forEach(element => {
        observer.observe(element);
    });
});
</script>

        <?php
        require 'layouts/footer.php';
        ?>