<?php
// logout.php - Versi Canggih
session_start();

$redirect = "login.php";

// Cek dari mana user logout
if (isset($_SESSION['admin'])) {
    $redirect = "admin/login.php";
} elseif (isset($_SESSION['mahasiswa'])) {
    $redirect = "login.php";
}

session_unset();
session_destroy();

header("Location: $redirect?logout=1");
exit;
?>