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
        Schema::create('penandatangan', function (Blueprint $table) {
            $table->id();
            $table->string('nama', 100);
            $table->string('nip', 30)->nullable();
            $table->string('jabatan', 100);
            $table->string('pangkat_golongan', 50)->nullable();
            $table->boolean('is_active')->default(true);
            $table->boolean('is_default')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('penandatangan');
    }
};
