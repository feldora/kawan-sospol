<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class KonflikSeederReal extends Seeder
{
    public function run(): void
    {
        DB::statement('SET session_replication_role = replica;');
        DB::table('potensi_konflik')->truncate();
        DB::statement('SET session_replication_role = DEFAULT;');


        // DB::enableQueryLog();
        // Helper untuk ambil id desa dari tabel `desa`
        $getDesaId = function (string $namaDesa, ?string $namaKecamatan = null) {
            $q = DB::table('desa')->whereRaw('LOWER(nama) = ?', [mb_strtolower($namaDesa, 'UTF-8')]);

            if ($namaKecamatan && DB::getSchemaBuilder()->hasColumn('desa', 'kecamatan')) {
                $q->whereRaw('LOWER(kecamatan) = ?', [mb_strtolower($namaKecamatan, 'UTF-8')]);
            }

            $id = $q->value('id');

            if (!$id) {
                throw new \RuntimeException("ID desa untuk '{$namaDesa}'" . ($namaKecamatan ? " (Kec. {$namaKecamatan})" : '') . " tidak ditemukan di tabel `desa`. Sesuaikan pencarian nama/kolomnya.");
            }
            return $id;
        };

$rows = [
    [
        'nama_potensi'     => 'RDP Lintas Komisi Terkait Dampak Aktivitas Pertambangan PT. HM di Perkebunan Masyarakat Desa Padabaho',
        'tanggal_potensi'  => Carbon::parse('2025-01-05'),
        'desa_id'          => $getDesaId('Bahoruru', 'Bungku Tengah'),
        'latar_belakang'   => implode(' ', [
            "Rapat Dengar Pendapat (RDP) Lintas Komisi II & III DPRD Kab. Morowali membahas dampak aktivitas pertambangan PT. Hengjaya Mineralindo (PT. HM) di perkebunan masyarakat Desa Padabaho.",
            "Masyarakat melaporkan jalan hauling merusak kebun, sumber air bersih mengalami kekeruhan, dan ganti rugi tanam tumbuh belum dibayarkan.",
            "Kelompok Tani Jaya Bakti (±650 Ha, 230 KK) merasa haknya dilanggar karena lahan mereka tumpang tindih dengan IPPKH PT. HM. Sebagian kecil warga mendapat tali asih, tetapi masih ada puluhan warga yang belum mendapat ganti rugi.",
            "Poktan Jaya Bakti sebelumnya mendapat legalitas dari Bupati Morowali (1999) serta bantuan pertanian, dan lahan mereka juga dijadikan jaminan pinjaman ke bank.",
            "Aktivitas hauling PT. HM menutup akses warga menuju kebun serta menimbulkan sengketa lahan dengan luasan sekitar 785 Ha IPPKH.",
            "Pihak masyarakat menuntut kompensasi serta klarifikasi legalitas perizinan perusahaan."
        ]),
        'penanggung_jawab' => 'DPRD Kabupaten Morowali (Komisi II & III)',
    ],
[
    'nama_potensi'     => 'RDP Lanjutan Terkait Penolakan Aktivitas Tambang Batu Gamping PT. Denmar Jaya Mandiri (PT. DJM) oleh Sebagian Masyarakat di Desa Laroue',
    'tanggal_potensi'  => Carbon::parse('2025-01-13'),
    'desa_id'          => $getDesaId('Laroue', 'Bungku Timur'),
    'latar_belakang'   => implode(' ', [
        "Rapat Dengar Pendapat (RDP) lanjutan DPRD Kab. Morowali terkait penolakan masyarakat Desa Laroue terhadap aktivitas tambang batu gamping PT. Denmar Jaya Mandiri (PT. DJM).",
        "Perwakilan DPRD, Pemda, dan instansi teknis hadir untuk membahas legalitas izin perusahaan serta dampak terhadap masyarakat.",
        "Dari hasil peninjauan lapangan: luas lahan 5,021 Ha, dengan 1 Ha masuk dalam IUP Operasi Produksi PT. DJM dan 4 Ha berada di luar IUP.",
        "PT. DJM telah memiliki IUP OP seluas 73,53 Ha di Desa Laroue, Kec. Bungku Timur, serta persetujuan kesesuaian kegiatan pemanfaatan ruang (PKKPR).",
        "Dalam proses perizinan, terdapat syarat PKKPR dan Persetujuan Lingkungan; perusahaan dengan modal di bawah Rp. 5 miliar dapat terbit tanpa PKKPR.",
        "Tinjauan tata ruang menunjukkan area tambang masuk dalam RDTR 2022 Sub Zona Perkebunan, sedangkan rencana pelabuhan/tersus berada di Zona Pariwisata.",
        "Sebagian masyarakat tetap menolak aktivitas tambang dan mempertanyakan legalitas izin yang telah diterbitkan."
    ]),
    'penanggung_jawab' => 'DPRD Kabupaten Morowali',
],
[
    'nama_potensi'     => 'RDP Lintas Komisi Terkait Ganti Rugi Tanam Tumbuh Masyarakat Tangofa (FLS) Yang Digusur oleh PT. Hengjaya Mineralindo',
    'tanggal_potensi'  => Carbon::parse('2025-01-14'),
    'desa_id'          => $getDesaId('Tangofa', 'Bungku Pesisir'),
    'latar_belakang'   => implode(' ', [
        "Rapat Dengar Pendapat (RDP) lintas komisi DPRD Morowali membahas tuntutan ganti rugi tanam tumbuh masyarakat Desa Tangofa (Forum Lingkar Sulawesi/FLS) yang digusur oleh PT. Hengjaya Mineralindo.",
        "Sejumlah perwakilan DPRD, Pemda, aparat kepolisian, serta PT. HM hadir dalam pertemuan.",
        "FLS menuntut penyelesaian ganti rugi untuk 4 keluarga (±8 Ha) yang lahannya digusur pada Desember 2024 tanpa pembayaran kompensasi, meskipun sudah ada berita acara mediasi sejak 2019.",
        "Pemerintah daerah menegaskan bahwa meskipun ganti rugi lahan tidak bisa dilakukan, seharusnya ganti rugi tanam tumbuh bisa diberikan kepada masyarakat terdampak.",
        "PT. HM menjelaskan timeline izin: IUP Eksplorasi sejak 2011 (6.249 Ha, meliputi Padabaho, Bete-Bete, Puungkeu, Tangofa, One Ete, Tandaoleo, Lafeu, Makarti Jaya), IPPKH I (851,22 Ha) pada 2013, dan IPPKH II (994 Ha di Tangofa) pada 2018.",
        "Namun, konflik tetap berlanjut karena adanya penggusuran lahan masyarakat yang belum mendapat penyelesaian ganti rugi tanam tumbuh."
    ]),
    'penanggung_jawab' => 'DPRD Kabupaten Morowali (Lintas Komisi)',
],
[
    'nama_potensi'     => 'AUR oleh Tenaga Kerja Bongkar Muat (TKBM) Desa Topogaro dan Desa Tondo, Kec. Bungku Barat',
    'tanggal_potensi'  => Carbon::parse('2025-02-08'),
    'desa_id'          => $getDesaId('Topogaro', 'Bungku Barat'),
    'latar_belakang'   => implode(' ', [
        "Aksi Unjuk Rasa (AUR) dilakukan oleh Tenaga Kerja Bongkar Muat (TKBM) Desa Topogaro dan Desa Tondo, Kecamatan Bungku Barat, Kabupaten Morowali.",
        "Massa aksi sekitar 20 orang menuntut PT. Baoshuo Taman Industri Investment Group (BTIIG), PT. Indonesia Huabao Industrial Park (IHIP), dan PT. Laju Mineral Utama (LMU) untuk memberdayakan tenaga kerja lokal.",
        "Aksi dilakukan di dua lokasi: Jetty Topogaro dan Jetty Tondo, dengan dipimpin oleh Dirman (Ketua TKBM Topogaro), Sahidun (Ketua TKBM Tondo), Muhammad Sarif (Korlap I), dan Rudy (Korlap II).",
        "Tuntutan utama: hingga saat ini perusahaan belum memberdayakan TKBM lokal meskipun legalitas sudah dipenuhi dan telah dilakukan ±25 kali pertemuan tanpa hasil.",
        "Aksi berupa orasi, blokade akses Jetty dengan mobil sound, serta desakan mediasi dengan pihak perusahaan.",
        "Wazir Muhaimin menyampaikan bahwa reklamasi laut tidak pernah disosialisasikan, dampak perusahaan meluas hingga petani rumput laut, dan menyinggung dugaan aktivitas ilegal PT. BTIIG.",
        "Situasi sempat memanas ketika kendaraan perusahaan menghadang massa, namun aksi berakhir pukul 17.00 WITA dengan rencana aksi lanjutan."
    ]),
    'penanggung_jawab' => 'TKBM Desa Topogaro dan Desa Tondo',
],
[
    'nama_potensi'   => 'UR Oleh Tenaga Kerja Bongkar Muat (TKBM) Desa Topogaro dan Desa Tondo Kecamatan Bungku Barat Kabupaten Morowali',
    'tanggal_potensi'=> Carbon::parse('2025-02-09'),
    'desa_id'        => $getDesaId('Tondo', 'Bungku Barat', 'Morowali'),
    'latar_belakang' => "Pada hari Minggu, 9 Februari 2025 pukul 08.00 s.d 13.20 WITA, berlangsung aksi unjuk rasa oleh TKBM Desa Topogaro dan Desa Tondo menuntut pemberdayaan TKBM kepada PT. BTIIG/PT. IHIP/PT. LMU. Aksi dipimpin oleh Dirman (Ketua TKBM Topogaro), Sahidun (Ketua TKBM Tondo), Muhammad Sarif (Korlap I), Rudy (Korlap II), dan didampingi Wazir Muhaimin dengan sekitar 30 orang massa. Tuntutan utama adalah agar perusahaan segera memberdayakan TKBM lokal, karena hingga kini belum ada realisasi meski sudah ada perjanjian. Aksi dilakukan di Jetty Tondo, dengan alat peraga berupa mobil sound, spanduk, sepeda motor, dan perahu masyarakat.",
    'penanggung_jawab'=> 'Bakesbangpol Kab. Morowali',
],
[
    'nama_potensi'   => 'Aksi Unras Oleh Aliansi Masyarakat Torete Bersatu (AMTB)',
    'tanggal_potensi'=> Carbon::parse('2025-02-05'),
    'desa_id'        => $getDesaId('Torete', 'Bungku Pesisir', 'Morowali'),
    'latar_belakang' => "Pada 5 Februari 2025 pukul 10.00 WITA, sekitar 50 orang massa yang dipimpin Arlan Dahlin (Korlap) mengatasnamakan Aliansi Masyarakat Torete Bersatu (AMTB) melakukan unjuk rasa menolak aktivitas PT. Indo Berkah Jaya Mandiri (IJM)/PT. Batulicin Enam Sembilan (BES) dan PT. Raihan Catur Putra (RCP). Aksi dimulai dari Aula Serbaguna Desa Torete, dilanjutkan ke jalan hauling PT. IJM/PT. RCP, hingga ke Kantor Kecamatan Bungku Pesisir di Desa Lafeu. Massa menutup jalan hauling dan melakukan orasi. Tuntutan antara lain: perusahaan wajib sosialisasi AMDAL, menyelesaikan konflik lahan, bertanggung jawab atas kerusakan tanaman, memperhatikan keselamatan kerja, serta memberdayakan masyarakat lokal. Aksi dihadiri aparat keamanan, pemerintah kecamatan, dan perwakilan perusahaan (PT. IJM/PT. RCP). Mediasi berlangsung hingga pukul 13.47 WITA, dan disepakati akan ada sosialisasi lanjutan pada 12 Februari 2025.",
    'penanggung_jawab'=> 'Bakesbangpol Kab. Morowali',
],
[
    'nama_potensi'   => 'Aksi Unjuk Rasa Serikat Pekerja Industrial Morowali - KPBI',
    'tanggal_potensi'=> Carbon::parse('2025-02-18'),
    'desa_id'        => $getDesaId('Fatufia', 'Bahodopi', 'Morowali'),
    'latar_belakang' => "Pada 18 Februari 2025 pukul 09.10 WITA, sekitar 200 massa dari Serikat Pekerja Industrial Morowali - Konfederasi Persatuan Buruh Indonesia (SPIM-KPBI) dipimpin Muh. Fadil (Korlap) melakukan unjuk rasa di depan Pos Utama Kantor PT. IMIP, Desa Fatufia, Kec. Bahodopi. Aksi dipicu dugaan PHK sepihak oleh PT. ITSS yang dianggap bertentangan dengan rekomendasi Disnakertrans. Massa membawa mobil pick-up, sound system, bendera serikat, spanduk, dan selebaran. Tuntutan utama: maksimalkan penerapan K3, stop union busting & pekerjakan kembali Anwar sesuai anjuran Trans, hentikan mutasi sepihak, sediakan fasilitas layak bagi pekerja perempuan, laksanakan norma ketenagakerjaan & cabut izin LPTKS yang melanggar aturan, serta naikkan upah buruh 50%. Aksi berlangsung dengan orasi, long march, pembakaran ban, hingga dialog dengan manajemen PT. IMIP. Pertemuan mediasi digelar pukul 15.27 WITA dengan perwakilan HRD, legal, komrel, dan serikat buruh, namun keputusan final ditunda keesokan harinya. Massa bubar pukul 16.10 WITA dalam keadaan aman dan kondusif.",
    'penanggung_jawab'=> 'Bakesbangpol Kab. Morowali',
],
[
    'nama_potensi'    => 'Aksi Unjuk Rasa Himpunan Mahasiswa Pemuda Pelajar Kec. Bahodopi (HIMP2)',
    'tanggal_potensi' => Carbon::parse('2025-02-17'),
    'desa_id'         => $getDesaId('Tangofa', 'Bungku Pesisir', 'Morowali'),
    'latar_belakang'  => "Pada 17 Februari 2025 pukul 10.55 WITA, di depan Pos Security PT. Hengjaya Mineralindo Desa Tangofa, Kec. Bungku Pesisir, Kab. Morowali, berlangsung aksi unjuk rasa oleh Himpunan Mahasiswa Pemuda Pelajar Kec. Bahodopi (HIMP2 Sultra) dipimpin Sdr. Sahril (Korlap) dengan jumlah massa sekitar 30 orang. Tuntutan massa: (1) Mendesak PT. Hengjaya Mineralindo menunaikan kewajiban kepada masyarakat Desa Bete-Bete, (2) Transparansi AMDAL, IUP dan PPM, (3) Hentikan penggusuran tanpa kompensasi, (4) Tolak perampasan lahan, (5) Transparansi IUP 5.983 ha, (6) Pemberdayaan masyarakat Desa Bete-Bete. Aksi menggunakan mobil truk, sound system, bendera organisasi, dan spanduk. Rangkaian kegiatan: penggalangan massa di Desa Bete-Bete pukul 08.45, long march ke perusahaan pukul 10.12, tiba di pos keamanan pukul 10.55, lalu pertemuan di Gazebo Vendoari pukul 11.42 dengan pihak PT. Hengjaya Mineralindo, aparat Polsek Bungku Pesisir, Babinsa, dan Kades Bete-Bete. Hasil pertemuan: perusahaan menyebut telah memberi tali asih Rp40 juta/KK untuk 350 KK (total Rp5 miliar), namun ganti rugi tanam tumbuh belum dibayarkan. Disepakati pertemuan lanjutan di Balai Desa Bete-Bete bersama dinas terkait. Pukul 13.03 massa membubarkan diri tertib.",
    'penanggung_jawab'=> 'Bakesbangpol Kab. Morowali',
],
[
    'nama_potensi'    => 'Aksi Unras Aliansi Serikat Buruh Industri Pertambangan dan Energi (SBIPE) Morowali',
    'tanggal_potensi' => Carbon::parse('2025-02-17'),
    'desa_id'         => $getDesaId('Fatufia', 'Bahodopi', 'Morowali'),
    'latar_belakang'  => "Pada 17 Februari 2025 pukul 09.15 WITA, sekitar 20 orang dari Serikat Buruh Industri Pertambangan dan Energi (SBIPE) Morowali yang dipimpin Henri (Korlap/Ketua DPC SBIPE Morowali) melaksanakan aksi unjuk rasa memperingati Bulan K3 di depan Kantor PT. IMIP, Desa Fatufia, Kec. Bahodopi. Massa berkumpul sejak pukul 08.00 WITA di pelataran Masjid Al-Khairat, kemudian bergerak ke lokasi aksi pada pukul 08.54 WITA. Tuntutan yang disampaikan antara lain: tanggung jawab PT. IMIP terkait kecelakaan kerja, pemberian kompensasi yang adil bagi korban dan keluarga, peningkatan standar serta pengawasan K3, penyediaan peralatan dan pelatihan kerja yang lebih aman, serta perlindungan bagi seluruh pekerja di kawasan industri. Pukul 11.30 WITA, pihak manajemen yang diwakili Immanuel Tewel menemui massa, menyampaikan bahwa aksi tersebut dianggap sebagai kampanye sehingga dialog tidak bisa dilakukan, namun aspirasi akan diteruskan kepada manajemen. Pukul 11.51 WITA, massa aksi membubarkan diri secara aman dan terkendali.",
    'penanggung_jawab'=> 'Bakesbangpol Kab. Morowali',
],
[
    'nama_potensi' => 'Aksi Unras Oleh Aliansi Asosiasi Perusahaan Jasa Tenaga Kerja (Apjaker) Morowali',
    'tanggal_potensi' => '2025-02-25',
    'desa_id' => $getDesaId('Fatufia', 'Bahodopi', 'KAB. MOROWALI', 'Sulawesi Tengah'),
    'latar_belakang' => "Menuntut Pihak PT. Teknik Alum Sevise (PT.TAS) untuk melakukan sosialisasi kepada masyarakat mengenai rencana pembangunan pabrik dan segera menghentikan kegiatan pembebasan lahan yang nilainya sebesar Rp.10.000 - Per meter.
b. Menuntut Pihak PT. Teknik Alum Sevise (PT.TAS) untuk melakukan normalisasi sungai LAAMBARU dan sungai LAANGKUROTO yang sudah hilang, selanjutnya sungai CINALAA dan sungai LAROMONAMPO yang sudah terjadi pendangkalan akibat pencemaran lingkungan.
c. Menuntut Pihak PT. Teknik Alum Sevise (PT.TAS) untuk segera melakukan pembayaran lahan sagu masyarakat yang berada di blok A maupun blok B yang sudah rusak akibat pencemaran lingkungan.
d. Menuntut Pihak PT. Teknik Alum Sevise (PT.TAS) untuk dilakukan ADDENDUM dari perjanjian pembebasan lahan tahun 2009 dan 2011 karena poin-poin perjanjian dibuat oleh pihak perusahaan tanpa melibatkan pemilik lahan.
e. Menuntut Pihak PT. Teknik Alum Sevise (PT.TAS) untuk tidak melakukan kegiatan di atas lahan kelompok seluas 38,967 Ha karena lahan tersebut belum pernah dibebaskan.
f. Menuntut Pihak PT. Teknik Alum Sevise (PT.TAS) untuk segera menghentikan tanah Budel Laroenai dan Buleleng karena belum melakukan penyerahan atau jual beli.
g. Menuntut Pihak PT. Teknik Alum Sevise (PT.TAS) untuk menyampaikan secara terbuka data-data pembebasan lahan masyarakat tahun 2011, 2023 di Blok A dan tahun 2009, 2011, 2024 di Blok B.
h. Menuntut Pihak PT. Teknik Alum Sevise (PT.TAS) meninjau kembali surat penyerahan Tanah di Blok A karena pembohongan publik terkait budidaya porang.
i. Menuntut Pihak PT. Teknik Alum Sevise (PT.TAS) menerapkan Undang-Undang dan peraturan tenaga kerja, karena banyak keluhan karyawan terkait gaji.
j. Menuntut Pihak PT. Teknik Alum Sevise (PT.TAS) untuk memindahkan kantor karena melanggar isi perjanjian pembebasan lahan tahun 2009.
k. Menuntut Pihak PT. Teknik Alum Sevise (PT.TAS) untuk melakukan kerja sama atau pemberdayaan terhadap masyarakat secara merata dan berkeadilan.",
    'penanggung_jawab' => 'Bakesbangpol Kab. Morowali',
],
[
    'nama_potensi'     => 'Aksi Unras oleh Serikat Pekerja Industri Morowali - Konfederasi Persatuan Buruh Indonesia (SPIM - KPBI)',
    'tanggal_potensi'  => Carbon::parse('2025-03-08'),
    'desa_id'          => $getDesaId('Fatufia', 'Bahodopi', 'Morowali', 'Sulawesi Tengah'),
    'latar_belakang'   => "Pada 8 Maret 2025 pukul 16.34 WITA, Sdri. Firda (Korlap) bersama sekitar 30 orang dari Serikat Pekerja Industri Morowali - Konfederasi Persatuan Buruh Indonesia (SPIM-KPBI) melakukan aksi unjuk rasa memperingati Hari Perempuan Internasional di depan Kantor PT. IMIP, Desa Fatufia, Kec. Bahodopi, Kab. Morowali.

Issu/tuntutan aksi meliputi:
1) Penuhi hak kesehatan reproduksi bagi buruh perempuan (WC, makanan, transportasi, air bersih, laktasi, obat-obatan emergency).
2) Permudah cuti haid dan melahirkan.
3) Stop intimidasi buruh perempuan.
4) Kebebasan berserikat, berkumpul, dan mengeluarkan pendapat.
5) Kesempatan kerja yang sama bagi perempuan.
6) Hak cuti bagi bapak (pendampingan istri melahirkan).

