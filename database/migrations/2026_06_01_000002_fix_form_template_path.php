<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::table('template_surat')
            ->where('form_template', 'operator.buatsurat.forms.surat-keterangan-penghasilan')
            ->update(['form_template' => 'operator.buatsurat.forms.surat-penghasilan']);

        DB::table('jenis_surat')
            ->where('form_template', 'operator.buatsurat.forms.surat-keterangan-penghasilan')
            ->update(['form_template' => 'operator.buatsurat.forms.surat-penghasilan']);
    }

    public function down(): void
    {
        DB::table('template_surat')
            ->where('form_template', 'operator.buatsurat.forms.surat-penghasilan')
            ->update(['form_template' => 'operator.buatsurat.forms.surat-keterangan-penghasilan']);

        DB::table('jenis_surat')
            ->where('form_template', 'operator.buatsurat.forms.surat-penghasilan')
            ->update(['form_template' => 'operator.buatsurat.forms.surat-keterangan-penghasilan']);
    }
};
