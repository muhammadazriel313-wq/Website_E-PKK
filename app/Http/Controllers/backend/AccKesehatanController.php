<?php

namespace App\Http\Controllers\backend;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class AccKesehatanController extends Controller
{
    public function index()
    {
        $kes1 = 0;
        $kes2 = 0;

        // =====================================
        // 1. WEB KABUPATEN (Admin)
        // =====================================
        if (Auth::guard('web')->check()) {

            // MENUNGGU ACC KABUPATEN
            $kes1 = DB::table('laporan_bidang_kesehatan')
                ->leftJoin('users_mobile', 'laporan_bidang_kesehatan.id_user', '=', 'users_mobile.id')

                ->where(function ($query) {

                    // dari desa yang sudah acc kecamatan
                    $query->where(function ($q) {
                        $q->where('users_mobile.id_role', 1)
                            ->whereIn(
                                'laporan_bidang_kesehatan.status',
                                ['Disetujui1', 'disetujui1', 'DISETUJUI1']
                            );
                    })

                        // dari mobile kecamatan
                        ->orWhere(function ($q) {
                            $q->where('users_mobile.id_role', 2)
                                ->whereIn(
                                    'laporan_bidang_kesehatan.status',
                                    ['Proses', 'proses', 'PROSES', 'Menunggu', 'menunggu', 'MENUNGGU']
                                );
                        });
                })

                ->count();

            // SUDAH SELESAI ACC KABUPATEN
            $kes2 = DB::table('laporan_bidang_kesehatan')
                ->whereIn(
                    'status',
                    ['Disetujui2', 'disetujui2', 'DISETUJUI2']
                )
                ->count();
        }
        // =====================================
        // 2. PENGGUNA MOBILE (Kecamatan / Desa)
        // =====================================
        elseif (Auth::guard('pengguna')->check()) {
            $user = Auth::guard('pengguna')->user();

            if ($user->id_role == 2) {
                // Kecamatan: Menunggu = Proses | Selesai = Disetujui1
                $kes1 = DB::table('laporan_bidang_kesehatan')
                    ->leftJoin('users_mobile', 'laporan_bidang_kesehatan.id_user', '=', 'users_mobile.id')
                    ->where('users_mobile.id_subdistrict', $user->id_subdistrict)
                    ->where('users_mobile.id_role', 1)
                    ->whereIn('laporan_bidang_kesehatan.status', ['proses', 'Proses', 'PROSES', 'menunggu', 'Menunggu', 'MENUNGGU'])
                    ->count();

                $kes2 = DB::table('laporan_bidang_kesehatan')
                    ->leftJoin('users_mobile', 'laporan_bidang_kesehatan.id_user', '=', 'users_mobile.id')
                    ->where('users_mobile.id_subdistrict', $user->id_subdistrict)
                    ->where('users_mobile.id_role', 1)
                    ->whereIn('laporan_bidang_kesehatan.status', ['Disetujui1', 'disetujui1', 'DISETUJUI1'])
                    ->count();
            }
        }

        return view('backend.acckesehatan', compact('kes1', 'kes2'));
    }
}
