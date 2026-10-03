<?php

namespace App\Http\Controllers\backend;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class Pokja4Controller extends Controller
{
    public function index()
    {
        $modelPertama = 0;
        $modelKedua = 0;
        $modelKetiga = 0;
        $modelKeempat = 0;
        $modelKelima = 0;
        $modelKeenam = 0;
        $modelKetujuh = 0;
        $modelKedelapan = 0;

        $data = collect();

        /*
        |--------------------------------------------------------------------------
        | STATUS
        |--------------------------------------------------------------------------
        */

        $statusKecamatan = [
            'Proses',
            'proses',
            'PROSES',
            'Disetujui1',
            'disetujui1',
            'DISETUJUI1'
        ];

        $statusDesaKabupaten = [
            'Disetujui1',
            'disetujui1',
            'DISETUJUI1',
            'Disetujui2',
            'disetujui2',
            'DISETUJUI2'
        ];

        $statusKecamatanKabupaten = [
            'Proses',
            'proses',
            'PROSES',
            'Disetujui2',
            'disetujui2',
            'DISETUJUI2'
        ];

        /*
        |--------------------------------------------------------------------------
        | WEB KABUPATEN
        |--------------------------------------------------------------------------
        */

        if (Auth::guard('web')->check()) {

            $modelPertama = DB::table('laporan_bidang_kesehatan')
                ->leftJoin('users_mobile', 'laporan_bidang_kesehatan.id_user', '=', 'users_mobile.id')
                ->where(function ($query) use ($statusDesaKabupaten, $statusKecamatanKabupaten) {
                    $query->where(function ($q) use ($statusDesaKabupaten) {
                        $q->where('users_mobile.id_role', 1)->whereIn('laporan_bidang_kesehatan.status', $statusDesaKabupaten);
                    })
                        ->orWhere(function ($q) use ($statusKecamatanKabupaten) {
                            $q->where('users_mobile.id_role', 2)->whereIn('laporan_bidang_kesehatan.status', $statusKecamatanKabupaten);
                        });
                })->count();

            $modelKedua = DB::table('laporan_kelestarian_lingkungan_hidup')
                ->leftJoin('users_mobile', 'laporan_kelestarian_lingkungan_hidup.id_user', '=', 'users_mobile.id')
                ->where(function ($query) use ($statusDesaKabupaten, $statusKecamatanKabupaten) {
                    $query->where(function ($q) use ($statusDesaKabupaten) {
                        $q->where('users_mobile.id_role', 1)->whereIn('laporan_kelestarian_lingkungan_hidup.status', $statusDesaKabupaten);
                    })
                        ->orWhere(function ($q) use ($statusKecamatanKabupaten) {
                            $q->where('users_mobile.id_role', 2)->whereIn('laporan_kelestarian_lingkungan_hidup.status', $statusKecamatanKabupaten);
                        });
                })->count();

            $modelKetiga = DB::table('laporan_perencanaan_sehat')
                ->leftJoin('users_mobile', 'laporan_perencanaan_sehat.id_user', '=', 'users_mobile.id')
                ->where(function ($query) use ($statusDesaKabupaten, $statusKecamatanKabupaten) {
                    $query->where(function ($q) use ($statusDesaKabupaten) {
                        $q->where('users_mobile.id_role', 1)->whereIn('laporan_perencanaan_sehat.status', $statusDesaKabupaten);
                    })
                        ->orWhere(function ($q) use ($statusKecamatanKabupaten) {
                            $q->where('users_mobile.id_role', 2)->whereIn('laporan_perencanaan_sehat.status', $statusKecamatanKabupaten);
                        });
                })->count();

            $modelKeempat = DB::table('laporan_kader_pokja4')
                ->leftJoin('users_mobile', 'laporan_kader_pokja4.id_user', '=', 'users_mobile.id')
                ->where(function ($query) use ($statusDesaKabupaten, $statusKecamatanKabupaten) {
                    $query->where(function ($q) use ($statusDesaKabupaten) {
                        $q->where('users_mobile.id_role', 1)->whereIn('laporan_kader_pokja4.status', $statusDesaKabupaten);
                    })
                        ->orWhere(function ($q) use ($statusKecamatanKabupaten) {
                            $q->where('users_mobile.id_role', 2)->whereIn('laporan_kader_pokja4.status', $statusKecamatanKabupaten);
                        });
                })->count();

            $modelKelima = DB::table('rekap_desa_bulanan')
                ->leftJoin('users_mobile', 'rekap_desa_bulanan.id_user', '=', 'users_mobile.id')
                ->where(function ($query) {
                    $query->where('rekap_desa_bulanan.kategori', 'unggulan')->orWhere('rekap_desa_bulanan.kategori', 'prioritas');
                })
                ->where(function ($query) use ($statusDesaKabupaten, $statusKecamatanKabupaten) {
                    $query->where(function ($q) use ($statusDesaKabupaten) {
                        $q->where('users_mobile.id_role', 1)->whereIn('rekap_desa_bulanan.status', $statusDesaKabupaten);
                    })
                        ->orWhere(function ($q) use ($statusKecamatanKabupaten) {
                            $q->where('users_mobile.id_role', 2)->whereIn('rekap_desa_bulanan.status', $statusKecamatanKabupaten);
                        });
                })->count();

            $modelKeenam = DB::table('rekap_desa_tahunan')
                ->leftJoin('users_mobile', 'rekap_desa_tahunan.id_user', '=', 'users_mobile.id')
                ->where(function ($query) {
                    $query->where('rekap_desa_tahunan.kategori', 'unggulan')->orWhere('rekap_desa_tahunan.kategori', 'prioritas');
                })
                ->where(function ($query) use ($statusDesaKabupaten, $statusKecamatanKabupaten) {
                    $query->where(function ($q) use ($statusDesaKabupaten) {
                        $q->where('users_mobile.id_role', 1)->whereIn('rekap_desa_tahunan.status', $statusDesaKabupaten);
                    })
                        ->orWhere(function ($q) use ($statusKecamatanKabupaten) {
                            $q->where('users_mobile.id_role', 2)->whereIn('rekap_desa_tahunan.status', $statusKecamatanKabupaten);
                        });
                })->count();

            $modelKetujuh = DB::table('posyandu')
                ->leftJoin('users_mobile', 'posyandu.id_user', '=', 'users_mobile.id')
                ->where(function ($query) {
                    $query->where('posyandu.kategori', 'unggulan')->orWhere('posyandu.kategori', 'prioritas');
                })
                ->where(function ($query) use ($statusDesaKabupaten, $statusKecamatanKabupaten) {
                    $query->where(function ($q) use ($statusDesaKabupaten) {
                        $q->where('users_mobile.id_role', 1)->whereIn('posyandu.status', $statusDesaKabupaten);
                    })
                        ->orWhere(function ($q) use ($statusKecamatanKabupaten) {
                            $q->where('users_mobile.id_role', 2)->whereIn('posyandu.status', $statusKecamatanKabupaten);
                        });
                })->count();

            $modelKedelapan = DB::table('kegiatan_pokja4')
                ->leftJoin('users_mobile', 'kegiatan_pokja4.id_user', '=', 'users_mobile.id')
                ->where(function ($query) {
                    $query->where('kegiatan_pokja4.kategori', 'unggulan')->orWhere('kegiatan_pokja4.kategori', 'prioritas');
                })
                ->where(function ($query) use ($statusDesaKabupaten, $statusKecamatanKabupaten) {
                    $query->where(function ($q) use ($statusDesaKabupaten) {
                        $q->where('users_mobile.id_role', 1)->whereIn('kegiatan_pokja4.status', $statusDesaKabupaten);
                    })
                        ->orWhere(function ($q) use ($statusKecamatanKabupaten) {
                            $q->where('users_mobile.id_role', 2)->whereIn('kegiatan_pokja4.status', $statusKecamatanKabupaten);
                        });
                })->count();
        }

        /*
        |--------------------------------------------------------------------------
        | WEB KECAMATAN
        |--------------------------------------------------------------------------
        */ else if (Auth::guard('pengguna')->check()) {
            $user = Auth::guard('pengguna')->user();
            if ($user->id_role == 2) {
                $modelPertama = DB::table('laporan_bidang_kesehatan')->leftJoin('users_mobile', 'laporan_bidang_kesehatan.id_user', '=', 'users_mobile.id')
                    ->where('users_mobile.id_subdistrict', $user->id_subdistrict)->where('users_mobile.id_role', 1)->whereIn('laporan_bidang_kesehatan.status', $statusKecamatan)->count();

                $modelKedua = DB::table('laporan_kelestarian_lingkungan_hidup')->leftJoin('users_mobile', 'laporan_kelestarian_lingkungan_hidup.id_user', '=', 'users_mobile.id')
                    ->where('users_mobile.id_subdistrict', $user->id_subdistrict)->where('users_mobile.id_role', 1)->whereIn('laporan_kelestarian_lingkungan_hidup.status', $statusKecamatan)->count();

                $modelKetiga = DB::table('laporan_perencanaan_sehat')->leftJoin('users_mobile', 'laporan_perencanaan_sehat.id_user', '=', 'users_mobile.id')
                    ->where('users_mobile.id_subdistrict', $user->id_subdistrict)->where('users_mobile.id_role', 1)->whereIn('laporan_perencanaan_sehat.status', $statusKecamatan)->count();

                $modelKeempat = DB::table('laporan_kader_pokja4')->leftJoin('users_mobile', 'laporan_kader_pokja4.id_user', '=', 'users_mobile.id')
                    ->where('users_mobile.id_subdistrict', $user->id_subdistrict)->where('users_mobile.id_role', 1)->whereIn('laporan_kader_pokja4.status', $statusKecamatan)->count();

                $modelKelima = DB::table('rekap_desa_bulanan')->leftJoin('users_mobile', 'rekap_desa_bulanan.id_user', '=', 'users_mobile.id')
                    ->where(function ($query) {
                        $query->where('rekap_desa_bulanan.kategori', 'unggulan')->orWhere('rekap_desa_bulanan.kategori', 'prioritas');
                    })
                    ->where('users_mobile.id_subdistrict', $user->id_subdistrict)->where('users_mobile.id_role', 1)->whereIn('rekap_desa_bulanan.status', $statusKecamatan)->count();

                $modelKeenam = DB::table('rekap_desa_tahunan')->leftJoin('users_mobile', 'rekap_desa_tahunan.id_user', '=', 'users_mobile.id')
                    ->where(function ($query) {
                        $query->where('rekap_desa_tahunan.kategori', 'unggulan')->orWhere('rekap_desa_tahunan.kategori', 'prioritas');
                    })
                    ->where('users_mobile.id_subdistrict', $user->id_subdistrict)->where('users_mobile.id_role', 1)->whereIn('rekap_desa_tahunan.status', $statusKecamatan)->count();

                $modelKetujuh = DB::table('posyandu')->leftJoin('users_mobile', 'posyandu.id_user', '=', 'users_mobile.id')
                    ->where(function ($query) {
                        $query->where('posyandu.kategori', 'unggulan')->orWhere('posyandu.kategori', 'prioritas');
                    })
                    ->where('users_mobile.id_subdistrict', $user->id_subdistrict)->where('users_mobile.id_role', 1)->whereIn('posyandu.status', $statusKecamatan)->count();

                $modelKedelapan = DB::table('kegiatan_pokja4')->leftJoin('users_mobile', 'kegiatan_pokja4.id_user', '=', 'users_mobile.id')
                    ->where(function ($query) {
                        $query->where('kegiatan_pokja4.kategori', 'unggulan')->orWhere('kegiatan_pokja4.kategori', 'prioritas');
                    })
                    ->where('users_mobile.id_subdistrict', $user->id_subdistrict)->where('users_mobile.id_role', 1)->whereIn('kegiatan_pokja4.status', $statusKecamatan)->count();
            }
        }

        return view('backend.pokja4', compact('modelPertama', 'modelKedua', 'modelKetiga', 'modelKeempat', 'modelKelima', 'modelKeenam', 'modelKetujuh', 'modelKedelapan', 'data'));
    }