Alat peraga: spanduk, selebaran/pamflet, megaphone, bendera, kendaraan roda dua.

Rangkaian kegiatan:
- Pukul 16.34 WITA massa bergerak dari sekretariat SPIM-KPBI menuju perempatan Pos 2 PT. IMIP menggunakan sepeda motor.
- Pukul 16.45 WITA massa tiba di lokasi dan melakukan orasi bergantian dengan isi antara lain: seruan bangkit & bersuara untuk kesetaraan gender, menuntut pemenuhan hak-hak buruh perempuan, penolakan pelecehan/PHK sepihak, fasilitas transportasi & WC bagi ibu hamil, makanan bergizi, cuti haid, serta solidaritas dengan membagikan takjil.
- Pukul 18.00 WITA kegiatan selesai, massa membubarkan diri tertib dan aman.

Catatan: Aksi unjuk rasa rutin setiap tahun oleh SPIM-KPBI dalam rangka Hari Perempuan Internasional, kali ini dirangkaikan dengan pembagian takjil. Aksi mendapat pengamanan dari aparat TNI-POLRI dan Security MSS.",
    'penanggung_jawab' => 'Bakesbangpol Kab. Morowali',
],
[
    'nama_potensi'     => 'Aksi Spontanitas Pembakaran Pos dan Mobil Patroli Safety oleh Karyawan Kontraktor',
    'tanggal_potensi'  => Carbon::parse('2025-03-02'),
    'desa_id'          => $getDesaId('Fatufia', 'Bahodopi', 'Morowali', 'Sulawesi Tengah'),
    'latar_belakang'   => "Pada 2 Maret 2025 pukul 05.30 WITA terjadi aksi spontanitas pembakaran pos dan mobil patroli Safety oleh karyawan kontraktor terkait penggunaan bus LPTKS/karyawan kontraktor di kawasan Desa Fatufia, Kec. Bahodopi, Kab. Morowali. Massa aksi berjumlah sekitar 2.000 orang.

Kronologi:
1) Pukul 05.30 WITA, karyawan kontraktor yang masuk kerja melalui Lorong Kampus Poltek Desa Labota (Pos 6) dan Pos 1 Bandara Desa Keurea tidak diperbolehkan masuk karena tidak menggunakan bus, sesuai aturan baru mulai 1 Maret 2025.
2) Pukul 06.00 WITA, karyawan LPTKS/kontraktor melawan Safety PT. IMIP dan Security PT. MSS, membakar mobil Hilux milik Safety PT. IMIP serta pos Security.
3) Pukul 07.51 WITA, satu regu Brimob tiba di TKP (Pos 6, Desa Labota).
4) Pukul 07.55 WITA, situasi di Pos 6 mulai terkendali, sebagian massa bubar.
5) Pukul 09.00 WITA, TNI-POLRI menenangkan massa di jalur masuk Pos Bandara.
6) Pukul 09.45 WITA, massa mulai membuka akses lalu lintas di jalur masuk Pos Bandara.
7) Pukul 09.50 WITA, massa membubarkan diri dengan kondusif.
8) Pukul 10.05 WITA, arus lalu lintas di Pos Bandara kembali normal.

