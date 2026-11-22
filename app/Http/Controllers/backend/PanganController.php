<?php

namespace App\Http\Controllers\backend;

use Carbon\Carbon;
use App\Models\Ttd;
use App\Models\Pangan;
use App\Models\Pengguna;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

class PanganController extends Controller
{
    public function index()
    {
        $data = collect();

        // =====================================
        // 1. WEB KABUPATEN (Hanya Lihat Disetujui1)
        // =====================================
        if (Auth::guard('web')->check()) {
            $data = DB::table('laporan_pangan')
                ->leftJoin('users_mobile', 'laporan_pangan.id_user', '=', 'users_mobile.id')
                ->leftJoin('subdistrict', 'users_mobile.id_subdistrict', '=', 'subdistrict.id')
                ->leftJoin('village', 'users_mobile.id_village', '=', 'village.id')
                ->select('laporan_pangan.*', 'subdistrict.name as nama_kec', 'village.name as nama_desa')
                // KABUPATEN HANYA BISA MELIHAT DATA YANG SUDAH LEWAT KECAMATAN
                ->where(function ($query) {
                    // LAPORAN DARI DESA
                    $query->where(function ($q) {
                        $q->where('users_mobile.id_role', 1)
                            ->whereIn(
                                'laporan_pangan.status',
                                ['Disetujui1', 'disetujui1', 'DISETUJUI1']
                            );
                    })
                        // LAPORAN DARI MOBILE KECAMATAN
                        ->orWhere(function ($q) {
                            $q->where('users_mobile.id_role', 2)
                                ->whereIn(
                                    'laporan_pangan.status',
                                    ['Proses', 'proses', 'PROSES']
                                );
                        });
                })
                ->orderBy('laporan_pangan.id_pokja3_bidang1', 'desc')
                ->get();

            return view('backend.pangan', compact('data'));
        } 
        // =====================================
        // 2. WEB KECAMATAN (Hanya Lihat Proses)
        // =====================================
        if (Auth::guard('pengguna')->check()) {
            $user = Auth::guard('pengguna')->user();

            if ($user->id_role == 2) { // KECAMATAN
                $data = DB::table('laporan_pangan')
                    ->leftJoin('users_mobile', 'laporan_pangan.id_user', '=', 'users_mobile.id')
                    ->leftJoin('subdistrict', 'users_mobile.id_subdistrict', '=', 'subdistrict.id')
                    ->leftJoin('village', 'users_mobile.id_village', '=', 'village.id')
                    ->select('laporan_pangan.*', 'subdistrict.name as nama_kec', 'village.name as nama_desa')
                    ->where('users_mobile.id_subdistrict', $user->id_subdistrict)
                    ->where('users_mobile.id_role', 1)
                    // KECAMATAN HANYA BISA MELIHAT DATA MENTAH
                    ->whereIn('laporan_pangan.status', ['proses', 'Proses', 'PROSES'])
                    ->orderBy('laporan_pangan.id_pokja3_bidang1', 'desc')
                    ->get();
            }

            return view('backend.pangan', compact('data'));
        }

        return view('backend.pangan', compact('data'));
    }

    public function edit(string $id_pokja3_bidang1)
    {
        $data = Pangan::find($id_pokja3_bidang1);
        if (!$data) return redirect()->back()->with('error', 'Data tidak ditemukan!');
        return view('backend.tampil_pangan', compact('data'));
    }

    public function update(Request $request, string $id_pokja3_bidang1)
    {
        $data = Pangan::find($id_pokja3_bidang1);

        // Tentukan status persetujuan berdasarkan guard (Sama seperti Penghayatan)
        $status = $request->status;
        if ($status == 'Disetujui') {
            if (Auth::guard('pengguna')->check()) {
                $status = 'Disetujui1'; // Level Kecamatan
            } else {
                $status = 'Disetujui2'; // Level Kabupaten
            }
        }

        $data->update([
            'beras'           => $request->beras,
            'non_beras'       => $request->non_beras,
            'peternakan'      => $request->peternakan,
            'perikanan'       => $request->perikanan,
            'warung_hidup'    => $request->warung_hidup,
            'lumbung_hidup'   => $request->lumbung_hidup,
            'toga'            => $request->toga,
            'tanaman_keras'   => $request->tanaman_keras,
            'tanaman_lainnya' => $request->tanaman_lainnya, // Field baru tetap update
            'status'          => $status,
            'catatan'         => $request->catatan,
        ]);

        return redirect()->route('pangan.index')->with(['success' => 'Berhasil Mengubah Status']);
    }

    public function filter(Request $request)
    {
        // Level Filter (Sesuai Guard)
        $statusTarget = Auth::guard('web')->check() ? 'Disetujui2' : 'Disetujui1';

        if ($request->has('search') || $request->has('search2')) {
            $searchTerm = $request->has('search') ? $request->search : $request->search2;
            $isYearly = $request->has('search2');

            $pangan = DB::table('laporan_pangan')
                ->leftJoin('users_mobile', 'laporan_pangan.id_user', '=', 'users_mobile.id')
                ->leftJoin('subdistrict', 'users_mobile.id_subdistrict', '=', 'subdistrict.id')
                ->select('laporan_pangan.*', 'subdistrict.name as nama_kec')
                ->when($isYearly, fn($q) => $q->whereYear('laporan_pangan.created_at', $searchTerm), 
                                  fn($q) => $q->where('laporan_pangan.created_at', 'LIKE', '%' . $searchTerm . '%'))
                ->where('laporan_pangan.status', $statusTarget)
                ->get();

            if ($pangan->isEmpty()) return back()->with('error', 'Data tidak ditemukan');

            $total1 = $pangan->sum('beras');
            $total2 = $pangan->sum('non_beras');
            $total3 = $pangan->sum('peternakan');
            $total31 = $pangan->sum('perikanan');
            $total4 = $pangan->sum('warung_hidup');
            $total5 = $pangan->sum('lumbung_hidup');
            $total6 = $pangan->sum('toga');
            $total7 = $pangan->sum('tanaman_keras');
            $total_tanaman_lainnya = $pangan->sum('tanaman_lainnya');

            $formattedDate = Carbon::now()->isoFormat('dddd, D MMMM YYYY');
            $created_at = $isYearly ? $searchTerm : (Carbon::hasFormat($searchTerm, 'Y-m') ? Carbon::parse($searchTerm)->isoFormat('MMMM YYYY') : $searchTerm);
            $ketua = Ttd::where('jabatan', 'Ketua')->where('pokja', 'Kelompok Kerja III')->get();

            $viewName = $isYearly ? 'backend.cetak_tahun_pokja3' : 'backend.cetak_bulan_pokja3';

            return view($viewName, compact(
                'pangan', 'total1', 'total2', 'total3', 'total31', 'total4', 'total5', 'total6', 'total7', 'total_tanaman_lainnya',
                'formattedDate', 'ketua', 'created_at'
            ));
        }

        return redirect()->back();
    }

    public function destroy(string $id_pokja3_bidang1)
    {
        $data = Pangan::find($id_pokja3_bidang1);
        $data->delete();
        return redirect()->route('pangan.index')->with(['success' => 'Berhasil Menghapus Laporan']);
    }
}