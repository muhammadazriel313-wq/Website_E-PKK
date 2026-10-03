-- Catatan: Jalankan SEKALI saja pada database pkklur.

ALTER TABLE `laporan_penghayatan_n_pengamalan`
-- [PERUBAHAN] kolom lama dipertahankan dan diberi DEFAULT 0 agar data lama aman dan INSERT API baru tidak gagal:
MODIFY COLUMN `jumlah_kel_simulasi1` int(11) NOT NULL DEFAULT 0,
MODIFY COLUMN `jumlah_anggota1` int(11) NOT NULL DEFAULT 0,
MODIFY COLUMN `jumlah_kel_simulasi2` int(11) NOT NULL DEFAULT 0,
MODIFY COLUMN `jumlah_anggota2` int(11) NOT NULL DEFAULT 0,
MODIFY COLUMN `jumlah_kel_simulasi3` int(11) NOT NULL DEFAULT 0,
MODIFY COLUMN `jumlah_anggota3` int(11) NOT NULL DEFAULT 0,
MODIFY COLUMN `jumlah_kel_simulasi4` int(11) NOT NULL DEFAULT 0,
MODIFY COLUMN `jumlah_anggota4` int(11) NOT NULL DEFAULT 0,
-- [PERUBAHAN] kolom lama dipertahankan agar data lama aman:
-- DROP COLUMN `jumlah_kel_simulasi1`,
-- DROP COLUMN `jumlah_anggota1`,
-- DROP COLUMN `jumlah_kel_simulasi2`,
-- DROP COLUMN `jumlah_anggota2`,
-- DROP COLUMN `jumlah_kel_simulasi3`,
-- DROP COLUMN `jumlah_anggota3`,
-- DROP COLUMN `jumlah_kel_simulasi4`,
-- DROP COLUMN `jumlah_anggota4`,
ADD COLUMN `kisah_kegiatan` varchar(255) DEFAULT NULL AFTER `id_user`,
ADD COLUMN `kisah_vol` int(11) DEFAULT 0 AFTER `kisah_kegiatan`,
ADD COLUMN `kisah_metode` varchar(255) DEFAULT NULL AFTER `kisah_vol`,
ADD COLUMN `kisah_sasaran` int(11) DEFAULT 0 AFTER `kisah_metode`,
ADD COLUMN `krisan_kegiatan` varchar(255) DEFAULT NULL AFTER `kisah_sasaran`,
ADD COLUMN `krisan_vol` int(11) DEFAULT 0 AFTER `krisan_kegiatan`,
ADD COLUMN `krisan_metode` varchar(255) DEFAULT NULL AFTER `krisan_vol`,
ADD COLUMN `krisan_sasaran` int(11) DEFAULT 0 AFTER `krisan_metode`,
ADD COLUMN `kilas_kegiatan` varchar(255) DEFAULT NULL AFTER `krisan_sasaran`,
ADD COLUMN `kilas_vol` int(11) DEFAULT 0 AFTER `kilas_kegiatan`,
ADD COLUMN `kilas_metode` varchar(255) DEFAULT NULL AFTER `kilas_vol`,
ADD COLUMN `kilas_sasaran` int(11) DEFAULT 0 AFTER `kilas_metode`,
ADD COLUMN `kiat_kegiatan` varchar(255) DEFAULT NULL AFTER `kilas_sasaran`,
ADD COLUMN `kiat_vol` int(11) DEFAULT 0 AFTER `kiat_kegiatan`,
ADD COLUMN `kiat_metode` varchar(255) DEFAULT NULL AFTER `kiat_vol`,
ADD COLUMN `kiat_sasaran` int(11) DEFAULT 0 AFTER `kiat_metode`,
ADD COLUMN `kisak_kegiatan` varchar(255) DEFAULT NULL AFTER `kiat_sasaran`,
ADD COLUMN `kisak_vol` int(11) DEFAULT 0 AFTER `kisak_kegiatan`,
ADD COLUMN `kisak_metode` varchar(255) DEFAULT NULL AFTER `kisak_vol`,
ADD COLUMN `kisak_sasaran` int(11) DEFAULT 0 AFTER `kisak_metode`,
ADD COLUMN `pkbn_kegiatan` varchar(255) DEFAULT NULL AFTER `kisak_sasaran`,
ADD COLUMN `pkbn_vol` int(11) DEFAULT 0 AFTER `pkbn_kegiatan`,
ADD COLUMN `pkbn_metode` varchar(255) DEFAULT NULL AFTER `pkbn_vol`,
ADD COLUMN `pkbn_sasaran` int(11) DEFAULT 0 AFTER `pkbn_metode`;

-- [PERUBAHAN] DINONAKTIFKAN: Flutter/API/web masih memakai PKBN, PKDRT, pola_asuh.
-- ALTER TABLE `laporan_kader_pokja1`
-- DROP COLUMN `PKBN`,
-- DROP COLUMN `PKDRT`,
-- DROP COLUMN `pola_asuh`,
-- ADD COLUMN `kader_umum` int(11) DEFAULT 0 AFTER `id_user`,
-- ADD COLUMN `kader_khusus` int(11) DEFAULT 0 AFTER `kader_umum`;

