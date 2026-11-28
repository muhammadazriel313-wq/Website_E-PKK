<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasColumn('laporan_umum', 'dusun_lingkungan')) {
            DB::statement("ALTER TABLE `laporan_umum` MODIFY `dusun_lingkungan` VARCHAR(255) NOT NULL DEFAULT ''");
        }
    }

    public function down(): void
    {
        // Intentionally left empty to preserve values entered as text.
    }
};
