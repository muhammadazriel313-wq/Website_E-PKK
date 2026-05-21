<?php

namespace App\Http\Controllers\backend;

use App\Models\Ttd;
use App\Models\Ttds;
use App\Models\Galeri;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;
use App\Http\Controllers\Controller;

class Galeri3Controller extends Controller
{
    public function index()
    {
        $pertama = 0;
        $kedua = 0;
        $ketiga = 0;
        $keempat = 0;

        // =====================================
        // WEB KABUPATEN
        // =====================================
        if (Auth::guard('web')->check()) {
            $pertama = Galeri::leftJoin('users_mobile', 'galerys.id_user', '=', 'users_mobile.id')->where('galerys.bidang', 'Program Pangan')->where(function ($query) {
                $query->where(function ($q) {
                    $q->where('users_mobile.id_role', 1)->whereIn('galerys.status', ['upload1', 'upload2']);
                })
                    ->orWhere(function ($q) {
                        $q->where('users_mobile.id_role', 2)->whereIn('galerys.status', ['Proses', 'upload2']);
                    });
            })->count();

            $kedua = Galeri::leftJoin('users_mobile', 'galerys.id_user', '=', 'users_mobile.id')->where('galerys.bidang', 'Program Sandang')->where(function ($query) {
                $query->where(function ($q) {
                    $q->where('users_mobile.id_role', 1)->whereIn('galerys.status', ['upload1', 'upload2']);
                })
                    ->orWhere(function ($q) {
                        $q->where('users_mobile.id_role', 2)->whereIn('galerys.status', ['Proses', 'upload2']);
                    });
            })->count();

            $ketiga = Galeri::leftJoin('users_mobile', 'galerys.id_user', '=', 'users_mobile.id')->where('galerys.bidang', 'Program Perumahan & Tata Laksana Rumah Tangga')->where(function ($query) {
                $query->where(function ($q) {
                    $q->where('users_mobile.id_role', 1)->whereIn('galerys.status', ['upload1', 'upload2']);
                })
                    ->orWhere(function ($q) {
                        $q->where('users_mobile.id_role', 2)->whereIn('galerys.status', ['Proses', 'upload2']);
                    });
            })->count();

            $keempat = Galeri::leftJoin('users_mobile', 'galerys.id_user', '=', 'users_mobile.id')->where('galerys.bidang', 'Kader Pokja III')->where(function ($query) {
                $query->where(function ($q) {
                    $q->where('users_mobile.id_role', 1)->whereIn('galerys.status', ['upload1', 'upload2']);
                })
                    ->orWhere(function ($q) {
                        $q->where('users_mobile.id_role', 2)->whereIn('galerys.status', ['Proses', 'upload2']);
                    });
            })->count();
        }
        // =====================================
        // WEB KECAMATAN
        // =====================================
        elseif (Auth::guard('pengguna')->check()) {
            $user = Auth::guard('pengguna')->user();

            if ($user->id_role == 2) {
                $pertama = Galeri::leftJoin('users_mobile', 'galerys.id_user', '=', 'users_mobile.id')->where('galerys.bidang', 'Program Pangan')->where('users_mobile.id_role', 1)->where('users_mobile.id_subdistrict', $user->id_subdistrict)->whereIn('galerys.status', ['Proses', 'upload1', 'upload2'])->count();
                $kedua = Galeri::leftJoin('users_mobile', 'galerys.id_user', '=', 'users_mobile.id')->where('galerys.bidang', 'Program Sandang')->where('users_mobile.id_role', 1)->where('users_mobile.id_subdistrict', $user->id_subdistrict)->whereIn('galerys.status', ['Proses', 'upload1', 'upload2'])->count();
                $ketiga = Galeri::leftJoin('users_mobile', 'galerys.id_user', '=', 'users_mobile.id')->where('galerys.bidang', 'Program Perumahan & Tata Laksana Rumah Tangga')->where('users_mobile.id_role', 1)->where('users_mobile.id_subdistrict', $user->id_subdistrict)->whereIn('galerys.status', ['Proses', 'upload1', 'upload2'])->count();
                $keempat = Galeri::leftJoin('users_mobile', 'galerys.id_user', '=', 'users_mobile.id')->where('galerys.bidang', 'Kader Pokja III')->where('users_mobile.id_role', 1)->where('users_mobile.id_subdistrict', $user->id_subdistrict)->whereIn('galerys.status', ['Proses', 'upload1', 'upload2'])->count();
            }
        }

        return view('backend.galeripokja3', compact('pertama', 'kedua', 'ketiga', 'keempat'));
    }

