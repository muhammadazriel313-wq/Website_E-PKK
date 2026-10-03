<?php

namespace App\Http\Controllers\backend;

use App\Models\PanganSandang;
use App\Models\Pengguna;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class PanganSandangController extends Controller
{
    /**
     * Halaman gabungan: Menunggu Persetujuan (Pangan + Sandang dalam 1 tabel)
     */
    public function index()
    {
        $data = collect();

        // =====================================
        // 1. WEB KABUPATEN (Hanya Lihat Disetujui1)
        // =====================================
        if (Auth::guard('web')->check()) {
            $data = DB::table('laporan_pangan_sandang')
                ->leftJoin('users_mobile', 'laporan_pangan_sandang.id_user', '=', 'users_mobile.id')
                ->leftJoin('subdistrict', 'users_mobile.id_subdistrict', '=', 'subdistrict.id')
                ->leftJoin('village', 'users_mobile.id_village', '=', 'village.id')
                ->select('laporan_pangan_sandang.*', 'subdistrict.name as nama_kec', 'village.name as nama_desa')
                ->where(function ($query) {
                    $query->where(function ($q) {
                        $q->where('users_mobile.id_role', 1)
                            ->whereIn('laporan_pangan_sandang.status', ['Disetujui1', 'disetujui1', 'DISETUJUI1']);
                    })
                    ->orWhere(function ($q) {
                        $q->where('users_mobile.id_role', 2)
                            ->whereIn('laporan_pangan_sandang.status', ['Proses', 'proses', 'PROSES']);
                    });
                })
                ->orderBy('laporan_pangan_sandang.id_pangan_sandang', 'desc')
                ->get();
        }
        // =====================================
        // 2. WEB KECAMATAN
        // =====================================
        elseif (Auth::guard('pengguna')->check()) {
            $user = Auth::guard('pengguna')->user();

            if ($user->id_role == 2) {
                $data = DB::table('laporan_pangan_sandang')
                    ->leftJoin('users_mobile', 'laporan_pangan_sandang.id_user', '=', 'users_mobile.id')
                    ->leftJoin('subdistrict', 'users_mobile.id_subdistrict', '=', 'subdistrict.id')
                    ->leftJoin('village', 'users_mobile.id_village', '=', 'village.id')
                    ->select('laporan_pangan_sandang.*', 'subdistrict.name as nama_kec', 'village.name as nama_desa')
                    ->where('users_mobile.id_subdistrict', $user->id_subdistrict)
                    ->where('users_mobile.id_role', 1)
                    ->whereIn('laporan_pangan_sandang.status', ['proses', 'Proses', 'PROSES'])
                    ->orderBy('laporan_pangan_sandang.id_pangan_sandang', 'desc')
                    ->get();
            }
        }

        return view('backend.pangansandang', compact('data'));
    }

    /**
     * Review / Edit data
     */
    public function edit(string $id)
    {
        $data = PanganSandang::find($id);
        if (!$data) return redirect()->back()->with('error', 'Data tidak ditemukan!');

        $user = Pengguna::find($data->id_user);
        $kecamatan = $user ? DB::table('subdistrict')->where('id', $user->id_subdistrict)->first() : null;
        $desa = $user ? DB::table('village')->where('id', $user->id_village)->first() : null;

        return view('backend.tampil_pangansandang', compact('data', 'kecamatan', 'desa'));
    }

    /**
     * Update status / data
     */
    public function update(Request $request, string $id)
    {
        $data = PanganSandang::find($id);

        $status = $request->status;
        if ($status == 'Disetujui') {
            if (Auth::guard('pengguna')->check()) {
                $status = 'Disetujui1'; // Level Kecamatan
            } else {
                $status = 'Disetujui2'; // Level Kabupaten
            }
        }

        $data->update([
            'beras'            => $request->beras ?? $data->beras,
            'non_beras'        => $request->non_beras ?? $data->non_beras,
            'peternakan'       => $request->peternakan ?? $data->peternakan,
            'perikanan'        => $request->perikanan ?? $data->perikanan,
            'warung_hidup'     => $request->warung_hidup ?? $data->warung_hidup,
            'lumbung_hidup'    => $request->lumbung_hidup ?? $data->lumbung_hidup,
            'toga'             => $request->toga ?? $data->toga,
            'tanaman_keras'    => $request->tanaman_keras ?? $data->tanaman_keras,
            'tanaman_lainnya'  => $request->tanaman_lainnya ?? $data->tanaman_lainnya,
            'industri_pangan'  => $request->industri_pangan ?? $data->industri_pangan,
            'industri_sandang' => $request->industri_sandang ?? $data->industri_sandang,
            'jasa'             => $request->jasa ?? $data->jasa,
            'status'           => $status,
            'catatan'          => $request->catatan,
        ]);

        return redirect()->route('pangansandang.index')->with(['success' => 'Status Laporan Berhasil Diperbarui']);
    }

    /**
     * Hapus data
     */
    public function destroy(string $id)
    {
        $data = PanganSandang::find($id);
        if ($data) {
            $data->delete();
            return redirect()->route('pangansandang.index')->with(['success' => 'Berhasil Menghapus Laporan']);
        }
        return redirect()->route('pangansandang.index')->with(['error' => 'Data tidak ditemukan']);
    }
}
