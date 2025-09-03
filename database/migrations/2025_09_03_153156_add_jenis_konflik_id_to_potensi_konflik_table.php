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
            // tambahkan kolom baru, boleh nullable dulu agar data lama tidak error
            $table->unsignedBigInteger('jenis_konflik_id')->nullable()->after('id');

            // buat foreign key ke tabel jenis_konflik
            $table->foreign('jenis_konflik_id')
                  ->references('id')
                  ->on('jenis_konflik')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('potensi_konflik', function (Blueprint $table) {
            $table->dropForeign(['jenis_konflik_id']);
            $table->dropColumn('jenis_konflik_id');
        });
    }
};
