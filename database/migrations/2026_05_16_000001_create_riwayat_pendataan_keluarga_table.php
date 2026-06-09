<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('riwayat_pendataan_keluarga', function (Blueprint $table) {
            $table->id();
            $table->foreignId('petugas_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('keluarga_id')->constrained('keluarga')->onDelete('cascade');
            $table->string('no_kk', 20);
            $table->string('kepala_keluarga_nama')->nullable();
            $table->json('data_sebelum')->nullable();
            $table->json('data_sesudah')->nullable();
            $table->string('qr_token')->unique();
            $table->timestamp('tanggal_update')->useCurrent();
            $table->text('catatan')->nullable();
            $table->string('aksi')->default('update'); // create, update, delete
            $table->timestamps();

            $table->index('qr_token');
            $table->index(['keluarga_id', 'tanggal_update']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('riwayat_pendataan_keluarga');
    }
};