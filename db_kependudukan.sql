-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 22, 2025 at 12:20 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_kependudukan`
--

DELIMITER $$
--
-- Procedures
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `SHOW_KK` (IN `p_no_kk` VARCHAR(20))   BEGIN
    
    SELECT
        dk.no_kk AS `No. KK`,
        dp_kepala.nama AS `Nama Kepala Keluarga`,
        dk.alamat AS Alamat,
        CONCAT(dk.rt, '/', dk.rw) AS `RT/RW`,
        dk.desa AS Desa,
        dk.kecamatan AS Kecamatan,
        dk.tanggal_dikeluarkan AS `Tanggal Dikeluarkan`
    FROM data_keluarga dk
    JOIN data_pribadi dp_kepala ON dk.no_kk = dp_kepala.no_kk_id
    WHERE dp_kepala.hubungan_keluarga_id = (
        SELECT id FROM hubungan_keluarga WHERE UPPER(nama) = 'KEPALA KELUARGA'
    ) AND dk.no_kk = p_no_kk;

    
    SELECT
        dp.nik AS NIK,
        dp.nama AS Nama,
        dp.jenis_kelamin AS `Jenis Kelamin`,
        dp.tempat_lahir AS `Tempat Lahir`,
        dp.tanggal_lahir AS `Tanggal Lahir`,
        ag.nama AS Agama,
        pt.nama AS Pendidikan,
        pk.nama AS Pekerjaan,
        dp.golongan_darah AS `Gol. Darah`,
        dp.status_perkawinan AS `Status Perkawinan`,
        dp.tanggal_perkawinan AS `Tanggal Perkawinan`,
        hk.nama AS `Status Hubungan`,
        dp.kewarganegaraan AS Kewarganegaraan,
        dp.nama_ayah AS Ayah,
        dp.nama_ibu AS Ibu
    FROM data_pribadi dp
    LEFT JOIN agama ag ON dp.agama_id = ag.id
    LEFT JOIN pendidikan_terakhir pt ON dp.pendidikan_terakhir_id = pt.id
    LEFT JOIN pekerjaan pk ON dp.pekerjaan_id = pk.id
    LEFT JOIN hubungan_keluarga hk ON dp.hubungan_keluarga_id = hk.id
    WHERE dp.no_kk_id = p_no_kk
    ORDER BY dp.hubungan_keluarga_id;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `SHOW_KTP` (IN `p_nik` VARCHAR(20))   BEGIN
    SELECT
        dp.nik AS NIK,
        dp.nama AS Nama,
        CONCAT(dp.tempat_lahir, ' / ', DATE_FORMAT(dp.tanggal_lahir, '%d-%m-%Y')) AS `Tempat / Tanggal Lahir`,
        dp.jenis_kelamin AS `Jenis Kelamin`,
        dp.golongan_darah AS `Golongan Darah`,
        dk.alamat AS Alamat,
        CONCAT(dk.rt, ' / ', dk.rw) AS `RT / RW`,
        dk.desa AS Desa,
        dk.kecamatan AS Kecamatan,
        ag.nama AS Agama,
        dp.status_perkawinan AS `Status Perkawinan`,
        pk.nama AS Pekerjaan,
        dp.kewarganegaraan AS Kewarganegaraan
    FROM data_pribadi dp
    JOIN data_keluarga dk ON dp.no_kk_id = dk.no_kk
    LEFT JOIN agama ag ON dp.agama_id = ag.id
    LEFT JOIN pekerjaan pk ON dp.pekerjaan_id = pk.id
    WHERE dp.nik = p_nik;
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `agama`
--

CREATE TABLE `agama` (
  `id` int(11) NOT NULL,
  `nama` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `agama`
--

INSERT INTO `agama` (`id`, `nama`) VALUES
(1, 'Islam'),
(2, 'Kristen (Protestan)'),
(3, 'Hindu'),
(4, 'Budha'),
(5, 'Katolik'),
(6, 'Konghucu');

-- --------------------------------------------------------

--
-- Table structure for table `data_keluarga`
--

CREATE TABLE `data_keluarga` (
  `no_kk` varchar(20) NOT NULL,
  `alamat` text NOT NULL,
  `rt` varchar(10) DEFAULT NULL,
  `rw` varchar(10) DEFAULT NULL,
  `desa` varchar(50) DEFAULT NULL,
  `kecamatan` varchar(50) DEFAULT NULL,
  `tanggal_dikeluarkan` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `data_keluarga`
--

INSERT INTO `data_keluarga` (`no_kk`, `alamat`, `rt`, `rw`, `desa`, `kecamatan`, `tanggal_dikeluarkan`) VALUES
('3210010101010001', 'Jl. Melati No. 1', '01', '02', 'Desa Sukamaju', 'Kec. Sukaraja', '2020-01-15'),
('3210010101010002', 'Jl. Mawar No. 5', '03', '04', 'Desa Mekarsari', 'Kec. Cibiru', '2021-06-10');

-- --------------------------------------------------------

--
-- Table structure for table `data_pribadi`
--

CREATE TABLE `data_pribadi` (
  `nik` varchar(20) NOT NULL,
  `no_kk_id` varchar(20) DEFAULT NULL,
  `hubungan_keluarga_id` int(11) DEFAULT NULL,
  `nama` varchar(100) NOT NULL,
  `tempat_lahir` varchar(50) DEFAULT NULL,
  `tanggal_lahir` date DEFAULT NULL,
  `jenis_kelamin` enum('LAKI-LAKI','PEREMPUAN') DEFAULT NULL,
  `golongan_darah` enum('A','B','AB','O','-') DEFAULT NULL,
  `agama_id` int(11) DEFAULT NULL,
  `status_perkawinan` enum('Belum Kawin','Kawin','Cerai Hidup','Cerai Mati') DEFAULT NULL,
  `tanggal_perkawinan` date DEFAULT NULL,
  `tanggal_perceraian` date DEFAULT NULL,
  `pendidikan_terakhir_id` int(11) DEFAULT NULL,
  `pekerjaan_id` int(11) DEFAULT NULL,
  `kewarganegaraan` enum('WNI','WNA') NOT NULL DEFAULT 'WNI',
  `penyandang_disabilitas` tinyint(1) DEFAULT 0,
  `nama_ayah` varchar(100) DEFAULT NULL,
  `nama_ibu` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `data_pribadi`
--

INSERT INTO `data_pribadi` (`nik`, `no_kk_id`, `hubungan_keluarga_id`, `nama`, `tempat_lahir`, `tanggal_lahir`, `jenis_kelamin`, `golongan_darah`, `agama_id`, `status_perkawinan`, `tanggal_perkawinan`, `tanggal_perceraian`, `pendidikan_terakhir_id`, `pekerjaan_id`, `kewarganegaraan`, `penyandang_disabilitas`, `nama_ayah`, `nama_ibu`) VALUES
('3201010101010001', '3210010101010001', 1, 'BUDI SANTOSA', 'Bandung', '1975-02-15', 'LAKI-LAKI', 'O', 1, 'Kawin', '1995-06-20', NULL, 2, 5, 'WNI', 0, 'SUDARSO', 'SRI WAHYUNI'),
('3201010101010002', '3210010101010001', 3, 'SRI LESTARI', 'Bandung', '1978-07-30', 'PEREMPUAN', 'A', 1, 'Kawin', '1995-06-20', NULL, 3, 2, 'WNI', 0, 'SUMARNO', 'KARTINI'),
('3201010101010003', '3210010101010001', 4, 'ANDI SANTOSA', 'Bandung', '2002-11-10', 'LAKI-LAKI', 'B', 1, 'Belum Kawin', NULL, NULL, 3, 3, 'WNI', 0, 'BUDI SANTOSA', 'SRI LESTARI'),
('3201010101010004', '3210010101010001', 4, 'NINA SANTOSA', 'Bandung', '2005-03-21', 'PEREMPUAN', 'O', 1, 'Belum Kawin', NULL, NULL, 3, NULL, 'WNI', 0, 'BUDI SANTOSA', 'SRI LESTARI'),
('3201010101010005', '3210010101010001', 10, 'SUPARTO', 'Bandung', '1950-06-10', 'LAKI-LAKI', 'A', 1, 'Cerai Mati', '1972-01-01', '2020-10-01', 2, NULL, 'WNI', 0, 'NA', 'NA'),
('3201010101010006', '3210010101010002', 1, 'AGUS FIRMANSYAH', 'Cimahi', '1980-03-01', 'LAKI-LAKI', 'AB', 1, 'Kawin', '2004-05-12', NULL, 4, 1, 'WNI', 0, 'SUTISNA', 'RAHMAH'),
('3201010101010007', '3210010101010002', 3, 'DEWI RAHAYU', 'Cimahi', '1982-12-09', 'PEREMPUAN', 'O', 1, 'Kawin', '2004-05-12', NULL, 3, 2, 'WNI', 0, 'SUPARMAN', 'MURNI'),
('3201010101010008', '3210010101010002', 4, 'RINA FIRMANSYAH', 'Cimahi', '2010-08-25', 'PEREMPUAN', 'A', 1, 'Belum Kawin', NULL, NULL, 1, NULL, 'WNI', 0, 'AGUS FIRMANSYAH', 'DEWI RAHAYU'),
('3201010101010009', '3210010101010002', 4, 'REZA FIRMANSYAH', 'Cimahi', '2015-01-14', 'LAKI-LAKI', 'B', 1, 'Belum Kawin', NULL, NULL, 1, NULL, 'WNI', 0, 'AGUS FIRMANSYAH', 'DEWI RAHAYU'),
('3201010101010010', '3210010101010002', 10, 'KARMINAH', 'Cimahi', '1955-02-10', 'PEREMPUAN', 'AB', 1, 'Cerai Hidup', '1975-02-02', '2010-12-01', 2, NULL, 'WNI', 0, 'NA', 'NA');

-- --------------------------------------------------------

--
-- Table structure for table `hubungan_keluarga`
--

CREATE TABLE `hubungan_keluarga` (
  `id` int(11) NOT NULL,
  `nama` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `hubungan_keluarga`
--

INSERT INTO `hubungan_keluarga` (`id`, `nama`) VALUES
(1, 'KEPALA KELUARGA'),
(2, 'SUAMI'),
(3, 'ISTRI'),
(4, 'ANAK'),
(5, 'MENANTU'),
(6, 'CUCU'),
(7, 'ORANG TUA'),
(8, 'MERTUA'),
(9, 'FAMILI LAIN'),
(10, 'PEMBANTU'),
(11, 'LAINNYA');

-- --------------------------------------------------------

--
-- Table structure for table `pekerjaan`
--

CREATE TABLE `pekerjaan` (
  `id` int(11) NOT NULL,
  `nama` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pekerjaan`
