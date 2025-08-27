<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Kabupaten;
use App\Models\Kecamatan;
use App\Models\Desa;
use App\Models\Konflik;
use App\Models\PenangananKonflik;
use Carbon\Carbon;

class KonflikSeeder extends Seeder
{
    public function run(): void
    {
        $kabupatenIds = ['72.71', '72.10'];

        $jenisKonflik = ['sosial', 'politik'];
        $penangananArr = [
            'Mediasi oleh aparat kelurahan',
            'Ditangani Bawaslu dan Kesbangpol',
            'Dialog antar tokoh masyarakat',
            'Pengawasan Bawaslu',
            'Penyelesaian adat setempat',
            'Pendampingan oleh Kesbangpol',
            'Difasilitasi FKUB',
            'Dilaporkan ke KPU setempat'
        ];

        foreach ($kabupatenIds as $id) {
            $kab = Kabupaten::with(['kecamatan.desa.geoFeature'])->find((string) $id);

            if ($kab) {
                if($id == '72.71'){
                    $desaList = $kab->kecamatan->flatMap->desa->take(3);
                } else {
                    $kecamatan_ids = ['72.10.14', '72.10.12','72.10.01'];
                    $desaList = $kab->kecamatan->whereIn('id', $kecamatan_ids)->flatMap->desa->take(3);
                }

                foreach ($desaList as $desa) {
                    if (!$desa->geoFeature) {
                        continue;
                    }

                    // Buat konflik
                    $konflik = Konflik::create([
                        'desa_id'    => $desa->id,
                        'jenis'      => $jenisKonflik[array_rand($jenisKonflik)],
                        'judul'      => 'Kasus ' . ucfirst($desa->nama),
                        'deskripsi'  => 'Terjadi permasalahan di wilayah ini terkait isu lokal.',
                        'jumlah'     => rand(1, 15),
                        'penanganan' => $penangananArr[array_rand($penangananArr)],
                        'status'     => ['aktif', 'selesai', 'dalam_proses'][array_rand(['aktif', 'selesai', 'dalam_proses'])],
                        'tanggal'    => Carbon::now()->subDays(rand(0, 30)),
                        'sumber'     => 'Laporan masyarakat',
                    ]);

                    // Buat penanganan konflik untuk konflik tersebut (bisa lebih dari 1)
                    $jumlahPenanganan = rand(1, 2);
                    for ($i = 0; $i < $jumlahPenanganan; $i++) {
                        PenangananKonflik::create([
                            'konflik_id' => $konflik->id,
                            'instansi'   => ['Bawaslu', 'Kesbangpol', 'Polsek', 'FKUB'][array_rand(['Bawaslu', 'Kesbangpol', 'Polsek', 'FKUB'])],
                            'tindakan'   => $penangananArr[array_rand($penangananArr)],
                            'tanggal'    => Carbon::now()->subDays(rand(0, 30)),
                        ]);
                    }
                }
            }
        }
    }
}
