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
        Schema::create('pendataan_penduduk', function (Blueprint $table) {
            $table->id();
            $table->foreignId('petugas_id')->constrained('users')->onDelete('cascade');
            $table->string('nik', 20)->unique();
            $table->string('no_kk', 20);
            $table->string('nama_lengkap', 100)->nullable();
            $table->string('tempat_lahir', 50)->nullable();
            $table->date('tanggal_lahir')->nullable();
            $table->enum('jenis_kelamin', ['L', 'P']);
            $table->string('agama', 20)->nullable();
            $table->string('status_perkawinan', 20)->nullable();
            $table->string('hubungan_keluarga', 30)->nullable();
            $table->string('pekerjaan', 50)->nullable();
            $table->string('pendidikan_terakhir', 30)->nullable();
            $table->text('alamat')->nullable();
            $table->enum('status_hidup', ['hidup', 'meninggal', 'pindah'])->default('hidup');
            $table->enum('status_verifikasi', ['pending', 'terverifikasi', 'ditolak'])->default('pending');
            $table->text('catatan')->nullable();
            $table->timestamp('tanggal_pendataan')->useCurrent();
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pendataan_penduduk');
    }
};