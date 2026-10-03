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
            'laporan_gotong_royong'
        ],

        2 => [
            'laporan_pendidikan_n_keterampilan',
            'laporan_pengembangan_kehidupan'
        ],

        3 => [
            'laporan_kader_pokja3',
            'laporan_pangan',
            'laporan_sandang',
            'laporan_perumahan'
        ],

        4 => [
            'laporan_kader_pokja4',
            'laporan_bidang_kesehatan',
            'laporan_kelestarian_lingkungan_hidup',
            'laporan_perencanaan_sehat',
            'rekap_desa_bulanan',
            'rekap_desa_tahunan',
            'posyandu',
            'kegiatan_pokja4'
        ],

        5 => [
            'laporan_umum'
        ]
    ];

    /// =======================================================
    /// UUID TABLE MAPPING
    /// =======================================================

    private $uuidMapping = [

        1 => [
            'KP1'   => 'laporan_kader_pokja1',
            'KP1B1' => 'laporan_penghayatan_n_pengamalan',
            'KP1B2' => 'laporan_gotong_royong'
        ],

        2 => [
            'KP2B1' => 'laporan_pendidikan_n_keterampilan',
            'KP2B2' => 'laporan_pengembangan_kehidupan'
        ],

        3 => [
            'KP3'   => 'laporan_kader_pokja3',
            'KP3B1' => 'laporan_pangan',
            'KP3B2' => 'laporan_sandang',
            'KP3B3' => 'laporan_perumahan'
        ],

        4 => [
            'KP4'       => 'laporan_kader_pokja4',
            'KP4B1'     => 'laporan_bidang_kesehatan',
            'KP4B2'     => 'laporan_kelestarian_lingkungan_hidup',
            'KP4B3'     => 'laporan_perencanaan_sehat',
            'PRIORITAS' => ['rekap_desa_bulanan', 'rekap_desa_tahunan','posyandu', 'kegiatan_pokja4'],
            'UNGGULAN'  => ['rekap_desa_bulanan', 'rekap_desa_tahunan','posyandu', 'kegiatan_pokja4']
        ],

        5 => [
            'PKKUM' => 'laporan_umum'
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

            DB::table($table)

                ->where(
                    'uuid',
                    $uuid
                )

                ->update($data);

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

                $data = DB::table($table)

                    ->select(

                        'uuid',
                        'id_user',
                        'status',
                        'created_at',
                        'id_role',
                        'id_organization'
                    )

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

                    $results[] = $row;
                }
            } catch (\Exception $e) {

                continue;
            }
        }

        return $results;
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