Akibat kejadian:
- Personil: Bripka Roni mengalami luka di kepala akibat pukulan massa.
- Materiil: 3 unit mobil Hilux Safety terbakar habis, Pos Security di Poltek dan Bandara rusak (dinding terbakar, kaca pecah).

Catatan:
Aksi terjadi karena aturan baru yang mewajibkan seluruh karyawan tenant dan kontraktor, baik TKA maupun lokal, menggunakan bus untuk antar-jemput di dalam kawasan IMIP. Perlu evaluasi bagi pihak manajemen PT. IMIP selaku pemilik kawasan terkait kebijakan tersebut. Perkembangan situasi dilaporkan lebih lanjut.",
    'penanggung_jawab' => '',
],
[
    'nama_potensi'     => 'Aksi Pemalangan Jalan Houling PT BTIIG/PT IHIP di Desa Topogaro',
    'tanggal_potensi'  => Carbon::parse('2025-04-05'),
    'desa_id'          => $getDesaId('Topogaro', 'Bungku Barat', 'Morowali', 'Sulawesi Tengah'),
    'latar_belakang'   => "Pada 5 April 2025 pukul 09.25–16.00 WITA berlangsung aksi pemalangan jalan houling PT BTIIG/PT IHIP di Desa Topogaro, Kec. Bungku Barat, Kab. Morowali. Aksi dipimpin oleh Tamrin Polempa (korlap) dan diikuti 10 orang.

Tuntutan massa:
a) Kelompok tani Dusun Rompio bersama masyarakat pemilik lahan di Gunung Le'ete/Pandera Kila menolak penggusuran/penyerobotan lahan oleh PT BTIIG tanpa sepengetahuan mereka.
b) Lahan tersebut belum diganti rugi meskipun telah dilakukan beberapa kali pertemuan, tetapi belum ada kejelasan dan respon dari perusahaan.

