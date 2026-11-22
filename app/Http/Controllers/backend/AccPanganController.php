<?php

namespace App\Http\Controllers\backend;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class AccPanganController extends Controller
{
    public function index()
    {
        $pang1 = 0;
        $pang2 = 0;
        $data = collect();

        // =========================
        // 1. WEB KABUPATEN (ADMIN)
        // =========================
        if (Auth::guard('web')->check()) {

            // MENUNGGU ACC KABUPATEN
            $pang1 = DB::table('laporan_pangan')
                ->leftJoin(
                    'users_mobile',
                    'laporan_pangan.id_user',
                    '=',
                    'users_mobile.id'
                )

                ->where(function ($query) {

                    // dari desa yang sudah acc kecamatan
                    $query->where(function ($q) {
                        $q->where('users_mobile.id_role', 1)
                            ->whereIn(
                                'laporan_pangan.status',
                                ['Disetujui1', 'disetujui1', 'DISETUJUI1']
                            );
                    })

                    // dari mobile kecamatan
                    ->orWhere(function ($q) {
                        $q->where('users_mobile.id_role', 2)
                            ->whereIn(
                                'laporan_pangan.status',
                                ['Proses', 'proses', 'PROSES']
                            );
                    });
                })

                ->count();

            // SUDAH SELESAI ACC KABUPATEN
            $pang2 = DB::table('laporan_pangan')
                ->whereIn(
                    'status',
                    ['Disetujui2', 'disetujui2', 'DISETUJUI2']
                )
                ->count();
        }

        // =========================
        // 2. WEB KECAMATAN / DESA
        // =========================
        elseif (Auth::guard('pengguna')->check()) {

            $user = Auth::guard('pengguna')->user();

            if ($user->id_role == 2) {

                // MENUNGGU ACC KECAMATAN
                $pang1 = DB::table('laporan_pangan')
                    ->leftJoin(
                        'users_mobile',
                        'laporan_pangan.id_user',
                        '=',
                        'users_mobile.id'
                    )
                    ->where(
                        'users_mobile.id_subdistrict',
                        $user->id_subdistrict
                    )
                    ->where('users_mobile.id_role', 1)
                    ->whereIn(
                        'laporan_pangan.status',
                        ['Proses', 'proses', 'PROSES']
                    )
                    ->count();

                // SUDAH ACC KECAMATAN
                $pang2 = DB::table('laporan_pangan')
                    ->leftJoin(
                        'users_mobile',
                        'laporan_pangan.id_user',
                        '=',
                        'users_mobile.id'
                    )
                    ->where(
                        'users_mobile.id_subdistrict',
                        $user->id_subdistrict
                    )
                    ->where('users_mobile.id_role', 1)
                    ->whereIn(
                        'laporan_pangan.status',
                        ['Disetujui1', 'disetujui1', 'DISETUJUI1']
                    )
                    ->count();
            }
        }

        return view(
            'backend.accpangan',
            compact('pang1', 'pang2', 'data')
        );
    }
}