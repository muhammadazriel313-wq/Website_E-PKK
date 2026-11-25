<?php

namespace App\Http\Controllers\backend;

use Illuminate\Http\Request;
use App\Models\Penghayatan;
use App\Models\Pengguna;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class AccPenghayatanController extends Controller
{
    public function index()
    {
        $peng1 = 0;
        $peng2 = 0;

        // =========================
        // WEB KABUPATEN
        // =========================
        // 1. CEK KABUPATEN DULU
        if (Auth::guard('web')->check()) {

            // MENUNGGU ACC KABUPATEN
            $peng1 = DB::table('laporan_penghayatan_n_pengamalan')
                ->leftJoin('users_mobile', 'laporan_penghayatan_n_pengamalan.id_user', '=', 'users_mobile.id')

                ->where(function ($query) {

                    // dari desa yang sudah acc kecamatan
                    $query->where(function ($q) {
                        $q->where('users_mobile.id_role', 1)
                            ->whereIn(
                                'laporan_penghayatan_n_pengamalan.status',
                                ['Disetujui1', 'disetujui1', 'DISETUJUI1']
                            );
                    })

                        // dari mobile kecamatan
                        ->orWhere(function ($q) {
                            $q->where('users_mobile.id_role', 2)
                                ->whereIn(
                                    'laporan_penghayatan_n_pengamalan.status',
                                    ['Proses', 'proses', 'PROSES']
                                );
                        });
                })

                ->count();

            // SUDAH SELESAI ACC KABUPATEN
            $peng2 = DB::table('laporan_penghayatan_n_pengamalan')
                ->whereIn(
                    'status',
                    ['Disetujui2', 'disetujui2', 'DISETUJUI2']
                )
                ->count();
        }

        // =========================
        // WEB KECAMATAN
        // =========================
        elseif (Auth::guard('pengguna')->check()) {
            $user = Auth::guard('pengguna')->user();

            if ($user->id_role == 2) {
                // Kecamatan: Menunggu = Proses | Selesai = Disetujui1
                $peng1 = DB::table('laporan_penghayatan_n_pengamalan')
                    ->leftJoin('users_mobile', 'laporan_penghayatan_n_pengamalan.id_user', '=', 'users_mobile.id')
                    ->where('users_mobile.id_subdistrict', $user->id_subdistrict)
                    ->where('users_mobile.id_role', 1)
                    ->whereIn('laporan_penghayatan_n_pengamalan.status', ['proses', 'Proses', 'PROSES', 'menunggu', 'Menunggu', 'MENUNGGU'])
                    ->count();

                $peng2 = DB::table('laporan_penghayatan_n_pengamalan')
                    ->leftJoin('users_mobile', 'laporan_penghayatan_n_pengamalan.id_user', '=', 'users_mobile.id')
                    ->where('users_mobile.id_subdistrict', $user->id_subdistrict)
                    ->where('users_mobile.id_role', 1)
                    ->whereIn('laporan_penghayatan_n_pengamalan.status', ['Disetujui1', 'disetujui1', 'DISETUJUI1'])
                    ->count();
            }
        }

        return view(
            'backend.accpenghayatan',
            compact('peng1', 'peng2')
        );
    }
}
