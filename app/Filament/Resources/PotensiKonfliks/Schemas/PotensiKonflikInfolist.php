<?php

namespace App\Filament\Resources\PotensiKonfliks\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class PotensiKonflikInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(6)
            ->components([
                TextEntry::make('tanggal_potensi')
                    ->date()
                    ->columnSpan(6),
                TextEntry::make('nama_potensi')
                    ->columnSpan(6),
                TextEntry::make('desa_id')
                    ->columnSpan(6),
                TextEntry::make('penanggung_jawab')
                    ->columnSpan(6),

                TextEntry::make('latar_belakang')
                    ->label('Latar Belakang')
                    ->columnSpan(6)
                    ->html(),
                // TextEntry::make('created_at')
                //     ->dateTime()
                //     ->columnSpan(6),
                // TextEntry::make('updated_at')
                //     ->dateTime()
                //     ->columnSpan(6),

            ]);
    }
}
