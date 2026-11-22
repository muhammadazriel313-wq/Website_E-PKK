<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\Pangan;
use App\Traits\PokjaReportTrait;

class DecPanganController extends Controller
{
    use PokjaReportTrait;

    public function index()
    {
        $query = $this->buildReportQuery('laporan_pangan');
        $query = $this->applyApprovedFilter($query, 'laporan_pangan');

        $data2 = $query->orderBy('laporan_pangan.id', 'desc')->get();

        return view('backend.decpangan', compact('data2'));
    }

    public function destroy(string $id)
    {
        $data = Pangan::find($id);
        if ($data) {
            $data->delete();
            return redirect()->route('decpangan.index')->with(['success' => 'Berhasil Menghapus Riwayat Laporan']);
        }

        return redirect()->route('decpangan.index')->with(['error' => 'Data tidak ditemukan']);
    }
}