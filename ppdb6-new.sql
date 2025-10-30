-- AdminNeo 4.17.2 MySQL 8.0.30 dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';


DROP TABLE IF EXISTS `identitas_siswa`;
CREATE TABLE `identitas_siswa` (
  `Id_Identitas_Siswa` int NOT NULL AUTO_INCREMENT,
  `NISN` varchar(15) NOT NULL,
  `No_KK` varchar(20) DEFAULT NULL,
  `NIK` varchar(16) NOT NULL,
  `Nama_Panggilan` text,
  `Nama_Peserta_Didik` text NOT NULL,
  `no_telepon` varchar(15) DEFAULT NULL,
  `Tempat_Lahir` varchar(30) DEFAULT NULL,
  `Tanggal_Lahir` date NOT NULL,
  `asal_sekolah` varchar(100) DEFAULT NULL,
  `Jenis_Kelamin` enum('Laki-Laki','Perempuan') DEFAULT NULL,
  `Agama` varchar(9) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `Gol_Darah` varchar(5) DEFAULT NULL,
  `Tinggi_Badan` varchar(4) DEFAULT NULL,
  `Berat_Badan` varchar(3) DEFAULT NULL,
  `Suku` varchar(10) DEFAULT NULL,
  `Bahasa` varchar(12) DEFAULT NULL,
  `Kewarganegaraan` varchar(10) DEFAULT NULL,
  `Status_Anak` varchar(12) DEFAULT NULL,
  `Anak_Ke` int DEFAULT NULL,
  `Jml_Saudara` int DEFAULT NULL,
  `Jenis_Tinggal` varchar(17) DEFAULT NULL,
  `Alamat_Tinggal` text,
  `Provinsi_Tinggal` varchar(30) DEFAULT NULL,
  `Kab_Kota_Tinggal` varchar(30) DEFAULT NULL,
  `Kec_Tinggal` varchar(30) DEFAULT NULL,
  `Kelurahan_Tinggal` varchar(30) DEFAULT NULL,
  `Kode_POS` varchar(6) DEFAULT NULL,
  `Jarak_Ke_Sekolah` varchar(5) DEFAULT NULL,
  `Riwayat_Penyakit` text,
  `status_ortu` tinyint(1) NOT NULL,
  `status_administrasi` tinyint(1) NOT NULL,
  `jurusan_pilihan` enum('TKJT','PPLG') DEFAULT NULL,
  `status_pendaftaran` enum('Menunggu Verifikasi','Diverifikasi','Diterima','Tidak Diterima') DEFAULT 'Menunggu Verifikasi',
  `tgl_buat` datetime NOT NULL,
  `tgl_ubah` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Kelainan_Jasmani` text,
  `Kebutuhan_Khusus` text,
  `Hobby` text,
  `Email` varchar(50) DEFAULT NULL,
  `Alamat_Sekolah` text,
  `Transport_Ke_Sekolah` varchar(30) DEFAULT NULL,
  `Hobi` varchar(100) DEFAULT NULL,
  `Nama_Ayah` varchar(100) DEFAULT NULL,
  `Nama_Ibu` varchar(100) DEFAULT NULL,
  `Alamat_Ortu` text,
  `No_Telp` varchar(15) DEFAULT NULL,
  `Tinggal_Bersama` varchar(50) DEFAULT NULL,
  `Transport` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`Id_Identitas_Siswa`),
  UNIQUE KEY `NISN` (`NISN`),
  UNIQUE KEY `NIK` (`NIK`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `identitas_siswa` (`Id_Identitas_Siswa`, `NISN`, `No_KK`, `NIK`, `Nama_Panggilan`, `Nama_Peserta_Didik`, `no_telepon`, `Tempat_Lahir`, `Tanggal_Lahir`, `asal_sekolah`, `Jenis_Kelamin`, `Agama`, `Gol_Darah`, `Tinggi_Badan`, `Berat_Badan`, `Suku`, `Bahasa`, `Kewarganegaraan`, `Status_Anak`, `Anak_Ke`, `Jml_Saudara`, `Jenis_Tinggal`, `Alamat_Tinggal`, `Provinsi_Tinggal`, `Kab_Kota_Tinggal`, `Kec_Tinggal`, `Kelurahan_Tinggal`, `Kode_POS`, `Jarak_Ke_Sekolah`, `Riwayat_Penyakit`, `status_ortu`, `status_administrasi`, `jurusan_pilihan`, `status_pendaftaran`, `tgl_buat`, `tgl_ubah`, `Kelainan_Jasmani`, `Kebutuhan_Khusus`, `Hobby`, `Email`, `Alamat_Sekolah`, `Transport_Ke_Sekolah`, `Hobi`, `Nama_Ayah`, `Nama_Ibu`, `Alamat_Ortu`, `No_Telp`, `Tinggal_Bersama`, `Transport`) VALUES
(1,	'0001999901',	'0001999901666444',	'0001999901666444',	'Agung',	'Agung Dermawan',	NULL,	'Jember',	'2014-11-14',	NULL,	'Laki-Laki',	'Islam',	'A',	'108',	'28',	'Jawa',	'Indonesia',	'Indonesia',	'Jawa',	2,	3,	'Kontrak',	'Jl. Dr. Soebandi Gg. Kenitu',	'Jawa Timur',	'Jember',	'Wuluhan',	'Wuluhan',	'68119',	'1',	'Tidak Ada',	0,	1,	NULL,	'Menunggu Verifikasi',	'0000-00-00 00:00:00',	'2025-09-28 14:09:57',	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL),
(21,	'',	'',	'3175042810020002',	'',	'Noval Octavian',	NULL,	'',	'2002-10-28',	NULL,	'',	'',	'',	'',	'',	'',	'',	'',	'',	0,	0,	'',	'',	'',	'',	'',	'SMP Darul Quran',	'',	'',	'',	0,	0,	NULL,	'Menunggu Verifikasi',	'2025-10-15 04:03:30',	'2025-10-15 02:03:30',	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL),
(24,	'1231231241',	NULL,	'1231232131241241',	NULL,	'user test',	'0821324342342',	NULL,	'2000-11-12',	'binar',	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	0,	0,	NULL,	'Menunggu Verifikasi',	'2025-10-15 15:07:20',	'2025-10-15 15:07:20',	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL),
(25,	'2122221212',	NULL,	'1232131231234144',	NULL,	'doni',	'082334485952',	NULL,	'2000-03-12',	'binar',	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	0,	0,	NULL,	'Menunggu Verifikasi',	'2025-10-19 13:29:08',	'2025-10-19 13:29:08',	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL),
(26,	'2112121212',	NULL,	'1212222222222222',	NULL,	'user',	'0821324342342',	NULL,	'2000-01-01',	'binar',	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	0,	0,	NULL,	'Menunggu Verifikasi',	'2025-10-19 13:32:09',	'2025-10-19 13:32:09',	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL),
(27,	'2121212121',	NULL,	'1231231231231232',	NULL,	'user1',	'0131231444',	NULL,	'2002-02-01',	'binar',	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	0,	0,	NULL,	'Menunggu Verifikasi',	'2025-10-19 13:55:23',	'2025-10-19 13:55:23',	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL),
(28,	'2138284832',	NULL,	'2138123812848184',	NULL,	'user2',	'09848484832',	NULL,	'2000-02-02',	'binar',	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	0,	0,	NULL,	'Menunggu Verifikasi',	'2025-10-19 13:56:14',	'2025-10-19 13:56:14',	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL),
(29,	'2131923914',	NULL,	'2913914834123914',	NULL,	'user2',	'0438482343',	NULL,	'1999-02-02',	'binar',	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	0,	0,	NULL,	'Menunggu Verifikasi',	'2025-10-19 13:57:04',	'2025-10-19 13:57:04',	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL),
(30,	'9388484848',	NULL,	'8328424324329439',	NULL,	'user3',	'0488334334234',	NULL,	'2000-02-02',	'binar',	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	0,	0,	NULL,	'Menunggu Verifikasi',	'2025-10-19 14:18:09',	'2025-10-19 14:18:09',	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL),
(31,	'3842342344',	NULL,	'2131434823423434',	NULL,	'user4',	'0383343123123',	NULL,	'2000-01-01',	'binar',	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	0,	1,	NULL,	'Menunggu Verifikasi',	'2025-10-19 14:56:27',	'2025-10-26 04:34:39',	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL),
(32,	'3294239423',	'2311323121312321',	'2342934923449333',	'test user',	'user5',	'038423423434',	'Jakarta',	'2000-02-02',	'binar',	'Laki-Laki',	'islam',	'O',	'170',	'60',	'dayak',	'indonesia',	'indonesia',	'dayak',	1,	3,	'pemilik',	'jl.keadilan',	'jawa barat',	'depok',	'pancoran mas',	'rangkapan jaya',	'16435',	'1',	'tipes',	0,	0,	'TKJT',	'Menunggu Verifikasi',	'2025-10-19 15:00:33',	'2025-10-25 08:38:04',	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL),
(33,	'1231231231',	NULL,	'2342345345345345',	NULL,	'user6',	'08214234234234',	NULL,	'2222-02-02',	'binar',	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	0,	1,	NULL,	'Menunggu Verifikasi',	'2025-10-26 06:05:03',	'2025-10-26 06:49:23',	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL),
(34,	'7457834672',	NULL,	'2938012839189948',	NULL,	'user7',	'08242942343',	NULL,	'1111-02-02',	'binar',	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	0,	1,	NULL,	'Menunggu Verifikasi',	'2025-10-26 09:37:09',	'2025-10-26 09:51:48',	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL),
(35,	'8742347832',	'2389123789127389',	'2347892374892748',	'doni',	'doni',	'098342374234',	'depok',	'2220-02-02',	'-',	'Laki-Laki',	'Islam',	'A',	'160',	'60',	'-',	'-',	'-',	'-',	2,	5,	'Wali',	'dfdadwq',	'-',	'-',	'-',	'-',	'16435',	'1',	'-',	0,	1,	'TKJT',	'Menunggu Verifikasi',	'2025-10-26 14:10:56',	'2025-10-26 07:45:19',	NULL,	'-',	NULL,	'doni@gmail.com',	'-',	NULL,	'-',	'ayah doni',	'-',	'-',	'-',	'Orang Tua',	'Mobil'),
(36,	'8375834523',	'',	'5834906738975238',	NULL,	'dani',	'0823423423',	NULL,	'2222-02-02',	'binar',	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	1,	1,	NULL,	'Menunggu Verifikasi',	'2025-10-26 14:11:42',	'2025-10-26 16:21:49',	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL);


DROP TABLE IF EXISTS `administrasi`;
CREATE TABLE `administrasi` (
  `id_administrasi` int NOT NULL AUTO_INCREMENT,
  `id_identitas_siswa` int NOT NULL,
  `harga` int NOT NULL,
  `status` enum('Lunas','Belum Lunas') NOT NULL,
  `tgl_buat` datetime NOT NULL,
  `tgl_ubah` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_administrasi`),
  KEY `id_identitas_siswa` (`id_identitas_siswa`),
  CONSTRAINT `administrasi_ibfk_1` FOREIGN KEY (`id_identitas_siswa`) REFERENCES `identitas_siswa` (`Id_Identitas_Siswa`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `administrasi` (`id_administrasi`, `id_identitas_siswa`, `harga`, `status`, `tgl_buat`, `tgl_ubah`) VALUES
(5,	1,	1250000,	'Lunas',	'2020-09-17 09:48:12',	'2020-09-17 08:22:50'),
(6,	31,	100000,	'Lunas',	'2025-10-26 04:34:39',	'2025-10-26 04:34:39'),
(7,	33,	100000,	'Lunas',	'2025-10-26 06:49:23',	'2025-10-26 06:49:23'),
(8,	34,	100000,	'Lunas',	'2025-10-26 09:51:48',	'2025-10-26 09:51:48'),
(9,	36,	100000,	'Lunas',	'2025-10-26 14:12:19',	'2025-10-26 14:12:19'),
(10,	35,	100000,	'Lunas',	'2025-10-26 14:24:03',	'2025-10-26 14:24:03');

DELIMITER ;;

CREATE TRIGGER `TambahAdministrasi` AFTER INSERT ON `administrasi` FOR EACH ROW
BEGIN
  UPDATE identitas_siswa SET status_administrasi = 1 
  WHERE Id_Identitas_Siswa = NEW.id_identitas_siswa;
END;;

CREATE TRIGGER `HapusAdministrasi` AFTER DELETE ON `administrasi` FOR EACH ROW
BEGIN
  UPDATE identitas_siswa SET status_administrasi = 0 
  WHERE Id_Identitas_Siswa = OLD.id_identitas_siswa; 
END;;

DELIMITER ;

DROP TABLE IF EXISTS `orang_tua_wali`;
CREATE TABLE `orang_tua_wali` (
  `Id_Orang_Tua_Wali` int NOT NULL AUTO_INCREMENT,
  `Id_Identitas_Siswa` int NOT NULL,
  `Nama_Ayah` varchar(30) NOT NULL,
  `Status_Ayah` text,
  `Tgl_Lahir_Ayah` date NOT NULL,
  `Telepon_Ayah` varchar(14) NOT NULL,
  `Pendidikan_Terakhir_Ayah` varchar(20) NOT NULL,
  `Pekerjaan_Ayah` varchar(30) NOT NULL,
  `Penghasilan_Ayah` varchar(10) NOT NULL,
  `Alamat_Ayah` text,
  `Nama_Ibu` varchar(30) NOT NULL,
  `Status_Ibu` text,
  `Tgl_Lahir_Ibu` date NOT NULL,
  `Telepon_Ibu` varchar(14) NOT NULL,
  `Pendidikan_Terakhir_Ibu` varchar(20) NOT NULL,
  `Pekerjaan_Ibu` varchar(30) NOT NULL,
  `Penghasilan_Ibu` varchar(10) NOT NULL,
  `Alamat_Ibu` text,
  `Nama_Wali` varchar(30) DEFAULT NULL,
  `Status_Wali` varchar(20) DEFAULT NULL,
  `Tgl_Lahir_Wali` date DEFAULT NULL,
  `Telepon_Wali` varchar(14) DEFAULT NULL,
  `Pendidikan_Terakhir_Wali` varchar(20) DEFAULT NULL,
  `Pekerjaan_Wali` varchar(30) DEFAULT NULL,
  `Penghasilan_Wali` varchar(20) DEFAULT NULL,
  `Alamat_Wali` text,
  `tgl_buat` datetime NOT NULL,
  `tgl_ubah` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`Id_Orang_Tua_Wali`),
  KEY `Id_Identitas_Siswa` (`Id_Identitas_Siswa`),
  CONSTRAINT `orang_tua_wali_ibfk_1` FOREIGN KEY (`Id_Identitas_Siswa`) REFERENCES `identitas_siswa` (`Id_Identitas_Siswa`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `orang_tua_wali` (`Id_Orang_Tua_Wali`, `Id_Identitas_Siswa`, `Nama_Ayah`, `Status_Ayah`, `Tgl_Lahir_Ayah`, `Telepon_Ayah`, `Pendidikan_Terakhir_Ayah`, `Pekerjaan_Ayah`, `Penghasilan_Ayah`, `Alamat_Ayah`, `Nama_Ibu`, `Status_Ibu`, `Tgl_Lahir_Ibu`, `Telepon_Ibu`, `Pendidikan_Terakhir_Ibu`, `Pekerjaan_Ibu`, `Penghasilan_Ibu`, `Alamat_Ibu`, `Nama_Wali`, `Status_Wali`, `Tgl_Lahir_Wali`, `Telepon_Wali`, `Pendidikan_Terakhir_Wali`, `Pekerjaan_Wali`, `Penghasilan_Wali`, `Alamat_Wali`, `tgl_buat`, `tgl_ubah`) VALUES
(4,	36,	'-',	'Cerai',	'2003-01-29',	'08237487236478',	'SMP',	'-',	'3 - 5 Juta',	'-',	'-',	'Masih Hidup',	'2007-02-07',	'012838172',	'SMP',	'-',	'1 - 3 Juta',	'-',	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	'2025-10-26 16:21:49',	'2025-10-26 16:21:49');

DELIMITER ;;

CREATE TRIGGER `TambahOrangTuaWali` AFTER INSERT ON `orang_tua_wali` FOR EACH ROW
BEGIN
  UPDATE identitas_siswa SET status_ortu = 1 
  WHERE Id_Identitas_Siswa = NEW.Id_Identitas_Siswa;
END;;

CREATE TRIGGER `HapusOrangTuaWali` AFTER DELETE ON `orang_tua_wali` FOR EACH ROW
BEGIN
  UPDATE identitas_siswa SET status_ortu = 0 
  WHERE Id_Identitas_Siswa = OLD.Id_Identitas_Siswa;
END;;

DELIMITER ;

SET NAMES utf8mb4;

DROP TABLE IF EXISTS `setting_kuota`;
CREATE TABLE `setting_kuota` (
  `id` int NOT NULL AUTO_INCREMENT,
  `jurusan` enum('TKJT','PPLG') NOT NULL,
  `kuota_total` int NOT NULL,
  `kuota_terisi` int DEFAULT '0',
  `tahun_ajaran` varchar(9) DEFAULT '2024/2025',
  `tgl_buat` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

INSERT INTO `setting_kuota` (`id`, `jurusan`, `kuota_total`, `kuota_terisi`, `tahun_ajaran`, `tgl_buat`) VALUES
(1,	'TKJT',	30,	0,	'2024/2025',	'2025-10-26 07:32:11'),
(2,	'PPLG',	42,	0,	'2024/2025',	'2025-10-26 07:32:11');

DROP TABLE IF EXISTS `user`;
CREATE TABLE `user` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nama` char(45) NOT NULL,
  `username` char(65) NOT NULL,
  `password` char(125) NOT NULL,
  `hak` enum('admin','pegawai') NOT NULL,
  `status` enum('aktif','tidak aktif') NOT NULL,
  `tgl_buat` datetime NOT NULL,
  `tgl_ubah` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `user` (`id`, `nama`, `username`, `password`, `hak`, `status`, `tgl_buat`, `tgl_ubah`) VALUES
(1,	'Andi Santosoku',	'andisantoso',	'andisantoso',	'pegawai',	'aktif',	'2020-09-16 19:09:20',	'2020-09-16 17:20:12'),
(6,	'Noval Octavian',	'novaloct',	'admin123',	'admin',	'aktif',	'2020-09-16 18:32:57',	'2025-09-28 13:57:44');

-- 2025-10-26 16:45:55 UTC
