<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class UnggulanController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | DASHBOARD UNGGULAN
    |--------------------------------------------------------------------------
    */

    public function index()
    {
        /*
        |--------------------------------------------------------------------------
        | WEB KECAMATAN
        |--------------------------------------------------------------------------
        | HANYA MENAMPILKAN:
        | - DATA DESA (id_role = 1)
        | - STATUS PROSES & DISETUJUI1
        |--------------------------------------------------------------------------
        */

        $statusKec = [
            'Proses',
            'proses',
            'PROSES',
            'Menunggu',
            'menunggu',
            'MENUNGGU',
            'Disetujui1',
            'disetujui1',
            'DISETUJUI1'
        ];

        $bulanan = DB::table('rekap_desa_bulanan')
            ->leftJoin(
                'users_mobile',
                'rekap_desa_bulanan.id_user',
                '=',
                'users_mobile.id'
            )
            ->where('rekap_desa_bulanan.kategori', 'Unggulan')
            ->where('users_mobile.id_role', 1)
            ->whereIn('rekap_desa_bulanan.status', $statusKec)
            ->count();

        $tahunan = DB::table('rekap_desa_tahunan')
            ->leftJoin(
                'users_mobile',
                'rekap_desa_tahunan.id_user',
                '=',
                'users_mobile.id'
            )
            ->where('rekap_desa_tahunan.kategori', 'Unggulan')
            ->where('users_mobile.id_role', 1)
            ->whereIn('rekap_desa_tahunan.status', $statusKec)
            ->count();

        $posyandu = DB::table('posyandu')
            ->leftJoin(
                'users_mobile',
                'posyandu.id_user',
                '=',
                'users_mobile.id'
            )
            ->where('posyandu.kategori', 'Unggulan')
            ->where('users_mobile.id_role', 1)
            ->whereIn('posyandu.status', $statusKec)
            ->count();

        $kegiatan = DB::table('kegiatan_pokja4')
            ->leftJoin(
                'users_mobile',
                'kegiatan_pokja4.id_user',
                '=',
                'users_mobile.id'
            )
            ->where('kegiatan_pokja4.kategori', 'Unggulan')
            ->where('users_mobile.id_role', 1)
            ->whereIn('kegiatan_pokja4.status', $statusKec)
            ->count();

        return view(
            'backend.unggulan',
            compact(
                'bulanan',
                'tahunan',
                'posyandu',
                'kegiatan'
            )
        );
    }

    /*
    |--------------------------------------------------------------------------
    | DASHBOARD UNGGULAN KABUPATEN
    |--------------------------------------------------------------------------
    */

    public function kabupaten()
    {
        $bulanan = DB::table('rekap_desa_bulanan')
            ->leftJoin(
                'users_mobile',
                'rekap_desa_bulanan.id_user',
                '=',
                'users_mobile.id'
            )

            ->where('rekap_desa_bulanan.kategori', 'Unggulan')

            ->where(function ($query) {

                // DATA DESA
                $query->where(function ($q) {

                    $q->where('users_mobile.id_role', 1)

                        ->whereIn(
                            'rekap_desa_bulanan.status',
                            [
                                'Disetujui1',
                                'disetujui1',
                                'DISETUJUI1',

                                'Disetujui2',
                                'disetujui2',
                                'DISETUJUI2'
                            ]
                        );
                })

                    // DATA MOBILE KECAMATAN
                    ->orWhere(function ($q) {

                        $q->where('users_mobile.id_role', 2)

                            ->whereIn(
                                'rekap_desa_bulanan.status',
                                [
                                    'Proses',
                                    'proses',
                                    'PROSES',

                                    'Menunggu',
                                    'menunggu',
                                    'MENUNGGU',

                                    'Disetujui2',
                                    'disetujui2',
                                    'DISETUJUI2'
                                ]
                            );
                    });
            })

            ->count();

        $tahunan = DB::table('rekap_desa_tahunan')

            ->leftJoin(
                'users_mobile',
                'rekap_desa_tahunan.id_user',
                '=',
                'users_mobile.id'
            )

            ->where('rekap_desa_tahunan.kategori', 'Unggulan')

            ->where(function ($query) {

                // DATA DESA
                $query->where(function ($q) {

                    $q->where('users_mobile.id_role', 1)

                        ->whereIn(
                            'rekap_desa_tahunan.status',
                            [
                                'Disetujui1',
                                'disetujui1',
                                'DISETUJUI1',

                                'Disetujui2',
                                'disetujui2',
                                'DISETUJUI2'
                            ]
                        );
                })

                    // DATA MOBILE KECAMATAN
                    ->orWhere(function ($q) {

                        $q->where('users_mobile.id_role', 2)

                            ->whereIn(
                                'rekap_desa_tahunan.status',
                                [
                                    'Proses',
                                    'proses',
                                    'PROSES',

                                    'Menunggu',
                                    'menunggu',
                                    'MENUNGGU',

                                    'Disetujui2',
                                    'disetujui2',
                                    'DISETUJUI2'
                                ]
                            );
                    });
            })

            ->count();

        $posyandu = DB::table('posyandu')

            ->leftJoin(
                'users_mobile',
                'posyandu.id_user',
                '=',
                'users_mobile.id'
            )

            ->where('posyandu.kategori', 'Unggulan')

            ->where(function ($query) {

                // DATA DESA
                $query->where(function ($q) {

                    $q->where('users_mobile.id_role', 1)

                        ->whereIn(
                            'posyandu.status',
                            [
                                'Disetujui1',
                                'disetujui1',
                                'DISETUJUI1',

                                'Disetujui2',
                                'disetujui2',
                                'DISETUJUI2'
                            ]
                        );
                })

                    // DATA MOBILE KECAMATAN
                    ->orWhere(function ($q) {

                        $q->where('users_mobile.id_role', 2)

                            ->whereIn(
                                'posyandu.status',
                                [
                                    'Proses',
                                    'proses',
                                    'PROSES',

                                    'Menunggu',
                                    'menunggu',
                                    'MENUNGGU',

                                    'Disetujui2',
                                    'disetujui2',
                                    'DISETUJUI2'
                                ]
                            );
                    });
            })

            ->count();

        $kegiatan = DB::table('kegiatan_pokja4')

            ->leftJoin(
                'users_mobile',
                'kegiatan_pokja4.id_user',
                '=',
                'users_mobile.id'
            )

            ->where('kegiatan_pokja4.kategori', 'Unggulan')

            ->where(function ($query) {

                // DATA DESA
                $query->where(function ($q) {

                    $q->where('users_mobile.id_role', 1)

                        ->whereIn(
                            'kegiatan_pokja4.status',
                            [
                                'Disetujui1',
                                'disetujui1',
                                'DISETUJUI1',

                                'Disetujui2',
                                'disetujui2',
                                'DISETUJUI2'
                            ]
                        );
                })

                    // DATA MOBILE KECAMATAN
                    ->orWhere(function ($q) {

                        $q->where('users_mobile.id_role', 2)

                            ->whereIn(
                                'kegiatan_pokja4.status',
                                [
                                    'Proses',
                                    'proses',
                                    'PROSES',

                                    'Menunggu',
                                    'menunggu',
                                    'MENUNGGU',

                                    'Disetujui2',
                                    'disetujui2',
                                    'DISETUJUI2'
                                ]
                            );
                    });
            })

            ->count();

        return view(
            'backend.unggulan',
            compact(
                'bulanan',
                'tahunan',
                'posyandu',
                'kegiatan'
            )
        );
    }

    /*
    |--------------------------------------------------------------------------
    | UNGGULAN BULANAN
    |--------------------------------------------------------------------------
    */

    public function bulanan()
    {
        if (Auth::guard('web')->check()) {

            // WEB KABUPATEN
            $data = DB::table('rekap_desa_bulanan')

                ->leftJoin(
                    'users_mobile',
                    'rekap_desa_bulanan.id_user',
                    '=',
                    'users_mobile.id'
                )

                ->leftJoin(
                    'subdistrict',
                    'users_mobile.id_subdistrict',
                    '=',
                    'subdistrict.id'
                )

                ->leftJoin(
                    'village',
                    'users_mobile.id_village',
                    '=',
                    'village.id'
                )

                ->select(
                    'rekap_desa_bulanan.*',
                    'subdistrict.name as nama_kecamatan',
                    'village.name as nama_desa'
                )

                ->where('rekap_desa_bulanan.kategori', 'Unggulan')

                ->where(function ($query) {

                    // DATA DESA
                    $query->where(function ($q) {

                        $q->where('users_mobile.id_role', 1)

                            ->whereIn(
                                'rekap_desa_bulanan.status',
                                [
                                    'Disetujui1',
                                    'disetujui1',
                                    'DISETUJUI1',

                                    'Disetujui2',
                                    'disetujui2',
                                    'DISETUJUI2'
                                ]
                            );
                    })

                        // DATA MOBILE KECAMATAN
                        ->orWhere(function ($q) {

                            $q->where('users_mobile.id_role', 2)

                                ->whereIn(
                                    'rekap_desa_bulanan.status',
                                    [
                                        'Proses',
                                        'proses',
                                        'PROSES',

                                        'Menunggu',
                                        'menunggu',
                                        'MENUNGGU',

                                        'Disetujui2',
                                        'disetujui2',
                                        'DISETUJUI2'
                                    ]
                                );
                        });
                })

                ->get();
        } else {

            // WEB KECAMATAN
            $data = DB::table('rekap_desa_bulanan')

                ->leftJoin(
                    'users_mobile',
                    'rekap_desa_bulanan.id_user',
                    '=',
                    'users_mobile.id'
                )

                ->leftJoin(
                    'subdistrict',
                    'users_mobile.id_subdistrict',
                    '=',
                    'subdistrict.id'
                )

                ->leftJoin(
                    'village',
                    'users_mobile.id_village',
                    '=',
                    'village.id'
                )

                ->select(
                    'rekap_desa_bulanan.*',
                    'subdistrict.name as nama_kecamatan',
                    'village.name as nama_desa'
                )

                ->where('rekap_desa_bulanan.kategori', 'Unggulan')

                // HANYA DESA
                ->where('users_mobile.id_role', 1)

                ->whereIn(
                    'rekap_desa_bulanan.status',
                    [
                        'Proses',
                        'proses',
                        'PROSES',

                        'Menunggu',
                        'menunggu',
                        'MENUNGGU',

                        'Disetujui1',
                        'disetujui1',
                        'DISETUJUI1'
                    ]
                )

                ->get();
        }

        return view(
            'backend.unggulan_bulanan',
            compact('data')
        );
    }
}