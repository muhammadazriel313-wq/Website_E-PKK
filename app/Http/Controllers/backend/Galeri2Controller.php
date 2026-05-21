<?php

namespace App\Http\Controllers\backend;

use App\Models\Ttd;
use App\Models\Ttds;
use App\Models\Galeri;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Http\Controllers\Controller;

class Galeri2Controller extends Controller
{
    public function index()
    {
        $pertama = 0;
        $kedua = 0;
        // =====================================
        if (Auth::guard('web')->check()) {

            $pertama = Galeri::leftJoin('users_mobile', 'galerys.id_user', '=', 'users_mobile.id')
                ->where('galerys.bidang', 'Pendidikan & Ketrampilan')
                ->where(function ($query) {
                    // DATA DESA YANG SUDAH DIREVIEW KEC
                    $query->where(function ($q) {
                        $q->where('users_mobile.id_role', 1)
                            ->whereIn('galerys.status', ['upload1', 'upload2']);
                    })
                    // DATA MOBILE KECAMATAN
                    ->orWhere(function ($q) {
                        $q->where('users_mobile.id_role', 2)
                            ->whereIn('galerys.status', ['Proses', 'upload2']);
                    });
                })->count();

            $kedua = Galeri::leftJoin('users_mobile', 'galerys.id_user', '=', 'users_mobile.id')
                ->where('galerys.bidang', 'Pengembangan Kehidupan Berkoperasi')
                ->where(function ($query) {
                    $query->where(function ($q) {
                        $q->where('users_mobile.id_role', 1)
                            ->whereIn('galerys.status', ['upload1', 'upload2']);
                    })
                    ->orWhere(function ($q) {
                        $q->where('users_mobile.id_role', 2)
                            ->whereIn('galerys.status', ['Proses', 'upload2']);
                    });
                })->count();

        }
        // =====================================
        // WEB KECAMATAN
        // =====================================
        elseif (Auth::guard('pengguna')->check()) {

            $user = Auth::guard('pengguna')->user();

            if ($user->id_role == 2) {
                $pertama = Galeri::leftJoin('users_mobile', 'galerys.id_user', '=', 'users_mobile.id')
                    ->where('galerys.bidang', 'Pendidikan & Ketrampilan')
                    ->where('users_mobile.id_role', 1)
                    ->where('users_mobile.id_subdistrict', $user->id_subdistrict)
                    ->whereIn('galerys.status', ['Proses', 'upload1', 'upload2'])
                    ->count();

                $kedua = Galeri::leftJoin('users_mobile', 'galerys.id_user', '=', 'users_mobile.id')
                    ->where('galerys.bidang', 'Pengembangan Kehidupan Berkoperasi')
                    ->where('users_mobile.id_role', 1)
                    ->where('users_mobile.id_subdistrict', $user->id_subdistrict)
                    ->whereIn('galerys.status', ['Proses', 'upload1', 'upload2'])
                    ->count();
            }
        }

        return view('backend.galeripokja2', compact('pertama', 'kedua'));
    }

    // FUNGSI FILTER MENGARAH KE CETAK AGAR LOGIKA SAMA
    public function filter(Request $request)
    {
        return $this->cetak($request);
    }

    // FUNGSI SHOW MENGARAH KE INDEX JIKA DIAKSES TANPA PARAMETER CETAK
    public function show(Request $request, string $id)
    {
        if($request->has('search') || $request->has('search2')){
            return $this->cetak($request);
        }
        return redirect()->route('galeripokja2.index');
    }

    /*
    |--------------------------------------------------------------------------
    | FUNGSI CETAK GALERI POKJA 2
    |--------------------------------------------------------------------------
    */
    public function cetak(Request $request)
    {
        // Tangkap input dari frontend (mendukung form modal baru maupun lama)
        $tipeCetak = $request->input('tipe_cetak', ($request->filled('search') ? 'perbulan' : 'tahunan')); 
        $bulan = $request->input('search', $request->input('bulan')); 
        $tahun = $request->input('search2', $request->input('tahun', date('Y')));

        // Query Dasar
        $query = Galeri::where('pokja', 'pokja II')->where('status', 'Upload'); // Pokja 2

        // Filter Role (Kecamatan / Kabupaten)
        if (Auth::guard('pengguna')->check()) {
            $user = Auth::guard('pengguna')->user();
            $query->where('id_user', $user->id);
        }

        // Tanda Tangan
        $ketua = Ttd::where('jabatan', 'Ketua')->where('pokja', 'Kelompok Kerja II')->get();
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
                // Gunakan kolom 'created_at' (atau 'tanggal' jika struktur DB komandan berubah)
                $query->whereMonth('created_at', $bulan)->whereYear('created_at', $tahun);
            }
            
            $allData = $query->orderBy('created_at', 'ASC')->get();

            // Membagi data sesuai bidang di Pokja 2
            $pendidikan = $allData->where('bidang', 'Pendidikan & Ketrampilan');
            $pengembangan = $allData->where('bidang', 'Pengembangan Kehidupan Berkoperasi');
            
            $pendidikan1 = $pendidikan;
            $pengembangan1 = $pengembangan;

            $tanggal = $namaBulan[$bulan] ?? 'Bulan Tidak Dikenali';
            $tanggal2 = $tahun;

            return view('backend.cetak_galeri_bulan_pokja2', compact(
                'pendidikan', 'pendidikan1', 'pengembangan', 'pengembangan1', 'tanggal', 'tanggal2', 'ketua', 'wakil'
            ));
        } 
        
        // =====================================
        // JIKA CETAK TAHUNAN
        // =====================================
        else {
            $query->whereYear('created_at', $tahun);
            $allData = $query->orderBy('created_at', 'ASC')->get();

            // Memecah data berdasarkan bulan untuk array jan-des (Aman dari Undefined Variable)
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

            return view('backend.cetak_galeri_tahun_pokja2', compact(
                'jan', 'feb', 'mar', 'apr', 'mei', 'jun', 'jul', 'agu', 'sep', 'okt', 'nov', 'des', 
                'tanggal', 'tanggal2', 'ketua', 'wakil'
            ));
        }
    }
}