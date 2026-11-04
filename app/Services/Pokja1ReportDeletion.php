<?php

namespace App\Services;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class Pokja1ReportDeletion
{
    private array $ownerCache = [];

    private const REPORTS = [
        'penghayatan' => [
            'table' => 'laporan_penghayatan_n_pengamalan',
            'primary_key' => 'id_pokja1_bidang1',
        ],
        'gotong_royong' => [
            'table' => 'laporan_gotong_royong',
            'primary_key' => 'id_pokja1_bidang2',
        ],
        'kader' => [
            'table' => 'laporan_kader_pokja1',
            'primary_key' => 'id_kader_pokja1',
        ],
    ];

    public function canDelete(string $type, object $report, ?object $actor = null, ?string $guard = null): bool
    {
        $definition = self::REPORTS[$type] ?? null;
        if (!$definition) {
            return false;
        }

        $actor ??= $this->actor();
        $guard ??= $this->guard();
        if (!$actor || !$guard || !property_exists($report, 'status')) {
            return false;
        }

        $status = (string) $report->status;
        $isFinal = in_array($status, ['Disetujui2', 'disetujui2', 'DISETUJUI2'], true);
        if ($isFinal) {
            return $guard === 'web';
        }

        $isApprovedByDistrict = in_array($status, ['Disetujui1', 'disetujui1', 'DISETUJUI1'], true);
        $isInProcess = in_array($status, ['Proses', 'proses', 'PROSES'], true);
        if (!$isApprovedByDistrict && !$isInProcess) {
            return false;
        }

        $ownerId = (int) ($report->id_user ?? 0);
        if (!array_key_exists($ownerId, $this->ownerCache)) {
            $this->ownerCache[$ownerId] = DB::table('users_mobile')->where('id', $ownerId)->first();
        }
        $owner = $this->ownerCache[$ownerId];
        if (!$owner) {
            return false;
        }

        if ($guard === 'web') {
            return ($isApprovedByDistrict && (int) $owner->id_role === 1)
                || ($isInProcess && (int) $owner->id_role === 2);
        }

        if ($guard !== 'pengguna' || !$isInProcess || (int) ($actor->id_role ?? 0) !== 2) {
            return false;
        }

        return (int) $owner->id_role === 1
            && (int) $owner->id_subdistrict === (int) ($actor->id_subdistrict ?? 0);
    }

    public function delete(string $type, int|string $id): void
    {
        $definition = self::REPORTS[$type] ?? null;
        if (!$definition) {
            throw new NotFoundHttpException('Laporan tidak ditemukan.');
        }

        DB::transaction(function () use ($type, $id, $definition) {
            $report = DB::table($definition['table'])
                ->where($definition['primary_key'], $id)
                ->lockForUpdate()
                ->first();

            if (!$report) {
                throw new NotFoundHttpException('Laporan tidak ditemukan.');
            }

            if (!$this->canDelete($type, $report)) {
                throw new AccessDeniedHttpException('Anda tidak berhak menghapus laporan ini.');
            }

            $owner = DB::table('users_mobile')->where('id', $report->id_user)->first();
            $statusAtDeletion = (string) $report->status;
            $guard = $this->guard();
            $actor = $this->actor();

            DB::table('log_penghapusan_laporan')->insert([
                'jenis' => $type,
                'id_laporan' => $report->{$definition['primary_key']},
                'status_saat_dihapus' => $statusAtDeletion,
                'guard' => $guard,
                'id_penghapus' => $actor->id,
                'nama_kecamatan' => $owner
                    ? DB::table('subdistrict')->where('id', $owner->id_subdistrict)->value('name')
                    : null,
                'nama_desa' => $owner
                    ? DB::table('village')->where('id', $owner->id_village)->value('name')
                    : null,
                'created_at' => now(),
            ]);

            DB::table($definition['table'])
                ->where($definition['primary_key'], $report->{$definition['primary_key']})
                ->delete();
        });
    }

    private function guard(): ?string
    {
        if (Auth::guard('web')->check()) {
            return 'web';
        }
        if (Auth::guard('pengguna')->check()) {
            return 'pengguna';
        }
        return null;
    }

    private function actor(): ?object
    {
        if (Auth::guard('web')->check()) {
            return Auth::guard('web')->user();
        }
        if (Auth::guard('pengguna')->check()) {
            return Auth::guard('pengguna')->user();
        }
        return null;
    }
}
