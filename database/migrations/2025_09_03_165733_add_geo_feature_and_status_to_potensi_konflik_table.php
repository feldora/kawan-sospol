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
        Schema::table('potensi_konflik', function (Blueprint $table) {
            // Tambah relasi opsional ke geo_features (bisa point/line/polygon khusus konflik)
            $table->foreignId('geo_feature_id')
                  ->nullable()
                  ->after('jenis_konflik_id')
                  ->constrained('geo_features')
                  ->nullOnDelete();

            // Tambah eskalasi untuk level konflik
            $table->enum('eskalasi', ['rendah', 'sedang', 'tinggi'])
                  ->nullable()
                  ->after('latar_belakang');

            // Tambah status monitoring konflik
            $table->enum('status_konflik', ['aktif', 'selesai', 'dipantau'])
                  ->default('aktif')
                  ->after('eskalasi');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('potensi_konflik', function (Blueprint $table) {
            $table->dropForeign(['geo_feature_id']);
            $table->dropColumn(['geo_feature_id', 'eskalasi', 'status_konflik']);
        });
    }
};
