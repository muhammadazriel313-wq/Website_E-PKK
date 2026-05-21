<?php

namespace App\Http\Controllers\backend;

use App\Models\Ttd;
use App\Models\Ttds;
use App\Models\Galeri;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Auth;

class GaleriBidangUmumController extends Controller
{
    public function index()
    {
        // =====================================
        // WEB KABUPATEN
        // =====================================
        if (Auth::guard('web')->check()) {

            $data = Galeri::leftJoin('users_mobile', 'galerys.id_user', '=', 'users_mobile.id')
                ->where('galerys.bidang', 'Laporan Umum')
                ->where(function ($query) {
                    // DATA DARI DESA
                    $query->where(function ($q) {
                        $q->where('galerys.id_role', 1)
                            ->whereIn('galerys.status', ['upload1', 'upload2']);
                    })
                    // DATA DARI MOBILE KECAMATAN
                    ->orWhere(function ($q) {
                        $q->where('galerys.id_role', 2)
                            ->whereIn('galerys.status', ['Proses', 'upload2']);
                    });
                })
                ->select('galerys.*')
                ->latest('galerys.created_at')
                ->get();
        }

        // =====================================
        // WEB KECAMATAN
        // =====================================
        elseif (Auth::guard('pengguna')->check()) {

            $user = Auth::guard('pengguna')->user();

            $data = Galeri::leftJoin('users_mobile', 'galerys.id_user', '=', 'users_mobile.id')
                ->where('galerys.bidang', 'Laporan Umum')
                ->where('galerys.id_role', 1)
                ->where('users_mobile.id_subdistrict', $user->id_subdistrict)
                ->whereIn('galerys.status', ['Proses', 'upload1', 'upload2'])
                ->select('galerys.*')
                ->latest('galerys.created_at')
                ->get();
        }

        return view('backend.galeribidangumum', compact('data'));
    }


    public function edit(string $id)
    {
        $data = Galeri::find($id);
        return view('backend.tampil_galeribidangumum', compact('data'));
    }

    public function update(Request $request, string $id)
    {
        $data = Galeri::find($id);

        if (Auth::guard('pengguna')->check()) {
            $data->update([
                'deskripsi' => $request->deskripsi,
                'tanggal'   => $request->tanggal,
                'lokasi'    => $request->tempat_kegiatan,
                'status'    => 'upload1',
            ]);

            return redirect()->route('galeribidangumum.index')->with(['success' => 'Berhasil Upload Ke Kabupaten']);
        }

        if (Auth::guard('web')->check()) {
            $data->update([
                'deskripsi' => $request->deskripsi,
                'tanggal'   => $request->tanggal,
                'lokasi'    => $request->tempat_kegiatan,
                'status'    => 'upload2',
            ]);

            return redirect()->route('galeribidangumum.index')->with(['success' => 'Berhasil Publish Ke Landing Page']);
        }
    }

    public function destroy($id)
    {
        $data = Galeri::findOrFail($id);

        $filePath = public_path('frontend2/gallery2/' . $data->gambar);

        if (File::exists($filePath)) {
            File::delete($filePath);
        }

        $data->delete();

        return redirect()->route('galeribidangumum.index')->with(['success' => 'Berhasil Menghapus Gambar dalam Galeri']);
    }

