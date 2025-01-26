-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 26, 2025 at 09:26 AM
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
-- Database: `db_absensi`
--

-- --------------------------------------------------------

--
-- Table structure for table `dt_karyawan`
--

CREATE TABLE `dt_karyawan` (
  `NPK` varchar(50) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `jabatan` varchar(100) NOT NULL,
  `alamat` text NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` varchar(50) DEFAULT 'dt_karyawan',
  `foto` longblob DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `dt_karyawan`
--

INSERT INTO `dt_karyawan` (`NPK`, `nama`, `jabatan`, `alamat`, `password`, `role`, `foto`) VALUES
('0000000000', 'Kasmuri rinanto', 'management', 'dusun ngraho', '$2y$10$wceOuvFtk1rvaTIHbTyhfu5X3sxChOTK0KiW1S2oiHaAaDb3NOBzm', 'user', 0x64656661756c742d6176617461722e6a7067),
('1111111111', 'dausss', 'polisi hutan', 'desa kampunkan', '$2y$10$HNPnBT7zIFORazVQmihaGeo3TFd4QRDRP0O6th1.6fDuINrNYoq9O', 'user', 0x313131313131313131312e6a7067),
('2222222222', 'jasminto.SH,', 'keuangan', 'jalan ahmad gadul,ponegoro', '$2y$10$Tbku1tKJJFyiN9s5G3GgDuhcS706Fl9ely/jjvtfKxAzrDFmgIYsO', 'user', 0x64656661756c742d6176617461722e6a7067),
('3333333333', 'sakidi sajuahikakilima', 'tukang las karbit', 'kidulan jaya ryaa', '$2y$10$0UrivxMS74z18U.R3DGhG..n9ZEc6ZDr2G7zriKTGJXAkKXX7hFX.', 'user', 0x333333333333333333332e6a7067),
('4444444444', 'kasenii binti jayus', 'dapur', 'ngarrp omah', '$2y$10$Ja1vsS.3prAldkiZdkQvFeHvE//HEsWWwDTEDBxS345Pd6AKSpG8K', 'user', 0x64656661756c742d6176617461722e6a7067),
('5555555555', 'Rasya saputro monjalik', 'ketua kantor', 'desa pelem kec.purwosari ', '$2y$10$8k6t1JiVC/oPgKazXFWmIe3fr2PldcNYECyf1k1wDkWJqvZJ75Njm', 'user', 0x64656661756c742d6176617461722e6a7067),
('6666666666', 'tarmuji', 'pengelola bahan jual', 'desa pelem', '$2y$10$DM7W1g4ie865reBCALOb6uGN7qvvbvCWfxVfonHLo/qXaiNHFLEGG', 'user', 0x363636363636363636362e706e67),
('7777777777', 'jodi hermawannn st', 'pedagang kaku lima', 'ngrejeng jaya', '$2y$10$ar5Wv82baKsKkYA9k4X9hOzSCJZ7RbeSrQ4WI.blWaIOsUJXUtXja', 'user', 0x64656661756c742d6176617461722e6a7067),
('8888888888', 'mahmud suyuti.skom', 'IT server', 'dusun ngledekan ', '$2y$10$L5RsAwhvzEEr3cJpnUNIa.j8tJYzCD7S6EWnAF/lBW8mlT9YhIHVO', 'user', 0x64656661756c742d6176617461722e6a7067);

-- --------------------------------------------------------

--
-- Table structure for table `tb_absensi`
--

CREATE TABLE `tb_absensi` (
  `id` int(11) NOT NULL,
  `NPK` bigint(20) DEFAULT NULL,
  `tanggal` date NOT NULL DEFAULT curdate(),
  `keterangan` enum('Hadir','Izin','Sakit','Tanpa Keterangan') NOT NULL,
  `waktu_absen` timestamp NOT NULL DEFAULT current_timestamp(),
  `nama_karyawan` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tb_absensi`
--

INSERT INTO `tb_absensi` (`id`, `NPK`, `tanggal`, `keterangan`, `waktu_absen`, `nama_karyawan`) VALUES
(72, 3333333333, '2025-01-26', 'Izin', '2025-01-26 06:22:16', 'sakidi sajuahikakilima');

-- --------------------------------------------------------

--
-- Table structure for table `tb_admin`
--

CREATE TABLE `tb_admin` (
  `id` int(11) NOT NULL,
  `NPK` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `nama` varchar(100) DEFAULT NULL,
  `role` varchar(20) DEFAULT 'admin'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tb_admin`
--

INSERT INTO `tb_admin` (`id`, `NPK`, `password`, `nama`, `role`) VALUES
(1, '121104', 'admin', 'Admin Name', 'admin');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `dt_karyawan`
--
ALTER TABLE `dt_karyawan`
  ADD PRIMARY KEY (`NPK`);

--
-- Indexes for table `tb_absensi`
--
ALTER TABLE `tb_absensi`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tb_admin`
--
ALTER TABLE `tb_admin`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tb_absensi`
--
ALTER TABLE `tb_absensi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=73;

--
-- AUTO_INCREMENT for table `tb_admin`
--
ALTER TABLE `tb_admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
