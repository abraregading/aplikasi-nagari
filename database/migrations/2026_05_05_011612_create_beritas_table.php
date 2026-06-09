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
        Schema::create('beritas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kategoriberita_id')->constrained('kategoriberitas')->onDelete('cascade');
            $table->string('judul_berita');
            $table->string('slug')->unique();
            $table->text('isi_berita1');
            $table->text('isi_berita2');
            $table->text('isi_berita3');
            $table->text('quote');
            $table->string('gambar_berita');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('beritas');
    }
};
