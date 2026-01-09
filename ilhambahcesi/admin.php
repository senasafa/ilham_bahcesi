<?php
session_start();
include('db.php');
if (!isset($_SESSION['role']) || strtolower($_SESSION['role']) !== 'admin') {
    die("Bu sayfaya erişim yetkiniz yok!");
}
$user_count = $conn->query("
    SELECT COUNT(*) AS total 
    FROM users 
    WHERE role='ogrenci'
")->fetch_assoc();
$admin_total_help_res = $conn->query("SELECT SUM(yardım_tl) as genel_toplam FROM user_creatures");
$admin_total_data = $admin_total_help_res->fetch_assoc();
$gerçek_yardim = $admin_total_data['genel_toplam'] ?? 0;

$total_points = $conn->query("
    SELECT COALESCE(SUM(points),0) AS total 
    FROM users
")->fetch_assoc();

$farmed_count = $conn->query("
    SELECT COUNT(*) AS total 
    FROM user_creatures 
    WHERE status='farmed'
")->fetch_assoc();
$yardim_miktari = $total_points['total'] * 0.5;
?>
<!DOCTYPE html>
<html lang="tr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>İlham Bahçesi | Admin Paneli</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<style>
.stat-card {
    border-left: 5px solid #27ae60;
    transition: .3s;
    text-decoration: none;
    color: inherit;
    display: block;
}
.stat-card:hover {
    transform: translateY(-5px);
    background-color: #f8f9fa;
}
</style>
</head>
<body class="bg-light">

<nav class="navbar navbar-dark bg-dark mb-4 shadow-sm">
    <div class="container">
        <span class="navbar-brand">🛡️ İlham Bahçesi Yönetim</span>
        <a href="logout.php" class="btn btn-outline-danger btn-sm">Çıkış</a>
    </div>
</nav>

<div class="container">

<div class="row mb-4">
    <div class="col-md-3 col-6 mb-3">
        <div class="card p-3 stat-card shadow-sm">
            <h6>Toplam Öğrenci</h6>
            <h3><?= $user_count['total']; ?></h3>
        </div>
    </div>

    <div class="col-md-3 col-6 mb-3">
        <div class="card p-3 stat-card shadow-sm">
            <h6>Büyütülen Canlı</h6>
            <h3><?= $farmed_count['total']; ?></h3>
        </div>
    </div>

    <div class="col-md-3 col-6 mb-3">
        <div class="card p-3 stat-card shadow-sm" style="border-left-color:#f1c40f">
            <h6>Toplam Puan</h6>
            <h3><?= $total_points['total']; ?></h3>
        </div>
    </div>

    <div class="col-md-3 col-6 mb-3">
        <a href="bagis_yap.php" class="card p-3 stat-card shadow-sm" style="border-left-color:#e74c3c; cursor: pointer;">
            <h6>Biriken Yardım (₺)</h6>
            <h3><?= number_format($gerçek_yardim, 2); ?></h3>
            <small class="text-danger">Bağış Yapmak İçin Tıkla</small>
        </a>
    </div>
</div>

<div class="card shadow">
    <div class="card-header bg-white fw-bold">
        Kullanıcı Listesi
    </div>

    <div class="table-responsive">
        <table class="table table-hover mb-0 align-middle">
            <thead class="table-light">
                <tr>
                    <th>ID</th>
                    <th>Kullanıcı</th>
                    <th>E-posta</th>
                    <th>Puan</th>
                    <th>Bağış (TL)</th> <th>Rol</th>
                    <th>Durum</th>
                    <th>İşlem</th>
                </tr> 
            </thead>
            <tbody>
            <?php
        
            $users = $conn->query("
                SELECT u.*, COALESCE(SUM(c.yardım_tl), 0) as kisi_yardim 
                FROM users u 
                LEFT JOIN user_creatures c ON u.id = c.user_id 
                GROUP BY u.id
            ");
            while ($u = $users->fetch_assoc()):
            ?>
                <tr>
                    <td>#<?= $u['id']; ?></td>
                    <td><?= htmlspecialchars($u['username']); ?></td>
                    <td><?= htmlspecialchars($u['email']); ?></td>
                    <td>
                        <span class="badge bg-success">
                            <?= $u['points']; ?> P
                        </span>
                    </td>
                    <td><strong><?= number_format($u['kisi_yardim'], 2); ?> ₺</strong></td> <td><?= $u['role']; ?></td>
                    <td>
                        <?php if($u['status']=='active'): ?>
                            <span class="badge bg-success">Aktif</span>
                        <?php else: ?>
                            <span class="badge bg-danger">Pasif</span>
                        <?php endif; ?>
                    </td>
                    <td>
                        <a href="user_toggle.php?id=<?= $u['id']; ?>" class="btn btn-sm btn-warning">Değiştir</a>
                    </td>
                </tr>
            <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</div>

<hr class="my-4">

<div class="card shadow p-4 mb-4">
    <h5 class="fw-bold mb-3">📢 Duyuru Gönder</h5>
    <form action="duyuru_ekle.php" method="post">
        <input type="text" name="baslik" class="form-control mb-2" placeholder="Duyuru Başlığı" required>
        <textarea name="icerik" class="form-control mb-3" placeholder="Duyuru İçeriği" required></textarea>
        <button class="btn btn-success">Duyuru Yayınla</button>
    </form>
</div>

<div class="card shadow p-4">
    <h5 class="fw-bold mb-3">💬 Kullanıcıya Mesaj Gönder</h5>
    <form action="mesaj_gonder.php" method="post">
        <input type="number" name="user_id" class="form-control mb-2" placeholder="Kullanıcı ID" required>
        <textarea name="mesaj" class="form-control mb-3" placeholder="Mesaj" required></textarea>
        <button class="btn btn-primary">Mesaj Gönder</button>
    </form>
</div>

</div>
</body>
</html>