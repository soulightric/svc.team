<?php
// ==================== PASTIKAN TIDAK ADA OUTPUT SEBELUM INI ====================
// ob_start(); // Menangkap output agar redirect aman

session_start();

// ==================== SESSION TIMEOUT 30 MENIT ====================
$timeout = 30 * 60; 

if (isset($_SESSION['mahasiswa']['last_activity'])) {
    $inactive = time() - $_SESSION['mahasiswa']['last_activity'];
    if ($inactive >= $timeout) {
        session_unset();
        session_destroy();
        header("Location: login.php?timeout=1");
        exit;
    }
}
$_SESSION['mahasiswa']['last_activity'] = time();

// ==================== CEK LOGIN (PALING PENTING) ====================
if (!isset($_SESSION['mahasiswa']) || empty($_SESSION['mahasiswa']['id_mahasiswa'])) {
    header("Location: login.php");
    exit;
}


require_once 'config.php';
require_once 'auth.php';

$user = $_SESSION['mahasiswa'];
$error = '';
$success = false;

// ==================== PROSES KIRIM ADUAN ====================
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['kirim_aduan'])) {
    $id_layanan = trim($_POST['id_layanan']);
    $judul      = trim($_POST['judul']);
    $deskripsi  = trim($_POST['deskripsi']);

    if (empty($id_layanan) || empty($judul) || empty($deskripsi)) {
        $error = "Semua field wajib diisi!";
    } else {
        try {
            $stmt = $pdo->query("SELECT id_feedback FROM feedback ORDER BY id_feedback DESC LIMIT 1");
            $last = $stmt->fetch();
            $newId = $last ? 'FD' . str_pad((intval(substr($last['id_feedback'], 2)) + 1), 4, '0', STR_PAD_LEFT) : 'FD0001';

            $stmt = $pdo->prepare("INSERT INTO feedback 
                (id_feedback, id_layanan, id_mahasiswa, judul_feedback, isi_feedback, rating, status, created_at, updated_at) 
                VALUES (?, ?, ?, ?, ?, '3', 0, NOW(), NOW())");
            
            $stmt->execute([$newId, $id_layanan, $user['id_mahasiswa'], $judul, $deskripsi]);
            $success = true;
        } catch (PDOException $e) {
            $error = "Gagal menyimpan: " . $e->getMessage();
        }
    }
}

// ==================== AMBIL DATA ADUAN ====================
$stmt = $pdo->prepare("SELECT f.*, k.nama_kategori, m.nama as nama_mahasiswa, m.nim 
                       FROM feedback f 
                       LEFT JOIN kategori_layanan k ON f.id_layanan = k.id_layanan 
                       LEFT JOIN mahasiswa m ON f.id_mahasiswa = m.id_mahasiswa 
                       ORDER BY f.created_at DESC");
$stmt->execute();
$feedbacks = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Mahasiswa - SVC</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <link rel="shortcut icon" href="/public/favicon.ico" type="image/x-icon">
    <style>
        body { font-family: 'Inter', system-ui, sans-serif; }
        .card-hover:hover { transform: translateY(-4px); }
    </style>
</head>
<body class="bg-[#f8f7f4] min-h-screen">

<!-- HEADER -->
<header class="bg-[#0f1b2d] text-white py-6">
    <div class="max-w-6xl mx-auto px-6 flex justify-between items-center">
        <div class="flex items-center gap-3">
            <img src="/assets/logo.png" alt="ITH" class="h-11">
            <div>
                <h1 class="text-3xl font-bold">SVC</h1>
                <p class="text-teal-400 text-sm">Student Voice Campus</p>
            </div>
        </div>
        <div class="flex items-center gap-4">
            <div class="text-right">
                <p class="font-medium"><?= htmlspecialchars($user['nama']) ?></p>
                <p class="text-xs text-slate-400"><?= $user['nim'] ?></p>
            </div>
            <a href="logout.php" class="px-5 py-2 bg-red-600 hover:bg-red-700 rounded-xl text-sm">Logout</a>
        </div>
    </div>
</header>

<div class="max-w-6xl mx-auto px-6 py-8 grid grid-cols-1 lg:grid-cols-5 gap-8">

    <!-- FORM KIRIM ADUAN -->
    <div class="lg:col-span-2">
        <div class="bg-white rounded-3xl p-7 shadow sticky top-6">
            <h2 class="text-2xl font-semibold mb-2">Buat Aduan Baru</h2>
            <p class="text-slate-500 mb-6">Suara Anda akan terlihat oleh semua mahasiswa</p>

            <?php if ($success): ?>
                <div class="bg-emerald-100 text-emerald-700 p-4 rounded-2xl mb-6">✅ Aduan berhasil dikirim!</div>
            <?php endif; ?>

            <?php if ($error): ?>
                <div class="bg-red-100 text-red-700 p-4 rounded-2xl mb-6"><?= htmlspecialchars($error) ?></div>
            <?php endif; ?>

            <form method="POST">
                <input type="hidden" name="kirim_aduan" value="1">

                <div class="mb-5">
                    <label class="block text-sm font-medium mb-2">Kategori Layanan</label>
                    <select name="id_layanan" required class="w-full px-4 py-3 border rounded-2xl focus:outline-none focus:border-teal-500">
                        <option value="">-- Pilih Kategori --</option>
                        <?php
                        $kat = $pdo->query("SELECT * FROM kategori_layanan ORDER BY nama_kategori");
                        while ($row = $kat->fetch()) {
                            echo "<option value='{$row['id_layanan']}'>{$row['nama_kategori']}</option>";
                        }
                        ?>
                    </select>
                </div>

                <div class="mb-5">
                    <label class="block text-sm font-medium mb-2">Judul Aduan</label>
                    <input type="text" name="judul" maxlength="100" required
                           class="w-full px-4 py-3 border rounded-2xl focus:outline-none focus:border-teal-500"
                           placeholder="Ringkasan masalah...">
                </div>

                <div class="mb-6">
                    <label class="block text-sm font-medium mb-2">Deskripsi Lengkap</label>
                    <textarea name="deskripsi" rows="6" required
                              class="w-full px-4 py-3 border rounded-2xl focus:outline-none focus:border-teal-500"
                              placeholder="Jelaskan secara detail..."></textarea>
                </div>

                <button type="submit" class="w-full bg-teal-600 hover:bg-teal-700 text-white font-semibold py-4 rounded-2xl">
                    Kirim Aduan
                </button>
            </form>
        </div>
    </div>

    <!-- LIST ADUAN -->
    <div class="lg:col-span-3">
        <h2 class="text-2xl font-semibold mb-6">Semua Aduan Mahasiswa (<?= count($feedbacks) ?>)</h2>

        <?php if (empty($feedbacks)): ?>
            <div class="bg-white rounded-3xl p-16 text-center text-slate-400">
                Belum ada aduan yang dibuat.
            </div>
        <?php else: ?>
            <div class="space-y-5">
                <?php foreach ($feedbacks as $fb): ?>
                    <div class="bg-white rounded-3xl p-6 shadow-sm card-hover">
                        <div class="flex justify-between items-start">
                            <div>
                                <span class="px-3 py-1 text-xs font-medium rounded-full 
                                    <?= $fb['status'] == 0 ? 'bg-yellow-100 text-yellow-700' : 
                                       ($fb['status'] == 1 ? 'bg-emerald-100 text-emerald-700' : 'bg-red-100 text-red-700') ?>">
                                    <?= $fb['status'] == 0 ? 'Menunggu' : ($fb['status'] == 1 ? 'Diterima' : 'Ditolak') ?>
                                </span>
                                <p class="text-sm text-slate-500 mt-3">
                                    Oleh: <strong><?= htmlspecialchars($fb['nama_mahasiswa']) ?></strong> (<?= $fb['nim'] ?>)
                                </p>
                            </div>
                            <div class="text-xs text-slate-400 text-right">
                                <?= date('d M Y H:i', strtotime($fb['created_at'])) ?>
                            </div>
                        </div>
                        <h3 class="font-semibold text-lg mt-3"><?= htmlspecialchars($fb['judul_feedback']) ?></h3>
                        <p class="text-slate-600 mt-2"><?= nl2br(htmlspecialchars($fb['isi_feedback'])) ?></p>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</div>

</body>
</html>