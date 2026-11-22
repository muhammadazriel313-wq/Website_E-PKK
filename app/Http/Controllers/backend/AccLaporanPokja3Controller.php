<?php

namespace App\Http\Controllers\backend;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class AccLaporanPokja3Controller extends Controller
{
    public function index()
    {
        $lap1 = 0;
        $lap2 = 0;
        $data = collect();

        // =====================================
        // 1. WEB KABUPATEN (ADMIN)
        // =====================================
        if (Auth::guard('web')->check()) {

            // MENUNGGU ACC KABUPATEN
            $lap1 = DB::table('laporan_kader_pokja3')
                ->leftJoin('users_mobile', 'laporan_kader_pokja3.id_user', '=', 'users_mobile.id')

                ->where(function ($query) {

                    // dari desa yang sudah acc kecamatan
                    $query->where(function ($q) {
                        $q->where('users_mobile.id_role', 1)
                            ->whereIn(
                                'laporan_kader_pokja3.status',
                                ['Disetujui1', 'disetujui1', 'DISETUJUI1']
                            );
                    })

                        // dari mobile kecamatan
                        ->orWhere(function ($q) {
                            $q->where('users_mobile.id_role', 2)
                                ->whereIn(
                                    'laporan_kader_pokja3.status',
                                    ['Proses', 'proses', 'PROSES']
                                );
                        });
                })

                ->count();

            // SUDAH SELESAI ACC KABUPATEN
            $lap2 = DB::table('laporan_kader_pokja3')
                ->whereIn(
                    'status',
                    ['Disetujui2', 'disetujui2', 'DISETUJUI2']
                )
                ->count();
        }

        // =====================================
        // 2. PENGGUNA MOBILE (KECAMATAN / DESA)
        // =====================================
        elseif (Auth::guard('pengguna')->check()) {
            $user = Auth::guard('pengguna')->user();

            if ($user->id_role == 2) {
                // Kecamatan: Menunggu = Proses | Selesai = Disetujui1
                $lap1 = DB::table('laporan_kader_pokja3')
                    ->leftJoin('users_mobile', 'laporan_kader_pokja3.id_user', '=', 'users_mobile.id')
                    ->where('users_mobile.id_subdistrict', $user->id_subdistrict)
                    ->where('users_mobile.id_role', 1)
                    ->whereIn('laporan_kader_pokja3.status', ['proses', 'Proses', 'PROSES'])
                    ->count();

                $lap2 = DB::table('laporan_kader_pokja3')
                    ->leftJoin('users_mobile', 'laporan_kader_pokja3.id_user', '=', 'users_mobile.id')
                    ->where('users_mobile.id_subdistrict', $user->id_subdistrict)
                    ->where('users_mobile.id_role', 1)
                    ->whereIn('laporan_kader_pokja3.status', ['Disetujui1', 'disetujui1', 'DISETUJUI1'])
                    ->count();
            }
        }

        return view('backend.acclaporanpokja3', compact('lap1', 'lap2', 'data'));
    }
}
