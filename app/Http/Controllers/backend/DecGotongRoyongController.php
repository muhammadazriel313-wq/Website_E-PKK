<?php

namespace App\Http\Controllers\backend;

use App\Models\GotongRoyong;
use App\Services\Pokja1ReportDeletion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class DecGotongRoyongController extends Controller
{
    public function index()
    {
        $data2 = collect(); // Default data kosong

        // Cek guard yang sedang login
        if (Auth::guard('web')->check()) {
            // Jika admin web, tampilkan semua data yang sudah disetujui
            $data2 = DB::table('laporan_gotong_royong')
                ->join('users_mobile', 'laporan_gotong_royong.id_user', '=', 'users_mobile.id')
                ->join('subdistrict', 'users_mobile.id_subdistrict', '=', 'subdistrict.id')
                ->join('village', 'users_mobile.id_village', '=', 'village.id')
                ->select('laporan_gotong_royong.*', 'subdistrict.name as nama_kec', 'village.name as nama_desa')
                ->where('laporan_gotong_royong.status', 'Disetujui2')
                ->orderBy('id_pokja1_bidang2', 'desc')
                ->get();
        } elseif (Auth::guard('pengguna')->check()) {
            // Jika pengguna mobile, cek role-nya
            $user = Auth::guard('pengguna')->user();

            if ($user->id_role == 2) { // Kecamatan (role 2)
                // Ambil data desa (role 1) pada kecamatan yang sama
                $data2 = DB::table('laporan_gotong_royong')
                    ->join('users_mobile as desa', 'laporan_gotong_royong.id_user', '=', 'desa.id')
                    ->join('subdistrict', 'desa.id_subdistrict', '=', 'subdistrict.id')
                    ->join('village', 'desa.id_village', '=', 'village.id')
                    ->where('desa.id_role', 1) // Hanya desa
                    ->where('desa.id_subdistrict', $user->id_subdistrict) // Kecamatan yang sama
                    ->where('laporan_gotong_royong.status', 'Disetujui1')
                    ->select('laporan_gotong_royong.*', 'subdistrict.name as nama_kec', 'village.name as nama_desa')
                    ->orderBy('id_pokja1_bidang2', 'desc')
                    ->get();
            }
        }

        return view('backend.decgotongroyong', compact('data2'));
    }

    public function destroy(string $id_pokja1_bidang2, Pokja1ReportDeletion $deletion)
    {
        try {
            $deletion->delete('gotong_royong', $id_pokja1_bidang2);
        } catch (\Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException $exception) {
            abort(403, 'Anda tidak berhak menghapus laporan ini.');
        } catch (\Symfony\Component\HttpKernel\Exception\NotFoundHttpException $exception) {
            return redirect()->route('decgotongroyong.index')->with('error', 'Laporan tidak ditemukan.');
        }

        return redirect()->route('decgotongroyong.index')->with('success', 'Laporan berhasil dihapus permanen.');
    }
}