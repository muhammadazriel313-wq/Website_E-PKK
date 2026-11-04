<?php

namespace App\Http\Controllers\backend;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Services\Pokja1ReportDeletion;

class DecLaporanPokja1Controller extends Controller
{
    public function index()
    {
        $data2 = collect();

        // 1. CEK KABUPATEN DULU
        if (Auth::guard('web')->check()) {
            $data2 = DB::table('laporan_kader_pokja1')
                ->leftJoin('users_mobile', 'laporan_kader_pokja1.id_user', '=', 'users_mobile.id')
                ->leftJoin('subdistrict', 'users_mobile.id_subdistrict', '=', 'subdistrict.id')
                ->leftJoin('village', 'users_mobile.id_village', '=', 'village.id')
                ->select('laporan_kader_pokja1.*', 'subdistrict.name as nama_kec', 'village.name as nama_desa')
                ->whereIn('laporan_kader_pokja1.status', ['Disetujui2', 'disetujui2', 'DISETUJUI2'])
                ->orderBy('id_kader_pokja1', 'desc')
                ->get();
        }
        // 2. CEK KECAMATAN
        elseif (Auth::guard('pengguna')->check()) {
            $user = Auth::guard('pengguna')->user();
            if ($user->id_role == 2) {
                $data2 = DB::table('laporan_kader_pokja1')
                    ->leftJoin('users_mobile', 'laporan_kader_pokja1.id_user', '=', 'users_mobile.id')
                    ->leftJoin('subdistrict', 'users_mobile.id_subdistrict', '=', 'subdistrict.id')
                    ->leftJoin('village', 'users_mobile.id_village', '=', 'village.id')
                    ->select('laporan_kader_pokja1.*', 'subdistrict.name as nama_kec', 'village.name as nama_desa')
                    ->where('users_mobile.id_subdistrict', $user->id_subdistrict)
                    ->where('users_mobile.id_role', 1)
                    ->whereIn('laporan_kader_pokja1.status', ['Disetujui1', 'disetujui1', 'DISETUJUI1'])
                    ->orderBy('id_kader_pokja1', 'desc')
                    ->get();
            }
        }

        return view('backend.declaporanpokja1', compact('data2'));
    }

    public function destroy(string $id_kader_pokja1, Pokja1ReportDeletion $deletion)
    {
        try {
            $deletion->delete('kader', $id_kader_pokja1);
        } catch (\Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException $exception) {
            abort(403, 'Anda tidak berhak menghapus laporan ini.');
        } catch (\Symfony\Component\HttpKernel\Exception\NotFoundHttpException $exception) {
            return redirect()->route('declaporanpokja1.index')->with('error', 'Laporan tidak ditemukan.');
        }

        return redirect()->route('declaporanpokja1.index')->with('success', 'Laporan berhasil dihapus permanen.');
    }
}