Koordinator aksi:
- Tamrin Polempa
- Udin T
- Samani
- Mukriadi
- Albar
- Hedar
- Piartinus Tumakaka
- Tukijan
- Ayub T
- Moh. Amin

Rangkaian aksi:
1) Pukul 09.30 WITA, massa menuju lokasi pemalangan, mendirikan tenda, dan menduduki lokasi.
2) Pemalangan dilakukan di perempatan jalan menuju kantor induk PT BTIIG di Desa Folili, Kec. Bungku Barat, menuntut penyelesaian ganti rugi lahan.
3) Pukul 11.30 WITA, massa menuntut realisasi surat perjanjian damai yang ditandatangani 18 Desember 2024 antara perusahaan BTIIG dan masyarakat terkait lahan.
4) Pukul 16.30 WITA, massa masih menduduki lokasi dan direncanakan akan dibubarkan paksa oleh Satpol-PP pada pukul 17.00 WITA.

Catatan:
Perkembangan situasi dan hal menonjol akan dilaporkan lebih lanjut.",
    'penanggung_jawab' => '',
],
[
    'nama_potensi'   => 'Banyaknya polemik dan keluhan masyarakat, kontraktor, pelajar lingkar tambang Kecamatan Bungku Timur atas hadirnya PT. Vale Indonesia Tbk (INCO) dan PT. Petrosea Tbk (PTRO) di Desa Bahomotefe, Kec. Bungku Timur, Kab. Morowali',
    'tanggal_potensi'=> Carbon::parse('2025-04-04'),
    'desa_id'        => $getDesaId('Kolono', 'Bungku Timur', 'Morowali', 'Sulawesi Tengah'),
    'latar_belakang' => "Aksi Unjuk Rasa oleh Aliansi Mahasiswa Bungku Timur (AMBT).
Pada 04 April 2025 pukul 14.00 WITA, Sdr. Reza (Korlap) bersama sekitar 30 orang melakukan aksi unjuk rasa terkait polemik dan keluhan masyarakat, kontraktor, dan pelajar lingkar tambang Bungku Timur atas kehadiran PT. Vale Indonesia Tbk (INCO) dan PT. Petrosea Tbk (PTRO).
Isu aksi: hentikan aktivitas PT. Petrosea, pemerataan dan pemberdayaan kontraktor lokal, perekrutan tenaga kerja lokal di 13 desa, transparansi rekrutmen Vale dan Petrosea, pembinaan karyawan baru, realisasi bantuan pendidikan.
Rangkaian aksi: berkumpul di masjid Al-Kautsar Desa Kolono, bergeser ke PT. Vale Desa Bahomotefe, berorasi soal lemahnya pemberdayaan lokal, menutup akses jalan Houling, membakar ban, lalu mediasi dengan perwakilan PT. Vale namun belum ada kesepakatan.
Catatan: massa memberi waktu 3x24 jam untuk diskusi ulang dengan manajemen Vale dan Petrosea, bila tidak maka akan dilakukan aksi lanjutan.",
    'penanggung_jawab' => '',
],
[
    'nama_potensi' => 'Aksi Unjuk Rasa oleh Aliansi Mahasiswa Bungku Timur (AMBT)',
    'tanggal_potensi' => Carbon::parse('2025-04-15'),
    'desa_id' => $getDesaId('Bahomotefe', 'Bungku Timur', 'Kab. Morowali', 'Sulawesi Tengah'),
    'latar_belakang' => 'I. Fakta-fakta A. Pada tanggal 15 April 2025 Pukul 11.57 Wita s.d selesai bertempat di Kantor PT. Petrosea dan Jalan Houling PT. Vale Desa Bahomotefe Kec. Bungku Timur Kab. Morowali rencana akan dilaksanakan Aksi Unjuk Rasa oleh Aliansi Mahasiswa Bungku Timur (AMBT), sehubungan banyaknya Polemik dan Keluhan Masyarakat, Kontraktor, Pelajar, Lingkar Tambang Kec. Bungku Timur atas hadirnya PT. Vale dan PT. Petrosea, dipimpin Jenderal Lapangan Sdr. Amrin, dengan estimasi massa ± 15 Orang. B. Adapun Issu Aksi sbb : 1. Hentikan aktivitas PT.Petrosea 2. Wujudkan pemerataan dan pemberdayaan kontraktor lokal 3. Wujudkan pemerataan dan perekrutan tenaga kerja lokal di wilayah pemberdayaan 13 Desa. 4. Wujudkan transparansi dan evaluasi perekrutan Vale dan Petrosea. 5. Vale dan Petrosea melakukan pembinaan terhadap karyawan yang baru direkrut. 6. Vale realisasikan bantuan pendidikan SD, SMP, SMA dan Mahasiswa. C. Perlengkapan aksi: Toa (pengeras suara), Mokom, Selebaran, Ban bekas, bensin, spanduk, dan kendaraan roda 2. D. Rangkaian kegiatan aksi: 1. Pukul 11.57 WITA, massa aksi berkumpul di depan kantor Camat Bungku Timur sembari menyiapkan spanduk. 2. Pukul 13.30 WITA, massa aksi bergerak menuju jembatan layang jalan Houling PT. Vale. 3. Pukul 13.50 WITA, massa tiba di lokasi dan mulai berorasi. Inti orasi: a. Kami sebagai putra daerah tidak akan tinggal diam melihat kesimpangan oleh pihak Vale dan Petrosea. b. Kami turun ke jalan bukan membawa kepentingan pribadi, tapi kepentingan masyarakat. c. Pemberdayaan lokal hanyalah wacana, komitmen sebelumnya belum diakomodir Vale. 4. Pukul 14.25 WITA, Tim Eksternal PT. Vale (Ibu Ani) dan perwakilan manajemen PT. Petrosea (Bpk. Jefrin) menemui massa aksi untuk menjadwalkan mediasi. E. Pukul 14.45 Wita, Massa Aksi membubarkan diri. II. Catatan: 1. Rencana pada 16 April 2025 pukul 10.00 WITA akan diadakan mediasi oleh PT. Vale dan PT. Petrosea bersama massa aksi di kantor Camat Bungku Timur. 2. Aksi tersebut merupakan aksi lanjutan, dimana belum ada titik temu dan kesepakatan dengan pihak manajemen.',
    'penanggung_jawab' => '',
],
[
    'nama_potensi'     => 'Unjuk Rasa Oleh Serikat Buruh Industri Pertambangan dan Energi (SBIPE) Morowali',
    'tanggal_potensi'  => Carbon::parse('2025-04-16'),
    'desa_id'          => $getDesaId('Fatufia', 'Bahodopi', 'Kab. Morowali', 'Sulawesi Tengah'),
    'latar_belakang'   => 'Aksi Unjuk Rasa (Piket) dilakukan oleh Serikat Buruh Industri Pertambangan dan Energi (SBIPE) Morowali pada 16 April 2025 di kawasan PT. IMIP Desa Fatufia, Kecamatan Bahodopi, Kabupaten Morowali. Aksi dipimpin oleh Henry Foord Jebss (Ketua SBIPE) dengan massa sekitar 10 orang, menyuarakan persoalan penerapan K3 di kawasan IMIP. Tuntutan mencakup kompensasi korban kecelakaan kerja, penghentian aktivitas kerja saat insiden, tanggung jawab penuh IMIP atas K3, penyediaan fasilitas K3 memadai, penghentian sanksi/denda terhadap korban kecelakaan, keterlibatan serikat buruh dalam investigasi, kenaikan upah, penghentian pembatasan izin sakit, pencabutan UU Cipta Kerja, serta evaluasi total standar K3 di seluruh proyek strategis nasional. Massa menggunakan megaphone, spanduk, dan selebaran, melakukan orasi tentang buruknya kondisi K3 di IMIP, di mana telah terjadi 9 kecelakaan kerja fatal sejak Februari 2025. Aksi berlangsung dari pukul 16.00–17.35 Wita dan berakhir tertib. Catatan tambahan: aksi ini merupakan agenda rutin tiap Rabu menjelang May Day sebagai protes sistem K3 di IMIP.',
    'penanggung_jawab' => '',
],
[
  'nama_potensi' => 'Aksi Spontanitas Karyawan PT. Wanxiang terkait keterlambatan pembayaran gaji',
  'tanggal_potensi' => Carbon::parse('2025-04-30'),
  'desa_id' => $getDesaId('Bahomotefe', 'Bungku Timur', 'Kab. Morowali', 'Sulawesi Tengah'),
  'latar_belakang' => 'Pada 30 April 2025, sekitar pukul 17.20 s.d 21.50 WITA, terjadi aksi spontanitas oleh kurang lebih 500 orang karyawan PT. Wanxiang di depan kantor perusahaan, Desa Bahomotefe, Kecamatan Bungku Timur, Morowali. Aksi dipicu oleh keterlambatan pembayaran gaji karyawan. Kronologi dimulai dengan pemberitahuan dari Afeng (Humas PT. Wanxiang) terkait keterlambatan gaji melalui grup WhatsApp, disusul dengan berkumpulnya karyawan di pintu gerbang hingga depan kantor. Massa berteriak menuntut pembayaran gaji segera. HRD perusahaan (Mr. Cheng) dan Supervisor HR (Indra) menyampaikan bahwa keterlambatan disebabkan kendala teknis dan administratif, dengan janji pembayaran paling lambat 15 Mei 2025. Namun massa menolak rapelan dan mendesak pembayaran segera. Disnakertrans Morowali, melalui mediator Moh Saleh Gamal dan Kabid HI Galib, memfasilitasi mediasi. Dalam pertemuan, massa menuntut: pembayaran gaji segera, hak lembur, dan pesangon PHK. Manajemen menyanggupi sebagian tuntutan, termasuk pembayaran gaji paling lambat 1 Mei 2025 pukul 18.00 WITA, serta kesepakatan bersama ditandatangani oleh semua pihak. Massa akhirnya bubar tertib pukul 21.50 WITA setelah adanya perjanjian tertulis.',
  'penanggung_jawab' => '',
],
[
    'nama_potensi' => 'Rapat Dengar Pendapat Masyarakat Talise Penggarap Lokasi Raranggarui, Kota Palu, Provinsi Sulawesi Tengah',
    'tanggal_potensi' => '2025-05-07',
    'desa_id' => $getDesaId('Besusu Barat', 'Palu Timur', 'Kota Palu', 'Sulawesi Tengah'),
    'latar_belakang' => "Pada hari Rabu tanggal 07 Mei 2025, pukul 11.40 WITA, bertempat di Ruang Baruga DPRD Prov. Sulteng Jl. Sam Ratulangi, Kel. Besusu Barat, Kec. Palu Timur, Kota Palu, Prov. Sulteng, dilaksanakan Rapat Dengar Pendapat (RDP) Masyarakat Talise penggarap lokasi Raranggarui yang diikuti ± 30 orang.

Peserta rapat antara lain Ketua Komisi 1 DPRD Prov. Sulteng, Wakil Ketua Komisi 1 DPRD Prov. Sulteng, Komisi III DPRD Prov. Sulteng, Ketua Perwakilan Pemilik Tanah Talise, Lembaga Adat Talise, anggota Komisi 1 DPRD, serta tokoh-tokoh masyarakat Talise.

Kronologi:
- Pukul 11.40, rapat dimulai oleh Ketua Komisi 1 DPRD Prov. Sulteng.
- Pukul 11.43, Ketua Perwakilan Pemilik Tanah Talise menyampaikan bahwa kehadiran PT. Citra Palu Minerals (CPM) menimbulkan berbagai masalah seperti potensi pencemaran logam berat, konflik sosial, kontribusi CSR yang minim, penggusuran lahan garapan masyarakat, penggunaan air tanpa kejelasan pajak, serta perlakuan tidak adil terhadap masyarakat Talise.
- Pukul 12.00, kegiatan istirahat.
- Pukul 12.34, rapat dilanjutkan.
- Pukul 12.35, Lembaga Adat Talise menyampaikan kronologi masyarakat Talise menguasai tanah sejak menanam dan memagar tanah, pembentukan aliansi masyarakat pada 18 Juli 2018, dan ancaman dari pihak yang mengklaim HGB.
- Pukul 13.01, RDP selesai berjalan aman dan lancar.",
    'penanggung_jawab' => 'Bakesbangpol Prov. Sul-Teng',
],
[
    'nama_potensi' => 'Warga Blokade Akses Jalan PT CPM, Tolak Tambang Bawah Tanah di Poboya Palu',
    'tanggal_potensi' => '2025-05-20',
    'desa_id' => $getDesaId('Poboya', 'Palu', 'Kota Palu', 'Sulawesi Tengah'),
    'latar_belakang' => "Pada hari Selasa tanggal 20 Mei 2025, bertempat di Jalan menuju tambang Citra Palu Minerals (CPM) di Kelurahan Poboya, Kota Palu, sejumlah warga melakukan aksi protes dengan memblokade akses jalan.

Aksi ini merupakan bentuk kekesalan warga terkait adanya kabar peresmian tambang bawah tanah (underground mining) PT CPM dan Macmahon di Poboya, yang dihadiri petinggi PT Bumi Resources Minerals Tbk (BRMS).

Koordinator Lapangan, Kusnadi Paputungan, menyampaikan bahwa sistem penambangan bawah tanah masih menjadi polemik bagi masyarakat lingkar tambang Poboya, karena perusahaan belum memberikan kepastian terkait dampak aktivitas tambang terhadap Kota Palu, terutama yang pernah dilanda gempa, tsunami, dan liquifaksi akibat sesar aktif Palu Koro.

Selain itu, CPM belum memberikan kepastian terkait tambang rakyat yang digarap masyarakat untuk kebutuhan sehari-hari. Masyarakat meminta agar CPM memberikan kepastian agar mereka bisa melakukan penambangan rakyat.

Tokoh Masyarakat Lingkar Tambang, Agus Salim Walahi, menambahkan bahwa persoalan lingkungan, kawasan Taman Hutan Raya (Tahura), dan tambang rakyat menimbulkan konflik. Masyarakat diklaim ilegal, tanah diambil paksa dan dibayar murah, serta pembebasan lahan dilakukan secara sistematis dan masif. PT CPM melalui BRMS menguasai sekitar 1.600 hektare lahan tanpa memberi ruang bagi masyarakat mengelola tambang rakyat. Banyak warga dikriminalisasi saat memperjuangkan haknya.

Masyarakat menegaskan tidak menolak investasi, tetapi menuntut pemberdayaan lingkar tambang dan penyelesaian konflik lahan dengan harga layak.",
    'penanggung_jawab' => 'Bakesbangpol Prov. Sul-Teng',
],
[
    'nama_potensi' => 'Warga Tutup Akses ke PT CPM, Tuntut Kepastian IPR di Poboya',
    'tanggal_potensi' => '2025-05-20',
    'desa_id' => $getDesaId('Poboya', 'Mantikulore', 'Kota Palu', 'Sulawesi Tengah'),
    'latar_belakang' => "Pada hari Selasa, tanggal 20 Mei 2025, puluhan warga penambang dan masyarakat lingkar tambang Poboya menutup akses jalan menuju PT Citra Palu Minerals (CPM) di Kelurahan Poboya, Kecamatan Mantikulore, Kota Palu.

Koordinator Rakyat Lingkar Tambang Poboya, Kusnadi Paputungan, menjelaskan bahwa aksi penutupan jalan ini sebagai bentuk penolakan terhadap sistem pertambangan bawah tanah (underground) yang diresmikan oleh Abu Rizal Bakrie. Masyarakat masih khawatir apakah sistem tambang bawah tanah ini aman atau berpotensi membahayakan lingkungan, terutama mengingat Kota Palu pernah dilanda gempa.

Selain itu, PT CPM belum memberikan kejelasan terkait Izin Pertambangan Rakyat (IPR) yang telah lama dinantikan warga. Tambang rakyat justru berisiko dibersihkan, sementara masyarakat yang menggantungkan hidup dari sana dicap sebagai PETI (Penambangan Tanpa Izin).

Tokoh Masyarakat Poboya, Agus Salim Walahi, menambahkan bahwa konflik PT CPM kompleks, mencakup persoalan lingkungan, kawasan Taman Hutan Raya (Tahura), dan tambang rakyat. Banyak warga dikriminalisasi saat memperjuangkan haknya. Masyarakat tidak menolak investasi, tetapi menuntut pemberdayaan, pemberian tambang rakyat, penyelesaian konflik lahan dengan harga layak, dan akses yang adil ke kebun mereka yang saat ini dibatasi oleh pos-pos perusahaan.",
    'penanggung_jawab' => 'Bakesbangpol Prov. Sul-Teng',
],

    [
        'nama_potensi' => 'Komunitas Anti Korupsi Sulawesi Tengah Jaringan Pendamping Kebijakan Pembangunan Bersama Forum Petani/Petani Plasma Kelapa Sawit Toli-Tili',
        'tanggal_potensi' => '2025-05-21',
        'desa_id' => $getDesaId('Besusu Barat', 'Palu Timur', 'Kota Palu', 'Sulawesi Tengah'),
        'latar_belakang' => "Pada hari Rabu tanggal 21 Mei 2025, pukul 08.40 s/d 12.00 WITA, bertempat di Kantor Gubernur Provinsi Sulawesi Tengah, sekitar 30 orang massa aksi dipimpin oleh Raslin, diterima oleh Karo Hukum A.n Adiman dan staf ahli Gubernur DR. Rohani Mastura.

Tuntutan aksi antara lain:
- Membuktikan bahwa Kajati berani menindak perusahaan yang merugikan rakyat dan daerah.
- Pemeriksaan puluhan perusahaan kelapa sawit harus murni penegakan hukum tanpa manipulasi.
- Forum Diskusi dan Gelar Kasus untuk menindak kecurangan perusahaan sawit.
- Menetapkan tersangka pada kasus PT. Ras dan menaikkan status lidik menjadi sidik pada kasus PT. TEN, PT. SONKELING buana dan perusahaan sawit lainnya.
- Bantuan gubernur dalam menyelesaikan persoalan lahan pertanian yang diserobot perusahaan kelapa sawit.
- Hentikan penerbitan HGU untuk lahan tidak clear & clean dan hentikan aktivitas perusahaan sawit ilegal.
- Evaluasi izin lokasi perusahaan perkebunan agar tidak terjadi monopoli lahan.
- Bersinergi dengan aparat penegak hukum untuk memberantas mafia perkebunan dan pertanahan.
- Gubernur harus tegas, berani mengganti pimpinan OPD jika tidak berani melaksanakan program untuk menjadikan Sulawesi Tengah Nambaso.",
        'penanggung_jawab' => 'Bakesbangpol Provinsi Sul-Teng',
    ],
    [
        'nama_potensi' => 'Penertiban Lokasi Tambang Emas (Ilegal Mining) dan Keberadaan WNA di Desa Kayuboko',
        'tanggal_potensi' => '2025-05-22',
        'desa_id' => $getDesaId('Kayuboko', 'Parigi Barat', 'Parigi Moutong', 'Sulawesi Tengah'),
        'latar_belakang' => "Pada Kamis, 22 Mei 2025, pukul 14.00 WITA, berlangsung kegiatan penertiban lokasi tambang emas ilegal dan keberadaan WNA di Desa Kayuboko, Kecamatan Parigi Barat, Kabupaten Parigi Moutong.

Peserta hadir meliputi AKBP Fery Nur Abdulah, AKBP Hendrawan, Abdul Rahman SH, Kompol Hendry Burhanudin, Akp Aris Suhendar, Iptu Moh. Fikri, Iptu Agus Salim, Iptu Yakobus Mangopo, Akp Mattan Songgo, Samrun (Kades Kayuboko), dan warga setempat.

Arahan Kapolres dan Dirreskrimsus Polda Sulteng menekankan penindakan tegas terhadap aktivitas PETI yang menggunakan alat berat excavator dan talang jombu. Aktivitas ilegal ini telah berjalan ± 3 bulan, dengan diduga dibekingi cukong tertentu. Masyarakat meminta aparat menertibkan seluruh pihak terkait untuk mencegah bencana lingkungan akibat aktivitas PETI, terutama saat musim penghujan.

Selain itu, ditemukan 14 WNA dari China yang terlibat di lokasi pertambangan ilegal, menginap di hotel dan penginapan lokal, yang harus ditindaklanjuti oleh aparat untuk menghentikan kegiatan ilegal tersebut.",
        'penanggung_jawab' => 'Bakesbangpol Kab. Parimo',
    ],
