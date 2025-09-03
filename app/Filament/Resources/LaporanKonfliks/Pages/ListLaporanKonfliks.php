<?php

namespace App\Filament\Resources\LaporanKonfliks\Pages;

use App\Filament\Resources\LaporanKonfliks\LaporanKonflikResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListLaporanKonfliks extends ListRecords
{
    protected static string $resource = LaporanKonflikResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
