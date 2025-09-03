<?php

namespace App\Filament\Resources\PotensiKonfliks\Pages;

use App\Filament\Resources\PotensiKonfliks\PotensiKonflikResource;
use Filament\Resources\Pages\ViewRecord;
use Filament\Actions;
use Barryvdh\DomPDF\Facade\Pdf;

class ViewPotensiKonflik extends ViewRecord
{
    protected static string $resource = PotensiKonflikResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
            // Actions\Action::make('duplicate')
            //     ->label('Duplikat')
            //     ->icon('heroicon-o-document-duplicate')
            //     ->color('info')
            //     ->action(function ($record) {
            //         $newRecord = $record->replicate();
            //         $newRecord->nama_potensi = $record->nama_potensi . ' (Copy)';
            //         $newRecord->save();
            //     })
            //     ->requiresConfirmation(),

            Actions\Action::make('export_pdf')
                ->label('Export PDF')
                ->icon('heroicon-o-arrow-down-tray')
                ->color('success')
                ->action(function ($record) {
                    $pdf = Pdf::loadView('pdf.potensi-konflik', ['record' => $record]);
                    return response()->streamDownload(
                        fn () => print($pdf->output()),
                        'potensi-konflik-' . $record->id . '.pdf'
                    );
                }),
        ];
    }
}
