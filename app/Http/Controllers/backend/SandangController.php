<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\Pengguna;
use App\Models\Sandang;
use App\Models\Subdistrict;
use App\Models\Village;
use App\Traits\PokjaReportTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class SandangController extends Controller
{
    use PokjaReportTrait;

    /**
     * Halaman Daftar Laporan Menunggu Persetujuan - Program Sandang
     */
    public function index()
    {
        $query = $this->buildReportQuery('laporan_sandang');
        $query = $this->applyWaitingApprovalFilter($query, 'laporan_sandang');

        $data = $query->orderBy('laporan_sandang.id', 'desc')->get();

        return view('backend.sandang', compact('data'));
    }

    /**
     * Form Input Laporan Baru - Program Sandang
     */
    public function create()
    {
        $kecamatanList = Subdistrict::orderBy('name', 'asc')->get();
        $desaList = Village::orderBy('name', 'asc')->get();

        return view('backend.input_sandang', compact('kecamatanList', 'desaList'));
    }

    /**
     * Simpan Laporan Baru - Program Sandang
     */
    public function store(Request $request)
    {
        $request->validate([
            'kecamatan_id' => 'required',
            'desa_id'      => 'required',
        ]);

        $uuid = 'KP3B2-' . strtoupper(Str::random(6));

        $idUser = null;
        if (Auth::guard('pengguna')->check()) {
            $idUser = Auth::guard('pengguna')->id();
        }

        Sandang::create([
            'uuid'             => $uuid,
            'id_user'          => $idUser,
            'kecamatan_id'     => $request->kecamatan_id,
            'desa_id'          => $request->desa_id,
            'kader_sandang'    => max(0, (int) ($request->kader_sandang ?? 0)),
            'industri_pangan'  => max(0, (int) ($request->industri_pangan ?? $request->pangan ?? 0)),
            'industri_sandang' => max(0, (int) ($request->industri_sandang ?? $request->sandang ?? 0)),
            'jasa'             => max(0, (int) ($request->jasa ?? 0)),
            'catatan'          => $request->catatan,
            'status'           => 'Proses',
        ]);

        return redirect()->route('sandang.index')->with(['success' => 'Berhasil Menambahkan Laporan Program Sandang']);
    }

    /**
     * Tampilkan Review / Edit Laporan Program Sandang
     */
    public function edit(string $id)
    {
        $data = Sandang::find($id);
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

        return view('backend.tampil_sandang', compact('data', 'kecamatan', 'desa'));
    }

    /**
     * Update Status & Data Laporan Program Sandang (Persetujuan / Penolakan)
     */
    public function update(Request $request, string $id)
    {
        $data = Sandang::find($id);
        if (!$data) {
            return redirect()->route('sandang.index')->with(['error' => 'Data tidak ditemukan!']);
        }

        $status = $this->resolveApprovalStatus($request->status);

        $approvedAt = $data->approved_at;
        $approvedBy = $data->approved_by;

        if (in_array($status, ['Disetujui1', 'Disetujui2'])) {
            $approvedAt = now();
            $approvedBy = Auth::guard('web')->id() ?? Auth::guard('pengguna')->id();
        }

        $data->update([
            'kader_sandang'    => max(0, (int) ($request->kader_sandang ?? $data->kader_sandang)),
            'industri_pangan'  => max(0, (int) ($request->industri_pangan ?? $request->pangan ?? $data->industri_pangan)),
            'industri_sandang' => max(0, (int) ($request->industri_sandang ?? $request->sandang ?? $data->industri_sandang)),
            'jasa'             => max(0, (int) ($request->jasa ?? $data->jasa)),
            'status'           => $status,
            'catatan'          => $request->catatan,
            'approved_at'      => $approvedAt,
            'approved_by'      => $approvedBy,
        ]);

        return redirect()->route('sandang.index')->with(['success' => 'Status Laporan Sandang Berhasil Diperbarui']);
    }

    /**
     * Hapus Laporan Program Sandang
     */
    public function destroy(string $id)
    {
        $data = Sandang::find($id);
        if ($data) {
            $data->delete();
            return redirect()->route('sandang.index')->with(['success' => 'Berhasil Menghapus Laporan']);
        }

        return redirect()->route('sandang.index')->with(['error' => 'Data tidak ditemukan']);
    }
}