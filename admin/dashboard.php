<?php
session_start();
require_once '../config.php';
require_once '../auth.php';

if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit;
}

$admin = $_SESSION['admin'];

// ==================== PROSES UPDATE STATUS & TANGGAPAN ====================
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_feedback = $_POST['id_feedback'];
    $status      = $_POST['status'];
    $isi_tanggapan = trim($_POST['isi_tanggapan'] ?? '');

    try {
        // Update status feedback
        $stmt = $pdo->prepare("UPDATE feedback SET status = ?, updated_at = NOW() WHERE id_feedback = ?");
        $stmt->execute([$status, $id_feedback]);

        // Simpan tanggapan jika ada
        if (!empty($isi_tanggapan)) {
            $id_tanggapan = 'TGP' . str_pad(rand(1000,9999), 4, '0', STR_PAD_LEFT);
            
            $stmt = $pdo->prepare("INSERT INTO tanggapan (id_tanggapan, id_admin, id_feedback, isi_tanggapan, created_at, updated_at) 
                                  VALUES (?, ?, ?, ?, NOW(), NOW())");
            $stmt->execute([$id_tanggapan, $admin['id_admin'], $id_feedback, $isi_tanggapan]);
        }

        header("Location: dashboard.php?success=1");
        exit;
    } catch (Exception $e) {
        $error = "Gagal memproses: " . $e->getMessage();
    }
}

