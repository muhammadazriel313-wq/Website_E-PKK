<?php

namespace App\Http\Controllers\backend;

use Illuminate\Http\Request;
use App\Models\Sandang;
use App\Models\Pangan;
use App\Models\Perumahan;
use App\Models\LaporanPokja3;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Pengguna;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class Pokja3Controller extends Controller
{
    public function index()
    {
        $modelPertama = 0; // Pangan
        $modelKedua = 0;   // Sandang
        $modelKetiga = 0;  // Perumahan
        $modelKeempat = 0; // Kader Pokja 3

        // =====================================
        // 1. WEB KABUPATEN (ADMIN)
        // =====================================
        if (Auth::guard('web')->check()) {
            $statusAdmin = ['Disetujui1', 'Disetujui2'];

            $modelPertama = DB::table('laporan_pangan')
                ->leftJoin('users_mobile', 'laporan_pangan.id_user', '=', 'users_mobile.id')
                ->where(function ($query) {
                    $query->where(function ($q) {
                        $q->where('users_mobile.id_role', 1)
                            ->whereIn('laporan_pangan.status', ['Disetujui1', 'Disetujui2']);
                    })
                        ->orWhere(function ($q) {
                            $q->where('users_mobile.id_role', 2)
                                ->whereIn('laporan_pangan.status', ['Proses', 'proses', 'PROSES', 'Disetujui2']);
                        });
                })->count();

            $modelKedua = DB::table('laporan_sandang')
                ->leftJoin('users_mobile', 'laporan_sandang.id_user', '=', 'users_mobile.id')
                ->where(function ($query) {
                    $query->where(function ($q) {
                        $q->where('users_mobile.id_role', 1)
                            ->whereIn('laporan_sandang.status', ['Disetujui1', 'Disetujui2']);
                    })
                        ->orWhere(function ($q) {
                            $q->where('users_mobile.id_role', 2)
                                ->whereIn('laporan_sandang.status', ['Proses', 'proses', 'PROSES', 'Disetujui2']);
                        });
                })->count();

            $modelKetiga = DB::table('laporan_perumahan')
                ->leftJoin('users_mobile', 'laporan_perumahan.id_user', '=', 'users_mobile.id')
                ->where(function ($query) {
                    $query->where(function ($q) {
                        $q->where('users_mobile.id_role', 1)
                            ->whereIn('laporan_perumahan.status', ['Disetujui1', 'Disetujui2']);
                    })
                        ->orWhere(function ($q) {
                            $q->where('users_mobile.id_role', 2)
                                ->whereIn('laporan_perumahan.status', ['Proses', 'proses', 'PROSES', 'Disetujui2']);
                        });
                })->count();

            $modelKeempat = DB::table('laporan_kader_pokja3')
                ->leftJoin('users_mobile', 'laporan_kader_pokja3.id_user', '=', 'users_mobile.id')
                ->where(function ($query) {
                    $query->where(function ($q) {
                        $q->where('users_mobile.id_role', 1)
                            ->whereIn('laporan_kader_pokja3.status', ['Disetujui1', 'Disetujui2']);
                    })
                        ->orWhere(function ($q) {
                            $q->where('users_mobile.id_role', 2)
                                ->whereIn('laporan_kader_pokja3.status', ['Proses', 'proses', 'PROSES', 'Disetujui2']);
                        });
                })->count();
        }
        // =====================================
        // 2. PENGGUNA MOBILE (KECAMATAN / DESA)
        // =====================================
        elseif (Auth::guard('pengguna')->check()) {
            $user = Auth::guard('pengguna')->user();

            if ($user->id_role == 2) {
                $statusKecamatan = ['Proses', 'Disetujui1'];

                $modelPertama = DB::table('laporan_pangan')
                    ->leftJoin('users_mobile', 'laporan_pangan.id_user', '=', 'users_mobile.id')
                    ->where('users_mobile.id_subdistrict', $user->id_subdistrict)
                    ->where('users_mobile.id_role', 1)
                    ->whereIn('laporan_pangan.status', $statusKecamatan)
                    ->count();

                $modelKedua = DB::table('laporan_sandang')
                    ->leftJoin('users_mobile', 'laporan_sandang.id_user', '=', 'users_mobile.id')
                    ->where('users_mobile.id_subdistrict', $user->id_subdistrict)
                    ->where('users_mobile.id_role', 1)
                    ->whereIn('laporan_sandang.status', $statusKecamatan)
                    ->count();

                $modelKetiga = DB::table('laporan_perumahan')
                    ->leftJoin('users_mobile', 'laporan_perumahan.id_user', '=', 'users_mobile.id')
                    ->where('users_mobile.id_subdistrict', $user->id_subdistrict)
                    ->where('users_mobile.id_role', 1)
                    ->whereIn('laporan_perumahan.status', $statusKecamatan)
                    ->count();

                $modelKeempat = DB::table('laporan_kader_pokja3')
                    ->leftJoin('users_mobile', 'laporan_kader_pokja3.id_user', '=', 'users_mobile.id')
                    ->where('users_mobile.id_subdistrict', $user->id_subdistrict)
                    ->where('users_mobile.id_role', 1)
                    ->whereIn('laporan_kader_pokja3.status', $statusKecamatan)
                    ->count();
            }
        }

        return view('backend.pokja3', compact('modelPertama', 'modelKedua', 'modelKetiga', 'modelKeempat'));
    }

    // ==========================================
    // FUNGSI EXPORT JSON POKJA 3
    // ==========================================
    public function getExportData(Request $request)
    {
        $bulan = $request->bulan;
        $tahun = $request->tahun;
        $bidang = $request->bidang;

        // Pilih tabel berdasarkan bidang (Sudah disesuaikan dengan database komandan)
        $tabel = '';
        if ($bidang == 'pangan') $tabel = 'laporan_pangan';
        elseif ($bidang == 'sandang') $tabel = 'laporan_sandang';
        elseif ($bidang == 'perumahan') $tabel = 'laporan_perumahan';
        elseif ($bidang == 'kader') $tabel = 'laporan_kader_pokja3';
        else return response()->json(['status' => 'error', 'message' => 'Bidang tidak valid.']);

        try {
            $query = DB::table($tabel)
                ->leftJoin('users_mobile', "$tabel.id_user", '=', 'users_mobile.id')
                ->leftJoin('subdistrict', 'users_mobile.id_subdistrict', '=', 'subdistrict.id')
                ->leftJoin('village', 'users_mobile.id_village', '=', 'village.id')
                ->select('subdistrict.name as nama_kecamatan', 'village.name as nama_desa', "$tabel.*");

            // FILTER ROLE & STATUS 
            if (Auth::guard('web')->check()) {
                $statusAdmin = ['Disetujui1', 'disetujui1', 'DISETUJUI1', 'Disetujui2', 'disetujui2', 'DISETUJUI2'];
                $query->whereIn("$tabel.status", $statusAdmin);
            } elseif (Auth::guard('pengguna')->check()) {
                $user = Auth::guard('pengguna')->user();
                if ($user->id_role == 2) {
                    $statusKecamatan = ['Proses', 'proses', 'PROSES', 'Disetujui1', 'disetujui1', 'DISETUJUI1'];
                    $query->whereIn("$tabel.status", $statusKecamatan)
                        ->where('users_mobile.id_subdistrict', $user->id_subdistrict);
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

            return response()->json([
                'status' => 'success',
                'bidang' => strtoupper($bidang),
                'data' => $data
            ]);
        } catch (\Throwable $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 500);
        }
    }

    /*
    |--------------------------------------------------------------------------
    | FUNGSI CETAK LAPORAN POKJA 3
    |--------------------------------------------------------------------------
    */
    public function cetak(Request $request)
    {
        $tipeCetak = $request->input('tipe_cetak', 'tahunan');
        $bulan = $request->input('bulan', date('m'));
        $tahun = $request->input('tahun', date('Y'));

        $bidang = $request->input('bidang', 'semua');

        $tanggal = ($tipeCetak == 'perbulan')
            ? Carbon::createFromDate($tahun, $bulan)->format('F Y')
            : $tahun;

        $formattedDate = Carbon::now()->isoFormat('d MMMM Y');

        // =====================================================
        // NAMA TABEL
        // =====================================================

        $tabelPangan    = 'laporan_pangan';
        $tabelSandang   = 'laporan_sandang';
        $tabelPerumahan = 'laporan_perumahan';
        $tabelKader     = 'laporan_kader_pokja3';

        // =====================================================
        // QUERY PANGAN
        // =====================================================

        $queryPangan = DB::table($tabelPangan)
            ->leftJoin(
                'users_mobile',
                $tabelPangan . '.id_user',
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
                $tabelPangan . '.*',
                'subdistrict.name as nama_kec'
            );

        // =====================================================
        // QUERY SANDANG
        // =====================================================

        $querySandang = DB::table($tabelSandang)
            ->leftJoin(
                'users_mobile',
                $tabelSandang . '.id_user',
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
                $tabelSandang . '.*',
                'subdistrict.name as nama_kec'
            );

        // =====================================================
        // QUERY PERUMAHAN
        // =====================================================

        $queryPerumahan = DB::table($tabelPerumahan)
            ->leftJoin(
                'users_mobile',
                $tabelPerumahan . '.id_user',
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
                $tabelPerumahan . '.*',
                'subdistrict.name as nama_kec'
            );

        // =====================================================
        // QUERY KADER POKJA 3
        // =====================================================

        $queryKader = DB::table($tabelKader)
            ->leftJoin(
                'users_mobile',
                $tabelKader . '.id_user',
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
                $tabelKader . '.*',
                'subdistrict.name as nama_kec'
            );

        // =====================================================
        // FILTER LOGIN
        // =====================================================

        // =====================================
        // WEB KABUPATEN
        // =====================================

        if (Auth::guard('web')->check()) {

            $queryPangan->whereIn(
                $tabelPangan . '.status',
                ['Disetujui2', 'disetujui2', 'DISETUJUI2']
            );

            $querySandang->whereIn(
                $tabelSandang . '.status',
                ['Disetujui2', 'disetujui2', 'DISETUJUI2']
            );

            $queryPerumahan->whereIn(
                $tabelPerumahan . '.status',
                ['Disetujui2', 'disetujui2', 'DISETUJUI2']
            );

            $queryKader->whereIn(
                $tabelKader . '.status',
                ['Disetujui2', 'disetujui2', 'DISETUJUI2']
            );
        }

        // =====================================
        // WEB KECAMATAN
        // =====================================

        elseif (Auth::guard('pengguna')->check()) {

            $user = Auth::guard('pengguna')->user();

            if ($user->id_role == 2) {

                $queryPangan
                    ->where('users_mobile.id_subdistrict', $user->id_subdistrict)
                    ->where('users_mobile.id_role', 1)
                    ->whereIn(
                        $tabelPangan . '.status',
                        ['Disetujui1', 'disetujui1', 'DISETUJUI1']
                    );

                $querySandang
                    ->where('users_mobile.id_subdistrict', $user->id_subdistrict)
                    ->where('users_mobile.id_role', 1)
                    ->whereIn(
                        $tabelSandang . '.status',
                        ['Disetujui1', 'disetujui1', 'DISETUJUI1']
                    );

                $queryPerumahan
                    ->where('users_mobile.id_subdistrict', $user->id_subdistrict)
                    ->where('users_mobile.id_role', 1)
                    ->whereIn(
                        $tabelPerumahan . '.status',
                        ['Disetujui1', 'disetujui1', 'DISETUJUI1']
                    );

                $queryKader
                    ->where('users_mobile.id_subdistrict', $user->id_subdistrict)
                    ->where('users_mobile.id_role', 1)
                    ->whereIn(
                        $tabelKader . '.status',
                        ['Disetujui1', 'disetujui1', 'DISETUJUI1']
                    );
            }
        }

        // =====================================================
        // FILTER BULAN / TAHUN
        // =====================================================

        if ($tipeCetak == 'perbulan') {

            $queryPangan
                ->whereMonth($tabelPangan . '.created_at', $bulan)
                ->whereYear($tabelPangan . '.created_at', $tahun);

            $querySandang
                ->whereMonth($tabelSandang . '.created_at', $bulan)
                ->whereYear($tabelSandang . '.created_at', $tahun);

            $queryPerumahan
                ->whereMonth($tabelPerumahan . '.created_at', $bulan)
                ->whereYear($tabelPerumahan . '.created_at', $tahun);

            $queryKader
                ->whereMonth($tabelKader . '.created_at', $bulan)
                ->whereYear($tabelKader . '.created_at', $tahun);
        } else {

            $queryPangan
                ->whereYear($tabelPangan . '.created_at', $tahun);

            $querySandang
                ->whereYear($tabelSandang . '.created_at', $tahun);

            $queryPerumahan
                ->whereYear($tabelPerumahan . '.created_at', $tahun);

            $queryKader
                ->whereYear($tabelKader . '.created_at', $tahun);
        }

        // =====================================================
        // EKSEKUSI QUERY
        // =====================================================

        $pangan = $queryPangan
            ->orderBy($tabelPangan . '.created_at', 'desc')
            ->get();

        $sandang = $querySandang
            ->orderBy($tabelSandang . '.created_at', 'desc')
            ->get();

        $perumahan = $queryPerumahan
            ->orderBy($tabelPerumahan . '.created_at', 'desc')
            ->get();

        $laporanpokja3 = $queryKader
            ->orderBy($tabelKader . '.created_at', 'desc')
            ->get();

        // =====================================================
        // DATA TANDA TANGAN
        // =====================================================

        $wakil = DB::table('ttds')
            ->where('pokja', 'Kelompok Kerja III')
            ->where(function ($q) {
                $q->where('jabatan', 'like', '%Wakil%')
                    ->orWhere('jabatan', 'like', '%Sekretaris%');
            })
            ->get();

        $ketua = DB::table('ttds')
            ->where('pokja', 'Kelompok Kerja III')
            ->where('jabatan', 'Ketua')
            ->get();

        // =====================================================
        // VIEW
        // =====================================================

        $viewName = ($tipeCetak == 'perbulan')
            ? 'backend.cetak_bulan_pokja3'
            : 'backend.cetak_tahun_pokja3';

        return view($viewName, compact(
            'pangan',
            'sandang',
            'perumahan',
            'laporanpokja3',
            'wakil',
            'ketua',
            'tanggal',
            'formattedDate',
            'bidang'
        ));
    }
}
