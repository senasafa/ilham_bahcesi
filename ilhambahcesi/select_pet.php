<?php
session_start();
include 'db.php';
if (!isset($_SESSION['user_id'])) { header("Location: index.php"); exit; }

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $canli = $_POST['canli'];
  $conn->query("UPDATE users SET canli_turu='$canli' WHERE id={$_SESSION['user_id']}");
  header("Location: dashboard.php");
}
?>
<!DOCTYPE html>
<html lang="tr">
<head>
<meta charset="UTF-8">
<title>Canlı Seçimi</title>
<link rel="stylesheet" type="text/css" href="assets/css/style.css">

</head>
<body>
<div class="container">
  <h2>Canlını Seç 🌱</h2>
  <form method="post">
    <select name="canli">
      <optgroup label="Bitkiler">
        <option value="Papatya">🌼 Papatya</option>
        <option value="Meşe Ağacı">🌳 Meşe Ağacı</option>
      
      </optgroup>
      <optgroup label="Hayvanlar">
        <option value="Kedi">🐱 Kedi</option>
        <option value="Tilki">🦊 Tilki</option>
      
      </optgroup>
    </select>
    <button type="submit">Seçimi Kaydet</button>
  </form>
</div>
</body>
</html>