// ==================== AMBIL SEMUA DATA ====================
$feedbacks = $pdo->query("SELECT f.*, k.nama_kategori, m.nama as nama_mahasiswa, m.nim 
                         FROM feedback f 
                         LEFT JOIN kategori_layanan k ON f.id_layanan = k.id_layanan 
                         LEFT JOIN mahasiswa m ON f.id_mahasiswa = m.id_mahasiswa 
                         ORDER BY f.created_at DESC")->fetchAll();

$stats = [
    'total'     => $pdo->query("SELECT COUNT(*) FROM feedback")->fetchColumn(),
    'menunggu'  => $pdo->query("SELECT COUNT(*) FROM feedback WHERE status = 0")->fetchColumn(),
    'diterima'  => $pdo->query("SELECT COUNT(*) FROM feedback WHERE status = 1")->fetchColumn(),
    'ditolak'   => $pdo->query("SELECT COUNT(*) FROM feedback WHERE status = 3")->fetchColumn(),
];
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - SVC</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <link rel="shortcut icon" href="/public/favicon.ico" type="image/x-icon">
    <style>
        body { font-family: 'Inter', system-ui, sans-serif; }
        .card-hover:hover { transform: translateY(-3px); }
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
            <div class="text-right">
                <p class="font-medium"><?= htmlspecialchars($admin['nama_admin'] ?? $admin['username']) ?></p>
                <p class="text-xs text-slate-400">Administrator</p>
            </div>
            <a href="../logout.php" class="px-4 py-2 bg-red-600 hover:bg-red-700 rounded text-sm">Logout</a>
            <?php if (($_SESSION['admin']['role'] ?? 'admin') === 'super_admin'): ?>
                <a href="kelola_admin.php" 
                class="px-4 py-2 bg-amber-500 hover:bg-amber-600 text-white rounded text-sm flex items-center gap-2">
                    <i class="fa-solid fa-users-cog"></i>
                    <span>Kelola Admin</span>
                </a>
            <?php endif; ?>

            <a href="ganti_password.php" 
            class="px-4 py-2 bg-white/10 hover:bg-white/20 rounded text-sm flex items-center gap-2">
                <i class="fa-solid fa-key"></i>
                <span>Ganti Password</span>
            </a>
        </div>
    </div>
</header>

<div class="max-w-7xl mx-auto px-6 py-8">

    <!-- STATISTIK -->
    <div class="grid grid-cols-2 md:grid-cols-4 gap-6 mb-10">
        <div class="bg-white rounded p-6 shadow card-hover">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 bg-blue-100 rounded flex items-center justify-center text-blue-600">
                    <i class="fa-solid fa-bullhorn text-2xl"></i>
                </div>
                <div>
                    <p class="text-4xl font-bold"><?= $stats['total'] ?></p>
                    <p class="text-slate-500">Total Aduan</p>
                </div>
            </div>
        </div>
        <div class="bg-white rounded p-6 shadow card-hover">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 bg-amber-100 rounded flex items-center justify-center text-amber-600">
                    <i class="fa-solid fa-clock text-2xl"></i>
                </div>
                <div>
                    <p class="text-4xl font-bold"><?= $stats['menunggu'] ?></p>
                    <p class="text-slate-500">Menunggu</p>
                </div>
            </div>
        </div>
        <div class="bg-white rounded p-6 shadow card-hover">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 bg-emerald-100 rounded flex items-center justify-center text-emerald-600">
                    <i class="fa-solid fa-circle-check text-2xl"></i>
                </div>
                <div>
                    <p class="text-4xl font-bold"><?= $stats['diterima'] ?></p>
                    <p class="text-slate-500">Diterima</p>
                </div>
            </div>
        </div>
        <div class="bg-white rounded p-6 shadow card-hover">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 bg-red-100 rounded flex items-center justify-center text-red-600">
                    <i class="fa-solid fa-circle-xmark text-2xl"></i>
                </div>
                <div>
                    <p class="text-4xl font-bold"><?= $stats['ditolak'] ?></p>
                    <p class="text-slate-500">Ditolak</p>
                </div>
            </div>
        </div>
    </div>

    <!-- DAFTAR ADUAN -->
    <div class="bg-white rounded shadow">
        <div class="px-6 py-5 border-b flex justify-between items-center">
            <h2 class="text-xl font-semibold">Daftar Semua Aduan</h2>
            <span class="text-sm text-slate-500"><?= count($feedbacks) ?> aduan</span>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-slate-50">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-medium text-slate-500">ID</th>
                        <th class="px-6 py-4 text-left text-xs font-medium text-slate-500">Mahasiswa</th>
                        <th class="px-6 py-4 text-left text-xs font-medium text-slate-500">Kategori</th>
                        <th class="px-6 py-4 text-left text-xs font-medium text-slate-500">Judul</th>
                        <th class="px-6 py-4 text-left text-xs font-medium text-slate-500">Status</th>
                        <th class="px-6 py-4 text-left text-xs font-medium text-slate-500">Tanggal</th>
                        <th class="px-6 py-4 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y">
                    <?php foreach ($feedbacks as $fb): ?>
                    <tr class="hover:bg-slate-50">
                        <td class="px-6 py-4 font-mono text-sm"><?= $fb['id_feedback'] ?></td>
                        <td class="px-6 py-4">
                            <div><?= htmlspecialchars($fb['nama_mahasiswa']) ?></div>
                            <div class="text-xs text-slate-400"><?= $fb['nim'] ?></div>
                        </td>
                        <td class="px-6 py-4 text-sm"><?= htmlspecialchars($fb['nama_kategori'] ?? '-') ?></td>
                        <td class="px-6 py-4"><?= htmlspecialchars($fb['judul_feedback']) ?></td>
                        <td class="px-6 py-4">
                            <span class="px-3 py-1 text-xs rounded 
                                <?= $fb['status'] == 0 ? 'bg-yellow-100 text-yellow-700' : 
                                   ($fb['status'] == 1 ? 'bg-emerald-100 text-emerald-700' : 'bg-red-100 text-red-700') ?>">
                                <?= $fb['status'] == 0 ? 'Menunggu' : ($fb['status'] == 1 ? 'Diterima' : 'Ditolak') ?>
                            </span>
                        </td>
                        <td class="px-6 py-4 text-sm text-slate-500"><?= date('d M Y', strtotime($fb['created_at'])) ?></td>
                        <td class="px-6 py-4 text-center">
                            <button onclick="showResponseModal('<?= $fb['id_feedback'] ?>', '<?= htmlspecialchars($fb['judul_feedback']) ?>')" 
                                    class="bg-teal-600 hover:bg-teal-700 text-white px-4 py-2 rounded text-sm">
                                Beri Tanggapan
                            </button>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- RESPONSE MODAL -->
<div id="responseModal" class="hidden fixed inset-0 bg-black/70 flex items-center justify-center z-50">
    <div class="bg-white rounded max-w-lg w-full mx-4">
        <div class="p-6 border-b">
            <h3 class="font-semibold text-lg">Beri Tanggapan</h3>
            <p id="modalJudul" class="text-sm text-slate-500 mt-1"></p>
        </div>
        <form method="POST" class="p-6 space-y-5">
            <input type="hidden" name="id_feedback" id="modalIdFeedback">
            
            <div>
                <label class="block text-sm font-medium mb-2">Status</label>
                <select name="status" class="w-full px-4 py-3 border rounded" required>
                    <option value="0">Menunggu</option>
                    <option value="1">Diterima & Diproses</option>
                    <option value="3">Ditolak</option>
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium mb-2">Isi Tanggapan</label>
                <textarea name="isi_tanggapan" rows="5" class="w-full px-4 py-3 border rounded" 
                          placeholder="Jelaskan tindak lanjut atau alasan penolakan..."></textarea>
            </div>

            <div class="flex gap-3 pt-4">
                <button type="button" onclick="hideModal()" 
                        class="flex-1 py-3 border rounded font-medium">Batal</button>
                <button type="submit" 
                        class="flex-1 py-3 bg-teal-600 text-white rounded font-semibold">Simpan Tanggapan</button>
            </div>
        </form>
    </div>
</div>

<script>
function showResponseModal(id, judul) {
    document.getElementById('modalIdFeedback').value = id;
    document.getElementById('modalJudul').textContent = judul;
    document.getElementById('responseModal').classList.remove('hidden');
}

function hideModal() {
    document.getElementById('responseModal').classList.add('hidden');
}
</script>

</body>
</html>