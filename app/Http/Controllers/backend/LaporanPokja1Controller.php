<?php

namespace App\Http\Controllers\backend;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\LaporanPokja1;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Services\FirebaseService;

class LaporanPokja1Controller extends Controller
{
    // --- 1. MENAMPILKAN TABEL DATA (INDEX) ---
    public function index()
    {
        $data = collect();

        // BLOK 1: MUTLAK HANYA UNTUK KABUPATEN
        if (Auth::guard('web')->check()) {
            $data = DB::table('laporan_kader_pokja1')
                ->leftJoin('users_mobile', 'laporan_kader_pokja1.id_user', '=', 'users_mobile.id')
                ->leftJoin('subdistrict', 'users_mobile.id_subdistrict', '=', 'subdistrict.id')
                ->leftJoin('village', 'users_mobile.id_village', '=', 'village.id')
                ->select('laporan_kader_pokja1.*', 'subdistrict.name as nama_kec', 'village.name as nama_desa')
                // KABUPATEN HANYA BISA MELIHAT DATA YANG SUDAH LEWAT KECAMATAN
                ->where(function ($query) {
                    // LAPORAN DARI DESA
                    $query->where(function ($q) {
                        $q->where('users_mobile.id_role', 1)
                            ->whereIn(
                                'laporan_kader_pokja1.status',
                                ['Disetujui1', 'disetujui1', 'DISETUJUI1']
                            );
                    })
                        // LAPORAN DARI MOBILE KECAMATAN
                        ->orWhere(function ($q) {
                            $q->where('users_mobile.id_role', 2)
                                ->whereIn(
                                    'laporan_kader_pokja1.status',
                                    ['Proses', 'proses', 'PROSES']
                                );
                        });
                })
                ->orderBy('laporan_kader_pokja1.id_kader_pokja1', 'desc')
                ->get();

            return view('backend.laporanpokja1', compact('data'));
        }

        // BLOK 2: MUTLAK HANYA UNTUK KECAMATAN & DESA
        if (Auth::guard('pengguna')->check()) {
            $user = Auth::guard('pengguna')->user();

            if ($user->id_role == 2) { // KECAMATAN
                $data = DB::table('laporan_kader_pokja1')
                    ->leftJoin('users_mobile', 'laporan_kader_pokja1.id_user', '=', 'users_mobile.id')
                    ->leftJoin('subdistrict', 'users_mobile.id_subdistrict', '=', 'subdistrict.id')
                    ->leftJoin('village', 'users_mobile.id_village', '=', 'village.id')
                    ->select('laporan_kader_pokja1.*', 'subdistrict.name as nama_kec', 'village.name as nama_desa')
                    ->where('users_mobile.id_subdistrict', $user->id_subdistrict)
                    ->where('users_mobile.id_role', 1)
                    // KECAMATAN HANYA BISA MELIHAT DATA MENTAH
                    ->whereIn('laporan_kader_pokja1.status', ['proses', 'Proses', 'PROSES'])
                    ->orderBy('laporan_kader_pokja1.id_kader_pokja1', 'desc')
                    ->get();
            }

            return view('backend.laporanpokja1', compact('data'));
        }

        // JIKA TIDAK LOGIN, KEMBALIKAN DATA KOSONG
        return view('backend.laporanpokja1', compact('data'));
    }

    // --- 2. MENAMPILKAN FORM EDIT/REVIEW ---
    public function edit(string $id_kader_pokja1)
    {
        $data = LaporanPokja1::find($id_kader_pokja1);
        if (!$data) {
            return redirect()->route('laporanpokja1.index')->with('error', 'Data tidak ditemukan');
        }
        return view('backend.tampil_laporanpokja1', compact('data'));
    }

    // --- 3. MEMPROSES PERUBAHAN STATUS/DATA (UPDATE) ---
    public function update(Request $request, string $id_kader_pokja1)
    {
        $data = LaporanPokja1::find($id_kader_pokja1);
        if (!$data) {
            return redirect()->back()->with(['error' => 'Data tidak ditemukan!']);
        }

        $status = $request->status;
        $statusVariasi = ['disetujui', 'disetujui (admin)', 'disetujui (kecamatan)', 'disetujui1', 'disetujui2'];

        if (in_array(strtolower($status), $statusVariasi)) {
            // Jika login pakai 'tim penggerak' -> Disetujui2, Jika 'aldi' -> Disetujui1
            $status = Auth::guard('web')->check() ? 'Disetujui2' : 'Disetujui1';
        }

        $data->update([
            'PKBN'      => $request->PKBN ?? $data->PKBN,
            'PKDRT'     => $request->PKDRT ?? $data->PKDRT,
            'pola_asuh' => $request->pola_asuh ?? $data->pola_asuh,
            'tanggal'   => $request->tanggal ?? $data->tanggal,
            'status'    => $status,
            'catatan'   => $request->catatan,
        ]);

        $user = DB::table('users_mobile')
            ->where('id', $data->id_user)
            ->first();

        if ($user && $user->fcm_token) {

            try {

                $firebase = new FirebaseService();

                // ACC Kecamatan
                if ($status == 'Disetujui1') {

                    $totalAcc = DB::table('laporan_kader_pokja1')
                        ->where('id_user', $data->id_user)
                        ->where('status', 'Disetujui1')
                        ->count();

                    $firebase->sendNotification(
                        $user->fcm_token,
                        'Laporan Disetujui Kecamatan',
                        "$totalAcc laporan Anda telah disetujui Kecamatan"
                    );
                }

                // ACC Kabupaten
                if ($status == 'Disetujui2') {

                    $totalAcc = DB::table('laporan_kader_pokja1')
                        ->where('id_user', $data->id_user)
                        ->where('status', 'Disetujui2')
                        ->count();

                    $firebase->sendNotification(
                        $user->fcm_token,
                        'Laporan Disetujui Kabupaten',
                        "$totalAcc laporan Anda telah disetujui Kabupaten"
                    );
                }
            } catch (\Exception $e) {

                dd($e->getMessage());
            }
        }

        return redirect()->route('laporanpokja1.index')->with(['success' => 'Berhasil Mengubah Status']);
    }

