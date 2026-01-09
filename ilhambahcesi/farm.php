<?php 
include('db.php');
if(session_status() == PHP_SESSION_NONE){
    session_start();
}

if(!isset($_SESSION['user_id'])) { 
    header("Location: index.php"); 
    exit; 
}

$uid = $_SESSION['user_id'];
$farmed_creatures = $conn->query("
    SELECT * FROM user_creatures 
    WHERE user_id='$uid' AND status='farmed'
");
$total_farm_help_res = $conn->query("SELECT SUM(yardım_tl) as toplam FROM user_creatures WHERE user_id='$uid' AND status='farmed'");
$total_farm_help = $total_farm_help_res->fetch_assoc()['toplam'] ?? 0;
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>İlham Bahçesi | Benim Çiftliğim</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background: #e8f5e9; font-family: 'Poppins', sans-serif; }
        .garden-area { 
            background: url('https://img.freepik.com/free-vector/green-grass-field-pixel-art-style_23-2148773779.jpg'); 
            background-size: cover; min-height: 400px; border-radius: 30px; padding: 50px; border: 10px solid #8d6e63;
        }
        .farm-item { font-size: 60px; display: inline-block; margin: 15px; filter: drop-shadow(2px 4px 6px black); transition: 0.3s; }
        
        .farm-wrapper { display: inline-block; text-align: center; }
        .help-amount { 
            display: block; 
            background: rgba(255,255,255,0.8); 
            border-radius: 10px; 
            font-size: 14px; 
            font-weight: bold; 
            color: #2e7d32;
            margin-top: -5px;
        }
    </style>
</head>
<body>

<div class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>🏡 Benim Güzel Çiftliğim</h1>
        <h4 class="text-success">Toplam Yardım: <?= number_format($total_farm_help, 2); ?> TL</h4>
        <a href="dashboard.php" class="btn btn-success">Bahçeye Dön</a>
    </div>

    <div class="card shadow-lg p-2">
        <div class="garden-area text-center">
            <?php if($farmed_creatures->num_rows > 0): ?>
                <?php while($row = $farmed_creatures->fetch_assoc()): ?>
                    <div class="farm-wrapper">
                        <div class="farm-item" title="Başarıyla büyütüldü!">
                            <?php 
                                $icons = ['tilki'=>'🦊', 'kedi'=>'🐱', 'papatya'=>'🌼', 'mese'=>'🌳'];
                                echo $icons[$row['type']];
                            ?>
                        </div>
                        <span class="help-amount"><?= $row['yardım_tl']; ?> TL</span>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <h4 class="text-white mt-5">Henüz çiftliğinde hiç canlı yok. Çalışmaya başla ve ilk canlıyı buraya gönder!</h4>
            <?php endif; ?>
        </div>
    </div>
</div>
</body>
</html>