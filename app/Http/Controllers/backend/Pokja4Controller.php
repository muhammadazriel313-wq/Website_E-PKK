<?php

namespace App\Http\Controllers\backend;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon; // <-- Tambahan untuk format tanggal

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

            /*
            |--------------------------------------------------------------------------
            | MODEL 1
            |--------------------------------------------------------------------------
            */

            $modelPertama = DB::table('laporan_bidang_kesehatan')

                ->leftJoin(
                    'users_mobile',
                    'laporan_bidang_kesehatan.id_user',
                    '=',
                    'users_mobile.id'
                )

                ->where(function ($query) use (
                    $statusDesaKabupaten,
                    $statusKecamatanKabupaten
                ) {

                    // DESA
                    $query->where(function ($q) use ($statusDesaKabupaten) {

                        $q->where('users_mobile.id_role', 1)

                            ->whereIn(
                                'laporan_bidang_kesehatan.status',
                                $statusDesaKabupaten
                            );
                    })

                    // KECAMATAN
                    ->orWhere(function ($q) use ($statusKecamatanKabupaten) {

                        $q->where('users_mobile.id_role', 2)

                            ->whereIn(
                                'laporan_bidang_kesehatan.status',
                                $statusKecamatanKabupaten
                            );
                    });
                })

                ->count();

            /*
            |--------------------------------------------------------------------------
            | MODEL 2
            |--------------------------------------------------------------------------
            */

            $modelKedua = DB::table('laporan_kelestarian_lingkungan_hidup')

                ->leftJoin(
                    'users_mobile',
                    'laporan_kelestarian_lingkungan_hidup.id_user',
                    '=',
                    'users_mobile.id'
                )

                ->where(function ($query) use (
                    $statusDesaKabupaten,
                    $statusKecamatanKabupaten
                ) {

                    $query->where(function ($q) use ($statusDesaKabupaten) {

                        $q->where('users_mobile.id_role', 1)

                            ->whereIn(
                                'laporan_kelestarian_lingkungan_hidup.status',
                                $statusDesaKabupaten
                            );
                    })

                    ->orWhere(function ($q) use ($statusKecamatanKabupaten) {

                        $q->where('users_mobile.id_role', 2)

                            ->whereIn(
                                'laporan_kelestarian_lingkungan_hidup.status',
                                $statusKecamatanKabupaten
                            );
                    });
                })

                ->count();

            /*
            |--------------------------------------------------------------------------
            | MODEL 3
            |--------------------------------------------------------------------------
            */

            $modelKetiga = DB::table('laporan_perencanaan_sehat')

                ->leftJoin(
                    'users_mobile',
                    'laporan_perencanaan_sehat.id_user',
                    '=',
                    'users_mobile.id'
                )

                ->where(function ($query) use (
                    $statusDesaKabupaten,
                    $statusKecamatanKabupaten
                ) {

                    $query->where(function ($q) use ($statusDesaKabupaten) {

                        $q->where('users_mobile.id_role', 1)

                            ->whereIn(
                                'laporan_perencanaan_sehat.status',
                                $statusDesaKabupaten
                            );
                    })

                    ->orWhere(function ($q) use ($statusKecamatanKabupaten) {

                        $q->where('users_mobile.id_role', 2)

                            ->whereIn(
                                'laporan_perencanaan_sehat.status',
                                $statusKecamatanKabupaten
                            );
                    });
                })

                ->count();

            /*
            |--------------------------------------------------------------------------
            | MODEL 4
            |--------------------------------------------------------------------------
            */

            $modelKeempat = DB::table('laporan_kader_pokja4')

                ->leftJoin(
                    'users_mobile',
                    'laporan_kader_pokja4.id_user',
                    '=',
                    'users_mobile.id'
                )

                ->where(function ($query) use (
                    $statusDesaKabupaten,
                    $statusKecamatanKabupaten
                ) {

                    $query->where(function ($q) use ($statusDesaKabupaten) {

                        $q->where('users_mobile.id_role', 1)

                            ->whereIn(
                                'laporan_kader_pokja4.status',
                                $statusDesaKabupaten
                            );
                    })

                    ->orWhere(function ($q) use ($statusKecamatanKabupaten) {

                        $q->where('users_mobile.id_role', 2)

                            ->whereIn(
                                'laporan_kader_pokja4.status',
                                $statusKecamatanKabupaten
                            );
                    });
                })

                ->count();

            /*
            |--------------------------------------------------------------------------
            | MODEL 5 = REKAP BULANAN UNGGULAN
            |--------------------------------------------------------------------------
            */

            $modelKelima = DB::table('rekap_desa_bulanan')

                ->leftJoin(
                    'users_mobile',
                    'rekap_desa_bulanan.id_user',
                    '=',
                    'users_mobile.id'
                )

                ->where(function ($query) {
                    $query->where('rekap_desa_bulanan.kategori', 'unggulan')
                          ->orWhere('rekap_desa_bulanan.kategori', 'prioritas');
                })

                ->where(function ($query) use (
                    $statusDesaKabupaten,
                    $statusKecamatanKabupaten
                ) {

                    // DESA
                    $query->where(function ($q) use ($statusDesaKabupaten) {

                        $q->where('users_mobile.id_role', 1)

                            ->whereIn(
                                'rekap_desa_bulanan.status',
                                $statusDesaKabupaten
                            );
                    })

                    // KECAMATAN
                    ->orWhere(function ($q) use ($statusKecamatanKabupaten) {

                        $q->where('users_mobile.id_role', 2)

                            ->whereIn(
                                'rekap_desa_bulanan.status',
                                $statusKecamatanKabupaten
                            );
                    });
                })

                ->count();

            /*
            |--------------------------------------------------------------------------
            | MODEL 6 = REKAP TAHUNAN UNGGULAN
            |--------------------------------------------------------------------------
            */

            $modelKeenam = DB::table('rekap_desa_tahunan')

                ->leftJoin(
                    'users_mobile',
                    'rekap_desa_tahunan.id_user',
                    '=',
                    'users_mobile.id'
                )

                ->where(function ($query) {
                    $query->where('rekap_desa_tahunan.kategori', 'unggulan')
                          ->orWhere('rekap_desa_tahunan.kategori', 'prioritas');
                })

                ->where(function ($query) use (
                    $statusDesaKabupaten,
                    $statusKecamatanKabupaten
                ) {

                    // DESA
                    $query->where(function ($q) use ($statusDesaKabupaten) {

                        $q->where('users_mobile.id_role', 1)

                            ->whereIn(
                                'rekap_desa_tahunan.status',
                                $statusDesaKabupaten
                            );
                    })

                    // KECAMATAN
                    ->orWhere(function ($q) use ($statusKecamatanKabupaten) {

                        $q->where('users_mobile.id_role', 2)

                            ->whereIn(
                                'rekap_desa_tahunan.status',
                                $statusKecamatanKabupaten
                            );
                    });
                })

                ->count();

            /*
            |--------------------------------------------------------------------------
            | MODEL 7 = POSYANDU UNGGULAN
            |--------------------------------------------------------------------------
            */

            $modelKetujuh = DB::table('posyandu')

                ->leftJoin(
                    'users_mobile',
                    'posyandu.id_user',
                    '=',
                    'users_mobile.id'
                )

                ->where(function ($query) {
                    $query->where('posyandu.kategori', 'unggulan')
                          ->orWhere('posyandu.kategori', 'prioritas');
                })

                ->where(function ($query) use (
                    $statusDesaKabupaten,
                    $statusKecamatanKabupaten
                ) {

                    // DESA
                    $query->where(function ($q) use ($statusDesaKabupaten) {

                        $q->where('users_mobile.id_role', 1)

                            ->whereIn(
                                'posyandu.status',
                                $statusDesaKabupaten
                            );
                    })

                    // KECAMATAN
                    ->orWhere(function ($q) use ($statusKecamatanKabupaten) {

                        $q->where('users_mobile.id_role', 2)

                            ->whereIn(
                                'posyandu.status',
                                $statusKecamatanKabupaten
                            );
                    });
                })

                ->count();

            /*
            |--------------------------------------------------------------------------
            | MODEL 8 = KEGIATAN UNGGULAN
            |--------------------------------------------------------------------------
            */

            $modelKedelapan = DB::table('kegiatan_pokja4')

                ->leftJoin(
                    'users_mobile',
                    'kegiatan_pokja4.id_user',
                    '=',
                    'users_mobile.id'
                )

                ->where(function ($query) {
                    $query->where('kegiatan_pokja4.kategori', 'unggulan')
                          ->orWhere('kegiatan_pokja4.kategori', 'prioritas');
                })

                ->where(function ($query) use (
                    $statusDesaKabupaten,
                    $statusKecamatanKabupaten
                ) {

                    // DESA
                    $query->where(function ($q) use ($statusDesaKabupaten) {

                        $q->where('users_mobile.id_role', 1)

                            ->whereIn(
                                'kegiatan_pokja4.status',
                                $statusDesaKabupaten
                            );
                    })

                    // KECAMATAN
                    ->orWhere(function ($q) use ($statusKecamatanKabupaten) {

                        $q->where('users_mobile.id_role', 2)

                            ->whereIn(
                                'kegiatan_pokja4.status',
                                $statusKecamatanKabupaten
                            );
                    });
                })

                ->count();
        }

        /*
        |--------------------------------------------------------------------------
        | WEB KECAMATAN
        |--------------------------------------------------------------------------
        */

        else if (Auth::guard('pengguna')->check()) {

            $user = Auth::guard('pengguna')->user();

            if ($user->id_role == 2) {

                $modelPertama = DB::table('laporan_bidang_kesehatan')
                    ->leftJoin(
                        'users_mobile',
                        'laporan_bidang_kesehatan.id_user',
                        '=',
                        'users_mobile.id'
                    )
                    ->where('users_mobile.id_subdistrict', $user->id_subdistrict)
                    ->where('users_mobile.id_role', 1)
                    ->whereIn(
                        'laporan_bidang_kesehatan.status',
                        $statusKecamatan
                    )
                    ->count();

                $modelKedua = DB::table('laporan_kelestarian_lingkungan_hidup')
                    ->leftJoin(
                        'users_mobile',
                        'laporan_kelestarian_lingkungan_hidup.id_user',
                        '=',
                        'users_mobile.id'
                    )
                    ->where('users_mobile.id_subdistrict', $user->id_subdistrict)
                    ->where('users_mobile.id_role', 1)
                    ->whereIn(
                        'laporan_kelestarian_lingkungan_hidup.status',
                        $statusKecamatan
                    )
                    ->count();

                $modelKetiga = DB::table('laporan_perencanaan_sehat')
                    ->leftJoin(
                        'users_mobile',
                        'laporan_perencanaan_sehat.id_user',
                        '=',
                        'users_mobile.id'
                    )
                    ->where('users_mobile.id_subdistrict', $user->id_subdistrict)
                    ->where('users_mobile.id_role', 1)
                    ->whereIn(
                        'laporan_perencanaan_sehat.status',
                        $statusKecamatan
                    )
                    ->count();

                $modelKeempat = DB::table('laporan_kader_pokja4')
                    ->leftJoin(
                        'users_mobile',
                        'laporan_kader_pokja4.id_user',
                        '=',
                        'users_mobile.id'
                    )
                    ->where('users_mobile.id_subdistrict', $user->id_subdistrict)
                    ->where('users_mobile.id_role', 1)
                    ->whereIn(
                        'laporan_kader_pokja4.status',
                        $statusKecamatan
                    )
                    ->count();

                $modelKelima = DB::table('rekap_desa_bulanan')
                    ->leftJoin(
                        'users_mobile',
                        'rekap_desa_bulanan.id_user',
                        '=',
                        'users_mobile.id'
                    )
                    ->where(function ($query) {
                        $query->where('rekap_desa_bulanan.kategori', 'unggulan')
                              ->orWhere('rekap_desa_bulanan.kategori', 'prioritas');
                    })
                    ->where('users_mobile.id_subdistrict', $user->id_subdistrict)
                    ->where('users_mobile.id_role', 1)
                    ->whereIn(
                        'rekap_desa_bulanan.status',
                        $statusKecamatan
                    )
                    ->count();

                $modelKeenam = DB::table('rekap_desa_tahunan')
                    ->leftJoin(
                        'users_mobile',
                        'rekap_desa_tahunan.id_user',
                        '=',
                        'users_mobile.id'
                    )
                    ->where(function ($query) {
                        $query->where('rekap_desa_tahunan.kategori', 'unggulan')
                              ->orWhere('rekap_desa_tahunan.kategori', 'prioritas');
                    })
                    ->where('users_mobile.id_subdistrict', $user->id_subdistrict)
                    ->where('users_mobile.id_role', 1)
                    ->whereIn(
                        'rekap_desa_tahunan.status',
                        $statusKecamatan
                    )
                    ->count();

                $modelKetujuh = DB::table('posyandu')
                    ->leftJoin(
                        'users_mobile',
                        'posyandu.id_user',
                        '=',
                        'users_mobile.id'
                    )
                    ->where(function ($query) {
                        $query->where('posyandu.kategori', 'unggulan')
                              ->orWhere('posyandu.kategori', 'prioritas');
                    })
                    ->where('users_mobile.id_subdistrict', $user->id_subdistrict)
                    ->where('users_mobile.id_role', 1)
                    ->whereIn(
                        'posyandu.status',
                        $statusKecamatan
                    )
                    ->count();

                $modelKedelapan = DB::table('kegiatan_pokja4')
                    ->leftJoin(
                        'users_mobile',
                        'kegiatan_pokja4.id_user',
                        '=',
                        'users_mobile.id'
                    )
                    ->where(function ($query) {
                        $query->where('kegiatan_pokja4.kategori', 'unggulan')
                              ->orWhere('kegiatan_pokja4.kategori', 'prioritas');
                    })
                    ->where('users_mobile.id_subdistrict', $user->id_subdistrict)
                    ->where('users_mobile.id_role', 1)
                    ->whereIn(
                        'kegiatan_pokja4.status',
                        $statusKecamatan
                    )
                    ->count();
            }
        }

        return view(
            'backend.pokja4',
            compact(
                'modelPertama',
                'modelKedua',
                'modelKetiga',
                'modelKeempat',
                'modelKelima',
                'modelKeenam',
                'modelKetujuh',
                'modelKedelapan',
                'data'
            )
        );
    }

    /*
    |--------------------------------------------------------------------------
    | FUNGSI CETAK LAPORAN POKJA 4 (PDF)
    |--------------------------------------------------------------------------
    */
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

        $tanggal = ($tipeCetak == 'perbulan' && $bulan) ? \Carbon\Carbon::createFromDate($tahun, $bulan)->format('F Y') : $tahun;
        $formattedDate = \Carbon\Carbon::now()->isoFormat('d MMMM Y');

        // Query Utama
        $queryKesehatan   = DB::table('laporan_bidang_kesehatan')->leftJoin('users_mobile', 'laporan_bidang_kesehatan.id_user', '=', 'users_mobile.id')->leftJoin('subdistrict', 'users_mobile.id_subdistrict', '=', 'subdistrict.id')->select('laporan_bidang_kesehatan.*', 'subdistrict.name as nama_kec')->where('laporan_bidang_kesehatan.status', 'Disetujui2');
        $queryKelestarian = DB::table('laporan_kelestarian_lingkungan_hidup')->leftJoin('users_mobile', 'laporan_kelestarian_lingkungan_hidup.id_user', '=', 'users_mobile.id')->leftJoin('subdistrict', 'users_mobile.id_subdistrict', '=', 'subdistrict.id')->select('laporan_kelestarian_lingkungan_hidup.*', 'subdistrict.name as nama_kec')->where('laporan_kelestarian_lingkungan_hidup.status', 'Disetujui2');
        $queryPerencanaan = DB::table('laporan_perencanaan_sehat')->leftJoin('users_mobile', 'laporan_perencanaan_sehat.id_user', '=', 'users_mobile.id')->leftJoin('subdistrict', 'users_mobile.id_subdistrict', '=', 'subdistrict.id')->select('laporan_perencanaan_sehat.*', 'subdistrict.name as nama_kec')->where('laporan_perencanaan_sehat.status', 'Disetujui2');
        $queryKader       = DB::table('laporan_kader_pokja4')->leftJoin('users_mobile', 'laporan_kader_pokja4.id_user', '=', 'users_mobile.id')->leftJoin('subdistrict', 'users_mobile.id_subdistrict', '=', 'subdistrict.id')->select('laporan_kader_pokja4.*', 'subdistrict.name as nama_kec')->where('laporan_kader_pokja4.status', 'Disetujui2');
        
        // QUERY INOVASI
        $queryInovasiRDB = DB::table('rekap_desa_bulanan')->leftJoin('users_mobile', 'rekap_desa_bulanan.id_user', '=', 'users_mobile.id')->leftJoin('subdistrict', 'users_mobile.id_subdistrict', '=', 'subdistrict.id')->select('rekap_desa_bulanan.*', 'subdistrict.name as nama_kec')->where('rekap_desa_bulanan.status', 'Disetujui2');
        $queryInovasiRDT = DB::table('rekap_desa_tahunan')->leftJoin('users_mobile', 'rekap_desa_tahunan.id_user', '=', 'users_mobile.id')->leftJoin('subdistrict', 'users_mobile.id_subdistrict', '=', 'subdistrict.id')->select('rekap_desa_tahunan.*', 'subdistrict.name as nama_kec')->where('rekap_desa_tahunan.status', 'Disetujui2');
        $queryInovasiPos = DB::table('posyandu')->leftJoin('users_mobile', 'posyandu.id_user', '=', 'users_mobile.id')->leftJoin('subdistrict', 'users_mobile.id_subdistrict', '=', 'subdistrict.id')->select('posyandu.*', 'subdistrict.name as nama_kec')->where('posyandu.status', 'Disetujui2');
        $queryInovasiKP4 = DB::table('kegiatan_pokja4')->leftJoin('users_mobile', 'kegiatan_pokja4.id_user', '=', 'users_mobile.id')->leftJoin('subdistrict', 'users_mobile.id_subdistrict', '=', 'subdistrict.id')->select('kegiatan_pokja4.*', 'subdistrict.name as nama_kec')->where('kegiatan_pokja4.status', 'Disetujui2');

        // Filter Tahun
        $queryKesehatan->whereYear('laporan_bidang_kesehatan.created_at', $tahun);
        $queryKelestarian->whereYear('laporan_kelestarian_lingkungan_hidup.created_at', $tahun);
        $queryPerencanaan->whereYear('laporan_perencanaan_sehat.created_at', $tahun);
        $queryKader->whereYear('laporan_kader_pokja4.created_at', $tahun);
        $queryInovasiRDB->whereYear('rekap_desa_bulanan.created_at', $tahun);
        $queryInovasiRDT->whereYear('rekap_desa_tahunan.created_at', $tahun);
        $queryInovasiPos->whereYear('posyandu.created_at', $tahun);
        $queryInovasiKP4->whereYear('kegiatan_pokja4.created_at', $tahun);

        // Ambil data
        $kesehatan     = $queryKesehatan->get();
        $kelestarian   = $queryKelestarian->get();
        $perencanaan   = $queryPerencanaan->get();
        $laporanpokja4 = $queryKader->get();
        $inovasiRDB    = $queryInovasiRDB->get();
        $inovasiRDT    = $queryInovasiRDT->get();
        $inovasiPos    = $queryInovasiPos->get();
        $inovasiKP4    = $queryInovasiKP4->get();

        $wakil = DB::table('ttds')->where('pokja', 'Kelompok Kerja IV')->where(function($q) { $q->where('jabatan', 'like', '%Wakil%')->orWhere('jabatan', 'like', '%Sekretaris%'); })->get();
        $ketua = DB::table('ttds')->where('pokja', 'Kelompok Kerja IV')->where('jabatan', 'Ketua')->get();

        $viewName = ($tipeCetak == 'perbulan') ? 'backend.cetak_bulan_pokja4' : 'backend.cetak_tahun_pokja4';

