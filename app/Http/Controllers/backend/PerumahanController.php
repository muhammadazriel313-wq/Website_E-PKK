<?php

namespace App\Http\Controllers\backend;

use App\Models\Perumahan;
use App\Models\Pengguna;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class PerumahanController extends Controller
{
    public function index()
    {
        $data = collect();

        // 1. JIKA YANG LOGIN ADMIN WEB (KABUPATEN)
        if (Auth::guard('web')->check()) {
            $data = DB::table('laporan_perumahan')
                ->leftJoin('users_mobile', 'laporan_perumahan.id_user', '=', 'users_mobile.id')
                ->leftJoin('subdistrict', 'users_mobile.id_subdistrict', '=', 'subdistrict.id')
                ->leftJoin('village', 'users_mobile.id_village', '=', 'village.id')
                ->select('laporan_perumahan.*', 'subdistrict.name as nama_kec', 'village.name as nama_desa')
                // KABUPATEN HANYA BISA MELIHAT DATA YANG SUDAH LEWAT KECAMATAN ATAU DARI KECAMATAN
                ->where(function ($query) {
                    // LAPORAN DARI DESA
                    $query->where(function ($q) {
                        $q->where('users_mobile.id_role', 1)
                            ->whereIn(
                                'laporan_perumahan.status',
                                ['Disetujui1', 'disetujui1', 'DISETUJUI1']
                            );
                    })
                        // LAPORAN DARI MOBILE KECAMATAN
                        ->orWhere(function ($q) {
                            $q->where('users_mobile.id_role', 2)
                                ->whereIn(
                                    'laporan_perumahan.status',
                                    ['Proses', 'proses', 'PROSES']
                                );
                        });
                })
                ->orderBy('laporan_perumahan.id_pokja3_bidang3', 'desc')
                ->get();

            return view('backend.perumahan', compact('data'));
        } 

        // 2. JIKA YANG LOGIN PENGGUNA MOBILE (KECAMATAN / DESA)
        if (Auth::guard('pengguna')->check()) {
            $user = Auth::guard('pengguna')->user();

            if ($user->id_role == 2) { // KECAMATAN
                $data = DB::table('laporan_perumahan')
                    ->leftJoin('users_mobile', 'laporan_perumahan.id_user', '=', 'users_mobile.id')
                    ->leftJoin('subdistrict', 'users_mobile.id_subdistrict', '=', 'subdistrict.id')
                    ->leftJoin('village', 'users_mobile.id_village', '=', 'village.id')
                    ->select('laporan_perumahan.*', 'subdistrict.name as nama_kec', 'village.name as nama_desa')
                    ->where('users_mobile.id_subdistrict', $user->id_subdistrict)
                    ->where('users_mobile.id_role', 1)
                    // KECAMATAN HANYA BISA MELIHAT DATA MENTAH
                    ->whereIn('laporan_perumahan.status', ['proses', 'Proses', 'PROSES'])
                    ->orderBy('laporan_perumahan.id_pokja3_bidang3', 'desc')
                    ->get();
            }

            return view('backend.perumahan', compact('data'));
        }

        return view('backend.perumahan', compact('data'));
    }

    public function edit(string $id_pokja3_bidang3)
    {
        $data = Perumahan::find($id_pokja3_bidang3);
        if (!$data) return redirect()->back()->with('error', 'Data tidak ditemukan!');

        $user = Pengguna::find($data->id_user);
        $kecamatan = $user ? DB::table('subdistrict')->where('id', $user->id_subdistrict)->first() : null;
        $desa = $user ? DB::table('village')->where('id', $user->id_village)->first() : null;

        return view('backend.tampil_perumahan', compact('data', 'kecamatan', 'desa'));
    }

    public function update(Request $request, string $id_pokja3_bidang3)
    {
        $data = Perumahan::find($id_pokja3_bidang3);
        $status = $request->status;

        if (strtolower($status) == 'disetujui') {
            $status = Auth::guard('pengguna')->check() ? 'Disetujui1' : 'Disetujui2';
        }

        $data->update([
            'layak_huni'  => $request->layak_huni ?? $data->layak_huni,
            'tidak_layak' => $request->tidak_layak ?? $data->tidak_layak,
            'status'      => $status,
            'catatan'     => $request->catatan,
            'updated_at'  => now(),
        ]);

        return redirect()->route('perumahan.index')->with(['success' => 'Berhasil Mengubah Status Laporan']);
    }

    public function destroy(string $id_pokja3_bidang3)
    {
        $data = Perumahan::find($id_pokja3_bidang3);
        if ($data) {
            $data->delete();
            return redirect()->route('perumahan.index')->with(['success' => 'Laporan Berhasil Dihapus']);
        }
        return redirect()->route('perumahan.index')->with(['error' => 'Data tidak ditemukan']);
    }
}