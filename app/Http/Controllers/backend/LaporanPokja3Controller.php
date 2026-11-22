<?php

namespace App\Http\Controllers\backend;

use App\Models\LaporanPokja3;
use App\Models\Pengguna;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class LaporanPokja3Controller extends Controller
{
    public function index()
    {
        $data = collect();

        // 1. WEB KABUPATEN (ADMIN)
        if (Auth::guard('web')->check()) {
            $data = DB::table('laporan_kader_pokja3')
                ->leftJoin('users_mobile', 'laporan_kader_pokja3.id_user', '=', 'users_mobile.id')
                ->leftJoin('subdistrict', 'users_mobile.id_subdistrict', '=', 'subdistrict.id')
                ->leftJoin('village', 'users_mobile.id_village', '=', 'village.id')
                ->select('laporan_kader_pokja3.*', 'subdistrict.name as nama_kec', 'village.name as nama_desa')
                // KABUPATEN HANYA BISA MELIHAT DATA YANG SUDAH LEWAT KECAMATAN
                ->where(function ($query) {
                    // LAPORAN DARI DESA
                    $query->where(function ($q) {
                        $q->where('users_mobile.id_role', 1)
                            ->whereIn(
                                'laporan_kader_pokja3.status',
                                ['Disetujui1', 'disetujui1', 'DISETUJUI1']
                            );
                    })
                        // LAPORAN DARI MOBILE KECAMATAN
                        ->orWhere(function ($q) {
                            $q->where('users_mobile.id_role', 2)
                                ->whereIn(
                                    'laporan_kader_pokja3.status',
                                    ['Proses', 'proses', 'PROSES']
                                );
                        });
                })
                ->orderBy('laporan_kader_pokja3.id_kader_pokja3', 'desc')
                ->get();

            return view('backend.laporanpokja3', compact('data'));
        } 
        
        // 2. PENGGUNA MOBILE (KECAMATAN / DESA)
        if (Auth::guard('pengguna')->check()) {
            $user = Auth::guard('pengguna')->user();

            if ($user->id_role == 2) { // KECAMATAN
                $data = DB::table('laporan_kader_pokja3')
                    ->leftJoin('users_mobile', 'laporan_kader_pokja3.id_user', '=', 'users_mobile.id')
                    ->leftJoin('subdistrict', 'users_mobile.id_subdistrict', '=', 'subdistrict.id')
                    ->leftJoin('village', 'users_mobile.id_village', '=', 'village.id')
                    ->select('laporan_kader_pokja3.*', 'subdistrict.name as nama_kec', 'village.name as nama_desa')
                    ->where('users_mobile.id_subdistrict', $user->id_subdistrict)
                    ->where('users_mobile.id_role', 1)
                    // KECAMATAN HANYA BISA MELIHAT DATA MENTAH
                    ->whereIn('laporan_kader_pokja3.status', ['proses', 'Proses', 'PROSES'])
                    ->orderBy('laporan_kader_pokja3.id_kader_pokja3', 'desc')
                    ->get();
            }

            return view('backend.laporanpokja3', compact('data'));
        }

        return view('backend.laporanpokja3', compact('data'));
    }

    public function edit(string $id_kader_pokja3)
    {
        $data = LaporanPokja3::find($id_kader_pokja3);
        if (!$data) return redirect()->back()->with('error', 'Data tidak ditemukan!');
        return view('backend.tampil_laporanpokja3', compact('data'));
    }

    public function update(Request $request, string $id_kader_pokja3)
    {
        $data = LaporanPokja3::find($id_kader_pokja3);
        $status = $request->status;

        // Otomatis tentukan level ACC
        if (in_array(strtolower($status), ['disetujui', 'disetujui1', 'disetujui2'])) {
            $status = Auth::guard('pengguna')->check() ? 'Disetujui1' : 'Disetujui2';
        }

        $data->update([
            'pangan'             => $request->pangan ?? $data->pangan,
            'sandang'            => $request->sandang ?? $data->sandang,
            'tata_laksana_rumah' => $request->tata_laksana_rumah ?? $data->tata_laksana_rumah,
            'status'             => $status,
            'catatan'            => $request->catatan,
            'updated_at'         => now(),
        ]);

        return redirect()->route('laporanpokja3.index')->with(['success' => 'Status Berhasil Diperbarui']);
    }

    public function destroy(string $id_kader_pokja3)
    {
        $data = LaporanPokja3::find($id_kader_pokja3);
        if ($data) {
            $data->delete();
            return redirect()->route('laporanpokja3.index')->with(['success' => 'Laporan Berhasil Dihapus']);
        }
        return redirect()->route('laporanpokja3.index')->with(['error' => 'Data tidak ditemukan']);
    }
}