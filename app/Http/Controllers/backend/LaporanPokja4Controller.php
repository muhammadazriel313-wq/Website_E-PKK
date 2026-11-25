<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\LaporanPokja4; 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class LaporanPokja4Controller extends Controller
{
    // --- 1. MENAMPILKAN TABEL DATA (INDEX) ---
    public function index(Request $request)
    {
        $data = collect();

        // BLOK 1: MUTLAK HANYA UNTUK KABUPATEN
        if (Auth::guard('web')->check()) {
            $data = DB::table('laporan_kader_pokja4')
                ->leftJoin('users_mobile', 'laporan_kader_pokja4.id_user', '=', 'users_mobile.id')
                ->leftJoin('subdistrict', 'users_mobile.id_subdistrict', '=', 'subdistrict.id')
                ->leftJoin('village', 'users_mobile.id_village', '=', 'village.id')
                ->select('laporan_kader_pokja4.*', 'subdistrict.name as nama_kec', 'village.name as nama_desa')
                // KABUPATEN HANYA BISA MELIHAT DATA YANG SUDAH LEWAT KECAMATAN
                ->where(function ($query) {
                    // LAPORAN DARI DESA
                    $query->where(function ($q) {
                        $q->where('users_mobile.id_role', 1)
                            ->whereIn(
                                'laporan_kader_pokja4.status',
                                ['Disetujui1', 'disetujui1', 'DISETUJUI1']
                            );
                    })
                        // LAPORAN DARI MOBILE KECAMATAN
                        ->orWhere(function ($q) {
                            $q->where('users_mobile.id_role', 2)
                                ->whereIn(
                                    'laporan_kader_pokja4.status',
                                    ['Proses', 'proses', 'PROSES', 'Menunggu', 'menunggu', 'MENUNGGU']
                                );
                        });
                })
                ->orderBy('laporan_kader_pokja4.id_kader_pokja4', 'desc')
                ->get();

            return view('backend.laporanpokja4', compact('data'));
        }

        // B. JIKA YANG LOGIN PENGGUNA MOBILE (KECAMATAN / DESA)
        if (Auth::guard('pengguna')->check()) {
            $user = Auth::guard('pengguna')->user();

            if ($user->id_role == 2) { // KECAMATAN
                $data = DB::table('laporan_kader_pokja4')
                    ->leftJoin('users_mobile', 'laporan_kader_pokja4.id_user', '=', 'users_mobile.id')
                    ->leftJoin('subdistrict', 'users_mobile.id_subdistrict', '=', 'subdistrict.id')
                    ->leftJoin('village', 'users_mobile.id_village', '=', 'village.id')
                    ->select('laporan_kader_pokja4.*', 'subdistrict.name as nama_kec', 'village.name as nama_desa')
                    ->where('users_mobile.id_subdistrict', $user->id_subdistrict)
                    ->where('users_mobile.id_role', 1)
                    // KECAMATAN HANYA BISA MELIHAT DATA MENTAH
                    ->whereIn('laporan_kader_pokja4.status', ['proses', 'Proses', 'PROSES', 'menunggu', 'Menunggu', 'MENUNGGU'])
                    ->orderBy('laporan_kader_pokja4.id_kader_pokja4', 'desc')
                    ->get();
            }

            return view('backend.laporanpokja4', compact('data'));
        }

        return view('backend.laporanpokja4', compact('data'));
    }

    public function create()
    {
        return view('backend.laporanpokja4_create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'posyandu' => 'nullable|integer',
            'gizi' => 'nullable|integer',
            'kesling' => 'nullable|integer',
            'penyuluhan_narkoba' => 'nullable|integer',
            'PHBS' => 'nullable|integer',
            'KB' => 'nullable|integer',
            'status' => 'nullable|string',
        ]);
        
        try {
            if (Auth::guard('pengguna')->check()) {
                $validated['id_user'] = Auth::guard('pengguna')->id();
            }
            LaporanPokja4::create($validated);
            return redirect()->route('laporanpokja4.index')->with('success', 'Data laporan berhasil ditambahkan!');
        } catch (\Exception $e) {
            Log::error('Error store laporan pokja4: ' . $e->getMessage());
            return back()->withInput()->with('error', 'Gagal menyimpan data: ' . $e->getMessage());
        }
    }

    public function edit(string $id)
    {
        $data = LaporanPokja4::where('id_kader_pokja4', $id)->firstOrFail();
        return view('backend.tampil_laporanpokja4', compact('data'));
    }

    // --- 3. MEMPROSES PERUBAHAN STATUS/DATA (UPDATE) ---
    public function update(Request $request, string $id)
    {
        $data = LaporanPokja4::where('id_kader_pokja4', $id)->first();
        if(!$data) return redirect()->back()->with('error', 'Data tidak ditemukan');
        
        $status = $request->status;
        $statusVariasi = ['disetujui', 'disetujui (admin)', 'disetujui (kecamatan)', 'disetujui1', 'disetujui2'];
        
        // OTOMATIS DETEKSI LEVEL PERSETUJUAN
        if (in_array(strtolower($status), $statusVariasi)) {
            $status = Auth::guard('web')->check() ? 'Disetujui2' : 'Disetujui1';
        }
        
        try {
            $data->update([
                'posyandu'           => $request->posyandu ?? $data->posyandu,
                'gizi'               => $request->gizi ?? $data->gizi,
                'kesling'            => $request->kesling ?? $data->kesling,
                'penyuluhan_narkoba' => $request->penyuluhan_narkoba ?? $data->penyuluhan_narkoba,
                'PHBS'               => $request->PHBS ?? $data->PHBS,
                'KB'                 => $request->KB ?? $data->KB,
                'status'             => $status,
                'catatan'            => $request->catatan,
                'updated_at'         => now(),
            ]);
            return redirect()->route('laporanpokja4.index')->with('success', 'Data laporan berhasil diperbarui!');
        } catch (\Exception $e) {
            return back()->withInput()->with('error', 'Gagal memperbarui data: ' . $e->getMessage());
        }
    }

    public function destroy(string $id)
    {
        $data = LaporanPokja4::where('id_kader_pokja4', $id)->first();
        if($data) {
            $data->delete();
            return redirect()->route('laporanpokja4.index')->with('success', 'Data berhasil dihapus');
        }
        return redirect()->back()->with('error', 'Data gagal dihapus');
    }

    // --- 4. EXPORT JSON ---
    public function getExportData(Request $request)
    {
        $bulan = $request->bulan;
        $tahun = $request->tahun;
        $bidang = $request->bidang;
        $data = [];

        // Admin melihat Disetujui2, Kecamatan melihat Disetujui1
        $statusTarget = Auth::guard('web')->check() ? ['Disetujui2'] : ['Disetujui1', 'Disetujui2'];

        try {
            if ($bidang == 'kesehatan') {
                $query = DB::table('laporan_bidang_kesehatan');
            } elseif ($bidang == 'kelestarian') {
                $query = DB::table('laporan_kelestarian_lingkungan_hidup');
            } elseif ($bidang == 'perencanaan') {
                $query = DB::table('laporan_perencanaan_sehat');
            } else {
                $query = DB::table('laporan_kader_pokja4');
            }

            $data = $query->join('users_mobile', $query->from.'.id_user', '=', 'users_mobile.id')
                ->join('subdistrict', 'users_mobile.id_subdistrict', '=', 'subdistrict.id')
                ->join('village', 'users_mobile.id_village', '=', 'village.id')
                ->select('subdistrict.name as nama_kecamatan', 'village.name as nama_desa', $query->from.'.*')
                ->when($bulan, fn($q) => $q->whereMonth($query->from.'.created_at', $bulan))
                ->when($tahun, fn($q) => $q->whereYear($query->from.'.created_at', $tahun))
                ->whereIn($query->from.'.status', $statusTarget) 
                ->get();

            return response()->json(['status' => 'success', 'bidang' => $bidang, 'data' => $data]);

        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 500);
        }
    }
}