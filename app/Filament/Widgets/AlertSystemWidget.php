<?php

namespace App\Filament\Widgets;

use App\Models\LaporanKonflik;
use App\Models\PotensiKonflik;
use Filament\Widgets\Widget;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class AlertSystemWidget extends Widget
{
    protected string $view = 'filament.widgets.alert-system-widget';
    protected static ?int $sort = 7;
    protected int | string | array $columnSpan = 'full';

    protected function getViewData(): array
    {
        $laporanBaru = LaporanKonflik::where('status', 'baru')
            ->where('created_at', '<', Carbon::now()->subDays(3))
            ->count();

        $potensiMendekatTanggal = PotensiKonflik::whereNotNull('tanggal_potensi')
            ->whereBetween('tanggal_potensi', [
                Carbon::now(),
                Carbon::now()->addDays(7)
            ])
            ->count();

        $wilayahKonflikTinggi = DB::table('laporan_konflik')
            ->join('desa', 'laporan_konflik.desa_id', '=', 'desa.id')
            ->join('kecamatan', 'desa.kecamatan_id', '=', 'kecamatan.id')
            ->select('kecamatan.nama', DB::raw('COUNT(*) as total'))
            ->groupBy('kecamatan.nama', 'kecamatan.id')
            ->havingRaw('COUNT(*) >= 5')
            ->count();

        $potensiTanpaLaporan = PotensiKonflik::whereDoesntHave('laporanKonflik')->count();

        $laporanDiteruskan = LaporanKonflik::whereNotNull('diteruskan_ke')
            ->where('status', '!=', 'selesai')
            ->where('updated_at', '<', Carbon::now()->subDays(7))
            ->count();

        return [
            'laporanBaru' => $laporanBaru,
            'potensiMendekatTanggal' => $potensiMendekatTanggal,
            'wilayahKonflikTinggi' => $wilayahKonflikTinggi,
            'potensiTanpaLaporan' => $potensiTanpaLaporan,
            'laporanDiteruskan' => $laporanDiteruskan,
        ];
    }
}
