<?php

namespace App\Http\Controllers\backend;

use App\Models\Penghayatan;
use App\Services\Pokja1ReportDeletion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class PenghayatanController extends Controller
{
    public function index()
    {
        $data = collect();

        // =========================
        // WEB KABUPATEN
        // =========================
        if (Auth::guard('web')->check()) {
            $data = DB::table('laporan_penghayatan_n_pengamalan')
                ->leftJoin('users_mobile', 'laporan_penghayatan_n_pengamalan.id_user', '=', 'users_mobile.id')
                ->leftJoin('subdistrict', 'users_mobile.id_subdistrict', '=', 'subdistrict.id')
                ->leftJoin('village', 'users_mobile.id_village', '=', 'village.id')
                ->select('laporan_penghayatan_n_pengamalan.*', 'subdistrict.name as nama_kec', 'village.name as nama_desa')
                // KABUPATEN HANYA BISA MELIHAT DATA YANG SUDAH LEWAT KECAMATAN
                ->where(function ($query) {
                    // LAPORAN DARI DESA
                    $query->where(function ($q) {
                        $q->where('users_mobile.id_role', 1)
                            ->whereIn(
                                'laporan_penghayatan_n_pengamalan.status',
                                ['Disetujui1', 'disetujui1', 'DISETUJUI1']
                            );
                    })
                        // LAPORAN DARI MOBILE KECAMATAN
                        ->orWhere(function ($q) {
                            $q->where('users_mobile.id_role', 2)
                                ->whereIn(
                                    'laporan_penghayatan_n_pengamalan.status',
                                    ['Proses', 'proses', 'PROSES']
                                );
                        });
                })
                ->orderBy('laporan_penghayatan_n_pengamalan.id_pokja1_bidang1', 'desc')
                ->get();

            return view('backend.penghayatan', compact('data'));
        }

        // =========================
        // WEB KECAMATAN
        // =========================
        if (Auth::guard('pengguna')->check()) {
            $user = Auth::guard('pengguna')->user();

            if ($user->id_role == 2) { // KECAMATAN
                $data = DB::table('laporan_penghayatan_n_pengamalan')
                    ->leftJoin('users_mobile', 'laporan_penghayatan_n_pengamalan.id_user', '=', 'users_mobile.id')
                    ->leftJoin('subdistrict', 'users_mobile.id_subdistrict', '=', 'subdistrict.id')
                    ->leftJoin('village', 'users_mobile.id_village', '=', 'village.id')
                    ->select('laporan_penghayatan_n_pengamalan.*', 'subdistrict.name as nama_kec', 'village.name as nama_desa')
                    ->where('users_mobile.id_subdistrict', $user->id_subdistrict)
                    ->where('users_mobile.id_role', 1)
                    // KECAMATAN HANYA BISA MELIHAT DATA MENTAH
                    ->whereIn('laporan_penghayatan_n_pengamalan.status', ['proses', 'Proses', 'PROSES', 'menunggu', 'Menunggu', 'MENUNGGU'])
                    ->orderBy('laporan_penghayatan_n_pengamalan.id_pokja1_bidang1', 'desc')
                    ->get();
            }

            return view('backend.penghayatan', compact('data'));
        }

        return view('backend.penghayatan', compact('data'));
    }

    public function edit(string $id_pokja1_bidang1)
    {
        $data = Penghayatan::find($id_pokja1_bidang1);
        return view('backend.tampil_penghayatan', compact('data'));
    }

    public function update(Request $request, string $id_pokja1_bidang1)
    {
        $data = Penghayatan::find($id_pokja1_bidang1);

        // Tentukan status persetujuan berdasarkan guard
        $status = $request->status;
        if ($status == 'Disetujui') {
            if (Auth::guard('pengguna')->check()) {
                $status = 'Disetujui1'; // Status untuk pengguna mobile
            } else {
                $status = 'Disetujui2'; // Status untuk web
            }
        }

        $data->update([
            'status' => $status,
            'catatan' => $request->catatan,
        ]);

        return redirect()->route('penghayatan.index')->with(['success' => 'Berhasil Mengubah Status']);
    }

    public function destroy(string $id_pokja1_bidang1, Pokja1ReportDeletion $deletion)
    {
        try {
            $deletion->delete('penghayatan', $id_pokja1_bidang1);
        } catch (\Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException $exception) {
            abort(403, 'Anda tidak berhak menghapus laporan ini.');
        } catch (\Symfony\Component\HttpKernel\Exception\NotFoundHttpException $exception) {
            return redirect()->route('penghayatan.index')->with('error', 'Laporan tidak ditemukan.');
        }

        return redirect()->route('penghayatan.index')->with('success', 'Laporan berhasil dihapus permanen.');
    }
}
