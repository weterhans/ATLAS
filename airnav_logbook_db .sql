-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Oct 24, 2025 at 02:35 PM
-- Server version: 8.4.3
-- PHP Version: 8.3.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `airnav_logbook_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cnsd_activities`
--

CREATE TABLE `cnsd_activities` (
  `id` int NOT NULL,
  `kode` varchar(255) DEFAULT NULL,
  `dinas` varchar(50) DEFAULT NULL,
  `tanggal` date DEFAULT NULL,
  `waktu_mulai` time DEFAULT NULL,
  `waktu_selesai` time DEFAULT NULL,
  `alat` varchar(255) DEFAULT NULL,
  `permasalahan` text,
  `tindakan` text,
  `hasil` text,
  `status` varchar(50) DEFAULT NULL,
  `waktu_terputus` varchar(100) DEFAULT NULL,
  `teknisi` json DEFAULT NULL,
  `lampiran` json DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `cnsd_activities`
--

INSERT INTO `cnsd_activities` (`id`, `kode`, `dinas`, `tanggal`, `waktu_mulai`, `waktu_selesai`, `alat`, `permasalahan`, `tindakan`, `hasil`, `status`, `waktu_terputus`, `teknisi`, `lampiran`, `created_at`, `updated_at`) VALUES
(12, 'KG-CNSD-318135', 'Siang', '2025-10-23', '13:32:00', '15:32:00', 'ADSB', ' asg ag ag s', 'hs  shsdshs', ' shshdhdfg s fsf sdff  r a wfawrf awf f', 'Selesai', '1 jam', '[\"Andi Julianto\", \"joko\", \"testttt\"]', '[\"F:\\\\Project\\\\Airnav-App\\\\attachments\\\\attachment-1761208355238-kda-akali-league-of-legends-cosplay-black-background-neon-5k-1080x2400-2206.jpg\", \"F:\\\\Project\\\\Airnav-App\\\\attachments\\\\attachment-1761208355278-kda-league-of-legends-neon-smoke-black-background-cosplay-1024x768-300.jpg\", \"F:\\\\Project\\\\Airnav-App\\\\attachments\\\\attachment-1761208355283-kda-league-of-legends-neon-smoke-black-background-cosplay-1080x2400-300.jpg\", \"F:\\\\Project\\\\Airnav-App\\\\attachments\\\\attachment-1761208355293-kda-league-of-legends-neon-smoke-black-background-cosplay-1920x1080-300.jpg\"]', '2025-10-23 08:32:35', '2025-10-23 08:32:35'),
(13, 'KG-CNSD-017334', 'Malam', '2025-10-23', '23:47:00', '21:47:00', ' dsgsg sgs dg', 's dhsdhs fsfs', 'f sfs dfs hs gsd', 'gsdgsdh sdg sdgsdg', 'Selesai', NULL, '[\"Andi Julianto\", \"joko\", \"joko\"]', '[\"F:\\\\Project\\\\Airnav-App\\\\attachments\\\\attachment-1761220074491-wp4346716-asus-tuf-wallpapers.jpg\", \"F:\\\\Project\\\\Airnav-App\\\\attachments\\\\attachment-1761220074494-wp4346768-asus-tuf-wallpapers.jpg\", \"F:\\\\Project\\\\Airnav-App\\\\attachments\\\\attachment-1761220074499-wp4625863-asus-vivobook-wallpapers.gif\"]', '2025-10-23 11:47:54', '2025-10-23 11:47:54'),
(14, 'KG-CNSD-076503', 'Pagi', '2025-10-24', '22:48:00', '08:48:00', 'dgsd gs', 'gds ggs g', 'sd hdfa da af', 'a aghafasfa fa sf ', 'Selesai', NULL, '[\"Andi Julianto\", \"testttt\", \"joko\"]', '[\"F:\\\\Project\\\\Airnav-App\\\\attachments\\\\attachment-1761220114641-HslL1Dg.jpg\"]', '2025-10-23 11:48:34', '2025-10-23 11:48:34'),
(16, 'KG-CNSD-199764', 'Siang', '2025-10-24', '13:50:00', '15:50:00', ' das gag as', ' safdafasf', 'a sfa fas fafa', 'f asfasfasfas f', 'Selesai', NULL, '[\"Andi Julianto\", \"joko\", \"joko\", \"testttt\"]', '[\"F:\\\\Project\\\\Airnav-App\\\\attachments\\\\attachment-1761220230814-HslL1Dg.jpg\"]', '2025-10-23 11:50:30', '2025-10-23 11:50:30'),
(17, 'KG-CNSD-237564', 'Malam', '2025-10-24', '20:50:00', '22:50:00', ' asga  gfas', 'sa gasgasfas', 'hgasg asgfas', 'f afasfas gfazwaq', 'Selesai', NULL, '[\"Andi Julianto\", \"joko\", \"testttt\"]', '[\"F:\\\\Project\\\\Airnav-App\\\\attachments\\\\attachment-1761220263832-GYRlMoT.png\"]', '2025-10-23 11:51:03', '2025-10-23 11:51:03'),
(18, 'KG-CNSD-282140', 'Pagi', '2025-10-25', '08:51:00', '22:51:00', ' fasfa fgas', ' gagagas', 'ga gagsg', 'a g asg dfh fdh ddh dhdr he rerg wet w r wawq wqr aw fwra awf aw  wafwa ', 'Selesai', NULL, '[\"Andi Julianto\", \"joko\", \"testttt\"]', '[\"F:\\\\Project\\\\Airnav-App\\\\attachments\\\\attachment-1761220313684-wallpaperflare.com_wallpaper (1).jpg\"]', '2025-10-23 11:51:53', '2025-10-23 11:51:53'),
(19, 'KG-CNSD-319691', 'Siang', '2025-10-25', '15:52:00', '18:52:00', ' f f fffa', ' asfsfas fas f', 'as fas fas f ass rhg fa sf afas ', 'afafsasf asf r3  dwadsas ', 'Selesai', NULL, '[\"joko\", \"Andi Julianto\", \"testttt\"]', '[\"F:\\\\Project\\\\Airnav-App\\\\attachments\\\\attachment-1761220350605-GYRlMoT.png\", \"F:\\\\Project\\\\Airnav-App\\\\attachments\\\\attachment-1761220350640-HslL1Dg.jpg\"]', '2025-10-23 11:52:30', '2025-10-23 11:52:30'),
(20, 'KG-CNSD-359166', 'Malam', '2025-10-25', '19:52:00', '20:52:00', 'as fas fas fsa f', 'fa affa fa af ', 'fasfas  sszf r   wq rqw2', '  a   hdfsg dr ds sd gds ', 'Selesai', NULL, '[\"Andi Julianto\", \"testttt\", \"joko\"]', '[\"F:\\\\Project\\\\Airnav-App\\\\attachments\\\\attachment-1761220395566-wallpaperflare.com_wallpaper (1).jpg\"]', '2025-10-23 11:53:15', '2025-10-23 11:53:15'),
(21, 'KG-CNSD-423715', 'Pagi', '2025-10-26', '07:53:00', '09:53:00', 'sd fh hfd dfh hdf', 'sdsdgdsg gsd sgd', 'hfdfdhhfdhfd', 'hfd hfd fhd ', 'Selesai', NULL, '[\"joko\", \"Andi Julianto\", \"testttt\"]', '[\"F:\\\\Project\\\\Airnav-App\\\\attachments\\\\attachment-1761220452204-E1vvXpNVUAQkwIz.jpeg\"]', '2025-10-23 11:54:12', '2025-10-23 11:54:12'),
(22, 'KG-CNSD-453526', 'Siang', '2025-10-26', '13:54:00', '15:54:00', 'sdg g   fsasg ', 'sg dgsd sdg gsdgsd', 'sgdsg dgsdgsd sgdgsd g', 's gs gs sg dsdg gsd sdg ', 'Selesai', NULL, '[\"Andi Julianto\", \"joko\", \"testttt\"]', '[\"F:\\\\Project\\\\Airnav-App\\\\attachments\\\\attachment-1761220489770-j9pAs2N.jpg\"]', '2025-10-23 11:54:49', '2025-10-23 11:54:49'),
(23, 'KG-CNSD-495707', 'Malam', '2025-10-26', '20:55:00', '23:55:00', ' afasf afs fa sf fa ', 'fas sfa sfafsa fas', 'af saf sfa saf safs asf ', 'f safa sfa sfasfas f as', 'Selesai', NULL, '[\"joko\", \"testttt\", \"joko\"]', '[]', '2025-10-23 11:55:19', '2025-10-23 11:55:19');

-- --------------------------------------------------------

--
-- Table structure for table `cnsd_equipment`
--

CREATE TABLE `cnsd_equipment` (
  `id` int NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `cnsd_equipment`
--

INSERT INTO `cnsd_equipment` (`id`, `name`) VALUES
(1, 'VHF GND Main (p) 118.9'),
(2, 'VHF GND Main (s) 119.15'),
(3, 'VHF ADC Main (p) 118.3'),
(4, 'VHF ADC Main (s) 118.1'),
(5, 'VHF APP Direc Main (p) 123.2'),
(6, 'VHF APP Direc Main (s) 124.5'),
(7, 'VHF APP West Main (p) 125.1'),
(8, 'VHF APP West Main (s) 123.55'),
(9, 'VHF APP East Main (p) 124.0'),
(10, 'VHF APP East Main (s) 122.85'),
(11, 'VHF CDU (p) 121.65'),
(12, 'VHF CDU (s) 121.85'),
(13, 'VHF-ER Makassar (p) 123.9'),
(14, 'VHF-ER Makassar (s) 125.9'),
(15, 'VHF-ER UPKN 134.1'),
(16, 'VHF-ER UBLI 125.7'),
(17, 'VHF ATIS 128.2'),
(18, 'VHF Emergency 121.5'),
(19, 'VHF GND Backup (p) 118.9'),
(20, 'VHF GND Backup (s) 119.15'),
(21, 'VHF ADC Backup (p) 118.3'),
(22, 'VHF ADC Backup (s) 118.1'),
(23, 'VHF APP Direc Backup (p) 123.2'),
(24, 'VHF APP West Backup (p) 125.1'),
(25, 'VHF APP East Main (p) 124.0'),
(26, 'Server Recorder A'),
(27, 'Server Recorder B'),
(28, 'PC Recorder Playback'),
(29, 'NTP Server & Gps'),
(30, 'ATIS Server A'),
(31, 'ATIS Server B'),
(32, 'PC Client Oprator'),
(33, 'Server AMSC A'),
(34, 'Server AMSC B'),
(35, 'Control & Spv console A'),
(36, 'Control & Spv console B'),
(37, 'Komputer ADPS'),
(38, 'BO 1 WARRZPZE'),
(39, 'BO 2 WARRYMYO'),
(40, 'METEO 1 WARRYMYF'),
(41, 'METEO 2 WARRYMYO'),
(42, 'INFORMASI WARRYIYX'),
(43, 'VCCS - GATE X2 - 01'),
(44, 'VCCS - GATE X2 - 02'),
(45, 'VCCS - GATE X2 - 03'),
(46, 'VCCS - GATE X2 - 04'),
(47, 'VCCS - GPIF 1-4'),
(48, 'VCCS - ERIF 1-10'),
(49, 'VCCS - BCA 1-5'),
(50, 'VCCS - BCB 1-9'),
(51, 'CWP1'),
(52, 'CWP2'),
(53, 'CWP3'),
(54, 'CWP4'),
(55, 'CWP5'),
(56, 'CWP6'),
(57, 'CWP7'),
(58, 'CWP8'),
(59, 'CWP9'),
(60, 'CWP10'),
(61, 'CWP11 (CDU)'),
(62, 'CWP12'),
(63, 'DVOR'),
(64, 'DME'),
(65, 'ILS - Localizer'),
(66, 'ILS - Glide Path'),
(67, 'ILS - T-DME'),
(68, 'MSSR - RMM 1 & 2'),
(69, 'MSSR - LCMS 1 & 2'),
(70, 'MSSR - SMP 1 & 2'),
(71, 'MSSR- RDP 1 & 2'),
(72, 'ADSB');

-- --------------------------------------------------------

--
-- Table structure for table `cnsd_savedata`
--

CREATE TABLE `cnsd_savedata` (
  `id` int NOT NULL,
  `type` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `tanggal` date NOT NULL,
  `dinas` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `mantek` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `nama_alat` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `sampai` date DEFAULT NULL,
  `print` varchar(10) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `grup` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `file_name` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cnsd_savedata`
--

INSERT INTO `cnsd_savedata` (`id`, `type`, `tanggal`, `dinas`, `mantek`, `nama_alat`, `sampai`, `print`, `grup`, `file_name`) VALUES
(6, 'Harian', '2025-10-23', 'SIANG', 'Danang Pambodos', NULL, NULL, 'YA', 'CNSD', NULL),
(7, 'Harian', '2025-10-24', 'PAGI', 'Teknisi B', NULL, NULL, 'YA', 'CNSD', NULL),
(8, 'Bulanan', '2025-10-24', NULL, NULL, 'ALL Equipment', '2025-10-26', 'YA', 'CNSD', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `daily_cnsd_reports`
--

CREATE TABLE `daily_cnsd_reports` (
  `id` int NOT NULL,
  `report_id_custom` varchar(255) DEFAULT NULL,
  `dinas` varchar(50) DEFAULT NULL,
  `tanggal` date DEFAULT NULL,
  `jam` time DEFAULT NULL,
  `mantek` varchar(255) DEFAULT NULL,
  `acknowledge` varchar(255) DEFAULT NULL,
  `kode` varchar(255) DEFAULT NULL,
  `jadwal_dinas` text,
  `equipment_status` json DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `daily_cnsd_reports`
--

INSERT INTO `daily_cnsd_reports` (`id`, `report_id_custom`, `dinas`, `tanggal`, `jam`, `mantek`, `acknowledge`, `kode`, `jadwal_dinas`, `equipment_status`, `created_at`, `updated_at`) VALUES
(9, 'SIANG-23/10/2025-CNSD', 'SIANG', '2025-10-23', '15:31:00', 'Andi Julianto', 'joko', 'SIANG23102025CNSA', '1. Andi Julianto\n2. joko\n3. testttt', '{\"dme\": {\"status\": \"NORMAL\"}, \"adsb\": {\"status\": \"NORMAL\"}, \"cwp1\": {\"status\": \"NORMAL\"}, \"cwp2\": {\"status\": \"NORMAL\"}, \"cwp3\": {\"status\": \"NORMAL\"}, \"cwp4\": {\"status\": \"NORMAL\"}, \"cwp5\": {\"status\": \"NORMAL\"}, \"cwp6\": {\"status\": \"NORMAL\"}, \"cwp7\": {\"status\": \"NORMAL\"}, \"cwp8\": {\"status\": \"NORMAL\"}, \"cwp9\": {\"status\": \"NORMAL\"}, \"dvor\": {\"status\": \"NORMAL\"}, \"cwp10\": {\"status\": \"NORMAL\"}, \"cwp12\": {\"status\": \"NORMAL\"}, \"ilstdme\": {\"status\": \"NORMAL\"}, \"cwp11cdu\": {\"status\": \"NORMAL\"}, \"vccsbca15\": {\"status\": \"NORMAL\"}, \"vccsbcb19\": {\"status\": \"NORMAL\"}, \"mssrrdp1&2\": {\"status\": \"NORMAL\"}, \"mssrrmm1&2\": {\"status\": \"NORMAL\"}, \"mssrsmp1&2\": {\"status\": \"NORMAL\"}, \"vccsgpif14\": {\"status\": \"NORMAL\"}, \"atisservera\": {\"status\": \"NORMAL\"}, \"atisserverb\": {\"status\": \"NORMAL\"}, \"bo1warrzpze\": {\"status\": \"NORMAL\"}, \"bo2warrymyo\": {\"status\": \"NORMAL\"}, \"mssrlcms1&2\": {\"status\": \"NORMAL\"}, \"serveramsca\": {\"status\": \"NORMAL\"}, \"serveramscb\": {\"status\": \"NORMAL\"}, \"vccserif110\": {\"status\": \"NORMAL\"}, \"vhfatis1282\": {\"status\": \"NORMAL\"}, \"ilsglidepath\": {\"status\": \"NORMAL\"}, \"ilslocalizer\": {\"status\": \"NORMAL\"}, \"komputeradps\": {\"status\": \"NORMAL\"}, \"vccsgatex201\": {\"status\": \"NORMAL\"}, \"vccsgatex202\": {\"status\": \"NORMAL\"}, \"vccsgatex203\": {\"status\": \"NORMAL\"}, \"vccsgatex204\": {\"status\": \"NORMAL\"}, \"vhfcdup12165\": {\"status\": \"NORMAL\"}, \"vhfcdus12185\": {\"status\": \"NORMAL\"}, \"ntpserver&gps\": {\"status\": \"NORMAL\"}, \"vhferubli1257\": {\"status\": \"NORMAL\"}, \"vhferupkn1341\": {\"status\": \"NORMAL\"}, \"meteo1warrymyf\": {\"status\": \"NORMAL\"}, \"meteo2warrymyo\": {\"status\": \"NORMAL\"}, \"pcclientoprator\": {\"status\": \"NORMAL\"}, \"serverrecordera\": {\"status\": \"NORMAL\"}, \"serverrecorderb\": {\"status\": \"NORMAL\"}, \"vhfadcmainp1183\": {\"status\": \"SINGLE\", \"keterangan\": \"agag asasgags\"}, \"vhfadcmains1181\": {\"status\": \"U/S\", \"keterangan\": \" hdhfd fjdj dfd ghd\"}, \"vhfgndmainp1189\": {\"status\": \"NORMAL\"}, \"vhfemergency1215\": {\"status\": \"NORMAL\"}, \"vhfgndmains11915\": {\"status\": \"GANGGUAN\", \"keterangan\": \"adouahfoa faf asg ag\"}, \"informasiwarryiyx\": {\"status\": \"NORMAL\"}, \"vhfadcbackupp1183\": {\"status\": \"NORMAL\"}, \"vhfadcbackups1181\": {\"status\": \"NORMAL\"}, \"vhfgndbackupp1189\": {\"status\": \"NORMAL\"}, \"pcrecorderplayback\": {\"status\": \"NORMAL\"}, \"vhfermakassarp1239\": {\"status\": \"NORMAL\"}, \"vhfermakassars1259\": {\"status\": \"NORMAL\"}, \"vhfgndbackups11915\": {\"status\": \"NORMAL\"}, \"control&spvconsolea\": {\"status\": \"NORMAL\"}, \"control&spvconsoleb\": {\"status\": \"NORMAL\"}, \"vhfappeastmainp1240\": {\"status\": \"NORMAL\"}, \"vhfappwestmainp1251\": {\"status\": \"NORMAL\"}, \"vhfappdirecmainp1232\": {\"status\": \"NORMAL\"}, \"vhfappdirecmains1245\": {\"status\": \"NORMAL\"}, \"vhfappeastmains12285\": {\"status\": \"NORMAL\"}, \"vhfappwestmains12355\": {\"status\": \"NORMAL\"}, \"vhfappwestbackupp1251\": {\"status\": \"NORMAL\"}, \"vhfappdirecbackupp1232\": {\"status\": \"NORMAL\"}}', '2025-10-23 08:31:49', '2025-10-23 08:31:49'),
(10, 'MALAM-23/10/2025-CNSD', 'MALAM', '2025-10-23', '21:41:00', 'Andi Julianto', '', 'MALAM23102025CNSA', '1. joko\n2. Andi Julianto\n3. testttt\n4. wqeqewe', '{\"dme\": {\"status\": \"NORMAL\"}, \"adsb\": {\"status\": \"NORMAL\"}, \"cwp1\": {\"status\": \"NORMAL\"}, \"cwp2\": {\"status\": \"NORMAL\"}, \"cwp3\": {\"status\": \"NORMAL\"}, \"cwp4\": {\"status\": \"NORMAL\"}, \"cwp5\": {\"status\": \"NORMAL\"}, \"cwp6\": {\"status\": \"NORMAL\"}, \"cwp7\": {\"status\": \"NORMAL\"}, \"cwp8\": {\"status\": \"NORMAL\"}, \"cwp9\": {\"status\": \"NORMAL\"}, \"dvor\": {\"status\": \"NORMAL\"}, \"cwp10\": {\"status\": \"NORMAL\"}, \"cwp12\": {\"status\": \"NORMAL\"}, \"ilstdme\": {\"status\": \"NORMAL\"}, \"cwp11cdu\": {\"status\": \"NORMAL\"}, \"vccsbca15\": {\"status\": \"NORMAL\"}, \"vccsbcb19\": {\"status\": \"NORMAL\"}, \"mssrrdp1&2\": {\"status\": \"NORMAL\"}, \"mssrrmm1&2\": {\"status\": \"NORMAL\"}, \"mssrsmp1&2\": {\"status\": \"NORMAL\"}, \"vccsgpif14\": {\"status\": \"NORMAL\"}, \"atisservera\": {\"status\": \"NORMAL\"}, \"atisserverb\": {\"status\": \"NORMAL\"}, \"bo1warrzpze\": {\"status\": \"NORMAL\"}, \"bo2warrymyo\": {\"status\": \"NORMAL\"}, \"mssrlcms1&2\": {\"status\": \"NORMAL\"}, \"serveramsca\": {\"status\": \"NORMAL\"}, \"serveramscb\": {\"status\": \"NORMAL\"}, \"vccserif110\": {\"status\": \"NORMAL\"}, \"vhfatis1282\": {\"status\": \"NORMAL\"}, \"ilsglidepath\": {\"status\": \"NORMAL\"}, \"ilslocalizer\": {\"status\": \"NORMAL\"}, \"komputeradps\": {\"status\": \"NORMAL\"}, \"vccsgatex201\": {\"status\": \"NORMAL\"}, \"vccsgatex202\": {\"status\": \"NORMAL\"}, \"vccsgatex203\": {\"status\": \"NORMAL\"}, \"vccsgatex204\": {\"status\": \"NORMAL\"}, \"vhfcdup12165\": {\"status\": \"NORMAL\"}, \"vhfcdus12185\": {\"status\": \"NORMAL\"}, \"ntpserver&gps\": {\"status\": \"NORMAL\"}, \"vhferubli1257\": {\"status\": \"NORMAL\"}, \"vhferupkn1341\": {\"status\": \"NORMAL\"}, \"meteo1warrymyf\": {\"status\": \"NORMAL\"}, \"meteo2warrymyo\": {\"status\": \"NORMAL\"}, \"pcclientoprator\": {\"status\": \"NORMAL\"}, \"serverrecordera\": {\"status\": \"NORMAL\"}, \"serverrecorderb\": {\"status\": \"NORMAL\"}, \"vhfadcmainp1183\": {\"status\": \"NORMAL\"}, \"vhfadcmains1181\": {\"status\": \"GANGGUAN\", \"keterangan\": \" a asfashgaf asfg\"}, \"vhfgndmainp1189\": {\"status\": \"GANGGUAN\", \"keterangan\": \"das gag asfdas \"}, \"vhfemergency1215\": {\"status\": \"NORMAL\"}, \"vhfgndmains11915\": {\"status\": \"NORMAL\"}, \"informasiwarryiyx\": {\"status\": \"NORMAL\"}, \"vhfadcbackupp1183\": {\"status\": \"NORMAL\"}, \"vhfadcbackups1181\": {\"status\": \"NORMAL\"}, \"vhfgndbackupp1189\": {\"status\": \"NORMAL\"}, \"pcrecorderplayback\": {\"status\": \"NORMAL\"}, \"vhfermakassarp1239\": {\"status\": \"NORMAL\"}, \"vhfermakassars1259\": {\"status\": \"NORMAL\"}, \"vhfgndbackups11915\": {\"status\": \"NORMAL\"}, \"control&spvconsolea\": {\"status\": \"NORMAL\"}, \"control&spvconsoleb\": {\"status\": \"NORMAL\"}, \"vhfappeastmainp1240\": {\"status\": \"NORMAL\"}, \"vhfappwestmainp1251\": {\"status\": \"NORMAL\"}, \"vhfappdirecmainp1232\": {\"status\": \"NORMAL\"}, \"vhfappdirecmains1245\": {\"status\": \"NORMAL\"}, \"vhfappeastmains12285\": {\"status\": \"NORMAL\"}, \"vhfappwestmains12355\": {\"status\": \"NORMAL\"}, \"vhfappwestbackupp1251\": {\"status\": \"NORMAL\"}, \"vhfappdirecbackupp1232\": {\"status\": \"NORMAL\"}}', '2025-10-23 11:42:17', '2025-10-23 11:42:17'),
(11, 'PAGI-24/10/2025-CNSD', 'PAGI', '2025-10-24', '09:42:00', 'Andi Julianto', '', 'PAGI24102025CNSA', '1. Andi Julianto\n2. joko\n3. wqeqewe\n4. testttt', '{\"dme\": {\"status\": \"NORMAL\"}, \"adsb\": {\"status\": \"NORMAL\"}, \"cwp1\": {\"status\": \"NORMAL\"}, \"cwp2\": {\"status\": \"NORMAL\"}, \"cwp3\": {\"status\": \"NORMAL\"}, \"cwp4\": {\"status\": \"NORMAL\"}, \"cwp5\": {\"status\": \"NORMAL\"}, \"cwp6\": {\"status\": \"NORMAL\"}, \"cwp7\": {\"status\": \"NORMAL\"}, \"cwp8\": {\"status\": \"NORMAL\"}, \"cwp9\": {\"status\": \"NORMAL\"}, \"dvor\": {\"status\": \"NORMAL\"}, \"cwp10\": {\"status\": \"NORMAL\"}, \"cwp12\": {\"status\": \"NORMAL\"}, \"ilstdme\": {\"status\": \"NORMAL\"}, \"cwp11cdu\": {\"status\": \"NORMAL\"}, \"vccsbca15\": {\"status\": \"NORMAL\"}, \"vccsbcb19\": {\"status\": \"NORMAL\"}, \"mssrrdp1&2\": {\"status\": \"NORMAL\"}, \"mssrrmm1&2\": {\"status\": \"NORMAL\"}, \"mssrsmp1&2\": {\"status\": \"NORMAL\"}, \"vccsgpif14\": {\"status\": \"NORMAL\"}, \"atisservera\": {\"status\": \"NORMAL\"}, \"atisserverb\": {\"status\": \"NORMAL\"}, \"bo1warrzpze\": {\"status\": \"NORMAL\"}, \"bo2warrymyo\": {\"status\": \"NORMAL\"}, \"mssrlcms1&2\": {\"status\": \"NORMAL\"}, \"serveramsca\": {\"status\": \"NORMAL\"}, \"serveramscb\": {\"status\": \"NORMAL\"}, \"vccserif110\": {\"status\": \"NORMAL\"}, \"vhfatis1282\": {\"status\": \"NORMAL\"}, \"ilsglidepath\": {\"status\": \"NORMAL\"}, \"ilslocalizer\": {\"status\": \"NORMAL\"}, \"komputeradps\": {\"status\": \"NORMAL\"}, \"vccsgatex201\": {\"status\": \"NORMAL\"}, \"vccsgatex202\": {\"status\": \"NORMAL\"}, \"vccsgatex203\": {\"status\": \"NORMAL\"}, \"vccsgatex204\": {\"status\": \"NORMAL\"}, \"vhfcdup12165\": {\"status\": \"NORMAL\"}, \"vhfcdus12185\": {\"status\": \"NORMAL\"}, \"ntpserver&gps\": {\"status\": \"NORMAL\"}, \"vhferubli1257\": {\"status\": \"NORMAL\"}, \"vhferupkn1341\": {\"status\": \"NORMAL\"}, \"meteo1warrymyf\": {\"status\": \"NORMAL\"}, \"meteo2warrymyo\": {\"status\": \"NORMAL\"}, \"pcclientoprator\": {\"status\": \"NORMAL\"}, \"serverrecordera\": {\"status\": \"NORMAL\"}, \"serverrecorderb\": {\"status\": \"NORMAL\"}, \"vhfadcmainp1183\": {\"status\": \"SINGLE\", \"keterangan\": \"sag agasgaada \"}, \"vhfadcmains1181\": {\"status\": \"NORMAL\"}, \"vhfgndmainp1189\": {\"status\": \"NORMAL\"}, \"vhfemergency1215\": {\"status\": \"NORMAL\"}, \"vhfgndmains11915\": {\"status\": \"NORMAL\"}, \"informasiwarryiyx\": {\"status\": \"NORMAL\"}, \"vhfadcbackupp1183\": {\"status\": \"NORMAL\"}, \"vhfadcbackups1181\": {\"status\": \"NORMAL\"}, \"vhfgndbackupp1189\": {\"status\": \"NORMAL\"}, \"pcrecorderplayback\": {\"status\": \"NORMAL\"}, \"vhfermakassarp1239\": {\"status\": \"NORMAL\"}, \"vhfermakassars1259\": {\"status\": \"NORMAL\"}, \"vhfgndbackups11915\": {\"status\": \"NORMAL\"}, \"control&spvconsolea\": {\"status\": \"NORMAL\"}, \"control&spvconsoleb\": {\"status\": \"NORMAL\"}, \"vhfappeastmainp1240\": {\"status\": \"NORMAL\"}, \"vhfappwestmainp1251\": {\"status\": \"NORMAL\"}, \"vhfappdirecmainp1232\": {\"status\": \"NORMAL\"}, \"vhfappdirecmains1245\": {\"status\": \"NORMAL\"}, \"vhfappeastmains12285\": {\"status\": \"NORMAL\"}, \"vhfappwestmains12355\": {\"status\": \"NORMAL\"}, \"vhfappwestbackupp1251\": {\"status\": \"NORMAL\"}, \"vhfappdirecbackupp1232\": {\"status\": \"NORMAL\"}}', '2025-10-23 11:42:58', '2025-10-23 11:42:58'),
(12, 'SIANG-24/10/2025-CNSD', 'SIANG', '2025-10-24', '15:43:00', 'joko', '', 'SIANG24102025CNSA', '1. joko\n2. testttt\n3. wqeqewe', '{\"dme\": {\"status\": \"NORMAL\"}, \"adsb\": {\"status\": \"NORMAL\"}, \"cwp1\": {\"status\": \"NORMAL\"}, \"cwp2\": {\"status\": \"NORMAL\"}, \"cwp3\": {\"status\": \"NORMAL\"}, \"cwp4\": {\"status\": \"NORMAL\"}, \"cwp5\": {\"status\": \"NORMAL\"}, \"cwp6\": {\"status\": \"NORMAL\"}, \"cwp7\": {\"status\": \"NORMAL\"}, \"cwp8\": {\"status\": \"NORMAL\"}, \"cwp9\": {\"status\": \"NORMAL\"}, \"dvor\": {\"status\": \"NORMAL\"}, \"cwp10\": {\"status\": \"NORMAL\"}, \"cwp12\": {\"status\": \"NORMAL\"}, \"ilstdme\": {\"status\": \"NORMAL\"}, \"cwp11cdu\": {\"status\": \"NORMAL\"}, \"vccsbca15\": {\"status\": \"NORMAL\"}, \"vccsbcb19\": {\"status\": \"NORMAL\"}, \"mssrrdp1&2\": {\"status\": \"NORMAL\"}, \"mssrrmm1&2\": {\"status\": \"NORMAL\"}, \"mssrsmp1&2\": {\"status\": \"NORMAL\"}, \"vccsgpif14\": {\"status\": \"NORMAL\"}, \"atisservera\": {\"status\": \"NORMAL\"}, \"atisserverb\": {\"status\": \"NORMAL\"}, \"bo1warrzpze\": {\"status\": \"NORMAL\"}, \"bo2warrymyo\": {\"status\": \"NORMAL\"}, \"mssrlcms1&2\": {\"status\": \"NORMAL\"}, \"serveramsca\": {\"status\": \"NORMAL\"}, \"serveramscb\": {\"status\": \"NORMAL\"}, \"vccserif110\": {\"status\": \"NORMAL\"}, \"vhfatis1282\": {\"status\": \"NORMAL\"}, \"ilsglidepath\": {\"status\": \"NORMAL\"}, \"ilslocalizer\": {\"status\": \"NORMAL\"}, \"komputeradps\": {\"status\": \"NORMAL\"}, \"vccsgatex201\": {\"status\": \"NORMAL\"}, \"vccsgatex202\": {\"status\": \"NORMAL\"}, \"vccsgatex203\": {\"status\": \"NORMAL\"}, \"vccsgatex204\": {\"status\": \"NORMAL\"}, \"vhfcdup12165\": {\"status\": \"NORMAL\"}, \"vhfcdus12185\": {\"status\": \"NORMAL\"}, \"ntpserver&gps\": {\"status\": \"NORMAL\"}, \"vhferubli1257\": {\"status\": \"NORMAL\"}, \"vhferupkn1341\": {\"status\": \"NORMAL\"}, \"meteo1warrymyf\": {\"status\": \"NORMAL\"}, \"meteo2warrymyo\": {\"status\": \"NORMAL\"}, \"pcclientoprator\": {\"status\": \"NORMAL\"}, \"serverrecordera\": {\"status\": \"NORMAL\"}, \"serverrecorderb\": {\"status\": \"NORMAL\"}, \"vhfadcmainp1183\": {\"status\": \"NORMAL\"}, \"vhfadcmains1181\": {\"status\": \"NORMAL\"}, \"vhfgndmainp1189\": {\"status\": \"U/S\", \"keterangan\": \"f asfas fafa\"}, \"vhfemergency1215\": {\"status\": \"NORMAL\"}, \"vhfgndmains11915\": {\"status\": \"NORMAL\"}, \"informasiwarryiyx\": {\"status\": \"NORMAL\"}, \"vhfadcbackupp1183\": {\"status\": \"NORMAL\"}, \"vhfadcbackups1181\": {\"status\": \"NORMAL\"}, \"vhfgndbackupp1189\": {\"status\": \"NORMAL\"}, \"pcrecorderplayback\": {\"status\": \"NORMAL\"}, \"vhfermakassarp1239\": {\"status\": \"NORMAL\"}, \"vhfermakassars1259\": {\"status\": \"NORMAL\"}, \"vhfgndbackups11915\": {\"status\": \"NORMAL\"}, \"control&spvconsolea\": {\"status\": \"NORMAL\"}, \"control&spvconsoleb\": {\"status\": \"NORMAL\"}, \"vhfappeastmainp1240\": {\"status\": \"NORMAL\"}, \"vhfappwestmainp1251\": {\"status\": \"NORMAL\"}, \"vhfappdirecmainp1232\": {\"status\": \"NORMAL\"}, \"vhfappdirecmains1245\": {\"status\": \"NORMAL\"}, \"vhfappeastmains12285\": {\"status\": \"NORMAL\"}, \"vhfappwestmains12355\": {\"status\": \"NORMAL\"}, \"vhfappwestbackupp1251\": {\"status\": \"NORMAL\"}, \"vhfappdirecbackupp1232\": {\"status\": \"NORMAL\"}}', '2025-10-23 11:43:52', '2025-10-23 11:43:52'),
(13, 'MALAM-24/10/2025-CNSD', 'MALAM', '2025-10-24', '21:43:00', 'testttt', '', 'MALAM24102025CNSA', '1. Andi Julianto\n2. joko\n3. testttt', '{\"dme\": {\"status\": \"NORMAL\"}, \"adsb\": {\"status\": \"NORMAL\"}, \"cwp1\": {\"status\": \"NORMAL\"}, \"cwp2\": {\"status\": \"NORMAL\"}, \"cwp3\": {\"status\": \"NORMAL\"}, \"cwp4\": {\"status\": \"NORMAL\"}, \"cwp5\": {\"status\": \"NORMAL\"}, \"cwp6\": {\"status\": \"NORMAL\"}, \"cwp7\": {\"status\": \"NORMAL\"}, \"cwp8\": {\"status\": \"NORMAL\"}, \"cwp9\": {\"status\": \"NORMAL\"}, \"dvor\": {\"status\": \"NORMAL\"}, \"cwp10\": {\"status\": \"NORMAL\"}, \"cwp12\": {\"status\": \"NORMAL\"}, \"ilstdme\": {\"status\": \"NORMAL\"}, \"cwp11cdu\": {\"status\": \"NORMAL\"}, \"vccsbca15\": {\"status\": \"NORMAL\"}, \"vccsbcb19\": {\"status\": \"NORMAL\"}, \"mssrrdp1&2\": {\"status\": \"NORMAL\"}, \"mssrrmm1&2\": {\"status\": \"NORMAL\"}, \"mssrsmp1&2\": {\"status\": \"NORMAL\"}, \"vccsgpif14\": {\"status\": \"NORMAL\"}, \"atisservera\": {\"status\": \"NORMAL\"}, \"atisserverb\": {\"status\": \"NORMAL\"}, \"bo1warrzpze\": {\"status\": \"NORMAL\"}, \"bo2warrymyo\": {\"status\": \"NORMAL\"}, \"mssrlcms1&2\": {\"status\": \"NORMAL\"}, \"serveramsca\": {\"status\": \"NORMAL\"}, \"serveramscb\": {\"status\": \"NORMAL\"}, \"vccserif110\": {\"status\": \"NORMAL\"}, \"vhfatis1282\": {\"status\": \"NORMAL\"}, \"ilsglidepath\": {\"status\": \"NORMAL\"}, \"ilslocalizer\": {\"status\": \"NORMAL\"}, \"komputeradps\": {\"status\": \"NORMAL\"}, \"vccsgatex201\": {\"status\": \"NORMAL\"}, \"vccsgatex202\": {\"status\": \"NORMAL\"}, \"vccsgatex203\": {\"status\": \"NORMAL\"}, \"vccsgatex204\": {\"status\": \"NORMAL\"}, \"vhfcdup12165\": {\"status\": \"NORMAL\"}, \"vhfcdus12185\": {\"status\": \"NORMAL\"}, \"ntpserver&gps\": {\"status\": \"NORMAL\"}, \"vhferubli1257\": {\"status\": \"NORMAL\"}, \"vhferupkn1341\": {\"status\": \"NORMAL\"}, \"meteo1warrymyf\": {\"status\": \"NORMAL\"}, \"meteo2warrymyo\": {\"status\": \"NORMAL\"}, \"pcclientoprator\": {\"status\": \"NORMAL\"}, \"serverrecordera\": {\"status\": \"NORMAL\"}, \"serverrecorderb\": {\"status\": \"NORMAL\"}, \"vhfadcmainp1183\": {\"status\": \"NORMAL\"}, \"vhfadcmains1181\": {\"status\": \"GANGGUAN\", \"keterangan\": \"a sgfasg asga fas fasfd\"}, \"vhfgndmainp1189\": {\"status\": \"NORMAL\"}, \"vhfemergency1215\": {\"status\": \"NORMAL\"}, \"vhfgndmains11915\": {\"status\": \"NORMAL\"}, \"informasiwarryiyx\": {\"status\": \"NORMAL\"}, \"vhfadcbackupp1183\": {\"status\": \"NORMAL\"}, \"vhfadcbackups1181\": {\"status\": \"NORMAL\"}, \"vhfgndbackupp1189\": {\"status\": \"NORMAL\"}, \"pcrecorderplayback\": {\"status\": \"NORMAL\"}, \"vhfermakassarp1239\": {\"status\": \"NORMAL\"}, \"vhfermakassars1259\": {\"status\": \"NORMAL\"}, \"vhfgndbackups11915\": {\"status\": \"NORMAL\"}, \"control&spvconsolea\": {\"status\": \"NORMAL\"}, \"control&spvconsoleb\": {\"status\": \"NORMAL\"}, \"vhfappeastmainp1240\": {\"status\": \"NORMAL\"}, \"vhfappwestmainp1251\": {\"status\": \"NORMAL\"}, \"vhfappdirecmainp1232\": {\"status\": \"NORMAL\"}, \"vhfappdirecmains1245\": {\"status\": \"NORMAL\"}, \"vhfappeastmains12285\": {\"status\": \"NORMAL\"}, \"vhfappwestmains12355\": {\"status\": \"NORMAL\"}, \"vhfappwestbackupp1251\": {\"status\": \"NORMAL\"}, \"vhfappdirecbackupp1232\": {\"status\": \"NORMAL\"}}', '2025-10-23 11:44:16', '2025-10-23 11:44:16'),
(14, 'PAGI-25/10/2025-CNSD', 'PAGI', '2025-10-25', '08:44:00', 'Andi Julianto', '', 'PAGI25102025CNSA', '1. Andi Julianto\n2. joko\n3. wqeqewe', '{\"dme\": {\"status\": \"NORMAL\"}, \"adsb\": {\"status\": \"NORMAL\"}, \"cwp1\": {\"status\": \"NORMAL\"}, \"cwp2\": {\"status\": \"NORMAL\"}, \"cwp3\": {\"status\": \"NORMAL\"}, \"cwp4\": {\"status\": \"NORMAL\"}, \"cwp5\": {\"status\": \"NORMAL\"}, \"cwp6\": {\"status\": \"NORMAL\"}, \"cwp7\": {\"status\": \"NORMAL\"}, \"cwp8\": {\"status\": \"NORMAL\"}, \"cwp9\": {\"status\": \"NORMAL\"}, \"dvor\": {\"status\": \"NORMAL\"}, \"cwp10\": {\"status\": \"NORMAL\"}, \"cwp12\": {\"status\": \"NORMAL\"}, \"ilstdme\": {\"status\": \"NORMAL\"}, \"cwp11cdu\": {\"status\": \"NORMAL\"}, \"vccsbca15\": {\"status\": \"NORMAL\"}, \"vccsbcb19\": {\"status\": \"NORMAL\"}, \"mssrrdp1&2\": {\"status\": \"NORMAL\"}, \"mssrrmm1&2\": {\"status\": \"NORMAL\"}, \"mssrsmp1&2\": {\"status\": \"NORMAL\"}, \"vccsgpif14\": {\"status\": \"NORMAL\"}, \"atisservera\": {\"status\": \"NORMAL\"}, \"atisserverb\": {\"status\": \"NORMAL\"}, \"bo1warrzpze\": {\"status\": \"NORMAL\"}, \"bo2warrymyo\": {\"status\": \"NORMAL\"}, \"mssrlcms1&2\": {\"status\": \"NORMAL\"}, \"serveramsca\": {\"status\": \"NORMAL\"}, \"serveramscb\": {\"status\": \"NORMAL\"}, \"vccserif110\": {\"status\": \"NORMAL\"}, \"vhfatis1282\": {\"status\": \"NORMAL\"}, \"ilsglidepath\": {\"status\": \"NORMAL\"}, \"ilslocalizer\": {\"status\": \"NORMAL\"}, \"komputeradps\": {\"status\": \"NORMAL\"}, \"vccsgatex201\": {\"status\": \"NORMAL\"}, \"vccsgatex202\": {\"status\": \"NORMAL\"}, \"vccsgatex203\": {\"status\": \"NORMAL\"}, \"vccsgatex204\": {\"status\": \"NORMAL\"}, \"vhfcdup12165\": {\"status\": \"NORMAL\"}, \"vhfcdus12185\": {\"status\": \"NORMAL\"}, \"ntpserver&gps\": {\"status\": \"NORMAL\"}, \"vhferubli1257\": {\"status\": \"NORMAL\"}, \"vhferupkn1341\": {\"status\": \"NORMAL\"}, \"meteo1warrymyf\": {\"status\": \"NORMAL\"}, \"meteo2warrymyo\": {\"status\": \"NORMAL\"}, \"pcclientoprator\": {\"status\": \"NORMAL\"}, \"serverrecordera\": {\"status\": \"NORMAL\"}, \"serverrecorderb\": {\"status\": \"NORMAL\"}, \"vhfadcmainp1183\": {\"status\": \"NORMAL\"}, \"vhfadcmains1181\": {\"status\": \"NORMAL\"}, \"vhfgndmainp1189\": {\"status\": \"NORMAL\"}, \"vhfemergency1215\": {\"status\": \"NORMAL\"}, \"vhfgndmains11915\": {\"status\": \"NORMAL\"}, \"informasiwarryiyx\": {\"status\": \"NORMAL\"}, \"vhfadcbackupp1183\": {\"status\": \"NORMAL\"}, \"vhfadcbackups1181\": {\"status\": \"NORMAL\"}, \"vhfgndbackupp1189\": {\"status\": \"NORMAL\"}, \"pcrecorderplayback\": {\"status\": \"NORMAL\"}, \"vhfermakassarp1239\": {\"status\": \"NORMAL\"}, \"vhfermakassars1259\": {\"status\": \"NORMAL\"}, \"vhfgndbackups11915\": {\"status\": \"NORMAL\"}, \"control&spvconsolea\": {\"status\": \"NORMAL\"}, \"control&spvconsoleb\": {\"status\": \"NORMAL\"}, \"vhfappeastmainp1240\": {\"status\": \"NORMAL\"}, \"vhfappwestmainp1251\": {\"status\": \"NORMAL\"}, \"vhfappdirecmainp1232\": {\"status\": \"SINGLE\", \"keterangan\": \"asgasga gagssa\"}, \"vhfappdirecmains1245\": {\"status\": \"NORMAL\"}, \"vhfappeastmains12285\": {\"status\": \"NORMAL\"}, \"vhfappwestmains12355\": {\"status\": \"NORMAL\"}, \"vhfappwestbackupp1251\": {\"status\": \"NORMAL\"}, \"vhfappdirecbackupp1232\": {\"status\": \"NORMAL\"}}', '2025-10-23 11:44:42', '2025-10-23 11:44:42'),
(15, 'SIANG-25/10/2025-CNSD', 'SIANG', '2025-10-25', '14:44:00', 'joko', '', 'SIANG25102025CNSA', '1. joko\n2. joko\n3. joko\n4. testttt', '{\"dme\": {\"status\": \"NORMAL\"}, \"adsb\": {\"status\": \"NORMAL\"}, \"cwp1\": {\"status\": \"NORMAL\"}, \"cwp2\": {\"status\": \"NORMAL\"}, \"cwp3\": {\"status\": \"NORMAL\"}, \"cwp4\": {\"status\": \"NORMAL\"}, \"cwp5\": {\"status\": \"NORMAL\"}, \"cwp6\": {\"status\": \"NORMAL\"}, \"cwp7\": {\"status\": \"NORMAL\"}, \"cwp8\": {\"status\": \"NORMAL\"}, \"cwp9\": {\"status\": \"NORMAL\"}, \"dvor\": {\"status\": \"NORMAL\"}, \"cwp10\": {\"status\": \"NORMAL\"}, \"cwp12\": {\"status\": \"NORMAL\"}, \"ilstdme\": {\"status\": \"NORMAL\"}, \"cwp11cdu\": {\"status\": \"NORMAL\"}, \"vccsbca15\": {\"status\": \"NORMAL\"}, \"vccsbcb19\": {\"status\": \"NORMAL\"}, \"mssrrdp1&2\": {\"status\": \"NORMAL\"}, \"mssrrmm1&2\": {\"status\": \"NORMAL\"}, \"mssrsmp1&2\": {\"status\": \"NORMAL\"}, \"vccsgpif14\": {\"status\": \"NORMAL\"}, \"atisservera\": {\"status\": \"NORMAL\"}, \"atisserverb\": {\"status\": \"NORMAL\"}, \"bo1warrzpze\": {\"status\": \"NORMAL\"}, \"bo2warrymyo\": {\"status\": \"NORMAL\"}, \"mssrlcms1&2\": {\"status\": \"NORMAL\"}, \"serveramsca\": {\"status\": \"NORMAL\"}, \"serveramscb\": {\"status\": \"NORMAL\"}, \"vccserif110\": {\"status\": \"NORMAL\"}, \"vhfatis1282\": {\"status\": \"NORMAL\"}, \"ilsglidepath\": {\"status\": \"NORMAL\"}, \"ilslocalizer\": {\"status\": \"NORMAL\"}, \"komputeradps\": {\"status\": \"NORMAL\"}, \"vccsgatex201\": {\"status\": \"NORMAL\"}, \"vccsgatex202\": {\"status\": \"NORMAL\"}, \"vccsgatex203\": {\"status\": \"NORMAL\"}, \"vccsgatex204\": {\"status\": \"NORMAL\"}, \"vhfcdup12165\": {\"status\": \"NORMAL\"}, \"vhfcdus12185\": {\"status\": \"NORMAL\"}, \"ntpserver&gps\": {\"status\": \"NORMAL\"}, \"vhferubli1257\": {\"status\": \"NORMAL\"}, \"vhferupkn1341\": {\"status\": \"NORMAL\"}, \"meteo1warrymyf\": {\"status\": \"NORMAL\"}, \"meteo2warrymyo\": {\"status\": \"NORMAL\"}, \"pcclientoprator\": {\"status\": \"NORMAL\"}, \"serverrecordera\": {\"status\": \"NORMAL\"}, \"serverrecorderb\": {\"status\": \"NORMAL\"}, \"vhfadcmainp1183\": {\"status\": \"NORMAL\"}, \"vhfadcmains1181\": {\"status\": \"NORMAL\"}, \"vhfgndmainp1189\": {\"status\": \"NORMAL\"}, \"vhfemergency1215\": {\"status\": \"NORMAL\"}, \"vhfgndmains11915\": {\"status\": \"NORMAL\"}, \"informasiwarryiyx\": {\"status\": \"NORMAL\"}, \"vhfadcbackupp1183\": {\"status\": \"NORMAL\"}, \"vhfadcbackups1181\": {\"status\": \"NORMAL\"}, \"vhfgndbackupp1189\": {\"status\": \"NORMAL\"}, \"pcrecorderplayback\": {\"status\": \"NORMAL\"}, \"vhfermakassarp1239\": {\"status\": \"NORMAL\"}, \"vhfermakassars1259\": {\"status\": \"NORMAL\"}, \"vhfgndbackups11915\": {\"status\": \"NORMAL\"}, \"control&spvconsolea\": {\"status\": \"NORMAL\"}, \"control&spvconsoleb\": {\"status\": \"NORMAL\"}, \"vhfappeastmainp1240\": {\"status\": \"NORMAL\"}, \"vhfappwestmainp1251\": {\"status\": \"SINGLE\", \"keterangan\": \"kjabfka jfsba faklf amfna lfma\"}, \"vhfappdirecmainp1232\": {\"status\": \"NORMAL\"}, \"vhfappdirecmains1245\": {\"status\": \"NORMAL\"}, \"vhfappeastmains12285\": {\"status\": \"NORMAL\"}, \"vhfappwestmains12355\": {\"status\": \"NORMAL\"}, \"vhfappwestbackupp1251\": {\"status\": \"NORMAL\"}, \"vhfappdirecbackupp1232\": {\"status\": \"NORMAL\"}}', '2025-10-23 11:45:19', '2025-10-23 11:45:19'),
(16, 'MALAM-25/10/2025-CNSD', 'MALAM', '2025-10-25', '18:45:00', 'testttt', '', 'MALAM25102025CNSA', '1. testttt\n2. joko\n3. Andi Julianto', '{\"dme\": {\"status\": \"NORMAL\"}, \"adsb\": {\"status\": \"NORMAL\"}, \"cwp1\": {\"status\": \"NORMAL\"}, \"cwp2\": {\"status\": \"NORMAL\"}, \"cwp3\": {\"status\": \"NORMAL\"}, \"cwp4\": {\"status\": \"NORMAL\"}, \"cwp5\": {\"status\": \"NORMAL\"}, \"cwp6\": {\"status\": \"NORMAL\"}, \"cwp7\": {\"status\": \"NORMAL\"}, \"cwp8\": {\"status\": \"NORMAL\"}, \"cwp9\": {\"status\": \"NORMAL\"}, \"dvor\": {\"status\": \"NORMAL\"}, \"cwp10\": {\"status\": \"NORMAL\"}, \"cwp12\": {\"status\": \"NORMAL\"}, \"ilstdme\": {\"status\": \"NORMAL\"}, \"cwp11cdu\": {\"status\": \"NORMAL\"}, \"vccsbca15\": {\"status\": \"NORMAL\"}, \"vccsbcb19\": {\"status\": \"NORMAL\"}, \"mssrrdp1&2\": {\"status\": \"NORMAL\"}, \"mssrrmm1&2\": {\"status\": \"NORMAL\"}, \"mssrsmp1&2\": {\"status\": \"NORMAL\"}, \"vccsgpif14\": {\"status\": \"NORMAL\"}, \"atisservera\": {\"status\": \"NORMAL\"}, \"atisserverb\": {\"status\": \"NORMAL\"}, \"bo1warrzpze\": {\"status\": \"NORMAL\"}, \"bo2warrymyo\": {\"status\": \"NORMAL\"}, \"mssrlcms1&2\": {\"status\": \"NORMAL\"}, \"serveramsca\": {\"status\": \"NORMAL\"}, \"serveramscb\": {\"status\": \"NORMAL\"}, \"vccserif110\": {\"status\": \"NORMAL\"}, \"vhfatis1282\": {\"status\": \"NORMAL\"}, \"ilsglidepath\": {\"status\": \"NORMAL\"}, \"ilslocalizer\": {\"status\": \"NORMAL\"}, \"komputeradps\": {\"status\": \"NORMAL\"}, \"vccsgatex201\": {\"status\": \"NORMAL\"}, \"vccsgatex202\": {\"status\": \"NORMAL\"}, \"vccsgatex203\": {\"status\": \"NORMAL\"}, \"vccsgatex204\": {\"status\": \"NORMAL\"}, \"vhfcdup12165\": {\"status\": \"NORMAL\"}, \"vhfcdus12185\": {\"status\": \"NORMAL\"}, \"ntpserver&gps\": {\"status\": \"NORMAL\"}, \"vhferubli1257\": {\"status\": \"NORMAL\"}, \"vhferupkn1341\": {\"status\": \"NORMAL\"}, \"meteo1warrymyf\": {\"status\": \"NORMAL\"}, \"meteo2warrymyo\": {\"status\": \"NORMAL\"}, \"pcclientoprator\": {\"status\": \"NORMAL\"}, \"serverrecordera\": {\"status\": \"NORMAL\"}, \"serverrecorderb\": {\"status\": \"NORMAL\"}, \"vhfadcmainp1183\": {\"status\": \"NORMAL\"}, \"vhfadcmains1181\": {\"status\": \"NORMAL\"}, \"vhfgndmainp1189\": {\"status\": \"SINGLE\", \"keterangan\": \" afsfa gasg ag asgasf sgf\"}, \"vhfemergency1215\": {\"status\": \"NORMAL\"}, \"vhfgndmains11915\": {\"status\": \"NORMAL\"}, \"informasiwarryiyx\": {\"status\": \"NORMAL\"}, \"vhfadcbackupp1183\": {\"status\": \"NORMAL\"}, \"vhfadcbackups1181\": {\"status\": \"NORMAL\"}, \"vhfgndbackupp1189\": {\"status\": \"NORMAL\"}, \"pcrecorderplayback\": {\"status\": \"NORMAL\"}, \"vhfermakassarp1239\": {\"status\": \"NORMAL\"}, \"vhfermakassars1259\": {\"status\": \"NORMAL\"}, \"vhfgndbackups11915\": {\"status\": \"NORMAL\"}, \"control&spvconsolea\": {\"status\": \"NORMAL\"}, \"control&spvconsoleb\": {\"status\": \"NORMAL\"}, \"vhfappeastmainp1240\": {\"status\": \"NORMAL\"}, \"vhfappwestmainp1251\": {\"status\": \"NORMAL\"}, \"vhfappdirecmainp1232\": {\"status\": \"NORMAL\"}, \"vhfappdirecmains1245\": {\"status\": \"NORMAL\"}, \"vhfappeastmains12285\": {\"status\": \"NORMAL\"}, \"vhfappwestmains12355\": {\"status\": \"NORMAL\"}, \"vhfappwestbackupp1251\": {\"status\": \"NORMAL\"}, \"vhfappdirecbackupp1232\": {\"status\": \"NORMAL\"}}', '2025-10-23 11:45:39', '2025-10-23 11:45:39'),
(17, 'PAGI-26/10/2025-CNSD', 'PAGI', '2025-10-26', '08:45:00', 'Andi Julianto', '', 'PAGI26102025CNSA', '1. joko\n2. testttt\n3. wqeqewe\n4. joko', '{\"dme\": {\"status\": \"NORMAL\"}, \"adsb\": {\"status\": \"NORMAL\"}, \"cwp1\": {\"status\": \"NORMAL\"}, \"cwp2\": {\"status\": \"NORMAL\"}, \"cwp3\": {\"status\": \"NORMAL\"}, \"cwp4\": {\"status\": \"NORMAL\"}, \"cwp5\": {\"status\": \"NORMAL\"}, \"cwp6\": {\"status\": \"NORMAL\"}, \"cwp7\": {\"status\": \"NORMAL\"}, \"cwp8\": {\"status\": \"NORMAL\"}, \"cwp9\": {\"status\": \"NORMAL\"}, \"dvor\": {\"status\": \"NORMAL\"}, \"cwp10\": {\"status\": \"NORMAL\"}, \"cwp12\": {\"status\": \"NORMAL\"}, \"ilstdme\": {\"status\": \"NORMAL\"}, \"cwp11cdu\": {\"status\": \"NORMAL\"}, \"vccsbca15\": {\"status\": \"NORMAL\"}, \"vccsbcb19\": {\"status\": \"NORMAL\"}, \"mssrrdp1&2\": {\"status\": \"NORMAL\"}, \"mssrrmm1&2\": {\"status\": \"NORMAL\"}, \"mssrsmp1&2\": {\"status\": \"NORMAL\"}, \"vccsgpif14\": {\"status\": \"NORMAL\"}, \"atisservera\": {\"status\": \"NORMAL\"}, \"atisserverb\": {\"status\": \"NORMAL\"}, \"bo1warrzpze\": {\"status\": \"NORMAL\"}, \"bo2warrymyo\": {\"status\": \"NORMAL\"}, \"mssrlcms1&2\": {\"status\": \"NORMAL\"}, \"serveramsca\": {\"status\": \"NORMAL\"}, \"serveramscb\": {\"status\": \"NORMAL\"}, \"vccserif110\": {\"status\": \"NORMAL\"}, \"vhfatis1282\": {\"status\": \"NORMAL\"}, \"ilsglidepath\": {\"status\": \"NORMAL\"}, \"ilslocalizer\": {\"status\": \"NORMAL\"}, \"komputeradps\": {\"status\": \"NORMAL\"}, \"vccsgatex201\": {\"status\": \"NORMAL\"}, \"vccsgatex202\": {\"status\": \"NORMAL\"}, \"vccsgatex203\": {\"status\": \"NORMAL\"}, \"vccsgatex204\": {\"status\": \"NORMAL\"}, \"vhfcdup12165\": {\"status\": \"NORMAL\"}, \"vhfcdus12185\": {\"status\": \"NORMAL\"}, \"ntpserver&gps\": {\"status\": \"NORMAL\"}, \"vhferubli1257\": {\"status\": \"NORMAL\"}, \"vhferupkn1341\": {\"status\": \"NORMAL\"}, \"meteo1warrymyf\": {\"status\": \"NORMAL\"}, \"meteo2warrymyo\": {\"status\": \"NORMAL\"}, \"pcclientoprator\": {\"status\": \"NORMAL\"}, \"serverrecordera\": {\"status\": \"NORMAL\"}, \"serverrecorderb\": {\"status\": \"NORMAL\"}, \"vhfadcmainp1183\": {\"status\": \"NORMAL\"}, \"vhfadcmains1181\": {\"status\": \"NORMAL\"}, \"vhfgndmainp1189\": {\"status\": \"NORMAL\"}, \"vhfemergency1215\": {\"status\": \"NORMAL\"}, \"vhfgndmains11915\": {\"status\": \"NORMAL\"}, \"informasiwarryiyx\": {\"status\": \"NORMAL\"}, \"vhfadcbackupp1183\": {\"status\": \"NORMAL\"}, \"vhfadcbackups1181\": {\"status\": \"NORMAL\"}, \"vhfgndbackupp1189\": {\"status\": \"NORMAL\"}, \"pcrecorderplayback\": {\"status\": \"NORMAL\"}, \"vhfermakassarp1239\": {\"status\": \"NORMAL\"}, \"vhfermakassars1259\": {\"status\": \"NORMAL\"}, \"vhfgndbackups11915\": {\"status\": \"NORMAL\"}, \"control&spvconsolea\": {\"status\": \"NORMAL\"}, \"control&spvconsoleb\": {\"status\": \"NORMAL\"}, \"vhfappeastmainp1240\": {\"status\": \"NORMAL\"}, \"vhfappwestmainp1251\": {\"status\": \"NORMAL\"}, \"vhfappdirecmainp1232\": {\"status\": \"U/S\", \"keterangan\": \".a ,mmnsflamfg nal;s gmkagas\"}, \"vhfappdirecmains1245\": {\"status\": \"NORMAL\"}, \"vhfappeastmains12285\": {\"status\": \"NORMAL\"}, \"vhfappwestmains12355\": {\"status\": \"NORMAL\"}, \"vhfappwestbackupp1251\": {\"status\": \"NORMAL\"}, \"vhfappdirecbackupp1232\": {\"status\": \"NORMAL\"}}', '2025-10-23 11:46:05', '2025-10-23 11:46:05'),
(18, 'SIANG-26/10/2025-CNSD', 'SIANG', '2025-10-26', '09:46:00', 'Andi Julianto', 'testttt', 'SIANG26102025CNSA', '1. Andi Julianto\n2. Andi Julianto\n3. joko\n4. testttt', '{\"dme\": {\"status\": \"NORMAL\"}, \"adsb\": {\"status\": \"NORMAL\"}, \"cwp1\": {\"status\": \"NORMAL\"}, \"cwp2\": {\"status\": \"NORMAL\"}, \"cwp3\": {\"status\": \"NORMAL\"}, \"cwp4\": {\"status\": \"NORMAL\"}, \"cwp5\": {\"status\": \"NORMAL\"}, \"cwp6\": {\"status\": \"NORMAL\"}, \"cwp7\": {\"status\": \"NORMAL\"}, \"cwp8\": {\"status\": \"NORMAL\"}, \"cwp9\": {\"status\": \"NORMAL\"}, \"dvor\": {\"status\": \"NORMAL\"}, \"cwp10\": {\"status\": \"NORMAL\"}, \"cwp12\": {\"status\": \"NORMAL\"}, \"ilstdme\": {\"status\": \"NORMAL\"}, \"cwp11cdu\": {\"status\": \"NORMAL\"}, \"vccsbca15\": {\"status\": \"NORMAL\"}, \"vccsbcb19\": {\"status\": \"NORMAL\"}, \"mssrrdp1&2\": {\"status\": \"NORMAL\"}, \"mssrrmm1&2\": {\"status\": \"NORMAL\"}, \"mssrsmp1&2\": {\"status\": \"NORMAL\"}, \"vccsgpif14\": {\"status\": \"NORMAL\"}, \"atisservera\": {\"status\": \"NORMAL\"}, \"atisserverb\": {\"status\": \"NORMAL\"}, \"bo1warrzpze\": {\"status\": \"NORMAL\"}, \"bo2warrymyo\": {\"status\": \"NORMAL\"}, \"mssrlcms1&2\": {\"status\": \"NORMAL\"}, \"serveramsca\": {\"status\": \"NORMAL\"}, \"serveramscb\": {\"status\": \"NORMAL\"}, \"vccserif110\": {\"status\": \"NORMAL\"}, \"vhfatis1282\": {\"status\": \"NORMAL\"}, \"ilsglidepath\": {\"status\": \"NORMAL\"}, \"ilslocalizer\": {\"status\": \"NORMAL\"}, \"komputeradps\": {\"status\": \"NORMAL\"}, \"vccsgatex201\": {\"status\": \"NORMAL\"}, \"vccsgatex202\": {\"status\": \"NORMAL\"}, \"vccsgatex203\": {\"status\": \"NORMAL\"}, \"vccsgatex204\": {\"status\": \"NORMAL\"}, \"vhfcdup12165\": {\"status\": \"NORMAL\"}, \"vhfcdus12185\": {\"status\": \"NORMAL\"}, \"ntpserver&gps\": {\"status\": \"NORMAL\"}, \"vhferubli1257\": {\"status\": \"NORMAL\"}, \"vhferupkn1341\": {\"status\": \"NORMAL\"}, \"meteo1warrymyf\": {\"status\": \"NORMAL\"}, \"meteo2warrymyo\": {\"status\": \"NORMAL\"}, \"pcclientoprator\": {\"status\": \"NORMAL\"}, \"serverrecordera\": {\"status\": \"NORMAL\"}, \"serverrecorderb\": {\"status\": \"NORMAL\"}, \"vhfadcmainp1183\": {\"status\": \"SINGLE\", \"keterangan\": \"k amnfal fkaf ;as,fasfas\"}, \"vhfadcmains1181\": {\"status\": \"NORMAL\"}, \"vhfgndmainp1189\": {\"status\": \"NORMAL\"}, \"vhfemergency1215\": {\"status\": \"NORMAL\"}, \"vhfgndmains11915\": {\"status\": \"NORMAL\"}, \"informasiwarryiyx\": {\"status\": \"NORMAL\"}, \"vhfadcbackupp1183\": {\"status\": \"NORMAL\"}, \"vhfadcbackups1181\": {\"status\": \"NORMAL\"}, \"vhfgndbackupp1189\": {\"status\": \"NORMAL\"}, \"pcrecorderplayback\": {\"status\": \"NORMAL\"}, \"vhfermakassarp1239\": {\"status\": \"NORMAL\"}, \"vhfermakassars1259\": {\"status\": \"NORMAL\"}, \"vhfgndbackups11915\": {\"status\": \"NORMAL\"}, \"control&spvconsolea\": {\"status\": \"NORMAL\"}, \"control&spvconsoleb\": {\"status\": \"NORMAL\"}, \"vhfappeastmainp1240\": {\"status\": \"NORMAL\"}, \"vhfappwestmainp1251\": {\"status\": \"NORMAL\"}, \"vhfappdirecmainp1232\": {\"status\": \"NORMAL\"}, \"vhfappdirecmains1245\": {\"status\": \"NORMAL\"}, \"vhfappeastmains12285\": {\"status\": \"NORMAL\"}, \"vhfappwestmains12355\": {\"status\": \"NORMAL\"}, \"vhfappwestbackupp1251\": {\"status\": \"NORMAL\"}, \"vhfappdirecbackupp1232\": {\"status\": \"NORMAL\"}}', '2025-10-23 11:46:28', '2025-10-23 11:46:28'),
(19, 'MALAM-26/10/2025-CNSD', 'MALAM', '2025-10-26', '21:46:00', 'Andi Julianto', '', 'MALAM26102025CNSA', '1. wqeqewe\n2. Andi Julianto\n3. joko\n4. joko', '{\"dme\": {\"status\": \"NORMAL\"}, \"adsb\": {\"status\": \"NORMAL\"}, \"cwp1\": {\"status\": \"NORMAL\"}, \"cwp2\": {\"status\": \"NORMAL\"}, \"cwp3\": {\"status\": \"NORMAL\"}, \"cwp4\": {\"status\": \"NORMAL\"}, \"cwp5\": {\"status\": \"NORMAL\"}, \"cwp6\": {\"status\": \"NORMAL\"}, \"cwp7\": {\"status\": \"NORMAL\"}, \"cwp8\": {\"status\": \"NORMAL\"}, \"cwp9\": {\"status\": \"NORMAL\"}, \"dvor\": {\"status\": \"NORMAL\"}, \"cwp10\": {\"status\": \"NORMAL\"}, \"cwp12\": {\"status\": \"NORMAL\"}, \"ilstdme\": {\"status\": \"NORMAL\"}, \"cwp11cdu\": {\"status\": \"NORMAL\"}, \"vccsbca15\": {\"status\": \"NORMAL\"}, \"vccsbcb19\": {\"status\": \"NORMAL\"}, \"mssrrdp1&2\": {\"status\": \"NORMAL\"}, \"mssrrmm1&2\": {\"status\": \"NORMAL\"}, \"mssrsmp1&2\": {\"status\": \"NORMAL\"}, \"vccsgpif14\": {\"status\": \"NORMAL\"}, \"atisservera\": {\"status\": \"NORMAL\"}, \"atisserverb\": {\"status\": \"NORMAL\"}, \"bo1warrzpze\": {\"status\": \"NORMAL\"}, \"bo2warrymyo\": {\"status\": \"NORMAL\"}, \"mssrlcms1&2\": {\"status\": \"NORMAL\"}, \"serveramsca\": {\"status\": \"NORMAL\"}, \"serveramscb\": {\"status\": \"NORMAL\"}, \"vccserif110\": {\"status\": \"NORMAL\"}, \"vhfatis1282\": {\"status\": \"NORMAL\"}, \"ilsglidepath\": {\"status\": \"NORMAL\"}, \"ilslocalizer\": {\"status\": \"NORMAL\"}, \"komputeradps\": {\"status\": \"NORMAL\"}, \"vccsgatex201\": {\"status\": \"NORMAL\"}, \"vccsgatex202\": {\"status\": \"NORMAL\"}, \"vccsgatex203\": {\"status\": \"NORMAL\"}, \"vccsgatex204\": {\"status\": \"NORMAL\"}, \"vhfcdup12165\": {\"status\": \"NORMAL\"}, \"vhfcdus12185\": {\"status\": \"NORMAL\"}, \"ntpserver&gps\": {\"status\": \"NORMAL\"}, \"vhferubli1257\": {\"status\": \"NORMAL\"}, \"vhferupkn1341\": {\"status\": \"NORMAL\"}, \"meteo1warrymyf\": {\"status\": \"NORMAL\"}, \"meteo2warrymyo\": {\"status\": \"NORMAL\"}, \"pcclientoprator\": {\"status\": \"NORMAL\"}, \"serverrecordera\": {\"status\": \"NORMAL\"}, \"serverrecorderb\": {\"status\": \"NORMAL\"}, \"vhfadcmainp1183\": {\"status\": \"NORMAL\"}, \"vhfadcmains1181\": {\"status\": \"SINGLE\", \"keterangan\": \".,a snmfdal.,s gfa.fd as;dad.am,a amd \"}, \"vhfgndmainp1189\": {\"status\": \"NORMAL\"}, \"vhfemergency1215\": {\"status\": \"NORMAL\"}, \"vhfgndmains11915\": {\"status\": \"NORMAL\"}, \"informasiwarryiyx\": {\"status\": \"NORMAL\"}, \"vhfadcbackupp1183\": {\"status\": \"NORMAL\"}, \"vhfadcbackups1181\": {\"status\": \"NORMAL\"}, \"vhfgndbackupp1189\": {\"status\": \"NORMAL\"}, \"pcrecorderplayback\": {\"status\": \"NORMAL\"}, \"vhfermakassarp1239\": {\"status\": \"NORMAL\"}, \"vhfermakassars1259\": {\"status\": \"NORMAL\"}, \"vhfgndbackups11915\": {\"status\": \"NORMAL\"}, \"control&spvconsolea\": {\"status\": \"NORMAL\"}, \"control&spvconsoleb\": {\"status\": \"NORMAL\"}, \"vhfappeastmainp1240\": {\"status\": \"NORMAL\"}, \"vhfappwestmainp1251\": {\"status\": \"NORMAL\"}, \"vhfappdirecmainp1232\": {\"status\": \"NORMAL\"}, \"vhfappdirecmains1245\": {\"status\": \"NORMAL\"}, \"vhfappeastmains12285\": {\"status\": \"NORMAL\"}, \"vhfappwestmains12355\": {\"status\": \"NORMAL\"}, \"vhfappwestbackupp1251\": {\"status\": \"NORMAL\"}, \"vhfappdirecbackupp1232\": {\"status\": \"NORMAL\"}}', '2025-10-23 11:46:49', '2025-10-23 11:46:49');

-- --------------------------------------------------------

--
-- Table structure for table `daily_tfp_reports`
--

CREATE TABLE `daily_tfp_reports` (
  `id` int NOT NULL,
  `report_id_custom` varchar(255) DEFAULT NULL,
  `dinas` varchar(50) DEFAULT NULL,
  `tanggal` date DEFAULT NULL,
  `jam` time DEFAULT NULL,
  `mantek` varchar(255) DEFAULT NULL,
  `acknowledge` varchar(255) DEFAULT NULL,
  `kode` varchar(255) DEFAULT NULL,
  `jadwal_dinas` text,
  `equipment_status` json DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `daily_tfp_reports`
--

INSERT INTO `daily_tfp_reports` (`id`, `report_id_custom`, `dinas`, `tanggal`, `jam`, `mantek`, `acknowledge`, `kode`, `jadwal_dinas`, `equipment_status`, `created_at`, `updated_at`) VALUES
(1, NULL, 'PAGI', '2025-10-09', '11:28:00', '', '', 'PAGI09102025TFPA', 'johan\nrosana\najul', '{\"cctv\": {\"status\": \"NORMAL\"}, \"powergp\": {\"status\": \"NORMAL\"}, \"powermm\": {\"status\": \"NORMAL\"}, \"powerrx\": {\"status\": \"NORMAL\"}, \"powertx\": {\"status\": \"NORMAL\"}, \"ruangrx\": {\"status\": \"NORMAL\"}, \"telepon\": {\"status\": \"NORMAL\"}, \"doorlock\": {\"status\": \"NORMAL\"}, \"gedungtx\": {\"status\": \"NORMAL\"}, \"poweraro\": {\"status\": \"NORMAL\"}, \"powerpia\": {\"status\": \"NORMAL\"}, \"ruangaro\": {\"status\": \"NORMAL\"}, \"ruangcbt\": {\"status\": \"NORMAL\"}, \"ruangk2s\": {\"status\": \"NORMAL\"}, \"ruangpia\": {\"status\": \"NORMAL\"}, \"acpackage\": {\"status\": \"NORMAL\"}, \"lifttower\": {\"status\": \"NORMAL\"}, \"poweramsc\": {\"status\": \"NORMAL\"}, \"powerdvor\": {\"status\": \"NORMAL\"}, \"powermssr\": {\"status\": \"NORMAL\"}, \"powervccs\": {\"status\": \"NORMAL\"}, \"powervsat\": {\"status\": \"NORMAL\"}, \"ruangamsc\": {\"status\": \"NORMAL\"}, \"sheltergp\": {\"status\": \"NORMAL\"}, \"sheltermm\": {\"status\": \"NORMAL\"}, \"exhaustfan\": {\"status\": \"NORMAL\"}, \"ups&genset\": {\"status\": \"NORMAL\"}, \"acsplitduct\": {\"status\": \"NORMAL\"}, \"acsplitwall\": {\"status\": \"NORMAL\"}, \"gedungradar\": {\"status\": \"NORMAL\"}, \"powerasmgcs\": {\"status\": \"NORMAL\"}, \"shelterdvor\": {\"status\": \"NORMAL\"}, \"obstaclelight\": {\"status\": \"NORMAL\"}, \"radiotrunking\": {\"status\": \"NORMAL\"}, \"ruanggm&sekgm\": {\"status\": \"NORMAL\"}, \"toiletltg,1,2\": {\"status\": \"NORMAL\"}, \"koridorltg,1,2\": {\"status\": \"NORMAL\"}, \"poweratcsystem\": {\"status\": \"NORMAL\"}, \"powerlocalizer\": {\"status\": \"NORMAL\"}, \"powerrecording\": {\"status\": \"NORMAL\"}, \"rotatingbeacon\": {\"status\": \"NORMAL\"}, \"acstandingfloor\": {\"status\": \"NORMAL\"}, \"ruangkontrolapp\": {\"status\": \"NORMAL\"}, \"gensetgedungdvor\": {\"status\": \"NORMAL\"}, \"ruangistrahatapp\": {\"status\": \"NORMAL\"}, \"ruangrapatoprasi\": {\"status\": \"NORMAL\"}, \"ruangrapatteknik\": {\"status\": \"NORMAL\"}, \"shelterlocalizer\": {\"status\": \"NORMAL\"}, \"gensetgedungradar\": {\"status\": \"NORMAL\"}, \"ruangequipmentaob\": {\"status\": \"NORMAL\"}, \"ruangistrahattower\": {\"status\": \"NORMAL\"}, \"ruangmanagerteknik\": {\"status\": \"NORMAL\"}, \"upsu1topazgedungtx\": {\"status\": \"NORMAL\"}, \"lampupjugedungradar\": {\"status\": \"NORMAL\"}, \"lampusorotpapannama\": {\"status\": \"NORMAL\"}, \"ruangstandbyteknisi\": {\"status\": \"NORMAL\"}, \"upsu2pillergedungtx\": {\"status\": \"NORMAL\"}, \"ruangkontrolatctower\": {\"status\": \"NORMAL\"}, \"ruangrapatmanagerial\": {\"status\": \"NORMAL\"}, \"ruangmanagerialoprasi\": {\"status\": \"NORMAL\"}, \"ruangmanagerialteknik\": {\"status\": \"NORMAL\"}, \"upsu3pillergedungradar\": {\"status\": \"NORMAL\"}, \"upsu6daleequipmentroom\": {\"status\": \"NORMAL\"}, \"upsu7daleequipmentroom\": {\"status\": \"NORMAL\"}, \"upsu8gamaequipmentroom\": {\"status\": \"NORMAL\"}, \"ruangadministrasi&keuangan\": {\"status\": \"NORMAL\"}, \"upsu9protectaequipmentroom\": {\"status\": \"NORMAL\"}}', '2025-10-09 04:29:15', '2025-10-09 04:29:15'),
(2, 'PAGI-09/10/2025-TFP', 'PAGI', '2025-10-09', '11:45:00', 'joko', 'Andi Julianto', 'PAGI09102025TFPA', 'ajul\nnopi', '{\"cctv\": {\"status\": \"NORMAL\"}, \"powergp\": {\"status\": \"NORMAL\"}, \"powermm\": {\"status\": \"NORMAL\"}, \"powerrx\": {\"status\": \"NORMAL\"}, \"powertx\": {\"status\": \"GANGGUAN\", \"keterangan\": \"meledak\"}, \"ruangrx\": {\"status\": \"NORMAL\"}, \"telepon\": {\"status\": \"NORMAL\"}, \"doorlock\": {\"status\": \"NORMAL\"}, \"gedungtx\": {\"status\": \"NORMAL\"}, \"poweraro\": {\"status\": \"NORMAL\"}, \"powerpia\": {\"status\": \"NORMAL\"}, \"ruangaro\": {\"status\": \"NORMAL\"}, \"ruangcbt\": {\"status\": \"NORMAL\"}, \"ruangk2s\": {\"status\": \"NORMAL\"}, \"ruangpia\": {\"status\": \"NORMAL\"}, \"acpackage\": {\"status\": \"NORMAL\"}, \"lifttower\": {\"status\": \"NORMAL\"}, \"poweramsc\": {\"status\": \"NORMAL\"}, \"powerdvor\": {\"status\": \"NORMAL\"}, \"powermssr\": {\"status\": \"NORMAL\"}, \"powervccs\": {\"status\": \"NORMAL\"}, \"powervsat\": {\"status\": \"NORMAL\"}, \"ruangamsc\": {\"status\": \"NORMAL\"}, \"sheltergp\": {\"status\": \"NORMAL\"}, \"sheltermm\": {\"status\": \"NORMAL\"}, \"exhaustfan\": {\"status\": \"NORMAL\"}, \"ups&genset\": {\"status\": \"NORMAL\"}, \"acsplitduct\": {\"status\": \"NORMAL\"}, \"acsplitwall\": {\"status\": \"NORMAL\"}, \"gedungradar\": {\"status\": \"NORMAL\"}, \"powerasmgcs\": {\"status\": \"NORMAL\"}, \"shelterdvor\": {\"status\": \"NORMAL\"}, \"obstaclelight\": {\"status\": \"NORMAL\"}, \"radiotrunking\": {\"status\": \"NORMAL\"}, \"ruanggm&sekgm\": {\"status\": \"NORMAL\"}, \"toiletltg,1,2\": {\"status\": \"NORMAL\"}, \"koridorltg,1,2\": {\"status\": \"NORMAL\"}, \"poweratcsystem\": {\"status\": \"NORMAL\"}, \"powerlocalizer\": {\"status\": \"NORMAL\"}, \"powerrecording\": {\"status\": \"NORMAL\"}, \"rotatingbeacon\": {\"status\": \"NORMAL\"}, \"acstandingfloor\": {\"status\": \"NORMAL\"}, \"ruangkontrolapp\": {\"status\": \"NORMAL\"}, \"gensetgedungdvor\": {\"status\": \"NORMAL\"}, \"ruangistrahatapp\": {\"status\": \"NORMAL\"}, \"ruangrapatoprasi\": {\"status\": \"NORMAL\"}, \"ruangrapatteknik\": {\"status\": \"NORMAL\"}, \"shelterlocalizer\": {\"status\": \"NORMAL\"}, \"gensetgedungradar\": {\"status\": \"NORMAL\"}, \"ruangequipmentaob\": {\"status\": \"NORMAL\"}, \"ruangistrahattower\": {\"status\": \"NORMAL\"}, \"ruangmanagerteknik\": {\"status\": \"NORMAL\"}, \"upsu1topazgedungtx\": {\"status\": \"NORMAL\"}, \"lampupjugedungradar\": {\"status\": \"NORMAL\"}, \"lampusorotpapannama\": {\"status\": \"NORMAL\"}, \"ruangstandbyteknisi\": {\"status\": \"NORMAL\"}, \"upsu2pillergedungtx\": {\"status\": \"NORMAL\"}, \"ruangkontrolatctower\": {\"status\": \"NORMAL\"}, \"ruangrapatmanagerial\": {\"status\": \"NORMAL\"}, \"ruangmanagerialoprasi\": {\"status\": \"NORMAL\"}, \"ruangmanagerialteknik\": {\"status\": \"NORMAL\"}, \"upsu3pillergedungradar\": {\"status\": \"NORMAL\"}, \"upsu6daleequipmentroom\": {\"status\": \"NORMAL\"}, \"upsu7daleequipmentroom\": {\"status\": \"NORMAL\"}, \"upsu8gamaequipmentroom\": {\"status\": \"NORMAL\"}, \"ruangadministrasi&keuangan\": {\"status\": \"NORMAL\"}, \"upsu9protectaequipmentroom\": {\"status\": \"NORMAL\"}}', '2025-10-09 04:45:49', '2025-10-09 04:45:49'),
(3, 'SIANG-21/10/2025-TFP', 'SIANG', '2025-10-21', '15:49:00', 'Andi Julianto', '', 'SIANG21102025TFPA', '1. joko\n2. Andi Julianto\n3. testttt', '{\"cctv\": {\"status\": \"NORMAL\"}, \"powergp\": {\"status\": \"NORMAL\"}, \"powermm\": {\"status\": \"NORMAL\"}, \"powerrx\": {\"status\": \"NORMAL\"}, \"powertx\": {\"status\": \"GANGGUAN\", \"keterangan\": \"dasfa asf afas f\"}, \"ruangrx\": {\"status\": \"NORMAL\"}, \"telepon\": {\"status\": \"NORMAL\"}, \"doorlock\": {\"status\": \"NORMAL\"}, \"gedungtx\": {\"status\": \"NORMAL\"}, \"poweraro\": {\"status\": \"NORMAL\"}, \"powerpia\": {\"status\": \"NORMAL\"}, \"ruangaro\": {\"status\": \"NORMAL\"}, \"ruangcbt\": {\"status\": \"NORMAL\"}, \"ruangk2s\": {\"status\": \"NORMAL\"}, \"ruangpia\": {\"status\": \"NORMAL\"}, \"acpackage\": {\"status\": \"NORMAL\"}, \"lifttower\": {\"status\": \"NORMAL\"}, \"poweramsc\": {\"status\": \"NORMAL\"}, \"powerdvor\": {\"status\": \"NORMAL\"}, \"powermssr\": {\"status\": \"NORMAL\"}, \"powervccs\": {\"status\": \"NORMAL\"}, \"powervsat\": {\"status\": \"NORMAL\"}, \"ruangamsc\": {\"status\": \"NORMAL\"}, \"sheltergp\": {\"status\": \"NORMAL\"}, \"sheltermm\": {\"status\": \"NORMAL\"}, \"exhaustfan\": {\"status\": \"NORMAL\"}, \"ups&genset\": {\"status\": \"NORMAL\"}, \"acsplitduct\": {\"status\": \"NORMAL\"}, \"acsplitwall\": {\"status\": \"NORMAL\"}, \"gedungradar\": {\"status\": \"NORMAL\"}, \"powerasmgcs\": {\"status\": \"NORMAL\"}, \"shelterdvor\": {\"status\": \"NORMAL\"}, \"obstaclelight\": {\"status\": \"NORMAL\"}, \"radiotrunking\": {\"status\": \"NORMAL\"}, \"ruanggm&sekgm\": {\"status\": \"NORMAL\"}, \"toiletltg,1,2\": {\"status\": \"NORMAL\"}, \"koridorltg,1,2\": {\"status\": \"NORMAL\"}, \"poweratcsystem\": {\"status\": \"NORMAL\"}, \"powerlocalizer\": {\"status\": \"NORMAL\"}, \"powerrecording\": {\"status\": \"GANGGUAN\", \"keterangan\": \"dasgfas adsd as\"}, \"rotatingbeacon\": {\"status\": \"NORMAL\"}, \"acstandingfloor\": {\"status\": \"NORMAL\"}, \"ruangkontrolapp\": {\"status\": \"NORMAL\"}, \"gensetgedungdvor\": {\"status\": \"NORMAL\"}, \"ruangistrahatapp\": {\"status\": \"NORMAL\"}, \"ruangrapatoprasi\": {\"status\": \"NORMAL\"}, \"ruangrapatteknik\": {\"status\": \"NORMAL\"}, \"shelterlocalizer\": {\"status\": \"NORMAL\"}, \"gensetgedungradar\": {\"status\": \"NORMAL\"}, \"ruangequipmentaob\": {\"status\": \"NORMAL\"}, \"ruangistrahattower\": {\"status\": \"NORMAL\"}, \"ruangmanagerteknik\": {\"status\": \"NORMAL\"}, \"upsu1topazgedungtx\": {\"status\": \"NORMAL\"}, \"lampupjugedungradar\": {\"status\": \"NORMAL\"}, \"lampusorotpapannama\": {\"status\": \"NORMAL\"}, \"ruangstandbyteknisi\": {\"status\": \"NORMAL\"}, \"upsu2pillergedungtx\": {\"status\": \"NORMAL\"}, \"ruangkontrolatctower\": {\"status\": \"NORMAL\"}, \"ruangrapatmanagerial\": {\"status\": \"NORMAL\"}, \"ruangmanagerialoprasi\": {\"status\": \"NORMAL\"}, \"ruangmanagerialteknik\": {\"status\": \"NORMAL\"}, \"upsu3pillergedungradar\": {\"status\": \"NORMAL\"}, \"upsu6daleequipmentroom\": {\"status\": \"NORMAL\"}, \"upsu7daleequipmentroom\": {\"status\": \"NORMAL\"}, \"upsu8gamaequipmentroom\": {\"status\": \"NORMAL\"}, \"ruangadministrasi&keuangan\": {\"status\": \"NORMAL\"}, \"upsu9protectaequipmentroom\": {\"status\": \"NORMAL\"}}', '2025-10-21 08:49:56', '2025-10-21 10:17:32');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint UNSIGNED NOT NULL,
  `reserved_at` int UNSIGNED DEFAULT NULL,
  `available_at` int UNSIGNED NOT NULL,
  `created_at` int UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext COLLATE utf8mb4_unicode_ci,
  `cancelled_at` int DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000001_create_cache_table', 1),
(2, '0001_01_01_000002_create_jobs_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `schedules_cnsd`
--

CREATE TABLE `schedules_cnsd` (
  `id` int NOT NULL,
  `schedule_id_custom` varchar(255) DEFAULT NULL,
  `tanggal` date DEFAULT NULL,
  `hari` varchar(50) DEFAULT NULL,
  `dinas` varchar(50) DEFAULT NULL,
  `teknisi_1` varchar(255) DEFAULT NULL,
  `teknisi_2` varchar(255) DEFAULT NULL,
  `teknisi_3` varchar(255) DEFAULT NULL,
  `teknisi_4` varchar(255) DEFAULT NULL,
  `teknisi_5` varchar(255) DEFAULT NULL,
  `teknisi_6` varchar(255) DEFAULT NULL,
  `kode` varchar(100) DEFAULT NULL,
  `grup` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT 'CNSD',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `schedules_cnsd`
--

INSERT INTO `schedules_cnsd` (`id`, `schedule_id_custom`, `tanggal`, `hari`, `dinas`, `teknisi_1`, `teknisi_2`, `teknisi_3`, `teknisi_4`, `teknisi_5`, `teknisi_6`, `kode`, `grup`, `created_at`, `updated_at`) VALUES
(10, 'SIANG-23/10/2025-CNSD', '2025-10-23', 'Rabu', 'Siang', 'Andi Julianto', 'joko', 'testttt', 'Andi Julianto', 'joko', 'wqeqewe', 'SIANG-23/10/2025-CNSD', 'CNSD', '2025-10-23 08:31:11', '2025-10-23 10:50:55'),
(11, 'MALAM-23/10/2025-CNSD', '2025-10-23', 'Rabu', 'Malam', 'joko', 'Andi Julianto', 'testttt', 'wqeqewe', NULL, NULL, 'MALAM-23/10/2025-CNSD', 'CNSD', '2025-10-23 11:35:49', '2025-10-23 11:35:49'),
(12, 'PAGI-24/10/2025-CNSD', '2025-10-24', 'Kamis', 'Pagi', 'Andi Julianto', 'joko', 'wqeqewe', 'testttt', NULL, NULL, 'PAGI-24/10/2025-CNSD', 'CNSD', '2025-10-23 11:36:14', '2025-10-23 11:36:14'),
(13, 'SIANG-24/10/2025-CNSD', '2025-10-24', 'Kamis', 'Siang', 'joko', 'testttt', 'wqeqewe', NULL, NULL, NULL, 'SIANG-24/10/2025-CNSD', 'CNSD', '2025-10-23 11:36:45', '2025-10-23 11:36:45'),
(15, 'MALAM-24/10/2025-CNSD', '2025-10-24', 'Kamis', 'Malam', 'Andi Julianto', 'joko', 'testttt', NULL, NULL, NULL, 'MALAM-24/10/2025-CNSD', 'CNSD', '2025-10-23 11:38:38', '2025-10-23 11:38:38'),
(16, 'PAGI-25/10/2025-CNSD', '2025-10-25', 'Jumat', 'Pagi', 'Andi Julianto', 'joko', 'wqeqewe', NULL, NULL, NULL, 'PAGI-25/10/2025-CNSD', 'CNSD', '2025-10-23 11:39:06', '2025-10-23 11:39:06'),
(17, 'SIANG-25/10/2025-CNSD', '2025-10-25', 'Jumat', 'Siang', 'joko', 'joko', 'joko', 'testttt', NULL, NULL, 'SIANG-25/10/2025-CNSD', 'CNSD', '2025-10-23 11:39:18', '2025-10-23 11:39:18'),
(18, 'MALAM-25/10/2025-CNSD', '2025-10-25', 'Jumat', 'Malam', 'testttt', 'joko', 'Andi Julianto', NULL, NULL, NULL, 'MALAM-25/10/2025-CNSD', 'CNSD', '2025-10-23 11:39:28', '2025-10-23 11:39:28'),
(19, 'SIANG-26/10/2025-CNSD', '2025-10-26', 'Sabtu', 'Siang', 'Andi Julianto', 'Andi Julianto', 'joko', 'testttt', NULL, NULL, 'SIANG-26/10/2025-CNSD', 'CNSD', '2025-10-23 11:39:44', '2025-10-23 11:39:44'),
(20, 'PAGI-26/10/2025-CNSD', '2025-10-26', 'Sabtu', 'Pagi', 'joko', 'testttt', 'wqeqewe', 'joko', NULL, NULL, 'PAGI-26/10/2025-CNSD', 'CNSD', '2025-10-23 11:40:15', '2025-10-23 11:40:15'),
(21, 'MALAM-26/10/2025-CNSD', '2025-10-26', 'Sabtu', 'Malam', 'wqeqewe', 'Andi Julianto', 'joko', NULL, 'joko', NULL, 'MALAM-26/10/2025-CNSD', 'CNSD', '2025-10-23 11:40:31', '2025-10-23 11:40:31');

-- --------------------------------------------------------

--
-- Table structure for table `schedules_tfp`
--

CREATE TABLE `schedules_tfp` (
  `id` int NOT NULL,
  `schedule_id_custom` varchar(255) DEFAULT NULL,
  `tanggal` date DEFAULT NULL,
  `hari` varchar(50) DEFAULT NULL,
  `dinas` varchar(50) DEFAULT NULL,
  `teknisi_1` varchar(255) DEFAULT NULL,
  `teknisi_2` varchar(255) DEFAULT NULL,
  `teknisi_3` varchar(255) DEFAULT NULL,
  `teknisi_4` varchar(255) DEFAULT NULL,
  `teknisi_5` varchar(255) DEFAULT NULL,
  `teknisi_6` varchar(255) DEFAULT NULL,
  `kode` varchar(100) DEFAULT NULL,
  `grup` varchar(100) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `schedules_tfp`
--

INSERT INTO `schedules_tfp` (`id`, `schedule_id_custom`, `tanggal`, `hari`, `dinas`, `teknisi_1`, `teknisi_2`, `teknisi_3`, `teknisi_4`, `teknisi_5`, `teknisi_6`, `kode`, `grup`, `created_at`, `updated_at`) VALUES
(1, 'MALAM-08/10/2025-TFP', '2025-10-08', 'Rabu', 'Malam', 'wqeqewe', NULL, NULL, NULL, NULL, NULL, 'MALAM-08/10/2025-TFP', 'TFP', '2025-10-08 19:49:20', '2025-10-08 19:49:20'),
(2, 'MALAM-20/10/2025-TFP', '2025-10-19', 'Minggu', 'Malam', 'Andi Julianto', 'joko', 'testttt', NULL, NULL, NULL, 'MALAM-20/10/2025-TFP', 'TFP', '2025-10-20 16:50:36', '2025-10-21 10:32:12'),
(3, 'SIANG-21/10/2025-TFP', '2025-10-21', 'Senin', 'Siang', 'joko', 'Andi Julianto', 'testttt', NULL, NULL, NULL, 'SIANG-21/10/2025-TFP', 'TFP', '2025-10-21 07:49:24', '2025-10-21 10:36:49'),
(4, 'MALAM-23/10/2025-TFP', '2025-10-23', 'Rabu', 'Malam', 'Andi Julianto', 'joko', 'testttt', NULL, NULL, NULL, 'MALAM-23/10/2025-TFP', 'TFP', '2025-10-23 18:50:35', '2025-10-23 18:50:35');

-- --------------------------------------------------------

--
-- Table structure for table `tfp_activities`
--

CREATE TABLE `tfp_activities` (
  `id` int NOT NULL,
  `kode` varchar(255) DEFAULT NULL,
  `dinas` varchar(50) DEFAULT NULL,
  `tanggal` date DEFAULT NULL,
  `waktu_mulai` time DEFAULT NULL,
  `waktu_selesai` time DEFAULT NULL,
  `alat` varchar(255) DEFAULT NULL,
  `permasalahan` text,
  `tindakan` text,
  `hasil` text,
  `status` varchar(50) DEFAULT NULL,
  `waktu_terputus` varchar(100) DEFAULT NULL,
  `teknisi` json DEFAULT NULL,
  `lampiran` json DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `tfp_activities`
--

INSERT INTO `tfp_activities` (`id`, `kode`, `dinas`, `tanggal`, `waktu_mulai`, `waktu_selesai`, `alat`, `permasalahan`, `tindakan`, `hasil`, `status`, `waktu_terputus`, `teknisi`, `lampiran`, `created_at`, `updated_at`) VALUES
(1, 'KG-TFP-743401', 'Malam', '2025-10-08', '19:46:00', '21:45:00', 'Antena', 'aagwhgdhdhdh', 'hdfhdhdfkjd', 'dfhdfjdfjd', 'Selesai', '2 jam', '[\"Andi Julianto\", \"joko\"]', '[\"F:\\\\Project\\\\Airnav-App\\\\attachments\\\\attachment-tfp-1760894702088-89437506_p0.jpg\"]', '2025-10-09 15:47:43', '2025-10-19 17:25:02'),
(2, 'KG-TFP-703853', 'Malam', '2025-10-17', '10:25:00', '00:25:00', 'fsaf asfa sf', ' afas fasfs', 'f sfafasf asfas f', 'asf asfa  asfasf', 'Selesai', '1 jam 30 mnt', '[\"joko\", \"Andi Julianto\"]', '[\"F:\\\\Project\\\\Airnav-App\\\\attachments\\\\attachment-tfp-1760894736274-Dark Queen.png\", \"F:\\\\Project\\\\Airnav-App\\\\attachments\\\\attachment-tfp-1760894757594-uhdpaper.com-download-hd-wallpaper-1920x1080-658.0_a.jpg\", \"F:\\\\Project\\\\Airnav-App\\\\attachments\\\\attachment-tfp-1760894757598-wallpaperflare.com_wallpaper (1).jpg\", \"F:\\\\Project\\\\Airnav-App\\\\attachments\\\\attachment-tfp-1760894757644-wallpaperflare.com_wallpaper2.jpg\", \"F:\\\\Project\\\\Airnav-App\\\\attachments\\\\attachment-tfp-1761037183186-wp4346768-asus-tuf-wallpapers.jpg\", \"F:\\\\Project\\\\Airnav-App\\\\attachments\\\\attachment-tfp-1761040140728-89437506_p0.jpg\"]', '2025-10-19 17:25:36', '2025-10-21 09:49:00'),
(3, 'KG-TFP-166126', 'Siang', '2025-10-21', '15:49:00', '16:49:00', ' fa sfas fas fas fa', ' gas adasd a', ' agsas gag dsdg', 'sdgsdg sdhgs hsdh sdh s', 'Selesai', '1 jam', '[\"joko\"]', '[\"F:\\\\Project\\\\Airnav-App\\\\attachments\\\\attachment-tfp-1761040201899-kda-league-of-legends-neon-smoke-black-background-cosplay-1024x768-300.jpg\", \"F:\\\\Project\\\\Airnav-App\\\\attachments\\\\attachment-tfp-1761040201902-kda-league-of-legends-neon-smoke-black-background-cosplay-1080x2400-300.jpg\", \"F:\\\\Project\\\\Airnav-App\\\\attachments\\\\attachment-tfp-1761040201905-kda-league-of-legends-neon-smoke-black-background-cosplay-1920x1080-300.jpg\"]', '2025-10-21 09:50:01', '2025-10-21 09:50:01'),
(4, 'KG-TFP-927198', 'Siang', '2025-10-21', '16:52:00', '17:52:00', 'lkna lkaslkfa', ' ,mlksf ,asl lnas', 'las djaklsgfoia ra ', 'laks rlaosf k rl', 'Selesai', '1 jam', '[\"Andi Julianto\"]', '[\"F:\\\\Project\\\\Airnav-App\\\\attachments\\\\attachment-tfp-1761043956743-89437506_p0.jpg\"]', '2025-10-21 10:52:36', '2025-10-21 10:52:36');

-- --------------------------------------------------------

--
-- Table structure for table `tfp_equipment`
--

CREATE TABLE `tfp_equipment` (
  `id` int NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `tfp_equipment`
--

INSERT INTO `tfp_equipment` (`id`, `name`) VALUES
(1, 'Power Tx'),
(2, 'Power Rx'),
(3, 'Power Recording'),
(4, 'Power VCCS'),
(5, 'Power AMSC'),
(6, 'Power VSAT'),
(7, 'Power DVOR'),
(8, 'Power Localizer'),
(9, 'Power GP'),
(10, 'Power MM'),
(11, 'Power ARO'),
(12, 'Power MSSR'),
(13, 'Power ASMGCS'),
(14, 'Power ATC System'),
(15, 'Power PIA'),
(16, 'UPS & GENSET'),
(17, 'UPS.U1(TOPAZ): Gedung TX'),
(18, 'UPS.U3(PILLER): Gedung Radar'),
(19, 'UPS U6(DALE): Equipment Room'),
(20, 'UPS U7(DALE): Equipment Room'),
(21, 'UPS U8(GAMA): Equipment Room'),
(22, 'UPS U9(PROTECTA): Equipment Room'),
(23, 'UPS U2(PILLER): Gedung TX'),
(24, 'GENSET: Gedung Radar'),
(25, 'GENSET: Gedung DVOR'),
(26, 'AC Split Duct'),
(27, 'AC Standing Floor'),
(28, 'AC Package'),
(29, 'AC Split Wall'),
(30, 'Exhaust Fan'),
(31, 'Lift Tower'),
(32, 'Telepon'),
(33, 'Door lock'),
(34, 'CCTV'),
(35, 'Radio Trunking'),
(36, 'Ruang Kontrol ATC Tower'),
(37, 'Ruang Kontrol APP'),
(38, 'Ruang Equipment AOB'),
(39, 'Ruang Manager Teknik'),
(40, 'Ruang Managerial Teknik'),
(41, 'Ruang Standby Teknisi'),
(42, 'Ruang Istrahat APP'),
(43, 'Ruang Istrahat Tower'),
(44, 'Ruang PIA'),
(45, 'Ruang ARO'),
(46, 'Ruang AMSC'),
(47, 'Ruang CBT'),
(48, 'Ruang K2S'),
(49, 'Ruang Administrasi & Keuangan'),
(50, 'Ruang Managerial Oprasi'),
(51, 'Ruang GM & Sek GM'),
(52, 'Ruang Rapat Managerial'),
(53, 'Ruang Rapat Oprasi'),
(54, 'Ruang Rapat Teknik'),
(55, 'Koridor Lt.G,1,2'),
(56, 'Toilet Lt.G,1,2'),
(57, 'Obstacle Light'),
(58, 'Rotating Beacon'),
(59, 'Gedung Radar'),
(60, 'Gedung TX'),
(61, 'Ruang RX'),
(62, 'Shelter DVOR'),
(63, 'Shelter GP'),
(64, 'Shelter MM'),
(65, 'Shelter Localizer'),
(66, 'Lampu Sorot Papan Nama'),
(67, 'Lampu PJU Gedung Radar');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int NOT NULL,
  `username` varchar(255) NOT NULL,
  `fullname` varchar(255) DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `signature_url` text,
  `avatar_url` text,
  `phone_number` varchar(25) DEFAULT NULL,
  `role` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `fullname`, `email`, `password`, `signature_url`, `avatar_url`, `phone_number`, `role`) VALUES
(1, 'andiharper', 'Andi Julianto', 'andiharper@gmail.com', '$2b$10$u.XE6XPY9TTaW5WQiHm5xeb4qgBlcAqhsR8G5hLfYxF9JLjRaA0Pm', 'F:\\Project\\Airnav-App\\signatures\\signature-1-1761216725158.png', 'F:\\Project\\Airnav-App\\avatars\\avatar-1-1759424130061.png', '12512341241241', 'teknisi'),
(2, 'joko', 'joko', 'joko@gmail.com', '$2b$10$vqPsDmeZvP94h.PCX5fZAehPRdvA6p0AzYBaVe3ODk5EZkBYUPa/i', 'F:\\Project\\Airnav-App\\signatures\\signature-joko-1758555426365.png', NULL, NULL, 'teknisi'),
(3, 'testt', 'testttt', 'test@gmail.com', '$2b$10$VqcebjA50knin02NbjrcOOWVUthgf1D3Z7DO5puHb1sJRQHXPjPTe', 'F:\\Project\\Airnav-App\\signatures\\signature-testt-1758559721603.png', NULL, NULL, 'teknisi'),
(4, 'qweqwe', 'wqeqewe', 'eqweqwe@adawd.com', '$2b$10$PVOBK5FyYP0w003KjwFyuu9vS9.Nl5PeO8r62VoFFIv8TYICJ/EB.', 'F:\\Project\\Airnav-App\\signatures\\signature-qweqwe-1758561928129.png', NULL, NULL, 'teknisi'),
(6, 'harper', 'andijulian', 'andijuliant@gmail.com', '$2b$10$RrhsAEvMfSNTYBZPniQrb.TFrIofEHd3hDGRez3snxd/8xc3Y2bNa', 'F:\\Project\\Airnav-App\\signatures\\signature-harper-1759420227538.png', NULL, NULL, 'Supervisor'),
(7, 'andiwibowo', 'Andi WIbowo', 'andiwibowo@airnav.id', '$2b$10$F79Q0djEj/Wi7K/gvKyXeeXAS2X3iMEo4/73yUETOOrLxCDQbMxUi', 'F:\\Project\\Airnav-App\\signatures\\signature-andiwibowo-1759420342195.png', NULL, NULL, 'Manager');

-- --------------------------------------------------------

--
-- Table structure for table `workorders_cnsd`
--

CREATE TABLE `workorders_cnsd` (
  `id` int NOT NULL,
  `wo_id_custom` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `tertuju` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `shift` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `shift_dinas_nama` text COLLATE utf8mb4_general_ci,
  `tanggal` date DEFAULT NULL,
  `jam_display` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `deskripsi` text COLLATE utf8mb4_general_ci,
  `output` json DEFAULT NULL,
  `jam_mulai` time DEFAULT NULL,
  `jam_selesai` time DEFAULT NULL,
  `status_pelaksanaan` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `catatan_kendala` text COLLATE utf8mb4_general_ci,
  `usulan` text COLLATE utf8mb4_general_ci,
  `catatan_pemberi_tugas` text COLLATE utf8mb4_general_ci,
  `verify_manager` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `verify_supervisor` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `verify_pelaksana` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `workorders_cnsd`
--

INSERT INTO `workorders_cnsd` (`id`, `wo_id_custom`, `tertuju`, `shift`, `shift_dinas_nama`, `tanggal`, `jam_display`, `deskripsi`, `output`, `jam_mulai`, `jam_selesai`, `status_pelaksanaan`, `catatan_kendala`, `usulan`, `catatan_pemberi_tugas`, `verify_manager`, `verify_supervisor`, `verify_pelaksana`) VALUES
(1, 'WO-CNSD-0001', 'CNSD', 'MALAM', '1. Andi Julianto\n2. joko\n3. testttt', '2025-10-20', '19.00 - 07.00', 'dasdasdasdsa', '[]', '21:25:00', '23:25:00', NULL, 'dasdadasda whatsupp dadsa dasda', 'asda dasdas das dsa dasd hello dadasda sd', 'dadasda da dasd asf asf', '2', '6', '11'),
(2, 'WO-CNSD-0002', 'CNSD', 'SIANG', '1. Andi Julianto\n2. joko\n3. testttt', '2025-10-21', '13.00 - 19.00', 'kldkal ksk asklf a;lksf;la fa', '[]', '00:00:00', '00:00:00', NULL, ' asfafa', 'fafasfa afsf sa', 'afsasasf as ffsa ', '', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `workorders_tfp`
--

CREATE TABLE `workorders_tfp` (
  `id` int NOT NULL,
  `wo_id_custom` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `tertuju` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `shift` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `shift_dinas_nama` text COLLATE utf8mb4_general_ci,
  `tanggal` date DEFAULT NULL,
  `jam_display` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `deskripsi` text COLLATE utf8mb4_general_ci,
  `output` json DEFAULT NULL,
  `jam_mulai` time DEFAULT NULL,
  `jam_selesai` time DEFAULT NULL,
  `status_pelaksanaan` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `catatan_kendala` text COLLATE utf8mb4_general_ci,
  `usulan` text COLLATE utf8mb4_general_ci,
  `catatan_pemberi_tugas` text COLLATE utf8mb4_general_ci,
  `verify_manager` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `verify_supervisor` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `verify_pelaksana` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

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
-- Indexes for table `cnsd_activities`
--
ALTER TABLE `cnsd_activities`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cnsd_equipment`
--
ALTER TABLE `cnsd_equipment`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cnsd_savedata`
--
ALTER TABLE `cnsd_savedata`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `daily_cnsd_reports`
--
ALTER TABLE `daily_cnsd_reports`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `daily_tfp_reports`
--
ALTER TABLE `daily_tfp_reports`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

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
-- Indexes for table `schedules_cnsd`
--
ALTER TABLE `schedules_cnsd`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `schedules_tfp`
--
ALTER TABLE `schedules_tfp`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tfp_activities`
--
ALTER TABLE `tfp_activities`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tfp_equipment`
--
ALTER TABLE `tfp_equipment`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `workorders_cnsd`
--
ALTER TABLE `workorders_cnsd`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `workorders_tfp`
--
ALTER TABLE `workorders_tfp`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cnsd_activities`
--
ALTER TABLE `cnsd_activities`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `cnsd_equipment`
--
ALTER TABLE `cnsd_equipment`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=73;

--
-- AUTO_INCREMENT for table `cnsd_savedata`
--
ALTER TABLE `cnsd_savedata`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `daily_cnsd_reports`
--
ALTER TABLE `daily_cnsd_reports`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `daily_tfp_reports`
--
ALTER TABLE `daily_tfp_reports`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `schedules_cnsd`
--
ALTER TABLE `schedules_cnsd`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `schedules_tfp`
--
ALTER TABLE `schedules_tfp`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `tfp_activities`
--
ALTER TABLE `tfp_activities`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `tfp_equipment`
--
ALTER TABLE `tfp_equipment`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=68;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `workorders_cnsd`
--
ALTER TABLE `workorders_cnsd`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `workorders_tfp`
--
ALTER TABLE `workorders_tfp`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