    // --- 4. MENGHAPUS DATA (DESTROY) ---
    public function destroy(string $id_kader_pokja1)
    {
        $data = LaporanPokja1::find($id_kader_pokja1);
        if ($data) {
            $data->delete();
            return redirect()->route('laporanpokja1.index')->with(['success' => 'Berhasil Menghapus Laporan']);
        }
        return redirect()->route('laporanpokja1.index')->with(['error' => 'Data tidak ditemukan']);
    }

    // --- 5. FILTER / CETAK PDF ---
    public function filter(Request $request)
    {
        $bulan = $request->bulan;
        $tahun = $request->tahun;

        $gotongroyong = DB::table('laporan_gotong_royong')
            ->leftJoin('users_mobile', 'laporan_gotong_royong.id_user', '=', 'users_mobile.id')
            ->leftJoin('subdistrict', 'users_mobile.id_subdistrict', '=', 'subdistrict.id')
            ->select('laporan_gotong_royong.*', 'subdistrict.name as nama_kec')
            ->when($bulan, fn($q) => $q->whereMonth('tanggal', $bulan))
            ->when($tahun, fn($q) => $q->whereYear('tanggal', $tahun))
            ->whereIn('status', ['Disetujui2', 'disetujui2'])
            ->get();

        $penghayatan = DB::table('laporan_penghayatan_n_pengamalan')
            ->leftJoin('users_mobile', 'laporan_penghayatan_n_pengamalan.id_user', '=', 'users_mobile.id')
            ->leftJoin('subdistrict', 'users_mobile.id_subdistrict', '=', 'subdistrict.id')
            ->select('laporan_penghayatan_n_pengamalan.*', 'subdistrict.name as nama_kec')
            ->when($bulan, fn($q) => $q->whereMonth('created_at', $bulan))
            ->when($tahun, fn($q) => $q->whereYear('created_at', $tahun))
            ->whereIn('status', ['Disetujui2', 'disetujui2'])
            ->get();

        $laporanpokja1 = DB::table('laporan_kader_pokja1')
            ->leftJoin('users_mobile', 'laporan_kader_pokja1.id_user', '=', 'users_mobile.id')
            ->leftJoin('subdistrict', 'users_mobile.id_subdistrict', '=', 'subdistrict.id')
            ->select('laporan_kader_pokja1.*', 'subdistrict.name as nama_kec')
            ->when($bulan, fn($q) => $q->whereMonth('tanggal', $bulan))
            ->when($tahun, fn($q) => $q->whereYear('tanggal', $tahun))
            ->whereIn('status', ['Disetujui2', 'disetujui2'])
            ->get();

        $formattedDate = now()->format('d F Y');

        return view('backend.cetak_pokja1', compact('gotongroyong', 'penghayatan', 'laporanpokja1', 'bulan', 'tahun', 'formattedDate'));
    }

    // --- 6. EXPORT KE GOOGLE SHEETS ---
    public function getExportData(Request $request)
    {
        $bulan = $request->bulan;
        $tahun = $request->tahun;
        $bidang = $request->bidang;
        $data = [];

        try {
            if ($bidang == 'gotongroyong') {
                $data = DB::table('laporan_gotong_royong')
                    ->when($bulan, fn($q) => $q->whereMonth('tanggal', $bulan))
                    ->when($tahun, fn($q) => $q->whereYear('tanggal', $tahun))
                    ->whereIn('status', ['Disetujui2', 'disetujui2'])->get();
            } elseif ($bidang == 'penghayatan') {
                $data = DB::table('laporan_penghayatan_n_pengamalan')
                    ->when($bulan, fn($q) => $q->whereMonth('created_at', $bulan))
                    ->when($tahun, fn($q) => $q->whereYear('created_at', $tahun))
                    ->whereIn('status', ['Disetujui2', 'disetujui2'])->get();
            } elseif ($bidang == 'kader') {
                $data = DB::table('laporan_kader_pokja1')
                    ->when($bulan, fn($q) => $q->whereMonth('tanggal', $bulan))
                    ->when($tahun, fn($q) => $q->whereYear('tanggal', $tahun))
                    ->whereIn('status', ['Disetujui2', 'disetujui2'])->get();
            }
            return response()->json(['status' => 'success', 'bidang' => $bidang, 'data' => $data]);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => 'Error Laravel: ' . $e->getMessage()], 500);
        }
    }
}
