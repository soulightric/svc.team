<?php
session_start();
require_once 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nim      = trim($_POST['nim']);
    $password = $_POST['password'];

    $stmt = $pdo->prepare("SELECT * FROM mahasiswa WHERE nim = ?");
    $stmt->execute([$nim]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['mahasiswa'] = [
            'id'   => $user['id'],
            'nim'  => $user['nim'],
            'nama' => $user['nama']
        ];
        header("Location: dashboard-mahasiswa.php");
        exit;
    } else {
        $error = "NIM atau password salah!";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Mahasiswa</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="shortcut icon" href="assets/logo.png" type="image/x-icon">
</head>
<body class="bg-gray-50 min-h-screen flex items-center justify-center">
    <div class="max-w-md w-full mx-4">
        <div class="bg-white rounded-3xl shadow-xl p-8">
            <h2 class="text-3xl font-bold text-center mb-8">Login Mahasiswa</h2>
            
            <?php if (isset($error)): ?>
                <div class="bg-red-100 text-red-700 p-4 rounded-2xl mb-6 text-center">
                    <?= $error ?>
                </div>
            <?php endif; ?>

            <form method="POST" class="space-y-6">
                <div>
                    <label class="block text-sm font-medium mb-2">NIM</label>
                    <input type="text" name="nim" required
                           class="w-full px-5 py-4 border border-gray-300 rounded-2xl focus:outline-none focus:border-emerald-500">
                </div>
                <div>
                    <label class="block text-sm font-medium mb-2">Password</label>
                    <input type="password" name="password" required
                           class="w-full px-5 py-4 border border-gray-300 rounded-2xl focus:outline-none focus:border-emerald-500">
                </div>
                <button type="submit"
                        class="w-full bg-emerald-600 hover:bg-emerald-700 text-white font-semibold py-4 rounded-2xl transition">
                    MASUK
                </button>
            </form>
        </div>
    </div>
</body>
</html>