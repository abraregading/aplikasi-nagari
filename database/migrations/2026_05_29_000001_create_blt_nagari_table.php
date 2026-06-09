<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('blt_nagari', function (Blueprint $table) {
            $table->id();
            $table->foreignId('penduduk_id')->nullable()->constrained('penduduk')->nullOnDelete();
            $table->string('nik', 20);
            $table->string('nama', 100);
            $table->string('no_kk', 20)->nullable();
            $table->string('tempat_lahir', 50)->nullable();
            $table->date('tanggal_lahir')->nullable();
            $table->text('alamat_jalan')->nullable();
            $table->string('alamat_jorong', 50)->nullable();
            $table->string('pekerjaan', 50)->nullable();
            $table->integer('jumlah_anggota_keluarga')->default(0);
            $table->year('tahun')->default(date('Y'));
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('blt_nagari');
    }
};
