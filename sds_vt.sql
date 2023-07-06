-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Anamakine: 127.0.0.1:3306
-- Üretim Zamanı: 05 Tem 2023, 13:51:03
-- Sunucu sürümü: 8.0.31
-- PHP Sürümü: 7.4.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Veritabanı: `sds_vt`
--

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `kullanicilar`
--

DROP TABLE IF EXISTS `kullanicilar`;
CREATE TABLE IF NOT EXISTS `kullanicilar` (
  `id` int NOT NULL AUTO_INCREMENT,
  `cuzdan` int DEFAULT '0',
  `tema` tinyint DEFAULT '0',
  `talep_sayisi` int DEFAULT '0',
  `eposta` varchar(200) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `sifre` varchar(200) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `tipi` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `belge_adi` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `tckimlik` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `onay` varchar(30) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `ad` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `soyad` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `kayit_tarihi` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `guncelleme_tarihi` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `kullanicilar`
--

INSERT INTO `kullanicilar` (`id`, `cuzdan`, `tema`, `talep_sayisi`, `eposta`, `sifre`, `tipi`, `belge_adi`, `tckimlik`, `onay`, `ad`, `soyad`, `kayit_tarihi`, `guncelleme_tarihi`) VALUES
(1, 0, 0, 0, 'aycaadmin', '123ayca', 'Admin', NULL, NULL, NULL, NULL, NULL, '2023-07-05 10:25:55', NULL),
(18, 3500, 0, 0, 'bagisci@gmail.com', 'mehmet01', 'Bağışçı', 'Yok', NULL, NULL, NULL, NULL, '2023-07-05 12:08:12', 1688559115),
(19, 1500, 0, 0, 'ogrenci@gmail.com', 'mehmet01', 'Öğrenci', 'ogrenci-896647411.png', '', 'evet', '', '', '2023-07-05 12:08:45', 1688558973);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `talepler`
--

DROP TABLE IF EXISTS `talepler`;
CREATE TABLE IF NOT EXISTS `talepler` (
  `id` int NOT NULL AUTO_INCREMENT,
  `goster` varchar(50) COLLATE utf8mb4_general_ci DEFAULT 'evet',
  `eposta` varchar(200) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `talep_adi` text COLLATE utf8mb4_general_ci,
  `talep_miktari` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `talep_aciklamasi` text COLLATE utf8mb4_general_ci,
  `onay_durumu` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `kayit_tarihi` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `guncelleme_tarihi` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `talepler`
--

INSERT INTO `talepler` (`id`, `goster`, `eposta`, `talep_adi`, `talep_miktari`, `talep_aciklamasi`, `onay_durumu`, `kayit_tarihi`, `guncelleme_tarihi`) VALUES
(14, 'hayir', 'ogrenci@gmail.com', 'Kira Yardımı', '800', 'Kiramı ödeyeceğim ama yeterli durumum bulunmamakta. SDÜ\'de otomotiv mühendisliği okuyorum. Teşekkür ederim.', 'evet', '2023-07-05 12:10:24', 1688559697);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `yapilan_bagislar`
--

DROP TABLE IF EXISTS `yapilan_bagislar`;
CREATE TABLE IF NOT EXISTS `yapilan_bagislar` (
  `id` int NOT NULL AUTO_INCREMENT,
  `ogrenci_eposta` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `bagisci_eposta` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `talep_adi` text COLLATE utf8mb4_general_ci,
  `bagis_miktari` int DEFAULT NULL,
  `kayit_tarihi` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `yapilan_bagislar`
--

INSERT INTO `yapilan_bagislar` (`id`, `ogrenci_eposta`, `bagisci_eposta`, `talep_adi`, `bagis_miktari`, `kayit_tarihi`) VALUES
(9, 'ogrenci@gmail.com', 'bagisci@gmail.com', 'Kira Yardımı', 500, '2023-07-05 15:12:18'),
(10, 'ogrenci@gmail.com', 'bagisci@gmail.com', 'Kira Yardımı', 100, '2023-07-05 15:15:01'),
(11, 'ogrenci@gmail.com', 'bagisci@gmail.com', 'Kira Yardımı', 100, '2023-07-05 15:18:55'),
(12, 'ogrenci@gmail.com', 'bagisci@gmail.com', 'Kira Yardımı', 800, '2023-07-05 15:21:37');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
