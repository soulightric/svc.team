<?php
session_start();
require_once 'config.php';
require_once 'auth.php';

$error = '';
$_SESSION['mahasiswa']['last_activity'] = time();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nim_username = trim($_POST['nim_username']);
    $password     = trim($_POST['password']);

    if (!empty($nim_username) && !empty($password)) {
        $stmt = $pdo->prepare("SELECT * FROM mahasiswa 
                              WHERE (nim = ? OR username = ? OR email = ?) 
                              LIMIT 1");
        $stmt->execute([$nim_username, $nim_username, $nim_username]);
        $mahasiswa = $stmt->fetch();

        if ($mahasiswa && $mahasiswa['password'] === $password) {
            $_SESSION['mahasiswa'] = [
                'id_mahasiswa' => $mahasiswa['id_mahasiswa'],
                'nama'         => $mahasiswa['nama'],
                'nim'          => $mahasiswa['nim'],
                'username'     => $mahasiswa['username']
            ];
            
            header("Location: feedback.php");
            exit;
        } else {
            $error = "NIM / Username atau Password salah!";
        }
    } else {
        $error = "Mohon isi NIM dan Password!";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portal Mahasiswa - SVC</title>
    
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600&family=Playfair+Display:wght@500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <link rel="stylesheet" href="/assets/css/login_mhs.css">
    <link rel="shortcut icon" href="/public/favicon.ico" type="image/x-icon">
</head>
<body>

    <div class="header-section">
        <div class="logo-placeholder">
            <img src="/assets/logo.png" alt="Logo ITH">
        </div>
        <h1 class="title">Portal Mahasiswa</h1>
        <p class="subtitle">SVC — Student Voice Campus</p>
    </div>

    <div class="login-card">
        <?php if ($error): ?>
            <div class="error-message">
                <?= htmlspecialchars($error) ?>
            </div>
        <?php endif; ?>

        <form action="" method="POST">
            <div class="input-group">
                <label>NIM / Username</label>
                <div class="input-wrapper">
                    <i class="fa-solid fa-hashtag"></i>
                    <input type="text" name="nim_username" 
                           placeholder="Masukkan NIM atau Username" 
                           value="<?= isset($_POST['nim_username']) ? htmlspecialchars($_POST['nim_username']) : '' ?>" 
                           required autofocus>
                </div>
            </div>

            <div class="input-group">
                <label>PASSWORD</label>
                <div class="input-wrapper">
                    <i class="fa-solid fa-lock"></i>
                    <input type="password" name="password" id="password" 
                           placeholder="Masukkan Password" required>
                    <button type="button" class="btn-toggle-password" onclick="togglePassword()">
                        <i class="fa-solid fa-eye-slash" id="toggleIcon"></i>
                    </button>
                </div>
            </div>

            <button type="submit" class="btn-login">
                Login <i class="fa-solid fa-arrow-right-to-bracket"></i>
            </button>
        </form>

        <hr class="divider">

        <a href="../index.php" class="back-link">
            <i class="fa-solid fa-arrow-left"></i> Kembali ke Beranda
        </a>
    </div>

    <div class="footer-link">
        <i class="fa-regular fa-message"></i>
        <span>Belum terdaftar? Hubungi admin kampus</span>
    </div>

    <script>
        function togglePassword() {
            const passwordInput = document.getElementById('password');
            const toggleIcon = document.getElementById('toggleIcon');
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                toggleIcon.classList.remove('fa-eye-slash');
                toggleIcon.classList.add('fa-eye');
            } else {
                passwordInput.type = 'password';
                toggleIcon.classList.remove('fa-eye');
                toggleIcon.classList.add('fa-eye-slash');
            }
        }
    </script>
</body>
</html>