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
        Schema::create('template_surat', function (Blueprint $table) {
            $table->id();
            $table->string('nama_template', 100);
            $table->text('deskripsi')->nullable();
            $table->text('isi_template'); // HTML atau teks template surat
            $table->string('tipe', 50)->nullable(); // Jenis surat, misal: pengantar, keterangan, dsb
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('template_surat');
    }
};
