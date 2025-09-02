<?php

namespace App\Filament\Resources\PotensiKonfliks\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class PotensiKonflikInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('nama_potensi'),
                TextEntry::make('tanggal_potensi')
                    ->date(),
                TextEntry::make('desa_id'),
                TextEntry::make('penanggung_jawab'),
                TextEntry::make('created_at')
                    ->dateTime(),
                TextEntry::make('updated_at')
                    ->dateTime(),
            ]);
    }
}
