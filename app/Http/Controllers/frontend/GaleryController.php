<?php

namespace App\Http\Controllers\frontend;

//import Model "Post

use App\Models\Berita;
use App\Models\Galeri;

//return type View
use Illuminate\View\View;

//return type redirectResponse
use Illuminate\Http\RedirectResponse;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Str;
use App\Models\Visitor;
use Carbon\Carbon;

class GaleryController extends Controller
{
    /**
     * index
     *
     * @return View
     */
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
        $galerys = Galeri::where('status', 'upload2')

            ->when($request->search, function ($query) use ($request) {

                $query->where(function ($q) use ($request) {

                    $q->where('deskripsi', 'LIKE', '%' . $request->search . '%')

                        ->orWhere('lokasi', 'LIKE', '%' . $request->search . '%')

                        ->orWhere('bidang', 'LIKE', '%' . $request->search . '%')

                        ->orWhere('pokja', 'LIKE', '%' . $request->search . '%');
                });
            })

            ->latest()

            ->paginate(8);


        //render view with posts
        return view('frontend.galery', compact('galerys', 'visitor', 'totalMinggu', 'totalBulan', 'totalTahun', 'totalVisitors'));

        //get posts
        // $data = Galeri::latest()->paginate(6);

        // //render view with posts
        // return view('frontend.galery', compact('data'));
    }
}
