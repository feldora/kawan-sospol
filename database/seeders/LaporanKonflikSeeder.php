<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Kabupaten;
use App\Models\Desa;
use App\Models\LaporanKonflik;

class LaporanKonflikSeeder extends Seeder
{
    public function run(): void
    {
        // Ambil kabupaten dengan id '72.71'
        $kabupaten = Kabupaten::with('kecamatan.desa')->find('72.71');

        if (! $kabupaten) {
            $this->command->warn("Kabupaten dengan id 72.71 tidak ditemukan, seeder dilewati.");
            return;
        }

        // Kumpulkan semua desa dari kecamatan di kabupaten ini
        $desaIds = $kabupaten->kecamatan->flatMap->desa->pluck('id');

        if ($desaIds->isEmpty()) {
            $this->command->warn("Tidak ada desa dalam kabupaten 72.71, seeder dilewati.");
            return;
        }

        $faker = fake();

        // Buat banyak data (misalnya 500 laporan konflik)
        foreach (range(1, 500) as $i) {
            $desaId = $desaIds->random();
            $desa = Desa::with('kecamatan.kabupaten')->find($desaId);

            LaporanKonflik::create([
                'nama_pelapor'   => $faker->name(),
                'kontak'         => $faker->phoneNumber(),
                'desa_id'        => $desa->id,
                'potensi_konflik_id' => null, // bisa nanti dihubungkan ke data nyata
                'lokasi_text'    => "{$desa->nama}, {$desa->kecamatan->nama}, {$desa->kecamatan->kabupaten->nama}",
                'lat'            => $faker->latitude(-1.0, 1.0),
                'lng'            => $faker->longitude(119.0, 122.0),
                'deskripsi'      => $faker->paragraphs(2, true),
                'status'         => $faker->randomElement(['baru', 'ditindaklanjuti', 'selesai']),
                'diteruskan_ke'  => $faker->company(),
            ]);
        }

        $this->command->info("Seeder berhasil menambahkan 500 laporan konflik dummy untuk kabupaten 72.71.");
    }
}
