<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('users_mobile') && !Schema::hasColumn('users_mobile', 'foto')) {
            Schema::table('users_mobile', function (Blueprint $table) {
                $table->string('foto', 255)->nullable()->after('password');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('users_mobile') && Schema::hasColumn('users_mobile', 'foto')) {
            Schema::table('users_mobile', function (Blueprint $table) {
                $table->dropColumn('foto');
            });
        }
    }
};
