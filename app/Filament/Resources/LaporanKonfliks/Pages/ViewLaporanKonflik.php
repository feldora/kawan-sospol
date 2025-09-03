<?php

namespace App\Filament\Resources\LaporanKonfliks\Pages;

use App\Filament\Resources\LaporanKonfliks\LaporanKonflikResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewLaporanKonflik extends ViewRecord
{
    protected static string $resource = LaporanKonflikResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
