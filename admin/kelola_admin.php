<?php
session_start();
require_once '../config.php';
require_once '../auth.php';

// Cek login
if (!isset($_SESSION['admin']) || empty($_SESSION['admin']['id_admin'])) {
    header("Location: login.php");
    exit;
}

$admin = $_SESSION['admin'];
$is_super = ($admin['role'] ?? 'admin') === 'super_admin';

if (!$is_super) {
    header("Location: dashboard.php?error=akses_ditolak");
    exit;
}

$error = '';
$success = '';

// ==================== PROSES TAMBAH ADMIN BARU ====================
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['tambah_admin'])) {
    $username     = trim($_POST['username']);
    $password     = trim($_POST['password']);
    $konfirmasi   = trim($_POST['konfirmasi']);
    $role_baru    = $_POST['role'] ?? 'admin';

    if (empty($username) || empty($password) || empty($konfirmasi)) {
        $error = "Username dan password wajib diisi!";
    } elseif ($password !== $konfirmasi) {
        $error = "Password dan konfirmasi tidak sama!";
    } elseif (strlen($password) < 6) {
        $error = "Password minimal 6 karakter!";
    } else {
        try {
            // Cek username sudah ada?
            $cek = $pdo->prepare("SELECT id_admin FROM admin WHERE adm_username = ?");
            $cek->execute([$username]);
            if ($cek->fetch()) {
                $error = "Username sudah digunakan oleh admin lain!";
            } else {
                // Generate ID Admin baru (AD006, AD007, ...)
                $last = $pdo->query("SELECT id_admin FROM admin ORDER BY id_admin DESC LIMIT 1")->fetch();
                if ($last) {
                    $num = intval(substr($last['id_admin'], 2)) + 1;
                    $new_id = 'AD' . str_pad($num, 3, '0', STR_PAD_LEFT);
                } else {
                    $new_id = 'AD001';
                }

                // Hash password
                $hashed = password_hash($password, PASSWORD_DEFAULT);

                // Insert
                $stmt = $pdo->prepare("INSERT INTO admin (id_admin, role, adm_username, adm_password, created_at) 
                                       VALUES (?, ?, ?, ?, NOW())");
                $stmt->execute([$new_id, $role_baru, $username, $hashed]);

                $success = "Admin baru berhasil ditambahkan! ID: {$new_id} | Username: {$username}";
            }
        } catch (PDOException $e) {
            $error = "Gagal menambahkan admin: " . $e->getMessage();
        }
    }
}

// ==================== AMBIL DAFTAR ADMIN ====================
$admins = $pdo->query("SELECT * FROM admin ORDER BY 
    CASE WHEN role = 'super_admin' THEN 0 ELSE 1 END, 
    created_at DESC")->fetchAll();
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Admin - SVC</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <style>
        body { font-family: 'Inter', system-ui, sans-serif; }
        .admin-card { transition: transform 0.2s ease, box-shadow 0.2s ease; }
        .admin-card:hover { transform: translateY(-2px); box-shadow: 0 10px 15px -3px rgb(0 0 0 / 0.1); }
        .badge-super { background: linear-gradient(135deg, #f59e0b, #d97706); color: white; }
    </style>
</head>
<body class="bg-gray-50">

<header class="bg-[#0f1b2d] text-white py-2">
    <div class="max-w-7xl mx-auto px-6 flex justify-between items-center">
        <div class="flex items-center gap-3">
            <img src="/assets/logo.png" alt="ITH" class="h-8">
            <div>
                <h1 class="text-1xl font-bold">Kelola Admin</h1>
                <p class="text-teal-400 text-xs">Hanya Super Admin yang dapat menambah admin baru</p>
            </div>
        </div>
        <div>
            <a href="dashboard.php" class="px-5 py-2.5 bg-white/10 hover:bg-white/20 rounded text-sm flex items-center gap-2">
                <i class="fa-solid fa-arrow-left"></i> Kembali ke Dashboard
            </a>
        </div>
    </div>
</header>

<div class="max-w-7xl mx-auto px-6 py-8">

    <?php if ($error): ?>
        <div class="bg-red-100 text-red-700 px-5 py-4 rounded mb-6 flex items-center gap-3">
            <i class="fa-solid fa-exclamation-triangle"></i> <?= htmlspecialchars($error) ?>
        </div>
    <?php endif; ?>

    <?php if ($success): ?>
        <div class="bg-emerald-100 text-emerald-700 px-5 py-4 rounded mb-6 flex items-center gap-3">
            <i class="fa-solid fa-check-circle"></i> <?= htmlspecialchars($success) ?>
        </div>
    <?php endif; ?>

    <div class="grid lg:grid-cols-5 gap-8">
        
        <!-- FORM TAMBAH ADMIN -->
        <div class="lg:col-span-2">
            <div class="bg-white rounded shadow p-7 sticky top-6">
                <div class="flex items-center gap-3 mb-6">
                    <div class="w-10 h-10 bg-teal-600 text-white rounded flex items-center justify-center">
                        <i class="fa-solid fa-user-plus"></i>
                    </div>
                    <div>
                        <h3 class="font-semibold text-xl">Tambah Admin Baru</h3>
                        <p class="text-sm text-slate-500">Registrasi admin oleh Super Admin</p>
                    </div>
                </div>

                <form method="POST" class="space-y-5">
                    <input type="hidden" name="tambah_admin" value="1">

                    <div>
                        <label class="text-sm font-medium text-slate-700">Username Admin</label>
                        <input type="text" name="username" required 
                               class="mt-1 w-full px-4 py-3 border rounded focus:border-teal-500"
                               placeholder="contoh: admin_kampus">
                    </div>

                    <div>
                        <label class="text-sm font-medium text-slate-700">Role</label>
                        <select name="role" class="mt-1 w-full px-4 py-3 border rounded focus:border-teal-500">
                            <option value="admin">Admin Biasa</option>
                            <option value="super_admin">Super Admin</option>
                        </select>
                        <p class="text-xs text-amber-600 mt-1">Hati-hati memberikan role Super Admin!</p>
                    </div>

                    <div>
                        <label class="text-sm font-medium text-slate-700">Password</label>
                        <input type="password" name="password" required minlength="6"
                               class="mt-1 w-full px-4 py-3 border rounded focus:border-teal-500"
                               placeholder="Minimal 6 karakter">
                    </div>

                    <div>
                        <label class="text-sm font-medium text-slate-700">Konfirmasi Password</label>
                        <input type="password" name="konfirmasi" required
                               class="mt-1 w-full px-4 py-3 border rounded focus:border-teal-500">
                    </div>

                    <button type="submit" 
                            class="w-full bg-teal-600 hover:bg-teal-700 text-white font-semibold py-3.5 rounded flex items-center justify-center gap-2">
                        <i class="fa-solid fa-plus"></i> Tambahkan Admin
                    </button>
                </form>
            </div>
        </div>

        <!-- DAFTAR ADMIN -->
        <div class="lg:col-span-3">
            <div class="flex justify-between items-center mb-4 px-1">
                <h3 class="font-semibold text-xl">Daftar Admin Saat Ini (<?= count($admins) ?>)</h3>
                <span class="text-xs px-3 py-1 bg-slate-100 text-slate-600 rounded-full">Hanya Super Admin yang bisa menambah</span>
            </div>

            <div class="bg-white rounded shadow overflow-hidden">
                <table class="w-full">
                    <thead class="bg-slate-50">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-medium text-slate-500">ID</th>
                            <th class="px-6 py-4 text-left text-xs font-medium text-slate-500">Username</th>
                            <th class="px-6 py-4 text-left text-xs font-medium text-slate-500">Role</th>
                            <th class="px-6 py-4 text-left text-xs font-medium text-slate-500">Dibuat</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y text-sm">
                        <?php foreach ($admins as $adm): ?>
                        <tr class="hover:bg-slate-50 admin-card">
                            <td class="px-6 py-4 font-mono text-teal-700 font-medium"><?= $adm['id_admin'] ?></td>
                            <td class="px-6 py-4 font-medium"><?= htmlspecialchars($adm['adm_username']) ?></td>
                            <td class="px-6 py-4">
                                <?php if ($adm['role'] === 'super_admin'): ?>
                                    <span class="badge-super px-3 py-1 text-xs font-semibold rounded-full">SUPER ADMIN</span>
                                <?php else: ?>
                                    <span class="px-3 py-1 text-xs font-medium bg-slate-100 text-slate-600 rounded-full">Admin</span>
                                <?php endif; ?>
                            </td>
                            <td class="px-6 py-4 text-slate-500 text-xs">
                                <?= date('d M Y', strtotime($adm['created_at'])) ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

            <div class="mt-4 text-xs text-slate-500 px-2">
                <i class="fa-solid fa-info-circle"></i> 
                Super Admin memiliki akses penuh termasuk menambah admin lain dan mengelola sistem. 
                Berikan role ini hanya kepada orang yang benar-benar dipercaya.
            </div>
        </div>

    </div>
</div>

</body>
</html>