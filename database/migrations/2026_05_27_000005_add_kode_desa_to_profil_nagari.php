<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::table('profil_nagari')->insert([
            'setting_key' => 'kode_desa',
            'setting_value' => '400.7.22',
        ]);
    }

    public function down(): void
    {
        DB::table('profil_nagari')->where('setting_key', 'kode_desa')->delete();
    }
};
