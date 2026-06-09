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
        Schema::create('jenis_layanan', function (Blueprint $table) {
            $table->id();
            $table->string('nama_layanan', 100);
            $table->text('deskripsi')->nullable();
            $table->text('persyaratan')->nullable();
            $table->unsignedBigInteger('template_id')->nullable(); // Relasi ke template_surat
            $table->timestamp('created_at')->useCurrent();

            $table->foreign('template_id')->references('id')->on('template_surat')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jenis_layanan');
    }
};
