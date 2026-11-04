<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('log_penghapusan_laporan')) {
            return;
        }

        Schema::create('log_penghapusan_laporan', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('jenis', 32);
            $table->unsignedBigInteger('id_laporan');
            $table->string('status_saat_dihapus', 50);
            $table->string('guard', 16);
            $table->unsignedBigInteger('id_penghapus');
            $table->string('nama_kecamatan')->nullable();
            $table->string('nama_desa')->nullable();
            $table->timestamp('created_at')->useCurrent();
        });
    }

    public function down(): void
    {
    }
};
