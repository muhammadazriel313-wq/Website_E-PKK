<?php

namespace App\Http\Controllers\backend;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class Pokja1Controller extends Controller
{
    public function index()
    {
        $modelPertama = 0;
        $modelKedua = 0;
        $modelKetiga = 0;

        // =====================================
        // WEB KABUPATEN
        // =====================================
        if (Auth::guard('web')->check()) {
            $statusAdmin = ['Disetujui1', 'Disetujui2'];

            $modelPertama = DB::table('laporan_penghayatan_n_pengamalan')
                ->leftJoin('users_mobile', 'laporan_penghayatan_n_pengamalan.id_user', '=', 'users_mobile.id')
                ->where(function ($query) {
                    $query->where(function ($q) {
                        $q->where('users_mobile.id_role', 1)
                            ->whereIn('laporan_penghayatan_n_pengamalan.status', ['Disetujui1', 'Disetujui2']);
                    })
                        ->orWhere(function ($q) {
                            $q->where('users_mobile.id_role', 2)
                                ->whereIn('laporan_penghayatan_n_pengamalan.status', ['Proses', 'proses', 'PROSES', 'Disetujui2']);
                        });
                })->count();

            $modelKedua = DB::table('laporan_gotong_royong')
                ->leftJoin('users_mobile', 'laporan_gotong_royong.id_user', '=', 'users_mobile.id')
                ->where(function ($query) {
                    $query->where(function ($q) {
                        $q->where('users_mobile.id_role', 1)
                            ->whereIn('laporan_gotong_royong.status', ['Disetujui1', 'Disetujui2']);
                    })
                        ->orWhere(function ($q) {
                            $q->where('users_mobile.id_role', 2)
                                ->whereIn('laporan_gotong_royong.status', ['Proses', 'proses', 'PROSES', 'Disetujui2']);
                        });
                })->count();

            $modelKetiga = DB::table('laporan_kader_pokja1')
                ->leftJoin('users_mobile', 'laporan_kader_pokja1.id_user', '=', 'users_mobile.id')
                ->where(function ($query) {
                    $query->where(function ($q) {
                        $q->where('users_mobile.id_role', 1)
                            ->whereIn('laporan_kader_pokja1.status', ['Disetujui1', 'Disetujui2']);
                    })
                        ->orWhere(function ($q) {
                            $q->where('users_mobile.id_role', 2)
                                ->whereIn('laporan_kader_pokja1.status', ['Proses', 'proses', 'PROSES', 'Disetujui2']);
                        });
                })->count();
        }
        // =====================================
        // WEB KECAMATAN
        // =====================================
        else if (Auth::guard('pengguna')->check()) {
            $user = Auth::guard('pengguna')->user();

            if ($user->id_role == 2) {
                $statusKecamatan = ['Proses', 'Disetujui1'];

                $modelPertama = DB::table('laporan_penghayatan_n_pengamalan')
                    ->leftJoin('users_mobile', 'laporan_penghayatan_n_pengamalan.id_user', '=', 'users_mobile.id')
                    ->where('users_mobile.id_subdistrict', $user->id_subdistrict)
                    ->where('users_mobile.id_role', 1)
                    ->whereIn('laporan_penghayatan_n_pengamalan.status', $statusKecamatan)
                    ->count();

                $modelKedua = DB::table('laporan_gotong_royong')
                    ->leftJoin('users_mobile', 'laporan_gotong_royong.id_user', '=', 'users_mobile.id')
                    ->where('users_mobile.id_subdistrict', $user->id_subdistrict)
                    ->where('users_mobile.id_role', 1)
                    ->whereIn('laporan_gotong_royong.status', $statusKecamatan)
                    ->count();

                $modelKetiga = DB::table('laporan_kader_pokja1')
                    ->leftJoin('users_mobile', 'laporan_kader_pokja1.id_user', '=', 'users_mobile.id')
                    ->where('users_mobile.id_subdistrict', $user->id_subdistrict)
                    ->where('users_mobile.id_role', 1)
                    ->whereIn('laporan_kader_pokja1.status', $statusKecamatan)
                    ->count();
            }
        }

        return view('backend.pokja1', compact('modelPertama', 'modelKedua', 'modelKetiga'));
    }

