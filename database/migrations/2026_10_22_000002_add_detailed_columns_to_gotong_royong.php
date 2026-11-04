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
        Schema::table('laporan_gotong_royong', function (Blueprint $table) {
            // Sub-kolom untuk KERJA BAKTI
            if (!Schema::hasColumn('laporan_gotong_royong', 'kerja_bakti_kegiatan')) {
                $table->string('kerja_bakti_kegiatan')->nullable()->after('id_user');
            }
            if (!Schema::hasColumn('laporan_gotong_royong', 'kerja_bakti_vol')) {
                $table->string('kerja_bakti_vol')->nullable()->after('kerja_bakti_kegiatan');
            }
            if (!Schema::hasColumn('laporan_gotong_royong', 'kerja_bakti_metode')) {
                $table->string('kerja_bakti_metode')->nullable()->after('kerja_bakti_vol');
            }
            if (!Schema::hasColumn('laporan_gotong_royong', 'kerja_bakti_sasaran')) {
                $table->string('kerja_bakti_sasaran')->nullable()->after('kerja_bakti_metode');
            }

            // Sub-kolom untuk BANTUAN ANAK YATIM
            if (!Schema::hasColumn('laporan_gotong_royong', 'bantuan_yatim_kegiatan')) {
                $table->string('bantuan_yatim_kegiatan')->nullable()->after('kerja_bakti_sasaran');
            }
            if (!Schema::hasColumn('laporan_gotong_royong', 'bantuan_yatim_vol')) {
                $table->string('bantuan_yatim_vol')->nullable()->after('bantuan_yatim_kegiatan');
            }
            if (!Schema::hasColumn('laporan_gotong_royong', 'bantuan_yatim_metode')) {
                $table->string('bantuan_yatim_metode')->nullable()->after('bantuan_yatim_vol');
            }
            if (!Schema::hasColumn('laporan_gotong_royong', 'bantuan_yatim_sasaran')) {
                $table->string('bantuan_yatim_sasaran')->nullable()->after('bantuan_yatim_metode');
            }

            // Sub-kolom untuk KEGIATAN SOSIAL
            if (!Schema::hasColumn('laporan_gotong_royong', 'kegiatan_sosial_kegiatan')) {
                $table->string('kegiatan_sosial_kegiatan')->nullable()->after('bantuan_yatim_sasaran');
            }
            if (!Schema::hasColumn('laporan_gotong_royong', 'kegiatan_sosial_vol')) {
                $table->string('kegiatan_sosial_vol')->nullable()->after('kegiatan_sosial_kegiatan');
            }
            if (!Schema::hasColumn('laporan_gotong_royong', 'kegiatan_sosial_metode')) {
                $table->string('kegiatan_sosial_metode')->nullable()->after('kegiatan_sosial_vol');
            }
            if (!Schema::hasColumn('laporan_gotong_royong', 'kegiatan_sosial_sasaran')) {
                $table->string('kegiatan_sosial_sasaran')->nullable()->after('kegiatan_sosial_metode');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('laporan_gotong_royong', function (Blueprint $table) {
            $cols = [
                'kerja_bakti_kegiatan', 'kerja_bakti_vol', 'kerja_bakti_metode', 'kerja_bakti_sasaran',
                'bantuan_yatim_kegiatan', 'bantuan_yatim_vol', 'bantuan_yatim_metode', 'bantuan_yatim_sasaran',
                'kegiatan_sosial_kegiatan', 'kegiatan_sosial_vol', 'kegiatan_sosial_metode', 'kegiatan_sosial_sasaran',
            ];
            foreach ($cols as $col) {
                if (Schema::hasColumn('laporan_gotong_royong', $col)) {
                    $table->dropColumn($col);
                }
            }
        });
    }
};
