<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Traits\PokjaReportTrait;

class AccSandangController extends Controller
{
    use PokjaReportTrait;

    public function index()
    {
        $counts = $this->getReportStatusCounts('laporan_sandang');
        $sand1 = $counts['menunggu'];
        $sand2 = $counts['disetujui'];

        return view('backend.accsandang', compact('sand1', 'sand2'));
    }
}