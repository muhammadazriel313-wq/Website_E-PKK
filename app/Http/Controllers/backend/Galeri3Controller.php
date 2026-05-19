<?php

namespace App\Http\Controllers\backend;

use App\Models\Ttd;
use App\Models\Ttds;
use App\Models\Galeri;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;
use App\Http\Controllers\Controller;

class Galeri3Controller extends Controller
{
    public function index()
    {
        $pertama = 0;
        $kedua = 0;
        $ketiga = 0;
        $keempat = 0;

        // =====================================
        if (Auth::guard('web')->check()) {

            $pertama = Galeri::leftJoin(
                'users_mobile',
                'galerys.id_user',
                '=',
                'users_mobile.id'
            )

                ->where('galerys.bidang', 'Program Pangan')

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

                ->where('galerys.bidang', 'Program Sandang')

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
            $ketiga = Galeri::leftJoin(
                'users_mobile',
                'galerys.id_user',
                '=',
                'users_mobile.id'
            )

                ->where('galerys.bidang', 'Program Perumahan & Tata Laksana Rumah Tangga')

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
            $keempat = Galeri::leftJoin(
                'users_mobile',
                'galerys.id_user',
                '=',
                'users_mobile.id'
            )

                ->where('galerys.bidang', 'Kader Pokja III')

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
                    ->where('galerys.bidang', 'Program Pangan')

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
                    ->where('galerys.bidang','Program Sandang')

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

                $ketiga = Galeri::leftJoin(
                    'users_mobile',
                    'galerys.id_user',
                    '=',
                    'users_mobile.id'
                )
                    ->where('galerys.bidang','Program Perumahan & Tata Laksana Rumah Tangga')

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

                $keempat = Galeri::leftJoin(
                    'users_mobile',
                    'galerys.id_user',
                    '=',
                    'users_mobile.id'
                )
                    ->where('galerys.bidang','Kader Pokja III')

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

        return view('backend.galeripokja3', compact('pertama', 'kedua', 'ketiga', 'keempat'));
    }

    public function filter(Request $request)
    {
        if ($request->has('search')) {
            $pangan = Galeri::where('created_at', 'LIKE', '%' . $request->search . '%')->where('pokja', 'pokja I')->where('bidang', 'Program Pangan')->where('status', 'Upload')->orderBy('created_at', 'ASC')->get();
            $sandang = Galeri::where('created_at', 'LIKE', '%' . $request->search . '%')->where('pokja', 'pokja I')->where('bidang', 'Program Sandang')->where('status', 'Upload')->orderBy('created_at', 'ASC')->get();
            $perumahan = Galeri::where('created_at', 'LIKE', '%' . $request->search . '%')->where('pokja', 'pokja I')->where('bidang', 'Program Perumahan & Tata Laksana Rumah Tangga')->where('status', 'Upload')->orderBy('created_at', 'ASC')->get();
            $laporanpokja3 = Galeri::where('created_at', 'LIKE', '%' . $request->search . '%')->where('pokja', 'pokja I')->where('bidang', 'Kader Pokja 3')->where('status', 'Upload')->orderBy('created_at', 'ASC')->get();

            $pangan1 = Galeri::where('created_at', 'LIKE', '%' . $request->search . '%')->where('pokja', 'pokja I')->where('bidang', 'Program Pangan')->where('status', 'Upload')->orderBy('created_at', 'ASC')->get();
            $sandang2 = Galeri::where('created_at', 'LIKE', '%' . $request->search . '%')->where('pokja', 'pokja I')->where('bidang', 'Program Sandang')->where('status', 'Upload')->orderBy('created_at', 'ASC')->get();
            $perumahan3 = Galeri::where('created_at', 'LIKE', '%' . $request->search . '%')->where('pokja', 'pokja I')->where('bidang', 'Program Perumahan & Tata Taksana Rumah Tangga')->where('status', 'Upload')->orderBy('created_at', 'ASC')->get();
            $laporanpokja31 = Galeri::where('created_at', 'LIKE', '%' . $request->search . '%')->where('pokja', 'pokja I')->where('bidang', 'Kader Pokja 3')->where('status', 'Upload')->orderBy('created_at', 'ASC')->get();

            $tanggal = $request->input('search');
            $carbonDate = Carbon::parse($tanggal);
            $tanggal = $carbonDate->isoFormat('MMMM');

            $tanggal2 = $request->input('search');

            $ketua = Ttd::where('jabatan', 'Ketua')->where('pokja', 'Kelompok Kerja III')->get();
            $wakil = Ttds::where('jabatan', 'Wakil Ketua I')->get();

            return view('backend.cetak_galeri_bulan_pokja3', compact('pangan', 'sandang', 'perumahan', 'laporanpokja3', 'pangan1', 'sandang2', 'perumahan3', 'laporanpokja31', 'tanggal', 'tanggal2', 'ketua', 'wakil'));
        } elseif ($request->has('search2')) {
            $janu = 1;
            $jan = Galeri::whereMonth('created_at', $janu)->where('created_at', 'LIKE', '%' . $request->search2 . '%')->where('pokja', 'pokja I')->where('status', 'Upload')->orderBy('created_at', 'ASC')->get();

            $febr = 2;
            $feb = Galeri::whereMonth('created_at', $febr)->where('created_at', 'LIKE', '%' . $request->search2 . '%')->where('pokja', 'pokja I')->where('status', 'Upload')->orderBy('created_at', 'ASC')->get();

            $mare = 3;
            $mar = Galeri::whereMonth('created_at', $mare)->where('created_at', 'LIKE', '%' . $request->search2 . '%')->where('pokja', 'pokja I')->where('status', 'Upload')->orderBy('created_at', 'ASC')->get();

            $apri = 4;
            $apr = Galeri::whereMonth('created_at', $apri)->where('created_at', 'LIKE', '%' . $request->search2 . '%')->where('pokja', 'pokja I')->where('status', 'Upload')->orderBy('created_at', 'ASC')->get();

            $meii = 5;
            $mei = Galeri::whereMonth('created_at', $meii)->where('created_at', 'LIKE', '%' . $request->search2 . '%')->where('pokja', 'pokja I')->where('status', 'Upload')->orderBy('created_at', 'ASC')->get();

            $juni = 6;
            $jun = Galeri::whereMonth('created_at', $juni)->where('created_at', 'LIKE', '%' . $request->search2 . '%')->where('pokja', 'pokja I')->where('status', 'Upload')->orderBy('created_at', 'ASC')->get();

            $juli = 7;
            $jul = Galeri::whereMonth('created_at', $juli)->where('created_at', 'LIKE', '%' . $request->search2 . '%')->where('pokja', 'pokja I')->where('status', 'Upload')->orderBy('created_at', 'ASC')->get();

            $agus = 8;
            $agu = Galeri::whereMonth('created_at', $agus)->where('created_at', 'LIKE', '%' . $request->search2 . '%')->where('pokja', 'pokja I')->where('status', 'Upload')->orderBy('created_at', 'ASC')->get();

            $sept = 9;
            $sep = Galeri::whereMonth('created_at', $sept)->where('created_at', 'LIKE', '%' . $request->search2 . '%')->where('pokja', 'pokja I')->where('status', 'Upload')->orderBy('created_at', 'ASC')->get();

            $okto = 10;
            $okt = Galeri::whereMonth('created_at', $okto)->where('created_at', 'LIKE', '%' . $request->search2 . '%')->where('pokja', 'pokja I')->where('status', 'Upload')->orderBy('created_at', 'ASC')->get();

            $nove = 11;
            $nov = Galeri::whereMonth('created_at', $nove)->where('created_at', 'LIKE', '%' . $request->search2 . '%')->where('pokja', 'pokja I')->where('status', 'Upload')->orderBy('created_at', 'ASC')->get();

            $dese = 12;
            $des = Galeri::whereMonth('created_at', $dese)->where('created_at', 'LIKE', '%' . $request->search2 . '%')->where('pokja', 'pokja I')->where('status', 'Upload')->orderBy('created_at', 'ASC')->get();

            $currentDate = Carbon::now();
            $formattedDate = $currentDate->isoFormat('dddd, D MMMM YYYY');
            $tanggal = $request->input('search2');

            $tanggal2 = $request->input('search2');

            $ketua = Ttd::where('jabatan', 'Ketua')->where('pokja', 'Kelompok Kerja III')->get();
            $wakil = Ttds::where('jabatan', 'Wakil Ketua I')->get();

            return view('backend.cetak_galeri_tahun_pokja3', compact(
                'jan',
                'feb',
                'mar',
                'apr',
                'mei',
                'jun',
                'jul',
                'agu',
                'sep',
                'okt',
                'nov',
                'des',
                'tanggal',
                'tanggal2',
                'ketua',
                'wakil'
            ));
        } else {
        }
    }
}