    // Biarkan fungsi filter lama sebagai fallback (walaupun jarang dipakai)
// Biarkan fungsi filter lama sebagai fallback
    public function filter(Request $request)
    {
        // Gunakan filled() agar mengabaikan parameter 'search' yang kosong
        if ($request->filled('search')) {
            $bidangumum = Galeri::where('created_at', 'LIKE', '%' . $request->search . '%')->where('pokja', 'Kader Pokja I')->where('bidang', 'Laporan Umum')->where('status', 'Upload')->orderBy('created_at', 'ASC')->get();
            $bidangumum1 = Galeri::where('created_at', 'LIKE', '%' . $request->search . '%')->where('pokja', 'Kader Pokja I')->where('bidang', 'Laporan Umum')->where('status', 'Upload')->orderBy('created_at', 'ASC')->get();
            $tanggal = Carbon::parse($request->input('search'))->isoFormat('MMMM');
            $tanggal2 = $request->input('search');
            $ketua = Ttd::where('jabatan', 'Sekretaris')->where('pokja', 'Bidang Umum')->get();
            $wakil = Ttd::where('jabatan', 'Ketua')->get();

            return view('backend.cetak_galeri_bulan_bidangumum', compact('bidangumum', 'bidangumum1', 'tanggal', 'tanggal2', 'ketua', 'wakil'));
            
        } elseif ($request->filled('search2')) {
            $tahun = $request->input('search2');

            // Menggunakan whereYear agar lebih aman daripada LIKE
            $jan = Galeri::whereMonth('created_at', 1)->whereYear('created_at', $tahun)->where('pokja', 'Kader Pokja I')->where('status', 'Upload')->orderBy('created_at', 'ASC')->get();
            $feb = Galeri::whereMonth('created_at', 2)->whereYear('created_at', $tahun)->where('pokja', 'Kader Pokja I')->where('status', 'Upload')->orderBy('created_at', 'ASC')->get();
            $mar = Galeri::whereMonth('created_at', 3)->whereYear('created_at', $tahun)->where('pokja', 'Kader Pokja I')->where('status', 'Upload')->orderBy('created_at', 'ASC')->get();
            $apr = Galeri::whereMonth('created_at', 4)->whereYear('created_at', $tahun)->where('pokja', 'Kader Pokja I')->where('status', 'Upload')->orderBy('created_at', 'ASC')->get();
            $mei = Galeri::whereMonth('created_at', 5)->whereYear('created_at', $tahun)->where('pokja', 'Kader Pokja I')->where('status', 'Upload')->orderBy('created_at', 'ASC')->get();
            $jun = Galeri::whereMonth('created_at', 6)->whereYear('created_at', $tahun)->where('pokja', 'Kader Pokja I')->where('status', 'Upload')->orderBy('created_at', 'ASC')->get();
            $jul = Galeri::whereMonth('created_at', 7)->whereYear('created_at', $tahun)->where('pokja', 'Kader Pokja I')->where('status', 'Upload')->orderBy('created_at', 'ASC')->get();
            $agu = Galeri::whereMonth('created_at', 8)->whereYear('created_at', $tahun)->where('pokja', 'Kader Pokja I')->where('status', 'Upload')->orderBy('created_at', 'ASC')->get();
            $sep = Galeri::whereMonth('created_at', 9)->whereYear('created_at', $tahun)->where('pokja', 'Kader Pokja I')->where('status', 'Upload')->orderBy('created_at', 'ASC')->get();
            $okt = Galeri::whereMonth('created_at', 10)->whereYear('created_at', $tahun)->where('pokja', 'Kader Pokja I')->where('status', 'Upload')->orderBy('created_at', 'ASC')->get();
            $nov = Galeri::whereMonth('created_at', 11)->whereYear('created_at', $tahun)->where('pokja', 'Kader Pokja I')->where('status', 'Upload')->orderBy('created_at', 'ASC')->get();
            $des = Galeri::whereMonth('created_at', 12)->whereYear('created_at', $tahun)->where('pokja', 'Kader Pokja I')->where('status', 'Upload')->orderBy('created_at', 'ASC')->get();

            $tanggal = $tahun;
            $tanggal2 = $tahun;
            $ketua = Ttd::where('jabatan', 'Sekretaris')->where('pokja', 'Bidang Umum')->get();
            $wakil = Ttds::where('jabatan', 'Wakil Ketua I')->get();

            return view('backend.cetak_galeri_tahun_bidangumum', compact('jan','feb','mar','apr','mei','jun','jul','agu','sep','okt','nov','des','tanggal','tanggal2','ketua','wakil'));
        }

        // Kembalikan ke halaman sebelumnya jika tidak ada input
        return redirect()->back();
    }

