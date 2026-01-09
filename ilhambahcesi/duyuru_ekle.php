<?php
session_start();
include('db.php');

if (!isset($_SESSION['role']) || strtolower($_SESSION['role']) !== 'admin') {
    die("Yetkiniz yok!");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $baslik = $conn->real_escape_string($_POST['baslik']);
    $icerik = $conn->real_escape_string($_POST['icerik']);

    $conn->query("INSERT INTO duyurular (baslik, icerik, tarih) VALUES ('$baslik','$icerik',NOW())");

    header("Location: admin.php?mesaj=duyuru_eklendi");
    exit;
}
?>
