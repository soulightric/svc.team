<?php
// config.php
$host     = '127.0.0.1';
$dbname   = 'svcteam';
$username = 'root';           // sesuaikan jika berbeda
$password = '091106';               // sesuaikan jika ada password

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("❌ Koneksi Database Gagal: " . $e->getMessage());
}
?>