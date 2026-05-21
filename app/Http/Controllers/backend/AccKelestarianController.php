<?php

namespace App\Http\Controllers\backend;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class AccKelestarianController extends Controller
{
    public function index()
    {
        $kel1 = 0;
        $kel2 = 0;

        // 1. ADMIN WEB (KABUPATEN)
        if (Auth::guard('web')->check()) {

            // MENUNGGU ACC KABUPATEN
            $kel1 = DB::table('laporan_kelestarian_lingkungan_hidup')
                ->leftJoin('users_mobile', 'laporan_kelestarian_lingkungan_hidup.id_user', '=', 'users_mobile.id')

                ->where(function ($query) {

                    // dari desa yang sudah acc kecamatan
                    $query->where(function ($q) {
                        $q->where('users_mobile.id_role', 1)
                            ->whereIn(
                                'laporan_kelestarian_lingkungan_hidup.status',
                                ['Disetujui1', 'disetujui1', 'DISETUJUI1']
                            );
                    })

                        // dari mobile kecamatan
                        ->orWhere(function ($q) {
                            $q->where('users_mobile.id_role', 2)
                                ->whereIn(
                                    'laporan_kelestarian_lingkungan_hidup.status',
                                    ['Proses', 'proses', 'PROSES']
                                );
                        });
                })

                ->count();

            // SUDAH SELESAI ACC KABUPATEN
            $kel2 = DB::table('laporan_kelestarian_lingkungan_hidup')
                ->whereIn(
                    'status',
                    ['Disetujui2', 'disetujui2', 'DISETUJUI2']
                )
                ->count();
        }
        // 2. PENGGUNA MOBILE (KECAMATAN / DESA)
        elseif (Auth::guard('pengguna')->check()) {
            $user = Auth::guard('pengguna')->user();

            if ($user->id_role == 2) {
                // Kecamatan: Menunggu = Proses | Selesai = Disetujui1
                $kel1 = DB::table('laporan_kelestarian_lingkungan_hidup')
                    ->leftJoin('users_mobile', 'laporan_kelestarian_lingkungan_hidup.id_user', '=', 'users_mobile.id')
                    ->where('users_mobile.id_subdistrict', $user->id_subdistrict)
                    ->where('users_mobile.id_role', 1)
                    ->whereIn('laporan_kelestarian_lingkungan_hidup.status', ['proses', 'Proses', 'PROSES'])
                    ->count();

                $kel2 = DB::table('laporan_kelestarian_lingkungan_hidup')
                    ->leftJoin('users_mobile', 'laporan_kelestarian_lingkungan_hidup.id_user', '=', 'users_mobile.id')
                    ->where('users_mobile.id_subdistrict', $user->id_subdistrict)
                    ->where('users_mobile.id_role', 1)
                    ->whereIn('laporan_kelestarian_lingkungan_hidup.status', ['Disetujui1', 'disetujui1', 'DISETUJUI1'])
                    ->count();
            }
        }

        return view('backend.acckelestarian', compact('kel1', 'kel2'));
    }
}
