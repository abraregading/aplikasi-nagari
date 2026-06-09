<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('jenis_surat', function (Blueprint $table) {
            if (!Schema::hasColumn('jenis_surat', 'template_file')) {
                $table->string('template_file', 100)->nullable()->after('template_id');
            }
            if (!Schema::hasColumn('jenis_surat', 'form_template')) {
                $table->string('form_template', 100)->nullable()->after('template_file');
            }
        });

        DB::table('template_surat')
            ->where('form_template', 'operator.buatsurat.forms.surat-keterangan-penghasilan')
            ->update(['form_template' => 'operator.buatsurat.forms.surat-penghasilan']);

        DB::table('jenis_surat')
            ->where('form_template', 'operator.buatsurat.forms.surat-keterangan-penghasilan')
            ->update(['form_template' => 'operator.buatsurat.forms.surat-penghasilan']);
    }

    public function down(): void
    {
        if (Schema::hasColumn('jenis_surat', 'form_template')) {
            Schema::table('jenis_surat', function (Blueprint $table) {
                $table->dropColumn('form_template');
            });
        }
        if (Schema::hasColumn('jenis_surat', 'template_file')) {
            Schema::table('jenis_surat', function (Blueprint $table) {
                $table->dropColumn('template_file');
            });
        }
    }
};
