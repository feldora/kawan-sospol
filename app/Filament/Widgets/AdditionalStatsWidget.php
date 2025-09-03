<?php

namespace App\Filament\Widgets;

use App\Models\LaporanKonflik;
use App\Models\PotensiKonflik;
use Filament\Widgets\StatsOverviewWidget as BaseStatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Facades\DB;

class AdditionalStatsWidget extends BaseStatsOverviewWidget
{
    protected static ?int $sort = 9;
    protected int | string | array $columnSpan = 'full';

    protected function getStats(): array
    {
        // $avgResolutionTime = LaporanKonflik::where('status', 'selesai')
        //     ->selectRaw('AVG(DATEDIFF(updated_at, created_at)) as avg_days')
        //     ->value('avg_days');
        $avgResolutionTime = LaporanKonflik::where('status', 'selesai')
            ->selectRaw('AVG(EXTRACT(EPOCH FROM (updated_at - created_at)) / 86400) as avg_days')
            ->value('avg_days');

        $activePenanggungJawab = PotensiKonflik::whereNotNull('penanggung_jawab')
            ->groupBy('penanggung_jawab')
            ->selectRaw('penanggung_jawab, COUNT(*) as count')
            ->orderByDesc('count')
            ->first();

        $laporanDenganKoordinat = LaporanKonflik::whereNotNull('lat')
            ->whereNotNull('lng')
            ->count();

        $totalLaporan = LaporanKonflik::count();
        $persentaseKoordinat = $totalLaporan > 0 ?
            round(($laporanDenganKoordinat / $totalLaporan) * 100, 1) : 0;

        $potensiDenganLaporan = PotensiKonflik::whereHas('laporanKonflik')->count();
        $totalPotensi = PotensiKonflik::count();
        $konversiRate = $totalPotensi > 0 ?
            round(($potensiDenganLaporan / $totalPotensi) * 100, 1) : 0;

        return [
            Stat::make('Rata-rata Waktu Penyelesaian',
                $avgResolutionTime ? round($avgResolutionTime, 1) . ' hari' : 'Belum ada data')
                ->description('Waktu dari laporan hingga selesai')
                ->descriptionIcon('heroicon-m-clock')
                ->color('info'),

            Stat::make('Penanggung Jawab Aktif',
                $activePenanggungJawab ? $activePenanggungJawab->penanggung_jawab : 'Belum ada')
                ->description($activePenanggungJawab ?
                    $activePenanggungJawab->count . ' kasus ditangani' : 'Tidak ada data')
                ->descriptionIcon('heroicon-m-user')
                ->color('success'),

            Stat::make('Kelengkapan Koordinat', $persentaseKoordinat . '%')
                ->description($laporanDenganKoordinat . ' dari ' . $totalLaporan . ' laporan memiliki koordinat')
                ->descriptionIcon('heroicon-m-map-pin')
                ->color($persentaseKoordinat >= 70 ? 'success' : 'warning'),

            Stat::make('Tingkat Konversi Potensi', $konversiRate . '%')
                ->description($potensiDenganLaporan . ' dari ' . $totalPotensi . ' potensi menjadi laporan')
                ->descriptionIcon('heroicon-m-arrow-right')
                ->color($konversiRate >= 30 ? 'danger' : 'success'),
        ];
    }
}
