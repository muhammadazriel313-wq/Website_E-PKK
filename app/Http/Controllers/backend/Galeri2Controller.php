<?php

namespace App\Http\Controllers\backend;

use App\Models\Ttd;
use App\Models\Ttds;
use App\Models\Galeri;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Http\Controllers\Controller;

class Galeri2Controller extends Controller
{
    public function index()
    {
        $pertama = 0;
        $kedua = 0;
        // =====================================
        if (Auth::guard('web')->check()) {

            $pertama = Galeri::leftJoin(
                'users_mobile',
                'galerys.id_user',
                '=',
                'users_mobile.id'
            )

                ->where('galerys.bidang', 'Pendidikan & Ketrampilan')

                ->where(function ($query) {

                    // DATA DESA YANG SUDAH DIREVIEW KEC
                    $query->where(function ($q) {

                        $q->where('users_mobile.id_role', 1)

                            ->whereIn('galerys.status', [
                                'upload1',
                                'upload2'
                            ]);
                    })

                        // DATA MOBILE KECAMATAN
                        ->orWhere(function ($q) {

                            $q->where('users_mobile.id_role', 2)

                                ->whereIn('galerys.status', [
                                    'Proses',
                                    'upload2'
                                ]);
                        });
                })

                ->count();



            $kedua = Galeri::leftJoin(
                'users_mobile',
                'galerys.id_user',
                '=',
                'users_mobile.id'
            )

                ->where('galerys.bidang', 'Pengembangan Kehidupan Berkoperasi')

                ->where(function ($query) {

                    $query->where(function ($q) {

                        $q->where('users_mobile.id_role', 1)

                            ->whereIn('galerys.status', [
                                'upload1',
                                'upload2'
                            ]);
                    })

                        ->orWhere(function ($q) {

                            $q->where('users_mobile.id_role', 2)

                                ->whereIn('galerys.status', [
                                    'Proses',
                                    'upload2'
                                ]);
                        });
                })

                ->count();

        }
        // =====================================
        // WEB KECAMATAN
        // =====================================
        elseif (Auth::guard('pengguna')->check()) {

            $user = Auth::guard('pengguna')->user();

            if ($user->id_role == 2) {

                $pertama = Galeri::leftJoin(
                    'users_mobile',
                    'galerys.id_user',
                    '=',
                    'users_mobile.id'
                )
                    ->where('galerys.bidang', 'Pendidikan & Ketrampilan')

                    // HANYA DATA DESA
                    ->where('users_mobile.id_role', 1)

                    ->where(
                        'users_mobile.id_subdistrict',
                        $user->id_subdistrict
                    )

                    ->whereIn('galerys.status', [
                        'Proses',
                        'upload1',
                        'upload2'
                    ])

                    ->count();



                $kedua = Galeri::leftJoin(
                    'users_mobile',
                    'galerys.id_user',
                    '=',
                    'users_mobile.id'
                )
                    ->where('galerys.bidang', 'Pengembangan Kehidupan Berkoperasi')

                    // HANYA DATA DESA
                    ->where('users_mobile.id_role', 1)

                    ->where(
                        'users_mobile.id_subdistrict',
                        $user->id_subdistrict
                    )

                    ->whereIn('galerys.status', [
                        'Proses',
                        'upload1',
                        'upload2'
                    ])

                    ->count();
            }
        }

        return view('backend.galeripokja2', compact('pertama', 'kedua'));
    }

