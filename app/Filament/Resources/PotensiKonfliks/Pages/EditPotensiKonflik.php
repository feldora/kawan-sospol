<?php

namespace App\Filament\Resources\PotensiKonfliks\Pages;

use App\Filament\Resources\PotensiKonfliks\PotensiKonflikResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditPotensiKonflik extends EditRecord
{
    protected static string $resource = PotensiKonflikResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
