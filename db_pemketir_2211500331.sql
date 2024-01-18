-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 10 Okt 2023 pada 10.00
-- Versi server: 10.4.28-MariaDB
-- Versi PHP: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_pemketir_2211500331`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `classify_2211500331`
--

CREATE TABLE `classify_2211500331` (
  `data_bersih` tinytext NOT NULL,
  `id_actual` varchar(3) DEFAULT NULL,
  `id_predicted` varchar(3) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `galert_data_2211500331`
--

CREATE TABLE `galert_data_2211500331` (
  `galert_id` varchar(300) NOT NULL DEFAULT '',
  `galert_title` tinytext DEFAULT NULL,
  `galert_link` tinytext DEFAULT NULL,
  `galert_update` tinytext DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `galert_entry_2211500331`
--

CREATE TABLE `galert_entry_2211500331` (
  `entry_id` varchar(300) NOT NULL,
  `entry_title` tinytext NOT NULL,
  `entry_link` tinytext NOT NULL,
  `entry_published` tinytext NOT NULL,
  `entry_updated` tinytext NOT NULL,
  `entry_content` tinytext NOT NULL,
  `entry_author` tinytext NOT NULL,
  `feed_id` varchar(300) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `kategori_2211500331`
--

CREATE TABLE `kategori_2211500331` (
  `id_kategori` int(11) UNSIGNED NOT NULL,
  `nm_kategori` varchar(50) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `preprocessing_2211500331`
--

CREATE TABLE `preprocessing_2211500331` (
  `entry_id` varchar(300) NOT NULL,
  `p_cf` tinytext NOT NULL,
  `p_simbol` tinytext NOT NULL,
  `p_sword` tinytext NOT NULL,
  `p_stopword` tinytext NOT NULL,
  `p_stemming` tinytext NOT NULL,
  `p_tokenisasi` tinytext NOT NULL,
  `data_bersih` tinytext NOT NULL,
  `id_kategori` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `probabilitas_kata_2211500331`
--

CREATE TABLE `probabilitas_kata_2211500331` (
  `kata` varchar(100) NOT NULL,
  `id_kategori` int(11) NOT NULL,
  `jml_data` int(11) DEFAULT 0,
  `nilai_probabilitas` float(10,10) DEFAULT 0.0000000000
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `probabilitas_kategori_2211500331`
--

CREATE TABLE `probabilitas_kategori_2211500331` (
  `id_kategori` int(11) NOT NULL,
  `jml_data` int(11) DEFAULT 0,
  `nilai_probabilitas` float(10,10) DEFAULT 0.0000000000,
  `tmp_nilai` float(10,10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `slangword_2211500331`
--

CREATE TABLE `slangword_2211500331` (
  `kata_tbaku` varchar(50) NOT NULL,
  `kata_baku` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `galert_data_2211500331`
--
ALTER TABLE `galert_data_2211500331`
  ADD PRIMARY KEY (`galert_id`);

--
-- Indeks untuk tabel `galert_entry_2211500331`
--
ALTER TABLE `galert_entry_2211500331`
  ADD PRIMARY KEY (`entry_id`);

--
-- Indeks untuk tabel `kategori_2211500331`
--
ALTER TABLE `kategori_2211500331`
  ADD PRIMARY KEY (`id_kategori`);

--
-- Indeks untuk tabel `preprocessing_2211500331`
--
ALTER TABLE `preprocessing_2211500331`
  ADD PRIMARY KEY (`entry_id`);

--
-- Indeks untuk tabel `probabilitas_kategori_2211500331`
--
ALTER TABLE `probabilitas_kategori_2211500331`
  ADD PRIMARY KEY (`id_kategori`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `kategori_2211500331`
--
ALTER TABLE `kategori_2211500331`
  MODIFY `id_kategori` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
