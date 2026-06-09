<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('penghuni_kos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('bisnis_kos_id')->constrained('bisnis_kos')->onDelete('cascade');
            $table->foreignId('petugas_id')->constrained('users')->onDelete('cascade');
            $table->string('nama_lengkap', 100);
            $table->string('nik', 20)->nullable();
            $table->string('jekel', 10)->nullable();
            $table->date('tanggal_lahir')->nullable();
            $table->string('tempat_lahir', 100)->nullable();
            $table->string('pekerjaan', 100)->nullable();
            $table->string('asal_desa', 100)->nullable();
            $table->string('asal_kecamatan', 100)->nullable();
            $table->string('asal_kabupaten', 100)->nullable();
            $table->string('no_kamar', 20)->nullable();
            $table->decimal('harga_sewa', 15, 2)->nullable();
            $table->date('tanggal_masuk')->nullable();
            $table->date('tanggal_keluar')->nullable();
            $table->enum('status', ['aktif', 'pindah', 'keluar'])->default('aktif');
            $table->text('catatan')->nullable();
            $table->timestamps();

            $table->index('bisnis_kos_id');
            $table->index('petugas_id');
            $table->index('status');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('penghuni_kos');
    }
};