<?php

namespace App\Http\Controllers\backend;

use App\Models\PerencanaanSehat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class PerencanaanSehatController extends Controller
{
    public function index()
    {
        $data = collect();

        if (Auth::guard('web')->check()) {
            $data = DB::table('laporan_perencanaan_sehat')
                ->leftJoin('users_mobile', 'laporan_perencanaan_sehat.id_user', '=', 'users_mobile.id')
                ->leftJoin('subdistrict', 'users_mobile.id_subdistrict', '=', 'subdistrict.id')
                ->leftJoin('village', 'users_mobile.id_village', '=', 'village.id')
                ->select('laporan_perencanaan_sehat.*', 'subdistrict.name as nama_kec', 'village.name as nama_desa')
                // KABUPATEN HANYA BISA MELIHAT DATA YANG SUDAH LEWAT KECAMATAN
                ->where(function ($query) {
                    // LAPORAN DARI DESA
                    $query->where(function ($q) {
                        $q->where('users_mobile.id_role', 1)
                            ->whereIn(
                                'laporan_perencanaan_sehat.status',
                                ['Disetujui1', 'disetujui1', 'DISETUJUI1']
                            );
                    })
                        // LAPORAN DARI MOBILE KECAMATAN
                        ->orWhere(function ($q) {
                            $q->where('users_mobile.id_role', 2)
                                ->whereIn(
                                    'laporan_perencanaan_sehat.status',
                                    ['Proses', 'proses', 'PROSES']
                                );
                        });
                })
                ->orderBy('laporan_perencanaan_sehat.id_pokja4_bidang3', 'desc')
                ->get();

            return view('backend.perencanaan_sehat', compact('data'));
        }

         // =========================
        // WEB KECAMATAN
        // =========================
        if (Auth::guard('pengguna')->check()) {
            $user = Auth::guard('pengguna')->user();

            if ($user->id_role == 2) { // KECAMATAN
                $data = DB::table('laporan_perencanaan_sehat')
                    ->leftJoin('users_mobile', 'laporan_perencanaan_sehat.id_user', '=', 'users_mobile.id')
                    ->leftJoin('subdistrict', 'users_mobile.id_subdistrict', '=', 'subdistrict.id')
                    ->leftJoin('village', 'users_mobile.id_village', '=', 'village.id')
                    ->select('laporan_perencanaan_sehat.*', 'subdistrict.name as nama_kec', 'village.name as nama_desa')
                    ->where('users_mobile.id_subdistrict', $user->id_subdistrict)
                    ->where('users_mobile.id_role', 1)
                    // KECAMATAN HANYA BISA MELIHAT DATA MENTAH
                    ->whereIn('laporan_perencanaan_sehat.status', ['proses', 'Proses', 'PROSES'])
                    ->orderBy('laporan_perencanaan_sehat.id_pokja4_bidang3', 'desc')
                    ->get();
            }

            return view('backend.perencanaan_sehat', compact('data'));
        }

        return view('backend.perencanaan_sehat', compact('data'));
    }

    public function edit($id)
    {
        $data = PerencanaanSehat::where('id_pokja4_bidang3', $id)->firstOrFail();
        return view('backend.tampil_perencanaan_sehat', compact('data'));
    }

    public function update(Request $request, $id)
    {
        $data = PerencanaanSehat::where('id_pokja4_bidang3', $id)->firstOrFail();
        $status = $request->status;
        if (strtolower($status) == 'disetujui') {
            $status = Auth::guard('web')->check() ? 'Disetujui2' : 'Disetujui1';
        }

        $data->update([
            'J_Psubur' => $request->J_Psubur ?? $data->J_Psubur,
            'J_Wsubur' => $request->J_Wsubur ?? $data->J_Wsubur,
            'Kb_p' => $request->Kb_p ?? $data->Kb_p,
            'Kb_w' => $request->Kb_w ?? $data->Kb_w,
            'Kk_tbg' => $request->Kk_tbg ?? $data->Kk_tbg,
            'Kk_asuransi' => $request->Kk_asuransi ?? $data->Kk_asuransi,
            'status' => $status,
            'catatan' => $request->catatan,
        ]);

        return redirect()->route('perencanaan_sehat.index')->with(['success' => 'Status Berhasil Diperbarui']);
    }

    public function destroy($id)
    {
        PerencanaanSehat::where('id_pokja4_bidang3', $id)->delete();
        return redirect()->route('perencanaan_sehat.index')->with(['success' => 'Laporan Berhasil Dihapus']);
    }
}