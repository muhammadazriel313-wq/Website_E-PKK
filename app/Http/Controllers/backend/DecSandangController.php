<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\Sandang;
use App\Traits\PokjaReportTrait;

class DecSandangController extends Controller
{
    use PokjaReportTrait;

    public function index()
    {
        $query = $this->buildReportQuery('laporan_sandang');
        $query = $this->applyApprovedFilter($query, 'laporan_sandang');

        $data2 = $query->orderBy('laporan_sandang.id', 'desc')->get();

        return view('backend.decsandang', compact('data2'));
    }

    public function destroy(string $id)
    {
        $data = Sandang::find($id);
        if ($data) {
            $data->delete();
            return redirect()->route('decsandang.index')->with(['success' => 'Berhasil Menghapus Riwayat Laporan']);
        }

        return redirect()->route('decsandang.index')->with(['error' => 'Data tidak ditemukan']);
    }
}