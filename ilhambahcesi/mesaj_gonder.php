<?php
session_start();
include('db.php');
if (!isset($_SESSION['role']) || strtolower($_SESSION['role']) !== 'admin') {
    die("Yetkiniz yok!");
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = (int)$_POST['user_id'];
    $mesaj = $conn->real_escape_string($_POST['mesaj']);

    $kontrol = $conn->query("SELECT id FROM users WHERE id=$user_id");
    if ($kontrol->num_rows == 0) {
        die("Kullanıcı bulunamadı!");
    }

    $conn->query("INSERT INTO mesajlar (user_id, mesaj, tarih) VALUES ($user_id, '$mesaj', NOW())");

    header("Location: admin.php?mesaj=mesaj_gonderildi");
    exit;
}
?>
