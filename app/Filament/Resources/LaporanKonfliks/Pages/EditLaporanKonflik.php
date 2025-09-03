<?php

namespace App\Filament\Resources\LaporanKonfliks\Pages;

use App\Filament\Resources\LaporanKonfliks\LaporanKonflikResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditLaporanKonflik extends EditRecord
{
    protected static string $resource = LaporanKonflikResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
