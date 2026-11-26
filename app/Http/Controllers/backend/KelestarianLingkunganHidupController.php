<?php

namespace App\Http\Controllers\backend;

use App\Models\KelestarianLingkunganHidup;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class KelestarianLingkunganHidupController extends Controller
{
    public function index()
    {
        $data = collect();

         if (Auth::guard('web')->check()) {
            $data = DB::table('laporan_kelestarian_lingkungan_hidup')
                ->leftJoin('users_mobile', 'laporan_kelestarian_lingkungan_hidup.id_user', '=', 'users_mobile.id')
                ->leftJoin('subdistrict', 'users_mobile.id_subdistrict', '=', 'subdistrict.id')
                ->leftJoin('village', 'users_mobile.id_village', '=', 'village.id')
                ->select('laporan_kelestarian_lingkungan_hidup.*', 'subdistrict.name as nama_kec', 'village.name as nama_desa')
                // KABUPATEN HANYA BISA MELIHAT DATA YANG SUDAH LEWAT KECAMATAN
                ->where(function ($query) {
                    // LAPORAN DARI DESA
                    $query->where(function ($q) {
                        $q->where('users_mobile.id_role', 1)
                            ->whereIn(
                                'laporan_kelestarian_lingkungan_hidup.status',
                                ['Disetujui1', 'disetujui1', 'DISETUJUI1']
                            );
                    })
                        // LAPORAN DARI MOBILE KECAMATAN
                        ->orWhere(function ($q) {
                            $q->where('users_mobile.id_role', 2)
                                ->whereIn(
                                    'laporan_kelestarian_lingkungan_hidup.status',
                                    ['Proses', 'proses', 'PROSES', 'Menunggu', 'menunggu', 'MENUNGGU']
                                );
                        });
                })
                ->orderBy('laporan_kelestarian_lingkungan_hidup.id_pokja4_bidang2', 'desc')
                ->get();

            return view('backend.kelestarian_lingkungan_hidup', compact('data'));
        }

        // =========================
        // WEB KECAMATAN
        // =========================
        if (Auth::guard('pengguna')->check()) {
            $user = Auth::guard('pengguna')->user();

            if ($user->id_role == 2) { // KECAMATAN
                $data = DB::table('laporan_kelestarian_lingkungan_hidup')
                    ->leftJoin('users_mobile', 'laporan_kelestarian_lingkungan_hidup.id_user', '=', 'users_mobile.id')
                    ->leftJoin('subdistrict', 'users_mobile.id_subdistrict', '=', 'subdistrict.id')
                    ->leftJoin('village', 'users_mobile.id_village', '=', 'village.id')
                    ->select('laporan_kelestarian_lingkungan_hidup.*', 'subdistrict.name as nama_kec', 'village.name as nama_desa')
                    ->where('users_mobile.id_subdistrict', $user->id_subdistrict)
                    ->where('users_mobile.id_role', 1)
                    // KECAMATAN HANYA BISA MELIHAT DATA MENTAH
                    ->whereIn('laporan_kelestarian_lingkungan_hidup.status', ['proses', 'Proses', 'PROSES', 'menunggu', 'Menunggu', 'MENUNGGU'])
                    ->orderBy('laporan_kelestarian_lingkungan_hidup.id_pokja4_bidang2', 'desc')
                    ->get();
            }

            return view('backend.kelestarian_lingkungan_hidup', compact('data'));
        }

        return view('backend.kelestarian_lingkungan_hidup', compact('data'));
    }

    public function edit($id)
    {
        $data = KelestarianLingkunganHidup::where('id_pokja4_bidang2', $id)->firstOrFail();
        return view('backend.tampil_kelestarian_lingkungan_hidup', compact('data'));
    }

    public function update(Request $request, $id)
    {
        $data = KelestarianLingkunganHidup::where('id_pokja4_bidang2', $id)->firstOrFail();
        $status = $request->status;

        if (in_array(strtolower($status), ['disetujui', 'disetujui1', 'disetujui2'])) {
            $status = Auth::guard('web')->check() ? 'Disetujui2' : 'Disetujui1';
        }

        $data->update([
            'jamban' => $request->jamban ?? $data->jamban,
            'spal'   => $request->spal ?? $data->spal,
            'tps'    => $request->tps ?? $data->tps,
            'mck'    => $request->mck ?? $data->mck,
            'pdam'   => $request->pdam ?? $data->pdam,
            'sumur'  => $request->sumur ?? $data->sumur,
            'dll'    => $request->dll ?? $data->dll,
            'status' => $status,
            'catatan' => $request->catatan,
        ]);

        return redirect()->route('kelestarian_lingkungan_hidup.index')->with(['success' => 'Berhasil Mengubah Status']);
    }

    public function destroy($id)
    {
        KelestarianLingkunganHidup::where('id_pokja4_bidang2', $id)->delete();
        return redirect()->route('kelestarian_lingkungan_hidup.index')->with(['success' => 'Laporan Berhasil Dihapus']);
    }
}