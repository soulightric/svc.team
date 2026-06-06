<?php
session_start();
require_once '../config.php';
require_once '../auth.php';

// Cek login admin
if (!isset($_SESSION['admin']) || empty($_SESSION['admin']['id_admin'])) {
    header("Location: login.php");
    exit;
}

$admin = $_SESSION['admin'];
$error = '';
$success = '';

// Proses ganti password
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['ganti_password'])) {
    $password_lama = trim($_POST['password_lama']);
    $password_baru = trim($_POST['password_baru']);
    $konfirmasi    = trim($_POST['konfirmasi']);

    // Validasi
    if (empty($password_lama) || empty($password_baru) || empty($konfirmasi)) {
        $error = "Semua field wajib diisi!";
    } elseif ($password_baru !== $konfirmasi) {
        $error = "Password baru dan konfirmasi tidak sama!";
    } elseif (strlen($password_baru) < 6) {
        $error = "Password baru minimal 6 karakter!";
    } else {
        try {
            // Ambil password saat ini dari DB
            $stmt = $pdo->prepare("SELECT adm_password FROM admin WHERE id_admin = ?");
            $stmt->execute([$admin['id_admin']]);
            $current = $stmt->fetchColumn();

            $password_valid = false;

            // Support hashed password
            if (password_verify($password_lama, $current)) {
                $password_valid = true;
            } 
            // Backward compatibility untuk password lama yang masih plain
            elseif ($current === $password_lama) {
                $password_valid = true;
            }

            if (!$password_valid) {
                $error = "Password lama salah!";
            } else {
                // Hash password baru
                $hashed_baru = password_hash($password_baru, PASSWORD_DEFAULT);

                // Update ke database
                $update = $pdo->prepare("UPDATE admin SET adm_password = ?, updated_at = NOW() WHERE id_admin = ?");
                $update->execute([$hashed_baru, $admin['id_admin']]);

                $success = "Password berhasil diganti! Silakan login kembali dengan password baru jika diminta.";
                
                // Opsional: logout otomatis setelah ganti password untuk keamanan
                // session_destroy();
                // header("Location: login.php?password_changed=1");
                // exit;
            }
        } catch (PDOException $e) {
            $error = "Terjadi kesalahan sistem: " . $e->getMessage();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ganti Password - Admin SVC</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <style>
        body { font-family: 'Inter', system-ui, sans-serif; }
        .card { transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1); }
        .input-focus:focus { border-color: #14b8a6; box-shadow: 0 0 0 3px rgba(20, 184, 166, 0.1); }
    </style>
</head>
<body class="bg-gray-50">

<!-- HEADER -->
<header class="bg-[#0f1b2d] text-white py-2">
    <div class="max-w-7xl mx-auto px-6 flex justify-between items-center">
        <div class="flex items-center gap-3">
            <img src="/assets/logo.png" alt="ITH" class="h-8">
            <div>
                <h1 class="text-1xl font-bold">SVC Admin</h1>
                <p class="text-teal-400 text-xs">Student Voice Campus</p>
            </div>
        </div>
        <div class="flex items-center gap-4">
            <div class="text-right text-sm">
                <p class="font-medium"><?= htmlspecialchars($admin['nama_admin'] ?? $admin['username']) ?></p>
                <p class="text-xs text-slate-400"><?= $admin['role'] ?? 'admin' ?></p>
            </div>
            <a href="dashboard.php" class="px-4 py-2 bg-white/10 hover:bg-white/20 rounded text-sm flex items-center gap-2">
                <i class="fa-solid fa-arrow-left"></i> Kembali
            </a>
        </div>
    </div>
</header>

<div class="max-w-md mx-auto px-6 py-10">
    <div class="bg-white rounded shadow-xl p-8 card">
        <div class="text-center mb-8">
            <div class="w-16 h-16 bg-teal-100 text-teal-600 rounded flex items-center justify-center mx-auto mb-4">
                <i class="fa-solid fa-key text-3xl"></i>
            </div>
            <h2 class="text-3xl font-semibold">Ganti Kata Sandi</h2>
            <p class="text-slate-500 mt-1">Perbarui password akun admin Anda</p>
        </div>

        <?php if ($error): ?>
            <div class="bg-red-100 border border-red-200 text-red-700 px-4 py-3 rounded mb-6 flex items-start gap-3">
                <i class="fa-solid fa-exclamation-circle mt-1"></i>
                <span><?= htmlspecialchars($error) ?></span>
            </div>
        <?php endif; ?>

        <?php if ($success): ?>
            <div class="bg-emerald-100 border border-emerald-200 text-emerald-700 px-4 py-3 rounded mb-6 flex items-start gap-3">
                <i class="fa-solid fa-check-circle mt-1"></i>
                <span><?= htmlspecialchars($success) ?></span>
            </div>
            <div class="text-center">
                <a href="dashboard.php" class="inline-flex items-center gap-2 bg-teal-600 hover:bg-teal-700 text-white px-6 py-3 rounded font-medium">
                    <i class="fa-solid fa-home"></i> Kembali ke Dashboard
                </a>
            </div>
        <?php else: ?>

        <form method="POST" class="space-y-6">
            <input type="hidden" name="ganti_password" value="1">

            <!-- Password Lama -->
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-2">Password Lama</label>
                <div class="relative">
                    <input type="password" name="password_lama" id="password_lama" required
                           class="w-full px-4 py-3 border border-slate-300 rounded input-focus pr-12"
                           placeholder="Masukkan password saat ini">
                    <button type="button" onclick="togglePassword('password_lama', this)" 
                            class="absolute right-4 top-4 text-slate-400 hover:text-slate-600">
                        <i class="fa-solid fa-eye"></i>
                    </button>
                </div>
            </div>

            <!-- Password Baru -->
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-2">Password Baru</label>
                <div class="relative">
                    <input type="password" name="password_baru" id="password_baru" required minlength="6"
                           class="w-full px-4 py-3 border border-slate-300 rounded input-focus pr-12"
                           placeholder="Minimal 6 karakter">
                    <button type="button" onclick="togglePassword('password_baru', this)" 
                            class="absolute right-4 top-4 text-slate-400 hover:text-slate-600">
                        <i class="fa-solid fa-eye"></i>
                    </button>
                </div>
                <p class="text-xs text-slate-500 mt-1">Gunakan kombinasi huruf, angka, dan simbol untuk keamanan lebih baik.</p>
            </div>

            <!-- Konfirmasi -->
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-2">Konfirmasi Password Baru</label>
                <div class="relative">
                    <input type="password" name="konfirmasi" id="konfirmasi" required
                           class="w-full px-4 py-3 border border-slate-300 rounded input-focus pr-12"
                           placeholder="Ulangi password baru">
                    <button type="button" onclick="togglePassword('konfirmasi', this)" 
                            class="absolute right-4 top-4 text-slate-400 hover:text-slate-600">
                        <i class="fa-solid fa-eye"></i>
                    </button>
                </div>
            </div>

            <div class="pt-4 flex gap-3">
                <a href="dashboard.php" 
                   class="flex-1 text-center py-3 border border-slate-300 rounded font-medium hover:bg-slate-50">
                    Batal
                </a>
                <button type="submit" 
                        class="flex-1 bg-teal-600 hover:bg-teal-700 text-white py-3 rounded font-semibold flex items-center justify-center gap-2">
                    <i class="fa-solid fa-sync-alt"></i> Ganti Password
                </button>
            </div>
        </form>

        <?php endif; ?>
    </div>

    <p class="text-center text-xs text-slate-400 mt-6">
        Demi keamanan, password akan di-hash menggunakan algoritma modern.<br>
        Jangan bagikan password kepada siapa pun.
    </p>
</div>

<script>
function togglePassword(fieldId, btn) {
    const input = document.getElementById(fieldId);
    const icon = btn.querySelector('i');
    
    if (input.type === 'password') {
        input.type = 'text';
        icon.classList.remove('fa-eye');
        icon.classList.add('fa-eye-slash');
    } else {
        input.type = 'password';
        icon.classList.remove('fa-eye-slash');
        icon.classList.add('fa-eye');
    }
}
</script>

</body>
</html>