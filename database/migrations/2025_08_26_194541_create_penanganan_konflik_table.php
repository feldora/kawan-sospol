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
        Schema::create('penanganan_konflik', function (Blueprint $table) {
            $table->id();
            $table->foreignId('konflik_id')->constrained('konflik')->cascadeOnDelete();

            $table->string('instansi')->nullable();
            $table->text('tindakan')->nullable();
            $table->dateTime('tanggal')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('penanganan_konflik');
    }
};
