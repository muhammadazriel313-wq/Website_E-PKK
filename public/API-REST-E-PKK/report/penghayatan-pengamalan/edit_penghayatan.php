<?php
include 'koneksi.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $kisah_kegiatan = $_POST['kisah_kegiatan'] ?? null;
    $kisah_vol = $_POST['kisah_vol'] ?? null;
    $kisah_metode = $_POST['kisah_metode'] ?? null;
    $kisah_sasaran = $_POST['kisah_sasaran'] ?? null;

    $krisan_kegiatan = $_POST['krisan_kegiatan'] ?? null;
    $krisan_vol = $_POST['krisan_vol'] ?? null;
    $krisan_metode = $_POST['krisan_metode'] ?? null;
    $krisan_sasaran = $_POST['krisan_sasaran'] ?? null;

    $kilas_kegiatan = $_POST['kilas_kegiatan'] ?? null;
    $kilas_vol = $_POST['kilas_vol'] ?? null;
    $kilas_metode = $_POST['kilas_metode'] ?? null;
    $kilas_sasaran = $_POST['kilas_sasaran'] ?? null;

    $kiat_kegiatan = $_POST['kiat_kegiatan'] ?? null;
    $kiat_vol = $_POST['kiat_vol'] ?? null;
    $kiat_metode = $_POST['kiat_metode'] ?? null;
    $kiat_sasaran = $_POST['kiat_sasaran'] ?? null;

    $kisak_kegiatan = $_POST['kisak_kegiatan'] ?? null;
    $kisak_vol = $_POST['kisak_vol'] ?? null;
    $kisak_metode = $_POST['kisak_metode'] ?? null;
    $kisak_sasaran = $_POST['kisak_sasaran'] ?? null;

    $pkbn_kegiatan = $_POST['pkbn_kegiatan'] ?? null;
    $pkbn_vol = $_POST['pkbn_vol'] ?? null;
    $pkbn_metode = $_POST['pkbn_metode'] ?? null;
    $pkbn_sasaran = $_POST['pkbn_sasaran'] ?? null;

    $user_id = $_POST['id_pokja1_bidang1'];
    $tanggal = date('Y-m-d');

    date_default_timezone_set('Asia/Jakarta');
    $timestamp = time();
    $created_at = date("Y-m-d H:i:s", $timestamp);
    $waktu = date("H:i", $timestamp);

    try {
        $query = "UPDATE laporan_penghayatan_n_pengamalan SET
                    kisah_kegiatan = '$kisah_kegiatan', kisah_vol = '$kisah_vol', kisah_metode = '$kisah_metode', kisah_sasaran = '$kisah_sasaran',
                    krisan_kegiatan = '$krisan_kegiatan', krisan_vol = '$krisan_vol', krisan_metode = '$krisan_metode', krisan_sasaran = '$krisan_sasaran',
                    kilas_kegiatan = '$kilas_kegiatan', kilas_vol = '$kilas_vol', kilas_metode = '$kilas_metode', kilas_sasaran = '$kilas_sasaran',
                    kiat_kegiatan = '$kiat_kegiatan', kiat_vol = '$kiat_vol', kiat_metode = '$kiat_metode', kiat_sasaran = '$kiat_sasaran',
                    kisak_kegiatan = '$kisak_kegiatan', kisak_vol = '$kisak_vol', kisak_metode = '$kisak_metode', kisak_sasaran = '$kisak_sasaran',
                    pkbn_kegiatan = '$pkbn_kegiatan', pkbn_vol = '$pkbn_vol', pkbn_metode = '$pkbn_metode', pkbn_sasaran = '$pkbn_sasaran',
                    catatan = '', status = 'Proses', updated_at = '$created_at'
                    WHERE id_pokja1_bidang1 = '$user_id'";

        $result = mysqli_query($koneksi, $query);
        $check = mysqli_affected_rows($koneksi);

        if ($check > 0) {
            $response['kode'] = 1;
            $response['message'] = "Data Masuk";
            $response['data'] = [
                'Berhasil' => $check
            ];
        } else {
            $response['kode'] = 0;
            $response['message'] = "Data Gagal Masuk";
        }

        // echo 'Data berhasil disimpan!';
    } catch (Exception $e) {
        $response['kode'] = 0;
        $response['message'] = $e->getMessage();
    }
    echo json_encode($response);
    mysqli_close($koneksi);
}
