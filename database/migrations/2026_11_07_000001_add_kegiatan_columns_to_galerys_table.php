<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('galerys', function (Blueprint $table) {
            if (!Schema::hasColumn('galerys', 'nama_peserta')) {
                $table->text('nama_peserta')->nullable()->after('deskripsi');
            }
            if (!Schema::hasColumn('galerys', 'jabatan')) {
                $table->string('jabatan', 100)->nullable()->after('nama_peserta');
            }
            if (!Schema::hasColumn('galerys', 'tanggal')) {
                $table->dateTime('tanggal')->nullable()->after('jabatan');
            }
        });
    }

    public function down(): void
    {
        Schema::table('galerys', function (Blueprint $table) {
            foreach (['tanggal', 'jabatan', 'nama_peserta'] as $col) {
                if (Schema::hasColumn('galerys', $col)) {
                    $table->dropColumn($col);
                }
            }
        });
    }
};
