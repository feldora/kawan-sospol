<?php

namespace App\Filament\Widgets;

use App\Models\LaporanKonflik;
use App\Models\PotensiKonflik;
use Filament\Widgets\ChartWidget;
use Carbon\Carbon;

class MonthlyTrendWidget extends ChartWidget
{
    protected ?string $heading = 'Tren Laporan Konflik (12 Bulan Terakhir)';
    protected static ?int $sort = 5;
    protected int | string | array $columnSpan = 'full';

    protected function getData(): array
    {
        $months = [];
        $laporanData = [];
        $potensiData = [];

        for ($i = 11; $i >= 0; $i--) {
            $date = Carbon::now()->subMonths($i);
            $months[] = $date->format('M Y');

            $laporanCount = LaporanKonflik::whereYear('created_at', $date->year)
                ->whereMonth('created_at', $date->month)
                ->count();
            $laporanData[] = $laporanCount;

            $potensiCount = PotensiKonflik::whereYear('created_at', $date->year)
                ->whereMonth('created_at', $date->month)
                ->count();
            $potensiData[] = $potensiCount;
        }

        return [
            'datasets' => [
                [
                    'label' => 'Laporan Konflik',
                    'data' => $laporanData,
                    'borderColor' => '#FF6384',
                    'backgroundColor' => 'rgba(255, 99, 132, 0.1)',
                    'fill' => false,
                ],
                [
                    'label' => 'Potensi Konflik',
                    'data' => $potensiData,
                    'borderColor' => '#36A2EB',
                    'backgroundColor' => 'rgba(54, 162, 235, 0.1)',
                    'fill' => false,
                ],
            ],
            'labels' => $months,
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }

    protected function getOptions(): array
    {
        return [
            'responsive' => true,
            'maintainAspectRatio' => false,
            'scales' => [
                'y' => [
                    'beginAtZero' => true,
                ],
            ],
            'plugins' => [
                'legend' => [
                    'display' => true,
                    'position' => 'top',
                ],
            ],
        ];
    }
}
