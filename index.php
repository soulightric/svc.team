<?php
session_start();
require_once 'config.php';

// Ambil statistik keseluruhan
$total = $pdo->query("SELECT COUNT(*) as total FROM feedback")->fetch()['total'];
$menunggu = $pdo->query("SELECT COUNT(*) as jml FROM feedback WHERE status = 0")->fetch()['jml'];
$diterima = $pdo->query("SELECT COUNT(*) as jml FROM feedback WHERE status = 1")->fetch()['jml'];
$ditolak  = $pdo->query("SELECT COUNT(*) as jml FROM feedback WHERE status = 3")->fetch()['jml'];
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Voice Campus</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <link rel="shortcut icon" href="/public/favicon.ico" type="image/x-icon">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap');
        
        body {
            font-family: 'Inter', system-ui, sans-serif;
        }
        
        .hero-bg {
            position: relative;
            overflow: hidden;
        }
        
        .hero-slider {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 1;
        }
        
        .hero-slider img {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            opacity: 0;
            transition: opacity 1s ease-in-out;
        }
        
        .hero-slider img.active {
            opacity: 0.25;
        }
        
        .hero-content {
            position: relative;
            z-index: 2;
        }
        
        .card-hover {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        
        .card-hover:hover {
            transform: translateY(-6px);
            box-shadow: 0 15px 25px -5px rgb(0 0 0 / 0.1), 0 8px 10px -6px rgb(0 0 0 / 0.1);
        }
        
        .stat-card {
            transition: all 0.3s ease;
        }
        
        .rounded-custom {
            border-radius: 12px;
        }
    </style>
</head>
<body class="bg-gray-50">

    <!-- Navigation -->
    <header class="bg-[#0f172a] text-white sticky top-0 z-50 shadow-md">
        <div class="max-w-7xl mx-auto px-4 py-1 flex justify-between items-center">
            <div class="flex items-center gap-4">
                <div class="flex items-center gap-3">
                    <img src="assets/logo.png" alt="Logo Kampus" class="h-8 w-auto object-contain">
                    <div class="hidden sm:block h-5 w-px bg-white/30"></div>
                </div>
                <div>
                    <span class="tracking-tight text-emerald-400">Portal Resmi</span><br>
                    <span class="tracking-tight">SVC</span>
                </div>
            </div>

            <div class="flex items-center gap-2">
                <a href="/admin/login.php" 
                   class="px-5 py-2 bg-white/10 hover:bg-white/20 border border-white/30 rounded text-sm font-medium transition-all hidden md:flex items-center gap-2">
                    <i class="fa-solid fa-user-shield"></i>
                    <span>Admin</span>
                </a>
            </div>
        </div>
    </header>

    <!-- HERO SECTION -->
    <section class="hero-bg text-white py-20 md:py-24">
        <!-- Background Image Slider -->
        <div class="hero-slider" id="heroSlider">
            <!-- Gambar akan di-inject via JavaScript -->
        </div>

        <!-- Overlay gelap agar teks lebih jelas -->
        <div class="absolute inset-0 bg-black/50 z-[1]"></div>

        <div class="max-w-4xl mx-auto px-4 text-center relative z-10 hero-content">
            <h1 class="text-5xl md:text-6xl font-bold leading-tight mb-6">
                Suara Mahasiswa,<br>
                <span class="text-orange-400">Kampus Lebih Baik</span>
            </h1>
            <p class="text-xl text-gray-200 max-w-2xl mx-auto mb-10">
                Platform pengaduan dan feedback fasilitas kampus. Setiap masukan Anda akan ditindaklanjuti oleh tim yang berwenang.
            </p>
            
            <a href="login.php" 
               class="inline-flex items-center justify-center bg-emerald-500 hover:bg-emerald-600 transition-all text-white text-xl font-semibold px-10 py-5 rounded gap-3 group">
                Login & Kirim Aduan
                <i class="fa-solid fa-arrow-right group-active:translate-x-1 transition-transform"></i>
            </a>
            
            <p class="text-sm text-gray-300 mt-6">
                Khusus mahasiswa terdaftar — gunakan NIM dan password Anda
            </p>
        </div>
    </section>

    <!-- STATISTIK -->
    <div class="max-w-7xl mx-auto px-4 -mt-8 relative z-10">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
            
            <div class="stat-card bg-white rounded shadow-xl p-8 text-center card-hover border border-emerald-100">
                <div class="w-14 h-14 mx-auto bg-emerald-100 text-emerald-600 rounded flex items-center justify-center mb-4">
                    <i class="fa-solid fa-bullhorn text-3xl"></i>
                </div>
                <div class="text-5xl font-bold text-gray-800 mb-1"><?= $total ?></div>
                <div class="text-gray-600 font-medium">Total Aduan</div>
            </div>
            
            <div class="stat-card bg-white rounded shadow-xl p-8 text-center card-hover border border-amber-100">
                <div class="w-14 h-14 mx-auto bg-amber-100 text-amber-600 rounded flex items-center justify-center mb-4">
                    <i class="fa-solid fa-clock text-3xl"></i>
                </div>
                <div class="text-5xl font-bold text-gray-800 mb-1"><?= $menunggu ?></div>
                <div class="text-gray-600 font-medium">Menunggu</div>
            </div>
            
            <div class="stat-card bg-white rounded shadow-xl p-8 text-center card-hover border border-cyan-100">
                <div class="w-14 h-14 mx-auto bg-cyan-100 text-cyan-600 rounded flex items-center justify-center mb-4">
                    <i class="fa-solid fa-circle-check text-3xl"></i>
                </div>
                <div class="text-5xl font-bold text-gray-800 mb-1"><?= $diterima ?></div>
                <div class="text-gray-600 font-medium">Diterima</div>
            </div>
            
            <div class="stat-card bg-white rounded shadow-xl p-8 text-center card-hover border border-rose-100">
                <div class="w-14 h-14 mx-auto bg-rose-100 text-rose-600 rounded flex items-center justify-center mb-4">
                    <i class="fa-solid fa-circle-xmark text-3xl"></i>
                </div>
                <div class="text-5xl font-bold text-gray-800 mb-1"><?= $ditolak ?></div>
                <div class="text-gray-600 font-medium">Ditolak</div>
            </div>
        </div>
    </div>

    <!-- CARA KERJA -->
    <section class="max-w-7xl mx-auto px-4 py-20">
        <div class="text-center mb-12">
            <h2 class="text-4xl font-bold text-gray-800 mb-3">Cara Kerja</h2>
            <p class="text-gray-600">Tiga langkah mudah untuk menyampaikan aduan</p>
        </div>
        
        <div class="grid md:grid-cols-3 gap-8">
            <div class="bg-white rounded p-8 card-hover shadow-lg">
                <div class="inline-flex items-center justify-center w-12 h-12 bg-emerald-100 text-emerald-700 rounded font-bold text-2xl mb-6">01</div>
                <h3 class="text-2xl font-semibold mb-3">Login</h3>
                <p class="text-gray-600 leading-relaxed">
                    Masuk menggunakan NIM dan password yang telah didaftarkan oleh admin kampus.
                </p>
            </div>
            
            <div class="bg-white rounded p-8 card-hover shadow-lg">
                <div class="inline-flex items-center justify-center w-12 h-12 bg-emerald-100 text-emerald-700 rounded font-bold text-2xl mb-6">02</div>
                <h3 class="text-2xl font-semibold mb-3">Kirim Aduan</h3>
                <p class="text-gray-600 leading-relaxed">
                    Pilih kategori fasilitas, jelaskan masalah secara detail agar mudah ditindaklanjuti.
                </p>
            </div>
            
            <div class="bg-white rounded p-8 card-hover shadow-lg">
                <div class="inline-flex items-center justify-center w-12 h-12 bg-emerald-100 text-emerald-700 rounded font-bold text-2xl mb-6">03</div>
                <h3 class="text-2xl font-semibold mb-3">Pantau Status</h3>
                <p class="text-gray-600 leading-relaxed">
                    Lihat status aduan Anda: menunggu, diterima, ditolak beserta balasan resmi.
                </p>
            </div>
        </div>
    </section>

    <!-- CTA -->
    <section class="bg-[#0f172a] py-16">
        <div class="max-w-3xl mx-auto px-4 text-center">
            <div class="inline-flex items-center justify-center w-16 h-16 bg-emerald-500/10 text-emerald-400 rounded-full mb-6">
                <i class="fa-solid fa-user text-4xl"></i>
            </div>
            <h2 class="text-4xl font-bold text-white mb-3">Siap Menyampaikan Aduan?</h2>
            <p class="text-emerald-100/80 text-lg mb-10">
                Login sekarang dan bantu kami tingkatkan kualitas fasilitas kampus
            </p>
            <a href="login.php" 
               class="inline-flex items-center justify-center bg-emerald-500 hover:bg-emerald-600 text-white text-xl font-semibold px-12 py-5 rounded gap-3 transition-all">
                Masuk Sekarang
                <i class="fa-solid fa-arrow-right"></i>
            </a>
        </div>
    </section>

    <!-- FOOTER -->
    <footer class="bg-gray-900 text-gray-400 py-12">
        <div class="max-w-7xl mx-auto px-4 text-center">
            <p>&copy; 2026 Suara Mahasiswa - Kampus Lebih Baik</p>
            <p class="text-sm mt-2">Platform Pengaduan Fasilitas Kampus</p>
        </div>
    </footer>

    <script>
        // ==================== HERO IMAGE SLIDER ====================
        const heroImages = [
            'https://ith.ac.id/public/carouselImg/2024-11-22T01-02-08-093Z.jpeg', // kampus / gedung
            'https://ith.ac.id/public/carouselImg/2025-02-07T14-32-15-837Z.JPG', // mahasiswa
            'https://ith.ac.id/public/carouselImg/2024-11-22T00-56-59-919Z.jpeg', // ruang kelas
            'https://ith.ac.id/public/carouselImg/2024-11-22T01-00-23-481Z.jpeg'  // perpustakaan / kampus
        ];

        const sliderContainer = document.getElementById('heroSlider');
        
        // Buat elemen gambar
        heroImages.forEach((src, index) => {
            const img = document.createElement('img');
            img.src = src;
            img.alt = `Hero image ${index + 1}`;
            if (index === 0) img.classList.add('active');
            sliderContainer.appendChild(img);
        });

        let currentSlide = 0;
        const slides = sliderContainer.querySelectorAll('img');

        function showSlide(index) {
            slides.forEach(slide => slide.classList.remove('active'));
            slides[index].classList.add('active');
        }

        function nextSlide() {
            currentSlide = (currentSlide + 1) % slides.length;
            showSlide(currentSlide);
        }

        // Auto slide setiap 5 detik
        setInterval(nextSlide, 5000);

        // Optional: Pause slider saat hover (opsional, bisa dihapus)
        sliderContainer.addEventListener('mouseenter', () => {
            clearInterval(window.heroInterval);
        });
        
        sliderContainer.addEventListener('mouseleave', () => {
            window.heroInterval = setInterval(nextSlide, 5000);
        });
    </script>

</body>
</html>