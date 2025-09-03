<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class JenisKonflikSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('jenis_konflik')->insert([
            [
                'nama' => 'Konflik Sosial, Politik, Ekonomi, dan Budaya',
                'deskripsi' => 'Konflik akibat gesekan sosial, persaingan politik, kesenjangan ekonomi, atau perbedaan budaya.'
            ],
            [
                'nama' => 'Konflik Sumber Daya Alam',
                'deskripsi' => 'Sengketa lahan, pengelolaan hutan, air, tambang, dan perebutan sumber daya.'
            ],
            [
                'nama' => 'Konflik Agama, Suku, dan Ras (SARA)',
                'deskripsi' => 'Gesekan identitas terkait agama, suku, atau ras yang menimbulkan diskriminasi dan intoleransi.'
            ],
            [
                'nama' => 'Konflik Tapal Batas atau Batas Wilayah',
                'deskripsi' => 'Perselisihan batas desa, kelurahan, kecamatan, atau kabupaten/kota.'
            ],
            [
                'nama' => 'Konflik Pemerintahan',
                'deskripsi' => 'Perselisihan antarinstansi, konflik birokrasi, atau ketidakpuasan masyarakat terhadap kebijakan pemerintah.'
            ],
        ]);
    }
}
