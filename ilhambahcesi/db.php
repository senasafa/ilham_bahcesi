<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$host = "localhost";
$user = "root";
$pass = "";
$db   = "ilhambahcesi_db";

$conn = new mysqli($host, $user, $pass, $db);
?>
