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
            $table->string('kabupaten_id')->nullable()->after('id');
            $table->string('kecamatan_id')->nullable()->after('kabupaten_id');
            $table->enum('jenis', ['sosial', 'politik'])->nullable()->after('kecamatan_id');

            // Jika ingin menambahkan foreign key, bisa seperti ini:
            $table->foreign('kabupaten_id')->references('id')->on('kabupaten')->onDelete('cascade');
            $table->foreign('kecamatan_id')->references('id')->on('kecamatan')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('potensi_konflik', function (Blueprint $table) {
            $table->dropColumn(['kabupaten_id', 'kecamatan_id', 'jenis']);

            // Jika ada foreign key uncommented, hapus juga seperti ini:
            $table->dropForeign(['kabupaten_id']);
            $table->dropForeign(['kecamatan_id']);
        });
    }
};
