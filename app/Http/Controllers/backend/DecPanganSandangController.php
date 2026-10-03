<?php

namespace App\Http\Controllers\backend;

use App\Models\PanganSandang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class DecPanganSandangController extends Controller
{
    /**
     * Halaman gabungan: Sudah Disetujui / Riwayat
     */
    public function index()
    {
        $data = collect();

        // =====================================
        // 1. WEB KABUPATEN (Lihat Riwayat Final)
        // =====================================
        if (Auth::guard('web')->check()) {
            $data = DB::table('laporan_pangan_sandang')
                ->leftJoin('users_mobile', 'laporan_pangan_sandang.id_user', '=', 'users_mobile.id')
                ->leftJoin('subdistrict', 'users_mobile.id_subdistrict', '=', 'subdistrict.id')
                ->leftJoin('village', 'users_mobile.id_village', '=', 'village.id')
                ->select('laporan_pangan_sandang.*', 'subdistrict.name as nama_kec', 'village.name as nama_desa')
                ->whereIn('laporan_pangan_sandang.status', ['Disetujui2', 'disetujui2', 'DISETUJUI2'])
                ->orderBy('id_pangan_sandang', 'desc')
                ->get();
        }
        // =====================================
        // 2. PENGGUNA MOBILE (KECAMATAN / DESA)
        // =====================================
        elseif (Auth::guard('pengguna')->check()) {
            $user = Auth::guard('pengguna')->user();

            if ($user->id_role == 2) {
                $data = DB::table('laporan_pangan_sandang')
                    ->leftJoin('users_mobile', 'laporan_pangan_sandang.id_user', '=', 'users_mobile.id')
                    ->leftJoin('subdistrict', 'users_mobile.id_subdistrict', '=', 'subdistrict.id')
                    ->leftJoin('village', 'users_mobile.id_village', '=', 'village.id')
                    ->select('laporan_pangan_sandang.*', 'subdistrict.name as nama_kec', 'village.name as nama_desa')
                    ->where('users_mobile.id_subdistrict', $user->id_subdistrict)
                    ->whereIn('laporan_pangan_sandang.status', ['Disetujui1', 'disetujui1', 'DISETUJUI1'])
                    ->orderBy('id_pangan_sandang', 'desc')
                    ->get();
            } else {
                $data = DB::table('laporan_pangan_sandang')
                    ->leftJoin('users_mobile', 'laporan_pangan_sandang.id_user', '=', 'users_mobile.id')
                    ->leftJoin('subdistrict', 'users_mobile.id_subdistrict', '=', 'subdistrict.id')
                    ->leftJoin('village', 'users_mobile.id_village', '=', 'village.id')
                    ->select('laporan_pangan_sandang.*', 'subdistrict.name as nama_kec', 'village.name as nama_desa')
                    ->where('laporan_pangan_sandang.id_user', $user->id)
                    ->whereIn('laporan_pangan_sandang.status', ['Disetujui1', 'Disetujui2'])
                    ->orderBy('id_pangan_sandang', 'desc')
                    ->get();
            }
        }

        return view('backend.decpangansandang', compact('data'));
    }

    public function destroy(string $id)
    {
        $data = PanganSandang::find($id);
        if ($data) {
            $data->delete();
            return redirect()->route('decpangansandang.index')->with(['success' => 'Berhasil Menghapus Riwayat Laporan']);
        }
        return redirect()->route('decpangansandang.index')->with(['error' => 'Data tidak ditemukan']);
    }
}
