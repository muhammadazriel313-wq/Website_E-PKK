<?php
header('Content-Type: application/json');
require '../../config/config.php';

if ($_SERVER['REQUEST_METHOD'] === 'PUT') {
    parse_str(file_get_contents("php://input"), $_PUT);
    $kader_umum = $_PUT['kader_umum'] ?? null;
    $kader_khusus = $_PUT['kader_khusus'] ?? null;
    $id = $_PUT['id']; 

    date_default_timezone_set('Asia/Jakarta');
    $timestamp = time();
    $updated_at = date("Y-m-d H:i:s", $timestamp);

    try {
        $selectQuery = "SELECT kader_umum, kader_khusus FROM laporan_kader_pokja1 WHERE uuid = '$id'";
        $selectResult = mysqli_query($koneksi, $selectQuery);
        $data = mysqli_fetch_assoc($selectResult);

        if ($data) {
            if ($data['kader_umum'] == $kader_umum && $data['kader_khusus'] == $kader_khusus) {
                $response = [
                    'statusCode' => 304,
                    'message' => "No changes detected, the data is the same as before.",
                    'data' => null,
                    'error' => null
                ];
            } else {
                $query = "UPDATE laporan_kader_pokja1 SET 
                            kader_umum = '$kader_umum',
                            kader_khusus = '$kader_khusus',
                            catatan = '', 
                            status = 'Proses', 
                            updated_at = '$updated_at' 
                          WHERE uuid = '$id'";

                $result = mysqli_query($koneksi, $query);
                $check = mysqli_affected_rows($koneksi);

                if ($check > 0) {
                    $selectQuery = "SELECT * FROM laporan_kader_pokja1 WHERE uuid = '$id'";
                    $selectResult = mysqli_query($koneksi, $selectQuery);
                    $updatedData = mysqli_fetch_assoc($selectResult);

                    $response = [
                        'statusCode' => 200,
                        'message' => "Kader Pokja I report successfully updated",
                        'data' => [
                            "id" => $updatedData['uuid'],
                            "kader_umum" => $updatedData['kader_umum'],
                            "kader_khusus" => $updatedData['kader_khusus'],
                            "catatan" => $updatedData['catatan'],
                            "status" => $updatedData['status'],
                            "created_at" => $updatedData['created_at'],
                            "updated_at" => $updatedData['updated_at'],
                        ],
                        'error' => null
                    ];
                } else {
                    $response = [
                        'statusCode' => 404,
                        'message' => "Failed to update Kader Pokja I report. Report not found or no changes detected.",
                        'data' => null,
                        'error' => null
                    ];
                }
            }
        } else {
            $response = [
                'statusCode' => 404,
                'message' => "Report not found.",
                'data' => null,
                'error' => null
            ];
        }
    } catch (Exception $e) {
        $response = [
            'statusCode' => 500,
            'message' => $e->getMessage(),
            'data' => null,
            'error' => ['message' => 'An error occurred while updating the report.']
        ];
    }

    echo json_encode($response);
    mysqli_close($koneksi);
}
