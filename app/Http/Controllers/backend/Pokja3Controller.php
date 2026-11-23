<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\LaporanPokja3;
use App\Models\Pangan;
use App\Models\Pengguna;
use App\Models\Perumahan;
use App\Models\Sandang;
use App\Traits\PokjaReportTrait;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class Pokja3Controller extends Controller
{
    use PokjaReportTrait;

    public function index()
    {
        $modelPertama = 0; // Program Pangan
        $modelKedua = 0;   // Program Sandang
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

            $countSandang = DB::table('laporan_sandang')
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

            $modelPertama = $countPangan + $countSandang;
            $modelKedua = 0;

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
                $statusKecamatan = ['Menunggu', 'menunggu', 'MENUNGGU', 'Proses', 'proses', 'PROSES', 'Disetujui1', 'disetujui1', 'DISETUJUI1'];

                $modelPertama = DB::table('laporan_pangan')
                    ->leftJoin('users_mobile', 'laporan_pangan.id_user', '=', 'users_mobile.id')
                    ->where(function ($q) use ($user) {
                        $q->where('users_mobile.id_subdistrict', $user->id_subdistrict)
                          ->orWhere('laporan_pangan.kecamatan_id', $user->id_subdistrict);
                    })
                    ->where(function ($q) {
                        $q->where('users_mobile.id_role', 1)
                          ->orWhere('laporan_pangan.id_role', 1);
                    })
                    ->whereIn('laporan_pangan.status', $statusKecamatan)
                    ->count();

                $modelKedua = DB::table('laporan_sandang')
                    ->leftJoin('users_mobile', 'laporan_sandang.id_user', '=', 'users_mobile.id')
                    ->where(function ($q) use ($user) {
                        $q->where('users_mobile.id_subdistrict', $user->id_subdistrict)
                          ->orWhere('laporan_sandang.kecamatan_id', $user->id_subdistrict);
                    })
                    ->where(function ($q) {
                        $q->where('users_mobile.id_role', 1)
                          ->orWhere('laporan_sandang.id_role', 1);
                    })
                    ->whereIn('laporan_sandang.status', $statusKecamatan)
                    ->count();

                $countSandang = DB::table('laporan_sandang')
                    ->leftJoin('users_mobile', 'laporan_sandang.id_user', '=', 'users_mobile.id')
                    ->where('users_mobile.id_subdistrict', $user->id_subdistrict)
                    ->where('users_mobile.id_role', 1)
                    ->whereIn('laporan_sandang.status', $statusKecamatan)
                    ->count();

                $modelPertama = $countPangan + $countSandang;
                $modelKedua = 0;

                $modelKetiga = DB::table('laporan_perumahan')
                    ->leftJoin('users_mobile', 'laporan_perumahan.id_user', '=', 'users_mobile.id')
                    ->where('users_mobile.id_subdistrict', $user->id_subdistrict)
                    ->where(function ($q) {
                        $q->where('users_mobile.id_role', 1)
                          ->orWhere('laporan_perumahan.id_role', 1);
                    })
                    ->whereIn('laporan_perumahan.status', $statusKecamatan)
                    ->count();

                $modelKeempat = DB::table('laporan_kader_pokja3')
                    ->leftJoin('users_mobile', 'laporan_kader_pokja3.id_user', '=', 'users_mobile.id')
                    ->where('users_mobile.id_subdistrict', $user->id_subdistrict)
                    ->where(function ($q) {
                        $q->where('users_mobile.id_role', 1)
                          ->orWhere('laporan_kader_pokja3.id_role', 1);
                    })
                    ->whereIn('laporan_kader_pokja3.status', $statusKecamatan)
                    ->count();
            } elseif ($user->id_role == 1) {
                // Sisi Desa: Menghitung total semua laporan milik desa terkait
                $statusDesa = [
                    'Menunggu', 'menunggu', 'MENUNGGU',
                    'Proses', 'proses', 'PROSES',
                    'Disetujui1', 'disetujui1', 'DISETUJUI1',
                    'Disetujui2', 'disetujui2', 'DISETUJUI2'
                ];

                $modelPertama = DB::table('laporan_pangan')
                    ->where('id_user', $user->id)
                    ->whereIn('status', $statusDesa)
                    ->count();

                $modelKedua = DB::table('laporan_sandang')
                    ->where('id_user', $user->id)
                    ->whereIn('status', $statusDesa)
                    ->count();

                $modelKetiga = DB::table('laporan_perumahan')
                    ->where('id_user', $user->id)
                    ->whereIn('status', $statusDesa)
                    ->count();

                $modelKeempat = DB::table('laporan_kader_pokja3')
                    ->where('id_user', $user->id)
                    ->whereIn('status', $statusDesa)
                    ->count();
            }
        }

        return view('backend.pokja3', compact('modelPertama', 'modelKedua', 'modelKetiga', 'modelKeempat'));
    }

    /**
     * Export data dalam format JSON untuk integrasi Google Sheets
     */
    public function getExportData(Request $request)
    {
        $bulan = $request->bulan;
        $tahun = $request->tahun;
        $bidang = $request->bidang;

        $tabel = '';
        if ($bidang == 'pangan') $tabel = 'laporan_pangan';
        elseif ($bidang == 'sandang') $tabel = 'laporan_sandang';
        elseif ($bidang == 'perumahan') $tabel = 'laporan_perumahan';
        elseif ($bidang == 'kader') $tabel = 'laporan_kader_pokja3';
        else return response()->json(['status' => 'error', 'message' => 'Bidang tidak valid.']);

        try {
            $query = $this->buildReportQuery($tabel);

            if (Auth::guard('web')->check()) {
                $statusAdmin = ['Disetujui1', 'disetujui1', 'DISETUJUI1', 'Disetujui2', 'disetujui2', 'DISETUJUI2'];
                $query->whereIn("{$tabel}.status", $statusAdmin);
            } elseif (Auth::guard('pengguna')->check()) {
                $user = Auth::guard('pengguna')->user();
                if ($user->id_role == 2) {
                    $statusKecamatan = ['Proses', 'proses', 'PROSES', 'Disetujui1', 'disetujui1', 'DISETUJUI1'];
                    $query->whereIn("{$tabel}.status", $statusKecamatan)
                        ->where(function ($q) use ($tabel, $user) {
                            $q->where('users_mobile.id_subdistrict', $user->id_subdistrict)
                              ->orWhere("{$tabel}.kecamatan_id", $user->id_subdistrict);
                        });
                } else {
                    $query->where("{$tabel}.id_user", $user->id);
                }
            }

            if (!empty($bulan)) $query->whereMonth("{$tabel}.created_at", $bulan);
            if (!empty($tahun)) $query->whereYear("{$tabel}.created_at", $tahun);

            $data = $query->get();

            if ($data->isEmpty()) {
                return response()->json(['status' => 'empty', 'message' => 'Tidak ada data laporan yang valid pada periode tersebut.']);
            }

            $no = 1;
            $data = $data->map(function ($item) use (&$no, $bidang) {
                $row = [
                    'No' => $no++,
                    'Tanggal Laporan' => !empty($item->created_at) ? date('d-m-Y', strtotime($item->created_at)) : '-',
                    'Kecamatan' => !empty($item->nama_kec) ? ucwords(strtolower($item->nama_kec)) : '-',
                    'Desa / Kelurahan' => !empty($item->nama_desa) ? ucwords(strtolower($item->nama_desa)) : '-',
                ];

                if ($bidang == 'pangan') {
                    $row['Kader Pangan']    = $item->kader_pangan ?? 0;
                    $row['Beras']           = $item->beras ?? 0;
                    $row['Non Beras']       = $item->non_beras ?? 0;
                    $row['Peternakan']      = $item->peternakan ?? 0;
                    $row['Perikanan']       = $item->perikanan ?? 0;
                    $row['Warung Hidup']    = $item->warung_hidup ?? 0;
                    $row['Lumbung Hidup']   = $item->lumbung_hidup ?? 0;
                    $row['TOGA']            = $item->toga ?? 0;
                    $row['Tanaman Keras']   = $item->tanaman_keras ?? 0;
                    $row['Tanaman Lainnya'] = $item->tanaman_lainnya ?? 0;
                } elseif ($bidang == 'sandang') {
                    $row['Kader Sandang']   = $item->kader_sandang ?? 0;
                    $row['IRT Pangan']      = $item->industri_pangan ?? $item->pangan ?? 0;
                    $row['IRT Sandang']     = $item->industri_sandang ?? $item->sandang ?? 0;
                    $row['Jasa']            = $item->jasa ?? 0;
                } elseif ($bidang == 'perumahan') {
                    $row['Layak Huni']       = $item->layak_huni ?? 0;
                    $row['Tidak Layak Huni'] = $item->tidak_layak ?? 0;
                } elseif ($bidang == 'kader') {
                    $row['Kader Pangan']                 = $item->pangan ?? 0;
                    $row['Kader Sandang']                = $item->sandang ?? 0;
                    $row['Kader Tata Laksana RT']        = $item->tata_laksana_rumah ?? 0;
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
            $no = 1;
            $data = $data->map(function ($item) use (&$no, $bidang) {
                $row = [
                    'No' => $no++,
                    'Tanggal Laporan' => !empty($item->created_at) ? date('d-m-Y', strtotime($item->created_at)) : '-',
                    'Kecamatan' => !empty($item->nama_kecamatan) ? ucwords(strtolower($item->nama_kecamatan)) : '-',
                    'Desa / Kelurahan' => !empty($item->nama_desa) ? ucwords(strtolower($item->nama_desa)) : '-',
                ];

                if ($bidang == 'pangan') {
                    $row['Beras'] = $item->beras ?? 0;
                    $row['Non Beras'] = $item->non_beras ?? 0;
                    $row['Peternakan'] = $item->peternakan ?? 0;
                    $row['Perikanan'] = $item->perikanan ?? 0;
                    $row['Warung Hidup'] = $item->warung_hidup ?? 0;
                    $row['Lumbung Hidup'] = $item->lumbung_hidup ?? 0;
                    $row['Toga'] = $item->toga ?? 0;
                    $row['Tanaman Keras'] = $item->tanaman_keras ?? 0;
                    $row['Tanaman Lainnya'] = $item->tanaman_lainnya ?? 0;
                } elseif ($bidang == 'sandang') {
                    $row['Pangan'] = $item->pangan ?? 0;
                    $row['Sandang'] = $item->sandang ?? 0;
                    $row['Jasa'] = $item->jasa ?? 0;
                } elseif ($bidang == 'perumahan') {
                    $row['Layak Huni'] = $item->layak_huni ?? 0;
                    $row['Tidak Layak Huni'] = $item->tidak_layak ?? 0;
                } elseif ($bidang == 'kader') {
                    $row['Kader Pangan'] = $item->pangan ?? 0;
                    $row['Kader Sandang'] = $item->sandang ?? 0;
                    $row['Kader Tata Laksana Rumah Tangga'] = $item->tata_laksana_rumah ?? 0;
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

    /**
     * Cetak Laporan PDF / Print Pokja 3
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

        $formattedDate = Carbon::now()->isoFormat('D MMMM Y');

        $tabelPangan    = 'laporan_pangan';
        $tabelSandang   = 'laporan_sandang';
        $tabelPerumahan = 'laporan_perumahan';
        $tabelKader     = 'laporan_kader_pokja3';

        $queryPangan    = $this->buildReportQuery($tabelPangan);
        $querySandang   = $this->buildReportQuery($tabelSandang);
        $queryPerumahan = $this->buildReportQuery($tabelPerumahan);
        $queryKader     = $this->buildReportQuery($tabelKader);

        // Filter status persetujuan
        if (Auth::guard('web')->check()) {
            $queryPangan->whereIn("{$tabelPangan}.status", ['Disetujui2', 'disetujui2', 'DISETUJUI2']);
            $querySandang->whereIn("{$tabelSandang}.status", ['Disetujui2', 'disetujui2', 'DISETUJUI2']);
            $queryPerumahan->whereIn("{$tabelPerumahan}.status", ['Disetujui2', 'disetujui2', 'DISETUJUI2']);
            $queryKader->whereIn("{$tabelKader}.status", ['Disetujui2', 'disetujui2', 'DISETUJUI2']);
        } elseif (Auth::guard('pengguna')->check()) {
            $user = Auth::guard('pengguna')->user();
            if ($user->id_role == 2) {
                $statusKec = ['Disetujui1', 'disetujui1', 'DISETUJUI1', 'Disetujui2', 'disetujui2', 'DISETUJUI2'];
                $queryPangan->where(function ($q) use ($tabelPangan, $user) {
                    $q->where('users_mobile.id_subdistrict', $user->id_subdistrict)
                      ->orWhere("{$tabelPangan}.kecamatan_id", $user->id_subdistrict);
                })->whereIn("{$tabelPangan}.status", $statusKec);

                $querySandang->where(function ($q) use ($tabelSandang, $user) {
                    $q->where('users_mobile.id_subdistrict', $user->id_subdistrict)
                      ->orWhere("{$tabelSandang}.kecamatan_id", $user->id_subdistrict);
                })->whereIn("{$tabelSandang}.status", $statusKec);

                $queryPerumahan->where('users_mobile.id_subdistrict', $user->id_subdistrict)
                    ->whereIn("{$tabelPerumahan}.status", $statusKec);

                $queryKader->where('users_mobile.id_subdistrict', $user->id_subdistrict)
                    ->whereIn("{$tabelKader}.status", $statusKec);
            }
        }

        // Filter periode
        if ($tipeCetak == 'perbulan') {
            $queryPangan->whereMonth("{$tabelPangan}.created_at", $bulan)->whereYear("{$tabelPangan}.created_at", $tahun);
            $querySandang->whereMonth("{$tabelSandang}.created_at", $bulan)->whereYear("{$tabelSandang}.created_at", $tahun);
            $queryPerumahan->whereMonth("{$tabelPerumahan}.created_at", $bulan)->whereYear("{$tabelPerumahan}.created_at", $tahun);
            $queryKader->whereMonth("{$tabelKader}.created_at", $bulan)->whereYear("{$tabelKader}.created_at", $tahun);
        } else {
            $queryPangan->whereYear("{$tabelPangan}.created_at", $tahun);
            $querySandang->whereYear("{$tabelSandang}.created_at", $tahun);
            $queryPerumahan->whereYear("{$tabelPerumahan}.created_at", $tahun);
            $queryKader->whereYear("{$tabelKader}.created_at", $tahun);
        }

        $pangan         = $queryPangan->orderBy("{$tabelPangan}.created_at", 'desc')->get();
        $sandang        = $querySandang->orderBy("{$tabelSandang}.created_at", 'desc')->get();
        $perumahan      = $queryPerumahan->orderBy("{$tabelPerumahan}.created_at", 'desc')->get();
        $laporanpokja3  = $queryKader->orderBy("{$tabelKader}.created_at", 'desc')->get();

        // Rekap per Kecamatan (GROUP BY kecamatan untuk laporan berstatus Disetujui)
        $rekapPanganKecamatan = $pangan->groupBy(fn($item) => $item->nama_kec ?: 'Lainnya')->map(function ($items, $kec) {
            return [
                'nama_kecamatan'  => $kec,
                'total_kader'     => $items->sum('kader_pangan'),
                'total_beras'     => $items->sum('beras'),
                'total_non_beras' => $items->sum('non_beras'),
                'total_ternak'    => $items->sum('peternakan'),
                'total_ikan'      => $items->sum('perikanan'),
                'total_warung'    => $items->sum('warung_hidup'),
                'total_lumbung'   => $items->sum('lumbung_hidup'),
                'total_toga'      => $items->sum('toga'),
                'total_keras'     => $items->sum('tanaman_keras'),
                'total_lainnya'   => $items->sum('tanaman_lainnya'),
            ];
        });

        $rekapSandangKecamatan = $sandang->groupBy(fn($item) => $item->nama_kec ?: 'Lainnya')->map(function ($items, $kec) {
            return [
                'nama_kecamatan'  => $kec,
                'total_kader'     => $items->sum('kader_sandang'),
                'total_pangan'    => $items->sum(fn($i) => $i->industri_pangan ?? $i->pangan ?? 0),
                'total_sandang'   => $items->sum(fn($i) => $i->industri_sandang ?? $i->sandang ?? 0),
                'total_jasa'      => $items->sum('jasa'),
            ];
        });

        $wakil = DB::table('ttds')
            ->where('pokja', 'Kelompok Kerja III')
            ->where(function ($q) {
                $q->where('jabatan', 'like', '%Wakil%')
                    ->orWhere('jabatan', 'like', '%Sekretaris%');
            })->get();

        $ketua = DB::table('ttds')
            ->where('pokja', 'Kelompok Kerja III')
            ->where('jabatan', 'Ketua')
            ->get();

        $viewName = ($tipeCetak == 'perbulan')
            ? 'backend.cetak_bulan_pokja3'
            : 'backend.cetak_tahun_pokja3';

        return view($viewName, compact(
            'pangan',
            'sandang',
            'perumahan',
            'laporanpokja3',
            'rekapPanganKecamatan',
            'rekapSandangKecamatan',
            'wakil',
            'ketua',
            'tanggal',
            'formattedDate',
            'bidang'
        ));
    }

    /**
     * Export Excel Resmi (Dua Sheet atau Dua File)
     */
    public function exportExcel(Request $request)
    {
        $bidang = $request->input('bidang', 'semua');
        $tahun  = $request->input('tahun', date('Y'));
        $bulan  = $request->input('bulan');

        $queryPangan  = $this->buildReportQuery('laporan_pangan')->whereYear('laporan_pangan.created_at', $tahun);
        $querySandang = $this->buildReportQuery('laporan_sandang')->whereYear('laporan_sandang.created_at', $tahun);

        if (!empty($bulan)) {
            $queryPangan->whereMonth('laporan_pangan.created_at', $bulan);
            $querySandang->whereMonth('laporan_sandang.created_at', $bulan);
        }

        // Hanya dari laporan berstatus disetujui
        $statusApproved = ['Disetujui1', 'disetujui1', 'DISETUJUI1', 'Disetujui2', 'disetujui2', 'DISETUJUI2'];
        $panganData = $queryPangan->whereIn('laporan_pangan.status', $statusApproved)->orderBy('laporan_pangan.created_at', 'asc')->get();
        $sandangData = $querySandang->whereIn('laporan_sandang.status', $statusApproved)->orderBy('laporan_sandang.created_at', 'asc')->get();

        $periodeText = $bulan ? "Bulan {$bulan} Tahun {$tahun}" : "Tahun {$tahun}";

        // Format Spreadsheet XML (Mendukung Multi-Sheet di Excel)
        $filename = "Laporan_Pokja3_{$bidang}_{$tahun}.xls";

        return response()->view('backend.export_excel_pokja3', [
            'bidang'      => $bidang,
            'panganData'  => $panganData,
            'sandangData' => $sandangData,
            'periodeText' => $periodeText,
        ], 200, [
            'Content-Type'        => 'application/vnd.ms-excel; charset=UTF-8',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
            'Cache-Control'       => 'max-age=0',
        ]);
    }
}
