-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 14 Jan 2025 pada 08.55
-- Versi server: 10.4.28-MariaDB
-- Versi PHP: 8.0.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `perpus-unma`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `buku`
--

CREATE TABLE `buku` (
  `BukuID` int(11) NOT NULL,
  `Judul` varchar(255) NOT NULL,
  `Penulis` varchar(255) NOT NULL,
  `Penerbit` varchar(255) NOT NULL,
  `TahunTerbit` int(11) NOT NULL,
  `JumlahBuku` varchar(3) NOT NULL,
  `ISBN` varchar(17) NOT NULL,
  `Gambar` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `buku`
--

INSERT INTO `buku` (`BukuID`, `Judul`, `Penulis`, `Penerbit`, `TahunTerbit`, `JumlahBuku`, `ISBN`, `Gambar`) VALUES
(19, 'HTML & CSS: Design and Build Websites', 'Jon Duckett', 'Wiley', 2011, '9', '1928374651', 'buku_671c4752a186c.jpeg'),
(20, 'Learning PHP, MySQL & JavaScript', 'Robin Nixon', 'OReilly Media', 2017, '6', '1928374652', 'buku_671c48158f344.jpeg'),
(21, 'JavaScript: The Definitive Guide', 'David Flanagan', 'OReilly Media', 2020, '3', '1928374653', 'buku_671c498ba58db.jpeg'),
(22, 'Automate the Boring Stuff with Python', 'AI Sweigart', 'No Starch Press', 2015, '4', '1928374654', 'buku_671c49f2c80a3.jpeg'),
(23, 'Bahasa Inggris: English Grammar in Use', 'Raymond Murphy', 'Cambridge University Press', 2019, '6', '1928374655', 'buku_671c4bad30ba1.jpeg'),
(24, 'Bahasa Inggris: Fluent English', 'Barbara Raifsnider', 'Oxford University Press', 2006, '3', '1928374656', 'buku_671c4c21abc53.jpeg'),
(33, 'Bahasa Jepang: Norwegian Wood', 'Haruki Murakami', 'Harvill Secker', 2000, '3', '1928374657', 'buku_6722bdf52afa9.jpeg'),
(34, 'Head First HTML and CSS', 'Elisabeth Robson & Eric Freeman', 'OReilly Media', 2007, '7', '1928374658', 'buku_6722bf2cdf859.jpeg'),
(35, 'Modern PHP: New Features and Good Practices', 'Josh Lockhart', 'Leanpub', 2015, '2', '1928374659', 'buku_6722bf81987e5.jpeg'),
(36, 'Eloquent JavaScript', 'Marijn Haverbeke', 'No Starch Press', 2018, '3', '19283746510', 'buku_6722bfd13a676.jpeg'),
(37, 'Python Data Science Handbook', 'Jake VanderPlas', 'OReilly Media', 2016, '3', '19283746511', 'buku_6722c01f37699.jpeg'),
(38, 'Calculus: Early Transcendentals', 'James Stewart', 'Cengage Learning', 2015, '8', '19283746512', 'buku_67230a9b3daf2.jpeg'),
(39, 'Understanding Logarithms', 'Richard Rusczyk', 'Art of Problem Solving', 2012, '5', '19283746513', 'buku_67230ae79671b.jpeg');

-- --------------------------------------------------------

--
-- Struktur dari tabel `daftar_hadir`
--

CREATE TABLE `daftar_hadir` (
  `id` int(11) NOT NULL,
  `NPM` varchar(11) NOT NULL,
  `NamaLengkap` varchar(255) NOT NULL,
  `Prodi` enum('Informatika','Teknik Sipil','Teknik Mesin','Teknik Industri') NOT NULL,
  `Angkatan` enum('2020/2021','2021/2022','2022/2023','2023/2024','2024/2025') NOT NULL,
  `Keperluan` enum('Membaca Buku','Meminjam Buku','Mengerjakan Tugas','Keperluan Lainnya') NOT NULL,
  `TimeStamp` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `daftar_hadir`
--

INSERT INTO `daftar_hadir` (`id`, `NPM`, `NamaLengkap`, `Prodi`, `Angkatan`, `Keperluan`, `TimeStamp`) VALUES
(2, '1029384726', 'Nurul Hamim', 'Informatika', '2022/2023', 'Membaca Buku', '2024-11-28 06:15:50'),
(3, '2147483647', 'Muhammad Malik Maulana', 'Teknik Mesin', '2022/2023', 'Mengerjakan Tugas', '2024-11-28 07:44:57'),
(4, '2147483647', 'Dery', 'Teknik Industri', '2022/2023', 'Membaca Buku', '2024-11-29 07:07:48'),
(5, '293847281', 'Kenryu', 'Teknik Sipil', '2021/2022', 'Meminjam Buku', '2024-11-29 07:16:42'),
(6, '232141244', 'asdasd', 'Teknik Mesin', '2022/2023', 'Keperluan Lainnya', '2024-11-29 07:20:21'),
(7, '1029384726', 'Malik Maulana', 'Teknik Sipil', '2024/2025', 'Meminjam Buku', '2024-12-10 07:35:55'),
(8, '2932839423', 'Kenryu', 'Informatika', '2020/2021', 'Keperluan Lainnya', '2024-12-11 03:43:02'),
(9, '1928374625', 'Arifin Ilham', 'Informatika', '2021/2022', 'Keperluan Lainnya', '2025-01-06 02:06:47');

-- --------------------------------------------------------

--
-- Struktur dari tabel `kategoribuku`
--

CREATE TABLE `kategoribuku` (
  `KategoriID` int(11) NOT NULL,
  `NamaKategori` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `kategoribuku`
--

INSERT INTO `kategoribuku` (`KategoriID`, `NamaKategori`) VALUES
(9, 'Pemrograman HTML'),
(10, 'Pemrograman PHP'),
(11, 'Pemrograman JavaScript'),
(12, 'Pemrograman Python'),
(18, 'Bahasa'),
(20, 'Logaritma'),
(22, 'Sports');

-- --------------------------------------------------------

--
-- Struktur dari tabel `kategoribuku_relasi`
--

CREATE TABLE `kategoribuku_relasi` (
  `KategoriBukuID` int(11) NOT NULL,
  `BukuID` int(11) NOT NULL,
  `KategoriID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `kategoribuku_relasi`
--

INSERT INTO `kategoribuku_relasi` (`KategoriBukuID`, `BukuID`, `KategoriID`) VALUES
(18, 19, 9),
(19, 20, 10),
(20, 21, 11),
(21, 22, 12),
(22, 23, 18),
(23, 24, 18),
(32, 33, 18),
(33, 34, 9),
(34, 35, 10),
(35, 36, 11),
(36, 37, 12),
(37, 38, 20),
(38, 39, 20);

-- --------------------------------------------------------

--
-- Struktur dari tabel `koleksipribadi`
--

CREATE TABLE `koleksipribadi` (
  `KoleksiID` int(11) NOT NULL,
  `UserID` int(11) NOT NULL,
  `BukuID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `koleksipribadi`
--

INSERT INTO `koleksipribadi` (`KoleksiID`, `UserID`, `BukuID`) VALUES
(12, 6, 19),
(10, 6, 23),
(9, 15, 38),
(11, 22, 36);

-- --------------------------------------------------------

--
-- Struktur dari tabel `peminjaman`
--

CREATE TABLE `peminjaman` (
  `PeminjamanID` int(11) NOT NULL,
  `UserID` int(11) NOT NULL,
  `BukuID` int(11) NOT NULL,
  `TanggalPeminjaman` date NOT NULL,
  `TanggalPengembalian` date NOT NULL,
  `JumlahBuku` varchar(3) NOT NULL,
  `StatusPeminjaman` enum('pinjam','dikembalikan','pending') NOT NULL DEFAULT 'pending',
  `Created` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `peminjaman`
--

INSERT INTO `peminjaman` (`PeminjamanID`, `UserID`, `BukuID`, `TanggalPeminjaman`, `TanggalPengembalian`, `JumlahBuku`, `StatusPeminjaman`, `Created`) VALUES
(42, 15, 21, '2024-12-11', '2025-01-14', '1', 'pinjam', '2024-12-11 04:14:26'),
(47, 21, 19, '2024-12-18', '2025-01-14', '1', 'pinjam', '2024-12-18 06:20:31'),
(56, 6, 19, '2024-12-23', '2025-01-07', '1', 'dikembalikan', '2024-12-23 03:45:44'),
(57, 6, 38, '2024-12-23', '2025-01-11', '1', 'dikembalikan', '2025-01-11 03:29:04'),
(59, 21, 33, '2024-12-23', '2024-12-29', '1', 'dikembalikan', '2024-12-23 07:29:19'),
(60, 22, 39, '2024-12-23', '2025-01-13', '1', 'pinjam', '2024-12-23 07:47:55'),
(63, 6, 36, '2024-12-24', '2025-01-13', '1', 'pinjam', '2024-12-24 02:48:58'),
(68, 6, 35, '2025-01-11', '2025-01-17', '1', 'pinjam', '2025-01-11 03:35:00');

-- --------------------------------------------------------

--
-- Struktur dari tabel `ulasanbuku`
--

CREATE TABLE `ulasanbuku` (
  `UlasanID` int(11) NOT NULL,
  `UserID` int(11) NOT NULL,
  `BukuID` int(11) NOT NULL,
  `Ulasan` text NOT NULL,
  `Rating` int(11) NOT NULL,
  `Created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `ulasanbuku`
--

INSERT INTO `ulasanbuku` (`UlasanID`, `UserID`, `BukuID`, `Ulasan`, `Rating`, `Created_at`) VALUES
(16, 6, 19, 'Mantap', 8, '2024-12-02 02:49:35'),
(17, 15, 36, 'Bagus buat logika dasar JavaScript', 8, '2024-12-06 03:52:54'),
(18, 21, 19, 'Basdjaksjd  jaijd jasjfk jaksjfkj aksflk hashfk hashfkj hajshf jhajs hfjhasj hfjahs jfhjash fjhasj hfjhasj fhjahs jfhjsah fjakljsflkjalksjf kljaksj fkjsak jfhajh advj kjsvjnj vjnjd nkjnsajd nvjands jvnsajd nvjas jvnjsd vjnas jvdnjsand vjsdav njnsajdv njsand jvnajsd nvjsan jvasj nvdjsavj sajd vjsa', 10, '2024-12-19 04:05:37'),
(19, 22, 35, 'Yahhhuuuuuuuuu', 9, '2024-12-20 07:09:30');

-- --------------------------------------------------------

--
-- Struktur dari tabel `user`
--

CREATE TABLE `user` (
  `UserID` int(11) NOT NULL,
  `Username` varchar(255) NOT NULL,
  `Password` varchar(255) NOT NULL,
  `NPM` int(11) NOT NULL,
  `Email` varchar(255) NOT NULL,
  `NamaLengkap` varchar(255) NOT NULL,
  `Alamat` text NOT NULL,
  `Role` enum('user','petugas','admin') DEFAULT 'user',
  `status` enum('unactive','active') DEFAULT 'unactive',
  `Gambar` varchar(255) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `user`
--

INSERT INTO `user` (`UserID`, `Username`, `Password`, `NPM`, `Email`, `NamaLengkap`, `Alamat`, `Role`, `status`, `Gambar`, `created_at`) VALUES
(3, 'akas', '$2y$10$jsA8KFOjUGpE1y4uTwtoZe2r4kDqSxXChQprDZlBOdJbd2mKN3f3q', 1192837482, 'akas@gmail.com', 'Akas Muhamad Pirdaus', 'Ciomas', 'admin', 'active', 'kas.jpg', '2024-10-18 21:08:00'),
(4, 'gilang', '$2y$10$I3Zpnq2IgrvmJy7Bj78iwOsTzkw64l2v/SUGrVp1VlEK2yQBpLHMO', 1192837936, 'gilang@gmail.com', 'Gilang Rahmat Firdaus', 'Cikaracak', 'petugas', 'active', 'gi.jpg', '2024-10-18 21:08:00'),
(6, 'malik', '$2y$10$Kx.Q0IIquhuhqjZC/XoxjOoHrHPCbZibkqVcFzw4jdaU0KaR/M9Qi', 1923892838, 'malik@gmail.com', 'Muhamad Malik Maulana', 'Mekarwangi', 'user', 'active', 'mal.jpg', '2024-10-19 07:15:12'),
(15, 'hamim', '$2y$10$xdVPKPGuQy7eUwpr4oxey.jFRm72p0Kmk2FOpJ5BnC.X25J3GaKby', 1928372632, 'nurulhamim@gmail.com', 'Nurul Hamim', 'Cimara', 'user', 'active', 'ham.jpg', '2024-12-02 13:36:38'),
(21, 'billal', '$2y$10$qfXUe4GtADUtn4bN.6NlNOAstCX7wRgPL2UygOvvlN/zFzVaqdE7C', 1829372651, 'billal@gmail.com', 'Billal Fauzan', 'Maja', 'user', 'active', 'bil.jpg', '2024-12-04 10:22:47'),
(22, 'dery', '$2y$10$bMAu/2oeZOmEeOrkx3oWSe.JO8Kppd6aTPr9Whq6cL.2WGTwZoGJy', 1928304837, 'dery@gmail.com', 'Dery purn', 'Pasangrahan', 'user', 'active', 'dery.jpg', '2024-12-20 13:51:11');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `buku`
--
ALTER TABLE `buku`
  ADD PRIMARY KEY (`BukuID`);

--
-- Indeks untuk tabel `daftar_hadir`
--
ALTER TABLE `daftar_hadir`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `kategoribuku`
--
ALTER TABLE `kategoribuku`
  ADD PRIMARY KEY (`KategoriID`);

--
-- Indeks untuk tabel `kategoribuku_relasi`
--
ALTER TABLE `kategoribuku_relasi`
  ADD PRIMARY KEY (`KategoriBukuID`),
  ADD KEY `BukuID` (`BukuID`),
  ADD KEY `KategoriID` (`KategoriID`);

--
-- Indeks untuk tabel `koleksipribadi`
--
ALTER TABLE `koleksipribadi`
  ADD PRIMARY KEY (`KoleksiID`),
  ADD KEY `UserID` (`UserID`,`BukuID`),
  ADD KEY `BukuID` (`BukuID`);

--
-- Indeks untuk tabel `peminjaman`
--
ALTER TABLE `peminjaman`
  ADD PRIMARY KEY (`PeminjamanID`),
  ADD KEY `UserID` (`UserID`,`BukuID`),
  ADD KEY `BukuID` (`BukuID`);

--
-- Indeks untuk tabel `ulasanbuku`
--
ALTER TABLE `ulasanbuku`
  ADD PRIMARY KEY (`UlasanID`),
  ADD KEY `UserID` (`UserID`,`BukuID`),
  ADD KEY `BukuID` (`BukuID`);

--
-- Indeks untuk tabel `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`UserID`),
  ADD UNIQUE KEY `Username` (`Username`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `buku`
--
ALTER TABLE `buku`
  MODIFY `BukuID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT untuk tabel `daftar_hadir`
--
ALTER TABLE `daftar_hadir`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT untuk tabel `kategoribuku`
--
ALTER TABLE `kategoribuku`
  MODIFY `KategoriID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT untuk tabel `kategoribuku_relasi`
--
ALTER TABLE `kategoribuku_relasi`
  MODIFY `KategoriBukuID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT untuk tabel `koleksipribadi`
--
ALTER TABLE `koleksipribadi`
  MODIFY `KoleksiID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT untuk tabel `peminjaman`
--
ALTER TABLE `peminjaman`
  MODIFY `PeminjamanID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=69;

--
-- AUTO_INCREMENT untuk tabel `ulasanbuku`
--
ALTER TABLE `ulasanbuku`
  MODIFY `UlasanID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT untuk tabel `user`
--
ALTER TABLE `user`
  MODIFY `UserID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `kategoribuku_relasi`
--
ALTER TABLE `kategoribuku_relasi`
  ADD CONSTRAINT `kategoribuku_relasi_ibfk_1` FOREIGN KEY (`BukuID`) REFERENCES `buku` (`BukuID`),
  ADD CONSTRAINT `kategoribuku_relasi_ibfk_2` FOREIGN KEY (`KategoriID`) REFERENCES `kategoribuku` (`KategoriID`);

--
-- Ketidakleluasaan untuk tabel `koleksipribadi`
--
ALTER TABLE `koleksipribadi`
  ADD CONSTRAINT `koleksipribadi_ibfk_1` FOREIGN KEY (`UserID`) REFERENCES `user` (`UserID`),
  ADD CONSTRAINT `koleksipribadi_ibfk_2` FOREIGN KEY (`BukuID`) REFERENCES `buku` (`BukuID`);

--
-- Ketidakleluasaan untuk tabel `peminjaman`
--
ALTER TABLE `peminjaman`
  ADD CONSTRAINT `peminjaman_ibfk_1` FOREIGN KEY (`BukuID`) REFERENCES `buku` (`BukuID`),
  ADD CONSTRAINT `peminjaman_ibfk_2` FOREIGN KEY (`UserID`) REFERENCES `user` (`UserID`);

--
-- Ketidakleluasaan untuk tabel `ulasanbuku`
--
ALTER TABLE `ulasanbuku`
  ADD CONSTRAINT `ulasanbuku_ibfk_1` FOREIGN KEY (`BukuID`) REFERENCES `buku` (`BukuID`),
  ADD CONSTRAINT `ulasanbuku_ibfk_2` FOREIGN KEY (`UserID`) REFERENCES `user` (`UserID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
