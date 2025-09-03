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
        Schema::table('laporan_konflik', function (Blueprint $table) {
            // Tambahkan kolom relasi opsional ke potensi_konflik
            $table->foreignId('potensi_konflik_id')
                  ->nullable()
                  ->after('desa_id')
                  ->constrained('potensi_konflik')
                  ->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('laporan_konflik', function (Blueprint $table) {
            $table->dropForeign(['potensi_konflik_id']);
            $table->dropColumn('potensi_konflik_id');
        });
    }
};
