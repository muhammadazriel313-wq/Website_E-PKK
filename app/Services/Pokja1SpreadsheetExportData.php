<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Validation\ValidationException;

class Pokja1SpreadsheetExportData
{
    public function get(int $tahun, ?int $bulan, string $bidang): array
    {
        return $this->build($tahun, $bulan, $bidang, null);
    }

    public function getForDistrict(int $tahun, ?int $bulan, string $bidang, int $idSubdistrict, array $statuses): array
    {
        return $this->build($tahun, $bulan, $bidang, [
            'id_subdistrict' => $idSubdistrict,
            'statuses' => $statuses,
        ]);
    }

    private function build(int $tahun, ?int $bulan, string $bidang, ?array $district): array
    {
        if (!in_array($bidang, ['semua', 'penghayatan', 'gotongroyong', 'kader'], true)) {
            throw ValidationException::withMessages(['bidang' => 'Bidang yang dipilih tidak valid.']);
        }

        $result = [];

        if ($bidang === 'semua' || $bidang === 'penghayatan') {
            $result['penghayatan'] = $this->penghayatan($tahun, $bulan, $district);
        }

        if ($bidang === 'semua' || $bidang === 'gotongroyong') {
            $result['gotong_royong'] = $this->gotongRoyong($tahun, $bulan, $district);
        }

        if ($bidang === 'semua' || $bidang === 'kader') {
            $result['kader'] = $this->kader($tahun, $bulan, $district);
        }

        return $result;
    }

    private function baseQuery(string $table, int $tahun, ?int $bulan, ?array $district = null)
    {
        $query = DB::table($table . ' as laporan')
            ->leftJoin('users_mobile as pengguna', 'laporan.id_user', '=', 'pengguna.id')
            ->leftJoin('subdistrict as kecamatan', 'pengguna.id_subdistrict', '=', 'kecamatan.id')
            ->leftJoin('village as desa', 'pengguna.id_village', '=', 'desa.id')
            ->whereYear('laporan.created_at', $tahun)
            ->when($bulan !== null, fn ($query) => $query->whereMonth('laporan.created_at', $bulan))
            ->select('laporan.*', 'kecamatan.name as nama_kecamatan', 'desa.name as nama_desa');

        if ($district === null) {
            return $query->where('laporan.status', 'Disetujui2');
        }

        return $query->where(function ($groupedQuery) use ($district) {
            $groupedQuery->where(function ($q) use ($district) {
                $q->where('pengguna.id_role', 1)
                    ->where('pengguna.id_subdistrict', $district['id_subdistrict'])
                    ->whereIn('laporan.status', $district['statuses']);
            })->orWhere(function ($q) use ($district) {
                $q->where('pengguna.id_role', 2)
                    ->where('pengguna.id_subdistrict', $district['id_subdistrict'])
                    ->whereIn('laporan.status', ['Proses', 'proses', 'PROSES', 'Disetujui2']);
            });
        });
    }

    private function orderQuery($query, ?array $district, string $primaryKey)
    {
        if ($district !== null) {
            return $query->orderBy('desa.name')->orderBy('laporan.created_at')->orderBy('laporan.' . $primaryKey);
        }

        return $query->orderBy('laporan.created_at')->orderBy('laporan.' . $primaryKey);
    }

