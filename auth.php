<?php
function checkMahasiswaLogin() {
    if (session_status() === PHP_SESSION_NONE) session_start();

    $timeout = 30 * 60; // 30 menit
    if (isset($_SESSION['mahasiswa']['last_activity'])) {
        if (time() - $_SESSION['mahasiswa']['last_activity'] >= $timeout) {
            session_destroy();
            header("Location: login.php?timeout=1");
            exit;
        }
    }
    $_SESSION['mahasiswa']['last_activity'] = time();

    if (!isset($_SESSION['mahasiswa']) || empty($_SESSION['mahasiswa']['id_mahasiswa'])) {
        header("Location: login.php");
        exit;
    }
    return $_SESSION['mahasiswa'];
}

function checkAdminLogin() {
    if (session_status() === PHP_SESSION_NONE) session_start();
    if (!isset($_SESSION['admin']) || empty($_SESSION['admin']['id_admin'])) {
        header("Location: admin/login.php");
        exit;
    }
    return $_SESSION['admin'];
}
?>