<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bisnis_kos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('petugas_id')->constrained('users')->onDelete('cascade');
            $table->string('nama_usaha', 100);
            $table->enum('jenis_usaha', ['kos', 'kontrakan', 'rumah_petak']);
            $table->string('alamat', 255);
            $table->string('rt', 10)->nullable();
            $table->string('rw', 10)->nullable();
            $table->string('desa_kelurahan', 100)->nullable();
            $table->string('kecamatan', 100)->nullable();
            $table->string('kabupaten_kota', 100)->nullable();
            $table->string('provinsi', 100)->nullable();
            $table->integer('jumlah_kamar')->default(0);
            $table->decimal('harga_sewa_min', 15, 2)->nullable();
            $table->decimal('harga_sewa_max', 15, 2)->nullable();
            $table->string('fasilitas', 500)->nullable();
            $table->string('pemilik_nama', 100);
            $table->string('pemilik_nik', 20)->nullable();
            $table->string('pemilik_telepon', 20)->nullable();
            $table->enum('status', ['aktif', 'nonaktif'])->default('aktif');
            $table->text('catatan')->nullable();
            $table->timestamps();

            $table->index('jenis_usaha');
            $table->index('status');
            $table->index('petugas_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bisnis_kos');
    }
};