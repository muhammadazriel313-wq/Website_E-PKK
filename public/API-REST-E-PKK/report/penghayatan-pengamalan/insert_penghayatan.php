<?php
header('Content-Type: application/json');
require '../../config/config.php';

function generateCustomUUID() {
    $randomString = substr(str_shuffle("0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 6); // Membuat 7 karakter acak
    return 'KP1B1-' . $randomString; 
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    if (!$koneksi) {
        $response['statusCode'] = 500;
        $response['message'] = "Koneksi Database Gagal.";
        $response['data'] = null;
        $response['error'] = ['message' => 'Failed to connect to database'];
        echo json_encode($response);
        exit();
    }

    $input = json_decode(file_get_contents("php://input"), true);

    $kisah_kegiatan = $input['kisah_kegiatan'] ?? null;
    $kisah_vol = $input['kisah_vol'] ?? null;
    $kisah_metode = $input['kisah_metode'] ?? null;
    $kisah_sasaran = $input['kisah_sasaran'] ?? null;

    $krisan_kegiatan = $input['krisan_kegiatan'] ?? null;
    $krisan_vol = $input['krisan_vol'] ?? null;
    $krisan_metode = $input['krisan_metode'] ?? null;
    $krisan_sasaran = $input['krisan_sasaran'] ?? null;

    $kilas_kegiatan = $input['kilas_kegiatan'] ?? null;
    $kilas_vol = $input['kilas_vol'] ?? null;
    $kilas_metode = $input['kilas_metode'] ?? null;
    $kilas_sasaran = $input['kilas_sasaran'] ?? null;

    $kiat_kegiatan = $input['kiat_kegiatan'] ?? null;
    $kiat_vol = $input['kiat_vol'] ?? null;
    $kiat_metode = $input['kiat_metode'] ?? null;
    $kiat_sasaran = $input['kiat_sasaran'] ?? null;

    $kisak_kegiatan = $input['kisak_kegiatan'] ?? null;
    $kisak_vol = $input['kisak_vol'] ?? null;
    $kisak_metode = $input['kisak_metode'] ?? null;
    $kisak_sasaran = $input['kisak_sasaran'] ?? null;

    $pkbn_kegiatan = $input['pkbn_kegiatan'] ?? null;
    $pkbn_vol = $input['pkbn_vol'] ?? null;
    $pkbn_metode = $input['pkbn_metode'] ?? null;
    $pkbn_sasaran = $input['pkbn_sasaran'] ?? null;

    $id_user = $input['id_user'];
    $id_role = $input['id_role'];
    $id_organization = $input['id_organization'];

    date_default_timezone_set('Asia/Jakarta');
    $timestamp = time();
    $created_at = date("Y-m-d H:i:s", $timestamp);
    $updated_at = date("Y-m-d H:i:s", $timestamp);

    $uuid = generateCustomUUID();

    try {
        $query = "INSERT INTO laporan_penghayatan_n_pengamalan (uuid, id_user, kisah_kegiatan, kisah_vol, kisah_metode, kisah_sasaran, krisan_kegiatan, krisan_vol, krisan_metode, krisan_sasaran, kilas_kegiatan, kilas_vol, kilas_metode, kilas_sasaran, kiat_kegiatan, kiat_vol, kiat_metode, kiat_sasaran, kisak_kegiatan, kisak_vol, kisak_metode, kisak_sasaran, pkbn_kegiatan, pkbn_vol, pkbn_metode, pkbn_sasaran, status, created_at, updated_at, id_role, id_organization)
        VALUES ('$uuid', '$id_user', '$kisah_kegiatan', '$kisah_vol', '$kisah_metode', '$kisah_sasaran', '$krisan_kegiatan', '$krisan_vol', '$krisan_metode', '$krisan_sasaran', '$kilas_kegiatan', '$kilas_vol', '$kilas_metode', '$kilas_sasaran', '$kiat_kegiatan', '$kiat_vol', '$kiat_metode', '$kiat_sasaran', '$kisak_kegiatan', '$kisak_vol', '$kisak_metode', '$kisak_sasaran', '$pkbn_kegiatan', '$pkbn_vol', '$pkbn_metode', '$pkbn_sasaran', 'Proses', '$created_at', '$updated_at', '$id_role', '$id_organization')";

        $result = mysqli_query($koneksi, $query);
        $check = mysqli_affected_rows($koneksi);

        if ($check > 0) {
            $selectQuery = "
                SELECT 
                    laporan_penghayatan_n_pengamalan.id_pokja1_bidang1,
                    laporan_penghayatan_n_pengamalan.uuid,
                    laporan_penghayatan_n_pengamalan.id_user,
                    laporan_penghayatan_n_pengamalan.kisah_kegiatan,
                    laporan_penghayatan_n_pengamalan.kisah_vol,
                    laporan_penghayatan_n_pengamalan.kisah_metode,
                    laporan_penghayatan_n_pengamalan.kisah_sasaran,
                    laporan_penghayatan_n_pengamalan.krisan_kegiatan,
                    laporan_penghayatan_n_pengamalan.krisan_vol,
                    laporan_penghayatan_n_pengamalan.krisan_metode,
                    laporan_penghayatan_n_pengamalan.krisan_sasaran,
                    laporan_penghayatan_n_pengamalan.kilas_kegiatan,
                    laporan_penghayatan_n_pengamalan.kilas_vol,
                    laporan_penghayatan_n_pengamalan.kilas_metode,
                    laporan_penghayatan_n_pengamalan.kilas_sasaran,
                    laporan_penghayatan_n_pengamalan.kiat_kegiatan,
                    laporan_penghayatan_n_pengamalan.kiat_vol,
                    laporan_penghayatan_n_pengamalan.kiat_metode,
                    laporan_penghayatan_n_pengamalan.kiat_sasaran,
                    laporan_penghayatan_n_pengamalan.kisak_kegiatan,
                    laporan_penghayatan_n_pengamalan.kisak_vol,
                    laporan_penghayatan_n_pengamalan.kisak_metode,
                    laporan_penghayatan_n_pengamalan.kisak_sasaran,
                    laporan_penghayatan_n_pengamalan.pkbn_kegiatan,
                    laporan_penghayatan_n_pengamalan.pkbn_vol,
                    laporan_penghayatan_n_pengamalan.pkbn_metode,
                    laporan_penghayatan_n_pengamalan.pkbn_sasaran,
                    laporan_penghayatan_n_pengamalan.catatan,
                    laporan_penghayatan_n_pengamalan.status,
                    laporan_penghayatan_n_pengamalan.created_at,
                    laporan_penghayatan_n_pengamalan.updated_at,
                    role_users_mobile.id AS role_id,
                    role_users_mobile.uuid AS role_uuid,
                    role_users_mobile.name AS role_name,
                    role_organization.id AS organization_id,
                    role_organization.uuid AS organization_uuid,
                    role_organization.name AS organization_name
                FROM laporan_penghayatan_n_pengamalan
                LEFT JOIN role_users_mobile ON laporan_penghayatan_n_pengamalan.id_role = role_users_mobile.id
                LEFT JOIN role_organization ON laporan_penghayatan_n_pengamalan.id_organization = role_organization.id
                WHERE laporan_penghayatan_n_pengamalan.uuid = '$uuid'
            ";
                    
            $selectResult = mysqli_query($koneksi, $selectQuery);
            $data = mysqli_fetch_assoc($selectResult);

            $response['statusCode'] = 200;
            $response['message'] = "Successfully uploaded report penghayatan pengamalan";
            $response['data'] = [
                "id_pokja1_bidang1" => $data['id_pokja1_bidang1'],
                "uuid" => $data['uuid'],
                "id_user" => $data['id_user'],
                "kisah_kegiatan" => $data['kisah_kegiatan'],
                "kisah_vol" => $data['kisah_vol'],
                "kisah_metode" => $data['kisah_metode'],
                "kisah_sasaran" => $data['kisah_sasaran'],
                "krisan_kegiatan" => $data['krisan_kegiatan'],
                "krisan_vol" => $data['krisan_vol'],
                "krisan_metode" => $data['krisan_metode'],
                "krisan_sasaran" => $data['krisan_sasaran'],
                "kilas_kegiatan" => $data['kilas_kegiatan'],
                "kilas_vol" => $data['kilas_vol'],
                "kilas_metode" => $data['kilas_metode'],
                "kilas_sasaran" => $data['kilas_sasaran'],
                "kiat_kegiatan" => $data['kiat_kegiatan'],
                "kiat_vol" => $data['kiat_vol'],
                "kiat_metode" => $data['kiat_metode'],
                "kiat_sasaran" => $data['kiat_sasaran'],
                "kisak_kegiatan" => $data['kisak_kegiatan'],
                "kisak_vol" => $data['kisak_vol'],
                "kisak_metode" => $data['kisak_metode'],
                "kisak_sasaran" => $data['kisak_sasaran'],
                "pkbn_kegiatan" => $data['pkbn_kegiatan'],
                "pkbn_vol" => $data['pkbn_vol'],
                "pkbn_metode" => $data['pkbn_metode'],
                "pkbn_sasaran" => $data['pkbn_sasaran'],
                "catatan" => $data['catatan'],
                "status" => $data['status'],
                "created_at" => $data['created_at'],
                "updated_at" => $data['updated_at'],
                "role" => [
                    "id" => $data['role_id'],
                    "uuid"=> $data['role_uuid'],
                    "name" => $data['role_name']
                ],
                "organization" => [
                    "id" => $data['organization_id'],
                    'uuid' => $data['organization_uuid'],
                    "name" => $data['organization_name']
                ],
            ]; 
            $response['error'] = null;
        } else {
            $response['statusCode'] = 500;
            $response['message'] = "Failed to upload report kader pokja I";
            $response['data'] = null;
            $response['error'] = ['message' => 'Data insertion failed'];
        }
    } catch (Exception $e) {
        $response['statusCode'] = 500;
        $response['message'] = "An error occurred while processing the request.";
        $response['data'] = null;
        $response['error'] = ['message' => $e->getMessage()];
    }
    echo json_encode($response);
    mysqli_close($koneksi);
}
?>


