<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Services\Pokja1SpreadsheetExportData;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Throwable;

class Pokja1DistrictSpreadsheetController extends Controller
{
    public function export(Request $request, Pokja1SpreadsheetExportData $exportData): JsonResponse
    {
        $user = auth()->guard('pengguna')->user();
        if (!$user || (int) $user->id_role !== 2) {
            return response()->json(['status' => 'error', 'message' => 'Ekspor spreadsheet hanya tersedia untuk akun kecamatan.'], 403);
        }

        if (array_diff(array_keys($request->all()), ['tahun', 'bulan', 'bidang'])) {
            return response()->json(['status' => 'error', 'message' => 'Data ekspor tidak valid.'], 422);
        }

        $validator = Validator::make($request->all(), [
            'tahun' => ['required', 'integer', 'min:2021', 'max:' . (now()->year + 1)],
            'bulan' => ['nullable', 'integer', 'between:1,12'],
            'bidang' => ['required', 'in:semua,penghayatan,gotongroyong,kader'],
            'id_kecamatan' => ['prohibited'],
            'nama_kecamatan' => ['prohibited'],
            'target' => ['prohibited'],
            'file_id' => ['prohibited'],
        ]);
        if ($validator->fails()) {
            return response()->json(['status' => 'error', 'message' => 'Periksa pilihan tahun, bulan, dan bidang.', 'errors' => $validator->errors()], 422);
        }

        $scriptUrl = (string) config('services.sheets.script_url', '');
        $triggerToken = (string) config('services.sheets.trigger_token', '');
        if ($scriptUrl === '' || $triggerToken === '') {
            return response()->json(['status' => 'error', 'message' => 'Integrasi spreadsheet belum dikonfigurasi. Hubungi pengelola aplikasi.'], 503);
        }

        $district = DB::table('subdistrict')->where('id', $user->id_subdistrict)->first(['id', 'name']);
        if (!$district || !is_numeric($district->id) || (int) $district->id < 1) {
            return response()->json(['status' => 'error', 'message' => 'Data kecamatan akun tidak valid.'], 403);
        }

        $filters = $validator->validated();
        $tahun = (int) $filters['tahun'];
        $bulan = isset($filters['bulan']) && $filters['bulan'] !== '' ? (int) $filters['bulan'] : null;
        $bidang = $filters['bidang'];
        $namaBulan = [1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April', 5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus', 9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'];
        $periode = $bulan === null ? 'Tahun ' . $tahun : $namaBulan[$bulan] . ' ' . $tahun;
        $labelPeriode = 'Kecamatan ' . $district->name . ' | Periode: ' . $periode;

        try {
            $data = $exportData->getForDistrict($tahun, $bulan, $bidang, (int) $district->id, ['Disetujui1', 'Disetujui2']);
            $response = Http::timeout(120)->withOptions(['allow_redirects' => ['max' => 5, 'strict' => false]])->asJson()->post($scriptUrl, [
                'token' => $triggerToken,
                'tahun' => $tahun,
                'bulan' => $bulan,
                'bidang' => $bidang,
                'label_periode' => $labelPeriode,
                'target' => ['tipe' => 'kecamatan', 'id_kecamatan' => (int) $district->id, 'nama_kecamatan' => (string) $district->name],
                'data' => $data,
            ]);

            if (!$response->successful()) {
                Log::warning('Pokja 1 district spreadsheet Web App returned an unsuccessful HTTP status.', ['status' => $response->status()]);
                return response()->json(['status' => 'error', 'message' => 'Spreadsheet tidak dapat diperbarui. Coba lagi atau hubungi pengelola aplikasi.'], 502);
            }

            $result = $response->json();
            if (!is_array($result) || ($result['status'] ?? null) !== 'success') {
                return response()->json(['status' => 'error', 'message' => is_array($result) && isset($result['message']) ? (string) $result['message'] : 'Spreadsheet mengembalikan respons yang tidak dapat dibaca.'], 502);
            }

            $allowedTabs = ['penghayatan dan pengamalan pancasila', 'gotong royong', 'KADER POKJA 1'];
            $rawResults = $result['results'] ?? null;
            $fileUrl = $result['file_url'] ?? null;
            if (!is_array($rawResults) || !is_string($fileUrl) || !preg_match('~^https://docs\.google\.com/spreadsheets/d/([A-Za-z0-9_-]+)/edit$~', $fileUrl, $fileMatches)) {
                return response()->json(['status' => 'error', 'message' => 'Spreadsheet mengembalikan hasil yang tidak lengkap.'], 502);
            }

            $validatedResults = collect($rawResults)->filter(function ($item) use ($allowedTabs) {
                return is_array($item)
                    && in_array($item['tab'] ?? null, $allowedTabs, true)
                    && is_int($item['count'] ?? null) && $item['count'] >= 0
                    && in_array($item['label'] ?? null, ['written', 'merged', 'protected'], true)
                    && is_int($item['sheet_id'] ?? null) && $item['sheet_id'] >= 0;
            })->map(function ($item) use ($fileMatches) {
                return [
                    'tab' => $item['tab'],
                    'count' => $item['count'],
                    'label' => $item['label'],
                    'url' => 'https://docs.google.com/spreadsheets/d/' . $fileMatches[1] . '/edit#gid=' . $item['sheet_id'],
                ];
            })->values();

            if ($validatedResults->count() !== count($data)) {
                return response()->json(['status' => 'error', 'message' => 'Spreadsheet mengembalikan hasil yang tidak lengkap.'], 502);
            }

            $total = $validatedResults->sum('count');
            return response()->json([
                'status' => 'success',
                'message' => $total === 0 ? 'Tidak ada laporan Disetujui1 atau Disetujui2 pada periode ini.' : 'Spreadsheet berhasil diperbarui.',
                'results' => $validatedResults->map(fn ($item) => ['tab' => $item['tab'], 'count' => $item['count'], 'label' => $item['label']])->all(),
                'links' => $validatedResults->map(fn ($item) => ['tab' => $item['tab'], 'url' => $item['url']])->all(),
                'file_url' => $fileUrl,
                'diekspor_sebagai' => 'Kecamatan ' . $district->name,
            ]);
        } catch (Throwable $exception) {
            Log::error('Pokja 1 district spreadsheet export failed.', ['exception' => $exception::class]);
            return response()->json(['status' => 'error', 'message' => 'Spreadsheet tidak dapat diperbarui. Periksa koneksi dan coba lagi.'], 502);
        }
    }
}
