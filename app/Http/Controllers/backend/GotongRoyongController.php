<?php

namespace App\Http\Controllers\backend;

use Carbon\Carbon;
use App\Models\Ttd;
use App\Models\GotongRoyong;
use App\Services\Pokja1ReportDeletion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\Pengguna;
use Illuminate\Support\Facades\Auth;

class GotongRoyongController extends Controller
{
    public function index()
    {
        // =========================
        // WEB KABUPATEN
        // =========================
        if (Auth::guard('web')->check()) {
            $data = DB::table('laporan_gotong_royong')
                ->leftJoin('users_mobile', 'laporan_gotong_royong.id_user', '=', 'users_mobile.id')
                ->leftJoin('subdistrict', 'users_mobile.id_subdistrict', '=', 'subdistrict.id')
                ->leftJoin('village', 'users_mobile.id_village', '=', 'village.id')
                ->select('laporan_gotong_royong.*', 'subdistrict.name as nama_kec', 'village.name as nama_desa')
                // KABUPATEN HANYA BISA MELIHAT DATA YANG SUDAH LEWAT KECAMATAN
                ->where(function ($query) {
                    // LAPORAN DARI DESA
                    $query->where(function ($q) {
                        $q->where('users_mobile.id_role', 1)
                            ->whereIn(
                                'laporan_gotong_royong.status',
                                ['Disetujui1', 'disetujui1', 'DISETUJUI1']
                            );
                    })
                        // LAPORAN DARI MOBILE KECAMATAN
                        ->orWhere(function ($q) {
                            $q->where('users_mobile.id_role', 2)
                                ->whereIn(
                                    'laporan_gotong_royong.status',
                                    ['Proses', 'proses', 'PROSES']
                                );
                        });
                })
                ->orderBy('laporan_gotong_royong.id_pokja1_bidang2', 'desc')
                ->get();

            return view('backend.gotongroyong', compact('data'));
        }

        // =========================
        // WEB KECAMATAN
        // =========================
        if (Auth::guard('pengguna')->check()) {
            $user = Auth::guard('pengguna')->user();

            if ($user->id_role == 2) { // KECAMATAN
                $data = DB::table('laporan_gotong_royong')
                    ->leftJoin('users_mobile', 'laporan_gotong_royong.id_user', '=', 'users_mobile.id')
                    ->leftJoin('subdistrict', 'users_mobile.id_subdistrict', '=', 'subdistrict.id')
                    ->leftJoin('village', 'users_mobile.id_village', '=', 'village.id')
                    ->select('laporan_gotong_royong.*', 'subdistrict.name as nama_kec', 'village.name as nama_desa')
                    ->where('users_mobile.id_subdistrict', $user->id_subdistrict)
                    ->where('users_mobile.id_role', 1)
                    // KECAMATAN HANYA BISA MELIHAT DATA MENTAH
                    ->whereIn('laporan_gotong_royong.status', ['proses', 'Proses', 'PROSES'])
                    ->orderBy('laporan_gotong_royong.id_pokja1_bidang2', 'desc')
                    ->get();
            }

            return view('backend.gotongroyong', compact('data'));
        }

        return view(
            'backend.gotongroyong',
            compact('data')
        );
    }

    public function edit(string $id_pokja1_bidang2)
    {
        $data = GotongRoyong::find($id_pokja1_bidang2);

        if (!$data) {
            return redirect()->back()->with('error', 'Data tidak ditemukan!');
        }

        $user = Pengguna::find($data->id_user);

        // Gunakan nullable object handling
        $kecamatan = $user ? DB::table('subdistrict')->where('id', $user->id_subdistrict)->first() : null;
        $desa = $user ? DB::table('village')->where('id', $user->id_village)->first() : null;

        return view('backend.tampil_gotongroyong', compact('data', 'kecamatan', 'desa'));
    }

    public function update(Request $request, string $id_pokja1_bidang2)
    {
        $data = GotongRoyong::find($id_pokja1_bidang2);

        if (!$data) {
            abort(404);
        }

        $status = $request->status;
        if (strtolower((string) $status) == 'disetujui') {
            $status = Auth::guard('pengguna')->check() ? 'Disetujui1' : 'Disetujui2';
        }

        $updates = [
            'status' => $status,
            'catatan' => $request->catatan === 'null' ? null : $request->catatan,
            'updated_at' => now(),
        ];

        foreach (['kerja_bakti', 'rukun_kematian', 'keagamaan', 'jimpitan', 'arisan'] as $field) {
            if ($request->exists($field) && $request->input($field) !== null) {
                $updates[$field] = $request->input($field);
            }
        }

        $data->update($updates);

        return redirect()->route('gotongroyong.index')->with(['success' => 'Berhasil Mengubah Status']);
    }

