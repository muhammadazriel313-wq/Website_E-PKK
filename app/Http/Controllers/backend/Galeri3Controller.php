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
        $pertama = 0; $kedua = 0; $ketiga = 0; $keempat = 0;

        // =====================================
        // WEB KABUPATEN
        // =====================================
        if (Auth::guard('web')->check()) {
            $pertama = Galeri::leftJoin('users_mobile', 'galerys.id_user', '=', 'users_mobile.id')->where('galerys.bidang', 'Program Pangan')->where(function ($query) {
                $query->where(function ($q) { $q->where('users_mobile.id_role', 1)->whereIn('galerys.status', ['upload1', 'upload2']); })
                      ->orWhere(function ($q) { $q->where('users_mobile.id_role', 2)->whereIn('galerys.status', ['Proses', 'upload2']); });
            })->count();

            $kedua = Galeri::leftJoin('users_mobile', 'galerys.id_user', '=', 'users_mobile.id')->where('galerys.bidang', 'Program Sandang')->where(function ($query) {
                $query->where(function ($q) { $q->where('users_mobile.id_role', 1)->whereIn('galerys.status', ['upload1', 'upload2']); })
                      ->orWhere(function ($q) { $q->where('users_mobile.id_role', 2)->whereIn('galerys.status', ['Proses', 'upload2']); });
            })->count();

            $ketiga = Galeri::leftJoin('users_mobile', 'galerys.id_user', '=', 'users_mobile.id')->where('galerys.bidang', 'Program Perumahan & Tata Laksana Rumah Tangga')->where(function ($query) {
                $query->where(function ($q) { $q->where('users_mobile.id_role', 1)->whereIn('galerys.status', ['upload1', 'upload2']); })
                      ->orWhere(function ($q) { $q->where('users_mobile.id_role', 2)->whereIn('galerys.status', ['Proses', 'upload2']); });
            })->count();

            $keempat = Galeri::leftJoin('users_mobile', 'galerys.id_user', '=', 'users_mobile.id')->where('galerys.bidang', 'Kader Pokja III')->where(function ($query) {
                $query->where(function ($q) { $q->where('users_mobile.id_role', 1)->whereIn('galerys.status', ['upload1', 'upload2']); })
                      ->orWhere(function ($q) { $q->where('users_mobile.id_role', 2)->whereIn('galerys.status', ['Proses', 'upload2']); });
            })->count();
        }
        // =====================================
        // WEB KECAMATAN
        // =====================================
        elseif (Auth::guard('pengguna')->check()) {
            $user = Auth::guard('pengguna')->user();

            if ($user->id_role == 2) {
                $pertama = Galeri::leftJoin('users_mobile', 'galerys.id_user', '=', 'users_mobile.id')->where('galerys.bidang', 'Program Pangan')->where('users_mobile.id_role', 1)->where('users_mobile.id_subdistrict', $user->id_subdistrict)->whereIn('galerys.status', ['Proses', 'upload1', 'upload2'])->count();
                $kedua = Galeri::leftJoin('users_mobile', 'galerys.id_user', '=', 'users_mobile.id')->where('galerys.bidang','Program Sandang')->where('users_mobile.id_role', 1)->where('users_mobile.id_subdistrict', $user->id_subdistrict)->whereIn('galerys.status', ['Proses', 'upload1', 'upload2'])->count();
                $ketiga = Galeri::leftJoin('users_mobile', 'galerys.id_user', '=', 'users_mobile.id')->where('galerys.bidang','Program Perumahan & Tata Laksana Rumah Tangga')->where('users_mobile.id_role', 1)->where('users_mobile.id_subdistrict', $user->id_subdistrict)->whereIn('galerys.status', ['Proses', 'upload1', 'upload2'])->count();
                $keempat = Galeri::leftJoin('users_mobile', 'galerys.id_user', '=', 'users_mobile.id')->where('galerys.bidang','Kader Pokja III')->where('users_mobile.id_role', 1)->where('users_mobile.id_subdistrict', $user->id_subdistrict)->whereIn('galerys.status', ['Proses', 'upload1', 'upload2'])->count();
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
        if($request->has('search') || $request->has('search2')){
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
        // Tangkap input (mendukung form modal)
        $tipeCetak = $request->input('tipe_cetak', ($request->filled('search') ? 'perbulan' : 'tahunan')); 
        $bulan = $request->input('search', $request->input('bulan')); 
        $tahun = $request->input('search2', $request->input('tahun', date('Y')));

        // 🚨 BUG FIX: Diubah dari 'pokja I' menjadi 'pokja III'
        $query = Galeri::where('pokja', 'pokja III')->where('status', 'Upload'); 

        // Filter Role (Kecamatan / Kabupaten)
        if (Auth::guard('pengguna')->check()) {
            $user = Auth::guard('pengguna')->user();
            $query->where('id_user', $user->id);
        }

        // Tanda Tangan
        $ketua = Ttd::where('jabatan', 'Ketua')->where('pokja', 'Kelompok Kerja III')->get();
        $wakil = Ttds::where('jabatan', 'Wakil Ketua I')->get();

        $namaBulan = [
            1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
            5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
            9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember',
            '01' => 'Januari', '02' => 'Februari', '03' => 'Maret', '04' => 'April',
            '05' => 'Mei', '06' => 'Juni', '07' => 'Juli', '08' => 'Agustus',
            '09' => 'September', '10' => 'Oktober', '11' => 'November', '12' => 'Desember'
        ];

        // =====================================
        // JIKA CETAK PERBULAN
        // =====================================
        if ($tipeCetak == 'perbulan') {
            if ($bulan) {
                $query->whereMonth('created_at', $bulan)->whereYear('created_at', $tahun);
            }
            
            $allData = $query->orderBy('created_at', 'ASC')->get();

            // Membagi data sesuai bidang di Pokja 3
            $pangan = $allData->where('bidang', 'Program Pangan');
            $sandang = $allData->where('bidang', 'Program Sandang');
            $perumahan = $allData->where('bidang', 'Program Perumahan & Tata Laksana Rumah Tangga');
            
            // Mengatasi kemungkinan penulisan 'Kader Pokja 3' atau 'Kader Pokja III' di database
            $laporanpokja3 = $allData->filter(function($item) {
                return in_array($item->bidang, ['Kader Pokja 3', 'Kader Pokja III']);
            });
            
            // Variabel duplikat agar Blade lama komandan tidak error (Undefined)
            $pangan1 = $pangan;
            $sandang2 = $sandang;
            $perumahan3 = $perumahan;
            $laporanpokja31 = $laporanpokja3;

            $tanggal = $namaBulan[$bulan] ?? 'Bulan Tidak Dikenali';
            $tanggal2 = $tahun;

            return view('backend.cetak_galeri_bulan_pokja3', compact(
                'pangan', 'sandang', 'perumahan', 'laporanpokja3', 
                'pangan1', 'sandang2', 'perumahan3', 'laporanpokja31', 
                'tanggal', 'tanggal2', 'ketua', 'wakil'
            ));
        } 
        
        // =====================================
        // JIKA CETAK TAHUNAN
        // =====================================
        else {
            $query->whereYear('created_at', $tahun);
            $allData = $query->orderBy('created_at', 'ASC')->get();

            // Memecah data berdasarkan bulan (Aman dari Undefined Variable di View)
            $jan = $allData->filter(fn($item) => \Carbon\Carbon::parse($item->created_at)->month == 1);
            $feb = $allData->filter(fn($item) => \Carbon\Carbon::parse($item->created_at)->month == 2);
            $mar = $allData->filter(fn($item) => \Carbon\Carbon::parse($item->created_at)->month == 3);
            $apr = $allData->filter(fn($item) => \Carbon\Carbon::parse($item->created_at)->month == 4);
            $mei = $allData->filter(fn($item) => \Carbon\Carbon::parse($item->created_at)->month == 5);
            $jun = $allData->filter(fn($item) => \Carbon\Carbon::parse($item->created_at)->month == 6);
            $jul = $allData->filter(fn($item) => \Carbon\Carbon::parse($item->created_at)->month == 7);
            $agu = $allData->filter(fn($item) => \Carbon\Carbon::parse($item->created_at)->month == 8);
            $sep = $allData->filter(fn($item) => \Carbon\Carbon::parse($item->created_at)->month == 9);
            $okt = $allData->filter(fn($item) => \Carbon\Carbon::parse($item->created_at)->month == 10);
            $nov = $allData->filter(fn($item) => \Carbon\Carbon::parse($item->created_at)->month == 11);
            $des = $allData->filter(fn($item) => \Carbon\Carbon::parse($item->created_at)->month == 12);

            $tanggal = $tahun;
            $tanggal2 = $tahun;

            return view('backend.cetak_galeri_tahun_pokja3', compact(
                'jan', 'feb', 'mar', 'apr', 'mei', 'jun', 'jul', 'agu', 'sep', 'okt', 'nov', 'des', 
                'tanggal', 'tanggal2', 'ketua', 'wakil'
            ));
        }
    }
}