--

INSERT INTO `pekerjaan` (`id`, `nama`) VALUES
(1, 'Belum / Tidak Bekerja'),
(2, 'Mengurus Rumah Tangga'),
(3, 'Pelajar / Mahasiswa'),
(4, 'Pensiunan'),
(5, 'Pegawai Negeri Sipil'),
(6, 'Tentara Nasional Indonesia'),
(7, 'Kepolisian RI'),
(8, 'Perdagangan'),
(9, 'Petani / Pekebun'),
(10, 'Peternak'),
(11, 'Nelayan / Perikanan'),
(12, 'Industri'),
(13, 'Konstruksi'),
(14, 'Transportasi'),
(15, 'Karyawan Swasta'),
(16, 'Karyawan BUMN'),
(17, 'Karyawan BUMD'),
(18, 'Karyawan Honorer'),
(19, 'Buruh Harian Lepas'),
(20, 'Buruh Tani / Perkebunan'),
(21, 'Buruh Nelayan / Perikanan'),
(22, 'Buruh Peternakan'),
(23, 'Pembantu Rumah Tangga'),
(24, 'Tukang Cukur'),
(25, 'Tukang Listrik'),
(26, 'Tukang Batu'),
(27, 'Tukang Kayu'),
(28, 'Tukang Sol Sepatu'),
(29, 'Tukang Las / Pandai Besi'),
(30, 'Tukang Jahit'),
(31, 'Penata Rambut'),
(32, 'Penata Rias'),
(33, 'Penata Busana'),
(34, 'Mekanik'),
(35, 'Tukang Gigi'),
(36, 'Seniman'),
(37, 'Tabib'),
(38, 'Paraji'),
(39, 'Perancang Busana'),
(40, 'Penterjemah'),
(41, 'Imam Masjid'),
(42, 'Pendeta'),
(43, 'Pastur'),
(44, 'Wartawan'),
(45, 'Ustadz / Mubaligh'),
(46, 'Juru Masak'),
(47, 'Promotor Acara'),
(48, 'Anggota DPR-RI'),
(49, 'Anggota DPD'),
(50, 'Anggota BPK'),
(51, 'Presiden'),
(52, 'Wakil Presiden'),
(53, 'Anggota Mahkamah Konstitusi'),
(54, 'Anggota Kabinet / Kementerian'),
(55, 'Duta Besar'),
(56, 'Gubernur'),
(57, 'Wakil Gubernur'),
(58, 'Bupati'),
(59, 'Wakil Bupati'),
(60, 'Walikota'),
(61, 'Wakil Walikota'),
(62, 'Anggota DPRD Propinsi'),
(63, 'Anggota DPRD Kabupaten / Kota'),
(64, 'Dosen'),
(65, 'Guru'),
(66, 'Pilot'),
(67, 'Pengacara'),
(68, 'Notaris'),
(69, 'Arsitek'),
(70, 'Akuntan'),
(71, 'Konsultan'),
(72, 'Dokter'),
(73, 'Bidan'),
(74, 'Perawat'),
(75, 'Apoteker'),
(76, 'Psikiater / Psikolog'),
(77, 'Penyiar Televisi'),
(78, 'Penyiar Radio'),
(79, 'Pelaut'),
(80, 'Peneliti'),
(81, 'Sopir'),
(82, 'Pialang'),
(83, 'Paranormal'),
(84, 'Pedagang'),
(85, 'Perangkat Desa'),
(86, 'Kepala Desa'),
(87, 'Biarawati'),
(88, 'Wiraswasta'),
(89, 'Anggota Lembaga Tinggi'),
(90, 'Artis'),
(91, 'Atlit'),
(92, 'Cheff'),
(93, 'Manajer'),
(94, 'Tenaga Tata Usaha'),
(95, 'Operator'),
(96, 'Pekerja Pengolahan, Kerajinan'),
(97, 'Teknisi'),
(98, 'Asisten Ahli'),
(99, 'Lainnya');

