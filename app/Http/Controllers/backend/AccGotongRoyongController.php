<?php

namespace App\Http\Controllers\backend;

use Illuminate\Http\Request;
use App\Models\Pengguna;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AccGotongRoyongController extends Controller
{
    public function index()
    {
        $got1 = 0;
        $got2 = 0;

        // =====================================
        // WEB KABUPATEN
        // =====================================
        if (Auth::guard('web')->check()) {

            // MENUNGGU ACC KABUPATEN
            $got1 = DB::table('laporan_gotong_royong')
                ->leftJoin('users_mobile', 'laporan_gotong_royong.id_user', '=', 'users_mobile.id')

                ->where(function ($query) {

                    // dari desa yang sudah acc kecamatan
                    $query->where(function ($q) {
                        $q->where('users_mobile.id_role', 1)
                            ->whereIn(
                                'laporan_gotong_royong.status',
                                ['Disetujui1', 'disetujui1', 'DISETUJUI1']
                            );
                    })

                        // dari mobile kecamatan
                        ->orWhere(function ($q) {
                            $q->where('users_mobile.id_role', 2)
                                ->whereIn(
                                    'laporan_gotong_royong.status',
                                    ['Proses', 'proses', 'PROSES', 'Menunggu', 'menunggu', 'MENUNGGU']
                                );
                        });
                })

                ->count();

            // SUDAH SELESAI ACC KABUPATEN
            $got2 = DB::table('laporan_gotong_royong')
                ->whereIn(
                    'status',
                    ['Disetujui2', 'disetujui2', 'DISETUJUI2']
                )
                ->count();
        }

        // =====================================
        // WEB KECAMATAN
        // =====================================
        elseif (Auth::guard('pengguna')->check()) {
            $user = Auth::guard('pengguna')->user();

            if ($user->id_role == 2) {
                // Kecamatan: Menunggu = Proses | Selesai = Disetujui1
                $got1 = DB::table('laporan_gotong_royong')
                    ->leftJoin('users_mobile', 'laporan_gotong_royong.id_user', '=', 'users_mobile.id')
                    ->where('users_mobile.id_subdistrict', $user->id_subdistrict)
                    ->where('users_mobile.id_role', 1)
                    ->whereIn('laporan_gotong_royong.status', ['proses', 'Proses', 'PROSES', 'menunggu', 'Menunggu', 'MENUNGGU'])
                    ->count();

                $got2 = DB::table('laporan_gotong_royong')
                    ->leftJoin('users_mobile', 'laporan_gotong_royong.id_user', '=', 'users_mobile.id')
                    ->where('users_mobile.id_subdistrict', $user->id_subdistrict)
                    ->where('users_mobile.id_role', 1)
                    ->whereIn('laporan_gotong_royong.status', ['Disetujui1', 'disetujui1', 'DISETUJUI1'])
                    ->count();
            }
        }

        return view(
            'backend.accgotongroyong',
            compact('got1', 'got2')
        );
    }
}