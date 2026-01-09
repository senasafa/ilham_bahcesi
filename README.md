# ilham_bahcesi
🌿 İlham Bahçesi 
İlham Bahçesi, ders çalışma veya odaklanma sürecini keyifli bir serüvene dönüştüren, Pomodoro Tekniği tabanlı bir oyunlaştırma ve sosyal sorumluluk platformudur. Kullanıcılar odaklandıkça dijital canlılarını büyütür ve toplumsal bağış projelerine katkı sağlarlar.

🚀 Proje Özellikleri
Oyunlaştırılmış Pomodoro: Kullanıcılar çalışma süreleri boyunca kedi, tilki, papatya veya meşe gibi canlıları 3 farklı seviyede büyütebilirler.

Çiftlik (Farm) Sistemi: Maksimum seviyeye (Level 3) ulaşan canlılar, kullanıcının kalıcı "Çiftliğim" alanına eklenerek bir başarı tablosu oluşturur.

Sosyal Sorumluluk Modeli: Her başarılı odaklanma seansı sonunda sistem kullanıcı adına sembolik bir "Yardım Tutarı" biriktirir.

Gelişmiş Admin Paneli: Yöneticilerin kullanıcı hareketlerini izleyebileceği, duyuru yayınlayabileceği ve biriken bağışları (TEMA, LÖSEV, HAYTAP vb.) koordine edebileceği kapsamlı bir panel.

Odaklanma Araçları: Çalışma verimliliğini artırmak amacıyla panel içerisine entegre edilmiş Lofi müzik çalar modülü.

Responsive Tasarım: Bootstrap 5 kullanılarak hazırlanan, mobil ve masaüstü cihazlarla tam uyumlu kullanıcı dostu arayüz.

🛠️ Kullanılan Teknolojiler
Backend: PHP 8.x

Database: MySQL

Frontend: Bootstrap 5, CSS3 Animasyonları, JavaScript (ES6+)

Kütüphaneler: Canvas-Confetti (Başarı kutlamaları için)

📦 Kurulum ve Çalıştırma
Bu repoyu bilgisayarınıza klonlayın:

Bash

git clone https://github.com/kullaniciadi/ilham-bahcesi.git
Dosyaları yerel sunucunuza (XAMPP, WAMP veya MAMP) taşıyın (örn: htdocs/ilham-bahcesi).

Veritabanı kurulumu:

phpMyAdmin üzerinden ilham_bahcesi adında bir veritabanı oluşturun.

Size iletilen .sql dosyasını içeri aktarın.

db.php dosyasındaki veritabanı kullanıcı adı ve şifre bilgilerini kendi yerel ayarlarınıza göre güncelleyin.

Tarayıcınızdan localhost/ilham-bahcesi adresine giderek uygulamayı başlatın.

📝 Teknik Çözümler ve Geliştirme Notları
Proje geliştirme sürecinde aşağıdaki teknik zorluklar optimize edilmiş algoritmalarla çözülmüştür:

Dinamik Bakiye Yönetimi: Bağış yapıldığında sistemdeki tüm bakiyenin sıfırlanması yerine, bağışlanan tutarın toplam bakiyeye oranlanarak her kullanıcıdan adil bir şekilde düşülmesini sağlayan matematiksel model kurulmuştur.

Oturum Güvenliği: PHP session çakışmalarını önlemek adına güvenli oturum başlatma kontrolleri (session_status) entegre edilmiştir.

Görsel Senkronizasyon: Canlıların seviye bazlı evrimleşme süreci için "evrim_serisi" dizi yapısı kullanılarak veritabanı ile görsel arayüz tam uyumlu hale getirilmiştir.


Geliştirici: Sena SAFA 

Proje Durumu: Tamamlandı / Geliştirilmeye Açık

Lisans: MIT
