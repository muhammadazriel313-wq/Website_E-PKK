<?php

namespace App\Http\Controllers\backend;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class AccSandangController extends Controller
{
    public function index()
    {
        $sand1 = 0;
        $sand2 = 0;

        // =====================================
        // 1. WEB KABUPATEN (ADMIN)
        // =====================================
        if (Auth::guard('web')->check()) {

            // MENUNGGU ACC KABUPATEN
            $sand1 = DB::table('laporan_sandang')
                ->leftJoin('users_mobile', 'laporan_sandang.id_user', '=', 'users_mobile.id')

                ->where(function ($query) {

                    // dari desa yang sudah acc kecamatan
                    $query->where(function ($q) {
                        $q->where('users_mobile.id_role', 1)
                            ->whereIn(
                                'laporan_sandang.status',
                                ['Disetujui1', 'disetujui1', 'DISETUJUI1']
                            );
                    })

                        // dari mobile kecamatan
                        ->orWhere(function ($q) {
                            $q->where('users_mobile.id_role', 2)
                                ->whereIn(
                                    'laporan_sandang.status',
                                    ['Proses', 'proses', 'PROSES']
                                );
                        });
                })

                ->count();

            // SUDAH SELESAI ACC KABUPATEN
            $sand2 = DB::table('laporan_sandang')
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
                $sand1 = DB::table('laporan_sandang')
                    ->leftJoin('users_mobile', 'laporan_sandang.id_user', '=', 'users_mobile.id')
                    ->where('users_mobile.id_subdistrict', $user->id_subdistrict)
                    ->where('users_mobile.id_role', 1)
                    ->whereIn('laporan_sandang.status', ['proses', 'Proses', 'PROSES'])
                    ->count();

                $sand2 = DB::table('laporan_sandang')
                    ->leftJoin('users_mobile', 'laporan_sandang.id_user', '=', 'users_mobile.id')
                    ->where('users_mobile.id_subdistrict', $user->id_subdistrict)
                    ->where('users_mobile.id_role', 1)
                    ->whereIn('laporan_sandang.status', ['Disetujui1', 'disetujui1', 'DISETUJUI1'])
                    ->count();
            }
        }

        return view('backend.accsandang', compact('sand1', 'sand2'));
    }
}