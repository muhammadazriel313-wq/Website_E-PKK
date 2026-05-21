<?php

namespace App\Http\Controllers\backend;

use App\Models\Ttd;
use App\Models\Ttds;
use App\Models\Galeri;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;
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

            return view('backend.cetak_galeri_tahun_bidangumum', compact('jan', 'feb', 'mar', 'apr', 'mei', 'jun', 'jul', 'agu', 'sep', 'okt', 'nov', 'des', 'tanggal', 'tanggal2', 'ketua', 'wakil'));
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
        $tipeCetak = $request->input('tipe_cetak', 'tahunan');
        $bulan     = $request->input('bulan', date('m'));
        $tahun     = $request->input('tahun', date('Y'));

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
            ->where('galerys.bidang', 'Laporan Umum');

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
        // FILTER BULAN / TAHUN
        // =====================================================

        if ($tipeCetak == 'perbulan') {

            $query->whereMonth('galerys.created_at', $bulan)
                ->whereYear('galerys.created_at', $tahun);
        } else {

            $query->whereYear('galerys.created_at', $tahun);
        }

        // =====================================================
        // EKSEKUSI QUERY
        // =====================================================

        $data = $query
            ->orderBy('galerys.created_at', 'desc')
            ->get();

        // =====================================================
        // FORMAT TANGGAL
        // =====================================================

        $tanggal = ($tipeCetak == 'perbulan')
            ? Carbon::createFromDate($tahun, $bulan)->isoFormat('MMMM Y')
            : $tahun;

        $formattedDate = Carbon::now()->isoFormat('d MMMM Y');

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
            ->where('pokja', 'Bidang Umum')
            ->where('jabatan', 'Sekretaris')
            ->get();

        // =====================================================
        // VIEW
        // =====================================================

        $viewName = ($tipeCetak == 'perbulan')
            ? 'backend.cetak_galeri_bulan_bidangumum'
            : 'backend.cetak_galeri_tahun_bidangumum';

        // =====================================================
        // CETAK BULANAN
        // =====================================================

        if ($tipeCetak == 'perbulan') {

            return view($viewName, [
                'bidangumum'  => $data,
                'wakil'       => $wakil,
                'ketua'       => $ketua,
                'tanggal'     => $tanggal,
                'tanggal2'    => $tahun,
                'formattedDate' => $formattedDate,
            ]);
        }

        // =====================================================
        // CETAK TAHUNAN
        // =====================================================

        $getData = function ($month) use ($tahun, $query) {

            return (clone $query)
                ->whereMonth('galerys.created_at', $month)
                ->whereYear('galerys.created_at', $tahun)
                ->orderBy('galerys.created_at', 'desc')
                ->get();
        };

        return view($viewName, [
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

            'wakil'        => $wakil,
            'ketua'        => $ketua,
            'tanggal'      => $tanggal,
            'tanggal2' => $tahun,
            'formattedDate' => $formattedDate,
        ]);
    }
    public function show($id)
    {
        return redirect()->route('galeribidangumum.index');
    }
}
