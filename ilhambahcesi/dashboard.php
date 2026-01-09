<?php
if(session_status() == PHP_SESSION_NONE){
    session_start();
}
include('db.php');
$uid = $_SESSION['user_id'] ?? null;
if(!$uid){
    header("Location: index.php");
    exit;
}
$active = $conn->query("
    SELECT * FROM user_creatures 
    WHERE user_id='$uid' AND status='active'
")->fetch_assoc();
if ($active && !isset($active['yardım_tl'])) {
    $active['yardım_tl'] = 0;
}
$total_query = $conn->query("SELECT SUM(yardım_tl) as toplam FROM user_creatures WHERE user_id='$uid'");
$total_data = $total_query->fetch_assoc();
$total_help = $total_data['toplam'] ?? 0;

$user_role = $_SESSION['role'] ?? 'ogrenci';

$evrim_serisi = [
    'kedi' => [1 => 'assets/img/kedi_1.jfif', 2 => 'assets/img/kedi_2.jpg', 3 => 'assets/img/kedi_3.jfif'],
    'tilki' => [1 => 'assets/img/tilki_1.jfif', 2 => 'assets/img/tilki_2.jfif', 3 => 'assets/img/tilki_3.jfif'],
    'papatya' => [1 => 'assets/img/papatya_1.jfif', 2 => 'assets/img/papatya_2.jfif', 3 => 'assets/img/papatya_3.jfif'],
    'mese' => [1 => 'assets/img/mese_1.jfif', 2 => 'assets/img/mese_2.jfif', 3 => 'assets/img/mese_3.jfif']
];
?>
<!DOCTYPE html>
<html lang="tr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>İlham Bahçesi | Dashboard</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<style>
body { background:#f0f7f4; font-family:'Segoe UI',sans-serif; }
.sidebar { background:#fff; padding:20px; border-radius:15px; box-shadow:0 4px 15px rgba(0,0,0,.05); }
.timer-circle { width:200px; height:200px; border:8px solid #27ae60; border-radius:50%; display:flex; align-items:center; justify-content:center; font-size:40px; margin:20px auto; font-weight:bold; color:#27ae60; }
.creature-wrapper { width:250px; height:250px; display:flex; align-items:center; justify-content:center; margin:auto; }
.creature-img { transition:.5s; }
.lvl-1 { width:80px; filter:grayscale(20%); }
.lvl-2 { width:140px; }
.lvl-3 { width:200px; filter:drop-shadow(0 0 10px #28a745); animation:float 3s infinite ease-in-out; }
@keyframes float { 0%,100%{transform:translateY(0);} 50%{transform:translateY(-15px);} }
</style>
</head>
<body>

<nav class="navbar navbar-dark bg-success mb-4 shadow-sm">
    <div class="container d-flex align-items-center">
        <span class="navbar-brand">🌿 İlham Bahçesi</span>
        <div class="ms-auto d-flex align-items-center gap-2">
            <span class="text-white"><?php echo $_SESSION['username']; ?></span>
            <?php if($user_role === 'admin'): ?>
                <a href="admin.php" class="btn btn-warning btn-sm">🛡️ Admin Paneli</a>
            <?php endif; ?>
            <a href="logout.php" class="btn btn-outline-light btn-sm">Çıkış</a>
        </div>
    </div>
</nav>

<div class="container">
<div style="position:fixed; top:100px; right:0; z-index:999; display:flex; flex-direction:column; gap:10px;">
    <button id="btnDuyurular" class="btn btn-success btn-sm">📢 Duyurular</button>
    <button id="btnMesajlar" class="btn btn-primary btn-sm">💬 Mesajlarım</button>
</div>

<div id="sidePanel" style="position:fixed; top:80px; right:-350px; width:350px; height:80%; background:#fff; box-shadow: -2px 0 10px rgba(0,0,0,.2); padding:20px; overflow-y:auto; transition:0.3s; z-index:998;">
    <h5 id="panelTitle"></h5>
    <div id="panelContent"></div>
</div>

<div class="row">
    <div class="col-md-3 mb-3">
        <div class="sidebar text-center">
            <h5 class="text-success border-bottom pb-2">Menü</h5>
            <a href="dashboard.php" class="d-block mb-2 fw-bold text-decoration-none">🏠 Ana Panel</a>
            <a href="farm.php" class="d-block mb-3 text-decoration-none">🏡 Çiftliğim</a>
            
            <div class="alert alert-success p-2 mb-3">
                <small>Toplam Biriken Yardım</small><br>
                <strong style="font-size:1.2rem;"><?php echo number_format($total_help, 2); ?> TL</strong>
            </div>

            <h6 class="text-success">Odaklanma Müziği</h6>
            <audio id="bgMusic" loop>
                <source src="https://www.soundhelix.com/examples/mp3/SoundHelix-Song-1.mp3">
            </audio>
            <button onclick="toggleMusic()" id="musicBtn" class="btn btn-outline-success btn-sm w-100">▶️ Başlat</button>
        </div>
    </div>

    <div class="col-md-9 text-center">
    <?php if(!$active): ?>
        <div class="card p-4 shadow-sm border-0">
            <h3>Büyütmek İstediğin Canlıyı Seç</h3>
            <div class="row mt-4">
            <?php foreach(['kedi'=>'🐱','tilki'=>'🦊','papatya'=>'🌼','mese'=>'🌳'] as $tip=>$ikon): ?>
                <div class="col-6 col-md-3 mb-3">
                    <div class="card p-3 shadow-sm position-relative" style="cursor:pointer">
                        <a href="islem.php?durum=sec&tip=<?php echo $tip; ?>" class="stretched-link"></a>
                        <div style="font-size:50px"><?php echo $ikon; ?></div>
                        <h6 class="mt-2"><?php echo ucfirst($tip); ?></h6>
                    </div>
                </div>
            <?php endforeach; ?>
            </div>
        </div>
    <?php else: ?>
        <div class="row">
            <div class="col-md-6 mb-4">
                <div class="card p-4 shadow border-0">
                    <h4>Zamanlayıcı</h4>
                    <div class="mb-2">
                        <label for="timerInput" class="form-label">Kaç dakika odaklanmak istiyorsun?</label>
                        <input type="number" id="timerInput" class="form-control" min="1" max="120" value="25">
                    </div>
                    <div class="timer-circle" id="timer">25:00</div>
                    <button id="btnStart" onclick="baslat()" class="btn btn-success btn-lg w-100">Odaklanmayı Başlat</button>
                    <a href="islem.php?durum=sifirla" class="btn btn-outline-danger w-100 mt-2" onclick="return confirm('Bu canlıyı bırakıp yeni bir canlı seçmek istiyor musun?')">🔄 Canlıyı Değiştir</a>
                </div>
            </div>

            <div class="col-md-6 mb-4">
                <div class="card p-4 shadow border-0">
                    <h4>Canlın: <?php echo ucfirst($active['type']); ?></h4>
                    <?php if($active['level']===3): ?>
                        <p class="text-success fw-bold">🎉 Canlınız maksimum seviyede!</p>
                    <?php endif; ?>
                    <div class="creature-wrapper mt-3">
                        <img src="<?php echo $evrim_serisi[$active['type']][$active['level']]; ?>" class="creature-img lvl-<?php echo $active['level']; ?>">
                    </div>
                    <p class="text-muted mt-2">Seviye <?php echo $active['level']; ?>/3</p>
                    <p class="fw-bold text-success">💚 Aktif Canlı Yardımı: <?php echo $active['yardım_tl']; ?> TL</p>
                </div>
            </div>
        </div>
    <?php endif; ?>
    </div>
</div>
</div>

<script src="https://cdn.jsdelivr.net/npm/canvas-confetti@1.5.1/dist/confetti.browser.min.js"></script>
<script>
function baslat(){
    let dakika = parseInt(document.getElementById('timerInput').value) || 25;
    let s = dakika * 60;
    const timerElem = document.getElementById('timer');
    const btnStart = document.getElementById('btnStart');

    btnStart.disabled = true;
    let i = setInterval(()=>{
        s--;
        timerElem.innerText = `${String(Math.floor(s/60)).padStart(2,'0')}:${String(s%60).padStart(2,'0')}`;
        if(s <= 0){
            clearInterval(i);
            location.href="islem.php?durum=buyu&mesaj=basari";
        }
    }, 1000);
}
function toggleMusic(){
    const m=document.getElementById("bgMusic");
    const musicBtn = document.getElementById("musicBtn");
    m.paused?(m.play(),musicBtn.innerText="⏸️ Durdur"):(m.pause(),musicBtn.innerText="▶️ Başlat");
}
if(new URLSearchParams(window.location.search).get("mesaj")==="basari"){
    confetti({particleCount:200,spread:90,origin:{y:0.6}});
}

const sidePanel = document.getElementById('sidePanel');
const panelTitle = document.getElementById('panelTitle');
const panelContent = document.getElementById('panelContent');

document.getElementById('btnDuyurular').onclick = () => {
    panelTitle.innerText = "📢 Duyurular";
    panelContent.innerHTML = `<?php
        $duyurular = $conn->query("SELECT * FROM duyurular ORDER BY tarih DESC LIMIT 5");
        while($d = $duyurular->fetch_assoc()):
    ?>
        <div class="border-bottom mb-2 pb-1">
            <strong><?= htmlspecialchars($d['baslik']); ?></strong><br>
            <small><?= htmlspecialchars($d['icerik']); ?></small>
        </div>
    <?php endwhile; ?>`;
    sidePanel.style.right = "0";
};

document.getElementById('btnMesajlar').onclick = () => {
    panelTitle.innerText = "💬 Mesajlarım";
    panelContent.innerHTML = `<?php
        $mesajlar = $conn->query("SELECT * FROM mesajlar WHERE user_id='$uid' ORDER BY tarih DESC LIMIT 5");
        if($mesajlar->num_rows > 0){
            while($m = $mesajlar->fetch_assoc()){
                echo "<div class='border-bottom mb-2 pb-1'>".htmlspecialchars($m['mesaj'])."</div>";
            }
        } else { echo "Henüz mesajınız yok."; }
    ?>`;
    sidePanel.style.right = "0";
};

document.addEventListener('click', (e) => {
    if(!sidePanel.contains(e.target) && !e.target.matches('#btnDuyurular,#btnMesajlar')){
        sidePanel.style.right = "-350px";
    }
});
</script>
</body>
</html>