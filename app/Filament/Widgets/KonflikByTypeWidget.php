<?php

namespace App\Filament\Widgets;

use App\Models\PotensiKonflik;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\DB;

class KonflikByTypeWidget extends ChartWidget
{

    protected  ?string $heading = 'Distribusi Berdasarkan Jenis Konflik';
    protected static ?int $sort = 3;

    protected function getData(): array
    {
        $data = DB::table('potensi_konflik')
            ->join('jenis_konflik', 'potensi_konflik.jenis_konflik_id', '=', 'jenis_konflik.id')
            ->select('jenis_konflik.nama', DB::raw('COUNT(*) as total'))
            ->groupBy('jenis_konflik.nama')
            ->get();

        return [
            'datasets' => [
                [
                    'label' => 'Jumlah Konflik',
                    'data' => $data->pluck('total')->toArray(),
                    'backgroundColor' => [
                        '#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0', '#9966FF',
                        '#FF9F40', '#FF6384', '#C9CBCF', '#4BC0C0', '#FF6384'
                    ],
                ],
            ],
            'labels' => $data->pluck('nama')->toArray(),
        ];
    }

    protected function getType(): string
    {
        return 'pie';
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
