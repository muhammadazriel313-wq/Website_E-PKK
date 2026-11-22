<?php

namespace App\Traits;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

trait PokjaReportTrait
{
    /**
     * Membangun query dasar laporan dengan join pengguna, kecamatan, dan desa.
     */
    protected function buildReportQuery(string $table)
    {
        $hasDirectWilayah = in_array($table, ['laporan_pangan', 'laporan_sandang']);

        $query = DB::table($table)
            ->leftJoin('users_mobile', "{$table}.id_user", '=', 'users_mobile.id');

        if ($hasDirectWilayah) {
            $query->leftJoin('subdistrict', function ($join) use ($table) {
                $join->on('subdistrict.id', '=', DB::raw("COALESCE({$table}.kecamatan_id, users_mobile.id_subdistrict)"));
            })
            ->leftJoin('village', function ($join) use ($table) {
                $join->on('village.id', '=', DB::raw("COALESCE({$table}.desa_id, users_mobile.id_village)"));
            });
        } else {
            $query->leftJoin('subdistrict', 'subdistrict.id', '=', 'users_mobile.id_subdistrict')
                  ->leftJoin('village', 'village.id', '=', 'users_mobile.id_village');
        }

        return $query->select("{$table}.*", 'subdistrict.name as nama_kec', 'village.name as nama_desa');
    }

    /**
     * Terapkan filter hak akses untuk halaman Menunggu Persetujuan.
     */
    protected function applyWaitingApprovalFilter($query, string $table)
    {
        $hasDirectWilayah = in_array($table, ['laporan_pangan', 'laporan_sandang']);

        // 1. Web Kabupaten (Admin)
        if (Auth::guard('web')->check()) {
            return $query->where(function ($q) use ($table) {
                // Dari Desa yang sudah disetujui Kecamatan
                $q->where(function ($sub) use ($table) {
                    $sub->where('users_mobile.id_role', 1)
                        ->whereIn("{$table}.status", ['Disetujui1', 'disetujui1', 'DISETUJUI1']);
                })
                // Atau langsung dari Mobile Kecamatan yang berstatus Menunggu / Proses
                ->orWhere(function ($sub) use ($table) {
                    $sub->where('users_mobile.id_role', 2)
                        ->whereIn("{$table}.status", ['Menunggu', 'menunggu', 'MENUNGGU', 'Proses', 'proses', 'PROSES']);
                });
            });
        }

        // 2. Web Kecamatan (Role 2)
        if (Auth::guard('pengguna')->check()) {
            $user = Auth::guard('pengguna')->user();
            if ($user->id_role == 2) {
                return $query->where(function ($q) use ($table, $user, $hasDirectWilayah) {
                    $q->where('users_mobile.id_subdistrict', $user->id_subdistrict);
                    if ($hasDirectWilayah) {
                        $q->orWhere("{$table}.kecamatan_id", $user->id_subdistrict);
                    }
                })
                ->where(function ($q) use ($table) {
                    $q->where('users_mobile.id_role', 1)
                      ->orWhere("{$table}.id_role", 1);
                })
                ->whereIn("{$table}.status", ['Menunggu', 'menunggu', 'MENUNGGU', 'Proses', 'proses', 'PROSES']);
            }

            // Desa: hanya melihat laporannya sendiri yang masih Menunggu / Proses
            return $query->where("{$table}.id_user", $user->id)
                ->whereIn("{$table}.status", ['Menunggu', 'menunggu', 'MENUNGGU', 'Proses', 'proses', 'PROSES']);
        }

        return $query;
    }

    /**
     * Terapkan filter hak akses untuk halaman Riwayat / Sudah Disetujui.
     */
    protected function applyApprovedFilter($query, string $table)
    {
        // 1. Web Kabupaten (Admin): Hanya yang sudah final (Disetujui2)
        if (Auth::guard('web')->check()) {
            return $query->whereIn("{$table}.status", ['Disetujui2', 'disetujui2', 'DISETUJUI2']);
        }

        // 2. Pengguna Web Kecamatan / Desa
        if (Auth::guard('pengguna')->check()) {
            $user = Auth::guard('pengguna')->user();
            if ($user->id_role == 2) {
                return $query->where(function ($q) use ($table, $user) {
                    $q->where('users_mobile.id_subdistrict', $user->id_subdistrict)
                      ->orWhere("{$table}.kecamatan_id", $user->id_subdistrict);
                })
                ->whereIn("{$table}.status", ['Disetujui1', 'disetujui1', 'DISETUJUI1', 'Disetujui2', 'disetujui2', 'DISETUJUI2']);
            }

            // Desa: melihat laporannya sendiri yang sudah lolos seleksi
            return $query->where("{$table}.id_user", $user->id)
                ->whereIn("{$table}.status", ['Disetujui1', 'Disetujui2']);
        }

        return $query;
    }

