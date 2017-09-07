-- phpMyAdmin SQL Dump
-- version 4.0.9
-- http://www.phpmyadmin.net
--
-- Inang: 127.0.0.1
-- Waktu pembuatan: 07 Sep 2017 pada 13.16
-- Versi Server: 5.6.14
-- Versi PHP: 5.5.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Basis data: `asumu`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `history_target`
--

CREATE TABLE IF NOT EXISTS `history_target` (
  `username` varchar(255) NOT NULL,
  `id_target` int(11) NOT NULL,
  KEY `username` (`username`),
  KEY `id_target` (`id_target`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur dari tabel `pengeluaran_default`
--

CREATE TABLE IF NOT EXISTS `pengeluaran_default` (
  `username` varchar(255) NOT NULL,
  `pengeluaran_desc` varchar(255) NOT NULL,
  `pengeluaran_amount` int(11) NOT NULL,
  KEY `username` (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur dari tabel `target`
--

CREATE TABLE IF NOT EXISTS `target` (
  `id_target` int(11) NOT NULL AUTO_INCREMENT,
  `target_desc` varchar(255) DEFAULT NULL,
  `target_amount` int(11) NOT NULL,
  `target_startdate` date NOT NULL,
  `target_duedate` date NOT NULL,
  `offset` int(11) NOT NULL DEFAULT '0',
  `normal_expense` int(11) NOT NULL DEFAULT '0',
  `status` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id_target`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data untuk tabel `target`
--

INSERT INTO `target` (`id_target`, `target_desc`, `target_amount`, `target_startdate`, `target_duedate`, `offset`, `normal_expense`, `status`) VALUES
(1, 'asdasdas', 1, '2017-09-04', '2017-09-13', 0, 0, 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `nama_user` varchar(255) NOT NULL,
  `penghasilan` int(11) DEFAULT NULL,
  `id_target` int(11) DEFAULT NULL,
  PRIMARY KEY (`username`),
  KEY `id_target` (`id_target`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `user`
--

INSERT INTO `user` (`username`, `password`, `nama_user`, `penghasilan`, `id_target`) VALUES
('asdasda', 'dasdasd', 'asdasdas', 1, NULL);

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `history_target`
--
ALTER TABLE `history_target`
  ADD CONSTRAINT `history_target_ibfk_1` FOREIGN KEY (`username`) REFERENCES `user` (`username`),
  ADD CONSTRAINT `history_target_ibfk_2` FOREIGN KEY (`id_target`) REFERENCES `target` (`id_target`);

--
-- Ketidakleluasaan untuk tabel `pengeluaran_default`
--
ALTER TABLE `pengeluaran_default`
  ADD CONSTRAINT `pengeluaran_default_ibfk_1` FOREIGN KEY (`username`) REFERENCES `user` (`username`);

--
-- Ketidakleluasaan untuk tabel `user`
--
ALTER TABLE `user`
  ADD CONSTRAINT `user_ibfk_1` FOREIGN KEY (`id_target`) REFERENCES `target` (`id_target`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
