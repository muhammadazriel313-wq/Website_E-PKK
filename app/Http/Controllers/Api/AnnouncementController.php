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
            $limit = $request->limit ?? 5;
            $page = $request->page ?? 1;
            $offset = ($page - 1) * $limit;

            //  ambil data
            $data = DB::table('pengumumen')
                ->select(
                    'id',
                    'judulPengumuman as judul_pengumuman',
                    'deskripsiPengumuman as deskripsi_pengumuman',
                    'tempatPengumuman as tempat_pengumuman',
                    'tanggalPengumuman as tanggal_pengumuman',
                    'updated_at',
                    'created_at'
                )
                ->orderBy('tanggalPengumuman', 'desc')
                ->limit($limit)
                ->offset($offset)
                ->get();

            //  total data
            $totalData = DB::table('pengumumen')->count();

            if ($data->isEmpty()) {
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
                    'total_halaman' => ceil($totalData / $limit),
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
