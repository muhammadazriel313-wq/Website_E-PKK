<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Memecah program Pangan & Industri Rumah Tangga menjadi 2 tabel mandiri:
     * laporan_pangan dan laporan_sandang sesuai format resmi PKK.
     */
    public function up(): void
    {
        // 1. Amankan tabel lama jika sudah ada (tanpa menghapus data)
        if (Schema::hasTable('laporan_pangan') && !Schema::hasColumn('laporan_pangan', 'kecamatan_id')) {
            if (!Schema::hasTable('laporan_pangan_old')) {
                Schema::rename('laporan_pangan', 'laporan_pangan_old');
            }
        }

        if (Schema::hasTable('laporan_sandang') && !Schema::hasColumn('laporan_sandang', 'kecamatan_id')) {
            if (!Schema::hasTable('laporan_sandang_old')) {
                Schema::rename('laporan_sandang', 'laporan_sandang_old');
            }
        }

        // 2. Buat tabel laporan_pangan mandiri baru
        if (!Schema::hasTable('laporan_pangan')) {
            Schema::create('laporan_pangan', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->string('uuid', 64)->nullable()->index();
                $table->unsignedBigInteger('id_user')->nullable()->index();
                $table->unsignedBigInteger('kecamatan_id')->nullable()->index();
                $table->unsignedBigInteger('desa_id')->nullable()->index();

                // Kolom spesifik Program Pangan (Semua kolom angka: integer unsigned >= 0)
                $table->unsignedInteger('kader_pangan')->default(0);
                $table->unsignedInteger('beras')->default(0);
                $table->unsignedInteger('non_beras')->default(0);
                $table->unsignedInteger('peternakan')->default(0);
                $table->unsignedInteger('perikanan')->default(0);
                $table->unsignedInteger('warung_hidup')->default(0);
                $table->unsignedInteger('lumbung_hidup')->default(0);
                $table->unsignedInteger('toga')->default(0);
                $table->unsignedInteger('tanaman_keras')->default(0);
                $table->unsignedInteger('tanaman_lainnya')->default(0);
                $table->unsignedInteger('industri_pangan')->default(0);

                // Kolom umum & alur persetujuan
                $table->text('catatan')->nullable();
                $table->string('status', 50)->default('Proses')->index();
                $table->unsignedBigInteger('id_role')->nullable();
                $table->unsignedBigInteger('id_organization')->nullable();
                $table->timestamp('approved_at')->nullable();
                $table->unsignedBigInteger('approved_by')->nullable();
                $table->timestamps();
            });
        }

        // 3. Buat tabel laporan_sandang mandiri baru
        if (!Schema::hasTable('laporan_sandang')) {
            Schema::create('laporan_sandang', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->string('uuid', 64)->nullable()->index();
                $table->unsignedBigInteger('id_user')->nullable()->index();
                $table->unsignedBigInteger('kecamatan_id')->nullable()->index();
                $table->unsignedBigInteger('desa_id')->nullable()->index();

                // Kolom spesifik Program Sandang (Semua kolom angka: integer unsigned >= 0)
                $table->unsignedInteger('kader_sandang')->default(0);
                $table->unsignedInteger('industri_sandang')->default(0);
                $table->unsignedInteger('jasa')->default(0);

                // Kolom umum & alur persetujuan
                $table->text('catatan')->nullable();
                $table->string('status', 50)->default('Proses')->index();
                $table->unsignedBigInteger('id_role')->nullable();
                $table->unsignedBigInteger('id_organization')->nullable();
                $table->timestamp('approved_at')->nullable();
                $table->unsignedBigInteger('approved_by')->nullable();
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('laporan_pangan');
        Schema::dropIfExists('laporan_sandang');

        if (Schema::hasTable('laporan_pangan_old') && !Schema::hasTable('laporan_pangan')) {
            Schema::rename('laporan_pangan_old', 'laporan_pangan');
        }

        if (Schema::hasTable('laporan_sandang_old') && !Schema::hasTable('laporan_sandang')) {
            Schema::rename('laporan_sandang_old', 'laporan_sandang');
        }
    }
};
