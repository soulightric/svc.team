-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               8.4.3 - MySQL Community Server - GPL
-- Server OS:                    Win64
-- HeidiSQL Version:             12.8.0.6908
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Dumping database structure for svc_team
CREATE DATABASE IF NOT EXISTS `svc_team` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `svc_team`;

-- Dumping structure for table svc_team.admin
CREATE TABLE IF NOT EXISTS `admin` (
  `adm_username` varchar(50) NOT NULL COMMENT 'Admin001',
  `adm_password` varchar(255) NOT NULL COMMENT '#pw241011002',
  `id_admin` varchar(5) NOT NULL COMMENT 'AD001',
  `created_at` timestamp NOT NULL COMMENT '5/12/2024  2:30:00 PM',
  PRIMARY KEY (`id_admin`),
  UNIQUE KEY `adm_username` (`adm_username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table svc_team.admin: ~5 rows (approximately)
INSERT INTO `admin` (`adm_username`, `adm_password`, `id_admin`, `created_at`) VALUES
	('AdminKiki01', 'admin_Ki01', 'AD001', '2026-05-04 13:45:08'),
	('AdminMisbah02', 'admin_Mi02', 'AD002', '2026-05-04 13:45:53'),
	('AdminIfah03', 'admin_If03', 'AD003', '2026-05-04 13:46:43'),
	('AdminFikri04', 'admin_Fi04', 'AD004', '2026-05-04 13:48:24'),
	('AdminFarhan05', 'admin_Fa05', 'AD005', '2026-05-04 13:48:56');

-- Dumping structure for table svc_team.feedback
CREATE TABLE IF NOT EXISTS `feedback` (
  `id_feedback` varchar(6) NOT NULL COMMENT 'contoh: LN0001',
  `id_layanan` varchar(6) NOT NULL COMMENT 'contoh: FD0001',
  `id_mahasiswa` varchar(7) NOT NULL COMMENT 'contoh: MHS0001',
  `isi_feedback` text NOT NULL,
  `judul_feedback` varchar(50) NOT NULL,
  `rating` enum('1','2','3','4','5') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL COMMENT '1 = bintang 1\r\n2 = bintang 2\r\n3 = bintang 3\r\n4 = bintang 4\r\n5 = bintang 5',
  `status` tinyint unsigned NOT NULL COMMENT '0=Menunggu, 1=Diproses, 2=Selesai, 3=Ditolak',
  `created_at` timestamp NOT NULL COMMENT '5/12/2024  2:30:00 PM',
  `updated_at` timestamp NOT NULL COMMENT '5/12/2024  2:30:00 PM',
  PRIMARY KEY (`id_feedback`),
  KEY `id_layanan` (`id_layanan`),
  KEY `id_mahasiswa` (`id_mahasiswa`),
  CONSTRAINT `FK_feedback_kategori_layanan` FOREIGN KEY (`id_layanan`) REFERENCES `kategori_layanan` (`id_layanan`),
  CONSTRAINT `FK_feedback_mahasiswa` FOREIGN KEY (`id_mahasiswa`) REFERENCES `mahasiswa` (`id_mahasiswa`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table svc_team.feedback: ~0 rows (approximately)

-- Dumping structure for table svc_team.kategori_layanan
CREATE TABLE IF NOT EXISTS `kategori_layanan` (
  `nama_kategori` varchar(45) NOT NULL,
  `id_layanan` varchar(6) NOT NULL COMMENT 'LN0001',
  PRIMARY KEY (`id_layanan`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table svc_team.kategori_layanan: ~0 rows (approximately)

-- Dumping structure for table svc_team.lampiran
CREATE TABLE IF NOT EXISTS `lampiran` (
  `id_lampiran` varchar(6) NOT NULL COMMENT 'LMP001',
  `id_feedback` varchar(6) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL COMMENT 'FD0001',
  `nama_file` varchar(255) NOT NULL COMMENT 'bukti_kursi_jelek.jpg',
  `ukuran_file` int unsigned NOT NULL DEFAULT '0' COMMENT '2048',
  `tipe_file` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL COMMENT 'image/jpeg',
  `path_file` varchar(255) NOT NULL COMMENT '/uploads/lampiran/bukti_error_login.jpg',
  `updated_at` timestamp NOT NULL COMMENT '5/12/2024  2:30:00 PM',
  PRIMARY KEY (`id_lampiran`),
  KEY `id_feedback` (`id_feedback`),
  CONSTRAINT `FK_lampiran_feedback` FOREIGN KEY (`id_feedback`) REFERENCES `feedback` (`id_feedback`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table svc_team.lampiran: ~0 rows (approximately)

-- Dumping structure for table svc_team.mahasiswa
CREATE TABLE IF NOT EXISTS `mahasiswa` (
  `id_mahasiswa` varchar(7) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL DEFAULT '' COMMENT 'MHS0001',
  `nama` varchar(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL COMMENT 'Misbah',
  `nim` int NOT NULL DEFAULT '0' COMMENT '241011002',
  `email` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL COMMENT 'misbahramadani1710@gmail.com',
  `username` varchar(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL COMMENT 'Misbah241011002',
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `created_at` timestamp NOT NULL,
  `updated_at` timestamp NOT NULL,
  PRIMARY KEY (`id_mahasiswa`),
  UNIQUE KEY `nim` (`nim`),
  UNIQUE KEY `email` (`email`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table svc_team.mahasiswa: ~5 rows (approximately)
INSERT INTO `mahasiswa` (`id_mahasiswa`, `nama`, `nim`, `email`, `username`, `password`, `created_at`, `updated_at`) VALUES
	('MHS0001', 'RIZQI KURNIA NINGSIH', 241011001, 'rizqikurnianingsih.241011001@mahasiswa.ith.ac.id', '241011001', '_241011001', '2026-05-04 14:01:01', '2026-05-04 14:01:03'),
	('MHS0002', 'MISBAH RAMADANI', 241011002, 'misbahramadani.241011002@mahasiswa.ith.ac.id', '241011002', '_241011002', '2026-05-04 14:11:14', '2026-05-04 14:11:13'),
	('MHS0003', 'RESKY MUH. SALEH', 241011003, 'reskymuhsaleh.241011003@mahasiswa.ith.ac.id', '241011003', '_241011003', '2026-05-04 14:13:34', '2026-05-04 14:13:36'),
	('MHS0004', 'APRILIANTI SAPUTRI', 241011005, 'apriliantisaputri.241011005@mahasiswa.ith.ac.id', '241011005', '_241011005', '2026-05-04 14:35:23', '2026-05-04 14:35:24'),
	('MHS0005', 'DIVAN DWI SYAHPUTRA', 241011006, 'divandwisyahputra.241011006@mahasiswa.ith.ac.id', '241011006', '_241011006', '2026-05-04 14:41:06', '2026-05-04 14:41:11');

-- Dumping structure for table svc_team.notifikasi
CREATE TABLE IF NOT EXISTS `notifikasi` (
  `id_notifikasi` varchar(6) NOT NULL COMMENT 'NTF001',
  `id_mahasiswa` varchar(7) NOT NULL COMMENT 'MHS0001',
  `id_feedback` varchar(6) NOT NULL COMMENT 'FD0001',
  `is_read` tinyint unsigned NOT NULL DEFAULT (0) COMMENT 'Belum dibaca (False)", sistem akan menyimpannya sebagai angka 0.\r\n"Sudah dibaca (True)", sistem akan menyimpannya sebagai angka 1.',
  `isi_notifikasi` varchar(255) NOT NULL COMMENT 'Tanggapan baru telah ditambahkan pada feedback Anda',
  `judul_notifikasi` varchar(45) NOT NULL COMMENT 'Halo, Feedback Perpus',
  `created_at` timestamp NOT NULL COMMENT '5/12/2024  2:30:00 PM',
  PRIMARY KEY (`id_notifikasi`),
  KEY `id_mahasiswa` (`id_mahasiswa`),
  KEY `id_feedback` (`id_feedback`),
  CONSTRAINT `FK_notifikasi_feedback` FOREIGN KEY (`id_feedback`) REFERENCES `feedback` (`id_feedback`),
  CONSTRAINT `FK_notifikasi_mahasiswa` FOREIGN KEY (`id_mahasiswa`) REFERENCES `mahasiswa` (`id_mahasiswa`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table svc_team.notifikasi: ~0 rows (approximately)

-- Dumping structure for table svc_team.tanggapan
CREATE TABLE IF NOT EXISTS `tanggapan` (
  `id_tanggapan` varchar(6) NOT NULL COMMENT 'TGP001',
  `id_admin` varchar(5) NOT NULL COMMENT 'AD001',
  `id_feedback` varchar(6) NOT NULL COMMENT 'FD0001',
  `isi_tanggapan` text NOT NULL,
  `created_at` timestamp NOT NULL COMMENT '5/12/2024  2:30:00 PM',
  `updated_at` timestamp NOT NULL COMMENT '5/12/2024  2:30:00 PM',
  PRIMARY KEY (`id_tanggapan`),
  KEY `id_admin` (`id_admin`),
  KEY `id_feedback` (`id_feedback`),
  CONSTRAINT `FK_tanggapan_admin` FOREIGN KEY (`id_admin`) REFERENCES `admin` (`id_admin`),
  CONSTRAINT `FK_tanggapan_feedback` FOREIGN KEY (`id_feedback`) REFERENCES `feedback` (`id_feedback`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table svc_team.tanggapan: ~0 rows (approximately)

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