    /**
     * Tentukan status persetujuan berjenjang:
     * - Kecamatan -> Disetujui1
     * - Kabupaten -> Disetujui2
     * - Ditolak / Revisi tetap
     */
    protected function resolveApprovalStatus(?string $inputStatus): string
    {
        if (in_array($inputStatus, ['Disetujui', 'Disetujui1', 'Disetujui2'])) {
            if (Auth::guard('pengguna')->check()) {
                return 'Disetujui1';
            }
            return 'Disetujui2';
        }

        if (strtolower($inputStatus ?? '') === 'revisi') {
            return 'Revisi';
        }

        if (strtolower($inputStatus ?? '') === 'ditolak') {
            return 'Ditolak';
        }

        return $inputStatus ?: 'Proses';
    }

    /**
     * Hitung ringkasan jumlah laporan menunggu dan disetujui untuk kartu dashboard.
     */
    protected function getReportStatusCounts(string $table): array
    {
        $menunggu = 0;
        $disetujui = 0;

        if (Auth::guard('web')->check()) {
            $menunggu = DB::table($table)
                ->leftJoin('users_mobile', "{$table}.id_user", '=', 'users_mobile.id')
                ->where(function ($query) use ($table) {
                    $query->where(function ($q) use ($table) {
                        $q->where('users_mobile.id_role', 1)
                            ->whereIn("{$table}.status", ['Disetujui1', 'disetujui1', 'DISETUJUI1']);
                    })
                    ->orWhere(function ($q) use ($table) {
                        $q->where('users_mobile.id_role', 2)
                            ->whereIn("{$table}.status", ['Menunggu', 'menunggu', 'MENUNGGU', 'Proses', 'proses', 'PROSES']);
                    });
                })->count();

            $disetujui = DB::table($table)
                ->whereIn('status', ['Disetujui2', 'disetujui2', 'DISETUJUI2'])
                ->count();
        } elseif (Auth::guard('pengguna')->check()) {
            $user = Auth::guard('pengguna')->user();
            if ($user->id_role == 2) {
                $menunggu = DB::table($table)
                    ->leftJoin('users_mobile', "{$table}.id_user", '=', 'users_mobile.id')
                    ->where(function ($q) use ($table, $user) {
                        $q->where('users_mobile.id_subdistrict', $user->id_subdistrict)
                          ->orWhere("{$table}.kecamatan_id", $user->id_subdistrict);
                    })
                    ->where(function ($q) use ($table) {
                        $q->where('users_mobile.id_role', 1)
                          ->orWhere("{$table}.id_role", 1);
                    })
                    ->whereIn("{$table}.status", ['Menunggu', 'menunggu', 'MENUNGGU', 'Proses', 'proses', 'PROSES'])
                    ->count();

                $disetujui = DB::table($table)
                    ->leftJoin('users_mobile', "{$table}.id_user", '=', 'users_mobile.id')
                    ->where(function ($q) use ($table, $user) {
                        $q->where('users_mobile.id_subdistrict', $user->id_subdistrict)
                          ->orWhere("{$table}.kecamatan_id", $user->id_subdistrict);
                    })
                    ->where(function ($q) use ($table) {
                        $q->where('users_mobile.id_role', 1)
                          ->orWhere("{$table}.id_role", 1);
                    })
                    ->whereIn("{$table}.status", ['Disetujui1', 'disetujui1', 'DISETUJUI1', 'Disetujui2', 'disetujui2', 'DISETUJUI2'])
                    ->count();
            } elseif ($user->id_role == 1) {
                // Sisi Desa: Menghitung laporan miliknya sendiri
                $menunggu = DB::table($table)
                    ->where("{$table}.id_user", $user->id)
                    ->whereIn("{$table}.status", ['Menunggu', 'menunggu', 'MENUNGGU', 'Proses', 'proses', 'PROSES'])
                    ->count();

                $disetujui = DB::table($table)
                    ->where("{$table}.id_user", $user->id)
                    ->whereIn("{$table}.status", ['Disetujui1', 'disetujui1', 'DISETUJUI1', 'Disetujui2', 'disetujui2', 'DISETUJUI2'])
                    ->count();
            }
        }

        return ['menunggu' => $menunggu, 'disetujui' => $disetujui];
    }
}
