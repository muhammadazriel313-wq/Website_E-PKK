<?php

namespace App\Http\Controllers\backend;

use App\Models\Galeri;
use App\Models\Ttd;
use App\Models\Ttds;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class Galeri1Controller extends Controller
{
    public function index()
    {
        $pertama = 0;
        $kedua = 0;
        $ketiga = 0;

        // =====================================
        // WEB KABUPATEN
        // =====================================
        if (Auth::guard('web')->check()) {

            $pertama = Galeri::leftJoin('users_mobile', 'galerys.id_user', '=', 'users_mobile.id')
                ->where('galerys.bidang', 'Penghayatan & Pengamalan Pancasila')
                ->where(function ($query) {
                    $query->where(function ($q) {
                        $q->where('users_mobile.id_role', 1)
                            ->whereIn('galerys.status', ['upload1', 'upload2']);
                    })
                        ->orWhere(function ($q) {
                            $q->where('users_mobile.id_role', 2)
                                ->whereIn('galerys.status', ['Proses', 'upload2']);
                        });
                })
                ->count();

            $kedua = Galeri::leftJoin('users_mobile', 'galerys.id_user', '=', 'users_mobile.id')
                ->where('galerys.bidang', 'Gotong Royong')
                ->where(function ($query) {
                    $query->where(function ($q) {
                        $q->where('users_mobile.id_role', 1)
                            ->whereIn('galerys.status', ['upload1', 'upload2']);
                    })
                        ->orWhere(function ($q) {
                            $q->where('users_mobile.id_role', 2)
                                ->whereIn('galerys.status', ['Proses', 'upload2']);
                        });
                })
                ->count();

            $ketiga = Galeri::leftJoin('users_mobile', 'galerys.id_user', '=', 'users_mobile.id')
                ->where('galerys.bidang', 'Kader Pokja I')
                ->where(function ($query) {
                    $query->where(function ($q) {
                        $q->where('users_mobile.id_role', 1)
                            ->whereIn('galerys.status', ['upload1', 'upload2']);
                    })
                        ->orWhere(function ($q) {
                            $q->where('users_mobile.id_role', 2)
                                ->whereIn('galerys.status', ['Proses', 'upload2']);
                        });
                })
                ->count();
        }
        // =====================================
        // WEB KECAMATAN
        // =====================================
        elseif (Auth::guard('pengguna')->check()) {

            $user = Auth::guard('pengguna')->user();

            if ($user->id_role == 2) {

                $pertama = Galeri::leftJoin('users_mobile', 'galerys.id_user', '=', 'users_mobile.id')
                    ->where('galerys.bidang', 'Penghayatan & Pengamalan Pancasila')
                    ->where('users_mobile.id_role', 1)
                    ->where('users_mobile.id_subdistrict', $user->id_subdistrict)
                    ->whereIn('galerys.status', ['Proses', 'upload1', 'upload2'])
                    ->count();

                $kedua = Galeri::leftJoin('users_mobile', 'galerys.id_user', '=', 'users_mobile.id')
                    ->where('galerys.bidang', 'Gotong Royong')
                    ->where('users_mobile.id_role', 1)
                    ->where('users_mobile.id_subdistrict', $user->id_subdistrict)
                    ->whereIn('galerys.status', ['Proses', 'upload1', 'upload2'])
                    ->count();

                $ketiga = Galeri::leftJoin('users_mobile', 'galerys.id_user', '=', 'users_mobile.id')
                    ->where('galerys.bidang', 'Kader Pokja I')
                    ->where('users_mobile.id_role', 1)
                    ->where('users_mobile.id_subdistrict', $user->id_subdistrict)
                    ->whereIn('galerys.status', ['Proses', 'upload1', 'upload2'])
                    ->count();
            }
        }

        return view('backend.galeripokja1', compact('pertama', 'kedua', 'ketiga'));
    }

    public function filter(Request $request)
    {
        return $this->cetak($request);
    }

    public function show(Request $request, string $id)
    {
        // PENTING: Semua request dari URL filter lama dialihkan ke fungsi cetak()
        // agar tidak ada lagi masalah "Bulan Tidak Dikenali"
        return $this->cetak($request);
    }

    public function cetak(Request $request)
{
    // =====================================================
    // AMBIL INPUT
    // =====================================================

    $bulan = $request->input('search', $request->input('bulan'));
    $tahun = $request->input('search2', $request->input('tahun', date('Y')));

    // =====================================================
    // DETEKSI TIPE CETAK
    // =====================================================

    if ($request->filled('tipe_cetak')) {

        $tipeCetak = $request->input('tipe_cetak');

    } else {

        $tipeCetak = $request->filled('search')
            ? 'perbulan'
            : 'tahunan';
    }

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
        ->where('galerys.pokja', 'Kader Pokja I');

    // =====================================================
    // FILTER LOGIN
    // =====================================================

    // =====================================
    // WEB KABUPATEN
    // =====================================

    if (Auth::guard('web')->check()) {

        $query->whereIn(
            'galerys.status',
            ['upload2', 'UPLOAD2']
        );
    }

    // =====================================
    // WEB KECAMATAN
    // =====================================

    elseif (Auth::guard('pengguna')->check()) {

        $user = Auth::guard('pengguna')->user();

        if ($user->id_role == 2) {

            $query->where('users_mobile.id_subdistrict', $user->id_subdistrict)
                ->where('galerys.id_role', 1)
                ->whereIn(
                    'galerys.status',
                    ['upload1', 'UPLOAD1']
                );
        }
    }

    // =====================================================
    // TANDA TANGAN
    // =====================================================

    $ketua = DB::table('ttds')
        ->where('pokja', 'Kelompok Kerja I')
        ->where('jabatan', 'Ketua')
        ->get();

    $wakil = DB::table('ttds')
        ->where(function ($q) {
            $q->where('jabatan', 'like', '%Wakil%')
                ->orWhere('jabatan', 'like', '%Sekretaris%');
        })
        ->where('pokja', 'Kelompok Kerja I')
        ->get();

    $tanggal2 = $tahun;

    // =====================================================
    // NAMA BULAN
    // =====================================================

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

    // =====================================================
    // CETAK PER BULAN
    // =====================================================

    if ($tipeCetak == 'perbulan') {

        if ($bulan) {

            $query->whereMonth('galerys.created_at', $bulan)
                ->whereYear('galerys.created_at', $tahun);
        }

        $allData = $query
            ->orderBy('galerys.created_at', 'ASC')
            ->get();

        $penghayatan = $allData->where(
            'bidang',
            'Penghayatan & Pengamalan Pancasila'
        );

        $gotong = $allData->where(
            'bidang',
            'Gotong Royong'
        );

        $kader = $allData->where(
            'bidang',
            'Kader Pokja I'
        );

        $penghayatan1 = $penghayatan;
        $gotong1 = $gotong;
        $kader1 = $kader;

        $tanggal = $namaBulan[$bulan] ?? 'Bulan Tidak Dikenali';

        return view(
            'backend.cetak_galeri_bulan_pokja1',
            compact(
                'penghayatan',
                'gotong',
                'kader',
                'tanggal',
                'tanggal2',
                'penghayatan1',
                'gotong1',
                'kader1',
                'ketua',
                'wakil'
            )
        );
    }

    // =====================================================
    // CETAK TAHUNAN
    // =====================================================

    $query->whereYear('galerys.created_at', $tahun);

    $allData = $query
        ->orderBy('galerys.created_at', 'ASC')
        ->get();

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

    $tanggal = $tahun;

    return view(
        'backend.cetak_galeri_tahun_pokja1',
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