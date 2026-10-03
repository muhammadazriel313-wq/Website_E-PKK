<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Menggabungkan tabel laporan_pangan dan laporan_sandang menjadi laporan_pangan_sandang
     */
    public function up(): void
    {
        // 1. Buat tabel baru gabungan
        Schema::create('laporan_pangan_sandang', function (Blueprint $table) {
            $table->bigIncrements('id_pangan_sandang');
            $table->string('uuid')->nullable();
            $table->unsignedBigInteger('id_user')->nullable();

            // === KOLOM PANGAN ===
            $table->integer('beras')->default(0);
            $table->integer('non_beras')->default(0);
            $table->integer('peternakan')->default(0);
            $table->integer('perikanan')->default(0);
            $table->integer('warung_hidup')->default(0);
            $table->integer('lumbung_hidup')->default(0);
            $table->integer('toga')->default(0);
            $table->integer('tanaman_keras')->default(0);
            $table->integer('tanaman_lainnya')->default(0);

            // === KOLOM INDUSTRI RUMAH TANGGA (SANDANG) ===
            $table->integer('industri_pangan')->default(0);
            $table->integer('industri_sandang')->default(0);
            $table->integer('jasa')->default(0);

            // === KOLOM UMUM ===
            $table->text('catatan')->nullable();
            $table->string('status')->default('Proses');
            $table->unsignedBigInteger('id_role')->nullable();
            $table->unsignedBigInteger('id_organization')->nullable();
            $table->timestamps();
        });

        // 2. Migrasi data dari laporan_pangan
        $dataPangan = DB::table('laporan_pangan')->get();
        foreach ($dataPangan as $row) {
            DB::table('laporan_pangan_sandang')->insert([
                'uuid'             => $row->uuid ?? null,
                'id_user'          => $row->id_user,
                'beras'            => $row->beras ?? 0,
                'non_beras'        => $row->non_beras ?? 0,
                'peternakan'       => $row->peternakan ?? 0,
                'perikanan'        => $row->perikanan ?? 0,
                'warung_hidup'     => $row->warung_hidup ?? 0,
                'lumbung_hidup'    => $row->lumbung_hidup ?? 0,
                'toga'             => $row->toga ?? 0,
                'tanaman_keras'    => $row->tanaman_keras ?? 0,
                'tanaman_lainnya'  => $row->tanaman_lainnya ?? 0,
                'industri_pangan'  => 0,
                'industri_sandang' => 0,
                'jasa'             => 0,
                'catatan'          => $row->catatan ?? null,
                'status'           => $row->status ?? 'Proses',
                'id_role'          => $row->id_role ?? null,
                'id_organization'  => $row->id_organization ?? null,
                'created_at'       => $row->created_at,
                'updated_at'       => $row->updated_at,
            ]);
        }

        // 3. Migrasi data dari laporan_sandang
        $dataSandang = DB::table('laporan_sandang')->get();
        foreach ($dataSandang as $row) {
            DB::table('laporan_pangan_sandang')->insert([
                'uuid'             => $row->uuid ?? null,
                'id_user'          => $row->id_user,
                'beras'            => 0,
                'non_beras'        => 0,
                'peternakan'       => 0,
                'perikanan'        => 0,
                'warung_hidup'     => 0,
                'lumbung_hidup'    => 0,
                'toga'             => 0,
                'tanaman_keras'    => 0,
                'tanaman_lainnya'  => 0,
                'industri_pangan'  => $row->pangan ?? 0,
                'industri_sandang' => $row->sandang ?? 0,
                'jasa'             => $row->jasa ?? 0,
                'catatan'          => $row->catatan ?? null,
                'status'           => $row->status ?? 'Proses',
                'id_role'          => $row->id_role ?? null,
                'id_organization'  => $row->id_organization ?? null,
                'created_at'       => $row->created_at,
                'updated_at'       => $row->updated_at,
            ]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('laporan_pangan_sandang');
    }
};
