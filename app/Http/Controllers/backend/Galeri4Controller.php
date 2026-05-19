<?php

namespace App\Http\Controllers\backend;

use App\Models\Ttd;
use App\Models\Ttds;
use App\Models\Galeri;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Http\Controllers\Controller;

class Galeri4Controller extends Controller
{
    public function index()
    {
        $pertama = 0;
        $kedua = 0;
        $ketiga = 0;
        $keempat = 0;
        $kelima = 0;

        // =====================================
        if (Auth::guard('web')->check()) {

            $pertama = Galeri::leftJoin(
                'users_mobile',
                'galerys.id_user',
                '=',
                'users_mobile.id'
            )

                ->where('galerys.bidang', 'Kesehatan')

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

                ->where('galerys.bidang', 'Kelestarian Lingkungan Hidup')

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

                ->where('galerys.bidang', 'Perencanaan Sehat')

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

                ->where('galerys.bidang', 'Kader Pokja IV')

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
            $kelima = Galeri::leftJoin(
                'users_mobile',
                'galerys.id_user',
                '=',
                'users_mobile.id'
            )

                ->whereIn('galerys.bidang', ['Inovasi Prioritas', 'Inovasi Unggulan'])

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
                    ->where('galerys.bidang', 'Kesehatan')

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
                    ->where('galerys.bidang', 'Kelestarian Lingkungan Hidup')

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
                    ->where('galerys.bidang', 'Perencanaan Sehat')

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
                    ->where('galerys.bidang', 'Kader Pokja IV')

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
                $kelima = Galeri::leftJoin(
                    'users_mobile',
                    'galerys.id_user',
                    '=',
                    'users_mobile.id'
                )
                    ->whereIn('galerys.bidang', ['Inovasi Prioritas', 'Inovasi Unggulan'])

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

        return view('backend.galeripokja4', compact('pertama', 'kedua', 'ketiga', 'keempat', 'kelima'));
    }

    public function filter(Request $request)
    {
        if ($request->has('search')) {
            $kesehatan = Galeri::where('created_at', 'LIKE', '%' . $request->search . '%')->where('pokja', 'pokja I')->where('bidang', 'Kesehatan')->where('status', 'Upload')->orderBy('created_at', 'ASC')->get();
            $kelestarian = Galeri::where('created_at', 'LIKE', '%' . $request->search . '%')->where('pokja', 'pokja I')->where('bidang', 'Kelestarian Lingkungan Hidup')->where('status', 'Upload')->orderBy('created_at', 'ASC')->get();
            $perencanaan = Galeri::where('created_at', 'LIKE', '%' . $request->search . '%')->where('pokja', 'pokja I')->where('bidang', 'Perencanaan Sehat')->where('status', 'Upload')->orderBy('created_at', 'ASC')->get();
            $laporanpokja4 = Galeri::where('created_at', 'LIKE', '%' . $request->search . '%')->where('pokja', 'pokja I')->where('bidang', 'Kader Pokja IV')->where('status', 'Upload')->orderBy('created_at', 'ASC')->get();

            $kesehatan1 = Galeri::where('created_at', 'LIKE', '%' . $request->search . '%')->where('pokja', 'pokja I')->where('bidang', 'Kesehatan')->where('status', 'Upload')->orderBy('created_at', 'ASC')->get();
            $kelestarian1 = Galeri::where('created_at', 'LIKE', '%' . $request->search . '%')->where('pokja', 'pokja I')->where('bidang', 'Kelestarian Lingkungan Hidup')->where('status', 'Upload')->orderBy('created_at', 'ASC')->get();
            $perencanaan1 = Galeri::where('created_at', 'LIKE', '%' . $request->search . '%')->where('pokja', 'pokja I')->where('bidang', 'Perencanaan Sehat')->where('status', 'Upload')->orderBy('created_at', 'ASC')->get();
            $laporanpokja41 = Galeri::where('created_at', 'LIKE', '%' . $request->search . '%')->where('pokja', 'pokja I')->where('bidang', 'Kader Pokja IV')->where('status', 'Upload')->orderBy('created_at', 'ASC')->get();

            $tanggal = $request->input('search');
            $carbonDate = Carbon::parse($tanggal);
            $tanggal = $carbonDate->isoFormat('MMMM');

            $tanggal2 = $request->input('search');

            $ketua = Ttd::where('jabatan', 'Ketua')->where('pokja', 'Kelompok Kerja IV')->get();
            $wakil = Ttds::where('jabatan', 'Wakil Ketua I')->get();

            return view('backend.cetak_galeri_bulan_pokja4', compact('kesehatan', 'kelestarian', 'perencanaan', 'laporanpokja4', 'kesehatan1', 'kelestarian1', 'perencanaan1', 'laporanpokja41', 'tanggal', 'tanggal2', 'ketua', 'wakil'));
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

            $ketua = Ttd::where('jabatan', 'Ketua')->where('pokja', 'Kelompok Kerja IV')->get();
            $wakil = Ttds::where('jabatan', 'Wakil Ketua I')->get();

            return view('backend.cetak_galeri_tahun_pokja4', compact(
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
