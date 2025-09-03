<?php

namespace App\Filament\Resources\LaporanKonfliks\Schemas;

use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Infolist;
use Filament\Schemas\Schema;
// use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components;

class LaporanKonflikInfolist
{
    public static function schema(Schema $schema): Schema
    {
        return $schema->schema([
            Components\Section::make('Data Pelapor')->schema([
                TextEntry::make('nama_pelapor'),
                TextEntry::make('kontak'),
            ])->columns(2)->columnSpanFull(),

            Components\Section::make('Detail Laporan')->schema([
                TextEntry::make('lokasi_text'),
                TextEntry::make('deskripsi')->html()->columnSpanFull(),
                TextEntry::make('status')->badge(),
                TextEntry::make('potensiKonflik.nama_potensi'),
            ])->columns(2)->columnSpanFull(),

            Components\Section::make('Meta')->schema([
                TextEntry::make('created_at')->dateTime('d M Y H:i'),
                TextEntry::make('updated_at')->dateTime('d M Y H:i'),
            ])->columns(2)->columnSpanFull(),
        ]);
    }
}
