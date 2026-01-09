<?php
session_start();
include('db.php');
if(!isset($_SESSION['user_id'])) { header("Location: index.php"); exit(); }
$uid = $_SESSION['user_id'];

if(isset($_POST['done'])){
    $conn->query("UPDATE users SET xp = xp + 20, buyume_seviyesi = LEAST(buyume_seviyesi + 1, 5), toplam_bagis = toplam_bagis + 5 WHERE id=$uid");
    $conn->query("UPDATE genel_yardim SET toplam_para = toplam_para + 5 WHERE id=1");
    header("Location: dashboard.php");
}
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>Odaklanma Zamanı</title>
    <style>
        body { background: #f0f7f4; font-family: sans-serif; text-align: center; padding-top: 50px; }
        #timer { font-size: 120px; color: #2d3436; font-weight: bold; margin: 30px 0; }
        .btn { background: #00b894; color: white; padding: 15px 40px; border: none; border-radius: 50px; cursor: pointer; font-size: 20px; }
        .radio-card { margin-top: 40px; background: white; padding: 20px; display: inline-block; border-radius: 20px; box-shadow: 0 5px 15px rgba(0,0,0,0.05); }
    </style>
</head>
<body>
    <h1>⏳ Odaklanma Başladı</h1>
    <div id="timer">25:00</div>
    <button class="btn" id="startBtn" onclick="startTimer()">Başlat</button>

    <form method="POST" id="finishForm" style="display:none;">
        <h2 style="color: #00b894;">Harikasın! Canlın gelişti. ✨</h2>
        <button name="done" class="btn" style="background: #e17055;">Gelişimi Kaydet & Çiftliğe Dön</button>
    </form>

    <div class="radio-card">
        <h3>🎧 Odaklanma Radyosu</h3>
        <audio id="audio" loop></audio>
        <select onchange="var a=document.getElementById('audio'); a.src=this.value; this.value ? a.play() : a.pause();">
            <option value="">Sessiz</option>
            <option value="https://stream.zeno.fm/f36y07n8u79uv">Lofi HipHop</option>
            <option value="https://www.soundhelix.com/examples/mp3/SoundHelix-Song-2.mp3">Yağmur Sesi</option>
        </select>
    </div>

    <script>
        let sec = 25 * 60; 
        function startTimer() {
            document.getElementById('startBtn').style.display = 'none';
            let t = setInterval(() => {
                sec--;
                let m = Math.floor(sec/60); let s = sec%60;
                document.getElementById('timer').innerText = `${m}:${s<10?'0':''}${s}`;
                if(sec <= 0) {
                    clearInterval(t);
                    document.getElementById('timer').innerText = "Vakit Doldu!";
                    document.getElementById('finishForm').style.display = 'block';
                }
            }, 1000);
        }
    </script>
</body>
</html>