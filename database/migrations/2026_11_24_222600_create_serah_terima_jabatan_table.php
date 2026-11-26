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
        Schema::create('serah_terima_jabatan', function (Blueprint $table) {
            $table->id();
            $table->string('nama_lengkap');
            $table->string('email');
            $table->string('nomor_sk_baru');
            $table->date('tanggal_efektif');
            $table->string('pejabat_lama')->nullable();
            $table->string('dokumen_sk')->nullable();
            $table->text('keterangan')->nullable();
            $table->string('status')->default('Berhasil');
            $table->unsignedBigInteger('id_user')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('serah_terima_jabatan');
    }
};
