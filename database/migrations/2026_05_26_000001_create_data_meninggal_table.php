<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('data_meninggal', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('penduduk_id')->nullable();
            $table->string('nik', 20);
            $table->string('nama_lengkap', 100);
            $table->enum('jenis_kelamin', ['L', 'P']);
            $table->date('tanggal_lahir')->nullable();
            $table->string('no_kk', 20)->nullable();
            $table->string('jorong', 100)->nullable();
            $table->date('tanggal_meninggal');
            $table->time('waktu_meninggal')->nullable();
            $table->string('tempat_meninggal', 100)->nullable();
            $table->string('sebab_meninggal', 200)->nullable();
            $table->text('keterangan')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('data_meninggal');
    }
};
