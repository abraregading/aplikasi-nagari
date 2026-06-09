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
        Schema::create('riwayat_surat', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('nik_pemohon', 20)->nullable();
            $table->string('jenis_surat', 100);
            $table->text('keterangan')->nullable();
            $table->string('pernyataan', 255)->nullable();
            $table->unsignedBigInteger('penandatangan_id')->nullable();
            $table->string('jorong', 100)->nullable();
            $table->string('nama_jalan', 255)->nullable();
            $table->date('tanggal_pengantar')->nullable();
            $table->string('nomor_surat', 50)->nullable();
            $table->enum('status', ['diajukan', 'diproses', 'selesai', 'ditolak'])->default('diajukan');
            $table->string('file_lampiran', 255)->nullable();
            $table->timestamp('tanggal_pengajuan')->useCurrent();
            $table->dateTime('tanggal_selesai')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('layanan_surat');
    }
};
