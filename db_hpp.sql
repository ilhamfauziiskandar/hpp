-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 15 Jan 2021 pada 13.34
-- Versi server: 10.4.13-MariaDB
-- Versi PHP: 7.3.20

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_hpp`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `barang`
--

CREATE TABLE `barang` (
  `kode_barang` varchar(5) NOT NULL,
  `nama_barang` varchar(100) NOT NULL,
  `satuan` varchar(20) NOT NULL,
  `harga` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `barang`
--

INSERT INTO `barang` (`kode_barang`, `nama_barang`, `satuan`, `harga`) VALUES
('A1013', 'Baju Navy XL', 'pcs', 26000),
('A1014', 'Baju Maroon XL', 'pcs', 26000),
('A1015', 'Polos Putih XL', 'pcs', 26000),
('A1016', 'Polos Navi XL', 'pcs', 26000),
('A1017', 'Polos Maroon XL', 'pcs', 26000),
('A1018', 'Polos Putih L', 'pcs', 25000),
('A1019', 'Polos Navi L', 'pcs', 25000),
('A1020', 'Polos Maroon L', 'pcs', 25000),
('A1021', 'Polos Putih M', 'pcs', 25000),
('A1022', 'Polos Navi M', 'pcs', 25000),
('A1023', 'Polos Maroon M', 'pcs', 25000);

-- --------------------------------------------------------

--
-- Struktur dari tabel `hpp`
--

CREATE TABLE `hpp` (
  `id_hpp` int(5) NOT NULL,
  `id_persediaan` int(5) NOT NULL,
  `date` date NOT NULL,
  `nama_hpp` varchar(100) NOT NULL,
  `pembelian` double NOT NULL,
  `retur_pembelian` double NOT NULL,
  `pot_pembelian` double NOT NULL,
  `persediaan_awal` double NOT NULL,
  `persediaan_akhir` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `hpp`
--

INSERT INTO `hpp` (`id_hpp`, `id_persediaan`, `date`, `nama_hpp`, `pembelian`, `retur_pembelian`, `pot_pembelian`, `persediaan_awal`, `persediaan_akhir`) VALUES
(10001, 20001, '2021-01-14', 'Laporan Persediaan', 3000000, 123, 333, 0, 0),
(10002, 20002, '2021-01-04', 'Laporan Persediaan', 3000000, 12333, 123, 0, 0),
(10003, 20003, '2021-01-07', 'Laporan Persediaan', 3000000, 123, 321, 0, 0),
(10004, 20004, '2021-01-09', 'Laporan Persediaan', 3000000, 3000, 30000, 0, 0),
(10005, 20005, '2021-01-01', 'Laporan Persediaan', 3000000, 333, 3, 0, 0);

-- --------------------------------------------------------

--
-- Struktur dari tabel `persediaan_barang`
--

CREATE TABLE `persediaan_barang` (
  `id_persediaan` int(5) NOT NULL,
  `id_hpp` int(5) NOT NULL,
  `kode_barang` varchar(5) NOT NULL,
  `date` date NOT NULL,
  `qty` int(100) NOT NULL,
  `masuk` int(100) NOT NULL,
  `keluar` int(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `persediaan_barang`
--

INSERT INTO `persediaan_barang` (`id_persediaan`, `id_hpp`, `kode_barang`, `date`, `qty`, `masuk`, `keluar`) VALUES
(20002, 10002, '', '2021-01-04', 0, 0, 0),
(20003, 10003, '', '2021-01-07', 0, 0, 0),
(20001, 10001, '', '2021-01-08', 0, 0, 0),
(20003, 10003, 'A1014', '2021-01-07', 2, 1, 0),
(20001, 10001, 'A1014', '2021-01-14', 1, 8, 6),
(20004, 10004, '', '2021-01-09', 0, 0, 0),
(20004, 10004, 'Rokok', '2021-01-09', 12, 0, 0),
(20004, 10004, 'Rokok', '2021-01-09', 12, 0, 0),
(20004, 10004, 'Kain ', '2021-01-09', 12, 0, 0),
(20004, 10004, 'Rokok', '2021-01-09', 22, 0, 0),
(20004, 10004, 'A1013', '2021-01-09', 12, 3, 13),
(20004, 10004, 'A1014', '2021-01-09', 22, 5, 12),
(20005, 10005, '', '2021-01-01', 0, 0, 0),
(0, 0, '', '0000-00-00', 0, 0, 0),
(20001, 10001, 'A1013', '2021-01-14', 5, 0, 0),
(20001, 10001, 'A1015', '2021-01-14', 2, 0, 0),
(20001, 10001, 'A1016', '2021-01-14', 5, 0, 0),
(20001, 10001, 'A1017', '2021-01-14', 7, 0, 0),
(20001, 10001, 'A1018', '2021-01-14', 8, 0, 0);

-- --------------------------------------------------------

--
-- Struktur dari tabel `status`
--

CREATE TABLE `status` (
  `id_status` int(1) NOT NULL,
  `nama_status` varchar(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `status`
--

INSERT INTO `status` (`id_status`, `nama_status`) VALUES
(1, 'in'),
(2, 'out'),
(3, 'restok');

-- --------------------------------------------------------

--
-- Struktur dari tabel `transaksi`
--

CREATE TABLE `transaksi` (
  `id_transaksi` int(255) NOT NULL,
  `id_persediaan` int(5) NOT NULL,
  `kode_barang` varchar(5) NOT NULL,
  `id_status` int(1) NOT NULL,
  `jumlah` int(150) NOT NULL,
  `tanggal` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `transaksi`
--

INSERT INTO `transaksi` (`id_transaksi`, `id_persediaan`, `kode_barang`, `id_status`, `jumlah`, `tanggal`) VALUES
(6, 20001, 'A1013', 1, 1, '2021-01-05'),
(7, 20001, 'A1013', 2, 1, '2021-01-05'),
(8, 20003, 'A1014', 1, 1, '2021-01-05'),
(9, 20001, 'A1014', 2, 1, '2021-01-06'),
(10, 20001, 'A1014', 1, 1, '2021-01-09'),
(11, 20001, 'A1014', 1, 2, '2021-01-09'),
(12, 20001, 'A1014', 2, 2, '2021-01-09'),
(13, 20001, 'A1014', 1, 5, '2021-01-09'),
(14, 20001, 'A1014', 2, 3, '2021-01-09'),
(15, 20004, 'A1013', 1, 3, '2021-01-09'),
(16, 20004, 'A1014', 1, 5, '2021-01-09'),
(17, 20004, 'A1013', 2, 13, '2021-01-09'),
(18, 20004, 'A1014', 2, 12, '2021-01-09');

-- --------------------------------------------------------

--
-- Struktur dari tabel `user`
--

CREATE TABLE `user` (
  `id` int(5) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `alamat` varchar(255) NOT NULL,
  `tmpt_lahir` varchar(15) NOT NULL,
  `tgl_lahir` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `user`
--

INSERT INTO `user` (`id`, `username`, `password`, `nama`, `alamat`, `tmpt_lahir`, `tgl_lahir`) VALUES
(1, 'admin', 'admin', 'Gabor Muhrer', 'Rumah', 'LA (Los Anjim)', '2020-11-30'),
(2, 'ilham', 'ilham', 'Ilham Fauzi Iskandar', 'Belum Mengisi Alamat', 'Belum Mengisi A', '0000-00-00'),
(3, 'gabor', 'gabor', 'Gabor Parker', 'Ngakost', 'Deket Rumah', '2020-11-29'),
(13, '0063546066', '123', '1233', '', '', '0000-00-00');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `barang`
--
ALTER TABLE `barang`
  ADD PRIMARY KEY (`kode_barang`);

--
-- Indeks untuk tabel `hpp`
--
ALTER TABLE `hpp`
  ADD PRIMARY KEY (`id_hpp`);

--
-- Indeks untuk tabel `transaksi`
--
ALTER TABLE `transaksi`
  ADD PRIMARY KEY (`id_transaksi`);

--
-- Indeks untuk tabel `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `hpp`
--
ALTER TABLE `hpp`
  MODIFY `id_hpp` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10029;

--
-- AUTO_INCREMENT untuk tabel `transaksi`
--
ALTER TABLE `transaksi`
  MODIFY `id_transaksi` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT untuk tabel `user`
--
ALTER TABLE `user`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
