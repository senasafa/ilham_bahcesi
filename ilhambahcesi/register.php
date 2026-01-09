
<?php
include('db.php'); 
$msg = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $u = $conn->real_escape_string($_POST['u']);
    $e = $conn->real_escape_string($_POST['e']);
    $p = $_POST['p']; 
    $role = $_POST['role']; 
    $kontrol = $conn->query("SELECT * FROM users WHERE username='$u' OR email='$e'");
    
    if ($kontrol->num_rows > 0) {
        $msg = "Bu kullanıcı adı veya e-posta zaten kullanımda!";
    } else {
        $sql = "INSERT INTO users (username, email, password, role) VALUES ('$u', '$e', '$p', '$role')";
        if ($conn->query($sql)) {
            $msg = "<span style='color:green;'>Kayıt başarılı! Girişe yönlendiriliyorsunuz...</span>";
            header("refresh:2;url=index.php");
        } else {
            $msg = "Hata: " . $conn->error;
        }
    }
}
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>İlham Bahçesi | Kayıt Ol</title>
    <style>
        body { margin: 0; font-family: 'Poppins', sans-serif; background: linear-gradient(rgba(0,0,0,0.5), rgba(0,0,0,0.5)), url('https://images.unsplash.com/photo-1501004318641-729e8e3986ff?auto=format&fit=crop&w=1920&q=80'); background-size: cover; height: 100vh; display: flex; align-items: center; justify-content: center; }
        .box { background: rgba(255, 255, 255, 0.95); padding: 40px; border-radius: 20px; text-align: center; width: 350px; box-shadow: 0 10px 25px rgba(0,0,0,0.3); }
        input, select { width: 100%; padding: 12px; margin: 8px 0; border-radius: 10px; border: 1px solid #ccc; box-sizing: border-box; font-family: inherit; }
        .btn { background: #27ae60; color: white; border: none; padding: 12px; width: 100%; border-radius: 10px; cursor: pointer; font-weight: bold; margin-top: 10px; }
    </style>
</head>
<body>
    <div class="box">
        <h2>🌱 Kayıt Ol</h2>
        <form method="POST">
            <input type="text" name="u" placeholder="Kullanıcı Adı" required>
            <input type="email" name="e" placeholder="E-posta" required>
            <input type="password" name="p" placeholder="Şifre" required>
            
            <select name="role" required>
                <option value="" disabled selected>Rolünüzü Seçin</option>
                <option value="ogrenci">Öğrenci</option>
                <option value="admin">Admin (Yönetici)</option>
            </select>
            
            <button type="submit" class="btn">Hesap Oluştur</button>
        </form>
        <p style="font-size: 13px; margin-top: 15px;">Zaten hesabın var mı? <a href="index.php">Giriş Yap</a></p>
        <p><?php echo $msg; ?></p>
    </div>
</body>
</html>