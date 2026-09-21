-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Waktu pembuatan: 23 Bulan Mei 2026 pada 14.20
-- Versi server: 11.8.6-MariaDB-log
-- Versi PHP: 7.2.34

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `u137138991_pkk`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `animals`
--

CREATE TABLE `animals` (
  `id` int(11) NOT NULL,
  `uuid` char(36) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `name` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `beritas`
--

CREATE TABLE `beritas` (
  `id` int(11) NOT NULL,
  `image` text NOT NULL,
  `judul` varchar(255) NOT NULL,
  `deskripsi` text NOT NULL,
  `file` varchar(255) DEFAULT NULL,
  `updated_at` timestamp(6) NULL DEFAULT NULL,
  `created_at` timestamp(6) NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `beritas`
--

INSERT INTO `beritas` (`id`, `image`, `judul`, `deskripsi`, `file`, `updated_at`, `created_at`) VALUES
(90, 'Kebakaran.jpeg', 'ditinggal sembahyang dapur, tempat tidur warga desa nglawak terbakar', '\"Yang mengetahui pertama kali adalah warga sekitar yang kebetulan lewat. Api sudah berkobar cukup tinggi sehingga warga tidak bisa berbuat banyak,\" kata Wastika, Sabtu petang.\r\n\r\nWaskita menuturkan jarak antara satu rumah dengan rumah yang lainnya cukup berjauhan. Sehingga, kebakaran baru diketahui setelah api membesar.\r\n\r\nIa menjelaskan kebakaran tersebut sempat dilaporkan ke Dinas Pemadam Kebakaran dan Penyelamatan (Damkartan) Kabupaten Nganjuk. Hanya saja, api sudah bisa dipadamkan oleh warga sekitar saat petugas Damkartan tiba di lokasi kejadian.', NULL, '2023-06-12 10:34:12.000000', '2023-06-12 10:34:12.000000'),
(91, 'kereta_1.jpg', 'longsor di patianrowo putus akses jalan tol', 'Menurut Janwar, warga setempat yang ingin keluar dari Desa Kunyi terpaksa berjalan kaki menyusuri sungai jika sedang surut atau bertaruh nyawa menapaki material longsor yang memutus jalan.', NULL, '2023-06-12 10:37:08.000000', '2023-06-12 10:37:08.000000'),
(92, 'WhatsApp-Image-2020-04-12-at-14.30.32-compressor1.jpeg', '120 orang mengungsi akibat banjirrr', 'Seperti dilaporkan AFP, hujan deras pada awal pekan ini telah menewaskan 14 orang. Banjir juga mengubah jalan-jalan di kota-kota wilayah Emilia Romagna menjadi sungai. Dan, karena intensitas hujan kian deras, otoritas regional memperpanjang peringatan cuaca merah hingga Minggu (21/5/2023).', 'ANDRY ANDARU 155100006 Section Class Content Via OSF Lecture Arie Setya Putra-1 (1).pdf', '2023-07-05 18:41:11.000000', '2023-06-12 10:37:50.000000');

-- --------------------------------------------------------

--
-- Struktur dari tabel `detail_pokja`
--

CREATE TABLE `detail_pokja` (
  `id_detail_pokja` varchar(50) NOT NULL,
  `bidang1` varchar(50) NOT NULL,
  `bidang2` varchar(50) NOT NULL,
  `bidang3` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data untuk tabel `detail_pokja`
--

INSERT INTO `detail_pokja` (`id_detail_pokja`, `bidang1`, `bidang2`, `bidang3`) VALUES
('pokja1', 'Penghayatan dan Pancasila', 'Gotong Royong', '0'),
('pokja2', 'Pendidikan dan Ketrampilan', 'Pengembangan Kehidupan Berkoperasi', '0'),
('pokja3', 'Pangan ', 'Sandang', 'Perumahan'),
('pokja4', 'Kesehatan', 'Kelestarian', 'Perencanaan');

-- --------------------------------------------------------

--
-- Struktur dari tabel `galerys`
--

CREATE TABLE `galerys` (
  `id` int(10) UNSIGNED NOT NULL,
  `uuid` char(36) NOT NULL,
  `id_user` int(11) NOT NULL,
  `deskripsi` text NOT NULL,
  `lokasi` varchar(255) DEFAULT NULL,
  `latitude` double DEFAULT NULL,
  `longitude` double DEFAULT NULL,
  `gambar` text NOT NULL,
  `pokja` varchar(50) NOT NULL,
  `bidang` varchar(50) NOT NULL,
  `status` varchar(50) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `id_role` int(11) NOT NULL,
  `id_organization` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `galerys`
--

INSERT INTO `galerys` (`id`, `uuid`, `id_user`, `deskripsi`, `lokasi`, `latitude`, `longitude`, `gambar`, `pokja`, `bidang`, `status`, `created_at`, `updated_at`, `id_role`, `id_organization`) VALUES
(50, 'GAL-47CSWA', 16, 'poihh', 'Kauman, Kecamatan Nganjuk', -7.5948137, 111.8953906, '6a0c198bcb4fd_1000417135.jpg', 'Bidang Umum', 'Laporan Umum', 'Upload', '2026-05-19 01:04:27', '2026-05-19 01:06:01', 1, 5),
(57, 'GAL-KWWQVA', 19, 'Peringatan Hari Kartini', 'Gedung PKK', NULL, NULL, '6a0ed960b2509_scaled_1000467077.jpg', 'Kader Pokja I', 'Penghayatan & Pengamalan Pancasila', 'upload2', '2026-05-21 10:07:28', '2026-05-21 10:09:03', 1, 1),
(58, 'GAL-LPAMB8', 19, 'Requirement Bersama Polije', 'Gedung PKK', NULL, NULL, '6a0edaf8e07f2_scaled_1000467078.jpg', 'Kader Pokja I', 'Penghayatan & Pengamalan Pancasila', 'upload2', '2026-05-21 10:14:16', '2026-05-21 10:15:07', 1, 1),
(59, 'GAL-JZR5C0', 19, 'Sosialisasi Bersama PKK', 'SMK PGRI 2 NGANJUK', NULL, NULL, '6a0edbf3e64e5_scaled_1000467076.jpg', 'Kader Pokja I', 'Penghayatan & Pengamalan Pancasila', 'upload2', '2026-05-21 10:18:27', '2026-05-21 10:27:21', 1, 1),
(60, 'GAL-XNISE1', 19, 'Kegiatan Bersama', 'Nganjuk', NULL, NULL, '6a0edc857db7b_scaled_1000467075.jpg', 'Kader Pokja I', 'Kader Pokja I', 'upload2', '2026-05-21 10:20:53', '2026-05-21 10:27:32', 1, 1),
(61, 'GAL-5EBVGW', 19, 'Sosialisasi Pembekalan Kader', 'Gedung PKK', NULL, NULL, '6a0edcbfbdfa9_scaled_1000467073.jpg', 'Kader Pokja I', 'Kader Pokja I', 'upload2', '2026-05-21 10:21:51', '2026-05-21 10:27:36', 1, 1),
(62, 'GAL-QIAWJC', 29, 'coba', 'Kauman, Kecamatan Nganjuk', -7.59381, 111.8952254, '6a118928190b4_scaled_1000466105.jpg', 'Kader Pokja II', 'Pendidikan & Ketrampilan', 'Proses', '2026-05-23 11:02:00', '2026-05-23 11:02:00', 1, 2),
(63, 'GAL-RCTINI', 2, 'hahay', 'Kauman, Kecamatan Nganjuk', -7.5937914, 111.895225, '6a118b6e77c60_scaled_1000469064.jpg', 'Kader Pokja I', 'Kader Pokja I', 'Proses', '2026-05-23 11:11:42', '2026-05-23 11:11:42', 2, 1),
(64, 'GAL-TL0EC7', 7, 'bayu', 'Kauman, Kecamatan Nganjuk', -7.593797, 111.8952458, '6a118ee1f2327_scaled_1000469064.jpg', 'Kader Pokja II', 'Pendidikan & Ketrampilan', 'upload1', '2026-05-23 11:26:25', '2026-05-23 11:26:35', 1, 2),
(65, 'GAL-RDFMAV', 7, 'bayu', 'Kauman, Kecamatan Nganjuk', -7.5937963, 111.8952413, '6a118f09da631_scaled_1000469064.jpg', 'Kader Pokja II', 'Pengembangan Kehidupan Berkoperasi', 'upload1', '2026-05-23 11:27:05', '2026-05-23 11:27:18', 1, 2),
(66, 'GAL-VU0QBR', 29, 'test', 'Kauman, Kecamatan Nganjuk', -7.5938104, 111.89525, '6a11908a24439_scaled_1000468831.jpg', 'Kader Pokja II', 'Pendidikan & Ketrampilan', 'Proses', '2026-05-23 11:33:30', '2026-05-23 11:33:30', 1, 2),
(67, 'GAL-EWMSHC', 10, 'srd', 'Kauman, Kecamatan Nganjuk', -7.5937945, 111.8952473, '6a1190e0a4ed9_scaled_1000468651.jpg', 'Kader Pokja III', 'Kader Pokja III', 'upload1', '2026-05-23 11:34:56', '2026-05-23 11:35:33', 1, 3),
(68, 'GAL-KDKQCZ', 13, 'inovasi', 'Kauman, Kecamatan Nganjuk', -7.5937673, 111.8952152, '6a1192dcb791b_scaled_1000468670.jpg', 'Kader Pokja IV', 'Inovasi Prioritas', 'Proses', '2026-05-23 11:43:24', '2026-05-23 11:43:24', 1, 4),
(69, 'GAL-2ENDPM', 30, 'TEST', 'Kauman, Kecamatan Nganjuk', -7.593795, 111.8952395, '6a11937fd0596_scaled_1000469064.jpg', 'Kader Pokja I', 'Kader Pokja I', 'Proses', '2026-05-23 11:46:07', '2026-05-23 11:46:07', 1, 1),
(70, 'GAL-UWCGSA', 30, 'test', 'kost', NULL, NULL, '6a11948c12f8d_scaled_1000469064.jpg', 'Kader Pokja I', 'Penghayatan & Pengamalan Pancasila', 'Proses', '2026-05-23 11:50:36', '2026-05-23 11:50:36', 1, 1),
(71, 'GAL-YTEWMD', 31, 'coba', 'Kauman, Kecamatan Nganjuk', -7.5936323, 111.8950917, '6a119582e8371_scaled_1000468774.jpg', 'Kader Pokja I', 'Penghayatan & Pengamalan Pancasila', 'Proses', '2026-05-23 11:54:42', '2026-05-23 11:54:42', 1, 1),
(72, 'GAL-LLN5PQ', 2, 'Meningkatan Kapasitas Kader', 'Gedung PKK', NULL, NULL, '6a119f44decff_scaled_1000454971.jpg', 'Kader Pokja I', 'Kader Pokja I', 'upload2', '2026-05-23 12:36:20', '2026-05-23 12:36:30', 2, 1),
(73, 'GAL-FF6B9T', 32, 'game', 'Kauman, Kecamatan Nganjuk', -7.5938229, 111.8952705, '6a119ff114fac_scaled_1000468668.jpg', 'Kader Pokja I', 'Kader Pokja I', 'Proses', '2026-05-23 12:39:13', '2026-05-23 12:39:13', 1, 1),
(74, 'GAL-DKOPLX', 2, 'test', 'Kauman, Kecamatan Nganjuk', -7.5937902, 111.8952275, '6a11a123a9cde_scaled_c6a08382-5db8-490a-a6f3-7587cca92d255926773052519708732.jpg', 'Kader Pokja I', 'Penghayatan & Pengamalan Pancasila', 'Proses', '2026-05-23 12:44:19', '2026-05-23 12:44:19', 2, 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `kegiatan_pokja4`
--

CREATE TABLE `kegiatan_pokja4` (
  `id_kegiatan_pokja4` int(11) NOT NULL,
  `uuid` char(36) DEFAULT NULL,
  `id_user` int(11) DEFAULT NULL,
  `kader_kesehatan` int(11) DEFAULT 0,
  `gizi` int(11) DEFAULT 0,
  `kesling` int(11) DEFAULT 0,
  `phbs` int(11) DEFAULT 0,
  `kb` int(11) DEFAULT 0,
  `posyandu` int(11) DEFAULT 0,
  `imunisasi_vaksinasi_bayi_balita` int(11) DEFAULT 0,
  `pkg` int(11) DEFAULT 0,
  `tbc` int(11) DEFAULT 0,
  `jamban_wc` int(11) DEFAULT 0,
  `spal` int(11) DEFAULT 0,
  `tps` int(11) DEFAULT 0,
  `jumlah_mck` int(11) DEFAULT 0,
  `pdam` int(11) DEFAULT 0,
  `sumur` int(11) DEFAULT 0,
  `lain_lain` int(11) DEFAULT 0,
  `jml_pus` int(11) DEFAULT 0,
  `jml_wus` int(11) DEFAULT 0,
  `akseptor_kb_l` int(11) DEFAULT 0,
  `akseptor_kb_p` int(11) DEFAULT 0,
  `kk_memiliki_tabungan` int(11) DEFAULT 0,
  `kk_memiliki_asuransi` int(11) DEFAULT 0,
  `kesehatan` int(11) DEFAULT 0,
  `kelestarian_lingkungan_hidup` int(11) DEFAULT 0,
  `perencanaan_sehat` int(11) DEFAULT 0,
  `catatan` text DEFAULT NULL,
  `kategori` enum('unggulan','prioritas') DEFAULT 'prioritas',
  `status` varchar(50) DEFAULT 'proses',
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `id_role` int(11) DEFAULT NULL,
  `id_organization` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `kegiatan_pokja4`
--

INSERT INTO `kegiatan_pokja4` (`id_kegiatan_pokja4`, `uuid`, `id_user`, `kader_kesehatan`, `gizi`, `kesling`, `phbs`, `kb`, `posyandu`, `imunisasi_vaksinasi_bayi_balita`, `pkg`, `tbc`, `jamban_wc`, `spal`, `tps`, `jumlah_mck`, `pdam`, `sumur`, `lain_lain`, `jml_pus`, `jml_wus`, `akseptor_kb_l`, `akseptor_kb_p`, `kk_memiliki_tabungan`, `kk_memiliki_asuransi`, `kesehatan`, `kelestarian_lingkungan_hidup`, `perencanaan_sehat`, `catatan`, `kategori`, `status`, `created_at`, `updated_at`, `id_role`, `id_organization`) VALUES
(2, 'UNGGULAN-KP4-X2ULO5', 13, 23, 34, 45, 56, 46, 56, 56, 46, 46, 24, 35, 35, 57, 46, 46, 57, 23, 35, 35, 36, 35, 45, 35, 46, 46, NULL, 'unggulan', 'Disetujui2', '2026-05-16 05:56:36', '2026-05-16 07:19:26', 1, 4),
(3, 'PRIORITAS-KP4-HHVDQX', 13, 1, 5, 6, 7, 6, 5, 6, 7, 7, 78, 78, 7, 77, 7, 8, 8, 8, 8, 7, 7, 7, 7, 7, 7, 7, NULL, 'prioritas', 'Disetujui1', '2026-05-16 09:33:34', '2026-05-16 21:41:06', 1, 4),
(4, 'UNGGULAN-KP4-M3SU5D', 13, 2, 2, 3, 5, 5, 4, 5, 5, 5, 2, 3, 5, 5, 4, 6, 8, 2, 3, 5, 9, 2, 3, 5, 6, 4, NULL, 'unggulan', 'Proses', '2026-05-19 21:40:32', '2026-05-19 21:40:32', 1, 4),
(5, 'PRIORITAS-KP4-88EKCN', 13, 68, 8, 8, 0, 0, 0, 0, 0, 0, 8, 8, 8, 8, 8, 8, 8, 6, 8, 8, 8, 6, 5, 5, 8, 8, NULL, 'prioritas', 'Dibatalkan', '2026-05-22 15:12:38', '2026-05-23 04:48:52', 1, 4);

-- --------------------------------------------------------

--
-- Struktur dari tabel `laporan_bidang_kesehatan`
--

CREATE TABLE `laporan_bidang_kesehatan` (
  `id_pokja4_bidang1` int(11) NOT NULL,
  `uuid` char(36) NOT NULL,
  `id_user` int(11) NOT NULL,
  `jumlah_posyandu` int(11) NOT NULL,
  `jumlah_posyandu_iterasi` int(11) NOT NULL,
  `jumlah_klp` int(11) NOT NULL,
  `jumlah_anggota` int(11) NOT NULL,
  `jumlah_kartu_gratis` int(11) NOT NULL,
  `catatan` text DEFAULT NULL,
  `status` varchar(50) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `id_role` int(11) NOT NULL,
  `id_organization` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `laporan_bidang_kesehatan`
--

INSERT INTO `laporan_bidang_kesehatan` (`id_pokja4_bidang1`, `uuid`, `id_user`, `jumlah_posyandu`, `jumlah_posyandu_iterasi`, `jumlah_klp`, `jumlah_anggota`, `jumlah_kartu_gratis`, `catatan`, `status`, `created_at`, `updated_at`, `id_role`, `id_organization`) VALUES
(1, 'KP4B1-GCCGTT', 13, 67, 89, 67, 67, 56, NULL, 'Disetujui2', '2026-05-15 01:00:29', '2026-05-15 01:36:21', 1, 4),
(2, 'KP4B1-GX0CQ7', 12, 23, 45, 78, 23, 23, '', 'Proses', '2026-05-15 01:39:29', '2026-05-15 01:39:29', 2, 4),
(3, 'KP4B1-GJ7WAC', 13, 2, 6, 78, 67, 67, NULL, 'Disetujui1', '2026-05-15 20:26:57', '2026-05-20 00:34:53', 1, 4),
(4, 'KP4B1-S0KISI', 13, 2, 2, 3, 5, 8, '', 'Proses', '2026-05-19 20:07:34', '2026-05-19 20:07:34', 1, 4);

-- --------------------------------------------------------

--
-- Struktur dari tabel `laporan_gotong_royong`
--

CREATE TABLE `laporan_gotong_royong` (
  `id_pokja1_bidang2` int(11) NOT NULL,
  `uuid` char(36) NOT NULL,
  `id_user` int(11) NOT NULL,
  `kerja_bakti` int(11) NOT NULL,
  `rukun_kematian` int(11) NOT NULL,
  `keagamaan` int(11) NOT NULL,
  `jimpitan` int(11) NOT NULL,
  `arisan` int(11) NOT NULL,
  `catatan` text DEFAULT NULL,
  `status` varchar(50) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `id_role` int(11) NOT NULL,
  `id_organization` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data untuk tabel `laporan_gotong_royong`
--

INSERT INTO `laporan_gotong_royong` (`id_pokja1_bidang2`, `uuid`, `id_user`, `kerja_bakti`, `rukun_kematian`, `keagamaan`, `jimpitan`, `arisan`, `catatan`, `status`, `created_at`, `updated_at`, `id_role`, `id_organization`) VALUES
(5, 'KP1B2-DM63K6', 2, 54, 23, 34, 56, 23, NULL, 'Disetujui2', '2026-05-14 19:18:41', '2026-05-14 19:19:09', 2, 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `laporan_kader_pokja1`
--

CREATE TABLE `laporan_kader_pokja1` (
  `id_kader_pokja1` int(11) NOT NULL,
  `uuid` char(36) NOT NULL,
  `id_user` int(11) NOT NULL,
  `PKBN` int(11) NOT NULL,
  `PKDRT` int(11) NOT NULL,
  `pola_asuh` int(11) NOT NULL,
  `catatan` text DEFAULT NULL,
  `status` varchar(50) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `id_role` int(11) NOT NULL,
  `id_organization` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data untuk tabel `laporan_kader_pokja1`
--

INSERT INTO `laporan_kader_pokja1` (`id_kader_pokja1`, `uuid`, `id_user`, `PKBN`, `PKDRT`, `pola_asuh`, `catatan`, `status`, `created_at`, `updated_at`, `id_role`, `id_organization`) VALUES
(4, 'KP1-IWTYS3', 2, 34, 77, 55, NULL, 'Disetujui2', '2026-05-13 07:55:01', '2026-05-13 07:56:37', 2, 1),
(6, 'KP1-VYNRVO', 2, 100, 120, 130, NULL, 'Proses', '2026-05-14 19:17:15', '2026-05-14 19:17:15', 2, 1),
(8, 'KP1-3JSMST', 18, 21, 23, 23, NULL, 'Proses', '2026-05-17 19:23:25', '2026-05-17 19:23:25', 1, 1),
(21, 'KP1-YVMVTT', 2, 23, 28, 58, NULL, 'Disetujui2', '2026-05-19 08:26:17', '2026-05-19 08:27:00', 2, 1),
(22, 'KP1-BGQNIG', 2, 23, 58, 47, NULL, 'Disetujui2', '2026-05-19 08:30:53', '2026-05-19 08:31:07', 2, 1),
(23, 'KP1-NPXT3V', 2, 23, 55, 58, NULL, 'Disetujui2', '2026-05-19 08:43:53', '2026-05-19 08:44:06', 2, 1),
(24, 'KP1-BHOBDA', 2, 36, 25, 58, NULL, 'Disetujui2', '2026-05-19 08:47:05', '2026-05-19 08:47:27', 2, 1),
(34, 'KP1-QFPZYC', 2, 25, 55, 66, NULL, 'Proses', '2026-05-23 11:11:01', '2026-05-23 11:11:01', 2, 1),
(35, 'KP1-YXM3LT', 31, 28, 5, 8, NULL, 'Proses', '2026-05-23 12:33:36', '2026-05-23 12:33:36', 1, 1),
(36, 'KP1-YG1Q11', 2, 21, 69, 88, NULL, 'Proses', '2026-05-23 12:34:53', '2026-05-23 12:34:53', 2, 1),
(37, 'KP1-QMTFTW', 32, 25, 88, 55, NULL, 'Proses', '2026-05-23 12:38:32', '2026-05-23 12:38:32', 1, 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `laporan_kader_pokja3`
--

CREATE TABLE `laporan_kader_pokja3` (
  `id_kader_pokja3` int(11) NOT NULL,
  `uuid` char(36) NOT NULL,
  `id_user` int(11) NOT NULL,
  `pangan` int(11) NOT NULL,
  `sandang` int(11) NOT NULL,
  `tata_laksana_rumah` int(11) NOT NULL,
  `catatan` text DEFAULT NULL,
  `status` varchar(50) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `id_role` int(11) NOT NULL,
  `id_organization` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data untuk tabel `laporan_kader_pokja3`
--

INSERT INTO `laporan_kader_pokja3` (`id_kader_pokja3`, `uuid`, `id_user`, `pangan`, `sandang`, `tata_laksana_rumah`, `catatan`, `status`, `created_at`, `updated_at`, `id_role`, `id_organization`) VALUES
(1, 'KP3-FQPTL7', 10, 34, 67, 56, NULL, 'Disetujui2', '2026-05-14 19:59:20', '2026-05-14 20:27:32', 1, 3),
(2, 'KP3-WNGYME', 11, 100, 200, 300, '', 'Proses', '2026-05-14 20:28:36', '2026-05-14 20:28:36', 2, 3),
(3, 'KP3-XOSLYB', 10, 45, 78, 56, '', 'Proses', '2026-05-14 20:52:51', '2026-05-14 20:52:51', 1, 3),
(4, 'KP3-3JS2NC', 10, 12, 34, 67, NULL, 'Disetujui1', '2026-05-15 00:26:13', '2026-05-15 00:41:15', 1, 3),
(5, 'KP3-6BFWLZ', 11, 100, 79, 456, '', 'Proses', '2026-05-15 00:29:34', '2026-05-15 00:29:34', 2, 3),
(6, 'KP3-KD8RWV', 10, 2, 36, 58, '', 'Proses', '2026-05-19 19:35:47', '2026-05-19 19:35:47', 1, 3),
(7, 'KP3-A50GVL', 10, 36, 22, 77, NULL, 'Disetujui1', '2026-05-19 19:36:49', '2026-05-20 00:14:27', 1, 3),
(8, 'KP3-O1SWYH', 10, 36, 58, 25, '', 'Proses', '2026-05-19 19:40:33', '2026-05-19 19:40:33', 1, 3),
(9, 'KP3-16AMVR', 10, 36, 58, 25, NULL, 'Disetujui1', '2026-05-19 19:40:47', '2026-05-19 23:48:56', 1, 3);

-- --------------------------------------------------------

--
-- Struktur dari tabel `laporan_kader_pokja4`
--

CREATE TABLE `laporan_kader_pokja4` (
  `id_kader_pokja4` int(11) NOT NULL,
  `uuid` char(36) NOT NULL,
  `id_user` int(11) NOT NULL,
  `posyandu` int(11) NOT NULL,
  `gizi` int(11) NOT NULL,
  `kesling` int(11) NOT NULL,
  `penyuluhan_narkoba` int(11) NOT NULL,
  `PHBS` int(11) NOT NULL,
  `KB` int(11) NOT NULL,
  `catatan` text DEFAULT NULL,
  `status` varchar(50) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `id_role` int(11) NOT NULL,
  `id_organization` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data untuk tabel `laporan_kader_pokja4`
--

INSERT INTO `laporan_kader_pokja4` (`id_kader_pokja4`, `uuid`, `id_user`, `posyandu`, `gizi`, `kesling`, `penyuluhan_narkoba`, `PHBS`, `KB`, `catatan`, `status`, `created_at`, `updated_at`, `id_role`, `id_organization`) VALUES
(1, 'KP4-YGOFIY', 13, 34, 56, 89, 67, 56, 56, NULL, 'Disetujui2', '2026-05-15 01:00:14', '2026-05-15 01:37:10', 1, 4),
(2, 'KP4-SOWVSV', 13, 5, 78, 89, 78, 45, 56, 'po', 'Proses', '2026-05-15 01:07:17', '2026-05-15 01:07:17', 1, 4),
(3, 'KP4-FVOWY1', 12, 23, 56, 88, 46, 45, 12, '', 'Proses', '2026-05-15 01:38:15', '2026-05-15 01:38:15', 2, 4),
(4, 'KP4-AJSWTB', 13, 12, 67, 56, 45, 67, 56, '', 'Proses', '2026-05-15 20:25:50', '2026-05-15 20:25:50', 1, 4),
(5, 'KP4-UDVW3K', 13, 2, 36, 2, 2, 2, 2, NULL, 'Disetujui1', '2026-05-19 20:01:49', '2026-05-20 00:38:30', 1, 4);

-- --------------------------------------------------------

--
-- Struktur dari tabel `laporan_kelestarian_lingkungan_hidup`
--

CREATE TABLE `laporan_kelestarian_lingkungan_hidup` (
  `id_pokja4_bidang2` int(11) NOT NULL,
  `uuid` char(36) NOT NULL,
  `id_user` int(11) NOT NULL,
  `jamban` int(11) NOT NULL,
  `spal` int(11) NOT NULL,
  `tps` int(11) NOT NULL,
  `mck` int(11) NOT NULL,
  `pdam` int(11) NOT NULL,
  `sumur` int(11) NOT NULL,
  `dll` int(11) NOT NULL,
  `catatan` text DEFAULT NULL,
  `status` varchar(50) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `id_role` int(11) NOT NULL,
  `id_organization` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `laporan_kelestarian_lingkungan_hidup`
--

INSERT INTO `laporan_kelestarian_lingkungan_hidup` (`id_pokja4_bidang2`, `uuid`, `id_user`, `jamban`, `spal`, `tps`, `mck`, `pdam`, `sumur`, `dll`, `catatan`, `status`, `created_at`, `updated_at`, `id_role`, `id_organization`) VALUES
(1, 'KP4B2-JQCAAL', 13, 56, 67, 78, 56, 67, 78, 78, NULL, 'Disetujui2', '2026-05-15 01:00:59', '2026-05-15 01:36:42', 1, 4),
(2, 'KP4B2-YP9PFM', 12, 12, 35, 56, 78, 12, 35, 67, '', 'Proses', '2026-05-15 01:39:46', '2026-05-15 01:39:46', 2, 4),
(3, 'KP4B2-BECNM5', 13, 77, 89, 78, 67, 78, 78, 76, NULL, 'Disetujui1', '2026-05-15 20:27:20', '2026-05-20 01:54:55', 1, 4),
(4, 'KP4B2-N5QJN5', 13, 2, 2, 3, 3, 2, 3, 2, '', 'Proses', '2026-05-19 20:14:47', '2026-05-19 20:14:47', 1, 4),
(5, 'KP4B2-HXAZ6A', 13, 2, 3, 5, 5, 3, 3, 3, '', 'Proses', '2026-05-23 05:37:57', '2026-05-23 05:37:57', 1, 4);

-- --------------------------------------------------------

--
-- Struktur dari tabel `laporan_pangan`
--

CREATE TABLE `laporan_pangan` (
  `id_pokja3_bidang1` int(11) NOT NULL,
  `uuid` char(36) NOT NULL,
  `id_user` int(11) NOT NULL,
  `beras` int(11) NOT NULL,
  `non_beras` int(11) NOT NULL,
  `peternakan` int(11) NOT NULL,
  `perikanan` int(11) NOT NULL,
  `warung_hidup` int(11) NOT NULL,
  `lumbung_hidup` int(11) NOT NULL,
  `toga` int(11) NOT NULL,
  `tanaman_keras` int(11) NOT NULL,
  `tanaman_lainnya` int(11) DEFAULT 0,
  `catatan` text DEFAULT NULL,
  `status` varchar(50) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `id_role` int(11) NOT NULL,
  `id_organization` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data untuk tabel `laporan_pangan`
--

INSERT INTO `laporan_pangan` (`id_pokja3_bidang1`, `uuid`, `id_user`, `beras`, `non_beras`, `peternakan`, `perikanan`, `warung_hidup`, `lumbung_hidup`, `toga`, `tanaman_keras`, `tanaman_lainnya`, `catatan`, `status`, `created_at`, `updated_at`, `id_role`, `id_organization`) VALUES
(1, 'KP3B1-NP2A1V', 10, 34, 67, 56, 78, 45, 35, 34, 46, 34, NULL, 'Disetujui2', '2026-05-14 19:57:07', '2026-05-14 20:26:16', 1, 3),
(2, 'KP3B1-3LFZP2', 11, 20, 30, 40, 50, 60, 70, 80, 90, 100, '', 'Proses', '2026-05-14 20:29:03', '2026-05-14 20:29:03', 2, 3),
(3, 'KP3B1-R5S1BA', 10, 56, 89, 78, 78, 78, 89, 45, 67, 78, NULL, 'Disetujui2', '2026-05-14 20:53:26', '2026-05-14 21:04:40', 1, 3),
(4, 'KP3B1-ZBIXSZ', 10, 45, 67, 89, 67, 56, 45, 34, 34, 12, NULL, 'Disetujui1', '2026-05-15 00:27:26', '2026-05-15 00:31:10', 1, 3),
(5, 'KP3B1-KBTL5O', 11, 98, 67, 45, 78, 45, 34, 23, 56, 34, '', 'Proses', '2026-05-15 00:29:19', '2026-05-15 00:29:19', 2, 3),
(6, 'KP3B1-KPKXR6', 10, 2, 3, 2, 2, 3, 5, 8, 5, 6, NULL, 'Disetujui1', '2026-05-19 19:47:39', '2026-05-19 23:46:41', 1, 3),
(7, 'KP3B1-U7HOIW', 10, 25, 36, 25, 36, 55, 25, 36, 25, 25, NULL, 'Disetujui1', '2026-05-19 19:54:40', '2026-05-19 23:46:33', 1, 3),
(8, 'KP3B1-2CABWF', 10, 2, 3, 0, 0, 0, 0, 0, 0, 0, '', 'Proses', '2026-05-22 14:12:39', '2026-05-22 14:12:39', 1, 3),
(9, 'KP3B1-AGO9PJ', 10, 2, 3, 5, 6, 2, 3, 2, 2, 2, '', 'Proses', '2026-05-23 05:27:52', '2026-05-23 05:27:52', 1, 3);

-- --------------------------------------------------------

--
-- Struktur dari tabel `laporan_pendidikan_n_keterampilan`
--

CREATE TABLE `laporan_pendidikan_n_keterampilan` (
  `id_pokja2_bidang1` int(11) NOT NULL,
  `uuid` char(36) NOT NULL,
  `id_user` int(11) NOT NULL,
  `warga_buta` int(11) NOT NULL,
  `kel_belajarA` int(11) NOT NULL,
  `warga_belajarA` int(11) NOT NULL,
  `kel_belajarB` int(11) NOT NULL,
  `warga_belajarB` int(11) NOT NULL,
  `kel_belajarC` int(11) NOT NULL,
  `warga_belajarC` int(11) NOT NULL,
  `kel_belajarKF` int(11) NOT NULL,
  `warga_belajarKF` int(11) NOT NULL,
  `paud` int(11) NOT NULL,
  `taman_bacaan` int(11) NOT NULL,
  `jumlah_klp` int(11) NOT NULL,
  `jumlah_ibu_peserta` int(11) NOT NULL,
  `jumlah_ape` int(11) NOT NULL,
  `jumlah_kel_simulasi` int(11) NOT NULL,
  `KF` int(11) NOT NULL,
  `paud_tutor` int(11) NOT NULL,
  `BKB` int(11) NOT NULL,
  `koperasi` int(11) NOT NULL,
  `ketrampilan` int(11) NOT NULL,
  `LP3PKK` int(11) NOT NULL,
  `TP3PKK` int(11) NOT NULL,
  `damas_pkk` int(11) NOT NULL,
  `catatan` text DEFAULT NULL,
  `status` varchar(50) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `id_role` int(11) NOT NULL,
  `id_organization` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data untuk tabel `laporan_pendidikan_n_keterampilan`
--

INSERT INTO `laporan_pendidikan_n_keterampilan` (`id_pokja2_bidang1`, `uuid`, `id_user`, `warga_buta`, `kel_belajarA`, `warga_belajarA`, `kel_belajarB`, `warga_belajarB`, `kel_belajarC`, `warga_belajarC`, `kel_belajarKF`, `warga_belajarKF`, `paud`, `taman_bacaan`, `jumlah_klp`, `jumlah_ibu_peserta`, `jumlah_ape`, `jumlah_kel_simulasi`, `KF`, `paud_tutor`, `BKB`, `koperasi`, `ketrampilan`, `LP3PKK`, `TP3PKK`, `damas_pkk`, `catatan`, `status`, `created_at`, `updated_at`, `id_role`, `id_organization`) VALUES
(1, 'KP2B1-6I6FUX', 7, 1, 2, 3, 4, 5, 5, 7, 6, 4, 4, 3, 5, 6, 7, 9, 3, 4, 5, 7, 8, 23, 87, 100, NULL, 'Disetujui2', '2026-05-13 08:01:03', '2026-05-13 08:04:54', 1, 2),
(2, 'KP2B1-XXQ9Q6', 9, 34, 57, 44, 34, 24, 45, 34, 78, 34, 67, 78, 87, 567, 34, 35, 67, 67, 34, 56, 56, 98, 76, 87, NULL, 'Disetujui2', '2026-05-13 08:06:51', '2026-05-13 08:24:11', 2, 2),
(3, 'KP2B1-F31M5L', 7, 1, 2, 3, 4, 5, 6, 6, 7, 7, 4, 6, 2, 4, 5, 7, 3, 2, 3, 5, 56, 56, 66, 45, NULL, 'Disetujui2', '2026-05-13 08:49:10', '2026-05-13 09:02:02', 1, 2),
(4, 'KP2B1-ULF9LA', 7, 2, 5, 7, 8, 9, 34, 22, 3, 76, 45, 34, 34, 21, 45, 56, 23, 1, 3, 4, 8, 4, 8, 100, 'perubahan di damas pkk', 'Disetujui2', '2026-05-14 19:20:44', '2026-05-14 21:26:46', 1, 2),
(5, 'KP2B1-CWDQ5I', 20, 23, 25, 55, 5, 2, 36, 25, 88, 47, 36, 25, 23, 25, 58, 14, 25, 36, 25, 55, 44, 2, 3, 55, '', 'Proses', '2026-05-19 19:30:02', '2026-05-19 19:30:02', 1, 2),
(6, 'KP2B1-Y3C2AP', 7, 25, 36, 58, 52, 69, 36, 2, 5, 6, 5, 2, 2, 3, 5, 6, 5, 6, 5, 6, 5, 2, 3, 5, NULL, 'Disetujui1', '2026-05-20 06:37:30', '2026-05-20 06:45:05', 1, 2);

-- --------------------------------------------------------

--
-- Struktur dari tabel `laporan_pengembangan_kehidupan`
--

CREATE TABLE `laporan_pengembangan_kehidupan` (
  `id_pokja2_bidang2` int(11) NOT NULL,
  `uuid` char(36) NOT NULL,
  `id_user` int(11) NOT NULL,
  `jumlah_kelompok_pemula` int(11) NOT NULL,
  `jumlah_peserta_pemula` int(11) NOT NULL,
  `jumlah_kelompok_madya` int(11) NOT NULL,
  `jumlah_peserta_madya` int(11) NOT NULL,
  `jumlah_kelompok_utama` int(11) NOT NULL,
  `jumlah_peserta_utama` int(11) NOT NULL,
  `jumlah_kelompok_mandiri` int(11) NOT NULL,
  `jumlah_peserta_mandiri` int(11) NOT NULL,
  `jumlah_kelompok_hukum` int(11) NOT NULL,
  `jumlah_peserta_hukum` int(11) NOT NULL,
  `catatan` text DEFAULT NULL,
  `status` varchar(50) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `id_role` int(11) NOT NULL,
  `id_organization` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data untuk tabel `laporan_pengembangan_kehidupan`
--

INSERT INTO `laporan_pengembangan_kehidupan` (`id_pokja2_bidang2`, `uuid`, `id_user`, `jumlah_kelompok_pemula`, `jumlah_peserta_pemula`, `jumlah_kelompok_madya`, `jumlah_peserta_madya`, `jumlah_kelompok_utama`, `jumlah_peserta_utama`, `jumlah_kelompok_mandiri`, `jumlah_peserta_mandiri`, `jumlah_kelompok_hukum`, `jumlah_peserta_hukum`, `catatan`, `status`, `created_at`, `updated_at`, `id_role`, `id_organization`) VALUES
(1, 'KP2B2-3JXMCJ', 7, 45, 78, 67, 46, 45, 56, 68, 45, 67, 46, NULL, 'Disetujui2', '2026-05-13 08:01:47', '2026-05-13 08:05:23', 1, 2),
(2, 'KP2B2-SX1M4R', 9, 46, 45, 68, 45, 35, 34, 24, 45, 88, 345, NULL, 'Disetujui2', '2026-05-13 08:08:06', '2026-05-13 08:46:47', 2, 2),
(3, 'KP2B2-EUCPHW', 7, 45, 56, 56, 55, 55, 67, 33, 23, 12, 67, NULL, 'Disetujui2', '2026-05-13 08:52:54', '2026-05-13 09:02:31', 1, 2),
(4, 'KP2B2-2DHATC', 7, 3, 1, 3, 6, 4, 3, 4, 3, 4, 6, NULL, 'Disetujui2', '2026-05-14 19:21:24', '2026-05-14 21:28:19', 1, 2),
(5, 'KP2B2-2KGLZT', 20, 25, 14, 52, 36, 85, 5, 14, 25, 25, 36, '', 'Proses', '2026-05-19 19:33:59', '2026-05-19 19:33:59', 1, 2),
(6, 'KP2B2-BIUW37', 7, 2, 36, 5, 8, 2, 2, 2, 6, 5, 9, '', 'Proses', '2026-05-20 07:00:45', '2026-05-20 07:00:45', 1, 2);

-- --------------------------------------------------------

--
-- Struktur dari tabel `laporan_penghayatan_n_pengamalan`
--

CREATE TABLE `laporan_penghayatan_n_pengamalan` (
  `id_pokja1_bidang1` int(11) NOT NULL,
  `uuid` char(36) NOT NULL,
  `id_user` int(11) NOT NULL,
  `jumlah_kel_simulasi1` int(11) NOT NULL,
  `jumlah_anggota1` int(11) NOT NULL,
  `jumlah_kel_simulasi2` int(11) NOT NULL,
  `jumlah_anggota2` int(11) NOT NULL,
  `jumlah_kel_simulasi3` int(11) NOT NULL,
  `jumlah_anggota3` int(11) NOT NULL,
  `jumlah_kel_simulasi4` int(11) NOT NULL,
  `jumlah_anggota4` int(11) NOT NULL,
  `catatan` text DEFAULT NULL,
  `status` varchar(50) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `id_role` int(11) NOT NULL,
  `id_organization` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data untuk tabel `laporan_penghayatan_n_pengamalan`
--

INSERT INTO `laporan_penghayatan_n_pengamalan` (`id_pokja1_bidang1`, `uuid`, `id_user`, `jumlah_kel_simulasi1`, `jumlah_anggota1`, `jumlah_kel_simulasi2`, `jumlah_anggota2`, `jumlah_kel_simulasi3`, `jumlah_anggota3`, `jumlah_kel_simulasi4`, `jumlah_anggota4`, `catatan`, `status`, `created_at`, `updated_at`, `id_role`, `id_organization`) VALUES
(1, 'KP1B1-VD6IFL', 2, 1, 2, 3, 4, 5, 6, 7, 8, NULL, 'Disetujui2', '2026-05-13 03:33:03', '2026-05-13 04:57:09', 2, 1),
(5, 'KP1B1-MPCZPG', 2, 2, 45, 93, 45, 67, 23, 56, 67, NULL, 'Proses', '2026-05-14 19:18:09', '2026-05-14 19:18:09', 2, 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `laporan_perencanaan_sehat`
--

CREATE TABLE `laporan_perencanaan_sehat` (
  `id_pokja4_bidang3` int(11) NOT NULL,
  `uuid` char(36) NOT NULL,
  `id_user` int(11) NOT NULL,
  `J_Psubur` int(11) NOT NULL,
  `J_Wsubur` int(11) NOT NULL,
  `Kb_p` int(11) NOT NULL,
  `Kb_w` int(11) NOT NULL,
  `Kk_tbg` int(11) NOT NULL,
  `catatan` text DEFAULT NULL,
  `status` varchar(50) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `id_role` int(11) NOT NULL,
  `id_organization` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `laporan_perencanaan_sehat`
--

INSERT INTO `laporan_perencanaan_sehat` (`id_pokja4_bidang3`, `uuid`, `id_user`, `J_Psubur`, `J_Wsubur`, `Kb_p`, `Kb_w`, `Kk_tbg`, `catatan`, `status`, `created_at`, `updated_at`, `id_role`, `id_organization`) VALUES
(1, 'KP4B3-DUKSDM', 13, 45, 67, 78, 89, 67, NULL, 'Disetujui2', '2026-05-15 01:01:16', '2026-05-15 01:36:57', 1, 4),
(2, 'KP4B3-DFBTJX', 12, 23, 24, 78, 57, 56, '', 'Proses', '2026-05-15 01:40:03', '2026-05-15 01:40:03', 2, 4),
(3, 'KP4B3-NNTCHU', 13, 67, 89, 78, 67, 67, '', 'Proses', '2026-05-15 20:27:34', '2026-05-15 20:27:34', 1, 4),
(4, 'KP4B3-W5QA2J', 13, 2, 3, 2, 2, 3, '', 'Proses', '2026-05-19 20:04:37', '2026-05-19 20:04:37', 1, 4);

-- --------------------------------------------------------

--
-- Struktur dari tabel `laporan_perumahan`
--

CREATE TABLE `laporan_perumahan` (
  `id_pokja3_bidang3` int(11) NOT NULL,
  `uuid` char(36) NOT NULL,
  `id_user` int(11) NOT NULL,
  `layak_huni` int(11) NOT NULL,
  `tidak_layak` int(11) NOT NULL,
  `catatan` text DEFAULT NULL,
  `status` varchar(50) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `id_role` int(11) NOT NULL,
  `id_organization` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data untuk tabel `laporan_perumahan`
--

INSERT INTO `laporan_perumahan` (`id_pokja3_bidang3`, `uuid`, `id_user`, `layak_huni`, `tidak_layak`, `catatan`, `status`, `created_at`, `updated_at`, `id_role`, `id_organization`) VALUES
(1, 'KP3B3-EHRKEY', 10, 78, 67, NULL, 'Disetujui2', '2026-05-14 19:59:40', '2026-05-14 20:27:11', 1, 3),
(2, 'KP3B3-GIRCRM', 11, 98, 100, '', 'Proses', '2026-05-14 20:29:45', '2026-05-14 20:29:45', 2, 3),
(3, 'KP3B3-NI6AGB', 11, 67, 89, '', 'Proses', '2026-05-15 00:30:07', '2026-05-15 00:30:07', 2, 3),
(4, 'KP3B3-GJB2LH', 10, 25, 36, '', 'Proses', '2026-05-19 19:54:08', '2026-05-19 19:54:08', 1, 3),
(5, 'KP3B3-DJBODH', 10, 36, 25, NULL, 'Disetujui1', '2026-05-19 19:56:50', '2026-05-19 23:37:01', 1, 3),
(6, 'KP3B3-BXEWWX', 10, 36, 25, NULL, 'Disetujui1', '2026-05-19 19:57:41', '2026-05-19 23:36:51', 1, 3);

-- --------------------------------------------------------

--
-- Struktur dari tabel `laporan_sandang`
--

CREATE TABLE `laporan_sandang` (
  `id_pokja3_bidang2` int(11) NOT NULL,
  `uuid` char(36) NOT NULL,
  `id_user` int(11) NOT NULL,
  `pangan` int(11) NOT NULL,
  `sandang` int(11) NOT NULL,
  `jasa` int(11) NOT NULL,
  `catatan` text DEFAULT NULL,
  `status` varchar(50) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `id_role` int(11) NOT NULL,
  `id_organization` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data untuk tabel `laporan_sandang`
--

INSERT INTO `laporan_sandang` (`id_pokja3_bidang2`, `uuid`, `id_user`, `pangan`, `sandang`, `jasa`, `catatan`, `status`, `created_at`, `updated_at`, `id_role`, `id_organization`) VALUES
(1, 'KP3B2-SWSBIP', 10, 56, 89, 78, NULL, 'Disetujui2', '2026-05-14 19:59:33', '2026-05-14 20:26:44', 1, 3),
(2, 'KP3B2-HKNQSM', 11, 40, 60, 80, NULL, 'Disetujui2', '2026-05-14 20:29:36', '2026-05-19 23:30:24', 2, 3),
(3, 'KP3B2-AAWA4H', 11, 56, 56, 56, '', 'Proses', '2026-05-15 00:29:56', '2026-05-15 00:29:56', 2, 3),
(4, 'KP3B2-AI0RWJ', 10, 25, 36, 80, '', 'Proses', '2026-05-19 19:56:45', '2026-05-19 19:56:45', 1, 3);

-- --------------------------------------------------------

--
-- Struktur dari tabel `laporan_umum`
--

CREATE TABLE `laporan_umum` (
  `id_laporan_umum` int(11) NOT NULL,
  `uuid` char(36) NOT NULL,
  `id_user` int(11) NOT NULL,
  `dusun_lingkungan` int(11) NOT NULL,
  `PKK_RW` int(11) NOT NULL,
  `PKK_RT` int(11) DEFAULT NULL,
  `desa_wisma` int(11) NOT NULL,
  `KRT` int(11) NOT NULL,
  `KK` int(11) NOT NULL,
  `jiwa_laki` int(11) NOT NULL,
  `jiwa_perempuan` int(11) NOT NULL,
  `anggota_laki` int(11) NOT NULL,
  `anggota_perempuan` int(11) NOT NULL,
  `umum_laki` int(11) NOT NULL,
  `umum_perempuan` int(11) NOT NULL,
  `khusus_laki` int(11) NOT NULL,
  `khusus_perempuan` int(11) NOT NULL,
  `honorer_laki` int(11) NOT NULL,
  `honorer_perempuan` int(11) NOT NULL,
  `bantuan_laki` int(11) NOT NULL,
  `bantuan_perempuan` int(11) NOT NULL,
  `catatan` text DEFAULT NULL,
  `status` varchar(50) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `id_role` int(11) NOT NULL,
  `id_organization` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data untuk tabel `laporan_umum`
--

INSERT INTO `laporan_umum` (`id_laporan_umum`, `uuid`, `id_user`, `dusun_lingkungan`, `PKK_RW`, `PKK_RT`, `desa_wisma`, `KRT`, `KK`, `jiwa_laki`, `jiwa_perempuan`, `anggota_laki`, `anggota_perempuan`, `umum_laki`, `umum_perempuan`, `khusus_laki`, `khusus_perempuan`, `honorer_laki`, `honorer_perempuan`, `bantuan_laki`, `bantuan_perempuan`, `catatan`, `status`, `created_at`, `updated_at`, `id_role`, `id_organization`) VALUES
(1, 'PKKUM-A9BXEY', 17, 23, 45, 78, 78, 78, 78, 67, 78, 78, 88, 88, 78, 88, 67, 12, 56, 66, 78, NULL, 'Disetujui2', '2026-05-15 02:35:30', '2026-05-15 03:05:04', 2, 5),
(2, 'PKKUM-UV1SZM', 17, 67, 78, 67, 67, 23, 44, 23, 45, 67, 66, 56, 23, 23, 35, 67, 24, 23, 23, '', 'Proses', '2026-05-15 03:07:15', '2026-05-15 03:07:15', 2, 5),
(3, 'PKKUM-V3BHE7', 16, 23, 34, 23, 23, 23, 23, 13, 23, 23, 23, 23, 23, 23, 134, 34, 23, 13, 23, NULL, 'Disetujui1', '2026-05-15 03:14:39', '2026-05-15 03:16:53', 1, 5),
(4, 'PKKUM-DHBOIK', 16, 67, 56, 46, 67, 78, 78, 67, 45, 34, 67, 34, 23, 67, 56, 78, 89, 67, 56, NULL, 'Disetujui1', '2026-05-15 03:26:16', '2026-05-15 03:26:30', 1, 5),
(5, 'PKKUM-DVJ8CT', 16, 2, 3, 5, 11, 2, 6, 2, 5, 6, 5, 5, 6, 6, 5, 2, 3, 5, 2, '', 'Proses', '2026-05-19 21:49:09', '2026-05-19 21:49:09', 1, 5);

-- --------------------------------------------------------

--
-- Struktur dari tabel `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_reset_tokens_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2019_12_14_000001_create_personal_access_tokens_table', 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `password_reset_tokens`
--

INSERT INTO `password_reset_tokens` (`email`, `token`, `created_at`) VALUES
('a@gmail.com', '$2y$10$b8LB3hCSLnuqMWKx.IKkmeUWaPS.I9pCNqmN1l1bTlZbMISBSgR8a', '2023-07-05 15:34:44'),
('cermotmine@gmail.com', '$2y$10$w47j.vn1LhEGB8356gEYue5EtJtUki8zDiR7Q.t7Xlkd8V3yWjTo2', '2023-05-08 23:47:52'),
('pkknganjuk3005@gmail.com', '$2y$10$08cURMZCpue.hIRmdRAWnOgLzC6xzipvB/cvcqLpDY.flBugeApX2', '2026-05-08 03:55:05');

-- --------------------------------------------------------

--
-- Struktur dari tabel `pengumumen`
--

CREATE TABLE `pengumumen` (
  `id` int(11) NOT NULL,
  `judulPengumuman` varchar(255) NOT NULL,
  `deskripsiPengumuman` text NOT NULL,
  `tempatPengumuman` varchar(255) NOT NULL,
  `tanggalPengumuman` date NOT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `pengumumen`
--

INSERT INTO `pengumumen` (`id`, `judulPengumuman`, `deskripsiPengumuman`, `tempatPengumuman`, `tanggalPengumuman`, `updated_at`, `created_at`) VALUES
(6, 'Lomba Kreasi Daur Ulang', 'Mari tunjukkan kreativitas dan kesadaran lingkungan dengan mengikuti Lomba Kreasi Daur Ulang. Gunakan barang bekas untuk membuat produk unik dan berguna. Lomba ini terbuka untuk semua anggota PKK dan masyarakat umum. Bersiaplah untuk memamerkan kreasi Anda dan menangkan hadiah menarik.', 'Lapangan Desa', '2024-09-21', '2023-05-04 18:18:04', '2024-07-20 18:18:04'),
(9, 'kerja bakti sosial', 'kerja bakti diadakan pada hari rabu tanggal 23 februari', 'lingkungan', '2024-09-30', '2023-08-31 19:26:39', '2023-07-05 07:59:46'),
(12, 'Test', 'Ini merupakan testing untuk tampil di mobile', 'Nganjuk', '2023-11-07', '2023-11-06 18:23:35', '2023-11-06 18:23:35'),
(13, 'Sosialisasi', 'Sosialisasi PKK', 'Nganjuk', '2024-10-22', '2024-07-21 19:49:40', '2024-07-21 19:49:40'),
(14, 'Kerja Bakti ', 'Kerja bakti ya teman teman', 'Di Alun alun Nganjuk', '2024-09-25', '2024-09-18 15:24:49', '2024-09-18 15:24:49'),
(15, 'Bersih bersih Desa ', 'Desa nya masing masing', 'Desa nya', '2024-09-18', '2024-09-18 15:24:49', '2024-09-18 15:24:49'),
(16, 'Kerja Kerja ', 'Kerja kerja bos ya teman teman', 'Di sini', '2024-09-25', '2024-09-18 15:24:49', '2024-09-18 15:24:49'),
(17, 'Bersih bersih Kota ', 'Kota nya masing masing', 'Kota nya', '2024-09-18', '2024-09-18 15:24:49', '2024-09-18 15:24:49'),
(18, 'Kerja Bakti ', 'Kerja bakti ya teman teman', 'Di Alun alun Nganjuk', '2024-09-25', '2024-09-18 15:24:49', '2024-09-18 15:24:49'),
(19, 'Bersih bersih Desa ', 'Desa nya masing masing', 'Desa nya', '2024-09-18', '2024-09-18 15:24:49', '2024-09-18 15:24:49'),
(20, 'Kerja Bakti ', 'Kerja bakti ya teman teman', 'Di Alun alun Nganjuk', '2024-09-25', '2024-09-18 15:24:49', '2024-09-18 15:24:49'),
(21, 'Bersih bersih Desa ', 'Desa nya masing masing', 'Desa nya', '2024-09-18', '2024-09-18 15:24:49', '2024-09-18 15:24:49'),
(22, 'Kerja Bakti ', 'Kerja bakti ya teman teman', 'Di Alun alun Nganjuk', '2024-09-25', '2024-09-18 15:24:49', '2024-09-18 15:24:49'),
(23, 'Bersih bersih Desa ', 'Desa nya masing masing', 'Desa nya', '2024-09-18', '2024-09-18 15:24:49', '2024-09-18 15:24:49'),
(24, 'Kerja Bakti ', 'Kerja bakti ya teman teman', 'Di Alun alun Nganjuk', '2024-09-25', '2024-09-18 15:24:49', '2024-09-18 15:24:49'),
(25, 'Bersih bersih Desa ', 'Desa nya masing masing', 'Desa nya', '2024-09-18', '2024-09-18 15:24:49', '2024-09-18 15:24:49'),
(26, 'Coba Pengumuman 1', 'Percobaan post dan get pengumuman', 'Nganjuk', '2025-05-14', '2025-05-14 00:16:44', '2025-05-14 00:16:44');

-- --------------------------------------------------------

--
-- Struktur dari tabel `posyandu`
--

CREATE TABLE `posyandu` (
  `id_posyandu` int(11) NOT NULL,
  `uuid` char(36) DEFAULT NULL,
  `id_user` int(11) DEFAULT NULL,
  `bulan` varchar(20) DEFAULT NULL,
  `jml_ibu_hamil` int(11) DEFAULT 0,
  `diperiksa` int(11) DEFAULT 0,
  `fe_tablet_darah` int(11) DEFAULT 0,
  `jml_ibu_menyusui` int(11) DEFAULT 0,
  `kondom` int(11) DEFAULT 0,
  `pil` int(11) DEFAULT 0,
  `implant` int(11) DEFAULT 0,
  `mop` int(11) DEFAULT 0,
  `mow` int(11) DEFAULT 0,
  `iud` int(11) DEFAULT 0,
  `suntikan` int(11) DEFAULT 0,
  `lain_lain_kb` int(11) DEFAULT 0,
  `jml_balita_l` int(11) DEFAULT 0,
  `jml_balita_p` int(11) DEFAULT 0,
  `buku_kia_l` int(11) DEFAULT 0,
  `buku_kia_p` int(11) DEFAULT 0,
  `datang_l` int(11) DEFAULT 0,
  `datang_p` int(11) DEFAULT 0,
  `naik_l` int(11) DEFAULT 0,
  `naik_p` int(11) DEFAULT 0,
  `vit_a_l` int(11) DEFAULT 0,
  `vit_a_p` int(11) DEFAULT 0,
  `pmt_l` int(11) DEFAULT 0,
  `pmt_p` int(11) DEFAULT 0,
  `imunisasi_tt_1` int(11) DEFAULT 0,
  `imunisasi_tt_2` int(11) DEFAULT 0,
  `catatan` text DEFAULT NULL,
  `kategori` enum('unggulan','prioritas') DEFAULT 'prioritas',
  `status` varchar(50) DEFAULT 'proses',
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `id_role` int(11) DEFAULT NULL,
  `id_organization` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `posyandu`
--

INSERT INTO `posyandu` (`id_posyandu`, `uuid`, `id_user`, `bulan`, `jml_ibu_hamil`, `diperiksa`, `fe_tablet_darah`, `jml_ibu_menyusui`, `kondom`, `pil`, `implant`, `mop`, `mow`, `iud`, `suntikan`, `lain_lain_kb`, `jml_balita_l`, `jml_balita_p`, `buku_kia_l`, `buku_kia_p`, `datang_l`, `datang_p`, `naik_l`, `naik_p`, `vit_a_l`, `vit_a_p`, `pmt_l`, `pmt_p`, `imunisasi_tt_1`, `imunisasi_tt_2`, `catatan`, `kategori`, `status`, `created_at`, `updated_at`, `id_role`, `id_organization`) VALUES
(2, 'UNGGULAN-POS-QIWMTX', 13, 'Mei', 1, 2, 3, 4, 5, 6, 7, 8, 9, 1, 2, 0, 5, 5, 7, 6, 6, 6, 1, 3, 4, 5, 5, 6, 5, 7, '', 'unggulan', 'Proses', '2026-05-16 01:34:31', '2026-05-16 01:34:31', 1, 4),
(3, 'UNGGULAN-POS-AEOZ1M', 13, 'Mei', 3, 4, 5, 7, 5, 7, 6, 6, 6, 6, 7, 0, 5, 8, 8, 9, 9, 9, 6, 7, 7, 7, 7, 9, 7, 8, NULL, 'unggulan', 'Disetujui1', '2026-05-16 02:03:50', '2026-05-20 01:20:10', 1, 4),
(4, 'UNGGULAN-POS-4J8JAA', 13, 'Juni', 23, 56, 56, 34, 34, 56, 56, 35, 56, 56, 56, 0, 34, 56, 67, 45, 45, 67, 12, 46, 57, 56, 56, 56, 56, 67, '', 'unggulan', 'Proses', '2026-05-16 02:18:29', '2026-05-16 02:18:29', 1, 4),
(5, 'UNGGULAN-POS-IKCOAB', 13, 'Juni', 34, 45, 45, 56, 55, 56, 34, 34, 56, 56, 56, 0, 55, 45, 45, 45, 34, 45, 45, 56, 56, 56, 56, 45, 56, 66, NULL, 'unggulan', 'Disetujui2', '2026-05-16 02:32:35', '2026-05-16 05:45:02', 1, 4),
(6, 'UNGGULAN-POS-40G0SF', 13, 'Agustus', 2, 4, 5, 6, 67, 66, 45, 45, 45, 56, 56, 0, 45, 56, 45, 45, 34, 23, 45, 45, 35, 56, 56, 45, 45, 56, NULL, 'unggulan', 'Disetujui2', '2026-05-16 02:37:56', '2026-05-16 05:44:31', 1, 4),
(7, 'UNGGULAN-POS-UUXHMJ', 13, 'November', 34, 56, 5, 78, 67, 78, 88, 8, 87, 67, 68, 67, 56, 67, 76, 78, 67, 69, 67, 78, 78, 78, 78, 78, 78, 78, NULL, 'unggulan', 'Disetujui2', '2026-05-16 02:41:58', '2026-05-16 05:44:20', 1, 4),
(8, 'UNGGULAN-POS-7BNJON', 13, 'Agustus', 23, 34, 45, 56, 45, 5, 56, 56, 56, 45, 56, 56, 56, 56, 45, 45, 56, 56, 67, 67, 56, 67, 57, 66, 56, 56, '', 'unggulan', 'Proses', '2026-05-16 21:27:55', '2026-05-16 21:27:55', 1, 4),
(9, 'PRIORITAS-POS-K4EUSN', 13, 'November', 35, 56, 56, 45, 34, 56, 45, 45, 56, 45, 57, 67, 56, 56, 56, 56, 56, 78, 67, 55, 45, 45, 45, 56, 56, 56, NULL, 'prioritas', 'Disetujui1', '2026-05-16 21:29:15', '2026-05-16 21:37:46', 1, 4),
(10, 'UNGGULAN-POS-AU2VGJ', 13, 'Februari', 2, 3, 5, 8, 2, 3, 5, 8, 5, 8, 7, 5, 3, 5, 5, 8, 5, 9, 2, 3, 5, 5, 8, 4, 25, 58, '', 'unggulan', 'Proses', '2026-05-19 21:33:22', '2026-05-19 21:33:22', 1, 4);

-- --------------------------------------------------------

--
-- Struktur dari tabel `rekap_desa_bulanan`
--

CREATE TABLE `rekap_desa_bulanan` (
  `id_rekap_desa_bulanan` int(11) NOT NULL,
  `uuid` char(36) NOT NULL,
  `id_user` int(11) NOT NULL,
  `rw` int(11) NOT NULL,
  `rt` int(11) NOT NULL,
  `dasa_wisma` int(11) NOT NULL,
  `hamil` int(11) NOT NULL,
  `melahirkan` int(11) NOT NULL,
  `nifas` int(11) NOT NULL,
  `meninggal` int(11) NOT NULL,
  `bayi_lahir_l` int(11) NOT NULL,
  `bayi_lahir_p` int(11) NOT NULL,
  `akte_kelahiran_ada` int(11) NOT NULL,
  `akte_kelahiran_tidak` int(11) NOT NULL,
  `bayi_meninggal_l` int(11) NOT NULL,
  `bayi_meninggal_p` int(11) NOT NULL,
  `balita_meninggal_l` int(11) NOT NULL,
  `balita_meninggal_p` int(11) NOT NULL,
  `catatan` text DEFAULT NULL,
  `kategori` enum('unggulan','prioritas') NOT NULL,
  `status` varchar(50) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `id_role` int(11) NOT NULL,
  `id_organization` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `rekap_desa_bulanan`
--

INSERT INTO `rekap_desa_bulanan` (`id_rekap_desa_bulanan`, `uuid`, `id_user`, `rw`, `rt`, `dasa_wisma`, `hamil`, `melahirkan`, `nifas`, `meninggal`, `bayi_lahir_l`, `bayi_lahir_p`, `akte_kelahiran_ada`, `akte_kelahiran_tidak`, `bayi_meninggal_l`, `bayi_meninggal_p`, `balita_meninggal_l`, `balita_meninggal_p`, `catatan`, `kategori`, `status`, `created_at`, `updated_at`, `id_role`, `id_organization`) VALUES
(1, 'UNGGULAN-RDB-UJNFGG', 13, 67, 78, 89, 67, 78, 67, 67, 89, 67, 66, 78, 67, 45, 34, 45, NULL, 'unggulan', 'Disetujui2', '2026-05-15 01:01:51', '2026-05-15 01:37:25', 1, 4),
(3, 'UNGGULAN-RDB-POD0IM', 12, 46, 89, 67, 46, 34, 56, 56, 56, 55, 35, 56, 45, 34, 34, 23, NULL, 'unggulan', 'Disetujui2', '2026-05-15 01:41:24', '2026-05-15 19:49:47', 2, 4),
(5, 'UNGGULAN-RDB-1JGKPV', 13, 67, 67, 67, 67, 67, 67, 67, 67, 67, 67, 67, 67, 67, 67, 67, NULL, 'unggulan', 'Disetujui1', '2026-05-15 20:28:14', '2026-05-15 21:11:06', 1, 4),
(6, 'UNGGULAN-RDB-C6VPLM', 13, 56, 78, 78, 67, 57, 67, 56, 56, 67, 56, 67, 56, 35, 56, 78, NULL, 'unggulan', 'Disetujui1', '2026-05-15 21:49:22', '2026-05-15 21:49:34', 1, 4),
(7, 'UNGGULAN-RDB-YW1LQG', 13, 97, 76, 68, 68, 78, 78, 67, 77, 88, 67, 67, 56, 56, 56, 56, '', 'unggulan', 'Proses', '2026-05-15 21:58:26', '2026-05-15 21:58:26', 1, 4),
(8, 'UNGGULAN-RDB-XZC7DY', 12, 23, 45, 13, 12, 34, 45, 67, 67, 24, 35, 67, 67, 67, 67, 78, NULL, 'unggulan', 'Disetujui2', '2026-05-15 22:15:48', '2026-05-16 00:44:58', 2, 4),
(9, 'UNGGULAN-RDB-AW7XJJ', 12, 56, 56, 45, 56, 56, 56, 57, 55, 56, 67, 67, 56, 55, 56, 56, NULL, 'unggulan', 'Disetujui2', '2026-05-15 22:17:51', '2026-05-16 00:44:11', 2, 4),
(10, 'PRIORITAS-RDB-JECCDE', 13, 23, 23, 23, 23, 23, 23, 23, 23, 23, 23, 23, 23, 23, 23, 23, NULL, 'prioritas', 'Disetujui1', '2026-05-16 09:30:16', '2026-05-16 09:35:35', 1, 4),
(11, 'UNGGULAN-RDB-WDL4F0', 13, 2, 3, 5, 14, 25, 3, 5, 23, 5, 2, 25, 36, 5, 2, 2, '', 'unggulan', 'Proses', '2026-05-19 20:47:57', '2026-05-19 20:47:57', 1, 4),
(12, 'UNGGULAN-RDB-8JPQNU', 13, 25, 63, 47, 8, 5, 1, 2, 25, 47, 36, 25, 2, 25, 25, 36, '', 'unggulan', 'Proses', '2026-05-19 21:10:02', '2026-05-19 21:10:02', 1, 4);

-- --------------------------------------------------------

--
-- Struktur dari tabel `rekap_desa_tahunan`
--

CREATE TABLE `rekap_desa_tahunan` (
  `id_rekap_desa_tahunan` int(11) NOT NULL,
  `uuid` char(36) DEFAULT NULL,
  `id_user` int(11) DEFAULT NULL,
  `kader_kesehatan` int(11) DEFAULT 0,
  `gizi` int(11) DEFAULT 0,
  `kesling` int(11) DEFAULT 0,
  `phbs` int(11) DEFAULT 0,
  `kb` int(11) DEFAULT 0,
  `posyandu` int(11) DEFAULT 0,
  `imunisasi_vaksinasi_bayi_balita` int(11) DEFAULT 0,
  `pkg` int(11) DEFAULT 0,
  `tbc` int(11) DEFAULT 0,
  `jamban_wc` int(11) DEFAULT 0,
  `spal` int(11) DEFAULT 0,
  `tps` int(11) DEFAULT 0,
  `jumlah_mck` int(11) DEFAULT 0,
  `pdam` int(11) DEFAULT 0,
  `sumur` int(11) DEFAULT 0,
  `lain_lain` int(11) DEFAULT 0,
  `jml_pus` int(11) DEFAULT 0,
  `jml_wus` int(11) DEFAULT 0,
  `akseptor_kb_l` int(11) DEFAULT 0,
  `akseptor_kb_p` int(11) DEFAULT 0,
  `jml_kk_tabungan` int(11) DEFAULT 0,
  `jml_kk_asuransi` int(11) DEFAULT 0,
  `kesehatan_program` int(11) DEFAULT 0,
  `kelestarian_lingkungan_hidup` int(11) DEFAULT 0,
  `perencanaan_sehat_program` int(11) DEFAULT 0,
  `catatan` text DEFAULT NULL,
  `kategori` enum('unggulan','prioritas') DEFAULT NULL,
  `status` varchar(50) DEFAULT 'proses',
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `id_role` int(11) DEFAULT NULL,
  `id_organization` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `rekap_desa_tahunan`
--

INSERT INTO `rekap_desa_tahunan` (`id_rekap_desa_tahunan`, `uuid`, `id_user`, `kader_kesehatan`, `gizi`, `kesling`, `phbs`, `kb`, `posyandu`, `imunisasi_vaksinasi_bayi_balita`, `pkg`, `tbc`, `jamban_wc`, `spal`, `tps`, `jumlah_mck`, `pdam`, `sumur`, `lain_lain`, `jml_pus`, `jml_wus`, `akseptor_kb_l`, `akseptor_kb_p`, `jml_kk_tabungan`, `jml_kk_asuransi`, `kesehatan_program`, `kelestarian_lingkungan_hidup`, `perencanaan_sehat_program`, `catatan`, `kategori`, `status`, `created_at`, `updated_at`, `id_role`, `id_organization`) VALUES
(1, 'UNGGULAN-RDT-VFC4OJ', 13, 23, 56, 78, 23, 45, 45, 23, 23, 78, 46, 67, 57, 45, 23, 12, 56, 56, 67, 45, 34, 56, 56, 43, 24, 46, NULL, 'unggulan', 'Disetujui1', '2026-05-15 06:58:53', '2026-05-16 20:30:26', 1, 4),
(2, 'UNGGULAN-RDT-P4YVD7', 13, 23, 67, 56, 33, 67, 78, 66, 12, 56, 45, 12, 56, 0, 67, 45, 67, 67, 77, 67, 77, 23, 77, 67, 77, 77, NULL, 'unggulan', 'Disetujui2', '2026-05-15 07:25:12', '2026-05-15 22:12:06', 1, 4),
(3, 'UNGGULAN-RDT-T2YHRR', 12, 23, 78, 34, 33, 23, 23, 34, 33, 23, 23, 34, 23, 0, 34, 34, 33, 23, 23, 23, 23, 23, 23, 23, 23, 23, NULL, 'unggulan', 'Disetujui2', '2026-05-15 22:16:34', '2026-05-16 00:56:05', 2, 4),
(4, 'PRIORITAS-RDT-FYA6XG', 13, 24, 24, 24, 24, 24, 24, 24, 24, 24, 24, 24, 24, 0, 24, 24, 24, 24, 24, 24, 24, 24, 24, 24, 24, 24, NULL, 'prioritas', 'Disetujui1', '2026-05-16 09:31:19', '2026-05-16 20:16:58', 1, 4),
(5, 'UNGGULAN-RDT-IDFTUN', 13, 88, 67, 67, 67, 56, 67, 67, 57, 56, 67, 67, 67, 0, 56, 67, 46, 67, 67, 67, 67, 67, 67, 67, 67, 67, NULL, 'unggulan', 'Disetujui1', '2026-05-16 20:00:58', '2026-05-16 20:22:12', 1, 4),
(6, 'PRIORITAS-RDT-BFTUZU', 13, 45, 56, 46, 46, 46, 56, 46, 56, 56, 56, 45, 56, 0, 56, 67, 56, 67, 35, 35, 34, 67, 56, 56, 45, 45, NULL, 'prioritas', 'Disetujui1', '2026-05-16 20:20:37', '2026-05-16 20:21:08', 1, 4),
(7, 'UNGGULAN-RDT-CIFAWN', 13, 28, 53, 56, 56, 56, 56, 56, 56, 57, 45, 56, 66, 67, 57, 66, 67, 67, 67, 68, 67, 67, 68, 68, 78, 78, NULL, 'unggulan', 'Disetujui1', '2026-05-16 20:32:10', '2026-05-16 20:32:44', 1, 4),
(8, 'UNGGULAN-RDT-Z9V4J3', 13, 1, 2, 5, 5, 8, 5, 6, 5, 5, 2, 3, 5, 5, 5, 5, 8, 2, 3, 5, 5, 5, 6, 5, 8, 4, '', 'unggulan', 'Proses', '2026-05-19 21:19:43', '2026-05-19 21:19:43', 1, 4);

-- --------------------------------------------------------

--
-- Struktur dari tabel `role_organization`
--

CREATE TABLE `role_organization` (
  `id` int(11) NOT NULL,
  `uuid` char(36) NOT NULL,
  `name` varchar(225) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `role_organization`
--

INSERT INTO `role_organization` (`id`, `uuid`, `name`) VALUES
(1, 'a5366433-7510-11ef-af29-7c10c9ad62dc', 'Kader Pokja I'),
(2, 'a5366f79-7510-11ef-af29-7c10c9ad62dc', 'Kader Pokja II'),
(3, 'a5367028-7510-11ef-af29-7c10c9ad62dc', 'Kader Pokja III'),
(4, 'a5367053-7510-11ef-af29-7c10c9ad62dc', 'Kader Pokja IV'),
(5, 'a5367077-7510-11ef-af29-7c10c9ad62dc', 'Bidang Umum');

-- --------------------------------------------------------

--
-- Struktur dari tabel `role_users_mobile`
--

CREATE TABLE `role_users_mobile` (
  `id` int(11) NOT NULL,
  `uuid` char(36) NOT NULL,
  `name` varchar(225) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `role_users_mobile`
--

INSERT INTO `role_users_mobile` (`id`, `uuid`, `name`) VALUES
(1, 'e604a0c7-750f-11ef-af29-7c10c9ad62dc', 'Desa'),
(2, 'e604ac2d-750f-11ef-af29-7c10c9ad62dc', 'Kecamatan');

--
-- Trigger `role_users_mobile`
--
DELIMITER $$
CREATE TRIGGER `uuid_role_users_mobile` BEFORE INSERT ON `role_users_mobile` FOR EACH ROW BEGIN
    IF NEW.uuid IS NULL THEN
        SET NEW.uuid = UUID();
    END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Struktur dari tabel `subdistrict`
--

CREATE TABLE `subdistrict` (
  `id` int(11) NOT NULL,
  `uuid` char(36) NOT NULL,
  `name` varchar(225) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `subdistrict`
--

INSERT INTO `subdistrict` (`id`, `uuid`, `name`) VALUES
(1, 'b713300b-7570-11ef-88d9-7c10c9ad62dc', 'Bagor'),
(2, 'b71602c8-7570-11ef-88d9-7c10c9ad62dc', 'Baron'),
(3, 'b717bbcf-7570-11ef-88d9-7c10c9ad62dc', 'Berbek'),
(4, 'b7196b6c-7570-11ef-88d9-7c10c9ad62dc', 'Gondang'),
(5, 'b71b066e-7570-11ef-88d9-7c10c9ad62dc', 'Jatikalen'),
(6, 'b71cc114-7570-11ef-88d9-7c10c9ad62dc', 'Kertosono'),
(7, 'b71e6c2f-7570-11ef-88d9-7c10c9ad62dc', 'Lengkong'),
(8, 'b7201810-7570-11ef-88d9-7c10c9ad62dc', 'Loceret'),
(9, 'b721d230-7570-11ef-88d9-7c10c9ad62dc', 'Nganjuk'),
(10, 'b723abf7-7570-11ef-88d9-7c10c9ad62dc', 'Ngetos'),
(11, 'b72571bb-7570-11ef-88d9-7c10c9ad62dc', 'Ngluyu'),
(12, 'b7271eb5-7570-11ef-88d9-7c10c9ad62dc', 'Ngronggot'),
(13, 'b728ccf9-7570-11ef-88d9-7c10c9ad62dc', 'Pace'),
(14, 'b72a8181-7570-11ef-88d9-7c10c9ad62dc', 'Patianrowo'),
(15, 'b72c3b53-7570-11ef-88d9-7c10c9ad62dc', 'Prambon'),
(16, 'b72de736-7570-11ef-88d9-7c10c9ad62dc', 'Rejoso'),
(17, 'b72f9796-7570-11ef-88d9-7c10c9ad62dc', 'Sawahan'),
(18, 'b73152ed-7570-11ef-88d9-7c10c9ad62dc', 'Sukomoro'),
(19, 'b732f3fe-7570-11ef-88d9-7c10c9ad62dc', 'Tanjunganom'),
(20, 'b734a5d2-7570-11ef-88d9-7c10c9ad62dc', 'Wilangan');

-- --------------------------------------------------------

--
-- Struktur dari tabel `ttds`
--

CREATE TABLE `ttds` (
  `id_ttds` int(11) NOT NULL,
  `nama_terang` varchar(225) NOT NULL,
  `jabatan` varchar(225) NOT NULL,
  `pokja` varchar(225) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `ttds`
--

INSERT INTO `ttds` (`id_ttds`, `nama_terang`, `jabatan`, `pokja`, `created_at`, `updated_at`) VALUES
(2, 'Ny. Windarti, SST.M.Kes', 'Ketua', 'Kelompok Kerja IV', '2026-05-21 00:58:17', '2023-09-07 08:20:31'),
(4, 'Ny. Nur Katrina Hendro Djoko', 'Ketua', 'Kelompok Kerja II', '2023-08-29 21:45:07', '2023-08-29 21:45:07'),
(5, 'Ny. Hj. Ulfa Lishandoyo, S.Pd. M.Si', 'Ketua', 'Kelompok Kerja I', '2023-08-30 04:49:25', '2023-08-29 21:46:21'),
(6, 'Ny. Ir. Ninik Fajar Yudiono', 'Ketua', 'Kelompok Kerja III', '2023-08-29 21:47:21', '2023-08-29 21:47:21'),
(11, 'Ny. Laila Arief Mahatma, S.Sos', 'Sekretaris', 'Bidang Umum', '2026-05-21 00:57:19', '2023-08-31 08:22:34'),
(12, 'Ny. Hj. S Wahyuni Marhaen,  SE', 'Ketua', NULL, '2023-09-01 01:47:00', '2023-08-31 18:47:00');

-- --------------------------------------------------------

--
-- Struktur dari tabel `ttdss`
--

CREATE TABLE `ttdss` (
  `id_ttdss` int(11) NOT NULL,
  `nama_terang` varchar(225) NOT NULL,
  `jabatan` varchar(225) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `ttdss`
--

INSERT INTO `ttdss` (`id_ttdss`, `nama_terang`, `jabatan`, `created_at`, `updated_at`) VALUES
(3, 'Ny. Etty Aminingsih Noerdin, BBA', 'Wakil Ketua I', '2023-08-29 21:48:44', '2023-08-29 21:48:44');

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `nomer_telepon` bigint(20) NOT NULL,
  `alamat` varchar(225) NOT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `nomer_telepon`, `alamat`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(3, 'alkahfi', 'a@gmail.com', 0, '', '$2y$10$9NxheOOx8eR7DJnfICm5deZzYr3CDsZYxYFv2LWrBLBDH/ENNDm6K', 'kJEX18kRLVX8pOD57xF1KmlGlz4gR3yHcfEIIqSLGyniHYVbtrndImMp4vjS', '2023-04-04 07:11:42', '2023-05-08 20:06:39'),
(12, 'tim penggerak pkk-nganjukk', 'pkknganjuk3005@gmail.com', 82142568403, 'nganjukk', '$2y$10$H8q19SLEyr3oChy9w3lAJeaXAvs8R7kv/6uUH0LSLAysxwcb.LiVu', 'efTr3eAljKc29KTYGotG4x9geaLEWGnSjos4ACu7nkqBfl5ofzFnFlbY4pbB', NULL, '2026-05-18 19:05:38'),
(13, 'cermot', 'cermotmine@gmail.com', 0, '', '$2y$10$pzVbzpRYQR.L8yfG7e2hvOoWLrws3QNjpJ82HXv05zhzMSEKAx36K', NULL, NULL, NULL),
(14, 'admin', 'dimasdhy28@gmail.com', 82142064308, 'Nganjuk, Jawa Timur', '$2y$10$HU2cMd6d5YWfK1FZqBFJRe34phBRvHo4v4GkjAXwrRI255ZQOxybG', 'MQW9xRaYU1tifM3IjwAzNYSwEwPyyInfjYFy1kigxAKsqS2JBG1zzi2zigZc', '2026-05-17 05:08:47', '2026-05-16 22:18:47');

-- --------------------------------------------------------

--
-- Struktur dari tabel `users_mobile`
--

CREATE TABLE `users_mobile` (
  `id` int(11) NOT NULL,
  `uuid` char(36) NOT NULL,
  `phone_number` char(20) NOT NULL,
  `full_name` varchar(255) NOT NULL,
  `password` varchar(256) NOT NULL,
  `kode_otp` varchar(10) NOT NULL,
  `fcm_token` text DEFAULT NULL,
  `status` varchar(10) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `id_subdistrict` int(11) NOT NULL,
  `id_village` int(11) NOT NULL,
  `id_role` int(11) NOT NULL,
  `id_organization` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `users_mobile`
--

INSERT INTO `users_mobile` (`id`, `uuid`, `phone_number`, `full_name`, `password`, `kode_otp`, `fcm_token`, `status`, `created_at`, `updated_at`, `id_subdistrict`, `id_village`, `id_role`, `id_organization`) VALUES
(2, '97a0f2d2-fbf5-4fd3-a854-2c8b11c40082', '082142064309', 'aldi', '$2y$10$TkqMbyrCeApM3vaf2wrrW./72vzu3Md9HXBrr2GooDjQLkAXBlPEe', '6458', 'dHCg6k_6Tc20kyBNEslxgh:APA91bFcK-4T4aUOG8lVAN5Flpadr_cjzFedgZRjSev12VF1f27kk3WhfCwoA2AP6pZpzrv_ZP5BQEGyUdKLqMhCPmVN5hTqbw1DxI_qD4rtJIODWp3NwhI', 'Active', '2026-05-13 08:47:41', '2026-05-20 06:05:38', 9, 423, 2, 1),
(7, '9ac20f09-4ed8-11f1-a860-426eba1d2f04', '082142064310', 'Dimas', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '5555', 'eIxlSShqT36rDPrEaTZHq0:APA91bGsXPiANjBg2UViL1B5EhUSgpfjJQF1lYYINRU6r-kZ7yZtKZkAtI-cSSlYMYA-FGmeeaHl4Kb27Aefwa3UF2oRPA-ox2_0YqqILkdYUNZwy9c-BGE', 'Active', '2026-05-13 21:32:44', '2026-05-20 14:04:44', 9, 424, 1, 2),
(9, 'f87e44c2-4ed9-11f1-a860-426eba1d2f04', '081234567890', 'Admin Desa 2', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '2222', NULL, 'Active', '2026-05-13 21:42:30', '2026-05-13 21:42:30', 9, 422, 2, 2),
(10, 'c2ae36d9-5007-11f1-8003-426eba1d2f04', '082140206401', 'Andi Saputra', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '1234', 'fLX6WppITVq1wc4IeyXX-7:APA91bEnq9zW160IMsxv8LuCwF8LCQ6frDraLw1ens2LNPC9KThtlG-c14msim8oUVJYTXzgFJObCx_Ot2k08qz20v6Kp8grd3g3mVWoFXjiqHYZKwbJhlU', 'Active', '2026-05-15 09:42:48', '2026-05-20 02:50:33', 9, 423, 1, 3),
(11, 'c2af0375-5007-11f1-8003-426eba1d2f04', '082140206402', 'Dimas Pratama', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '5678', NULL, 'Active', '2026-05-15 09:42:48', '2026-05-15 09:42:48', 9, 424, 2, 3),
(12, 'a1e7ef59-5033-11f1-8003-426eba1d2f04', '081234567801', 'Kecamatan Demo', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '1234', NULL, 'Active', '2026-05-15 14:56:51', '2026-05-16 08:31:44', 9, 423, 2, 4),
(13, 'a1e8790e-5033-11f1-8003-426eba1d2f04', '081234567802', 'Desa Demo', '$2y$10$Jp8pHjvhpnG4XrpGM6TLFuUj/cD3JpkP31cs2xUQpGnojS7NBQCNe', '5678', 'eIxlSShqT36rDPrEaTZHq0:APA91bGsXPiANjBg2UViL1B5EhUSgpfjJQF1lYYINRU6r-kZ7yZtKZkAtI-cSSlYMYA-FGmeeaHl4Kb27Aefwa3UF2oRPA-ox2_0YqqILkdYUNZwy9c-BGE', 'Active', '2026-05-15 14:56:51', '2026-05-23 05:02:11', 9, 424, 1, 4),
(16, 'b2057c40-5040-11f1-8003-426eba1d2f04', '081234567855', 'Desa Dummy Organization 5', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '0000', 'eIxlSShqT36rDPrEaTZHq0:APA91bGsXPiANjBg2UViL1B5EhUSgpfjJQF1lYYINRU6r-kZ7yZtKZkAtI-cSSlYMYA-FGmeeaHl4Kb27Aefwa3UF2oRPA-ox2_0YqqILkdYUNZwy9c-BGE', 'aktif', '2026-05-15 16:30:22', '2026-05-20 09:15:39', 9, 424, 1, 5),
(17, 'b2064bee-5040-11f1-8003-426eba1d2f04', '081234567856', 'Kecamatan Organization 5', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '0000', NULL, 'aktif', '2026-05-15 16:30:22', '2026-05-18 08:48:01', 9, 423, 2, 5),
(18, '98808dae-87a2-4c99-94eb-c90fc82b25fe', '087828032496', 'lendra', '$2y$10$LXwPebXGwOG.zZ4za6GAhO5tQeIgV2yfW2hG.VhvvlxbMB4Tyl5Qu', '9009', NULL, 'Active', '2026-05-18 02:21:30', '2026-05-18 02:21:30', 14, 478, 1, 1),
(20, '1bd6a00d-a0fe-40de-8df2-79a1ee1f9f3b', '089666324884', 'riski', '$2y$10$UjDbGbAWRcVI19MiYuEUveRIFEP5KZqn/YCXcukNW3qdzFy1z901.', '1417', 'fLX6WppITVq1wc4IeyXX-7:APA91bEnq9zW160IMsxv8LuCwF8LCQ6frDraLw1ens2LNPC9KThtlG-c14msim8oUVJYTXzgFJObCx_Ot2k08qz20v6Kp8grd3g3mVWoFXjiqHYZKwbJhlU', 'Active', '2026-05-20 02:21:59', '2026-05-20 02:32:56', 16, 504, 1, 2),
(21, '25fcfc0e-04dc-4a8d-9f12-6948f1eede48', '085888072919', 'depi', '$2y$10$Bg1FNkfRdbVLYXOd0JPU9uO8vfGeJIGo1CCSZ3.7RynyYnbRc41s6', '3193', NULL, 'Active', '2026-05-22 09:49:07', '2026-05-22 10:05:23', 20, 567, 1, 2),
(22, '745132e8-5c7a-4182-9017-73f1aebe7fb3', '081933542806', 'lendra', '$2y$10$6HY/zpdb/T.aK9dY3/vVLOFOyAUn/3QrbXwXqqxrgOoeMhPfFHjm2', '8593', NULL, 'Active', '2026-05-23 06:30:09', '2026-05-23 06:30:09', 14, 478, 1, 2),
(30, '32a5792c-d2a3-4cf1-83c1-13a03d46333f', '082142064308', 'DIMAS ALDI', '$2y$10$pm88aWP3rL/dt6W4Q.BMguMHSB4YFhOvctP44bdTgkBNra8iotHFa', '4776', NULL, 'Active', '2026-05-23 11:45:33', '2026-05-23 11:45:33', 1, 286, 1, 1),
(31, 'ad387ce1-e8c5-4738-822e-208d059492fd', '081358111998', 'Mahardika', '$2y$10$hjI4l26zX1WEeHPC1.Yiu.vbVP.ysbF1zHhssiO/OmsqexVseGgHC', '5944', NULL, 'Active', '2026-05-23 11:54:20', '2026-05-23 11:54:20', 3, 319, 1, 1),
(32, '819968cf-e840-4a8e-8dde-798b87697708', '082337162041', 'Alex', '$2y$10$m77xb.mcUVF9IpgW9yaCbOo7DBz3/U2E56g88CMvijO9ePdFF/WvK', '4097', NULL, 'Active', '2026-05-23 12:38:07', '2026-05-23 12:38:07', 9, 424, 1, 1),
(33, '2250fba3-a7d6-46c1-8d33-4665fdc27fd5', '08563664511', 'Miraww', '$2y$10$T1nnHU67CqhJqk0QcZYlZOganSaum.w4hw.nYxYOsUwUaAz66iyXm', '2373', NULL, 'Active', '2026-05-23 14:00:36', '2026-05-23 14:00:36', 3, 335, 1, 1),
(34, 'b7374e04-16eb-4a00-a340-2028b8de7e4a', '0895366436487', 'Akuya', '$2y$10$gidj4pAj4OLO1y/5b94NFebBtjx1zvivo27g90Gft6O9DIQAc68Ra', '7945', NULL, 'Active', '2026-05-23 14:12:36', '2026-05-23 14:12:36', 2, 306, 2, 2);

--
-- Trigger `users_mobile`
--
DELIMITER $$
CREATE TRIGGER `uuid_users_mobile` BEFORE INSERT ON `users_mobile` FOR EACH ROW BEGIN
    IF NEW.uuid IS NULL THEN
        SET NEW.uuid = UUID();
    END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Struktur dari tabel `village`
--

CREATE TABLE `village` (
  `id` int(11) NOT NULL,
  `uuid` char(36) NOT NULL,
  `id_subdistrict` int(11) NOT NULL,
  `name` varchar(225) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `village`
--

INSERT INTO `village` (`id`, `uuid`, `id_subdistrict`, `name`) VALUES
(285, 'e830cf75-4615-4af0-9473-6c7b49c9d9a1', 1, 'Bagor'),
(286, '0509c70e-a4df-46fc-a844-00e899eaf811', 1, 'Balongrejo'),
(287, '81bb46ad-2ed9-48c4-af1f-de8b0a14dac4', 1, 'Banaran Kulon'),
(288, 'afc0ecb9-ed8a-4cf4-a951-e368af9e5a8d', 1, 'Banaran Wetan'),
(289, 'd8e212c7-c298-4102-a046-1baa3bef6f88', 1, 'Buduran'),
(290, '81654a01-69e2-41e0-897f-5f358b9454af', 1, 'Gandu'),
(291, 'de3daa89-12ea-4ce6-a6e0-785ee1d2f849', 1, 'Gemenggeng'),
(292, '68362b7c-dfd0-4f52-a230-edca6f35502b', 1, 'Girirejo'),
(293, '83721f8c-42ad-45ff-8deb-67cba674ae33', 1, 'Karang Tengah'),
(294, '70a48396-dc6e-4f53-8f0c-da645bbba58d', 1, 'Kendalrejo'),
(295, 'f0bd897f-7572-11ef-88d9-7c10c9ad62dc', 1, 'Kerep Kidul'),
(296, 'f0bdfcf1-7572-11ef-88d9-7c10c9ad62dc', 1, 'Kutorejo'),
(297, 'f0be6ca1-7572-11ef-88d9-7c10c9ad62dc', 1, 'Ngumpul'),
(298, 'f0becdbe-7572-11ef-88d9-7c10c9ad62dc', 1, 'Paron'),
(299, 'f0bf3f96-7572-11ef-88d9-7c10c9ad62dc', 1, 'Pesudukuh'),
(300, 'f0bfac2c-7572-11ef-88d9-7c10c9ad62dc', 1, 'Petak'),
(301, 'f0c022e3-7572-11ef-88d9-7c10c9ad62dc', 1, 'Sekarputih'),
(302, 'f0c08a2a-7572-11ef-88d9-7c10c9ad62dc', 1, 'Selorejo'),
(303, 'f0c0f105-7572-11ef-88d9-7c10c9ad62dc', 1, 'Sugihwaras'),
(304, 'f0c164c7-7572-11ef-88d9-7c10c9ad62dc', 1, 'Kelurahan Guyangan'),
(305, 'f0c1d26f-7572-11ef-88d9-7c10c9ad62dc', 1, 'Kelurahan Kedondong'),
(306, 'f0c247ef-7572-11ef-88d9-7c10c9ad62dc', 2, 'Baron'),
(307, 'f0c2aef9-7572-11ef-88d9-7c10c9ad62dc', 2, 'Garu'),
(308, 'f0c321cf-7572-11ef-88d9-7c10c9ad62dc', 2, 'Gebangkerep'),
(309, 'f0c38ca9-7572-11ef-88d9-7c10c9ad62dc', 2, 'Jambi'),
(310, 'f0c40a4c-7572-11ef-88d9-7c10c9ad62dc', 2, 'Jekek'),
(311, 'f0c477fd-7572-11ef-88d9-7c10c9ad62dc', 2, 'Katerban'),
(312, 'f0c4e40a-7572-11ef-88d9-7c10c9ad62dc', 2, 'Kemaduh'),
(313, 'f0c54e1d-7572-11ef-88d9-7c10c9ad62dc', 2, 'Kemlokolegi'),
(314, 'f0c5b8f9-7572-11ef-88d9-7c10c9ad62dc', 2, 'Mabung'),
(315, 'f0c62e26-7572-11ef-88d9-7c10c9ad62dc', 2, 'Sambiroto'),
(316, 'f0c69fc1-7572-11ef-88d9-7c10c9ad62dc', 2, 'Waung'),
(317, 'f0c70f51-7572-11ef-88d9-7c10c9ad62dc', 3, 'Balongrejo'),
(318, 'f0c77c9b-7572-11ef-88d9-7c10c9ad62dc', 3, 'Bendungrejo'),
(319, 'f0c7e2ad-7572-11ef-88d9-7c10c9ad62dc', 3, 'Berbek'),
(320, 'f0c84d9d-7572-11ef-88d9-7c10c9ad62dc', 3, 'Bulu'),
(321, 'f0c8bf5e-7572-11ef-88d9-7c10c9ad62dc', 3, 'Cepoko'),
(322, 'f0c92ded-7572-11ef-88d9-7c10c9ad62dc', 3, 'Grojogan'),
(323, 'f0c99e4d-7572-11ef-88d9-7c10c9ad62dc', 3, 'Kacangan'),
(324, 'f0ca0893-7572-11ef-88d9-7c10c9ad62dc', 3, 'Maguan'),
(325, 'f0ca70f0-7572-11ef-88d9-7c10c9ad62dc', 3, 'Mlilir'),
(326, 'f0cade9e-7572-11ef-88d9-7c10c9ad62dc', 3, 'Ngrawan'),
(327, 'f0cb48f7-7572-11ef-88d9-7c10c9ad62dc', 3, 'Patranrejo'),
(328, 'f0cbb192-7572-11ef-88d9-7c10c9ad62dc', 3, 'Salamrojo'),
(329, 'f0cc20ee-7572-11ef-88d9-7c10c9ad62dc', 3, 'Semare'),
(330, 'f0cc88d9-7572-11ef-88d9-7c10c9ad62dc', 3, 'Sendangbumen'),
(331, 'f0cced56-7572-11ef-88d9-7c10c9ad62dc', 3, 'Sengkut'),
(332, 'f0cd54c3-7572-11ef-88d9-7c10c9ad62dc', 3, 'Sonopatik'),
(333, 'f0cdb7e4-7572-11ef-88d9-7c10c9ad62dc', 3, 'Sumberurip'),
(334, 'f0ce2750-7572-11ef-88d9-7c10c9ad62dc', 3, 'Sumberwindu'),
(335, 'f0ce915b-7572-11ef-88d9-7c10c9ad62dc', 3, 'Tiripan'),
(336, 'f0ceff63-7572-11ef-88d9-7c10c9ad62dc', 4, 'Balonggebang'),
(337, 'f0cf6c01-7572-11ef-88d9-7c10c9ad62dc', 4, 'Campur'),
(338, 'f0cfd3b5-7572-11ef-88d9-7c10c9ad62dc', 4, 'Gondangkulon'),
(339, 'f0d03c5b-7572-11ef-88d9-7c10c9ad62dc', 4, 'Ja\'an'),
(340, 'f0d0aa80-7572-11ef-88d9-7c10c9ad62dc', 4, 'Karangsemi'),
(341, 'f0d115d6-7572-11ef-88d9-7c10c9ad62dc', 4, 'Kedungglugu'),
(342, 'f0d179e4-7572-11ef-88d9-7c10c9ad62dc', 4, 'Ketawang'),
(343, 'f0d1d964-7572-11ef-88d9-7c10c9ad62dc', 4, 'Losari'),
(344, 'f0d24e40-7572-11ef-88d9-7c10c9ad62dc', 4, 'Mojoseto'),
(345, 'f0d2af71-7572-11ef-88d9-7c10c9ad62dc', 4, 'Nglinggo'),
(346, 'f0d32017-7572-11ef-88d9-7c10c9ad62dc', 4, 'Ngunjung'),
(347, 'f0d38c2c-7572-11ef-88d9-7c10c9ad62dc', 4, 'Pandean'),
(348, 'f0d3eca9-7572-11ef-88d9-7c10c9ad62dc', 4, 'Sanggrahan'),
(349, 'f0d44ff4-7572-11ef-88d9-7c10c9ad62dc', 4, 'Senggowar'),
(350, 'f0d4b2a9-7572-11ef-88d9-7c10c9ad62dc', 4, 'Senjayan'),
(351, 'f0d519e6-7572-11ef-88d9-7c10c9ad62dc', 4, 'Sumberagung'),
(352, 'f0d5a13b-7572-11ef-88d9-7c10c9ad62dc', 4, 'Sumberjo'),
(353, 'f0d61660-7572-11ef-88d9-7c10c9ad62dc', 5, 'Begendeng'),
(354, 'f0d67fd1-7572-11ef-88d9-7c10c9ad62dc', 5, 'Dawuhan'),
(355, 'f0d6eae7-7572-11ef-88d9-7c10c9ad62dc', 5, 'Dlururejo'),
(356, 'f0d75345-7572-11ef-88d9-7c10c9ad62dc', 5, 'Gondang Wetan'),
(357, 'f0d7c2b7-7572-11ef-88d9-7c10c9ad62dc', 5, 'Jatikalen'),
(358, 'f0d82a84-7572-11ef-88d9-7c10c9ad62dc', 5, 'Lumpangkuwik'),
(359, 'f0d89438-7572-11ef-88d9-7c10c9ad62dc', 5, 'Munung'),
(360, 'f0d90a54-7572-11ef-88d9-7c10c9ad62dc', 5, 'Ngasem'),
(361, 'f0d97ccc-7572-11ef-88d9-7c10c9ad62dc', 5, 'Pernin'),
(362, 'f0d9e8b9-7572-11ef-88d9-7c10c9ad62dc', 5, 'Pule'),
(363, 'f0da5b8f-7572-11ef-88d9-7c10c9ad62dc', 5, 'Pulowetan'),
(364, 'f0dad079-7572-11ef-88d9-7c10c9ad62dc', 6, 'Bangsri'),
(365, 'f0db3c49-7572-11ef-88d9-7c10c9ad62dc', 6, 'Drenges'),
(366, 'f0dba787-7572-11ef-88d9-7c10c9ad62dc', 6, 'Kalianyar'),
(367, 'f0dc0dfe-7572-11ef-88d9-7c10c9ad62dc', 6, 'Kepuh'),
(368, 'f0dc729a-7572-11ef-88d9-7c10c9ad62dc', 6, 'Kudu'),
(369, 'f0dcd667-7572-11ef-88d9-7c10c9ad62dc', 6, 'Kutorejo'),
(370, 'f0dd3c5d-7572-11ef-88d9-7c10c9ad62dc', 6, 'Lambangkuning'),
(371, 'f0ddae47-7572-11ef-88d9-7c10c9ad62dc', 6, 'Nglawak'),
(372, 'f0de2082-7572-11ef-88d9-7c10c9ad62dc', 6, 'Pandantoyo'),
(373, 'f0de8ed8-7572-11ef-88d9-7c10c9ad62dc', 6, 'Pelem'),
(374, 'f0df0aed-7572-11ef-88d9-7c10c9ad62dc', 6, 'Tanjung'),
(375, 'f0df7441-7572-11ef-88d9-7c10c9ad62dc', 6, 'Tembarak'),
(376, 'f0dfd4bc-7572-11ef-88d9-7c10c9ad62dc', 6, 'Yuwono'),
(377, 'f0e0490b-7572-11ef-88d9-7c10c9ad62dc', 6, 'Kelurahan Banaran'),
(378, 'f0e0ae50-7572-11ef-88d9-7c10c9ad62dc', 7, 'Balongasem'),
(379, 'f0e1166c-7572-11ef-88d9-7c10c9ad62dc', 7, 'Bangle'),
(380, 'f0e178d0-7572-11ef-88d9-7c10c9ad62dc', 7, 'Banjardowo'),
(381, 'f0e1daa7-7572-11ef-88d9-7c10c9ad62dc', 7, 'Jatipunggur'),
(382, 'f0e23f3d-7572-11ef-88d9-7c10c9ad62dc', 7, 'Jegreg'),
(383, 'f0e2a61b-7572-11ef-88d9-7c10c9ad62dc', 7, 'Kedungmlaten'),
(384, 'f0e31dd7-7572-11ef-88d9-7c10c9ad62dc', 7, 'Ketandan'),
(385, 'f0e38676-7572-11ef-88d9-7c10c9ad62dc', 7, 'Lengkong'),
(386, 'f0e3e6bc-7572-11ef-88d9-7c10c9ad62dc', 7, 'Ngepung'),
(387, 'f0e44d61-7572-11ef-88d9-7c10c9ad62dc', 7, 'Ngringin'),
(388, 'f0e4b216-7572-11ef-88d9-7c10c9ad62dc', 7, 'Pinggir'),
(389, 'f0e51504-7572-11ef-88d9-7c10c9ad62dc', 7, 'Prayungan'),
(390, 'f0e583f3-7572-11ef-88d9-7c10c9ad62dc', 7, 'Sawahan'),
(391, 'f0e5f0f9-7572-11ef-88d9-7c10c9ad62dc', 7, 'Sumberkepuh'),
(392, 'f0e65ed4-7572-11ef-88d9-7c10c9ad62dc', 7, 'Sumbermiri'),
(393, 'f0e6c99b-7572-11ef-88d9-7c10c9ad62dc', 7, 'Sumbersono'),
(394, 'f0e728ab-7572-11ef-88d9-7c10c9ad62dc', 8, 'Bajulan'),
(395, 'f0e79014-7572-11ef-88d9-7c10c9ad62dc', 8, 'Candirejo'),
(396, 'f0e7f21e-7572-11ef-88d9-7c10c9ad62dc', 8, 'Gejagan'),
(397, 'f0e867a6-7572-11ef-88d9-7c10c9ad62dc', 8, 'Genjeng'),
(398, 'f0e8ce58-7572-11ef-88d9-7c10c9ad62dc', 8, 'Godean'),
(399, 'f0e93a2e-7572-11ef-88d9-7c10c9ad62dc', 8, 'Jatirejo'),
(400, 'f0e9a8b8-7572-11ef-88d9-7c10c9ad62dc', 8, 'Karangsono'),
(401, 'f0ea0dc6-7572-11ef-88d9-7c10c9ad62dc', 8, 'Kenep'),
(402, 'f0ea6fca-7572-11ef-88d9-7c10c9ad62dc', 8, 'Kwagean'),
(403, 'f0ead88a-7572-11ef-88d9-7c10c9ad62dc', 8, 'Loceret'),
(404, 'f0eb3f76-7572-11ef-88d9-7c10c9ad62dc', 8, 'Macanan'),
(405, 'f0ebb583-7572-11ef-88d9-7c10c9ad62dc', 8, 'Mungkung'),
(406, 'f0ec1bde-7572-11ef-88d9-7c10c9ad62dc', 8, 'Ngepeh'),
(407, 'f0ec7c85-7572-11ef-88d9-7c10c9ad62dc', 8, 'Nglaban'),
(408, 'f0ecf2a5-7572-11ef-88d9-7c10c9ad62dc', 8, 'Patihan'),
(409, 'f0ed68bb-7572-11ef-88d9-7c10c9ad62dc', 8, 'Putukrejo'),
(410, 'f0ede2d5-7572-11ef-88d9-7c10c9ad62dc', 8, 'Sekaran'),
(411, 'f0ee4e76-7572-11ef-88d9-7c10c9ad62dc', 8, 'Sombron'),
(412, 'f0eeb038-7572-11ef-88d9-7c10c9ad62dc', 8, 'Sukorejo'),
(413, 'f0ef1c32-7572-11ef-88d9-7c10c9ad62dc', 8, 'Tanjungrejo'),
(414, 'f0ef7f32-7572-11ef-88d9-7c10c9ad62dc', 8, 'Teken Glagahan'),
(415, 'f0efe1a5-7572-11ef-88d9-7c10c9ad62dc', 8, 'Tempel Wetan'),
(416, 'f0f045b6-7572-11ef-88d9-7c10c9ad62dc', 9, 'Balongpacul'),
(417, 'f0f0ad88-7572-11ef-88d9-7c10c9ad62dc', 9, 'Kedungdowo'),
(418, 'f0f11300-7572-11ef-88d9-7c10c9ad62dc', 9, 'Kelurahan Begadung'),
(419, 'f0f17920-7572-11ef-88d9-7c10c9ad62dc', 9, 'Kelurahan Bogo'),
(420, 'f0f1e083-7572-11ef-88d9-7c10c9ad62dc', 9, 'Kelurahan Cangkringan'),
(421, 'f0f24336-7572-11ef-88d9-7c10c9ad62dc', 9, 'Kelurahan Ganungkidul'),
(422, 'f0f2a62c-7572-11ef-88d9-7c10c9ad62dc', 9, 'Kelurahan Jatirejo'),
(423, 'f0f30c06-7572-11ef-88d9-7c10c9ad62dc', 9, 'Kelurahan Kartoharjo'),
(424, 'f0f3731c-7572-11ef-88d9-7c10c9ad62dc', 9, 'Kelurahan Kauman'),
(425, 'f0f3df36-7572-11ef-88d9-7c10c9ad62dc', 9, 'Kelurahan Kramat'),
(426, 'f0f4593c-7572-11ef-88d9-7c10c9ad62dc', 9, 'Kelurahan Mangundikaran'),
(427, 'f0f4c3f2-7572-11ef-88d9-7c10c9ad62dc', 9, 'Kelurahan Payaman'),
(428, 'f0f53073-7572-11ef-88d9-7c10c9ad62dc', 9, 'Kelurahan Ploso'),
(429, 'f0f59209-7572-11ef-88d9-7c10c9ad62dc', 9, 'Kelurahan Ringinanom'),
(430, 'f0f5fe36-7572-11ef-88d9-7c10c9ad62dc', 9, 'Kelurahan Werungotok'),
(431, 'f0f671d7-7572-11ef-88d9-7c10c9ad62dc', 10, 'Blongko'),
(432, 'f0f6dbf3-7572-11ef-88d9-7c10c9ad62dc', 10, 'Kepel'),
(433, 'f0f74d62-7572-11ef-88d9-7c10c9ad62dc', 10, 'Klodan'),
(434, 'f0f7b0fc-7572-11ef-88d9-7c10c9ad62dc', 10, 'Kuncir'),
(435, 'f0f817e5-7572-11ef-88d9-7c10c9ad62dc', 10, 'Kweden'),
(436, 'f0f88032-7572-11ef-88d9-7c10c9ad62dc', 10, 'Mojoduwur'),
(437, 'f0f8e2d8-7572-11ef-88d9-7c10c9ad62dc', 10, 'Ngetos'),
(438, 'f0f94313-7572-11ef-88d9-7c10c9ad62dc', 10, 'Oro-oro Ombo'),
(439, 'f0f9ad6c-7572-11ef-88d9-7c10c9ad62dc', 10, 'Suru'),
(440, 'f0fa1284-7572-11ef-88d9-7c10c9ad62dc', 11, 'Bajang'),
(441, 'f0fa74cf-7572-11ef-88d9-7c10c9ad62dc', 11, 'Gampeng'),
(442, 'f0fad7df-7572-11ef-88d9-7c10c9ad62dc', 11, 'Lengkong Lor'),
(443, 'f0fb3e91-7572-11ef-88d9-7c10c9ad62dc', 11, 'Ngluyu'),
(444, 'f0fba110-7572-11ef-88d9-7c10c9ad62dc', 11, 'Sugihwaras'),
(445, 'f0fc0296-7572-11ef-88d9-7c10c9ad62dc', 11, 'Tempuran'),
(446, 'f0fc6253-7572-11ef-88d9-7c10c9ad62dc', 12, 'Banjarsari'),
(447, 'f0fcd4a1-7572-11ef-88d9-7c10c9ad62dc', 12, 'Betet'),
(448, 'f0fd42c9-7572-11ef-88d9-7c10c9ad62dc', 12, 'Cengkok'),
(449, 'f0fdc951-7572-11ef-88d9-7c10c9ad62dc', 12, 'Dadapan'),
(450, 'f0fe2ffa-7572-11ef-88d9-7c10c9ad62dc', 12, 'Juwet'),
(451, 'f0fe9b2d-7572-11ef-88d9-7c10c9ad62dc', 12, 'Kalianyar'),
(452, 'f0ff020d-7572-11ef-88d9-7c10c9ad62dc', 12, 'Kaloran'),
(453, 'f0ff613b-7572-11ef-88d9-7c10c9ad62dc', 12, 'Kelutan'),
(454, 'f0ffc4fc-7572-11ef-88d9-7c10c9ad62dc', 12, 'Klurahan'),
(455, 'f100329a-7572-11ef-88d9-7c10c9ad62dc', 12, 'Mojokendil'),
(456, 'f10096b5-7572-11ef-88d9-7c10c9ad62dc', 12, 'Ngronggot'),
(457, 'f100f7c5-7572-11ef-88d9-7c10c9ad62dc', 12, 'Tanjungkalang'),
(458, 'f10159b7-7572-11ef-88d9-7c10c9ad62dc', 12, 'Trayang'),
(459, 'f101b81c-7572-11ef-88d9-7c10c9ad62dc', 13, 'Babadan'),
(460, 'f1022de6-7572-11ef-88d9-7c10c9ad62dc', 13, 'Banaran'),
(461, 'f1028f40-7572-11ef-88d9-7c10c9ad62dc', 13, 'Batembat'),
(462, 'f102f2a2-7572-11ef-88d9-7c10c9ad62dc', 13, 'Bodor'),
(463, 'f1035aad-7572-11ef-88d9-7c10c9ad62dc', 13, 'Cerme'),
(464, 'f103bb28-7572-11ef-88d9-7c10c9ad62dc', 13, 'Gemenggeng'),
(465, 'f1042239-7572-11ef-88d9-7c10c9ad62dc', 13, 'Gondang'),
(466, 'f1049f9a-7572-11ef-88d9-7c10c9ad62dc', 13, 'Jampes'),
(467, 'f105a6ac-7572-11ef-88d9-7c10c9ad62dc', 13, 'Jatigreges'),
(468, 'f106143e-7572-11ef-88d9-7c10c9ad62dc', 13, 'Jetis'),
(469, 'f10684dc-7572-11ef-88d9-7c10c9ad62dc', 13, 'Joho'),
(470, 'f106f591-7572-11ef-88d9-7c10c9ad62dc', 13, 'Kecubung'),
(471, 'f1076881-7572-11ef-88d9-7c10c9ad62dc', 13, 'Kepanjen'),
(472, 'f107cd4d-7572-11ef-88d9-7c10c9ad62dc', 13, 'Mlandangan'),
(473, 'f1083250-7572-11ef-88d9-7c10c9ad62dc', 13, 'Pace Wetan'),
(474, 'f108a1fb-7572-11ef-88d9-7c10c9ad62dc', 13, 'Pacekulon'),
(475, 'f1091761-7572-11ef-88d9-7c10c9ad62dc', 13, 'Plosoharjo'),
(476, 'f1098765-7572-11ef-88d9-7c10c9ad62dc', 13, 'Sanan'),
(477, 'f109f0dc-7572-11ef-88d9-7c10c9ad62dc', 14, 'Babadan'),
(478, 'f10a5988-7572-11ef-88d9-7c10c9ad62dc', 14, 'Bukur'),
(479, 'f10ac5f2-7572-11ef-88d9-7c10c9ad62dc', 14, 'Lestari'),
(480, 'f10b28b4-7572-11ef-88d9-7c10c9ad62dc', 14, 'Ngepung'),
(481, 'f10b9702-7572-11ef-88d9-7c10c9ad62dc', 14, 'Ngrombot'),
(482, 'f10c0522-7572-11ef-88d9-7c10c9ad62dc', 14, 'Pakuncen'),
(483, 'f10c6bc0-7572-11ef-88d9-7c10c9ad62dc', 14, 'Patianrowo'),
(484, 'f10ccf5d-7572-11ef-88d9-7c10c9ad62dc', 14, 'Pecuk'),
(485, 'f10d2c4c-7572-11ef-88d9-7c10c9ad62dc', 14, 'Pisang'),
(486, 'f10d9fa0-7572-11ef-88d9-7c10c9ad62dc', 14, 'Rowomarto'),
(487, 'f10e10af-7572-11ef-88d9-7c10c9ad62dc', 14, 'Tirtobinangun'),
(488, 'f10e6e12-7572-11ef-88d9-7c10c9ad62dc', 15, 'Baleturi'),
(489, 'f10efdff-7572-11ef-88d9-7c10c9ad62dc', 15, 'Bandung'),
(490, 'f10f58c5-7572-11ef-88d9-7c10c9ad62dc', 15, 'Gondanglegi'),
(491, 'f10fb8e8-7572-11ef-88d9-7c10c9ad62dc', 15, 'Kurungrejo'),
(492, 'f1101d54-7572-11ef-88d9-7c10c9ad62dc', 15, 'Mojoagung'),
(493, 'f1108173-7572-11ef-88d9-7c10c9ad62dc', 15, 'Nglawak'),
(494, 'f110e8a7-7572-11ef-88d9-7c10c9ad62dc', 15, 'Rowoharjo'),
(495, 'f1114d08-7572-11ef-88d9-7c10c9ad62dc', 15, 'Sanggrahan'),
(496, 'f111aea6-7572-11ef-88d9-7c10c9ad62dc', 15, 'Singkalanyar'),
(497, 'f1121477-7572-11ef-88d9-7c10c9ad62dc', 15, 'Sono Ageng'),
(498, 'f1127188-7572-11ef-88d9-7c10c9ad62dc', 15, 'Sugihwaras'),
(499, 'f112dbe9-7572-11ef-88d9-7c10c9ad62dc', 15, 'Tanjungtani'),
(500, 'f1134b2f-7572-11ef-88d9-7c10c9ad62dc', 15, 'Tegaron'),
(501, 'f113a92b-7572-11ef-88d9-7c10c9ad62dc', 15, 'Watudandang'),
(502, 'f11406a5-7572-11ef-88d9-7c10c9ad62dc', 16, 'Banjarejo'),
(503, 'f1146270-7572-11ef-88d9-7c10c9ad62dc', 16, 'Bendoasri'),
(504, 'f114bd6c-7572-11ef-88d9-7c10c9ad62dc', 16, 'Gempol'),
(505, 'f115347b-7572-11ef-88d9-7c10c9ad62dc', 16, 'Jatirejo'),
(506, 'f1159d5e-7572-11ef-88d9-7c10c9ad62dc', 16, 'Jintel'),
(507, 'f115fd22-7572-11ef-88d9-7c10c9ad62dc', 16, 'Kedungpadang'),
(508, 'f1165c61-7572-11ef-88d9-7c10c9ad62dc', 16, 'Klagen'),
(509, 'f116bc7a-7572-11ef-88d9-7c10c9ad62dc', 16, 'Mlorah'),
(510, 'f1172970-7572-11ef-88d9-7c10c9ad62dc', 16, 'Mojorembun'),
(511, 'f117968a-7572-11ef-88d9-7c10c9ad62dc', 16, 'Mungkung'),
(512, 'f117fd2d-7572-11ef-88d9-7c10c9ad62dc', 16, 'Musir Kidul'),
(513, 'f11868e7-7572-11ef-88d9-7c10c9ad62dc', 16, 'Musir Lor'),
(514, 'f118c6a1-7572-11ef-88d9-7c10c9ad62dc', 16, 'Ngadiboyo'),
(515, 'f1192fd5-7572-11ef-88d9-7c10c9ad62dc', 16, 'Ngangkatan'),
(516, 'f1198d77-7572-11ef-88d9-7c10c9ad62dc', 16, 'Puhkerep'),
(517, 'f119f695-7572-11ef-88d9-7c10c9ad62dc', 16, 'Rejoso'),
(518, 'f11a5c6a-7572-11ef-88d9-7c10c9ad62dc', 16, 'Sambikerep'),
(519, 'f11ad464-7572-11ef-88d9-7c10c9ad62dc', 16, 'Setren'),
(520, 'f11b498c-7572-11ef-88d9-7c10c9ad62dc', 16, 'Sidokare'),
(521, 'f11bb4a5-7572-11ef-88d9-7c10c9ad62dc', 16, 'Sukorejo'),
(522, 'f11c1d1e-7572-11ef-88d9-7c10c9ad62dc', 16, 'Talang'),
(523, 'f11c83b6-7572-11ef-88d9-7c10c9ad62dc', 16, 'Talun'),
(524, 'f11ce070-7572-11ef-88d9-7c10c9ad62dc', 16, 'Tritik'),
(525, 'f11d5f19-7572-11ef-88d9-7c10c9ad62dc', 16, 'Wengkal'),
(526, 'f11dc813-7572-11ef-88d9-7c10c9ad62dc', 17, 'Bareng'),
(527, 'f11e28a3-7572-11ef-88d9-7c10c9ad62dc', 17, 'Bendolo'),
(528, 'f11e8809-7572-11ef-88d9-7c10c9ad62dc', 17, 'Duren'),
(529, 'f11eeeed-7572-11ef-88d9-7c10c9ad62dc', 17, 'Kebonagung'),
(530, 'f11f48fb-7572-11ef-88d9-7c10c9ad62dc', 17, 'Margopatut'),
(531, 'f11facfc-7572-11ef-88d9-7c10c9ad62dc', 17, 'Ngliman'),
(532, 'f120086f-7572-11ef-88d9-7c10c9ad62dc', 17, 'Sawahan'),
(533, 'f12063bc-7572-11ef-88d9-7c10c9ad62dc', 17, 'Sidorejo'),
(534, 'f120c85e-7572-11ef-88d9-7c10c9ad62dc', 17, 'Siwalan'),
(535, 'f12129a7-7572-11ef-88d9-7c10c9ad62dc', 18, 'Bagor Wetan'),
(536, 'f1218849-7572-11ef-88d9-7c10c9ad62dc', 18, 'Blitaran'),
(537, 'f121f603-7572-11ef-88d9-7c10c9ad62dc', 18, 'Bungur'),
(538, 'f122631e-7572-11ef-88d9-7c10c9ad62dc', 18, 'Kedungsoko'),
(539, 'f122c4db-7572-11ef-88d9-7c10c9ad62dc', 18, 'Nglundo'),
(540, 'f1233143-7572-11ef-88d9-7c10c9ad62dc', 18, 'Ngrami'),
(541, 'f123986b-7572-11ef-88d9-7c10c9ad62dc', 18, 'Ngrengket'),
(542, 'f1240458-7572-11ef-88d9-7c10c9ad62dc', 18, 'Pehserut'),
(543, 'f124632b-7572-11ef-88d9-7c10c9ad62dc', 18, 'Putren'),
(544, 'f124c27e-7572-11ef-88d9-7c10c9ad62dc', 18, 'Sumengko'),
(545, 'f1252696-7572-11ef-88d9-7c10c9ad62dc', 18, 'Kelurahan Kapas'),
(546, 'f1258d3a-7572-11ef-88d9-7c10c9ad62dc', 18, 'Kelurahan Sukomoro'),
(547, 'f125f581-7572-11ef-88d9-7c10c9ad62dc', 19, 'Kedungombo'),
(548, 'f1265861-7572-11ef-88d9-7c10c9ad62dc', 19, 'Sumberkepuh'),
(549, 'f126bd7a-7572-11ef-88d9-7c10c9ad62dc', 19, 'Kampungbaru'),
(550, 'f1272558-7572-11ef-88d9-7c10c9ad62dc', 19, 'Wates'),
(551, 'f12787b2-7572-11ef-88d9-7c10c9ad62dc', 19, 'Malangsari'),
(552, 'f127e5a5-7572-11ef-88d9-7c10c9ad62dc', 19, 'Getas'),
(553, 'f12854a8-7572-11ef-88d9-7c10c9ad62dc', 19, 'Sonobekel'),
(554, 'f128c5fe-7572-11ef-88d9-7c10c9ad62dc', 19, 'Ngadirejo'),
(555, 'f1292f76-7572-11ef-88d9-7c10c9ad62dc', 19, 'Banjaranyar'),
(556, 'f12993d4-7572-11ef-88d9-7c10c9ad62dc', 19, 'Sidoharjo'),
(557, 'f129f674-7572-11ef-88d9-7c10c9ad62dc', 19, 'Jogomerto'),
(558, 'f12a5af1-7572-11ef-88d9-7c10c9ad62dc', 19, 'Kedungrejo'),
(559, 'f12abf39-7572-11ef-88d9-7c10c9ad62dc', 19, 'Sambirejo'),
(560, 'f12b302f-7572-11ef-88d9-7c10c9ad62dc', 19, 'Demangan'),
(561, 'f12b9d36-7572-11ef-88d9-7c10c9ad62dc', 19, 'Kelurahan Tanjunganom'),
(562, 'f12c05bc-7572-11ef-88d9-7c10c9ad62dc', 19, 'Kelurahan Warungjayeng'),
(563, 'f12c6e95-7572-11ef-88d9-7c10c9ad62dc', 20, 'Mancon'),
(564, 'f12cdfad-7572-11ef-88d9-7c10c9ad62dc', 20, 'Ngadipiro'),
(565, 'f12d4fa6-7572-11ef-88d9-7c10c9ad62dc', 20, 'Ngudikan'),
(566, 'f12dae72-7572-11ef-88d9-7c10c9ad62dc', 20, 'Sudimoroharjo'),
(567, 'f12e15d4-7572-11ef-88d9-7c10c9ad62dc', 20, 'Sukoharjo'),
(568, 'f12e82f6-7572-11ef-88d9-7c10c9ad62dc', 20, 'Wilangan');

-- --------------------------------------------------------

--
-- Struktur dari tabel `visitors`
--

CREATE TABLE `visitors` (
  `tanggal` date NOT NULL,
  `count` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data untuk tabel `visitors`
--

INSERT INTO `visitors` (`tanggal`, `count`, `created_at`, `updated_at`) VALUES
('2023-08-25', 16, NULL, NULL),
('2023-08-26', 22, NULL, NULL),
('2023-08-27', 31, NULL, NULL),
('2023-08-28', 25, NULL, NULL),
('2023-08-29', 41, NULL, NULL),
('2023-08-30', 25, NULL, NULL),
('2023-08-31', 58, NULL, '2023-08-31 07:22:48'),
('2023-09-01', 72, '2023-08-31 18:02:03', '2023-08-31 21:53:06'),
('2023-09-03', 3, '2023-09-02 22:57:19', '2023-09-02 22:59:43'),
('2023-09-04', 3, '2023-09-03 20:15:27', '2023-09-03 20:26:39'),
('2023-09-05', 7, '2023-09-04 22:34:03', '2023-09-05 08:26:30'),
('2023-09-06', 5, '2023-09-05 18:29:26', '2023-09-05 20:13:29'),
('2023-09-07', 3, '2023-09-07 07:35:35', '2023-09-07 07:37:23'),
('2023-09-08', 46, '2023-09-07 18:02:27', '2023-09-07 23:05:51'),
('2023-11-04', 6, '2023-11-04 04:14:51', '2023-11-04 16:38:49'),
('2023-11-05', 67, '2023-11-04 17:08:58', '2023-11-05 16:39:50'),
('2023-11-06', 47, '2023-11-05 17:09:21', '2023-11-06 16:43:28'),
('2023-11-07', 17, '2023-11-06 17:11:06', '2023-11-07 00:11:12'),
('2023-11-16', 7, '2023-11-16 04:36:25', '2023-11-16 04:39:14'),
('2023-11-18', 2, '2023-11-18 06:17:54', '2023-11-18 06:18:31'),
('2023-11-22', 3, '2023-11-21 19:48:13', '2023-11-22 08:59:41'),
('2023-12-02', 1, '2023-12-02 06:05:06', '2023-12-02 06:05:06'),
('2023-12-11', 1, '2023-12-10 22:13:22', '2023-12-10 22:13:22'),
('2023-12-14', 38, '2023-12-13 23:31:20', '2023-12-14 16:38:11'),
('2023-12-15', 50, '2023-12-14 17:08:02', '2023-12-15 16:38:09'),
('2023-12-16', 50, '2023-12-15 17:08:42', '2023-12-16 16:38:28'),
('2023-12-17', 49, '2023-12-16 17:07:46', '2023-12-17 16:40:34'),
('2023-12-18', 38, '2023-12-17 17:42:34', '2023-12-18 16:39:49'),
('2023-12-19', 50, '2023-12-18 17:12:20', '2023-12-19 16:38:22'),
('2023-12-20', 48, '2023-12-19 17:08:50', '2023-12-20 16:37:47'),
('2023-12-21', 50, '2023-12-20 17:07:48', '2023-12-21 16:38:13'),
('2023-12-22', 51, '2023-12-21 17:08:09', '2023-12-22 16:37:57'),
('2023-12-23', 50, '2023-12-22 17:08:13', '2023-12-23 16:39:12'),
('2023-12-24', 51, '2023-12-23 17:09:22', '2023-12-24 16:39:56'),
('2023-12-25', 42, '2023-12-24 17:09:54', '2023-12-25 16:40:34'),
('2023-12-26', 43, '2023-12-25 17:11:24', '2023-12-26 16:38:16'),
('2023-12-27', 49, '2023-12-26 17:08:25', '2023-12-27 16:38:18'),
('2023-12-28', 50, '2023-12-27 17:08:35', '2023-12-28 16:38:17'),
('2023-12-29', 50, '2023-12-28 17:08:24', '2023-12-29 16:38:31'),
('2023-12-30', 48, '2023-12-29 17:08:05', '2023-12-30 16:38:25'),
('2023-12-31', 48, '2023-12-30 17:07:51', '2023-12-31 16:38:35'),
('2024-01-01', 51, '2023-12-31 17:09:53', '2024-01-01 16:40:09'),
('2024-01-02', 51, '2024-01-01 17:09:12', '2024-01-02 16:38:00'),
('2024-01-03', 48, '2024-01-02 17:08:32', '2024-01-03 16:38:18'),
('2024-01-04', 50, '2024-01-03 17:07:56', '2024-01-04 16:38:06'),
('2024-01-05', 50, '2024-01-04 17:08:21', '2024-01-05 16:38:00'),
('2024-01-06', 50, '2024-01-05 17:08:08', '2024-01-06 16:37:59'),
('2024-01-07', 51, '2024-01-06 17:08:27', '2024-01-07 16:44:28'),
('2024-01-08', 40, '2024-01-07 17:10:32', '2024-01-08 16:41:13'),
('2024-01-09', 49, '2024-01-08 17:10:34', '2024-01-09 16:38:08'),
('2024-01-10', 51, '2024-01-09 17:07:38', '2024-01-10 16:37:31'),
('2024-01-11', 50, '2024-01-10 17:07:38', '2024-01-11 16:37:46'),
('2024-01-12', 46, '2024-01-11 17:07:58', '2024-01-12 16:37:57'),
('2024-01-13', 48, '2024-01-12 17:07:21', '2024-01-13 16:37:55'),
('2024-01-14', 49, '2024-01-13 17:07:35', '2024-01-14 16:38:16'),
('2024-01-15', 44, '2024-01-14 17:08:17', '2024-01-15 16:38:09'),
('2024-01-16', 46, '2024-01-15 17:08:18', '2024-01-16 16:37:49'),
('2024-01-17', 50, '2024-01-16 17:07:50', '2024-01-17 16:37:55'),
('2024-01-18', 47, '2024-01-17 17:07:32', '2024-01-18 16:37:51'),
('2024-01-19', 50, '2024-01-18 17:07:21', '2024-01-19 16:37:06'),
('2024-01-20', 48, '2024-01-19 17:07:48', '2024-01-20 16:37:23'),
('2024-01-21', 52, '2024-01-20 17:07:27', '2024-01-21 16:37:40'),
('2024-01-22', 49, '2024-01-21 17:07:39', '2024-01-22 16:37:53'),
('2024-01-23', 48, '2024-01-22 17:07:41', '2024-01-23 16:36:37'),
('2024-01-24', 50, '2024-01-23 17:06:09', '2024-01-24 16:36:26'),
('2024-01-25', 50, '2024-01-24 17:06:30', '2024-01-25 16:37:06'),
('2024-01-26', 50, '2024-01-25 17:06:39', '2024-01-26 16:36:25'),
('2024-01-27', 49, '2024-01-26 17:06:16', '2024-01-27 16:36:20'),
('2024-01-28', 48, '2024-01-27 17:06:13', '2024-01-28 16:36:28'),
('2024-01-29', 48, '2024-01-28 17:08:06', '2024-01-29 16:36:04'),
('2024-01-30', 47, '2024-01-29 17:06:10', '2024-01-30 16:36:52'),
('2024-01-31', 51, '2024-01-30 17:06:12', '2024-01-31 16:36:22'),
('2024-02-01', 50, '2024-01-31 17:06:08', '2024-02-01 16:36:20'),
('2024-02-02', 48, '2024-02-01 17:06:10', '2024-02-02 16:35:56'),
('2024-02-03', 69, '2024-02-02 17:05:58', '2024-02-03 16:35:57'),
('2024-02-04', 48, '2024-02-03 17:06:05', '2024-02-04 16:35:59'),
('2024-02-05', 47, '2024-02-04 17:06:30', '2024-02-05 16:36:54'),
('2024-02-06', 44, '2024-02-05 17:07:52', '2024-02-06 15:38:33'),
('2024-02-07', 49, '2024-02-06 17:36:49', '2024-02-07 16:36:20'),
('2024-02-08', 48, '2024-02-07 17:05:55', '2024-02-08 16:35:56'),
('2024-02-09', 48, '2024-02-08 17:05:24', '2024-02-09 16:35:24'),
('2024-02-10', 48, '2024-02-09 17:05:03', '2024-02-10 16:35:06'),
('2024-02-11', 50, '2024-02-10 17:05:31', '2024-02-11 16:36:10'),
('2024-02-12', 54, '2024-02-11 17:05:48', '2024-02-12 16:36:42'),
('2024-02-13', 50, '2024-02-12 17:06:46', '2024-02-13 16:37:50'),
('2024-02-14', 51, '2024-02-13 17:05:44', '2024-02-14 16:35:17'),
('2024-02-15', 48, '2024-02-14 17:05:24', '2024-02-15 16:35:43'),
('2024-02-16', 60, '2024-02-15 17:05:05', '2024-02-16 16:35:07'),
('2024-02-17', 48, '2024-02-16 17:05:17', '2024-02-17 16:35:06'),
('2024-02-18', 65, '2024-02-17 17:05:38', '2024-02-18 16:35:55'),
('2024-02-19', 7, '2024-02-18 17:05:14', '2024-02-18 19:16:00'),
('2024-07-20', 9, '2024-07-20 07:50:32', '2024-07-20 15:28:50'),
('2024-07-21', 73, '2024-07-20 21:21:16', '2024-07-21 16:03:19'),
('2024-07-22', 282, '2024-07-21 18:06:28', '2024-07-22 16:59:44'),
('2024-07-23', 5, '2024-07-22 18:20:36', '2024-07-23 05:24:32'),
('2024-07-24', 9, '2024-07-23 21:05:40', '2024-07-24 08:30:14'),
('2024-07-25', 1, '2024-07-25 05:22:32', '2024-07-25 05:22:32'),
('2024-07-26', 3, '2024-07-26 01:52:01', '2024-07-26 02:00:48'),
('2024-07-28', 2, '2024-07-28 11:56:01', '2024-07-28 13:58:26'),
('2024-07-29', 3, '2024-07-28 21:06:13', '2024-07-29 16:10:40'),
('2024-07-30', 6, '2024-07-30 01:54:06', '2024-07-30 08:08:15'),
('2024-07-31', 3, '2024-07-30 19:30:16', '2024-07-30 19:34:55'),
('2024-08-01', 5, '2024-07-31 22:09:42', '2024-08-01 05:15:38'),
('2024-08-04', 1, '2024-08-04 14:47:31', '2024-08-04 14:47:31'),
('2024-08-05', 1, '2024-08-05 01:27:49', '2024-08-05 01:27:49'),
('2024-08-06', 3, '2024-08-05 22:58:10', '2024-08-06 01:56:07'),
('2024-08-07', 4, '2024-08-06 17:03:09', '2024-08-07 02:11:11'),
('2024-08-08', 1, '2024-08-07 20:04:41', '2024-08-07 20:04:41'),
('2024-08-09', 2, '2024-08-08 23:58:36', '2024-08-08 23:58:38'),
('2024-08-15', 2, '2024-08-15 05:01:47', '2024-08-15 05:01:49'),
('2024-08-17', 6, '2024-08-17 02:34:14', '2024-08-17 02:34:18'),
('2024-08-19', 24, '2024-08-18 21:00:29', '2024-08-19 16:16:46'),
('2024-08-20', 3, '2024-08-19 22:09:33', '2024-08-19 22:51:54'),
('2025-04-29', 2, '2025-04-29 04:44:29', '2025-04-29 04:45:27'),
('2025-04-30', 2, '2025-04-30 00:51:32', '2025-04-30 02:00:14'),
('2025-05-01', 1, '2025-04-30 18:11:54', '2025-04-30 18:11:54'),
('2025-05-13', 3, '2025-05-13 07:00:11', '2025-05-13 07:09:42'),
('2025-05-14', 5, '2025-05-14 00:08:28', '2025-05-14 00:25:06'),
('2025-05-15', 5, '2025-05-14 18:40:04', '2025-05-14 19:35:25'),
('2025-05-20', 1, '2025-05-19 20:07:33', '2025-05-19 20:07:33'),
('2025-05-22', 1, '2025-05-22 07:04:33', '2025-05-22 07:04:33'),
('2026-04-01', 10, '2026-03-31 18:45:05', '2026-03-31 20:44:21'),
('2026-04-05', 4, '2026-04-05 02:10:42', '2026-04-05 03:52:39'),
('2026-04-07', 2, '2026-04-06 19:01:23', '2026-04-06 21:11:08'),
('2026-04-08', 7, '2026-04-08 05:05:13', '2026-04-08 07:08:30'),
('2026-04-09', 5, '2026-04-08 18:44:39', '2026-04-08 21:20:18'),
('2026-04-12', 4, '2026-04-12 06:21:34', '2026-04-12 06:48:07'),
('2026-04-13', 1, '2026-04-12 19:10:40', '2026-04-12 19:10:40'),
('2026-04-16', 3, '2026-04-16 01:29:30', '2026-04-16 01:30:44'),
('2026-04-22', 4, '2026-04-22 01:50:15', '2026-04-22 01:51:14'),
('2026-04-23', 3, '2026-04-23 01:36:04', '2026-04-23 06:42:41'),
('2026-04-24', 2, '2026-04-23 20:22:49', '2026-04-23 20:30:48'),
('2026-04-26', 287, '2026-04-25 18:10:33', '2026-04-26 00:16:13'),
('2026-04-28', 12, '2026-04-27 21:10:38', '2026-04-27 21:33:57'),
('2026-04-30', 3, '2026-04-29 18:53:40', '2026-04-30 00:14:11'),
('2026-05-01', 10, '2026-04-30 23:46:31', '2026-05-01 01:31:25'),
('2026-05-02', 7, '2026-05-02 09:06:40', '2026-05-02 10:57:37'),
('2026-05-03', 1, '2026-05-02 23:25:21', '2026-05-02 23:25:21'),
('2026-05-04', 4, '2026-05-03 23:37:04', '2026-05-04 00:25:05'),
('2026-05-06', 1, '2026-05-06 07:32:52', '2026-05-06 07:32:52'),
('2026-05-08', 12, '2026-05-08 03:37:16', '2026-05-08 03:57:42'),
('2026-05-11', 60, '2026-05-10 20:23:48', '2026-05-11 04:58:47'),
('2026-05-12', 4, '2026-05-11 18:27:59', '2026-05-11 18:30:16'),
('2026-05-13', 65, '2026-05-13 01:25:19', '2026-05-13 09:02:38'),
('2026-05-15', 39, '2026-05-14 19:00:52', '2026-05-15 10:39:32'),
('2026-05-16', 41, '2026-05-15 18:52:51', '2026-05-16 09:35:57'),
('2026-05-17', 14, '2026-05-16 19:51:34', '2026-05-16 22:22:57'),
('2026-05-18', 79, '2026-05-17 21:24:28', '2026-05-18 09:21:33'),
('2026-05-19', 76, '2026-05-18 17:58:57', '2026-05-19 08:26:34'),
('2026-05-20', 17, '2026-05-19 18:35:47', '2026-05-20 06:33:13'),
('2026-05-21', 158, '2026-05-20 17:10:24', '2026-05-21 23:17:08'),
('2026-05-22', 34, '2026-05-22 00:21:31', '2026-05-22 20:31:02'),
('2026-05-23', 35, '2026-05-23 01:56:20', '2026-05-23 12:59:03');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `animals`
--
ALTER TABLE `animals`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uuid` (`uuid`),
  ADD UNIQUE KEY `slug` (`slug`);

--
-- Indeks untuk tabel `beritas`
--
ALTER TABLE `beritas`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `detail_pokja`
--
ALTER TABLE `detail_pokja`
  ADD PRIMARY KEY (`id_detail_pokja`);

--
-- Indeks untuk tabel `galerys`
--
ALTER TABLE `galerys`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uuid` (`uuid`),
  ADD KEY `id_user` (`id_user`),
  ADD KEY `id_role` (`id_role`),
  ADD KEY `id_organization` (`id_organization`);

--
-- Indeks untuk tabel `kegiatan_pokja4`
--
ALTER TABLE `kegiatan_pokja4`
  ADD PRIMARY KEY (`id_kegiatan_pokja4`),
  ADD KEY `fk_pokja4_user` (`id_user`),
  ADD KEY `fk_pokja4_role` (`id_role`),
  ADD KEY `fk_pokja4_organization` (`id_organization`);

--
-- Indeks untuk tabel `laporan_bidang_kesehatan`
--
ALTER TABLE `laporan_bidang_kesehatan`
  ADD PRIMARY KEY (`id_pokja4_bidang1`),
  ADD UNIQUE KEY `uuid` (`uuid`),
  ADD KEY `id_user` (`id_user`),
  ADD KEY `id_role` (`id_role`),
  ADD KEY `id_organization` (`id_organization`);

--
-- Indeks untuk tabel `laporan_gotong_royong`
--
ALTER TABLE `laporan_gotong_royong`
  ADD PRIMARY KEY (`id_pokja1_bidang2`),
  ADD UNIQUE KEY `uuid` (`uuid`),
  ADD KEY `id_user` (`id_user`),
  ADD KEY `id_role` (`id_role`),
  ADD KEY `id_organization` (`id_organization`);

--
-- Indeks untuk tabel `laporan_kader_pokja1`
--
ALTER TABLE `laporan_kader_pokja1`
  ADD PRIMARY KEY (`id_kader_pokja1`),
  ADD UNIQUE KEY `uuid` (`uuid`),
  ADD KEY `id_user` (`id_user`),
  ADD KEY `id_role` (`id_role`),
  ADD KEY `id_organization` (`id_organization`);

--
-- Indeks untuk tabel `laporan_kader_pokja3`
--
ALTER TABLE `laporan_kader_pokja3`
  ADD PRIMARY KEY (`id_kader_pokja3`),
  ADD UNIQUE KEY `uuid` (`uuid`),
  ADD KEY `id_user` (`id_user`),
  ADD KEY `id_role` (`id_role`),
  ADD KEY `id_organization` (`id_organization`);

--
-- Indeks untuk tabel `laporan_kader_pokja4`
--
ALTER TABLE `laporan_kader_pokja4`
  ADD PRIMARY KEY (`id_kader_pokja4`),
  ADD UNIQUE KEY `uuid` (`uuid`),
  ADD KEY `id_user` (`id_user`),
  ADD KEY `id_role` (`id_role`),
  ADD KEY `id_organization` (`id_organization`);

--
-- Indeks untuk tabel `laporan_kelestarian_lingkungan_hidup`
--
ALTER TABLE `laporan_kelestarian_lingkungan_hidup`
  ADD PRIMARY KEY (`id_pokja4_bidang2`),
  ADD UNIQUE KEY `uuid` (`uuid`) USING BTREE,
  ADD KEY `id_user` (`id_user`),
  ADD KEY `id_role` (`id_role`),
  ADD KEY `id_organization` (`id_organization`);

--
-- Indeks untuk tabel `laporan_pangan`
--
ALTER TABLE `laporan_pangan`
  ADD PRIMARY KEY (`id_pokja3_bidang1`),
  ADD UNIQUE KEY `uuid` (`uuid`),
  ADD KEY `id_user` (`id_user`),
  ADD KEY `id_role` (`id_role`),
  ADD KEY `id_organization` (`id_organization`);

--
-- Indeks untuk tabel `laporan_pendidikan_n_keterampilan`
--
ALTER TABLE `laporan_pendidikan_n_keterampilan`
  ADD PRIMARY KEY (`id_pokja2_bidang1`),
  ADD UNIQUE KEY `uuid` (`uuid`) USING BTREE,
  ADD KEY `id_user` (`id_user`) USING BTREE,
  ADD KEY `id_role` (`id_role`),
  ADD KEY `id_organization` (`id_organization`);

--
-- Indeks untuk tabel `laporan_pengembangan_kehidupan`
--
ALTER TABLE `laporan_pengembangan_kehidupan`
  ADD PRIMARY KEY (`id_pokja2_bidang2`),
  ADD UNIQUE KEY `uuid` (`uuid`),
  ADD KEY `id_user` (`id_user`),
  ADD KEY `id_role` (`id_role`),
  ADD KEY `id_organization` (`id_organization`);

--
-- Indeks untuk tabel `laporan_penghayatan_n_pengamalan`
--
ALTER TABLE `laporan_penghayatan_n_pengamalan`
  ADD PRIMARY KEY (`id_pokja1_bidang1`),
  ADD UNIQUE KEY `uuid` (`uuid`),
  ADD KEY `id_user` (`id_user`),
  ADD KEY `id_role` (`id_role`),
  ADD KEY `id_organization` (`id_organization`);

--
-- Indeks untuk tabel `laporan_perencanaan_sehat`
--
ALTER TABLE `laporan_perencanaan_sehat`
  ADD PRIMARY KEY (`id_pokja4_bidang3`),
  ADD UNIQUE KEY `uuid` (`uuid`),
  ADD KEY `id_user` (`id_user`),
  ADD KEY `id_role` (`id_role`),
  ADD KEY `id_organization` (`id_organization`);

--
-- Indeks untuk tabel `laporan_perumahan`
--
ALTER TABLE `laporan_perumahan`
  ADD PRIMARY KEY (`id_pokja3_bidang3`),
  ADD UNIQUE KEY `uuid` (`uuid`),
  ADD KEY `id_user` (`id_user`),
  ADD KEY `id_role` (`id_role`),
  ADD KEY `id_organization` (`id_organization`);

--
-- Indeks untuk tabel `laporan_sandang`
--
ALTER TABLE `laporan_sandang`
  ADD PRIMARY KEY (`id_pokja3_bidang2`),
  ADD UNIQUE KEY `uuid` (`uuid`),
  ADD KEY `id_user` (`id_user`),
  ADD KEY `id_role` (`id_role`),
  ADD KEY `id_organization` (`id_organization`);

--
-- Indeks untuk tabel `laporan_umum`
--
ALTER TABLE `laporan_umum`
  ADD PRIMARY KEY (`id_laporan_umum`),
  ADD UNIQUE KEY `uuid` (`uuid`),
  ADD KEY `id_user` (`id_user`),
  ADD KEY `id_role` (`id_role`),
  ADD KEY `id_organization` (`id_organization`);

--
-- Indeks untuk tabel `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indeks untuk tabel `pengumumen`
--
ALTER TABLE `pengumumen`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `posyandu`
--
ALTER TABLE `posyandu`
  ADD PRIMARY KEY (`id_posyandu`),
  ADD KEY `fk_posyandu_user` (`id_user`),
  ADD KEY `fk_posyandu_role` (`id_role`),
  ADD KEY `fk_posyandu_organization` (`id_organization`);

--
-- Indeks untuk tabel `rekap_desa_bulanan`
--
ALTER TABLE `rekap_desa_bulanan`
  ADD PRIMARY KEY (`id_rekap_desa_bulanan`),
  ADD KEY `fk_rekap_desa_role` (`id_role`),
  ADD KEY `fk_rekap_desa_organization` (`id_organization`),
  ADD KEY `fk_rekap_desa_user` (`id_user`);

--
-- Indeks untuk tabel `rekap_desa_tahunan`
--
ALTER TABLE `rekap_desa_tahunan`
  ADD PRIMARY KEY (`id_rekap_desa_tahunan`),
  ADD KEY `fk_rdt_user` (`id_user`),
  ADD KEY `fk_rdt_role` (`id_role`),
  ADD KEY `fk_rdt_organization` (`id_organization`);

--
-- Indeks untuk tabel `role_organization`
--
ALTER TABLE `role_organization`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uuid` (`uuid`);

--
-- Indeks untuk tabel `role_users_mobile`
--
ALTER TABLE `role_users_mobile`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uuid` (`uuid`);

--
-- Indeks untuk tabel `subdistrict`
--
ALTER TABLE `subdistrict`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uuid` (`uuid`);

--
-- Indeks untuk tabel `ttds`
--
ALTER TABLE `ttds`
  ADD PRIMARY KEY (`id_ttds`);

--
-- Indeks untuk tabel `ttdss`
--
ALTER TABLE `ttdss`
  ADD PRIMARY KEY (`id_ttdss`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Indeks untuk tabel `users_mobile`
--
ALTER TABLE `users_mobile`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uuid` (`uuid`),
  ADD KEY `id_orfanization` (`id_organization`),
  ADD KEY `id_role` (`id_role`),
  ADD KEY `id_subdistrict` (`id_subdistrict`),
  ADD KEY `id_village` (`id_village`);

--
-- Indeks untuk tabel `village`
--
ALTER TABLE `village`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uuid` (`uuid`),
  ADD KEY `id_subdistrict` (`id_subdistrict`);

--
-- Indeks untuk tabel `visitors`
--
ALTER TABLE `visitors`
  ADD PRIMARY KEY (`tanggal`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `animals`
--
ALTER TABLE `animals`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `beritas`
--
ALTER TABLE `beritas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=98;

--
-- AUTO_INCREMENT untuk tabel `galerys`
--
ALTER TABLE `galerys`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=75;

--
-- AUTO_INCREMENT untuk tabel `kegiatan_pokja4`
--
ALTER TABLE `kegiatan_pokja4`
  MODIFY `id_kegiatan_pokja4` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT untuk tabel `laporan_bidang_kesehatan`
--
ALTER TABLE `laporan_bidang_kesehatan`
  MODIFY `id_pokja4_bidang1` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `laporan_gotong_royong`
--
ALTER TABLE `laporan_gotong_royong`
  MODIFY `id_pokja1_bidang2` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT untuk tabel `laporan_kader_pokja1`
--
ALTER TABLE `laporan_kader_pokja1`
  MODIFY `id_kader_pokja1` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT untuk tabel `laporan_kader_pokja3`
--
ALTER TABLE `laporan_kader_pokja3`
  MODIFY `id_kader_pokja3` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT untuk tabel `laporan_kader_pokja4`
--
ALTER TABLE `laporan_kader_pokja4`
  MODIFY `id_kader_pokja4` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT untuk tabel `laporan_kelestarian_lingkungan_hidup`
--
ALTER TABLE `laporan_kelestarian_lingkungan_hidup`
  MODIFY `id_pokja4_bidang2` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT untuk tabel `laporan_pangan`
--
ALTER TABLE `laporan_pangan`
  MODIFY `id_pokja3_bidang1` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT untuk tabel `laporan_pendidikan_n_keterampilan`
--
ALTER TABLE `laporan_pendidikan_n_keterampilan`
  MODIFY `id_pokja2_bidang1` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT untuk tabel `laporan_pengembangan_kehidupan`
--
ALTER TABLE `laporan_pengembangan_kehidupan`
  MODIFY `id_pokja2_bidang2` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT untuk tabel `laporan_penghayatan_n_pengamalan`
--
ALTER TABLE `laporan_penghayatan_n_pengamalan`
  MODIFY `id_pokja1_bidang1` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT untuk tabel `laporan_perencanaan_sehat`
--
ALTER TABLE `laporan_perencanaan_sehat`
  MODIFY `id_pokja4_bidang3` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `laporan_perumahan`
--
ALTER TABLE `laporan_perumahan`
  MODIFY `id_pokja3_bidang3` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT untuk tabel `laporan_sandang`
--
ALTER TABLE `laporan_sandang`
  MODIFY `id_pokja3_bidang2` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `laporan_umum`
--
ALTER TABLE `laporan_umum`
  MODIFY `id_laporan_umum` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT untuk tabel `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `pengumumen`
--
ALTER TABLE `pengumumen`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT untuk tabel `posyandu`
--
ALTER TABLE `posyandu`
  MODIFY `id_posyandu` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT untuk tabel `rekap_desa_bulanan`
--
ALTER TABLE `rekap_desa_bulanan`
  MODIFY `id_rekap_desa_bulanan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT untuk tabel `rekap_desa_tahunan`
--
ALTER TABLE `rekap_desa_tahunan`
  MODIFY `id_rekap_desa_tahunan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT untuk tabel `role_organization`
--
ALTER TABLE `role_organization`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT untuk tabel `role_users_mobile`
--
ALTER TABLE `role_users_mobile`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `subdistrict`
--
ALTER TABLE `subdistrict`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT untuk tabel `ttds`
--
ALTER TABLE `ttds`
  MODIFY `id_ttds` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT untuk tabel `ttdss`
--
ALTER TABLE `ttdss`
  MODIFY `id_ttdss` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT untuk tabel `users_mobile`
--
ALTER TABLE `users_mobile`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT untuk tabel `village`
--
ALTER TABLE `village`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=569;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `kegiatan_pokja4`
--
ALTER TABLE `kegiatan_pokja4`
  ADD CONSTRAINT `fk_pokja4_organization` FOREIGN KEY (`id_organization`) REFERENCES `role_organization` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_pokja4_role` FOREIGN KEY (`id_role`) REFERENCES `role_users_mobile` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_pokja4_user` FOREIGN KEY (`id_user`) REFERENCES `users_mobile` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `laporan_bidang_kesehatan`
--
ALTER TABLE `laporan_bidang_kesehatan`
  ADD CONSTRAINT `laporan_bidang_kesehatan_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `users_mobile` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `laporan_bidang_kesehatan_ibfk_2` FOREIGN KEY (`id_role`) REFERENCES `role_users_mobile` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `laporan_bidang_kesehatan_ibfk_3` FOREIGN KEY (`id_organization`) REFERENCES `role_organization` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `laporan_gotong_royong`
--
ALTER TABLE `laporan_gotong_royong`
  ADD CONSTRAINT `laporan_gotong_royong_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `users_mobile` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `laporan_gotong_royong_ibfk_2` FOREIGN KEY (`id_role`) REFERENCES `role_users_mobile` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `laporan_gotong_royong_ibfk_3` FOREIGN KEY (`id_organization`) REFERENCES `role_organization` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `laporan_kader_pokja1`
--
ALTER TABLE `laporan_kader_pokja1`
  ADD CONSTRAINT `laporan_kader_pokja1_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `users_mobile` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `laporan_kader_pokja1_ibfk_2` FOREIGN KEY (`id_role`) REFERENCES `role_users_mobile` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `laporan_kader_pokja1_ibfk_3` FOREIGN KEY (`id_organization`) REFERENCES `role_organization` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `laporan_kader_pokja3`
--
ALTER TABLE `laporan_kader_pokja3`
  ADD CONSTRAINT `laporan_kader_pokja3_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `users_mobile` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `laporan_kader_pokja3_ibfk_2` FOREIGN KEY (`id_role`) REFERENCES `role_users_mobile` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `laporan_kader_pokja3_ibfk_3` FOREIGN KEY (`id_organization`) REFERENCES `role_organization` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `laporan_kader_pokja4`
--
ALTER TABLE `laporan_kader_pokja4`
  ADD CONSTRAINT `laporan_kader_pokja4_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `users_mobile` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `laporan_kader_pokja4_ibfk_2` FOREIGN KEY (`id_role`) REFERENCES `role_users_mobile` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `laporan_kader_pokja4_ibfk_3` FOREIGN KEY (`id_organization`) REFERENCES `role_organization` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `laporan_kelestarian_lingkungan_hidup`
--
ALTER TABLE `laporan_kelestarian_lingkungan_hidup`
  ADD CONSTRAINT `laporan_kelestarian_lingkungan_hidup_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `users_mobile` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `laporan_kelestarian_lingkungan_hidup_ibfk_2` FOREIGN KEY (`id_role`) REFERENCES `role_users_mobile` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `laporan_kelestarian_lingkungan_hidup_ibfk_3` FOREIGN KEY (`id_organization`) REFERENCES `role_organization` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `laporan_pangan`
--
ALTER TABLE `laporan_pangan`
  ADD CONSTRAINT `laporan_pangan_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `users_mobile` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `laporan_pangan_ibfk_2` FOREIGN KEY (`id_role`) REFERENCES `role_users_mobile` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `laporan_pangan_ibfk_3` FOREIGN KEY (`id_organization`) REFERENCES `role_organization` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `laporan_pendidikan_n_keterampilan`
--
ALTER TABLE `laporan_pendidikan_n_keterampilan`
  ADD CONSTRAINT `laporan_pendidikan_n_keterampilan_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `users_mobile` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `laporan_pendidikan_n_keterampilan_ibfk_2` FOREIGN KEY (`id_role`) REFERENCES `role_users_mobile` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `laporan_pendidikan_n_keterampilan_ibfk_3` FOREIGN KEY (`id_organization`) REFERENCES `role_organization` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `laporan_pengembangan_kehidupan`
--
ALTER TABLE `laporan_pengembangan_kehidupan`
  ADD CONSTRAINT `laporan_pengembangan_kehidupan_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `users_mobile` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `laporan_pengembangan_kehidupan_ibfk_2` FOREIGN KEY (`id_role`) REFERENCES `role_users_mobile` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `laporan_pengembangan_kehidupan_ibfk_3` FOREIGN KEY (`id_organization`) REFERENCES `role_organization` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `laporan_penghayatan_n_pengamalan`
--
ALTER TABLE `laporan_penghayatan_n_pengamalan`
  ADD CONSTRAINT `laporan_penghayatan_n_pengamalan_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `users_mobile` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `laporan_penghayatan_n_pengamalan_ibfk_2` FOREIGN KEY (`id_role`) REFERENCES `role_users_mobile` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `laporan_penghayatan_n_pengamalan_ibfk_3` FOREIGN KEY (`id_organization`) REFERENCES `role_organization` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `laporan_perencanaan_sehat`
--
ALTER TABLE `laporan_perencanaan_sehat`
  ADD CONSTRAINT `laporan_perencanaan_sehat_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `users_mobile` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `laporan_perencanaan_sehat_ibfk_2` FOREIGN KEY (`id_role`) REFERENCES `role_users_mobile` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `laporan_perencanaan_sehat_ibfk_3` FOREIGN KEY (`id_organization`) REFERENCES `role_organization` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `laporan_perumahan`
--
ALTER TABLE `laporan_perumahan`
  ADD CONSTRAINT `laporan_perumahan_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `users_mobile` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `laporan_perumahan_ibfk_2` FOREIGN KEY (`id_role`) REFERENCES `role_users_mobile` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `laporan_perumahan_ibfk_3` FOREIGN KEY (`id_organization`) REFERENCES `role_organization` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `laporan_sandang`
--
ALTER TABLE `laporan_sandang`
  ADD CONSTRAINT `laporan_sandang_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `users_mobile` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `laporan_sandang_ibfk_2` FOREIGN KEY (`id_role`) REFERENCES `role_users_mobile` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `laporan_sandang_ibfk_3` FOREIGN KEY (`id_organization`) REFERENCES `role_organization` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `laporan_umum`
--
ALTER TABLE `laporan_umum`
  ADD CONSTRAINT `laporan_umum_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `users_mobile` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `laporan_umum_ibfk_2` FOREIGN KEY (`id_role`) REFERENCES `role_users_mobile` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `laporan_umum_ibfk_3` FOREIGN KEY (`id_organization`) REFERENCES `role_organization` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `posyandu`
--
ALTER TABLE `posyandu`
  ADD CONSTRAINT `fk_posyandu_organization` FOREIGN KEY (`id_organization`) REFERENCES `role_organization` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_posyandu_role` FOREIGN KEY (`id_role`) REFERENCES `role_users_mobile` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_posyandu_user` FOREIGN KEY (`id_user`) REFERENCES `users_mobile` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `rekap_desa_bulanan`
--
ALTER TABLE `rekap_desa_bulanan`
  ADD CONSTRAINT `fk_rdb_organization` FOREIGN KEY (`id_organization`) REFERENCES `role_organization` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_rdb_role` FOREIGN KEY (`id_role`) REFERENCES `role_users_mobile` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_rdb_user` FOREIGN KEY (`id_user`) REFERENCES `users_mobile` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_rekap_desa_organization` FOREIGN KEY (`id_organization`) REFERENCES `role_organization` (`id`),
  ADD CONSTRAINT `fk_rekap_desa_role` FOREIGN KEY (`id_role`) REFERENCES `role_users_mobile` (`id`),
  ADD CONSTRAINT `fk_rekap_desa_user` FOREIGN KEY (`id_user`) REFERENCES `users_mobile` (`id`);

--
-- Ketidakleluasaan untuk tabel `rekap_desa_tahunan`
--
ALTER TABLE `rekap_desa_tahunan`
  ADD CONSTRAINT `fk_rdt_organization` FOREIGN KEY (`id_organization`) REFERENCES `role_organization` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_rdt_role` FOREIGN KEY (`id_role`) REFERENCES `role_users_mobile` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_rdt_user` FOREIGN KEY (`id_user`) REFERENCES `users_mobile` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_rekap_user` FOREIGN KEY (`id_user`) REFERENCES `users_mobile` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `users_mobile`
--
ALTER TABLE `users_mobile`
  ADD CONSTRAINT `users_mobile_ibfk_1` FOREIGN KEY (`id_organization`) REFERENCES `role_organization` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `users_mobile_ibfk_2` FOREIGN KEY (`id_role`) REFERENCES `role_users_mobile` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `users_mobile_ibfk_3` FOREIGN KEY (`id_subdistrict`) REFERENCES `subdistrict` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `users_mobile_ibfk_4` FOREIGN KEY (`id_village`) REFERENCES `village` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `village`
--
ALTER TABLE `village`
  ADD CONSTRAINT `village_ibfk_1` FOREIGN KEY (`id_subdistrict`) REFERENCES `subdistrict` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
