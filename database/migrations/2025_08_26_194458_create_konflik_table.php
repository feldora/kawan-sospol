<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('konflik', function (Blueprint $table) {
            $table->id();
            $table->string('desa_id');
            $table->foreign('desa_id')->references('id')->on('desa')->cascadeOnDelete();

            $table->enum('jenis', ['sosial', 'politik']);
            $table->string('judul')->nullable();
            $table->text('deskripsi')->nullable();
            $table->integer('jumlah')->default(0);

            $table->text('penanganan')->nullable();
            $table->enum('status', ['aktif', 'selesai', 'dalam_proses'])->default('aktif');

            $table->dateTime('tanggal')->nullable();
            $table->string('sumber')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('konflik');
    }
};
