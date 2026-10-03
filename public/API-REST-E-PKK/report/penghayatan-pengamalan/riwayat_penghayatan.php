<?php
require("koneksi.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $idUser = $_POST['id_user'];
    $perintah = "SELECT * FROM laporan_penghayatan_n_pengamalan WHERE id_user = '$idUser' 
                ORDER BY id_pokja1_bidang1 DESC";
    $eksekusi = mysqli_query($koneksi, $perintah);
    $cek = mysqli_affected_rows($koneksi);

    if ($cek > 0) {
        $response["kode"] = 1;
        $response["message"] = "Data Tersedia";
        $response["data"] = array();

        while ($ambil = mysqli_fetch_object($eksekusi)) {
            $F["id_pokja1_bidang1"] = $ambil->id_pokja1_bidang1;
            $F["kisah_kegiatan"] = $ambil->kisah_kegiatan;
            $F["kisah_vol"] = $ambil->kisah_vol;
            $F["kisah_metode"] = $ambil->kisah_metode;
            $F["kisah_sasaran"] = $ambil->kisah_sasaran;
            $F["krisan_kegiatan"] = $ambil->krisan_kegiatan;
            $F["krisan_vol"] = $ambil->krisan_vol;
            $F["krisan_metode"] = $ambil->krisan_metode;
            $F["krisan_sasaran"] = $ambil->krisan_sasaran;
            $F["kilas_kegiatan"] = $ambil->kilas_kegiatan;
            $F["kilas_vol"] = $ambil->kilas_vol;
            $F["kilas_metode"] = $ambil->kilas_metode;
            $F["kilas_sasaran"] = $ambil->kilas_sasaran;
            $F["kiat_kegiatan"] = $ambil->kiat_kegiatan;
            $F["kiat_vol"] = $ambil->kiat_vol;
            $F["kiat_metode"] = $ambil->kiat_metode;
            $F["kiat_sasaran"] = $ambil->kiat_sasaran;
            $F["kisak_kegiatan"] = $ambil->kisak_kegiatan;
            $F["kisak_vol"] = $ambil->kisak_vol;
            $F["kisak_metode"] = $ambil->kisak_metode;
            $F["kisak_sasaran"] = $ambil->kisak_sasaran;
            $F["pkbn_kegiatan"] = $ambil->pkbn_kegiatan;
            $F["pkbn_vol"] = $ambil->pkbn_vol;
            $F["pkbn_metode"] = $ambil->pkbn_metode;
            $F["pkbn_sasaran"] = $ambil->pkbn_sasaran;
            $F["status"] = $ambil->status;
            $F['tanggal'] = $ambil->tanggal;
            $F['catatan'] = $ambil->catatan;
            $F['waktu'] = $ambil->waktu;
            $F["created_at"] = $ambil->created_at;
            $F["updated_at"] = $ambil->updated_at;

            array_push($response["data"], $F);
        }
    } else {
        $response["kode"] = 0;
        $response["message"] = "Data Tidak Tersedia";
        $response["data"] = null;
    }
}
echo json_encode($response);
mysqli_close($koneksi);
