-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 25, 2025 at 02:18 PM
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
CREATE DEFINER=`root`@`localhost` PROCEDURE `COUNT_KELUARGA` ()   BEGIN
    SELECT COUNT(*) AS jumlah_keluarga FROM data_keluarga;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `COUNT_PENDUDUK` ()   BEGIN
    SELECT COUNT(*) AS jumlah_penduduk FROM data_pribadi;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `SHOW_DATA_WARGA_DESA` ()   BEGIN
    SELECT
        dp.nama AS `Nama`,
        dp.nik AS `NIK`,
        dp.no_kk_id AS `No. KK`,
        CONCAT(dp.tempat_lahir, ', ', DATE_FORMAT(dp.tanggal_lahir, '%d %M %Y')) AS `Tempat Tanggal Lahir`,
        CASE dp.jenis_kelamin
            WHEN 'LAKI-LAKI' THEN 'Laki-laki'
            WHEN 'PEREMPUAN' THEN 'Perempuan'
            ELSE '-'
        END AS `Jenis Kelamin`
    FROM data_pribadi dp
    ORDER BY dp.nama;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `SHOW_DETAIL_DATA_WARGA` (IN `p_nik` VARCHAR(20))   BEGIN
    
    SELECT
        dp.no_kk_id AS `Nomor KK`,
        dp.nik AS `Nomor NIK`,
        dp.nama AS `Nama Lengkap`,
        CONCAT(dp.tempat_lahir, ', ', DATE_FORMAT(dp.tanggal_lahir, '%d %M %Y')) AS `Tempat, Tanggal Lahir`,
        TIMESTAMPDIFF(YEAR, dp.tanggal_lahir, CURDATE()) AS `Usia`,
        pt.nama AS `Pendidikan Terakhir`,
        IF(dp.golongan_darah = '-', '-', dp.golongan_darah) AS `Gol Darah`,
        ag.nama AS `Agama`,
        dp.status_perkawinan AS `Status Pernikahan`,
        dk.rt AS RT,
        dk.rw AS RW,
        CONCAT(dk.alamat, ', RT ', dk.rt, ' / RW ', dk.rw, ', Kel. ', dk.desa, ', Kec. ', dk.kecamatan) AS `Alamat Lengkap`,
        IF(dp.penyandang_disabilitas, 'Ya', 'Tidak') AS `Penyandang Disabilitas`
    FROM data_pribadi dp
    LEFT JOIN data_keluarga dk ON dp.no_kk_id = dk.no_kk
    LEFT JOIN agama ag ON dp.agama_id = ag.id
    LEFT JOIN pendidikan_terakhir pt ON dp.pendidikan_terakhir_id = pt.id
    WHERE dp.nik = p_nik;

    
    SELECT
        hk.nama AS `Hubungan`,
        dp2.nama AS `Nama Anggota`,
        dp2.nik AS `NIK`
    FROM data_pribadi dp1
    JOIN data_pribadi dp2 ON dp1.no_kk_id = dp2.no_kk_id
    LEFT JOIN hubungan_keluarga hk ON dp2.hubungan_keluarga_id = hk.id
    WHERE dp1.nik = p_nik
    ORDER BY dp2.hubungan_keluarga_id;
END$$

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
        CONCAT(dp.tempat_lahir, ', ', DATE_FORMAT(dp.tanggal_lahir, '%d-%m-%Y')) AS `Tempat / Tanggal Lahir`,
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
  `id` int(10) UNSIGNED NOT NULL,
  `nama` varchar(50) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `agama`
--

