<?php

namespace App\Http\Controllers\backend;

use App\Models\Ttd;
use App\Models\Ttds;
use App\Models\Galeri;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Http\Controllers\Controller;

class Galeri4Controller extends Controller
{
    public function index()
    {
        $pertama = 0; $kedua = 0; $ketiga = 0; $keempat = 0; $kelima = 0;

        // =====================================
        // WEB KABUPATEN
        // =====================================
        if (Auth::guard('web')->check()) {
            $pertama = Galeri::leftJoin('users_mobile', 'galerys.id_user', '=', 'users_mobile.id')->where('galerys.bidang', 'Kesehatan')->where(function ($query) {
                $query->where(function ($q) { $q->where('users_mobile.id_role', 1)->whereIn('galerys.status', ['upload1', 'upload2']); })
                      ->orWhere(function ($q) { $q->where('users_mobile.id_role', 2)->whereIn('galerys.status', ['Proses', 'upload2']); });
            })->count();

            $kedua = Galeri::leftJoin('users_mobile', 'galerys.id_user', '=', 'users_mobile.id')->where('galerys.bidang', 'Kelestarian Lingkungan Hidup')->where(function ($query) {
                $query->where(function ($q) { $q->where('users_mobile.id_role', 1)->whereIn('galerys.status', ['upload1', 'upload2']); })
                      ->orWhere(function ($q) { $q->where('users_mobile.id_role', 2)->whereIn('galerys.status', ['Proses', 'upload2']); });
            })->count();

            $ketiga = Galeri::leftJoin('users_mobile', 'galerys.id_user', '=', 'users_mobile.id')->where('galerys.bidang', 'Perencanaan Sehat')->where(function ($query) {
                $query->where(function ($q) { $q->where('users_mobile.id_role', 1)->whereIn('galerys.status', ['upload1', 'upload2']); })
                      ->orWhere(function ($q) { $q->where('users_mobile.id_role', 2)->whereIn('galerys.status', ['Proses', 'upload2']); });
            })->count();

            $keempat = Galeri::leftJoin('users_mobile', 'galerys.id_user', '=', 'users_mobile.id')->where('galerys.bidang', 'Kader Pokja IV')->where(function ($query) {
                $query->where(function ($q) { $q->where('users_mobile.id_role', 1)->whereIn('galerys.status', ['upload1', 'upload2']); })
                      ->orWhere(function ($q) { $q->where('users_mobile.id_role', 2)->whereIn('galerys.status', ['Proses', 'upload2']); });
            })->count();

            $kelima = Galeri::leftJoin('users_mobile', 'galerys.id_user', '=', 'users_mobile.id')->whereIn('galerys.bidang', ['Inovasi Prioritas', 'Inovasi Unggulan'])->where(function ($query) {
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
                $pertama = Galeri::leftJoin('users_mobile', 'galerys.id_user', '=', 'users_mobile.id')->where('galerys.bidang', 'Kesehatan')->where('users_mobile.id_role', 1)->where('users_mobile.id_subdistrict', $user->id_subdistrict)->whereIn('galerys.status', ['Proses', 'upload1', 'upload2'])->count();
                $kedua = Galeri::leftJoin('users_mobile', 'galerys.id_user', '=', 'users_mobile.id')->where('galerys.bidang', 'Kelestarian Lingkungan Hidup')->where('users_mobile.id_role', 1)->where('users_mobile.id_subdistrict', $user->id_subdistrict)->whereIn('galerys.status', ['Proses', 'upload1', 'upload2'])->count();
                $ketiga = Galeri::leftJoin('users_mobile', 'galerys.id_user', '=', 'users_mobile.id')->where('galerys.bidang', 'Perencanaan Sehat')->where('users_mobile.id_role', 1)->where('users_mobile.id_subdistrict', $user->id_subdistrict)->whereIn('galerys.status', ['Proses', 'upload1', 'upload2'])->count();
                $keempat = Galeri::leftJoin('users_mobile', 'galerys.id_user', '=', 'users_mobile.id')->where('galerys.bidang', 'Kader Pokja IV')->where('users_mobile.id_role', 1)->where('users_mobile.id_subdistrict', $user->id_subdistrict)->whereIn('galerys.status', ['Proses', 'upload1', 'upload2'])->count();
                $kelima = Galeri::leftJoin('users_mobile', 'galerys.id_user', '=', 'users_mobile.id')->whereIn('galerys.bidang', ['Inovasi Prioritas', 'Inovasi Unggulan'])->where('users_mobile.id_role', 1)->where('users_mobile.id_subdistrict', $user->id_subdistrict)->whereIn('galerys.status', ['Proses', 'upload1', 'upload2'])->count();
            }
        }

        return view('backend.galeripokja4', compact('pertama', 'kedua', 'ketiga', 'keempat', 'kelima'));
    }

    public function filter(Request $request)
    {
        return $this->cetak($request);
    }

    public function show(Request $request, string $id)
    {
        if($request->has('search') || $request->has('search2')){
            return $this->cetak($request);
        }
        return redirect()->route('galeripokja4.index');
    }

    /*
    |--------------------------------------------------------------------------
    | FUNGSI CETAK GALERI POKJA 4
    |--------------------------------------------------------------------------
    */
    public function cetak(Request $request)
    {
        $tipeCetak = $request->input('tipe_cetak', ($request->filled('search') ? 'perbulan' : 'tahunan')); 
        $bulan = $request->input('search', $request->input('bulan')); 
        $tahun = $request->input('search2', $request->input('tahun', date('Y')));

        // 🚨 BUG FIX: Diubah dari 'pokja I' menjadi 'pokja IV'
        $query = Galeri::where('pokja', 'pokja IV')->where('status', 'Upload'); 

        // Filter Role (Kecamatan / Kabupaten)
        if (Auth::guard('pengguna')->check()) {
            $user = Auth::guard('pengguna')->user();
            $query->where('id_user', $user->id);
        }

        $ketua = Ttd::where('jabatan', 'Ketua')->where('pokja', 'Kelompok Kerja IV')->get();
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

            $kesehatan = $allData->where('bidang', 'Kesehatan');
            $kelestarian = $allData->where('bidang', 'Kelestarian Lingkungan Hidup');
            $perencanaan = $allData->where('bidang', 'Perencanaan Sehat');
            $laporanpokja4 = $allData->filter(function($item) {
                return in_array($item->bidang, ['Kader Pokja 4', 'Kader Pokja IV']);
            });
            $inovasi = $allData->whereIn('bidang', ['Inovasi Prioritas', 'Inovasi Unggulan']);
            
            $kesehatan1 = $kesehatan;
            $kelestarian1 = $kelestarian;
            $perencanaan1 = $perencanaan;
            $laporanpokja41 = $laporanpokja4;
            $inovasi1 = $inovasi;

            $tanggal = $namaBulan[$bulan] ?? 'Bulan Tidak Dikenali';
            $tanggal2 = $tahun;

            return view('backend.cetak_galeri_bulan_pokja4', compact(
                'kesehatan', 'kelestarian', 'perencanaan', 'laporanpokja4', 'inovasi',
                'kesehatan1', 'kelestarian1', 'perencanaan1', 'laporanpokja41', 'inovasi1',
                'tanggal', 'tanggal2', 'ketua', 'wakil'
            ));
        } 
        
        // =====================================
        // JIKA CETAK TAHUNAN
        // =====================================
        else {
            $query->whereYear('created_at', $tahun);
            $allData = $query->orderBy('created_at', 'ASC')->get();

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

            return view('backend.cetak_galeri_tahun_pokja4', compact(
                'jan', 'feb', 'mar', 'apr', 'mei', 'jun', 'jul', 'agu', 'sep', 'okt', 'nov', 'des', 
                'tanggal', 'tanggal2', 'ketua', 'wakil'
            ));
        }
    }
}