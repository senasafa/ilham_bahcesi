<?php
session_start();
include('db.php'); 

if (!isset($_SESSION['role']) || strtolower($_SESSION['role']) !== 'admin') {
    die("Yetkisiz erişim!");
}

$sorgu = $conn->query("SELECT SUM(yardım_tl) as miktar FROM user_creatures");
$sonuc = $sorgu->fetch_assoc();
$biriken_toplam = (float)($sonuc['miktar'] ?? 0);

$mesaj = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['bagis_onayla'])) {
    $bagis_miktari = (float)$_POST['bagis_miktari'];
    $kurum = htmlspecialchars($_POST['kurum']);
    
    if ($bagis_miktari > 0 && $bagis_miktari <= $biriken_toplam) {
    
        $oran = $bagis_miktari / $biriken_toplam;
        $guncelle = $conn->query("UPDATE user_creatures SET yardım_tl = yardım_tl * (1 - $oran)");

        if($guncelle) {
            $biriken_toplam -= $bagis_miktari; 
            $mesaj = "<div class='alert alert-success'>✅ Bağış başarıyla yapıldı!</div>";
        }
    } else {
        $mesaj = "<div class='alert alert-danger'>❌ Hata: Bakiye yetersiz veya miktar geçersiz.</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>Bağış Yap</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container py-5 text-center">
        <?= $mesaj; ?>
        <div class="card shadow p-5">
            <h2 class="text-muted">Sistemde Biriken Toplam</h2>
            <h1 class="display-1 fw-bold text-danger">
                <?= number_format($biriken_toplam, 2); ?> ₺
            </h1>
            
            <form action="" method="POST" class="mt-4 text-start mx-auto" style="max-width: 400px;">
                <label class="fw-bold">Bağışlanacak Kurum</label>
                <select name="kurum" class="form-select mb-3" required>
                    <option value="TEMA">TEMA Vakfı</option>
                    <option value="LÖSEV">LÖSEV</option>
                </select>

                <label class="fw-bold">Bağışlanacak Miktar</label>
                <input type="number" name="bagis_miktari" step="0.01" class="form-control mb-4" value="<?= $biriken_toplam; ?>" max="<?= $biriken_toplam; ?>" required>

                <button type="submit" name="bagis_onayla" class="btn btn-danger w-100 py-3">BAĞIŞI ONAYLA</button>
                <div class="mt-3 text-center"><a href="admin.php">Geri Dön</a></div>
            </form>
        </div>
    </div>
</body>
</html>