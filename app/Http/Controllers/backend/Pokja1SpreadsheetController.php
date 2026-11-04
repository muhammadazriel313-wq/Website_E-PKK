<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Services\Pokja1SpreadsheetExportData;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Throwable;

class Pokja1SpreadsheetController extends Controller
{
    public function export(Request $request, Pokja1SpreadsheetExportData $exportData): JsonResponse
    {
        if (!auth()->guard('web')->check()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Ekspor spreadsheet hanya tersedia untuk akun kabupaten.',
            ], 403);
        }

        $validator = Validator::make($request->all(), [
            'tahun' => ['required', 'integer', 'min:2021', 'max:' . (now()->year + 1)],
            'bulan' => ['nullable', 'integer', 'between:1,12'],
            'bidang' => ['required', 'in:semua,penghayatan,gotongroyong,kader'],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Periksa pilihan tahun, bulan, dan bidang.',
                'errors' => $validator->errors(),
            ], 422);
        }

        $scriptUrl = (string) config('services.sheets.script_url', '');
        $triggerToken = (string) config('services.sheets.trigger_token', '');

        if ($scriptUrl === '' || $triggerToken === '') {
            return response()->json([
                'status' => 'error',
                'message' => 'Integrasi spreadsheet belum dikonfigurasi. Hubungi pengelola aplikasi.',
            ], 503);
        }

        $filters = $validator->validated();
        $tahun = (int) $filters['tahun'];
        $bulan = isset($filters['bulan']) && $filters['bulan'] !== '' ? (int) $filters['bulan'] : null;
        $bidang = $filters['bidang'];
        $namaBulan = [
            1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
            5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
            9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember',
        ];
        $labelPeriode = $bulan === null
            ? 'Periode: Tahun ' . $tahun
            : 'Periode: ' . $namaBulan[$bulan] . ' ' . $tahun;

        try {
            $data = $exportData->get($tahun, $bulan, $bidang);
            $response = Http::timeout(120)
                ->withOptions(['allow_redirects' => ['max' => 5, 'strict' => false]])
                ->asJson()
                ->post($scriptUrl, [
                    'token' => $triggerToken,
                    'tahun' => $tahun,
                    'bulan' => $bulan,
                    'bidang' => $bidang,
                    'label_periode' => $labelPeriode,
                    'data' => $data,
                ]);

            if (!$response->successful()) {
                Log::warning('Pokja 1 spreadsheet Web App returned an unsuccessful HTTP status.', [
                    'status' => $response->status(),
                ]);

                return response()->json([
                    'status' => 'error',
                    'message' => 'Spreadsheet tidak dapat diperbarui. Coba lagi atau hubungi pengelola aplikasi.',
                ], 502);
            }

            $result = $response->json();
            if (!is_array($result) || ($result['status'] ?? null) !== 'success') {
                return response()->json([
                    'status' => 'error',
                    'message' => is_array($result) && isset($result['message'])
                        ? (string) $result['message']
                        : 'Spreadsheet mengembalikan respons yang tidak dapat dibaca.',
                ], 502);
            }

            $allowedTabs = [
                'penghayatan dan pengamalan pancasila',
                'gotong royong',
                'KADER POKJA 1',
            ];
            $spreadsheetUrl = (string) config('services.sheets.spreadsheet_url', '');
            $baseUrl = preg_replace('~/edit(?:[?#].*)?$~', '/edit', $spreadsheetUrl);
            if ($baseUrl === $spreadsheetUrl && !str_ends_with($baseUrl, '/edit')) {
                $baseUrl = rtrim($spreadsheetUrl, '/');
            }

            $rawResults = $result['results'] ?? [];
            if (!is_array($rawResults)) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Spreadsheet mengembalikan hasil yang tidak lengkap.',
                ], 502);
            }

            $validatedResults = collect($rawResults)->filter(function ($item) use ($allowedTabs) {
                return is_array($item)
                    && in_array($item['tab'] ?? null, $allowedTabs, true)
                    && is_int($item['count'] ?? null)
                    && $item['count'] >= 0
                    && in_array($item['label'] ?? null, ['written', 'merged', 'protected'], true)
                    && (!array_key_exists('sheet_id', $item)
                        || (is_int($item['sheet_id']) && $item['sheet_id'] >= 0));
            })->map(function ($item) {
                return [
                    'tab' => $item['tab'],
                    'count' => $item['count'],
                    'label' => $item['label'],
                    'sheet_id' => $item['sheet_id'] ?? null,
                ];
            })->values();

            if ($validatedResults->count() !== count($data)) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Spreadsheet mengembalikan hasil yang tidak lengkap.',
                ], 502);
            }

            $results = $validatedResults->map(function ($item) {
                return ['tab' => $item['tab'], 'count' => $item['count'], 'label' => $item['label']];
            });
            $links = $validatedResults->map(function ($item) use ($baseUrl) {
                $url = $baseUrl;
                if (is_int($item['sheet_id']) && $item['sheet_id'] >= 0) {
                    $url .= '#gid=' . $item['sheet_id'];
                }

                return ['tab' => $item['tab'], 'url' => $url];
            })->values();

            $total = $results->sum('count');
            $message = $total === 0
                ? 'Tidak ada laporan Disetujui2 pada periode ini.'
                : 'Spreadsheet berhasil diperbarui.';

            return response()->json([
                'status' => 'success',
                'message' => $message,
                'results' => $results,
                'links' => $links,
                'diekspor_sebagai' => 'Kabupaten',
            ]);
        } catch (Throwable $exception) {
            Log::error('Pokja 1 spreadsheet export failed.', ['exception' => $exception::class]);

            return response()->json([
                'status' => 'error',
                'message' => 'Spreadsheet tidak dapat diperbarui. Periksa koneksi dan coba lagi.',
            ], 502);
        }
    }
}