    /*
    |--------------------------------------------------------------------------
    | FUNGSI CETAK LAPORAN POKJA 4 (PDF)
    |--------------------------------------------------------------------------
    */
    public function cetak(Request $request)
    {
        $tipeCetak = $request->input('tipe_cetak', 'tahunan');
        $bulan = $request->input('bulan');
        $tahun = $request->input('tahun', date('Y'));

        $bidang = $request->input('bidang', 'semua');
        $subBidang = $request->input('sub_bidang', 'semua');

        $tanggal = ($tipeCetak == 'perbulan' && $bulan)
            ? \Carbon\Carbon::createFromDate($tahun, $bulan)->format('F Y')
            : $tahun;

        $formattedDate = \Carbon\Carbon::now()->isoFormat('d MMMM Y');

        // =====================================================
        // QUERY KESEHATAN
        // =====================================================

        $queryKesehatan = DB::table('laporan_bidang_kesehatan')
            ->leftJoin(
                'users_mobile',
                'laporan_bidang_kesehatan.id_user',
                '=',
                'users_mobile.id'
            )
            ->leftJoin(
                'subdistrict',
                'users_mobile.id_subdistrict',
                '=',
                'subdistrict.id'
            )
            ->select(
                'laporan_bidang_kesehatan.*',
                'subdistrict.name as nama_kec'
            );

        // =====================================================
        // QUERY KELESTARIAN
        // =====================================================

        $queryKelestarian = DB::table('laporan_kelestarian_lingkungan_hidup')
            ->leftJoin(
                'users_mobile',
                'laporan_kelestarian_lingkungan_hidup.id_user',
                '=',
                'users_mobile.id'
            )
            ->leftJoin(
                'subdistrict',
                'users_mobile.id_subdistrict',
                '=',
                'subdistrict.id'
            )
            ->select(
                'laporan_kelestarian_lingkungan_hidup.*',
                'subdistrict.name as nama_kec'
            );

        // =====================================================
        // QUERY PERENCANAAN SEHAT
        // =====================================================

        $queryPerencanaan = DB::table('laporan_perencanaan_sehat')
            ->leftJoin(
                'users_mobile',
                'laporan_perencanaan_sehat.id_user',
                '=',
                'users_mobile.id'
            )
            ->leftJoin(
                'subdistrict',
                'users_mobile.id_subdistrict',
                '=',
                'subdistrict.id'
            )
            ->select(
                'laporan_perencanaan_sehat.*',
                'subdistrict.name as nama_kec'
            );

        // =====================================================
        // QUERY KADER POKJA 4
        // =====================================================

        $queryKader = DB::table('laporan_kader_pokja4')
            ->leftJoin(
                'users_mobile',
                'laporan_kader_pokja4.id_user',
                '=',
                'users_mobile.id'
            )
            ->leftJoin(
                'subdistrict',
                'users_mobile.id_subdistrict',
                '=',
                'subdistrict.id'
            )
            ->select(
                'laporan_kader_pokja4.*',
                'subdistrict.name as nama_kec'
            );

        // =====================================================
        // QUERY INOVASI
        // =====================================================

        $queryInovasiRDB = DB::table('rekap_desa_bulanan')
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
            ->select(
                'rekap_desa_bulanan.*',
                'subdistrict.name as nama_kec'
            );

        $queryInovasiRDT = DB::table('rekap_desa_tahunan')
            ->leftJoin(
                'users_mobile',
                'rekap_desa_tahunan.id_user',
                '=',
                'users_mobile.id'
            )
            ->leftJoin(
                'subdistrict',
                'users_mobile.id_subdistrict',
                '=',
                'subdistrict.id'
            )
            ->select(
                'rekap_desa_tahunan.*',
                'subdistrict.name as nama_kec'
            );

        $queryInovasiPos = DB::table('posyandu')
            ->leftJoin(
                'users_mobile',
                'posyandu.id_user',
                '=',
                'users_mobile.id'
            )
            ->leftJoin(
                'subdistrict',
                'users_mobile.id_subdistrict',
                '=',
                'subdistrict.id'
            )
            ->select(
                'posyandu.*',
                'subdistrict.name as nama_kec'
            );

        $queryInovasiKP4 = DB::table('kegiatan_pokja4')
            ->leftJoin(
                'users_mobile',
                'kegiatan_pokja4.id_user',
                '=',
                'users_mobile.id'
            )
            ->leftJoin(
                'subdistrict',
                'users_mobile.id_subdistrict',
                '=',
                'subdistrict.id'
            )
            ->select(
                'kegiatan_pokja4.*',
                'subdistrict.name as nama_kec'
            );

        // =====================================================
        // FILTER LOGIN
        // =====================================================

        // =====================================
        // WEB KABUPATEN
        // =====================================

        if (Auth::guard('web')->check()) {

            $queryKesehatan->whereIn(
                'laporan_bidang_kesehatan.status',
                ['Disetujui2', 'disetujui2', 'DISETUJUI2']
            );

            $queryKelestarian->whereIn(
                'laporan_kelestarian_lingkungan_hidup.status',
                ['Disetujui2', 'disetujui2', 'DISETUJUI2']
            );

            $queryPerencanaan->whereIn(
                'laporan_perencanaan_sehat.status',
                ['Disetujui2', 'disetujui2', 'DISETUJUI2']
            );

            $queryKader->whereIn(
                'laporan_kader_pokja4.status',
                ['Disetujui2', 'disetujui2', 'DISETUJUI2']
            );

            $queryInovasiRDB->whereIn(
                'rekap_desa_bulanan.status',
                ['Disetujui2', 'disetujui2', 'DISETUJUI2']
            );

            $queryInovasiRDT->whereIn(
                'rekap_desa_tahunan.status',
                ['Disetujui2', 'disetujui2', 'DISETUJUI2']
            );

            $queryInovasiPos->whereIn(
                'posyandu.status',
                ['Disetujui2', 'disetujui2', 'DISETUJUI2']
            );

            $queryInovasiKP4->whereIn(
                'kegiatan_pokja4.status',
                ['Disetujui2', 'disetujui2', 'DISETUJUI2']
            );
        }

        // =====================================
        // WEB KECAMATAN
        // =====================================

        elseif (Auth::guard('pengguna')->check()) {

            $user = Auth::guard('pengguna')->user();

            if ($user->id_role == 2) {

                $queryKesehatan
                    ->where('users_mobile.id_subdistrict', $user->id_subdistrict)
                    ->where('users_mobile.id_role', 1)
                    ->whereIn(
                        'laporan_bidang_kesehatan.status',
                        ['Disetujui1', 'disetujui1', 'DISETUJUI1']
                    );

                $queryKelestarian
                    ->where('users_mobile.id_subdistrict', $user->id_subdistrict)
                    ->where('users_mobile.id_role', 1)
                    ->whereIn(
                        'laporan_kelestarian_lingkungan_hidup.status',
                        ['Disetujui1', 'disetujui1', 'DISETUJUI1']
                    );

                $queryPerencanaan
                    ->where('users_mobile.id_subdistrict', $user->id_subdistrict)
                    ->where('users_mobile.id_role', 1)
                    ->whereIn(
                        'laporan_perencanaan_sehat.status',
                        ['Disetujui1', 'disetujui1', 'DISETUJUI1']
                    );

                $queryKader
                    ->where('users_mobile.id_subdistrict', $user->id_subdistrict)
                    ->where('users_mobile.id_role', 1)
                    ->whereIn(
                        'laporan_kader_pokja4.status',
                        ['Disetujui1', 'disetujui1', 'DISETUJUI1']
                    );

                $queryInovasiRDB
                    ->where('users_mobile.id_subdistrict', $user->id_subdistrict)
                    ->where('users_mobile.id_role', 1)
                    ->whereIn(
                        'rekap_desa_bulanan.status',
                        ['Disetujui1', 'disetujui1', 'DISETUJUI1']
                    );

                $queryInovasiRDT
                    ->where('users_mobile.id_subdistrict', $user->id_subdistrict)
                    ->where('users_mobile.id_role', 1)
                    ->whereIn(
                        'rekap_desa_tahunan.status',
                        ['Disetujui1', 'disetujui1', 'DISETUJUI1']
                    );

                $queryInovasiPos
                    ->where('users_mobile.id_subdistrict', $user->id_subdistrict)
                    ->where('users_mobile.id_role', 1)
                    ->whereIn(
                        'posyandu.status',
                        ['Disetujui1', 'disetujui1', 'DISETUJUI1']
                    );

                $queryInovasiKP4
                    ->where('users_mobile.id_subdistrict', $user->id_subdistrict)
                    ->where('users_mobile.id_role', 1)
                    ->whereIn(
                        'kegiatan_pokja4.status',
                        ['Disetujui1', 'disetujui1', 'DISETUJUI1']
                    );
            }
        }

        // =====================================================
        // FILTER INOVASI
        // =====================================================

        if ($bidang == 'inovasi_prioritas') {

            $queryInovasiRDB->where(
                'rekap_desa_bulanan.kategori',
                'prioritas'
            );

            $queryInovasiRDT->where(
                'rekap_desa_tahunan.kategori',
                'prioritas'
            );

            $queryInovasiPos->where(
                'posyandu.kategori',
                'prioritas'
            );

            $queryInovasiKP4->where(
                'kegiatan_pokja4.kategori',
                'prioritas'
            );
        } elseif ($bidang == 'inovasi_unggulan') {

            $queryInovasiRDB->where(
                'rekap_desa_bulanan.kategori',
                'unggulan'
            );

            $queryInovasiRDT->where(
                'rekap_desa_tahunan.kategori',
                'unggulan'
            );

            $queryInovasiPos->where(
                'posyandu.kategori',
                'unggulan'
            );

            $queryInovasiKP4->where(
                'kegiatan_pokja4.kategori',
                'unggulan'
            );
        }

        // =====================================================
        // FILTER BULAN / TAHUN
        // =====================================================

        if ($tipeCetak == 'perbulan' && $bulan) {

            $queryKesehatan
                ->whereMonth('laporan_bidang_kesehatan.created_at', $bulan)
                ->whereYear('laporan_bidang_kesehatan.created_at', $tahun);

            $queryKelestarian
                ->whereMonth('laporan_kelestarian_lingkungan_hidup.created_at', $bulan)
                ->whereYear('laporan_kelestarian_lingkungan_hidup.created_at', $tahun);

            $queryPerencanaan
                ->whereMonth('laporan_perencanaan_sehat.created_at', $bulan)
                ->whereYear('laporan_perencanaan_sehat.created_at', $tahun);

            $queryKader
                ->whereMonth('laporan_kader_pokja4.created_at', $bulan)
                ->whereYear('laporan_kader_pokja4.created_at', $tahun);

            $queryInovasiRDB
                ->whereMonth('rekap_desa_bulanan.created_at', $bulan)
                ->whereYear('rekap_desa_bulanan.created_at', $tahun);

            $queryInovasiRDT
                ->whereMonth('rekap_desa_tahunan.created_at', $bulan)
                ->whereYear('rekap_desa_tahunan.created_at', $tahun);

            $queryInovasiPos
                ->whereMonth('posyandu.created_at', $bulan)
                ->whereYear('posyandu.created_at', $tahun);

            $queryInovasiKP4
                ->whereMonth('kegiatan_pokja4.created_at', $bulan)
                ->whereYear('kegiatan_pokja4.created_at', $tahun);
        } else {

            $queryKesehatan->whereYear(
                'laporan_bidang_kesehatan.created_at',
                $tahun
            );

            $queryKelestarian->whereYear(
                'laporan_kelestarian_lingkungan_hidup.created_at',
                $tahun
            );

            $queryPerencanaan->whereYear(
                'laporan_perencanaan_sehat.created_at',
                $tahun
            );

            $queryKader->whereYear(
                'laporan_kader_pokja4.created_at',
                $tahun
            );

            $queryInovasiRDB->whereYear(
                'rekap_desa_bulanan.created_at',
                $tahun
            );

            $queryInovasiRDT->whereYear(
                'rekap_desa_tahunan.created_at',
                $tahun
            );

            $queryInovasiPos->whereYear(
                'posyandu.created_at',
                $tahun
            );

            $queryInovasiKP4->whereYear(
                'kegiatan_pokja4.created_at',
                $tahun
            );
        }

        // =====================================================
        // EKSEKUSI QUERY
        // =====================================================

        $kesehatan = $queryKesehatan->get();

        $kelestarian = $queryKelestarian->get();

        $perencanaan = $queryPerencanaan->get();

        $laporanpokja4 = $queryKader->get();

        $inovasiRDB = $queryInovasiRDB->get();

        $inovasiRDT = $queryInovasiRDT->get();

        $inovasiPos = $queryInovasiPos->get();

        $inovasiKP4 = $queryInovasiKP4->get();

        // =====================================================
        // FILTER SUB BIDANG
        // =====================================================

        if ($subBidang == 'rekap_bulanan') {

            $inovasiRDT = collect();
            $inovasiPos = collect();
            $inovasiKP4 = collect();
        } elseif ($subBidang == 'rekap_tahunan') {

            $inovasiRDB = collect();
            $inovasiPos = collect();
            $inovasiKP4 = collect();
        } elseif ($subBidang == 'posyandu') {

            $inovasiRDB = collect();
            $inovasiRDT = collect();
            $inovasiKP4 = collect();
        } elseif ($subBidang == 'kegiatan_pokja4') {

            $inovasiRDB = collect();
            $inovasiRDT = collect();
            $inovasiPos = collect();
        }

        // =====================================================
        // TANDA TANGAN
        // =====================================================

        $wakil = DB::table('ttds')
            ->where('pokja', 'Kelompok Kerja IV')
            ->where(function ($q) {
                $q->where('jabatan', 'like', '%Wakil%')
                    ->orWhere('jabatan', 'like', '%Sekretaris%');
            })
            ->get();

        $ketua = DB::table('ttds')
            ->where('pokja', 'Kelompok Kerja IV')
            ->where('jabatan', 'Ketua')
            ->get();

        // =====================================================
        // VIEW
        // =====================================================

        $viewName = ($tipeCetak == 'perbulan')
            ? 'backend.cetak_bulan_pokja4'
            : 'backend.cetak_tahun_pokja4';

        return view($viewName, compact(
            'kesehatan',
            'kelestarian',
            'perencanaan',
            'laporanpokja4',

            'inovasiRDB',
            'inovasiRDT',
            'inovasiPos',
            'inovasiKP4',

            'wakil',
            'ketua',

            'tanggal',
            'formattedDate',

            'bidang',
            'subBidang',

            'tahun',
            'tipeCetak'
        ));
    }
    /*
    |--------------------------------------------------------------------------
    | FUNGSI EXPORT DATA JSON POKJA 4 (GOOGLE SHEETS)
    |--------------------------------------------------------------------------
    */
    public function getExportData(Request $request)
    {
        $bulan = $request->bulan;
        $tahun = $request->tahun;
        $bidang = $request->bidang;
        $subBidang = $request->sub_bidang;

        $tabel = '';
        $isKategoriInovasi = false;
        $kategoriNilai = '';

        if ($bidang == 'kesehatan') $tabel = 'laporan_bidang_kesehatan';
        elseif ($bidang == 'kelestarian') $tabel = 'laporan_kelestarian_lingkungan_hidup';
        elseif ($bidang == 'perencanaan') $tabel = 'laporan_perencanaan_sehat';
        elseif ($bidang == 'kader') $tabel = 'laporan_kader_pokja4';
        elseif ($bidang == 'inovasi_prioritas' || $bidang == 'inovasi_unggulan') {
            if ($subBidang == 'rekap_bulanan') $tabel = 'rekap_desa_bulanan';
            elseif ($subBidang == 'rekap_tahunan') $tabel = 'rekap_desa_tahunan';
            elseif ($subBidang == 'posyandu') $tabel = 'posyandu';
            elseif ($subBidang == 'kegiatan_pokja4') $tabel = 'kegiatan_pokja4';
            else return response()->json(['status' => 'error', 'message' => 'Pilih Sub Bidang Inovasi yang spesifik untuk Excel.']);

            $isKategoriInovasi = true;
            $kategoriNilai = ($bidang == 'inovasi_prioritas') ? 'prioritas' : 'unggulan';
        } else return response()->json(['status' => 'error', 'message' => 'Bidang tidak valid.']);

        try {
            $query = DB::table($tabel)
                ->leftJoin('users_mobile', "$tabel.id_user", '=', 'users_mobile.id')
                ->leftJoin('subdistrict', 'users_mobile.id_subdistrict', '=', 'subdistrict.id')
                ->leftJoin('village', 'users_mobile.id_village', '=', 'village.id')
                ->select('subdistrict.name as nama_kecamatan', 'village.name as nama_desa', "$tabel.*");

            if ($isKategoriInovasi) {
                $query->where("$tabel.kategori", $kategoriNilai);
            }

            $statusValid = ['Proses', 'proses', 'PROSES', 'Disetujui1', 'disetujui1', 'DISETUJUI1', 'Disetujui2', 'disetujui2', 'DISETUJUI2'];
            $query->whereIn("$tabel.status", $statusValid);

            if (Auth::guard('pengguna')->check()) {
                $user = Auth::guard('pengguna')->user();
                if ($user->id_role == 2) {
                    $query->where('users_mobile.id_subdistrict', $user->id_subdistrict);
                } else {
                    $query->where("$tabel.id_user", $user->id);
                }
            }

            if (!empty($bulan)) $query->whereMonth("$tabel.created_at", $bulan);
            if (!empty($tahun)) $query->whereYear("$tabel.created_at", $tahun);

            $data = $query->get();

            if ($data->isEmpty()) {
                return response()->json(['status' => 'empty', 'message' => 'Tidak ada data laporan yang valid pada periode tersebut.']);
            }

            // ==========================================
            // 🧹 [PERUBAHAN 03-10-2026] Merapikan pemetaan kolom ekspor Pokja 4; kode lama di bawah dinonaktifkan
            /*
            $data->transform(function ($item) {
                $kolomSampah = ['uuid', 'id_user', 'id_role', 'id_organization', 'created_at', 'updated_at'];
                foreach ($kolomSampah as $kolom) {
                    if (property_exists($item, $kolom)) unset($item->$kolom);
                }
                foreach ((array) $item as $key => $value) {
                    if (strpos($key, 'id_') === 0) unset($item->$key);
                }
                if (property_exists($item, 'status')) {
                    $item->status = ucfirst(strtolower($item->status));
                }
                return $item;
            });

            return response()->json(['status' => 'success', 'bidang' => strtoupper($bidang), 'data' => $data]);
            */
            $no = 1;
            $data = $data->map(function ($item) use (&$no, $bidang, $subBidang) {
                $row = [
                    'No' => $no++,
                    'Tanggal Laporan' => !empty($item->created_at) ? date('d-m-Y', strtotime($item->created_at)) : '-',
                    'Kecamatan' => !empty($item->nama_kecamatan) ? ucwords(strtolower($item->nama_kecamatan)) : '-',
                    'Desa / Kelurahan' => !empty($item->nama_desa) ? ucwords(strtolower($item->nama_desa)) : '-',
                ];

                if ($bidang == 'kesehatan') {
                    $row['Posyandu'] = $item->jumlah_posyandu ?? 0;
                    $row['Posyandu Terintegrasi'] = $item->jumlah_posyandu_iterasi ?? 0;
                    $row['Kelompok Lansia'] = $item->jumlah_klp ?? 0;
                    $row['Anggota Lansia'] = $item->jumlah_anggota ?? 0;
                    $row['Kartu Berobat Gratis'] = $item->jumlah_kartu_gratis ?? 0;
                } elseif ($bidang == 'kelestarian') {
                    $row['Jamban'] = $item->jamban ?? 0;
                    $row['SPAL'] = $item->spal ?? 0;
                    $row['TPS'] = $item->tps ?? 0;
                    $row['MCK'] = $item->mck ?? 0;
                    $row['PDAM'] = $item->pdam ?? 0;
                    $row['Sumur'] = $item->sumur ?? 0;
                    $row['Lainnya'] = $item->dll ?? 0;
                } elseif ($bidang == 'perencanaan') {
                    $row['Pasangan Usia Subur'] = $item->J_Psubur ?? 0;
                    $row['Wanita Usia Subur'] = $item->J_Wsubur ?? 0;
                    $row['Akseptor KB Pria'] = $item->Kb_p ?? 0;
                    $row['Akseptor KB Wanita'] = $item->Kb_w ?? 0;
                    $row['KK Tabungan'] = $item->Kk_tbg ?? 0;
                } elseif ($bidang == 'kader') {
                    $row['Kader Posyandu'] = $item->posyandu ?? 0;
                    $row['Kader Gizi'] = $item->gizi ?? 0;
                    $row['Kader Kesling'] = $item->kesling ?? 0;
                    $row['Kader Penyuluhan Narkoba'] = $item->penyuluhan_narkoba ?? 0;
                    $row['Kader PHBS'] = $item->PHBS ?? 0;
                    $row['Kader KB'] = $item->KB ?? 0;
                } elseif ($bidang == 'inovasi_prioritas' || $bidang == 'inovasi_unggulan') {
                    $row['Kategori'] = !empty($item->kategori) ? ucfirst($item->kategori) : '-';
                    if ($subBidang == 'rekap_bulanan') {
                        $row['RW'] = $item->rw ?? 0;
                        $row['RT'] = $item->rt ?? 0;
                        $row['Dasa Wisma'] = $item->dasa_wisma ?? 0;
                        $row['Hamil'] = $item->hamil ?? 0;
                        $row['Melahirkan'] = $item->melahirkan ?? 0;
                        $row['Nifas'] = $item->nifas ?? 0;
                        $row['Ibu Meninggal'] = $item->meninggal ?? 0;
                        $row['Bayi Lahir L'] = $item->bayi_lahir_l ?? 0;
                        $row['Bayi Lahir P'] = $item->bayi_lahir_p ?? 0;
                        $row['Akte Kelahiran Ada'] = $item->akte_kelahiran_ada ?? 0;
                        $row['Akte Kelahiran Tidak Ada'] = $item->akte_kelahiran_tidak ?? 0;
                        $row['Bayi Meninggal L'] = $item->bayi_meninggal_l ?? 0;
                        $row['Bayi Meninggal P'] = $item->bayi_meninggal_p ?? 0;
                        $row['Balita Meninggal L'] = $item->balita_meninggal_l ?? 0;
                        $row['Balita Meninggal P'] = $item->balita_meninggal_p ?? 0;
                    } elseif ($subBidang == 'rekap_tahunan') {
                        $row['Kader Kesehatan'] = $item->kader_kesehatan ?? 0;
                        $row['Gizi'] = $item->gizi ?? 0;
                        $row['Kesling'] = $item->kesling ?? 0;
                        $row['PHBS'] = $item->phbs ?? 0;
                        $row['KB'] = $item->kb ?? 0;
                        $row['Posyandu'] = $item->posyandu ?? 0;
                        $row['Imunisasi Bayi Balita'] = $item->imunisasi_vaksinasi_bayi_balita ?? 0;
                        $row['PKG'] = $item->pkg ?? 0;
                        $row['TBC'] = $item->tbc ?? 0;
                        $row['Jamban WC'] = $item->jamban_wc ?? 0;
                        $row['SPAL'] = $item->spal ?? 0;
                        $row['TPS'] = $item->tps ?? 0;
                        $row['Jumlah MCK'] = $item->jumlah_mck ?? 0;
                        $row['PDAM'] = $item->pdam ?? 0;
                        $row['Sumur'] = $item->sumur ?? 0;
                        $row['Lain-lain'] = $item->lain_lain ?? 0;
                        $row['Jml PUS'] = $item->jml_pus ?? 0;
                        $row['Jml WUS'] = $item->jml_wus ?? 0;
                        $row['Akseptor KB L'] = $item->akseptor_kb_l ?? 0;
                        $row['Akseptor KB P'] = $item->akseptor_kb_p ?? 0;
                        $row['KK Memiliki Tabungan'] = $item->jml_kk_tabungan ?? 0;
                        $row['KK Memiliki Asuransi'] = $item->jml_kk_asuransi ?? 0;
                        $row['Kesehatan Program'] = $item->kesehatan_program ?? 0;
                        $row['Kelestarian Lingkungan Hidup'] = $item->kelestarian_lingkungan_hidup ?? 0;
                        $row['Perencanaan Sehat Program'] = $item->perencanaan_sehat_program ?? 0;
                    } elseif ($subBidang == 'posyandu') {
                        $row['Bulan'] = $item->bulan ?? '-';
                        $row['Jml Ibu Hamil'] = $item->jml_ibu_hamil ?? 0;
                        $row['Diperiksa'] = $item->diperiksa ?? 0;
                        $row['Fe Tablet Darah'] = $item->fe_tablet_darah ?? 0;
                        $row['Jml Ibu Menyusui'] = $item->jml_ibu_menyusui ?? 0;
                        $row['KB Kondom'] = $item->kondom ?? 0;
                        $row['KB Pil'] = $item->pil ?? 0;
                        $row['KB Implant'] = $item->implant ?? 0;
                        $row['KB MOP'] = $item->mop ?? 0;
                        $row['KB MOW'] = $item->mow ?? 0;
                        $row['KB IUD'] = $item->iud ?? 0;
                        $row['KB Suntikan'] = $item->suntikan ?? 0;
                        $row['KB Lain-lain'] = $item->lain_lain_kb ?? 0;
                        $row['Jml Balita L'] = $item->jml_balita_l ?? 0;
                        $row['Jml Balita P'] = $item->jml_balita_p ?? 0;
                        $row['Buku KIA L'] = $item->buku_kia_l ?? 0;
                        $row['Buku KIA P'] = $item->buku_kia_p ?? 0;
                        $row['Datang L'] = $item->datang_l ?? 0;
                        $row['Datang P'] = $item->datang_p ?? 0;
                        $row['Naik L'] = $item->naik_l ?? 0;
                        $row['Naik P'] = $item->naik_p ?? 0;
                        $row['Vit A L'] = $item->vit_a_l ?? 0;
                        $row['Vit A P'] = $item->vit_a_p ?? 0;
                        $row['PMT L'] = $item->pmt_l ?? 0;
                        $row['PMT P'] = $item->pmt_p ?? 0;
                        $row['Imunisasi TT 1'] = $item->imunisasi_tt_1 ?? 0;
                        $row['Imunisasi TT 2'] = $item->imunisasi_tt_2 ?? 0;
                    } elseif ($subBidang == 'kegiatan_pokja4') {
                        $row['Kader Kesehatan'] = $item->kader_kesehatan ?? 0;
                        $row['Gizi'] = $item->gizi ?? 0;
                        $row['Kesling'] = $item->kesling ?? 0;
                        $row['PHBS'] = $item->phbs ?? 0;
                        $row['KB'] = $item->kb ?? 0;
                        $row['Posyandu'] = $item->posyandu ?? 0;
                        $row['Imunisasi Bayi Balita'] = $item->imunisasi_vaksinasi_bayi_balita ?? 0;
                        $row['PKG'] = $item->pkg ?? 0;
                        $row['TBC'] = $item->tbc ?? 0;
                        $row['Jamban WC'] = $item->jamban_wc ?? 0;
                        $row['SPAL'] = $item->spal ?? 0;
                        $row['TPS'] = $item->tps ?? 0;
                        $row['Jumlah MCK'] = $item->jumlah_mck ?? 0;
                        $row['PDAM'] = $item->pdam ?? 0;
                        $row['Sumur'] = $item->sumur ?? 0;
                        $row['Lain-lain'] = $item->lain_lain ?? 0;
                        $row['Jml PUS'] = $item->jml_pus ?? 0;
                        $row['Jml WUS'] = $item->jml_wus ?? 0;
                        $row['Akseptor KB L'] = $item->akseptor_kb_l ?? 0;
                        $row['Akseptor KB P'] = $item->akseptor_kb_p ?? 0;
                        $row['KK Memiliki Tabungan'] = $item->kk_memiliki_tabungan ?? 0;
                        $row['KK Memiliki Asuransi'] = $item->kk_memiliki_asuransi ?? 0;
                        $row['Kesehatan'] = $item->kesehatan ?? 0;
                        $row['Kelestarian Lingkungan'] = $item->kelestarian_lingkungan_hidup ?? 0;
                        $row['Perencanaan Sehat'] = $item->perencanaan_sehat ?? 0;
                    }
                }

                $row['Catatan'] = $item->catatan ?? '-';
                $row['Status'] = !empty($item->status) ? ucfirst(strtolower($item->status)) : '-';

                return $row;
            });

            return response()->json([
                'status' => 'success',
                'bidang' => strtoupper($bidang),
                'data' => $data
            ]);
            // ==========================================
        } catch (\Throwable $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 500);
        }
    }
}