    public function filter(Request $request)
    {
        $status = Auth::guard('web')->check() ? 'Disetujui2' : 'Disetujui1';

        // FILTER PENCARIAN
        if ($request->has('search') || $request->has('search2')) {

            $searchTerm = $request->has('search') ? $request->search : $request->search2;
            $isYearly = $request->has('search2');

            $gotongroyong = DB::table('laporan_gotong_royong')
                ->leftJoin('users_mobile', 'laporan_gotong_royong.id_user', '=', 'users_mobile.id')
                ->leftJoin('subdistrict', 'users_mobile.id_subdistrict', '=', 'subdistrict.id')
                ->select('laporan_gotong_royong.*', 'subdistrict.name as nama_kec')
                ->when($isYearly, function ($q) use ($searchTerm) {
                    return $q->whereYear('laporan_gotong_royong.created_at', $searchTerm);
                }, function ($q) use ($searchTerm) {
                    return $q->where('laporan_gotong_royong.created_at', 'LIKE', '%' . $searchTerm . '%');
                })
                ->where('laporan_gotong_royong.status', $status)
                ->get();

            $penghayatan = DB::table('laporan_penghayatan_n_pengamalan')
                ->leftJoin('users_mobile', 'laporan_penghayatan_n_pengamalan.id_user', '=', 'users_mobile.id')
                ->leftJoin('subdistrict', 'users_mobile.id_subdistrict', '=', 'subdistrict.id')
                ->select('laporan_penghayatan_n_pengamalan.*', 'subdistrict.name as nama_kec')
                ->when($isYearly, function ($q) use ($searchTerm) {
                    return $q->whereYear('laporan_penghayatan_n_pengamalan.created_at', $searchTerm);
                }, function ($q) use ($searchTerm) {
                    return $q->where('laporan_penghayatan_n_pengamalan.created_at', 'LIKE', '%' . $searchTerm . '%');
                })
                ->where('laporan_penghayatan_n_pengamalan.status', $status)
                ->get();

            $laporanpokja1 = DB::table('laporan_kader_pokja1')
                ->leftJoin('users_mobile', 'laporan_kader_pokja1.id_user', '=', 'users_mobile.id')
                ->leftJoin('subdistrict', 'users_mobile.id_subdistrict', '=', 'subdistrict.id')
                ->select('laporan_kader_pokja1.*', 'subdistrict.name as nama_kec')
                ->when($isYearly, function ($q) use ($searchTerm) {
                    return $q->whereYear('laporan_kader_pokja1.created_at', $searchTerm);
                }, function ($q) use ($searchTerm) {
                    return $q->where('laporan_kader_pokja1.created_at', 'LIKE', '%' . $searchTerm . '%');
                })
                ->where('laporan_kader_pokja1.status', $status)
                ->get();

            // Hitung total
            $total5 = $gotongroyong->sum('kerja_bakti');
            $total6 = $gotongroyong->sum('rukun_kematian');
            $total7 = $gotongroyong->sum('keagamaan');
            $total8 = $gotongroyong->sum('jimpitan');
            $total9 = $gotongroyong->sum('arisan');

            $total12 = $penghayatan->sum('jumlah_kel_simulasi1');
            $total13 = $penghayatan->sum('jumlah_anggota1');
            $total14 = $penghayatan->sum('jumlah_kel_simulasi2');
            $total15 = $penghayatan->sum('jumlah_anggota2');
            $total16 = $penghayatan->sum('jumlah_kel_simulasi3');
            $total17 = $penghayatan->sum('jumlah_anggota3');
            $total18 = $penghayatan->sum('jumlah_kel_simulasi4');
            $total19 = $penghayatan->sum('jumlah_anggota4');

            $total = $laporanpokja1->sum('PKBN');
            $total1 = $laporanpokja1->sum('PKDRT');
            $total2 = $laporanpokja1->sum('pola_asuh');

            if ($gotongroyong->isEmpty() && $penghayatan->isEmpty() && $laporanpokja1->isEmpty()) {
                return back()->with('error', 'Tidak ada data laporan untuk periode tersebut');
            }

            $formattedDate = Carbon::now()->isoFormat('dddd, D MMMM YYYY');

            // Format waktu untuk view
            $created_at = $searchTerm;
            if (!$isYearly) {
                try {
                    $created_at = Carbon::parse($searchTerm)->isoFormat('MMMM YYYY');
                } catch (\Exception $e) {
                }
            }

            $ketua = Ttd::where('jabatan', 'Ketua')->where('pokja', 'Kelompok Kerja I')->get();
            $wakil = Ttd::where('jabatan', 'Ketua')->where('id_ttds', '12')->get();

            $viewName = $isYearly ? 'backend.cetak_tahun_pokja1' : 'backend.cetak_bulan_pokja1';

            return view($viewName, compact(
                'gotongroyong',
                'penghayatan',
                'laporanpokja1',
                'total5',
                'total6',
                'total7',
                'total8',
                'total9',
                'total12',
                'total13',
                'total14',
                'total15',
                'total16',
                'total17',
                'total18',
                'total19',
                'total',
                'total1',
                'total2',
                'created_at',
                'formattedDate',
                'ketua',
                'wakil'
            ));
        }

        return redirect()->back();
    }

    public function destroy(string $id_pokja1_bidang2, Pokja1ReportDeletion $deletion)
    {
        try {
            $deletion->delete('gotong_royong', $id_pokja1_bidang2);
        } catch (\Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException $exception) {
            abort(403, 'Anda tidak berhak menghapus laporan ini.');
        } catch (\Symfony\Component\HttpKernel\Exception\NotFoundHttpException $exception) {
            return redirect()->route('gotongroyong.index')->with('error', 'Laporan tidak ditemukan.');
        }

        return redirect()->route('gotongroyong.index')->with('success', 'Laporan berhasil dihapus permanen.');
    }
}