    /*
    |--------------------------------------------------------------------------
    | FUNGSI CETAK GALERI BIDANG UMUM (SUPER CERDAS)
    |--------------------------------------------------------------------------
    */
public function cetak(Request $request)
{
    // 1. Ambil input (fleksibel: mendukung form baru 'bulan'/'tahun' atau form lama 'search'/'search2')
    $tipeCetak = $request->input('tipe_cetak', 'tahunan');
    $bulan     = $request->input('bulan', $request->input('search')); 
    $tahun     = $request->input('tahun', $request->input('search2', date('Y'))); 

    // 2. Query dasar (ditambahkan filter 'pokja' dan 'status' agar sama dengan data filter lama)
    $query = Galeri::where('bidang', 'Laporan Umum')
                   ->where('pokja', 'Kader Pokja I')
                   ->where('status', 'Upload');

    // Filter bulanan
    if ($tipeCetak == 'perbulan' && $bulan) {
        $query->whereMonth('created_at', $bulan)
              ->whereYear('created_at', $tahun);
    } else {
        // Tahunan
        $query->whereYear('created_at', $tahun);
    }

    $data = $query->orderBy('created_at', 'ASC')->get();

    // Nama bulan Indonesia
    $namaBulan = [
        1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
        5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
        9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember',
        '01' => 'Januari', '02' => 'Februari', '03' => 'Maret', '04' => 'April',
        '05' => 'Mei', '06' => 'Juni', '07' => 'Juli', '08' => 'Agustus',
        '09' => 'September', '10' => 'Oktober', '11' => 'November', '12' => 'Desember'
    ];

    // Untuk judul halaman cetak
    $tanggal  = ($tipeCetak == 'perbulan') ? ($namaBulan[$bulan] ?? '-') : $tahun;
    $tanggal2 = $tahun;

    // Ambil data tanda tangan
    $ketua = Ttd::where('jabatan', 'Sekretaris')
                ->where('pokja', 'Bidang Umum')
                ->get();

    $wakil = Ttds::where('jabatan', 'Wakil Ketua I')->get();

    // =====================================
    // PROSES CETAK BULANAN
    // =====================================
    if ($tipeCetak == 'perbulan') {
        return view('backend.cetak_galeri_bulan_bidangumum', [
            'bidangumum' => $data, // DIUBAH KE 'bidangumum' AGAR COMPATIBLE DENGAN BLADE
            'tanggal'    => $tanggal,
            'tanggal2'   => $tanggal2,
            'ketua'      => $ketua,
            'wakil'      => $wakil
        ]);
    }

    // =====================================
    // PROSES CETAK TAHUNAN
    // =====================================
    $getData = function($month) use ($tahun) {
        return Galeri::where('bidang', 'Laporan Umum')
            ->where('pokja', 'Kader Pokja I')
            ->where('status', 'Upload')
            ->whereMonth('created_at', $month)
            ->whereYear('created_at', $tahun)
            ->orderBy('created_at', 'ASC')
            ->get();
    };

    return view('backend.cetak_galeri_tahun_bidangumum', [
        'jan' => $getData(1),
        'feb' => $getData(2),
        'mar' => $getData(3),
        'apr' => $getData(4),
        'mei' => $getData(5),
        'jun' => $getData(6),
        'jul' => $getData(7),
        'agu' => $getData(8),
        'sep' => $getData(9),
        'okt' => $getData(10),
        'nov' => $getData(11),
        'des' => $getData(12),

        'tanggal'  => $tanggal,
        'tanggal2' => $tanggal2,
        'ketua'    => $ketua,
        'wakil'    => $wakil
    ]);
}
public function show($id)
    {
        return redirect()->route('galeribidangumum.index');
    }
}