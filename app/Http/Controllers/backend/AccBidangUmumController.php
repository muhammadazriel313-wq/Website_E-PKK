<?php

namespace App\Http\Controllers\backend;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class AccBidangUmumController extends Controller
{
    public function index()
    {
        $got1 = 0;
        $got2 = 0;

        // =====================================
        // 1. WEB KABUPATEN (ADMIN)
        // =====================================
        if (Auth::guard('web')->check()) {

            // MENUNGGU ACC KABUPATEN
            $got1 = DB::table('laporan_umum')
                ->leftJoin('users_mobile', 'laporan_umum.id_user', '=', 'users_mobile.id')

                ->where(function ($query) {

                    // dari desa yang sudah acc kecamatan
                    $query->where(function ($q) {
                        $q->where('users_mobile.id_role', 1)
                            ->whereIn(
                                'laporan_umum.status',
                                ['Disetujui1', 'disetujui1', 'DISETUJUI1']
                            );
                    })

                        // dari mobile kecamatan
                        ->orWhere(function ($q) {
                            $q->where('users_mobile.id_role', 2)
                                ->whereIn(
                                    'laporan_umum.status',
                                    ['Proses', 'proses', 'PROSES']
                                );
                        });
                })

                ->count();

            // SUDAH SELESAI ACC KABUPATEN
            $got2 = DB::table('laporan_umum')
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
                $got1 = DB::table('laporan_umum')
                    ->leftJoin('users_mobile', 'laporan_umum.id_user', '=', 'users_mobile.id')
                    ->where('users_mobile.id_subdistrict', $user->id_subdistrict)
                    ->where('users_mobile.id_role', 1)
                    ->whereIn('laporan_umum.status', ['proses', 'Proses', 'PROSES', 'menunggu', 'Menunggu', 'MENUNGGU'])
                    ->count();

                $got2 = DB::table('laporan_umum')
                    ->leftJoin('users_mobile', 'laporan_umum.id_user', '=', 'users_mobile.id')
                    ->where('users_mobile.id_subdistrict', $user->id_subdistrict)
                    ->where('users_mobile.id_role', 1)
                    ->whereIn('laporan_umum.status', ['Disetujui1', 'disetujui1', 'DISETUJUI1'])
                    ->count();
            }
        }

        return view('backend.accbidangumum', compact('got1', 'got2'));
    }
}
