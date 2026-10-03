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
                                    ['Proses', 'proses', 'PROSES']
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
                    ->whereIn('laporan_umum.status', ['proses', 'Proses', 'PROSES'])
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

        $query = DB::table('laporan_umum')
            ->join('users_mobile', 'laporan_umum.id_user', '=', 'users_mobile.id')
            ->join('subdistrict', 'users_mobile.id_subdistrict', '=', 'subdistrict.id')
            ->select('laporan_umum.*', 'subdistrict.name as nama_kec')
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

        $formattedDate = Carbon::now()->isoFormat('dddd, D MMMM YYYY');
        $ketua = Ttd::where('jabatan', 'Sekretaris')->where('pokja', 'Bidang Umum')->get();
        $viewName = $request->has('search2') ? 'backend.cetak_tahun_bidangumum' : 'backend.cetak_bulan_bidangumum';

        return view($viewName, compact('bidangumum', 'formattedDate', 'ketua'));
    }

    public function destroy($id)
    {
        BidangUmum::where('id_laporan_umum', $id)->delete();
        return redirect()->route('bidangumum.index')->with('success', 'Berhasil Menghapus Laporan');
    }
    // ==========================================
    // FUNGSI BARU: EXPORT JSON BIDANG UMUM
    // ==========================================
    public function getExportData(Request $request)
    {
        $bulan = $request->bulan;
        $tahun = $request->tahun;

        // Ambil data yang masih Proses maupun sudah Disetujui/Upload
        $statusTarget = ['Proses', 'proses', 'PROSES', 'Disetujui1', 'Disetujui2', 'disetujui1', 'disetujui2', 'DISETUJUI1', 'DISETUJUI2', 'Upload', 'upload', 'upload1', 'upload2', 'UPLOAD1', 'UPLOAD2'];

        try {
            // ==========================================
            // 🧹 [PERUBAHAN 03-10-2026] Menggunakan tabel galerys untuk ekspor Bidang Umum sesuai format kegiatan (No, Tanggal, Kecamatan, Desa, Nama Kegiatan, Nama Peserta, Lokasi, Status); kode lama query laporan_umum dinonaktifkan
            /*
            $query = DB::table('laporan_umum')
                ->leftJoin('users_mobile', 'laporan_umum.id_user', '=', 'users_mobile.id')
                ->leftJoin('subdistrict', 'users_mobile.id_subdistrict', '=', 'subdistrict.id')
                ->leftJoin('village', 'users_mobile.id_village', '=', 'village.id')
                ->select('subdistrict.name as nama_kecamatan', 'village.name as nama_desa', 'laporan_umum.*')
                ->whereIn('laporan_umum.status', $statusTarget);

            // Filter Role (Keamanan Data)
            if (Auth::guard('web')->check()) {
                // Admin: Biarkan query utuh (Tembus semua wilayah)
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

            $data = $query->get();

            if ($data->isEmpty()) {
                return response()->json([
                    'status' => 'empty', 
                    'message' => 'Tidak ada data laporan pada periode tersebut.'
                ]);
            }

            return response()->json([
                'status' => 'success',
                'bidang' => 'BIDANG UMUM',
                'data' => $data
            ]);
            */
            $query = DB::table('galerys')
                ->leftJoin('users_mobile', 'galerys.id_user', '=', 'users_mobile.id')
                ->leftJoin('subdistrict', 'users_mobile.id_subdistrict', '=', 'subdistrict.id')
                ->leftJoin('village', 'users_mobile.id_village', '=', 'village.id')
                ->select('subdistrict.name as nama_kecamatan', 'village.name as nama_desa', 'galerys.*')
                ->where(function($q) {
                    $q->where('galerys.bidang', 'Laporan Umum')
                      ->orWhere('galerys.id_organization', 5)
                      ->orWhere('galerys.pokja', 'Bidang Umum');
                })
                ->whereIn('galerys.status', $statusTarget);

            // Filter Role (Keamanan Data)
            if (Auth::guard('web')->check()) {
                // Admin Kabupaten: Semua wilayah
            } elseif (Auth::guard('pengguna')->check()) {
                $user = Auth::guard('pengguna')->user();
                if ($user->id_role == 2) {
                    $query->where('users_mobile.id_subdistrict', $user->id_subdistrict);
                } else {
                    $query->where('galerys.id_user', $user->id);
                }
            }

            // Filter Waktu
            if (!empty($bulan)) $query->whereMonth('galerys.created_at', $bulan);
            if (!empty($tahun)) $query->whereYear('galerys.created_at', $tahun);

            $data = $query->latest('galerys.created_at')->get();

            if ($data->isEmpty()) {
                return response()->json([
                    'status' => 'empty', 
                    'message' => 'Tidak ada data laporan kegiatan pada periode tersebut.'
                ]);
            }

            $no = 1;
            $data = $data->map(function ($item) use (&$no) {
                $namaPesertaStr = '-';
                if (!empty($item->nama_peserta)) {
                    $peserta = json_decode($item->nama_peserta, true);
                    if (is_array($peserta) && !empty($peserta)) {
                        $namaPesertaStr = implode(', ', $peserta);
                    } elseif (is_string($item->nama_peserta) && trim($item->nama_peserta) !== '') {
                        $namaPesertaStr = trim($item->nama_peserta);
                    }
                }

                return [
                    'No' => $no++,
                    'Tanggal' => !empty($item->created_at) ? date('d-m-Y', strtotime($item->created_at)) : '-',
                    'Kecamatan' => !empty($item->nama_kecamatan) ? ucwords(strtolower($item->nama_kecamatan)) : '-',
                    'Desa' => !empty($item->nama_desa) ? ucwords(strtolower($item->nama_desa)) : '-',
                    'Nama Kegiatan' => $item->deskripsi ?? '-',
                    'Nama Peserta' => $namaPesertaStr,
                    'Lokasi' => $item->lokasi ?? '-',
                    'Status' => !empty($item->status) ? ucfirst(strtolower($item->status)) : '-',
                ];
            });

            return response()->json([
                'status' => 'success',
                'bidang' => 'BIDANG UMUM',
                'data' => $data
            ]);
            // ==========================================

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