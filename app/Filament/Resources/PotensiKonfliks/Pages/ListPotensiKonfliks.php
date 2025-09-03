<?php

namespace App\Filament\Resources\PotensiKonfliks\Pages;

use App\Filament\Resources\PotensiKonfliks\PotensiKonflikResource;
use Filament\Actions\CreateAction;
use Filament\Actions\Action;
use Filament\Resources\Pages\ListRecords;
use App\Models\PotensiKonflik;
use Filament\Notifications\Notification;

class ListPotensiKonfliks extends ListRecords
{
    protected static string $resource = PotensiKonflikResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // Action::make('export')
            //     ->label('Export Data')
            //     ->icon('heroicon-o-document-arrow-down')
            //     ->color('success')
            //     ->action(function () {
            //         // Logic export (bisa ke CSV/Excel/PDF)
            //         Notification::make()
            //             ->title('Export berhasil')
            //             ->body('Data potensi konflik telah diekspor.')
            //             ->success()
            //             ->send();
            //     }),

            // Action::make('import')
            //     ->label('Import Data')
            //     ->icon('heroicon-o-document-arrow-up')
            //     ->color('info')
            //     ->action(function () {
            //         // Logic import
            //         Notification::make()
            //             ->title('Import berhasil')
            //             ->body('Data berhasil diimpor ke sistem.')
            //             ->success()
            //             ->send();
            //     }),

            CreateAction::make()
                ->label('Tambah Potensi Konflik')
                ->icon('heroicon-o-plus')
                ->color('primary'),
        ];
    }

    public function getTitle(): string
    {
        return 'Data Potensi Konflik';
    }

    public function getSubheading(): ?string
    {
        $total = PotensiKonflik::count();
        $bulanIni = PotensiKonflik::whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->count();

        return "Total {$total} data potensi konflik, {$bulanIni} data ditambahkan bulan ini.";
    }

    protected function getHeaderWidgets(): array
    {
        return [
            // Uncomment jika widget sudah dibuat
            // PotensiKonflikResource\Widgets\PotensiKonflikOverview::class,
        ];
    }
}
