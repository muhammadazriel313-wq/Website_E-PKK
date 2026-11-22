<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        $kesehatanColumns = [
            'kader_kesehatan',
            'kader_gizi',
            'kader_kesling',
            'kader_phbs',
            'kader_kb',
            'posyandu',
            'imunisasi_vaksinasi',
            'pkg',
            'tbc',
        ];

        foreach ($kesehatanColumns as $column) {
            if (!Schema::hasColumn('laporan_bidang_kesehatan', $column)) {
                Schema::table('laporan_bidang_kesehatan', function ($table) use ($column) {
                    $table->integer($column)->nullable();
                });
            }
        }

        if (!Schema::hasColumn('laporan_perencanaan_sehat', 'Kk_asuransi')) {
            Schema::table('laporan_perencanaan_sehat', function ($table) {
                $table->integer('Kk_asuransi')->nullable();
            });
        }
    }

    public function down(): void
    {
        // Intentionally left empty to preserve columns and existing data.
    }
};