[
    'nama_potensi' => 'Rapat Mediasi Masyarakat Desa Laroenai, Kec. Bungku Pesisir dengan Pemerintah Kabupaten Morowali serta PT. Bima Cakra Mineralindo',
    'tanggal_potensi' => '2025-05-23',
    'desa_id' => $getDesaId('Bente', 'Bungku Tengah', 'Morowali', 'Sulawesi Tengah'),
    'latar_belakang' => "Pada hari 23 Mei 2025, pukul 09.30 s.d 11.45 WITA, bertempat di Ruangan Asisten I, Kantor Bupati Morowali, Kompleks Perkantoran Bumi Fonuasingko, Desa Bente, Kec. Bungku Tengah, Kab. Morowali, telah dilaksanakan Rapat Mediasi Masyarakat Desa Laroenai dengan Pemerintah Kabupaten Morowali dan PT. Bima Cakra Mineralindo.

Hadir dalam kegiatan: Ir. Rizal Baduddin (Asisten I Pemda Kab. Morowali), Asfar (Staff Khusus Bupati), Ahmad S.T (Kadisnakertrans), Bahdin Baid S.H M.H (Kabag Hukum), Asep Haerudin (Kabag Tapem), Galib (Kepala Bidang Hubungan Industri Nakertrans), Samran (Sekretaris Camat Bungku Pesisir), Dahlan Lette (Sekretaris Desa Laroenai), Herlan & Rustam (Forum Masyarakat Desa Laroenai), Ahmad Lufi & Aldo (Perwakilan PT. Bima Cakra Mineralindo).

Rangkaian kegiatan:
- Pukul 09.33 WITA, Ir. Rizal Baduddin menyampaikan latar belakang rapat terkait aspirasi masyarakat terhadap aktivitas PT. Bima Cakra Mineralindo, khususnya Biaya PPM Plus, PBM, dan TKBM.
- Dahlan Lette menyampaikan permintaan masyarakat agar perusahaan lebih memperhatikan desa.
- Rustam menekankan ketidakadilan perusahaan terkait pemberdayaan masyarakat, serta permintaan biaya per tongkang Rp. 3.500.000 dan sewa jalan Rani meningkat dari Rp. 100.000.000 menjadi Rp. 200.000.000 per tahun.
- Aldo (Perusahaan) menyampaikan PPM Plus mencakup jalan tani, PBM, TKBM sesuai kesepakatan sebelumnya, namun kompensasi yang disanggupi hanya Rp. 1.050.000.000.
- Ir. Rizal Baduddin menyatakan seluruh PPM Plus akan direalisasikan dalam bentuk program, PBM dan TKBM dibahas terpisah.
- Kesimpulan rapat: PT. Bima Cakra Mineralindo menyetujui anggaran Program PPM dan penyelesaian jalan tani sebesar Rp. 1.050.000.000, dengan rincian Rp. 1.000.000.000 untuk PPM dan jalan tani, dan Rp. 50.000.000 untuk PBM/TKBM, direalisasikan dalam bentuk program. Penyelesaian lahan sewa pakai dibahas terpisah antara perusahaan dan pemilik lahan.",
    'penanggung_jawab' => 'Bakesbangpol Kab. Morowali',
],
// [
//     'nama_potensi' => 'Firli Soroti Tambang Ilegal di Parimo, Desak Gubernur Segera Bentuk Satgas Tambang dan Lingkungan',
//     'tanggal_potensi' => '2025-05-26',
//     'desa_id' => $getDesaId('-', '-', 'Parigi Moutong', 'Sulawesi Tengah'),
//     'latar_belakang' => "Pada hari Senin tanggal 26 Mei 2025, Ketua Tim Milenial Berani Parigi Moutong, Firli, menanggapi wacana pembentukan Satuan Tugas (Satgas) Tambang, Lingkungan Hidup, dan Kehutanan oleh Gubernur Sulawesi Tengah.

