<?php

namespace App\Filament\Widgets;

use App\Models\LaporanKonflik;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\DB;

class StatusProgressWidget extends ChartWidget
{
    protected ?string $heading = 'Progress Status Laporan';
    protected static ?int $sort = 4;

    protected function getData(): array
    {
        $statusData = LaporanKonflik::select('status', DB::raw('COUNT(*) as count'))
            ->groupBy('status')
            ->get();

        $statusLabels = [
            'baru' => 'Baru',
            'ditindaklanjuti' => 'Ditindaklanjuti',
            'selesai' => 'Selesai'
        ];

        $labels = [];
        $data = [];
        $colors = [
            'baru' => '#FF6384',
            'ditindaklanjuti' => '#FFCE56',
            'selesai' => '#36A2EB'
        ];

        $backgroundColors = [];
        foreach ($statusData as $status) {
            $labels[] = $statusLabels[$status->status] ?? $status->status;
            $data[] = $status->count;
            $backgroundColors[] = $colors[$status->status] ?? '#CCCCCC';
        }

        return [
            'datasets' => [
                [
                    'data' => $data,
                    'backgroundColor' => $backgroundColors,
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getType(): string
    {
        return 'doughnut';
    }

    protected function getOptions(): array
    {
        return [
            'responsive' => true,
            'maintainAspectRatio' => false,
            'plugins' => [
                'legend' => [
                    'display' => true,
                    'position' => 'bottom',
                ],
            ],
        ];
    }
}
