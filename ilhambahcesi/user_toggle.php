<?php
session_start();
include('db.php');

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    die("Yetkisiz erişim");
}

$id = intval($_GET['id']);

$user = $conn->query("SELECT status FROM users WHERE id=$id")->fetch_assoc();

$newStatus = ($user['status'] === 'active') ? 'passive' : 'active';

$conn->query("UPDATE users SET status='$newStatus' WHERE id=$id");

header("Location: admin.php");
exit;
