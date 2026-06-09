<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('template_surat', function (Blueprint $table) {
            $table->string('form_template', 100)->nullable()->after('tipe');
            $table->string('cetak_template', 100)->nullable()->after('form_template');
        });
    }

    public function down(): void
    {
        Schema::table('template_surat', function (Blueprint $table) {
            $table->dropColumn(['form_template', 'cetak_template']);
        });
    }
};
