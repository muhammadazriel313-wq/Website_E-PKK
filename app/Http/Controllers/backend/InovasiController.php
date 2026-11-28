<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class InovasiController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | WEB KECAMATAN
    |--------------------------------------------------------------------------
    */

    public function index()
    {
        $statusKecamatan = [

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

        /*
        |--------------------------------------------------------------------------
        | AMBIL ID SUBDISTRICT
        |--------------------------------------------------------------------------
        */

        $idSubdistrict = null;

        if (Auth::guard('pengguna')->check()) {

            $user = Auth::guard('pengguna')->user();

            $idSubdistrict = $user->id_subdistrict;
        }

        /*
        |--------------------------------------------------------------------------
        | PRIORITAS
        |--------------------------------------------------------------------------
        */

        $prioritasBulanan = DB::table('rekap_desa_bulanan')

            ->leftJoin(
                'users_mobile',
                'rekap_desa_bulanan.id_user',
                '=',
                'users_mobile.id'
            )

            ->where('rekap_desa_bulanan.kategori', 'prioritas')

            ->where('users_mobile.id_role', 1)

            ->when($idSubdistrict, function ($query) use ($idSubdistrict) {

                $query->where(
                    'users_mobile.id_subdistrict',
                    $idSubdistrict
                );
            })

            ->whereIn(
                'rekap_desa_bulanan.status',
                $statusKecamatan
            )

            ->count();

        $prioritasTahunan = DB::table('rekap_desa_tahunan')

            ->leftJoin(
                'users_mobile',
                'rekap_desa_tahunan.id_user',
                '=',
                'users_mobile.id'
            )

            ->where('rekap_desa_tahunan.kategori', 'prioritas')

            ->where('users_mobile.id_role', 1)

            ->when($idSubdistrict, function ($query) use ($idSubdistrict) {

                $query->where(
                    'users_mobile.id_subdistrict',
                    $idSubdistrict
                );
            })

            ->whereIn(
                'rekap_desa_tahunan.status',
                $statusKecamatan
            )

            ->count();

        $prioritasPosyandu = DB::table('posyandu')

            ->leftJoin(
                'users_mobile',
                'posyandu.id_user',
                '=',
                'users_mobile.id'
            )

            ->where('posyandu.kategori', 'prioritas')

            ->where('users_mobile.id_role', 1)

            ->when($idSubdistrict, function ($query) use ($idSubdistrict) {

                $query->where(
                    'users_mobile.id_subdistrict',
                    $idSubdistrict
                );
            })

            ->whereIn(
                'posyandu.status',
                $statusKecamatan
            )

            ->count();

        $prioritasKegiatan = DB::table('kegiatan_pokja4')

            ->leftJoin(
                'users_mobile',
                'kegiatan_pokja4.id_user',
                '=',
                'users_mobile.id'
            )

            ->where('kegiatan_pokja4.kategori', 'prioritas')

            ->where('users_mobile.id_role', 1)

            ->when($idSubdistrict, function ($query) use ($idSubdistrict) {

                $query->where(
                    'users_mobile.id_subdistrict',
                    $idSubdistrict
                );
            })

            ->whereIn(
                'kegiatan_pokja4.status',
                $statusKecamatan
            )

            ->count();

        $prioritas =
            $prioritasBulanan +
            $prioritasTahunan +
            $prioritasPosyandu +
            $prioritasKegiatan;

        /*
        |--------------------------------------------------------------------------
        | UNGGULAN
        |--------------------------------------------------------------------------
        */

        $unggulanBulanan = DB::table('rekap_desa_bulanan')

            ->leftJoin(
                'users_mobile',
                'rekap_desa_bulanan.id_user',
                '=',
                'users_mobile.id'
            )

            ->where('rekap_desa_bulanan.kategori', 'unggulan')

            ->where('users_mobile.id_role', 1)

            ->when($idSubdistrict, function ($query) use ($idSubdistrict) {

                $query->where(
                    'users_mobile.id_subdistrict',
                    $idSubdistrict
                );
            })

            ->whereIn(
                'rekap_desa_bulanan.status',
                $statusKecamatan
            )

            ->count();

        $unggulanTahunan = DB::table('rekap_desa_tahunan')

            ->leftJoin(
                'users_mobile',
                'rekap_desa_tahunan.id_user',
                '=',
                'users_mobile.id'
            )

            ->where('rekap_desa_tahunan.kategori', 'unggulan')

            ->where('users_mobile.id_role', 1)

            ->when($idSubdistrict, function ($query) use ($idSubdistrict) {

                $query->where(
                    'users_mobile.id_subdistrict',
                    $idSubdistrict
                );
            })

            ->whereIn(
                'rekap_desa_tahunan.status',
                $statusKecamatan
            )

            ->count();

        $unggulanPosyandu = DB::table('posyandu')

            ->leftJoin(
                'users_mobile',
                'posyandu.id_user',
                '=',
                'users_mobile.id'
            )

            ->where('posyandu.kategori', 'unggulan')

            ->where('users_mobile.id_role', 1)

            ->when($idSubdistrict, function ($query) use ($idSubdistrict) {

                $query->where(
                    'users_mobile.id_subdistrict',
                    $idSubdistrict
                );
            })

            ->whereIn(
                'posyandu.status',
                $statusKecamatan
            )

            ->count();

        $unggulanKegiatan = DB::table('kegiatan_pokja4')

            ->leftJoin(
                'users_mobile',
                'kegiatan_pokja4.id_user',
                '=',
                'users_mobile.id'
            )

            ->where('kegiatan_pokja4.kategori', 'unggulan')

            ->where('users_mobile.id_role', 1)

            ->when($idSubdistrict, function ($query) use ($idSubdistrict) {

                $query->where(
                    'users_mobile.id_subdistrict',
                    $idSubdistrict
                );
            })

            ->whereIn(
                'kegiatan_pokja4.status',
                $statusKecamatan
            )

            ->count();

        $unggulan =
            $unggulanBulanan +
            $unggulanTahunan +
            $unggulanPosyandu +
            $unggulanKegiatan;

        return view(
            'backend.inovasi',
            compact(
                'prioritas',
                'unggulan'
            )
        );
    }

    /*
    |--------------------------------------------------------------------------
    | WEB KABUPATEN
    |--------------------------------------------------------------------------
    */

    public function kabupaten()
    {
        /*
    |--------------------------------------------------------------------------
    | PRIORITAS
    |--------------------------------------------------------------------------
    */

        $prioritasBulanan = DB::table('rekap_desa_bulanan')

            ->leftJoin(
                'users_mobile',
                'rekap_desa_bulanan.id_user',
                '=',
                'users_mobile.id'
            )

            ->where('rekap_desa_bulanan.kategori', 'prioritas')

            ->where(function ($query) {

                // ROLE 1 = DESA
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

                    // ROLE 2 = KECAMATAN
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

        $prioritasTahunan = DB::table('rekap_desa_tahunan')

            ->leftJoin(
                'users_mobile',
                'rekap_desa_tahunan.id_user',
                '=',
                'users_mobile.id'
            )

            ->where('rekap_desa_tahunan.kategori', 'prioritas')

            ->where(function ($query) {

                // ROLE 1 = DESA
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

                    // ROLE 2 = KECAMATAN
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

        $prioritasPosyandu = DB::table('posyandu')

            ->leftJoin(
                'users_mobile',
                'posyandu.id_user',
                '=',
                'users_mobile.id'
            )

            ->where('posyandu.kategori', 'prioritas')

            ->where(function ($query) {

                // ROLE 1 = DESA
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

                    // ROLE 2 = KECAMATAN
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

        $prioritasKegiatan = DB::table('kegiatan_pokja4')

            ->leftJoin(
                'users_mobile',
                'kegiatan_pokja4.id_user',
                '=',
                'users_mobile.id'
            )

            ->where('kegiatan_pokja4.kategori', 'prioritas')

            ->where(function ($query) {

                // ROLE 1 = DESA
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

                    // ROLE 2 = KECAMATAN
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

        $prioritas =
            $prioritasBulanan +
            $prioritasTahunan +
            $prioritasPosyandu +
            $prioritasKegiatan;

        /*
    |--------------------------------------------------------------------------
    | UNGGULAN
    |--------------------------------------------------------------------------
    */

        $unggulanBulanan = DB::table('rekap_desa_bulanan')

            ->leftJoin(
                'users_mobile',
                'rekap_desa_bulanan.id_user',
                '=',
                'users_mobile.id'
            )

            ->where('rekap_desa_bulanan.kategori', 'unggulan')

            ->where(function ($query) {

                // ROLE 1 = DESA
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

                    // ROLE 2 = KECAMATAN
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

        $unggulanTahunan = DB::table('rekap_desa_tahunan')

            ->leftJoin(
                'users_mobile',
                'rekap_desa_tahunan.id_user',
                '=',
                'users_mobile.id'
            )

            ->where('rekap_desa_tahunan.kategori', 'unggulan')

            ->where(function ($query) {

                // ROLE 1 = DESA
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

                    // ROLE 2 = KECAMATAN
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

        $unggulanPosyandu = DB::table('posyandu')

            ->leftJoin(
                'users_mobile',
                'posyandu.id_user',
                '=',
                'users_mobile.id'
            )

            ->where('posyandu.kategori', 'unggulan')

            ->where(function ($query) {

                // ROLE 1 = DESA
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

                    // ROLE 2 = KECAMATAN
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

        $unggulanKegiatan = DB::table('kegiatan_pokja4')

            ->leftJoin(
                'users_mobile',
                'kegiatan_pokja4.id_user',
                '=',
                'users_mobile.id'
            )

            ->where('kegiatan_pokja4.kategori', 'unggulan')

            ->where(function ($query) {

                // ROLE 1 = DESA
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

                    // ROLE 2 = KECAMATAN
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

        $unggulan =
            $unggulanBulanan +
            $unggulanTahunan +
            $unggulanPosyandu +
            $unggulanKegiatan;

        return view(
            'backend.inovasi',
            compact(
                'prioritas',
                'unggulan'
            )
        );
    }
}
