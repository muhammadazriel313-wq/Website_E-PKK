<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class SplitPanganSandangCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'pkk:split-pangan-sandang {--dry-run : Pratinjau migrasi tanpa menyimpan ke database}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Migrasi memisahkan data laporan_pangan_sandang ke laporan_pangan dan laporan_sandang';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $isDryRun = (bool) $this->option('dry-run');

        $this->info("============================================================");
        $this->info("  MIGRASI DATA: PROGRAM PANGAN & SANDANG (POKJA 3)");
        $this->info($isDryRun ? "  MODE: DRY-RUN (Simulasi / Tidak mengubah database)" : "  MODE: EKSEKUSI PENUH");
        $this->info("============================================================");

        if (!Schema::hasTable('laporan_pangan') || !Schema::hasTable('laporan_sandang')) {
            $this->error("Tabel laporan_pangan atau laporan_sandang baru belum dibuat. Silakan jalankan 'php artisan migrate' terlebih dahulu.");
            return 1;
        }

        DB::beginTransaction();

        try {
            $stats = [
                'total_sumber' => 0,
                'pangan_dipindah' => 0,
                'sandang_dipindah' => 0,
                'dilewati_kosong' => 0,
            ];

            // 1. Ambil data dari tabel gabungan laporan_pangan_sandang
            $sumberRows = collect();
            if (Schema::hasTable('laporan_pangan_sandang')) {
                $sumberRows = DB::table('laporan_pangan_sandang')->orderBy('id_pangan_sandang', 'asc')->get();
            }

            $stats['total_sumber'] = $sumberRows->count();
            $this->info("Ditemukan {$stats['total_sumber']} baris data pada tabel gabungan laporan_pangan_sandang.");

            $detailRows = [];

            foreach ($sumberRows as $row) {
                // Relasi user, kecamatan, dan desa
                $user = null;
                if (!empty($row->id_user)) {
                    $user = DB::table('users_mobile')->where('id', $row->id_user)->first();
                }

                $kecamatanId = $user->id_subdistrict ?? null;
                $desaId = $user->id_village ?? null;
                $idRole = $row->id_role ?? ($user->id_role ?? null);
                $idOrg = $row->id_organization ?? ($user->id_organization ?? null);

                // Kolom Pangan
                $beras = max(0, (int) ($row->beras ?? 0));
                $nonBeras = max(0, (int) ($row->non_beras ?? 0));
                $peternakan = max(0, (int) ($row->peternakan ?? 0));
                $perikanan = max(0, (int) ($row->perikanan ?? 0));
                $warungHidup = max(0, (int) ($row->warung_hidup ?? 0));
                $lumbungHidup = max(0, (int) ($row->lumbung_hidup ?? 0));
                $toga = max(0, (int) ($row->toga ?? 0));
                $tanamanKeras = max(0, (int) ($row->tanaman_keras ?? 0));
                $tanamanLainnya = max(0, (int) ($row->tanaman_lainnya ?? 0));
                $irtPangan = max(0, (int) ($row->industri_pangan ?? 0));

                // Cek data kader dari laporan_kader_pokja3 jika ada
                $kaderPangan = 0;
                $kaderSandang = 0;
                if (!empty($row->id_user)) {
                    $kader = DB::table('laporan_kader_pokja3')
                        ->where('id_user', $row->id_user)
                        ->whereDate('created_at', date('Y-m-d', strtotime($row->created_at)))
                        ->first();
                    if ($kader) {
                        $kaderPangan = max(0, (int) ($kader->pangan ?? 0));
                        $kaderSandang = max(0, (int) ($kader->sandang ?? 0));
                    }
                }

                // Kolom Sandang
                $irtSandang = max(0, (int) ($row->industri_sandang ?? 0));
                $jasa = max(0, (int) ($row->jasa ?? 0));

                // Evaluasi apakah baris memiliki data untuk program terkait (berdasarkan kolom tabel gabungan)
                $hasPanganData = ($beras > 0 || $nonBeras > 0 || $peternakan > 0 || $perikanan > 0 ||
                                  $warungHidup > 0 || $lumbungHidup > 0 || $toga > 0 || $tanamanKeras > 0 ||
                                  $tanamanLainnya > 0 || $irtPangan > 0);

                $hasSandangData = ($irtSandang > 0 || $jasa > 0);

                if (!$hasPanganData && !$hasSandangData) {
                    $stats['dilewati_kosong']++;
                    continue;
                }

                // Waktu persetujuan
                $approvedAt = null;
                $approvedBy = null;
                if (in_array(strtolower($row->status ?? ''), ['disetujui1', 'disetujui2'])) {
                    $approvedAt = $row->updated_at ?? $row->created_at;
                }

                $tujuan = [];

                // 1. Pindahkan ke laporan_pangan jika ada data pangan
                if ($hasPanganData) {
                    $uuidPangan = $row->uuid ?? ('KP3B1-' . strtoupper(bin2hex(random_bytes(3))));
                    // Jika UUID sumbernya KP3B2 tapi isinya pangan, buat UUID pangan baru yang konsisten
                    if (str_starts_with($uuidPangan, 'KP3B2-') && !$hasSandangData) {
                        $uuidPangan = 'KP3B1-' . substr($uuidPangan, 6);
                    }

                    $panganPayload = [
                        'uuid'            => $uuidPangan,
                        'id_user'         => $row->id_user,
                        'kecamatan_id'    => $kecamatanId,
                        'desa_id'         => $desaId,
                        'kader_pangan'    => $kaderPangan,
                        'beras'           => $beras,
                        'non_beras'       => $nonBeras,
                        'peternakan'      => $peternakan,
                        'perikanan'       => $perikanan,
                        'warung_hidup'    => $warungHidup,
                        'lumbung_hidup'   => $lumbungHidup,
                        'toga'            => $toga,
                        'tanaman_keras'   => $tanamanKeras,
                        'tanaman_lainnya' => $tanamanLainnya,
                        'industri_pangan' => $irtPangan,
                        'catatan'         => $row->catatan ?? null,
                        'status'          => $row->status ?? 'Proses',
                        'id_role'         => $idRole,
                        'id_organization' => $idOrg,
                        'approved_at'     => $approvedAt,
                        'approved_by'     => $approvedBy,
                        'created_at'      => $row->created_at,
                        'updated_at'      => $row->updated_at,
                    ];

                    if (!$isDryRun) {
                        DB::table('laporan_pangan')->updateOrInsert(
                            ['uuid' => $uuidPangan],
                            $panganPayload
                        );
                    }
                    $stats['pangan_dipindah']++;
                    $tujuan[] = 'Pangan';
                }

                // 2. Pindahkan ke laporan_sandang jika ada data sandang
                if ($hasSandangData) {
                    $uuidSandang = $row->uuid ?? ('KP3B2-' . strtoupper(bin2hex(random_bytes(3))));
                    // Jika UUID sumbernya KP3B1 tapi isinya sandang, buat UUID sandang baru yang konsisten
                    if (str_starts_with($uuidSandang, 'KP3B1-') && !$hasPanganData) {
                        $uuidSandang = 'KP3B2-' . substr($uuidSandang, 6);
                    }

                    $sandangPayload = [
                        'uuid'             => $uuidSandang,
                        'id_user'          => $row->id_user,
                        'kecamatan_id'     => $kecamatanId,
                        'desa_id'          => $desaId,
                        'kader_sandang'    => $kaderSandang,
                        'industri_sandang' => $irtSandang,
                        'jasa'             => $jasa,
                        'catatan'          => $row->catatan ?? null,
                        'status'           => $row->status ?? 'Proses',
                        'id_role'          => $idRole,
                        'id_organization'  => $idOrg,
                        'approved_at'      => $approvedAt,
                        'approved_by'      => $approvedBy,
                        'created_at'       => $row->created_at,
                        'updated_at'       => $row->updated_at,
                    ];

                    if (!$isDryRun) {
                        DB::table('laporan_sandang')->updateOrInsert(
                            ['uuid' => $uuidSandang],
                            $sandangPayload
                        );
                    }
                    $stats['sandang_dipindah']++;
                    $tujuan[] = 'Sandang';
                }

                $detailRows[] = [
                    'ID Lama' => $row->id_pangan_sandang,
                    'UUID'    => $row->uuid ?? '-',
                    'User ID' => $row->id_user ?? '-',
                    'Kec ID'  => $kecamatanId ?? '-',
                    'Desa ID' => $desaId ?? '-',
                    'Status'  => $row->status ?? '-',
                    'Tujuan'  => implode(' & ', $tujuan),
                ];
            }

            // Tampilkan tabel pratinjau
            $this->table(['ID Lama', 'UUID', 'User ID', 'Kec ID', 'Desa ID', 'Status', 'Tujuan'], $detailRows);

            if ($isDryRun) {
                DB::rollBack();
                $this->warn("\n[DRY-RUN] Transaksi dibatalkan (rollback). Tidak ada baris yang tersimpan.");
            } else {
                DB::commit();
                $this->info("\n[BERHASIL] Transaksi berhasil di-commit ke database.");
            }

            $this->info("------------------------------------------------------------");
            $this->info("Ringkasan Hasil Migrasi:");
            $this->line("- Total data sumber gabungan       : {$stats['total_sumber']}");
            $this->line("- Baris dipindah ke laporan_pangan : {$stats['pangan_dipindah']}");
            $this->line("- Baris dipindah ke laporan_sandang: {$stats['sandang_dipindah']}");
            $this->line("- Baris dilewati (semua bernilai 0): {$stats['dilewati_kosong']}");
            $this->info("------------------------------------------------------------");

            return 0;
        } catch (\Throwable $e) {
            DB::rollBack();
            $this->error("Terjadi kesalahan saat migrasi: " . $e->getMessage());
            return 1;
        }
    }
}
