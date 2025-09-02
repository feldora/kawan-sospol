<?php

namespace App\Filament\Resources\PotensiKonfliks\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;

class PotensiKonflikForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(6) // Set schema ke 3 kolom
            ->components([
                TextInput::make('nama_potensi')
                    ->required()
                    ->columnSpan(6), // Menggunakan 3 kolom (full width)

                DatePicker::make('tanggal_potensi')
                    ->columnSpan(3), // Menggunakan 3 kolom (full width)

                TextInput::make('penanggung_jawab')
                    ->columnSpan(3), // Menggunakan 3 kolom (full width)

                Select::make('kabupaten_id')
                    ->label('Kabupaten')
                    ->options(\App\Models\Kabupaten::all()->pluck('nama', 'id'))
                    ->reactive() // membuat field ini "reactive" untuk dependent dropdown
                    ->required()
                    ->columnSpan(2) // Menggunakan 1 kolom dari 3
                    ->afterStateUpdated(fn ($state, callable $set) => $set('kecamatan_id', null)),

                Select::make('kecamatan_id')
                    ->label('Kecamatan')
                    ->options(function (callable $get) {
                        $kabupatenId = $get('kabupaten_id');
                        if (!$kabupatenId) return [];
                        return \App\Models\Kecamatan::where('kabupaten_id', $kabupatenId)
                            ->pluck('nama', 'id');
                    })
                    ->reactive()
                    ->required()
                    ->columnSpan(2) // Menggunakan 1 kolom dari 3
                    ->afterStateUpdated(fn ($state, callable $set) => $set('desa_id', null)),

                Select::make('desa_id')
                    ->label('Desa')
                    ->options(function (callable $get) {
                        $kecamatanId = $get('kecamatan_id');
                        if (!$kecamatanId) return [];
                        return \App\Models\Desa::where('kecamatan_id', $kecamatanId)
                            ->plunk('nama', 'id');
                    })
                    ->required()
                    ->columnSpan(2), // Menggunakan 1 kolom dari 3

                RichEditor::make('latar_belakang')
                    ->label('Latar Belakang')
                    ->nullable()
                    ->toolbarButtons([
                        'bold', 'italic', 'underline', 'link',
                        'bulletList', 'orderedList', 'codeBlock'
                    ])
                    ->required()
                    ->columnSpan(6) // Menggunakan 3 kolom (full width)
                    ->extraAttributes([
                        'style' => 'min-height: 200px;'
                    ]),
            ]);
    }
}