    /*
    |--------------------------------------------------------------------------
    | FUNGSI FILTER (Menyaring Laporan Berdasarkan Waktu)
    |--------------------------------------------------------------------------
    */
    public function filter(Request $request)
    {
        $bulan = $request->bulan;
        $tahun = $request->tahun;

        // Ambil data untuk dikirim kembali ke View setelah di-filter
        $modelPertama = DB::table('laporan_penghayatan_n_pengamalan')->when($bulan, function ($q) use ($bulan) {
            return $q->whereMonth('created_at', $bulan);
        })->when($tahun, function ($q) use ($tahun) {
            return $q->whereYear('created_at', $tahun);
        })->count();
        $modelKedua = DB::table('laporan_gotong_royong')->when($bulan, function ($q) use ($bulan) {
            return $q->whereMonth('created_at', $bulan);
        })->when($tahun, function ($q) use ($tahun) {
            return $q->whereYear('created_at', $tahun);
        })->count();
        $modelKetiga = DB::table('laporan_kader_pokja1')->when($bulan, function ($q) use ($bulan) {
            return $q->whereMonth('created_at', $bulan);
        })->when($tahun, function ($q) use ($tahun) {
            return $q->whereYear('created_at', $tahun);
        })->count();

        // Menyimpan nilai filter untuk ditampilkan lagi di dropdown
        return view('backend.pokja1', compact('modelPertama', 'modelKedua', 'modelKetiga', 'bulan', 'tahun'));
    }

