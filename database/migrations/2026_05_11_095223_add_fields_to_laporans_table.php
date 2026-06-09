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
        Schema::table('laporans', function (Blueprint $table) {
            $table->text('catatan')->nullable()->after('isi_laporan');
            $table->unsignedBigInteger('diproses_oleh')->nullable()->after('catatan');
            $table->timestamp('diproses_at')->nullable()->after('diproses_oleh');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('laporans', function (Blueprint $table) {
            $table->dropColumn(['catatan', 'diproses_oleh', 'diproses_at']);
        });
    }
};
