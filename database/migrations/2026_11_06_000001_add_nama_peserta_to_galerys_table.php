<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('galerys', function (Blueprint $table) {
            // Daftar nama peserta kegiatan (disimpan sebagai JSON array)
            if (!Schema::hasColumn('galerys', 'nama_peserta')) {
                $table->text('nama_peserta')->nullable()->after('deskripsi');
            }

            // Dipakai oleh method update() di controller web (Galeri*Controller)
            if (!Schema::hasColumn('galerys', 'tanggal')) {
                $table->dateTime('tanggal')->nullable()->after('nama_peserta');
            }
        });
    }

    public function down(): void
    {
        Schema::table('galerys', function (Blueprint $table) {
            if (Schema::hasColumn('galerys', 'tanggal')) {
                $table->dropColumn('tanggal');
            }
            if (Schema::hasColumn('galerys', 'nama_peserta')) {
                $table->dropColumn('nama_peserta');
            }
        });
    }
};