    public function filter(Request $request)
    {
        if ($request->has('search')) {
            $pendidikan = Galeri::where('created_at', 'LIKE', '%' . $request->search . '%')
                ->where('pokja', 'pokja I')
                ->where('bidang', 'Pendidikan & Ketrampilan')
                ->where('status', 'Upload')
                ->orderBy('created_at', 'ASC')
                ->get();
            $pengembangan = Galeri::where('created_at', 'LIKE', '%' . $request->search . '%')
                ->where('pokja', 'pokja I')
                ->where('bidang', 'Pengembangan Kehidupan Berkoperasi')
                ->where('status', 'Upload')
                ->orderBy('created_at', 'ASC')
                ->get();

            $pendidikan1 = Galeri::where('created_at', 'LIKE', '%' . $request->search . '%')
                ->where('pokja', 'pokja I')
                ->where('bidang', 'Pendidikan & Ketrampilan')
                ->where('status', 'Upload')
                ->orderBy('created_at', 'ASC')
                ->get();
            $pengembangan1 = Galeri::where('created_at', 'LIKE', '%' . $request->search . '%')
                ->where('pokja', 'pokja I')
                ->where('bidang', 'Pengembangan Kehidupan Berkoperasi')
                ->where('status', 'Upload')
                ->orderBy('created_at', 'ASC')
                ->get();

            $tanggal = $request->input('search');
            $carbonDate = Carbon::parse($tanggal);
            $tanggal = $carbonDate->isoFormat('MMMM');

            $tanggal2 = $request->input('search');

            $ketua = Ttd::where('jabatan', 'Ketua')->where('pokja', 'Kelompok Kerja II')->get();
            $wakil = Ttds::where('jabatan', 'Wakil Ketua I')->get();

            return view('backend.cetak_galeri_bulan_pokja2', compact('pendidikan', 'pendidikan1', 'pengembangan', 'pengembangan1', 'tanggal', 'tanggal2', 'ketua', 'wakil'));
        } elseif ($request->has('search2')) {
            $janu = 1;
            $jan = Galeri::whereMonth('created_at', $janu)
                ->where('created_at', 'LIKE', '%' . $request->search2 . '%')
                ->where('pokja', 'pokja I')
                ->where('status', 'Upload')
                ->orderBy('created_at', 'ASC')
                ->get();

            $febr = 2;
            $feb = Galeri::whereMonth('created_at', $febr)
                ->where('created_at', 'LIKE', '%' . $request->search2 . '%')
                ->where('pokja', 'pokja I')
                ->where('status', 'Upload')
                ->orderBy('created_at', 'ASC')
                ->get();

            $mare = 3;
            $mar = Galeri::whereMonth('created_at', $mare)
                ->where('created_at', 'LIKE', '%' . $request->search2 . '%')
                ->where('pokja', 'pokja I')
                ->where('status', 'Upload')
                ->orderBy('created_at', 'ASC')
                ->get();

            $apri = 4;
            $apr = Galeri::whereMonth('created_at', $apri)
                ->where('created_at', 'LIKE', '%' . $request->search2 . '%')
                ->where('pokja', 'pokja I')
                ->where('status', 'Upload')
                ->orderBy('created_at', 'ASC')
                ->get();

            $meii = 5;
            $mei = Galeri::whereMonth('created_at', $meii)
                ->where('created_at', 'LIKE', '%' . $request->search2 . '%')
                ->where('pokja', 'pokja I')
                ->where('status', 'Upload')
                ->orderBy('created_at', 'ASC')
                ->get();

            $juni = 6;
            $jun = Galeri::whereMonth('created_at', $juni)
                ->where('created_at', 'LIKE', '%' . $request->search2 . '%')
                ->where('pokja', 'pokja I')
                ->where('status', 'Upload')
                ->orderBy('created_at', 'ASC')
                ->get();

            $juli = 7;
            $jul = Galeri::whereMonth('created_at', $juli)
                ->where('created_at', 'LIKE', '%' . $request->search2 . '%')
                ->where('pokja', 'pokja I')
                ->where('status', 'Upload')
                ->orderBy('created_at', 'ASC')
                ->get();

            $agus = 8;
            $agu = Galeri::whereMonth('created_at', $agus)
                ->where('created_at', 'LIKE', '%' . $request->search2 . '%')
                ->where('pokja', 'pokja I')
                ->where('status', 'Upload')
                ->orderBy('created_at', 'ASC')
                ->get();

            $sept = 9;
            $sep = Galeri::whereMonth('created_at', $sept)
                ->where('created_at', 'LIKE', '%' . $request->search2 . '%')
                ->where('pokja', 'pokja I')
                ->where('status', 'Upload')
                ->orderBy('created_at', 'ASC')
                ->get();

            $okto = 10;
            $okt = Galeri::whereMonth('created_at', $okto)
                ->where('created_at', 'LIKE', '%' . $request->search2 . '%')
                ->where('pokja', 'pokja I')
                ->where('status', 'Upload')
                ->orderBy('created_at', 'ASC')
                ->get();

            $nove = 11;
            $nov = Galeri::whereMonth('created_at', $nove)
                ->where('created_at', 'LIKE', '%' . $request->search2 . '%')
                ->where('pokja', 'pokja I')
                ->where('status', 'Upload')
                ->orderBy('created_at', 'ASC')
                ->get();

            $dese = 12;
            $des = Galeri::whereMonth('created_at', $dese)
                ->where('created_at', 'LIKE', '%' . $request->search2 . '%')
                ->where('pokja', 'pokja I')
                ->where('status', 'Upload')
                ->orderBy('created_at', 'ASC')
                ->get();

            $currentDate = Carbon::now();
            $formattedDate = $currentDate->isoFormat('dddd, D MMMM YYYY');
            $tanggal = $request->input('search2');

            $tanggal2 = $request->input('search2');

            $ketua = Ttd::where('jabatan', 'Ketua')->where('pokja', 'Kelompok Kerja II')->get();
            $wakil = Ttds::where('jabatan', 'Wakil Ketua I')->get();

            return view('backend.cetak_galeri_tahun_pokja2', compact('jan', 'feb', 'mar', 'apr', 'mei', 'jun', 'jul', 'agu', 'sep', 'okt', 'nov', 'des', 'tanggal', 'tanggal2', 'ketua', 'wakil'));
        } else {
        }
    }
}