// ... (di dalam fungsi cetak Pokja4Controller.php) ...
        return view($viewName, compact(
            'kesehatan', 'kelestarian', 'perencanaan', 'laporanpokja4', 
            'inovasiRDB', 'inovasiRDT', 'inovasiPos', 'inovasiKP4',
            'wakil', 'ketua', 'tanggal', 'formattedDate', 'bidang', 'tipeCetak', 'tahun'
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

        // Routing nama tabel berdasarkan parameter bidang
        $tabel = '';
        $isKategoriInovasi = false;
        $kategoriNilai = '';

        if ($bidang == 'kesehatan') $tabel = 'laporan_bidang_kesehatan';
        elseif ($bidang == 'kelestarian') $tabel = 'laporan_kelestarian_lingkungan_hidup';
        elseif ($bidang == 'perencanaan') $tabel = 'laporan_perencanaan_sehat';
        elseif ($bidang == 'kader') $tabel = 'laporan_kader_pokja4';
        elseif ($bidang == 'inovasi_prioritas') { $tabel = 'kegiatan_pokja4'; $isKategoriInovasi = true; $kategoriNilai = 'prioritas'; }
        elseif ($bidang == 'inovasi_unggulan') { $tabel = 'kegiatan_pokja4'; $isKategoriInovasi = true; $kategoriNilai = 'unggulan'; }
        else return response()->json(['status' => 'error', 'message' => 'Bidang tidak valid.']);

        try {
            $query = DB::table($tabel)
                ->leftJoin('users_mobile', "$tabel.id_user", '=', 'users_mobile.id')
                ->leftJoin('subdistrict', 'users_mobile.id_subdistrict', '=', 'subdistrict.id')
                ->leftJoin('village', 'users_mobile.id_village', '=', 'village.id')
                ->select('subdistrict.name as nama_kecamatan', 'village.name as nama_desa', "$tabel.*");

            // Filter Kategori Khusus jika itu data inovasi
            if ($isKategoriInovasi) {
                $query->where("$tabel.kategori", $kategoriNilai);
            }

            // FILTER VALIDASI STATUS (Hanya data terverifikasi Admin)
            if (Auth::guard('web')->check()) {
                $statusAdmin = ['Disetujui1', 'disetujui1', 'DISETUJUI1', 'Disetujui2', 'disetujui2', 'DISETUJUI2'];
                $query->whereIn("$tabel.status", $statusAdmin);
            } elseif (Auth::guard('pengguna')->check()) {
                $user = Auth::guard('pengguna')->user();
                if ($user->id_role == 2) {
                    $statusKecamatan = ['Proses', 'proses', 'PROSES', 'Disetujui1', 'disetujui1', 'DISETUJUI1'];
                    $query->whereIn("$tabel.status", $statusKecamatan)->where('users_mobile.id_subdistrict', $user->id_subdistrict);
                } else {
                    $query->where("$tabel.id_user", $user->id);
                }
            }

            // Filter berdasarkan bulan & tahun
            if (!empty($bulan)) $query->whereMonth("$tabel.created_at", $bulan);
            if (!empty($tahun)) $query->whereYear("$tabel.created_at", $tahun);

            $data = $query->get();

            if ($data->isEmpty()) {
                return response()->json(['status' => 'empty', 'message' => 'Tidak ada data laporan yang valid pada periode tersebut.']);
            }

            // Membersihkan kolom sistem database internal agar rapi di Excel
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

            return response()->json([
                'status' => 'success',
                'bidang' => strtoupper($bidang),
                'data' => $data
            ]);
        } catch (\Throwable $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 500);
        }
    }
}