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
        Schema::table('penduduk', function (Blueprint $table) {
            $table->string('nik_hash', 64)->nullable()->after('nik');
        });

        Schema::table('keluarga', function (Blueprint $table) {
            $table->string('kepala_keluarga_nik_hash', 64)->nullable()->after('kepala_keluarga_nik');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('penduduk', function (Blueprint $table) {
            $table->dropColumn('nik_hash');
        });

        Schema::table('keluarga', function (Blueprint $table) {
            $table->dropColumn('kepala_keluarga_nik_hash');
        });
    }
};