    /*
    |--------------------------------------------------------------------------
    | FUNGSI CETAK LAPORAN (Menyiapkan Data ke View Print)
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
        // QUERY PENGHAYATAN
        // =====================================================

        $queryPenghayatan = DB::table('laporan_penghayatan_n_pengamalan')
            ->leftJoin(
                'users_mobile',
                'laporan_penghayatan_n_pengamalan.id_user',
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
                'laporan_penghayatan_n_pengamalan.*',
                'subdistrict.name as nama_kec'
            );

        // =====================================================
        // QUERY GOTONG ROYONG
        // =====================================================

        $queryGotongRoyong = DB::table('laporan_gotong_royong')
            ->leftJoin(
                'users_mobile',
                'laporan_gotong_royong.id_user',
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
                'laporan_gotong_royong.*',
                'subdistrict.name as nama_kec'
            );

        // =====================================================
        // QUERY KADER POKJA 1
        // =====================================================

        $queryKaderPokja = DB::table('laporan_kader_pokja1')
            ->leftJoin(
                'users_mobile',
                'laporan_kader_pokja1.id_user',
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
                'laporan_kader_pokja1.*',
                'subdistrict.name as nama_kec'
            );

        // =====================================================
        // FILTER LOGIN
        // =====================================================

        // =====================================
        // WEB KABUPATEN
        // =====================================

        if (Auth::guard('web')->check()) {

            $queryPenghayatan->whereIn(
                'laporan_penghayatan_n_pengamalan.status',
                ['Disetujui2', 'disetujui2', 'DISETUJUI2']
            );

            $queryGotongRoyong->whereIn(
                'laporan_gotong_royong.status',
                ['Disetujui2', 'disetujui2', 'DISETUJUI2']
            );

            $queryKaderPokja->whereIn(
                'laporan_kader_pokja1.status',
                ['Disetujui2', 'disetujui2', 'DISETUJUI2']
            );
        }

        // =====================================
        // WEB KECAMATAN
        // =====================================

        elseif (Auth::guard('pengguna')->check()) {

            $user = Auth::guard('pengguna')->user();

            if ($user->id_role == 2) {

                $queryPenghayatan
                    ->where('users_mobile.id_subdistrict', $user->id_subdistrict)
                    ->where('users_mobile.id_role', 1)
                    ->whereIn(
                        'laporan_penghayatan_n_pengamalan.status',
                        ['Disetujui1', 'disetujui1', 'DISETUJUI1']
                    );

                $queryGotongRoyong
                    ->where('users_mobile.id_subdistrict', $user->id_subdistrict)
                    ->where('users_mobile.id_role', 1)
                    ->whereIn(
                        'laporan_gotong_royong.status',
                        ['Disetujui1', 'disetujui1', 'DISETUJUI1']
                    );

                $queryKaderPokja
                    ->where('users_mobile.id_subdistrict', $user->id_subdistrict)
                    ->where('users_mobile.id_role', 1)
                    ->whereIn(
                        'laporan_kader_pokja1.status',
                        ['Disetujui1', 'disetujui1', 'DISETUJUI1']
                    );
            }
        }

        // =====================================================
        // FILTER BULAN / TAHUN
        // =====================================================

        if ($tipeCetak == 'perbulan') {

            $queryPenghayatan
                ->whereMonth('laporan_penghayatan_n_pengamalan.created_at', $bulan)
                ->whereYear('laporan_penghayatan_n_pengamalan.created_at', $tahun);

            $queryGotongRoyong
                ->whereMonth('laporan_gotong_royong.created_at', $bulan)
                ->whereYear('laporan_gotong_royong.created_at', $tahun);

            $queryKaderPokja
                ->whereMonth('laporan_kader_pokja1.created_at', $bulan)
                ->whereYear('laporan_kader_pokja1.created_at', $tahun);
        } else {

            $queryPenghayatan
                ->whereYear('laporan_penghayatan_n_pengamalan.created_at', $tahun);

            $queryGotongRoyong
                ->whereYear('laporan_gotong_royong.created_at', $tahun);

            $queryKaderPokja
                ->whereYear('laporan_kader_pokja1.created_at', $tahun);
        }

        // =====================================================
        // EKSEKUSI QUERY
        // =====================================================

        $penghayatan = $queryPenghayatan
            ->orderBy('laporan_penghayatan_n_pengamalan.created_at', 'desc')
            ->get();

        $gotongroyong = $queryGotongRoyong
            ->orderBy('laporan_gotong_royong.created_at', 'desc')
            ->get();

        $laporanpokja1 = $queryKaderPokja
            ->orderBy('laporan_kader_pokja1.created_at', 'desc')
            ->get();

        // =====================================================
        // TANDA TANGAN
        // =====================================================

        $wakil = DB::table('ttds')
            ->where('pokja', 'Kelompok Kerja I')
            ->where(function ($q) {
                $q->where('jabatan', 'like', '%Wakil%')
                    ->orWhere('jabatan', 'like', '%Sekretaris%');
            })
            ->get();

        $ketua = DB::table('ttds')
            ->where('pokja', 'Kelompok Kerja I')
            ->where('jabatan', 'Ketua')
            ->get();

        // =====================================================
        // VIEW
        // =====================================================

        $viewName = ($tipeCetak == 'perbulan')
            ? 'backend.cetak_bulan_pokja1'
            : 'backend.cetak_tahun_pokja1';

        return view($viewName, compact(
            'penghayatan',
            'gotongroyong',
            'laporanpokja1',
            'wakil',
            'ketua',
            'tanggal',
            'formattedDate',
            'bidang'
        ));
    }

    // ==========================================
    // FUNGSI BARU: EXPORT JSON POKJA 1
    // ==========================================
    public function getExportData(Request $request)
    {
        $bulan = $request->bulan;
        $tahun = $request->tahun;
        $bidang = $request->bidang;

        // Pilih tabel berdasarkan bidang
        $tabel = '';
        if ($bidang == 'penghayatan') $tabel = 'laporan_penghayatan_n_pengamalan';
        elseif ($bidang == 'gotongroyong') $tabel = 'laporan_gotong_royong';
        elseif ($bidang == 'kader') $tabel = 'laporan_kader_pokja1';
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

            // ==========================================
            // 🧹 JURUS RAPI: BERSIHKAN KOLOM DATABASE
            // ==========================================
            $data->transform(function ($item) {
                // 1. Daftar kolom 'dapur' yang tidak boleh masuk ke Excel
                $kolomSampah = ['uuid', 'id_user', 'id_role', 'id_organization', 'created_at', 'updated_at'];

                foreach ($kolomSampah as $kolom) {
                    if (property_exists($item, $kolom)) {
                        unset($item->$kolom); // Buang kolomnya!
                    }
                }

                // 2. Hapus otomatis semua kolom Primary Key (yang depannya 'id_')
                foreach ((array) $item as $key => $value) {
                    if (strpos($key, 'id_') === 0) {
                        unset($item->$key);
                    }
                }

                // 3. Rapikan penulisan huruf pada status
                if (property_exists($item, 'status')) {
                    $item->status = ucfirst(strtolower($item->status));
                }

                return $item;
            });
            // ==========================================

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
}
