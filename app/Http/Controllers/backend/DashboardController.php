<?php

namespace App\Http\Controllers\backend;

use Illuminate\Http\Request;
use App\Models\Pengguna;
use App\Models\BidangUmum;
use App\Models\GotongRoyong;
use App\Models\Penghayatan;
use App\Models\Pendidikan;
use App\Models\Pengembangan;
use App\Models\Pangan;
use App\Models\Sandang;
use App\Models\Perumahan;
use App\Models\LaporanPokja1;
use App\Models\LaporanPokja3;
use App\Models\LaporanPokja4;
use App\Models\Kesehatan;
use App\Models\Inovasi;
use App\Models\KelestarianLingkunganHidup;
use App\Models\PerencanaanSehat;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {

        // =========================================
        // JUMLAH USER
        // =========================================

        if (Auth::guard('pengguna')->check()) {

            $loggedInUser = Auth::guard('pengguna')->user();

            // KECAMATAN
            if ($loggedInUser->id_role == 2) {

                $jmlh_user = Pengguna::where('id_role', 1)
                    ->where(
                        'id_subdistrict',
                        $loggedInUser->id_subdistrict
                    )
                    ->count();
            } else {

                // DESA
                $jmlh_user = 1;
            }
        } else {

            // WEB KABUPATEN
            $jmlh_user = Pengguna::count();
        }

        // =========================================
        // FILTER QUERY
        // =========================================

        $getFilteredQuery = function ($model) {

            // =====================================
            // WEB KECAMATAN
            // =====================================

            if (Auth::guard('pengguna')->check()) {

                $user = Auth::guard('pengguna')->user();

                // ROLE KECAMATAN
                if ($user->id_role == 2) {

                    return $model
                        ->leftJoin(
                            'users_mobile',
                            $model->getTable() . '.id_user',
                            '=',
                            'users_mobile.id'
                        )
                        ->where('users_mobile.id_subdistrict', $user->id_subdistrict)
                        // HANYA LAPORAN DESA
                        ->where('users_mobile.id_role', 1)
                        ->where(function ($query) use ($model) {
                            $query->where($model->getTable() . '.status', 'Proses')
                                ->orWhere($model->getTable() . '.status', 'Disetujui1');
                        });
                }
            }

            // =====================================
            // WEB KABUPATEN
            // =====================================

            return $model
                ->leftJoin(
                    'users_mobile',
                    $model->getTable() . '.id_user',
                    '=',
                    'users_mobile.id'
                )

                ->where(function ($query) use ($model) {

                    // LAPORAN DESA
                    $query->where(function ($q) use ($model) {

                        $q->where('users_mobile.id_role', 1)

                            ->where(function ($qq) use ($model) {

                                $qq->where($model->getTable() . '.status', 'Disetujui1')
                                    ->orWhere($model->getTable() . '.status', 'Disetujui2');
                            });
                    })

                        // LAPORAN MOBILE KECAMATAN
                        ->orWhere(function ($q) use ($model) {

                            $q->where('users_mobile.id_role', 2)
                                ->whereIn(
                                    $model->getTable() . '.status',
                                    ['Proses', 'Disetujui1','Disetujui2']
                                );
                        });
                });
        };

        // =========================================
        // BIDANG UMUM
        // =========================================

        $bidangumum = $getFilteredQuery(new BidangUmum())->count();

        // =========================================
        // POKJA 1
        // =========================================

        $bidang11 = $getFilteredQuery(new GotongRoyong())->count();
        $bidang12 = $getFilteredQuery(new Penghayatan())->count();
        $laporan1 = $getFilteredQuery(new LaporanPokja1())->count();

        $totalbidang1 =
            $bidang11 +
            $bidang12 +
            $laporan1;

        // =========================================
        // POKJA 2
        // =========================================

        $bidang21 = $getFilteredQuery(new Pendidikan())->count();
        $bidang22 = $getFilteredQuery(new Pengembangan())->count();

        $totalbidang2 =
            $bidang21 +
            $bidang22;

        // =========================================
        // POKJA 3
        // =========================================

        $bidang31 = $getFilteredQuery(new Pangan())->count();
        $bidang32 = $getFilteredQuery(new Sandang())->count();
        $bidang33 = $getFilteredQuery(new Perumahan())->count();
        $laporan3 = $getFilteredQuery(new LaporanPokja3())->count();

        $totalbidang3 =
            $bidang31 +
            $bidang32 +
            $bidang33 +
            $laporan3;

        // =========================================
        // POKJA 4
        // =========================================

        $bidang41 = $getFilteredQuery(new Kesehatan())->count();

        $bidang42 = $getFilteredQuery(
            new KelestarianLingkunganHidup()
        )->count();

        $bidang43 = $getFilteredQuery(
            new PerencanaanSehat()
        )->count();

        $laporan4 = $getFilteredQuery(
            new LaporanPokja4()
        )->count();
        
        $laporan44 = $getFilteredQuery(
            new Inovasi()
        )->count();

        $totalbidang4 =
            $bidang41 +
            $bidang42 +
            $bidang43 +
            $laporan44 +
            $laporan4 ;

        $totalSemuaLaporan = $bidangumum + $totalbidang1 + $totalbidang2 + $totalbidang3 + $totalbidang4;

        $detailProgramKerja = [
            [
                'kategori' => 'Bidang Umum',
                'program' => 'Laporan Umum',
                'jumlah' => $bidangumum,
                'warna' => '#ca8a04'
            ],
            [
                'kategori' => 'Pokja 1',
                'program' => 'Gotong Royong',
                'jumlah' => $bidang11,
                'warna' => '#16a34a'
            ],
            [
                'kategori' => 'Pokja 1',
                'program' => 'Penghayatan Pancasila',
                'jumlah' => $bidang12,
                'warna' => '#16a34a'
            ],
            [
                'kategori' => 'Pokja 1',
                'program' => 'Rekap Lap. Pokja 1',
                'jumlah' => $laporan1,
                'warna' => '#16a34a'
            ],
            [
                'kategori' => 'Pokja 2',
                'program' => 'Pendidikan & Ketrampilan',
                'jumlah' => $bidang21,
                'warna' => '#7c3aed'
            ],
            [
                'kategori' => 'Pokja 2',
                'program' => 'Pengemb. Berkoperasi',
                'jumlah' => $bidang22,
                'warna' => '#7c3aed'
            ],
            [
                'kategori' => 'Pokja 3',
                'program' => 'Pangan',
                'jumlah' => $bidang31,
                'warna' => '#ea580c'
            ],
            [
                'kategori' => 'Pokja 3',
                'program' => 'Sandang',
                'jumlah' => $bidang32,
                'warna' => '#ea580c'
            ],
            [
                'kategori' => 'Pokja 3',
                'program' => 'Perumahan & Tata Laksana',
                'jumlah' => $bidang33,
                'warna' => '#ea580c'
            ],
            [
                'kategori' => 'Pokja 3',
                'program' => 'Rekap Lap. Pokja 3',
                'jumlah' => $laporan3,
                'warna' => '#ea580c'
            ],
            [
                'kategori' => 'Pokja 4',
                'program' => 'Kesehatan',
                'jumlah' => $bidang41,
                'warna' => '#db2777'
            ],
            [
                'kategori' => 'Pokja 4',
                'program' => 'Kelestarian Lingkungan',
                'jumlah' => $bidang42,
                'warna' => '#db2777'
            ],
            [
                'kategori' => 'Pokja 4',
                'program' => 'Perencanaan Sehat',
                'jumlah' => $bidang43,
                'warna' => '#db2777'
            ],
            [
                'kategori' => 'Pokja 4',
                'program' => 'Rekap Lap. Pokja 4',
                'jumlah' => $laporan4,
                'warna' => '#db2777'
            ],
            [
                'kategori' => 'Pokja 4',
                'program' => 'Inovasi',
                'jumlah' => $laporan44,
                'warna' => '#db2777'
            ],
        ];

        // =========================================
        // DATA TREN BULANAN (GRAFIK AREA BIRU)
        // =========================================
        $selectedYear = date('Y');
        $monthlyTotals = array_fill(1, 12, 0);
        $pokjaMonthly = [
            'umum' => array_fill(1, 12, 0),
            'pokja1' => array_fill(1, 12, 0),
            'pokja2' => array_fill(1, 12, 0),
            'pokja3' => array_fill(1, 12, 0),
            'pokja4' => array_fill(1, 12, 0),
        ];

        $groups = [
            'umum' => [new BidangUmum()],
            'pokja1' => [new GotongRoyong(), new Penghayatan(), new LaporanPokja1()],
            'pokja2' => [new Pendidikan(), new Pengembangan()],
            'pokja3' => [new Pangan(), new Sandang(), new Perumahan(), new LaporanPokja3()],
            'pokja4' => [new Kesehatan(), new KelestarianLingkunganHidup(), new PerencanaanSehat(), new LaporanPokja4(), new Inovasi()],
        ];

        foreach ($groups as $groupKey => $models) {
            foreach ($models as $m) {
                $tbl = $m->getTable();
                $rows = $getFilteredQuery($m)
                    ->selectRaw("MONTH({$tbl}.created_at) as bln, count(*) as total")
                    ->whereYear("{$tbl}.created_at", $selectedYear)
                    ->groupBy('bln')
                    ->get();
                foreach ($rows as $r) {
                    $b = (int)$r->bln;
                    if ($b >= 1 && $b <= 12) {
                        $pokjaMonthly[$groupKey][$b] += (int)$r->total;
                        $monthlyTotals[$b] += (int)$r->total;
                    }
                }
            }
        }

        $chartMonthlyData = array_values($monthlyTotals);
        $chartPokjaMonthly = [
            'umum' => array_values($pokjaMonthly['umum']),
            'pokja1' => array_values($pokjaMonthly['pokja1']),
            'pokja2' => array_values($pokjaMonthly['pokja2']),
            'pokja3' => array_values($pokjaMonthly['pokja3']),
            'pokja4' => array_values($pokjaMonthly['pokja4']),
        ];

        return view(
            'backend.dashboard',
            compact(
                'jmlh_user',
                'bidangumum',
                'totalbidang1',
                'totalbidang2',
                'totalbidang3',
                'totalbidang4',
                'totalSemuaLaporan',
                'detailProgramKerja',
                'chartMonthlyData',
                'chartPokjaMonthly',
                'selectedYear',
                'bidang11',
                'bidang12',
                'laporan1',
                'bidang21',
                'bidang22',
                'bidang31',
                'bidang32',
                'bidang33',
                'laporan3',
                'bidang41',
                'bidang42',
                'bidang43',
                'laporan4',
                'laporan44'
            )
        );
    }
}
