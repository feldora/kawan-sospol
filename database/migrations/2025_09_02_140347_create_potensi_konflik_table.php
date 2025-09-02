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
        Schema::create('potensi_konflik', function (Blueprint $table) {
            $table->id();
            $table->string('nama_potensi'); // Nama Potensi Konflik
            $table->date('tanggal_potensi')->nullable(); // Tanggal konflik
            $table->string('desa_id'); // Relasi ke tabel desa
            $table->text('latar_belakang')->nullable(); // Fakta/latar belakang
            $table->string('penanggung_jawab')->nullable(); // Penanggung jawab / Korlap
            $table->timestamps();

            // Foreign key
            $table->foreign('desa_id')->references('id')->on('desa')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('potensi_konflik');
    }
};
