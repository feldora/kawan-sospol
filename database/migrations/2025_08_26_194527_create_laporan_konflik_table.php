<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('laporan_konflik', function (Blueprint $table) {
            $table->id();

            $table->string('nama_pelapor')->nullable();
            $table->string('kontak')->nullable();

            // $table->foreignId('desa_id')->nullable()->constrained('desa')->nullOnDelete();
            $table->string('desa_id')->nullable();
            $table->foreign('desa_id')->references('id')->on('desa')->nullOnDelete();

            $table->string('lokasi_text')->nullable();

            // kalau butuh koordinat manual
            $table->decimal('lat', 10, 7)->nullable();
            $table->decimal('lng', 10, 7)->nullable();

            $table->text('deskripsi')->nullable();

            $table->enum('status', ['baru', 'ditindaklanjuti', 'selesai'])->default('baru');
            $table->string('diteruskan_ke')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('laporan_konflik');
    }
};
