-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 27, 2024 at 04:12 PM
-- Server version: 8.0.30
-- PHP Version: 7.4.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `akademik`
--

-- --------------------------------------------------------

--
-- Table structure for table `absensi`
--

CREATE TABLE `absensi` (
  `id_absen` int NOT NULL,
  `jam_pelajaran` int NOT NULL,
  `keterangan` enum('Hadir','Sakit','Izin','Absen') NOT NULL,
  `id_kelas` varchar(11) NOT NULL,
  `nis` varchar(15) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `id_guru` int NOT NULL,
  `date_created` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `absensi`
--

INSERT INTO `absensi` (`id_absen`, `jam_pelajaran`, `keterangan`, `id_kelas`, `nis`, `id_guru`, `date_created`) VALUES
(574, 9, 'Hadir', '1', '201643502124', 2, '2024-01-27'),
(575, 9, 'Hadir', '1', '201643502224', 2, '2024-01-27'),
(576, 9, 'Hadir', '1', '201643502232', 2, '2024-01-27'),
(577, 9, 'Hadir', '1', '201643502250', 2, '2024-01-27'),
(578, 9, 'Absen', '1', '201643502275', 2, '2024-01-27'),
(579, 9, 'Hadir', '1', '201643502278', 2, '2024-01-27'),
(580, 9, 'Hadir', '1', '201643502296', 2, '2024-01-27'),
(581, 1, 'Hadir', '1', '201643502124', 2, '2024-01-28'),
(582, 1, 'Hadir', '1', '201643502224', 2, '2024-01-28'),
(583, 1, 'Hadir', '1', '201643502232', 2, '2024-01-28'),
(584, 1, 'Hadir', '1', '201643502250', 2, '2024-01-28'),
(585, 1, 'Absen', '1', '201643502275', 2, '2024-01-28'),
(586, 1, 'Absen', '1', '201643502278', 2, '2024-01-28'),
(587, 1, 'Absen', '1', '201643502296', 2, '2024-01-28');

-- --------------------------------------------------------

--
-- Table structure for table `guru`
--

CREATE TABLE `guru` (
  `id_guru` int NOT NULL,
  `nama` varchar(30) NOT NULL,
  `jk` enum('Pria','Wanita') NOT NULL,
  `tgl_lahir` date NOT NULL,
  `email` varchar(30) NOT NULL,
  `password` varchar(255) NOT NULL,
  `no_hp` varchar(15) NOT NULL,
  `status` enum('admin','guru') CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `guru`
--

INSERT INTO `guru` (`id_guru`, `nama`, `jk`, `tgl_lahir`, `email`, `password`, `no_hp`, `status`) VALUES
(1, 'Aditya Pramono', 'Pria', '2005-01-12', 'adit@gmail.com', '11111111', '111111111111', 'admin'),
(2, 'Isal', 'Pria', '2014-01-09', 'isal@gmail.com', '22222222', '0895564476532', 'guru'),
(8, 'bu pri', 'Wanita', '2000-02-02', 'bupri13@gmail.com', '33441122', '0987654', 'guru');

-- --------------------------------------------------------

--
-- Table structure for table `kelas`
--

CREATE TABLE `kelas` (
  `id_kelas` int NOT NULL,
  `nama_kelas` varchar(30) NOT NULL,
  `id_guru` varchar(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `kelas`
--

INSERT INTO `kelas` (`id_kelas`, `nama_kelas`, `id_guru`) VALUES
(1, 'RPL1', '2'),
(2, 'RPL2', '2'),
(17, 'RPL3', '1'),
(19, 'PS1', '1'),
(20, 'PS2', '1');

-- --------------------------------------------------------

--
-- Table structure for table `mapel`
--

CREATE TABLE `mapel` (
  `id_mapel` int NOT NULL,
  `nama_mapel` varchar(50) NOT NULL,
  `jenis_mapel` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `id_guru` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `mapel`
--

INSERT INTO `mapel` (`id_mapel`, `nama_mapel`, `jenis_mapel`, `id_guru`) VALUES
(1, 'Pemrograman Web', 'Semi Praktikum', 2),
(2, 'Matematika', 'Non Praktikum', 2),
(7, 'SEJARAH', 'SEMI PRAKTIKUM', 1),
(8, 'IPA', 'SEMI PRAKTIKUM', 1),
(9, 'SISTEM KOMPUTER', 'PRAKTIKUM', 1),
(10, 'PENJASKES', 'PRAKTIKUM', 1);

-- --------------------------------------------------------

--
-- Table structure for table `siswa`
--

CREATE TABLE `siswa` (
  `nis` varchar(15) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `nama` varchar(30) NOT NULL,
  `jk` enum('Pria','Wanita') NOT NULL,
  `tgl_lahir` date NOT NULL,
  `alamat` varchar(255) NOT NULL,
  `id_kelas` varchar(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `siswa`
--

INSERT INTO `siswa` (`nis`, `nama`, `jk`, `tgl_lahir`, `alamat`, `id_kelas`) VALUES
('201643502124', 'Nadila Safitra', 'Wanita', '2024-01-24', 'Jl condet', '1'),
('201643502125', 'Dwi Tama Aditya', 'Pria', '2019-06-02', 'Gedong', '17'),
('201643502127', 'Nadila Safitri', 'Wanita', '2019-06-01', 'Rancho Tuba', '17'),
('201643502130', 'Shafira Puri Haliza', 'Pria', '2019-06-03', 'Padang Mahsyar', '17'),
('201643502131', 'Eko Purnomo ', 'Pria', '2019-06-04', 'Padang Parimanan', '2'),
('201643502132', 'Mirna Miranda', 'Wanita', '2019-06-05', 'Gedong', '2'),
('201643502133', 'Alfian Prakoso', 'Wanita', '2019-06-06', 'Rancho', '2'),
('201643502218', 'Irfan Yusuf Prayugo', 'Pria', '1998-07-05', 'Jl. Raya Gedong', '2'),
('201643502220', 'Pradita Sinta Dewi ', 'Wanita', '2019-06-01', 'Jl. PKP 2\r\n\r\n', '2'),
('201643502224', 'Dimas Ishlah Saputra', 'Pria', '2019-06-02', 'Cibinong', '1'),
('201643502227', 'Andikha Dian Nugraha', 'Pria', '2018-02-13', 'Gg Macho', '19'),
('201643502228', 'Moh. Irvan Nendra', 'Pria', '2019-06-03', 'Bojong', ''),
('201643502229', 'Indi Muthiah', 'Wanita', '2019-06-04', 'Tanjung Barat', ''),
('201643502230', 'Isnaini Muthiah', 'Wanita', '2019-06-05', 'Kokas', ''),
('201643502232', 'Azri Akmal', 'Pria', '2019-06-12', 'Jl Munjul', '1'),
('201643502235', 'Moh. Rifqi Subchan', 'Pria', '2019-06-06', 'Cinere Depok', '17'),
('201643502239', 'Wildan', 'Pria', '2019-06-07', 'Cileungsi', '2'),
('201643502250', 'Rayhan Warsito', 'Pria', '2019-06-08', 'Tambun', '1'),
('201643502252', 'Bianco Akbar Firdhaus', 'Pria', '2019-06-09', 'Kalibata City', ''),
('201643502275', 'Dita Rizky Ananda', 'Wanita', '2019-06-10', 'Depok ', '1'),
('201643502277', 'Devi Novianti', 'Wanita', '2019-06-11', 'Depok II', ''),
('201643502278', 'Reyfa Refian', 'Pria', '2019-06-12', 'Depok II', '1'),
('201643502294', 'Mahesa Alwi Sumaja Nabila', 'Pria', '2019-06-14', 'Rawi Geni', ''),
('201643502296', 'Faris Al Fathin', 'Pria', '2019-06-15', 'Depok Skate Park', '1'),
('201643502297', 'Linda Ramadhani', 'Wanita', '1998-06-04', 'Jl Condet', '002'),
('201643502301', 'Ravi Zarazka Putra', 'Pria', '2019-06-16', 'Tangerang City', '002'),
('201643502302', 'Muhammad Syaiful Yahya', 'Pria', '2019-06-03', 'Jl Depok', '002'),
('345566987', 'Muhammad Adhim Niokagi', 'Pria', '2024-01-24', 'Jetis', '17'),
('666999763', 'Agaminston', 'Pria', '2024-01-24', 'Hamburg', '17'),
('888328383', 'Isal Nugroho', 'Pria', '2005-10-11', 'Pulorejo', '17');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `absensi`
--
ALTER TABLE `absensi`
  ADD PRIMARY KEY (`id_absen`),
  ADD KEY `id_kelas` (`id_kelas`),
  ADD KEY `npm` (`nis`),
  ADD KEY `id_guru` (`id_guru`);

--
-- Indexes for table `guru`
--
ALTER TABLE `guru`
  ADD PRIMARY KEY (`id_guru`);

--
-- Indexes for table `kelas`
--
ALTER TABLE `kelas`
  ADD PRIMARY KEY (`id_kelas`),
  ADD KEY `id_dosen` (`id_guru`);

--
-- Indexes for table `mapel`
--
ALTER TABLE `mapel`
  ADD PRIMARY KEY (`id_mapel`),
  ADD KEY `id_dosen` (`id_guru`);

--
-- Indexes for table `siswa`
--
ALTER TABLE `siswa`
  ADD PRIMARY KEY (`nis`),
  ADD KEY `id_kelas` (`id_kelas`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `absensi`
--
ALTER TABLE `absensi`
  MODIFY `id_absen` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=609;

--
-- AUTO_INCREMENT for table `guru`
--
ALTER TABLE `guru`
  MODIFY `id_guru` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `kelas`
--
ALTER TABLE `kelas`
  MODIFY `id_kelas` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `mapel`
--
ALTER TABLE `mapel`
  MODIFY `id_mapel` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
