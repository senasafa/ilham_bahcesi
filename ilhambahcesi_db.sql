-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Anamakine: 127.0.0.1
-- Üretim Zamanı: 09 Oca 2026, 01:41:56
-- Sunucu sürümü: 10.4.32-MariaDB
-- PHP Sürümü: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Veritabanı: `ilhambahcesi_db`
--

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `announcements`
--

CREATE TABLE `announcements` (
  `id` int(11) NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `content` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `duyurular`
--

CREATE TABLE `duyurular` (
  `id` int(11) NOT NULL,
  `baslik` varchar(255) DEFAULT NULL,
  `icerik` text DEFAULT NULL,
  `tarih` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `duyurular`
--

INSERT INTO `duyurular` (`id`, `baslik`, `icerik`, `tarih`) VALUES
(1, 'merhabalar, lütfen hayvan seçtiğinizde levelleri yarıda bırakmayın çiftliğe gitmek istiyorlar...', 'önemli', '2026-01-08 21:50:23');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `mesajlar`
--

CREATE TABLE `mesajlar` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `mesaj` text DEFAULT NULL,
  `tarih` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `mesajlar`
--

INSERT INTO `mesajlar` (`id`, `user_id`, `mesaj`, `tarih`) VALUES
(1, 1, 'sena aferin çok çalışıyorsun.', '2026-01-09 02:04:34');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('ogrenci','admin') DEFAULT 'ogrenci',
  `points` int(11) DEFAULT 0,
  `status` enum('active','passive') DEFAULT 'active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `role`, `points`, `status`) VALUES
(1, 'sena ', 'senasafa@gmail.com', '123', 'ogrenci', 0, 'active'),
(2, 'sevcan ', 'sevcan@gmail.com', '123', 'admin', 0, 'active'),
(3, 'yavuz', 'yavuz@hot.com', '123', 'admin', 0, 'active'),
(4, 'eylül', 'eyl@saa.com', '123', 'ogrenci', 0, 'active'),
(5, 'zeynep', 'zeyno@gmail.com', '123', 'ogrenci', 0, 'active'),
(6, 'zeliha', 'zelha@ask.com', 'salakceren4', 'admin', 0, 'active'),
(7, 'tuğsem', 'tusem@sen.com', '123', 'admin', 0, 'active');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `user_creatures`
--

CREATE TABLE `user_creatures` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `type` varchar(50) DEFAULT NULL,
  `level` int(11) DEFAULT 1,
  `status` enum('active','farmed') DEFAULT 'active',
  `yardım_tl` int(11) DEFAULT 0,
  `farm_added` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `user_creatures`
--

INSERT INTO `user_creatures` (`id`, `user_id`, `type`, `level`, `status`, `yardım_tl`, `farm_added`) VALUES
(23, 1, 'kedi', 1, '', 0, 0),
(24, 1, 'tilki', 1, '', 0, 0),
(25, 1, 'papatya', 1, '', 0, 0),
(26, 1, 'mese', 1, '', 0, 0),
(27, 1, 'kedi', 1, '', 0, 0),
(28, 1, 'tilki', 1, '', 0, 0),
(29, 1, 'kedi', 1, '', 0, 0),
(30, 1, 'kedi', 1, '', 0, 0),
(31, 1, 'tilki', 1, '', 0, 0),
(32, 1, 'papatya', 1, '', 0, 0),
(33, 1, 'mese', 1, '', 0, 0),
(34, 1, 'kedi', 1, '', 0, 0),
(35, 1, 'tilki', 1, '', 0, 0),
(36, 1, 'kedi', 1, '', 0, 0),
(37, 1, 'tilki', 1, '', 0, 0),
(38, 1, 'kedi', 1, '', 0, 0),
(39, 1, 'kedi', 3, '', 0, 0),
(40, 1, 'tilki', 1, '', 0, 0),
(41, 1, 'kedi', 1, '', 0, 0),
(42, 1, 'kedi', 1, '', 0, 0),
(43, 1, 'papatya', 1, '', 0, 0),
(44, 1, 'tilki', 1, '', 0, 0),
(45, 1, 'kedi', 3, '', 0, 0),
(46, 1, 'kedi', 1, '', 0, 0),
(47, 1, 'papatya', 3, '', 0, 1),
(48, 1, 'tilki', 1, '', 0, 0),
(49, 1, 'mese', 3, 'farmed', 0, 1),
(50, 1, 'tilki', 3, 'farmed', 0, 1),
(51, 1, 'tilki', 3, 'farmed', 0, 1),
(52, 1, 'papatya', 3, 'farmed', 0, 1),
(53, 1, 'kedi', 3, 'farmed', 0, 1),
(54, 1, 'tilki', 1, '', 0, 0),
(55, 1, 'papatya', 3, 'farmed', 0, 1),
(56, 1, 'tilki', 1, '', 0, 0),
(57, 1, 'kedi', 1, '', 0, 0),
(58, 1, 'tilki', 1, '', 0, 0),
(59, 1, 'papatya', 1, '', 0, 0),
(60, 1, 'mese', 1, '', 0, 0),
(61, 7, 'kedi', 3, 'farmed', 0, 1),
(62, 1, 'kedi', 3, 'farmed', 10, 1),
(63, 1, 'tilki', 3, 'farmed', 10, 1);

--
-- Dökümü yapılmış tablolar için indeksler
--

--
-- Tablo için indeksler `announcements`
--
ALTER TABLE `announcements`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `duyurular`
--
ALTER TABLE `duyurular`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `mesajlar`
--
ALTER TABLE `mesajlar`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Tablo için indeksler `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Tablo için indeksler `user_creatures`
--
ALTER TABLE `user_creatures`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Dökümü yapılmış tablolar için AUTO_INCREMENT değeri
--

--
-- Tablo için AUTO_INCREMENT değeri `announcements`
--
ALTER TABLE `announcements`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Tablo için AUTO_INCREMENT değeri `duyurular`
--
ALTER TABLE `duyurular`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Tablo için AUTO_INCREMENT değeri `mesajlar`
--
ALTER TABLE `mesajlar`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Tablo için AUTO_INCREMENT değeri `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Tablo için AUTO_INCREMENT değeri `user_creatures`
--
ALTER TABLE `user_creatures`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=64;

--
-- Dökümü yapılmış tablolar için kısıtlamalar
--

--
-- Tablo kısıtlamaları `mesajlar`
--
ALTER TABLE `mesajlar`
  ADD CONSTRAINT `mesajlar_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Tablo kısıtlamaları `user_creatures`
--
ALTER TABLE `user_creatures`
  ADD CONSTRAINT `user_creatures_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