INSERT INTO `agama` (`id`, `nama`, `created_at`, `updated_at`) VALUES
(1, 'ISLAM', NULL, NULL),
(2, 'KRISTEN', NULL, NULL),
(3, 'KATOLIK', NULL, NULL),
(4, 'HINDU', NULL, NULL),
(5, 'BUDDHA', NULL, NULL),
(6, 'KHONGHUCU', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
  `tanggal_dikeluarkan` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `data_keluarga`
--

INSERT INTO `data_keluarga` (`no_kk`, `alamat`, `rt`, `rw`, `desa`, `kecamatan`, `tanggal_dikeluarkan`, `created_at`, `updated_at`) VALUES
('3210010101010001', 'Jl. Melati No. 1', '01', '02', 'Desa Sukamaju', 'Kec. Sukaraja', '2020-01-15', NULL, NULL),
('3210010101010002', 'Jl. Mawar No. 5', '03', '04', 'Desa Mekarsari', 'Kec. Cibiru', '2021-06-10', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `data_pribadi`
--

CREATE TABLE `data_pribadi` (
  `nik` varchar(20) NOT NULL,
  `no_kk_id` varchar(20) DEFAULT NULL,
  `hubungan_keluarga_id` int(10) UNSIGNED DEFAULT NULL,
  `nama` varchar(100) NOT NULL,
  `tempat_lahir` varchar(50) DEFAULT NULL,
  `tanggal_lahir` date DEFAULT NULL,
  `jenis_kelamin` enum('LAKI-LAKI','PEREMPUAN') DEFAULT NULL,
  `golongan_darah` enum('A','B','AB','O','-') DEFAULT NULL,
  `agama_id` int(10) UNSIGNED DEFAULT NULL,
  `status_perkawinan` enum('Belum Kawin','Kawin','Cerai Hidup','Cerai Mati') DEFAULT NULL,
  `tanggal_perkawinan` date DEFAULT NULL,
  `tanggal_perceraian` date DEFAULT NULL,
  `pendidikan_terakhir_id` int(10) UNSIGNED DEFAULT NULL,
  `pekerjaan_id` int(10) UNSIGNED DEFAULT NULL,
  `kewarganegaraan` enum('WNI','WNA') NOT NULL DEFAULT 'WNI',
  `penyandang_disabilitas` tinyint(1) NOT NULL DEFAULT 0,
  `nama_ayah` varchar(100) DEFAULT NULL,
  `nama_ibu` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `data_pribadi`
--

INSERT INTO `data_pribadi` (`nik`, `no_kk_id`, `hubungan_keluarga_id`, `nama`, `tempat_lahir`, `tanggal_lahir`, `jenis_kelamin`, `golongan_darah`, `agama_id`, `status_perkawinan`, `tanggal_perkawinan`, `tanggal_perceraian`, `pendidikan_terakhir_id`, `pekerjaan_id`, `kewarganegaraan`, `penyandang_disabilitas`, `nama_ayah`, `nama_ibu`, `created_at`, `updated_at`) VALUES
('3201010101010001', '3210010101010001', 1, 'BUDI SANTOSA', 'Bandung', '1975-02-15', 'LAKI-LAKI', 'O', 1, 'Kawin', '1995-06-20', NULL, 2, 5, 'WNI', 0, 'SUDARSO', 'SRI WAHYUNI', NULL, NULL),
('3201010101010002', '3210010101010001', 3, 'SRI LESTARI', 'Bandung', '1978-07-30', 'PEREMPUAN', 'A', 1, 'Kawin', '1995-06-20', NULL, 3, 2, 'WNI', 0, 'SUMARNO', 'KARTINI', NULL, NULL),
('3201010101010003', '3210010101010001', 4, 'ANDI SANTOSA', 'Bandung', '2002-11-10', 'LAKI-LAKI', 'B', 1, 'Belum Kawin', NULL, NULL, 3, 3, 'WNI', 0, 'BUDI SANTOSA', 'SRI LESTARI', NULL, NULL),
('3201010101010004', '3210010101010001', 4, 'NINA SANTOSA', 'Bandung', '2005-03-21', 'PEREMPUAN', 'O', 1, 'Belum Kawin', NULL, NULL, 3, NULL, 'WNI', 0, 'BUDI SANTOSA', 'SRI LESTARI', NULL, NULL),
('3201010101010005', '3210010101010001', 10, 'SUPARTO', 'Bandung', '1950-06-10', 'LAKI-LAKI', 'A', 1, 'Cerai Mati', '1972-01-01', '2020-10-01', 2, NULL, 'WNI', 0, 'NA', 'NA', NULL, NULL),
('3201010101010006', '3210010101010002', 1, 'AGUS FIRMANSYAH', 'Cimahi', '1980-03-01', 'LAKI-LAKI', 'AB', 1, 'Kawin', '2004-05-12', NULL, 4, 1, 'WNI', 0, 'SUTISNA', 'RAHMAH', NULL, NULL),
('3201010101010007', '3210010101010002', 3, 'DEWI RAHAYU', 'Cimahi', '1982-12-09', 'PEREMPUAN', 'O', 1, 'Kawin', '2004-05-12', NULL, 3, 2, 'WNI', 0, 'SUPARMAN', 'MURNI', NULL, NULL),
('3201010101010008', '3210010101010002', 4, 'RINA FIRMANSYAH', 'Cimahi', '2010-08-25', 'PEREMPUAN', 'A', 1, 'Belum Kawin', NULL, NULL, 1, NULL, 'WNI', 0, 'AGUS FIRMANSYAH', 'DEWI RAHAYU', NULL, NULL),
('3201010101010009', '3210010101010002', 4, 'REZA FIRMANSYAH', 'Cimahi', '2015-01-14', 'LAKI-LAKI', 'B', 1, 'Belum Kawin', NULL, NULL, 1, NULL, 'WNI', 0, 'AGUS FIRMANSYAH', 'DEWI RAHAYU', NULL, NULL),
('3201010101010010', '3210010101010002', 10, 'KARMINAH', 'Cimahi', '1955-02-10', 'PEREMPUAN', 'AB', 1, 'Cerai Hidup', '1975-02-02', '2010-12-01', 2, NULL, 'WNI', 0, 'NA', 'NA', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `hubungan_keluarga`
--

CREATE TABLE `hubungan_keluarga` (
  `id` int(10) UNSIGNED NOT NULL,
  `nama` varchar(50) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `hubungan_keluarga`
--

INSERT INTO `hubungan_keluarga` (`id`, `nama`, `created_at`, `updated_at`) VALUES
(1, 'KEPALA KELUARGA', NULL, NULL),
(2, 'SUAMI', NULL, NULL),
(3, 'ISTRI', NULL, NULL),
(4, 'ANAK', NULL, NULL),
(5, 'MENANTU', NULL, NULL),
(6, 'CUCU', NULL, NULL),
(7, 'ORANG TUA', NULL, NULL),
(8, 'MERTUA', NULL, NULL),
(9, 'FAMILI LAIN', NULL, NULL),
(10, 'PEMBANTU', NULL, NULL),
(11, 'LAINNYA', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2025_07_25_092421_create_agama_table', 1),
(5, '2025_07_25_092421_create_pekerjaan_table', 1),
(6, '2025_07_25_092421_create_pendidikan_terakhir_table', 1),
(7, '2025_07_25_092433_create_hubungan_keluarga_table', 1),
(8, '2025_07_25_092510_create_data_keluarga_table', 1),
(9, '2025_07_25_092520_create_data_pribadi_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pekerjaan`
--

CREATE TABLE `pekerjaan` (
  `id` int(10) UNSIGNED NOT NULL,
  `nama` varchar(100) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pekerjaan`
--

INSERT INTO `pekerjaan` (`id`, `nama`, `created_at`, `updated_at`) VALUES
(1, 'Belum/Tidak Bekerja', NULL, NULL),
(2, 'Mengurus Rumah Tangga', NULL, NULL),
(3, 'Pelajar/Mahasiswa', NULL, NULL),
(4, 'Pensiunan', NULL, NULL),
(5, 'Pegawai Negeri Sipil (PNS)', NULL, NULL),
(6, 'Tentara Nasional Indonesia (TNI)', NULL, NULL),
(7, 'Kepolisian RI (POLRI)', NULL, NULL),
(8, 'Perdagangan', NULL, NULL),
(9, 'Petani/Pekebun', NULL, NULL),
(10, 'Peternak', NULL, NULL),
(11, 'Nelayan/Perikanan', NULL, NULL),
(12, 'Industri', NULL, NULL),
(13, 'Konstruksi', NULL, NULL),
(14, 'Transportasi', NULL, NULL),
(15, 'Karyawan Swasta', NULL, NULL),
(16, 'Karyawan BUMN', NULL, NULL),
(17, 'Karyawan BUMD', NULL, NULL),
(18, 'Karyawan Honorer', NULL, NULL),
(19, 'Buruh Harian Lepas', NULL, NULL),
(20, 'Buruh Tani/Perkebunan', NULL, NULL),
(21, 'Buruh Nelayan/Perikanan', NULL, NULL),
(22, 'Buruh Peternakan', NULL, NULL),
(23, 'Pembantu Rumah Tangga', NULL, NULL),
(24, 'Tukang Cukur', NULL, NULL),
(25, 'Tukang Listrik', NULL, NULL),
(26, 'Tukang Batu', NULL, NULL),
(27, 'Tukang Kayu', NULL, NULL),
(28, 'Tukang Sol Sepatu', NULL, NULL),
(29, 'Tukang Las/Pandai Besi', NULL, NULL),
(30, 'Tukang Jahit', NULL, NULL),
(31, 'Tukang Gigi', NULL, NULL),
(32, 'Penata Rias', NULL, NULL),
(33, 'Penata Busana', NULL, NULL),
(34, 'Penata Rambut', NULL, NULL),
(35, 'Mekanik', NULL, NULL),
(36, 'Seniman', NULL, NULL),
(37, 'Tabib', NULL, NULL),
(38, 'Paraji', NULL, NULL),
(39, 'Perancang Busana', NULL, NULL),
(40, 'Penterjemah', NULL, NULL),
(41, 'Imam Masjid', NULL, NULL),
(42, 'Pendeta', NULL, NULL),
(43, 'Pastor', NULL, NULL),
(44, 'Wartawan', NULL, NULL),
(45, 'Ustadz/Mubaligh', NULL, NULL),
(46, 'Juru Masak', NULL, NULL),
(47, 'Promotor Acara', NULL, NULL),
(48, 'Anggota DPR-RI', NULL, NULL),
(49, 'Anggota DPD', NULL, NULL),
(50, 'Anggota BPK', NULL, NULL),
(51, 'Presiden', NULL, NULL),
(52, 'Wakil Presiden', NULL, NULL),
(53, 'Anggota Mahkamah Konstitusi', NULL, NULL),
(54, 'Anggota Kabinet/Kementerian', NULL, NULL),
(55, 'Duta Besar', NULL, NULL),
(56, 'Gubernur', NULL, NULL),
(57, 'Wakil Gubernur', NULL, NULL),
(58, 'Bupati', NULL, NULL),
(59, 'Wakil Bupati', NULL, NULL),
(60, 'Walikota', NULL, NULL),
(61, 'Wakil Walikota', NULL, NULL),
(62, 'Anggota DPRD Provinsi', NULL, NULL),
(63, 'Anggota DPRD Kabupaten/Kota', NULL, NULL),
(64, 'Dosen', NULL, NULL),
(65, 'Guru', NULL, NULL),
(66, 'Pilot', NULL, NULL),
(67, 'Pengacara', NULL, NULL),
(68, 'Notaris', NULL, NULL),
(69, 'Arsitek', NULL, NULL),
(70, 'Akuntan', NULL, NULL),
(71, 'Konsultan', NULL, NULL),
(72, 'Dokter', NULL, NULL),
(73, 'Bidan', NULL, NULL),
(74, 'Perawat', NULL, NULL),
(75, 'Apoteker', NULL, NULL),
(76, 'Psikiater/Psikolog', NULL, NULL),
(77, 'Penyiar Televisi', NULL, NULL),
(78, 'Penyiar Radio', NULL, NULL),
(79, 'Pelaut', NULL, NULL),
(80, 'Peneliti', NULL, NULL),
(81, 'Sopir', NULL, NULL),
(82, 'Pialang', NULL, NULL),
(83, 'Paranormal', NULL, NULL),
(84, 'Pedagang', NULL, NULL),
(85, 'Perangkat Desa', NULL, NULL),
(86, 'Kepala Desa', NULL, NULL),
(87, 'Biarawati', NULL, NULL),
(88, 'Wiraswasta', NULL, NULL),
(89, 'Lainnya', NULL, NULL),
(90, 'Programmer', NULL, NULL),
(91, 'Desainer Grafis', NULL, NULL),
(92, 'Youtuber', NULL, NULL),
(93, 'Content Creator', NULL, NULL),
(94, 'Influencer', NULL, NULL),
(95, 'Streamer', NULL, NULL),
(96, 'Barista', NULL, NULL),
(97, 'Customer Service', NULL, NULL),
(98, 'Digital Marketing', NULL, NULL),
(99, 'Data Analyst', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `pendidikan_terakhir`
--

CREATE TABLE `pendidikan_terakhir` (
  `id` int(10) UNSIGNED NOT NULL,
  `nama` varchar(100) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pendidikan_terakhir`
--

INSERT INTO `pendidikan_terakhir` (`id`, `nama`, `created_at`, `updated_at`) VALUES
(1, 'TIDAK / BELUM SEKOLAH', NULL, NULL),
(2, 'BELUM TAMAT SD/SEDERAJAT', NULL, NULL),
(3, 'TAMAT SD/SEDERAJAT', NULL, NULL),
(4, 'SLTP/SEDERAJAT', NULL, NULL),
(5, 'SLTA/SEDERAJAT', NULL, NULL),
(6, 'DIPLOMA I/II', NULL, NULL),
(7, 'AKADEMI/DIPLOMA III/S. MUDA', NULL, NULL),
(8, 'DIPLOMA IV/STRATA I', NULL, NULL),
(9, 'STRATA II', NULL, NULL),
(10, 'STRATA III', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Test User', 'test@example.com', '2025-07-25 03:14:35', '$2y$12$56XTZDN6UcaRLQMGoMTIgetX7y0Arkx9iFKrLTLHhDKG/.NMEXXMy', 'mepXwWuE94', '2025-07-25 03:14:35', '2025-07-25 03:14:35');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `agama`
--
ALTER TABLE `agama`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

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
  ADD KEY `data_pribadi_no_kk_id_foreign` (`no_kk_id`),
  ADD KEY `data_pribadi_hubungan_keluarga_id_foreign` (`hubungan_keluarga_id`),
  ADD KEY `data_pribadi_agama_id_foreign` (`agama_id`),
  ADD KEY `data_pribadi_pendidikan_terakhir_id_foreign` (`pendidikan_terakhir_id`),
  ADD KEY `data_pribadi_pekerjaan_id_foreign` (`pekerjaan_id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `hubungan_keluarga`
--
ALTER TABLE `hubungan_keluarga`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indexes for table `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

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
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `data_pribadi`
--
ALTER TABLE `data_pribadi`
  ADD CONSTRAINT `data_pribadi_agama_id_foreign` FOREIGN KEY (`agama_id`) REFERENCES `agama` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `data_pribadi_hubungan_keluarga_id_foreign` FOREIGN KEY (`hubungan_keluarga_id`) REFERENCES `hubungan_keluarga` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `data_pribadi_no_kk_id_foreign` FOREIGN KEY (`no_kk_id`) REFERENCES `data_keluarga` (`no_kk`) ON DELETE SET NULL,
  ADD CONSTRAINT `data_pribadi_pekerjaan_id_foreign` FOREIGN KEY (`pekerjaan_id`) REFERENCES `pekerjaan` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `data_pribadi_pendidikan_terakhir_id_foreign` FOREIGN KEY (`pendidikan_terakhir_id`) REFERENCES `pendidikan_terakhir` (`id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
