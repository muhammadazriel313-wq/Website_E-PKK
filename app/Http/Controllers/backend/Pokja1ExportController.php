<?php

namespace App\Http\Controllers\backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;

class Pokja1ExportController extends Controller
{
    public function exportToSheet(Request $request)
    {
        try {
            // [PERUBAHAN 2026-10-09] Mengambil URL Apps Script dari config services; URL hardcode dinonaktifkan
            // $url = "https://script.google.com/macros/s/AKfycbzTkeEtrbv6b2_vdoetwHKMzY3CxBseQ47fVHAwlOpTyrRVBevwCpKIm7_B6hVOhmCf/exec";
            $url = config('services.sheets.script_url');

            if (empty($url)) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'URL Google Sheets belum diatur di .env'
                ], 500);
            }

            // Data dari form
            $data = [
                'bulan' => $request->bulan,
                'tahun' => $request->tahun,
                'bidang' => $request->bidang,
                'user' => Auth::user()->name ?? 'Guest',
                'source' => 'Laravel_Pokja1',
                'timestamp' => now()->toDateTimeString(),
                'pokja' => 'POKJA_1'
            ];

            // Kirim ke Apps Script
            $response = Http::withHeaders([
                'Content-Type' => 'text/plain'
            ])->post($url, json_encode($data));

            return response()->json([
                'status' => 'success',
                'message' => 'Data berhasil dikirim ke Google Sheets',
                'response' => $response->body()
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 500);
        }
    }
}