    // FUNGSI PENGALIHAN AGAR AMAN
    public function filter(Request $request)
    {
        return $this->cetak($request);
    }

    public function show(Request $request, string $id)
    {
        if ($request->has('search') || $request->has('search2')) {
            return $this->cetak($request);
        }
        return redirect()->route('galeripokja3.index');
    }

    /*
    |--------------------------------------------------------------------------
    | FUNGSI CETAK GALERI POKJA 3
    |--------------------------------------------------------------------------
    */
    public function cetak(Request $request)
    {
        // =====================================
        // TANGKAP INPUT
        // =====================================

        $tipeCetak = $request->input(
            'tipe_cetak',
            ($request->filled('search') ? 'perbulan' : 'tahunan')
        );

        $bulan = $request->input(
            'search',
            $request->input('bulan')
        );

        $tahun = $request->input(
            'search2',
            $request->input('tahun', date('Y'))
        );

        // =====================================================
        // QUERY DASAR
        // =====================================================

        $query = Galeri::leftJoin(
            'users_mobile',
            'galerys.id_user',
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
                'galerys.*',
                'subdistrict.name as nama_kec'
            )
            ->whereIn('galerys.pokja', [
                'Kader Pokja III',
                'Kelompok Kerja III'
            ]);

        // =====================================================
        // FILTER LOGIN
        // =====================================================

        // =====================================
        // WEB KABUPATEN
        // =====================================

        if (Auth::guard('web')->check()) {

            $query->whereIn(
                'galerys.status',
                [
                    'upload2',
                    'UPLOAD2',
                    'Upload2'
                ]
            );
        }

        // =====================================
        // WEB KECAMATAN
        // =====================================

        elseif (Auth::guard('pengguna')->check()) {

            $user = Auth::guard('pengguna')->user();

            if ($user->id_role == 2) {

                $query->where(
                    'users_mobile.id_subdistrict',
                    $user->id_subdistrict
                )
                    ->where('galerys.id_role', 1)
                    ->whereIn(
                        'galerys.status',
                        [
                            'upload1',
                            'UPLOAD1',
                            'Upload1'
                        ]
                    );
            }
        }

        // =====================================
        // TANDA TANGAN
        // =====================================

        $ketua = Ttd::where('jabatan', 'Ketua')
            ->where('pokja', 'Kelompok Kerja III')
            ->get();

        $wakil = Ttds::where('jabatan', 'Wakil Ketua I')->get();

        // =====================================
        // NAMA BULAN
        // =====================================

        $namaBulan = [

            1 => 'Januari',
            2 => 'Februari',
            3 => 'Maret',
            4 => 'April',
            5 => 'Mei',
            6 => 'Juni',
            7 => 'Juli',
            8 => 'Agustus',
            9 => 'September',
            10 => 'Oktober',
            11 => 'November',
            12 => 'Desember',

            '01' => 'Januari',
            '02' => 'Februari',
            '03' => 'Maret',
            '04' => 'April',
            '05' => 'Mei',
            '06' => 'Juni',
            '07' => 'Juli',
            '08' => 'Agustus',
            '09' => 'September',
            '10' => 'Oktober',
            '11' => 'November',
            '12' => 'Desember'

        ];

        // =====================================
        // CETAK PERBULAN
        // =====================================

        if ($tipeCetak == 'perbulan') {

            if ($bulan) {

                $query->whereMonth('galerys.created_at', $bulan)
                    ->whereYear('galerys.created_at', $tahun);
            }

            $allData = $query
                ->orderBy('galerys.created_at', 'ASC')
                ->get();

            // =====================================
            // FILTER BIDANG POKJA 3
            // =====================================

            $pangan = $allData->filter(function ($item) {

                return str_contains(
                    strtolower($item->bidang),
                    'pangan'
                );
            });

            $sandang = $allData->filter(function ($item) {

                return str_contains(
                    strtolower($item->bidang),
                    'sandang'
                );
            });

            $perumahan = $allData->filter(function ($item) {

                return str_contains(
                    strtolower($item->bidang),
                    'perumahan'
                );
            });

            $laporanpokja3 = $allData->filter(function ($item) {

                return in_array(
                    strtolower($item->bidang),
                    [
                        'kader pokja 3',
                        'kader pokja iii'
                    ]
                );
            });

            // =====================================
            // VARIABEL DUPLIKAT
            // =====================================

            $pangan1 = $pangan;
            $sandang1 = $sandang;
            $perumahan1 = $perumahan;
            $laporanpokja31 = $laporanpokja3;

            // =====================================
            // DATA VIEW
            // =====================================

            $tanggal = $namaBulan[$bulan] ?? 'Bulan Tidak Dikenali';
            $tanggal2 = $tahun;

            return view(
                'backend.cetak_galeri_bulan_pokja3',
                compact(
                    'pangan',
                    'sandang',
                    'perumahan',
                    'laporanpokja3',

                    'pangan1',
                    'sandang1',
                    'perumahan1',
                    'laporanpokja31',

                    'tanggal',
                    'tanggal2',

                    'ketua',
                    'wakil'
                )
            );
        }

        // =====================================
        // CETAK TAHUNAN
        // =====================================

        else {

            $query->whereYear('galerys.created_at', $tahun);

            $allData = $query
                ->orderBy('galerys.created_at', 'ASC')
                ->get();

            // =====================================
            // FILTER PER BULAN
            // =====================================

            $jan = $allData->filter(
                fn($item) =>
                \Carbon\Carbon::parse($item->created_at)->month == 1
            );

            $feb = $allData->filter(
                fn($item) =>
                \Carbon\Carbon::parse($item->created_at)->month == 2
            );

            $mar = $allData->filter(
                fn($item) =>
                \Carbon\Carbon::parse($item->created_at)->month == 3
            );

            $apr = $allData->filter(
                fn($item) =>
                \Carbon\Carbon::parse($item->created_at)->month == 4
            );

            $mei = $allData->filter(
                fn($item) =>
                \Carbon\Carbon::parse($item->created_at)->month == 5
            );

            $jun = $allData->filter(
                fn($item) =>
                \Carbon\Carbon::parse($item->created_at)->month == 6
            );

            $jul = $allData->filter(
                fn($item) =>
                \Carbon\Carbon::parse($item->created_at)->month == 7
            );

            $agu = $allData->filter(
                fn($item) =>
                \Carbon\Carbon::parse($item->created_at)->month == 8
            );

            $sep = $allData->filter(
                fn($item) =>
                \Carbon\Carbon::parse($item->created_at)->month == 9
            );

            $okt = $allData->filter(
                fn($item) =>
                \Carbon\Carbon::parse($item->created_at)->month == 10
            );

            $nov = $allData->filter(
                fn($item) =>
                \Carbon\Carbon::parse($item->created_at)->month == 11
            );

            $des = $allData->filter(
                fn($item) =>
                \Carbon\Carbon::parse($item->created_at)->month == 12
            );

            // =====================================
            // DATA VIEW
            // =====================================

            $tanggal = $tahun;
            $tanggal2 = $tahun;

            return view(
                'backend.cetak_galeri_tahun_pokja3',
                compact(
                    'jan',
                    'feb',
                    'mar',
                    'apr',
                    'mei',
                    'jun',
                    'jul',
                    'agu',
                    'sep',
                    'okt',
                    'nov',
                    'des',

                    'tanggal',
                    'tanggal2',

                    'ketua',
                    'wakil'
                )
            );
        }
    }
}
