<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\Pokja1SpreadsheetExportData;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Throwable;

class Pokja1ExportApiController extends Controller
{
    public function index(Request $request, Pokja1SpreadsheetExportData $exportData)
    {
        $expectedToken = (string) config('services.export_api.token', '');
        $providedToken = (string) $request->header('X-Export-Token', '');

        if ($expectedToken === '' || $providedToken === '' || !hash_equals($expectedToken, $providedToken)) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        $validator = Validator::make($request->query(), [
            'tahun' => ['required', 'integer', 'min:2021', 'max:' . (now()->year + 1)],
            'bulan' => ['nullable', 'integer', 'between:1,12'],
            'bidang' => ['required', 'in:semua,penghayatan,gotongroyong,kader'],
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => 'Filter tahun, bulan, atau bidang tidak valid.'], 422);
        }

        try {
            $filters = $validator->validated();
            $bulan = isset($filters['bulan']) && $filters['bulan'] !== '' ? (int) $filters['bulan'] : null;

            return response()->json([
                'data' => $exportData->get((int) $filters['tahun'], $bulan, $filters['bidang']),
            ]);
        } catch (Throwable $exception) {
            Log::error('Pokja 1 export data retrieval failed.', ['exception' => $exception::class]);
            return response()->json(['message' => 'Data laporan tidak dapat diambil saat ini.'], 500);
        }
    }
}
