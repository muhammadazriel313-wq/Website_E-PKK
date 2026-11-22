<?php

namespace App\Http\Controllers\backend;

use App\Models\Pangan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class DecPanganController extends Controller
{
    public function index()
    {
        $data2 = collect();

        // =====================================
        // 1. WEB KABUPATEN (Lihat Riwayat Final)
        // =====================================
        if (Auth::guard('web')->check()) {
            $data2 = DB::table('laporan_pangan')
                ->leftJoin('users_mobile', 'laporan_pangan.id_user', '=', 'users_mobile.id')
                ->leftJoin('subdistrict', 'users_mobile.id_subdistrict', '=', 'subdistrict.id')
                ->leftJoin('village', 'users_mobile.id_village', '=', 'village.id')
                ->select('laporan_pangan.*', 'subdistrict.name as nama_kec', 'village.name as nama_desa')
                // KABUPATEN: Hanya melihat yang sudah selesai di-ACC Admin (Final)
                ->whereIn('laporan_pangan.status', ['Disetujui2', 'disetujui2', 'DISETUJUI2'])
                ->orderBy('id_pokja3_bidang1', 'desc')
                ->get();
        } 
        // =====================================
        // 2. PENGGUNA MOBILE (KECAMATAN / DESA)
        // =====================================
        elseif (Auth::guard('pengguna')->check()) {
            $user = Auth::guard('pengguna')->user();

            if ($user->id_role == 2) { 
                // --- KECAMATAN ---
                // JURUS ANTI-0: Hapus filter role 1 agar semua laporan terbaca
                $data2 = DB::table('laporan_pangan')
                    ->leftJoin('users_mobile', 'laporan_pangan.id_user', '=', 'users_mobile.id')
                    ->leftJoin('subdistrict', 'users_mobile.id_subdistrict', '=', 'subdistrict.id')
                    ->leftJoin('village', 'users_mobile.id_village', '=', 'village.id')
                    ->select('laporan_pangan.*', 'subdistrict.name as nama_kec', 'village.name as nama_desa')
                    ->where('users_mobile.id_subdistrict', $user->id_subdistrict)
                    // KECAMATAN: Melihat riwayat yang sudah mereka ACC (Disetujui1)
                    ->whereIn('laporan_pangan.status', ['Disetujui1', 'disetujui1', 'DISETUJUI1'])
                    ->orderBy('id_pokja3_bidang1', 'desc')
                    ->get();
            } else {
                // --- DESA ---
                // FIX: Tambahkan logika agar Desa bisa melihat riwayat laporannya yang sudah di-ACC
                $data2 = DB::table('laporan_pangan')
                    ->leftJoin('users_mobile', 'laporan_pangan.id_user', '=', 'users_mobile.id')
                    ->leftJoin('subdistrict', 'users_mobile.id_subdistrict', '=', 'subdistrict.id')
                    ->leftJoin('village', 'users_mobile.id_village', '=', 'village.id')
                    ->select('laporan_pangan.*', 'subdistrict.name as nama_kec', 'village.name as nama_desa')
                    ->where('laporan_pangan.id_user', $user->id)
                    ->whereIn('laporan_pangan.status', ['Disetujui1', 'disetujui1', 'DISETUJUI1'])
                    ->orderBy('id_pokja3_bidang1', 'desc')
                    ->get();
            }
        }

        return view('backend.decpangan', compact('data2'));
    }

    public function destroy(string $id_pokja3_bidang1)
    {
        $data2 = Pangan::find($id_pokja3_bidang1);

        if ($data2) {
            $data2->delete();
            return redirect()->route('decpangan.index')->with(['success' => 'Berhasil Menghapus Riwayat Laporan']);
        }

        return redirect()->route('decpangan.index')->with(['error' => 'Data tidak ditemukan']);
    }
}