-- --------------------------------------------------------

--
-- Table structure for table `pendidikan_terakhir`
--

CREATE TABLE `pendidikan_terakhir` (
  `id` int(11) NOT NULL,
  `nama` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pendidikan_terakhir`
--

INSERT INTO `pendidikan_terakhir` (`id`, `nama`) VALUES
(1, 'TIDAK / BELUM SEKOLAH'),
(2, 'TAMAT SD / SEDERAJAT'),
(3, 'SLTA / SEDERAJAT'),
(4, 'SLTP/SEDERAJAT'),
(5, 'BELUM TAMAT SD/SEDERAJAT'),
(6, 'DIPLOMA IV/ STRATA I'),
(7, 'DIPLOMA I / II'),
(8, 'AKADEMI/ DIPLOMA III/S. MUDA'),
(9, 'STRATA II'),
(10, 'STRATA III');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `agama`
--
ALTER TABLE `agama`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `data_keluarga`
--
ALTER TABLE `data_keluarga`
  ADD PRIMARY KEY (`no_kk`);

--
-- Indexes for table `data_pribadi`
--
ALTER TABLE `data_pribadi`
  ADD PRIMARY KEY (`nik`),
  ADD KEY `no_kk_id` (`no_kk_id`),
  ADD KEY `hubungan_keluarga_id` (`hubungan_keluarga_id`),
  ADD KEY `agama_id` (`agama_id`),
  ADD KEY `pendidikan_terakhir_id` (`pendidikan_terakhir_id`),
  ADD KEY `pekerjaan_id` (`pekerjaan_id`);

--
-- Indexes for table `hubungan_keluarga`
--
ALTER TABLE `hubungan_keluarga`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pekerjaan`
--
ALTER TABLE `pekerjaan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pendidikan_terakhir`
--
ALTER TABLE `pendidikan_terakhir`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `agama`
--
ALTER TABLE `agama`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `hubungan_keluarga`
--
ALTER TABLE `hubungan_keluarga`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `pekerjaan`
--
ALTER TABLE `pekerjaan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=100;

--
-- AUTO_INCREMENT for table `pendidikan_terakhir`
--
ALTER TABLE `pendidikan_terakhir`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `data_pribadi`
--
ALTER TABLE `data_pribadi`
  ADD CONSTRAINT `data_pribadi_ibfk_1` FOREIGN KEY (`no_kk_id`) REFERENCES `data_keluarga` (`no_kk`),
  ADD CONSTRAINT `data_pribadi_ibfk_2` FOREIGN KEY (`hubungan_keluarga_id`) REFERENCES `hubungan_keluarga` (`id`),
  ADD CONSTRAINT `data_pribadi_ibfk_3` FOREIGN KEY (`agama_id`) REFERENCES `agama` (`id`),
  ADD CONSTRAINT `data_pribadi_ibfk_4` FOREIGN KEY (`pendidikan_terakhir_id`) REFERENCES `pendidikan_terakhir` (`id`),
  ADD CONSTRAINT `data_pribadi_ibfk_5` FOREIGN KEY (`pekerjaan_id`) REFERENCES `pekerjaan` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
