<?php

namespace App\Http\Controllers\backend;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

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
                                ['Disetujui1', 'Disetujui2']
                            );
                    })
                        // MOBILE KECAMATAN
                        ->orWhere(function ($q) {
                            $q->where('users_mobile.id_role', 2)
                                ->whereIn(
                                    'laporan_pendidikan_n_keterampilan.status',
                                    ['Proses', 'proses', 'PROSES', 'Disetujui2']
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
                                ['Disetujui1', 'Disetujui2']
                            );
                    })
                        // MOBILE KECAMATAN
                        ->orWhere(function ($q) {
                            $q->where('users_mobile.id_role', 2)
                                ->whereIn(
                                    'laporan_pengembangan_kehidupan.status',
                                    ['Proses', 'proses', 'PROSES', 'Disetujui2']
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

            // [PERUBAHAN 03-10-2026] Merapikan pemetaan kolom ekspor Pokja 2; kode lama di bawah dinonaktifkan
            /*
            return response()->json([
                'status' => 'success',
                'bidang' => strtoupper($bidang),
                'data' => $data
            ]);
            */
            $no = 1;
            $cleanData = $data->map(function ($item) use (&$no, $bidang) {
                $row = [
                    'No' => $no++,
                    'Tanggal Laporan' => !empty($item->created_at) ? date('d-m-Y', strtotime($item->created_at)) : '-',
                    'Kecamatan' => !empty($item->nama_kecamatan) ? ucwords(strtolower($item->nama_kecamatan)) : '-',
                    'Desa / Kelurahan' => !empty($item->nama_desa) ? ucwords(strtolower($item->nama_desa)) : '-',
                ];

                if ($bidang == 'pendidikan') {
                    $row['Warga Buta'] = $item->warga_buta ?? 0;
                    $row['Kel Belajar Paket A'] = $item->kel_belajarA ?? 0;
                    $row['Warga Belajar Paket A'] = $item->warga_belajarA ?? 0;
                    $row['Kel Belajar Paket B'] = $item->kel_belajarB ?? 0;
                    $row['Warga Belajar Paket B'] = $item->warga_belajarB ?? 0;
                    $row['Kel Belajar Paket C'] = $item->kel_belajarC ?? 0;
                    $row['Warga Belajar Paket C'] = $item->warga_belajarC ?? 0;
                    $row['Kel Belajar KF'] = $item->kel_belajarKF ?? 0;
                    $row['Warga Belajar KF'] = $item->warga_belajarKF ?? 0;
                    $row['PAUD/Sejenis'] = $item->paud ?? 0;
                    $row['Taman Bacaan'] = $item->taman_bacaan ?? 0;
                    $row['Jumlah Kelompok BKB'] = $item->jumlah_klp ?? 0;
                    $row['Jumlah Ibu Peserta BKB'] = $item->jumlah_ibu_peserta ?? 0;
                    $row['Jumlah APE'] = $item->jumlah_ape ?? 0;
                    $row['Jumlah Kelompok Simulasi'] = $item->jumlah_kel_simulasi ?? 0;
                    $row['Tutor KF'] = $item->KF ?? 0;
                    $row['Tutor PAUD'] = $item->paud_tutor ?? 0;
                    $row['Kader BKB'] = $item->BKB ?? 0;
                    $row['Kader Koperasi'] = $item->koperasi ?? 0;
                    $row['Kader Keterampilan'] = $item->ketrampilan ?? 0;
                    $row['Kader LP3PKK'] = $item->LP3PKK ?? 0;
                    $row['Kader TP3PKK'] = $item->TP3PKK ?? 0;
                    $row['Damas PKK'] = $item->damas_pkk ?? 0;
                } elseif ($bidang == 'pengembangan') {
                    $row['Kelompok UP2K Pemula'] = $item->jumlah_kelompok_pemula ?? 0;
                    $row['Peserta UP2K Pemula'] = $item->jumlah_peserta_pemula ?? 0;
                    $row['Kelompok UP2K Madya'] = $item->jumlah_kelompok_madya ?? 0;
                    $row['Peserta UP2K Madya'] = $item->jumlah_peserta_madya ?? 0;
                    $row['Kelompok UP2K Utama'] = $item->jumlah_kelompok_utama ?? 0;
                    $row['Peserta UP2K Utama'] = $item->jumlah_peserta_utama ?? 0;
                    $row['Kelompok UP2K Mandiri'] = $item->jumlah_kelompok_mandiri ?? 0;
                    $row['Peserta UP2K Mandiri'] = $item->jumlah_peserta_mandiri ?? 0;
                    $row['Kelompok Berbadan Hukum'] = $item->jumlah_kelompok_hukum ?? 0;
                    $row['Peserta Berbadan Hukum'] = $item->jumlah_peserta_hukum ?? 0;
                }

                $row['Catatan'] = $item->catatan ?? '-';
                $row['Status'] = !empty($item->status) ? ucfirst(strtolower($item->status)) : '-';

                return $row;
            });

            return response()->json([
                'status' => 'success',
                'bidang' => strtoupper($bidang),
                'data' => $cleanData
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

        $bidang = $request->input('bidang', 'semua');

        $tanggal = ($tipeCetak == 'perbulan')
            ? Carbon::createFromDate($tahun, $bulan)->format('F Y')
            : $tahun;

        $formattedDate = Carbon::now()->isoFormat('d MMMM Y');

        // =====================================================
        // QUERY PENDIDIKAN & KETERAMPILAN
        // =====================================================

        $queryPendidikan = DB::table('laporan_pendidikan_n_keterampilan')
            ->leftJoin(
                'users_mobile',
                'laporan_pendidikan_n_keterampilan.id_user',
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
                'laporan_pendidikan_n_keterampilan.*',
                'subdistrict.name as nama_kec'
            );

        // =====================================================
        // QUERY PENGEMBANGAN KEHIDUPAN BERKOPERASI
        // =====================================================

        $queryPengembangan = DB::table('laporan_pengembangan_kehidupan')
            ->leftJoin(
                'users_mobile',
                'laporan_pengembangan_kehidupan.id_user',
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
                'laporan_pengembangan_kehidupan.*',
                'subdistrict.name as nama_kec'
            );

        // =====================================================
        // FILTER LOGIN
        // =====================================================

        // =====================================
        // WEB KABUPATEN
        // =====================================

        if (Auth::guard('web')->check()) {

            $queryPendidikan->whereIn(
                'laporan_pendidikan_n_keterampilan.status',
                ['Disetujui2', 'disetujui2', 'DISETUJUI2']
            );

            $queryPengembangan->whereIn(
                'laporan_pengembangan_kehidupan.status',
                ['Disetujui2', 'disetujui2', 'DISETUJUI2']
            );
        }

        // =====================================
        // WEB KECAMATAN
        // =====================================

        elseif (Auth::guard('pengguna')->check()) {

            $user = Auth::guard('pengguna')->user();

            if ($user->id_role == 2) {

                $queryPendidikan
                    ->where('users_mobile.id_subdistrict', $user->id_subdistrict)
                    ->where('users_mobile.id_role', 1)
                    ->whereIn(
                        'laporan_pendidikan_n_keterampilan.status',
                        ['Disetujui1', 'disetujui1', 'DISETUJUI1']
                    );

                $queryPengembangan
                    ->where('users_mobile.id_subdistrict', $user->id_subdistrict)
                    ->where('users_mobile.id_role', 1)
                    ->whereIn(
                        'laporan_pengembangan_kehidupan.status',
                        ['Disetujui1', 'disetujui1', 'DISETUJUI1']
                    );
            }
        }

        // =====================================================
        // FILTER BULAN / TAHUN
        // =====================================================

        if ($tipeCetak == 'perbulan') {

            $queryPendidikan
                ->whereMonth(
                    'laporan_pendidikan_n_keterampilan.created_at',
                    $bulan
                )
                ->whereYear(
                    'laporan_pendidikan_n_keterampilan.created_at',
                    $tahun
                );

            $queryPengembangan
                ->whereMonth(
                    'laporan_pengembangan_kehidupan.created_at',
                    $bulan
                )
                ->whereYear(
                    'laporan_pengembangan_kehidupan.created_at',
                    $tahun
                );
        } else {

            $queryPendidikan
                ->whereYear(
                    'laporan_pendidikan_n_keterampilan.created_at',
                    $tahun
                );

            $queryPengembangan
                ->whereYear(
                    'laporan_pengembangan_kehidupan.created_at',
                    $tahun
                );
        }

        // =====================================================
        // EKSEKUSI QUERY
        // =====================================================

        $pendidikan = $queryPendidikan
            ->orderBy(
                'laporan_pendidikan_n_keterampilan.created_at',
                'desc'
            )
            ->get();

        $pengembangan = $queryPengembangan
            ->orderBy(
                'laporan_pengembangan_kehidupan.created_at',
                'desc'
            )
            ->get();

        // =====================================================
        // DATA TANDA TANGAN
        // =====================================================

        $wakil = DB::table('ttds')
            ->where('pokja', 'Kelompok Kerja II')
            ->where(function ($q) {
                $q->where('jabatan', 'like', '%Wakil%')
                    ->orWhere('jabatan', 'like', '%Sekretaris%');
            })
            ->get();

        $ketua = DB::table('ttds')
            ->where('pokja', 'Kelompok Kerja II')
            ->where('jabatan', 'Ketua')
            ->get();

        // =====================================================
        // VIEW
        // =====================================================

        $viewName = ($tipeCetak == 'perbulan')
            ? 'backend.cetak_bulan_pokja2'
            : 'backend.cetak_tahun_pokja2';

        return view($viewName, compact(
            'pendidikan',
            'pengembangan',
            'wakil',
            'ketua',
            'tanggal',
            'formattedDate',
            'bidang'
        ));
    }
}
