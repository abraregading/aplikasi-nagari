<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('data_meninggal', function (Blueprint $table) {
            $table->string('status_hubungan', 50)->nullable()->after('sebab_meninggal');
            $table->string('nama_saksi', 100)->nullable()->after('status_hubungan');
            $table->string('no_hp_saksi', 20)->nullable()->after('nama_saksi');
        });
    }

    public function down(): void
    {
        Schema::table('data_meninggal', function (Blueprint $table) {
            $table->dropColumn(['status_hubungan', 'nama_saksi', 'no_hp_saksi']);
        });
    }
};
