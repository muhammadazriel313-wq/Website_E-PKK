<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RiwayatController extends Controller
{
    /// =======================================================
    /// TABLE MAPPING
    /// =======================================================

    private $tableMapping = [

        1 => [
            'laporan_kader_pokja1',
            'laporan_penghayatan_n_pengamalan',
            'laporan_gotong_royong',
            'galerys'
        ],

        2 => [
            'laporan_pendidikan_n_keterampilan',
            'laporan_pengembangan_kehidupan',
            'galerys'
        ],

        3 => [
            'laporan_kader_pokja3',
            'laporan_pangan',
            'laporan_sandang',
            'laporan_perumahan',
            'galerys'
        ],

        4 => [
            'laporan_kader_pokja4',
            'laporan_bidang_kesehatan',
            'laporan_kelestarian_lingkungan_hidup',
            'laporan_perencanaan_sehat',
            'rekap_desa_bulanan',
            'rekap_desa_tahunan',
            'posyandu',
            'kegiatan_pokja4',
            'galerys'
        ],

        5 => [
            'laporan_umum',
            'galerys'
        ]
    ];

    /// =======================================================
    /// UUID TABLE MAPPING
    /// =======================================================

    private $uuidMapping = [

        1 => [
            'KP1'   => 'laporan_kader_pokja1',
            'KP1B1' => 'laporan_penghayatan_n_pengamalan',
            'KP1B2' => 'laporan_gotong_royong',
            'GAL'   => 'galerys'
        ],

        2 => [
            'KP2B1' => 'laporan_pendidikan_n_keterampilan',
            'KP2B2' => 'laporan_pengembangan_kehidupan',
            'GAL'   => 'galerys'
        ],

        3 => [
            'KP3'   => 'laporan_kader_pokja3',
            'KP3B1' => 'laporan_pangan',
            'KP3B2' => 'laporan_sandang',
            'KP3B3' => 'laporan_perumahan',
            'GAL'   => 'galerys'
        ],

        4 => [
            'KP4'       => 'laporan_kader_pokja4',
            'KP4B1'     => 'laporan_bidang_kesehatan',
            'KP4B2'     => 'laporan_kelestarian_lingkungan_hidup',
            'KP4B3'     => 'laporan_perencanaan_sehat',
            'PRIORITAS' => ['rekap_desa_bulanan', 'rekap_desa_tahunan','posyandu', 'kegiatan_pokja4'],
            'UNGGULAN'  => ['rekap_desa_bulanan', 'rekap_desa_tahunan','posyandu', 'kegiatan_pokja4'],
            'GAL'       => 'galerys'
        ],

        5 => [
            'PKKUM' => 'laporan_umum',
            'GAL'   => 'galerys'
        ]
    ];

    /// =======================================================
    /// RIWAYAT
    /// =======================================================

    public function getRiwayat(Request $request)
    {
        try {

            $userId   = $request->user_id;
            $userRole = $request->user_role;
            $userOrg  = $request->user_org;

            /// ================= VALIDASI =================

            if (
                !$userId ||
                !$userRole ||
                !$userOrg
            ) {

                return response()->json([

                    'statusCode' => 400,

                    'message' =>
                    'Parameter tidak lengkap',

                    'data' => [],

                    'error' => [
                        'message' =>
                        'user_id, user_role, user_org wajib'
                    ]

                ], 400);
            }

            /// ================= GET TABLE =================

            $allowedTables =
                $this->tableMapping[$userOrg]
                ?? [];

            if (empty($allowedTables)) {

                return response()->json([

                    'statusCode' => 200,

                    'message' =>
                    'Tidak ada data',

                    'data' => [],

                    'error' => null

                ]);
            }

            /// ================= GET DATA =================

            $results =
                $this->fetchReports(
                    $allowedTables,
                    $userId,
                    $userRole,
                    $userOrg
                );

            /// ================= SORT =================

            usort(
                $results,

                function ($a, $b) {

                    return strtotime($b->created_at)
                        - strtotime($a->created_at);
                }
            );

            return response()->json([

                'statusCode' => 200,

                'message' =>
                'Berhasil ambil riwayat',

                'data' =>
                $results,

                'error' =>
                null

            ], 200);
        } catch (\Exception $e) {

            return response()->json([

                'statusCode' => 500,

                'message' =>
                'Server error',

                'data' => [],

                'error' => [
                    'message' =>
                    $e->getMessage()
                ]

            ], 500);
        }
    }

    /// =======================================================
    /// GET REPORT
    /// =======================================================

    public function getReport(Request $request)
    {
        try {

            $userId   = $request->id_user;
            $userRole = $request->id_role;
            $userOrg  = $request->id_organization;

            $limit  = $request->limit ?? 10;
            $page   = $request->page ?? 1;
            $offset = ($page - 1) * $limit;

            /// ================= VALIDASI =================

            if (
                !$userId ||
                !$userRole ||
                !$userOrg
            ) {

                return response()->json([

                    'statusCode' => 400,

                    'message' =>
                    'Parameter id_user, id_role, dan id_organization wajib diisi.',

                    'data' => [],

                    'pagination' => null,

                    'error' => [
                        'message' =>
                        'Parameter tidak lengkap'
                    ]

                ], 400);
            }

            /// ================= GET TABLE =================

            $allowedTables =
                $this->tableMapping[$userOrg]
                ?? [];

            /// ================= GET DATA =================

            $results =
                $this->fetchReports(
                    $allowedTables,
                    $userId,
                    $userRole,
                    $userOrg
                );

            /// ================= SORT =================

            usort(
                $results,

                function ($a, $b) {

                    return strtotime($b->created_at)
                        - strtotime($a->created_at);
                }
            );

            /// ================= PAGINATION =================

            $totalData =
                count($results);

            $paginated =
                array_slice(
                    $results,
                    $offset,
                    $limit
                );

            if (count($paginated) == 0) {

                return response()->json([

                    'statusCode' => 404,

                    'message' =>
                    'Data laporan tidak ditemukan',

                    'data' => [],

                    'pagination' => null,

                    'error' => null

                ], 404);
            }

            return response()->json([

                'statusCode' => 200,

                'message' =>
                'Berhasil mengambil data laporan',

                'data' =>
                $paginated,

                'pagination' => [

                    'total_data' =>
                    $totalData,

                    'total_halaman' =>
                    ceil($totalData / $limit),

                    'halaman_sekarang' =>
                    (int) $page,

                    'data_per_halaman' =>
                    (int) $limit
                ],

                'error' =>
                null

            ], 200);
        } catch (\Exception $e) {

            return response()->json([

                'statusCode' => 500,

                'message' =>
                'Terjadi kesalahan server',

                'data' => null,

                'pagination' => null,

                'error' => [
                    'message' =>
                    $e->getMessage()
                ]

            ], 500);
        }
    }

    /// =======================================================
    /// DETAIL REPORT
    /// =======================================================

    public function getDetailReport(Request $request)
    {
        try {

            $uuid  = $request->uuid;
            $orgId = $request->org_id;

            /// ================= VALIDASI =================

            if (
                !$uuid ||
                !$orgId
            ) {

                return response()->json([

                    'statusCode' => 400,

                    'message' =>
                    'Parameter uuid dan org_id wajib diisi.',

                    'data' => null,

                    'error' => null

                ], 400);
            }

            /// ================= GET TABLE =================

            $table =
                $this->determineTableFromUUID(
                    $uuid,
                    $orgId
                );

            if (!$table) {

                return response()->json([

                    'statusCode' => 404,

                    'message' =>
                    'Tabel laporan tidak ditemukan.',

                    'data' => null,

                    'error' => null

                ], 404);
            }

            /// ================= GET DETAIL =================

            $data = DB::table($table)

                ->where(
                    'uuid',
                    $uuid
                )

                ->first();

            if (!$data) {

                return response()->json([

                    'statusCode' => 404,

                    'message' =>
                    'Data laporan tidak ditemukan',

                    'data' => null,

                    'error' => null

                ], 404);
            }

            // Khusus mobile: 'Menunggu' ditampilkan sebagai 'Proses'.
            $data->status = $this->mapStatusUntukMobile($data->status);

            // Kegiatan (galerys): tampilkan hanya field yang relevan
            if ($table === 'galerys') {
                $data = $this->formatGaleriDetail($data);
            }

            return response()->json([

                'statusCode' => 200,

                'message' =>
                'Berhasil mengambil detail laporan',

                'data' =>
                $data,

                'error' =>
                null

            ], 200);
        } catch (\Exception $e) {

            return response()->json([

                'statusCode' => 500,

                'message' =>
                'Terjadi kesalahan server',

                'data' => null,

                'error' => [
                    'message' =>
                    $e->getMessage()
                ]

            ], 500);
        }
    }
    /// =======================================================
    /// CANCEL REPORT
    /// =======================================================

    public function cancelReport(Request $request)
    {
        try {

            $uuid  = $request->uuid;
            $orgId = $request->org_id;

            /// ================= VALIDASI =================

            if (
                !$uuid ||
                !$orgId
            ) {

                return response()->json([

                    'statusCode' => 400,

                    'message' =>
                    'Parameter uuid dan org_id wajib diisi.',

                    'data' => null,

                    'error' => [
                        'message' =>
                        'Parameter tidak lengkap'
                    ]

                ], 400);
            }

            /// ================= GET TABLE =================

            $table =
                $this->determineTableFromUUID(
                    $uuid,
                    $orgId
                );

            if (!$table) {

                return response()->json([

                    'statusCode' => 404,

                    'message' =>
                    'Tabel laporan tidak ditemukan.',

                    'data' => null,

                    'error' => null

                ], 404);
            }

            /// ================= UPDATE STATUS =================

            $updated = DB::table($table)

                ->where(
                    'uuid',
                    $uuid
                )

                ->update([

                    'status' => 'Dibatalkan'
                ]);

            if (!$updated) {

                return response()->json([

                    'statusCode' => 404,

                    'message' =>
                    'Data laporan tidak ditemukan',

                    'data' => null,

                    'error' => null

                ], 404);
            }

            return response()->json([

                'statusCode' => 200,

                'message' =>
                'Laporan berhasil dibatalkan',

                'data' => [

                    'uuid' =>
                    $uuid,

                    'status' =>
                    'Dibatalkan'
                ],

                'error' =>
                null

            ], 200);
        } catch (\Exception $e) {

            return response()->json([

                'statusCode' => 500,

                'message' =>
                'Terjadi kesalahan server',

                'data' => null,

                'error' => [

                    'message' =>
                    $e->getMessage()
                ]

            ], 500);
        }
    }

    /// =======================================================
    /// UPDATE REPORT
    /// =======================================================

    public function updateLaporan(Request $request)
    {
        try {

            $uuid  = $request->uuid;
            $orgId = $request->org_id;
            $data  = $request->data;

            /// ================= VALIDASI =================

            if (
                !$uuid ||
                !$orgId ||
                !$data
            ) {

                return response()->json([

                    'statusCode' => 400,

                    'message' =>
                    'Parameter uuid, org_id, dan data wajib diisi.',

                    'data' => null,

                    'error' => [
                        'message' =>
                        'Parameter tidak lengkap'
                    ]

                ], 400);
            }

            /// ================= GET TABLE =================

            $table =
                $this->determineTableFromUUID(
                    $uuid,
                    $orgId
                );

            if (!$table) {

                return response()->json([

                    'statusCode' => 404,

                    'message' =>
                    'Tabel laporan tidak ditemukan.',

                    'data' => null,

                    'error' => null

                ], 404);
            }

            /// ================= CHECK DATA =================

            $existing = DB::table($table)

                ->where(
                    'uuid',
                    $uuid
                )

                ->first();

            if (!$existing) {

                return response()->json([

                    'statusCode' => 404,

                    'message' =>
                    'Data laporan tidak ditemukan',

                    'data' => null,

                    'error' => null

                ], 404);
            }

            /// ================= UPDATE =================

            $currentStatus = strtolower($existing->status ?? '');
            if (in_array($currentStatus, ['disetujui1', 'disetujui2'])) {
                return response()->json([
                    'statusCode' => 400,
                    'message'    => 'Laporan yang sudah disetujui tidak dapat diedit.',
                    'data'       => null,
                    'error'      => [
                        'message' => 'Status tidak mengizinkan pengeditan'
                    ]
                ], 400);
            }

            // Kembalikan status menjadi 'Menunggu' (diajukan ulang/menunggu review admin)
            if (in_array($currentStatus, ['revisi', 'ditolak', 'proses', 'menunggu'])) {
                $data['status'] = 'Menunggu';
            }

            unset($data['uuid'], $data['id'], $data['created_at']);
            $data['updated_at'] = now();

            if ($table === 'galerys') {

                // Kegiatan hanya boleh diedit saat masih berstatus Proses
                if ($existing->status !== 'Proses') {

                    return response()->json([

                        'statusCode' => 400,

                        'message' =>
                        'Kegiatan yang sudah diproses tidak bisa diedit',

                        'data' => null,

                        'error' => null

                    ], 400);
                }

                // Hanya field berikut yang boleh diubah dari mobile
                $payload = [];

                if (!empty(trim((string) ($data['nama_kegiatan'] ?? '')))) {
                    $payload['deskripsi'] = trim($data['nama_kegiatan']);
                }

                if (!empty(trim((string) ($data['lokasi'] ?? '')))) {
                    $payload['lokasi'] = trim($data['lokasi']);
                }

                if (array_key_exists('nama_peserta', $data)) {
                    $payload['nama_peserta'] =
                        $this->normalizeNamaPeserta($data['nama_peserta']);
                }

                // Jabatan hanya untuk akun Bidang Umum (id_organization 5)
                // dan harus salah satu dari 15 pilihan.
                if (
                    array_key_exists('jabatan', $data) &&
                    (string) $existing->id_organization === '5'
                ) {
                    $jab = trim((string) $data['jabatan']);

                    if (!in_array($jab, \App\Support\JabatanKegiatan::LIST, true)) {

                        return response()->json([

                            'statusCode' => 422,

                            'message' => 'Jabatan harus dipilih dari daftar',

                            'data' => null,

                            'error' => null

                        ], 422);
                    }

                    $payload['jabatan'] = $jab;
                }

                $payload['updated_at'] = now();

                DB::table($table)
                    ->where('uuid', $uuid)
                    ->update($payload);
            } else {

                DB::table($table)

                    ->where(
                        'uuid',
                        $uuid
                    )

                    ->update($data);
            }

            return response()->json([

                'statusCode' => 200,

                'message' =>
                'Update berhasil',

                'data' => [

                    'uuid' =>
                    $uuid
                ],

                'error' =>
                null

            ], 200);
        } catch (\Exception $e) {

            return response()->json([

                'statusCode' => 500,

                'message' =>
                'Terjadi kesalahan server',

                'data' => null,

                'error' => [

                    'message' =>
                    $e->getMessage()
                ]

            ], 500);
        }
    }

    /// =======================================================
    /// KIRIM ULANG LAPORAN (dari tab Revisi di mobile)
    /// =======================================================

    public function resubmitLaporan(Request $request)
    {
        try {

            $uuid  = $request->uuid;
            $orgId = $request->org_id;

            if (!$uuid || !$orgId) {

                return response()->json([

                    'statusCode' => 400,

                    'message' =>
                    'Parameter uuid dan org_id wajib diisi.',

                    'data' => null,

                    'error' => [
                        'message' =>
                        'Parameter tidak lengkap'
                    ]

                ], 400);
            }

            $table = $this->determineTableFromUUID($uuid, $orgId);

            if (!$table) {

                return response()->json([

                    'statusCode' => 404,

                    'message' =>
                    'Tabel laporan tidak ditemukan.',

                    'data' => null,

                    'error' => null

                ], 404);
            }

            $existing = DB::table($table)
                ->where('uuid', $uuid)
                ->first();

            if (!$existing) {

                return response()->json([

                    'statusCode' => 404,

                    'message' =>
                    'Data laporan tidak ditemukan',

                    'data' => null,

                    'error' => null

                ], 404);
            }

            $currentStatus = strtolower($existing->status ?? '');

            // Laporan yang sudah disetujui tidak boleh dikirim ulang
            if (in_array($currentStatus, ['disetujui1', 'disetujui2', 'upload1', 'upload2', 'upload'])) {

                return response()->json([

                    'statusCode' => 400,

                    'message' =>
                    'Laporan yang sudah disetujui tidak dapat dikirim ulang.',

                    'data' => null,

                    'error' => [
                        'message' =>
                        'Status tidak mengizinkan kirim ulang'
                    ]

                ], 400);
            }

            // Revisi/Ditolak -> Menunggu (menunggu review admin di website).
            // Status lain (Proses/Menunggu) tidak diubah, cukup dianggap berhasil.
            if (in_array($currentStatus, ['revisi', 'ditolak'])) {

                DB::table($table)
                    ->where('uuid', $uuid)
                    ->update([
                        'status'     => 'Menunggu',
                        'updated_at' => now(),
                    ]);
            }

            return response()->json([

                'statusCode' => 200,

                'message' =>
                'Laporan berhasil dikirim ulang dan menunggu review admin.',

                'data' => [
                    'uuid' => $uuid
                ],

                'error' => null

            ], 200);
        } catch (\Exception $e) {

            return response()->json([

                'statusCode' => 500,

                'message' =>
                'Terjadi kesalahan server',

                'data' => null,

                'error' => [
                    'message' =>
                    $e->getMessage()
                ]

            ], 500);
        }
    }

    /// =======================================================
    /// FETCH REPORTS
    /// =======================================================

    private function fetchReports(
        $tables,
        $userId,
        $userRole,
        $userOrg
    ) {

        $results = [];

        foreach ($tables as $table) {

            try {

                $columns = [

                    'uuid',
                    'id_user',
                    'status',
                    'created_at',
                    'id_role',
                    'id_organization'
                ];

                if (\Illuminate\Support\Facades\Schema::hasColumn($table, 'catatan')) {
                    $columns[] = 'catatan';
                }

                $data = DB::table($table)

                    ->select($columns)

                    ->where(
                        'id_organization',
                        $userOrg
                    )

                    ->where(
                        'id_user',
                        $userId
                    )

                    ->where(
                        'id_role',
                        $userRole
                    )

                    ->get();

                foreach ($data as $row) {

                    if ($table === 'galerys') {
                        $row->status = $this->mapGaleriStatus($row->status);
                    }

                    $row->status = $this->mapStatusUntukMobile($row->status);

                    if (!property_exists($row, 'catatan')) {
                        $row->catatan = null;
                    }

                    $results[] = $row;
                }
            } catch (\Exception $e) {

                continue;
            }
        }

        return $results;
    }

    /// =======================================================
    /// KEGIATAN (galerys) - HELPER
    /// =======================================================

    // Status kegiatan di web: Proses -> upload1 (Kecamatan) -> upload2 (Kabupaten).
    // Disamakan dengan status laporan lain supaya filter Riwayat mobile tetap sama.
    private function mapGaleriStatus($status)
    {
        switch ($status) {
            case 'upload1':
                return 'Disetujui1';
            case 'upload2':
            case 'Upload':
                return 'Disetujui2';
            default:
                return $status;
        }
    }

    // Khusus aplikasi mobile: status 'Menunggu' (menunggu review admin)
    // ditampilkan sebagai 'Proses' supaya laporan hasil kirim ulang tetap
    // muncul di tab Proses. Di website tetap tampil 'Menunggu'.
    private function mapStatusUntukMobile($status)
    {
        return strtolower(trim((string) $status)) === 'menunggu'
            ? 'Proses'
            : $status;
    }

    private function formatGaleriDetail($row)
    {
        $names = json_decode($row->nama_peserta ?? '[]', true);

        return [
            'uuid'            => $row->uuid,
            'id_user'         => $row->id_user,
            'status'          => $this->mapGaleriStatus($row->status),
            'created_at'      => $row->created_at,
            'id_role'         => $row->id_role,
            'id_organization' => $row->id_organization,

            'nama_kegiatan'   => $row->deskripsi,
            'nama_peserta'    => is_array($names) ? implode("\n", $names) : '',
            'jabatan'         => $row->jabatan ?? null,
            'lokasi'          => $row->lokasi,
            'bidang'          => $row->bidang,
            'gambar_url'      => url('storage/gallery/' . $row->gambar),
        ];
    }

    // Sama dengan ReportController::normalizeNamaPeserta
    private function normalizeNamaPeserta($value)
    {
        if ($value === null) {
            return null;
        }

        if (is_string($value)) {
            $trim = trim($value);
            if ($trim === '') {
                return null;
            }
            $decoded = json_decode($trim, true);
            if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
                $value = $decoded;
            } else {
                $value = explode("\n", str_replace("\r", '', $trim));
            }
        }

        if (!is_array($value)) {
            return null;
        }

        $names = [];
        foreach ($value as $name) {
            $name = trim((string) $name);
            if ($name !== '' && !in_array(mb_strtolower($name), array_map('mb_strtolower', $names), true)) {
                $names[] = $name;
            }
        }

        return count($names) ? json_encode($names, JSON_UNESCAPED_UNICODE) : null;
    }

    /// =======================================================
    /// DETERMINE TABLE FROM UUID
    /// =======================================================

    private function determineTableFromUUID(
        $uuid,
        $orgId
    ) {
        $prefix = explode('-', $uuid)[0];

        $table = $this->uuidMapping[$orgId][$prefix]
            ?? null;

        // jika mapping array
        if (is_array($table)) {

            foreach ($table as $tbl) {

                $exists = DB::table($tbl)
                    ->where('uuid', $uuid)
                    ->exists();

                if ($exists) {
                    return $tbl;
                }
            }

            return null;
        }

        return $table;
    }
}
