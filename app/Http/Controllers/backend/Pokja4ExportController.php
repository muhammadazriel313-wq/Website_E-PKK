<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class Pokja4ExportController extends Controller
{
    public function exportToSheet(Request $request)
    {
        $bulan = $request->bulan;
        $tahun = $request->tahun;
        $bidang = $request->bidang;

        $semuaStatus = ['Proses', 'proses', 'Disetujui1', 'Disetujui2'];
        $data = [];

        try {
            // 1. AMBIL DATA DARI DATABASE
            if ($bidang == 'kesehatan') {
                $data = DB::table('laporan_bidang_kesehatan')
                    ->join('users_mobile', 'laporan_bidang_kesehatan.id_user', '=', 'users_mobile.id')
                    ->join('subdistrict', 'users_mobile.id_subdistrict', '=', 'subdistrict.id')
                    ->join('village', 'users_mobile.id_village', '=', 'village.id')
                    ->select('subdistrict.name as nama_kecamatan', 'village.name as nama_desa', 'laporan_bidang_kesehatan.*')
                    ->when($bulan, fn($q) => $q->whereMonth('laporan_bidang_kesehatan.created_at', $bulan))
                    ->when($tahun, fn($q) => $q->whereYear('laporan_bidang_kesehatan.created_at', $tahun))
                    ->whereIn('laporan_bidang_kesehatan.status', $semuaStatus)
                    ->get();

            } elseif ($bidang == 'kelestarian') {
                $data = DB::table('laporan_kelestarian_lingkungan_hidup')
                    ->join('users_mobile', 'laporan_kelestarian_lingkungan_hidup.id_user', '=', 'users_mobile.id')
                    ->join('subdistrict', 'users_mobile.id_subdistrict', '=', 'subdistrict.id')
                    ->join('village', 'users_mobile.id_village', '=', 'village.id')
                    ->select('subdistrict.name as nama_kecamatan', 'village.name as nama_desa', 'laporan_kelestarian_lingkungan_hidup.*')
                    ->when($bulan, fn($q) => $q->whereMonth('laporan_kelestarian_lingkungan_hidup.created_at', $bulan))
                    ->when($tahun, fn($q) => $q->whereYear('laporan_kelestarian_lingkungan_hidup.created_at', $tahun))
                    ->whereIn('laporan_kelestarian_lingkungan_hidup.status', $semuaStatus)
                    ->get();

            } elseif ($bidang == 'perencanaan') {
                $data = DB::table('laporan_perencanaan_sehat')
                    ->join('users_mobile', 'laporan_perencanaan_sehat.id_user', '=', 'users_mobile.id')
                    ->join('subdistrict', 'users_mobile.id_subdistrict', '=', 'subdistrict.id')
                    ->join('village', 'users_mobile.id_village', '=', 'village.id')
                    ->select('subdistrict.name as nama_kecamatan', 'village.name as nama_desa', 'laporan_perencanaan_sehat.*')
                    ->when($bulan, fn($q) => $q->whereMonth('laporan_perencanaan_sehat.created_at', $bulan))
                    ->when($tahun, fn($q) => $q->whereYear('laporan_perencanaan_sehat.created_at', $tahun))
                    ->whereIn('laporan_perencanaan_sehat.status', $semuaStatus)
                    ->get();

            } elseif ($bidang == 'kader') {
                $data = DB::table('laporan_kader_pokja4')
                    ->join('users_mobile', 'laporan_kader_pokja4.id_user', '=', 'users_mobile.id')
                    ->join('subdistrict', 'users_mobile.id_subdistrict', '=', 'subdistrict.id')
                    ->join('village', 'users_mobile.id_village', '=', 'village.id')
                    ->select('subdistrict.name as nama_kecamatan', 'village.name as nama_desa', 'laporan_kader_pokja4.*')
                    ->when($bulan, fn($q) => $q->whereMonth('laporan_kader_pokja4.created_at', $bulan))
                    ->when($tahun, fn($q) => $q->whereYear('laporan_kader_pokja4.created_at', $tahun))
                    ->whereIn('laporan_kader_pokja4.status', $semuaStatus)
                    ->get();
            }

            // Jika Data Kosong
            if (count($data) == 0) {
                return response()->json(['status' => 'empty']);
            }

            // 2. KIRIM KE GOOGLE APPS SCRIPT VIA LARAVEL (BEBAS CORS)
            // [PERUBAHAN 2026-10-09] Mengambil URL Apps Script dari config services; URL hardcode dinonaktifkan
            // $url = "https://script.google.com/macros/s/AKfycbxI94KbVy5KxSoClLSGjrqSLCaU9rqGdiHghFFcLnKlFV9-SgRnHDhLR5661sBsQukN/exec";
            $url = config('services.sheets.script_url');

            if (empty($url)) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'URL Google Sheets belum diatur di .env'
                ], 500);
            }

            $payload = [
                'bidang' => $bidang,
                'data' => $data
            ];

            // Kirim sesuai format yang kita set di Google Script (e.parameter.data)
            $response = Http::asForm()->post($url, [
                'data' => json_encode($payload)
            ]);

            $result = json_decode($response->body(), true);

            if (isset($result['status']) && $result['status'] == 'success') {
                return response()->json(['status' => 'success']);
            } else {
                return response()->json([
                    'status' => 'error', 
                    'message' => $result['message'] ?? 'Gagal diproses oleh Google'
                ]);
            }

        } catch (\Exception $e) {
            Log::error('Export Pokja 4 Error: ' . $e->getMessage());
            return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }
}