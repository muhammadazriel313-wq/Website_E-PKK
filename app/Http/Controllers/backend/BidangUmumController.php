<?php

namespace App\Http\Controllers\backend;

use Carbon\Carbon;
use App\Models\Ttd;
use App\Models\BidangUmum;
use App\Models\Pengguna;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class BidangUmumController extends Controller
{
    public function index()
    {
        $data = collect();

        // 1. ADMIN WEB: Hanya lihat yang sudah di-ACC Kecamatan (Disetujui1)
        if (Auth::guard('web')->check()) {
            $data = DB::table('laporan_umum')
                ->leftJoin('users_mobile', 'laporan_umum.id_user', '=', 'users_mobile.id')
                ->leftJoin('subdistrict', 'users_mobile.id_subdistrict', '=', 'subdistrict.id')
                ->leftJoin('village', 'users_mobile.id_village', '=', 'village.id')
                ->select('laporan_umum.*', 'subdistrict.name as nama_kec', 'village.name as nama_desa')
                // KABUPATEN HANYA BISA MELIHAT DATA YANG SUDAH LEWAT KECAMATAN
                ->where(function ($query) {
                    // LAPORAN DARI DESA
                    $query->where(function ($q) {
                        $q->where('users_mobile.id_role', 1)
                            ->whereIn(
                                'laporan_umum.status',
                                ['Disetujui1', 'disetujui1', 'DISETUJUI1']
                            );
                    })
                        // LAPORAN DARI MOBILE KECAMATAN
                        ->orWhere(function ($q) {
                            $q->where('users_mobile.id_role', 2)
                                ->whereIn(
                                    'laporan_umum.status',
                                    ['Proses', 'proses', 'PROSES', 'Menunggu', 'menunggu', 'MENUNGGU']
                                );
                        });
                })
                ->orderBy('laporan_umum.id_laporan_umum', 'desc')
                ->get();

            return view('backend.bidangumum', compact('data'));
        } 
        // =====================================
        // 2. WEB KECAMATAN (Hanya Lihat Proses)
        // =====================================
        if (Auth::guard('pengguna')->check()) {
            $user = Auth::guard('pengguna')->user();

            if ($user->id_role == 2) { // KECAMATAN
                $data = DB::table('laporan_umum')
                    ->leftJoin('users_mobile', 'laporan_umum.id_user', '=', 'users_mobile.id')
                    ->leftJoin('subdistrict', 'users_mobile.id_subdistrict', '=', 'subdistrict.id')
                    ->leftJoin('village', 'users_mobile.id_village', '=', 'village.id')
                    ->select('laporan_umum.*', 'subdistrict.name as nama_kec', 'village.name as nama_desa')
                    ->where('users_mobile.id_subdistrict', $user->id_subdistrict)
                    ->where('users_mobile.id_role', 1)
                    // KECAMATAN HANYA BISA MELIHAT DATA MENTAH
                    ->whereIn('laporan_umum.status', ['proses', 'Proses', 'PROSES', 'menunggu', 'Menunggu', 'MENUNGGU'])
                    ->orderBy('laporan_umum.id_laporan_umum', 'desc')
                    ->get();
            }

            return view('backend.bidangumum', compact('data'));
        }

        return view('backend.bidangumum', compact('data'));
    }

    public function edit(string $id_laporan_umum)
    {
        $data = BidangUmum::where('id_laporan_umum', $id_laporan_umum)->firstOrFail();
        return view('backend.tampil_bidangumum', compact('data'));
    }

    public function update(Request $request, string $id_laporan_umum)
    {
        $data = BidangUmum::where('id_laporan_umum', $id_laporan_umum)->firstOrFail();
        $status = $request->status;

        if (in_array(strtolower($status), ['disetujui', 'disetujui1', 'disetujui2'])) {
            $status = Auth::guard('web')->check() ? 'Disetujui2' : 'Disetujui1';
        }

        $data->update([
            'dusun_lingkungan'  => $request->dusun_lingkungan ?? $data->dusun_lingkungan,
            'PKK_RW'            => $request->PKK_RW ?? $data->PKK_RW,
            'desa_wisma'        => $request->desa_wisma ?? $data->desa_wisma,
            'KRT'               => $request->KRT ?? $data->KRT,
            'KK'                => $request->KK ?? $data->KK,
            'jiwa_laki'         => $request->jiwa_laki ?? $data->jiwa_laki,
            'jiwa_perempuan'    => $request->jiwa_perempuan ?? $data->jiwa_perempuan,
            'anggota_laki'      => $request->anggota_laki ?? $data->anggota_laki,
            'anggota_perempuan' => $request->anggota_perempuan ?? $data->anggota_perempuan,
            'umum_laki'         => $request->umum_laki ?? $data->umum_laki,
            'umum_perempuan'    => $request->umum_perempuan ?? $data->umum_perempuan,
            'khusus_laki'       => $request->khusus_laki ?? $data->khusus_laki,
            'khusus_perempuan'  => $request->khusus_perempuan ?? $data->khusus_perempuan,
            'honorer_laki'      => $request->honorer_laki ?? $data->honorer_laki,
            'honorer_perempuan' => $request->honorer_perempuan ?? $data->honorer_perempuan,
            'bantuan_laki'      => $request->bantuan_laki ?? $data->bantuan_laki,
            'bantuan_perempuan' => $request->bantuan_perempuan ?? $data->bantuan_perempuan,
            'status'            => $status,
            'catatan'           => $request->catatan,
            'updated_at'        => now()
        ]);

        return redirect()->route('bidangumum.index')->with('success', 'Berhasil Mengubah Status');
    }

    public function filter(Request $request)
    {
        $statusTarget = Auth::guard('web')->check() ? 'Disetujui2' : 'Disetujui1';

        // [PERUBAHAN 2026-10-09] Tambahkan leftJoin village untuk menyertakan nama_desa sesuai tampilan web
        $query = DB::table('laporan_umum')
            ->leftJoin('users_mobile', 'laporan_umum.id_user', '=', 'users_mobile.id')
            ->leftJoin('subdistrict', 'users_mobile.id_subdistrict', '=', 'subdistrict.id')
            ->leftJoin('village', 'users_mobile.id_village', '=', 'village.id')
            ->select('laporan_umum.*', 'subdistrict.name as nama_kec', 'village.name as nama_desa')
            ->where('laporan_umum.status', $statusTarget);

        if (Auth::guard('pengguna')->check()) {
            $user = Auth::guard('pengguna')->user();
            if ($user->id_role == 2) $query->where('users_mobile.id_subdistrict', $user->id_subdistrict);
        }

        $searchTerm = $request->search ?? $request->search2;
        $bidangumum = $query->where('laporan_umum.created_at', 'LIKE', '%' . $searchTerm . '%')->get();

        if ($bidangumum->isEmpty()) return back()->with('error', 'Tidak ada data laporan untuk periode tersebut');

        $totals = [];
        for($i=1; $i<=17; $i++) { /* logic sum total di sini jika diperlukan di view */ }

        $tanggal = null;
        if ($request->has('search') && !empty($request->search)) {
            try {
                $tanggal = Carbon::parse($request->search)->isoFormat('MMMM Y');
            } catch (\Exception $e) {
                $tanggal = $request->search;
            }
        } elseif ($request->has('search2') && !empty($request->search2)) {
            $tanggal = $request->search2;
        }

        $formattedDate = Carbon::now()->isoFormat('dddd, D MMMM YYYY');
        $ketua = Ttd::where('jabatan', 'Sekretaris')->where('pokja', 'Bidang Umum')->get();
        $viewName = $request->has('search2') ? 'backend.cetak_tahun_bidangumum' : 'backend.cetak_bulan_bidangumum';

        return view($viewName, compact('bidangumum', 'formattedDate', 'ketua', 'tanggal'));
    }

    public function destroy($id)
    {
        BidangUmum::where('id_laporan_umum', $id)->delete();
        return redirect()->route('bidangumum.index')->with('success', 'Berhasil Menghapus Laporan');
    }

    // ==========================================
    // EXPORT JSON BIDANG UMUM (untuk Google Sheets)
    // Mengambil data dari tabel laporan_umum, sesuai tabel di website
    // ==========================================
    public function getExportData(Request $request)
    {
        $bulan = $request->bulan;
        $tahun = $request->tahun;

        // Ambil data yang masih Proses maupun sudah Disetujui/Upload
        $statusTarget = ['Proses', 'proses', 'PROSES', 'Disetujui1', 'Disetujui2', 'disetujui1', 'disetujui2', 'DISETUJUI1', 'DISETUJUI2', 'Upload', 'upload', 'upload1', 'upload2', 'UPLOAD1', 'UPLOAD2'];

        try {
            $query = DB::table('laporan_umum')
                ->leftJoin('users_mobile', 'laporan_umum.id_user', '=', 'users_mobile.id')
                ->leftJoin('subdistrict', 'users_mobile.id_subdistrict', '=', 'subdistrict.id')
                ->leftJoin('village', 'users_mobile.id_village', '=', 'village.id')
                ->select('subdistrict.name as nama_kecamatan', 'village.name as nama_desa', 'laporan_umum.*')
                ->whereIn('laporan_umum.status', $statusTarget);

            // Filter Role (Keamanan Data)
            if (Auth::guard('web')->check()) {
                // Admin Kabupaten: semua wilayah
            } elseif (Auth::guard('pengguna')->check()) {
                $user = Auth::guard('pengguna')->user();
                if ($user->id_role == 2) {
                    $query->where('users_mobile.id_subdistrict', $user->id_subdistrict);
                } else {
                    $query->where('laporan_umum.id_user', $user->id);
                }
            }

            // Filter Waktu
            if (!empty($bulan)) $query->whereMonth('laporan_umum.created_at', $bulan);
            if (!empty($tahun)) $query->whereYear('laporan_umum.created_at', $tahun);

            $data = $query->orderBy('laporan_umum.created_at', 'asc')->get();

            if ($data->isEmpty()) {
                return response()->json([
                    'status' => 'empty',
                    'message' => 'Tidak ada data laporan pada periode tersebut.'
                ]);
            }

            $no = 1;
            $data = $data->map(function ($item) use (&$no) {
                return [
                    'No' => $no++,
                    'Kecamatan' => !empty($item->nama_kecamatan) ? ucwords(strtolower($item->nama_kecamatan)) : '-',
                    'Desa' => !empty($item->nama_desa) ? ucwords(strtolower($item->nama_desa)) : '-',
                    'Dusun/Lingkungan' => $item->dusun_lingkungan ?? 0,
                    'PKK/RW' => $item->PKK_RW ?? 0,
                    'PKK/RT' => $item->PKK_RT ?? 0,
                    'Desa/Wisma' => $item->desa_wisma ?? 0,
                    'KRT' => $item->KRT ?? 0,
                    'KK' => $item->KK ?? 0,
                    'Jiwa Laki-laki' => $item->jiwa_laki ?? 0,
                    'Jiwa Perempuan' => $item->jiwa_perempuan ?? 0,
                    'Anggota TP PKK L' => $item->anggota_laki ?? 0,
                    'Anggota TP PKK P' => $item->anggota_perempuan ?? 0,
                    'Umum L' => $item->umum_laki ?? 0,
                    'Umum P' => $item->umum_perempuan ?? 0,
                    'Khusus L' => $item->khusus_laki ?? 0,
                    'Khusus P' => $item->khusus_perempuan ?? 0,
                    'Honorer L' => $item->honorer_laki ?? 0,
                    'Honorer P' => $item->honorer_perempuan ?? 0,
                    'Bantuan L' => $item->bantuan_laki ?? 0,
                    'Bantuan P' => $item->bantuan_perempuan ?? 0,
                    'Keterangan' => !empty($item->keterangan) ? $item->keterangan : '-',
                    'Status' => $item->status ?? '-',
                    'Tanggal' => !empty($item->created_at) ? date('d/m/Y H:i', strtotime($item->created_at)) : '-',
                ];
            });

            return response()->json([
                'status' => 'success',
                'bidang' => 'BIDANG UMUM',
                'data' => $data
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Terjadi kesalahan sistem: ' . $e->getMessage()
            ], 500);
        }
    }

    public function cetak(Request $request) 
    {
        // ... proses ambil data ...
        
        $tanggal = $request->tahun; // Atau dari mana saja sumber tanggalnya didapat

        // Pastikan 'tanggal' masuk ke dalam compact()
        return view('backend.cetak_tahun_bidangumum', compact('data', 'tanggal'));
    }
}
