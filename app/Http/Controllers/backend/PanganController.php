<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\Pangan;
use App\Models\Pengguna;
use App\Models\Subdistrict;
use App\Models\Ttd;
use App\Models\Village;
use App\Traits\PokjaReportTrait;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class PanganController extends Controller
{
    use PokjaReportTrait;

    /**
     * Halaman Daftar Laporan Menunggu Persetujuan - Program Pangan
     */
    public function index()
    {
        $query = $this->buildReportQuery('laporan_pangan');
        $query = $this->applyWaitingApprovalFilter($query, 'laporan_pangan');

        $data = $query->orderBy('laporan_pangan.id', 'desc')->get();

        return view('backend.pangan', compact('data'));
    }

    /**
     * Form Input Laporan Baru - Program Pangan
     */
    public function create()
    {
        $kecamatanList = Subdistrict::orderBy('name', 'asc')->get();
        $desaList = Village::orderBy('name', 'asc')->get();

        return view('backend.input_pangan', compact('kecamatanList', 'desaList'));
    }

    /**
     * Simpan Laporan Baru - Program Pangan
     */
    public function store(Request $request)
    {
        $request->validate([
            'kecamatan_id' => 'required',
            'desa_id'      => 'required',
        ]);

        $uuid = 'KP3B1-' . strtoupper(Str::random(6));

        $idUser = null;
        if (Auth::guard('pengguna')->check()) {
            $idUser = Auth::guard('pengguna')->id();
        }

        Pangan::create([
            'uuid'            => $uuid,
            'id_user'         => $idUser,
            'kecamatan_id'    => $request->kecamatan_id,
            'desa_id'         => $request->desa_id,
            'kader_pangan'    => max(0, (int) ($request->kader_pangan ?? 0)),
            'beras'           => max(0, (int) ($request->beras ?? 0)),
            'non_beras'       => max(0, (int) ($request->non_beras ?? 0)),
            'peternakan'      => max(0, (int) ($request->peternakan ?? 0)),
            'perikanan'       => max(0, (int) ($request->perikanan ?? 0)),
            'warung_hidup'    => max(0, (int) ($request->warung_hidup ?? 0)),
            'lumbung_hidup'   => max(0, (int) ($request->lumbung_hidup ?? 0)),
            'toga'            => max(0, (int) ($request->toga ?? 0)),
            'tanaman_keras'   => max(0, (int) ($request->tanaman_keras ?? 0)),
            'tanaman_lainnya' => max(0, (int) ($request->tanaman_lainnya ?? 0)),
            'industri_pangan' => max(0, (int) ($request->industri_pangan ?? 0)),
            'catatan'         => $request->catatan,
            'status'          => 'Proses',
        ]);

        return redirect()->route('pangan.index')->with(['success' => 'Berhasil Menambahkan Laporan Program Pangan']);
    }

    /**
     * Tampilkan Review / Edit Laporan Program Pangan
     */
    public function edit(string $id)
    {
        $data = Pangan::find($id);
        if (!$data) {
            return redirect()->back()->with('error', 'Data tidak ditemukan!');
        }

        $kecamatan = $data->kecamatan_id ? Subdistrict::find($data->kecamatan_id) : null;
        $desa = $data->desa_id ? Village::find($data->desa_id) : null;

        if (!$kecamatan && $data->id_user) {
            $user = Pengguna::find($data->id_user);
            if ($user) {
                $kecamatan = Subdistrict::find($user->id_subdistrict);
                $desa = Village::find($user->id_village);
            }
        }

        return view('backend.tampil_pangan', compact('data', 'kecamatan', 'desa'));
    }

    /**
     * Update Status & Data Laporan Program Pangan (Persetujuan / Penolakan)
     */
    public function update(Request $request, string $id)
    {
        $data = Pangan::find($id);
        if (!$data) {
            return redirect()->route('pangan.index')->with(['error' => 'Data tidak ditemukan!']);
        }

        $request->validate([
            'status'  => 'required|in:Revisi,Ditolak,Disetujui,Disetujui1,Disetujui2',
            'catatan' => 'nullable|string',
        ], [
            'status.required' => 'Harap pilih status laporan.',
            'status.in'       => 'Status laporan tidak valid.',
        ]);

        $status = $this->resolveApprovalStatus($request->status);

        $approvedAt = $data->approved_at;
        $approvedBy = $data->approved_by;

        if (in_array($status, ['Disetujui1', 'Disetujui2'])) {
            $approvedAt = now();
            $approvedBy = Auth::guard('web')->id() ?? Auth::guard('pengguna')->id();
        }

        $data->update([
            'kader_pangan'    => max(0, (int) ($request->kader_pangan ?? $data->kader_pangan)),
            'beras'           => max(0, (int) ($request->beras ?? $data->beras)),
            'non_beras'       => max(0, (int) ($request->non_beras ?? $data->non_beras)),
            'peternakan'      => max(0, (int) ($request->peternakan ?? $data->peternakan)),
            'perikanan'       => max(0, (int) ($request->perikanan ?? $data->perikanan)),
            'warung_hidup'    => max(0, (int) ($request->warung_hidup ?? $data->warung_hidup)),
            'lumbung_hidup'   => max(0, (int) ($request->lumbung_hidup ?? $data->lumbung_hidup)),
            'toga'            => max(0, (int) ($request->toga ?? $data->toga)),
            'tanaman_keras'   => max(0, (int) ($request->tanaman_keras ?? $data->tanaman_keras)),
            'tanaman_lainnya' => max(0, (int) ($request->tanaman_lainnya ?? $data->tanaman_lainnya)),
            'industri_pangan' => max(0, (int) ($request->industri_pangan ?? $data->industri_pangan)),
            'status'          => $status,
            'catatan'         => $request->catatan,
            'approved_at'     => $approvedAt,
            'approved_by'     => $approvedBy,
        ]);

        return redirect()->route('pangan.index')->with(['success' => 'Berhasil Memperbarui Status Laporan Pangan']);
    }

    /**
     * Hapus Laporan Program Pangan
     */
    public function destroy(string $id)
    {
        $data = Pangan::find($id);
        if ($data) {
            $data->delete();
            return redirect()->route('pangan.index')->with(['success' => 'Berhasil Menghapus Laporan']);
        }

        return redirect()->route('pangan.index')->with(['error' => 'Data tidak ditemukan']);
    }

    /**
     * Filter cetak rekap per periode
     */
    public function filter(Request $request)
    {
        $statusTarget = Auth::guard('web')->check() ? 'Disetujui2' : 'Disetujui1';

        if ($request->has('search') || $request->has('search2')) {
            $searchTerm = $request->has('search') ? $request->search : $request->search2;
            $isYearly = $request->has('search2');

            $pangan = $this->buildReportQuery('laporan_pangan')
                ->when($isYearly, fn($q) => $q->whereYear('laporan_pangan.created_at', $searchTerm),
                                  fn($q) => $q->where('laporan_pangan.created_at', 'LIKE', '%' . $searchTerm . '%'))
                ->where('laporan_pangan.status', $statusTarget)
                ->get();

            if ($pangan->isEmpty()) {
                return back()->with('error', 'Data tidak ditemukan');
            }

            $total_kader = $pangan->sum('kader_pangan');
            $total1 = $pangan->sum('beras');
            $total2 = $pangan->sum('non_beras');
            $total3 = $pangan->sum('peternakan');
            $total31 = $pangan->sum('perikanan');
            $total4 = $pangan->sum('warung_hidup');
            $total5 = $pangan->sum('lumbung_hidup');
            $total6 = $pangan->sum('toga');
            $total7 = $pangan->sum('tanaman_keras');
            $total_tanaman_lainnya = $pangan->sum('tanaman_lainnya');
            $total_irt_pangan = $pangan->sum('industri_pangan');

            $formattedDate = Carbon::now()->isoFormat('dddd, D MMMM YYYY');
            $created_at = $isYearly ? $searchTerm : (Carbon::hasFormat($searchTerm, 'Y-m') ? Carbon::parse($searchTerm)->isoFormat('MMMM YYYY') : $searchTerm);
            $ketua = Ttd::where('jabatan', 'Ketua')->where('pokja', 'Kelompok Kerja III')->get();

            $viewName = $isYearly ? 'backend.cetak_tahun_pokja3' : 'backend.cetak_bulan_pokja3';

            return view($viewName, compact(
                'pangan', 'total_kader', 'total1', 'total2', 'total3', 'total31',
                'total4', 'total5', 'total6', 'total7', 'total_tanaman_lainnya', 'total_irt_pangan',
                'formattedDate', 'ketua', 'created_at'
            ));
        }

        return redirect()->back();
    }
}