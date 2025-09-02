<?php

namespace App\Filament\Resources\PotensiKonfliks\Pages;

use App\Filament\Resources\PotensiKonfliks\PotensiKonflikResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListPotensiKonfliks extends ListRecords
{
    protected static string $resource = PotensiKonflikResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
