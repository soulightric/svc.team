<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Voice Campus</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <link rel="shortcut icon" href="assets/logo.png" type="image/x-icon">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap');
        
        body {
            font-family: 'Inter', system-ui, sans-serif;
        }
        
        .hero-bg {
            background: linear-gradient(135deg, #1e2937 0%, #0f172a 100%);
        }
        
        .card-hover {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        
        .card-hover:hover {
            transform: translateY(-8px);
            box-shadow: 0 20px 25px -5px rgb(0 0 0 / 0.1), 0 8px 10px -6px rgb(0 0 0 / 0.1);
        }
        
        .stat-card {
            transition: all 0.3s ease;
        }
    </style>
</head>
<body class="bg-gray-50">
    <!-- navigation bar -->
    <header class="bg-[#0f172a] text-white sticky top-0 z-50 shadow-md">
        <div class="max-w-7xl mx-auto px-4 py-4 flex justify-between items-center">
            <!-- logo kampus -->
            <div class="flex items-center gap-4">
                <div class="flex items-center gap-3">
                    <img id="campus-logo" 
                         src="assets/logo.png" 
                         alt="Logo Kampus" 
                         class="h-12 w-auto object-contain">
                    
                    <div class="hidden sm:block h-8 w-px bg-white/30"></div>
                </div>
                <!-- logo sistem -->
                <div class="flex items-center gap-3">
                    <div>
                        <span class="text-2xl tracking-tight text-emerald-400">Portal Resmi</span><br>
                        <span class="text-2xl tracking-tight">SVC</span>
                    </div>
                </div>
            </div>

            <!-- Right Side -->
            <div class="flex items-center gap-4">           
                <a href="/admin/login.php" 
                   class="px-5 py-2 bg-white/10 hover:bg-white/20 border border-white/30 rounded-2xl text-sm font-medium transition-all hidden md:flex items-center gap-2">
                    <i class="fa-solid fa-user-shield"></i>
                    <span>Admin</span>
                </a>
            </div>
        </div>
    </header>

    <!-- HERO -->
    <section class="hero-bg text-white py-20">
        <div class="max-w-4xl mx-auto px-4 text-center">
            <h1 class="text-5xl md:text-6xl font-bold leading-tight mb-6">
                Suara Mahasiswa,<br>
                <span class="text-emerald-400">Kampus Lebih Baik</span>
            </h1>
            <p class="text-xl text-gray-300 max-w-2xl mx-auto mb-10">
                Platform pengaduan dan feedback fasilitas kampus. Setiap masukan Anda akan ditindaklanjuti oleh tim yang berwenang.
            </p>
            
            <button>
                <a href="login.php" 
                class="bg-emerald-500 hover:bg-emerald-600 transition-all text-white text-xl font-semibold px-10 py-5 rounded-3xl flex items-center gap-3 mx-auto group">
                Login & Kirim Aduan
                <i class="fa-solid fa-arrow-right group-active:translate-x-1 transition-transform"></i>
            </a>
            </button>
            
            <p class="text-sm text-gray-400 mt-6">
                Khusus mahasiswa terdaftar — gunakan NIM dan password Anda
            </p>
        </div>
    </section>

    <!-- STATS -->
    <div class="max-w-7xl mx-auto px-4 -mt-8 relative z-10">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
            <!-- Stat 1 -->
            <div class="stat-card bg-white rounded-3xl shadow-xl p-8 text-center card-hover border border-emerald-100">
                <div class="w-14 h-14 mx-auto bg-emerald-100 text-emerald-600 rounded-2xl flex items-center justify-center mb-4">
                    <i class="fa-solid fa-bullhorn text-3xl"></i>
                </div>
                <div class="text-5xl font-bold text-gray-800 mb-1">0</div>
                <div class="text-gray-600 font-medium">Total Aduan</div>
            </div>
            
            <!-- Stat 2 -->
            <div class="stat-card bg-white rounded-3xl shadow-xl p-8 text-center card-hover border border-amber-100">
                <div class="w-14 h-14 mx-auto bg-amber-100 text-amber-600 rounded-2xl flex items-center justify-center mb-4">
                    <i class="fa-solid fa-clock text-3xl"></i>
                </div>
                <div class="text-5xl font-bold text-gray-800 mb-1">0</div>
                <div class="text-gray-600 font-medium">Menunggu</div>
            </div>
            
            <!-- Stat 3 -->
            <div class="stat-card bg-white rounded-3xl shadow-xl p-8 text-center card-hover border border-cyan-100">
                <div class="w-14 h-14 mx-auto bg-cyan-100 text-cyan-600 rounded-2xl flex items-center justify-center mb-4">
                    <i class="fa-solid fa-circle-check text-3xl"></i>
                </div>
                <div class="text-5xl font-bold text-gray-800 mb-1">0</div>
                <div class="text-gray-600 font-medium">Diterima</div>
            </div>
            
            <!-- Stat 4 -->
            <div class="stat-card bg-white rounded-3xl shadow-xl p-8 text-center card-hover border border-rose-100">
                <div class="w-14 h-14 mx-auto bg-rose-100 text-rose-600 rounded-2xl flex items-center justify-center mb-4">
                    <i class="fa-solid fa-circle-xmark text-3xl"></i>
                </div>
                <div class="text-5xl font-bold text-gray-800 mb-1">0</div>
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
            <!-- Step 1 -->
            <div class="bg-white rounded-3xl p-8 card-hover shadow-lg">
                <div class="inline-flex items-center justify-center w-12 h-12 bg-emerald-100 text-emerald-700 rounded-2xl font-bold text-2xl mb-6">01</div>
                <h3 class="text-2xl font-semibold mb-3">Login</h3>
                <p class="text-gray-600 leading-relaxed">
                    Masuk menggunakan NIM dan password yang telah didaftarkan oleh admin kampus.
                </p>
            </div>
            
            <!-- Step 2 -->
            <div class="bg-white rounded-3xl p-8 card-hover shadow-lg">
                <div class="inline-flex items-center justify-center w-12 h-12 bg-emerald-100 text-emerald-700 rounded-2xl font-bold text-2xl mb-6">02</div>
                <h3 class="text-2xl font-semibold mb-3">Kirim Aduan</h3>
                <p class="text-gray-600 leading-relaxed">
                    Pilih kategori fasilitas, jelaskan masalah secara detail agar mudah ditindaklanjuti.
                </p>
            </div>
            
            <!-- Step 3 -->
            <div class="bg-white rounded-3xl p-8 card-hover shadow-lg">
                <div class="inline-flex items-center justify-center w-12 h-12 bg-emerald-100 text-emerald-700 rounded-2xl font-bold text-2xl mb-6">03</div>
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
            <button onclick="showLoginModal()" 
                    class="bg-emerald-500 hover:bg-emerald-600 text-white text-xl font-semibold px-12 py-6 rounded-3xl inline-flex items-center gap-3 transition-all">
                <i class="fa-solid fa-arrow-right"></i>
                <span>Masuk Sekarang</span>
            </button>
        </div>
    </section>

    <!-- FOOTER -->
    <footer class="bg-gray-900 text-gray-400 py-12">
        <div class="max-w-7xl mx-auto px-4 text-center">
            <p>&copy; 2026 Suara Mahasiswa - Kampus Lebih Baik</p>
            <p class="text-sm mt-2">Platform Pengaduan Fasilitas Kampus</p>
        </div>
    </footer>

    <!-- LOGIN MODAL -->
    <div id="loginModal" class="fixed inset-0 bg-black/70 hidden flex items-center justify-center z-50">
        <div class="bg-white rounded-3xl max-w-md w-full mx-4 overflow-hidden">
            <div class="px-8 py-6 border-b flex justify-between items-center">
                <h3 class="text-2xl font-semibold">Login Mahasiswa</h3>
                <button onclick="hideLoginModal()" class="text-gray-400 hover:text-gray-600">
                    <i class="fa-solid fa-xmark text-2xl"></i>
                </button>
            </div>
            
            <div class="p-8 space-y-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">NIM</label>
                    <input type="text" placeholder="Contoh: 2023123456" 
                           class="w-full px-5 py-4 border border-gray-300 rounded-2xl focus:outline-none focus:border-emerald-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Password</label>
                    <input type="password" placeholder="Masukkan password" 
                           class="w-full px-5 py-4 border border-gray-300 rounded-2xl focus:outline-none focus:border-emerald-500">
                </div>
                
                <button onclick="fakeLogin()" 
                        class="w-full bg-emerald-600 hover:bg-emerald-700 py-4 rounded-2xl text-white font-semibold text-lg transition-colors">
                    Masuk
                </button>
                
                <div class="text-center text-sm text-gray-500">
                    Belum terdaftar? Hubungi admin kampus Anda
                </div>
            </div>
        </div>
    </div>

    <script>
        // Tailwind script already included via CDN
        
        // function showLoginModal() {
        //     document.getElementById('loginModal').classList.remove('hidden');
        //     document.getElementById('loginModal').classList.add('flex');
        // }
        
        // function hideLoginModal() {
        //     const modal = document.getElementById('loginModal');
        //     modal.classList.add('hidden');
        //     modal.classList.remove('flex');
        // }
        
        // function fakeLogin() {
        //     alert("✅ Login berhasil! (Demo Mode)\n\nAnda akan diarahkan ke dashboard pengaduan.");
        //     hideLoginModal();
        // }
        
        // Close modal when clicking outside
        document.getElementById('loginModal').addEventListener('click', function(e) {
            if (e.target === this) {
                hideLoginModal();
            }
        });
        
        // Keyboard escape
        document.addEventListener('keydown', function(e) {
            if (e.key === "Escape") {
                hideLoginModal();
            }
        });
    </script>
</body>
</html>