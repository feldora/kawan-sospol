<?php

namespace App\Filament\Widgets;

use App\Models\LaporanKonflik;
use Filament\Widgets\Widget;

class MapWidget extends Widget
{
    protected ?string $heading = 'MapWidget';
    protected string $view = 'filament.widgets.map-widget';
    protected static ?int $sort = 8;
    protected int | string | array $columnSpan = 'full';

    protected function getViewData(): array
    {
        $konflikData = LaporanKonflik::with(['desa.kecamatan.kabupaten'])
            ->whereNotNull('lat')
            ->whereNotNull('lng')
            ->get()
            ->map(function ($konflik) {
                return [
                    'id' => $konflik->id,
                    'lat' => (float) $konflik->lat,
                    'lng' => (float) $konflik->lng,
                    'pelapor' => $konflik->nama_pelapor ?: 'Anonim',
                    'desa' => $konflik->desa->nama ?? 'Tidak diketahui',
                    'kecamatan' => $konflik->desa->kecamatan->nama ?? 'Tidak diketahui',
                    'kabupaten' => $konflik->desa->kecamatan->kabupaten->nama ?? 'Tidak diketahui',
                    'status' => $konflik->status,
                    'deskripsi' => $konflik->deskripsi ?
                        (strlen($konflik->deskripsi) > 100 ?
                            substr($konflik->deskripsi, 0, 100) . '...' :
                            $konflik->deskripsi) :
                        'Tidak ada deskripsi',
                    'tanggal' => $konflik->created_at->format('d M Y H:i'),
                    'kontak' => $konflik->kontak,
                ];
            });

        $totalWithCoordinates = $konflikData->count();
        $statusCounts = LaporanKonflik::whereNotNull('lat')
            ->whereNotNull('lng')
            ->selectRaw('status, COUNT(*) as count')
            ->groupBy('status')
            ->pluck('count', 'status')
            ->toArray();

        return [
            'konflikData' => $konflikData,
            'totalWithCoordinates' => $totalWithCoordinates,
            'statusCounts' => $statusCounts,
        ];
    }
}
