<?php

namespace App\Http\Controllers\backend;

use App\Models\Sandang;
use App\Models\Pengguna;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class SandangController extends Controller
{
    public function index()
    {
        $data = collect();

        // =====================================
        // 1. WEB KABUPATEN (Hanya Lihat Disetujui1)
        // =====================================
        if (Auth::guard('web')->check()) {
            $data = DB::table('laporan_sandang')
                ->leftJoin('users_mobile', 'laporan_sandang.id_user', '=', 'users_mobile.id')
                ->leftJoin('subdistrict', 'users_mobile.id_subdistrict', '=', 'subdistrict.id')
                ->leftJoin('village', 'users_mobile.id_village', '=', 'village.id')
                ->select('laporan_sandang.*', 'subdistrict.name as nama_kec', 'village.name as nama_desa')
                // KABUPATEN HANYA BISA MELIHAT DATA YANG SUDAH LEWAT KECAMATAN
                ->where(function ($query) {
                    // LAPORAN DARI DESA
                    $query->where(function ($q) {
                        $q->where('users_mobile.id_role', 1)
                            ->whereIn(
                                'laporan_sandang.status',
                                ['Disetujui1', 'disetujui1', 'DISETUJUI1']
                            );
                    })
                        // LAPORAN DARI MOBILE KECAMATAN
                        ->orWhere(function ($q) {
                            $q->where('users_mobile.id_role', 2)
                                ->whereIn(
                                    'laporan_sandang.status',
                                    ['Proses', 'proses', 'PROSES']
                                );
                        });
                })
                ->orderBy('laporan_sandang.id_pokja3_bidang2', 'desc')
                ->get();

            return view('backend.sandang', compact('data'));
        } 
        
        // =====================================
        // 2. PENGGUNA MOBILE (KECAMATAN / DESA)
        // =====================================
        if (Auth::guard('pengguna')->check()) {
            $user = Auth::guard('pengguna')->user();

            if ($user->id_role == 2) { // KECAMATAN
                $data = DB::table('laporan_sandang')
                    ->leftJoin('users_mobile', 'laporan_sandang.id_user', '=', 'users_mobile.id')
                    ->leftJoin('subdistrict', 'users_mobile.id_subdistrict', '=', 'subdistrict.id')
                    ->leftJoin('village', 'users_mobile.id_village', '=', 'village.id')
                    ->select('laporan_sandang.*', 'subdistrict.name as nama_kec', 'village.name as nama_desa')
                    ->where('users_mobile.id_subdistrict', $user->id_subdistrict)
                    ->where('users_mobile.id_role', 1)
                    // KECAMATAN HANYA BISA MELIHAT DATA MENTAH
                    ->whereIn('laporan_sandang.status', ['proses', 'Proses', 'PROSES'])
                    ->orderBy('laporan_sandang.id_pokja3_bidang2', 'desc')
                    ->get();
            }

            return view('backend.sandang', compact('data'));
        }

        return view('backend.sandang', compact('data'));
    }

    public function edit(string $id_pokja3_bidang2)
    {
        $data = Sandang::find($id_pokja3_bidang2);
        
        if (!$data) {
            return redirect()->back()->with('error', 'Data tidak ditemukan!');
        }

        $user = Pengguna::find($data->id_user);
        $kecamatan = $user ? DB::table('subdistrict')->where('id', $user->id_subdistrict)->first() : null;
        $desa = $user ? DB::table('village')->where('id', $user->id_village)->first() : null;

        return view('backend.tampil_sandang', compact('data', 'kecamatan', 'desa'));
    }

    public function update(Request $request, string $id_pokja3_bidang2)
    {
        $data = Sandang::find($id_pokja3_bidang2);

        // Tentukan status persetujuan secara otomatis
        $status = $request->status;
        if ($status == 'Disetujui') {
            if (Auth::guard('pengguna')->check()) {
                $status = 'Disetujui1'; // Oleh Kecamatan
            } else {
                $status = 'Disetujui2'; // Oleh Admin Kabupaten
            }
        }

        $data->update([
            'pangan'     => $request->pangan ?? $data->pangan,
            'sandang'    => $request->sandang ?? $data->sandang,
            'jasa'       => $request->jasa ?? $data->jasa,
            'status'     => $status,
            'catatan'    => $request->catatan,
            'updated_at' => now(),
        ]);

        return redirect()->route('sandang.index')->with(['success' => 'Status Laporan Sandang Berhasil Diperbarui']);
    }

    public function destroy(string $id_pokja3_bidang2)
    {
        $data = Sandang::find($id_pokja3_bidang2);
        if ($data) {
            $data->delete();
            return redirect()->route('sandang.index')->with(['success' => 'Berhasil Menghapus Laporan']);
        }
        return redirect()->route('sandang.index')->with(['error' => 'Data tidak ditemukan']);
    }
}