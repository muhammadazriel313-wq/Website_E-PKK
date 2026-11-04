<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasColumn('laporan_kader_pokja1', 'kader_umum')) {
            Schema::table('laporan_kader_pokja1', function ($table) {
                $table->integer('kader_umum')->nullable();
            });
        }

        if (!Schema::hasColumn('laporan_kader_pokja1', 'kader_khusus')) {
            Schema::table('laporan_kader_pokja1', function ($table) {
                $table->integer('kader_khusus')->nullable();
            });
        }

        foreach (['PKBN', 'PKDRT', 'pola_asuh'] as $column) {
            if (Schema::hasColumn('laporan_kader_pokja1', $column)) {
                DB::statement("ALTER TABLE `laporan_kader_pokja1` MODIFY `{$column}` INT NULL DEFAULT NULL");
            }
        }
    }

    public function down(): void
    {
        // Intentionally left empty to preserve columns and existing data.
    }
};
