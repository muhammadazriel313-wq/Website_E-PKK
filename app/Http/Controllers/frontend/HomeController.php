<?php

namespace App\Http\Controllers\frontend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Visitor;
use App\Models\Galeri;
use Carbon\Carbon;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $today = now()->format('Y-m-d');
        $visitor = Visitor::firstOrNew(['tanggal' => $today]);
        $visitor->count++;
        $visitor->save();

        $startOfWeek = Carbon::now()->startOfWeek();
        $endOfWeek = Carbon::now()->endOfWeek();

        $totalMinggu = Visitor::whereBetween('tanggal', [$startOfWeek, $endOfWeek])
            ->sum('count');

        $startOfMonth = Carbon::now()->startOfMonth();
        $endOfMonth = Carbon::now()->endOfMonth();

        $totalBulan = Visitor::whereBetween('tanggal', [$startOfMonth, $endOfMonth])
            ->sum('count');

        $startOfYear = Carbon::now()->startOfYear();
        $endOfYear = Carbon::now()->endOfYear();

        $totalTahun = Visitor::whereBetween('tanggal', [$startOfYear, $endOfYear])
            ->sum('count');

        $totalVisitors = Visitor::sum('count');

        //  GALERI TERBARU
        $galerys = Galeri::where('status', 'upload2')
            ->latest()
            ->take(6)
            ->get();

        return view('home', compact(
            'visitor',
            'totalMinggu',
            'totalBulan',
            'totalTahun',
            'totalVisitors',
            'galerys'
        ));
    }
}
