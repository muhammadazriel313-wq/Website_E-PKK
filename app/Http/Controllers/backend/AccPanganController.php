<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Traits\PokjaReportTrait;

class AccPanganController extends Controller
{
    use PokjaReportTrait;

    public function index()
    {
        $counts = $this->getReportStatusCounts('laporan_pangan');
        $pang1 = $counts['menunggu'];
        $pang2 = $counts['disetujui'];

        return view('backend.accpangan', compact('pang1', 'pang2'));
    }
}