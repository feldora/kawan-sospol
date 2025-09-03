<?php

namespace App\Filament\Resources\PotensiKonfliks\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Placeholder;
use Filament\Schemas\Components\Section;
use App\Models\JenisKonflik;

class PotensiKonflikForm
{
    public static function getFormSchema(): array
    {
        return [
            Section::make('Form Potensi Konflik')
                ->description('Isi semua informasi terkait potensi konflik')
                ->icon('heroicon-o-information-circle')
                ->columns(6) // semua layout pakai 6 kolom
                ->columnSpanFull()
                ->schema([
                    TextInput::make('nama_potensi')
                        ->label('Nama Potensi Konflik')
                        ->required()
                        ->maxLength(255)
                        ->placeholder('Masukkan nama potensi konflik...')
                        ->prefixIcon('heroicon-o-exclamation-triangle')
                        ->columnSpan(6),

                    DatePicker::make('tanggal_potensi')
                        ->label('Tanggal Identifikasi')
                        ->required()
                        ->default(now())
                        ->prefixIcon('heroicon-o-calendar-days')
                        ->displayFormat('d/m/Y')
                        ->columnSpan(3),

                    Select::make('jenis_konflik_id')
                        ->label('Jenis Konflik')
                        ->options(JenisKonflik::pluck('nama', 'id'))
                        ->required()
                        ->searchable()
                        ->placeholder('Pilih Jenis Konflik')
                        ->prefixIcon('heroicon-o-tag')
                        ->createOptionForm([
                            TextInput::make('nama')
                                ->label('Nama Jenis Konflik')
                                ->required()
                                ->maxLength(255),
                            TextInput::make('deskripsi')
                                ->label('Deskripsi')
                                ->maxLength(500),
                        ])
                        ->createOptionUsing(function (array $data) {
                            return JenisKonflik::create($data)->id;
                        })
                        ->columnSpan(3),

                    TextInput::make('penanggung_jawab')
                        ->label('Penanggung Jawab')
                        ->placeholder('Nama penanggung jawab...')
                        ->prefixIcon('heroicon-o-user')
                        ->columnSpan(6),

                    Select::make('kabupaten_id')
                        ->label('Kabupaten/Kota')
                        ->options(\App\Models\Kabupaten::pluck('nama', 'id'))
                        ->reactive()
                        ->required()
                        ->searchable()
                        ->placeholder('Pilih Kabupaten/Kota')
                        ->prefixIcon('heroicon-o-building-office')
                        ->afterStateUpdated(fn ($state, callable $set) => $set('kecamatan_id', null))
                        ->afterStateHydrated(function ($set, $record) {
                            if ($record && $record->desa) {
                                $set('kabupaten_id', $record->desa->kecamatan->kabupaten_id);
                            }
                        })
                        ->columnSpan(2),

                    Select::make('kecamatan_id')
                        ->label('Kecamatan')
                        ->options(fn (callable $get) => $get('kabupaten_id')
                            ? \App\Models\Kecamatan::where('kabupaten_id', $get('kabupaten_id'))->pluck('nama', 'id')
                            : []
                        )
                        ->reactive()
                        ->required()
                        ->searchable()
                        ->placeholder('Pilih Kecamatan')
                        ->prefixIcon('heroicon-o-home-modern')
                        ->disabled(fn (callable $get) => !$get('kabupaten_id'))
                        ->afterStateUpdated(fn ($state, callable $set) => $set('desa_id', null))
                        ->afterStateHydrated(function ($set, $record) {
                            if ($record && $record->desa) {
                                $set('kecamatan_id', $record->desa->kecamatan_id);
                            }
                        })
                        ->columnSpan(2),

                    Select::make('desa_id')
                        ->label('Desa/Kelurahan')
                        ->options(fn (callable $get) => $get('kecamatan_id')
                            ? \App\Models\Desa::where('kecamatan_id', $get('kecamatan_id'))->pluck('nama', 'id')
                            : []
                        )
                        ->required()
                        ->searchable()
                        ->placeholder('Pilih Desa/Kelurahan')
                        ->prefixIcon('heroicon-o-home')
                        ->disabled(fn (callable $get) => !$get('kecamatan_id'))
                        ->columnSpan(2),

                    RichEditor::make('latar_belakang')
                        ->label('Latar Belakang')
                        ->placeholder('Jelaskan latar belakang terjadinya potensi konflik...')
                        ->required()
                        ->toolbarButtons([
                            'bold', 'italic', 'underline', 'link',
                            'bulletList', 'orderedList', 'blockquote',
                            'strike'
                        ])
                        ->extraAttributes(['style' => 'min-height: 200px;'])
                        ->columnSpan(6),
                ]),
        ];
    }
}
