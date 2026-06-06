<?php
session_start();
require_once '../config.php';
require_once '../auth.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    if (!empty($username) && !empty($password)) {
        $stmt = $pdo->prepare("SELECT * FROM admin WHERE adm_username = ? LIMIT 1");
        $stmt->execute([$username]);
        $admin = $stmt->fetch();

        $passwordOk = false;
        if (password_verify($password, $admin['adm_password'])) {
            $passwordOk = true;
        } elseif ($admin['adm_password'] === $password) {
            $passwordOk = true; // backward compatibility
        }

        if ($passwordOk) {
            $_SESSION['admin'] = [
                'id_admin'   => $admin['id_admin'],
                'username'   => $admin['adm_username'],
                'nama_admin' => $admin['adm_username'],
                'role'       => $admin['role'] ?? 'admin'   // ← TAMBAHKAN INI
            ];
            header("Location: dashboard.php");
            exit;
        } else {
            $error = "Username atau Password salah!";
        }
    } else {
        $error = "Mohon isi username dan password!";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portal Admin - SVC</title>
    
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600&family=Playfair+Display:wght@400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <link rel="stylesheet" href="/assets/css/login_admin.css">
    <link rel="shortcut icon" href="/public/favicon.ico" type="image/x-icon">
</head>
<body>

    <div class="header-section">
        <div class="logo-placeholder">
            <img src="/assets/logo.png" alt="Logo ITH">
        </div>
        <h1 class="title">Portal Admin</h1>
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
                <label>USER ADMIN</label>
                <div class="input-wrapper">
                    <i class="fa-solid fa-user left-icon"></i>
                    <input type="text" name="username" placeholder="Masukkan Username" required autofocus>
                </div>
            </div>

            <div class="input-group">
                <label>PASSWORD</label>
                <div class="input-wrapper">
                    <i class="fa-solid fa-lock left-icon"></i>
                    <input type="password" name="password" id="password" placeholder="Masukkan Password" required>
                    <button type="button" class="btn-toggle-password" onclick="togglePassword()">
                        <i class="fa-solid fa-eye-slash" id="toggleIcon"></i>
                    </button>
                </div>
            </div>

            <button type="submit" class="btn-login">
                Login <i class="fa-solid fa-arrow-right-to-bracket"></i>
            </button>
        </form>
        <a href="#" class="forgot-password">Lupa kata sandi?</a>
        <hr class="divider">

        <a href="../index.php" class="back-link">
            <i class="fa-solid fa-arrow-left"></i> Kembali ke Beranda
        </a>
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