// Firli menekankan pentingnya satgas untuk mengawasi aktivitas pertambangan legal maupun ilegal di wilayah Sulawesi Tengah. Ia mengungkapkan bahwa Parigi Moutong memiliki banyak titik pertambangan emas, termasuk di Kecamatan Moutong, Taopa, Lambunu, Ongka Malino, Tinombo Selatan, Kasimbar, Ampibabo, hingga Parigi, dengan banyak aktivitas diduga ilegal (PETI).

// Aktivitas ilegal ini merugikan negara, melanggar Pasal 158/161 UU No. 3 Tahun 2020, berdampak pada lingkungan dan masyarakat, misalnya pencemaran air sungai Hulu Sungai Taopa dan peningkatan risiko banjir. Firli juga menyoroti lemahnya pengawasan pemerintah kabupaten dan dugaan pembiaran aparat penegak hukum.

// Masyarakat telah melakukan protes, namun belum ada langkah tegas. Firli mendorong agar pembentukan Satgas Tambang dan Lingkungan segera dijalankan secara tegas dan transparan. Satgas diharapkan menindak pelaku ilegal mining, memberi edukasi tentang legalitas tambang melalui Izin Pertambangan Rakyat (IPR), dan menjaga keseimbangan antara kesejahteraan masyarakat dan keberlanjutan lingkungan di Parigi Moutong.",
//     'penanggung_jawab' => 'Bakesbangpol Kab. Parimo',
// ],
[
    'nama_potensi' => 'Demo Tolak Peti, Massa Aksi Desak Polisi Tangkap Oknum Kades, Aparat hingga Pemodal',
    'tanggal_potensi' => '2025-05-28',
    'desa_id' => $getDesaId('Tada', 'Tinombo Selatan', 'Parigi Moutong', 'Sulawesi Tengah'),
    'latar_belakang' => "Pada hari Rabu tanggal 28 Mei 2025, masyarakat Kecamatan Tinombo Selatan yang tergabung dalam Persatuan Rakyat Tani (PRT) menggelar aksi demonstrasi sambil berkonvoi menggunakan kendaraan roda dua. Massa aksi, sebagian besar petani, berkumpul di jembatan jalan trans Desa Tada sambil terus berorasi.

Mereka menuntut aparat kepolisian menghentikan aktivitas pertambangan emas tanpa izin (Peti) di Kecamatan Tinombo Selatan. Najib S. Masalihu meminta Polda Sulawesi Tengah dan Polres Parigi Moutong menangkap dan memproses pelaku Peti, termasuk oknum kepala desa, aparat, dan pemodal dari luar daerah. Aktivitas Peti di desa Tada, Oncone Raya, Tada Selatan, dan Silutung dianggap merusak ribuan hektar sawah dan mengancam panen warga.

Romansyah, Koordinator aksi, menyoroti bahwa tuntutan penutupan Peti telah disampaikan sejak 2012, namun aktivitas ilegal masih berlangsung. Pelaku tambang ilegal diancam pidana 5 tahun dan denda Rp 100 miliar sesuai UU Minerba No. 3 Tahun 2020. Massa aksi menekankan bahwa Peti telah menyebabkan gagal panen dan kerugian bagi warga, dan mereka akan mengawal tuntutan hingga ke Polda Sulawesi Tengah.",
    'penanggung_jawab' => 'Bakesbangpol Kab. Parimo',
],
[
    'nama_potensi' => 'Gubernur Sulawesi Tengah Tutup Permanen Dua Tambang di Palu Setelah Perjuangan Masyarakat',
    'tanggal_potensi' => '2025-06-11',
    'desa_id' => $getDesaId('Tipo', 'Ulujadi', 'Kota Palu', 'Sulawesi Tengah'),
    'latar_belakang' => "Gubernur Sulteng Anwar Hafid menutup permanen aktivitas dua tambang di Kelurahan Tipo, Kecamatan Ulujadi, Kota Palu, yang dikelola PT Bumi Alpamandiri dan PT Tambang Watu Kalora. Keputusan ini diumumkan di tengah aksi damai warga yang telah memperjuangkan penutupan tambang selama delapan bulan untuk melindungi lingkungan dan ruang hidup mereka.

Pengumuman penutupan dihadiri Ketua DPRD Sulteng Arus Abdul Karim, Bupati Sigi Moh. Rizal Intjenae, Sekretaris Kota Palu Irmayanti, dan sejumlah pejabat lainnya. Keputusan ini bukan untuk mencari popularitas, tetapi demi tanggung jawab gubernur terhadap daerah dan masyarakat.

Gubernur juga mengumumkan moratorium perizinan tambang di atas wilayah permukiman selama masa jabatannya. Keputusan penghentian permanen ini merupakan hasil proses panjang dan koordinasi lintas pihak, termasuk Wali Kota Palu dan Bupati Sigi. Faizal, Ketua Aliansi Pemuda dan Lingkungan Tipo, menyatakan aksi ini tidak hanya menolak tambang tetapi juga untuk menyelamatkan kawasan Gunung Kinovaro dan pegunungan sekitar sebagai paru-paru wilayah Palu dan Sigi.",
    'penanggung_jawab' => 'Bakesbangpol Prov. Sul-Teng',
],
[
    'nama_potensi' => 'DPRD Sulteng Dorong Pemda Evaluasi IUP Batuan dan Pasir',
    'tanggal_potensi' => '2025-06-12',
    'desa_id' => $getDesaId('Tipo', 'Ulujadi', 'Kota Palu', 'Sulawesi Tengah'),
    'latar_belakang' => "DPRD Provinsi Sulawesi Tengah (Sulteng) mendorong pemerintah daerah untuk mengevaluasi Izin Usaha Pertambangan (IUP) batuan dan pasir. Banyak pertambangan berizin yang belum sesuai dengan kaidah pertambangan yang diamanatkan oleh aturan perundang-undangan.

Anggota DPRD Abdul Rahman menjelaskan bahwa DPRD memiliki fungsi pengawasan, mendengar aduan masyarakat, dan mendorong pemda mengkaji serta mengevaluasi perizinan yang tidak sesuai ketentuan. Jika terdapat potensi kesalahan dalam pengelolaan lingkungan, pemerintah harus menertibkan.

DPRD mendukung langkah Gubernur Sulteng Anwar Hafid yang menutup permanen dua tambang di Kota Palu dan Kabupaten Sigi, yaitu PT Bumi Alpamandiri dan PT Tambang Watu Kalora, setelah sebelumnya hanya diberlakukan penghentian sementara. Penutupan ini dilakukan demi kepatuhan terhadap peraturan dan perlindungan masyarakat lingkar tambang.",
    'penanggung_jawab' => 'Bakesbangpol Prov. Sul-Teng',
],
[
    'nama_potensi' => 'Koorlap Aksi Unjuk Rasa di Tipo Apresiasi Gubernur Sulteng Cabut Izin Tambang Secara Permanen',
    'tanggal_potensi' => '2025-06-10',
    'desa_id' => $getDesaId('Tipo', 'Ulujadi', 'Kota Palu', 'Sulawesi Tengah'),
    'latar_belakang' => "Koordinator aksi damai masyarakat Kelurahan Tipo, Faisal, menyampaikan apresiasi atas keputusan Gubernur Sulawesi Tengah, Anwar Hafid, yang mencabut secara permanen izin usaha pertambangan dua perusahaan galian C di wilayah mereka.

Keputusan ini merupakan hasil perjuangan panjang masyarakat selama delapan bulan menempuh jalur aspirasi dari tingkat kelurahan hingga pemerintah provinsi. Aksi damai ini menyoroti dampak negatif tambang terhadap lingkungan dan kesehatan masyarakat, termasuk banjir di Kelurahan Silae dan tingginya kasus ISPA (sekitar 2.800 warga terdampak, 800 kasus di Tipo pada 2024–2025).

Faisal menegaskan seluruh lembaga di Kelurahan Tipo, termasuk Forum Pemuda dan Aliansi Pemerhati Lingkungan, bersatu menolak tambang, menjaga ruang hidup, kawasan hutan, dan pegunungan. Perjuangan ini juga menekankan pentingnya menyatukan kekuatan adat dan komunitas lokal untuk melindungi Gunung Kinovaro sebagai paru-paru Kota Palu dan Kabupaten Sigi.",
    'penanggung_jawab' => 'Bakesbangpol Prov. Sul-Teng',
],
[
    'nama_potensi' => 'Tewaskan 2 Penambang, Jatam Desak APH Bertindak Atas Longsor di Tambang Ilegal Poboya Palu',
    'tanggal_potensi' => '2025-06-05',
    'desa_id' => $getDesaId('Poboya', 'Mantikulore', 'Kota Palu', 'Sulawesi Tengah'),
    'latar_belakang' => "Dua penambang emas tewas akibat tertimbun longsor di lokasi Penambang Emas Tanpa Izin (PETI) di Kelurahan Poboya, Kecamatan Mantikulore, Kota Palu, tepatnya di titik tambang ilegal Kijang 30 pada 3 Juni 2025.

Jaringan Advokasi Tambang (Jatam) Sulteng menduga longsor dipicu oleh aktivitas alat berat ilegal. Sebelumnya, penambang tradisional sudah mengeluhkan potensi longsor akibat alat berat. Kejadian ini menunjukkan lemahnya penegakan hukum oleh aparat, terutama Polda Sulteng dan Polres Palu, terhadap pelaku PETI.

Jatam mendesak pencopotan Kapolda Sulteng dan Kapolres Palu, serta evaluasi menyeluruh terhadap PT CPM selaku pemegang Kontrak Karya di Poboya. Jatam menyoroti kegagalan PT CPM menjaga wilayah konsesinya dari aktivitas ilegal, termasuk praktik perendaman emas yang tidak terkendali, dan menuntut transparansi terkait hubungan PETI dengan perusahaan.",
    'penanggung_jawab' => 'Bakesbangpol Prov. Sul-Teng',
],
[
    'nama_potensi' => 'Warga Morowali: Satu Kampung Terkena Gangguan Pernapasan Imbas PLTU Captive',
    'tanggal_potensi' => '2025-05-22',
    'desa_id' => $getDesaId('Ambunu', '', 'Morowali', 'Sulawesi Tengah'),
    'latar_belakang' => "Warga Desa Ambunu, Morowali, terjangkit Infeksi Saluran Pernapasan Akut (ISPA) akibat operasional Pembangkit Listrik Tenaga Uap (PLTU) captive yang mendukung smelter nikel dan batu bara, bukan untuk publik. Hampir seluruh warga mengalami gejala sesak napas dan polusi debu terus masuk ke rumah meskipun ventilasi ditutup.

Selain ISPA, warga juga mengalami penyakit kulit dan gangguan kesehatan lain akibat polusi dari PLTU, kendaraan pertambangan, dan pengolahan batu bara yang berbatasan langsung dengan permukiman tanpa sekat yang memadai. Sumber air warga juga diduga tercemar limbah. Kejadian ini menimbulkan kekhawatiran serius terhadap kesehatan masyarakat di Desa Ambunu.",
    'penanggung_jawab' => 'Bakesbangpol Prov. Sul-Teng',
],

];

$rows = array_map(function ($item) {
    $item['created_at'] = now();
    // $item['updated_at'] = now();
    return array_map(function ($value) {
        return is_string($value) ? trim($value) : $value;
    }, $item);
}, $rows);

$this->command->info("Jumlah Data : ". count($rows) );
DB::table('potensi_konflik')->insert($rows);

        // DB::table('potensi_konflik')->insert($rows[0]);
        // dd(DB::getQueryLog());
        // DB::table('potensi_konflik')->insert([
        //     'nama_potensi' => 'Test',
        //     'tanggal_potensi' => now(),
        //     'desa_id' => "72.01.01.1006",
        //     'latar_belakang' => 'Test',
        //     'penanggung_jawab' => 'Test',
        // ]);

    }
}