    private function penghayatan(int $tahun, ?int $bulan, ?array $district = null): array
    {
        return $this->orderQuery($this->baseQuery('laporan_penghayatan_n_pengamalan', $tahun, $bulan, $district), $district, 'id_pokja1_bidang1')
            ->get()
            ->map(fn ($item) => [
                'id' => 'penghayatan:' . $item->id_pokja1_bidang1,
                'kecamatan' => $item->nama_kecamatan,
                'desa' => $item->nama_desa,
                'kisah_kegiatan' => $item->kisah_kegiatan,
                'kisah_vol' => $item->kisah_vol,
                'kisah_metode' => $item->kisah_metode,
                'kisah_sasaran' => $item->kisah_sasaran,
                'krisan_kegiatan' => $item->krisan_kegiatan,
                'krisan_vol' => $item->krisan_vol,
                'krisan_metode' => $item->krisan_metode,
                'krisan_sasaran' => $item->krisan_sasaran,
                'kilas_kegiatan' => $item->kilas_kegiatan,
                'kilas_vol' => $item->kilas_vol,
                'kilas_metode' => $item->kilas_metode,
                'kilas_sasaran' => $item->kilas_sasaran,
                'kiat_kegiatan' => $item->kiat_kegiatan,
                'kiat_vol' => $item->kiat_vol,
                'kiat_metode' => $item->kiat_metode,
                'kiat_sasaran' => $item->kiat_sasaran,
                'kisak_kegiatan' => $item->kisak_kegiatan,
                'kisak_vol' => $item->kisak_vol,
                'kisak_metode' => $item->kisak_metode,
                'kisak_sasaran' => $item->kisak_sasaran,
                'pkbn_kegiatan' => $item->pkbn_kegiatan,
                'pkbn_vol' => $item->pkbn_vol,
                'pkbn_metode' => $item->pkbn_metode,
                'pkbn_sasaran' => $item->pkbn_sasaran,
                'sumber_dana' => $item->sumber_dana,
                'hasil_kegiatan' => $item->hasil_kegiatan,
                'status' => $item->status,
                'tanggal' => $item->created_at,
            ])->all();
    }

    private function gotongRoyong(int $tahun, ?int $bulan, ?array $district = null): array
    {
        return $this->orderQuery($this->baseQuery('laporan_gotong_royong', $tahun, $bulan, $district), $district, 'id_pokja1_bidang2')
            ->get()
            ->map(fn ($item) => [
                'id' => 'gotong-royong:' . $item->id_pokja1_bidang2,
                'kecamatan' => $item->nama_kecamatan,
                'desa' => $item->nama_desa,
                'kerja_bakti_kegiatan' => $item->kerja_bakti_kegiatan,
                'kerja_bakti_vol' => $item->kerja_bakti_vol,
                'kerja_bakti_metode' => $item->kerja_bakti_metode,
                'kerja_bakti_sasaran' => $item->kerja_bakti_sasaran,
                'bantuan_yatim_kegiatan' => $item->bantuan_yatim_kegiatan,
                'bantuan_yatim_vol' => $item->bantuan_yatim_vol,
                'bantuan_yatim_metode' => $item->bantuan_yatim_metode,
                'bantuan_yatim_sasaran' => $item->bantuan_yatim_sasaran,
                'kegiatan_sosial_kegiatan' => $item->kegiatan_sosial_kegiatan,
                'kegiatan_sosial_vol' => $item->kegiatan_sosial_vol,
                'kegiatan_sosial_metode' => $item->kegiatan_sosial_metode,
                'kegiatan_sosial_sasaran' => $item->kegiatan_sosial_sasaran,
                'sumber_dana' => $item->sumber_dana,
                'hasil_kegiatan' => $item->hasil_kegiatan,
                'status' => $item->status,
                'tanggal' => $item->created_at,
            ])->all();
    }

    private function kader(int $tahun, ?int $bulan, ?array $district = null): array
    {
        $hasKaderUmum = Schema::hasColumn('laporan_kader_pokja1', 'kader_umum');
        $hasKaderKhusus = Schema::hasColumn('laporan_kader_pokja1', 'kader_khusus');

        $query = $this->orderQuery($this->baseQuery('laporan_kader_pokja1', $tahun, $bulan, $district), $district, 'id_kader_pokja1');

        if (!$hasKaderUmum || !$hasKaderKhusus) {
            $columns = [
                'laporan.id_kader_pokja1',
                'laporan.created_at',
                'laporan.status',
                'kecamatan.name as nama_kecamatan',
                'desa.name as nama_desa',
            ];
            if ($hasKaderUmum) $columns[] = 'laporan.kader_umum';
            if ($hasKaderKhusus) $columns[] = 'laporan.kader_khusus';
            $query->select($columns);
        }

        return $query->get()->map(fn ($item) => [
            'id' => 'kader:' . $item->id_kader_pokja1,
            'kecamatan' => $item->nama_kecamatan,
            'desa' => $item->nama_desa,
            'kader_umum' => $hasKaderUmum ? ($item->kader_umum ?? null) : null,
            'kader_khusus' => $hasKaderKhusus ? ($item->kader_khusus ?? null) : null,
            'status' => $item->status,
            'tanggal' => $item->created_at,
        ])->all();
    }
}
