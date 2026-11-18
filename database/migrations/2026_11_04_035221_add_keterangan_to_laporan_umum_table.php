<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('laporan_umum', function (Blueprint $table) {
            $table->text('keterangan')->nullable()->after('bantuan_perempuan');
        });
    }

    public function down(): void
    {
        Schema::table('laporan_umum', function (Blueprint $table) {
            $table->dropColumn('keterangan');
        });
    }
};