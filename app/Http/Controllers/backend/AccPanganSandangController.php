<?php

namespace App\Http\Controllers\backend;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class AccPanganSandangController extends Controller
{
    public function index()
    {
        $menunggu = 0;
        $disetujui = 0;

        // =========================
        // 1. WEB KABUPATEN (ADMIN)
        // =========================
        if (Auth::guard('web')->check()) {

            $menunggu = DB::table('laporan_pangan_sandang')
                ->leftJoin('users_mobile', 'laporan_pangan_sandang.id_user', '=', 'users_mobile.id')
                ->where(function ($query) {
                    $query->where(function ($q) {
                        $q->where('users_mobile.id_role', 1)
                            ->whereIn('laporan_pangan_sandang.status', ['Disetujui1', 'disetujui1', 'DISETUJUI1']);
                    })
                    ->orWhere(function ($q) {
                        $q->where('users_mobile.id_role', 2)
                            ->whereIn('laporan_pangan_sandang.status', ['Proses', 'proses', 'PROSES']);
                    });
                })
                ->count();

            $disetujui = DB::table('laporan_pangan_sandang')
                ->whereIn('status', ['Disetujui2', 'disetujui2', 'DISETUJUI2'])
                ->count();
        }

        // =========================
        // 2. WEB KECAMATAN / DESA
        // =========================
        elseif (Auth::guard('pengguna')->check()) {

            $user = Auth::guard('pengguna')->user();

            if ($user->id_role == 2) {

                $menunggu = DB::table('laporan_pangan_sandang')
                    ->leftJoin('users_mobile', 'laporan_pangan_sandang.id_user', '=', 'users_mobile.id')
                    ->where('users_mobile.id_subdistrict', $user->id_subdistrict)
                    ->where('users_mobile.id_role', 1)
                    ->whereIn('laporan_pangan_sandang.status', ['Proses', 'proses', 'PROSES'])
                    ->count();

                $disetujui = DB::table('laporan_pangan_sandang')
                    ->leftJoin('users_mobile', 'laporan_pangan_sandang.id_user', '=', 'users_mobile.id')
                    ->where('users_mobile.id_subdistrict', $user->id_subdistrict)
                    ->where('users_mobile.id_role', 1)
                    ->whereIn('laporan_pangan_sandang.status', ['Disetujui1', 'disetujui1', 'DISETUJUI1'])
                    ->count();
            }
        }

        return view('backend.accpangansandang', compact('menunggu', 'disetujui'));
    }
}
