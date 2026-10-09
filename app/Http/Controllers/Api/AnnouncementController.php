<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AnnouncementController extends Controller
{
        public function index(Request $request)
    {
        try {
            $limit = (int)($request->limit ?? 5);
            $page = (int)($request->page ?? 1);
            $offset = ($page - 1) * $limit;

            // [PERUBAHAN 08-10-2026] Parameter opsional filter tanggal dan bulan
            $dari = $request->input('dari');
            $sampai = $request->input('sampai');
            $bulan = $request->input('bulan');

            // Validasi format tanggal opsional jika disertakan
            if ($dari && !preg_match('/^\d{4}-\d{2}-\d{2}$/', $dari)) {
                return response()->json([
                    'statusCode' => 400,
                    'message' => 'Format parameter dari harus YYYY-MM-DD',
                    'data' => [],
                    'pagination' => null,
                    'error' => ['message' => 'Format parameter dari harus YYYY-MM-DD']
                ], 400);
            }
            if ($sampai && !preg_match('/^\d{4}-\d{2}-\d{2}$/', $sampai)) {
                return response()->json([
                    'statusCode' => 400,
                    'message' => 'Format parameter sampai harus YYYY-MM-DD',
                    'data' => [],
                    'pagination' => null,
                    'error' => ['message' => 'Format parameter sampai harus YYYY-MM-DD']
                ], 400);
            }
            if ($bulan && !preg_match('/^\d{4}-\d{2}$/', $bulan)) {
                return response()->json([
                    'statusCode' => 400,
                    'message' => 'Format parameter bulan harus YYYY-MM',
                    'data' => [],
                    'pagination' => null,
                    'error' => ['message' => 'Format parameter bulan harus YYYY-MM']
                ], 400);
            }

            // Query dasar
            $query = DB::table('pengumumen')
                ->select(
                    'id',
                    'judulPengumuman as judul_pengumuman',
                    'deskripsiPengumuman as deskripsi_pengumuman',
                    'tempatPengumuman as tempat_pengumuman',
                    'tanggalPengumuman as tanggal_pengumuman',
                    'updated_at',
                    'created_at'
                );

            // [PERUBAHAN 08-10-2026] Opsi C: rentang tanggalPengumuman ATAU created_at dalam rentang (dikonversi ke WIB dari UTC)
            if ($dari && $sampai) {
                $query->where(function ($q) use ($dari, $sampai) {
                    $q->whereBetween('tanggalPengumuman', [$dari, $sampai])
                      ->orWhereRaw("DATE(DATE_ADD(created_at, INTERVAL 7 HOUR)) BETWEEN ? AND ?", [$dari, $sampai]);
                });
            } elseif ($dari) {
                $query->where(function ($q) use ($dari) {
                    $q->where('tanggalPengumuman', '>=', $dari)
                      ->orWhereRaw("DATE(DATE_ADD(created_at, INTERVAL 7 HOUR)) >= ?", [$dari]);
                });
            } elseif ($sampai) {
                $query->where(function ($q) use ($sampai) {
                    $q->where('tanggalPengumuman', '<=', $sampai)
                      ->orWhereRaw("DATE(DATE_ADD(created_at, INTERVAL 7 HOUR)) <= ?", [$sampai]);
                });
            }

            // [PERUBAHAN 08-10-2026] Filter bulan khusus kalender riwayat (hanya memakai tanggalPengumuman)
            if ($bulan) {
                $query->whereRaw("DATE_FORMAT(tanggalPengumuman, '%Y-%m') = ?", [$bulan]);
            }

            // Hitung total data
            $totalData = $query->count();

            // Ambil data
            $data = $query->orderBy('tanggalPengumuman', 'desc')
                ->limit($limit)
                ->offset($offset)
                ->get();

            $isFiltered = ($dari || $sampai || $bulan);

            if ($data->isEmpty()) {
                // Untuk pemanggilan berfilter yang kosong, kembalikan 200 dengan data kosong
                if ($isFiltered) {
                    return response()->json([
                        'statusCode' => 200,
                        'message' => 'Data pengumuman tidak ditemukan',
                        'data' => [],
                        'pagination' => [
                            'total_data' => 0,
                            'total_halaman' => 0,
                            'halaman_sekarang' => (int)$page,
                            'data_per_halaman' => (int)$limit
                        ],
                        'error' => null
                    ], 200);
                }

                // Perilaku lama tanpa parameter: tetap kembalikan 404 saat kosong
                return response()->json([
                    'statusCode' => 404,
                    'message' => 'Data pengumuman tidak ditemukan',
                    'data' => [],
                    'pagination' => null,
                    'error' => null
                ], 404);
            }

            return response()->json([
                'statusCode' => 200,
                'message' => 'Berhasil mengambil data pengumuman',
                'data' => $data,
                'pagination' => [
                    'total_data' => $totalData,
                    'total_halaman' => (int)ceil($totalData / $limit),
                    'halaman_sekarang' => (int)$page,
                    'data_per_halaman' => (int)$limit
                ],
                'error' => null
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'statusCode' => 500,
                'message' => 'Terjadi kesalahan server',
                'data' => null,
                'pagination' => null,
                'error' => [
                    'message' => $e->getMessage()
                ]
            ], 500);
        }
    }

    // DETAIL PENGUMUMAN
    public function show($id)
    {
        try {
            //  ambil data berdasarkan ID
            $data = DB::table('pengumumen')
                ->where('id', $id)
                ->get();

            //  jika tidak ditemukan
            if ($data->isEmpty()) {
                return response()->json([
                    'statusCode' => 404,
                    'message' => 'Data Announcement not found!',
                    'data' => [],
                    'error' => null
                ], 404);
            }

            //  format response
            $result = $data->map(function ($item) {
                return [
                    'id' => $item->id,
                    'judulPengumuman' => $item->judulPengumuman,
                    'deskripsiPengumuman' => $item->deskripsiPengumuman,
                    'tempatPengumuman' => $item->tempatPengumuman,
                    'updated_at' => $item->updated_at,
                    'created_at' => $item->created_at
                ];
            });

            return response()->json([
                'statusCode' => 200,
                'message' => 'Successfully fetched detail Announcement!',
                'data' => $result,
                'error' => null
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'statusCode' => 500,
                'message' => 'Internal Server Error',
                'data' => [],
                'error' => [
                    'message' => $e->getMessage()
                ]
            ], 500);
        }
    }
}
