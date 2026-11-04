<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // 1. Tambah kolom sumber_dana dan hasil_kegiatan pada laporan_penghayatan_n_pengamalan
        Schema::table('laporan_penghayatan_n_pengamalan', function (Blueprint $table) {
            if (!Schema::hasColumn('laporan_penghayatan_n_pengamalan', 'sumber_dana')) {
                $table->string('sumber_dana')->nullable()->after('catatan');
            }
            if (!Schema::hasColumn('laporan_penghayatan_n_pengamalan', 'hasil_kegiatan')) {
                $table->text('hasil_kegiatan')->nullable()->after('sumber_dana');
            }
        });

        // 2. Tambah kolom jenis_kegiatan, sumber_dana, dan hasil_kegiatan pada laporan_gotong_royong
        Schema::table('laporan_gotong_royong', function (Blueprint $table) {
            if (!Schema::hasColumn('laporan_gotong_royong', 'jenis_kegiatan')) {
                $table->string('jenis_kegiatan')->nullable()->after('uuid');
            }
            if (!Schema::hasColumn('laporan_gotong_royong', 'sumber_dana')) {
                $table->string('sumber_dana')->nullable()->after('catatan');
            }
            if (!Schema::hasColumn('laporan_gotong_royong', 'hasil_kegiatan')) {
                $table->text('hasil_kegiatan')->nullable()->after('sumber_dana');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('laporan_penghayatan_n_pengamalan', function (Blueprint $table) {
            if (Schema::hasColumn('laporan_penghayatan_n_pengamalan', 'sumber_dana')) {
                $table->dropColumn('sumber_dana');
            }
            if (Schema::hasColumn('laporan_penghayatan_n_pengamalan', 'hasil_kegiatan')) {
                $table->dropColumn('hasil_kegiatan');
            }
        });

        Schema::table('laporan_gotong_royong', function (Blueprint $table) {
            if (Schema::hasColumn('laporan_gotong_royong', 'jenis_kegiatan')) {
                $table->dropColumn('jenis_kegiatan');
            }
            if (Schema::hasColumn('laporan_gotong_royong', 'sumber_dana')) {
                $table->dropColumn('sumber_dana');
            }
            if (Schema::hasColumn('laporan_gotong_royong', 'hasil_kegiatan')) {
                $table->dropColumn('hasil_kegiatan');
            }
        });
    }
};
