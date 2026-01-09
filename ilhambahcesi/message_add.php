<?php
session_start();
include('db.php');

if ($_SESSION['role'] !== 'admin') {
    die("Yetkisiz");
}

$user_id = intval($_POST['user_id']);
$message = $_POST['message'];

$conn->query("INSERT INTO messages (user_id, message) VALUES ($user_id,'$message')");

header("Location: admin.php");
exit;
