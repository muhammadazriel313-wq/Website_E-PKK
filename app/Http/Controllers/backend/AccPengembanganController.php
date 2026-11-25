<?php

namespace App\Http\Controllers\backend;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class AccPengembanganController extends Controller
{
    public function index()
    {
        $pen1 = 0;
        $pen2 = 0;

        // =========================
        // 1. WEB KABUPATEN
        // =========================
        if (Auth::guard('web')->check()) {

            // MENUNGGU ACC KABUPATEN
            $pen1 = DB::table('laporan_pengembangan_kehidupan')
                ->leftJoin('users_mobile', 'laporan_pengembangan_kehidupan.id_user', '=', 'users_mobile.id')

                ->where(function ($query) {

                    // dari desa yang sudah acc kecamatan
                    $query->where(function ($q) {
                        $q->where('users_mobile.id_role', 1)
                            ->whereIn(
                                'laporan_pengembangan_kehidupan.status',
                                ['Disetujui1', 'disetujui1', 'DISETUJUI1']
                            );
                    })

                    // dari mobile kecamatan
                    ->orWhere(function ($q) {
                        $q->where('users_mobile.id_role', 2)
                            ->whereIn(
                                'laporan_pengembangan_kehidupan.status',
                                ['Proses', 'proses', 'PROSES']
                            );
                    });
                })

                ->count();

            // SUDAH SELESAI ACC KABUPATEN
            $pen2 = DB::table('laporan_pengembangan_kehidupan')
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

            // ================= KECAMATAN =================
            if ($user->id_role == 2) {

                // MENUNGGU ACC KECAMATAN
                $pen1 = DB::table('laporan_pengembangan_kehidupan')
                    ->leftJoin('users_mobile', 'laporan_pengembangan_kehidupan.id_user', '=', 'users_mobile.id')
                    ->where('users_mobile.id_subdistrict', $user->id_subdistrict)
                    ->where('users_mobile.id_role', 1)
                    ->whereIn(
                        'laporan_pengembangan_kehidupan.status',
                        ['proses', 'Proses', 'PROSES', 'menunggu', 'Menunggu', 'MENUNGGU']
                    )
                    ->count();

                // SUDAH DISETUJUI KECAMATAN
                $pen2 = DB::table('laporan_pengembangan_kehidupan')
                    ->leftJoin('users_mobile', 'laporan_pengembangan_kehidupan.id_user', '=', 'users_mobile.id')
                    ->where('users_mobile.id_subdistrict', $user->id_subdistrict)
                    ->where('users_mobile.id_role', 1)
                    ->whereIn(
                        'laporan_pengembangan_kehidupan.status',
                        ['Disetujui1', 'disetujui1', 'DISETUJUI1']
                    )
                    ->count();
            }
        }

        return view('backend.accpengembangan', compact('pen1', 'pen2'));
    }
}