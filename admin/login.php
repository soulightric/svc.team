<?php
session_start();
require_once '../config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $password = $_POST['password'];

    $stmt = $pdo->prepare("SELECT * FROM admin WHERE username = ?");
    $stmt->execute([$username]);
    $admin = $stmt->fetch();

    if ($admin && password_verify($password, $admin['password'])) {
        $_SESSION['admin'] = [
            'id'   => $admin['id'],
            'nama' => $admin['nama_admin'],
            'role' => $admin['role']
        ];
        header("Location: dashboard.php");
        exit;
    } else {
        $error = "Username atau password admin salah!";
    }
}
?>

<!-- Desain mirip login mahasiswa, tapi dengan tema admin -->