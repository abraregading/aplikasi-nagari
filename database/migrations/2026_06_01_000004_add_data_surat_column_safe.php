<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('riwayat_surat', function (Blueprint $table) {
            if (!Schema::hasColumn('riwayat_surat', 'data_surat')) {
                $table->json('data_surat')->nullable()->after('pernyataan');
            }
        });
    }

    public function down(): void
    {
        Schema::table('riwayat_surat', function (Blueprint $table) {
            if (Schema::hasColumn('riwayat_surat', 'data_surat')) {
                $table->dropColumn('data_surat');
            }
        });
    }
};
