<?php

namespace App\Filament\Widgets;

use Filament\Widgets\ChartWidget;
use App\Models\LaporanKonflik;
use Illuminate\Support\Facades\DB;

class KonflikByLocationWidget extends ChartWidget
{
    protected ?string $heading = 'Konflik By Location Widget';

    protected function getData(): array
    {
        $data = DB::table('laporan_konflik')
            ->join('desa', 'laporan_konflik.desa_id', '=', 'desa.id')
            ->join('kecamatan', 'desa.kecamatan_id', '=', 'kecamatan.id')
            ->join('kabupaten', 'kecamatan.kabupaten_id', '=', 'kabupaten.id')
            ->select('kabupaten.nama', DB::raw('COUNT(*) as total'))
            ->groupBy('kabupaten.nama')
            ->orderBy('total', 'desc')
            ->limit(10)
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
