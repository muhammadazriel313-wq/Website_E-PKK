<?php

namespace App\Http\Controllers\backend;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class Pokja2Controller extends Controller
{
    public function index()
    {
        $modelPertama = 0; // Pendidikan & Keterampilan
        $modelKedua = 0;   // Pengembangan Kehidupan Berkoprasi

        // =====================================
        // 1. WEB KABUPATEN (ADMIN)
        // =====================================
        if (Auth::guard('web')->check()) {
            $statusAdmin = ['Disetujui1', 'Disetujui2'];

            $modelPertama = DB::table('laporan_pendidikan_n_keterampilan')
                ->leftJoin(
                    'users_mobile',
                    'laporan_pendidikan_n_keterampilan.id_user',
                    '=',
                    'users_mobile.id'
                )
                ->where(function ($query) {
                    // DESA
                    $query->where(function ($q) {
                        $q->where('users_mobile.id_role', 1)
                            ->whereIn(
                                'laporan_pendidikan_n_keterampilan.status',
                                ['Disetujui1','Disetujui2']
                            );
                    })
                        // MOBILE KECAMATAN
                        ->orWhere(function ($q) {
                            $q->where('users_mobile.id_role', 2)
                                ->whereIn(
                                    'laporan_pendidikan_n_keterampilan.status',
                                    ['Proses', 'proses', 'PROSES','Disetujui2']
                                );
                        });
                })
                ->count();

            $modelKedua = DB::table('laporan_pengembangan_kehidupan')
                ->leftJoin(
                    'users_mobile',
                    'laporan_pengembangan_kehidupan.id_user',
                    '=',
                    'users_mobile.id'
                )
                ->where(function ($query) {
                    // DESA
                    $query->where(function ($q) {
                        $q->where('users_mobile.id_role', 1)
                            ->whereIn(
                                'laporan_pengembangan_kehidupan.status',
                                ['Disetujui1','Disetujui2']
                            );
                    })
                        // MOBILE KECAMATAN
                        ->orWhere(function ($q) {
                            $q->where('users_mobile.id_role', 2)
                                ->whereIn(
                                    'laporan_pengembangan_kehidupan.status',
                                    ['Proses', 'proses', 'PROSES','Disetujui2']
                                );
                        });
                })
                ->count();

        }
        // =====================================
        // 2. PENGGUNA MOBILE (KECAMATAN / DESA)
        // =====================================
        else if (Auth::guard('pengguna')->check()) {
            $user = Auth::guard('pengguna')->user();

            if ($user->id_role == 2) {
                $statusKecamatan = ['Proses', 'Disetujui1'];

                $modelPertama = DB::table('laporan_pendidikan_n_keterampilan')
                    ->leftJoin('users_mobile', 'laporan_pendidikan_n_keterampilan.id_user', '=', 'users_mobile.id')
                    ->where('users_mobile.id_subdistrict', $user->id_subdistrict)
                    ->where('users_mobile.id_role', 1)
                    ->whereIn('laporan_pendidikan_n_keterampilan.status', $statusKecamatan)
                    ->count();

                $modelKedua = DB::table('laporan_pengembangan_kehidupan')
                    ->leftJoin('users_mobile', 'laporan_pengembangan_kehidupan.id_user', '=', 'users_mobile.id')
                    ->where('users_mobile.id_subdistrict', $user->id_subdistrict)
                    ->where('users_mobile.id_role', 1)
                    ->whereIn('laporan_pengembangan_kehidupan.status', $statusKecamatan)
                    ->count();

            }
        }

        return view('backend.pokja2', compact('modelPertama', 'modelKedua'));
    }
    // ==========================================
    // FUNGSI BARU: EXPORT JSON POKJA 2
    // ==========================================
    public function getExportData(Request $request)
    {
        $bulan = $request->bulan;
        $tahun = $request->tahun;
        $bidang = $request->bidang;

        // Pilih tabel berdasarkan bidang
        $tabel = '';
        if ($bidang == 'pendidikan') $tabel = 'laporan_pendidikan_n_keterampilan';
        elseif ($bidang == 'pengembangan') $tabel = 'laporan_pengembangan_kehidupan';
        // Opsional kalau ada Kader Pokja 2
        elseif ($bidang == 'kader') $tabel = 'laporan_kader_pokja2'; 
        else return response()->json(['status' => 'error', 'message' => 'Bidang tidak valid.']);

        try {
            $query = DB::table($tabel)
                ->leftJoin('users_mobile', "$tabel.id_user", '=', 'users_mobile.id')
                ->leftJoin('subdistrict', 'users_mobile.id_subdistrict', '=', 'subdistrict.id')
                ->leftJoin('village', 'users_mobile.id_village', '=', 'village.id')
                ->select('subdistrict.name as nama_kecamatan', 'village.name as nama_desa', "$tabel.*");

            // FILTER ROLE & STATUS YANG BENAR
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

            // Filter Waktu
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
            return response()->json([
                'status' => 'error', 
                'message' => 'Error Baris ' . $e->getLine() . ': ' . $e->getMessage()
            ], 500);
        }
    }
    /*
    |--------------------------------------------------------------------------
    | FUNGSI CETAK LAPORAN POKJA 2
    |--------------------------------------------------------------------------
    */
    public function cetak(Request $request)
    {
        $tipeCetak = $request->input('tipe_cetak', 'tahunan'); 
        $bulan = $request->input('bulan', date('m'));
        $tahun = $request->input('tahun', date('Y'));
        
        // 1. TANGKAP VARIABEL BIDANG (Saklar Tabel)
        $bidang = $request->input('bidang', 'semua'); 
        
        $tanggal = ($tipeCetak == 'perbulan') ? \Carbon\Carbon::createFromDate($tahun, $bulan)->format('F Y') : $tahun;
        $formattedDate = \Carbon\Carbon::now()->isoFormat('d MMMM Y');

        // =========================================================
        // PERHATIAN: Sesuaikan nama tabel 'laporan_pendidikan_n_keterampilan' 
        // dan 'laporan_pengembangan_kehidupan_berkoperasi' dengan yang ada di database komandan
        // =========================================================

        // QUERY PENDIDIKAN
     // 1. GANTI NAMA TABEL PENDIDIKAN DI SINI
        $queryPendidikan = \Illuminate\Support\Facades\DB::table('laporan_pendidikan_n_keterampilan')
            ->leftJoin('users_mobile', 'laporan_pendidikan_n_keterampilan.id_user', '=', 'users_mobile.id')
            ->leftJoin('subdistrict', 'users_mobile.id_subdistrict', '=', 'subdistrict.id')
            ->select('laporan_pendidikan_n_keterampilan.*', 'subdistrict.name as nama_kec')
            ->whereIn('laporan_pendidikan_n_keterampilan.status', ['Disetujui2']); 

        // 2. GANTI NAMA TABEL PENGEMBANGAN KOPERASI DI SINI
        $queryPengembangan = \Illuminate\Support\Facades\DB::table('laporan_pengembangan_kehidupan')
            ->leftJoin('users_mobile', 'laporan_pengembangan_kehidupan.id_user', '=', 'users_mobile.id')
            ->leftJoin('subdistrict', 'users_mobile.id_subdistrict', '=', 'subdistrict.id')
            ->select('laporan_pengembangan_kehidupan.*', 'subdistrict.name as nama_kec')
            ->whereIn('laporan_pengembangan_kehidupan.status', ['Disetujui2']);

        // ... dan jangan lupa ganti juga nama tabelnya di bagian FILTER TAHUN / BULAN di bawahnya:
        if ($tipeCetak == 'perbulan') {
            $queryPendidikan->whereMonth('laporan_pendidikan_n_keterampilan.created_at', $bulan)->whereYear('laporan_pendidikan_n_keterampilan.created_at', $tahun);
            $queryPengembangan->whereMonth('laporan_pengembangan_kehidupan.created_at', $bulan)->whereYear('laporan_pengembangan_kehidupan.created_at', $tahun);
        } else {
            $queryPendidikan->whereYear('laporan_pendidikan_n_keterampilan.created_at', $tahun);
            $queryPengembangan->whereYear('laporan_pengembangan_kehidupan.created_at', $tahun);
        }


        // Eksekusi Query
        $pendidikan = $queryPendidikan->get();
        $pengembangan = $queryPengembangan->get();

        // DATA TANDA TANGAN 
        $wakil = \Illuminate\Support\Facades\DB::table('ttds')->where('pokja', 'Kelompok Kerja II')
                    ->where(function($q) { $q->where('jabatan', 'like', '%Wakil%')->orWhere('jabatan', 'like', '%Sekretaris%'); })->get();
        
        $ketua = \Illuminate\Support\Facades\DB::table('ttds')->where('pokja', 'Kelompok Kerja II')->where('jabatan', 'Ketua')->get();

        $viewName = ($tipeCetak == 'perbulan') ? 'backend.cetak_bulan_pokja2' : 'backend.cetak_tahun_pokja2';

        // Lempar data ke view Print
        return view($viewName, compact(
            'pendidikan', 'pengembangan', 
            'wakil', 'ketua', 'tanggal', 'formattedDate', 'bidang'
        ));
    }
}