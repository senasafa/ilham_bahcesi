<?php
session_start();
include('db.php');
$error = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $u = $_POST['u']; 

    $p = $_POST['p'];

    $sorgu = $conn->query("SELECT * FROM users WHERE username='$u' AND password='$p'"); 

    if ($sorgu && $sorgu->num_rows > 0) {

        $kullanici_verisi = $sorgu->fetch_assoc(); 
        if ($kullanici_verisi['status'] === 'passive') {
    die("Hesabınız pasif. Yönetici ile iletişime geçin.");
}

        $_SESSION['user_id']   = $kullanici_verisi['id'];

        $_SESSION['username']  = $kullanici_verisi['username'];

        $_SESSION['role']      = $kullanici_verisi['role']; 
        header("Location: dashboard.php");

        exit(); 

    } else { 

        $error = "Hatalı kullanıcı adı veya şifre!"; 

    }

}

?>

<!DOCTYPE html>

<html lang="tr">

<head>

    <meta charset="UTF-8">

    <title>İlham Bahçesi | Giriş</title>

    <style>

        body {

            margin: 0; padding: 0; font-family: 'Poppins', sans-serif;

            background: linear-gradient(rgba(0,0,0,0.4), rgba(0,0,0,0.4)), url('https://images.unsplash.com/photo-1441974231531-c6227db76b6e?auto=format&fit=crop&w=1920&q=80');

            background-size: cover; height: 100vh; display: flex; align-items: center; justify-content: center;

        }

        .login-box {

            background: rgba(255, 255, 255, 0.9); padding: 40px; border-radius: 25px; 

            text-align: center; width: 350px; backdrop-filter: blur(10px); box-shadow: 0 15px 35px rgba(0,0,0,0.2);

        }

        input { width: 100%; padding: 12px; margin: 10px 0; border-radius: 12px; border: 1px solid #ddd; box-sizing: border-box; }

        .btn { background: #00b894; color: white; border: none; padding: 12px; width: 100%; border-radius: 12px; cursor: pointer; font-weight: bold; font-size: 16px; }

        .btn:hover { background: #00a082; }

    </style>

</head>

<body>

    <div class="login-box">

        <h1 style="color: #2d3436; margin-bottom: 5px;">🌿 Hoş Geldin</h1>

        <p style="color: #636e72; font-size: 14px; margin-bottom: 25px;">Doğayı büyütmeye hazır mısın?</p>

        <form method="POST">

            <input type="text" name="u" placeholder="Kullanıcı Adı" required>

            <input type="password" name="p" placeholder="Şifre" required>

            <button type="submit" class="btn">Giriş Yap</button>

        </form>

        <p style="font-size: 13px; margin-top: 15px;">Hesabın yok mu? <a href="register.php" style="color: #00b894; text-decoration: none; font-weight: bold;">Kayıt Ol 🌱</a></p>

        <p style="color:red; font-size:12px;"><?php echo $error; ?></p>

    </div>

</body>

</html>