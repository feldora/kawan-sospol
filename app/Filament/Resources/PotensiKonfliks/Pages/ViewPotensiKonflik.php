<?php

namespace App\Filament\Resources\PotensiKonfliks\Pages;

use App\Filament\Resources\PotensiKonfliks\PotensiKonflikResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewPotensiKonflik extends ViewRecord
{
    protected static string $resource = PotensiKonflikResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
