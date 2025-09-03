<?php

namespace App\Filament\Resources\LaporanKonfliks\Schemas;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Schemas\Schema;
// use Filament\Forms\Components;
use Filament\Schemas\Components;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;

class LaporanKonflikForm
{
    public static function schema(Schema $schema): Schema
    {
        return $schema->schema([
            Components\Section::make('Data Pelapor')->schema([
                TextInput::make('nama_pelapor')->required()->maxLength(255),
                TextInput::make('kontak')->tel()->maxLength(50),
            ])->columns(2)->columnSpanFull(),

            Components\Section::make('Detail Laporan')->schema([
                Textarea::make('lokasi_text')->required()->columnSpanFull(),
                RichEditor::make('deskripsi')->required()->columnSpanFull()
                        ->extraAttributes(['style' => 'min-height: 200px;']),
                Select::make('status')
                    ->options([
                        'baru' => 'Baru',
                        'diproses' => 'Diproses',
                        'selesai' => 'Selesai',
                    ])
                    ->default('baru')
                    ->required(),
                Select::make('potensi_konflik_id')
                    ->label('Terkait Potensi Konflik')
                    ->relationship('potensiKonflik', 'nama_potensi')
                    ->searchable()
                    ->preload(),
            ])->columns(2)->columnSpanFull(),
        ]);
    }
}
