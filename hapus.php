<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
session_start();
require_once 'config.php';

// Pastikan pengguna sudah login
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user']['id'];

try {
    // Hapus data pengguna dari database
    $delete_query = "DELETE FROM users WHERE id = ?";
    $stmt = $db->prepare($delete_query);
    $stmt->execute([$user_id]);

    // Hapus sesi
    session_destroy();

    // Redirect ke halaman login setelah akun dihapus
    header("Location: login.php");
    exit();
} catch (PDOException $e) {
    echo "Terjadi kesalahan: " . $e->getMessage();
}
