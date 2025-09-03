<?php

namespace App\Filament\Widgets;

use App\Models\LaporanKonflik;
use App\Models\PotensiKonflik;
use App\Models\JenisKonflik;
use Filament\Widgets\StatsOverviewWidget as BaseStatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverviewWidget extends BaseStatsOverviewWidget
{
    protected static ?int $sort = 1;

    protected function getStats(): array
    {
        $totalLaporan = LaporanKonflik::count();
        $totalPotensi = PotensiKonflik::count();
        $laporanBaru = LaporanKonflik::where('status', 'baru')->count();
        $laporanSelesai = LaporanKonflik::where('status', 'selesai')->count();

        $persentaseSelesai = $totalLaporan > 0 ? round(($laporanSelesai / $totalLaporan) * 100, 1) : 0;

        // Perbandingan bulan ini vs bulan lalu
        $thisMonth = LaporanKonflik::whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->count();

        $lastMonth = LaporanKonflik::whereMonth('created_at', now()->subMonth()->month)
            ->whereYear('created_at', now()->subMonth()->year)
            ->count();

        $monthlyGrowth = $lastMonth > 0 ? round((($thisMonth - $lastMonth) / $lastMonth) * 100, 1) : 0;

        return [
            Stat::make('Total Laporan Konflik', $totalLaporan)
                ->description($monthlyGrowth >= 0 ? "↗ {$monthlyGrowth}% dari bulan lalu" : "↘ " . abs($monthlyGrowth) . "% dari bulan lalu")
                ->descriptionIcon($monthlyGrowth >= 0 ? 'heroicon-m-arrow-trending-up' : 'heroicon-m-arrow-trending-down')
                ->color($monthlyGrowth >= 0 ? 'danger' : 'success'),

            Stat::make('Total Potensi Konflik', $totalPotensi)
                ->description('Potensi konflik teridentifikasi')
                ->descriptionIcon('heroicon-m-exclamation-triangle')
                ->color('warning'),

            Stat::make('Laporan Baru', $laporanBaru)
                ->description('Memerlukan tindak lanjut')
                ->descriptionIcon('heroicon-m-bell-alert')
                ->color('danger'),

            Stat::make('Tingkat Penyelesaian', $persentaseSelesai . '%')
                ->description($laporanSelesai . ' dari ' . $totalLaporan . ' laporan selesai')
                ->descriptionIcon('heroicon-m-check-circle')
                ->color('success'),
        ];
    }
}
